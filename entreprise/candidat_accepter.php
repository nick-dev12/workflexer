<?php
session_start();

if (isset($_SESSION['compte_entreprise'])) {
} else {
    header('Location: ../index.php');
}

include_once('../entreprise/app/controller/controllerEntreprise.php');
include_once('../entreprise/app/controller/controllerDescription.php');
include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_postulation.php');
include_once('../controller/controller_accepte_candidats.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
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

    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/candidat_accepte.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php
    include('../navbare.php')
    ?>

    <?php include('../include/header_entreprise.php') ?>


    <section class="section3">


        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="message">
                <p>
                    <span></span>
                    <?php echo $_SESSION['success_message']; ?>
                    <?php unset($_SESSION['success_message']); ?>
                </p>
            </div>
        <?php else : ?>
            <?php if (isset($_SESSION['error_message'])) : ?>
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
            setTimeout(function() {
                messageErreur.classList.add('visible');
            }, 200); // 1000 millisecondes équivalent à 1 seconde

            // Fonction pour masquer le message avec une transition de fondu
            setTimeout(function() {
                messageErreur.classList.remove('visible');
            }, 6000); // 6000 millisecondes équivalent à 6 secondes
        </script>
        <!-- <div class="box1">
            <h1>Bienvenu au centre de gestion des offres postuler !</h1>
            <div class="container_slider owl-carousel ">
            <img src="../image/gse.png" alt="">
            <img src="../image/gse2.jpg" alt="">
                <img src="../image/gestion_off1.jpg" alt="">
                <img src="../image/gestion_off2.jpg" alt="">
                <img src="../image/GestionOffre.png" alt="">
            </div>
        </div> -->





        <div class="div-section2 acc">
            <h4>Candidatures accepter</h4>
            <div class="container  ">

                <?php foreach ($getALLpostulations as $postulant) : ?>
                    <?php
                    $niveau = gettNiveau($db, $postulant['users_id']);
                    $explode_nom = explode(' ', $postulant['nom']);
                    $nom =  $explode_nom[0] . ' , ' . $explode_nom[1];
                    $competencesUsers = getCompetences($db, $postulant['users_id']);
                    $nombreCompetencesAffichees = 2;
                    ?>


                    <?php if ($postulant['statut'] == 'accepter') : ?>

                        <div class="items">
                            <h5 class="h51">accepter</h5>

                            <img src="../upload/<?= $postulant['images'] ?>" alt="">

                            <h5> <?= $postulant['competences'] ?></h5>
                            <ul>
                                <li>
                                    <strong>Nom : </strong> <?= $nom ?>
                                </li>
                                <?php if ($niveau) : ?>
                                    <li>
                                        <strong>Niveau : </strong> <?= $niveau['etude'] ?>
                                    </li>
                                    <li>
                                        <strong>expérience : </strong> <?= $niveau['experience'] ?>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <strong>Niveau : </strong> Non renseigner
                                    </li>
                                    <li>
                                        <strong>expérience : </strong> Non renseigner
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <strong>Niveau : </strong> <?= $postulant['phone'] ?>
                                </li>
                            </ul>


                            <div class="container-box_btn">
                                <button class="btn1"><img src="../image/vue2.png" alt=""> <a href="../page/candidats.php?id=<?= $postulant['users_id'] ?>">Voir le
                                        profil</a></button>
                                <button class="btn11"><img src="../image/message.png" alt=""> <a href="../entreprise/message.php">Message</a></button>

                            </div>
                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>
        </div>


    </section>









    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    
</body>

</html>