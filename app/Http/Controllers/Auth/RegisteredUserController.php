<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student; // Assurez-vous d'inclure le modèle Student
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    } 

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Ajoutez 'students' à la validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'students' => ['required', 'json'], // Validation pour le champ des étudiants
        ]);

        // Créez l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Ajoutez les étudiants
        $studentNames = json_decode($request->students); // Décoder le JSON des étudiants
        foreach ($studentNames as $studentName) {
            $user->students()->create(['nom_complet' => $studentName]); // Assurez-vous que la relation est bien définie
        }

        // Événement d'inscription
        event(new Registered($user));

        // Connexion de l'utilisateur
        Auth::login($user);

        // Redirection vers le tableau de bord
        return redirect(route('dashboard', absolute: false));
    }
}