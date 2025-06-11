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
    createTypeWriterEffect('messa', "À propos de nos concours");
    createTypeWriterEffect('messag', "Découvrez les dates , les conditions d'éligibilités , frais à payer de nos diffrents concours");

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


    //fenetre choix du mode de paieement
    document.getElementById("openModal").addEventListener("click", function () {
    // document.getElementById("paymentModal").classList.remove("hidden");
    document.getElementById("paymentModal").classList.remove("hidden");
 
 });


 document.getElementById("confirmPaymentPhone").addEventListener("click", function () {
    let phoneNumber = document.getElementById("phoneNumber").value.trim();

    if (!phoneNumber) {
        alert("Veuillez entrer un numéro de téléphone.");
        return;
    }

    // Injecter le numéro dans le champ de téléphone du formulaire
    document.getElementById("telephone").value = phoneNumber;

    //document.getElementById("mode_paiement").value = "telephone";
    // Soumettre le formulaire
    document.getElementById("inscriptionForm").submit();
});

document.getElementById("closeModal").addEventListener("click", function () {
    document.getElementById("paymentModal").classList.add("hidden");
});

    
    
document.getElementById("closeModal").addEventListener("click", function () {
    document.getElementById("paymentModal").classList.add("hidden");
});
});
