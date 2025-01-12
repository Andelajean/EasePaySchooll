<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement</title>
    <style>
     body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f9f9f9;
  position: relative;
}

.container {
  background: #fff;
  margin: 20px auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  position: relative;
  max-width: 800px;
}

.container::before {
  content: "easepayschool.com";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-45deg); /* Rotation de -45 degrés pour un affichage diagonal */
  font-size: 60px;
  color: rgba(0, 120, 255, 0.1); /* Bleu clair et transparent */
  z-index: 0;
  white-space: nowrap;
  pointer-events: none; /* Évite toute interaction avec le filigrane */
}

.header {
  text-align: center;
  margin-bottom: 20px;
}

.header img {
  max-width: 150px;
  border-radius: 10px;
}

.info-section {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.info {
  width: 45%;
  background-color: #f2f2f2;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.info h2 {
  font-size: 18px;
  margin-bottom: 10px;
  color: #0078ff;
}

.details-paiement {
  margin-top: 20px;
  background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.details-paiement h2 {
  font-size: 18px;
  margin-bottom: 15px;
  text-align: center;
  justify-content: center;
  color: #0078ff;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th, td {
  text-align: left;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

th {
  
  color: black;
}

.qr-code {
  text-align: center;
  margin-top: 20px;
}

.qr-code img {
  max-width: 150px;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.download-btn {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #0078ff;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-size: 16px;
}

.download-btn:hover {
  background-color: #005bb5;
}
    </style>
</head>
<body>
    <div class="container">
       
        <!-- Logo -->
        <div class="header">
            <img src="{{ public_path('image/logofin.jpg') }}" alt="Logo">
        </div>

        <!-- Informations entreprise et école -->
        <div class="info-section">
            <div class="info">
                <h2>Informations de l'entreprise</h2>
                <p><strong>EasePaySchool.com</strong></p>
                <p>Développé par TrueSiteTechnology</p>
                <p>Tel : +237 620 699 733 / 659 454 737 / 679 091 819</p>
            </div>
            <div class="info">
                <h2>Informations de l'école</h2>
                <p><strong>Nom de l'école :</strong> {{ $nom_ecole }}</p>
                <p><strong>Ville :</strong> {{ $ville }}</p>
                <p><strong>Téléphone :</strong> {{ $telephone }}</p>
            </div>
        </div>

        <!-- Détails du paiement -->
        <div class="details-paiement">
            <h2>Détails du Paiement</h2>
            <table>
                <tr>
                    <th>ID Paiement</th>
                    <td>{{ $id_paiement }}</td>
                </tr>
                <tr>
                    <th>Nom complet</th>
                    <td>{{ $nom_complet }}</td>
                </tr>
                <tr>
                    <th>Montant</th>
                    <td>{{ $montant }} FCFA</td>
                </tr>
                <tr>
                    <th>Détails</th>
                    <td>{{ $details }}</td>
                </tr>
                <tr>
                    <th>Banque</th>
                    <td>{{ $banque }}</td>
                </tr>
                <tr>
                    <th>Classe</th>
                    <td>{{ $classe }}</td>
                </tr>
                <tr>
                    <th>Niveau</th>
                    <td>{{ $niveau }}</td>
                </tr>
                <tr>
                    <th>Filière</th>
                    <td>{{ $filiere }}</td>
                </tr>
                <tr>
                    <th>Date Paiement</th>
                    <td>{{ $date_paiement }}</td>
                </tr>
                <tr>
                    <th>Heure Paiement</th>
                    <td>{{ $heure_paiement }}</td>
                </tr>
                <tr>
                    <th>Niveau Université</th>
                    <td>{{ $niveau_universite }}</td>
                </tr>
            </table>
        </div>

        <!-- QR Code -->
        <div class="qr-code">
            <img src="{{ public_path('qrcodes/' . $qr_code) }}" alt="QR Code">
        </div>
    </div>
</body>
</html>
