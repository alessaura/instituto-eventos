@extends('layouts.app')

@section('title', $evento->nome . ' - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ $evento->nome }}
            </h1>
            <div>
                <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Editar
                </a>
                <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informações do Evento -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações do Evento
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Data:</strong>
                    <br>
                    <span class="badge bg-primary fs-6">
                        {{ $evento->data->format('d/m/Y') }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Total de Participantes:</strong>
                    <br>
                    <span class="badge bg-success fs-6">
                        {{ $evento->participacoes->count() }} pessoas
                    </span>
                </div>
                
                @if($evento->descricao)
                <div class="mb-3">
                    <strong>Descrição:</strong>
                    <p class="mt-2 text-muted">{{ $evento->descricao }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <strong>Criado em:</strong>
                    <br>
                    <small class="text-muted">{{ $evento->created_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
        
        <!-- Ações Rápidas -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('import.index') }}?evento_id={{ $evento->id }}" class="btn btn-info">
                        <i class="fas fa-file-import me-2"></i>
                        Importar Participantes
                    </a>
                    <a href="{{ route('pessoas.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i>
                        Cadastrar Pessoa
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Lista de Participantes -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Participantes ({{ $evento->participacoes->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if($evento->participacoes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Empresa</th>
                                    <th>Data de Participação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($evento->participacoes as $participacao)
                                <tr>
                                    <td>
                                        <strong>{{ $participacao->pessoa->nome }}</strong>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $participacao->pessoa->email }}" class="text-decoration-none">
                                            {{ $participacao->pessoa->email }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $participacao->pessoa->empresa ?? '-' }}
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $participacao->data_participacao->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('pessoas.show', $participacao->pessoa) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Ver perfil">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Nenhum participante cadastrado</h4>
                        <p class="text-muted mb-4">Importe uma planilha ou cadastre participantes manualmente.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('import.index') }}?evento_id={{ $evento->id }}" class="btn btn-info">
                                <i class="fas fa-file-import me-2"></i>
                                Importar Planilha
                            </a>
                            <a href="{{ route('pessoas.create') }}" class="btn btn-success">
                                <i class="fas fa-user-plus me-2"></i>
                                Cadastrar Pessoa
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

