<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EasePaySchool - Accueil</title>
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
   <link href="/style/index.css" rel="stylesheet">
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

<h2 id="message" class="font-sans font-bold text-white text-2xl"></h2>

<section id="container">
 
  <div id="slider-container">
    <ul class="images-container">
      <li>
        
        <img src="{{asset('image/10.jpg')}}" alt="Image 1">
         <div class="overlay">
          <h3 class="image-caption">Avec EasePaySchool , Payez la scolarité de vos enfants depuis votre bureau</h3>
          <a href="{{route('register')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Créer un compte
</a>
<a href="{{route('paiement')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Effectuer paiement
</a>

        </div>
      </li>
      <li>
      <!-- Bouton fixe pour "Effectuer un paiement" -->
<a href="{{route('paiement')}}" 
   class="fixed-button bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 text-lg font-semibold">
   Effectuer un paiement
</a>

        
        <img src="{{asset('image/9.jpg')}}" alt="Image 2">
         <div class="overlay">
          <h3 class="image-caption">Avec EasePaySchool , c'est facile et c'est simple !!</h3>
         <a href="{{route('register')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Créer un compte
</a>
<a href="{{route('paiement')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Effectuer paiement
</a>

        </div>
      </li>
      <li>
        
        <img src="{{asset('image/8.jpg')}}" alt="Image 3">
         <div class="overlay">
          <h3 class="image-caption">Même au salon , vous payez la scolarité de vos enfants , plus besoin d'aller s'aligner à la banque pour payer!!</h3>
          <a href="{{route('register')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Créer un compte
</a>
<a href="{{route('paiement')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Effectuer paiement
</a>

        </div>
      </li>
      <li>
        
        <img src="{{asset('image/7.jpg')}}" alt="Image 4">
         <div class="overlay">
          <h3 class="image-caption">C'est Simple et c'est facile , pas besoin de se deplacer pour payer vos frais de scolarité</h3>
          <a href="{{route('register')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Créer un compte
</a>
<a href="{{route('paiement')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Effectuer paiement
</a>
        </div>
      </li>
      <li>
        <img src="{{asset('image/6.jpg')}}" alt="Image 5">
         <div class="overlay">
          <h3 class="image-caption">Même en marchant , ça se paye en 3 clics !</h3>
         <a href="{{route('register')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Créer un compte
</a>
<a href="{{route('paiement')}}" class="cta-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Effectuer paiement
</a>

        </div>
      </li>
    </ul>
    <span class="arrow a-left"></span>
    <span class="arrow a-right"></span>
    <div class='bullets-container'></div>
  </div>
</section>
<!-- Section container -->
<section class="px-4 py-8">
    <!-- Title -->
    <h2 class="text-2xl font-bold text-center mb-8" id="messa"></h2>
    <!-- Cards container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-2">Gestion simplifiée</h3>
            <p class="text-gray-700 mb-4">Avec EasePaySchool, centralisez toutes vos transactions scolaires en un seul endroit, ce qui simplifie la gestion pour les parents et les écoles.</p>
   
            <div class="flex gap-2 mt-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="showMessage('Android')">Télécharger pour Android</button>
                <button class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900" onclick="showMessage('iOS')">Télécharger pour Apple</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-2">Paiements sécurisés</h3>
            <p class="text-gray-700 mb-4">EasePaySchool garantit la sécurité des paiements, offrant aux parents et aux écoles une solution fiable pour toutes les transactions.</p>
         
            <div class="flex gap-2 mt-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="showMessage('Android')">Télécharger pour Android</button>
                <button class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900" onclick="showMessage('iOS')">Télécharger pour Apple</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-2">Suivi en temps réel</h3>
            <p class="text-gray-700 mb-4">Suivez toutes les transactions en temps réel et gardez un historique clair et détaillé des paiements effectués pour chaque élève.</p>
            <div class="flex gap-2 mt-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="showMessage('Android')">Télécharger pour Android</button>
                <button class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900" onclick="showMessage('iOS')">Télécharger pour Apple</button>
            </div>
        </div>
    </div>
</section>

<script>
    function showMessage(platform) {
        alert(`La version ${platform} n'est pas encore disponible.`);
    }
</script>

<!-- Section container -->
<!-- Section container -->
<section class="px-4 py-8 space-y-8">
    <!-- Card 1 -->
    <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <!-- Image of person using a phone at their desk -->
        <div class="w-full md:w-1/2">
            <img src="{{ asset('image/DALL·E 2024-11-04 04.00.59 - A professional setting with a person sitting at their desk using a smartphone. The background shows a clean, organized office space with a computer an.webp') }}" 
                 alt="Personne utilisant son téléphone depuis son bureau" 
                 class="w-full h-96 object-cover border-r-2 border-gray-200">
        </div>
        <!-- Text content -->
        <div class="p-6 md:w-1/2 flex flex-col justify-between">
            <div>
                <h3 class="text-2xl font-semibold mb-4">Paiement simplifié depuis votre bureau</h3>
                <p class="text-gray-700 mb-4">Avec EasePaySchool, les parents peuvent régler les frais de scolarité en toute simplicité depuis leur bureau. L'application permet un suivi en temps réel des transactions et offre une solution de paiement rapide et sécurisée.</p>
            </div>
            <!-- Stars -->
            <div class="flex justify-center text-yellow-500 text-4xl mt-4">
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9734;</span>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="flex flex-col md:flex-row-reverse bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <!-- Image of person paying from their vehicle -->
        <div class="w-full md:w-1/2">
            <img src="{{ asset('image/DALL·E 2024-11-04 04.00.48 - A person sitting in their vehicle using a smartphone, making an online payment. The background shows a modern car interior, with the person focused on.webp') }}" 
                 alt="Personne effectuant un paiement depuis son véhicule" 
                 class="w-full h-96 object-cover border-l-2 border-gray-200">
        </div>
        <!-- Text content -->
        <div class="p-6 md:w-1/2 flex flex-col justify-between">
            <div>
                <h3 class="text-2xl font-semibold mb-4">Paiement mobile, même en déplacement</h3>
                <p class="text-gray-700 mb-4">EasePaySchool permet aux parents de payer les frais de scolarité même lorsqu’ils sont en déplacement, directement depuis leur véhicule. Une solution flexible et adaptée à un mode de vie actif.</p>
            </div>
            <!-- Stars -->
            <div class="flex justify-center text-yellow-500 text-4xl mt-4">
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9734;</span>
            </div>
        </div>
    </div>
</section>
@include('Page.footer')


 <script src="/jscript/about.js"></script>

 <script src="/jscript/index.js"></script>
</body>
</html>
