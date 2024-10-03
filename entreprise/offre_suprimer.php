<?php
session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('app/controller/controllerOffre_emploi.php');
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <title>
        <?= $getEntreprise['entreprise']; ?>
    </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/offre_suprimer.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include('../include/header_entreprise.php') ?>

    <section class="section3">


        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message">
                <p>
                    <span></span>
                    <?php echo $_SESSION['success_message']; ?>
                    <?php unset($_SESSION['success_message']); ?>
                </p>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="erreurs" id="messageErreur">
                    <span></span>
                    <?php echo $_SESSION['error_message']; ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <script>
            let success = document.querySelector('.message')
            setTimeout(() => {
                success.classList.add('visible');
            }, 200);
            setTimeout(() => {
                success.classList.remove('visible');
            }, 6000);

            // Sélectionnez l'élément contenant le message d'erreur
            var messageErreur = document.getElementById('messageErreur');

            // Fonction pour afficher le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.add('visible');
            }, 200); // 1000 millisecondes équivalent à 1 seconde

            // Fonction pour masquer le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.remove('visible');
            }, 6000); // 6000 millisecondes équivalent à 6 secondes
        </script>


        <div class="container_box2">
            <div class="box1">
                <h1>Mes offres suprimées</h1>
                <span>
                    <?php $countOffre = count($afficheOffreEmplois_suprimer);
                    echo $countOffre
                        ?>
                </span>
            </div>

            <div class="box2">
                <?php
                if (empty($afficheOffreEmplois_suprimer)):
                    ?>
                    <p class="info"><strong>Info!</strong> Aucune offre d’emplois supprimée !</p>
                <?php else: ?>

                    <?php
                    foreach ($afficheOffreEmplois_suprimer as $offres):
                        ?>

                        <?php $countOffre = countOffre($db, $offres['entreprise_id'], $offres['offre_id']); ?>
                        <div class="carousel">
                            <a class="suprimer" href="?offre_id_suprime=<?= $offres['offre_id']; ?>"> Supprimer</a>
                            <div class="vue">
                                <img src="../image/vue.png" alt="">
                                <span>
                                    <?= $countOffre ?>
                                </span>
                            </div>

                            <div class="boximg">
                                <img src="../upload/<?= $offres['images'] ?> " alt="">
                            </div>


                            <div class="box_vendu">

                                <p class="p"><strong>Nous recherchons un(une)</strong>
                                    <?= $offres['poste'] ?>
                                </p>
                                <div class="vendu">
                                    <p><strong>Niveau :</strong>
                                        <?= $offres['etudes'] ?>
                                    </p>
                                    <p><strong>Experience :</strong>
                                        <?= $offres['experience'] ?>
                                    </p>
                                    <p><strong>Contrat :</strong>
                                        <?= $offres['contrat'] ?>
                                    </p>
                                    <p><strong>Localite :</strong>
                                        <?= $offres['ville'] ?>
                                    </p>
                                </div>
                            </div>

                            <p id="nom">
                                <?= $offres['date'] ?>
                            </p>

                            <div class="liens">
                                <a class="restore" href="?restorer=<?= $offres['offre_id'] ?>"><img src="../image/restore.png"
                                        alt=""></span>Republier l'offre</a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif ?>

            </div>
        </div>



    </section>





</body>

</html>