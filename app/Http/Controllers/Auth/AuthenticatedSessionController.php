<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // Authentifie l'utilisateur avec les informations fournies dans la requête
    $request->authenticate();

    // Régénère l'ID de session pour éviter les attaques de fixation de session
    $request->session()->regenerate();

    // Récupère l'utilisateur authentifié
    $user = auth()->user();

    // Récupère les messages de la table contacts
    $messages = \App\Models\Contact::where('lue', false)->latest()->get();
    $ecoles=\App\Models\Ecole::all();

    // Redirige en fonction du rôle de l'utilisateur
    switch ($user->role) {
        case 1:
            // Rôle 1 (admin)
            return redirect()->intended(route('dashboard-admin'))->with(['messages'=>$messages,'ecoles'=>$ecoles]);
        case 2:
            // Rôle 2 (école)
            return redirect()->intended(route('dashboard-ecole'));
        default:
            // Tous les autres rôles
            return redirect()->intended(route('dashboard'));
    }
}

    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
