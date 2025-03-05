document.addEventListener('DOMContentLoaded', function () {
    // Fonction pour créer l'effet de machine à écrire
    function createTypeWriterEffect(elementId, text) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.warn(`⚠️ L'élément avec l'ID "${elementId}" est introuvable.`);
            return;
        }

        let index = 0;

        function typeWriter() {
            if (index < text.length) {
                element.textContent = text.substring(0, index + 1); // Affiche uniquement les lettres déjà tapées
                index++;
                setTimeout(typeWriter, 100);
            } else {
                setTimeout(() => {
                    index = 0;
                    element.textContent = ""; // Efface le texte
                    typeWriter();
                }, 2000);
            }
        }

        typeWriter();
    }

    // Appliquer l'effet uniquement si les éléments existent
    createTypeWriterEffect('messa', "À propos de EasePaySchool");
    createTypeWriterEffect('messag', "Découvrez notre mission, nos fonctionnalités et nos avantages.");

    // Effet de chargement de la page
    const loader = document.getElementById('loader');
    if (loader) {
        loader.classList.add('fade-out');
        setTimeout(() => loader.style.display = 'none', 1000);
    }

    // Empêcher le clic droit
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });

    // Empêcher certaines combinaisons de touches
    document.addEventListener('keydown', function (e) {
        const key = e.key.toLowerCase();
        if ((e.ctrlKey || e.metaKey) && ['s', 'u', 'r'].includes(key)) {
            e.preventDefault();
        }
        if (['f12', 'f5'].includes(key)) {
            e.preventDefault();
        }
    });
});
