<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Child;
use App\Models\Paiement;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
     $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'children_names' => ['required', 'array'],
        'children_names.*' => ['required', 'string']
    ]);

    // Cr  ez l'utilisateur
    $user = new User([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Sauvegardez l'utilisateur pour obtenir son ID
    $user->save();

    // Ajoutez les noms des enfants et associez-les au parent (utilisateur)
    $childrenNames = $request->children_names;
    foreach ($childrenNames as $childName) {
        Child::create([
            'user_id' => $user->id, // Associe l'enfant au parent
            'nom_complet' => $childName
        ]);
    }

    try {
    // Enregistrez la chaîne des noms des enfants dans l'utilisateur avec des guillemets
    $user->children_names = '"' . implode(', ', array_map('trim', $childrenNames)) . '"';
    $user->save();
} catch (\Exception $e) {
    // Gérer l'erreur de sauvegarde (journalisation, affichage d'un message d'erreur, etc.)
    \Log::error("Erreur de sauvegarde de l'utilisateur : " . $e->getMessage());
    throw new \Exception("Une erreur s'est produite lors de l'enregistrement des noms des enfants.");
}
    //  ^iv  nement d'inscription
    event(new Registered($user));

    // Connexion de l'utilisateur
    Auth::login($user);

    // Redirection vers le tableau de bord
return redirect()->route('dashboard');
}

    /**
     * Show the user's dashboard with children payments.
     */
    public function showDashboard(): View
    {
        $parent = Auth::user();

        // Récupérez les enfants du parent
        $children = Child::where('user_id', $parent->id)->get();

        // Récupérez les paiements de chaque enfant
        $paiements = Paiement::whereIn('nom_complet', $children->pluck('nom_complet'))->get();

        return view('dashboard', compact('paiements'));
    }
}

