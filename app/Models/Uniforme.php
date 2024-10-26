<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniforme extends Model
{
    use HasFactory;
    protected $fillable = ['nom_eleve', 'classe', 'uniforme', 'reste','paiement','nom_ecole'];
}
