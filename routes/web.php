<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
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

