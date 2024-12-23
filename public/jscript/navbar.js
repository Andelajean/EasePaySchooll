document.addEventListener('DOMContentLoaded', function () {
    const burger = document.getElementById('burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', function () {
        navLinks.classList.toggle('active'); // Affiche ou masque les liens
        burger.classList.toggle('toggle');  // Change l'apparence du burger
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
