@extends('adminlte::page')

@section('title', 'Editar Tamanho | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Editar Tamanho</h1>
    <a href="{{ route('tamanhos.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulário de Edição</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('tamanhos.update', $tamanho) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Nome -->
                <div class="col-md-6 form-group">
                    <label>Nome <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-ruler"></i></span>
                        </div>
                        <input type="text" name="nome" value="{{ old('nome', $tamanho->nome) }}" class="form-control @error('nome') is-invalid @enderror" placeholder="Nome do tamanho">
                    </div>
                    @error('nome')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="col-md-6 form-group">
                    <label>Descrição</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                        </div>
                        <input type="text" name="descricao" value="{{ old('descricao', $tamanho->descricao) }}" class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição do tamanho">
                    </div>
                    @error('descricao')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-12 form-group">
                    <label>Status</label>
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="ativo" value="0">
                        <input type="checkbox" name="ativo" class="custom-control-input" id="ativo" value="1" {{ old('ativo', $tamanho->ativo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="ativo">Ativo</label>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop 