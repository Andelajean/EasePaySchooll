<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Parent - EasePaySchool</title>
    <link href="/style/navbar.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
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
                    @csrf
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
                            <a href="{{ route('download.receipt', ['id' => $paiement->id]) }}" class="btn btn-success">
                                <i class="material-icons">file_download</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
