document.getElementById('nom_eleve').addEventListener('input', function() {
    let nom_eleve = this.value;
    let classe = document.getElementById('classe').value;

    if (nom_eleve.length > 1) {
        // Requête AJAX pour chercher les élèves
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/uniforme/ecole/distribution?nom_eleve=${nom_eleve}&classe=${classe}`, true);
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
                        li.textContent = `${eleve.nom_eleve} (${eleve.classe})`;
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
        <td>${eleve.nom_eleve}</td>
        <td>${eleve.classe}</td>
        <td>${eleve.created_at}</td>
        <td>${eleve.materiel}</td>
        <td>${eleve.reste}</td>
        <td><button class="btn btn-primary" onclick="openReceptionModal('${eleve.paiement}')"> Distribuer </button></td>
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


//empecher le clic droit
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
