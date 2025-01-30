<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la pénalité</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Modifier la pénalité</h2>
        <form action="{{ route('penalite.update', $penalite->id) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-4">
                <label for="classe" class="block text-sm font-medium">Classe</label>
                <input type="text" id="classe" name="classe" value="{{ old('classe', $penalite->classe) }}" 
                    class="w-full border rounded px-4 py-2">
                @if ($errors->has('classe'))
                    <p class="text-red-500 text-sm">{{ $errors->first('classe') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="date_debut" class="block text-sm font-medium">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" value="{{ old('date_debut', $penalite->date_debut) }}" 
                    class="w-full border rounded px-4 py-2">
                @if ($errors->has('date_debut'))
                    <p class="text-red-500 text-sm">{{ $errors->first('date_debut') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="montant" class="block text-sm font-medium">Montant</label>
                <input type="number" id="montant" name="montant" value="{{ old('montant', $penalite->montant) }}" 
                    class="w-full border rounded px-4 py-2">
                @if ($errors->has('montant'))
                    <p class="text-red-500 text-sm">{{ $errors->first('montant') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="frequence" class="block text-sm font-medium">Fréquence</label>
                <select id="frequence" name="frequence" class="w-full border rounded px-4 py-2">
                    <option value="jour" {{ old('frequence', $penalite->frequence) === 'jour' ? 'selected' : '' }}>Jour</option>
                    <option value="semaine" {{ old('frequence', $penalite->frequence) === 'semaine' ? 'selected' : '' }}>Semaine</option>
                    <option value="mois" {{ old('frequence', $penalite->frequence) === 'mois' ? 'selected' : '' }}>Mois</option>
                </select>
                @if ($errors->has('frequence'))
                    <p class="text-red-500 text-sm">{{ $errors->first('frequence') }}</p>
                @endif
            </div>

            <div class="mb-4">
    <label for="tranche" class="block text-sm font-medium">Tranche</label>
    <select id="tranche" name="tranche" class="w-full border rounded px-4 py-2">
        <option value="" disabled {{ old('tranche', $penalite->tranche) == '' ? 'selected' : '' }}>Sélectionnez une tranche</option>
        <option value="premiere_tranche" {{ old('tranche', $penalite->tranche) == 'premiere_tranche1' ? 'selected' : '' }}>Première Tranche</option>
        <option value="deuxieme_tranche" {{ old('tranche', $penalite->tranche) == 'deuxieme_tranche' ? 'selected' : '' }}>Deuxième Tranche </option>
        <option value="troisieme_tranche" {{ old('tranche', $penalite->tranche) == 'troisieme_tranche' ? 'selected' : '' }}>TroisièmeTranche</option>
        <option value="quatrieme_tranche" {{ old('tranche', $penalite->tranche) == 'quatrieme_tranche' ? 'selected' : '' }}>Quatrième Tranche </option>
        <option value="cinquieme_tranche" {{ old('tranche', $penalite->tranche) == 'cinquieme_tranche' ? 'selected' : '' }}>Cinquème Tranche</option>
        <option value="sixieme_tranche" {{ old('tranche', $penalite->tranche) == 'sixieme_tranche' ? 'selected' : '' }}>Sixième Tranche </option>
        <option value="septieme_tranche" {{ old('tranche', $penalite->tranche) == 'septieme_tranche' ? 'selected' : '' }}>Septième Tranche </option>
        <option value="huitieme_tranche" {{ old('tranche', $penalite->tranche) == 'huitieme_tranche' ? 'selected' : '' }}> Huitième Tranche </option>
    </select>
    @if ($errors->has('tranche'))
        <p class="text-red-500 text-sm">{{ $errors->first('tranche') }}</p>
    @endif
</div>


            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
        </form>
    </div>
</body>
</html>
