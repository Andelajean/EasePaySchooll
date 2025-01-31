<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ecole;
use App\Models\Paiement;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $onlineUsers = \DB::table('sessions')->where('last_activity', '>=', Carbon::now()->subMinutes(5))->count();
        $newRegistrations = User::whereDate('created_at', Carbon::today())->count();
        $totalVisits = \DB::table('visits')->count(); // Assuming you have a visits table
        $ecoles = Ecole::all();
        $banques = Paiement::select('banque')->distinct()->get();

        // Récupérer le nombre total de paiements
        $totalPayments = Paiement::count();

        // Récupérer le nombre d'écoles inscrites
        $totalSchools = Ecole::count();

        // Récupérer le nombre de paiements par école
        $paymentsBySchool = Ecole::withCount('paiements')->get();

        // Récupérer les filtres
        $selectedDate = $request->input('date');
        $selectedEcole = $request->input('ecole');
        $selectedBanque = $request->input('banque');

        // Récupérer le nombre de paiements par école pour chaque jour
        $query = Paiement::selectRaw('ecoles.nom_ecole, paiements.id_ecole, DATE(paiements.created_at) as date, COUNT(*) as total, SUM(paiements.montant) as total_amount')
            ->join('ecoles', 'paiements.id_ecole', '=', 'ecoles.id')
            ->groupBy('paiements.id_ecole', 'date', 'ecoles.nom_ecole');

        if ($selectedDate) {
            $query->whereDate('paiements.created_at', $selectedDate);
        }

        if ($selectedEcole) {
            $query->where('paiements.id_ecole', $selectedEcole);
        }

        if ($selectedBanque) {
            $query->where('paiements.banque', $selectedBanque);
        }

        $dailyPaymentsBySchool = $query->get();

        return view('admin.statistics.index', compact('totalUsers', 'onlineUsers', 'newRegistrations', 'totalVisits', 'ecoles', 'banques', 'totalPayments', 'totalSchools', 'paymentsBySchool', 'dailyPaymentsBySchool', 'selectedDate', 'selectedEcole', 'selectedBanque'));
    }

    public function getBanquesByEcole($ecoleId)
    {
        $banques = Paiement::select('banque')->where('id_ecole', $ecoleId)->distinct()->get();
        return response()->json($banques);
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
