@extends('layouts.app')

@section('title', $pessoa->nome . ' - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user me-2"></i>
                {{ $pessoa->nome }}
            </h1>
            <div>
                <a href="{{ route('pessoas.edit', $pessoa) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Editar
                </a>
                <a href="{{ route('pessoas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informações da Pessoa -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-id-card me-2"></i>
                    Informações Pessoais
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nome:</strong>
                    <br>
                    {{ $pessoa->nome }}
                </div>
                
                <div class="mb-3">
                    <strong>Email:</strong>
                    <br>
                    <a href="mailto:{{ $pessoa->email }}" class="text-decoration-none">
                        {{ $pessoa->email }}
                    </a>
                </div>
                
                @if($pessoa->telefone)
                <div class="mb-3">
                    <strong>Telefone:</strong>
                    <br>
                    <a href="tel:{{ $pessoa->telefone }}" class="text-decoration-none">
                        {{ $pessoa->telefone }}
                    </a>
                </div>
                @endif
                
                @if($pessoa->empresa)
                <div class="mb-3">
                    <strong>Empresa:</strong>
                    <br>
                    {{ $pessoa->empresa }}
                </div>
                @endif
                
                <div class="mb-3">
                    <strong>Total de Participações:</strong>
                    <br>
                    <span class="badge bg-success fs-6">
                        {{ $pessoa->participacoes->count() }} eventos
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Cadastrado em:</strong>
                    <br>
                    <small class="text-muted">{{ $pessoa->created_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
        
        <!-- Estatísticas -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Estatísticas
                </h5>
            </div>
            <div class="card-body">
                @if($pessoa->participacoes->count() > 0)
                    <div class="mb-3">
                        <strong>Primeiro Evento:</strong>
                        <br>
                        <small class="text-muted">
                            {{ $pessoa->participacoes->sortBy('data_participacao')->first()->evento->nome }}
                            <br>
                            {{ $pessoa->participacoes->sortBy('data_participacao')->first()->data_participacao->format('d/m/Y') }}
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Último Evento:</strong>
                        <br>
                        <small class="text-muted">
                            {{ $pessoa->participacoes->sortByDesc('data_participacao')->first()->evento->nome }}
                            <br>
                            {{ $pessoa->participacoes->sortByDesc('data_participacao')->first()->data_participacao->format('d/m/Y') }}
                        </small>
                    </div>
                @else
                    <p class="text-muted">Nenhuma participação registrada.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Timeline de Participações -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Histórico de Participações
                </h5>
            </div>
            <div class="card-body">
                @if($pessoa->participacoes->count() > 0)
                    <div class="timeline">
                        @foreach($pessoa->participacoes->sortByDesc('data_participacao') as $participacao)
                        <div class="timeline-item">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                <a href="{{ route('eventos.show', $participacao->evento) }}" 
                                                   class="text-decoration-none">
                                                    {{ $participacao->evento->nome }}
                                                </a>
                                            </h6>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                Data do evento: {{ $participacao->evento->data->format('d/m/Y') }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-clock me-1"></i>
                                                Participou em: {{ $participacao->data_participacao->format('d/m/Y H:i') }}
                                            </p>
                                            @if($participacao->observacoes)
                                            <p class="mb-0">
                                                <strong>Observações:</strong> {{ $participacao->observacoes }}
                                            </p>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="badge bg-primary">
                                                {{ $participacao->evento->participacoes->count() }} participantes
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Nenhuma participação registrada</h4>
                        <p class="text-muted mb-4">Esta pessoa ainda não participou de nenhum evento.</p>
                        <a href="{{ route('eventos.index') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Ver Eventos Disponíveis
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

