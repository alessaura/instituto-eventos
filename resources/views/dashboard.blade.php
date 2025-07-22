@extends('layouts.app')

@section('title', 'Dashboard - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard
        </h1>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Total de Eventos</h5>
                        <h2 class="mb-0">{{ $totalEventos }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Total de Pessoas</h5>
                        <h2 class="mb-0">{{ $totalPessoas }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Total de Participações</h5>
                        <h2 class="mb-0">{{ $totalParticipacoes }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Eventos Recentes -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Eventos Recentes
                </h5>
                <a href="{{ route('eventos.index') }}" class="btn btn-sm btn-outline-primary">
                    Ver todos
                </a>
            </div>
            <div class="card-body">
                @if($eventosRecentes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Data</th>
                                    <th>Participantes</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventosRecentes as $evento)
                                <tr>
                                    <td>
                                        <strong>{{ $evento->nome }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $evento->data->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $evento->participacoes_count }} participantes
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('eventos.show', $evento) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Nenhum evento cadastrado ainda.</p>
                        <a href="{{ route('eventos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Criar Primeiro Evento
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Pessoas Mais Ativas -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-star me-2"></i>
                    Pessoas Mais Ativas
                </h5>
                <a href="{{ route('pessoas.index') }}" class="btn btn-sm btn-outline-primary">
                    Ver todas
                </a>
            </div>
            <div class="card-body">
                @if($pessoasAtivas->count() > 0)
                    @foreach($pessoasAtivas as $pessoa)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $pessoa->nome }}</strong>
                            <br>
                            <small class="text-muted">{{ $pessoa->empresa ?? 'Sem empresa' }}</small>
                        </div>
                        <div>
                            <span class="badge bg-success">
                                {{ $pessoa->participacoes_count }} eventos
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Nenhuma participação registrada.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('eventos.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Novo Evento
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('pessoas.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-user-plus me-2"></i>
                            Nova Pessoa
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('import.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-file-import me-2"></i>
                            Importar Dados
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('eventos.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list me-2"></i>
                            Ver Relatórios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

