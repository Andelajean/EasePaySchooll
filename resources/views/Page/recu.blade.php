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

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 210mm; /* Taille A4 */
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
            border: 1px solid #ddd;
        }
        .header img {
            width: 100px;
            display: block;
            margin: 0 auto;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info {
            width: 48%;
            font-size: 14px;
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
        }
        .qr-code img {
            display: block;
            margin: 20px auto;
            width: 150px;
        }
        .download-btn {
        display: inline-block;
        margin: 20px auto;
        padding: 10px 15px; /* Réduit les dimensions du bouton */
        background-color: blue;
        color: white;
        border: none;
        text-decoration: none;
        font-size: 14px; /* Taille de police ajustée */
        cursor: pointer;
        text-align: center;
        border-radius: 5px; /* Ajout de coins arrondis pour un style moderne */
        width: auto; /* Ajustement automatique à la taille du texte */
    }
    </style>
</head>
<body>
    <div class="container" id="recu-container">
        <!-- Logo -->
        <div class="header">
            <img src="{{ asset('image/logofin.jpg') }}" alt="Logo">
        </div>

        <!-- Informations de l'entreprise et de l'école -->
        <div class="info-section">
            <div class="info">
                <h2>Informations de l'entreprise</h2>
                <p><strong>TrueSiteTechnology SARL</strong></p>
                <p>Site web : <strong>www.truesitetechnology.com</strong></p>
                <p>Email : <strong>contact@truesitetechnology.com</strong></p>
                <p>Tel : <strong>+237 620 699 733 / 659 454 737 / 679 091 819</strong></p>
            </div>
            <div class="info">
                <h2>Informations de l'école</h2>
                <p><strong>Nom de l'école : {{ $nom_ecole }}</strong></p>
                <p>Ville :<strong> {{ $ville }}</strong></p>
                <p>Téléphone :<strong>{{ $telephone }}</strong></p>
            </div>
        </div>

        <!-- Détails du paiement -->
        <div class="details-paiement">
            <h2>Détails du Paiement</h2>
            <table>
                <tr><th>ID Paiement</th><td>{{ $id_paiement }}</td></tr>
                <tr><th>Nom complet</th><td>{{ $nom_complet }}</td></tr>
                <tr><th>Montant</th><td>{{ $montant }} FCFA</td></tr>
                <tr><th>Détails</th><td>{{ $details }}</td></tr>
                <tr><th>Banque</th><td>{{ $banque }}</td></tr>
                <tr><th>Classe</th><td>{{ $classe }}</td></tr>
                <tr><th>Niveau</th><td>{{ $niveau }}</td></tr>
                <tr><th>Filière</th><td>{{ $filiere }}</td></tr>
                <tr><th>Date Paiement</th><td>{{ $date_paiement }}</td></tr>
                <tr><th>Heure Paiement</th><td>{{ $heure_paiement }}</td></tr>
                <tr><th>Niveau Université</th><td>{{ $niveau_universite }}</td></tr>
            </table>
        </div>

        <!-- QR Code -->
        <div class="qr-code">
            <img src="{{ asset('qrcodes/' . $qr_code) }}" alt="QR Code">
        </div>

        <!-- Bouton de téléchargement du reçu -->
        <div style="text-align: center;">
            <a id="download-btn" class="download-btn">Télécharger le Reçu</a>
        </div>
    </div>


    <!-- Script html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
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
    e.preventDefault(); // Empêche l'affichage du menu contextuel
});

// Empêcher certaines combinaisons de touches
document.addEventListener('keydown', function (e) {
    const key = e.key.toLowerCase(); // Normalise la touche en minuscule

    // Empêcher certains raccourcis clavier
    if (e.ctrlKey || e.metaKey) {
        if (key === 's' || key === 'u' || key === 'r') {
            e.preventDefault();
        }
    }

    // Empêcher les touches spécifiques (F12, F5)
    if (key === 'f12' || key === 'f5') {
        e.preventDefault();
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', () => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = "Traitement...";
            }
        });
    }
});


    </script>

</body>
</html>
