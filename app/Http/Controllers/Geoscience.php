<?php

namespace App\Http\Controllers;

use App\Mail\GeoscienceMail;
use App\Mail\GeoscienceResultat;
use App\Models\Paiement;
use App\Models\PaiementSaintJean;
use App\Models\Geoscience as ModelsGeoscience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
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
    
   public function geoscience_finance(Request $request)
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


    private function callMomoApi(Request $request, $id_paiement, $montantMajore)
    {
        try {
         //   $url = "https://api.monetbil.com/widget/v2.1/3etaiVRfi6g1DbNmq7CVou52wisgHmfU";
             $url = "https://api.monetbil.com/widget/v2.1/W72TUlOJsXADleZCnz4b5NtQ6Y8JkaEN";
            $data = [
                'amount' =>$montantMajore , // Utiliser le montant majoré
                'currency' => 'XAF',
                'locale' => 'fr',
                'phone' => $request->telephone,
                'operator' => '',
                'country' => 'CM',
                'item_ref' => $id_paiement,
                'payment_ref' => $id_paiement,
                'return_url' => route('recu_geoscience', ['id_paiement' => $id_paiement]),
                'notify_url' => route('recu_geoscience', ['id_paiement' => $id_paiement]),
                'user' => $request->nom,
                'first_name' => $request->prenom,
                'last_name' => $request->nom,
                'email' => 'client@example.com',
                'nom_ecole' => 'INSTITUT SAINT JEAN',
                'classe' => 'Geoscience, Environnement et Agro Industrie (IGEA)'
                
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
            $candidat = ModelsGeoscience::create($insertData);
    
           // Création du paiement en base de données
        $paiement = PaiementSaintJean::create([
            'filiere_concours' => 'Geoscience, Environnement et Agro Industrie (IGEA)',
            'nom_concourant' => $inscriptionData['nom'] . ' ' . $inscriptionData['prenom'],
            'id_paiement' => $paymentId,
            'photo_concourant' => $photoPath,
            'somme_deboursee' => 25000,
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
    
    
    
    /*public function geoscience_finance(Request $request){
       try {
            // Vérification du mode de paiement choisi
            $modePaiement = $request->mode_paiement; // Récupérer le mode choisi (carte ou téléphone)
    
            // Validation des données
            $validator = Validator::make($request->all(), $this->validationRules($request));
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            // Récupérer la classe depuis la base de données
            $classeData = Classe::where('nom_classe', $request->classe)->first();
    
            if (!$classeData) {  
                throw new \Exception('Classe introuvable.');
            }
    
            // Récupérer le montant correspondant à la tranche
            $details = $request->details;
            $montantInitial = $classeData->$details;
    
            if (!$montantInitial) {
                throw new \Exception('Détail de paiement invalide.');
            }
    
            // Majorer le montant de 1,5%
            $montantMajore = $montantInitial * 1.013;
    
            // Générer un ID de paiement unique
            $id_paiement = Paiement::generateIdPaiement();
    
            // Stocker les données dans la session
          
        // Stocker les données en session
        session([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'sexe' => $validatedData['sexe'],
            'date_naissance' => $validatedData['date_naissance'],
            'lieu_naissance' => $validatedData['lieu_naissance'],
            'nationalite' => $validatedData['nationalite'],
            'region_origine' => $validatedData['region_origine'],
            'adresse' => $validatedData['adresse'],
            'telephone' => $validatedData['telephone'],
            'email' => $validatedData['email'],
            'titulaire_bac' => $validatedData['titulaire_bac'],
            'bulletin_seconde' => $validatedData['bulletin_seconde']->store('bulletins'),
            'bulletin_premiere' => $validatedData['bulletin_premiere']->store('bulletins'),
            'bulletin_terminale' => $validatedData['bulletin_terminale']->store('bulletins'),
            'diplome_probatoire' => $validatedData['diplome_probatoire']->store('diplomes'),
            'piece_identite_recto' => $validatedData['piece_identite_recto']->store('identites'),
            'piece_identite_verso' => $validatedData['piece_identite_verso']->store('identites'),
            'fiche_inscription' => $validatedData['fiche_inscription']->store('inscriptions'),
            'photo_path' => $validatedData['photo_file']->store('photos'),
            'montant_initial' => 25000,
            'montant_majore' => 25000, // Aucun frais supplémentaire ici
        ]);
        
            // Vérifier le mode de paiement et appeler l'API appropriée
            if ($modePaiement === "telephone") {
                // Paiement via Monetbil
                $paymentResponse = $this->callMomoApi($request, $id_paiement, $montantMajore);
            } elseif ($modePaiement === "carte") {
                // Paiement via Stripe
                $paymentResponse = $this->callStripeApi($request,$id_paiement, $montantMajore);
            } else {
                throw new \Exception("Mode de paiement invalide.");
            }
    
            // Vérifier si l'appel à l'API a échoué
            if ($paymentResponse['status'] === 'error') {
                return redirect()->back()->withErrors(['error' => $paymentResponse['message']]);
            }
    
            // Rediriger l'utilisateur vers l'URL de paiement
            return redirect()->away($paymentResponse['payment_url']);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'initiation du paiement:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Une erreur s\'est produite lors de l\'initiation du paiement.']);
        }


    }*/
}
