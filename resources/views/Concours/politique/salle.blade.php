<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SPH- Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    <header class="bg-red-600 text-white shadow p-4 flex justify-between items-center">
      <h1 class="text-lg font-semibold"> SPH (Liste des candidats)</h1>
      <div class="flex items-center gap-4">
        <button class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Profil</button>
        <button class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Se déconnecter</button>
      </div>
    </header>

    <!-- Page Content -->
   <main class="flex-1 p-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Liste Des Candidats Par ordre alphabetique pour la Filière  SPH</h2>
    <div class="flex space-x-4">
        <!-- Bouton Tri Alphabétique -->
        <a href="{{ route('admin_concours.geoscience', ['alphabetical' => true]) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded flex items-center">
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
           </svg>
          Rerour
        </a>
        
        <!-- Bouton Attribuer Salles -->
        <button onclick="showRoomModal()" 
                class="bg-green-600 text-white px-4 py-2 rounded flex items-center">
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
           </svg>
           Attribuer les salles
        </button>
    </div>
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
</div>

<!-- Modal pour l'attribution des salles -->
<div id="roomModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Attribution des salles</h3>
            
            <form method="POST" action="{{ route('candidates.assign-rooms.igea') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nombre d'étudiants par salle</label>
                    <input type="number" name="students_per_room" 
                           class="w-full px-3 py-2 border rounded-md" 
                           min="1" required>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideRoomModal()" 
                            class="px-4 py-2 border rounded-md">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md">
                        Appliquer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Boutons d'actions après attribution -->
@if($candidates->isNotEmpty() && $candidates[0]->exam_room)
<div class="flex justify-end space-x-4 mb-6">
    <a href="{{ route('candidates.print-rooms.politique') }}" target="_blank"
       class="bg-gray-200 px-4 py-2 rounded-md flex items-center">
       <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
       </svg>
       Imprimer
    </a>
    
    <form method="POST" action="{{ route('candidates.share-rooms.politique') }}">
    @csrf
    <input type="hidden" name="candidate_ids" value="{{ $candidates->pluck('id')->toJson() }}">
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
           </svg>
           Partager par email
        </button>
    </form>
</div>
@endif

<!-- Tableau des candidats -->
<table class="w-full border">
    <!-- En-têtes du tableau -->
    <thead>
        <tr class="bg-gray-100">
            <th class="p-3 text-left">Nom</th>
            <th class="p-3 text-left">Prénom</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Salle</th>
            <th class="p-3 text-left">Place</th>
        </tr>
    </thead>
    <!-- Corps du tableau -->
    <tbody>
        @foreach($candidates as $candidate)
        <tr class="border-t">
            <td class="p-3">{{ $candidate->nom }}</td>
            <td class="p-3">{{ $candidate->prenom }}</td>
            <td class="p-3">{{ $candidate->email }}</td>
            <td class="p-3">{{ $candidate->exam_room ?? '-' }}</td>
            <td class="p-3">{{ $candidate->exam_seat ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="mt-4">
    {{ $candidates->links() }}
</div>

<script>
function showRoomModal() {
    document.getElementById('roomModal').classList.remove('hidden');
}

function hideRoomModal() {
    document.getElementById('roomModal').classList.add('hidden');
}
</script>
        

           
        </div>
    </div>
</main>

  </div>
</body>
</html>
