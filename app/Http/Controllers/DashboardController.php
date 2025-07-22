<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pessoa;
use App\Models\Participacao;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEventos = Evento::count();
        $totalPessoas = Pessoa::count();
        $totalParticipacoes = Participacao::count();
        
        // ✅ CORRIGIDO: usando "data" (não "data_evento")
        $eventosRecentes = Evento::with('participacoes')
                                ->orderBy('data', 'desc')
                                ->limit(5)
                                ->get();
        
        // ✅ CORRIGIDO: usando has() ao invés de having()
        $pessoasAtivas = Pessoa::has('participacoes')
                              ->with('participacoes')
                              ->get()
                              ->sortByDesc(function ($pessoa) {
                                  return $pessoa->participacoes->count();
                              })
                              ->take(10);
        
        return view('dashboard', compact(
            'totalEventos',
            'totalPessoas', 
            'totalParticipacoes',
            'eventosRecentes',
            'pessoasAtivas'
        ));
    }
}