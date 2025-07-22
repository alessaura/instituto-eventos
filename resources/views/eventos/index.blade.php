@extends('layouts.app')

@section('title', 'Eventos - Instituto de Embalagens')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                Eventos
            </h1>
            <a href="{{ route('eventos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Novo Evento
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($eventos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Data</th>
                                    <th>Participantes</th>
                                    <th>Descrição</th>
                                    <th width="150">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventos as $evento)
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
                                        {{ Str::limit($evento->descricao, 50) }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('eventos.show', $evento) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('eventos.edit', $evento) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('eventos.destroy', $evento) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginação -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $eventos->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Nenhum evento cadastrado</h4>
                        <p class="text-muted mb-4">Comece criando seu primeiro evento para gerenciar participantes.</p>
                        <a href="{{ route('eventos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Criar Primeiro Evento
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

