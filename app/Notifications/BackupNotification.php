<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Events\CleanupHasFailed;
use Spatie\Backup\Events\CleanupWasSuccessful;
use Spatie\Backup\Events\HealthyBackupWasFound;
use Spatie\Backup\Events\UnhealthyBackupWasFound;

class BackupNotification extends Notification
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($this->getSubject())
            ->line($this->getMessage());

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage(),
            'subject' => $this->getSubject(),
            'type' => $this->getType(),
        ];
    }

    protected function getMessage(): string
    {
        if ($this->event instanceof BackupWasSuccessful) {
            return 'O backup foi concluído com sucesso!';
        }

        if ($this->event instanceof BackupHasFailed) {
            return 'O backup falhou. Erro: ' . $this->event->exception->getMessage();
        }

        if ($this->event instanceof CleanupWasSuccessful) {
            return 'A limpeza dos backups antigos foi concluída com sucesso!';
        }

        if ($this->event instanceof CleanupHasFailed) {
            return 'A limpeza dos backups antigos falhou. Erro: ' . $this->event->exception->getMessage();
        }

        if ($this->event instanceof HealthyBackupWasFound) {
            return 'Os backups estão saudáveis!';
        }

        if ($this->event instanceof UnhealthyBackupWasFound) {
            return 'Os backups estão com problemas. Verifique o sistema.';
        }

        return 'Evento de backup não reconhecido.';
    }

    protected function getSubject(): string
    {
        if ($this->event instanceof BackupWasSuccessful) {
            return 'Backup Concluído com Sucesso';
        }

        if ($this->event instanceof BackupHasFailed) {
            return 'Falha no Backup';
        }

        if ($this->event instanceof CleanupWasSuccessful) {
            return 'Limpeza de Backups Concluída';
        }

        if ($this->event instanceof CleanupHasFailed) {
            return 'Falha na Limpeza de Backups';
        }

        if ($this->event instanceof HealthyBackupWasFound) {
            return 'Backups Saudáveis';
        }

        if ($this->event instanceof UnhealthyBackupWasFound) {
            return 'Problemas nos Backups';
        }

        return 'Notificação de Backup';
    }

    protected function getType(): string
    {
        if ($this->event instanceof BackupWasSuccessful ||
            $this->event instanceof CleanupWasSuccessful ||
            $this->event instanceof HealthyBackupWasFound) {
            return 'success';
        }

        return 'danger';
    }
}
