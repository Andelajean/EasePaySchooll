$(document).ready(function() {
    $('#search-input').on('input', function() {
        let query = $(this).val().trim();
        let suggestionsBox = $('#suggestions');
        suggestionsBox.empty();

        if (query.length > 0) {
            $.ajax({
                url: `/search-student/badge`,
                type: "GET",
                data: { query: query },
                success: function(data) {
                    if (data.length > 0) {
                        data.forEach(student => {
                            suggestionsBox.append(`<li class="list-group-item" data-id="${student.id}">${student.nom_etudiant}</li>`);
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

    // Afficher les détails de l'élève dans la modale via une boucle
    $(document).on('click', '.list-group-item', function() {
        let studentId = $(this).data('id');
        $('#suggestions').hide();

        $.ajax({
            url: `/student-details/badge/${studentId}`,
            type: "GET",
            success: function(student) {
                // Vider le tableau avant de le remplir
                $('#student-details-table').empty();

                // Parcourir chaque propriété de l'objet `student` et créer une ligne pour chaque détail
                for (let key in student) {
                    // Formater le titre de la propriété (par exemple, "student_class" en "Classe")
                    let formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                    $('#student-details-table').append(`
                        <tr>
                            <th>${formattedKey}</th>
                            <td>${student[key]}</td>
                        </tr>
                    `);
                }

                // Afficher la modale
                $('#studentModal').modal('show');
            },
            error: function() {
                alert('Détails de l\'élève non trouvés.');
            }
        });
    });

    // Masquer les suggestions quand on clique en dehors
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
