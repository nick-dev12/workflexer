<?php
session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_niveau_etude_experience.php');
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
    
    <title> <?= $getEntreprise['entreprise']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/historique.css">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
 <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php include('../navbare.php') ?>


   <?php include ('../include/header_entreprise.php') ?>

    <section class="section3">

    
    <img src="../image/fleche.png" alt="" class="img222">
        <script>
            let img222 = document.querySelector('.img222');
            let section2 = document.querySelector('.section2');
            let img111 = document.querySelector('.img111')
           
            img222.addEventListener('click', () => {
                section2.style.marginLeft = '0px';
                img222.style.display = 'none';
            });

            img111.addEventListener('click', () => {
                section2.style.marginLeft = '-150%';
                img222.style.display = 'block';
            });
        </script>


        <div class="container_box2">
            <div class="box1">
                <h1>Historique</h1>
            </div>

            <div class="box2">
            <?php foreach ($historiques as $historique): ?>
                <?php $infoUsers = getInfoUsers($db,$historique['users_id'] ) ?>
                <?php $infoNiveau = gettNiveau($db,$historique['users_id']) ;?>

                            <div class="carousel">
                                <?php if ($infoUsers['statut'] == 'Disponible'): ?>
                                    <p class="statut"><span></span>
                                        <?= $infoUsers['statut'] ?>
                                    </p>
                                <?php else: ?>
                                    <?php if ($infoUsers['statut'] == 'Occuper'): ?>
                                        <p class="statut2"><span></span>
                                            <?= $infoUsers['statut'] ?>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <img src="../upload/<?php echo $infoUsers ['images'] ?>" alt="">
                               
                                <div class="info-box">
                                <h4>
                                    <?php echo $infoUsers ['competences']; ?>
                                </h4>

                                <div class="vendu">
                                    <?php $afficheCompetences = getCompetences($db, $infoUsers ['id']);
                                    $nombreCompetencesAffichees = 4;
                                    ?>
                                    <?php if (empty($afficheCompetences)): ?>
                                        <span>Competences indisponibles</span>
                                    <?php else: ?>
                                        <?php foreach ($afficheCompetences as $key => $compe):
                                            if ($key < $nombreCompetencesAffichees):
                                                ?>
                                                <span>
                                                    <?= $compe['competence'] ?>
                                                </span>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                </div>
                                <p class="nom">
                                    <?php
                                    $fullName = $infoUsers ['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' ' . $words[1];
                                    ?>
                                    <?php echo $nameUsers; ?>
                                </p>

                                <?php if ($infoNiveau !== false): ?>
                                    <p class="p" ><strong>Niveau:</strong>
                                    <?php echo $infoNiveau['etude'];   ?>
                                </p>
                                <p  class="p"><strong>Experience:</strong>
                                    <?php echo $infoNiveau['experience'];   ?>
                                </p>
                                <?php else : ?>
                                    <p class="p" ><strong>Niveau:</strong>
                                    indisponibles
                                </p>
                                <p  class="p"><strong>Experience:</strong>
                                    indisponibles
                                </p>
                                <?php endif; ?>

                                <p class="ville" id="nom">
                                    <?php echo $infoUsers ['ville']; ?>
                                </p>
                                </div>

                                <a href="/page/candidats.php?id=<?php echo $infoUsers ['id']; ?>">
                                    <i class="fa-solid fa-eye"></i>Profil
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