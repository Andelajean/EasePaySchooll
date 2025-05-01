<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RoomAssignment;

class RoomController extends Controller
{
    public function assignRooms(Request $request)
    {
        $request->validate([
            'students_per_room' => 'required|integer|min:1'
        ]);
    
        $candidates = DB::table('management_finances')
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
    
            DB::table('management_finances')
              ->where('id', $candidate->id)
              ->update([
                  'exam_room' => 'Salle ' . $roomNumber,
                  'exam_seat' => $seatCounter
              ]);
        }
    
        return back()->with('success', 'Salles attribuées avec succès!');
    }
    
    public function printRooms()
    {
        $candidates = DB::table('management_finances')
                      ->orderBy('exam_room')
                      ->orderBy('exam_seat')
                      ->get()
                      ->groupBy('exam_room');
        
        return view('Concours.Admin.liste_finance', compact('candidates'));
    }
    
    public function shareRooms()
    {
        $candidates = DB::table('management_finances')->get();
        
        foreach ($candidates as $candidate) {
            if ($candidate->email) {
                Mail::to($candidate->email)
                    ->send(new RoomAssignment($candidate));
            }
        }
        
        return response()->json(['success' => true]);
    }
   
    public function showAttribution(Request $request)
    {
        // Tri par défaut (date décroissante)
        $query = DB::table('management_finances')->orderBy('created_at', 'desc');
        
        // Si on veut le tri alphabétique
        if ($request->has('alphabetical')) {
            $query->orderBy('nom')->orderBy('prenom');
        }
    
        $candidates = $query->paginate(25);
    
        return view('Concours.Admin.salle', compact('candidates'));
    }
}