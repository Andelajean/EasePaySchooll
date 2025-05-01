<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administration</title>
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
<body class="h-screen flex items-center justify-center">

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
   <div class="absolute top-2 w-full text-center">
        <p id="error-message" class="text-white font-bold"></p>
    </div>
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm relative">

   @if ($errors->any())
    <div class="absolute top-20  w-full text-center">
        <p id="error" class="text-red-500 font-bold">
            {{ $errors->first('email') }}
        </p>
    </div>
  @endif

        <div class="flex justify-center mb-6">
            <img src="{{asset('image/logofin.jpg')}}" alt="Logo" class="h-16 w-16"> 
        </div>
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-indigo-700 mb-6">Inscription Administrateur</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('inscription.submit') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="nom" class="block text-gray-700 font-medium">Nom Complet</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" 
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nom') border-red-500 @enderror" 
                   placeholder="Entrez votre nom complet" required>
            @error('nom')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="telephone" class="block text-gray-700 font-medium">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" 
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('telephone') border-red-500 @enderror" 
                   placeholder="Ex: +2250123456789" required>
            @error('telephone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="email" class="block text-gray-700 font-medium">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror" 
                   placeholder="exemple@domain.com" required>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="identifiant" class="block text-gray-700 font-medium">Mot de passe</label>
            <input type="password" id="identifiant" name="identifiant" 
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('identifiant') border-red-500 @enderror" 
                   placeholder="Minimum 8 caractères" required>
            <p class="text-xs text-gray-500 mt-1">Doit contenir: majuscule, minuscule, chiffre et caractère spécial</p>
            @error('identifiant')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="identifiant_confirmation" class="block text-gray-700 font-medium">Confirmer Mot de passe</label>
            <input type="password" id="identifiant_confirmation" name="identifiant_confirmation" 
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   placeholder="Retapez votre mot de passe" required>
        </div>
        
        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                S'inscrire
            </button>
        </div>
    </form>
</div>

     <script src="/jscript/login_concours.js">
  </script>
  </body>
</html>