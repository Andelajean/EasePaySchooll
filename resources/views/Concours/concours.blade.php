<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nos Concours</title>
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
   <script src="https://cdn.tailwindcss.com"></script>
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

  <div class="max-w-6xl mx-auto p-6">

    <!-- Titre principal -->
    <header class="text-center py-8">
      <h1 class="text-4xl font-bold text-gray-900" id="messa"></span> </h1>
      <p class="mt-2 text-lg text-white" id="messag"></p>
    </header>
    <div class="max-w-7xl mx-auto">
        <!-- Section des cartes de formations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Carte 1 - Management et Finance (MF) -->
            <!-- Carte 1 - Management et Finance (MF) -->
<div class="bg-white rounded-lg shadow-md overflow-hidden p-6 relative">
    <div class="absolute top-6 right-6 text-blue-500">
        <i class="fas fa-chart-line text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-blue-600 mb-4">Management et Finance (MF)</h3>
    <div class="space-y-2 mb-6">
        <p class="text-gray-600">Concours 1 : 07/05/2025</p>
        <p class="text-gray-600">Concours 2 : 25/07/2025</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('finance') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
            Candidater
        </a>
        <a href="{{ asset('concours/fichier/Fiche inscription concours Management et Finances 2025.pdf') }}" download class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
    Télécharger la fiche
</a>

    </div>
</div>

<!-- Carte 2 - Science Politique et Humaine (SPH) -->
<div class="bg-white rounded-lg shadow-md overflow-hidden p-6 relative">
    <div class="absolute top-6 right-6 text-blue-500">
        <i class="fas fa-landmark text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-blue-600 mb-4">Science Politique et Humaine (SPH)</h3>
    <div class="space-y-2 mb-6">
        <p class="text-gray-600">Concours 1 : 10/05/2025</p>
        <p class="text-gray-600">Concours 2 : 19/07/2025</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('politique') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
            Candidater
        </a>
        <a href="{{ asset('concours/fichier/Fiche-inscription-SPH-concours-2025.pdf') }}" download class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
    Télécharger la fiche
</a>

    </div>
</div>

<!-- Carte 3 - Geoscience, Environnement et Agro Industrie (IGEA) -->
<div class="bg-white rounded-lg shadow-md overflow-hidden p-6 relative">
    <div class="absolute top-6 right-6 text-blue-500">
        <i class="fas fa-leaf text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-blue-600 mb-4">Geoscience, Environnement et Agro Industrie (IGEA)</h3>
    <div class="space-y-2 mb-6">
        <p class="text-gray-600">Concours 1 : 10/05/2025</p>
        <p class="text-gray-600">Concours 2 : 19/07/2025</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('geoscience') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
            Candidater
        </a>
        <a href="{{ asset('concours/fichier/Fiche-dinscription-concours-IGEA-2025.pdf') }}" download class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
    Télécharger la fiche
</a>

    </div>
</div>

<!-- Carte 4 - Ingenieur Generaliste (INGE) -->
<div class="bg-white rounded-lg shadow-md overflow-hidden p-6 relative">
    <div class="absolute top-6 right-6 text-blue-500">
        <i class="fas fa-cogs text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-blue-600 mb-4">Ingenieur Generaliste (INGE)</h3>
    <div class="space-y-2 mb-6">
        <p class="text-gray-600">Concours 1 : 17/05/2025</p>
        <p class="text-gray-600">Concours 2 : 12/07/2025</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('inge') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
            Candidater
        </a>
        <a href="{{ asset('concours/fichier/Fiche d\'inscription concours Ingé Généraliste 2025.pdf') }}" download class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
    Télécharger la fiche
     </a>

    </div>
</div>

<!-- Carte 5 - Ingenieur en genie civil (IGC) -->
<div class="bg-white rounded-lg shadow-md overflow-hidden p-6 relative">
    <div class="absolute top-6 right-6 text-blue-500">
        <i class="fas fa-hard-hat text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-blue-600 mb-4">Ingenieur en genie civil (IGC)</h3>
    <div class="space-y-2 mb-6">
        <p class="text-gray-600">Concours 1 : 17/05/2025</p>
        <p class="text-gray-600">Concours 2 : 22/07/2025</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('civil') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
            Candidater
        </a>
        <a href="{{ asset('concours/fichier/Fiche d\'inscription concours Génie Civil 2025.pdf') }}" download class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-center">
    Télécharger la fiche
</a>

    </div>
</div>


            <!-- Carte 6 - Exemple supplémentaire
            <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 relative">
                <div class="absolute top-6 right-6 text-blue-500">
                    <i class="fas fa-flask text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-blue-600 mb-4">Chimie Industrielle</h3>
                <div class="space-y-2 mb-6">
                    <p class="text-gray-600">Date de début: 18/09/2023</p>
                    <p class="text-gray-600">Date de fin: 18/06/2024</p>
                </div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Candidater
                </button>
            </div>
             -->
        </div>

        <!-- Section des centres de concours -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Centres de Concours</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Centre 1 - Yaoundé -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Yaoundé (Eyang)</h3>
                        <p class="text-gray-600">Campus Par Nkolbisson</p>
                    </div>
                </div>

                <!-- Centre 2 - Douala -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Douala</h3>
                        <p class="text-gray-600">Prepa saint jean (mitoyen au collège Liberman)</p>
                    </div>
                </div>

                <!-- Centre 3 - Bafoussam -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Bafoussam</h3>
                        <p class="text-gray-600">Collège Saint Jean Thomas d'Aquin</p>
                    </div>
                </div>

                <!-- Centre 4 - Limbé -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Limbé</h3>
                        <p class="text-gray-600">Collège Sonara</p>
                    </div>
                </div>

                <!-- Centre 5 - Ngaoundéré -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Ngaoundéré</h3>
                        <p class="text-gray-600">Collège De Mazenod</p>
                    </div>
                </div>

                <!-- Centre 6 - Garoua -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Garoua</h3>
                        <p class="text-gray-600">Collège Ste Thérèse de l'Enfant Jésus</p>
                    </div>
                </div>

                <!-- Centre 7 - Maroua -->
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4 mt-1">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Maroua</h3>
                        <p class="text-gray-600">Collège Jacques de Bernon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
  </div>

  @include('Page.footer')

 <script src="/jscript/concours.js"></script>
 
</body>
</html>