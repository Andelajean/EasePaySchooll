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
        <h1 class="text-2xl font-bold mb-4">Modifier la Filière : {{ $filiere->filiere }}</h1>

        <form action="/filiere/{{ $filiere->id }}/update" method="POST">
            @csrf
    <div class="grid grid-cols-2 gap-4 mb-4">
        <!-- Les champs tels qu'ils existent déjà -->
 
    
        <div>
            <label for="nom_classe" class="block text-sm font-medium">Nom de la Classe</label>
            <input type="text" id="nom_classe" name="nom_filiere" class="w-full border p-2 rounded" value="{{ $filiere->filiere }}">
        </div>
        <div>
            <label for="nom_classe" class="block text-sm font-medium hidden">Nom de la Classe</label>
            <input type="text" id="nom_classe" name="ecole_id" class="w-full border p-2 rounded hidden" value="{{ $filiere->ecole_id }}">
        </div>
       
    </div>

    <div class="flex justify-end">
        <a href="{{ route('profil')}}" class="bg-green-500 text-white px-4 py-2 rounded mr-2">Retour</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour</button>
    </div>
</form>
    </div>

</body>
</html>
