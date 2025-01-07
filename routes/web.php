<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEcoleController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UniformeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdmineController;
use App\Http\Controllers\Admin\EcolesController;
use App\Http\Controllers\Admin\BanquesController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\SidebarController;
use App\Http\Controllers\Admin\PaiementsController;
use App\Http\Controllers\Admin\SqlController;
use App\Http\Controllers\Admin\StatisticsController;

use App\Models\Ecole;
use App\Models\Role;

use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('Page.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

///***DASHBOARD ADMIN***///
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard-admin', [SidebarController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard-admin');;
});

 //** GESTION ECOLE ADMIN **//
 Route::group(['prefix' => 'ecole'], function () {
    
    Route::get('/addEcole',[EcolesController::class,'addEcole'])->name("add.Ecole");
    Route::get('/showAll',[EcolesController::class,'showAllEcole'])->name("show.all.Ecole");
    Route::post('/saveEcole',[EcolesController::class,'save'])->name('save');
    Route::get('/edit/{id}',[EcolesController::class,'editEcole'])->name('editEcole');
    Route::post('/update',[EcolesController::class,'updateEcole'])->name('update.ecole');
    Route::get('/delete/{id}',[EcolesController::class,'deleteEcole'])->name('deleteEcole');       
});

 //** GESTION BANQUE ADMIN **//
 Route::group(['prefix' => 'bank'], function () {
    
    Route::get('/addBanque',[BanquesController::class,'addBank'])->name('add.bank');
    Route::get('/showAll',[BanquesController::class,'showAllBank'])->name('show.all.bank');
    Route::post('/saveBank',[BanquesController::class,'saveBank'])->name('save.bank');
    Route::get('edit/{id}',[BanquesController::class,'editBank'])->name('edit.bank');
    Route::get('delete/{id}',[BanquesController::class,'deleteBank'])->name('delete.bank');
    Route::post('update',[BanquesController::class,'updateBank'])->name('update.bank'); 
});

 //** GESTION DES REQUESTES ADMIN **//
 Route::post('/execute-sql', [SqlController::class, 'execute']);
 Route::get('/request', function () {
        $ecoles=Ecole::all();
        return view('Admin.requetesql.sqlrequest',compact('ecoles'));
    })->middleware(['auth', 'verified'])->name('sql');

 //** GESTION DES STATISTIQUES ADMIN **//
 Route::get('/statistics', [StatisticsController::class, 'index'])->middleware(['auth', 'verified'])->name('statistics.index');
 Route::get('/statistics/data', [StatisticsController::class, 'getData']);
  

 //** GESTIONS DES PAIEMENTS ADMIN **//
 Route::group(['prefix' => 'paiement'], function(){
   
    Route::get('/showAll/{id}', [PaiementsController::class,'showAllPaiement'])->name('show.paiement.parEcole');
    Route::get('/showAllPaiement',[EcolesController::class,'showAllPaiement'])->name("show.all.paiement");

});

///*** CONTACTS ***///
Route::group(['prefix' => 'contact'], function () {
    Route::get('/showAll',[ContactsController::class,'showAllContact'])->name("show.all.Contact");
});

Route::post('/send-email', function (Illuminate\Http\Request $request) {
    $details = [
        'title' => 'Email de l\'administrateur',
        'body' => $request->message
    ];

    Mail::to($request->email)->send(new UserNotification($details));

    return response()->json(['message' => 'Email sent successfully']);
});
require __DIR__.'/auth.php';
Route::get('/ecole/contactadmin',[ContactsController::class,'ecolecontactadmin'])->name("ecole.contact.admin");
Route::post('/contact',[ContactsController::class,'contactadmin'])->name("contact.admin");
Route::post('/response',[ContactsController::class,'contactecole'])->name("request.contact");
Route::post('/contacts/{id}/mark-as-read', [ContactsController::class, 'markAsRead'])->name('contacts.markAsRead');
Route::get('/contacts/messages', [ContactsController::class, 'getMessages'])->name('contacts.getMessages');
Route::post('/contacts/send-reply', [ContactsController::class, 'sendReply'])->name('contacts.sendReply');


Route::get('/ecole/compte',[EcoleController::class,'compte'])->name('ecole.compte');
Route::post('/traitement_compte_ecole',[EcoleController::class,'traitement_compte'])->name('compte.traitement');
Route::get('/email/inscription/ecole',[EcoleController::class,'email_inscription_ecole'])->name('ecole.email.inscription');
Route::get('/email/admin/inscription/ecole',[AdminController::class,'email_incription_ecole'])->name('admin.emial.inscription.ecole');
Route::get('/paiement',[PaiementController::class,'formulaire_paiement'])->name('paiement');
Route::get('/paiement/primaire',[PaiementController::class,'primaire'])->name('primaire');
Route::get('/paiement/universite',[PaiementController::class,'universite'])->name('universite');
Route::get('/search-school', [EcoleController::class, 'searchSchool']);
Route::get('/school/{id}', [EcoleController::class, 'getSchoolDetails']);
Route::post('/payement',[PaiementController::class,'payer'])->name('payer');
Route::get('/recu-paiement',[PageController::class,'recu'])->name('recu');
Route::get('/telecharger-recu/{id_paiement}', [PageController::class, 'telechargerRecu'])->name('telecharger_recu');
Route::get('/verifier-paiement', [PageController::class, 'verifierPaiement'])->name('verifier.paiement');
Route::get('/login/ecole',[EcoleController::class,'login'])->name('login.ecole');
Route::post('/login-ecole', [AdminEcoleController::class, 'login'])->name('login-ecole');

