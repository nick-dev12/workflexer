<?php
session_start();
include '../conn/conn.php';

if (isset($_GET['supp3'])) {
    $users_id = $_GET['supp3'];
    $sql = "DELETE FROM notification_message_users WHERE users_id=:users_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: message_users.php");

    exit();
}

if (isset($_GET['id'])) {
    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_GET['id'];

    // Vous pouvez maintenant utiliser $commercant_id pour récupérer les informations de l'utilisateur depuis la base de données
// Écrivez votre requête SQL pour récupérer les informations nécessaires
    $conn = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $erreurs = '';

    $message = '';


    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
} else {

    if (isset($_COOKIE['users_id'])) {
        $users_id = $_COOKIE['users_id'];
    } else {
        $users_id = '';
    }


    // Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_SESSION['users_id'];

    // Vous pouvez maintenant utiliser $commercant_id pour récupérer les informations de l'utilisateur depuis la base de données
    // Écrivez votre requête SQL pour récupérer les informations nécessaires
    $conn = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);


    // $sql = "SELECT metier FROM metier_users WHERE users_id = :users_id";
    // $users_metier = $db->prepare($sql);
    // $users_metier->bindParam(':users_id', $users_id);
    // $users_metier->execute();


    $erreurs = '';

    $message = '';




    // Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session

    // Récupérer l'id du métier à supprimer (via lien ou formulaire par exemple)


    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_postulation.php');
    include_once('../entreprise/app/controller/controllerEntreprise.php');
    include_once('../entreprise/app/controller/controllerOffre_emploi.php');
    include_once('../controller/controller_appel_offre.php');
    include_once('../controller/controller_users.php');
}

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

    <title>Profil</title>
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src defer="../script/jquery-3.6.0.min.js"></script>

    <script src defer="../script/summernote@0.8.18.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">


    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="../css/navbare.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>



    <?php include('../include/header_users.php') ?>


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


        <div class="container_profil">

            <div class="box3">
                <h2>Candidatures retenues</h2>
                <?php if (empty($getPostulationUsers)): ?>
                    <p><strong>Info :</strong> aucune Candidatures trouver !!</p>
                <?php else: ?>
                    <?php foreach ($getPostulationUsers as $postulationUsers): ?>
                        <?php if ($postulationUsers['statut'] == 'accepter'): ?>
                            <?php $infoEntreprise = getEntreprise($db, $postulationUsers['entreprise_id']); ?>
                            <?php $afficheOffre = getOffresEmploit($db, $postulationUsers['offre_id']);

                            $afficheTMP1_Message1 = getTMP1_Message1($db, $postulationUsers['entreprise_id'], $postulationUsers['offre_id'], $postulationUsers['users_id']);

                            $totalMessage = count($afficheTMP1_Message1);

                            ?>
                            <a
                                href="get_message_users.php?users_id=<?= $postulationUsers['users_id'] ?>&offres_id=<?= $postulationUsers['offre_id'] ?>&entreprise_id=<?= $postulationUsers['entreprise_id'] ?>&statut=<?= $postulationUsers['statut'] ?> ">
                                <div class="info">
                                    <div class="c_img">
                                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                                    </div>

                                    <div class="div">
                                        <h4>
                                            <?= $infoEntreprise['entreprise'] ?>
                                        </h4>

                                        <?php if ($totalMessage): ?>
                                            <strong class="tmp">
                                                <?= $totalMessage ?>
                                            </strong>
                                        <?php endif; ?>

                                        <p><strong>Offre postuler:</strong>
                                            <?= $afficheOffre['poste'] ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="box2">
                <h2>Appels d'offres</h2>
                <?php if (empty($getAllAppel_offre)): ?>
                    <p><strong>Info :</strong> aucun Appel d'offres !!</p>
                <?php else: ?>
                    <?php foreach ($getAllAppel_offre as $appel_offre): ?>

                        <?php $infoEntreprise = getEntreprise($db, $appel_offre['entreprise_id']);

                        $appel_offre = getAppelOffre($db, $appel_offre['entreprise_id'], $appel_offre['users_id']);

                        $afficheTMP_message = getTMP2_Message3($db, $appel_offre['entreprise_id'], $appel_offre['users_id']);
                        $countTMP_message = count($afficheTMP_message);

                        ?>
                        <a
                            href="get_message_users2.php?users_id=<?= $appel_offre['users_id'] ?>&entreprise_id=<?= $appel_offre['entreprise_id'] ?>">
                            <div class="info">
                                <div class="c_img">
                                    <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                                </div>

                                <div class="div">
                                    <h4>
                                        <?= $infoEntreprise['nom'] ?>
                                    </h4>

                                    <?php if ($countTMP_message): ?>
                                        <strong class="tmp">
                                            <?= $countTMP_message ?>
                                        </strong>
                                    <?php endif; ?>

                                    <p> <strong>Competences:</strong>
                                        <?= $infoEntreprise['entreprise'] ?>
                                    </p>
                                </div>
                            </div>
                        </a>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


        </div>
    </section>


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