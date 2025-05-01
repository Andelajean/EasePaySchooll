<!DOCTYPE html>
<html>
<head>
    <title>Répartition des salles d'examen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-2xl font-bold mb-6">Répartition des salles d'examen</h1>
    
    @foreach($candidates as $room => $students)
    <div class="mb-8">
        <h2 class="text-xl font-semibold bg-gray-100 p-2">{{ $room }}</h2>
        <table class="min-w-full border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 border">Place</th>
                    <th class="px-4 py-2 border">Nom</th>
                    <th class="px-4 py-2 border">Prénom</th>
                    <th class="px-4 py-2 border">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td class="px-4 py-2 border text-center">{{ $student->exam_seat }}</td>
                    <td class="px-4 py-2 border">{{ $student->nom }}</td>
                    <td class="px-4 py-2 border">{{ $student->prenom }}</td>
                    <td class="px-4 py-2 border">{{ $student->email }}</td>
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