Route::get('/help',[PageController::class,'help'])->name('help');
Route::get('/about',[PageController::class,'about'])->name('about');
Route::get('/index',[PageController::class,'index'])->name('index');

Route::get('/ecole/compte/classe/primaire_secondaire/{id}', [EcoleController::class, 'classe_primaire'])->name('classe.primaire');
Route::get('/ecole/compte/classe/universite/{id}', [EcoleController::class, 'classe_univ'])->name('classe.univ');
Route::post('/ecole/compte/classe/traitement/{id}', [EcoleController::class, 'traitement_classe'])->name('traitement.classe');

Route::middleware(['auth.ecole'])->group(function () {
    Route::get('ecole/dashboard', [AdminEcoleController::class, 'dashboard'])->name('dashboard_ecole');

    Route::get('ecole/dashboard/profil', [AdminEcoleController::class, 'profil'])->name('profil');

    Route::get('/paiement/ecole/classe', [AdminEcoleController::class, 'classe'])->name('classe');
    Route::get('/paiement/ecole/tranche', [AdminEcoleController::class, 'tranche'])->name('tranche');
    Route::get('/paiement/ecole/niveau', [AdminEcoleController::class, 'niveau'])->name('niveau');
    Route::get('/paiement/ecole/filiere', [AdminEcoleController::class, 'filiere'])->name('filiere');
    Route::get('/paiement/ecole/banque', [AdminEcoleController::class, 'banque'])->name('banque');
    Route::get('/paiement/ecole/tout', [AdminEcoleController::class, 'tout'])->name('tout');  
    Route::get('/materiel/ecole/recu',[MaterielController::class,'recus'])->name('recus');
    Route::get('/materiel/ecole/reception',[MaterielController::class,'reception'])->name('reception');
    Route::post('/reception/materiel', [MaterielController::class, 'receptionMateriel'])->name('reception.materiel');
    Route::post('/materiel/update/{id}', [MaterielController::class, 'updateMateriel'])->name('materiel.update');
    Route::get('/materiel/update', [MaterielController::class, 'update_mat'])->name('update');
    Route::get('/uniforme/ecole/distribuer',[UniformeController::class,'distribuer'])->name('distribuer');
    Route::get('/uniforme/ecole/distribution',[UniformeController::class,'distribution'])->name('distribution');
    Route::post('/distribution/uniforme', [UniformeController::class, 'distribution_uniforme'])->name('distribution.uniforme');
    Route::post('/materiel/update/{id}', [UniformeController::class, 'update_uniforme'])->name('uniforme.update');
    Route::get('/materiel/update', [UniformeController::class, 'update_unif'])->name('updateu');
    Route::get('ecole/logout', [AdminEcoleController::class, 'logout'])->name('logoute');
    Route::get('/paiement/ecole/classe_tranche', [AdminEcoleController::class, 'classe_tranche'])->name('classe_tranche');
    Route::get('/paiement/ecole/filiere_classe', [AdminEcoleController::class, 'filiere_classe'])->name('classe_filiere');
    Route::get('/paiement/ecole/banque_classe', [AdminEcoleController::class, 'banque_classe'])->name('banque_classe');

    Route::get('uniforme/fac/distribuer/polo',[DistributionController::class,'polo'])->name('fac.distribuer_polo');
    Route::get('uniforme/fac/distribuer/badges',[DistributionController::class,'badge'])->name('fac.distribuer_badge');
    Route::get('uniforme/fac/reception/polo',[DistributionController::class,'polo_recu'])->name('fac.polo');
    Route::get('uniforme/fac/reception/badges',[DistributionController::class,'badge_recu'])->name('fac.badge');
    Route::post('/distribution/distribuer/{id_paiement}', [DistributionController::class, 'distribuer_polo'])->name('polo.distribuer');
    Route::post('/distribution/badge/{id_paiement}', [DistributionController::class, 'distribuer_badge'])->name('badge.distribuer');

    Route::get('/search-student/polo', [DistributionController::class, 'search_polo'])->name('search-student.polo');
    Route::get('/student-details/polo/{id}', [DistributionController::class, 'show_polo']);
    Route::get('/search-student/badge', [DistributionController::class, 'search_badge'])->name('search-student.badge');
    Route::get('/student-details/badge/{id}', [DistributionController::class, 'show_badge']);

    Route::get('/search-student/paiement', [AdminEcoleController::class, 'search_paiement'])->name('search-student');
Route::get('/student-details/paiement/{nom_complet}', [AdminEcoleController::class, 'show_paiement']);
});

