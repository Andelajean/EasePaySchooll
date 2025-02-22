
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
  <meta name="description" content="EasePaySchool est une plateforme qui permet de faciliterles paiements de frais de scolarité. grace à  son systeme de paiement en ligne , il devient la première application dans ce secteur.">
    <title>Dashbord Ecole</title>
    <script src="https://cdn.tailwindcss.com"></script>
   
</head>
<body>
    <div class="flex flex-col h-screen">
        <!-- Barre supérieure -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md">
        <div class="w-1/3">
                        <form action="#" class="relative flex items-center bg-blue-500 p-2 rounded-lg">
                            <input type="text" id="search-input" name="search" placeholder="Rechercher un élève, entrez son Nom" required class="w-full p-2 rounded-md outline-none text-white bg-blue-500 placeholder-white">
                        </form>
                    </div>

                    <!-- Nom de l'école centré -->
                    <div class="flex-grow text-center bg-gray-200 p-2 rounded-lg">
                        @if(Session::has('ecole'))
                            {{ Session::get('ecole')->nom_ecole }}  
                        @else
                            Invité <!-- Si aucune école n'est connectée, afficher 'Invité' -->
                        @endif
                    </div>

                    <!-- Boutons des paramètres et du profil -->
                    <div class="flex space-x-4">
                        <a href="{{route('penalite')}}" class=" text-white px-4 py-2 rounded-lg">
                            <img src="{{asset('img/parametre.png')}} " alt="Paramètres" class="w-6 h-6">
                        </a>
                        <a href="{{ route('profil') }}" class=" text-white px-4 py-2 rounded-lg">
                            <img src="{{asset('img/profil1.png')}}" alt="Profil" class="w-6 h-6">
                        </a>
                        <a href="{{route('logoute')}}" class="bg-red-500 text-white px-4 py-2 rounded-lg">
                            Se connecter
                        </a>
                    </div>
        </div>
        
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-64 bg-gray-800 text-white h-full p-4">
                <h2 class="text-xl font-bold mb-4">DashBoard</h2>
                <div>
                    <!-- Paiements -->
                    <div>
                        <button class="flex items-center w-full p-3 hover:bg-gray-700" onclick="toggleTab('paiements')">
                            💵 Paiements
                        </button>
                        <div id="paiements" class="hidden pl-6 bg-gray-700">
                            <ul class="mt-2 space-y-2">
                                <li class="active"><a href="{{route('dashboard_ecole')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('dashboard_ecole') ? 'bg-blue-700 text-white' : '' }}">Paiement D'Aujourd'hui</a></li>
                                <li><a href="{{route('classe')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('classe') ? 'bg-blue-700 text-white' : '' }}">Paiement Par Classe</a></li>
                               
                                <li><a href="{{route('banque')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('banque') ? 'bg-blue-700 text-white' : '' }}">Paiement Par Banque</a></li>
                                <li><a href="{{route('banque_classe')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('banque_classe') ? 'bg-blue-700 text-white' : '' }}">Paiement Par Classe et Par Banque</a></li>
                            
                                <li><a href="{{route('classe_tranche')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('classe_tranche') ? 'bg-blue-700 text-white' : '' }}">Paiement Par Classe et Par Tranche</a></li>
                                <li><a href="{{route('tranche')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('tranche') ? 'bg-blue-700 text-white' : '' }}">Paiement Par Tranche</a></li>
                                <li><a href="{{route('tout')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('tout') ? 'bg-blue-700 text-white' : '' }}">Tous les Paiements</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Uniforme -->
                    <div>
                        <button class="flex items-center w-full p-3 hover:bg-gray-700" onclick="toggleTab('uniforme')">
                            👕 Uniforme et Materiel
                        </button>
                        <div id="uniforme" class="hidden pl-6 bg-gray-700">
                        <ul class="mt-2 space-y-2">
                                <li><a href="{{route('distribution')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('distribution') ? 'bg-blue-700 text-white' : '' }}">Receptionner le Materiel</a></li>
                                <li><a href="{{route('distribuer')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('distribuer') ? 'bg-blue-700 text-white' : '' }}">Materiel Recu</a></li>
                                <li><a href="{{route('reception')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('reception') ? 'bg-blue-700 text-white' : '' }}">Distribution Des Uniformes Scolaires</a></li>
                                <li><a href="{{route('recus')}}" class="block px-4 py-2 rounded hover:bg-blue-700 {{ request()->routeIs('recus') ? 'bg-blue-700 text-white' : '' }}">Liste Des Uniformes Distribués</a></li>
                        </ul>
                        </div>
                    </div>

                    <!-- Pénalité -->
                    <div>
                        <button class="flex items-center w-full p-3 hover:bg-gray-700" onclick="toggleTab('penalite')">
                            ⚠️ Pénalité
                        </button>
                        <div id="penalite" class="hidden pl-6 bg-gray-700">
                            <ul class="mt-2 space-y-2">
                                <li><a href="{{route('calculer_penalites')}}" class="block px-4 py-2 rounded hover:bg-blue-700{{ request()->routeIs('calculer_penalites') ? 'bg-blue-700 text-white' : '' }}">Penalité Par classe</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contenu principal -->
            <div class="flex-1 p-6">
            <div class="main-content-inner">
                    <div class="sales-report-area mt-5 mb-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="single-report bg-gradient-to-r from-blue-400 to-blue-600 p-4 shadow-md rounded-lg text-white">
                             <div class="s-report-inner">
                                    <div class="icon text-3xl"><i class="fa fa-btc"></i></div>
                                    <div class="s-report-title flex justify-between">
                                        <h4 class="header-title mb-0">Paiements d'aujourd'hui</h4>
                                    </div>
                                    <div class="flex justify-between pb-2">
                                        <h2> {{ count($paiementsAujourdhui) }} </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="single-report bg-gradient-to-r from-green-400 to-green-600 p-4 shadow-md rounded-lg text-white">
                                <div class="s-report-inner">
                                    <div class="icon text-3xl"><i class="fa fa-money-bill"></i></div>
                                    <div class="s-report-title flex justify-between">
                                        <h4 class="header-title mb-0">Paiements d'hier</h4>
                                    </div>
                                    <div class="flex justify-between pb-2">
                                        <h2>{{ count($paiementsHier) }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="single-report bg-gradient-to-r from-yellow-400 to-yellow-600 p-4 shadow-md rounded-lg text-white">
                                <div class="s-report-inner">
                                    <div class="icon text-3xl"><i class="fa fa-eur"></i></div>
                                    <div class="s-report-title flex justify-between">
                                        <h4 class="header-title mb-0">Tous les paiements</h4>
                                    </div>
                                    <div class="flex justify-between pb-2">
                                        <h2>{{ count($paiementsTotal) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                     <div class="page-title-area bg-gray-100 p-4 rounded-lg shadow-md mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div>
                            <h4 class="text-xl font-semibold">Dashboard</h4>
                            <ul class="flex space-x-2 text-sm text-gray-600">
                                <li><a href="{{ route('dashboard_ecole') }}" class="hover:text-blue-600">Home</a></li>
                                <li><span class="text-blue-400">/ Paiement Par Classe et Par Tranche</span></li>
                            </ul>
                        </div>
                        
                        <!-- Sélection de la Banque -->
                        <div>
                        <form action="{{ route('classe_tranche') }}" method="GET" class="space-y-4">
                                <div>
                                    <label for="classe" class="block text-sm font-medium text-gray-700">Choisissez la classe :</label>
                                    <select id="classe" name="classe" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500">
                                        @if ($classes->isNotEmpty())
                                            @foreach ($classes as $classe)
                                                <option value="{{ $classe }}">
                                                    {{ $classe }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Aucune classe disponible</option>
                                        @endif
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="banque" class="block text-sm font-medium text-gray-700">Choisissez la Banque :</label>
                                    <select id="banque" name="banque" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500">
                                    @if ($classes->isNotEmpty())
                            @foreach ($banque as $banque)
                                <option value="{{ $banque}}">
                                    {{ $banque }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Aucune la Banque disponible</option>
                        @endif
                                    </select>
                                </div>
                                
                                <div class="mb-2">
                                    <label for="date" class="block text-sm font-medium text-gray-700">Date :</label>
                                    <input type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500" id="date" name="date" required>
                                </div>
                                
                                <button type="submit" class="mt-2 w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700">Rechercher</button>
                            </form>
                        </div>
                        
                        <!-- Sélection Période de Paiement -->
                        <div>
                            <form action="{{ route('classe_tranche') }}" method="GET">
                                <label for="periode" class="block text-sm font-medium text-gray-700">Choisissez la Période de Paiement :</label>
                                <select id="periode" name="periode" class="w-full p-2 border rounded-lg" onchange="this.form.submit()">
                                    <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Paiements Aujourd'hui</option>
                                    <option value="yesterday" {{ request('periode') == 'yesterday' ? 'selected' : '' }}>Paiements Hier</option>
                                    <option value="all" {{ request('periode') == 'all' ? 'selected' : '' }}>Tous les Paiements</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

               
                <!-- Tableau des Paiements -->
<!-- Bouton Imprimer -->
<div class="mt-4">
    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="printTable()">
        Imprimer
    </button>
</div>

<!-- Tableau des paiements -->
<div class="mt-4">
    <div class="overflow-x-auto">
        <table id="payment-table" class="min-w-full bg-white border border-blue-200">
            <!-- En-tête du tableau -->
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Nom Étudiant/Élève</th>
                    <th class="py-2 px-4 border-b">Classe</th>
                    <th class="py-2 px-4 border-b">Banque de Paiement</th>
                    <th class="py-2 px-4 border-b">Date Paiement</th>
                    <th class="py-2 px-4 border-b">Heure Paiement</th>
                    <th class="py-2 px-4 border-b">Filière</th>
                    <th class="py-2 px-4 border-b">Niveau</th>
                </tr>
            </thead>

            <!-- Corps du tableau -->
            <tbody>
                <!-- Paiements Aujourd'hui ou Date Sélectionnée -->
                @if(request('periode') == 'today' || request('date'))
                    @forelse($paiementsAujourdhui as $paiement)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $paiement->nom_complet }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->classe }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->banque }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->date_paiement }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->heure_paiement }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->filiere }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->niveau_universite }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-4 border-b text-center">Aucun paiement pour la période sélectionnée.</td>
                        </tr>
                    @endforelse
                @endif

                <!-- Paiements Hier -->
                @if(request('periode') == 'yesterday')
                    @forelse($paiementsHier as $paiement)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $paiement->nom_complet }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->classe }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->banque }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->date_paiement }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->heure_paiement }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->filiere }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->niveau_universite }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-4 border-b text-center">Aucun paiement effectué hier.</td>
                        </tr>
                    @endforelse
                @endif

                <!-- Tous les Paiements -->
                @if(request('periode') == 'all')
                    @forelse($paiementsTotal as $paiement)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $paiement->nom_complet }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->classe }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->banque }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->date_paiement }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->heure_paiement }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->filiere }}</td>
                            <td class="py-2 px-4 border-b">{{ $paiement->niveau_universite }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-4 border-b text-center">Aucun paiement disponible.</td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        @if(request('periode') == 'today' || request('date'))
            {{ $paiementsAujourdhui->appends(request()->query())->links() }}
        @elseif(request('periode') == 'yesterday')
            {{ $paiementsHier->appends(request()->query())->links() }}
        @elseif(request('periode') == 'all')
            {{ $paiementsTotal->appends(request()->query())->links() }}
        @endif
    </div>
</div>
</div>

            </div>
            
        </div>
        
    </div>
   
   

    <script>
        function toggleTab(tab) {
            let element = document.getElementById(tab);
            element.classList.toggle("hidden");
        }
    </script>
     <script src="/jscript/search_paiement.js"></script>
     <script src="/jscript/banque_impression.js"></script>
     <script src="/jscript/search_paiement.js"></script>
     <script src="/jscript/recherche_etudiant.js"></script>
     
</body>
</html>
