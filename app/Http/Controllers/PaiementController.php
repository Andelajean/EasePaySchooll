<?php

namespace App\Http\Controllers;
use App\Models\Paiement;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use App\Models\Classe;
use Illuminate\Support\Facades\Log;

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
    try {
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
        session([
            'nom_ecole' => $request->nom_ecole,
            'classe' => $request->classe,
            'details' => $request->details,
            'nom_complet' => $request->nom_complet,
            'telephone' => $request->telephone,
            'ville' => $request->ville,
            'banque' => $request->banque,
            'niveau' => $request->niveau,
            'filiere' => $request->filiere,
            'niveau_universite' => $request->niveau_universite,
            'montant_initial' => $montantInitial, // Montant sans majoration
            'montant_majore' => $montantMajore, // Montant avec majoration
        ]);

        // Effectuer le paiement via l'API Monetbil
        $paymentResponse = $this->callMomoApi($request, $id_paiement, $montantMajore);

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
        if ($request->has('phone')) {
            $rules['phone'] = 'required|string';
            
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
    
    private function createPaiementRecord(Request $request, $qrCode, $id_paiement, $id_ecole)
{
    try {
        // Récupérer les données depuis la session
        $nom_ecole = session('nom_ecole');
        $classe = session('classe');
        $details = session('details');
        $nom_complet = session('nom_complet');
        $telephone = session('telephone');
        $ville = session('ville');
        $banque = session('banque');
        $niveau = session('niveau');
        $filiere = session('filiere');
        $niveau_universite = session('niveau_universite');
        $montantInitial = session('montant_initial'); // Montant sans majoration

        // Préparer les données du paiement
        $paiementData = [
            'nom_ecole' => $nom_ecole,
            'telephone' => $telephone,
            'ville' => $ville,
            'banque' => $banque,
            'nom_complet' => $nom_complet,
            'niveau' => $niveau,
            'filiere' => $filiere,
            'niveau_universite' => $niveau_universite,
            'classe' => $classe,
            'details' => $details,
            'montant' => $montantInitial, // Utiliser le montant initial
            'date_paiement' => now()->format('Y-m-d'),
            'heure_paiement' => now()->format('H:i:s'),
            'qr_code' => $qrCode,
            'id_paiement' => $id_paiement,
            'id_ecole' => $id_ecole,
        ];

        // Créer et retourner le paiement
        return Paiement::create($paiementData);
    } catch (\Exception $e) {
        Log::error('Erreur lors de l\'enregistrement du paiement:', ['error' => $e->getMessage()]);
        throw $e; // Relancer l'exception pour une gestion centralisée
    }
}
    private function callMomoApi(Request $request, $id_paiement, $montantMajore)
    {
        try {
            $url = "https://api.monetbil.com/widget/v2.1/3etaiVRfi6g1DbNmq7CVou52wisgHmfU";
    
            $data = [
                'amount' => '6', // Utiliser le montant majoré
                'currency' => 'XAF',
                'locale' => 'fr',
                'phone' => $request->phone,
                'operator' => '',
                'country' => 'CM',
                'item_ref' => $id_paiement,
                'payment_ref' => $id_paiement,
                'return_url' => route('verifier_recu', ['id_paiement' => $id_paiement]),
                'notify_url' => route('verifier_recu', ['id_paiement' => $id_paiement]),
                'user' => $request->nom_complet,
                'first_name' => explode(' ', $request->nom_complet)[0] ?? '',
                'last_name' => explode(' ', $request->nom_complet)[1] ?? '',
                'email' => 'client@example.com',
                'nom_ecole' => $request->nom_ecole,
                'classe' => $request->classe,
                'details' => $request->details,
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
    private function checkPaymentStatus($paymentId)
    {
        // URL de l'API Monetbil pour vérifier le statut du paiement
        $url = 'https://api.monetbil.com/payment/v1/checkPayment';
    
        // Données à envoyer à l'API
        $data = [
            'paymentId' => $paymentId,
        ];
    
        // Envoyer la requête à l'API Monetbil
        $response = Http::post($url, $data);
    
        // Journaliser la réponse complète de l'API
        Log::info('Réponse de l\'API Monetbil:', [
            'status' => $response->status(),
            'headers' => $response->headers(),
            'body' => $response->body(),
        ]);
    
        // Vérifier si la requête a réussi
        if (!$response->successful()) {
            Log::error('Erreur lors de la vérification du statut du paiement', ['status' => $response->status()]);
            return null; // Retourner null en cas d'erreur
        }
    
        // Décoder la réponse JSON
        $responseData = $response->json();
    
        // Vérifier si la réponse contient la clé 'transaction'
        if (!isset($responseData['transaction'])) {
            Log::error('La réponse de l\'API ne contient pas de clé "transaction".', ['response' => $responseData]);
            return null;
        }
    
        // Récupérer le statut de la transaction
        $status = $responseData['transaction']['status'];
    
        // Interpréter le statut
        switch ($status) {
            case 1:
                return 'success'; // Paiement réussi
            case -1:
                return 'cancelled'; // Transaction annulée
            default:
                return 'failed'; // Paiement échoué
        }
    }
    public function handlePaymentConfirmation(Request $request, $paymentId)
{
    try {
        // Vérifiez les paramètres renvoyés par Monetbil
            $status = $request->get('status');
            $transactionId = $request->get('transaction_id');

            if ($status === 'success') {
                // Paiement réussi
                Log::warning('La réponse de l\'API Monetbil est invalide. Le paiement sera enregistré dans la base de données.');
            } else {
                // Paiement échoué ou annulé
               // return redirect()->back()->with('error', 'Le paiement a échoué ou a été annulé.');
               throw new \Exception('Le paiement a échoué ou a été annulé.');
            }

        // Vérifier le statut du paiement auprès de l'API Monetbil
       // $paymentStatus = $this->checkPaymentStatus($paymentId);

        // Si le statut est null (API ne retourne pas de réponse valide), enregistrer le paiement
       /* if ($paymentStatus === null) {
            Log::warning('La réponse de l\'API Monetbil est invalide. Le paiement sera enregistré dans la base de données.');
        }else{
           
           throw new \Exception('Le paiement a échoué ou a été annulé.');
        }*/
      /*  else($paymentStatus === 'failed' || $paymentStatus === 'cancelled') {
            throw new \Exception('Le paiement a échoué ou a été annulé.');
        }*/

       

        // Récupérer les données depuis la session
        $nom_ecole = session('nom_ecole');
        $classe = session('classe');
        $details = session('details');
        $nom_complet = session('nom_complet');
        $telephone = session('telephone');
        $ville = session('ville');
        $banque = session('banque');
        $niveau = session('niveau');
        $filiere = session('filiere');
        $niveau_universite = session('niveau_universite');
        $montantInitial = session('montant_initial'); // Montant sans majoration

        // Vérifier si les données requises sont présentes
        if (!$nom_ecole || !$classe || !$details || !$montantInitial) {
            throw new \Exception('Données manquantes dans la session.');
        }

        // Récupérer l'école
        $ecole = Ecole::where('nom_ecole', $nom_ecole)->first();

        if (!$ecole) {
            throw new \Exception('École non trouvée.');
        }

        $id_ecole = $ecole->id;

        // Générer le QR code
        $qrContent = [
            'ID_Paiement' => $paymentId,
            'Nom_Ecole' => $nom_ecole,
            'Nom_Complet' => $nom_complet,
            'Telephone' => $telephone,
            'Ville' => $ville,
            'Banque' => $banque,
            'Classe' => $classe,
            'Niveau' => $niveau,
            'Filiere' => $filiere,
            'Niveau_Universite' => $niveau_universite,
            'Montant' => $montantInitial, // Utiliser le montant initial pour le reçu
            'Details' => $details,
            'date_paiement' => now()->format('Y-m-d'),
            'heure_paiement' => now()->format('H:i:s'),
        ];

        $qrCodeData = http_build_query($qrContent, '', "\n");

        $qrCode = new QrCode($qrCodeData);
        $qrCode->setSize(300)
            ->setMargin(10)
            ->setEncoding(new Encoding('UTF-8'))
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $qrCodeDir = public_path('qrcodes');
        if (!file_exists($qrCodeDir)) {
            mkdir($qrCodeDir, 0777, true);
        }

        $qrCodePath = $qrCodeDir . '/' . $paymentId . '.png';
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $result->saveToFile($qrCodePath);

        // Enregistrer le paiement dans la base de données
        $paiement = $this->createPaiementRecord($request, $paymentId . '.png', $paymentId, $id_ecole);

        // Rediriger vers la page du reçu
        return redirect()->route('recu', ['id_paiement' => $paiement->id_paiement]);
    } catch (\Exception $e) {
        Log::error('Erreur lors de la confirmation du paiement:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}

public function historiquePaiement(Request $request)
    {
        $nom_complet = $request->input('nom_complet');
        $paiements = Paiement::where('nom_complet', 'like', '%' . $nom_complet . '%')->get();

        return view('historique_paiement', compact('paiements'));
    }
}
