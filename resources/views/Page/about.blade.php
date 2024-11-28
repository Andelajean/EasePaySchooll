<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>A Propos</title>
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

<section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
 <!-- Carte : C'est quoi EasePaySchool -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4" >C'est quoi <span class="font-bold italic text-blue-600">EasePaySchool</span> ?</h2>
        <p class="text-gray-600">
          <span class="font-bold italic text-blue-600">EasePaySchool</span>  est une plateforme conçue pour faciliter le paiement des frais scolaires. 
          Elle connecte parents, écoles et banques, offrant une solution rapide et sécurisée pour gérer les transactions. 
          Notre objectif est de simplifier la vie des utilisateurs en réduisant les contraintes liées aux paiements traditionnels.
        </p>
      </div>

      <!-- Carte : Pourquoi utiliser EasePaySchool -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Pourquoi utiliser <span class="font-bold italic text-blue-600">EasePaySchool</span> ?</h2>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="flex items-start space-x-3">
          <span class="text-blue-500 text-xl">&#9733;</span>
          <p class="text-gray-600">Sécurité et confidentialité des données.</p>
        </div>
        <div class="flex items-start space-x-3">
          <span class="text-blue-500 text-xl">&#9733;</span>
          <p class="text-gray-600">Gain de temps pour les parents et écoles.</p>
        </div>
        <div class="flex items-start space-x-3">
          <span class="text-blue-500 text-xl">&#9733;</span>
          <p class="text-gray-600">Facilité d'utilisation grâce à une interface intuitive.</p>
        </div>
        <div class="flex items-start space-x-3">
          <span class="text-blue-500 text-xl">&#9733;</span>
          <p class="text-gray-600">Assistance en cas de problème.</p>
        </div>
      </div>
      </div>
    </section>

    <!-- Section Qui peut utiliser EasePaySchool -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Qui peut utiliser <span class="font-bold italic text-blue-600">EasePaySchool</span> ?</h2>
      <p class="text-gray-600">
        <span class="font-bold italic text-blue-600">EasePaySchool</span> est destiné à toute personne ou organisation impliquée dans le paiement des frais scolaires :
      </p>
      <ul class="mt-4 space-y-2">
        <li class="flex items-start">
          <span class="text-blue-500 mr-2">&#10003;</span>
          <p class="text-gray-600">Les parents ou tuteurs pour régler les frais de leurs enfants.</p>
        </li>
        <li class="flex items-start">
          <span class="text-blue-500 mr-2">&#10003;</span>
          <p class="text-gray-600">Les écoles pour gérer efficacement les paiements entrants.</p>
        </li>
        <li class="flex items-start">
          <span class="text-blue-500 mr-2">&#10003;</span>
          <p class="text-gray-600">Les institutions financières pour offrir des services bancaires intégrés.</p>
        </li>
      </ul>
    </section>
    <!-- Section Présentation -->
     <!-- Section Qui a développé EasePaySchool -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Qui a développé <span class="font-bold italic text-blue-600">EasePaySchool</span> ?</h2>
      <p class="text-gray-600">
        <span class="font-bold italic text-blue-600">EasePaySchool</span> a été conçu et développé par <span class="font-semibold text-gray-900">Smart Tech Engineering</span>, une entreprise spécialisée dans les solutions technologiques innovantes. 
        À la tête de cette entreprise, se trouve <span class="font-semibold text-gray-900">Gael ANDELA</span>, un leader visionnaire et passionné par les technologies de pointe.
      </p>
      <div class="mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Qualités de Smart Tech Engineering :</h3>
        <ul class="list-disc list-inside text-gray-600">
          <li>Expertise en développement logiciel.</li>
          <li>Solutions innovantes adaptées aux besoins des utilisateurs.</li>
          <li>Engagement envers la qualité et la satisfaction client.</li>
        </ul>
      </div>
     
    </section>

    <!-- Section Fonctionnalités -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
      <h2 class="text-2xl font-semibold text-gray-800">Nos fonctionnalités</h2>
      <ul class="mt-4 space-y-2">
        <li class="flex items-center">
          <span class="text-blue-500 mr-2">&#10003;</span> Paiement sécurisé .
        </li>
        <li class="flex items-center">
          <span class="text-blue-500 mr-2">&#10003;</span> Vérification des  paiements.
        </li>
        <li class="flex items-center">
          <span class="text-blue-500 mr-2">&#10003;</span> Suivi en temps réel des transactions.
        </li>
        <li class="flex items-center">
          <span class="text-blue-500 mr-2">&#10003;</span> Historique des paiements pour les parents et écoles.
        </li>
      </ul>
    </section>

    
  </div>

  @include('Page.footer')

 <script src="/jscript/about.js"></script>
 
</body>
</html>