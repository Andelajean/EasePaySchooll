<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Paiement;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Mail\IdentifiantMisAJour;
use Illuminate\Support\Facades\Mail;

class ProfilEcole extends Controller
{

    public function edit($id)
    {
        // Récupération de la classe sélectionnée
        $classe = Classe::findOrFail($id);

        // Retourner la vue avec les données de la classe
        return view('Ecole.edit_classe', compact('classe'));
    }
   
        public function updateClasse(Request $request, $id)
        {
           // Valider les champs
        $validatedData = $request->validate([
            'nom_classe' => 'required|string|max:255',
            'premiere_tranche' => 'nullable|numeric|min:0',
            'deuxieme_tranche' => 'nullable|numeric|min:0',
            'troisieme_tranche' => 'nullable|numeric|min:0',
            'quatrieme_tranche' => 'nullable|numeric|min:0',
            'cinquieme_tranche' => 'nullable|numeric|min:0',
            'sixieme_tranche' => 'nullable|numeric|min:0',
            'septieme_tranche' => 'nullable|numeric|min:0',
            'huitieme_tranche' => 'nullable|numeric|min:0',
        ]);

        // Vérification que chaque tranche est remplie après la précédente
        $tranches = [
            'premiere_tranche',
            'deuxieme_tranche',
            'troisieme_tranche',
            'quatrieme_tranche',
            'cinquieme_tranche',
            'sixieme_tranche',
            'septieme_tranche',
            'huitieme_tranche',
        ];

        foreach ($tranches as $index => $tranche) {
            if (!empty($validatedData[$tranche]) && $index > 0) {
                $previousTranche = $tranches[$index - 1];
                if (empty($validatedData[$previousTranche])) {
                    return redirect()->back()->withErrors([
                        'error' => "Vous devez remplir la tranche " . ($index) . " avant de remplir la tranche " . ($index + 1) . ".",
                    ])->withInput();
                }
            }
        }

        // Calcul de la totalité
        $totalite = 0;
        foreach ($tranches as $tranche) {
            $totalite += $validatedData[$tranche] ?? 0;
        }

        // Mise à jour de la classe
        $classe = Classe::findOrFail($id);
        $classe->update(array_merge($validatedData, ['totalite' => $totalite]));
        $ecoleId = $classe->id_ecole;
        // Rediriger avec un message de succès
        return redirect()->route('profil', ['id' => $ecoleId])
        ->with('success', 'Classe mise à jour avec succès.');
    }
    public function profil($id)
{
    // Récupération de l'école avec ses classes
    $ecole = Ecole::with('classes')->findOrFail($id);

    // Filtrage des classes avec montants non nuls
    $classes = $ecole->classes->filter(function ($classe) {
        return $classe->premiere_tranche !== null ||
               $classe->deuxieme_tranche !== null ||
               $classe->troisieme_tranche !== null ||
               $classe->quatrieme_tranche !== null ||
               $classe->cinquieme_tranche !== null ||
               $classe->sixieme_tranche !== null ||
               $classe->septieme_tranche !== null ||
               $classe->huitieme_tranche !== null ||
               $classe->totalite !== null;
    });

    return view('Ecole.profil', compact('ecole', 'classes'));
}


public function update(Request $request, $id)
{
    // Trouver l'école
    $ecole = Ecole::findOrFail($id);

    // Valider les données
    $validatedData = $request->validate([
        'nom_ecole' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'ville' => 'required|string|max:255',
        'niveau' => 'required|string|max:255',
        'telephone' => 'required|string|max:20|unique:ecoles,telephone,' . $id,
        
    ]);

    // Mettre à jour les informations de l'école
    $ecole->update($validatedData);

    // Mettre à jour les paiements associés
    Paiement::where('id_ecole', $id)->update([
        'nom_ecole' => $validatedData['nom_ecole'],
        'telephone' => $validatedData['telephone'],
        'ville' => $validatedData['ville'],
        'niveau' => $validatedData['niveau'],
    ]);

    // Redirection avec un message de succès
    return redirect()->back()->with('success', 'Les informations de l\'école et des paiements associés ont été mises à jour.');
}

public function updateBanque(Request $request, $id)
    {
        // Valider les données d'entrée
        $request->validate([
            'nom_banque' => 'required|string|max:255',
            'numero_banque' => 'required|string|max:255',
            'banque_index' => 'required|integer|min:1|max:8',
        ]);

        // Récupérer l'école à mettre à jour
        $ecole = Ecole::findOrFail($id);

        // Construire le nom des colonnes dynamiquement en fonction de l'index
        $nomColonneBanque = 'nom_banque' . $request->banque_index;
        $numeroColonneBanque = 'numero_banque' . $request->banque_index;

        // Vérifier si les colonnes existent
        if (!array_key_exists($nomColonneBanque, $ecole->getAttributes()) || 
            !array_key_exists($numeroColonneBanque, $ecole->getAttributes())) {
            return redirect()->back()->withErrors('error','index de la banque non trouvé');
        }

        // Mettre à jour les colonnes
        $ecole->$nomColonneBanque = $request->nom_banque;
        $ecole->$numeroColonneBanque = $request->numero_banque;

        // Sauvegarder les changements
        $ecole->save();

        return redirect()->back()->with('success', 'Les informations ont été mises à jour.');
    }

   
    public function store(Request $request)
    {
        // Règles de validation de base
        $rules = [
            'id_ecole' => [
                'required',
                'exists:ecoles,id',
            ],
            'nom_classe' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'nom_classe')->where('id_ecole', $request->id_ecole),
            ],
            'premiere_tranche' => [
                'required',
                'numeric',
                'min:0',
            ],
            'deuxieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'troisieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'quatrieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'cinquieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'sixieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'septieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'huitieme_tranche' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ];
    
        // Messages personnalisés
        $messages = [
            'nom_classe.unique' => 'Cette classe existe déjà pour cette école.',
            'premiere_tranche.required' => 'La première tranche est obligatoire.',
        ];
    
        // Validation des données de base
        $validated = $request->validate($rules, $messages);
    
        // Vérification de l'ordre des tranches
        $tranches = [
            'premiere_tranche',
            'deuxieme_tranche',
            'troisieme_tranche',
            'quatrieme_tranche',
            'cinquieme_tranche',
            'sixieme_tranche',
            'septieme_tranche',
            'huitieme_tranche',
        ];
    
        $erreurTranche = null;
    
        // Vérifie si les tranches sont remplies dans l'ordre
        foreach ($tranches as $index => $tranche) {
            if ($request->$tranche !== null) {
                // Vérifie que toutes les tranches précédentes sont remplies
                for ($i = 0; $i < $index; $i++) {
                    if ($request->{$tranches[$i]} === null) {
                        $erreurTranche = "Vous devez remplir la tranche \"" . ucfirst(str_replace('_', ' ', $tranches[$i])) . "\" avant de remplir \"" . ucfirst(str_replace('_', ' ', $tranche)) . "\".";
                        break 2; // Sort des deux boucles
                    }
                }
            }
        }
    
        // Si une erreur d'ordre est détectée, retourne une erreur
        if ($erreurTranche) {
            return back()->withErrors(['tranche_order' => $erreurTranche])->withInput();
        }
    
        // Calculer le total des tranches
        $totalite = collect($tranches)
            ->map(fn($tranche) => $request->$tranche)
            ->filter()
            ->sum();
    
        // Création de la classe
        Classe::create([
            'id_ecole' => $validated['id_ecole'],
            'nom_classe' => $validated['nom_classe'],
            'premiere_tranche' => $validated['premiere_tranche'],
            'deuxieme_tranche' => $validated['deuxieme_tranche'],
            'troisieme_tranche' => $validated['troisieme_tranche'],
            'quatrieme_tranche' => $validated['quatrieme_tranche'],
            'cinquieme_tranche' => $validated['cinquieme_tranche'],
            'sixieme_tranche' => $validated['sixieme_tranche'],
            'septieme_tranche' => $validated['septieme_tranche'],
            'huitieme_tranche' => $validated['huitieme_tranche'],
            'totalite' => $totalite,
        ]);
    
        // Redirection après succès
        return redirect()
            ->route('profil', ['id' => $validated['id_ecole']])
            ->with('success', 'Classe ajoutée avec succès !');
    }
    

