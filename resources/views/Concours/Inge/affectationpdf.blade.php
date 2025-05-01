<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Affectation des salles - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Affectation des salles d'examen</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Salle</th>
                <th>Place</th>
            </tr>
        </thead>
        @foreach($candidates as $candidate)
    @if(is_array($candidate))
        <tr>
            <td>{{ $candidate['nom'] ?? '-' }}</td>
            <td>{{ $candidate['prenom'] ?? '-' }}</td>
            <td>{{ $candidate['exam_room'] ?? '-' }}</td>
            <td>{{ $candidate['exam_seat'] ?? '-' }}</td>
        </tr>
    @endif
@endforeach
        </tbody>
    </table>
</body>
</html>