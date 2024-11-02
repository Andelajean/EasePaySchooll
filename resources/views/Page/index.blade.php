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
          <a href="{{route('login')}}" class="cta-button">Créer un compte</a>
          <a href="{{route('paiement')}}" class="cta-button">Effectuer paiement</a>
        </div>
      </li>
      <li>
        
        <img src="{{asset('image/9.jpg')}}" alt="Image 2">
         <div class="overlay">
          <h3 class="image-caption">Avec EasePaySchool , c'est facile et c'est simple !!</h3>
          <a href="{{route('login')}}" class="cta-button">Créer un compte</a>
          <a href="{{route('paiement')}}" class="cta-button">Effectuer paiement</a>
        </div>
      </li>
      <li>
        
        <img src="{{asset('image/8.jpg')}}" alt="Image 3">
         <div class="overlay">
          <h3 class="image-caption">Même au salon , vous payez la scolarité de vos enfants , plus besoin d'aller s'aligner à la banque pour payer!!</h3>
          <a href="{{route('login')}}" class="cta-button">Créer un compte</a>
          <a href="{{route('paiement')}}" class="cta-button">Effectuer paiement</a>
        </div>
      </li>
      <li>
        
        <img src="{{asset('image/7.jpg')}}" alt="Image 4">
         <div class="overlay">
          <h3 class="image-caption">C'est Simple et c'est facile , pas besoin de se deplacer pour payer vos frais de scolarité</h3>
          <a href="{{route('login')}}" class="cta-button">Créer un compte</a>
          <a href="{{route('paiement')}}" class="cta-button">Effectuer paiement</a>
        </div>
      </li>
      <li>
        <img src="{{asset('image/6.jpg')}}" alt="Image 5">
         <div class="overlay">
          <h3 class="image-caption">Même en marchant , ça se paye en 3 clics !</h3>
          <a href="{{route('login')}}" class="cta-button">Créer un compte</a>
          <a href="{{route('paiement')}}" class="cta-button">Effectuer paiement</a>
        </div>
      </li>
    </ul>
    <span class="arrow a-left"></span>
    <span class="arrow a-right"></span>
    <div class='bullets-container'></div>
  </div>
</section>

 <script src="/jscript/index.js"></script>
</body>
</html>
