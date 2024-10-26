<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;

class MaterielController extends Controller
{
    public function reception(Request $request) {
        // Vérifier si l'école est bien présente dans la session
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }
    
        // Récupérer toutes les classes distinctes associées à cette école
        $classes = DB::table('paiements')
            ->select('classe')
            ->where('nom_ecole', $ecole->nom_ecole)
            ->distinct()
            ->get()
            ->pluck('classe');
    
        // Si c'est une requête AJAX pour la recherche d'élèves
        if ($request->ajax()) {
            $nom_complet = $request->get('nom_complet');
            $classe = $request->get('classe');
    
            // Requête pour chercher les élèves correspondant
            $eleves = DB::table('paiements')
                ->where('nom_ecole', $ecole->nom_ecole)
                ->where('nom_complet', 'like', '%' . $nom_complet . '%')
                ->where('classe', $classe)
                ->get();
    
            // Retourner les résultats sous forme JSON
            return response()->json($eleves);
        }
    
        // Sinon, retourner la vue avec les classes
        return view('Materiel.reception', compact('classes'));
    }
    

    public function recus(Request $request)
    {
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }
    
        // Récupérer toutes les classes distinctes associées à cette école
        $classes = DB::table('materiels')
            ->where('nom_ecole', $ecole->nom_ecole)
            ->distinct()
            ->pluck('classe');
    
        // Vérifier si une classe a été sélectionnée
        $classeSelectionnee = $request->input('classe');
       // dd($classeSelectionnee);  // Cette ligne affiche la classe sélectionnée et arrête l'exécution
    
        $materiels = collect();
    
        if ($classeSelectionnee) {
            $materiels = DB::table('materiels')
                ->where('nom_ecole', $ecole->nom_ecole)
                ->where('classe', $classeSelectionnee)
                ->get();
        }
    
        return view('Materiel.recu', compact('classes', 'materiels', 'classeSelectionnee'));
    }
    

    
    public function receptionMateriel(Request $request) {
        // Valider les données envoyées
        $request->validate([
            'eleve_id' => 'required|exists:paiements,id_paiement', // L'ID de l'élève doit exister dans la table "eleves"
            'materiel' => 'required', // Soit 'ok' soit 'non_ok'
            'reste' => 'nullable|string', // Le reste est optionnel, et n'est rempli que si materiel est 'non_ok'
        ]);
    
        // Récupérer les informations de l'élève avec l'ID
        $eleve = DB::table('paiements')->where('id_paiement', $request->eleve_id)->first();


     $materiel = Materiel::where('nom_eleve', $eleve->nom_complet)
        ->where('classe', $eleve->classe)
        ->where('paiement',$eleve->id_paiement)
        ->first();

    if ($materiel) {
        // Vérifier si le matériel est OK
        if ($materiel->materiel === 'non_ok') {
            session()->flash('materiel', $materiel);
            return redirect()->route('update', ['id' => $materiel->id]);
        }
         else {
            return redirect()->back()->with('success', 'l\'élève a déja déposé tout son materiel');
        }
    } else{
       // Insérer les données dans la table "materiel"
       Materiel::create([
        'nom_eleve' => $eleve->nom_complet,
        'nom_ecole' => $eleve->nom_ecole,
        'classe' => $eleve->classe,
        'materiel' => $request->materiel,
        'reste' => $request->materiel === 'non_ok' ? $request->reste : 'rien', // Si "NON OK", on enregistre les détails restants
        'paiement' => $eleve->id_paiement,
    ]);

    return redirect()->back()->with('success', 'Réception du matériel enregistrée avec succès.');
    }
       
    }
    public function updateMateriel(Request $request, $id) {
        // Récupérer le matériel
        $materiel = Materiel::find($id);
    
        // Validation des nouvelles données
        $request->validate([
            'materiel' => 'required|string',
            'reste' => 'nullable|string', // Champ optionnel pour le matériel manquant
        ]);
    
        // Mettre à jour le matériel
        $materiel->materiel = $request->materiel;
        $materiel->reste = $request->materiel === 'non_ok' ? $request->reste : 'rien'; // Si 'non_ok', mettre à jour le reste
        $materiel->save();
    
        return redirect()->route('reception', ['id' => $materiel->id])
                         ->with('success', 'Matériel mis à jour avec succès.');
    }
    public function update_mat(){
        return view('Materiel.update');
    }
}