public function addBank(Request $request, $id)
{
    // Valider les données d'entrée
    $request->validate([
        'nom_banque' => 'required|string|max:255',
        'numero_banque' => 'required|string|max:255',
        'banque_index' => 'required|integer|min:1|max:8',
    ]);

    // Récupérer l'école
    $ecole = Ecole::findOrFail($id);

    // Vérifier si le nom de la banque ou le numéro de compte existe déjà
    for ($i = 1; $i <= 8; $i++) {
        $nomColonne = 'nom_banque' . $i;
        $numeroColonne = 'numero_banque' . $i;

        if ($ecole->$nomColonne === $request->nom_banque) {
            return back()->withErrors([
                'error' => 'Ce nom de banque existe déjà dans l’enregistrement de la banque ' . $i . '.',
            ])->withInput();
        }

        if ($ecole->$numeroColonne === $request->numero_banque) {
            return back()->withErrors([
                'error' => 'Ce numéro de compte existe déjà dans l’enregistrement de la banque ' . $i . '.',
            ])->withInput();
        }
    }

    // Identifier les colonnes dynamiques
    $nomColonne = 'nom_banque' . $request->banque_index;
    $numeroColonne = 'numero_banque' . $request->banque_index;

    // Vérifier si l'index est déjà occupé
    if (!empty($ecole->$nomColonne) || !empty($ecole->$numeroColonne)) {
        // Trouver les index libres
        $indexesLibres = [];
        for ($i = 1; $i <= 8; $i++) {
            $nomCol = 'nom_banque' . $i;
            $numCol = 'numero_banque' . $i;

            if (empty($ecole->$nomCol) && empty($ecole->$numCol)) {
                $indexesLibres[] = $i;
            }
        }

        return back()->withErrors([
            'error' => 'L’index ' . $request->banque_index . ' est déjà occupé. Les index libres sont : ' . implode(', ', $indexesLibres) . '.',
        ])->withInput();
    }

    // Vérifier si l'ordre des index est respecté
    for ($i = 1; $i < $request->banque_index; $i++) {
        $nomCol = 'nom_banque' . $i;
        $numCol = 'numero_banque' . $i;

        if (empty($ecole->$nomCol) || empty($ecole->$numCol)) {
            return back()->withErrors([
                'error' => 'Vous devez remplir les index dans l’ordre. L’index ' . $i . ' n’est pas encore rempli.',
            ])->withInput();
        }
    }

    // Mettre à jour les colonnes
    $ecole->$nomColonne = $request->nom_banque;
    $ecole->$numeroColonne = $request->numero_banque;

    // Sauvegarder dans la base de données
    $ecole->save();

    // Redirection avec un message de succès
    return redirect()->back()->with('success', 'Banque ajoutée avec succès.');
}

