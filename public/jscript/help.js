  //chargement de la page
  window.addEventListener("load", function () {
    const loader = document.getElementById('loader');
    loader.classList.add('fade-out'); // Ajoute l'animation de fondu
    setTimeout(() => loader.style.display = 'none', 1000); // Masque le loader après l'animation
    });
    function toggleAnswer(id) {
        const answer = document.getElementById(`answer-${id}`);
        answer.classList.toggle('hidden');
    }

    
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
