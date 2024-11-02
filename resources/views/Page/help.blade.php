<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aide</title>
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
<div class="max-w-2xl mx-auto my-10 p-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Trouvez de l'aide Ici</h2>

    <!-- Question 1 -->
    <div class="mb-4">
        <button onclick="toggleAnswer(1)" class="w-full text-left py-3 px-4 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:bg-gray-200">
            <span class="font-semibold text-gray-800">1. Comment effectuer un Paiement??</span>
        </button>
        <div id="answer-1" class="mt-2 hidden">
            <p class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
            Pour effectuer un <a href="{{ route('paiement') }}" class="text-blue-500 underline">paiement</a>, veuillez d'abord cliquer sur <a href="{{ route('paiement') }}" class="text-blue-500 underline">paiement</a>. Ensuite, dans la barre de recherche, saisissez le nom de votre établissement. Parmi les suggestions affichées, sélectionnez le nom de l'établissement pour lequel vous souhaitez effectuer le paiement. Remplissez les champs requis, puis cliquez sur "Payer". Après la transaction, vous aurez la possibilité de télécharger votre reçu de paiement.
            </p>

        </div>
    </div>

    <!-- Question 2 -->
    <div class="mb-4">
        <button onclick="toggleAnswer(2)" class="w-full text-left py-3 px-4 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:bg-gray-200">
            <span class="font-semibold text-gray-800">2. Comment Verifier un Paiement?</span>
        </button>
        <div id="answer-2" class="mt-2 hidden">
           <p class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
    Pour vérifier un paiement, veuillez renseigner l'ID du paiement dans la barre de recherche située sur la barre de navigation, puis cliquez sur "Vérifier". Le reçu du paiement s'affichera. Vous pouvez également scanner le QR code pour obtenir les détails du paiement.
        </p>

        </div>
    </div>

    <!-- Question 3 -->
    <div class="mb-4">
        <button onclick="toggleAnswer(3)" class="w-full text-left py-3 px-4 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:bg-gray-200">
            <span class="font-semibold text-gray-800">3. Comment Suivre Un Elève ( Voir ses Uniformes reçus , restant...)??</span>
        </button>
        <div id="answer-3" class="mt-2 hidden">
            <p class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
              Pour avoir les informations sur un élève / etudiant , vous devez <a href="{{ route('register') }}" class="text-blue-500 underline">Créer un Compte</a> , ou vous <a href="{{ route('login') }}" class="text-blue-500 underline">Connecter à Votre compte</a> s'il existe déja.
            </p>
        </div>
    </div>

    <!-- Question 4 -->
    <div class="mb-4">
        <button onclick="toggleAnswer(4)" class="w-full text-left py-3 px-4 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:bg-gray-200">
            <span class="font-semibold text-gray-800">4. Comment contacter le support Administrateur?</span>
        </button>
        <div id="answer-4" class="mt-2 hidden">
            <p class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
                Vous pouvez contacter le support Administrateur via notre page de <a href="{{ route('paiement') }}" class="text-blue-500 underline">Contact</a> ou en envoyant un email à support@exemple.com.
            </p>
        </div>
    </div>
</div>


 <script src="/jscript/help.js"></script>
</body>
</html>
