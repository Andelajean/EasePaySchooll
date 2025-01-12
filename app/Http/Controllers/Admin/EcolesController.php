<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Banque;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
class EcolesController extends Controller
{
    //
    public function addEcole()
    {
        $ecoles=Ecole::all();
        return view('Admin.ecole.addEcole',compact('ecoles'));
    }
    public function showAllEcole()
    {
        $Ecole = Ecole::all();
        $ecoles=Ecole::all();
        return view('Admin.ecole.showAll',compact('Ecole','ecoles'));
    }

    public function showAllPaiement()
    {
        $ecoles = Ecole::all();
        $paiements=Paiement::all();
        return view('Admin.paiement.showAllPaiement',compact('paiements','ecoles'));
    }

    public function save(Request $request)
    {
        $identifier = Str::random(11);

        //return $request;
        $user = new User;
        $email= $request->input('email');
        $password =  Hash::make($request->input('password'));
        //$name= strstr($email,'@',true);
        $user->role = 2;
        $user->name = $name;
        $user->email = $email;
        $user->password =$password;

        $user->save();
        $iduser = $user->id;

        $Ecole = new Ecole;
        $nom_ecole = $request->input('nom_ecole');
        $email = $request->input('email');
        $nom_banque1 = $request->input('nom_banque1');
        $numero_banque1 = $request->input('numero_banque1');
        $nom_banque2 = $request->input('nom_banque2');
        $numero_banque2 = $request->input('numero_banque2');
        $nom_banque3 = $request->input('nom_banque3');
        $numero_banque3 = $request->input('numero_banque3');
        $nom_banque4 = $request->input('nom_banque4');
        $numero_banque4 = $request->input('numero_banque4');
        $nom_banque5 = $request->input('nom_banque5'); 
        $numero_banque5 = $request->input('numero_banque5');
        $nom_banque6 = $request->input('nom_banque6');
        $numero_banque6 = $request->input('numero_banque6');
        $nom_banque7 = $request->input('nom_banque7');
        $numero_banque7 = $request->input('numero_banque7');
        $nom_banque8 = $request->input('nom_banque8');
        $numero_banque8 = $request->input('numero_banque8');
        $ville = $request->input('ville');
        $phone = $request->input('tel');

        $Ecole->nom_ecole = $nom_ecole;
        $Ecole->identifiant = $identifier;
        $Ecole->email = $email;
        $Ecole->nom_banque1 = $nom_banque1;
        $Ecole->nom_banque2 = $nom_banque2;
        $Ecole->nom_banque3 = $nom_banque3;
        $Ecole->nom_banque4 = $nom_banque4;
        $Ecole->nom_banque5 = $nom_banque5;
        $Ecole->nom_banque6 = $nom_banque6;
        $Ecole->nom_banque7 = $nom_banque7;
        $Ecole->nom_banque8 = $nom_banque8;
        $Ecole->numero_banque1=$numero_banque1;
        $Ecole->numero_banque2=$numero_banque2;
        $Ecole->numero_banque3=$numero_banque3;
        $Ecole->numero_banque4=$numero_banque4;
        $Ecole->numero_banque5=$numero_banque5;
        $Ecole->numero_banque6=$numero_banque6;
        $Ecole->numero_banque7=$numero_banque7;
        $Ecole->numero_banque8=$numero_banque8;
        $Ecole->telephone = $phone;
        $Ecole->ville=$ville;

        $Ecole->save();
       
        return redirect()->route('show.all.Ecole')->with(['ajoute' => ' Ecole est Bien Ajoute ']);

    }

    public function editEcole($id)
    {
        $ecoles =Ecole::find($id);
        $banques=Banque::all();
        if(!$ecoles)
           redirect() -> route('show.all.Ecole') -> with(['Erreur' => "Ecole n'existe pas !!!"]);
         
        return view('Admin.ecole.update',compact('ecoles','banques','id'));
    }

    public function updateEcole(Request $request)
    {
       
          
        try {
            Ecole::where('id',$request ->id) -> update(
                    [
                        'email' => $request->email,
                        'nom_banque1' => $request->nom_banque1,
                        'nom_banque2' => $request->nom_banque2,
                        'nom_banque3' => $request->nom_banque3,
                        'nom_banque4' => $request->nom_banque4,
                        'nom_banque5' => $request->nom_banque5,
                        'nom_banque6' => $request->nom_banque6,
                        'numero_banque1' => $request->numero_banque1,
                        'numero_banque2' => $request->numero_banque2,
                        'numero_banque3' => $request->numero_banque3,
                        'numero_banque4' => $request->numero_banque4,
                        'numero_banque5' => $request->numero_banque5,
                        'numero_banque6' => $request->numero_banque6,
                        'telephone' => $request->tel,
                        'nom_ecole' => $request->nom_ecole,
                        'ville' => $request->ville,
                        
                    ]);
                    // un message de success afficher si les données sont bein modifiées 
                    return redirect()->route('show.all.Ecole')->with(['success' => ' Ecole est Bien modifié ']);
                    
            } catch (Exception $ex) {
                //  // un message d'erreur  s'il y a pas de modification 
                return redirect()->route('update.ecole')->with(['error' => 'There is something went wrong ']);
            }
    }

   
    public function deleteEcole($id)
    {
        $Ecole = Ecole::find($id);
        if(!$Ecole)
        redirect() -> route('show.all.Ecole') -> with(['error' => 'Ecole no existe']);

        Ecole::where('id',$id) -> delete();
        return redirect()->route('show.all.Ecole')->with(['delete' => 'Ecole supprime avec succes']); 
    }

  


}
