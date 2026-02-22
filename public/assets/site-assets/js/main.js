document.addEventListener('DOMContentLoaded', function () {
    var header = document.querySelector('#mainNavbar');

    window.addEventListener('scroll', function () {
        if (header) {
            header.classList.toggle('scrolled', window.scrollY > 0);
        }
    });
});

 $(document).ready(function () {


            $(".owl-carousel1").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,navText: [
        '<i class="fa-solid fa-chevron-left"></i>',
        '<i class="fa-solid fa-chevron-right"></i>'
    ],
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1,
                        autoplay: true
                    },
                    600: {
                        items: 2,
                        autoplay: true
                    },
                    1000: {
                        items: 4,
                        autoplay: true
                    }
                }
            });

            $(".owl-carousel2").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: false,
                autoplayHoverPause: false,
                responsive: {
                    0: { items: 1 },
                    600: { items: 2 },
                    1000: { items: 4 }
                }
            });
            
            
            $(".owl-carousel3").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: false,
                // autoplayTimeout: 4000,
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:2
                    },
                    1200:{
                        items:3
                    }
                }
            });

        });
   
      

        const buttons = document.querySelectorAll('.question button');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const parent = button.closest('.question');
                const answer = parent.querySelector('p');
                const icon = button.querySelector('.d-arrow');

                if (answer) {
                    answer.classList.toggle('show');
                } else {
                    console.warn('No answer <p> found for:', button);
                }

                if (icon) {
                    icon.classList.toggle('rotate');
                } else {
                    console.warn('No icon found in button:', button);
                }
            });
        });