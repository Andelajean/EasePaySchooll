<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiement</title>
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
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body >
  @include('navbar')
  <!-- Loader  -->
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
         <h2 class="text-lg font-bold text-white text-center mb-4">Formulaire de Paiement des frais de scolarité</h2>

  <div class="max-w-3xl mx-auto p-6">
    <!-- Barre de recherche -->
    <div class="mb-6">
        <input type="text" id="search" placeholder="Rechercher une école..." class="border p-2 w-full" autocomplete="off">
        <ul id="result-list" class="mt-2 border p-2 w-full hidden"></ul> <!-- Résultats de recherche -->
    </div>

    <form id="schoolForm" class="hidden" method="POST" action="{{ route('payer') }}">
    @csrf
    <!-- Section 1: Informations sur l'école -->
    <h2 class="text-lg font-bold mb-4">Informations sur l'école</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="nom_ecole">Nom de l'école</label>
            <input type="text" id="nom_ecole" name="nom_ecole" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="banque">Banque de paiement</label>
            <select id="banque" name="banque" class="border p-2 w-full" required></select>
        </div>
    </div>

    <!-- Section 2: Informations de l'étudiant -->
    <h2 class="text-lg font-bold mb-4">Informations de l'étudiant</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="nom_complet">Nom complet de l'élève</label>
            <input type="text" id="nom_complet" name="nom_complet" class="border p-2 w-full" placeholder="Exemple : NGA NGA Benoit" required>
        </div>
        <div>
            <label for="classe">Classe</label>
            <input type="text" id="classe" name="classe" class="border p-2 w-full" placeholder="Exemple : CM2, GL3D ..." required>
        </div>
        <div>
            <label for="niveau">Niveau</label>
            <select id="niveau" name="niveau" class="border p-2 w-full" required>
                <option value="primaire_secondaire"> Maternelle et Primaire </option>
                <option value="primaire_secondaire">Secondaire</option>
                <option value="universite">Université</option>
            </select>
        </div>
        <!-- Champs pour l'université -->
        <div id="university-fields" class="hidden md:col-span-2">
            <label for="filiere">Filière</label>
            <input type="text" id="filiere" name="filiere" class="border p-2 w-full" placeholder="Exemple : Génie logiciel" >
            <label for="niveau_universite">Niveau Universitaire</label>
             <select id="niveau_universite" name="niveau_universite" class="border p-2 w-full" required>
        <option value="" disabled selected>-- Sélectionnez une option --</option>
        <option value="Niveau 1">Niveau 1</option>
        <option value="Niveau 2">Niveau 2</option>
         <option value="Niveau 3">Niveau 3</option>
        <option value="Niveau 4">Niveau 4</option>
         <option value="Niveau 5">Niveau 5</option>
        <option value="Niveau 6">Niveau 6</option>
         <option value="Niveau 7">Niveau 7</option>
        
    </select>
        </div>
    </div>

    <!-- Section 3: Paiement -->
    <h2 class="text-lg font-bold mb-4">Détails du paiement</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="montant">Montant</label>
            <input type="text" id="montant" name="montant" class="border p-2 w-full" placeholder="Exemple : 100 000" required>
        </div>
        <div>
            <label for="montant_total">Montant Total</label>
            <input type="text" id="montant_total" name="montant_total" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="motif">Motif</label>
            <input type="text" id="motif" name="motif" class="border p-2 w-full" value="Frais de scolarité" readonly>
        </div>
        <div>
    <label for="details">
        Détails 
        <span class="text-red-700">*indiquez s'il s'agit d'une tranche de la scolarité ou de la totalité</span>
    </label>
    <select id="details" name="details" class="border p-2 w-full" required>
        <option value="" disabled selected>-- Sélectionnez une option --</option>
        <option value="premiere-tranche">Première tranche</option>
        <option value="deuxieme-tranche">Deuxième tranche</option>
         <option value="premiere-tranche">Troisième tranche</option>
        <option value="deuxieme-tranche">Quatrièeme tranche</option>
         <option value="premiere-tranche">Cinquième tranche</option>
        <option value="deuxieme-tranche">Sixième tranche</option>
         <option value="premiere-tranche">Septième tranche</option>
        <option value="deuxieme-tranche">Huitième tranche</option>
        <option value="totalite">Totalité</option>
    </select>
</div>

        <div>
            <label for="date_paiement">Date de paiement</label>
            <input type="date-local" id="date_paiement" name="date_paiement" class="border p-2 w-full" value="{{ date('Y-m-d\TH:i') }}" readonly>
        </div>
        <div>
            <label for="heure_paiement">Heure de paiement</label>
            <input type="text" id="heure_paiement" name="heure_paiement" class="border p-2 w-full" value="{{ date('H:i') }}" readonly>
        </div>
    </div>

    <!-- Boutons -->
    <div class="flex justify-between mt-4">
        <button type="button" id="annuler" class="bg-red-500 text-white px-4 py-2 rounded">Annuler</button>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Payer</button>
    </div>
</form>
</div>
 @include('Page.footer')
 <script src="/jscript/paiement.js"></script>
   <script src="https://cdn.tailwindcss.com"></script>

</body>
</html>
