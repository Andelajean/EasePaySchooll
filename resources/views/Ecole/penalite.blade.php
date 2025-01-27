<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Pénalités</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSection(sectionId) {
            const sections = document.querySelectorAll('main section');
            sections.forEach(section => {
                if (section.id === sectionId) {
                    section.classList.toggle('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        }

        function openModal() {
    const selectedClasses = [];
    document.querySelectorAll('input[name="classes[]"]:checked').forEach(checkbox => {
        selectedClasses.push({
            id: checkbox.value,
            name: checkbox.dataset.nom
        });
    });

    // Afficher les classes sélectionnées dans le modal
    const selectedClassesContainer = document.getElementById('selected-classes');
    const hiddenClassesInput = document.getElementById('hidden-classes');
    
    if (selectedClasses.length > 0) {
        selectedClassesContainer.textContent = selectedClasses.map(c => c.name).join(', ');
        hiddenClassesInput.value = JSON.stringify(selectedClasses);
    } else {
        selectedClassesContainer.textContent = 'Aucune classe sélectionnée.';
        hiddenClassesInput.value = '';
    }

    document.getElementById('penalite-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('penalite-modal').classList.add('hidden');
}

    </script>
</head>
<body class="bg-gray-100 h-screen">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-6 text-center text-2xl font-bold border-b border-gray-700">Pénalités</div>
            <nav class="flex-1">
                <ul class="mt-6">
                    <li>
                        <button onclick="toggleSection('ajouter-penalite')" class="block w-full text-left px-6 py-3 hover:bg-gray-700">Ajouter les Pénalités</button>
                    </li>
                    <li>
                        <button onclick="toggleSection('voir-penalites')" class="block w-full text-left px-6 py-3 hover:bg-gray-700">Voir les Pénalités</button>
                    </li>
                </ul>
            </nav>
        </aside>
      
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Messages de succès ou d'échec -->
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

            <button type="button" onclick="openModal()" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Appliquer</button>
        </form>
    </div>
</section>


            <!-- Voir les Pénalités -->
            <section id="voir-penalites" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Voir les Pénalités</h2>
                <div class="bg-white p-6 rounded shadow">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Montant</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Pénalité 1</td>
                                <td class="border border-gray-300 px-4 py-2">100 €</td>
                                <td class="border border-gray-300 px-4 py-2">Description de la pénalité</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

<!-- Modal -->
<div id="penalite-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-full max-w-2xl">
        <h2 class="text-xl font-bold mb-4">Définir les Pénalités</h2>
        <form id="modal-form">
            <div id="selected-classes" class="space-y-4">
                <!-- Les classes sélectionnées et les champs correspondants seront ajoutés ici dynamiquement -->
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 py-2 px-4 rounded hover:bg-gray-400">Annuler</button>
                <button type="button" onclick="savePenalites()" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const selectedClasses = document.querySelectorAll('input[name="classes[]"]:checked');
        const modal = document.getElementById('penalite-modal');
        const selectedClassesContainer = document.getElementById('selected-classes');

        selectedClassesContainer.innerHTML = '';

        if (selectedClasses.length === 0) {
            alert('Veuillez sélectionner au moins une classe.');
            return;
        }

        selectedClasses.forEach((checkbox) => {
            const className = checkbox.dataset.nom;
            const classId = checkbox.value;

            const classRow = document.createElement('div');
            classRow.classList.add('flex', 'space-x-4', 'items-center');

            classRow.innerHTML = `
                <div class="flex-1">
                    <p class="font-semibold">\${className}</p>
                </div>
                <input type="hidden" name="classes[\${classId}][id]" value="\${classId}">
                <input type="hidden" name="classes[\${classId}][nom]" value="\${className}">
                <input type="date" name="classes[\${classId}][date_debut]" class="border rounded p-2" required>
                <input type="number" name="classes[\${classId}][montant]" class="border rounded p-2" placeholder="Montant" required>
                <select name="classes[\${classId}][frequence]" class="border rounded p-2" required>
                    <option value="jour">Jour</option>
                    <option value="semaine">Semaine</option>
                    <option value="mois">Mois</option>
                </select>
                <input type="text" name="classes[\${classId}][tranche]" class="border rounded p-2" placeholder="Tranche" required>
            `;

            selectedClassesContainer.appendChild(classRow);
        });

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('penalite-modal').classList.add('hidden');
    }

    async function savePenalites() {
        const form = document.getElementById('modal-form');
        const formData = new FormData(form);

        try {
            const response = await fetch('{{ route('penalites.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            });

            if (response.ok) {
                alert('Pénalités enregistrées avec succès !');
                closeModal();
                location.reload();
            } else {
                alert('Une erreur s\'est produite lors de l\'enregistrement.');
            }
        } catch (error) {
            console.error(error);
            alert('Une erreur s\'est produite. Veuillez réessayer.');
        }
    }
</script>

</body>
</html>
