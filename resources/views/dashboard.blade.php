<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Parent - EasePaySchool</title>
    <link href="/style/navbar.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #ffffff; /* Fond blanc */
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
            min-height: 100vh;
        }

        .background-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .floating-symbol {
            position: absolute;
            animation: float 6s ease-in-out infinite;
            opacity: 0.7;
        }

        /* Animation de flottaison */
        @keyframes float {
            0% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(-15px, 15px);
            }
            100% {
                transform: translate(0, 0);
            }
        }
    </style>
</head>
<body>
    <!-- SVG Animation -->
    <svg class="background-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
        <!-- Cercle -->
        <circle cx="10%" cy="20%" r="5%" class="floating-symbol" id="circle1"></circle>
        <!-- Carré -->
        <rect x="70%" y="10%" width="8%" height="8%" class="floating-symbol" id="rect1"></rect>
        <!-- Triangle -->
        <polygon points="50,90 55,80 45,80" class="floating-symbol" id="triangle1"></polygon>
        <!-- Ellipse -->
        <ellipse cx="30%" cy="70%" rx="10%" ry="5%" class="floating-symbol" id="ellipse1"></ellipse>
        <!-- Cercle supplémentaire -->
        <circle cx="80%" cy="50%" r="4%" class="floating-symbol" id="circle2"></circle>
    </svg>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('image/logofin.jpg') }}" alt="Logo" class="logo-img">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('/')) bg-primary text-white @endif" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('about')) bg-primary text-white @endif" href="{{ route('about') }}">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('paiement') || Request::is('paiement/primaire') || Request::is('paiement/universite')) bg-primary text-white @endif" href="{{ route('paiement') }}">Paiement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('ecole/contact/admin')) bg-primary text-white @endif" href="{{ route('ecole.contact.admin') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('help')) bg-primary text-white @endif" href="{{ route('help') }}">Aide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('logout')) bg-primary text-white @endif" 
                            href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Se déconnecter
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('register')) bg-primary text-white @endif" href="{{ route('register') }}">Créer Un Compte</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Historique de Paiement</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Paiement</th>
                        <th>Nom Complet</th>
                        <th>École</th>
                        <th>Montant</th>
                        <th>Date de Paiement</th>
                        <th>Heure de Paiement</th>
                        <th>Détails</th>
                        <th>Reçu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id_paiement }}</td>
                        <td>{{ $paiement->nom_complet }}</td>
                        <td>{{ $paiement->nom_ecole }}</td>
                        <td>{{ $paiement->montant }} FCFA</td>
                        <td>{{ $paiement->date_paiement }}</td>
                        <td>{{ $paiement->heure_paiement }}</td>
                        <td>{{ $paiement->details }}</td>
                        <td>
                            <a href="{{ route('verifier.paiement', ['id_paiement' => $paiement->id_paiement]) }}" class="btn btn-success">
                                <i class="material-icons">file_download</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Fonction pour générer des couleurs aléatoires
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Appliquer des couleurs aléatoires à chaque figure
        function applyRandomColors() {
            const shapes = document.querySelectorAll('.floating-symbol');
            shapes.forEach(shape => {
                shape.style.fill = getRandomColor();
            });
        }

        // Changer les couleurs toutes les 2 secondes
        setInterval(applyRandomColors, 2000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
