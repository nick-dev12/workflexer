<?php

if (isset($_GET['users_id'])) {
    
}else{
    header('Location: ../index.php');
}

session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_postulation.php');
include('../controller/controller_message1.php'); 
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" href="/css/message_entreprise.css">
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

    <div class="container_profil">

    <div class="box3">
            <h2>Candidats retenu</h2>
            <?php foreach ($getALLpostulation as $postulant): ?>
                <?php if($postulant['statut']=='accepter'):?>
                    <?php $getoffre =getOffresEmploit($db,$postulant['offre_id']);?>
                 <?php  $afficheInfoUsers = getInfoUsers($db,$postulant['users_id']) ?>
                    <a href="message_entreprise.php?users_id=<?= $postulant['users_id']?>&offres_id=<?= $postulant['offre_id']?>&entreprise_id=<?= $postulant['entreprise_id']?>&statut=<?= $postulant['statut']?>">
           <div class="info" >
                <img src="../upload/<?php echo $afficheInfoUsers['images']?>" alt="">
                <div class="div" >
                    <h4><?= $postulant['nom']?></h4>
                    <p> <strong>Competences:</strong> <?= $postulant['competences']?></p>
                    <p><span class="span1" ><strong>Offre postuler:</strong> <?= $postulant['poste']?></span> <span class="span2" ><?= $getoffre['contrat']?></span></p>
                </div>
            </div>
           </a>
            <?php endif;?>
            <?php endforeach; ?>
        </div>

        <div class="box2">
            <h2>Appel d'offres</h2>
            <?php foreach($getAllAppel_offre as $appel_offre): ?>
                <?php $infoUsers =getInfoUsers($db,$appel_offre['users_id']) ?>
                <a href="message_entreprise2.php?users_id=<?= $appel_offre['users_id']?>&entreprise_id=<?=$appel_offre['entreprise_id']?>">
            <div class="info">
            <img src="../upload/<?php echo $infoUsers['images']?>" alt="">
                <div class="div" >
                <h4><?= $infoUsers['nom']?></h4>
                    <p> <strong>Competences:</strong> <?= $infoUsers['competences']?></p>
                    <p><span class="span1" ><strong>Sujet:</strong> Appelle d'offre </span> </p>
                </div>
            </div>
        </a>
            <?php endforeach; ?>
        </div>
    </div>





    <?php include('../include/affiche_message1.php') ?>
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


   
        // Actualisation des messages toutes les 2 secondes (exemple)
        setInterval('loadMessages()',1000);
function loadMessages() {
    $('#message')
}

    </script>



</body>

</html>