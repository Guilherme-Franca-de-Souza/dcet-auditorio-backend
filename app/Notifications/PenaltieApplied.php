<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenaltieApplied extends Notification
{
    use Queueable;

    private $info;

    /**
     * Create a new notification instance.
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Penalização Aplicada')
            ->greeting('Olá, ' . $notifiable->name)
            ->line('Você recebeu uma penalização no sistema.')
            ->line('Data da penalização: ' . $this->info['data'])
            ->line('Por favor, entre em contato com a administração para mais detalhes.')
            ->salutation('Atenciosamente, Sistema de Reservas DCET');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
