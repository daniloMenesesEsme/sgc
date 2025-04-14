@extends('adminlte::page')

@section('title', 'Editar Fornecedor')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Editar Fornecedor</h1>
        <a href="{{ route('fornecedores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('fornecedores.update', $fornecedor) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="tipo">Tipo <span class="text-danger">*</span></label>
                        <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                            <option value="">Selecione</option>
                            <option value="PF" {{ old('tipo', $fornecedor->tipo) == 'PF' ? 'selected' : '' }}>Pessoa Física</option>
                            <option value="PJ" {{ old('tipo', $fornecedor->tipo) == 'PJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="cpf_cnpj">CPF/CNPJ <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control @error('cpf_cnpj') is-invalid @enderror" 
                                value="{{ old('cpf_cnpj', $fornecedor->cpf_cnpj) }}" required>
                            <div class="input-group-append" id="div-busca-cnpj" style="{{ old('tipo', $fornecedor->tipo) == 'PJ' ? '' : 'display: none;' }}">
                                <button type="button" class="btn btn-info" id="btn-busca-cnpj">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @error('cpf_cnpj')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="nome_razao_social">Nome/Razão Social <span class="text-danger">*</span></label>
                        <input type="text" name="nome_razao_social" id="nome_razao_social" 
                            class="form-control @error('nome_razao_social') is-invalid @enderror" 
                            value="{{ old('nome_razao_social', $fornecedor->nome_razao_social) }}" required>
                        @error('nome_razao_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="nome_fantasia">Nome Fantasia</label>
                        <input type="text" name="nome_fantasia" id="nome_fantasia" 
                            class="form-control @error('nome_fantasia') is-invalid @enderror" 
                            value="{{ old('nome_fantasia', $fornecedor->nome_fantasia) }}">
                        @error('nome_fantasia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="inscricao_estadual">Inscrição Estadual</label>
                        <input type="text" name="inscricao_estadual" id="inscricao_estadual" 
                            class="form-control @error('inscricao_estadual') is-invalid @enderror" 
                            value="{{ old('inscricao_estadual', $fornecedor->inscricao_estadual) }}">
                        @error('inscricao_estadual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="telefone">Telefone <span class="text-danger">*</span></label>
                        <input type="text" name="telefone" id="telefone" 
                            class="form-control @error('telefone') is-invalid @enderror" 
                            value="{{ old('telefone', $fornecedor->telefone) }}" required>
                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email', $fornecedor->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <h5 class="mt-4 mb-3">Endereço</h5>
                
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="cep">CEP</label>
                        <div class="input-group">
                            <input type="text" name="cep" id="cep" 
                                class="form-control @error('cep') is-invalid @enderror" 
                                value="{{ old('cep', $fornecedor->cep) }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info" id="btn-busca-cep">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @error('cep')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-8">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" name="logradouro" id="logradouro" 
                            class="form-control @error('logradouro') is-invalid @enderror" 
                            value="{{ old('logradouro', $fornecedor->logradouro) }}">
                        @error('logradouro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" id="numero" 
                            class="form-control @error('numero') is-invalid @enderror" 
                            value="{{ old('numero', $fornecedor->numero) }}">
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" id="complemento" 
                            class="form-control @error('complemento') is-invalid @enderror" 
                            value="{{ old('complemento', $fornecedor->complemento) }}">
                        @error('complemento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" id="bairro" 
                            class="form-control @error('bairro') is-invalid @enderror" 
                            value="{{ old('bairro', $fornecedor->bairro) }}">
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" 
                            class="form-control @error('cidade') is-invalid @enderror" 
                            value="{{ old('cidade', $fornecedor->cidade) }}">
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                            <option value="">Selecione</option>
                            <option value="AC" {{ old('estado', $fornecedor->estado) == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="AL" {{ old('estado', $fornecedor->estado) == 'AL' ? 'selected' : '' }}>AL</option>
                            <option value="AP" {{ old('estado', $fornecedor->estado) == 'AP' ? 'selected' : '' }}>AP</option>
                            <option value="AM" {{ old('estado', $fornecedor->estado) == 'AM' ? 'selected' : '' }}>AM</option>
                            <option value="BA" {{ old('estado', $fornecedor->estado) == 'BA' ? 'selected' : '' }}>BA</option>
                            <option value="CE" {{ old('estado', $fornecedor->estado) == 'CE' ? 'selected' : '' }}>CE</option>
                            <option value="DF" {{ old('estado', $fornecedor->estado) == 'DF' ? 'selected' : '' }}>DF</option>
                            <option value="ES" {{ old('estado', $fornecedor->estado) == 'ES' ? 'selected' : '' }}>ES</option>
                            <option value="GO" {{ old('estado', $fornecedor->estado) == 'GO' ? 'selected' : '' }}>GO</option>
                            <option value="MA" {{ old('estado', $fornecedor->estado) == 'MA' ? 'selected' : '' }}>MA</option>
                            <option value="MT" {{ old('estado', $fornecedor->estado) == 'MT' ? 'selected' : '' }}>MT</option>
                            <option value="MS" {{ old('estado', $fornecedor->estado) == 'MS' ? 'selected' : '' }}>MS</option>
                            <option value="MG" {{ old('estado', $fornecedor->estado) == 'MG' ? 'selected' : '' }}>MG</option>
                            <option value="PA" {{ old('estado', $fornecedor->estado) == 'PA' ? 'selected' : '' }}>PA</option>
                            <option value="PB" {{ old('estado', $fornecedor->estado) == 'PB' ? 'selected' : '' }}>PB</option>
                            <option value="PR" {{ old('estado', $fornecedor->estado) == 'PR' ? 'selected' : '' }}>PR</option>
                            <option value="PE" {{ old('estado', $fornecedor->estado) == 'PE' ? 'selected' : '' }}>PE</option>
                            <option value="PI" {{ old('estado', $fornecedor->estado) == 'PI' ? 'selected' : '' }}>PI</option>
                            <option value="RJ" {{ old('estado', $fornecedor->estado) == 'RJ' ? 'selected' : '' }}>RJ</option>
                            <option value="RN" {{ old('estado', $fornecedor->estado) == 'RN' ? 'selected' : '' }}>RN</option>
                            <option value="RS" {{ old('estado', $fornecedor->estado) == 'RS' ? 'selected' : '' }}>RS</option>
                            <option value="RO" {{ old('estado', $fornecedor->estado) == 'RO' ? 'selected' : '' }}>RO</option>
                            <option value="RR" {{ old('estado', $fornecedor->estado) == 'RR' ? 'selected' : '' }}>RR</option>
                            <option value="SC" {{ old('estado', $fornecedor->estado) == 'SC' ? 'selected' : '' }}>SC</option>
                            <option value="SP" {{ old('estado', $fornecedor->estado) == 'SP' ? 'selected' : '' }}>SP</option>
                            <option value="SE" {{ old('estado', $fornecedor->estado) == 'SE' ? 'selected' : '' }}>SE</option>
                            <option value="TO" {{ old('estado', $fornecedor->estado) == 'TO' ? 'selected' : '' }}>TO</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <h5 class="mt-4 mb-3">Informações de Fornecimento</h5>
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="fornece_tecido" name="fornece_tecido" value="1" 
                                {{ old('fornece_tecido', $fornecedor->fornece_tecido) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="fornece_tecido">Fornece Tecido</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="fornece_tinta" name="fornece_tinta" value="1" 
                                {{ old('fornece_tinta', $fornecedor->fornece_tinta) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="fornece_tinta">Fornece Tinta</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="fornece_papel" name="fornece_papel" value="1" 
                                {{ old('fornece_papel', $fornecedor->fornece_papel) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="fornece_papel">Fornece Papel</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="fornece_outros" name="fornece_outros" value="1" 
                                {{ old('fornece_outros', $fornecedor->fornece_outros) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="fornece_outros">Fornece Outros</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row mt-3">
                    <div class="form-group col-md-12">
                        <label for="observacoes">Observações</label>
                        <textarea name="observacoes" id="observacoes" rows="4" 
                            class="form-control @error('observacoes') is-invalid @enderror">{{ old('observacoes', $fornecedor->observacoes) }}</textarea>
                        @error('observacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="ativo" name="ativo" value="1" 
                                {{ old('ativo', $fornecedor->ativo) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="ativo">Fornecedor Ativo</label>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer text-right">
                    <a href="{{ route('fornecedores.index') }}" class="btn btn-default">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Atualizar Fornecedor</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Máscaras para os campos
            $('#telefone').mask('(00) 00000-0000');
            $('#cep').mask('00000-000');
            
            // Mudança de máscara baseada no tipo de pessoa
            $('#tipo').change(function() {
                if ($(this).val() === 'PF') {
                    $('#cpf_cnpj').mask('000.000.000-00');
                    $('#div-busca-cnpj').hide();
                } else if ($(this).val() === 'PJ') {
                    $('#cpf_cnpj').mask('00.000.000/0000-00');
                    $('#div-busca-cnpj').show();
                } else {
                    $('#cpf_cnpj').unmask();
                    $('#div-busca-cnpj').hide();
                }
            });
            
            // Aplicar máscara inicial baseada no valor atual
            if ($('#tipo').val() === 'PF') {
                $('#cpf_cnpj').mask('000.000.000-00');
                $('#div-busca-cnpj').hide();
            } else if ($('#tipo').val() === 'PJ') {
                $('#cpf_cnpj').mask('00.000.000/0000-00');
                $('#div-busca-cnpj').show();
            }
            
            // Busca de CNPJ
            $('#btn-busca-cnpj').click(function() {
                var cnpj = $('#cpf_cnpj').val().replace(/[^\d]+/g, '');
                
                if (cnpj.length !== 14) {
                    Swal.fire({
                        icon: 'error',
                        title: 'CNPJ inválido',
                        text: 'Por favor, informe um CNPJ válido.'
                    });
                    return;
                }
                
                $.ajax({
                    url: "{{ route('busca.cnpj') }}",
                    type: 'GET',
                    data: { cnpj: cnpj },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Buscando dados...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        Swal.close();
                        
                        if (data.status === 'success') {
                            $('#nome_razao_social').val(data.razao_social);
                            $('#nome_fantasia').val(data.nome_fantasia);
                            $('#cep').val(data.cep);
                            $('#logradouro').val(data.logradouro);
                            $('#numero').val(data.numero);
                            $('#complemento').val(data.complemento);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.municipio);
                            $('#estado').val(data.uf);
                            $('#telefone').val(data.telefone);
                            $('#email').val(data.email);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao buscar CNPJ',
                                text: data.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao buscar CNPJ',
                            text: 'Não foi possível consultar o CNPJ. Tente novamente mais tarde.'
                        });
                    }
                });
            });
            
            // Busca de CEP
            $('#btn-busca-cep').click(function() {
                var cep = $('#cep').val().replace(/[^\d]+/g, '');
                
                if (cep.length !== 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'CEP inválido',
                        text: 'Por favor, informe um CEP válido.'
                    });
                    return;
                }
                
                $.ajax({
                    url: "{{ route('busca.cep') }}",
                    type: 'GET',
                    data: { cep: cep },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Buscando endereço...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        Swal.close();
                        
                        if (data.status === 'success') {
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.cidade);
                            $('#estado').val(data.uf);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao buscar CEP',
                                text: data.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao buscar CEP',
                            text: 'Não foi possível consultar o CEP. Tente novamente mais tarde.'
                        });
                    }
                });
            });
        });
    </script>
@stop 