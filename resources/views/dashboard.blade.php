@extends('adminlte::page')

@section('title', 'Dashboard | SGC')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .info-box-text {
        white-space: normal;
        font-weight: 600;
    }
    .card-body canvas {
        min-height: 250px;
    }
    .small-box h3 {
        font-size: 2.5rem;
        font-weight: 700;
    }
    .small-box .icon {
        opacity: 0.7;
    }
    .small-box:hover .icon {
        opacity: 1;
    }
    .card-title {
        font-weight: 600;
    }
    .timeline>li>.timeline-item {
        box-shadow: 0 0 1px rgba(0,0,0,.1);
    }
    .bg-navy {
        background-color: #001f3f !important;
    }
</style>
@stop

@section('content')
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{ $totalClientes ?? 0 }}</h3>
                    <p>Clientes Cadastrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('clientes.index') }}" class="small-box-footer">
                    Gerenciar Clientes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $totalEmpresas ?? 0 }}</h3>
                    <p>Empresas Cadastradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('empresas.index') }}" class="small-box-footer">
                    Gerenciar Empresas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $totalUsuarios ?? 0 }}</h3>
                    <p>Usuários Ativos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Gerenciar Usuários <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
            <!-- ÁREA DE GRÁFICOS -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Evolução de Cadastros
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                        <div class="text-center">
                            <i class="fas fa-chart-line fa-4x text-secondary mb-3"></i>
                            <p class="text-muted">Estatísticas serão exibidas aqui conforme o crescimento do sistema</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE: Últimos Clientes Cadastrados -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-plus mr-1"></i>
                        Últimos Clientes Cadastrados
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle fa-2x text-primary mr-2"></i>
                                            Cliente Exemplo
                                        </div>
                                    </td>
                                    <td><span class="badge badge-primary">Pessoa Física</span></td>
                                    <td>Hoje, 14:32</td>
                                    <td><span class="badge badge-success">Ativo</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building fa-2x text-purple mr-2"></i>
                                            Empresa Exemplo
                                        </div>
                                    </td>
                                    <td><span class="badge badge-purple">Pessoa Jurídica</span></td>
                                    <td>Ontem, 16:42</td>
                                    <td><span class="badge badge-success">Ativo</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-primary">Ver Todos os Clientes</a>
                </div>
            </div>
        </div>

        <!-- Right col -->
        <div class="col-md-4">
            <!-- CARD: INFORMAÇÕES DO SISTEMA -->
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Informações do Sistema
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-calendar-check mr-2 text-success"></i> Sistema atualizado</span>
                            <span class="badge badge-success">Sim</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-database mr-2 text-primary"></i> Backup mais recente</span>
                            <span>Hoje</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-code-branch mr-2 text-info"></i> Versão</span>
                            <span>1.0.0</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CARD: Atividades Recentes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Atividades Recentes
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="timeline timeline-inverse p-3">
                        <div class="time-label">
                            <span class="bg-primary">Hoje</span>
                        </div>
                        <div>
                            <i class="fas fa-user-plus bg-primary"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> 2 horas atrás</span>
                                <h3 class="timeline-header"><a href="#">Equipe de vendas</a> adicionou um novo cliente</h3>
                                <div class="timeline-body">
                                    Cliente foi cadastrado com sucesso no sistema.
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <i class="fas fa-building bg-success"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> 3 horas atrás</span>
                                <h3 class="timeline-header"><a href="#">Admin</a> atualizou empresa</h3>
                                <div class="timeline-body">
                                    Dados da empresa foram atualizados.
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <i class="fas fa-edit bg-warning"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> 5 horas atrás</span>
                                <h3 class="timeline-header"><a href="#">Suporte</a> atualizou informações do cliente</h3>
                                <div class="timeline-body">
                                    Alteração nos dados cadastrais do cliente.
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Script para inicializar futuros componentes JS (gráficos, etc)
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop
