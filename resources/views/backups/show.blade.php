@extends('adminlte::page')

@section('title', 'Detalhes do Backup | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Detalhes do Backup</h1>
    <a href="{{ route('backups.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informações do Backup</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Nome -->
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Nome</span>
                        <span class="info-box-number">{{ $backup->nome }}</span>
                    </div>
                </div>
            </div>

            <!-- Tipo -->
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-database"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tipo</span>
                        <span class="info-box-number">
                            {{ $backup->tipo === 'banco' ? 'Banco de Dados' : 'Sistema Completo' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Caminho -->
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-folder"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Caminho</span>
                        <span class="info-box-number">{{ $backup->caminho }}</span>
                    </div>
                </div>
            </div>

            <!-- Tamanho -->
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-weight"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tamanho</span>
                        <span class="info-box-number">{{ $backup->tamanho }}</span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-{{ $backup->status === 'concluido' ? 'success' : ($backup->status === 'pendente' ? 'warning' : 'danger') }}">
                        <i class="fas fa-{{ $backup->status === 'concluido' ? 'check' : ($backup->status === 'pendente' ? 'clock' : 'times') }}"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Status</span>
                        <span class="info-box-number">{{ ucfirst($backup->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- Data de Execução -->
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary"><i class="fas fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Data de Execução</span>
                        <span class="info-box-number">
                            {{ $backup->data_execucao ? $backup->data_execucao->format('d/m/Y H:i:s') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($backup->observacoes)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Observações</h3>
                    </div>
                    <div class="card-body">
                        {{ $backup->observacoes }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row mt-4">
            <div class="col-12">
                <form action="{{ route('backups.destroy', $backup) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este backup?')">
                        <i class="fas fa-trash mr-1"></i> Excluir Backup
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop 