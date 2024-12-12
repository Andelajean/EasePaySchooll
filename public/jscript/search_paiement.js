$(document).ready(function() {
    $('#search-input').on('input', function() {
        let query = $(this).val().trim();
        let suggestionsBox = $('#suggestions');
        suggestionsBox.empty();

        if (query.length > 0) {
            $.ajax({
                url: `/search-student/paiement`,
                type: "GET",
                data: { query: query },
                success: function(data) {
                    if (data.length > 0) {
                        data.forEach(student => {
                            suggestionsBox.append(`<li class="list-group-item" data-nom_complet="${student.nom_complet}">${student.nom_complet}</li>`);
                        });
                        suggestionsBox.show();
                    } else {
                        suggestionsBox.hide();
                    }
                }
            });
        } else {
            suggestionsBox.hide();
        }
    });

    // Afficher les détails de l'élève dans la modale
    $(document).on('click', '.list-group-item', function() {
        let studentName = $(this).data('nom_complet');
        console.log("Nom complet sélectionné : ", studentName);

        $('#suggestions').hide();

        $.ajax({
            url: `/student-details/paiement/${encodeURIComponent(studentName)}`,
            type: "GET",
            success: function(students) {
                $('#student-details-table').empty();

                students.forEach(student => {
                    for (let key in student) {
                        let formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        $('#student-details-table').append(`
                            <tr>
                                <th>${formattedKey}</th>
                                <td>${student[key]}</td>
                            </tr>
                        `);
                    }
                });

                $('#studentModal').modal('show');
            },
            error: function(xhr) {
                console.log("Erreur de récupération des détails:", xhr.responseText);
                alert("Détails de l'élève non trouvés.");
            }
        });
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.search-box').length) {
            $('#suggestions').hide();
        }
    });
});
$(document).ready(function() {
    // Gestionnaire d'événement pour la croix de fermeture
    $(document).on('click', '.btn-close', function() {
        $('#studentModal').modal('hide');
    });

    // Gestionnaire d'événement pour le bouton "Fermer" en bas
    $(document).on('click', '#close-modal-btn', function() {
        $('#studentModal').modal('hide');
    });
});


//empecher le clic droit
document.addEventListener('contextmenu', function (e) {
    e.preventDefault(); // Empêche l'affichage du menu contextuel
});
document.addEventListener('keydown', function (e) {
    // Empêcher certains raccourcis
    if (e.ctrlKey || e.metaKey) {
        // Ctrl + S
        if (e.key === 's') {
            e.preventDefault();
        }
        // Ctrl + U
        if (e.key === 'u') {
            e.preventDefault();
        }
        // F12 (dev tools)
        if (e.key === 'F12') {
            e.preventDefault();
        }
        if (e.key === 'r') {
            e.preventDefault();
        }
    }
    
    // Empêcher la touche F12 (pour les outils de développeur) et F5 (recharger la page)
    if (e.key === 'F12' || e.key === 'F5') {
        e.preventDefault();
    }
});