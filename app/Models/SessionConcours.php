<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SessionConcours extends Model
{
    use HasFactory;

    protected $table = 'sessions_concours'; // Nom de table spécifié comme demandé
    
    protected $fillable = [
        'nom_session',
        'nom_filiere',
        'date_debut',
        'date_concours',
        'date_fin',
        'statut'
    ];

    protected $dates = [
        'date_debut',
        'date_concours',
        'date_fin',
        'created_at',
        'updated_at'
    ];

    /**
     * Vérifie les conflits de dates pour une filière donnée
     */
    public static function hasConflict(string $filiere, string $dateDebut, string $dateFin): bool
    {
        return self::where('nom_filiere', $filiere)
            ->where(function($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('date_debut', [$dateDebut, $dateFin])
                      ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                      ->orWhere(function($q) use ($dateDebut, $dateFin) {
                          $q->where('date_debut', '<', $dateDebut)
                            ->where('date_fin', '>', $dateFin);
                      });
            })
            ->exists();
    }
}