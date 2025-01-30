<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Pénalités</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function toggleSection(sectionId) {
            document.querySelectorAll('main section').forEach(section => {
                section.classList.toggle('hidden', section.id !== sectionId);
            });
        }

        function openModal() {
            const selectedClasses = Array.from(document.querySelectorAll('input[name="classes[]"]:checked'))
                .map(checkbox => checkbox.dataset.nom);

            if (selectedClasses.length > 0) {
                document.getElementById('selected-classes').textContent = `Classes sélectionnées : ${selectedClasses.join(', ')}`;

                const modal = document.getElementById('penalite-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                alert('Veuillez sélectionner au moins une classe.');
            }
        }

        function closeModal() {
            const modal = document.getElementById('penalite-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        async function savePenalites() {
    const form = document.getElementById('modal-form');
    const dateDebut = form.querySelector('input[name="date_debut"]').value;
    const montant = form.querySelector('input[name="montant"]').value;
    const frequence = form.querySelector('select[name="frequence"]').value;
    const tranche = form.querySelector('select[name="tranche"]').value;

    // Récupérer les classes sélectionnées
    const selectedClasses = Array.from(document.querySelectorAll('input[name="classes[]"]:checked')).map(checkbox => ({
        nom: checkbox.dataset.nom,
        date_debut: dateDebut,
        montant: montant,
        frequence: frequence,
        tranche: tranche,
    }));

    if (selectedClasses.length === 0) {
        alert('Veuillez sélectionner au moins une classe.');
        return;
    }

    try {
        const response = await fetch("{{ route('penalites.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ classes: selectedClasses }),
        });

        const data = await response.json();

        if (response.ok) {
            displayMessage('success', data.message || 'Opération réussie.');
            closeModal();
            location.reload(); // Recharger la page si nécessaire
        } else {
            displayMessage('error', data.message || 'Une erreur est survenue. Veuillez réessayer.');
        }
    } catch (error) {
        displayMessage('error', 'Une erreur réseau est survenue. Veuillez vérifier votre connexion.');
    }
}

/**
 * Fonction utilitaire pour afficher un message à l'utilisateur.
 * @param {string} type - 'success' ou 'error'.
 * @param {string} message - Le contenu du message.
 */
function displayMessage(type, message) {
    const container = document.createElement('div');
    container.className = `px-4 py-3 rounded-lg mb-4 ${
        type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'
    }`;
    container.innerHTML = `<strong>${type === 'success' ? 'Succès !' : 'Erreur !'}</strong> ${message}`;
    document.body.prepend(container);

    // Supprimer après 5 secondes
    setTimeout(() => container.remove(), 5000);
}


    </script>
</head>
<body class="bg-gray-100 h-screen">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-6 text-center text-2xl font-bold border-b border-gray-700">Gestion Des Pénalités</div>
            <nav class="flex-1 mt-6">
                <ul>
                    <li>
                        <button onclick="toggleSection('ajouter-penalite')" class="block w-full text-left px-6 py-3 hover:bg-blue-700">
                            Ajouter les Pénalités
                        </button>
                    </li>
                    <li>
                        <button onclick="toggleSection('voir-penalites')" class="block w-full text-left px-6 py-3 hover:bg-blue-700">
                            Voir les Pénalités
                        </button>
                    </li>
                    <li>
                        <a href="{{route('dashboard_ecole')}}" class="block w-full text-left px-6 py-3 hover:bg-blue-700"> Retour</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Messages de notification -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                    <strong>Erreur !</strong> {{ session('error') }}
                </div>
            @endif

            <!-- Ajouter les Pénalités -->
            <section id="ajouter-penalite" class="hidden mb-12">
                <h2 class="text-2xl font-bold mb-4">Ajouter les Pénalités</h2>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-4">Sélectionnez les classes :</h3>
                    <form id="penalite-form" class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            @forelse ($classes as $classe)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="classes[]" data-nom="{{ $classe->nom_classe }}" value="{{ $classe->id }}" class="rounded">
                                    <span>{{ $classe->nom_classe }}</span>
                                </label>
                            @empty
                                <p class="text-gray-500 col-span-2">Aucune classe disponible pour cette école.</p>
                            @endforelse
                        </div>

                        <button type="button" onclick="openModal()" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                            Appliquer
                        </button>
                    </form>
                </div>
            </section>

            <!-- Voir les Pénalités -->
<section id="voir-penalites"class="hidden mb-12">
    <h2 class="text-2xl font-bold mb-4">Voir les Pénalités</h2>
    <div class="bg-white p-6 rounded shadow">
    <div class="overflow-x-auto">
    <table class="min-w-full border-collapse border border-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Classe</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Montant</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Tranche</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Date de Début</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Fréquence</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penalites as $penalite)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">{{ $penalite->classe }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penalite->montant }} CFA</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penalite->tranche }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penalite->date_debut }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penalite->frequence }}</td>
                    <td class="border border-gray-300 px-4 py-2 flex gap-2">
                        <!-- Bouton Éditer -->
                        <a href="{{ route('penalite.edit', $penalite->id) }}" class="text-blue-500 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-4-4m0 0l4-4m-4 4h12M19 11a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </a>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('penalite.destroy', $penalite->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette pénalité ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    </div>
</section>

    <!-- Modal -->
    <div id="penalite-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Configurer les pénalités</h2>
            <div id="selected-classes" class="mb-4 text-gray-700 font-medium"></div>

            <form id="modal-form">
                <label for="date_debut">Date de début :</label>
                <input type="date" id="date_debut" name="date_debut" required class="border p-2 rounded w-full mb-3">

                <label for="montant">Montant :</label>
                <input type="number" id="montant" name="montant" required min="0" class="border p-2 rounded w-full mb-3">

                <label for="frequence">Fréquence :</label>
                <select id="frequence" name="frequence" required class="border p-2 rounded w-full mb-3">
                    <option value="jour">Jour</option>
                    <option value="semaine">Semaine</option>
                    <option value="mois">Mois</option>
                </select>

                <label for="tranche">Tranche :</label>
                <select id="tranche" name="tranche" required class="border p-2 rounded w-full mb-3">
                    <option value="premiere_tranche">Première Tranche</option>
                    <option value="deuxieme_tranche">Deuxième Tranche</option>
                    <option value="troisieme_tranche">Troisième Tranche</option>
                    <option value="quatrieme_tranche">Quatrième Tranche</option>
                    <option value="cinquieme_tranche">Cinquième Tranche</option>
                    <option value="sixieme_tranche">Sixième Tranche</option>
                    <option value="septieme_tranche">Septième Tranche</option>
                    <option value="huitieme_tranche">Huitième Tranche</option>
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-red-500 text-white rounded">Annuler</button>
                    <button type="button" onclick="savePenalites()" class="px-4 py-2 bg-blue-500 text-white rounded">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
