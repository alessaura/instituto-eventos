<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Imports\PessoasImport;
use App\Imports\ParticipacaoImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Exibir página de importação
     */
    public function index()
    {
        return view('import.index');
    }

    /**
     * Importar pessoas de arquivo Excel/CSV
     */
    public function importPessoas(Request $request)
    {
        $request->validate([
            'arquivo_pessoas' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            $import = new PessoasImport();
            Excel::import($import, $request->file('arquivo_pessoas'));
            
            $stats = $import->getImportStats();
            
            $message = "Importação concluída! ";
            $message .= "{$stats['imported']} pessoas importadas";
            
            if ($stats['skipped'] > 0) {
                $message .= ", {$stats['skipped']} ignoradas (já existiam)";
            }
            
            if (!empty($stats['errors'])) {
                $message .= ". Alguns erros ocorreram: " . implode(', ', array_slice($stats['errors'], 0, 3));
                if (count($stats['errors']) > 3) {
                    $message .= " e mais " . (count($stats['errors']) - 3) . " erros.";
                }
            }

            return redirect()->route('import.index')
                           ->with('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            
            foreach ($failures as $failure) {
                $errors[] = "Linha {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->route('import.index')
                           ->with('error', 'Erro de validação: ' . implode(' | ', array_slice($errors, 0, 5)));
                           
        } catch (\Exception $e) {
            return redirect()->route('import.index')
                           ->with('error', 'Erro ao importar arquivo: ' . $e->getMessage());
        }
    }

    /**
     * Importar participações de arquivo Excel/CSV
     */
    public function importParticipacoes(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'arquivo_participacoes' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            $evento = Evento::findOrFail($request->evento_id);
            $import = new ParticipacaoImport($evento);
            Excel::import($import, $request->file('arquivo_participacoes'));
            
            $stats = $import->getImportStats();
            
            $message = "Importação concluída para o evento '{$evento->nome}'! ";
            $message .= "{$stats['imported']} participações importadas";
            
            if ($stats['skipped'] > 0) {
                $message .= ", {$stats['skipped']} ignoradas (já existiam)";
            }
            
            if (!empty($stats['errors'])) {
                $message .= ". Alguns erros ocorreram: " . implode(', ', array_slice($stats['errors'], 0, 3));
                if (count($stats['errors']) > 3) {
                    $message .= " e mais " . (count($stats['errors']) - 3) . " erros.";
                }
            }

            return redirect()->route('eventos.show', $evento)
                           ->with('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            
            foreach ($failures as $failure) {
                $errors[] = "Linha {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->route('import.index')
                           ->with('error', 'Erro de validação: ' . implode(' | ', array_slice($errors, 0, 5)));
                           
        } catch (\Exception $e) {
            return redirect()->route('import.index')
                           ->with('error', 'Erro ao importar arquivo: ' . $e->getMessage());
        }
    }
}
