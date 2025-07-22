<?php

namespace App\Imports;

use App\Models\Pessoa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class PessoasImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $importedCount = 0;
    private $skippedCount = 0;
    private $errors = [];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            try {
                // Verificar se a pessoa já existe pelo email
                $existingPessoa = Pessoa::where('email', $row['email'])->first();
                
                if ($existingPessoa) {
                    $this->skippedCount++;
                    continue;
                }

                // Criar nova pessoa
                Pessoa::create([
                    'nome' => $row['nome'],
                    'email' => $row['email'],
                    'telefone' => $row['telefone'] ?? null,
                    'empresa' => $row['empresa'] ?? null,
                ]);

                $this->importedCount++;
            } catch (\Exception $e) {
                $this->errors[] = "Erro na linha: " . $e->getMessage();
            }
        }
    }

    /**
     * Regras de validação
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'empresa' => 'nullable|string|max:255',
        ];
    }

    /**
     * Mensagens de validação customizadas
     */
    public function customValidationMessages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
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
