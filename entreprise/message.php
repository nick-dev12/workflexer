<?php

session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_postulation.php');
include_once('../controller/controller_users.php');
include_once('../controller/controller_message1.php');
include_once('../controller/controller_appel_offre.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

         <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5JBWCPV7');</script>
<!-- End Google Tag Manager -->

    <title> <?= $getEntreprise['entreprise']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include ('../include/header_entreprise.php') ?>

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
            <h2>Candidats retenu</h2>
            <?php foreach ($getALLpostulation as $postulant): ?>
                <?php if($postulant['statut']=='accepter'):?>
                    <?php $getoffre =getOffresEmploit($db,$postulant['offre_id']);?>
                    <?php $infoUsers =getInfoUsers($db,$postulant['users_id']) ?>
                    <a href="message_entreprise.php?users_id=<?= $postulant['users_id']?>&offres_id=<?= $postulant['offre_id']?>&entreprise_id=<?= $postulant['entreprise_id']?>&statut=<?= $postulant['statut']?>">
           <div class="info" >
            <div class="c_img">
                 <img class="img" src="../upload/<?php echo $infoUsers['images']?>" alt="">
            </div>
               
                <div class="div" >
                    <h4><?= $postulant['nom']?></h4>
                    <p> <strong>Domaine de Competences: </strong> <?= $postulant['competences']?></p>
                    <p><span class="span1" ><strong>Offre postuler :</strong> <?= $postulant['poste']?></span> <span class="span2" ><?= $getoffre['contrat']?></span></p>
                </div>
            </div>
           </a>
            <?php endif;?>
            <?php endforeach; ?>
        </div>

        <div class="box2">
            <h2>Appel d'offres </h2>
            <?php foreach($getAllAppel_offre as $appel_offre): ?>
                <?php $infoUsers =getInfoUsers($db,$appel_offre['users_id']) ?>
                <a href="message_entreprise2.php?users_id=<?= $appel_offre['users_id']?>&entreprise_id=<?=$appel_offre['entreprise_id']?>">
            <div class="info">
            <div class="c_img">
            <img class="img" src="../upload/<?php echo $infoUsers['images']?>" alt="">
            </div>
                <div class="div" >
                <h4><?= $infoUsers['nom']?></h4>
                    <p> <strong>Domaine de Competences:</strong> <?= $infoUsers['competences']?></p>
                    <p><span class="span1" ><strong>Sujet : </strong> Appelle d'offre </span> </p>
                </div>
            </div>
        </a>
            <?php endforeach; ?>
        </div>
    </div>


        </div>
    </section>