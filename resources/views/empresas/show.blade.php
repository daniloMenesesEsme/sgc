@extends('adminlte::page')

@section('title', 'Detalhes da Empresa | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Detalhes da Empresa</h1>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informações da Empresa</h3>
        <div class="card-tools">
            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit mr-1"></i> Editar
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informações Principais</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-muted">Status</span>
                                        <span class="info-box-number">
                                            @if($empresa->ativo)
                                                <span class="badge badge-success">Ativo</span>
                                            @else
                                                <span class="badge badge-danger">Inativo</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($empresa->logo)
                            <div class="col-md-12 mb-3 text-center">
                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo da {{ $empresa->nome_fantasia }}" class="img-fluid" style="max-height: 150px;">
                                <p class="text-muted mt-2">Logo da empresa</p>
                            </div>
                            @endif
                            
                            <div class="col-12">
                                <p><strong>Razão Social:</strong> {{ $empresa->razao_social }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>Nome Fantasia:</strong> {{ $empresa->nome_fantasia }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>CNPJ:</strong> {{ $empresa->cnpj }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>Inscrição Estadual:</strong> {{ $empresa->ie ?: 'Não informado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Informações de Contato</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p><strong>Telefone:</strong> {{ $empresa->telefone }}</p>
                            </div>
                            @if($empresa->email)
                            <div class="col-12">
                                <p><strong>E-mail:</strong> {{ $empresa->email }}</p>
                            </div>
                            @endif
                            @if($empresa->site)
                            <div class="col-12">
                                <p>
                                    <strong>Site:</strong>
                                    <a href="{{ $empresa->site }}" target="_blank">{{ $empresa->site }}</a>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Endereço</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p><strong>CEP:</strong> {{ $empresa->cep }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>Logradouro:</strong> {{ $empresa->logradouro }}, {{ $empresa->numero }}</p>
                            </div>
                            @if($empresa->complemento)
                            <div class="col-12">
                                <p><strong>Complemento:</strong> {{ $empresa->complemento }}</p>
                            </div>
                            @endif
                            <div class="col-12">
                                <p><strong>Bairro:</strong> {{ $empresa->bairro }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>Cidade/UF:</strong> {{ $empresa->cidade }}/{{ $empresa->estado }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($empresa->observacoes)
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Observações</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $empresa->observacoes }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta empresa?')">
                        <i class="fas fa-trash mr-1"></i> Excluir Empresa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop 