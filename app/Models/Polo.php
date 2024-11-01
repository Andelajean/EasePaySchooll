<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_etudiant',
        'classe',
        'nom_ecole',
        'banque',
        'id_paiement',
        'filiere',
        'niveau_université',
    ];
}
