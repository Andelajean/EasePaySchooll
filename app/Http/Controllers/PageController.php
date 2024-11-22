<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF; 

class PageController extends Controller
{
    public function recu(){
        return view('Page.recu');
    }

    public function about(){
        return view('Page.about');
    }
    public function telechargerRecu($id_paiement)
    {
        // Récupérer les détails du paiement en fonction de l'ID
        $paiement = Paiement::where('id_paiement', $id_paiement)->firstOrFail();

        // Passer les données à la vue
        $data = [
            'id_paiement' => $paiement->id_paiement,
            'nom_ecole' => $paiement->nom_ecole,
            'nom_complet' => $paiement->nom_complet,
            'montant' => $paiement->montant,
            'details' => $paiement->details,
            'telephone' => $paiement->telephone,
            'ville' => $paiement->ville,
            'banque' => $paiement->banque,
            'classe' => $paiement->classe,
            'niveau' => $paiement->niveau,
            'filiere' => $paiement->filiere,
            'niveau_universite' => $paiement->niveau_universite,
            'qr_code' => $paiement->qr_code,
            'date_paiement' => $paiement->date_paiement,
            'heure_paiement' => $paiement->heure_paiement,
        ];

       // Charger la vue Blade pour le reçu
    $pdf = PDF::loadView('Page.recu_pdf', $data);

    // Retourner le PDF en téléchargement
    return $pdf->download('recu_'.$id_paiement.'.pdf');
    }
    public function verifierPaiement(Request $request)
    {
       // $idPaiement = $request->input('id_paiement');
        
        // Recherche le paiement avec l'ID
        //$paiement = Paiement::find($idPaiement);
        $paiement =  Paiement::where('id_paiement', $request->input('id_paiement'))->first();
        
        // Vérifiez si le paiement existe et passez les données à la vue
        if ($paiement) {
            return view('Page.recu', [
                'nom_ecole' => $paiement->nom_ecole,
                'ville' => $paiement->ville,
                'telephone' => $paiement->telephone,
                'id_paiement' => $paiement->id_paiement,
                'nom_complet' => $paiement->nom_complet,
                'montant' => $paiement->montant,
                'details' => $paiement->details,
                'banque' => $paiement->banque,
                'classe' => $paiement->classe,
                'niveau' => $paiement->niveau,
                'filiere' => $paiement->filiere,
                'date_paiement' => $paiement->date_paiement,
                'heure_paiement' => $paiement->heure_paiement,
                'niveau_universite' => $paiement->niveau_universite,
                'qr_code' => $paiement->qr_code,
            ]);
        }
    
        return redirect()->back()->with('error', 'Paiement introuvable.');
    }
    
    public function help(){
        return view('Page.help');
    }
    public function index(){
        return view('Page.index');
    }
}
