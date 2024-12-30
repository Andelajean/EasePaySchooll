<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de paiement</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            font-family: Arial, sans-serif;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 18px;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        .section p {
            margin: 5px 0;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        .download-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 style="text-align: center;">Reçu de Paiement Des Frais de scolarité</h1>

        <!-- Première section : Informations de l'école -->
        <div class="section">
            <h2>Informations de l'école</h2>
            <p><strong>Nom de l'école :</strong> {{ $nom_ecole }}</p>
            <p><strong>Ville :</strong> {{ $ville }}</p>
            <p><strong>Téléphone :</strong> {{ $telephone }}</p>
        </div>

        <!-- Deuxième section : Détails du paiement -->
        <div class="section">
            <h2>Détails du paiement</h2>
            <p><strong>ID Paiement :</strong> {{ $id_paiement }}</p>
            <p><strong>Nom complet :</strong> {{ $nom_complet }}</p>
            <p><strong>Montant :</strong> {{ $montant }} FCFA</p>
            <p><strong>Détails :</strong> {{ $details }}</p>
            <p><strong>Banque :</strong> {{ $banque }}</p>
            <p><strong>Classe :</strong> {{ $classe }}</p>
            <p><strong>Niveau :</strong> {{ $niveau }}</p>
            <p><strong>Filière :</strong> {{ $filiere }}</p>
              <p><strong>Date Paiement :</strong> {{ $date_paiement }}</p>
            <p><strong>Heure Paiement:</strong> {{ $heure_paiement }}</p>
            <p><strong>Niveau Université :</strong> {{ $niveau_universite }}</p>
        </div>

        <!-- Afficher le QR code -->
        <div class="qr-code">
            <img src="{{ public_path('qrcodes/' . $qr_code) }}" alt="QR Code" width="150">
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>Reçu délivré par : <strong>EasePaySchool.com</strong></p>
            <p>Développé par <strong>Smart Tech Engineering</strong></p>
            <p>Tel : +237 620 699 733 / 659 454 737</p>
        </div>
    </div>
 <script src="/jscript/about.js"></script>
</body>
</html>
