<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    //


    public function index(){

         $ecoles=Ecole::all();

         return view('dashboard-admin', compact('ecoles'));

    }
}
