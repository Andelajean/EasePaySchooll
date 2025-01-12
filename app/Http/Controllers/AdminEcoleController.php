<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Paiement;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;

class AdminEcoleController extends Controller
{
    public function login(Request $request)
<<<<<<< HEAD
{  try{
=======
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}

public function logout(Request $request)
{ try{
=======

public function logout(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
    // Supprimer les données de l'école de la session
    Session::forget('ecole');

    // Invalider la session actuelle
    $request->session()->invalidate();

    // Régénérer le token de session pour sécurité
    $request->session()->regenerateToken();

    // Rediriger vers la page de connexion avec un message de déconnexion réussie
    return redirect()->route('login.ecole')->with('success', 'Déconnexion réussie!');
<<<<<<< HEAD
}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }

} 
 public function profil(){
    try{
    $ecole = Session::get('ecole');
    if ($ecole) {
        $compte = Ecole::where('id', $ecole->id)->first();
        $classe = Classe::where('id_ecole', $ecole->id)->get();
        return view('Ecole.profil', compact('compte', 'classe'));
    }
    return redirect()->route('login.ecole');}
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
    
=======

} 
 public function profil(){
    $infosecole = Ecole::all();
    $ecoleclass= Classe::all();
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
 }

public function dashboard(Request $request)
{
<<<<<<< HEAD
    try{
=======
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
    // Récupérer l'école connectée depuis la session
    $ecole = Session::get('ecole');

    if ($ecole) {
        $nomEcole = $ecole->nom_ecole;

        // Données générales
        $nombrePaiementsAujourdhui = Paiement::where('nom_ecole', $nomEcole)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $nombrePaiementsHier = Paiement::where('nom_ecole', $nomEcole)
            ->whereDate('created_at', Carbon::yesterday())
            ->count();

        $totalNombrePaiements = Paiement::where('nom_ecole', $nomEcole)->count();

        $montantAujourdhui = Paiement::where('nom_ecole', $nomEcole)
            ->whereDate('created_at', Carbon::today())
            ->sum('montant');

        $montantHier = Paiement::where('nom_ecole', $nomEcole)
            ->whereDate('created_at', Carbon::yesterday())
            ->sum('montant');

        $montantTotal = Paiement::where('nom_ecole', $nomEcole)->sum('montant');

        // Récupérer les classes de l'école
        $classes = Classe::where('id_ecole', $ecole->id)->get();

        // Gestion de la classe choisie
        $classeChoisie = $request->input('classe');
        $paiementsParClasse = null;

        if ($classeChoisie) {
            // Paiements de la classe choisie
            $paiements = Paiement::where('nom_ecole', $nomEcole)
                ->where('classe', $classeChoisie)
                ->get();

            $paiementsParTranche = [
                'premiere_tranche' => $paiements->where('details', 'premiere_tranche')->sum('montant'),
                'deuxieme_tranche' => $paiements->where('details', 'deuxieme_tranche')->sum('montant'),
                'troisieme_tranche' => $paiements->where('details', 'troisieme_tranche')->sum('montant'),
                'quatrieme_tranche' => $paiements->where('details', 'quatrieme_tranche')->sum('montant'),
                'cinquieme_tranche' => $paiements->where('details', 'cinquieme_tranche')->sum('montant'),
                'sixieme_tranche' => $paiements->where('details', 'sixieme_tranche')->sum('montant'),
                'septieme_tranche' => $paiements->where('details', 'septieme_tranche')->sum('montant'),
                'huitieme_tranche' => $paiements->where('details', 'huitieme_tranche')->sum('montant'),
                'totalite' => $paiements->where('details', 'toatlite')->sum('montant'),
                // Ajoutez d'autres tranches si nécessaire
            ];

            $paiementsParClasse = [
                'classe' => $classeChoisie,
                'paiements_par_tranche' => $paiementsParTranche,
                'montant_total_classe' => $paiements->sum('montant'),
                'nombre_paiements_classe' => $paiements->count(),
            ];
        }

        // Paiements d'aujourd'hui
        $paiementsAujourdhui = Paiement::where('nom_ecole', $nomEcole)
            ->whereDate('created_at', Carbon::today())
            ->get();
              
          if($ecole->niveau==='universite'){
            // Retourner les données à la vue
        return view('AdminEcole.dashboard', [
            'nombrePaiementsAujourdhui' => $nombrePaiementsAujourdhui,
            'nombrePaiementsHier' => $nombrePaiementsHier,
            'totalNombrePaiements' => $totalNombrePaiements,
            'montantAujourdhui' => $montantAujourdhui,
            'montantHier' => $montantHier,
            'montantTotal' => $montantTotal,
            'classes' => $classes,
            'paiementsParClasse' => $paiementsParClasse,
            'paiementsAujourdhui' => $paiementsAujourdhui,
        ]);
          }

        // Retourner les données à la vue
        return view('Primaire.dashboard_primaire', [
            'nombrePaiementsAujourdhui' => $nombrePaiementsAujourdhui,
            'nombrePaiementsHier' => $nombrePaiementsHier,
            'totalNombrePaiements' => $totalNombrePaiements,
            'montantAujourdhui' => $montantAujourdhui,
            'montantHier' => $montantHier,
            'montantTotal' => $montantTotal,
            'classes' => $classes,
            'paiementsParClasse' => $paiementsParClasse,
            'paiementsAujourdhui' => $paiementsAujourdhui,
        ]);
    }

    // Rediriger vers la page de connexion si l'école n'est pas connectée
    return redirect()->route('login.ecole');
}
<<<<<<< HEAD
catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}
=======
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053



public function classe(Request $request)
<<<<<<< HEAD
{ try{
=======
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
  catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}

public function banque(Request $request)
{ try{
=======

public function banque(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
  catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}


public function niveau(Request $request)
{ try{
=======


public function niveau(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
      ->pluck('niveau_universite');

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
<<<<<<< HEAD
catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}

public function filiere(Request $request)
{  try{
=======

public function filiere(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}
public function tout(Request $request)
{ try{
=======
public function tout(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
    catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}

public function tranche(Request $request)
{ try{
=======

public function tranche(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
}
  catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
   
}
public function banque_classe(Request $request)
{ try{
=======
   
}
public function banque_classe(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
  catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}

public function classe_tranche(Request $request)
{
    try {
=======

public function classe_tranche(Request $request)
{
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
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
<<<<<<< HEAD
catch (\Exception $e) {
    return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
}

public function filiere_classe(Request $request)
{
    try {
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

        $banque = DB::table('paiements')
            ->select('filiere')
            ->where('nom_ecole', $ecole->nom_ecole)
            ->distinct()
            ->get()
            ->pluck('filiere');

        // Classe (banque) sélectionnée
        $classeSelectionnee = $request->query('classe', $classes->first());
        $banqueSelectionnee = $request->query('banque', $banque->first());
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
                ->paginate(50); // Paginer les résultats par 50
        }

        // Retourner la vue avec les données
        return view('AdminEcole.classe_filiere', compact('banque', 'classes', 'paiementsAujourdhui', 'paiementsHier', 'paiementsTotal', 'classeSelectionnee', 'banqueSelectionnee'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}

public function search_paiement(Request $request)
{
    try {
        // Vérifier si l'école est bien présente dans la session
        $ecole = Session::get('ecole');
        if (!$ecole) {
            return redirect()->route('login.ecole')->with('error', 'Vous devez être connecté à une école.');
        }

        // Récupération du paramètre de recherche
        $query = $request->input('query');

        // Recherche des élèves dont le nom contient le texte recherché
        $students = Paiement::where('nom_ecole', $ecole->nom_ecole)
            ->where('nom_complet', 'LIKE', '%' . $query . '%')
            ->get(['id_paiement', 'nom_complet']);

        // Retour des résultats sous forme de JSON
        return response()->json($students);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
    }
}

public function show_paiement($nom_complet)
{
    try {
        // Rechercher les paiements associés au nom complet
        $students = Paiement::where('nom_complet', $nom_complet)->get();

        // Vérifier si des enregistrements existent
        if ($students->isEmpty()) {
            return response()->json(['error' => 'Élève non trouvé'], 404);
        }

        // Retourner tous les détails des paiements pour cet élève
        return response()->json($students);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
    }
=======


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
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
}

}
