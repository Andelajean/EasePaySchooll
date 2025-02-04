function printTable() {
    // Récupère l'en-tête du tableau et change le texte si nécessaire
    var tableHeader = document.getElementById('table-header');
    var originalHeader = tableHeader.innerHTML;

    // Récupérer dynamiquement le nom de la banque depuis la variable PHP
    var bankName = "{{ $banque }}";

    // Changer l'en-tête pour l'impression en utilisant le nom de la banque
    tableHeader.innerHTML = "Rapport des Paiements - " + bankName;

    // Récupère le contenu à imprimer
    var printContents = document.querySelector('.market-status-table').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();  // Ouvre la boîte de dialogue d'impression
    document.body.innerHTML = originalContents;

    // Rétablir l'en-tête original après impression
    tableHeader.innerHTML = originalHeader;
    
    window.location.reload();  // Recharger la page après impression
}

/// Empêcher le clic droit
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
