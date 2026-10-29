<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class CommandeConfirmee extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Commande $commande)
    {
        //
    }

    public function build()
    {
        return $this->subject('Confirmation de votre commande - ' . $this->commande->numero_commande)
                    ->markdown('emails.commandes.confirmation', [
                        'commande' => $this->commande,
                    ]);
    }
}
