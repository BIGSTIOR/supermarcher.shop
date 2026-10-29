<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BienvenueClient extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
        //
    }

    public function build(): self
    {
        return $this->subject('Bienvenue chez ' . config('app.name'))
            ->markdown('emails.bienvenue', [
                'user' => $this->user,
            ]);
    }
}
