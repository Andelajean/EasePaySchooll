<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    
        public function search(Request $request)
        {
            $query = $request->input('query');
            $students = Student::where('nom_complet', 'LIKE', "%$query%")->get();
    
            return response()->json($students);
        }
    //
}
