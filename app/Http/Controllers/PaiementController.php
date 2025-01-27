<?php

namespace App\Http\Controllers;
use App\Models\Paiement;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use App\Models\Classe; 

class PaiementController extends Controller
{
    public function formulaire_paiement()
    {
        return view('Paiement.paiement');
    }
    public function primaire(){
        return view('Paiement.primaire');
    }
public function universite(){
    return view('Paiement.universite');
}
public function payer(Request $request)
{
    // Validation des données
    $validator = Validator::make($request->all(), $this->validationRules($request));

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Générer un ID de paiement unique
    $id_paiement = Paiement::generateIdPaiement();

    // Effectuer le paiement via l'API MOMO
    $paymentResponse = $this->callMomoApi($request, $id_paiement);
    $ecole = Ecole::where('nom_ecole', $request->nom_ecole)->first();
    $id_ecole = $ecole->id;

    // Vérifier le statut du paiement
    if ($paymentResponse['status'] === 'success') {
        // Enregistrer le paiement dans la base de données
        $paiement = $this->createPaiementRecord($request, $paymentResponse['qr_code'], $id_paiement, $id_ecole);

        // Rediriger vers la page du reçu
        return redirect()->route('recu', ['id_paiement' => $paiement->id_paiement]);
    }

    // Gestion des erreurs de paiement
   return redirect()->back()->withErrors('error','une erreur s\'est produite ');
}


    private function validationRules(Request $request)
    {
        $rules = [];
    
        if ($request->has('nom_ecole')) {
            $rules['nom_ecole'] = 'required|string';
        }

        if ($request->has('telephone')) {
            $rules['telephone'] = 'required|string';
            
        }
        if ($request->has('ville')) {
            $rules['ville'] = 'required|string';
        }
        if ($request->has('banque')) {
            $rules['banque'] = 'required|string';
        }
    
        if ($request->has('nom_complet')) {
            $rules['nom_complet'] = 'required|string';
        }
    
        if ($request->has('classe')) {
            $rules['classe'] = 'required|string';
        }
    
        if ($request->has('niveau')) {
            $rules['niveau'] = 'required|string';
    
            // Vérifier si le niveau est 'université'
            if ($request->input('niveau') === 'université') {
                $rules['filiere'] = 'required|string';
                $rules['niveau_universite'] = 'required|string';
            }
        }
    
        if ($request->has('date_paiement')) {
            $rules['date_paiement'] = 'required|string';
        }
    
        if ($request->has('heure_paiement')) {
            $rules['heure_paiement'] = 'required|string';
        }
    
        if ($request->has('montant')) {
            $rules['montant'] = 'required|numeric';
        }
    
        if ($request->has('details')) {
            $rules['details'] = 'required|string';
        }
    
        return $rules;
    }
    
    private function createPaiementRecord(Request $request, $qrCode, $id_paiement,$id_ecole)
    {
        $paiementData = [];
        // Vérification et ajout conditionnel des données de paiement
        if ($request->has('nom_ecole')) {
            $paiementData['nom_ecole'] = $request->nom_ecole;
        }
        if ($request->has('telephone')) {
            $paiementData['telephone'] = $request->telephone;
        }
        if ($request->has('ville')) {
            $paiementData['ville'] = $request->ville;
        }
        if ($request->has('banque')) {
            $paiementData['banque'] = $request->banque;
        }
        if ($request->has('nom_complet')) {
            $paiementData['nom_complet'] = $request->nom_complet;
        }
       
        if ($request->has('niveau')) {
            $paiementData['niveau'] = $request->niveau;
            // Si le niveau est 'université', ajouter les champs spécifiques à l'université
            if ($request->input('niveau') === 'universite') {
                if ($request->has('filiere')) {
                    $paiementData['filiere'] = $request->filiere;
                }
                if ($request->has('niveau_universite')) {
                    $paiementData['niveau_universite'] = $request->niveau_universite;
                }
            }
        }
      // Assurez-vous que le modèle Classe est importé

        // Vérifiez si 'classe' et 'details' sont présents dans la requête
        if ($request->has('classe') && $request->has('details')) {
            $classe = $request->classe;
            $details = $request->details;
        
            // Recherchez les informations de la classe dans la table 'classes'
            $classeData = Classe::where('nom_classe', $classe)->first();
        
            if ($classeData) {
                // Vérifiez si le détail correspond à une tranche valide
                $validDetails = [
                    'premiere_tranche',
                    'deuxieme_tranche',
                    'troisieme_tranche',
                    'quatrieme_tranche',
                    'cinquieme_tranche',
                    'sixieme_tranche',
                    'septieme_tranche',
                    'huitieme_tranche',
                    'totalite',
                ];
        
                if (!in_array($details, $validDetails)) {
                    // Retourner une erreur si le détail est invalide
                    return redirect()->back()->with('error' , 'Le détail fourni est invalide.');
                }
        
                // Définissez le montant en fonction du détail
                $paiementData['montant'] = $classeData->$details;
            } else {
                // Si la classe n'est pas trouvée, retourner une erreur
                return redirect()->back()->with(['error' => 'Classe introuvable.'], 404);
            }
        } else {
            // Si 'classe' ou 'details' manquent dans la requête
            return redirect()->back()->with(['error' => 'Les champs classe et details sont requis.'], 400);
        }
        
        // Traitez les autres champs comme d'habitude
        if ($request->has('classe')) {
            $paiementData['classe'] = $request->classe;
        }
        if ($request->has('details')) {
            $paiementData['details'] = $request->details;
        }
          
        if ($request->has('date_paiement')) {
            $paiementData['date_paiement'] = now();
        }
        if ($request->has('heure_paiement')) {
            $paiementData['heure_paiement'] = now()->format('H:i:s'); 
        }
        // Ajout du QR Code et de l'ID de paiement
        $paiementData['qr_code'] = $qrCode;
        $paiementData['id_paiement'] = $id_paiement; // Utilisation du même ID de paiement généré
        $paiementData['id_ecole']=$id_ecole;
        // Création du paiement avec les données collectées
        return Paiement::create($paiementData);  
    }

