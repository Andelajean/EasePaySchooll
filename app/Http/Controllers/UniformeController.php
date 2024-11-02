<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Paiement;
use App\Models\Uniforme;
use Illuminate\Support\Facades\DB;

class UniformeController extends Controller
{
    public function distribution(Request $request) {
        // Vérifier si l'école est bien présente dans la session
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }
    
        // Récupérer toutes les classes distinctes associées à cette école
        $classes = DB::table('materiels')
            ->select('classe')
            ->where('nom_ecole', $ecole->nom_ecole)
            ->distinct()
            ->get()
            ->pluck('classe');
    
        // Si c'est une requête AJAX pour la recherche d'élèves
        if ($request->ajax()) {
            $nom_complet = $request->get('nom_eleve');
            $classe = $request->get('classe');
    
            // Requête pour chercher les élèves correspondant
            $eleves = DB::table('materiels')
                ->where('nom_ecole', $ecole->nom_ecole)
                ->where('nom_eleve', 'like', '%' . $nom_complet . '%')
                ->where('classe', $classe)
                ->get();
    
            // Retourner les résultats sous forme JSON
            return response()->json($eleves);
        }
    
        // Sinon, retourner la vue avec les classes
        return view('Uniforme.distribution', compact('classes'));
    }
    

    public function distribuer(Request $request)
    {
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }
    
        // Récupérer toutes les classes distinctes associées à cette école
        $classes = DB::table('uniformes')
            ->where('nom_ecole', $ecole->nom_ecole)
            ->distinct()
            ->pluck('classe');
    
        // Vérifier si une classe a été sélectionnée
        $classeSelectionnee = $request->input('classe');
       // dd($classeSelectionnee);  // Cette ligne affiche la classe sélectionnée et arrête l'exécution
    
        $materiels = collect();
    
        if ($classeSelectionnee) {
            $materiels = DB::table('uniformes')
                ->where('nom_ecole', $ecole->nom_ecole)
                ->where('classe', $classeSelectionnee)
                ->get();
        }
    
        return view('Uniforme.distribuer', compact('classes', 'materiels', 'classeSelectionnee'));
    }
    

    
    public function distribution_uniforme(Request $request) {
        // Valider les données envoyées
        $request->validate([
            'eleve_id' => 'required|exists:paiements,id_paiement', // L'ID de l'élève doit exister dans la table "eleves"
            'uniforme' => 'required', // Soit 'ok' soit 'non_ok'
            'reste' => 'nullable|string', // Le reste est optionnel, et n'est rempli que si materiel est 'non_ok'
        ]);
    
        // Récupérer les informations de l'élève avec l'ID
        $eleve = DB::table('paiements')->where('id_paiement', $request->eleve_id)->first();


     $materiel = Uniforme::where('nom_eleve', $eleve->nom_complet)
        ->where('classe', $eleve->classe)
        ->where('paiement',$eleve->id_paiement)
        ->first();

    if ($materiel) {
        // Vérifier si le matériel est OK
        if ($materiel->uniforme === 'non_ok') {
            session()->flash('materiel', $materiel);
            return redirect()->route('updateu', ['id' => $materiel->id]);
        }
         else {
            return redirect()->back()->with('success', 'l\'élève a déja reçu tous ses uniformes');
        }
    } else{
       // Insérer les données dans la table "materiel"
      Uniforme::create([
        'nom_eleve' => $eleve->nom_complet,
        'nom_ecole' => $eleve->nom_ecole,
        'classe' => $eleve->classe,
        'uniforme' => $request->uniforme,
        'reste' => $request->uniforme === 'non_ok' ? $request->reste : 'rien', // Si "NON OK", on enregistre les détails restants
        'paiement' => $eleve->id_paiement,
    ]);

    return redirect()->back()->with('success', 'Uniforme distribué avec succès.');
    }
       
    }
    public function update_uniforme(Request $request, $id) {
        // Récupérer le matériel
        $materiel = Uniforme::find($id);
    
        // Validation des nouvelles données
        $request->validate([
            'uniforme' => 'required|string',
            'reste' => 'nullable|string', // Champ optionnel pour le matériel manquant
        ]);
    
        // Mettre à jour le matériel
        $materiel->uniforme = $request->uniforme;
        $materiel->reste = $request->uniforme === 'non_ok' ? $request->reste : 'rien'; // Si 'non_ok', mettre à jour le reste
        $materiel->save();
    
        return redirect()->route('distribution', ['id' => $materiel->id])
                         ->with('success', 'uniforme mis à jour avec succès.');
    }
    public function update_unif(){
        return view('Uniforme.update');
    }
}
