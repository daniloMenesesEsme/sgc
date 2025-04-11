@extends('adminlte::page')

@section('title', 'Tamanhos | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Tamanhos</h1>
    <a href="{{ route('tamanhos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Novo Tamanho
    </a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tamanhos as $tamanho)
                        <tr>
                            <td>{{ $tamanho->nome }}</td>
                            <td>{{ $tamanho->descricao ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $tamanho->ativo ? 'success' : 'danger' }}">
                                    {{ $tamanho->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('tamanhos.edit', $tamanho) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tamanhos.destroy', $tamanho) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este tamanho?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum tamanho cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $tamanhos->links() }}
    </div>
</div>
@stop 