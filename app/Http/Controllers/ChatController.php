<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('assistant.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $message = strtolower(trim($validated['message']));
        $answer = $this->getBotReply($message);

        return response()->json([
            'answer' => $answer,
        ]);
    }

    protected function getBotReply(string $message): string
    {
        $faq = [
            'livraison' => 'La livraison est calculée selon votre zone et la commande est suivie depuis votre espace commandes.',
            'retour' => 'Les retours sont possibles dans les 7 jours suivant la réception, sous réserve des conditions de retour.',
            'paiement' => 'Nous acceptons le paiement à la livraison, le Mobile Money et la carte bancaire via un canal sécurisé.',
            'commande' => 'Pour suivre une commande, consultez la page de détails de votre commande ou votre historique.',
            'stock' => 'Le stock est vérifié à chaque ajout au panier et la commande ne peut pas dépasser le stock disponible.',
            'horaire' => 'Notre service client est disponible du lundi au samedi de 8h à 18h.',
            'contact' => 'Pour une demande manuelle, veuillez nous adresser votre demande via le formulaire de contact et un gestionnaire vous répondra.',
        ];

        foreach ($faq as $keyword => $reply) {
            if (str_contains($message, $keyword)) {
                return $reply;
            }
        }

        return 'Je peux vous aider sur la livraison, les paiements, les commandes et les produits. Si vous avez une demande spécifique, votre message sera transmis à un gestionnaire.';
    }
}
