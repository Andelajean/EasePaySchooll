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