<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Classe</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
                     
<div class="messages-container">
  @if(session('success'))
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {!! session('success') !!}
    </div>
  @endif
  @if(session('error'))
    <div class="text-red-500 font-bold mb-4 p-3 bg-red-100 border border-red-300 rounded">
      {{ session('error') }}
    </div>
  @endif
  @if ($errors->any())
    <div class="text-red-500 font-bold mb-4 p-3 bg-red-100 border border-red-300 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
        <h1 class="text-2xl font-bold mb-4">Modifier la classe : {{ $classe->nom_classe }}</h1>

        <form action="/classes/{{ $classe->id }}/update" method="POST">
            @csrf
    <div class="grid grid-cols-2 gap-4 mb-4">
        <!-- Les champs tels qu'ils existent déjà -->
 
    
        <div>
            <label for="nom_classe" class="block text-sm font-medium">Nom de la Classe</label>
            <input type="text" id="nom_classe" name="nom_classe" class="w-full border p-2 rounded" value="{{ $classe->nom_classe }}">
        </div>
        <div>
            <label for="premiere_tranche" class="block text-sm font-medium">Première Tranche</label>
            <input type="number" id="premiere_tranche" name="premiere_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->premiere_tranche ?? '-' }}">
        </div>
        <div>
            <label for="deuxieme_tranche" class="block text-sm font-medium">Deuxième Tranche</label>
            <input type="number" id="deuxieme_tranche" name="deuxieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->deuxieme_tranche }}">
        </div>
        <div>
            <label for="troisieme_tranche" class="block text-sm font-medium">Troisième Tranche</label>
            <input type="number" id="troisieme_tranche" name="troisieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->troisieme_tranche }}">
        </div>
        <div>
            <label for="quatrieme_tranche" class="block text-sm font-medium">Quatrième Tranche</label>
            <input type="number" id="quatrieme_tranche" name="quatrieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->quatrieme_tranche }}">
        </div>
        <div>
            <label for="cinquieme_tranche" class="block text-sm font-medium">Cinquième Tranche</label>
            <input type="number" id="cinquieme_tranche" name="cinquieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->cinquieme_tranche }}">
        </div>
        <div>
            <label for="sixieme_tranche" class="block text-sm font-medium">Sixième Tranche</label>
            <input type="number" id="sixieme_tranche" name="sixieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->sixieme_tranche }}">
        </div>
        <div>
            <label for="septieme_tranche" class="block text-sm font-medium">Septième Tranche</label>
            <input type="number" id="septieme_tranche" name="septieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->septieme_tranche }}">
        </div>
        <div>
            <label for="huitieme_tranche" class="block text-sm font-medium">Huitième Tranche</label>
            <input type="number" id="huitieme_tranche" name="huitieme_tranche" class="w-full border p-2 rounded tranche" value="{{ $classe->huitieme_tranche }}">
        </div>
        <div>
            <label for="totalite" class="block text-sm font-medium">Totalité</label>
            <input type="text" id="totalite" name="totalite" class="w-full border p-2 rounded" value="{{ $classe->totalite }}" readonly>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="/ecole/dashboard/profil/{{ $classe->id_ecole }}" class="bg-green-500 text-white px-4 py-2 rounded mr-2">Retour</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour</button>
    </div>
</form>
    </div>
    <script>
    // Fonction pour recalculer le total
    function calculerTotal() {
        let total = 0;

        // Récupérer toutes les tranches
        document.querySelectorAll('.tranche').forEach(input => {
            const valeur = parseFloat(input.value) || 0; // Convertir ou utiliser 0 si vide
            total += valeur;
        });

        // Mettre à jour le champ de totalité
        document.getElementById('totalite').value = total;
    }

    // Ajouter un événement "input" à chaque tranche
    document.querySelectorAll('.tranche').forEach(input => {
        input.addEventListener('input', calculerTotal);
    });

    // Calcul initial si nécessaire
    document.addEventListener('DOMContentLoaded', calculerTotal);
</script>
</body>
</html>
