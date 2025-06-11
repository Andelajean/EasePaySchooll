<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reçu de paiement</title>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">

  <!-- Feuille de style personnalisée -->
  <link href="{{ asset('style/recu.css') }}" rel="stylesheet">

  <style>

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 95%;
      max-width: 210mm;
      margin: 10px auto;
      padding: 20px;
      box-sizing: border-box;
      border: 1px solid #ddd;
      background-color: #fff;
      border-radius: 10px;
    }
    .header img {
      width: 80px;
      display: block;
      margin: 0 auto;
    }
    .info-section {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin-bottom: 20px;
      gap: 10px;
    }
    .info {
      width: 100%;
      flex: 1;
      font-size: 14px;
      box-sizing: border-box;
    }
    .details-paiement table {
      width: 100%;
      border-collapse: collapse;
    }
    .details-paiement table th, 
    .details-paiement table td {
      border: 1px solid #ddd;
      padding: 5px;
      text-align: left;
      font-size: 12px;
    }
    .qr-code img {
      display: block;
      margin: 20px auto;
      max-width: 150px;
      width: 50%;
    }
    .download-btn {
      display: block;
      margin: 20px auto;
      padding: 10px 15px;
      background-color: blue;
      color: white;
      border: none;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
      text-align: center;
      border-radius: 5px;
    }
    @media (max-width: 768px) {
      .header img {
        width: 60px;
      }
      .info {
        width: 100%;
      }
      .details-paiement table th, 
      .details-paiement table td {
        font-size: 12px;
      }
      .qr-code img {
        width: 100px;
      }
    }
    @media (max-width: 480px) {
      .container {
        padding: 10px;
      }
      .download-btn {
        font-size: 12px;
        padding: 8px 10px;
      }
    }

        .photo-logo-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .photo, .logo {
        flex: 1;
        text-align: center;
    }

  </style>
</head>
<body>
  <div class="container" id="recu-container">
    @php
       $photo_path = str_replace('documents/photo/', 'storage/photos/', $photo_path);
    @endphp
    <div class="photo-logo-container">
        <div class="photo">
            <img src="{{ asset($photo_path) }}" alt="Photo du candidat" style="max-width: 150px;">
        </div>
        <div class="logo">
            <img src="{{ asset('image/logofin.jpg') }}" alt="Logo" style="max-width: 150px;">
        </div>
    </div>

    <!-- Informations de l'entreprise et de l'école -->
    <div class="info-section">
      <div class="info">
        <h2>Informations de l'entreprise</h2>
        <p><strong>TrueSiteTechnology SARL</strong></p>
        <p>Site web : <strong>www.truesitetechnology.com</strong></p>
        <p>Email : <strong>contact@truesitetechnology.com</strong></p>
        <p>Tel : <strong>+237 659 454 737 / 679 091 819</strong></p>
      </div>
      <div class="info">
        <h2>Informations de l'école</h2>
        <p><strong>Nom de l'école :</strong>INSTITUT SAINT JEAN</p>
        <p><strong>Ville :</strong>YAOUNDE</p>
        <p><strong>Site web :</strong> <a href="http://www.institutsaintjean.com">www.institutsaintjean.com</a></p>
        <p><string> Filiere :</strong> <strong>{{ $filiere_concours }}</strong></p>
        <p><strong>Téléphone :</strong> {{ $telephone ?? 'Non défini' }}</p>
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
          <th>Date Paiement</th>
          <td>{{ $date_paiement }}</td>
        </tr>
        <tr>
          <th>Heure Paiement</th>
          <td>{{ $heure_paiement }}</td>
         
          
        </tr>
      </table>
    </div>

    

     <!-- QR Code -->
     <div class="qr-code">
            
            <img src="{{ asset($qr_code_path) }}" alt="QR Code">
     </div>

    <!-- Bouton de téléchargement du reçu -->
    <div style="text-align: center;">
      <a id="download-btn" class="download-btn">Télécharger le Reçu</a>
    </div>
  </div>

  <!-- Script html2pdf.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const downloadBtn = document.getElementById('download-btn');
      const recuContainer = document.getElementById('recu-container');

      downloadBtn.addEventListener('click', () => {
        // Masquer le bouton avant la génération du PDF
        downloadBtn.style.display = 'none';

        // Options pour html2pdf
        const options = {
          margin: [10, 10, 10, 10],
          filename: 'recu_paiement.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Générer et télécharger le PDF
        html2pdf().set(options).from(recuContainer).save().then(() => {
          // Réafficher le bouton après la génération
          downloadBtn.style.display = 'block';
        });
      });
    });

    // Empêcher le clic droit
    document.addEventListener('contextmenu', function (e) {
      e.preventDefault();
    });

    // Empêcher certaines combinaisons de touches
    document.addEventListener('keydown', function (e) {
      const key = e.key.toLowerCase();
      if (e.ctrlKey || e.metaKey) {
        if (key === 's' || key === 'u' || key === 'r') {
          e.preventDefault();
        }
      }
      if (key === 'f12' || key === 'f5') {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
