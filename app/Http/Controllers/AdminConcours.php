<?php

namespace App\Http\Controllers;

use App\Models\Administration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class AdminConcours extends Controller
{

    public function inscription(){
        return view('Concours.Auth.inscription');
    }
    public function processForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:administrations,telephone',
            'email' => 'required|email|unique:administrations,email',
            'identifiant' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ], [
            'identifiant.confirmed' => 'Les mots de passe ne correspondent pas.',
            'identifiant.regex' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Administration::create([
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'identifiant' => Hash::make($request->identifiant),
        ]);

        return redirect()->route('admin_concours.index')
            ->with('success', 'Inscription réussie! Vous pouvez maintenant vous connecter.');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'identifiant' => 'required',
    ]);

    $admin = Administration::where('email', $credentials['email'])->first();

    if (!$admin) {
        return back()->withErrors([
            'email' => 'Email incorrect',
        ])->onlyInput('email');
    }

    if (Hash::check($credentials['identifiant'], $admin->identifiant)) {
        Session::put('admin',  $admin);

        return redirect()->intended(route('admin_concours.index'))
               ->with('success', 'Connexion réussie!');
    }

    return back()->withErrors([
        'identifiant' => 'Mot de passe incorrect',
    ])->onlyInput('email');
}
    public function showLoginForm(){
        return view('Concours.Auth.connexion');
    }

    public function logout(Request $request)
    { try{
        // Supprimer les données de l'école de la session
        Session::forget('admin');
    
        // Invalider la session actuelle
        $request->session()->invalidate();
    
        // Régénérer le token de session pour sécurité
        $request->session()->regenerateToken();
    
        // Rediriger vers la page de connexion avec un message de déconnexion réussie
        return redirect()->route('admin.login')->with('success', 'Déconnexion réussie!');
    }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    
    } 
    public function index() {
        // Récupération des counts
        $managementCount = DB::table('management_finances')->count();
        $geosciencesCount = DB::table('geosciences')->count();
        $politiquesCount = DB::table('politiques')->count();
        $generalistesCount = DB::table('generalistes')->count();
        $civilsCount = DB::table('civils')->count();
    
        // Calcul des totaux
        $managementTotal = $managementCount * 35000;
        $geosciencesTotal = $geosciencesCount * 25000;
        $politiquesTotal = $politiquesCount * 25000;
        $generalistesTotal = $generalistesCount * 25000;
        $civilsTotal = $civilsCount * 25000;
    
        // Données pour le graphique
        $chartData = [
            'labels' => ['Management & Finances', 'Géosciences', 'Politiques', 'Généralistes', 'Civils'],
            'counts' => [$managementCount, $geosciencesCount, $politiquesCount, $generalistesCount, $civilsCount],
            'totals' => [$managementTotal, $geosciencesTotal, $politiquesTotal, $generalistesTotal, $civilsTotal]
        ];
    
        return view('Concours.Admin.index', compact(
            'managementCount',
            'geosciencesCount',
            'politiquesCount',
            'generalistesCount',
            'civilsCount',
            'managementTotal',
            'geosciencesTotal',
            'politiquesTotal',
            'generalistesTotal',
            'civilsTotal',
            'chartData'
        ));
    }
    public function finance(Request $request)
    {
        // Tri par défaut (date décroissante)
        $query = DB::table('management_finances')->orderBy('created_at', 'asc');
        
        // Si on veut le tri alphabétique
        if ($request->has('alphabetical')) {
            $query->orderBy('nom')->orderBy('prenom');
        }
    
        $candidates = $query->paginate(25);
    
        return view('Concours.Admin.finance', compact('candidates'));
    }
    
    
}
