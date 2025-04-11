@extends('adminlte::page')

@section('title', 'Editar Empresa | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Editar Empresa</h1>
    <a href="{{ route('empresas.index') }}" class="btn btn-primary">
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
        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Razão Social -->
                <div class="col-md-4 form-group">
                    <label>Razão Social <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <input type="text" name="razao_social" value="{{ old('razao_social', $empresa->razao_social) }}" class="form-control @error('razao_social') is-invalid @enderror" placeholder="Razão Social da empresa">
                    </div>
                    @error('razao_social')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nome Fantasia -->
                <div class="col-md-4 form-group">
                    <label>Nome Fantasia</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        </div>
                        <input type="text" name="nome_fantasia" value="{{ old('nome_fantasia', $empresa->nome_fantasia) }}" class="form-control @error('nome_fantasia') is-invalid @enderror" placeholder="Nome fantasia da empresa">
                    </div>
                    @error('nome_fantasia')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- CNPJ -->
                <div class="col-md-4 form-group">
                    <label>CNPJ <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj', $empresa->cnpj) }}" class="form-control @error('cnpj') is-invalid @enderror" placeholder="00.000.000/0000-00">
                    </div>
                    @error('cnpj')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- IE -->
                <div class="col-md-4 form-group">
                    <label>Inscrição Estadual</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <input type="text" name="ie" value="{{ old('ie', $empresa->ie) }}" class="form-control @error('ie') is-invalid @enderror" placeholder="Inscrição Estadual">
                    </div>
                    @error('ie')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- CEP -->
                <div class="col-md-4 form-group">
                    <label>CEP <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="cep" id="cep" value="{{ old('cep', $empresa->cep) }}" class="form-control @error('cep') is-invalid @enderror" placeholder="00000-000">
                        <div class="input-group-append">
                            <button type="button" id="btn-buscar-cep" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @error('cep')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Logradouro -->
                <div class="col-md-6 form-group">
                    <label>Logradouro <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-road"></i></span>
                        </div>
                        <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro', $empresa->logradouro) }}" class="form-control @error('logradouro') is-invalid @enderror" placeholder="Rua, Avenida, etc.">
                    </div>
                    @error('logradouro')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Número -->
                <div class="col-md-2 form-group">
                    <label>Número <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        </div>
                        <input type="text" name="numero" value="{{ old('numero', $empresa->numero) }}" class="form-control @error('numero') is-invalid @enderror" placeholder="Número">
                    </div>
                    @error('numero')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Complemento -->
                <div class="col-md-4 form-group">
                    <label>Complemento</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" name="complemento" value="{{ old('complemento', $empresa->complemento) }}" class="form-control @error('complemento') is-invalid @enderror" placeholder="Apto, Sala, etc.">
                    </div>
                    @error('complemento')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bairro -->
                <div class="col-md-4 form-group">
                    <label>Bairro <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map"></i></span>
                        </div>
                        <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $empresa->bairro) }}" class="form-control @error('bairro') is-invalid @enderror" placeholder="Bairro">
                    </div>
                    @error('bairro')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Cidade -->
                <div class="col-md-4 form-group">
                    <label>Cidade <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $empresa->cidade) }}" class="form-control @error('cidade') is-invalid @enderror" placeholder="Cidade">
                    </div>
                    @error('cidade')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="col-md-4 form-group">
                    <label>Estado <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                        </div>
                        <select name="estado" class="form-control @error('estado') is-invalid @enderror">
                            <option value="">Selecione o estado</option>
                            @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                                <option value="{{ $uf }}" {{ old('estado', $empresa->estado) == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('estado')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Telefone -->
                <div class="col-md-4 form-group">
                    <label>Telefone <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $empresa->telefone) }}" class="form-control @error('telefone') is-invalid @enderror" placeholder="(00) 0000-0000">
                    </div>
                    @error('telefone')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-4 form-group">
                    <label>E-mail</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $empresa->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@exemplo.com">
                    </div>
                    @error('email')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Site -->
                <div class="col-md-4 form-group">
                    <label>Site</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        </div>
                        <input type="url" name="site" value="{{ old('site', $empresa->site) }}" class="form-control @error('site') is-invalid @enderror" placeholder="https://www.exemplo.com.br">
                    </div>
                    @error('site')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Logo da Empresa -->
                <div class="col-md-4 form-group">
                    <label>Logo da Empresa</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="logo" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" accept="image/*">
                            <label class="custom-file-label" for="logo">{{ $empresa->logo ? 'Alterar logo' : 'Escolher arquivo' }}</label>
                        </div>
                    </div>
                    <small class="form-text text-muted">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</small>
                    @error('logo')
                        <span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                    
                    @if($empresa->logo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo da Empresa" class="img-thumbnail" style="max-height: 100px;">
                        <p class="text-muted mt-1 mb-0">Logo atual</p>
                    </div>
                    @endif
                </div>

                <!-- Status -->
                <div class="col-md-4 form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                        </div>
                        <select name="ativo" class="form-control @error('ativo') is-invalid @enderror">
                            <option value="1" {{ old('ativo', $empresa->ativo) == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('ativo', $empresa->ativo) == '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    @error('ativo')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Observações -->
                <div class="col-md-12 form-group">
                    <label>Observações</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                        </div>
                        <textarea name="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="3" placeholder="Observações sobre a empresa">{{ old('observacoes', $empresa->observacoes) }}</textarea>
                    </div>
                    @error('observacoes')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar
                    </button>
                    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Máscaras de input
    $('#cnpj').mask('00.000.000/0000-00');
    $('#cep').mask('00000-000');
    $('#telefone').mask('(00) 0000-0000');
    
    // Mostrar nome do arquivo selecionado no input de upload
    $('#logo').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Alterar logo');
    });

    // Função para buscar endereço pelo CEP
    $('#btn-buscar-cep').click(function() {
        var cep = $('#cep').val().replace(/\D/g, '');
        
        if (cep.length != 8) {
            alert('CEP inválido');
            return;
        }
        
        $.get(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
            if (!data.erro) {
                $('#logradouro').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#estado').val(data.uf);
                $('#numero').focus();
            } else {
                alert('CEP não encontrado');
            }
        });
    });
});
</script>
@endsection 