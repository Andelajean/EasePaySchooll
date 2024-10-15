<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // Pour générer un ID de paiement
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class PaiementController extends Controller
{
    public function formulaire_paiement()
    {
        return view('Paiement.paiement');
    }

    public function payer(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom_ecole' => 'required|string',
            'telephone' => 'required|string',
            'ville' => 'required|string',
            'banque' => 'required|string',
            'nom_complet' => 'required|string',
            'classe' => 'required|string',
            'niveau' => 'required|string',
            'filiere' => 'required_if:niveau,université|string',
            'niveau_universite' => 'required_if:niveau,université|string',
            'montant' => 'required|numeric',
            'details' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Effectuer le paiement via l'API MOMO
        $paymentResponse = $this->callMomoApi($request);

        // Vérifier le statut du paiement
        if ($paymentResponse['status'] == 'success') {
            // Enregistrer le paiement dans la base de données
            $paiement = Paiement::create([
                'nom_ecole' => $request->nom_ecole,
                'telephone' => $request->telephone,
                'ville' => $request->ville,
                'banque' => $request->banque,
                'nom_complet' => $request->nom_complet,
                'classe' => $request->classe,
                'niveau' => $request->niveau,
                'filiere' => $request->filiere,
                'niveau_universite' => $request->niveau_universite,
                'montant' => $request->montant,
                'details' => $request->details,
                'qr_code' => $paymentResponse['qr_code'], // Enregistrer le QR code
                'id_paiement' => $this->generateIdPaiement(), // Générer un ID de paiement
            ]);

            // Retourner la vue de reçu avec toutes les informations de paiement
            return $this->returnPaymentView($paiement, $request);
        }

        return response()->json(['message' => 'Échec du paiement, veuillez réessayer.'], 500);
    }

    private function callMomoApi(Request $request)
    {
        // Simulation de paiement
        $url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/bc-authorize";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Request headers
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cache-Control: no-cache',
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Request body
        $request_body = 'login_hint=ID:{msisdn}/MSISDN&scope={scope}&access_type={online/offline}';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

        $resp = curl_exec($curl);
        curl_close($curl);

        // Simuler le succès du paiement pour cet exemple
        $success = true; // Changez cela en fonction de votre logique

        if ($success) {
            // Générer un ID de paiement unique
            $id_paiement = strtoupper(bin2hex(random_bytes(5))); // 11 caractères alphanumériques

            // Générer le QR Code
            $qrCode = new QrCode('ID Paiement: ' . $id_paiement . ', Montant: ' . $request->montant);
            $qrCode->setSize(300)
                ->setMargin(10)
                ->setEncoding(new Encoding('UTF-8'))
                //->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)) // Vérifiez que cela fonctionne
                ->setForegroundColor(new Color(0, 0, 0)) // Couleur noire
                ->setBackgroundColor(new Color(0, 0, 255)); // Couleur bleue

            // Écrire le QR Code en tant qu'image PNG
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            
            // Sauvegarder le QR Code dans le dossier public
            $qrCodePath = public_path('qrcodes/' . $id_paiement . '.png');
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

    private function generateIdPaiement()
    {
        // Générer un ID de paiement aléatoire de 11 caractères alphanumériques
        return strtoupper(Str::random(11));
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
        ]);
    }
}
