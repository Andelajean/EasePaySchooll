 //chargement de la page
 window.addEventListener("load", function () {
    const loader = document.getElementById('loader');
    loader.classList.add('fade-out'); // Ajoute l'animation de fondu
    setTimeout(() => loader.style.display = 'none', 1000); // Masque le loader après l'animation
    });

    let currentTrancheInput;

    // Fonction pour ajouter une nouvelle ligne de classe
    function addRow(sectionId) {
        const section = document.getElementById(sectionId);
        const template = document.getElementById('classe-template').content.cloneNode(true);
        section.appendChild(template);
    }

    // Fonction pour générer les indices
    function generateIndices(input) {
        const row = input.closest('.grid');
        const nombre = parseInt(input.value);
        const indiceSelect = row.querySelector('select[name="indice[]"]');
        const indicesSummary = row.querySelector('.indices-summary');

        if (!isNaN(nombre) && nombre > 0) {
            const startIndex = indiceSelect.value.charCodeAt(0);
            const indices = [];

            for (let i = 0; i < nombre; i++) {
                indices.push(String.fromCharCode(startIndex + i));
            }

            indicesSummary.value = indices.join(', ');
        } else {
            indicesSummary.value = '';
        }
    }

    // Fonction pour ouvrir la fenêtre modale des tranches
    function openTrancheModal(input) {
        const count = parseInt(input.value);
        if (!isNaN(count) && count > 0) {
            currentTrancheInput = input;
            const tranchesContent = document.getElementById('tranchesContent');
            tranchesContent.innerHTML = '';

            for (let i = 1; i <= count; i++) {
                tranchesContent.innerHTML += `
                    <div class="mb-2">
                        <label class="block text-gray-700">Montant Tranche ${i}</label>
                        <input type="number" class="border rounded p-2 w-full tranche-amount" placeholder="Montant pour Tranche ${i}">
                    </div>`;
            }
            tranchesContent.innerHTML += `
                <div class="mt-4">
                    <label class="block text-gray-700">Totalité</label>
                    <input type="number" readonly id="totalite" class="border rounded p-2 w-full" placeholder="Totalité">
                </div>`;
            document.getElementById('trancheModal').classList.remove('hidden');
        }
    }

    // Fonction pour enregistrer les montants des tranches
    function saveTranches() {
        const trancheInputs = document.querySelectorAll('.tranche-amount');
        const montantSummary = [];
        let total = 0;

        trancheInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            montantSummary.push(value);
            total += value;
        });

        if (currentTrancheInput) {
            const row = currentTrancheInput.closest('.grid');
            row.querySelector('.montant-summary').value = montantSummary.join(', ');
            row.querySelector('.totalite-summary').value = total;
        }

        document.getElementById('trancheModal').classList.add('hidden');
    }

    

    // Fonction pour afficher l'aperçu
    function showPreview() {
        const form = document.getElementById('classesForm');
        const formData = new FormData(form);
        const previewContent = document.getElementById('previewContent');

        let previewHTML = '<h4 class="font-bold text-lg mb-2">Aperçu des Classes</h4>';
        const rows = document.querySelectorAll('#classes-section > div');

        rows.forEach((row, index) => {
            const nomClasse = formData.getAll('nom_classe[]')[index];
            const indices = formData.getAll('indices[]')[index];
            const montants = formData.getAll('montants[]')[index];
            const totalite = formData.getAll('totalite[]')[index];

            previewHTML += `
                <p><strong>Classe:</strong> ${nomClasse} (${indices}) | 
                <strong>Montants:</strong> ${montants} | <strong>Totalité:</strong> ${totalite}</p>
            `;
        });

        previewContent.innerHTML = previewHTML;
        document.getElementById('previewModal').classList.remove('hidden');
    }

    // Fonction pour fermer l'aperçu
    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
    }

    // Fonction pour soumettre le formulaire
    function submitForm() {
        const form = document.getElementById('classesForm');
        alert('Les données sont soumises avec succès !');
        form.submit(); // Soumet le formulaire
    }
    