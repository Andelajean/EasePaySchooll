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

    /*paiement
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var query = $(this).val();
            if (query.length >= 1) {
                $.ajax({
                    url: '/search-school',
                    data: { query: query },
                    success: function(data) {
                        var resultList = $('#result-list');
                        resultList.empty().removeClass('hidden');
                        if (data.length > 0) {
                            $.each(data, function(index, school) {
                                resultList.append('<li class="p-2 cursor-pointer hover:bg-gray-200" data-id="' + school.id + '">' + school.nom_ecole + '</li>');
                            });
                        } else {
                            resultList.append('<li class="p-2 text-gray-500">Aucune école trouvée</li>');
                        }
                    }
                });
            } else {
                $('#result-list').empty().addClass('hidden');
            }
        });

        // Récupérer les détails de l'école lorsqu'un résultat est cliqué
    $(document).on('click', '#result-list li', function() {
var schoolId = $(this).data('id');
$.ajax({
    url: '/school/' + schoolId,
    success: function(data) {
        if (data) {
            $('#nom_ecole').val(data.nom_ecole);
            $('#telephone').val(data.telephone);
            $('#ville').val(data.ville);

            // Gérer la liste des banques
            var banqueSelect = $('#banque');
            banqueSelect.empty().append('<option value="">Sélectionnez une banque</option>');

            $.each(data.banques, function(index, banque) {
                banqueSelect.append('<option value="' + banque.numero_banque + '">' + banque.nom_banque + '</option>');
            });

            // Masquer la liste des suggestions
            $('#result-list').empty().addClass('hidden');

            // Afficher le formulaire
            $('#form-container').removeClass('hidden');
        }
    }
});
});


        // Afficher les champs pour l'université
        $('#niveau').on('change', function() {
            if ($(this).val() === 'université') {
                $('#university-fields').removeClass('hidden');
            } else {
                $('#university-fields').addClass('hidden');
            }
        });
    });
    */