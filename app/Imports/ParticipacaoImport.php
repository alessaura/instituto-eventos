<?php

namespace App\Imports;

use App\Models\Pessoa;
use App\Models\Evento;
use App\Models\Participacao;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class ParticipacaoImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $evento;
    private $importedCount = 0;
    private $skippedCount = 0;
    private $errors = [];

    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            try {
                // Buscar pessoa pelo email
                $pessoa = Pessoa::where('email', $row['email'])->first();
                
                if (!$pessoa) {
                    $this->errors[] = "Pessoa com email '{$row['email']}' não encontrada no sistema.";
                    continue;
                }

                // Verificar se já existe participação
                $existingParticipacao = Participacao::where('pessoa_id', $pessoa->id)
                                                  ->where('evento_id', $this->evento->id)
                                                  ->first();
                
                if ($existingParticipacao) {
                    $this->skippedCount++;
                    continue;
                }

                // Processar data de participação
                $dataParticipacao = now();
                if (!empty($row['data_participacao'])) {
                    try {
                        // Tentar diferentes formatos de data
                        $dataParticipacao = Carbon::createFromFormat('d/m/Y H:i', $row['data_participacao']);
                    } catch (\Exception $e) {
                        try {
                            $dataParticipacao = Carbon::createFromFormat('d/m/Y', $row['data_participacao']);
                        } catch (\Exception $e) {
                            // Se não conseguir parsear, usar data atual
                            $dataParticipacao = now();
                        }
                    }
                }

                // Criar participação
                Participacao::create([
                    'pessoa_id' => $pessoa->id,
                    'evento_id' => $this->evento->id,
                    'data_participacao' => $dataParticipacao,
                    'observacoes' => $row['observacoes'] ?? null,
                ]);

                $this->importedCount++;
            } catch (\Exception $e) {
                $this->errors[] = "Erro ao processar email '{$row['email']}': " . $e->getMessage();
            }
        }
    }

    /**
     * Regras de validação
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'data_participacao' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ];
    }

    /**
     * Mensagens de validação customizadas
     */
    public function customValidationMessages()
    {
        return [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email deve ter um formato válido.',
        ];
    }

    /**
     * Retorna estatísticas da importação
     */
    public function getImportStats()
    {
        return [
            'imported' => $this->importedCount,
            'skipped' => $this->skippedCount,
            'errors' => $this->errors,
        ];
    }
}
