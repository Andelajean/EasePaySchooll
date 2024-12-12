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