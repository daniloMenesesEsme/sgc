@extends('adminlte::page')

@section('title', 'Novo Backup | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Novo Backup</h1>
    <a href="{{ route('backups.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulário de Backup</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('backups.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Tipo de Backup -->
                <div class="col-md-4 form-group">
                    <label>Tipo de Backup <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-database"></i></span>
                        </div>
                        <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                            <option value="">Selecione</option>
                            <option value="banco" {{ old('tipo') == 'banco' ? 'selected' : '' }}>Banco de Dados</option>
                            <option value="sistema" {{ old('tipo') == 'sistema' ? 'selected' : '' }}>Sistema Completo</option>
                            <option value="completo" {{ old('tipo') == 'completo' ? 'selected' : '' }}>Backup Completo (BD + Sistema)</option>
                        </select>
                    </div>
                    @error('tipo')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Caminho do Backup -->
                <div class="col-md-8 form-group">
                    <label>Caminho do Backup <small class="text-muted">(Opcional - Será usado o caminho padrão se vazio)</small></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                        </div>
                        <input type="text" name="caminho" value="{{ old('caminho', $caminhoPadrao) }}" class="form-control @error('caminho') is-invalid @enderror" placeholder="Caminho onde será salvo o backup">
                        <div class="input-group-append">
                            <span class="input-group-text bg-light">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="salvar_caminho" name="salvar_caminho" value="1" {{ old('salvar_caminho', '0') == '1' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="salvar_caminho">Salvar como padrão</label>
                                </div>
                            </span>
                        </div>
                    </div>
                    @error('caminho')
                        <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Caminho padrão atual: <strong>{{ $caminhoPadrao }}</strong></small>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-1"></i> Agendamento de Backup
                    </h3>
                    <div class="card-tools">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="agendamento_ativo" name="ativo" value="1" {{ old('ativo', '1') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="agendamento_ativo">Ativar Agendamento</label>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="agendamento_opcoes">
                    <div class="row">
                        <!-- Frequência -->
                        <div class="col-md-4 form-group">
                            <label>Frequência</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                </div>
                                <select name="frequencia" id="frequencia" class="form-control @error('frequencia') is-invalid @enderror">
                                    <option value="diario" {{ old('frequencia', 'diario') == 'diario' ? 'selected' : '' }}>Diário</option>
                                    <option value="semanal" {{ old('frequencia') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                                    <option value="mensal" {{ old('frequencia') == 'mensal' ? 'selected' : '' }}>Mensal</option>
                                </select>
                            </div>
                            @error('frequencia')
                                <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Horário -->
                        <div class="col-md-4 form-group">
                            <label>Horário</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                </div>
                                <input type="time" name="horario" value="{{ old('horario', '23:00') }}" class="form-control @error('horario') is-invalid @enderror">
                            </div>
                            @error('horario')
                                <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Dias da Semana (para backup semanal) -->
                    <div class="row mt-3" id="dias_semana_opcoes" style="{{ old('frequencia') == 'semanal' ? '' : 'display: none;' }}">
                        <div class="col-md-12 form-group">
                            <label>Dias da Semana</label>
                            <div class="d-flex flex-wrap bg-light p-3 rounded">
                                @php
                                    $diasSemana = [
                                        0 => 'Domingo',
                                        1 => 'Segunda',
                                        2 => 'Terça',
                                        3 => 'Quarta',
                                        4 => 'Quinta',
                                        5 => 'Sexta',
                                        6 => 'Sábado'
                                    ];
                                    $diasSelecionados = old('dias_semana', [1]); // Segunda-feira por padrão
                                    if (!is_array($diasSelecionados)) {
                                        $diasSelecionados = [$diasSelecionados];
                                    }
                                @endphp

                                @foreach($diasSemana as $valor => $dia)
                                <div class="custom-control custom-checkbox mr-4">
                                    <input type="checkbox" class="custom-control-input" id="dia_{{ $valor }}" name="dias_semana[]" value="{{ $valor }}" 
                                        {{ in_array($valor, $diasSelecionados) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="dia_{{ $valor }}">{{ $dia }}</label>
                                </div>
                                @endforeach
                            </div>
                            @error('dias_semana')
                                <span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Dia do Mês (para backup mensal) -->
                    <div class="row mt-3" id="dia_mes_opcoes" style="{{ old('frequencia') == 'mensal' ? '' : 'display: none;' }}">
                        <div class="col-md-4 form-group">
                            <label>Dia do Mês</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                </div>
                                <input type="number" name="dia_mes" min="1" max="31" value="{{ old('dia_mes', 1) }}" 
                                       class="form-control @error('dia_mes') is-invalid @enderror">
                            </div>
                            <small class="form-text text-muted">Se o dia não existir no mês (ex: 31 em Abril), o backup será feito no último dia do mês.</small>
                            @error('dia_mes')
                                <span class="error invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar e Executar Backup
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
        // Alternar visibilidade das opções de agendamento
        $('#agendamento_ativo').change(function() {
            if($(this).is(':checked')) {
                $('#agendamento_opcoes').slideDown();
            } else {
                $('#agendamento_opcoes').slideUp();
            }
        });

        // Alternar opções de dia com base na frequência
        $('#frequencia').change(function() {
            let frequencia = $(this).val();
            
            if(frequencia === 'semanal') {
                $('#dias_semana_opcoes').slideDown();
                $('#dia_mes_opcoes').slideUp();
            } else if(frequencia === 'mensal') {
                $('#dias_semana_opcoes').slideUp();
                $('#dia_mes_opcoes').slideDown();
            } else {
                $('#dias_semana_opcoes').slideUp();
                $('#dia_mes_opcoes').slideUp();
            }
        });

        // Inicializar a visibilidade com base no valor inicial
        if(!$('#agendamento_ativo').is(':checked')) {
            $('#agendamento_opcoes').hide();
        }
        
        // Inicializar a frequência atual
        $('#frequencia').trigger('change');
    });
</script>
@stop 