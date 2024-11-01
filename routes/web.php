<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
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
    return view('welcome');
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
        return view('admin.requetesql.sqlrequest',compact('ecoles'));
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
Route::get('/search-school', [EcoleController::class, 'searchSchool']);
Route::get('/school/{id}', [EcoleController::class, 'getSchoolDetails']);
Route::post('/payement',[PaiementController::class,'payer'])->name('payer');
Route::get('/recu-paiement',[PageController::class,'recu'])->name('recu');
Route::get('/telecharger-recu/{id_paiement}', [PageController::class, 'telechargerRecu'])->name('telecharger_recu');
Route::get('/verifier-paiement', [PageController::class, 'verifierPaiement'])->name('verifier.paiement');

