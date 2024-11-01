<?php

namespace App\Http\Controllers;

use App\Mail\AdminEcoleMail;
use App\Mail\EcoleMail;
use App\Models\Ecole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EcoleController extends Controller
{
  public function compte(){
        return view('Ecole.compte-ecole');
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
    
        // Retourner une réponse de succès avec l'identifiant unique
        return redirect()->back()->with('success', 'École enregistrée avec succès! Votre Identifiant vous a été envoyé par mail, consultez vos mails.');
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
        // Trouver l'école
        $ecole = Ecole::find($id);
    
        if ($ecole) {
            // Préparer les détails à envoyer au frontend
            $ecoleDetails = [
                'nom_ecole' => $ecole->nom_ecole,
                'telephone' => $ecole->telephone,
                'ville' => $ecole->ville,
                'niveau' => $ecole->niveau, // Montant total
            ];
    
            // Ajouter les banques (nom uniquement)
            for ($i = 1; $i <= 8; $i++) {
                if ($ecole->{'nom_banque' . $i}) {
                    $ecoleDetails['nom_banque' . $i] = $ecole->{'nom_banque' . $i};
                }
            }

            return response()->json($ecoleDetails);
        }
    
        return response()->json(null, 404);
    }
    public function login(){
        return view('Ecole.login');
    }
}
