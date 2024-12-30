<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ecole;
use App\Models\Contact;
class AdmineController extends Controller
{
    public function index()
    {
        $ecoles=Ecole::all();
        $messages = Contact::latest()->take(3)->get(); 
        return view('admin.dashboard',compact('ecoles','messages'));

    }




}
