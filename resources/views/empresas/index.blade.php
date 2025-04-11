@extends('adminlte::page')

@section('title', 'Empresas | SGC')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Lista de Empresas</h1>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar">
                <div class="input-group-append">
                    <button class="btn btn-default" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('empresas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nova Empresa
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->id }}</td>
                        <td>{{ $empresa->razao_social }}</td>
                        <td>{{ $empresa->nome_fantasia }}</td>
                        <td>{{ $empresa->cnpj }}</td>
                        <td>{{ $empresa->telefone }}</td>
                        <td>{{ $empresa->email }}</td>
                        <td>
                            <span class="badge {{ $empresa->ativo ? 'bg-success' : 'bg-danger' }}">
                                {{ $empresa->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('empresas.show', $empresa) }}" class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" title="Excluir" 
                                        onclick="event.preventDefault(); 
                                                document.getElementById('delete-empresa-{{ $empresa->id }}').submit();">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-empresa-{{ $empresa->id }}" action="{{ route('empresas.destroy', $empresa) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Nenhuma empresa encontrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $empresas->links() }}
    </div>
</div>
@endsection 