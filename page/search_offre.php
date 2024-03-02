<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');


// Vérifier si les résultats de la recherche sont disponibles dans la session
if (isset($_SESSION['resultats'])) {
    // Récupérer les résultats de la recherche
    $resultats = $_SESSION['resultats'];
    // Effacer les résultats de la recherche de la session (facultatif)
    unset($_SESSION['resultats']);
} else {
   
}
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
   

    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">

            <h1>Resultats</h1>
            <div class="affiche">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article
            class="articles owl-carousel carousel1">
            <?php if (empty($resultats)): ?>

                <h1 class="message">Aucun resultat trouver pour cette recherche !</h1>

            <?php else: ?>
                <?php foreach ($resultats as $ingenieurs): ?>
                    <div class="carousel">
            <?php $info_entreprise = getEntreprise($db, $ingenieurs['entreprise_id']) ?>
                        <img src="../upload/<?php echo $info_entreprise['images'] ?>" alt="">
                       <div class="info-box">
                       <p class="p">
                            <strong>
                                <?php echo $info_entreprise['entreprise']; ?>
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
                                <p>
                                    <strong>Niveau :</strong>
                                    <?php echo ($ingenieurs['etudes']); ?>
                                </p>
                                <p>
                                    <strong>Experience :</strong>
                                    <?php echo ($ingenieurs['experience']); ?>
                                </p>

                            </div>

                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($info_entreprise['ville']); ?>
                                </p>
                            </div>

                        </div>

                        <p id="nom">
                            <?php echo $ingenieurs['date']; ?>
                        </p>
                        <a
                            href="../entreprise/voir_offre.php?offres_id=<?= $ingenieurs['offre_id']; ?>&entreprise_id=<?= $ingenieurs['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                       </div>
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
    <script src="/js/silder_offres.js"></script>

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
    

</body>

</html>