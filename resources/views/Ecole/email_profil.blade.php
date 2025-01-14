<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de votre identifiant</title>
</head>
<body>
    <h1>Bonjour {{ $ecole->nom_ecole }}</h1>

    <p>Nous vous informons que l'identifiant de votre école a été mis à jour avec succès.</p>

    <p><strong>Nouvel identifiant :</strong> {{ $nouvelIdentifiant }}</p>

    <p>Si vous n'êtes pas à l'origine de cette action, veuillez contacter notre support immédiatement.</p>

    <p>Merci,<br>L'équipe d'administration</p>
</body>
</html>
