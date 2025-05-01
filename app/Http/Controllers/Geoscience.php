<?php

namespace App\Http\Controllers;

use App\Mail\GeoscienceMail;
use App\Mail\GeoscienceResultat;
use App\Models\Geoscience as ModelsGeoscience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

class Geoscience extends Controller
{
    public function index(){
        $dateActuelle = now()->format('Y-m-d');
        
        $concoursOuvert = DB::table('sessions_concours')
            ->where('nom_filiere', 'INGEA')
            ->where('statut', 'ouverte')
            ->where('date_debut', '<=', $dateActuelle)
            ->where('date_concours', '>=', $dateActuelle)
            ->exists();
    
        if (!$concoursOuvert) {
            
            return redirect()->back()->with('error', 'Aucun concours INGEA ouvert actuellement');
            
        }
    
        return view('Concours.Geoscience.index');
    }
    
   public function store_finance(Request $request)
   {
       // Initialisation de la variable filePaths
       $filePaths = [];
   
       try {
           // 1. VALIDATION DES DONNÉES
           $validatedData = $request->validate([
               // Coordonnées du candidat
               'nom' => 'required|string|max:255',
               'prenom' => 'required|string|max:255',
               'sexe' => 'required|in:M,F',
               'date_naissance' => 'required|date',
               'lieu_naissance' => 'required|string|max:255',
               'nationalite' => 'required|string|max:255',
               'region_origine' => 'required|string|max:255',
               'adresse' => 'required|string|max:500',
               'telephone' => 'required|string|max:20',
               'email' => 'required|email|unique:geosciences',
               'titulaire_bac' => 'required|boolean',
               
               // Fichiers obligatoires
               'bulletin_seconde' => 'required|file|mimes:pdf',
               'bulletin_premiere' => 'required|file|mimes:pdf',
               'bulletin_terminale' => 'required|file|mimes:pdf',
               'diplome_probatoire' => 'required|file|mimes:pdf',
               'piece_identite_recto' => 'required|file|mimes:pdf,jpg,jpeg,png',
               'piece_identite_verso' => 'required|file|mimes:pdf,jpg,jpeg,png',
               'certificat_scolarite' => 'required|file|mimes:pdf',
               'fiche_inscription' => 'required|file|mimes:pdf',
               
               // Photo (optionnelle si capture)
               'photo_file' => 'nullable|file|mimes:jpg,jpeg,png',
               'photo_data' => 'nullable|string',
               
               // Diplôme bac (conditionnel)
               'diplome_bac' => 'nullable|required_if:titulaire_bac,true|file|mimes:pdf'
           ]);
   
           // 2. GESTION DES FICHIERS
           $filePaths = [
               'bulletin_seconde' => $this->storeFile($request->file('bulletin_seconde'), 'bulletins'),
               'bulletin_premiere' => $this->storeFile($request->file('bulletin_premiere'), 'bulletins'),
               'bulletin_terminale' => $this->storeFile($request->file('bulletin_terminale'), 'bulletins'),
               'diplome_probatoire' => $this->storeFile($request->file('diplome_probatoire'), 'diplomes'),
               'piece_identite_recto' => $this->storeFile($request->file('piece_identite_recto'), 'pieces'),
               'piece_identite_verso' => $this->storeFile($request->file('piece_identite_verso'), 'pieces'),
               'certificat_scolarite' => $this->storeFile($request->file('certificat_scolarite'), 'scolarite'),
               'fiche_inscription' => $this->storeFile($request->file('fiche_inscription'), 'inscriptions'),
           ];
   
           // Fichier conditionnel (diplôme bac)
           if ($request->titulaire_bac && $request->hasFile('diplome_bac')) {
               $filePaths['diplome_bac'] = $this->storeFile($request->file('diplome_bac'), 'diplomes');
           }
   
           // Gestion de la photo (fichier ou capture)
           if ($request->hasFile('photo_file')) {
               $filePaths['photo'] = $this->storeFile($request->file('photo_file'), 'photos');
           } elseif ($request->photo_data) {
               $filePaths['photo'] = $this->storeBase64Photo($request->photo_data);
           } else {
               throw new \Exception('Vous devez fournir une photo 4x4');
           }
   
           // 3. PRÉPARATION DES DONNÉES POUR L'INSERTION
           $insertData = [
               'nom' => $request->nom,
               'prenom' => $request->prenom,
               'sexe' => $request->sexe,
               'date_naissance' => $request->date_naissance,
               'lieu_naissance' => $request->lieu_naissance,
               'nationalite' => $request->nationalite,
               'region_origine' => $request->region_origine,
               'adresse' => $request->adresse,
               'telephone' => $request->telephone,
               'email' => $request->email,
               'titulaire_bac' => $request->titulaire_bac,
               'created_at' => now(),
               'updated_at' => now()
           ];
   
           // Ajout des chemins des fichiers
           $insertData = array_merge($insertData, [
               'bulletin_seconde_path' => $filePaths['bulletin_seconde'],
               'bulletin_premiere_path' => $filePaths['bulletin_premiere'],
               'bulletin_terminale_path' => $filePaths['bulletin_terminale'],
               'diplome_probatoire_path' => $filePaths['diplome_probatoire'],
               'piece_identite_recto_path' => $filePaths['piece_identite_recto'],
               'piece_identite_verso_path' => $filePaths['piece_identite_verso'],
               'certificat_scolarite_path' => $filePaths['certificat_scolarite'],
               'fiche_inscription_path' => $filePaths['fiche_inscription'],
               'photo_path' => $filePaths['photo'],
               'diplome_bac_path' => $filePaths['diplome_bac'] ?? null
           ]);
   
           // 4. INSERTION EN BASE DE DONNÉES
           $id = DB::table('geosciences')->insertGetId($insertData);
   
           // 5. RÉPONSE
           return redirect()->back()
                          ->with('success', 'Inscription enregistrée avec succès!');
   
       } catch (\Illuminate\Validation\ValidationException $e) {
           return redirect()->back()
                          ->withErrors($e->validator)
                          ->withInput();
                          
       } catch (\Exception $e) {
           // Nettoyage des fichiers uploadés en cas d'erreur
           foreach ($filePaths as $path) {
               if (!empty($path)) {
                   try {
                       Storage::disk('public')->delete($path);
                   } catch (\Exception $deleteException) {
                       Log::error("Échec suppression fichier: ".$path);
                   }
               }
           }
           
           Log::error('Erreur inscription finance: '.$e->getMessage());
           
           return redirect()->back()
                          ->with('error', 'Erreur lors de l\'inscription: '.$e->getMessage())
                          ->withInput();
       }
   }
   
