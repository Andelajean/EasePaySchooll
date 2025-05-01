<!DOCTYPE html>
<html>
<head>
    <title>Impression InGé</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .room { page-break-after: always; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 20px;">Répartition des salles d'examen pour la filière Ingénieur Génaraliste</h1>
    
    @php
        $grouped = $candidates->groupBy('exam_room');
    @endphp
    
    @foreach($grouped as $room => $students)
    <div class="room">
        <h2 style="font-size: 18px; margin-bottom: 10px;">{{ $room }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Place</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->exam_seat }}</td>
                    <td>{{ $student->nom }}</td>
                    <td>{{ $student->prenom }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <script>
    window.onload = function() {
        window.print();
    }
    </script>
</body>
</html>