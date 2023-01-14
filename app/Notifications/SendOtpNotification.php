<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    
    public function __construct($otp)
    {
        $this->otp=$otp;
    }

    
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Hello.')
                    ->line('This is your verification code : ' . $this->otp );
    }

  
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
