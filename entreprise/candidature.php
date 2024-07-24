<?php
session_start();

if (isset($_SESSION['compte_entreprise'])) {

} else {
    header('Location: ../index.php');
}

include_once ('../entreprise/app/controller/controllerEntreprise.php');
include_once ('../entreprise/app/controller/controllerDescription.php');
include_once ('../entreprise/app/controller/controllerOffre_emploi.php');
include_once ('../controller/controller_postulation.php');
include_once ('../controller/controller_accepte_candidats.php');
include_once ('../controller/controller_competence_users.php');
include_once ('../controller/controller_niveau_etude_experience.php');
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

    <title>candidature</title>
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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php
    include ('../navbare.php')
        ?>

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

            <div class="categorie">
            <?php if(isset($getAllcategorie)  ): ?>
                
                <?php foreach( $getAllcategorie as $categorie): ?>
                    <?php
                        
                        $sql_o = " SELECT * FROM offre_emploi WHERE entreprise_id = :entreprise_id AND categorie = :categorie";
                        $stmt_o = $db->prepare($sql_o);
                        $stmt_o->bindValue(':entreprise_id', $_SESSION['compte_entreprise'] ,PDO::PARAM_INT);
                        $stmt_o->bindValue(':categorie', $categorie['categori'] ,PDO::PARAM_STR);
                        $stmt_o->execute();
                        $count_postulation = $stmt_o->fetchAll(PDO::FETCH_ASSOC);
                        $count_c = count($count_postulation);

                        ?>
                    <a href="postulation.php?categorie=<?= $categorie['categori'] ?>"><?= $categorie['categori'] ?> <span><?= $count_c ?></span> </a>
            
            <?php endforeach ?>
            <?php endif; ?>
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





        $(document).ready(function () {

            // Sélectionnez la section avec la classe "temoin"

            var owlSlider = document.querySelector('.teste');

            // Vérifiez si la section existe
            if (owlSlider) {
                // Obtenez la liste des éléments enfants de la section
                var enfantSection = owlSlider.children;

                // Vérifiez la condition du nombre d'éléments enfants
                if (enfantSection.length > 2) {
                    // Code à exécuter si le nombre d'éléments enfants est supérieur à 3
                    $('.teste').addClass('owl-carousel').owlCarousel({
                        items: 3,
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        animateOut: 'slideOutDown',
                        animateIn: 'flipInX',
                        stagePadding: 10,
                        smartSpeed: 450,
                        margin: 100,
                        nav: true,
                        responsive: {
                            0: {
                                items: 1,

                            },
                            610: {
                                items: 2,

                            },
                            1200: {
                                items: 3
                            },
                            1400: {
                                items: 3
                            }
                        }
                    });

                    // Code pour gérer la navigation du carousel
                    var carousel1 = $('.teste').owlCarousel();
                    $('.owl-next').click(function () {
                        carousel1.trigger('next.owl.carousel');
                    })
                    $('.owl-prev').click(function () {
                        carousel1.trigger('prev.owl.carousel');
                    });
                } else {
                    // Code à exécuter si le nombre d'éléments enfants est inférieur ou égal à 3
                    console.log("Le nombre d'éléments enfants est inférieur ou égal à 3. Ne faites rien.");
                }
            } else {
                console.error("La section avec la classe 'temoin' n'a pas été trouvée.");
            }

        });







        $(document).ready(function () {

            // Sélectionnez la section avec la classe "temoin"

            var owlSlider = document.querySelector('.teste1');

            // Vérifiez si la section existe
            if (owlSlider) {
                // Obtenez la liste des éléments enfants de la section
                var enfantSection = owlSlider.children;

                // Vérifiez la condition du nombre d'éléments enfants
                if (enfantSection.length > 2) {
                    // Code à exécuter si le nombre d'éléments enfants est supérieur à 3
                    $('.teste1').addClass('owl-carousel').owlCarousel({
                        items: 3,
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        animateOut: 'slideOutDown',
                        animateIn: 'flipInX',
                        stagePadding: 10,
                        smartSpeed: 650,
                        margin: 30,
                        nav: true,
                        responsive: {
                            0: {
                                items: 1,

                            },
                            610: {
                                items: 2,

                            },
                            1200: {
                                items: 3
                            },
                            1400: {
                                items: 3
                            }
                        }
                    });

                    // Code pour gérer la navigation du carousel
                    var carousel1 = $('.owl-carousel').owlCarousel();
                    $('.owl-next1').click(function () {
                        carousel1.trigger('next.owl.carousel');
                    })
                    $('.owl-prev1').click(function () {
                        carousel1.trigger('prev.owl.carousel');
                    });
                } else {
                    // Code à exécuter si le nombre d'éléments enfants est inférieur ou égal à 3
                    console.log("Le nombre d'éléments enfants est inférieur ou égal à 3. Ne faites rien.");
                }
            } else {
                console.error("La section avec la classe 'temoin' n'a pas été trouvée.");
            }

        });








        $(document).ready(function () {

            // Sélectionnez la section avec la classe "temoin"

            var owlSlider = document.querySelector('.teste2');

            // Vérifiez si la section existe
            if (owlSlider) {
                // Obtenez la liste des éléments enfants de la section
                var enfantSection = owlSlider.children;

                // Vérifiez la condition du nombre d'éléments enfants
                if (enfantSection.length > 2) {
                    // Code à exécuter si le nombre d'éléments enfants est supérieur à 3
                    $('.teste1').addClass('owl-carousel').owlCarousel({
                        items: 3,
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        animateOut: 'slideOutDown',
                        animateIn: 'flipInX',
                        stagePadding: 10,
                        smartSpeed: 450,
                        margin: 100,
                        nav: true,
                        responsive: {
                            0: {
                                items: 1,

                            },
                            610: {
                                items: 2,

                            },
                            1200: {
                                items: 3
                            },
                            1400: {
                                items: 3
                            }
                        }
                    });

                    // Code pour gérer la navigation du carousel
                    var carousel1 = $('.owl-carousel').owlCarousel();
                    $('.owl-next2').click(function () {
                        carousel1.trigger('next.owl.carousel');
                    })
                    $('.owl-prev2').click(function () {
                        carousel1.trigger('prev.owl.carousel');
                    });
                } else {
                    // Code à exécuter si le nombre d'éléments enfants est inférieur ou égal à 3
                    console.log("Le nombre d'éléments enfants est inférieur ou égal à 3. Ne faites rien.");
                }
            } else {
                console.error("La section avec la classe 'temoin' n'a pas été trouvée.");
            }

        });
    </script>
</body>

</html>