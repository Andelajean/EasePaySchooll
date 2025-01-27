<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penalite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_classe',
        'date_debut',
        'frequence',
        'montant',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'id_classe');
    }
}
