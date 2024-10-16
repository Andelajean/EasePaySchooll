/// navbar.js

document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', function() {
        navLinks.classList.toggle('active'); // Ajoute ou enlève la classe active
        burger.classList.toggle('toggle'); // Ajoute une classe pour l'animation de l'icône
    });
});


