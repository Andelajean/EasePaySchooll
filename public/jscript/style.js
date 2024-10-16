
  //chargement de la page
window.addEventListener("load", function () {
const loader = document.getElementById('loader');
loader.classList.add('fade-out'); // Ajoute l'animation de fondu
setTimeout(() => loader.style.display = 'none', 1000); // Masque le loader après l'animation
});
let bankCount = 1;
const maxBanks = 8;
// Fonction pour ajouter une nouvelle ligne de banque
document.getElementById('add-bank').addEventListener('click', function () {
    if (bankCount < maxBanks) {
        bankCount++;
        const newBankRow = document.createElement('div');
        newBankRow.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4', 'mb-4', 'bank-row');
        newBankRow.setAttribute('id', `bankRow${bankCount}`);
        newBankRow.innerHTML = `
            <!-- Nom Banque -->
            <div class="flex flex-col">
                <label for="nom_banque${bankCount}" class="mb-2 font-medium text-white">Nom de la Banque</label>
                <select class="p-2 border rounded-md bank-name" name="nom_banque${bankCount}">
                    <option value="" selected>Veuillez choisir une banque</option>
                    <option value="Afriland First Bank">Afriland First Bank</option>
                    <option value="Banque Atlantique">Banque Atlantique</option>
                    <option value="UBA Bank">UBA Bank</option>
                    <option value="SCB Bank">SCB Bank</option>
                    <option value="SGBC">SGBC</option>
                    <option value="Commercial Bank">Commercial Bank</option>
                    <option value="BICEC">BICEC</option>
                    <option value="Eco Bank">Eco Bank</option>
                    <option value="BGFI Bank">BGFI Bank</option>
                    <option value="Bange Bank">Bange Bank</option>
                    <option value="Express Union">Express Union</option>
                    <option value="Vision Finance">Vision Finance</option>
                    <option value="NFC Bank">NFC Bank</option>
                </select>
            </div>
            <!-- Numéro Compte -->
            <div class="flex flex-col">
                <label for="numero_compte${bankCount}" class="mb-2 font-medium text-white">Numéro de Compte</label>
                <input type="text" class="p-2 border rounded-md numero-compte" name="numero_compte${bankCount}" placeholder="Entrez le numéro de compte">
            </div>
        `;
        document.getElementById('bank-container').appendChild(newBankRow);
        // Mettre à jour les événements pour gérer les sélections
        updateBankListeners();
    } else {
        alert('Vous ne pouvez ajouter que ' + maxBanks + ' banques maximum.');
    }
});
// Fonction pour retirer la dernière ligne de banque
document.getElementById('remove-bank').addEventListener('click', function () {
    if (bankCount > 1) {
        const lastBankRow = document.getElementById(`bankRow${bankCount}`);
        lastBankRow.remove();
        bankCount--;
        updateBankListeners(); // Mise à jour après suppression
    } else {
        alert('Vous devez avoir au moins une banque.');
    }
});
// Fonction pour mettre à jour les options des banques afin d'empêcher la même sélection
function updateBankListeners() {
    const bankSelects = document.querySelectorAll('.bank-name');
    function updateBankOptions() {
        // Récupérer toutes les valeurs sélectionnées
        const selectedBanks = Array.from(bankSelects)
            .map(select => select.value)
            .filter(value => value !== ""); // On ignore les selects sans valeur sélectionnée
        // Parcourir chaque select et désactiver les options déjà sélectionnées
        bankSelects.forEach(select => {
            Array.from(select.options).forEach(option => {
                option.disabled = selectedBanks.includes(option.value) && select.value !== option.value;
            });
        });
    }
    // Ajouter un événement "change" sur chaque select pour surveiller les changements
    bankSelects.forEach(select => {
        select.addEventListener('change', updateBankOptions);
    });
    // Mise à jour initiale des options
    updateBankOptions();
}
// Appeler la fonction pour la première initialisation
updateBankListeners();