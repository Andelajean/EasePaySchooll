<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\PenailiteEcole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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

        // Retourner la vue avec les classes
        return view('Ecole.penalite', compact('classes'));
    }

    // Si aucune école n'est active, rediriger avec un message d'erreur
    return redirect()->route('login.ecole')->with('error', 'Aucune école active trouvée.');
    }

    public function store(Request $request)
{
    try {
        // Récupérer l'école depuis la session
        $ecole = Session::get('ecole');
        dd('École récupérée depuis la session.', ['ecole' => $ecole]);

        if (!$ecole) {
            dd('Aucune école trouvée dans la session.');
            return redirect()->back()->with('error', 'Aucune école trouvée dans la session.');
        }

        // Valider les données
        $validatedData = $request->validate([
            'classes' => 'required|array',
            'classes.*.id' => 'required|exists:classes,id',
            'classes.*.date_debut' => 'required|date',
            'classes.*.montant' => 'required|numeric|min:0',
            'classes.*.frequence' => 'required|string',
            'classes.*.tranche' => 'required|string',
        ]);

        dd('Données validées avec succès.', ['validatedData' => $validatedData]);

        // ID de l'école connectée
        $idEcole = $ecole->id;

        // Démarrer une transaction pour assurer la cohérence des données
        DB::beginTransaction();

        foreach ($validatedData['classes'] as $classData) {
            dd('Insertion de la pénalité pour la classe.', ['classData' => $classData]);

            // Insérer chaque classe dans la table
            DB::table('penalite_ecoles')->insert([
                'ecole_id' => $idEcole,
                'classe' => $classData['nom'],
                'date_debut' => $classData['date_debut'],
                'tranche' => $classData['tranche'],
                'frequence' => $classData['frequence'],
                'montant' => $classData['montant'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Valider la transaction
        DB::commit();
        dd('Toutes les pénalités ont été enregistrées avec succès.');

        return redirect()->back()->with('success', 'Pénalités enregistrées avec succès.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        dd('Erreur de validation.', ['errors' => $e->errors()]);
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        dd('Erreur lors de l’enregistrement.', ['exception' => $e->getMessage()]);
        DB::rollBack();
        return redirect()->back()->with('error', 'Une erreur est survenue lors de l’enregistrement. Veuillez réessayer.');
    }
}

    
}
