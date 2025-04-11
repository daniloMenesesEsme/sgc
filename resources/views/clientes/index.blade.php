@extends('adminlte::page')

@section('title', 'Clientes | SGC')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Lista de Clientes</h1>
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
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Novo Cliente
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nome/Razão Social</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->tipo === 'F' ? 'Pessoa Física' : 'Pessoa Jurídica' }}</td>
                        <td>{{ $cliente->nome_razao_social }}</td>
                        <td>{{ $cliente->cpf_cnpj }}</td>
                        <td>{{ $cliente->telefone }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>
                            <span class="badge {{ $cliente->ativo ? 'bg-success' : 'bg-danger' }}">
                                {{ $cliente->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" title="Excluir" 
                                        onclick="event.preventDefault(); 
                                                document.getElementById('delete-cliente-{{ $cliente->id }}').submit();">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-cliente-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Nenhum cliente encontrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $clientes->links() }}
    </div>
</div>
@endsection 