<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;

class AdminEcoleController extends Controller
{
    public function login(Request $request)
{
    // Valider les données du formulaire
    $request->validate([
        'email' => 'required|email',
        'identifiant' => 'required',
    ]);
    // Rechercher l'école par email
    $ecole = Ecole::where('email', $request->email)->first();
    // Si l'école est trouvée et que l'`identifiant` correspond (non crypté)
    if ($ecole && $request->identifiant == $ecole->identifiant) {
        // Stocker les informations de l'école dans la session
        Session::put('ecole', $ecole);

        // Rediriger vers le tableau de bord avec les données de l'école
        return redirect()->route('dashboard_ecole')->with('success', 'Connexion réussie!');
    }
    // Si l'authentification échoue
    return back()->withErrors([
        'email' => 'Les informations de connexion sont incorrectes.',
    ])->withInput();
}

public function logout(Request $request)
{
    // Supprimer les données de l'école de la session
    Session::forget('ecole');

    // Invalider la session actuelle
    $request->session()->invalidate();

    // Régénérer le token de session pour sécurité
    $request->session()->regenerateToken();

    // Rediriger vers la page de connexion avec un message de déconnexion réussie
    return redirect()->route('home')->with('success', 'Déconnexion réussie!');

}

public function dashboard() {
    // Récupérer l'école connectée depuis la session
    $ecole = Session::get('ecole');

    // Si l'école est connectée
    if ($ecole) {
        // Vérifier si le niveau de l'école est "université"
        if ($ecole->niveau === 'universite') {
            // Récupérer le nombre de paiements de l'école connectée
            $nombrePaiementsAujourdhui = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->whereDate('created_at', Carbon::today())
                ->count(); // Nombre de paiements d'aujourd'hui

            $nombrePaiementsHier = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->whereDate('created_at', Carbon::yesterday())
                ->count(); // Nombre de paiements d'hier

            $totalNombrePaiements = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->count(); // Total des paiements de l'école

            // Récupérer tous les paiements d'aujourd'hui
            $paiementsAujourdhui = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->whereDate('created_at', Carbon::today())
                ->get();

            // Passer les données à la vue
            return view('AdminEcole.dashboard', [
                'nombrePaiementsAujourdhui' => $nombrePaiementsAujourdhui,
                'nombrePaiementsHier' => $nombrePaiementsHier,
                'totalNombrePaiements' => $totalNombrePaiements,
                'paiementsAujourdhui' => $paiementsAujourdhui, // Paiements à afficher dans le tableau
            ]);
        } else {
            // Si le niveau de l'école n'est pas "université", rediriger vers une autre vue avec les mêmes données
            $nombrePaiementsAujourdhui = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->whereDate('created_at', Carbon::today())
                ->count(); // Nombre de paiements d'aujourd'hui

            $nombrePaiementsHier = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->whereDate('created_at', Carbon::yesterday())
                ->count(); // Nombre de paiements d'hier

            $totalNombrePaiements = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->count(); // Total des paiements de l'école

            $paiementsAujourdhui = Paiement::where('nom_ecole', $ecole->nom_ecole)
                ->whereDate('created_at', Carbon::today())
                ->get();

            // Rediriger vers une autre vue (par exemple 'AdminEcole.niveaux_inferieurs') avec les mêmes informations
            return view('Primaire.dashboard_primaire', [
                'nombrePaiementsAujourdhui' => $nombrePaiementsAujourdhui,
                'nombrePaiementsHier' => $nombrePaiementsHier,
                'totalNombrePaiements' => $totalNombrePaiements,
                'paiementsAujourdhui' => $paiementsAujourdhui, // Paiements à afficher dans le tableau
            ]);
        }
    }

    // Rediriger vers la page de connexion si l'école n'est pas connectée
    return redirect()->route('login.ecole');
}

public function classe(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('classe')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('classe');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('classe', $classeSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  $banque = $classes;
  // Retourner la vue avec les données
  if ($ecole->niveau === 'universite') {
      return view('AdminEcole.classe', compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
  } else {
      return view('Primaire.classe', compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
  }
}

public function banque(Request $request)
{
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

    // Récupérer toutes les classes distinctes (banques) associées à cette école
    $classes = DB::table('paiements')
        ->select('banque')
        ->where('nom_ecole', $ecole->nom_ecole)
        ->distinct()
        ->get()
        ->pluck('banque');

    // Classe (banque) sélectionnée
    $classeSelectionnee = $request->query('classe', $classes->first());
    $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    // Paiements pour aujourd'hui
    $paiementsAujourdhui = DB::table('paiements')
        ->where('banque', $classeSelectionnee)
        ->where('nom_ecole', $ecole->nom_ecole)
        ->where('created_at', '>=', $today)
        ->paginate(50);

    // Paiements pour hier
    $paiementsHier = DB::table('paiements')
        ->where('banque', $classeSelectionnee)
        ->where('nom_ecole', $ecole->nom_ecole)
        ->whereBetween('created_at', [$yesterday, $today])
        ->paginate(50);

    // Total des paiements (sans prendre en compte la date)
    $paiementsTotal = DB::table('paiements')
        ->where('banque', $classeSelectionnee)
        ->where('nom_ecole', $ecole->nom_ecole)
        ->paginate(50); // Ici on récupère le nombre total de paiements

    // Si une date est sélectionnée, récupérer les paiements pour cette date
    if ($dateSelectionnee) {
        $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
        $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

        $paiementsAujourdhui = DB::table('paiements')
            ->where('banque', $classeSelectionnee)
            ->where('nom_ecole', $ecole->nom_ecole)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->paginate(50);  // Paginer les résultats par 50
    }

    $banque = $classes;
  // Retourner la vue avec les données
  if ($ecole->niveau === 'universite') {
      return view('AdminEcole.banque', compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
  } else {
      return view('Primaire.banque', compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
  }
}


public function niveau(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('niveau')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('niveau');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('niveau', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('niveau', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('niveau', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('niveau', $classeSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  $banque = $classes;

    return view('AdminEcole.niveau', compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
}

public function filiere(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('filiere')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('filiere');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('filiere', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('filiere', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('filiere', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('filiere', $classeSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  $banque = $classes;

    return view('AdminEcole.filiere',compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
}
public function tout(Request $request)
{
    // Récupérer l'école actuellement connectée
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

    // Date sélectionnée par l'utilisateur
    $dateSelectionnee = $request->input('date');

    // Déterminer les périodes : aujourd'hui, hier, et total
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    // Paiements du jour (avec pagination)
    $paiementsAujourdhui = DB::table('paiements')
        ->where('nom_ecole', $ecole->nom_ecole)
        ->where('created_at', '>=', $today)
        ->paginate(50);  // Pagination sur 50 paiements par page

    // Paiements d'hier (sans pagination pour les totaux, juste pour l'affichage)
    $paiementsHier = DB::table('paiements')
        ->where('nom_ecole', $ecole->nom_ecole)
        ->whereBetween('created_at', [$yesterday, $today])
        ->get();

    // Paiements totaux (sans pagination pour les totaux)
    $paiementsTotal = DB::table('paiements')
        ->where('nom_ecole', $ecole->nom_ecole)
        ->get();

    // Si une date est sélectionnée, on récupère les paiements pour cette date
    if ($dateSelectionnee) {
        $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
        $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

        $paiementsAujourdhui = DB::table('paiements')
            ->where('nom_ecole', $ecole->nom_ecole)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->paginate(50);  // Pagination sur 50 paiements par page
    }

    // Retourner la vue avec les paiements et les totaux
   // return view('AdminEcole.paiements', compact('paiementsAujourdhui', 'paiementsHier', 'paiementsTotal'));
    $banque =  $dateSelectionnee;
    // Retourner la vue avec les données
    if ($ecole->niveau === 'universite') {
        return view('AdminEcole.tout', compact('banque','paiementsAujourdhui', 'paiementsHier', 'paiementsTotal'));
    } else {
        return view('Primaire.tout', compact('banque','paiementsAujourdhui', 'paiementsHier', 'paiementsTotal'));
    }
}

public function tranche(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('details')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('details');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('details', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('details', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('details', $classeSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('details', $classeSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  $banque = $classes;
  if ($ecole->niveau === 'universite'){
    return view('AdminEcole.tranche',compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
  }
  else{
    return view('Primaire.tranche',compact('banque','classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee'));
  }
   
}
public function banque_classe(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('classe')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('classe');

      $banque= DB::table('paiements')
      ->select('banque')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('banque');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $banqueSelectionnee = $request->query('banque', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('banque', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('banque', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('banque', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('classe', $classeSelectionnee)
          ->where('banque', $banqueSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  
  // Retourner la vue avec les données
  if ($ecole->niveau === 'universite') {
    return view('AdminEcole.classe_banque', compact('banque', 'classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee', 'banqueSelectionnee'));

  }
  else{
    return view('Primaire.banque_classe', compact('banque', 'classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee', 'banqueSelectionnee'));

  }
}

public function classe_tranche(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('classe')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('classe');

      $banque= DB::table('paiements')
      ->select('details')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('details');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $banqueSelectionnee = $request->query('banque', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('details', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('details', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('details', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('classe', $classeSelectionnee)
          ->where('details', $banqueSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  
  // Retourner la vue avec les données
  if ($ecole->niveau === 'universite'){
    return view('AdminEcole.classe_tranche', compact('banque', 'classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee', 'banqueSelectionnee'));

  }
 else{
    return view('Primaire.classe_tranche', compact('banque', 'classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee', 'banqueSelectionnee'));

 }
}


public function filiere_classe(Request $request)
{
    // Vérifier si l'école est bien présente dans la session
    $ecole = Session::get('ecole');
    if (!$ecole) {
        return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
    }

      // Récupérer toutes les classes distinctes (banques) associées à cette école
      $classes = DB::table('paiements')
      ->select('classe')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('classe');

      $banque= DB::table('paiements')
      ->select('filiere')
      ->where('nom_ecole', $ecole->nom_ecole)
      ->distinct()
      ->get()
      ->pluck('filiere');

  // Classe (banque) sélectionnée
  $classeSelectionnee = $request->query('classe', $classes->first());
  $banqueSelectionnee = $request->query('banque', $classes->first());
  $dateSelectionnee = $request->input('date'); // Récupère la date sélectionnée
  $today = Carbon::today();
  $yesterday = Carbon::yesterday();

  // Paiements pour aujourd'hui
  $paiementsAujourdhui = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('filiere', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->where('created_at', '>=', $today)
      ->paginate(50);

  // Paiements pour hier
  $paiementsHier = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('filiere', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->whereBetween('created_at', [$yesterday, $today])
      ->paginate(50);

  // Total des paiements (sans prendre en compte la date)
  $paiementsTotal = DB::table('paiements')
      ->where('classe', $classeSelectionnee)
      ->where('filiere', $banqueSelectionnee)
      ->where('nom_ecole', $ecole->nom_ecole)
      ->paginate(50); // Ici on récupère le nombre total de paiements

  // Si une date est sélectionnée, récupérer les paiements pour cette date
  if ($dateSelectionnee) {
      $startOfDay = Carbon::parse($dateSelectionnee)->startOfDay();
      $endOfDay = Carbon::parse($dateSelectionnee)->endOfDay();

      $paiementsAujourdhui = DB::table('paiements')
          ->where('classe', $classeSelectionnee)
          ->where('filiere', $banqueSelectionnee)
          ->where('nom_ecole', $ecole->nom_ecole)
          ->whereBetween('created_at', [$startOfDay, $endOfDay])
          ->paginate(50);  // Paginer les résultats par 50
  }
  
  // Retourner la vue avec les données
  
  return view('AdminEcole.classe_filiere', compact('banque', 'classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee', 'banqueSelectionnee'));

}
public function search_paiement(Request $request)
{

     // Vérifier si l'école est bien présente dans la session
     $ecole = Session::get('ecole');
     if (!$ecole) {
         return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
     }
    // Récupération du paramètre de recherche
    $query = $request->input('query');

    // Recherche des élèves dont le nom contient le texte recherché
    $students = Paiement::  where('nom_ecole', $ecole->nom_ecole)
                      -> where('nom_complet', 'LIKE', '%' . $query . '%')->get(['id_paiement', 'nom_complet']);

    // Retour des résultats sous forme de JSON
    return response()->json($students);
}

// Méthode pour récupérer les détails d'un élève spécifique
public function show_paiement($nom_complet)
{
    // Rechercher les paiements associés au nom complet
    $students = Paiement::where('nom_complet', $nom_complet)->get();

    // Vérifier si des enregistrements existent
    if ($students->isEmpty()) {
        return response()->json(['error' => 'Élève non trouvé'], 404);
    }

    // Retourner tous les détails des paiements pour cet élève
    return response()->json($students);
}

}
