<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementSaintJean extends Model
{
    use HasFactory;

    // Nom de la table associée
    protected $table = 'paiement_saintjean';

    // Les champs remplissables
    protected $fillable = [
        'filiere_concours',
        'nom_concourant',
        'id_paiement',
        'photo_concourant',
        'somme_deboursee',
        'numero_telephone',
        'date_paiement',
        'heure_paiement',
        'qr_code_path',
    ];

    /**
     * Indique si les timestamps (created_at, updated_at) doivent être gérés par Laravel.
     *
     * @var bool
     */
    public $timestamps = true;
}
