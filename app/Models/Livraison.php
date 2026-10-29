<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livraison extends Model
{
    protected $fillable = [
        'commande_id',
        'nom_livreur',
        'telephone_livreur',
        'adresse',
        'statut',
        'date_expedition',
        'date_livraison',
        'commentaire',
    ];

    protected $casts = [
        'date_expedition' => 'datetime',
        'date_livraison' => 'datetime',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
