@extends('adminlte::page')

@section('title', 'Novo Produto | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Novo Produto</h1>
    <a href="{{ route('produtos.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulário de Cadastro</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Código -->
                <div class="col-md-4 form-group">
                    <label>Código <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                        </div>
                        <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control @error('codigo') is-invalid @enderror" placeholder="Código do produto">
                    </div>
                    @error('codigo')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nome -->
                <div class="col-md-8 form-group">
                    <label>Nome <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                        </div>
                        <input type="text" name="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" placeholder="Nome do produto">
                    </div>
                    @error('nome')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="col-md-12 form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="3" placeholder="Descrição do produto">{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preço Custo -->
                <div class="col-md-4 form-group">
                    <label>Preço de Custo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" name="preco_custo" value="{{ old('preco_custo') }}" class="form-control money @error('preco_custo') is-invalid @enderror" placeholder="0,00">
                    </div>
                    @error('preco_custo')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preço Venda -->
                <div class="col-md-4 form-group">
                    <label>Preço de Venda <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" name="preco_venda" value="{{ old('preco_venda') }}" class="form-control money @error('preco_venda') is-invalid @enderror" placeholder="0,00">
                    </div>
                    @error('preco_venda')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Unidade de Medida -->
                <div class="col-md-4 form-group">
                    <label>Unidade de Medida <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                        </div>
                        <select name="unidade_medida" class="form-control @error('unidade_medida') is-invalid @enderror">
                            <option value="">Selecione</option>
                            <option value="UN" {{ old('unidade_medida') == 'UN' ? 'selected' : '' }}>Unidade (UN)</option>
                            <option value="KG" {{ old('unidade_medida') == 'KG' ? 'selected' : '' }}>Quilograma (KG)</option>
                            <option value="LT" {{ old('unidade_medida') == 'LT' ? 'selected' : '' }}>Litro (LT)</option>
                            <option value="MT" {{ old('unidade_medida') == 'MT' ? 'selected' : '' }}>Metro (MT)</option>
                            <option value="CX" {{ old('unidade_medida') == 'CX' ? 'selected' : '' }}>Caixa (CX)</option>
                        </select>
                    </div>
                    @error('unidade_medida')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Estoque Mínimo -->
                <div class="col-md-4 form-group">
                    <label>Estoque Mínimo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                        </div>
                        <input type="number" name="estoque_minimo" value="{{ old('estoque_minimo', 0) }}" class="form-control @error('estoque_minimo') is-invalid @enderror" min="0">
                    </div>
                    @error('estoque_minimo')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Estoque Atual -->
                <div class="col-md-4 form-group">
                    <label>Estoque Atual <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                        </div>
                        <input type="number" name="estoque_atual" value="{{ old('estoque_atual', 0) }}" class="form-control @error('estoque_atual') is-invalid @enderror" min="0">
                    </div>
                    @error('estoque_atual')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Imagem -->
                <div class="col-md-4 form-group">
                    <label>Imagem do Produto</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="imagem" class="custom-file-input @error('imagem') is-invalid @enderror" id="imagem" accept="image/*">
                            <label class="custom-file-label" for="imagem">Escolher arquivo</label>
                        </div>
                    </div>
                    <small class="form-text text-muted">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</small>
                    @error('imagem')
                        <span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-12 form-group">
                    <label>Status</label>
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="ativo" value="0">
                        <input type="checkbox" name="ativo" class="custom-control-input" id="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="ativo">Ativo</label>
                    </div>
                </div>

                <!-- Tamanhos -->
                <div class="col-md-12 form-group">
                    <label>Tamanhos</label>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">Selecionar</th>
                                    <th>Tamanho</th>
                                    <th>Preço</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Tamanho::where('ativo', true)->get() as $tamanho)
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="tamanhos[]" value="{{ $tamanho->id }}" class="custom-control-input" id="tamanho{{ $tamanho->id }}" {{ in_array($tamanho->id, old('tamanhos', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="tamanho{{ $tamanho->id }}"></label>
                                        </div>
                                    </td>
                                    <td>{{ $tamanho->nome }}</td>
                                    <td>
                                        <input type="text" name="precos[{{ $tamanho->id }}]" value="{{ old('precos.'.$tamanho->id) }}" class="form-control money" placeholder="0,00">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

@section('js')
<script>
    $(document).ready(function() {
        // Máscara para valores monetários
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
        
        // Mostrar nome do arquivo selecionado no input de upload
        $('#imagem').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Escolher arquivo');
        });
    });
</script>
@stop 