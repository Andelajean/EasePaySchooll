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
        <li><a href="/">Accueil</a></li>
        <li><a href="#">Apropos</a></li>
        <li><a href="{{route('paiement')}}">Paiement</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="{{route('help')}}">Aide</a></li>
    </ul>
    <div class="search-bar">
        <form id="searchForm" action="{{ route('verifier.paiement') }}" method="GET">
            <input type="text" name="id_paiement" id="id_paiement" placeholder="Entrez le ID du paiement..." required>
            <button type="submit">Vérifier</button>
        </form>
        <div class="hover-text">Entrez le ID du paiement pour le vérifier</div>
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
