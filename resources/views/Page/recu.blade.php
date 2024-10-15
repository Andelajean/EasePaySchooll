<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Ajoutez votre CSS ici -->
    <style>
        .recu-container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .download-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .download-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="recu-container">
        <h1>Reçu de Paiement</h1>
        <div class="container">
    <h1 class="text-center">Reçu de Paiement</h1>
    <div class="text-center">
        <img src="{{ asset($qr_code) }}" alt="QR Code" class="mb-4">
        <h2>ID Paiement: {{ $id_paiement }}</h2>
        <p><strong>Nom de l'École:</strong> {{ $nom_ecole }}</p>
        <p><strong>Nom Complet:</strong> {{ $nom_complet }}</p>
        <p><strong>Montant:</strong> {{ $montant }} FCFA</p>
        <p><strong>Détails:</strong> {{ $details }}</p>
    </div>
    <div class="text-center mt-4">
        <a href="{{ asset($qr_code) }}" class="btn btn-primary" download>Télécharger le Reçu</a>
    </div>
</div>
</body>
</html>
