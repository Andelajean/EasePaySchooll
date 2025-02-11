<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Parent - EasePaySchool</title>
    <link href="/style/navbar.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/2hb6Y1yXenZo5i4V4IMW4ZdwDFkFci6gA5pj0V" crossorigin="anonymous">
</head>
<style>
        .navbar {
        background-color: #ffffff;
        border-bottom: 1px solid #e5e5e5;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar .logo-img {
        width: 150px;
    }

    .nav-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 1rem;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .nav-links a:hover {
        background-color: #f0f0f0;
    }

    .nav-links a.bg-primary {
        background-color: #007bff;
        color: #ffffff;
    }

    .search-bar {
        display: flex;
        gap: 0.5rem;
    }

    .search-bar input {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .search-bar button {
        padding: 0.5rem 1rem;
        border: none;
        background-color: #007bff;
        color: #ffffff;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-bar button:hover {
        background-color: #0056b3;
    }

    .burger {
        display: none;
        flex-direction: column;
        gap: 0.25rem;
        cursor: pointer;
    }

    .burger .line {
        width: 25px;
        height: 3px;
        background-color: #333;
    }

    @media (max-width: 768px) {
        .nav-links {
            display: none;
            flex-direction: column;
            gap: 0;
        }

        .nav-links a {
            width: 100%;
            text-align: center;
            padding: 1rem 0;
        }

        .burger {
            display: flex;
        }
    }
</style>
<body>
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
                        <a class="nav-link @if(Request::is('login')) bg-primary text-white @endif" href="{{ route('login') }}">Se Connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('register')) bg-primary text-white @endif" href="{{ route('register') }}">Créer Un Compte</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Historique de Paiement</h1>
        <div class="row mb-4">
            <div class="col-md-6">
                <form id="searchForm" action="{{ route('historique.paiement') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="nom_complet" id="nom_complet" class="form-control" placeholder="Entrez le nom complet de l'enfant..." required>
                        <button class="btn btn-primary" type="submit">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybP7ab1UVa+glY6eLr6lzUHQSc5RxP4lzKO5R5ETa2xmH/Zm1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GnYDZKTXOtbuROfMrDhHgvQTcOVCRi5L6dOKYVGztPGLMCR69VRvxZT89kMO" crossorigin="anonymous"></script>
</body>
</html>
