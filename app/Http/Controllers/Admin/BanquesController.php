<?php

namespace App\Http\Controllers\Admin;
use App\Models\Banque;
use App\Models\Ecole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class BanquesController extends Controller
{
    //

     //la fonction qui permet de retourner le data du filiere u 
     public function addBank()
     {    
         $nom=Banque::select('id','nom')->get();
         $ecoles=Ecole::all();
         return view('Admin.banque.addBank',compact('nom','ecoles'));
       
     }
    // la fonction qui permet d'afficher les information  des Banques 
     public function showAllBank()
     {
         $banks=Banque::all();
         $ecoles=Ecole::all();
          //return $matieres;
         return view('Admin.banque.showAll',compact('banks','ecoles'));
     }
     //la fonction qui permet d'ajouter et enregistrer les Banque 
     public function saveBank(Request $request){
     
         // les données nesessaires dans l'ajoute 
         $request->validate([
                    'nom'=>'required',
                    'prenom'=>'required',
                    'email'=>'required',
                    'bank'=>'required',
                    'telephone'=>'required',
                    'pwd'=>'required',
                    'role'=>'required',
             ]);         
         // enregistrer les données dans la base de données 
     
            
             try{
                
                 $banque = new Banque;
                 $nom= $request->input("nom");
                 $prenom=$request->input("prenom");
                 $email= $request->input('email');
                 $bank=$request->input("bank");
                 $telephone=$request->input("telephone");
                 $pwd =  Hash::make($request->input('pwd'));
                 $role="user";

                 
                 $banque->nom  = $nom;
                 $banque->prenom = $prenom;
                 $banque->email = $email;
                 $banque->bank=$bank;
                 $banque->telephone=$telephone;
                 $banque->pwd =bcrypt($pwd);
                 $banque->role =$role;

                 $banque->save();
                 $id_bank = $banque->id;
             Banque::create(
                 [
                    'nom'=>$request->nom,
                    'prenom'=>$request->prenom,
                    'email'=>$request->email,
                    'bank'=>$request->bank,
                    'telephone'=>$request->telephone,
                    'pwd'=>$request->pwd,
                    'role'=>$request->role,
                     
                 ]
                 );
                 //afficher un message de success si  les données des Banques sont bein enregistrées 
                 return redirect()->route('show.all.Bank')->with(['success' => ' Banque est Bien ajouté ']);
                 
             } catch (\Exception $ex) {
                 //afficher un message d'erreur  si  les données des Banques ne sont pas bein enregistrées 
               return $ex;
                 return redirect()->route('add.Bank')->with(['error' => 'Erreur!!! ']);
         }
     }
    //la fonction utilises dans la modification des données des étudiants 
     public function editBank($id)
     {
         $Banques=Banque::find($id);
         if(!$Banques)
            redirect() -> route('show.all.Bank') -> with(['Erreur' => "Banque n'existe pas !!!"]);
          
            $banques=Banque::find($id); //select('id')->get();
            $ecoles=Ecole::all();
         return view('Admin.banque.update',compact('banques','id','ecoles'));
     }
 
     //la fonction permet de modifier les données des étudiants
     public function updateBank(Request $request)
     {
         
         $request->validate([
                    'nom'=>'required',
                    'prenom'=>'required',
                    'email'=>'required',
                    'bank'=>'required',
                    'telephone'=>'required',
                    'pwd'=>'required',
                   'role'=>'required',
             ]);  
             $role="user";       
         try {
             Banque::where('id',$request ->id) -> update(
                 [ 
                    'nom'=>$request->nom,
                    'prenom'=>$request->prenom,
                    'email'=>$request->email,
                    'bank'=>$request->bank,
                    'telephone'=>$request->telephone,
                    'pwd'=>bcrypt($request->pwd),
                    'role'=>$role,
                    
                 ]);
                 // un message de success afficher si les données sont bein modifiées 
                 return redirect()->route('show.all.bank')->with(['update' => ' Banque est Bien modifié ']);
                 
             } catch (\Exception $ex) {
                 //  // un message d'erreur  s'il y a pas de modification 
                 return redirect()->route('add.bank')->with(['error' => 'There is somthing went wrong ']);
         }
       
     }
   // la fonction qui permet de supprimer un étudiant 
     public function deleteBank($id)
     {
         $Bank=Banque::find($id);
         if(!$Bank)
            redirect() -> route('show.all.bank') -> with(['error' => 'Bank Does not exist']);
 
            Banque::where('id',$id) -> delete();
            return redirect()->route('show.all.bank')->with(['delete' => 'Banque est supprime avec succes']); 
     }
 
}
