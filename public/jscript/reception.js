document.getElementById('nom_complet').addEventListener('input', function() {
    let nom_complet = this.value;
    let classe = document.getElementById('classe').value;

    if (nom_complet.length > 1) {
        // Requête AJAX pour chercher les élèves
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/materiel/ecole/reception?nom_complet=${nom_complet}&classe=${classe}`, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function() {
            if (xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let suggestionsBox = document.getElementById('suggestions');
                suggestionsBox.innerHTML = ''; // Vider les suggestions précédentes

                if (data.length > 0) {
                    suggestionsBox.style.display = 'block';
                    data.forEach(eleve => {
                        let li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.textContent = `${eleve.nom_complet} (${eleve.classe})`;
                        li.addEventListener('click', function() {
                            ajouterAuTableau(eleve);
                            suggestionsBox.style.display = 'none'; // Cacher les suggestions après le clic
                        });
                        suggestionsBox.appendChild(li);
                    });
                } else {
                    suggestionsBox.style.display = 'none';
                }
            } else {
                console.error('Erreur lors de la requête');
            }
        };
        xhr.send();
    } else {
        document.getElementById('suggestions').style.display = 'none';
    }
});

// Fonction pour ajouter l'élève sélectionné au tableau
function ajouterAuTableau(eleve) {
    let table = document.getElementById('table-eleves').getElementsByTagName('tbody')[0];
    let row = table.insertRow();
    row.innerHTML = `
        <td>${eleve.nom_complet}</td>
        <td>${eleve.classe}</td>
        <td>${eleve.banque}</td>
        <td>${eleve.date_paiement}</td>
        <td>${eleve.heure_paiement}</td>
        <td><button class="btn btn-primary" onclick="openReceptionModal('${eleve.id_paiement}')">Réceptionner</button></td>
    `;
}
function openReceptionModal(eleveId) {
    // Injecter l'ID de l'élève dans le champ caché du formulaire
    document.getElementById('eleve_id').value = eleveId;
    
    // Ouvrir la modale
    $('#receptionModal').modal('show');
}

// Afficher le champ pour le matériel manquant si "Matériel NON OK" est sélectionné
document.getElementById('materiel_non_ok').addEventListener('click', function() {
    document.getElementById('materiel_restante_group').style.display = 'block';
});

document.getElementById('materiel_non_ok').addEventListener('change', function () {
    var resteGroup = document.getElementById('materiel_restante_group');
    var resteField = document.getElementById('materiel_restante');
    
    if (this.checked) {
        resteGroup.style.display = 'block';
        resteField.setAttribute('required', 'required');
    }
});

document.getElementById('materiel_ok').addEventListener('change', function () {
    var resteGroup = document.getElementById('materiel_restante_group');
    var resteField = document.getElementById('materiel_restante');
    
    if (this.checked) {
        resteGroup.style.display = 'none';
        resteField.removeAttribute('required');
    }
});