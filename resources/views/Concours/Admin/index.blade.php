<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Accueil - Dashboard</title>
  <style>
    .animate-fade-in-out {
        animation: fadeInOut 3s ease-in-out forwards;
    }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-20px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-20px); }
    }
</style>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

  <!-- Sidebar -->
  <aside class="w-64 bg-blue-700 text-white p-4 space-y-4">
    <h2 class="text-xl font-bold mb-6">Dashboard</h2>
    <nav class="space-y-2">
      <a href="{{route('admin_concours.index')}}" class="block px-4 py-2 bg-white text-blue-700 font-semibold rounded border border-blue-700 hover:bg-blue-100">Accueil</a>
      <a href="{{route('admin_concours.finance')}}" class="block px-4 py-2 bg-white text-blue-700 font-semibold rounded border border-blue-700 hover:bg-blue-100">M & F</a>
      <a href="{{route('admin_concours.geoscience')}}" class="block px-4 py-2 bg-white text-blue-700 font-semibold rounded border border-blue-700 hover:bg-blue-100"> INGEA</a>
      <a href="{{route('admin_concours.inge')}}" class="block px-4 py-2 bg-white text-blue-700 font-semibold rounded border border-blue-700 hover:bg-blue-100">InGé</a>
      <a href="{{route('admin_concours.civil')}}" class="block px-4 py-2 bg-white text-blue-700 font-semibold rounded border border-blue-700 hover:bg-blue-100">IGC</a>
      <a href="{{route('admin_concours.politique')}}" class="block px-4 py-2 bg-white text-blue-700 font-semibold rounded border border-blue-700 hover:bg-blue-100">SPH</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">

    <!-- Navbar -->
    <header class="bg-red-600 text-gray-900 shadow p-4 flex justify-between items-center">
    <h1 class="text-lg font-semibold text-white">Accueil</h1>
      <div class="flex items-center gap-4">
            <button  id="sessionBtn" class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Session</button>
            <a href="{{route('admin_concours.profil')}}" class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Profil</a>
            <a href="{{route('admin_concours.logout')}}" class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Se déconnecter</a>
      </div>

<!-- Fenêtre modale pour les sessions -->

<div id="sessionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-96">
    <h2 class="text-xl font-semibold mb-4">Nouvelle Session</h2>
    <form action="{{ route('sessions.store') }}" method="POST" class="space-y-4">
      @csrf
      
      <!-- Nom Session -->
      <div class="mb-4">
        <label for="nom_session" class="block text-sm font-medium text-gray-700 mb-1">Nom Session*</label>
        <input 
          type="text" 
          id="nom_session" 
          name="nom_session" 
          value="{{ old('nom_session') }}"
          class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 @error('nom_session') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
          required
        >
        @error('nom_session')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Date Début -->
      <div class="mb-4">
        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date début*</label>
        <input 
          type="date" 
          id="date_debut" 
          name="date_debut" 
          value="{{ old('date_debut') }}"
          class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 @error('date_debut') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
          required
        >
        @error('date_debut')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

     <!-- Date Fin -->
<div class="mb-4">
    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date fin* (avant le concours)</label>
    <input 
        type="date" 
        id="date_fin" 
        name="date_fin" 
        value="{{ old('date_fin') }}"
        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 @error('date_fin') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
        required
    >
    @error('date_fin')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Date Concours -->
