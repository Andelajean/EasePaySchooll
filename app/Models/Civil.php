<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Civil extends Model
{
   use HasFactory;
   protected $table = 'civils';

   protected $fillable = [
       'nom',
       'prenom',
       'sexe',
       'date_naissance',
       'lieu_naissance',
       'nationalite',
       'region_origine',
       'adresse',
       'telephone',
       'email',
       'lycee',
       'titulaire_bac',
       'diplome_bac_path',
       'bulletin_seconde_path',
       'bulletin_premiere_path',
       'bulletin_terminale_path',
       'diplome_probatoire_path',
       'piece_identite_recto_path',
       'piece_identite_verso_path',
       'certificat_scolarite_path',
       'fiche_inscription_path',
       'photo_path',
       'exam_room', 
       'exam_seat'
   ];

   protected $casts = [
       'date_naissance' => 'date',
       'titulaire_bac' => 'boolean'
   ];
}
