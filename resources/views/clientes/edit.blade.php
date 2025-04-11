@extends('adminlte::page')

@section('title', 'Editar Cliente | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Editar Cliente</h1>
    <a href="{{ route('clientes.index') }}" class="btn btn-primary">
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
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Ocorreram erros com os dados fornecidos</p>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Tipo de Cliente -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo de Cliente <span class="text-danger">*</span></label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-3">
                                <input class="custom-control-input" type="radio" id="tipoPF" name="tipo" value="F" {{ $cliente->tipo == 'F' ? 'checked' : '' }}>
                                <label for="tipoPF" class="custom-control-label">Pessoa Física</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="tipoPJ" name="tipo" value="J" {{ $cliente->tipo == 'J' ? 'checked' : '' }}>
                                <label for="tipoPJ" class="custom-control-label">Pessoa Jurídica</label>
                            </div>
                        </div>
                        @error('tipo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Nome/Razão Social -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome/Razão Social <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="nome_razao_social" value="{{ old('nome_razao_social', $cliente->nome_razao_social) }}" 
                                class="form-control @error('nome_razao_social') is-invalid @enderror" 
                                placeholder="Nome completo ou razão social">
                        </div>
                        @error('nome_razao_social')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Nome Fantasia -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome Fantasia</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                            <input type="text" name="nome_fantasia" value="{{ old('nome_fantasia', $cliente->nome_fantasia) }}" 
                                class="form-control @error('nome_fantasia') is-invalid @enderror" 
                                placeholder="Nome fantasia">
                        </div>
                        @error('nome_fantasia')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- CPF/CNPJ -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>CPF/CNPJ <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="{{ old('cpf_cnpj', $cliente->cpf_cnpj) }}" 
                                class="form-control @error('cpf_cnpj') is-invalid @enderror" 
                                placeholder="000.000.000-00 / 00.000.000/0000-00">
                        </div>
                        @error('cpf_cnpj')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- RG/IE -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>RG/IE</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <input type="text" name="rg_ie" value="{{ old('rg_ie', $cliente->rg_ie) }}" 
                                class="form-control @error('rg_ie') is-invalid @enderror" 
                                placeholder="RG ou Inscrição Estadual">
                        </div>
                        @error('rg_ie')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- CEP -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>CEP <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="cep" id="cep" value="{{ old('cep', $cliente->cep) }}" 
                                class="form-control @error('cep') is-invalid @enderror" 
                                placeholder="00000-000">
                            <div class="input-group-append">
                                <button type="button" id="btn-buscar-cep" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @error('cep')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Logradouro -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Logradouro <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-road"></i></span>
                            </div>
                            <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro', $cliente->logradouro) }}" 
                                class="form-control @error('logradouro') is-invalid @enderror" 
                                placeholder="Rua, Avenida, etc.">
                        </div>
                        @error('logradouro')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Número -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Número <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            </div>
                            <input type="text" name="numero" value="{{ old('numero', $cliente->numero) }}" 
                                class="form-control @error('numero') is-invalid @enderror" 
                                placeholder="Número">
                        </div>
                        @error('numero')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Complemento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Complemento</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                            </div>
                            <input type="text" name="complemento" value="{{ old('complemento', $cliente->complemento) }}" 
                                class="form-control @error('complemento') is-invalid @enderror" 
                                placeholder="Apto, Sala, etc.">
                        </div>
                        @error('complemento')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Bairro -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bairro <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map"></i></span>
                            </div>
                            <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $cliente->bairro) }}" 
                                class="form-control @error('bairro') is-invalid @enderror" 
                                placeholder="Bairro">
                        </div>
                        @error('bairro')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Cidade -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cidade <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                            </div>
                            <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $cliente->cidade) }}" 
                                class="form-control @error('cidade') is-invalid @enderror" 
                                placeholder="Cidade">
                        </div>
                        @error('cidade')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Estado -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                            </div>
                            <select name="estado" class="form-control @error('estado') is-invalid @enderror">
                                <option value="">Selecione o estado</option>
                                @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                                    <option value="{{ $uf }}" {{ old('estado', $cliente->estado) == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('estado')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Telefone -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone) }}" 
                                class="form-control @error('telefone') is-invalid @enderror" 
                                placeholder="(00) 0000-0000">
                        </div>
                        @error('telefone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>E-mail <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $cliente->email) }}" 
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="email@exemplo.com">
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <!-- Status -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                            </div>
                            <select name="ativo" class="form-control @error('ativo') is-invalid @enderror">
                                <option value="1" {{ old('ativo', $cliente->ativo) == 1 ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ old('ativo', $cliente->ativo) == 0 ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        @error('ativo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Observações -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observações</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                            </div>
                            <textarea name="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="3" 
                                placeholder="Observações sobre o cliente">{{ old('observacoes', $cliente->observacoes) }}</textarea>
                        </div>
                        @error('observacoes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar
                    </button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
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
    // Alterna máscara dependendo do tipo de cliente
    function toggleMask() {
        if ($('#tipoPF').is(':checked')) {
            $('#cpf_cnpj').mask('000.000.000-00', {placeholder: "000.000.000-00"});
        } else {
            $('#cpf_cnpj').mask('00.000.000/0000-00', {placeholder: "00.000.000/0000-00"});
        }
    }
    
    // Inicializa a máscara
    toggleMask();
    
    // Atualiza máscara quando o tipo é alterado
    $('input[name="tipo"]').change(function() {
        toggleMask();
    });
    
    // Máscaras para outros campos
    $('#cep').mask('00000-000');
    $('#telefone').mask('(00) 0000-0000');
    
    // Busca CEP
    $('#btn-buscar-cep').click(function() {
        var cep = $('#cep').val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                if (!data.erro) {
                    $('#logradouro').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('select[name=estado]').val(data.uf);
                    $('#numero').focus();
                } else {
                    alert('CEP não encontrado');
                }
            });
        } else {
            alert('Formato de CEP inválido. Use: 00000-000');
        }
    });
});
</script>
@endsection 