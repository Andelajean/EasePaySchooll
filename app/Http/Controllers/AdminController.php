<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function email_incription_ecole(){
        return view('Admin.email-inscription-ecole');
    }
}
