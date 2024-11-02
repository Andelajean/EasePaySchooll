<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ecole;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $onlineUsers = \DB::table('sessions')->where('last_activity', '>=', Carbon::now()->subMinutes(5))->count();
        $newRegistrations = User::whereDate('created_at', Carbon::today())->count();
        $totalVisits = \DB::table('visits')->count(); // Assuming you have a visits table
        $ecoles = Ecole::all();
        return view('admin.statistics.index', compact('totalUsers', 'onlineUsers', 'newRegistrations', 'totalVisits', 'ecoles'));
    }
    

    public function getData(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $totalUsers = User::count();
        $onlineUsers = \DB::table('sessions')->where('last_activity', '>=', Carbon::parse($date)->subMinutes(5))->count();
        $newRegistrations = User::whereDate('created_at', $date)->count();
        $totalVisits = \DB::table('visits')->whereDate('created_at', $date)->count(); // Assuming you have a visits table

        return response()->json([
            'totalUsers' => $totalUsers,
            'onlineUsers' => $onlineUsers,
            'newRegistrations' => $newRegistrations,
            'totalVisits' => $totalVisits
        ]);
    }
}
