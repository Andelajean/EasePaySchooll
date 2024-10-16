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
            <li><a href="#">Aide</a></li>
        </ul>
        <div class="search-bar">
            <input type="text" placeholder="Verifier un paiement...">
            <button>Vérifier</button>
        </div>
        <div class="burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </nav>
</body>
</html>
