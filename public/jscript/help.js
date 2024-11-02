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