   private function storeFile($file, $directory)
   {
       if (!$file) return null;
       
       $extension = $file->getClientOriginalExtension();
       $filename = Str::random(40).'.'.$extension;
       return $file->storeAs($directory, $filename, 'public');
   }
   
   private function storeBase64Photo($base64)
   {
       $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
       $filename = Str::random(40).'.png';
       $path = 'photos/'.$filename;
       
       Storage::disk('public')->put($path, $imageData);
       
       return $path;
   }

   public function geoscience(Request $request)
    {
        // Tri par défaut (date décroissante)
        $query = DB::table('geosciences')->orderBy('created_at', 'asc');
        
        // Si on veut le tri alphabétique
        if ($request->has('alphabetical')) {
            $query->orderBy('nom')->orderBy('prenom');
        }
    
        $candidates = $query->paginate(25);
    
        return view('Concours.Geoscience.dashboard', compact('candidates'));
    }
    public function showAttribution(Request $request)
    {
        // Tri par défaut (date décroissante)
        $query = DB::table('geosciences')->orderBy('created_at', 'desc');
        
        // Si on veut le tri alphabétique
        if ($request->has('alphabetical')) {
            $query->orderBy('nom')->orderBy('prenom');
        }
    
        $candidates = $query->paginate(25);
    
        return view('Concours.Geoscience.salle', compact('candidates'));
    }
    public function assignRooms(Request $request)
    {
        $request->validate([
            'students_per_room' => 'required|integer|min:1'
        ]);
    
        $candidates = DB::table('geosciences')
                      ->orderBy('nom')
                      ->orderBy('prenom')
                      ->get();
    
        $roomNumber = 1;
        $seatCounter = 0;
    
        foreach ($candidates as $candidate) {
            $seatCounter++;
            
            if ($seatCounter > $request->students_per_room) {
                $roomNumber++;
                $seatCounter = 1;
            }
    
            DB::table('geosciences')
              ->where('id', $candidate->id)
              ->update([
                  'exam_room' => 'Salle ' . $roomNumber,
                  'exam_seat' => $seatCounter
              ]);
        }
    
        return back()->with('success', 'Salles attribuées avec succès!');
    }
    public function shareRooms(Request $request)
    {
        logger()->info('Données reçues:', $request->all());
        
        $validated = $request->validate([
            'candidate_ids' => 'required|json'
        ]);
        $candidateIds = json_decode($validated['candidate_ids']);
        $candidates = ModelsGeoscience::whereIn('id', $candidateIds)
                              ->get()
                              ->map(function ($candidate) {
                                  return [
                                      'nom' => $candidate->nom,
                                      'prenom' => $candidate->prenom,
                                      'email' => $candidate->email,
                                      'exam_room' => $candidate->exam_room ?? '-',
                                      'exam_seat' => $candidate->exam_seat ?? '-'
                                  ];
                              })
                              ->toArray();
        
        logger()->info('Candidats récupérés:', $candidates);
        
        $generalistes = DB::table('geosciences')->pluck('email')->toArray();
        $pdf = PDF::loadView('Concours.Geoscience.partagemail', compact('candidates'));
        
        foreach ($generalistes as $email) {
            Mail::to($email)->send(new GeoscienceMail($candidates, $pdf));
        }
        
        return back()->with('success', 'Affectations envoyées avec succès !');
    }

    public function shareWithGeosciences(Request $request)
    {
        $request->validate([
            'results_file' => 'required|file|mimes:pdf',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        try {
            Log::info('Début de l\'envoi des résultats aux géosciences.');
    
            // Récupérer les emails
            $emails = DB::table('geosciences')->pluck('email')->toArray();
            Log::info('Emails récupérés : ' . count($emails) . ' destinataires.');
    
            // Stocker temporairement le fichier
            $file = $request->file('results_file');
            $filePath = $file->store('temp');
            $fullPath = Storage::path($filePath);
            Log::info('Fichier temporaire enregistré : ' . $filePath);
    
            // Envoyer à chaque email
            foreach ($emails as $email) {
                Mail::to($email)->send(new GeoscienceResultat(
                    $request->subject,
                    $request->message,
                    $fullPath
                ));
                Log::info('Email envoyé à : ' . $email);
            }
    
            // Supprimer le fichier temporaire
            Storage::delete($filePath);
            Log::info('Fichier temporaire supprimé : ' . $filePath);
    
            return back()->with('success', 'Résultats envoyés avec succès.');
    
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi des résultats : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi.');
        }
    }
}
