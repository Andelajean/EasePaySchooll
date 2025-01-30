<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenailiteEcole extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecole_id',
        'classe',
        'date_debut',
        'tranche',
        'frequence',
        'montant',
        
    ];
    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }
}

