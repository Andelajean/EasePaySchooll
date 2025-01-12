<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire d'Inscription des Écoles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Exo:400,700" rel="stylesheet">
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="/style/style.css" rel="stylesheet">
  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Barre de navigation -->
  @include('navbar')
  <!-- Loader -->
  <div id="loader" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
    <div class="loader"></div>
  </div>
  <!-- Section d'animation (background fixe) -->
  <div class="area">
    <ul class="circles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
 
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

<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-6 mb-6">

    <!-- Titre principal -->
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-4">Ajouter Vos classes ici</h2>
    

    <!-- Formulaire -->
    <form id="classesForm" action="{{ route('traitement.classe.profil', ['id' => $id]) }}" method="post">
        @csrf

        <!-- Section Classes -->
        <h3 class="text-xl font-semibold text-gray-800 mt-6">Classes</h3>
        <div id="classes-section" class="space-y-4">
            <template id="classe-template">
                <div class="grid grid-cols-6 gap-4 items-center border-b pb-4">
                    <input type="text" name="nom_classe[]" class="border rounded p-2 w-full" placeholder="Nom Classe (Ex: CP, L1)">
                    <select name="indice[]" class="border rounded p-2 w-full">
                        @foreach(range('A', 'Z') as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="nombre[]" class="border rounded p-2 w-full" placeholder="Nombre (Ex: 4)" oninput="generateIndices(this)">
                    <input type="number" class="border rounded p-2 w-full tranche-input" placeholder="Nombre de Tranches" oninput="openTrancheModal(this)">
                    <input type="text" readonly class="border rounded p-2 w-full indices-summary" placeholder="Indices générés" name="indices[]" value="">
                    <input type="text" readonly class="border rounded p-2 w-full montant-summary" placeholder="Montants par Tranches" name="montants[]" value="">
                    <input type="number" readonly class="border rounded p-2 w-full totalite-summary" placeholder="Totalité" name="totalite[]" value="">
                </div>
            </template>
        </div>

        <!-- Bouton pour ajouter une classe -->
        <div class="flex justify-end mt-4">
            <button type="button" onclick="addRow('classes-section')" class="text-blue-500 font-semibold">+ Ajouter une classe</button>
        </div>

        <!-- Bouton de validation -->
        <button type="button" onclick="showPreview()" class="w-full bg-blue-600 text-white p-3 rounded mt-6">
            Valider et Aperçu
        </button>
    </form>
</div>

<!-- Fenêtre modale pour les tranches -->
<div id="trancheModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Saisir les montants des tranches</h3>
        <div id="tranchesContent" class="space-y-2"></div>
        <button onclick="saveTranches()" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 w-full">Enregistrer</button>
    </div>
</div>

<!-- Fenêtre d'aperçu -->
<div id="previewModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Aperçu des données</h3>
        <div id="previewContent" class="text-sm text-gray-700"></div>
        <div class="flex justify-between mt-4">
            <button onclick="closePreview()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Annuler</button>
            <button onclick="submitForm()" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
        </div>
    </div>
</div>



  @include('Page.footer')
 <script src="/jscript/classe.js">
  </script>
   <script src="/jscript/style.js">
  </script>
</body>
</html>