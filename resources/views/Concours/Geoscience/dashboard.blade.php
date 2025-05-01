<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Accueil - Dashboard</title>
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
    <header class="bg-red-600 text-white shadow p-4 flex justify-between items-center">
      <h1 class="text-lg font-semibold">la Geoscience,Environnement et Agro-Industrie (IGEA)</h1>
      <div class="flex items-center gap-4">
      <a href="{{route('admin_concours.profil')}}" class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Profil</a>
      <a href="{{route('admin_concours.logout')}}" class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-red-100">Se déconnecter</a>
      </div>
    </header>

    <!-- Page Content -->
   <main class="flex-1 p-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Gestion des Candidats pour la Filière  Geoscience,Environnement et Agro-Industrie</h2>
    <div class="flex space-x-4">
         <!-- Bouton Tri Alphabétique -->
         <a href="{{ route('salles.attribution_sph', ['alphabetical' => true]) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded flex items-center">
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
           </svg>
           Trier par ordre alphabétique
        </a>
        <button onclick="openResultsModal()"
            class="bg-green-600 text-white px-4 py-2 rounded flex items-center hover:bg-green-700 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Partager les résultats
    </button>
    </div>
</div>



        <div class="px-6 py-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prénom</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sexe</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naissance</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nationalité</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Région</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">BAC</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fichiers</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($candidates as $candidate)
                        <tr>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $candidate->id }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $candidate->nom }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $candidate->prenom }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $candidate->sexe }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $candidate->date_naissance }}<br>
                                <small class="text-gray-400">{{ $candidate->lieu_naissance }}</small>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $candidate->nationalite }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $candidate->region_origine }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $candidate->telephone }}<br>
                                <small class="text-blue-500">{{ $candidate->email }}</small>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($candidate->titulaire_bac)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Oui</span>
                                    @if($candidate->diplome_bac_path)
                                        <a href="{{ Storage::url($candidate->diplome_bac_path) }}" target="_blank" class="text-blue-500 text-xs">Voir</a>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Non</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                <div class="grid grid-cols-2 gap-1 text-xs">
                                    <a href="{{ Storage::url($candidate->bulletin_seconde_path) }}" target="_blank" class="text-blue-500">Bulletin 2nde</a>
                                    <a href="{{ Storage::url($candidate->bulletin_premiere_path) }}" target="_blank" class="text-blue-500">Bulletin 1ère</a>
                                    <a href="{{ Storage::url($candidate->bulletin_terminale_path) }}" target="_blank" class="text-blue-500">Bulletin Tle</a>
                                    <a href="{{ Storage::url($candidate->diplome_probatoire_path) }}" target="_blank" class="text-blue-500">Probatoire</a>
                                    <a href="{{ Storage::url($candidate->piece_identite_recto_path) }}" target="_blank" class="text-blue-500">PI Recto</a>
                                    <a href="{{ Storage::url($candidate->piece_identite_verso_path) }}" target="_blank" class="text-blue-500">PI Verso</a>
                                    <a href="{{ Storage::url($candidate->certificat_scolarite_path) }}" target="_blank" class="text-blue-500">Certif. Scol.</a>
                                    <a href="{{ Storage::url($candidate->fiche_inscription_path) }}" target="_blank" class="text-blue-500">Fiche Inscrip.</a>
                                    <a href="{{ Storage::url($candidate->photo_path) }}" target="_blank" class="text-blue-500">Photo</a>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" onclick="openEmailModal('{{ $candidate->email }}')" class="text-indigo-600 hover:text-indigo-900 mr-2" title="Envoyer un email">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
    </svg>
</a>
                                <a href="{{ Storage::url($candidate->adresse) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Voir adresse">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $candidates->links() }}
            </div>
        </div>
    </div>
    <!-- Modale d'envoi d'email -->
<div id="emailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Envoyer un email</h3>
            <div class="mt-2 px-7 py-3">
                <form id="emailForm" action="{{ route('send.email') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" id="recipientEmail">
                    
                    <div class="mb-4">
                        <label for="emailSubject" class="block text-sm font-medium text-gray-700">Sujet</label>
                        <input type="text" name="subject" id="emailSubject" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="emailBody" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="body" id="emailBody" rows="6" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                  required></textarea>
                    </div>
                    
                    <div class="items-center px-4 py-3">
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Envoyer
                        </button>
                        <button type="button" onclick="closeEmailModal()" 
                                class="ml-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modale de partage des résultats -->
<div id="resultsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Partager les résultats</h3>
            <div class="mt-2 px-7 py-3">
                <form id="resultsForm" enctype="multipart/form-data" action="{{ route('share.results.geoscience') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fichier des résultats (PDF)</label>
                        <input type="file" id="resultsFile" name="results_file" accept=".pdf" 
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100" required>
                    </div>
                    <div class="mb-4">
                        <label for="emailSubject" class="block text-sm font-medium text-gray-700">Sujet du mail</label>
                        <input type="text" id="emailSubject" name="subject" value="Résultats du concours"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="emailMessage" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="emailMessage" name="message" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">Veuillez trouver ci-joint les résultats du concours.</textarea>
                    </div>
                    <div class="items-center px-4 py-3">
                <button onclick="shareResults()"
                        class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Envoyer
                </button>
                <button onclick="closeResultsModal()"
                        class="ml-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Annuler
                </button>
            </div>
                </form>
            </div>
           
        </div>
    </div>
</div>
<script>
    // Fonction pour ouvrir la modale
    function openEmailModal(email) {
        document.getElementById('recipientEmail').value = email;
        document.getElementById('emailModal').classList.remove('hidden');
        document.getElementById('emailSubject').focus();
    }

    // Fonction pour fermer la modale
    function closeEmailModal() {
        document.getElementById('emailModal').classList.add('hidden');
        document.getElementById('emailForm').reset();
    }

    // Fermer la modale si on clique en dehors
    window.addEventListener('click', (event) => {
        if (event.target === document.getElementById('emailModal')) {
            closeEmailModal();
        }
    });
</script>

<script>
    // Gestion de la modale
    function openResultsModal() {
        document.getElementById('resultsModal').classList.remove('hidden');
    }

    function closeResultsModal() {
        document.getElementById('resultsModal').classList.add('hidden');
        document.getElementById('resultsForm').reset();
    }

    // Envoi des résultats
    

    // Fermer la modale si clic en dehors
    window.addEventListener('click', (event) => {
        if (event.target === document.getElementById('resultsModal')) {
            closeResultsModal();
        }
    });
</script>
</main>

  </div>
</body>
</html>
