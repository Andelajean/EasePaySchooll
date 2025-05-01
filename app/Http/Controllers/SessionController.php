<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        // Log des données reçues
        Log::debug('Données du formulaire:', $request->all());

        // Règles de validation
        $rules = [
            'nom_session' => 'required|string|max:255',
            'nom_filiere' => 'required|string|in:IGC,M&F,INGE,INGEA,SPH',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_concours' => 'required|date|after:date_debut',
            'date_fin' => 'required|date|after:date_debut|before:date_concours' // Date fin avant concours
        ];

        // Messages d'erreur personnalisés
        $messages = [
            'date_debut.after_or_equal' => 'La date de début doit être aujourd\'hui ou ultérieure',
            'date_concours.after' => 'La date de concours doit être après la date de début',
            'date_fin.after' => 'La date de fin doit être après la date de début',
            'date_fin.before' => 'La date de fin doit être avant la date de concours'
        ];

        // Validation des données
        $validated = $request->validate($rules, $messages);

        // Vérification des conflits de dates
        $hasConflict = DB::table('sessions_concours')
            ->where('nom_filiere', $validated['nom_filiere'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                      ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('date_debut', '<', $validated['date_debut'])
                            ->where('date_fin', '>', $validated['date_fin']);
                      });
            })
            ->exists();

        if ($hasConflict) {
            Log::warning('Conflit de session détecté pour la filière '.$validated['nom_filiere']);
            return back()
                ->with('error', 'Une session existe déjà pour cette période')
                ->withInput();
        }

        // Enregistrement en base de données
        try {
            $id = DB::table('sessions_concours')->insertGetId([
                'nom_session' => $validated['nom_session'],
                'nom_filiere' => $validated['nom_filiere'],
                'date_debut' => $validated['date_debut'],
                'date_concours' => $validated['date_concours'],
                'date_fin' => $validated['date_fin'],
                'statut' => 'ouverte',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Nouvelle session créée - ID: '.$id);
            return back()->with('success', 'Session créée avec succès!');

        } catch (\Exception $e) {
            Log::error('Erreur d\'enregistrement: '.$e->getMessage());
            return back()
                ->with('error', 'Erreur technique: '.$e->getMessage())
                ->withInput();
        }
    }
}