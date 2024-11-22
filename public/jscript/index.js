   //chargement de la page
   window.addEventListener("load", function () {
    const loader = document.getElementById('loader');
    loader.classList.add('fade-out'); // Ajoute l'animation de fondu
    setTimeout(() => loader.style.display = 'none', 1000); // Masque le loader après l'animation
    });
    $(document).ready(mySlider);

function mySlider() {
    var imgNumber, 
        sliderContainerWidth, 
        imgContainer,
        index,
        flag = true,
        speed = 600,
        bullets = true,
        auto = true ,
        time = 5000 ;
        
    construction();
    $(window).resize(construction);
    if(auto){
     var handle = setInterval(slideRight, time) ; 
    }

    function construction() {
        index = 1;
        imgNumber = $('.images-container li').length;
        sliderContainerWidth = Math.round($('#slider-container').width());
        imgContainer = sliderContainerWidth * imgNumber;
        $('.images-container').css("width", imgContainer);
        $('.images-container li').css("width", sliderContainerWidth);
        $('.images-container').css("margin-left", 0);
        if (bullets == true) {
            $('.bullets-container').html("");
            for (i = 1; i <= imgNumber; i++) {
                $('.bullets-container').append("<span class='bullet'></span>");
            }
            $('.bullet').eq(0).addClass('active');
        }
        $(".bullet").click(pagers);
        $('.a-right').click(slideRight);
        $('.a-left').click(slideLeft);
    }

    function pagers() {
        if (!$(this).hasClass('active')) {
            var bulletIndex = $(".bullets-container span").index(this) + 1;
            index = bulletIndex;
            $(".bullets-container").find(".bullet").removeClass("active").eq(bulletIndex - 1).addClass("active");
            $('.images-container').animate({
                marginLeft: -sliderContainerWidth * (bulletIndex - 1)
            }, speed);
        }
    }

    function slideRight() {
        var imgContainerLeft = parseInt($('.images-container').css('margin-left'));
        if (flag) {
            if (imgContainerLeft == -sliderContainerWidth * (imgNumber - 1)) {
                index = 1;
                $('.images-container').animate({
                    marginLeft: 0
                }, speed, function() {
                    flag = true;
                })
            } else {
                index++;
                $('.images-container').animate({
                    marginLeft: '-=' + sliderContainerWidth
                }, speed, function() {
                    flag = true;
                })
            }
            flag = false;
            $(".bullets-container").find(".bullet").removeClass("active").eq(index - 1).addClass("active");
        }
    }

    function slideLeft() {
        var imgContainerLeft = parseInt($('.images-container').css('margin-left'));
        clearInterval(slideRight, 3000);
        if (flag) {
            if (imgContainerLeft == 0 ) {
                index = index + (imgNumber - 1);
                $('.images-container').animate({
                    marginLeft: -sliderContainerWidth * (imgNumber - 1) + 'px'
                }, speed, function() {
                    flag = true;
                })
            } else {
                index--;
                $('.images-container').animate({
                    marginLeft: '+=' + sliderContainerWidth
                }, speed, function() {
                    flag = true;
                })
            }
            flag = false;
            $(".bullets-container").find(".bullet").removeClass("active").eq(index - 1).addClass("active");
        }

    }
    $("#slider-container .arrow , .bullets-container").hover(function(){
      clearInterval(handle);
    },function(){
      handle = setInterval(slideRight, time) ;
    })
  
};

document.addEventListener('DOMContentLoaded', function() {
    // Message à afficher
    const message = "Bienvenue dans EasePaySchool : la meilleure plateforme pour régler vos frais de scolarité !";

    const errorMessage = document.getElementById('message');
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

 // Sélection du bouton
 const fixedButton = document.querySelector('.fixed-button');

 // Ajout d'un écouteur d'événement pour le scroll
 window.addEventListener('scroll', () => {
     // Vérification si la page est scrollée
     if (window.scrollY > 50) {
         fixedButton.classList.add('scrolled');
     } else {
         fixedButton.classList.remove('scrolled');
     }
 });

 
document.addEventListener('DOMContentLoaded', function() {
    // Message à afficher
    const message = "Pourquoi Utiliser EasePaySchool??";

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

//partenaire
