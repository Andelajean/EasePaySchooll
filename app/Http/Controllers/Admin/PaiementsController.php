<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Ecole;
use App\Models\Banque;

class PaiementsController extends Controller
{
    //

    public function showAllPaiement($id){
       $paiements=Paiement::where('ecole_id',$id)->get();
       $id_ecole=$id;
       $ecoles=Ecole::all();
       $banques=Banque::all();
       return view('admin.paiement.showAllParEcole', compact('paiements','ecoles','id','banques'));

    }
}
