<?php

namespace App\Http\Controllers;

use App\Mail\AdminEcoleMail;
use App\Mail\EcoleMail;
use App\Models\Ecole;
use App\Models\Banque;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class EcoleController extends Controller
{
  public function compte(){
         $banques=Banque::all();
        return view('Ecole.compte-ecole',compact('banques'));
    }
    public function traitement_compte(Request $request)
    {
        // Vérifier si l'email existe déjà dans la base de données
    $ecoleExistante = Ecole::where('email', $request->input('email'))->first();
    $ide = Ecole::where('identifiant', $request->input('identifiant'))->first();
    $ecoleexi = Ecole::where('nom_ecole', $request->input('nom_ecole'))->first();
   // $ecoleExistante = Ecole::where('email', $request->input('email'))->first();


    // Si l'email n'existe pas, renvoyer un message d'erreur
    if ($ecoleExistante) {
        return redirect()->back()->withErrors(['email' => 'L\'adresse e-mail existe deja. Veuillez entrer une adresse e-mail.']);
    }
    if ($ecoleexi) {
        return redirect()->back()->withErrors(['nom_ecole' => 'Cette ecole existe deja. Veuillez entrer le nom de votre ecole.']);
    }
    if ($ecoleExistante) {
        return redirect()->back()->withErrors(['identifiant' => 'L\'identifiant existe deja.']);
    }
        // Générer un identifiant unique pour l'école
        $identifier = Str::random(11);
    
        // Valider les données de base de l'école, y compris la première banque obligatoire
        $validated = $request->validate([
            'nom_ecole' => 'required|string|max:255|unique:ecoles,nom_ecole',
            'email' => 'required|string|email|max:255|unique:ecoles,email',
            'telephone' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'nom_banque1' => 'required|string|max:255|not_in:choisir', // Banque 1 obligatoire
            'numero_compte1' => 'required|string|max:255', // Numéro de compte 1 obligatoire
        ]);
    
        // Construire un tableau pour stocker les autres banques et comptes validés
        $banks = [];
        for ($i = 2; $i <= 8; $i++) {
            $bankKey = 'nom_banque' . $i;
            $accountKey = 'numero_compte' . $i;
    
            // Vérifier si le champ de la banque est rempli et n'est pas "choisir"
            if ($request->filled($bankKey) && $request->$bankKey !== 'choisir') {
                // Valider que le numéro de compte est requis si une banque est sélectionnée
                $bankValidated = $request->validate([
                    $bankKey => 'nullable|string|max:255|not_in:choisir',
                    $accountKey => 'required_with:' . $bankKey . '|string|max:255', // Numéro de compte requis si la banque est présente
                ]);
    
                // Ajouter la banque et le numéro de compte au tableau
                $banks[] = [
                    'nom_banque' => $request->$bankKey,
                    'numero_compte' => $request->$accountKey,
                ];
            }
        }
    
        // Ajouter l'identifiant unique aux données validées
        $validated['identifiant'] = $identifier;
    
        // Créer une nouvelle instance de l'école et assigner les valeurs validées
        $ecole = new Ecole();
        $ecole->nom_ecole = $validated['nom_ecole'];
        $ecole->email = $validated['email'];
        $ecole->identifiant = $validated['identifiant'];
        $ecole->telephone = $validated['telephone'];
        $ecole->ville = $validated['ville'];
        $ecole->niveau = $validated['niveau'];
    
        // Assigner les valeurs de la banque obligatoire
        $ecole->nom_banque1 = $validated['nom_banque1'];
        $ecole->numero_banque1 = $validated['numero_compte1'];
    
        // Assigner les autres banques et comptes au modèle Ecole
        foreach ($banks as $index => $bank) {
            $ecole->{"nom_banque" . ($index + 2)} = $bank['nom_banque']; // Commence à la banque 2
            $ecole->{"numero_banque" . ($index + 2)} = $bank['numero_compte'];
        }
        // Enregistrer l'école dans la base de données
        $ecole->save();
    
        // Envoyer des emails à l'école et à l'administrateur
        Mail::to($ecole->email)->send((new EcoleMail($ecole))->mailuser());
        Mail::to('ajeangael@gmail.com')->send(new AdminEcoleMail($ecole));
        //Mail::to('danielotomo34@gmail.com')->send(new AdminEcoleMail($ecole));
        // Retourner une réponse de succès avec l'identifiant unique
       // if($ecole->niveau==='universite'){
         //   return redirect('/ecole/compte/classe/universite')->with('success', 'École enregistrée avec succès! Votre Identifiant vous a été envoyé par mail, consultez vos mails.');
       // }

        return redirect("/ecole/compte/classe/primaire_secondaire/{$ecole->id}")
        ->with('success', 'École enregistrée avec succès! Votre Identifiant vous a été envoyé par mail, consultez vos mails.');
    
    }
    
    public function email_inscription_ecole(){
        return view('Ecole.email-inscription');
    }
    // Fonction pour rechercher des écoles qui contiennent les lettres saisies
    public function searchSchool(Request $request)
    {
        if ($request->has('query')) {
            $searchTerm = $request->input('query');
            
            // Rechercher uniquement par nom d'école
            $ecoles = Ecole::where('nom_ecole', 'LIKE', '%' . $searchTerm . '%')
                ->get(['id', 'nom_ecole']); // Récupérer seulement l'ID et le nom pour les suggestions
    
            return response()->json($ecoles);
        }
    
        return response()->json([]);
    }
    public function getSchoolDetails($id)
{
    $ecole = Ecole::with('classes')->find($id); // Charge l'école avec ses classes

    if ($ecole) {
        Log::info('Niveau trouvé pour l\'école (ID: ' . $ecole->id . ') : ' . $ecole->niveau);

        // Filtrer les banques non nulles
        $banques = collect([
            $ecole->nom_banque1,
            $ecole->nom_banque2,
            $ecole->nom_banque3,
            $ecole->nom_banque4,
            $ecole->nom_banque5,
            $ecole->nom_banque6,
            $ecole->nom_banque7,
            $ecole->nom_banque8,
        ])->filter()->values();

        // Préparer les données des classes avec montants dynamiques
        $classes = $ecole->classes->map(function ($classe) {
            $tranches = collect([
                'premiere_tranche' => $classe->premiere_tranche,
                'deuxieme_tranche' => $classe->deuxieme_tranche,
                'troisieme_tranche' => $classe->troisieme_tranche,
                'quatrieme_tranche' => $classe->quatrieme_tranche,
                'cinquieme_tranche' => $classe->cinquieme_tranche,
                'sixieme_tranche' => $classe->sixieme_tranche,
                'septieme_tranche' => $classe->septieme_tranche,
                'huitieme_tranche' => $classe->huitieme_tranche,
                'totalite' => $classe->totalite,
            ])->filter()->toArray();

            return [
                'nom_classe' => $classe->nom_classe,
                'montants' => $tranches,
            ];
        });

        // Stocker les données de l'école dans la session
        Session::put('school_data', [
            'nom_ecole' => $ecole->nom_ecole,
            'telephone' => $ecole->telephone,
            'ville' => $ecole->ville,
            'niveau' => $ecole->niveau,
            'banques' => $banques,
            'classes' => $classes,
        ]);

        return response()->json([
            'view' => $ecole->niveau === 'primaire_secondaire' ? route('primaire') : route('universite'),
            'banques' => $banques,
            'classes' => $classes,
        ]);
    }

    Log::error('École introuvable pour l\'ID : ' . $id);
    return response()->json(['error' => 'École introuvable'], 404);
}

    
    
    public function login(){
        return view('Ecole.login');
    }
    public function classe_primaire($id)
    {
        return view('Ecole.classe_primaire', ['id' => $id]);
    }
    
    public function classe_univ($id){
        return view('Ecole.classe_universite', ['id' => $id]);
    }

public function traitement_classe(Request $request, $id)
{
    try {
        // Ajouter l'ID de l'école à la requête
        $request->merge(['id_ecole' => $id]);

        // Valider les données
        $validatedData = $request->validate([
            'id_ecole' => 'required|exists:ecoles,id',
            'nom_classe.*' => 'required|string',
            'indice.*' => 'required|string',
            'nombre.*' => 'required|integer|min:1',
            'montants.*' => 'nullable|string',
            'totalite.*' => 'nullable|numeric',
        ]);

        // Extraction des données validées
        $idEcole = $validatedData['id_ecole'];
        $classes = $validatedData['nom_classe'];
        $indices = $validatedData['indice'];
        $nombres = $validatedData['nombre'];

        // Transformation des montants en tableaux numériques
        $montantsParClasse = [];
        if (!empty($validatedData['montants'])) {
            foreach ($validatedData['montants'] as $montants) {
                $montantsParClasse[] = array_map('floatval', explode(',', $montants));
            }
        }

        $totalites = $validatedData['totalite'] ?? [];

        // Enregistrement des classes dans la base de données
        foreach ($classes as $index => $nomClasse) {
            $indiceDepart = $indices[$index];
            $nombreClasses = $nombres[$index];
            $montants = $montantsParClasse[$index] ?? [];
            $totalite = $totalites[$index] ?? null;

            $indiceASCII = ord($indiceDepart);

            for ($i = 0; $i < $nombreClasses; $i++) {
                $indiceClasse = chr($indiceASCII + $i);
                $nomClasseComplet = $nomClasse . ' ' . $indiceClasse;

                // Vérifier si la classe existe déjà pour cette école
                $existingClasse = DB::table('classes')
                    ->where('id_ecole', $idEcole)
                    ->where('nom_classe', $nomClasseComplet)
                    ->first();

                if ($existingClasse) {
                    // Si la classe existe déjà, retourner un message d'erreur
                    return redirect()->back()->with('error', 
                        'La classe "' . $nomClasseComplet . '" existe déjà pour cette école.'
                    );
                }

                // Si la classe n'existe pas, procéder à l'insertion
                DB::table('classes')->insert([
                    'id_ecole' => $idEcole,
                    'nom_classe' => $nomClasseComplet,
                    'premiere_tranche' => $montants[0] ?? null,
                    'deuxieme_tranche' => $montants[1] ?? null,
                    'troisieme_tranche' => $montants[2] ?? null,
                    'quatrieme_tranche' => $montants[3] ?? null,
                    'cinquieme_tranche' => $montants[4] ?? null,
                    'sixieme_tranche' => $montants[5] ?? null,
                    'septieme_tranche' => $montants[6] ?? null,
                    'huitieme_tranche' => $montants[7] ?? null,
                    'totalite' => $totalite,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Retour en cas de succès
        return redirect()->back()->with('success', 
            'Classes ajoutées avec succès. Cliquez <a href="' . route('dashboard_ecole') . '" class="text-blue-500 font-bold">ici 🚀</a> pour accéder à votre tableau de bord.'
        );

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Retour en cas d'erreur de validation
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        // Retour en cas d'erreur inattendue
        return redirect()->back()
            ->with('error', 'Une erreur est survenue lors du traitement : ' . $e->getMessage())
            ->withInput();
    }
}

public function traitement_classe_profil(Request $request, $id)
{
    try {
        // Ajouter l'ID de l'école à la requête
        $request->merge(['id_ecole' => $id]);

        // Valider les données
        $validatedData = $request->validate([
            'id_ecole' => 'required|exists:ecoles,id',
            'nom_classe.*' => 'required|string',
            'indice.*' => 'required|string',
            'nombre.*' => 'required|integer|min:1',
            'montants.*' => 'nullable|string',
            'totalite.*' => 'nullable|numeric',
        ]);

        // Extraction des données validées
        $idEcole = $validatedData['id_ecole'];
        $classes = $validatedData['nom_classe'];
        $indices = $validatedData['indice'];
        $nombres = $validatedData['nombre'];

        // Transformation des montants en tableaux numériques
        $montantsParClasse = [];
        if (!empty($validatedData['montants'])) {
            foreach ($validatedData['montants'] as $montants) {
                $montantsParClasse[] = array_map('floatval', explode(',', $montants));
            }
        }

        $totalites = $validatedData['totalite'] ?? [];

        // Enregistrement des classes dans la base de données
        foreach ($classes as $index => $nomClasse) {
            $indiceDepart = $indices[$index];
            $nombreClasses = $nombres[$index];
            $montants = $montantsParClasse[$index] ?? [];
            $totalite = $totalites[$index] ?? null;

            $indiceASCII = ord($indiceDepart);

            for ($i = 0; $i < $nombreClasses; $i++) {
                $indiceClasse = chr($indiceASCII + $i);
                $nomClasseComplet = $nomClasse . ' ' . $indiceClasse;

                // Vérifier si la classe existe déjà pour cette école
                $existingClasse = DB::table('classes')
                    ->where('id_ecole', $idEcole)
                    ->where('nom_classe', $nomClasseComplet)
                    ->first();

                if ($existingClasse) {
                    // Si la classe existe déjà, retourner un message d'erreur
                    return redirect()->back()->with('error', 
                        'La classe "' . $nomClasseComplet . '" existe déjà pour cette école.'
                    );
                }

                // Si la classe n'existe pas, procéder à l'insertion
                DB::table('classes')->insert([
                    'id_ecole' => $idEcole,
                    'nom_classe' => $nomClasseComplet,
                    'premiere_tranche' => $montants[0] ?? null,
                    'deuxieme_tranche' => $montants[1] ?? null,
                    'troisieme_tranche' => $montants[2] ?? null,
                    'quatrieme_tranche' => $montants[3] ?? null,
                    'cinquieme_tranche' => $montants[4] ?? null,
                    'sixieme_tranche' => $montants[5] ?? null,
                    'septieme_tranche' => $montants[6] ?? null,
                    'huitieme_tranche' => $montants[7] ?? null,
                    'totalite' => $totalite,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

         // Retour en cas de succès
         return redirect()->route('profil', ['id' => $idEcole])
         ->with('success', 'Classes ajoutées avec succès.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Retour en cas d'erreur de validation
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        // Retour en cas d'erreur inattendue
        return redirect()->back()
            ->with('error', 'Une erreur est survenue lors du traitement : ' . $e->getMessage())
            ->withInput();
    }
}

}

        
    


