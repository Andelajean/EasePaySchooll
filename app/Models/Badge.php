<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_etudiant',
        'classe',
        'banque',
        'id_paiement',
        'filiere',
        'nom_ecole',
        'niveau_université',
    ];
}
