<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav Bar</title>
    <link href="/style/navbar.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
    <div class="logo">
        <img src="{{ asset('image/logofin.jpg') }}" alt="Logo" class="logo-img">
    </div>
    <ul class="nav-links">
    <li>
        <a href="/" class="
            @if(Request::is('/')) bg-blue-500 text-white @endif p-2 rounded">
            Accueil
        </a>
    </li>
    <li>
        <a href="{{ route('about') }}" class="
            @if(Request::is('about')) bg-blue-500 text-white @endif p-2 rounded">
            À propos
        </a>
    </li>
    <li>
    <a href="{{ route('paiement') }}" class=" 
        @if(Request::is('paiement') || Request::is('paiement/primaire') || Request::is('paiement/universite')) 
            bg-blue-500 text-white 
        @endif p-2 rounded">
        Paiement
    </a>
</li>

    <li>
        <a href="{{ route('ecole.contact.admin') }}" class=" 
            @if(Request::is('ecole/contact/admin')) bg-blue-500 text-white @endif p-2 rounded">
            Contact
        </a>
    </li>
    <li>
        <a href="{{ route('help') }}" class=" 
            @if(Request::is('help')) bg-blue-500 text-white @endif p-2 rounded">
            Aide
        </a>
    </li>
    <li>
        <a href="{{ route('login') }}" class=" 
            @if(Request::is('login')) bg-blue-500 text-white @endif p-2 rounded">
            Se Connecter
        </a>
    </li>
    <li>
        <a href="{{ route('register') }}" class=" 
            @if(Request::is('register')) bg-blue-500 text-white @endif p-2 rounded">
            Créer Un Compte
        </a>
    </li>
</ul>

    <div class="search-bar">
        <form id="searchForm" action="{{ route('verifier.paiement') }}" method="GET">
            <input type="text" name="id_paiement" id="id_paiement" placeholder="Entrez le ID du paiement..." required>
            <button type="submit">Vérifier</button>
        </form>
        
    </div>
    <div class="burger" id="burger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</nav>
 <!-- Afficher le message d'erreur s'il existe -->
    @if(session('error'))
        <div id="error-message" style="color:red;">
            {{ session('error') }}
        </div>
    @endif
    <div id="error-message" style="color:red;"></div>
    <script src="/jscript/navbar.js"></script>
</body>
</html>