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
<<<<<<< HEAD
       $paiements=Paiement::where('id_ecole',$id)->get();
=======
       $paiements=Paiement::where('ecole_id',$id)->get();
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
       $id_ecole=$id;
       $ecoles=Ecole::all();
       $banques=Banque::all();
       return view('admin.paiement.showAllParEcole', compact('paiements','ecoles','id','banques'));

    }
}
