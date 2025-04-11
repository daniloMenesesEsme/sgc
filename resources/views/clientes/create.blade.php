@extends('adminlte::page')

@section('title', 'Novo Cliente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Novo Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left mr-1"></i> Voltar
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Tipo de Cliente -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de Cliente <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio mr-3">
                                        <input class="custom-control-input" type="radio" id="tipoPF" name="tipo" value="F" {{ old('tipo', 'F') == 'F' ? 'checked' : '' }}>
                                        <label for="tipoPF" class="custom-control-label">Pessoa Física</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="tipoPJ" name="tipo" value="J" {{ old('tipo') == 'J' ? 'checked' : '' }}>
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
                                    <input type="text" name="nome_razao_social" value="{{ old('nome_razao_social') }}" 
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
                                    <input type="text" name="nome_fantasia" value="{{ old('nome_fantasia') }}" 
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
                                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="{{ old('cpf_cnpj') }}" 
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
                                    <input type="text" name="rg_ie" value="{{ old('rg_ie') }}" 
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
                                    <input type="text" name="cep" id="cep" value="{{ old('cep') }}" 
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
                                    <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro') }}" 
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
                                    <input type="text" name="numero" value="{{ old('numero') }}" 
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
                                    <input type="text" name="complemento" value="{{ old('complemento') }}" 
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
                                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro') }}" 
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
                                    <input type="text" name="cidade" id="cidade" value="{{ old('cidade') }}" 
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
                                            <option value="{{ $uf }}" {{ old('estado') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
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
                                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" 
                                        class="form-control @error('telefone') is-invalid @enderror" 
                                        placeholder="(00) 0000-0000">
                                </div>
                                @error('telefone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Celular -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Celular</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    </div>
                                    <input type="text" name="celular" id="celular" value="{{ old('celular') }}" 
                                        class="form-control @error('celular') is-invalid @enderror" 
                                        placeholder="(00) 00000-0000">
                                </div>
                                @error('celular')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>E-mail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        placeholder="email@exemplo.com">
                                </div>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Site -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Site</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    </div>
                                    <input type="url" name="site" value="{{ old('site') }}" 
                                        class="form-control @error('site') is-invalid @enderror" 
                                        placeholder="https://www.exemplo.com.br">
                                </div>
                                @error('site')
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
                                        <option value="1" {{ old('ativo', '1') == '1' ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ old('ativo') == '0' ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                </div>
                                @error('ativo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Observações</label>
                                <textarea name="observacoes" rows="3" 
                                    class="form-control @error('observacoes') is-invalid @enderror" 
                                    placeholder="Informações adicionais sobre o cliente">{{ old('observacoes') }}</textarea>
                                @error('observacoes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('clientes.index') }}" class="btn btn-default mr-2">
                            <i class="fas fa-times mr-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Aplicar máscara de acordo com o tipo selecionado
    $('input[name="tipo"]').change(function() {
        var tipo = $('input[name="tipo"]:checked').val();
        if (tipo === 'F') {
            $('#cpf_cnpj').mask('000.000.000-00', {
                placeholder: '000.000.000-00'
            });
        } else {
            $('#cpf_cnpj').mask('00.000.000/0000-00', {
                placeholder: '00.000.000/0000-00'
            });
        }
    }).trigger('change');
    
    // Máscara para telefone e celular
    $('#telefone').mask('(00) 0000-0000', {
        placeholder: '(00) 0000-0000'
    });
    
    $('#celular').mask('(00) 00000-0000', {
        placeholder: '(00) 00000-0000'
    });

    // Máscara para CEP
    $('#cep').mask('00000-000', {
        placeholder: '00000-000'
    });

    // Função para consultar o CEP
    function consultarCEP(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length === 8) {
            // Mostrar indicação de carregamento
            $('#logradouro').val('Carregando...');
            $('#bairro').val('Carregando...');
            $('#cidade').val('Carregando...');
            
            $.get(`https://viacep.com.br/ws/${cep}/json/`)
                .done(function(data) {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('select[name=estado]').val(data.uf);
                        
                        // Foco no número após preencher o endereço
                        $('input[name=numero]').focus();
                    } else {
                        alert('CEP não encontrado. Por favor, verifique o número informado.');
                        $('#logradouro').val('');
                        $('#bairro').val('');
                        $('#cidade').val('');
                        $('select[name=estado]').val('');
                    }
                })
                .fail(function() {
                    alert('Erro ao consultar o CEP. Verifique sua conexão e tente novamente.');
                    $('#logradouro').val('');
                    $('#bairro').val('');
                    $('#cidade').val('');
                    $('select[name=estado]').val('');
                });
        }
    }

    // Consultar CEP ao perder o foco
    $('#cep').blur(function() {
        consultarCEP($(this).val());
    });
    
    // Consultar CEP ao clicar no botão de busca
    $('#btn-buscar-cep').click(function() {
        consultarCEP($('#cep').val());
    });
});
</script>
@stop 