
document.addEventListener('DOMContentLoaded', function() {
    // Message à afficher
    const message = "À propos de EasePaySchool";

    const errorMessage = document.getElementById('messa');
    let index = 0;

    // Fonction pour afficher le texte lettre par lettre
    function typeWriter() {
        if (index < message.length) {
            errorMessage.innerHTML += message.charAt(index);
            index++;
            setTimeout(typeWriter, 100); // Délai entre chaque lettre (100ms)
        } else {
            // Une fois le message complètement affiché, attendre un peu avant de recommencer
            setTimeout(() => {
                index = 0; // Réinitialiser l'index pour recommencer
                errorMessage.innerHTML = ""; // Vider le texte affiché
                typeWriter(); // Relancer la fonction
            }, 2000); // Attendre 2 secondes avant de recommencer
        }
    }

    // Appeler la fonction pour démarrer l'effet de machine à écrire
    typeWriter();
});


document.addEventListener('DOMContentLoaded', function() {
    // Message à afficher
    const message = "Découvrez notre mission, nos fonctionnalités et nos avantages.";

    const errorMessage = document.getElementById('messag');
    let index = 0;

    // Fonction pour afficher le texte lettre par lettre
    function typeWriter() {
        if (index < message.length) {
            errorMessage.innerHTML += message.charAt(index);
            index++;
            setTimeout(typeWriter, 100); // Délai entre chaque lettre (100ms)
        } else {
            // Une fois le message complètement affiché, attendre un peu avant de recommencer
            setTimeout(() => {
                index = 0; // Réinitialiser l'index pour recommencer
                errorMessage.innerHTML = ""; // Vider le texte affiché
                typeWriter(); // Relancer la fonction
            }, 2000); // Attendre 2 secondes avant de recommencer
        }
    }

    // Appeler la fonction pour démarrer l'effet de machine à écrire
    typeWriter();
});
  //chargement de la page
  window.addEventListener("load", function () {
    const loader = document.getElementById('loader');
    loader.classList.add('fade-out'); // Ajoute l'animation de fondu
    setTimeout(() => loader.style.display = 'none', 1000); // Masque le loader après l'animation
    });
