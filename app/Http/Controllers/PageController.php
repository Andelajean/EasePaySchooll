<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function recu(){
        return view('Page.recu');
    }
}
