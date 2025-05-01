<!DOCTYPE html>
<html>
<head>
    <title>Affectation des salles d'examen</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Bonjour,</h2>
    <p>Voici les affectations de salles pour l'examen :</p>
    
    <table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Salle</th>
            <th>Place</th>
        </tr>
    </thead>
    <tbody>
        @foreach($candidates as $candidate)
            <tr>
                <td>{{ $candidate['nom'] }}</td>
                <td>{{ $candidate['prenom'] }}</td>
                <td>{{ $candidate['exam_room'] }}</td>
                <td>{{ $candidate['exam_seat'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
    
    <p>Cordialement,<br>L'équipe d'organisation</p>
    
    <p><small>Vous trouverez ces informations en pièce jointe au format PDF.</small></p>
</body>
</html>