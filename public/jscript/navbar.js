/// navbar.js

document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', function() {
        navLinks.classList.toggle('active'); // Ajoute ou enlève la classe active
        burger.classList.toggle('toggle'); // Ajoute une classe pour l'animation de l'icône
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