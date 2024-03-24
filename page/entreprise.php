<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <title>Bienvenu</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/aos.css" />
    <script src="../js/aos.js"></script>
    <link rel="stylesheet" href="/css/owl.carousel.css">

    <style>
        .section3{
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section3 h1{
            width: 400px;
            text-align: center;
            padding:10px 30px;
            background-color: red;
            color: white;
            border-radius: 20px;

        }
    </style>
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include ('../navbare.php') ?>

<section class="section3">
    <h1>
        Indisponible pour le moment !
    </h1>
</section>

    <?php include ('../footer.php') ?>





    <!--
ScrollSmoother.min.js, InertiaPlugin.min.js, ScrambleTextPlugin.min.js, and SplitText.min.js are Club GreenSock perks which are not available on a CDN. Download them from your GreenSock account and include them locally like this:

<script src="/[YOUR_DIRECTORY]/ScrollSmoother.min.js"></script>
<script src="/[YOUR_DIRECTORY]/InertiaPlugin.min.js"></script>
<script src="/[YOUR_DIRECTORY]/ScrambleTextPlugin.min.js"></script>
<script src="/[YOUR_DIRECTORY]/SplitText.min.js"></script>

Sign up at https://greensock.com/club or try them for free on CodePen or CodeSandbox
-->
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>


    <div></div>

    <script>

    </script>
    <script>
        $(document).ready(function () {


            $('.slider-area').owlCarousel({
                items: 1,
                loop: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 6000,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                smartSpeed: 900,
                stagePadding: 1,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });



            // Animation GSA
            // Initialiser le carrousel 1 avec la portée appropriée
            $('.box01').owlCarousel({
                items: 3,
                loop: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 6000,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                smartSpeed: 900,
                stagePadding: 1,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel1 = $('.box01').owlCarousel();
            $('.next').click(function () {
                carousel1.trigger('next.owl.carousel');
            })
            $('.prev').click(function () {
                carousel1.trigger('prev.owl.carousel');
            });




            // Sélectionnez la section avec la classe "temoin"

            var sectionTemoin = document.querySelector('.temoin');

            // Vérifiez si la section existe
            if (sectionTemoin) {
                // Obtenez la liste des éléments enfants de la section
                var enfantsSection = sectionTemoin.children;

                // Vérifiez la condition du nombre d'éléments enfants
                if (enfantsSection.length > 3) {
                    // Code à exécuter si le nombre d'éléments enfants est supérieur à 3
                    $('.temoin').addClass('owl-carousel').owlCarousel({
                        items: 4,
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        animateOut: 'slideOutDown',
                        animateIn: 'flipInX',
                        stagePadding: 10,
                        smartSpeed: 650,
                        margin: 100,
                        nav: true,
                        responsive: {
                            0: {
                                items: 1,
                                margin: 20,
                            },
                            550: {
                                items: 2,
                            },
                            690: {
                                items: 3,

                            },
                            890: {
                                items: 3
                            },
                            1200: {
                                items: 4
                            },
                            1400: {
                                items: 4
                            }
                        }
                    });

                    // Code pour gérer la navigation du carousel
                    var carousel1 = $('.temoin').owlCarousel();
                    $('.owl-next').click(function () {
                        carousel1.trigger('next.owl.carousel');
                    })
                    $('.owl-prev').click(function () {
                        carousel1.trigger('prev.owl.carousel');
                    });
                } else {
                    // Code à exécuter si le nombre d'éléments enfants est inférieur ou égal à 3
                    console.log("Le nombre d'éléments enfants est inférieur ou égal à 3. Ne faites rien.");
                }
            } else {
                console.error("La section avec la classe 'temoin' n'a pas été trouvée.");
            }



            // Sélectionnez la section avec la classe "temoin"

            var owlSlider = document.querySelector('.owl-slider');

            // Vérifiez si la section existe
            if (owlSlider) {
                // Obtenez la liste des éléments enfants de la section
                var enfantSection = owlSlider.children;

                // Vérifiez la condition du nombre d'éléments enfants
                if (enfantSection.length > 2) {
                    // Code à exécuter si le nombre d'éléments enfants est supérieur à 3
                    $('.owl-slider').addClass('owl-carousel').owlCarousel({
                        items: 3,
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        animateOut: 'slideOutDown',
                        animateIn: 'flipInX',
                        stagePadding: 10,
                        smartSpeed: 450,
                        margin: 100,
                        nav: true,
                        responsive: {
                            0: {
                                items: 1,
                                margin: 0,
                            },
                            460: {
                                items: 2,

                            },
                            550: {
                                items: 2,

                            },
                            890: {
                                items: 2,

                            },
                            1200: {
                                items: 3
                            },
                            1400: {
                                items: 3
                            }
                        }
                    });

                    // Code pour gérer la navigation du carousel
                    var carousel1 = $('.owl-carousel').owlCarousel();
                    $('.owl-next').click(function () {
                        carousel1.trigger('next.owl.carousel');
                    })
                    $('.owl-prev').click(function () {
                        carousel1.trigger('prev.owl.carousel');
                    });
                } else {
                    // Code à exécuter si le nombre d'éléments enfants est inférieur ou égal à 3
                    console.log("Le nombre d'éléments enfants est inférieur ou égal à 3. Ne faites rien.");
                }
            } else {
                console.error("La section avec la classe 'temoin' n'a pas été trouvée.");
            }




            $('.slider-area').owlCarousel({
                items: 1,
                loop: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 6000,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                smartSpeed: 900,
                stagePadding: 1,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });


        });






    </script>

    <script>
        // ..
        AOS.init();
    </script>
</body>

</html>