    private function callMomoApi(Request $request, $id_paiement)
    {
        // Simulation de paiement
        $url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/bc-authorize";
        $curl = curl_init($url);
    
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        // Request headers
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Cache-Control: no-cache',
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
        // Request body
        $request_body = 'login_hint=ID:{msisdn}/MSISDN&scope={scope}&access_type={online/offline}';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
    
        $resp = curl_exec($curl);
        curl_close($curl);
    
        // Simuler le succès du paiement pour cet exemple
        $success = true; // 
    
        if ($success) {
            // Créer le contenu du QR code avec tous les détails du paiement
            $qrContent = [
                'ID_Paiement' => $id_paiement,
                'Nom_Ecole' => $request->nom_ecole,
                'Nom_Complet' => $request->nom_complet,
                'Telephone' => $request->telephone,
                'Ville' => $request->ville,
                'Banque' => $request->banque,
                'Classe' => $request->classe,
                'Niveau' => $request->niveau,
                'Filiere' => $request->filiere,
                'Niveau_Universite' => $request->niveau_universite,
                'Montant' => $request->montant,
                'Details' => $request->details,
                'date_paiement' => $request->date_paiement,
                'heure_paiement' => $request->heure_paiement,
            ];
    
            // Convertir le contenu en chaîne formatée
            $qrCodeData = http_build_query($qrContent, '', "\n");
    
            $qrCode = new QrCode($qrCodeData);
            $qrCode->setSize(300)
                ->setMargin(10)
                ->setEncoding(new Encoding('UTF-8'))
                ->setForegroundColor(new Color(0, 0, 0)) // Couleur noire
                ->setBackgroundColor(new Color(255, 255, 255)); // Couleur bleue
    
            // Vérifier si le dossier pour les QR codes existe, sinon le créer
            $qrCodeDir = public_path('qrcodes');
            if (!file_exists($qrCodeDir)) {
                mkdir($qrCodeDir, 0777, true);
            }
    
            // Sauvegarder le QR Code dans le dossier public
            $qrCodePath = $qrCodeDir . '/' . $id_paiement . '.png';
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $result->saveToFile($qrCodePath);
    
            // Retourner la réponse du paiement
            return [
                'status' => 'success',
                'qr_code' => $id_paiement . '.png',
                'id_paiement' => $id_paiement,
            ];
        } else {
            // Gérer l'échec du paiement
            return ['status' => 'error'];
        }
    }
    

    private function returnPaymentView(Paiement $paiement, Request $request)
    {
        return view('Page.recu', [
            'id_paiement' => $paiement->id_paiement,
            'nom_ecole' => $paiement->nom_ecole,
            'nom_complet' => $paiement->nom_complet,
            'montant' => $request->montant,
            'details' => $paiement->details,
            'qr_code' => $paiement->qr_code, // QR Code généré pour le paiement
            'telephone' => $request->telephone,
            'ville' => $request->ville,
            'banque' => $request->banque,
            'classe' => $request->classe,
            'niveau' => $request->niveau,
            'filiere' => $request->filiere,
            'niveau_universite' => $request->niveau_universite,
            'date_paiement' => $request->date_paiement,
            'heure_paiement' => $request->heure_paiement,
        ]);
    }
}