public function destroy($id)
{
    try {
        // Recherche et suppression de la classe
        $classe = Classe::findOrFail($id);
        $classe->delete();

        // Redirection après suppression avec un message de succès
        return redirect()->back()->with('success', 'Classe supprimée avec succès.');
    } catch (\Exception $e) {
        // Gestion des erreurs
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression : ' . $e->getMessage());
    }
}
public function deleteBank(Request $request, $ecoleId, $index)
{
    try {
        // Récupérer l'école
        $ecole = Ecole::findOrFail($ecoleId);

        // Identifier les champs de la banque à supprimer
        $nomBanqueField = "nom_banque{$index}";
        $numeroBanqueField = "numero_banque{$index}";

        // Vérifier si les champs existent
        if (!$ecole->$nomBanqueField || !$ecole->$numeroBanqueField) {
            return redirect()->back()->with('error', 'Cette banque n\'existe pas ou a déjà été supprimée.');
        }

        // Supprimer les valeurs
        $ecole->$nomBanqueField = null;
        $ecole->$numeroBanqueField = null;

        // Sauvegarder les modifications
        $ecole->save();

        return redirect()->back()->with('success', 'La banque a été supprimée avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}
public function generateIdentifiant(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'telephone' => 'required|string',
        'email' => 'required|email',
    ]);

    // Recherche de l'école avec les informations fournies
    $ecole = Ecole::where('telephone', $validatedData['telephone'])
                  ->where('email', $validatedData['email'])
                  ->first();

    if (!$ecole) {
        return redirect()->back()->with('error', 'Aucune école ne correspond aux informations fournies.');
    }

    // Génération d'un nouvel identifiant unique
    $nouvelIdentifiant = strtoupper(Str::random(11)); // Chaîne aléatoire de 11 caractères

    // Mise à jour de l'école avec le nouvel identifiant
    $ecole->update(['identifiant' => $nouvelIdentifiant]);

    // Envoi d'un email à l'école
    Mail::to($ecole->email)
        ->cc('ajeangael@gmail.com') // Email de l'administrateur
        ->send(new IdentifiantMisAJour($ecole, $nouvelIdentifiant));

    return redirect()->back()->with('success', "L'identifiant a été généré avec succès et envoyé par email.");
}
}
