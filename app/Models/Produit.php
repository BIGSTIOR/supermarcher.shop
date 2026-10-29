<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'nom',
        'description',
        'prix',
        'stock',
        'unite',
        'image',
        'actif',
        'nombre_recherches',
    ];

    protected function casts(): array
    {
        return [
            'prix' => 'decimal:2',
            'actif' => 'boolean',
            'stock' => 'integer',
            'nombre_recherches' => 'integer',
        ];
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function paniers(): HasMany
    {
        return $this->hasMany(Panier::class);
    }

    public function detailsCommandes(): HasMany
    {
        return $this->hasMany(DetailCommande::class);
    }
}
