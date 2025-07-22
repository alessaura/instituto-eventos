@extends('layouts.app')

@section('title', 'Importar Dados - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-file-import me-2"></i>
                Importar Dados
            </h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Importar Pessoas -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Importar Pessoas
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Importe uma lista de pessoas a partir de um arquivo Excel ou CSV.
                </p>
                
                <form action="{{ route('import.pessoas') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="arquivo_pessoas" class="form-label">Arquivo de Pessoas *</label>
                        <input type="file" 
                               class="form-control @error('arquivo_pessoas') is-invalid @enderror" 
                               id="arquivo_pessoas" 
                               name="arquivo_pessoas" 
                               accept=".xlsx,.xls,.csv" 
                               required>
                        @error('arquivo_pessoas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Formatos aceitos: Excel (.xlsx, .xls) ou CSV (.csv)
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-upload me-2"></i>
                        Importar Pessoas
                    </button>
                </form>
                
                <hr>
                
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Formato esperado:</h6>
                    <ul class="mb-0 small">
                        <li><strong>Nome</strong> (obrigatório)</li>
                        <li><strong>Email</strong> (obrigatório, único)</li>
                        <li><strong>Telefone</strong> (opcional)</li>
                        <li><strong>Empresa</strong> (opcional)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Importar Participações -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-handshake me-2"></i>
                    Importar Participações
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Importe participações de um evento específico.
                </p>
                
                <form action="{{ route('import.participacoes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="evento_id" class="form-label">Evento *</label>
                        <select class="form-select @error('evento_id') is-invalid @enderror" 
                                id="evento_id" 
                                name="evento_id" 
                                required>
                            <option value="">Selecione um evento</option>
                            @foreach(\App\Models\Evento::orderBy('data', 'desc')->get() as $evento)
                                <option value="{{ $evento->id }}" 
                                        {{ request('evento_id') == $evento->id ? 'selected' : '' }}>
                                    {{ $evento->nome }} - {{ $evento->data->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('evento_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="arquivo_participacoes" class="form-label">Arquivo de Participações *</label>
                        <input type="file" 
                               class="form-control @error('arquivo_participacoes') is-invalid @enderror" 
                               id="arquivo_participacoes" 
                               name="arquivo_participacoes" 
                               accept=".xlsx,.xls,.csv" 
                               required>
                        @error('arquivo_participacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Formatos aceitos: Excel (.xlsx, .xls) ou CSV (.csv)
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-info w-100">
                        <i class="fas fa-upload me-2"></i>
                        Importar Participações
                    </button>
                </form>
                
                <hr>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Formato esperado:</h6>
                    <ul class="mb-0 small">
                        <li><strong>Email</strong> (obrigatório, deve existir no sistema)</li>
                        <li><strong>Data Participação</strong> (opcional, formato: dd/mm/aaaa hh:mm)</li>
                        <li><strong>Observações</strong> (opcional)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instruções Detalhadas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    Como Usar
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>1. Importação de Pessoas</h6>
                        <ul class="small text-muted">
                            <li>Prepare um arquivo Excel ou CSV com as colunas: Nome, Email, Telefone, Empresa</li>
                            <li>A primeira linha deve conter os cabeçalhos</li>
                            <li>Nome e Email são obrigatórios</li>
                            <li>Emails duplicados serão ignorados</li>
                        </ul>
                        
                        <h6>2. Importação de Participações</h6>
                        <ul class="small text-muted">
                            <li>Primeiro, selecione o evento</li>
                            <li>O arquivo deve conter pelo menos a coluna Email</li>
                            <li>As pessoas devem estar cadastradas no sistema</li>
                            <li>Participações duplicadas serão ignoradas</li>
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Exemplo de Arquivo de Pessoas:</h6>
                        <div class="bg-light p-3 rounded small">
                            <code>
                                Nome,Email,Telefone,Empresa<br>
                                João Silva,joao@email.com,(11) 99999-9999,Empresa ABC<br>
                                Maria Santos,maria@email.com,(11) 88888-8888,Empresa XYZ
                            </code>
                        </div>
                        
                        <h6 class="mt-3">Exemplo de Arquivo de Participações:</h6>
                        <div class="bg-light p-3 rounded small">
                            <code>
                                Email,Data Participação,Observações<br>
                                joao@email.com,22/07/2025 14:30,Participou ativamente<br>
                                maria@email.com,22/07/2025 14:35,Chegou um pouco atrasada
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

