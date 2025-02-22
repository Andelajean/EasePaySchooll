<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function email_incription_ecole(){
<<<<<<< HEAD
        try{
        return view('Admin.email-inscription-ecole');}
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
=======
        return view('Admin.email-inscription-ecole');
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
    }
}
