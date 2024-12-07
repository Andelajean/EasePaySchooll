
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
                alert('Une erreur s\'est produite. Veuillez réessayer.');
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
 // Fonction pour définir la date et l'heure actuelles
 document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    const currentDateTime = `${year}-${month}-${day}-${hours}:${minutes}`;
    document.getElementById('date_paiement').value = currentDateTime;
});

