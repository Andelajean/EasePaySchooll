<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Élève</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Détails de l'Élève</h2>
            <button onclick="window.history.back()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Retour</button>
        </div>
        <table class="w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="border border-gray-300 p-2">ID</th>
                    <th class="border border-gray-300 p-2">Nom Complet</th>
                    <th class="border border-gray-300 p-2">Classe</th>
                    <th class="border border-gray-300 p-2">Niveau</th>
                    <th class="border border-gray-300 p-2">Niveau Universitaire</th>
                    <th class="border border-gray-300 p-2">Filière</th>
                    <th class="border border-gray-300 p-2">Montant</th>
                    <th class="border border-gray-300 p-2">Date de Paiement</th>
                    <th class="border border-gray-300 p-2">Tranche</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($paiements as $paiement)
            <tr class="text-center bg-gray-100 hover:bg-gray-200">
                <td class="border border-gray-300 p-2">{{ $paiement->id_paiement }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->nom_complet }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->classe }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->niveau }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->niveau_universite }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->filiere }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->montant }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->date_paiement }}</td>
                <td class="border border-gray-300 p-2">{{ $paiement->details }}</td>
            </tr>
            @endforeach
                
            </tbody>
        </table>
    </div>
</body>
</html>
