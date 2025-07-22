<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = Pessoa::withCount('participacoes')
                        ->orderBy('nome')
                        ->paginate(15);
        
        return view('pessoas.index', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:pessoas,email',
            'telefone' => 'nullable|string|max:20',
            'empresa' => 'nullable|string|max:255'
        ]);

        Pessoa::create($request->all());

        return redirect()->route('pessoas.index')
                        ->with('success', 'Pessoa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pessoa $pessoa)
    {
        $pessoa->load(['participacoes.evento' => function($query) {
            $query->orderBy('data', 'desc');
        }]);
        
        return view('pessoas.show', compact('pessoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pessoa $pessoa)
    {
        return view('pessoas.edit', compact('pessoa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pessoa $pessoa)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:pessoas,email,' . $pessoa->id,
            'telefone' => 'nullable|string|max:20',
            'empresa' => 'nullable|string|max:255'
        ]);

        $pessoa->update($request->all());

        return redirect()->route('pessoas.index')
                        ->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pessoa $pessoa)
    {
        $pessoa->delete();

        return redirect()->route('pessoas.index')
                        ->with('success', 'Pessoa excluída com sucesso!');
    }
}
