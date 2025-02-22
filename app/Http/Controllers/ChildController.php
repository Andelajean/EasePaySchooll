<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use Illuminate\Support\Facades\Storage;

class ChildController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $children = Paiement::where('nom_complet', 'LIKE', "%{$query}%")->get(['nom_complet']);
        return response()->json($children);
    }

   
    
    public function downloadReceipt($id)
    {
        $paiement = Paiement::findOrFail($id);
        $filePath = public_path("qrcode/{$paiement->id_paiement}.png");

        if (file_exists($filePath)) {
            $headers = [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $paiement->id_paiement . '.png"',
            ];

            return response()->download($filePath, $paiement->id_paiement . '.png', $headers);
        } else {
            return redirect()->back()->with('error', 'Reçu introuvable.');
        }
    }
    
}
