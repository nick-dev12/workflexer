<?php
session_start();
include '../conn/conn.php';

if (isset($_GET['supp4'])) {
    $users_id = $_GET['supp4'];
    $sql = "DELETE FROM notification_suivi WHERE users_id=:users_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: mes_demande.php");
    exit();
}

include_once('../controller/controller_postulation.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');


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

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_users.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');
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

    <title>Mes demandes</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">

    <script defer src="../script/jquery-3.6.0.min.js"></script>

    <script defer src="../script/summernote@0.8.18.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script defer src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/candidature_accepter.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php'); ?>


    <?php include('../include/header_users.php') ?>



    <section class="section3">

        <div class="box6">
            <h3 class="h31">Candidatures acceptées</h3>
            <p class="p1">Ici apparaîtront les candidatures acceptées</p>
            <div class="container_accept">
                <?php if (empty($getPostulationUsers)): ?>
                    <p><strong>Info :</strong> aucune Candidatures trouver !!</p>
                <?php else: ?>
                    <?php foreach ($getPostulationUsers as $postulationUsers): ?>
                        <?php $getOffreEmploie = getOffresEmploit($db, $postulationUsers['offre_id']);
                        $infoEntreprises = getEntreprise($db, $postulationUsers['entreprise_id'])
                            ?>
                        <?php if ($postulationUsers['statut'] == 'accepter'): ?>
                            <div class="accept" data-aos="fade-up">
                                <?php if ($postulationUsers['statut'] == 'accepter'): ?>
                                    <!-- <h5 class="h51">accepter</h5> -->
                                <?php endif; ?>
                                <img class="img" src="../upload/<?= $infoEntreprises['images'] ?>" alt="">

                                <div class="box">

                                    <h4><?php echo $infoEntreprises['entreprise'] ?></h4>
                                    <h5><span>Poste :</span> <?= $postulationUsers['poste'] ?></h5>

                                    <div class="info">
                                        <p><strong>Contrat :</strong> <?= $getOffreEmploie['contrat'] ?> </p>
                                        <p><strong>Niveau :</strong> <?= $getOffreEmploie['etudes'] ?> </p>
                                        <p><strong>Experience :</strong> <?= $getOffreEmploie['experience'] ?> </p>
                                        <p><strong>Localité : </strong> <?= $getOffreEmploie['localite'] ?> </p>
                                    </div>

                                    <div class="lien">
                                        <?php if ($postulationUsers['statut'] == 'recaler'): ?>
                                            <a class="cursor"
                                                href="../entreprise/voir_offre.php?id=<?= $postulationUsers['offre_id']; ?>"><img
                                                    src="../image/vue3.png" alt=""> Désactiver
                                            </a>
                                        <?php else: ?>
                                            <a class="b" href="../page/message_users.php"><img src="../image/message.png" alt="">
                                                Message
                                            </a>
                                            <a class="a"
                                                href="../entreprise/voir_offre.php?offres_id=<?= $postulationUsers['offre_id']; ?>"><img
                                                    src="../image/vue2.png" alt=""> Voir l'offre
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>


                                <?php if ($postulationUsers['statut'] == 'accepter'): ?>
                                    <h5 class="h51"><span>acceptée</span></h5>
                                <?php endif; ?>

                            </div>
                        <?php else: ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>



    </section>




    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>

</body>

</html>