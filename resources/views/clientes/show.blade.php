@extends('adminlte::page')

@section('title', 'Detalhes do Cliente | SGC')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalhes do Cliente</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ações</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('clientes.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Voltar
                    </a>
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-info">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informações Principais</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Tipo de Cliente</span>
                                    <span class="info-box-number">
                                        @if($cliente->tipo == 'F')
                                            <span class="badge badge-primary">Pessoa Física</span>
                                        @else
                                            <span class="badge badge-purple">Pessoa Jurídica</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Status</span>
                                    <span class="info-box-number">
                                        @if($cliente->ativo)
                                            <span class="badge badge-success">Ativo</span>
                                        @else
                                            <span class="badge badge-danger">Inativo</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome/Razão Social</label>
                                <p>{{ $cliente->nome_razao_social }}</p>
                            </div>
                        </div>
                        @if($cliente->tipo == 'J')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome Fantasia</label>
                                <p>{{ $cliente->nome_fantasia ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPF/CNPJ</label>
                                <p>{{ $cliente->cpf_cnpj }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Informações de Contato</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <p>{{ $cliente->telefone }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Celular</label>
                                <p>{{ $cliente->celular }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <p>{{ $cliente->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site</label>
                                <p>{{ $cliente->site ?? 'Não informado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Endereço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CEP</label>
                                <p>{{ $cliente->cep }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logradouro</label>
                                <p>{{ $cliente->logradouro }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número</label>
                                <p>{{ $cliente->numero }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Complemento</label>
                                <p>{{ $cliente->complemento ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bairro</label>
                                <p>{{ $cliente->bairro }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cidade</label>
                                <p>{{ $cliente->cidade }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <p>{{ $cliente->estado }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Observações</h3>
                </div>
                <div class="card-body">
                    <p>{{ $cliente->observacoes ?? 'Nenhuma observação registrada.' }}</p>
                </div>
                <div class="card-footer bg-light">
                    <small class="text-muted">Criado em: {{ $cliente->created_at->format('d/m/Y H:i') }}</small><br>
                    <small class="text-muted">Última atualização: {{ $cliente->updated_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@stop 