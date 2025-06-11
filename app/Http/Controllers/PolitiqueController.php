<?php

namespace App\Http\Controllers;

use App\Mail\PolitiqueceMail;
use App\Mail\PolitiqueResultat;
use App\Models\Paiement;
use App\Models\Politique;
use App\Models\PaiementSaintJean;
use Endroid\QrCode\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
class PolitiqueController extends Controller
{
    public function index(){
        $dateActuelle = now()->format('Y-m-d');
        
        $concoursOuvert = DB::table('sessions_concours')
            ->where('nom_filiere', 'SPH')
            ->where('statut', 'ouverte')
            ->where('date_debut', '<=', $dateActuelle)
            ->where('date_concours', '>=', $dateActuelle)
            ->exists();
    
        if (!$concoursOuvert) {
            
            return redirect()->back()->with('error', 'Aucun concours SPH ouvert actuellement');
            
        }
    
        return view('Concours.politique.index');
    }
    
   public function store_pol(Request $request)
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
               'email' => 'required|email|unique:politiques',
               'lycee' => 'required|string|max:255',
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
               'lycee' => $request->lycee,
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
           $id = DB::table('politiques')->insertGetId($insertData);
   
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

   public function politique(Request $request)
    {
        // Tri par défaut (date décroissante)
        $query = DB::table('politiques')->orderBy('created_at', 'asc');
        
        // Si on veut le tri alphabétique
        if ($request->has('alphabetical')) {
            $query->orderBy('nom')->orderBy('prenom');
        }
    
        $candidates = $query->paginate(25);
    
        return view('Concours.politique.dashboard', compact('candidates'));
    }
    public function showAttribution(Request $request)
    {
        // Tri par défaut (date décroissante)
        $query = DB::table('politiques')->orderBy('created_at', 'desc');
        
        // Si on veut le tri alphabétique
        if ($request->has('alphabetical')) {
            $query->orderBy('nom')->orderBy('prenom');
        }
    
        $candidates = $query->paginate(25);
    
        return view('Concours.politique.salle', compact('candidates'));
    }
    public function assignRooms(Request $request)
    {
        $request->validate([
            'students_per_room' => 'required|integer|min:1'
        ]);
    
        $candidates = DB::table('politiques')
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
    
            DB::table('politiques')
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
        $candidates = Politique::whereIn('id', $candidateIds)
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
        
        $generalistes = DB::table('politiques')->pluck('email')->toArray();
        $pdf = PDF::loadView('Concours.politique.partagemail', compact('candidates'));
        
        foreach ($generalistes as $email) {
            Mail::to($email)->send(new PolitiqueceMail($candidates, $pdf));
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
        $emails = DB::table('politiques')->pluck('email')->toArray();
        Log::info('Emails récupérés : ' . count($emails) . ' destinataires.');

        // Stocker temporairement le fichier
        $file = $request->file('results_file');
        $filePath = $file->store('temp');
        $fullPath = Storage::path($filePath);
        Log::info('Fichier temporaire enregistré : ' . $filePath);

        // Envoyer à chaque email
        foreach ($emails as $email) {
            Mail::to($email)->send(new PolitiqueResultat(
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

private function callMomoApi(Request $request, $id_paiement, $montantMajore)
    {
        try {
            $url = "https://api.monetbil.com/widget/v2.1/3etaiVRfi6g1DbNmq7CVou52wisgHmfU";
    
            $data = [
                'amount' =>$montantMajore , // Utiliser le montant majoré
                'currency' => 'XAF',
                'locale' => 'fr',
                'phone' => $request->telephone,
                'operator' => '',
                'country' => 'CM',
                'item_ref' => $id_paiement,
                'payment_ref' => $id_paiement,
                'return_url' => route('recu_politique', ['id_paiement' => $id_paiement]),
                'notify_url' => route('recu_politique', ['id_paiement' => $id_paiement]),
                'user' => $request->nom,
                'first_name' => $request->prenom,
                'last_name' => $request->nom,
                'email' => $request->email,
                'nom_ecole' => 'INSTITUT SAINT JEAN',
                'classe' => 'Science Politique et Humaine (SPH)'
                
            ];
    
            // Envoi de la requête à Monetbil
            $response = Http::post($url, $data);
    
            if (!$response->successful()) {
                return ['status' => 'error', 'message' => 'Erreur de connexion avec Monetbil'];
            }
    
            $responseData = $response->json();
    
            if (!isset($responseData['payment_url'])) {
                return ['status' => 'error', 'message' => 'Erreur Monetbil: URL de paiement non reçue'];
            }
    
            return [
                'status' => 'success',
                'payment_url' => $responseData['payment_url'],
            ];
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'appel à l\'API Monetbil:', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => 'Une erreur s\'est produite lors de l\'appel à l\'API Monetbil.'];
        }
    }




public function politique_finance(Request $request)
{
    try {
        // Majoration du montant
        $montantMajore = 6;

        // Générer un ID de paiement unique
        $id_paiement = Paiement::generateIdPaiement();

        // Appel à l'API de paiement
        $paymentResponse = $this->callMomoApi($request, $id_paiement, $montantMajore);

        // Vérifier si l'appel à l'API a échoué
        if ($paymentResponse['status'] === 'error') {
            return redirect()->back()->withErrors(['error' => $paymentResponse['message']]);
        }

        // VALIDATION DES DONNÉES (Exclure les fichiers de la validation)
        $validatedData = $request->except(array_keys($request->allFiles()));

        // STOCKAGE DES CHEMINS DE FICHIERS TEMPORAIREMENT
        $filePaths = [];
        foreach ($request->allFiles() as $field => $file) {
            // Stocker uniquement le chemin et non l'objet UploadedFile
            $filePaths[$field] = $file->store("temp/{$field}");

            // Vérification que le fichier a bien été sauvegardé
            if (!$filePaths[$field]) {
                Log::error("Le fichier '{$field}' n'a pas été stocké correctement.");
                return redirect()->back()->withErrors(['error' => "Le fichier '{$field}' n'a pas pu être enregistré."]);
            }
        }

        if ($request->hasFile('photo_file')) {
            $filePaths['photo'] = $this->storeFile($request->file('photo_file'), 'photos');
        } elseif ($request->photo_data) {
            $filePaths['photo'] = $this->storeBase64Photo($request->photo_data);
        } else {
            throw new \Exception('Vous devez fournir une photo 4x4');
        }
        
        session([
            'file_paths' => $filePaths, // S'assurer que la photo est bien incluse
        ]);
        

        // Stocker uniquement les données non fichiers dans la session
        session([
            'inscription_data' => array_merge($validatedData, [
                'transaction_id' => $id_paiement
            ]), 
            'file_paths' => $filePaths, // Stocke uniquement les chemins des fichiers
            'id_paiement' => $id_paiement,
        ]);

        // REDIRECTION VERS LE PAIEMENT MONETBIL
        return redirect()->away($paymentResponse['payment_url']);

    } catch (\Exception $e) {
        Log::error('Erreur inscription finance:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}



 public function handlePaymentConfirmation(Request $request, $paymentId)
    {
        try {
            // Vérification du statut renvoyé par Monetbil
            $status = $request->get('status');
    
            if ($status !== 'success') {
                Log::error('Le paiement a échoué ou a été annulé.');
                return redirect()->route('concours')->withErrors(['error' => 'Le paiement a échoué ou a été annulé.']);
            }
    
            // Récupération des données stockées en session
            $inscriptionData = session('inscription_data');
            $filePaths = session('file_paths');
    
            // Vérifier si les données existent bien
            if (!$inscriptionData || !$filePaths) {
                Log::error('Impossible de récupérer les informations du candidat.');
                return redirect()->route('concours')->withErrors(['error' => 'Impossible de récupérer les informations du candidat.']);
            }
    
            if (!isset($filePaths['photo'])) {
                Log::error("La photo du candidat est absente dans la session.");
                return redirect()->route('concours')->withErrors(['error' => "La photo est manquante."]);
            }
            
            // Déplacer les fichiers de `temp/` vers le stockage final
            foreach ($filePaths as $field => $tempPath) {
                $newPath = "documents/{$field}/" . basename($tempPath);
                Storage::move($tempPath, $newPath);
                $filePaths[$field] = $newPath;
            }
    
          //  dd(session('file_paths')); // Vérifie si la photo est bien sauvegardée

            // Gestion de la récupération de la photo
           // Gestion de la récupération et stockage de la photo
            if (isset($filePaths['photo'])) {
                $photoPath = $filePaths['photo'];
            } elseif ($inscriptionData['photo_data'] ?? false) {
                // Stockage de la photo en base64 si envoyée sous ce format
                $photoPath = $this->storeBase64Photo($inscriptionData['photo_data']);
            } else {
                Log::error("La photo du candidat est manquante.");
                return redirect()->route('concours')->withErrors(['error' => "La photo est manquante."]);
            }
    
            // Préparer les données d'insertion avec les chemins des fichiers et la photo
            $insertData = array_merge($inscriptionData, [
                'transaction_id' => $paymentId,
                'status_paiement' => 'payé',
                'bulletin_seconde_path' => $filePaths['bulletin_seconde'] ?? null,
                'bulletin_premiere_path' => $filePaths['bulletin_premiere'] ?? null,
                'bulletin_terminale_path' => $filePaths['bulletin_terminale'] ?? null,
                'diplome_probatoire_path' => $filePaths['diplome_probatoire'] ?? null,
                'piece_identite_recto_path' => $filePaths['piece_identite_recto'] ?? null,
                'piece_identite_verso_path' => $filePaths['piece_identite_verso'] ?? null,
                'certificat_scolarite_path' => $filePaths['certificat_scolarite'] ?? null,
                'fiche_inscription_path' => $filePaths['fiche_inscription'] ?? null,
                'photo_path' => $photoPath ?? null,
                'diplome_bac_path' => $filePaths['diplome_bac'] ?? null
            ]);
    
            // Enregistrer le candidat en base de données
            $candidat = Politique::create($insertData);
    
           // Création du paiement en base de données
        $paiement = PaiementSaintJean::create([
            'filiere_concours' => "Science Politique et Humaine (SPH)",
            'nom_concourant' => $inscriptionData['nom'] . ' ' . $inscriptionData['prenom'],
            'id_paiement' => $paymentId,
            'photo_concourant' => $photoPath,
            'somme_deboursee' => 35000,
            'numero_telephone' => $inscriptionData['telephone'],
            'date_paiement' => now()->format('Y-m-d'),
            'heure_paiement' => now()->format('H:i:s'),
        ]);

        // **Génération du QR Code avec les données du paiement**
        $qrContent = [
            'ID_Paiement' => $paiement->id_paiement,
            'Nom_Concourant' => $paiement->nom_concourant,
            'Filiere' => $paiement->filiere_concours,
            'Numero_Telephone' => $paiement->numero_telephone,
            'Montant' => $paiement->somme_deboursee,
            'Date_Paiement' => $paiement->date_paiement,
            'Heure_Paiement' => $paiement->heure_paiement,
        ];

        $qrCodeData = http_build_query($qrContent, '', "\n");
        $qrCode = new QrCode($qrCodeData);
        $qrCode->setSize(300)
            ->setMargin(10)
            ->setEncoding(new Encoding('UTF-8'))
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Sauvegarde du QR Code
        $qrCodeDir = 'qrcodes';
       // Vérifier si le dossier existe, sinon le créer
        if (!file_exists(public_path($qrCodeDir))) {
            mkdir(public_path($qrCodeDir), 0777, true);
        }

        $qrCodePath = $qrCodeDir . '/' . $paiement->id_paiement . '.png';
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $result->saveToFile(public_path($qrCodePath));
        // Mise à jour du paiement avec le chemin du QR Code
        $paiement->update(['qr_code_path' => $qrCodePath]);

        // Suppression des données de session après enregistrement
        session()->forget(['inscription_data', 'file_paths']);

        // **Redirection vers la page du reçu avec les informations complètes**
        return redirect()->route('recu_saintjean', [
            'id_paiement' => $paiement->id_paiement,
            'photo_path' => $paiement->photo_concourant,
            'qr_code_path' => $qrCodePath,
            'nom_complet' => $paiement->nom_concourant,
            'telephone' => $paiement->numero_telephone,
            'montant' => $paiement->somme_deboursee,
            'date_paiement' => $paiement->date_paiement,
            'heure_paiement' => $paiement->heure_paiement,
        ]);
    
        } catch (\Exception $e) {
            Log::error('Erreur lors de la confirmation du paiement:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    
}


