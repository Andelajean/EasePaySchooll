<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;
    protected $fillable = [
       'nom_ecole', 'email', 'identifiant','ville','niveau',
        'telephone', 'nom_banque1', 'numero_banque1', 'nom_banque2',
        'numero_banque2', 'nom_banque3', 'numero_banque3', 'nom_banque4',
        'numero_banque4', 'nom_banque5', 'numero_banque5', 'nom_banque6','numero_banque6',
         'nom_banque7', 'numero_banque7', 'nom_banque8','numero_banque8',
    ];

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
    public function classes()
{
    return $this->hasMany(Classe::class, 'id_ecole', 'id');
}
}
