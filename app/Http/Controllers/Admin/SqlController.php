<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlController extends Controller
{
   
    public function execute(Request $request)
    {
            try {
                $query = $request->input('query');
                if (!is_string($query)) {
                    throw new \Exception('Invalid query format');
                }
                $results = DB::select($query);
                return response()->json($results)->header('Content-Type', 'application/json');
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()])->header('Content-Type', 'application/json');
            }
    }

}