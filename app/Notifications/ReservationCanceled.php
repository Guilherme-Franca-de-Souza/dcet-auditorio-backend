<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationCanceled extends Notification
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
            ->subject('Reserva Cancelada')
            ->greeting('Olá, ' . $notifiable->name)
            ->line('Informamos que sua reserva foi cancelada.')
            ->line('Detalhes da reserva cancelada:')
            ->line('Auditório: ' . $this->info['auditorio'])
            ->line('Data: ' . $this->info['data'])
            ->line('Horário: ' . $this->info['horario'])
            ->line('Se você acredita que isso foi um engano, entre em contato com a administração.')
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
