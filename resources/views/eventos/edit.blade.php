@extends('layouts.app')

@section('title', 'Editar ' . $evento->nome . ' - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>
                Editar Evento
            </h1>
            <div>
                <a href="{{ route('eventos.show', $evento) }}" class="btn btn-outline-info">
                    <i class="fas fa-eye me-2"></i>
                    Visualizar
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
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informações do Evento</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('eventos.update', $evento) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Evento *</label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome', $evento->nome) }}" 
                               required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="data" class="form-label">Data do Evento *</label>
                        <input type="date" 
                               class="form-control @error('data') is-invalid @enderror" 
                               id="data" 
                               name="data" 
                               value="{{ old('data', $evento->data->format('Y-m-d')) }}" 
                               required>
                        @error('data')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" 
                                  name="descricao" 
                                  rows="4" 
                                  placeholder="Descreva o evento, objetivos, público-alvo, etc.">{{ old('descricao', $evento->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('eventos.show', $evento) }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Estatísticas
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Total de Participantes:</strong>
                    <br>
                    <span class="badge bg-success fs-6">
                        {{ $evento->participacoes->count() }} pessoas
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Criado em:</strong>
                    <br>
                    <small class="text-muted">{{ $evento->created_at->format('d/m/Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Última atualização:</strong>
                    <br>
                    <small class="text-muted">{{ $evento->updated_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Zona de Perigo
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Excluir este evento removerá permanentemente todas as informações e participações associadas.
                </p>
                <form action="{{ route('eventos.destroy', $evento) }}" 
                      method="POST" 
                      onsubmit="return confirm('ATENÇÃO: Esta ação não pode ser desfeita. Tem certeza que deseja excluir este evento e todas as participações associadas?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-2"></i>
                        Excluir Evento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

