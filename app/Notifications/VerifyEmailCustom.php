<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailCustom extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Validez votre compte sur ' . config('app.name'))
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Merci pour votre inscription sur ' . config('app.name') . '.')
            ->line('Pour finaliser votre création de compte, veuillez valider votre adresse e-mail.')
            ->action('Valider mon compte', $verificationUrl)
            ->line('Si vous n’avez pas créé ce compte, vous pouvez ignorer cet e-mail.')
            ->salutation('Cordialement, l’équipe ' . config('app.name'));
    }
}
