<?php
session_start();

include_once('../entreprise/app/controller/controllerEntreprise.php');
include_once('../entreprise/app/controller/controllerDescription.php');
include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_postulation.php');
include_once('../controller/controller_accepte_candidats.php');
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

    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/candidature.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
</head>

<body>

 <!-- Google Tag Manager (noscript) -->
 <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <?php
    include('../navbare.php')
        ?>

<?php include('../include/header_entreprise.php') ?>


<section class="section3">
        <div class="box1">
            <h1>Bienvenu au centre de gestion des offres postuler !</h1>
            <div class="container_slider owl-carousel ">
            <img src="../image/gse.png" alt="">
            <img src="../image/gse2.jpg" alt="">
                <img src="../image/gestion_off1.jpg" alt="">
                <img src="../image/gestion_off2.jpg" alt="">
                <img src="../image/GestionOffre.png" alt="">
            </div>
        </div>

        <div class="box2">
            <p> <span>1</span><strong>Gérez vos candidatures :</strong> Suivez 
            facilement les postulants à vos offres d'emploi et simplifiez le processus de sélection
            </p>
            <p>
                <span>2</span><strong>Consultez vos candidats :</strong>Accédez 
                aux profils des personnes qui ont répondu à vos offres, explorez leurs compétences et expériences.
            </p>
        </div>


        <div class="div-section2">
        <h2>Liste des candidatures</h2>

        <div class="container">
        <?php if(empty($getALLpostulation )): ?>
            <p class="info" ><strong>Info!</strong> Aucune candidature a vos offres d'emplois pour le moment.</p>
            <?php else: ?>
            <?php foreach ($getALLpostulation as $postulant): ?>
                <?php if($postulant['statut']=='accepter'):?>
                    <?php else: ?>
                        <?php if($postulant['statut']=='recaler'):?>

                            <?php else: ?>

                                <?php if(empty($postulant['statut']== '')  ):?>
                                   
                                    <h6>accune candidature a traiter pour le moment!</h6>

                <?php else: ?>
                    <div class="items">
                        <?php if($postulant['statut']=='accepter'):?>
                        <h5 class="h51">accepter</h5>
                        <?php else: ?>
                            <?php if($postulant['statut']=='recaler'):?>
                                <h5 class="h52">recaler</h5>
                                <?php else: ?>
                                    <h5 class="h53">non traiter</h5>
                                <?php endif; ?>
                        <?php endif; ?>
                    <h3> <span>POSTE :</span>
                        <?= $postulant['poste'] ?>
                    </h3>
                    <img src="../upload/<?= $postulant['images'] ?>" alt="">
                    
                    <ul>
                        <li>
                           <strong>Nom : </strong> <?= $postulant['nom'] ?>
                        </li>
                        <li>
                        <strong>E-mail : </strong> <?= $postulant['mail'] ?>
                        </li>
                        <li>
                        <strong>Tel : </strong> <?= $postulant['phone'] ?>
                        </li>
                        <li class="dc" >Domaine de competence :</li>
                        <li class="comp" ><?= $postulant['competences'] ?></li>
                        
                    </ul>

                    <div class="container-box_btn">
                        <button class="btn1"><img src="../image/vue2.png" alt=""> <a href="../page/user_profil.php?id=<?= $postulant['users_id'] ?>">Voir le
                                profil</a></button>
                        <div class="box-btn">
                           
                               
                                <a class="btn2" href="?accepter=<?= $postulant['poste_id'] ?>&offrees_id=<?= $postulant['offre_id'] ?> "> Accepter</a>
                           
                          
                                <a class="btn3" href="?recaler=<?= $postulant['poste_id']?>&offrees_id=<?= $postulant['offre_id']?>">Recaler</a>
                           

                        </div>
                    </div>
                </div>
                   
                                    <?php endif; ?>
                               
                            <?php endif; ?>
               
                <?php endif; ?>
              
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="div-section2">
        <h2>Candidatures traiter </h2>

        <h4>Candidatures accepter</h4>
        <div class="container">
            
            <?php foreach ($getALLpostulation as $postulant): ?>
               
                    
                   
                <?php if($postulant['statut']=='accepter'):?>
                   
                                    <div class="items">
                        <h5 class="h51">accepter</h5>
                        
                    <h3> <span>POSTE :</span>
                        <?= $postulant['poste'] ?>
                    </h3>
                    <img src="/image/entreprise.jpg" alt="">

                    <ul>
                        <li>
                           <strong>Nom : </strong> <?= $postulant['nom'] ?>
                        </li>
                        <li>
                        <strong>E-mail : </strong> <?= $postulant['mail'] ?>
                        </li>
                        <li>
                        <strong>Tel : </strong> <?= $postulant['phone'] ?>
                        </li>
                        <li class="dc" >Domaine de competence :</li>
                        <li class="comp" ><?= $postulant['competences'] ?></li>
                        
                    </ul>

                    <div class="container-box_btn">
                        <button class="btn1"><img src="../image/vue2.png" alt=""> <a href="../page/user_profil.php?id=<?= $postulant['users_id'] ?>">Voir le
                                profil</a></button>
                        <div class="box-btn">
                           
                        <?php if($postulant['statut']=='accepter'):?>
                           
                            <?php endif; ?>
                            
                                <a class="btn3" href="?recaler=<?=$postulant['poste_id']?>&offrees_id=<?=$postulant['offre_id']?>">Recaler</a>

                        </div>
                    </div>
                </div>
               
                <?php endif; ?>
               
            <?php endforeach; ?>
          
        </div>
    </div>

    <div class="div-section2">

        <h4  class="h4" >Candidatures recaler</h4>
        <div class="container">
            <?php foreach ($getALLpostulation as $postulant): ?>
                <?php if($postulant['statut']=='recaler'):?>
                   
                                    <div class="items">
                        <h5 class="h52">recaler</h5>
                        
                    <h3> <span>POSTE :</span>
                        <?= $postulant['poste'] ?>
                    </h3>
                    <img src="/image/entreprise.jpg" alt="">
                    <ul>
                        <li>
                           <strong>Nom : </strong> <?= $postulant['nom'] ?>
                        </li>
                        <li>
                        <strong>E-mail : </strong> <?= $postulant['mail'] ?>
                        </li>
                        <li>
                        <strong>Tel : </strong> <?= $postulant['phone'] ?>
                        </li>
                        <li class="dc" >Domaine de competence :</li>
                        <li class="comp" ><?= $postulant['competences'] ?></li>
                        
                    </ul>

                    <div class="container-box_btn">
                        <button class="btn1"><img src="../image/vue2.png" alt=""> <a href="../page/user_profil.php?id=<?= $postulant['users_id'] ?>">Voir le
                                profil</a></button>
                        <div class="box-btn">
                           
                               
                                <a class="btn2" href="?accepter=<?= $postulant['poste_id']?>&offrees_id=<?=$postulant['offre_id']?>">Accepter</a>
                           
                            
                                <?php if($postulant['statut']=='recaler'):?>

                               <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
          
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