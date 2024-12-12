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