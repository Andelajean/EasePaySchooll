<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Pénalités</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
    <!-- Lien vers Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="p-4">
    <!-- Filtre par classe et tranche -->
    <form method="GET" action="{{ route('calculer_penalites') }}" class="mb-4 flex gap-4">
        <select name="classe" class="p-2 border rounded-md">
            <option value="">Sélectionnez une classe</option>
            @foreach ($classes as $classe)
                <option value="{{ $classe->nom_classe }}" 
                    {{ request('classe') == $classe->nom_classe ? 'selected' : '' }}>
                    {{ $classe->nom_classe }}
                </option>
            @endforeach
        </select>

        <select name="tranche" class="p-2 border rounded-md">
            <option value="">Sélectionnez une tranche</option>
            <option value="premiere_tranche">Première Tranche</option>
                    <option value="deuxieme_tranche">Deuxième Tranche</option>
                    <option value="troisieme_tranche">Troisième Tranche</option>
                    <option value="quatrieme_tranche">Quatrième Tranche</option>
                    <option value="cinquieme_tranche">Cinquième Tranche</option>
                    <option value="sixieme_tranche">Sixième Tranche</option>
                    <option value="septieme_tranche">Septième Tranche</option>
                    <option value="huitieme_tranche">Huitième Tranche</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Rechercher
        </button>
        <!-- Bouton pour imprimer -->
    <button onclick="imprimerTableau()" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
        Imprimer le tableau
    </button>
    <a href="{{route('dashboard_ecole')}}" class="mb-4 px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-blue-600">Retour</a>
    </form>

    

    <!-- Table -->
    <div class="overflow-x-auto">
        @if ($resultatsPagines->count() > 0)
            <table id="tableau-penalites" class="min-w-full border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nom de l'étudiant</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Classe</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Date de Paiement</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Date Début Pénalité</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nombre de Jours</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Montant à Payer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultatsPagines as $resultat)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2">{{ $resultat['nom_etudiant'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resultat['classe'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resultat['date_paiement'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resultat['date_debut_penalite'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resultat['nombre_jours'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resultat['montant_a_payer'] }} CFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
            {{ $resultatsPagines->appends(request()->query())->links() }}
            </div>
           

        @else
            <p class="text-gray-600">Aucun résultat trouvé pour cette sélection.</p>
        @endif
    </div>
</div>

<!-- Script pour imprimer le tableau -->
<script>
    function imprimerTableau() {
        const contenu = document.getElementById('tableau-penalites').outerHTML;
        const fenetreImpression = window.open('', '_blank');
        fenetreImpression.document.write('<html><head><title>Impression</title></head><body>' + contenu + '</body></html>');
        fenetreImpression.document.close();
        fenetreImpression.print();
    }
</script>
</body>
</html>
