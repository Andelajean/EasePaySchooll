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

require __DIR__.'/auth.php';
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
Route::get('/login/ecole',[EcoleController::class,'login'])->name('login.ecole');
Route::post('/login-ecole', [AdminEcoleController::class, 'login'])->name('login-ecole');

Route::middleware(['auth.ecole'])->group(function () {
    Route::get('ecole/dashboard', [AdminEcoleController::class, 'dashboard'])->name('dashboard_ecole');
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

