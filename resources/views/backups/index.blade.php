@extends('adminlte::page')

@section('title', 'Backups | SGC')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Backups</h1>
    <a href="{{ route('backups.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Novo Backup
    </a>
</div>
@stop

@section('content')
<!-- Resumo dos Backups -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $backups->count() }}</h3>
                <p>Total de Backups</p>
            </div>
            <div class="icon">
                <i class="fas fa-database"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $backups->where('status', 'concluido')->count() }}</h3>
                <p>Backups Concluídos</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $backups->where('status', 'pendente')->count() }}</h3>
                <p>Backups Pendentes</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $backups->where('status', 'falhou')->count() }}</h3>
                <p>Backups Com Falha</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Backups Agendados -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-alt mr-1"></i> Backups Agendados</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Frequência</th>
                        <th>Próximo Backup</th>
                        <th>Último Backup</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups->where('ativo', true) as $backup)
                    <tr>
                        <td>{{ $backup->nome }}</td>
                        <td>
                            <span class="badge badge-{{ $backup->tipo === 'banco' ? 'info' : 'success' }}">
                                {{ $backup->tipo === 'banco' ? 'Banco de Dados' : 'Sistema' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-secondary">
                                {{ ucfirst($backup->frequencia ?? 'Não definida') }}
                                @if($backup->frequencia === 'semanal')
                                    @php
                                        $dias = [
                                            0 => 'Dom',
                                            1 => 'Seg',
                                            2 => 'Ter',
                                            3 => 'Qua',
                                            4 => 'Qui',
                                            5 => 'Sex',
                                            6 => 'Sáb'
                                        ];
                                        $diasSemana = collect($backup->dias_semana ?? [1])->map(function($dia) use ($dias) {
                                            return $dias[$dia] ?? '';
                                        })->join(', ');
                                    @endphp
                                    ({{ $diasSemana }})
                                @elseif($backup->frequencia === 'mensal')
                                    (Dia {{ $backup->dia_mes ?? 1 }})
                                @endif
                                às {{ $backup->horario ?? '00:00' }}
                            </span>
                        </td>
                        <td>{{ $backup->proximo_backup ? $backup->proximo_backup->format('d/m/Y H:i') : 'Não agendado' }}</td>
                        <td>{{ $backup->ultimo_backup ? $backup->ultimo_backup->format('d/m/Y H:i') : 'Nunca executado' }}</td>
                        <td>
                            <span class="badge badge-{{ $backup->status === 'concluido' ? 'success' : ($backup->status === 'pendente' ? 'warning' : 'danger') }}">
                                {{ ucfirst($backup->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('backups.executar', $backup) }}" class="btn btn-primary btn-sm" title="Executar Agora">
                                    <i class="fas fa-play"></i>
                                </a>
                                <a href="{{ route('backups.show', $backup) }}" class="btn btn-info btn-sm" title="Visualizar Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('backups.edit', $backup) }}" class="btn btn-warning btn-sm" title="Editar Agendamento">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('backups.destroy', $backup) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este backup?')" title="Excluir Backup">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhum backup agendado encontrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Lista de Backups Executados -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history mr-1"></i> Histórico de Backups</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Tamanho</th>
                        <th>Status</th>
                        <th>Data de Execução</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                    <tr>
                        <td>{{ $backup->nome }}</td>
                        <td>
                            <span class="badge badge-{{ $backup->tipo === 'banco' ? 'info' : 'success' }}">
                                {{ $backup->tipo === 'banco' ? 'Banco de Dados' : 'Sistema' }}
                            </span>
                        </td>
                        <td>{{ $backup->tamanho }}</td>
                        <td>
                            <span class="badge badge-{{ $backup->status === 'concluido' ? 'success' : ($backup->status === 'pendente' ? 'warning' : 'danger') }}">
                                {{ ucfirst($backup->status) }}
                            </span>
                        </td>
                        <td>{{ $backup->data_execucao ? $backup->data_execucao->format('d/m/Y H:i:s') : '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('backups.show', $backup) }}" class="btn btn-info btn-sm" title="Visualizar Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('backups.destroy', $backup) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este backup?')" title="Excluir Backup">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum backup encontrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $backups->links() }}
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .small-box .icon {
        right: 15px;
        top: 15px;
        font-size: 50px;
    }
    
    .table .badge {
        font-size: 0.9em;
        padding: 5px 10px;
    }
    
    .pagination {
        margin-bottom: 0;
    }
</style>
@stop 