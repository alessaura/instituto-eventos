@extends('layouts.app')

@section('title', 'Novo Evento - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus me-2"></i>
                Novo Evento
            </h1>
            <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar
            </a>
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
                <form action="{{ route('eventos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Evento *</label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome') }}" 
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
                               value="{{ old('data') }}" 
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
                                  placeholder="Descreva o evento, objetivos, público-alvo, etc.">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Salvar Evento
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
                    <i class="fas fa-info-circle me-2"></i>
                    Dicas
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use nomes descritivos para facilitar a identificação
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        A data pode ser no passado para eventos já realizados
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        A descrição ajuda na organização e relatórios
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Após criar, você poderá importar participantes
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

