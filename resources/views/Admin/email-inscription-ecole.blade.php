<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle École Ajoutée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #004b8d;
        }
        .email-header h1 {
            font-size: 24px;
            color: #004b8d;
        }
        .email-content {
            padding: 20px;
            line-height: 1.6;
        }
        .email-content h2 {
            color: #004b8d;
            font-size: 22px;
        }
        .email-content p {
            font-size: 16px;
            margin: 5px 0;
        }
        .school-info {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .school-info p {
            margin: 8px 0;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #ccc;
            margin-top: 20px;
        }
        .email-footer p {
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="email-container">
    <!-- Header Section -->
    <div class="email-header">
        <h1>Nouvelle École Ajoutée à EasePaySchool</h1>
    </div>

    <!-- Email Content -->
    <div class="email-content">
        <h2>Bonjour Admin,</h2>
        <p>Une nouvelle école a été ajoutée avec succès à la plateforme <strong>EasePaySchool</strong>.</p>

        <div class="school-info">
            <p><strong>Nom de l'école :</strong> {{ $ecole['nom_ecole'] }}</p>
            <p><strong>Email :</strong> {{ $ecole['email'] }}</p>
            <p><strong>Téléphone :</strong>{{ $ecole['telephone'] }}</p>
            <p><strong>Ville :</strong> {{ $ecole['ville'] }}</p>
            <p><strong>Identifiant :</strong> {{ $ecole['identifiant'] }}</p>
        </div>

        <p>Vous pouvez vous connecter à l'interface administrateur pour consulter plus de détails.</p>
    </div>

    <!-- Footer Section -->
    <div class="email-footer">
        <p>Développé par Smart Tech Engineering pour EasePaySchool.</p>
    </div>
</div>

</body>
</html>