<div class="mb-4">
    <label for="date_concours" class="block text-sm font-medium text-gray-700 mb-1">Date du concours* (après la fin)</label>
    <input 
        type="date" 
        id="date_concours" 
        name="date_concours" 
        value="{{ old('date_concours') }}"
        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 @error('date_concours') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
        required
    >
    @error('date_concours')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
      

      <!-- Filière -->
      <div class="mb-4">
        <label for="nom_filiere" class="block text-sm font-medium text-gray-700 mb-1">Filière*</label>
        <select 
          id="nom_filiere" 
          name="nom_filiere" 
          class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 @error('nom_filiere') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
          required
        >
          <option value="">Sélectionnez une filière</option>
          <option value="M&F" @selected(old('nom_filiere') == 'M&F')>M & F</option>
          <option value="INGE" @selected(old('nom_filiere') == 'INGE')>INGE</option>
          <option value="IGC" @selected(old('nom_filiere') == 'IGC')>IGC</option>
          <option value="INGEA" @selected(old('nom_filiere') == 'INGEA')>INGEA</option>
          <option value="SPH" @selected(old('nom_filiere') == 'SPH')>SPH</option>
        </select>
      </div>

      <!-- Messages généraux -->
      @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
          {{ session('error') }}
        </div>
      @endif

      <!-- Boutons -->
      <div class="flex justify-end gap-3">
        <button 
          type="button" 
          id="cancelSession" 
          class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-red-300"
        >
          Annuler
        </button>
        <button 
          type="submit" 
          class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
        >
          Enregistrer
        </button>
      </div>
    </form>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const dateDebut = document.getElementById('date_debut');
  const dateFin = document.getElementById('date_fin');
  const dateConcours = document.getElementById('date_concours');
  
  // Initialisation des dates min
  const today = new Date();
  dateDebut.min = formatDate(today);
  
  // Ecouteurs d'événements
  dateDebut.addEventListener('change', updateDateConstraints);
  dateFin.addEventListener('change', updateConcoursMinDate);
  
  function updateDateConstraints() {
    if (!dateDebut.value) return;
    
    const debutDate = new Date(dateDebut.value);
    const finMinDate = new Date(debutDate);
    finMinDate.setDate(debutDate.getDate() + 1);
    
    // Mise à jour date fin
    dateFin.min = formatDate(finMinDate);
    if (dateFin.value && new Date(dateFin.value) < finMinDate) {
      dateFin.value = '';
      dateConcours.value = '';
    }
    
    // Mise à jour date concours si date fin existe
    if (dateFin.value) {
      updateConcoursMinDate();
    }
  }
  
  function updateConcoursMinDate() {
    if (!dateFin.value) return;
    
    const finDate = new Date(dateFin.value);
    const concoursMinDate = new Date(finDate);
    concoursMinDate.setDate(finDate.getDate() + 1);
    
    // Mise à jour date concours
    dateConcours.min = formatDate(concoursMinDate);
    if (dateConcours.value && new Date(dateConcours.value) < concoursMinDate) {
      dateConcours.value = '';
    }
  }
  
  function formatDate(date) {
    return date.toISOString().split('T')[0];
  }
  
  // Initialisation au chargement
  if (dateDebut.value) {
    updateDateConstraints();
  }
  if (dateFin.value) {
    updateConcoursMinDate();
  }
});
</script>

<script>
  // Gestion de la fenêtre modale
  const sessionBtn = document.getElementById('sessionBtn');
  const sessionModal = document.getElementById('sessionModal');
  const cancelSession = document.getElementById('cancelSession');
  
  sessionBtn.addEventListener('click', () => {
    sessionModal.classList.remove('hidden');
  });
  
  cancelSession.addEventListener('click', () => {
    sessionModal.classList.add('hidden');
  });
  
  // Gestion de la soumission du formulaire
  document.getElementById('sessionForm').addEventListener('submit', (e) => {
    e.preventDefault();
    // Récupérer les valeurs du formulaire
    const sessionName = document.getElementById('sessionName').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    // Ici vous pouvez ajouter le code pour traiter les données
    console.log({sessionName, startDate, endDate});
    
    // Fermer la modale
    sessionModal.classList.add('hidden');
    
    // Réinitialiser le formulaire
    e.target.reset();
  });
</script>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-bold mb-6">Statistiques générales</h2>
      @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-out transition-all duration-300">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-out transition-all duration-300">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif
      <!-- 5 Divs Solides -->
      <div class="space-y-8">
    <!-- Section des cartes -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Statistiques par filière</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-300 hover:shadow-lg transition-shadow">
                <p class="text-gray-500 text-sm">Management & Finances</p>
                <h3 class="text-2xl font-bold">{{ $managementCount }}</h3>
                <p class="text-green-600 font-semibold">Total: {{ number_format($managementTotal, 0, ',', ' ') }} FCFA</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-300 hover:shadow-lg transition-shadow">
                <p class="text-gray-500 text-sm">Géosciences</p>
                <h3 class="text-2xl font-bold">{{ $geosciencesCount }}</h3>
                <p class="text-green-600 font-semibold">Total: {{ number_format($geosciencesTotal, 0, ',', ' ') }} FCFA</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-300 hover:shadow-lg transition-shadow">
                <p class="text-gray-500 text-sm">Politiques</p>
                <h3 class="text-2xl font-bold">{{ $politiquesCount }}</h3>
                <p class="text-green-600 font-semibold">Total: {{ number_format($politiquesTotal, 0, ',', ' ') }} FCFA</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-300 hover:shadow-lg transition-shadow">
                <p class="text-gray-500 text-sm">Généralistes</p>
                <h3 class="text-2xl font-bold">{{ $generalistesCount }}</h3>
                <p class="text-green-600 font-semibold">Total: {{ number_format($generalistesTotal, 0, ',', ' ') }} FCFA</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-300 hover:shadow-lg transition-shadow">
                <p class="text-gray-500 text-sm">Civils</p>
                <h3 class="text-2xl font-bold">{{ $civilsCount }}</h3>
                <p class="text-green-600 font-semibold">Total: {{ number_format($civilsTotal, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    </div>

    <!-- Section du graphique -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Visualisation des inscriptions</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="w-full h-96">
                <canvas id="inscriptionsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Script pour le graphique -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('inscriptionsChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Nombre d\'inscriptions',
                    data: @json($chartData['counts']),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            footer: (tooltipItems) => {
                                const total = @json($chartData['totals'])[tooltipItems[0].dataIndex];
                                return 'Total: ' + new Intl.NumberFormat().format(total) + ' FCFA';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
    </main>
  </div>
</body>
</html>
