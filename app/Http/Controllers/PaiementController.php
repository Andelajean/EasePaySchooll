<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaiementController extends Controller
{
   public function formulaire_paiement(){
    return view('Paiement.paiement');
   }
}
