<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    // Caminho padrão para os backups
    protected $caminhoPadrao = 'backups';
    
    public function __construct()
    {
        // Configura o fuso horário para Brasil/São Paulo
        date_default_timezone_set('America/Sao_Paulo');
        
        // Fuso horário do Carbon
        Carbon::setLocale('pt_BR');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backups = Backup::orderBy('created_at', 'desc')->paginate(10);
        
        // Recupera configurações salvas no banco
        $configuracoes = DB::table('configuracoes')
            ->where('chave', 'backup_caminho_padrao')
            ->first();
            
        $caminhoPadrao = $configuracoes ? $configuracoes->valor : $this->caminhoPadrao;
        
        return view('backups.index', compact('backups', 'caminhoPadrao'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Recupera configurações salvas no banco
        $configuracoes = DB::table('configuracoes')
            ->where('chave', 'backup_caminho_padrao')
            ->first();
            
        $caminhoPadrao = $configuracoes ? $configuracoes->valor : $this->caminhoPadrao;
        
        return view('backups.create', compact('caminhoPadrao'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:banco,sistema,completo',
            'caminho' => 'nullable|string',
            'ativo' => 'boolean',
            'frequencia' => 'nullable|in:diario,semanal,mensal',
            'horario' => 'nullable|date_format:H:i',
            'dias_semana' => 'nullable|array',
            'dias_semana.*' => 'nullable|integer|between:0,6',
            'dia_mes' => 'nullable|integer|between:1,31',
            'salvar_caminho' => 'boolean',
        ]);
        
        // Salvar caminho como padrão se solicitado
        if ($request->has('salvar_caminho') && $request->salvar_caminho) {
            DB::table('configuracoes')
                ->updateOrInsert(
                    ['chave' => 'backup_caminho_padrao'],
                    ['valor' => $request->caminho, 'updated_at' => now()]
                );
        }
        
        // Recuperar caminho padrão se o caminho não foi fornecido
        $caminho = $request->caminho;
        if (empty($caminho)) {
            $configuracoes = DB::table('configuracoes')
                ->where('chave', 'backup_caminho_padrao')
                ->first();
                
            $caminho = $configuracoes ? $configuracoes->valor : $this->caminhoPadrao;
        }
        
        // Remover qualquer caminho absoluto (C:\) ou referências ao sistema de arquivos
        $caminho = preg_replace('/^[A-Z]:\\\\.*?\\\\/', '', $caminho);
        $caminho = str_replace('\\', '/', $caminho);
        
        // Garantir que o caminho começa com 'backups/'
        if (!Str::startsWith($caminho, 'backups/')) {
            $caminho = 'backups/' . trim($caminho, '/');
        }
        
        // Garantir que o nome do arquivo incluirá a data
        if (!Str::endsWith($caminho, '.zip')) {
            $caminho = rtrim($caminho, '/') . '/' . 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.zip';
        }

        $backup = new Backup([
            'nome' => 'backup_' . Carbon::now()->format('Y-m-d_H-i-s'),
            'tipo' => $request->tipo,
            'caminho' => $caminho,
            'status' => 'pendente',
            'tamanho' => '0',
        ]);

        // Configurar agendamento se ativo
        if ($request->has('ativo')) {
            $backup->ativo = true;
            $backup->frequencia = $request->frequencia ?? 'diario';
            $backup->horario = $request->horario ?? '23:00';
            
            if ($backup->frequencia === 'semanal') {
                $backup->dias_semana = $request->dias_semana ?? [1]; // Segunda-feira por padrão
            } elseif ($backup->frequencia === 'mensal') {
                $backup->dia_mes = $request->dia_mes ?? 1; // Dia 1 por padrão
            }
            
            $backup->proximo_backup = $backup->calcularProximoBackup();
        } else {
            $backup->ativo = false;
        }

        $backup->save();

        // Executar o backup imediatamente
        if ($request->tipo === 'banco') {
            $this->backupBanco($backup);
        } elseif ($request->tipo === 'sistema') {
            $this->backupSistema($backup);
        } else {
            $this->backupCompleto($backup);
        }

        return redirect()->route('backups.index')
            ->with('success', 'Backup configurado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Backup $backup)
    {
        return view('backups.show', compact('backup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Backup $backup)
    {
        return view('backups.edit', compact('backup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Backup $backup)
    {
        $request->validate([
            'ativo' => 'boolean',
            'frequencia' => 'nullable|in:diario,semanal,mensal',
            'horario' => 'nullable|date_format:H:i',
            'dias_semana' => 'nullable|array',
            'dias_semana.*' => 'nullable|integer|between:0,6',
            'dia_mes' => 'nullable|integer|between:1,31',
        ]);

        // Atualizar configurações de agendamento
        if ($request->has('ativo')) {
            $backup->ativo = true;
            $backup->frequencia = $request->frequencia ?? 'diario';
            $backup->horario = $request->horario ?? '23:00';
            
            if ($backup->frequencia === 'semanal') {
                $backup->dias_semana = $request->dias_semana ?? [1]; // Segunda-feira por padrão
            } elseif ($backup->frequencia === 'mensal') {
                $backup->dia_mes = $request->dia_mes ?? 1; // Dia 1 por padrão
            }
            
            $backup->proximo_backup = $backup->calcularProximoBackup();
        } else {
            $backup->ativo = false;
        }

        $backup->save();

        return redirect()->route('backups.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Backup $backup)
    {
        if (Storage::exists($backup->caminho)) {
            Storage::delete($backup->caminho);
        }
        
        $backup->delete();
        
        return redirect()->route('backups.index')
            ->with('success', 'Backup excluído com sucesso!');
    }

    /**
     * Executa o backup manualmente.
     */
    public function executar(Backup $backup)
    {
        if ($backup->tipo === 'banco') {
            $this->backupBanco($backup);
        } elseif ($backup->tipo === 'sistema') {
            $this->backupSistema($backup);
        } else {
            $this->backupCompleto($backup);
        }

        // Atualizar o próximo backup agendado se estiver ativo
        if ($backup->ativo) {
            $backup->ultimo_backup = now();
            $backup->proximo_backup = $backup->calcularProximoBackup();
            $backup->save();
        }
        
        return redirect()->route('backups.index')
            ->with('success', 'Backup executado com sucesso!');
    }

    /**
     * Salva o caminho padrão para backups.
     */
    public function salvarCaminhoPadrao(Request $request)
    {
        $request->validate([
            'caminho_padrao' => 'required|string',
        ]);
        
        DB::table('configuracoes')
            ->updateOrInsert(
                ['chave' => 'backup_caminho_padrao'],
                ['valor' => $request->caminho_padrao, 'updated_at' => now()]
            );
        
        return redirect()->route('backups.index')
            ->with('success', 'Caminho padrão de backup atualizado com sucesso!');
    }

    private function backupBanco(Backup $backup)
    {
        try {
            // Garantir que o diretório de destino exista
            $diretorio = dirname($backup->caminho);
            if (!Storage::exists($diretorio)) {
                Storage::makeDirectory($diretorio);
            }
            
            // Tentar executar o backup nativo do Laravel
            try {
                Artisan::call('backup:run', [
                    '--only-db' => true,
                    '--disable-notifications' => true,
                ]);
            } catch (\Exception $e) {
                // Se falhar com o mysqldump, tente usar o HeidiSQL (ou outra abordagem manual)
                $this->fazerBackupManual($backup);
                return;
            }
            
            // Verificar se o arquivo foi criado com sucesso
            if (Storage::exists($backup->caminho)) {
                $backup->update([
                    'status' => 'concluido',
                    'tamanho' => $this->formatarTamanho(Storage::size($backup->caminho)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                ]);
            } else {
                // Procurar pelo arquivo de backup mais recente
                $backupsDir = 'backups';
                $arquivos = [];
                
                if (Storage::exists($backupsDir)) {
                    $arquivos = Storage::files($backupsDir);
                }
                
                $arquivoMaisRecente = null;
                
                if (!empty($arquivos)) {
                    $arquivoMaisRecente = collect($arquivos)->sortByDesc(function ($arquivo) {
                        return Storage::lastModified($arquivo);
                    })->first();
                }
                
                if ($arquivoMaisRecente) {
                    $backup->update([
                        'caminho' => $arquivoMaisRecente,
                        'status' => 'concluido',
                        'tamanho' => $this->formatarTamanho(Storage::size($arquivoMaisRecente)),
                        'data_execucao' => now(),
                        'ultimo_backup' => now(),
                    ]);
                } else {
                    // Se não encontrou arquivo recente, tente backup manual
                    $this->fazerBackupManual($backup);
                }
            }
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'falhou',
                'observacoes' => $e->getMessage(),
                'data_execucao' => now(),
            ]);
        }
    }
    
    /**
     * Executa um backup manual do banco de dados
     */
    private function fazerBackupManual(Backup $backup)
    {
        try {
            // Obter configurações do banco de dados
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            
            // Manter o caminho original .zip ou substituir .txt por .sql
            $caminho = str_replace('.txt', '.sql', $backup->caminho);
            $caminho = str_replace('.zip', '.sql', $caminho);
            
            // Extrair o caminho base (sem o prefixo "backups/")
            $relativePath = preg_replace('/^backups\//', '', $caminho);
            
            // Obter caminho especificado pelo usuário
            $userPath = dirname($relativePath);
            
            // Criar caminho físico
            $backupDir = base_path('../backup_sgc');
            
            // Se o usuário informou um diretório específico, usar esse diretório
            if (!empty($userPath) && $userPath != '.') {
                $backupDir = $backupDir . '/' . $userPath;
            }
            
            // Verificar se o diretório existe, se não, criar
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            // Nome do arquivo SQL
            $sqlFile = $backupDir . '/' . basename($caminho);
            
            // Executar mysqldump
            $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe';
            
            if (!file_exists($mysqldump)) {
                // Tentar encontrar o mysqldump em outros caminhos comuns
                $potentialPaths = [
                    'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
                    'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                    'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
                    'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe'
                ];
                
                foreach ($potentialPaths as $path) {
                    if (file_exists($path)) {
                        $mysqldump = $path;
                        break;
                    }
                }
            }
            
            $cmd = "\"{$mysqldump}\" --user={$username} --host={$host} ";
            
            if (!empty($password)) {
                $cmd .= "--password={$password} ";
            }
            
            $cmd .= "{$database} > \"{$sqlFile}\"";
            
            // Executar o comando
            exec($cmd, $output, $returnVar);
            
            if ($returnVar !== 0) {
                // Se falhar, criar arquivo de texto com instruções
                $txtFile = str_replace('.sql', '.txt', $sqlFile);
                $message = "Este é um arquivo de instruções para backup manual criado em " . now()->format('d/m/Y H:i:s') . ".\n\n";
                $message .= "O backup automático falhou. Por favor, execute o backup do banco manualmente:\n";
                $message .= "Banco: {$database}\n";
                $message .= "Host: {$host}\n";
                $message .= "Usuário: {$username}\n\n";
                $message .= "Comando que falhou: {$cmd}\n";
                $message .= "Erro: " . ($output ? implode("\n", $output) : "Código de erro: {$returnVar}");
                
                file_put_contents($txtFile, $message);
                
                $backup->update([
                    'caminho' => str_replace('.sql', '.txt', $caminho),
                    'status' => 'concluido',
                    'tamanho' => $this->formatarTamanho(filesize($txtFile)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                    'observacoes' => 'Backup automático falhou. Veja o arquivo de instruções para detalhes.'
                ]);
            } else {
                // Backup bem-sucedido
                $backup->update([
                    'caminho' => $caminho,
                    'status' => 'concluido',
                    'tamanho' => $this->formatarTamanho(filesize($sqlFile)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                    'observacoes' => 'Backup do banco de dados realizado com sucesso usando mysqldump.'
                ]);
            }
            
            return true;
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'falhou',
                'observacoes' => 'Falha no backup do banco: ' . $e->getMessage(),
                'data_execucao' => now(),
            ]);
            
            \Log::error('Erro no backup do banco: ' . $e->getMessage());
            return false;
        }
    }

    private function backupSistema(Backup $backup)
    {
        try {
            // Garantir que o diretório de destino exista
            $diretorio = dirname($backup->caminho);
            if (!Storage::exists($diretorio)) {
                Storage::makeDirectory($diretorio);
            }
            
            try {
                Artisan::call('backup:run', [
                    '--only-files' => true,
                    '--disable-notifications' => true,
                ]);
            } catch (\Exception $e) {
                // Se falhar, use o método alternativo
                $this->fazerBackupSistemaManual($backup);
                return;
            }
            
            // Verificar se o arquivo foi criado com sucesso
            if (Storage::exists($backup->caminho)) {
                $backup->update([
                    'status' => 'concluido',
                    'tamanho' => $this->formatarTamanho(Storage::size($backup->caminho)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                ]);
            } else {
                // Procurar pelo arquivo de backup mais recente
                $backupsDir = 'backups';
                $arquivos = [];
                
                if (Storage::exists($backupsDir)) {
                    $arquivos = Storage::files($backupsDir);
                }
                
                $arquivoMaisRecente = null;
                
                if (!empty($arquivos)) {
                    $arquivoMaisRecente = collect($arquivos)->sortByDesc(function ($arquivo) {
                        return Storage::lastModified($arquivo);
                    })->first();
                }
                
                if ($arquivoMaisRecente) {
                    $backup->update([
                        'caminho' => $arquivoMaisRecente,
                        'status' => 'concluido',
                        'tamanho' => $this->formatarTamanho(Storage::size($arquivoMaisRecente)),
                        'data_execucao' => now(),
                        'ultimo_backup' => now(),
                    ]);
                } else {
                    // Se não encontrou nenhum arquivo, use o método alternativo
                    $this->fazerBackupSistemaManual($backup);
                }
            }
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'falhou',
                'observacoes' => $e->getMessage(),
                'data_execucao' => now(),
            ]);
            
            \Log::error('Erro no backup do sistema: ' . $e->getMessage());
        }
    }
    
    /**
     * Cria um arquivo de texto com informações sobre como fazer backup manual do sistema
     */
    private function fazerBackupSistemaManual(Backup $backup)
    {
        try {
            // Manter o caminho original .zip
            $caminho = str_replace('.txt', '.zip', $backup->caminho);
            
            // Extrair o caminho base (sem o prefixo "backups/")
            $relativePath = preg_replace('/^backups\//', '', $caminho);
            
            // Obter caminho especificado pelo usuário
            $userPath = dirname($relativePath);
            
            // Criar caminho físico
            $backupDir = base_path('../backup_sgc');
            
            // Se o usuário informou um diretório específico, usar esse diretório
            if (!empty($userPath) && $userPath != '.') {
                $backupDir = $backupDir . '/' . $userPath;
            }
            
            // Verificar se o diretório existe, se não, criar
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            // Nome do arquivo ZIP
            $zipFile = $backupDir . '/' . basename($caminho);
            
            // Diretório do projeto
            $sourceDir = base_path();
            
            // Tentar executar o comando ZIP nativo do Windows
            $zipCmd = "powershell -command \"Add-Type -A 'System.IO.Compression.FileSystem'; ";
            $zipCmd .= "[System.IO.Compression.ZipFile]::CreateFromDirectory('{$sourceDir}', '{$zipFile}', ";
            $zipCmd .= "[System.IO.Compression.CompressionLevel]::Optimal, `$false)\"";
            
            exec($zipCmd, $output, $returnVar);
            
            if ($returnVar !== 0) {
                // Se falhar com o PowerShell, tentar com 7-Zip se disponível
                $sevenZip = 'C:\\Program Files\\7-Zip\\7z.exe';
                if (file_exists($sevenZip)) {
                    $zipCmd = "\"{$sevenZip}\" a -tzip \"{$zipFile}\" \"{$sourceDir}\\*\" -xr!\"vendor\" -xr!\"node_modules\" -xr!\"storage\\logs\" -xr!\"*.git\"";
                    exec($zipCmd, $output, $returnVar);
                }
            }
            
            if ($returnVar !== 0) {
                // Se ambos falharem, criar arquivo de texto com instruções
                $txtFile = str_replace('.zip', '.txt', $zipFile);
                $message = "Este é um arquivo de instruções para backup manual criado em " . now()->format('d/m/Y H:i:s') . ".\n\n";
                $message .= "O backup automático do sistema falhou. Por favor, faça o backup manualmente:\n";
                $message .= "1. Comprima a pasta: {$sourceDir}\n";
                $message .= "2. Exclua as pastas 'vendor' e 'node_modules' para reduzir o tamanho\n";
                $message .= "3. Salve o arquivo .zip neste diretório\n";
                
                file_put_contents($txtFile, $message);
                
                $backup->update([
                    'caminho' => str_replace('.zip', '.txt', $caminho),
                    'status' => 'concluido',
                    'tamanho' => $this->formatarTamanho(filesize($txtFile)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                    'observacoes' => 'Backup automático do sistema falhou. Veja o arquivo de instruções para detalhes.'
                ]);
            } else {
                // Backup bem-sucedido
                $backup->update([
                    'caminho' => $caminho,
                    'status' => 'concluido',
                    'tamanho' => $this->formatarTamanho(filesize($zipFile)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                    'observacoes' => 'Backup do sistema realizado com sucesso.'
                ]);
            }
            
            return true;
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'falhou',
                'observacoes' => 'Falha no backup do sistema: ' . $e->getMessage(),
                'data_execucao' => now(),
            ]);
            
            \Log::error('Erro no backup do sistema: ' . $e->getMessage());
            return false;
        }
    }

    private function backupCompleto(Backup $backup)
    {
        try {
            // Garantir que o diretório de destino exista
            $diretorio = dirname($backup->caminho);
            if (!Storage::exists($diretorio)) {
                Storage::makeDirectory($diretorio);
            }
            
            // Vamos fazer uma tentativa alternativa em vez de usar o Artisan
            $this->fazerBackupCompletoManual($backup);
            return;
            
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'falhou',
                'observacoes' => $e->getMessage(),
                'data_execucao' => now(),
            ]);
            
            \Log::error('Erro no backup completo: ' . $e->getMessage());
        }
    }
    
    /**
     * Cria arquivos de backup para sistema e banco de dados manualmente
     */
    private function fazerBackupCompletoManual(Backup $backup)
    {
        try {
            // Verificar ferramentas necessárias
            $this->verificarDependencias($backup);
            
            // Gerar nomes de arquivos baseados no caminho original
            $caminhoBanco = str_replace('.zip', '_db.sql', $backup->caminho);
            $caminhoSistema = $backup->caminho; // Mantém o .zip para o sistema
            
            // Extrair o caminho base (sem o prefixo "backups/")
            $relativePath = preg_replace('/^backups\//', '', $backup->caminho);
            
            // Obter caminho especificado pelo usuário
            $userPath = dirname($relativePath);
            
            // Criar caminho físico
            $backupDir = base_path('../backup_sgc');
            
            // Diretório do projeto (declarar aqui para evitar erro)
            $sourceDir = base_path();
            
            // Se o usuário informou um diretório específico, usar esse diretório
            if (!empty($userPath) && $userPath != '.') {
                $backupDir = $backupDir . '/' . $userPath;
            }
            
            // Verificar se o diretório existe, se não, criar
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            // Configurações do banco de dados
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            
            // Preparar arquivos
            $sqlFile = $backupDir . '/' . basename($caminhoBanco);
            $zipFile = $backupDir . '/' . basename($caminhoSistema);
            
            // Tentar backup do banco de dados
            $mysqldump = $this->encontrarMysqldump();
            
            // Se não encontrou mysqldump, falhar
            if (!$mysqldump) {
                throw new \Exception('Mysqldump não encontrado. Instale MySQL ou MariaDB.');
            }
            
            $cmdBanco = "\"{$mysqldump}\" --user={$username} --host={$host} ";
            
            if (!empty($password)) {
                $cmdBanco .= "--password={$password} ";
            }
            
            $cmdBanco .= "{$database} > \"{$sqlFile}\"";
            
            // Executar comando de backup do banco
            exec($cmdBanco, $output, $returnVarBanco);
            
            // Executar comando de backup do sistema - usando método mais seguro
            $sevenZip = $this->encontrarZipTool();
            $returnVarSistema = 1; // Inicializa com erro
            
            if ($sevenZip) {
                $zipCmd = "\"{$sevenZip}\" a -tzip \"{$zipFile}\" \"{$sourceDir}\\*\" -xr!\"vendor\" -xr!\"node_modules\" -xr!\"storage\\logs\" -xr!\"*.git\"";
                exec($zipCmd, $output, $returnVarSistema);
            } else {
                // Tentar método alternativo com PowerShell (mais seguro)
                $zipCmd = "powershell -command \"Compress-Archive -Path '{$sourceDir}\\*' -DestinationPath '{$zipFile}' -Force\"";
                exec($zipCmd, $output, $returnVarSistema);
            }
            
            // Verificar resultados e criar mensagem de observação
            $observacoes = '';
            
            if ($returnVarBanco === 0 && $returnVarSistema === 0) {
                $observacoes = 'Backup completo realizado com sucesso (banco de dados e sistema).';
            } elseif ($returnVarBanco === 0) {
                $observacoes = 'Backup do banco realizado, mas falhou backup do sistema.';
            } elseif ($returnVarSistema === 0) {
                $observacoes = 'Backup do sistema realizado, mas falhou backup do banco.';
            } else {
                $observacoes = 'Falha ao realizar backup completo.';
                
                // Criar arquivo de texto com instruções
                $txtFile = str_replace('.zip', '.txt', $zipFile);
                $message = "Este é um arquivo de instruções para backup manual criado em " . now()->format('d/m/Y H:i:s') . ".\n\n";
                $message .= "O backup automático falhou. Por favor, faça o backup manualmente:\n\n";
                $message .= "== BACKUP DO BANCO ==\n";
                $message .= "Banco: {$database}\n";
                $message .= "Host: {$host}\n";
                $message .= "Usuário: {$username}\n\n";
                $message .= "== BACKUP DO SISTEMA ==\n";
                $message .= "1. Comprima a pasta: {$sourceDir}\n";
                $message .= "2. Exclua as pastas 'vendor' e 'node_modules' para reduzir o tamanho\n";
                
                file_put_contents($txtFile, $message);
                
                $backup->update([
                    'caminho' => str_replace('.zip', '.txt', $backup->caminho),
                    'status' => 'falhou',
                    'tamanho' => $this->formatarTamanho(filesize($txtFile)),
                    'data_execucao' => now(),
                    'ultimo_backup' => now(),
                    'observacoes' => $observacoes
                ]);
                
                return false;
            }
            
            // Definir tamanho baseado no que foi criado com sucesso
            $tamanho = 0;
            if ($returnVarBanco === 0) {
                $tamanho += filesize($sqlFile);
            }
            if ($returnVarSistema === 0) {
                $tamanho += filesize($zipFile);
            }
            
            $backup->update([
                'caminho' => $backup->caminho,
                'status' => 'concluido',
                'tamanho' => $this->formatarTamanho($tamanho),
                'data_execucao' => now(),
                'ultimo_backup' => now(),
                'observacoes' => $observacoes
            ]);
            
            return true;
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'falhou',
                'observacoes' => 'Falha no backup completo: ' . $e->getMessage(),
                'data_execucao' => now(),
            ]);
            
            \Log::error('Erro no backup completo: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Encontra o caminho para o mysqldump
     */
    private function encontrarMysqldump()
    {
        $potentialPaths = [
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\bin\\mysqldump.exe',
            // Caminhos adicionais específicos do Laragon
            'C:\\laragon\\bin\\mysql\\mariadb-10.11.2-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mariadb-10.4.10-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mariadb-10.5.8-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mariadb-10.6.7-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-5.7.33-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.33-winx64\\bin\\mysqldump.exe'
        ];
        
        // Tentar encontrar no diretório do Laragon
        $laragomBaseDir = 'C:\\laragon\\bin\\mysql';
        if (file_exists($laragomBaseDir) && is_dir($laragomBaseDir)) {
            $dirs = scandir($laragomBaseDir);
            foreach ($dirs as $dir) {
                if ($dir != '.' && $dir != '..' && is_dir($laragomBaseDir . '\\' . $dir)) {
                    $potentialPath = $laragomBaseDir . '\\' . $dir . '\\bin\\mysqldump.exe';
                    if (file_exists($potentialPath)) {
                        array_unshift($potentialPaths, $potentialPath);
                    }
                }
            }
        }
        
        foreach ($potentialPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return false;
    }

    /**
     * Encontra uma ferramenta de compressão disponível
     */
    private function encontrarZipTool()
    {
        $potentialPaths = [
            'C:\\Program Files\\7-Zip\\7z.exe',
            'C:\\Program Files (x86)\\7-Zip\\7z.exe'
        ];
        
        foreach ($potentialPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return false;
    }

    /**
     * Verifica se as dependências necessárias estão instaladas
     */
    private function verificarDependencias($backup)
    {
        $mensagens = [];
        $sourceDir = base_path();
        
        // Verificar mysqldump
        if (!$this->encontrarMysqldump()) {
            $mensagens[] = "- mysqldump não encontrado. Instale MySQL/MariaDB ou configure o caminho correto.";
        }
        
        // Verificar ferramenta de compressão
        if (!$this->encontrarZipTool() && !$this->verificarPowerShellZip()) {
            $mensagens[] = "- Ferramenta de compressão não encontrada. Instale 7-Zip ou verifique PowerShell.";
        }
        
        // Se houver mensagens, falhar com instruções
        if (!empty($mensagens)) {
            $txtFile = base_path('../backup_sgc/dependencias_faltantes.txt');
            $directory = dirname($txtFile);
            
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $message = "Dependências faltantes para o sistema de backup (gerado em " . now()->format('d/m/Y H:i:s') . "):\n\n";
            $message .= implode("\n", $mensagens) . "\n\n";
            $message .= "Instruções de Instalação:\n";
            $message .= "1. Para MySQL/MariaDB: Baixe e instale do site oficial ou use o instalador do Laragon\n";
            $message .= "2. Para 7-Zip: Baixe e instale de https://www.7-zip.org/\n";
            
            file_put_contents($txtFile, $message);
            
            throw new \Exception("Dependências faltantes para backup. Verifique o arquivo de instruções.");
        }
        
        return true;
    }

    /**
     * Verifica se o PowerShell pode comprimir arquivos
     */
    private function verificarPowerShellZip()
    {
        $testCmd = "powershell -command \"Get-Command Compress-Archive -ErrorAction SilentlyContinue\"";
        exec($testCmd, $output, $returnVar);
        
        return $returnVar === 0 && !empty($output);
    }

    private function formatarTamanho($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
