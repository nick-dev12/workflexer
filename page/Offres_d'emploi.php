<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php')
    ?>


<!DOCTYPE html>
<html lang="en">

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

    <title>bienvenu</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <section class="section2" data-aos="zoom-in">
        <div class="slider">
            <div class="box">
                <div class="img owl-carousel boot">
                    <img src="/image/offre1.jpg" alt="">
                    <img src="/image/offre-emploi-quebec.jpg" alt="">
                    <img src="/image/offre3.jpg" alt="">
                    <img src="/image/offre4.jpeg" alt="">
                </div>
                <div class="text">
                    <h1>Exploré les profils qui conviennent à vos besoins</h1>
                    <p>Un large éventail de profiles professionnels toute catégorie confondu pour satisfaire le moindres
                        de vos besoins en main d'œuvre et bien plus encore </p>
                    <form action="" method="post">
                        <input type="search" name="" id="search">
                        <label for="recherche"><i class="fa-solid fa-magnifying-glass fa-xs"></i></label>
                        <input type="submit" value="recherche" id="recherche">
                    </form>
                </div>
            </div>

        </div>

    </section>


    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">

            <h1>Ingénierie et architecture</h1>
            <div class="affiche">
                <img src="/image/ingenieur.jpeg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel1">
            <?php if (empty($offreIngenierie)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>
                <?php foreach ($offreIngenierie as $ingenieurs): ?>
                    <div class="carousel">
                        <img src="../upload/<?php echo $ingenieurs['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $ingenieurs['entreprise']; ?>
                            </strong>

                        </p>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($ingenieurs['poste']); ?>
                                </p>
                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($ingenieurs['contrat']); ?>
                                </p>

                            </div>

                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($ingenieurs['ville']); ?>
                                </p>
                            </div>

                        </div>

                        <p id="nom">
                            <?php echo $ingenieurs['date']; ?>
                        </p>
                        <a
                            href="../entreprise/voir_offre.php?id=<?= $ingenieurs['offre_id']; ?>&entreprise_id=<?= $ingenieurs['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>


                <?php endforeach ?>
            <?php endif; ?>
        </article>

    </section>




    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1> Design et création</h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/info.jpg" alt=""> -->
                <img src="/image/webdesign.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel2">
            <?php if (empty($offreDesing)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreDesing as $Designs): ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $Designs['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $Designs['entreprise']; ?>
                            </strong>
                        </p>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($Designs['poste']); ?>
                                </p>

                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($Designs['contrat']); ?>
                                </p>
                            </div>

                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($Designs['ville']); ?>
                                </p>
                            </div>

                        </div>

                        <p id="nom">
                            <?php echo $Designs['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?id=<?= $Designs['offre_id']; ?>&entreprise_id=<?= $Designs['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>












    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Rédaction et traduction</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/Redaction.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel3" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"
            data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true"
            data-aos-once="false">
            <?php if (empty($offreRedaction)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreRedaction as $Redaction): ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $Redaction['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $Redaction['entreprise']; ?>
                            </strong>
                        </p>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($Redaction['poste']); ?>
                                </p>

                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($Redaction['contrat']); ?>
                                </p>
                            </div>

                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($Redaction['ville']); ?>
                                </p>
                            </div>

                        </div>
                        <p id="nom">
                            <?php echo $Redaction['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?id=<?= $Redaction['offre_id']; ?>&entreprise_id=<?= $Redaction['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>
                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Marketing et communication</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/marketing.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel4" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"
            data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true"
            data-aos-once="false">
            <?php if (empty($offreMarcketing)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreMarcketing as $marketing): ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $marketing['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $marketing['entreprise']; ?>
                            </strong>
                        </p>

                        <div class="box_vendu">
                            <div class="vendu">
                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($marketing['poste']); ?>
                                </p>
                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($marketing['contrat']); ?>
                                </p>
                            </div>

                        </div>

                        <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($marketing['ville']); ?>
                                    </p>
                                </div>

                            </div>

                        <p id="nom">
                            <?php echo $marketing['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?id=<?= $marketing['offre_id']; ?>&entreprise_id=<?= $marketing['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>








    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Conseil et gestion d'entreprise</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/gestion.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel5" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"
            data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true"
            data-aos-once="false">
            <?php if (empty($offreBusiness)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>
                </h1>

            <?php else: ?>

                <?php foreach ($offreBusiness as $business): ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $business['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $business['entreprise']; ?>
                            </strong>

                        </p>

                        <div class="box_vendu">
                            <div class="vendu">
                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($business['poste']); ?>
                                </p>
                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($business['contrat']); ?>
                                </p>
                            </div>

                        </div>
                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($business['ville']); ?>
                                </p>
                            </div>

                        </div>
                        <p id="nom">
                            <?php echo $business['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?id=<?= $business['offre_id']; ?>&entreprise_id=<?= $business['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Juridique</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/juridique.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev" ><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next" ><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel6" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"
            data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true"
            data-aos-once="false">
            <?php if (empty($offreJuridique)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreJuridique as $Juridique): ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $Juridique['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $Juridique['entreprise']; ?>
                            </strong>
                        </p>

                        <div class="box_vendu">
                            <div class="vendu">
                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($Juridique['poste']); ?>
                                </p>
                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($Juridique['contrat']); ?>
                                </p>
                            </div>
                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($Juridique['ville']); ?>
                                </p>
                            </div>

                        </div>

                        <p id="nom">
                            <?php echo $Juridique['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?id=<?= $Juridique['offre_id']; ?>&entreprise_id=<?= $Juridique['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>









    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Informatique et tech </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/info.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next" ><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"
            data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true"
            data-aos-once="false">
            <?php if (empty($offreInformatique)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreInformatique as $Informatique): ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $Informatique['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $Informatique['entreprise']; ?>
                            </strong>

                        </p>
                        <div class="box_vendu">
                            <div class="vendu">
                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($Informatique['poste']); ?>
                                </p>
                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($Informatique['contrat']); ?>
                                </p>
                            </div>

                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($Informatique['ville']); ?>
                                </p>
                            </div>

                        </div>

                        <p id="nom">
                            <?php echo $Informatique['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?id=<?= $Informatique['offre_id']; ?>&entreprise_id=<?= $Informatique['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>










    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>

    <script>
        // ..
        AOS.init();

        // You can also pass an optional settings object
        // below listed default settings
        AOS.init({
            // Global settings:
            disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
            initClassName: 'aos-init', // class applied after initialization
            animatedClassName: 'aos-animate', // class applied on animation
            useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 400, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    </script>

    <script>
        $(document).ready(function () {

            var carousel = $('.carousel1');

            var numItems = carousel.find('.carousel').length;

            if (numItems > 4) {

                // Initialiser Owl Carousel si il y a plus de 4 éléments
                carousel.owlCarousel({
                    items: 5, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 20,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });

                var carousel = $('.carousel1').owlCarousel();
                $('.owl-next').click(function () {
                    carousel.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel.trigger('prev.owl.carousel');
                })



            } else {

                // Empêcher l'initialisation de Owl Carousel
                carousel.trigger('destroy.owl.carousel');

                // Remettre styles par défaut
                carousel.removeClass('owl-carousel owl-loaded');
                carousel.find('.owl-stage-outer').children().unwrap();

            }

            $(document).ready(function () {


                $('.boot').owlCarousel({
                    items: 1,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 1,
                    smartSpeed: 450,
                    margin: 0,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });


            });


        }),

            $(document).ready(function () {
                // Carrousel 3  
                var carousel2 = $('.carousel2');
                var numItems2 = carousel2.find('.carousel').length;

                if (numItems2 > 4) {

                    // Initialiser Owl carousel2 si il y a plus de 4 éléments
                    carousel2.owlCarousel({
                        items: 5, // Limitez le nombre d'éléments à afficher à 5
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 4000,
                        animateOut: 'slideOutDown',
                        animateIn: 'flipInX',
                        stagePadding: 30,
                        smartSpeed: 450,
                        margin: 200,
                        nav: true,
                        navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                    });

                    var carousel2 = $('.carousel2').owlCarousel();
                    $('.owl-next').click(function () {
                        carousel2.trigger('next.owl.carousel');
                    })
                    $('.owl-prev').click(function () {
                        carousel2.trigger('prev.owl.carousel');
                    })



                } else {

                    carousel2.trigger('destroy.owl.carousel');
                    carousel2.removeClass('owl-carousel owl-loaded');
                    carousel2.find('.owl-stage-outer').children().unwrap();

                }


            });












        $(document).ready(function () {
            // Carrousel 3  
            var carousel3 = $('.carousel3');
            var numItems2 = carousel3.find('.carousel').length;

            if (numItems2 > 4) {

                // Initialiser Owl carousel3 si il y a plus de 4 éléments
                carousel3.owlCarousel({
                    items: 5, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 20,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });

                var carousel3 = $('.carousel3').owlCarousel();
                $('.owl-next').click(function () {
                    carousel3.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel3.trigger('prev.owl.carousel');
                })



            } else {

                carousel3.trigger('destroy.owl.carousel');
                carousel3.removeClass('owl-carousel owl-loaded');
                carousel3.find('.owl-stage-outer').children().unwrap();

            }


        });




        $(document).ready(function () {
            // Carrousel 3  
            var carousel4 = $('.carousel4');
            var numItems2 = carousel4.find('.carousel').length;

            if (numItems2 > 4) {

                // Initialiser Owl carousel4 si il y a plus de 4 éléments
                carousel4.owlCarousel({
                    items: 4, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 20,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });

                var carousel4 = $('.carousel4').owlCarousel();
                $('.owl-next').click(function () {
                    carousel4.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel4.trigger('prev.owl.carousel');
                })



            } else {

                carousel4.trigger('destroy.owl.carousel');
                carousel4.removeClass('owl-carousel owl-loaded');
                carousel4.find('.owl-stage-outer').children().unwrap();

            }


        });


        $(document).ready(function () {
            // Carrousel 3  
            var carousel5 = $('.carousel5');
            var numItems2 = carousel5.find('.carousel').length;

            if (numItems2 > 4) {

                // Initialiser Owl carousel5 si il y a plus de 4 éléments
                carousel5.owlCarousel({
                    items: 5, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 200,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });

                var carousel5 = $('.carousel5').owlCarousel();
                $('.owl-next').click(function () {
                    carousel5.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel5.trigger('prev.owl.carousel');
                })



            } else {

                carousel5.trigger('destroy.owl.carousel');
                carousel5.removeClass('owl-carousel owl-loaded');
                carousel5.find('.owl-stage-outer').children().unwrap();

            }


        });



        $(document).ready(function () {
            // Carrousel 3  
            var carousel6 = $('.carousel6');
            var numItems2 = carousel6.find('.carousel').length;

            if (numItems2 > 4) {

                // Initialiser Owl carousel6 si il y a plus de 4 éléments
                carousel6.owlCarousel({
                    items: 5, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 20,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });

                var carousel6 = $('.carousel6').owlCarousel();
                $('.owl-next').click(function () {
                    carousel6.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel6.trigger('prev.owl.carousel');
                })



            } else {

                carousel6.trigger('destroy.owl.carousel');
                carousel6.removeClass('owl-carousel owl-loaded');
                carousel6.find('.owl-stage-outer').children().unwrap();

            }


        });



        $(document).ready(function () {
            // Carrousel 3  
            var carousel7 = $('.carousel7');
            var numItems2 = carousel7.find('.carousel').length;

            if (numItems2 > 4) {

                // Initialiser Owl carousel7 si il y a plus de 4 éléments
                carousel7.owlCarousel({
                    items: 5, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 20,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
                });

                var carousel7 = $('.carousel7').owlCarousel();
                $('.owl-next').click(function () {
                    carousel7.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel7.trigger('prev.owl.carousel');
                })



            } else {

                carousel7.trigger('destroy.owl.carousel');
                carousel7.removeClass('owl-carousel owl-loaded');
                carousel7.find('.owl-stage-outer').children().unwrap();

            }




            $('.container_slider').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 1000,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });


        });
    </script>

</body>

</html>