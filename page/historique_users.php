<?php
session_start();
include('../conn/conn.php');
include_once('../controller/controller_users.php');
include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Historique
    </title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/historique_users.css">
</head>

<body>
    <?php include('../navbare.php') ?>


    <?php include('../include/header_users.php') ?>

    <section class="section3">


        <div class="container_box2">
            <div class="box1">
                <h1>Mon historique</h1>
            </div>

            <div class="box2">
                <?php foreach ($historique_users as $historiques): ?>
                    <?php $infosEntreprise = getEntreprise($db, $historiques['entreprise_id']);
                    $infoOffre = getOffresEmploit($db, $historiques['offre_id']);
                    ?>

                    <div class="carousel">
                        <img src="../upload/<?php echo $infosEntreprise['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $infosEntreprise['entreprise']; ?>
                            </strong>
                        </p>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($infoOffre['poste']); ?>
                                </p>

                                <p>
                                    <strong>Contrat :</strong>
                                    <?php echo ($infoOffre['contrat']); ?>
                                </p>
                            </div>

                        </div>

                        <div class="box_vendu">
                            <div class="vendu">

                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($infoOffre['localite']); ?>
                                </p>

                                <p class="ville">
                                    <strong>Niveau :</strong>
                                    <?php echo ($infoOffre['etudes']); ?>
                                </p>

                                <p class="ville">
                                    <strong>Experience :</strong>
                                    <?php echo ($infoOffre['experience']); ?>
                                </p>
                            </div>

                        </div>

                        <p id="nom">
                            <?php echo $infoOffre['date']; ?>
                        </p>

                        <a
                            href="../entreprise/voir_offre.php?offres_id=<?= $infoOffre['offre_id']; ?>&entreprise_id=<?= $infoOffre['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endforeach ?>
            </div>
        </div>

    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>


    <script>
        $(document).ready(function () {
            // Initialiser le carrousel 1 avec la portée appropriée
            $('.slider1').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 700,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel1 = $('.slider').owlCarousel();
            $('.owl-next').click(function () {
                carousel1.trigger('next.owl.carousel');
            })
            $('.owl-prev').click(function () {
                carousel1.trigger('prev.owl.carousel');
            })


        });
    </script>



</body>

</html>