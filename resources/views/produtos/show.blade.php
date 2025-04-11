@extends('adminlte::page')

@section('title', 'Detalhes do Produto | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Detalhes do Produto</h1>
    <div>
        <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-primary">
            <i class="fas fa-edit mr-1"></i> Editar
        </a>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Voltar
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
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
                                    @if($produto->ativo)
                                        <span class="badge badge-success">Ativo</span>
                                    @else
                                        <span class="badge badge-danger">Inativo</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($produto->imagem)
                    <div class="col-md-12 mb-3 text-center">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Imagem do produto" class="img-fluid" style="max-height: 200px;">
                        <p class="text-muted mt-2">Imagem do produto</p>
                    </div>
                    @endif
                    
                    <div class="col-12">
                        <p><strong>Código:</strong> {{ $produto->codigo }}</p>
                        <p><strong>Nome:</strong> {{ $produto->nome }}</p>
                        <p><strong>Descrição:</strong> {{ $produto->descricao ?: 'Não informada' }}</p>
                        <p><strong>Preço de Custo:</strong> R$ {{ number_format($produto->preco_custo, 2, ',', '.') }}</p>
                        <p><strong>Preço de Venda:</strong> R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</p>
                        <p><strong>Unidade de Medida:</strong> {{ $produto->unidade_medida }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Informações de Estoque</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">Estoque Atual</span>
                                <span class="info-box-number">
                                    <span class="badge badge-{{ $produto->status_estoque }}">
                                        {{ $produto->estoque_atual }} {{ $produto->unidade_medida }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">Estoque Mínimo</span>
                                <span class="info-box-number">
                                    {{ $produto->estoque_minimo }} {{ $produto->unidade_medida }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Informações Adicionais</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p><strong>Data de Cadastro:</strong> {{ $produto->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Última Atualização:</strong> {{ $produto->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop 