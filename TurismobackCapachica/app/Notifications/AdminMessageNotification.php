<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminMessageNotification extends Notification
{
    use Queueable;
    protected $mensaje;
    public function __construct($mensaje) {
        $this->mensaje = $mensaje;
    }
    public function via($notifiable) {
        return ['mail'];
    }
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Mensaje de la administración')
            ->line($this->mensaje);
    }
} 