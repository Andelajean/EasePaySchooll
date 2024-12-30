$(function(){
  
    var swiper = new Swiper('.carousel-gallery .swiper-container', {
      effect: 'slide',
      speed: 900,
      slidesPerView: 5,
      spaceBetween: 20,
      simulateTouch: true,
      autoplay: {
        delay: 5000,
        stopOnLastSlide: false,
        disableOnInteraction: false
      },
      pagination: {
        el: '.carousel-gallery .swiper-pagination',
        clickable: true
      },
      breakpoints: {
        // when window width is <= 320px
        320: {
          slidesPerView: 1,
          spaceBetween: 5
        },
        // when window width is <= 480px
        425: {
          slidesPerView: 2,
          spaceBetween: 10
        },
        // when window width is <= 640px
        768: {
          slidesPerView: 3,
          spaceBetween: 20
        }
      }
    }); /*http://idangero.us/swiper/api/*/
  
    
  
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
