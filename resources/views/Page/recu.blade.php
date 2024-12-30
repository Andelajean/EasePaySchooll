<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de paiement</title>
    
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
  <!-- Google Web Fonts -->
  <link href="/style/recu.css" rel="stylesheet">
  <!-- Icon Font Stylesheet -->
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">Reçu de Paiement Des Frais De Scolarité</h1>
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
        <!-- QR code -->
        <div class="qr-code">
            <img src="{{ asset('qrcodes/' . $qr_code) }}" alt="QR Code">
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>Reçu délivré par : <strong>EasePaySchool.com</strong></p>
            <p>Développé par <strong>Smart Tech Engineering</strong></p>
            <p>Tel : +237 620 699 733 / 659 454 737 / 679 091 819</p>
        </div>
         <!-- Bouton de téléchargement du reçu -->
        <div style="text-align: center;">
            <a href="{{ route('telecharger_recu', ['id_paiement' => $id_paiement]) }}" class="download-btn">Télécharger le Reçu</a>
        </div>
    </div>
 <script src="/jscript/about.js"></script>
 <script src="/jscript/style.js">
  </script>
 
</body>
</html>
