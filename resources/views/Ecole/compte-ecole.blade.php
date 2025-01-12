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
  <!-- Titre principal -->
  <div class="text-center mt-20 text-white text-4xl font-bold">Formulaire d'Inscription des Écoles</div>
  <div class="messages-container">
  @if(session('success'))
    <div class="text-green-500 font-bold mb-4 p-3 bg-green-100 border border-green-300 rounded">
      {{ session('success') }}
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

  <!-- Formulaire École et Banques Partenaires -->
  <div class="max-w-4xl mx-auto mt-10 p-6 border border-yellow-500 rounded-lg relative z-10 bg-gray-900 bg-opacity-75">
    <h2 class="text-xl font-semibold mb-4 text-white">Informations de l'École</h2>
    <form id="combinedForm" method="post" action="{{ route('compte.traitement') }}">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Nom École -->
        <div class="flex flex-col">
          <label for="nomEcole" class="mb-2 font-medium text-white">Nom de l'école</label>
          <input type="text" id="nomEcole" name="nom_ecole" class="p-2 border rounded-md" placeholder="Entrez le nom de l'école" required>
        </div>
        <!-- Email -->
        <div class="flex flex-col">
          <label for="email" class="mb-2 font-medium text-white">Email</label>
          <input type="email" id="email" name="email" class="p-2 border rounded-md" placeholder="Entrez l'email" required>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Ville -->
        <div class="flex flex-col">
          <label for="ville" class="mb-2 font-medium text-white">Ville</label>
          <input type="text" id="ville" name="ville" class="p-2 border rounded-md" placeholder="Entrez la ville" required>
        </div>
        <!-- Telephone -->
        <div class="flex flex-col">
          <label for="telephone" class="mb-2 font-medium text-white">Téléphone</label>

          <input type="text" id="telephone" name="telephone" class="p-2 border rounded-md" placeholder="Entrez le numéro de téléphone" required>
        </div>

          <input type="tel" id="telephone" name="telephone" class="p-2 border rounded-md" placeholder="Entrez le num�ro de t�l�phone" required value="+237" maxlength="13">        </div>

          <input type="text" id="telephone" name="telephone" class="p-2 border rounded-md" placeholder="Entrez le numéro de téléphone" required>
        </div>

      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Niveau de l'école -->
    <div class="flex flex-col">
       
        <label for="niveau" class="mb-2 font-medium text-white">Niveau
          <p class="text-green-500 font-bold mb-4">
            Indiquez s'il s'agit d'une école maternelle, primaire et secondaire, ou d'une université
        </p>
        </label>
        <select name="niveau" id="niveau" class="p-2 bg-white border border-gray-300 rounded-md" required>
            <option value="">Veuillez Choisir</option>
            <option value="primaire_secondaire">Primaire et Secondaire</option>
            <option value="universite">Université</option>
        </select>
    </div>
</div>


      <!-- Section 2: Banques Partenaires -->
      <h2 class="text-xl font-semibold mt-6 mb-4 text-white">Banques Partenaires</h2>
      <p class="text-green-500 font-bold mb-4">Cliquez sur Ajouter une Banque pour ajouter vos banques partenaires</p>
      <p class="text-red-500 font-bold mb-4">NB: Une banque ne peut être choisie deux fois.</p>
     <div id="bank-container">
    <!-- Bloc par défaut (1ère banque) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 bank-row" id="bankRow1">
        <!-- Nom Banque -->
        <div class="flex flex-col">
            <label for="nom_banque1" class="mb-2 font-medium text-white">Nom de la Banque</label>
            <select class="p-2 border rounded-md bank-name" name="nom_banque1">
                            <option value="">Choisir une banque</option>
                         <option value="Afriland First Bank">Afriland First Bank</option>
                    <option value="Banque Atlantique">Banque Atlantique</option>
                    <option value="UBA Bank">UBA Bank</option>
                    <option value="SCB Bank">SCB Bank</option>
                    <option value="SGBC">SGBC</option>
                    <option value="Commercial Bank">Commercial Bank</option>
                    <option value="BICEC">BICEC</option>
                    <option value="Eco Bank">Eco Bank</option>
                    <option value="BGFI Bank">BGFI Bank</option>
                    <option value="Bange Bank">Bange Bank</option>
                    <option value="Express Union">Express Union</option>
                    <option value="Vision Finance">Vision Finance</option>
                    <option value="NFC Bank">NFC Bank</option>

                            <!-- Ajoutez ici les options pour chaque banque  -->
                            @isset($banques)
                             @foreach ($banques as $banque)
                              <option value="{{ $banque->nom }}">{{ $banque->nom }}</option>
                             @endforeach
                            @endisset  
                           
            </select>
        </div>
        <!-- Numéro Compte -->
        <div class="flex flex-col">
            <label for="numero_compte1" class="mb-2 font-medium text-white">Numéro de Compte</label>
            <input type="text" class="p-2 border rounded-md numero-compte" name="numero_compte1" placeholder="Entrez le numéro de compte">
        </div>
    </div>
</div>
<!-- Boutons d'ajout et de retrait -->
<div class="flex justify-center mt-6 space-x-4">
    <button type="button" id="add-bank" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Ajouter une banque</button>
    <button type="button" id="remove-bank" class="bg-red-500 text-white p-2 rounded-md hover:bg-red-600">Retirer une banque</button>
</div>
<!-- Bouton de soumission -->
<div class="flex justify-center mt-6">
    <button type="submit" class="bg-green-500 text-white p-2 rounded-md hover:bg-green-600">Soumettre</button>
</div>
    </form>
  </div>
  @include('Page.footer')
 <script src="/jscript/style.js">
  </script>
</body>
</html>