
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

    $(document).on('click', '#result-list li', function() {
        var schoolId = $(this).data('id');
    
        // Requête pour récupérer les détails complets de l'école
        $.ajax({
            url: '/school/' + schoolId,  // Utilise la même route
            method: 'GET',
            success: function(data) {
                if (data) {
                    // Pré-remplir les champs avec les détails de l'école
                    $('#nom_ecole').val(data.nom_ecole);
                    $('#telephone').val(data.telephone);
                    $('#ville').val(data.ville);
                    $('#montant_total').val(data.montant_total); // Champ Montant total
    
                    // Remplir la liste des banques (nom uniquement)
                    var banqueSelect = $('#banque');
                    banqueSelect.empty().append('<option value="">Sélectionnez une banque</option>');
                    for (var i = 1; i <= 6; i++) {
                        if (data['nom_banque' + i]) {
                            banqueSelect.append('<option value="' + data['nom_banque' + i] + '">' + data['nom_banque' + i] + '</option>');
                        }
                    }
    
                    // Masquer la liste des suggestions et afficher le formulaire
                    $('#result-list').empty().addClass('hidden');
                    $('#schoolForm').removeClass('hidden');
    
                    // Remplir automatiquement la date et l'heure actuelles
                    var now = new Date();
                    var date = now.toISOString().split('T')[0]; // Format YYYY-MM-DD
                    var time = now.toTimeString().split(' ')[0]; // Format HH:MM:SS
                    $('#date_paiement').val(date);
                    $('#heure_paiement').val(time);
    
                    // Comparer le niveau sélectionné avec le niveau de l'école
                    var ecoleNiveau = data.niveau;
                    var niveauSelect = $('#niveau');
                    var errorMessage = $('#error-message');
    
                    // Lorsqu'un niveau est sélectionné, vérifier s'il correspond à celui de l'école
                    niveauSelect.on('change', function() {
                        var selectedNiveau = this.value;
                        if (selectedNiveau !== ecoleNiveau) {
                            errorMessage.text(`Erreur : Le niveau sélectionné (${selectedNiveau}) ne correspond pas au niveau de l'école (${ecoleNiveau}).`);
                            errorMessage.show();
    
                            // Réinitialiser la sélection
                            niveauSelect.val('');
                        } else {
                            errorMessage.hide(); // Cacher le message si tout va bien
                        }
                    });
                }
            }
        });
    });
    

    // Afficher les champs spécifiques à l'université
    $('#niveau').on('change', function() {
        if ($(this).val() === 'université') {
            $('#university-fields').removeClass('hidden');
        } else {
            $('#university-fields').addClass('hidden');
        }
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
 // Fonction pour définir la date et l'heure actuelles
 document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById('date_paiement').value = currentDateTime;
});