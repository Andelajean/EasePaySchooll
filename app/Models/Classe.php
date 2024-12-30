<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    // Nom de la table
    protected $table = 'classes';

    // Champs autorisés pour insertion ou mise à jour
    protected $fillable = [
        'id_ecole',
        'nom_classe',
        'premiere_tranche',
        'deuxieme_tranche',
        'troisieme_tranche',
        'quatrieme_tranche',
        'cinquieme_tranche',
        'sixieme_tranche',
        'septieme_tranche',
        'huitieme_tranche',
        'totalite',
        
    ];

    // Définir une relation avec la table 'ecoles'
    public function ecole()
    {
        return $this->belongsTo(Ecole::class, 'id_ecole', 'id');
    }
}
