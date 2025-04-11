<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Notifications\BackupNotification;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Events\CleanupHasFailed;
use Spatie\Backup\Events\CleanupWasSuccessful;
use Spatie\Backup\Events\HealthyBackupWasFound;
use Spatie\Backup\Events\UnhealthyBackupWasFound;

class BackupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(BackupWasSuccessful::class, function (BackupWasSuccessful $event) {
            $this->processBackupEvent($event);
        });

        Event::listen(BackupHasFailed::class, function (BackupHasFailed $event) {
            $this->processBackupEvent($event);
        });

        Event::listen(CleanupWasSuccessful::class, function (CleanupWasSuccessful $event) {
            $this->processBackupEvent($event);
        });

        Event::listen(CleanupHasFailed::class, function (CleanupHasFailed $event) {
            $this->processBackupEvent($event);
        });

        Event::listen(HealthyBackupWasFound::class, function (HealthyBackupWasFound $event) {
            $this->processBackupEvent($event);
        });

        Event::listen(UnhealthyBackupWasFound::class, function (UnhealthyBackupWasFound $event) {
            $this->processBackupEvent($event);
        });
    }

    protected function processBackupEvent($event)
    {
        // Aqui você pode criar logs, registrar eventos no banco ou enviar notificações
        // Por exemplo, gravar no log do Laravel:
        \Log::info('Evento de backup: ' . get_class($event));
        
        // Ou você pode adicionar registros no banco de dados
        \App\Models\Backup::where('status', 'pendente')
            ->whereNull('data_execucao')
            ->update([
                'status' => ($event instanceof BackupHasFailed || $event instanceof CleanupHasFailed) 
                    ? 'falhou' 
                    : 'concluido',
                'data_execucao' => now(),
                'observacoes' => ($event instanceof BackupHasFailed || $event instanceof CleanupHasFailed)
                    ? 'Erro no backup: ' . ($event->exception->getMessage() ?? 'Erro desconhecido')
                    : 'Backup concluído com sucesso',
            ]);
    }
}
