<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Paiement;
use App\Models\PenailiteEcole;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class Penalite extends Controller
{
    public function penalite()
    {
        // Récupérer l'école active depuis la session
    $ecole = Session::get('ecole');

    if ($ecole) {
        // Récupérer l'identifiant de l'école active
        $idEcole = $ecole->id; // Supposant que l'id de l'école est stocké dans l'objet $ecole

        // Récupérer les classes de l'école
        $classes = Classe::where('id_ecole', $idEcole)->get();
        $penalites = PenailiteEcole::where('ecole_id',$idEcole)->get();

        // Retourner la vue avec les classes
        return view('Ecole.penalite', compact('classes','penalites'));
    }

    // Si aucune école n'est active, rediriger avec un message d'erreur
    return redirect()->route('login.ecole')->with('error', 'Aucune école active trouvée.');
    }

    public function store(Request $request)
    {
        try {
            // Étape 1 : Récupérer l'école depuis la session
            $ecole = Session::get('ecole');
            Log::info('École récupérée depuis la session.', ['ecole' => $ecole]);
    
            if (!$ecole || !isset($ecole->id)) {
                Log::error('Aucune école valide trouvée dans la session.');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Aucune école valide trouvée dans la session.'
                ], 400);
            }
    
            // Étape 2 : Validation des données
            Log::info('Données reçues pour validation.', ['data' => $request->all()]);
    
            // Préparer les données pour la validation
            $data = $request->all();
            foreach ($data['classes'] as &$class) {
                if (!isset($class['id'])) {
                    $class['id'] = null; // Ajout d'une valeur par défaut si "id" est absent
                }
            }
    
            // Validation des données entrantes
            $validated = Validator::make($data, [
                'classes' => 'required|array',
                'classes.*.id' => 'nullable|int', // "id" est facultatif
                'classes.*.nom' => 'required|string|max:255', // Valider les noms des classes
                'classes.*.date_debut' => 'required|date',
                'classes.*.montant' => 'required|numeric|min:0',
                'classes.*.frequence' => 'required|string|in:jour,semaine,mois',
                'classes.*.tranche' => 'required|string|max:255',
            ])->validate();
    
            Log::info('Données validées avec succès.', ['validatedData' => $validated]);
    
            // Étape 3 : Vérification et enregistrement
            foreach ($validated['classes'] as $classData) {
                Log::info('Traitement de la classe.', ['classData' => $classData]);
    
                // Vérification des duplications
                $existingPenalite = PenailiteEcole::where('classe', $classData['nom'])
                    ->where('ecole_id', $ecole->id)
                    ->where('tranche', $classData['tranche'])
                    ->first();
    
                if ($existingPenalite) {
                    Log::warning('Une pénalité existe déjà pour cette classe et cette tranche.', ['class_nom' => $classData['nom']]);
                    return response()->json([
                        'status' => 'error',
                        'message' => "Une pénalité existe déjà pour la classe '{$classData['nom']}' avec la tranche '{$classData['tranche']}'."
                    ], 400);
                }
    
                // Enregistrement de la pénalité
                PenailiteEcole::create([
                    'classe' => $classData['nom'],
                    'date_debut' => $classData['date_debut'],
                    'montant' => $classData['montant'],
                    'frequence' => $classData['frequence'],
                    'tranche' => $classData['tranche'],
                    'ecole_id' => $ecole->id,
                ]);
    
                Log::info('Pénalité enregistrée avec succès pour la classe.', ['class_nom' => $classData['nom']]);
            }
    
            Log::info('Toutes les pénalités ont été enregistrées avec succès.');
            return response()->json([
                'status' => 'success',
                'message' => 'Les pénalités ont été enregistrées avec succès.'
            ], 200);
    
        } catch (ValidationException $e) {
            Log::error('Erreur de validation.', [
                'errors' => $e->errors(),
                'data_sent' => $request->all(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de validation des données.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Une erreur inattendue s\'est produite.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur inattendue s\'est produite. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
public function edit($id)
{
    try {
        // Récupérer la pénalité via l'ID
        $penalite = PenailiteEcole::findOrFail($id);

        // Renvoyer la vue d'édition avec la pénalité
        return view('Ecole.edit_penalite', compact('penalite'));
    } catch (\Exception $e) {
        Log::error('Erreur lors de la récupération de la pénalité.', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Impossible de récupérer la pénalité.');
    }
}
public function destroy($id)
{
    try {
        // Récupérer et supprimer la pénalité
        $penalite = PenailiteEcole::findOrFail($id);
        $penalite->delete();

        return redirect()->route('penalite')->with('success', 'Pénalité supprimée avec succès.');
    } catch (\Exception $e) {
        Log::error('Erreur lors de la suppression de la pénalité.', ['message' => $e->getMessage()]);
        return redirect()->route('penalite')->with('error', 'Impossible de supprimer la pénalité.');
    }
}
public function update(Request $request, $id)
{
    try {
        // Valider les données
        $validated = $request->validate([
            'classe' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'montant' => 'required|numeric|min:0',
            'frequence' => 'required|string|in:jour,semaine,mois',
            'tranche' => 'required|string|max:255',
        ]);

        // Mettre à jour la pénalité
        $penalite = PenailiteEcole::findOrFail($id);
        $penalite->update($validated);

        return redirect()->route('penalite')->with('success', 'Pénalité mise à jour avec succès.');
    } catch (\Exception $e) {
        Log::error('Erreur lors de la mise à jour de la pénalité.', ['message' => $e->getMessage()]);
        return redirect()->route('penalite')->with('error', 'Impossible de mettre à jour la pénalité.');
    }
}
public function afficherPenalitesEtPaiements(Request $request)
{
    $ecole = Session::get('ecole'); // Récupération de l'école connectée

    if (!$ecole) {
        return redirect()->back()->with('error', 'Aucune école connectée.');
    }

    $classeSelectionnee = $request->input('classe');
    $trancheSelectionnee = $request->input('tranche');

    // Récupération des classes et tranches de l'école
    $classes = DB::table('classes')
        ->where('id_ecole', $ecole->id)
        ->get(['nom_classe', 'premiere_tranche', 'deuxieme_tranche', 'troisieme_tranche']);

    $resultats = [];

    if ($classeSelectionnee && $trancheSelectionnee) {
        // Récupérer les pénalités de la classe et tranche sélectionnées
        $penalites = PenailiteEcole::where('ecole_id', $ecole->id)
            ->where('classe', $classeSelectionnee)
            ->where('tranche', $trancheSelectionnee)
            ->get();

        foreach ($penalites as $penalite) {
            $paiements = Paiement::where('classe', $penalite->classe)
                ->where('id_ecole', $ecole->id)
                ->where('details', $penalite->tranche)
                ->whereDate('date_paiement', '>=', $penalite->date_debut)
                ->get();

            foreach ($paiements as $paiement) {
                $dateDebut = Carbon::parse($penalite->date_debut);
                $datePaiement = Carbon::parse($paiement->date_paiement);

                $nombreJours = $dateDebut->diffInDays($datePaiement);
                $penaliteMontant = match ($penalite->frequence) {
                    'mois' => $nombreJours * $penalite->montant,
                    'semaine' => floor($nombreJours / 7) * $penalite->montant,
                    'jour' => $nombreJours * $penalite->montant,
                    default => 0,
                };

                $resultats[] = [
                    'nom_etudiant' => $paiement->nom_complet,
                    'classe' => $paiement->classe,
                    'date_paiement' => $paiement->date_paiement,
                    'date_debut_penalite' => $penalite->date_debut,
                    'nombre_jours' => $nombreJours,
                    'montant_a_payer' => $penaliteMontant,
                ];
            }
        }
    }

    // Pagination manuelle pour un tableau PHP
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 3;
    $currentPageItems = array_slice($resultats, ($currentPage - 1) * $perPage, $perPage);
    $resultatsPagines = new LengthAwarePaginator($currentPageItems, count($resultats), $perPage);

    // Ajout des paramètres à la pagination pour garder les filtres dans les URLs
    $resultatsPagines->withPath(route('calculer_penalites'));

    return view('Ecole.penalite_classe', compact('classes', 'resultatsPagines', 'classeSelectionnee', 'trancheSelectionnee'));
}

  
}
