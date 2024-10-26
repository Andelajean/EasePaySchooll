<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_ecole', 'email', 'identifiant','niveau',
        'telephone', 'nom_banque1', 'numero_compte1', 'nom_banque2',
        'numero_compte2', 'nom_banque3', 'numero_compte3', 'nom_banque4',
        'numero_compte4', 'nom_banque5', 'numero_compte5', 'nom_banque6','numero_compte6',
         'nom_banque7', 'numero_compte7', 'nom_banque8','numero_compte8',
    ];
}
