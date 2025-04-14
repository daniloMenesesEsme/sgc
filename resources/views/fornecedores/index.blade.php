@extends('adminlte::page')

@section('title', 'Fornecedores')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Fornecedores</h1>
        <a href="{{ route('fornecedores.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Fornecedor
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('fornecedores.index') }}">
                <div class="form-row">
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por nome, CPF/CNPJ..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <select class="form-control" name="tipo">
                            <option value="">Tipo</option>
                            <option value="PF" {{ request('tipo') == 'PF' ? 'selected' : '' }}>Pessoa Física</option>
                            <option value="PJ" {{ request('tipo') == 'PJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
                        </select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <div class="d-flex">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="fornece_tecido" value="1" id="filtro_tecido" {{ request('fornece_tecido') ? 'checked' : '' }}>
                                <label class="form-check-label" for="filtro_tecido">Fornece Tecido</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="fornece_tinta" value="1" id="filtro_tinta" {{ request('fornece_tinta') ? 'checked' : '' }}>
                                <label class="form-check-label" for="filtro_tinta">Fornece Tinta</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="fornece_papel" value="1" id="filtro_papel" {{ request('fornece_papel') ? 'checked' : '' }}>
                                <label class="form-check-label" for="filtro_papel">Fornece Papel</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="fornece_outros" value="1" id="filtro_outros" {{ request('fornece_outros') ? 'checked' : '' }}>
                                <label class="form-check-label" for="filtro_outros">Fornece Outros</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('fornecedores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nome/Razão Social</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th>Cidade/UF</th>
                        <th>Fornece</th>
                        <th>Status</th>
                        <th width="15%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fornecedores as $fornecedor)
                        <tr>
                            <td>{{ $fornecedor->id }}</td>
                            <td>{{ $fornecedor->tipo }}</td>
                            <td>{{ $fornecedor->nome_razao_social }}</td>
                            <td>{{ $fornecedor->cpf_cnpj }}</td>
                            <td>{{ $fornecedor->telefone }}</td>
                            <td>{{ $fornecedor->cidade }}/{{ $fornecedor->estado }}</td>
                            <td>
                                @if($fornecedor->fornece_tecido)
                                    <span class="badge badge-info">Tecido</span>
                                @endif
                                @if($fornecedor->fornece_tinta)
                                    <span class="badge badge-warning">Tinta</span>
                                @endif
                                @if($fornecedor->fornece_papel)
                                    <span class="badge badge-success">Papel</span>
                                @endif
                                @if($fornecedor->fornece_outros)
                                    <span class="badge badge-secondary">Outros</span>
                                @endif
                            </td>
                            <td>
                                @if($fornecedor->ativo)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('fornecedores.show', $fornecedor) }}" class="btn btn-sm btn-info" title="Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('fornecedores.edit', $fornecedor) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" title="Excluir" 
                                            onclick="confirmarExclusao({{ $fornecedor->id }}, '{{ $fornecedor->nome_razao_social }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="form-excluir-{{ $fornecedor->id }}" action="{{ route('fornecedores.destroy', $fornecedor) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Nenhum fornecedor encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $fornecedores->appends(request()->query())->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        function confirmarExclusao(id, nome) {
            Swal.fire({
                title: 'Tem certeza?',
                text: `Você está prestes a excluir o fornecedor "${nome}"`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form-excluir-${id}`).submit();
                }
            });
        }
    </script>
@stop 