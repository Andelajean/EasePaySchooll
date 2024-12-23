<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Paiement;
use App\Models\Polo;
use Illuminate\Support\Facades\DB;
class DistributionController extends Controller
{
    public function polo(Request $request){
        try{
        // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

// Récupérer toutes les classes distinctes (banques) associées à cette école
$classes = DB::table('paiements')
->select('classe')
->where('nom_ecole', $ecole->nom_ecole)
->distinct()
->get()
->pluck('classe');
$classeSelectionnee = $request->query('classe', $classes->first());
$etudiantsAvecPolo = DB::table('polos')->pluck('nom_etudiant');
$paiement = DB::table('paiements')
->where('nom_ecole', $ecole->nom_ecole)
->where('classe',$classeSelectionnee)
->whereNotIn('nom_complet', $etudiantsAvecPolo)
->paginate(50); 
return view('Distribution.distribuer_polo', compact('classes','paiement'));}
catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
    }
    public function badge(Request $request){
        try{
     // Vérifier si l'école est bien présente dans la session
     $ecole = Session::get('ecole');
     if (!$ecole) {
         return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
     }
 
 // Récupérer toutes les classes distinctes (banques) associées à cette école
 $classes = DB::table('paiements')
 ->select('classe')
 ->where('nom_ecole', $ecole->nom_ecole)
 ->distinct()
 ->get()
 ->pluck('classe');
 $classeSelectionnee = $request->query('classe', $classes->first());
 $etudiantsAvecPolo = DB::table('badges')->pluck('nom_etudiant');
 $paiement = DB::table('paiements')
 ->where('nom_ecole', $ecole->nom_ecole)
 ->where('classe',$classeSelectionnee)
 ->whereNotIn('nom_complet', $etudiantsAvecPolo)
 ->paginate(50); 
 return view('Distribution.distribuer_badge', compact('classes','paiement'));}
 catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}

    }
    public function polo_recu(Request $request){
        try{
        // Vérifier si l'école est bien présente dans la session
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }
    
    // Récupérer toutes les classes distinctes (banques) associées à cette école
    $classes = DB::table('polos')
    ->select('classe')
    ->where('nom_ecole', $ecole->nom_ecole)
    ->distinct()
    ->get()
    ->pluck('classe');
    $classeSelectionnee = $request->query('classe', $classes->first());
    $paiement = DB::table('polos')
    ->where('nom_ecole', $ecole->nom_ecole)
    ->where('classe',$classeSelectionnee)
    ->paginate(50); 
    return view('Distribution.polo', compact('classes','paiement'));}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
   
       }
    public function badge_recu(Request $request){
        try{
        // Vérifier si l'école est bien présente dans la session
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }
    
    // Récupérer toutes les classes distinctes (banques) associées à cette école
    $classes = DB::table('badges')
    ->select('classe')
    ->where('nom_ecole', $ecole->nom_ecole)
    ->distinct()
    ->get()
    ->pluck('classe');
    $classeSelectionnee = $request->query('classe', $classes->first());
    $paiement = DB::table('badges')
    ->where('nom_ecole', $ecole->nom_ecole)
    ->where('classe',$classeSelectionnee)
    ->paginate(50); 
    return view('Distribution.badge', compact('classes','paiement'));}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
   
       }
    public function distribuer_polo($id_paiement)
    
{
    try{
    // Récupérer les informations du paiement par son id
    $paiement = DB::table('paiements')->where('id_paiement', $id_paiement)->first();

    if (!$paiement) {
        return redirect()->back()->with('error', 'Paiement introuvable.');
    }

    // Enregistrer les informations dans la table polos
    Polo::create([
       'id_paiement' => $paiement->id_paiement,
        'nom_etudiant' => $paiement->nom_complet,
        'classe' => $paiement->classe,
        'banque' => $paiement->banque,
        'filiere' => $paiement->filiere,
        'nom_ecole' => $paiement->nom_ecole,
        'niveau_université' => $paiement->niveau_universite,
    ]);

    return redirect()->back()->with('success', 'Polo distribué avec succès.');}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}
public function distribuer_badge($id_paiement)
{
    try{
    // Récupérer les informations du paiement par son id
    $paiement = DB::table('paiements')->where('id_paiement', $id_paiement)->first();
    // Enregistrer les informations dans la table polos
    Badge::create([
        'id_paiement' => $paiement->id_paiement,
        'nom_etudiant' => $paiement->nom_complet,
        'classe' => $paiement->classe,
        'banque' => $paiement->banque,
        'filiere' => $paiement->filiere,
         'nom_ecole' => $paiement->nom_ecole,
        'niveau_université' => $paiement->niveau_universite,
    ]);

    return redirect()->back()->with('success', 'badge distribué avec succès.');}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}
public function search_polo(Request $request)
{
    try{
     // Vérifier si l'école est bien présente dans la session
     $ecole = Session::get('ecole');
     if (!$ecole) {
         return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
     }
    // Récupération du paramètre de recherche
    $query = $request->input('query');

    // Recherche des élèves dont le nom contient le texte recherché
    $students = Polo::  where('nom_ecole', $ecole->nom_ecole)
                      -> where('nom_etudiant', 'LIKE', '%' . $query . '%')->get(['id', 'nom_etudiant']);

    // Retour des résultats sous forme de JSON
    return response()->json($students);
    }
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}

// Méthode pour récupérer les détails d'un élève spécifique
public function show_polo($id)
{  try{
    // Recherche de l'élève par ID
    $student = Polo::find($id);

    // Vérification si l'élève existe
    if (!$student) {
        return response()->json(['error' => 'Élève non trouvé'], 404);
    }

    // Retour des détails de l'élève sous forme de JSON
    return response()->json($student);
}catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}
public function search_badge(Request $request)
{
try{
     // Vérifier si l'école est bien présente dans la session
     $ecole = Session::get('ecole');
     if (!$ecole) {
         return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
     }
    // Récupération du paramètre de recherche
    $query = $request->input('query');

    // Recherche des élèves dont le nom contient le texte recherché
    $students = Badge::  where('nom_ecole', $ecole->nom_ecole)
                      -> where('nom_etudiant', 'LIKE', '%' . $query . '%')->get(['id', 'nom_etudiant']);

    // Retour des résultats sous forme de JSON
    return response()->json($students);}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}

// Méthode pour récupérer les détails d'un élève spécifique
public function show_badge($id)
{
    try{
    // Recherche de l'élève par ID
    $student =Badge::find($id);

    // Vérification si l'élève existe
    if (!$student) {
        return response()->json(['error' => 'Élève non trouvé'], 404);
    }

    // Retour des détails de l'élève sous forme de JSON
    return response()->json($student);
}
catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}
