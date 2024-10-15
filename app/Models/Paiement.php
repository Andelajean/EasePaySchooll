<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paiement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_ecole',
        'telephone',
        'ville',
        'banque',
        'nom_complet',
        'classe',
        'niveau',
        'filiere',
        'niveau_universite',
        'montant',
        'details',
        'qr_code',
    ];

    public static function generateIdPaiement()
    {
        return Str::upper(Str::random(11)); // Génère une chaîne aléatoire de 11 caractères alphanumériques
    }
}