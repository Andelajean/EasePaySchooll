
  //chargement de la page
  window.addEventListener("load", function () {
    const loader = document.getElementById('loader');
    loader.classList.add('fade-out'); // Ajoute l'animation de fondu
    setTimeout(() => loader.style.display = 'none', 1000); // Masque le loader après l'animation
    });$(document).ready(function() {
    var delayTimer;

    // Fonction pour effectuer la recherche à chaque frappe avec un délai de 300ms
    $('#search').on('input', function() {
        clearTimeout(delayTimer); // Reset du timer

        var query = $(this).val();

        delayTimer = setTimeout(function() {
            if (query.length > 0) {
                // Requête AJAX
                $.ajax({
                    url: '/search-school',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        var resultList = $('#result-list');
                        resultList.empty(); // Vider la liste des résultats avant d'ajouter les nouveaux

                        if (data.length > 0) {
                            resultList.removeClass('hidden');
                            $.each(data, function(index, school) {
                                resultList.append('<li class="p-2 cursor-pointer hover:bg-gray-200" data-id="' + school.id + '">' + school.nom_ecole + '</li>');
                            });
                        } else {
                            resultList.addClass('hidden');
                        }
                    }
                });
            } else {
                $('#result-list').empty().addClass('hidden'); // Masquer les suggestions si aucun texte
            }
        }, 300); // 300ms de délai
    });

  // Lorsque l'utilisateur clique sur un élément de la liste
  $(document).on('click', '#result-list li', function() {
    var schoolId = $(this).data('id');

    // Requête pour récupérer les détails complets de l'école
    $.ajax({
        url: '/school/' + schoolId, // URL de la route pour récupérer les détails
        method: 'GET',
        success: function(data) {
            if (data.view) {
                // Rediriger vers la vue appropriée après avoir stocké les données dans la session
                window.location.href = data.view;
            }
        },
        error: function(xhr) {
            if (xhr.status === 404) {
                alert('École introuvable.');
            } else {
                // Afficher les détails de l'erreur
                console.error('Statut de l\'erreur:', xhr.status); // Code d'état HTTP
                console.error('Statut du texte:', xhr.statusText); // Texte correspondant à l'état
                console.error('Réponse:', xhr.responseText); // Détails de la réponse du serveur
                
                // Afficher une alerte utilisateur avec un message détaillé
                alert('Une erreur s\'est produite : ' + xhr.status + ' - ' + xhr.statusText + 
                      '. Détails : ' + xhr.responseText);
            }
        }
        
    });
});

    
    // Bouton Annuler
    $('#annuler').on('click', function() {
        $('#form-container').addClass('hidden');
        $('#search').val('');
    });
});
 // Empêche la saisie d'espaces dans le champ montant
 document.getElementById('montant').addEventListener('keydown', function(e) {
    if (e.key === ' ') {
        e.preventDefault();  // Empêche l'utilisateur de saisir un espace
    }
});

// Calcul du montant total en fonction du montant saisi
document.getElementById('montant').addEventListener('input', function() {
    const montant = parseFloat(this.value) || 0; // Si vide ou invalide, montant = 0
    let montantTotal = montant;

    if (montant <= 50000) {
        montantTotal += 500;  // Ajoute 500 si montant < 50 000
    } else {
        montantTotal += 1000; // Ajoute 1 000 si montant >= 50 000
    }

    document.getElementById('montant_total').value = montantTotal;
});

document.addEventListener('DOMContentLoaded', function () {
    const classeSelect = document.getElementById('classe');
    const detailsSelect = document.getElementById('details');
    const montantInput = document.getElementById('montant');
    //const filiereSelect = document.getElementById('filiere');
    const montantTotalInput = document.getElementById('montant_total');

    // Fonction pour calculer le montant total
    function calculateTotalAmount(montant) {
        let montantTotal = montant <= 50000 ? montant + 500 : montant + 1000;
        montantTotalInput.value = montantTotal.toFixed(2); // Afficher avec deux décimales
    }

    
    // Gestion du changement de classe
    classeSelect.addEventListener('change', function () {
        const selectedOption = classeSelect.options[classeSelect.selectedIndex];
        console.log('Option de classe sélectionnée :', selectedOption);

        // Récupérer les montants
        const montantsData = selectedOption.getAttribute('data-montants');
        console.log('Données brutes des montants :', montantsData);

        const montants = JSON.parse(montantsData || '{}');
        console.log('Montants parsés :', montants);

        // Réinitialiser les tranches
        detailsSelect.innerHTML = '<option value="" disabled selected>-- Sélectionnez une tranche --</option>';
        Object.keys(montants).forEach(tranche => {
            const option = document.createElement('option');
            option.value = tranche;
            option.setAttribute('data-montant', montants[tranche]);
            option.textContent = tranche.replace('_', ' ');
            detailsSelect.appendChild(option);
        });

        // Réinitialiser les champs de montant
        montantInput.value = '';
        montantTotalInput.value = '';
    });

    // Gestion du changement de tranche
    detailsSelect.addEventListener('change', function () {
        const selectedOption = detailsSelect.options[detailsSelect.selectedIndex];
        const montant = parseFloat(selectedOption.getAttribute('data-montant')) || 0;

        montantInput.value = montant; // Afficher le montant de la tranche
        calculateTotalAmount(montant); // Calculer le montant total
    });
});
// Empêcher le clic droit
document.addEventListener('contextmenu', function (e) {
    e.preventDefault(); // Empêche l'affichage du menu contextuel
});

// Empêcher certaines combinaisons de touches
document.addEventListener('keydown', function (e) {
    const key = e.key.toLowerCase(); // Normalise la touche en minuscule

    // Empêcher certains raccourcis clavier
    if (e.ctrlKey || e.metaKey) {
        if (key === 's' || key === 'u' || key === 'r') {
            e.preventDefault();
        }
    }

    // Empêcher les touches spécifiques (F12, F5)
    if (key === 'f12' || key === 'f5') {
        e.preventDefault();
    }
});

//fenetre numero
document.getElementById("openModal").addEventListener("click", function () {
    document.getElementById("paymentModal").classList.remove("hidden");
});

document.getElementById("closeModal").addEventListener("click", function () {
    document.getElementById("paymentModal").classList.add("hidden");
});

document.getElementById("confirmPayment").addEventListener("click", function () {
    let phoneNumber = document.getElementById("phoneNumber").value.trim();

    if (!phoneNumber) {
        alert("Veuillez entrer un numéro de téléphone.");
        return;
    }

    // Injecter le numéro dans le champ de téléphone du formulaire
    document.getElementById("phone").value = phoneNumber;

    // Soumettre le formulaire
    document.getElementById("schoolForm").submit();
});