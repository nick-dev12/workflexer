<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session

include_once('controller/controller_users.php');

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Work-Flexer, la plateforme de mise en relation professionnelle qui connecte entreprises et talents. Recrutement simplifié, CV virtuels, offres d'emploi dans tous les domaines : informatique, marketing, finance, ingénierie. Inscription gratuite pour recruter ou trouver votre prochain emploi.">

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

    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <title>Bienvenue</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/aos.css" />
    <script src="../js/aos.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('navbare.php') ?>


    <!-- menu carousel slider -->
    <div class="slider-area owl-carousel">
        <div class="slider-item">
            <div class="slider-image-container">
                <img src="/image/image1.webp" alt="Work-Flexer plateforme de mise en relation">
                <div class="slider-overlay"></div>
                <div class="floating-icons">
                    <div class="floating-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="floating-icon"><i class="fas fa-users"></i></div>
                    <div class="floating-icon"><i class="fas fa-lightbulb"></i></div>
                    <div class="floating-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="floating-icon"><i class="fas fa-handshake"></i></div>
                    <div class="floating-icon"><i class="fas fa-rocket"></i></div>
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content-box">
                    <h1 class="split-text"><span class="accent">Work</span><span class="accent-alt">-Flexer</span></h1>
                    <h2 class="split-subtitle">Plateforme de mise en relation</h2>
                    <div class="separator"></div>
                    <p class="split-paragraph">La plateforme de professionnalisation qui relie entreprises,
                        entrepreneurs, travailleurs et étudiants dans tous les domaines confondus.</p>
                    <a href="/inscription.php" class="cta-button"><span>Commencer</span><i class="arrow-icon"></i></a>
                </div>
                <div class="slide-indicator">01</div>
            </div>
        </div>
        <div class="slider-item">
            <div class="slider-image-container">
                <img src="/image/mission.webp" alt="Nos services">
                <div class="slider-overlay"></div>
                <div class="floating-icons">
                    <div class="floating-icon"><i class="fas fa-cogs"></i></div>
                    <div class="floating-icon"><i class="fas fa-laptop-code"></i></div>
                    <div class="floating-icon"><i class="fas fa-bullseye"></i></div>
                    <div class="floating-icon"><i class="fas fa-comments"></i></div>
                    <div class="floating-icon"><i class="fas fa-paint-brush"></i></div>
                    <div class="floating-icon"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content-box">
                    <h1 class="split-text">Nos Services</h1>
                    <div class="separator"></div>
                    <p class="split-paragraph">Découvrez notre gamme complète de services spécialisés, conçus pour
                        répondre à vos besoins uniques et stimuler votre succès commercial. De la création de sites
                        internet sur mesure à l'audit marketing.</p>
                    <a href="/inscription.php" class="cta-button"><span>Commencer</span><i class="arrow-icon"></i></a>
                </div>
                <div class="slide-indicator">02</div>
            </div>
        </div>
        <div class="slider-item">
            <div class="slider-image-container">
                <img src="/image/Backgroudn-domaines-epita.webp" alt="Domaines d'expertise">
                <div class="slider-overlay"></div>
                <div class="floating-icons">
                    <div class="floating-icon"><i class="fas fa-code"></i></div>
                    <div class="floating-icon"><i class="fas fa-database"></i></div>
                    <div class="floating-icon"><i class="fas fa-network-wired"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-microchip"></i></div>
                    <div class="floating-icon"><i class="fas fa-project-diagram"></i></div>
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content-box">
                    <h1 class="split-text">Domaines d'expertise</h1>
                    <div class="separator"></div>
                    <p class="split-paragraph">Découvrez nos compétences spécialisées dans l'informatique, le marketing,
                        la finance, les ressources humaines, le droit, l'ingénierie et bien d'autres domaines.</p>
                    <a href="/inscription.php" class="cta-button"><span>Découvrir</span><i class="arrow-icon"></i></a>
                </div>
                <div class="slide-indicator">03</div>
            </div>
        </div>
        <div class="slider-item">
            <div class="slider-image-container">
                <img src="/image/duré.webp" alt="Flexibilité des missions">
                <div class="slider-overlay"></div>
                <div class="floating-icons">
                    <div class="floating-icon"><i class="fas fa-clock"></i></div>
                    <div class="floating-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="floating-icon"><i class="fas fa-tasks"></i></div>
                    <div class="floating-icon"><i class="fas fa-user-clock"></i></div>
                    <div class="floating-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="floating-icon"><i class="fas fa-business-time"></i></div>
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content-box">
                    <h1 class="split-text">Flexibilité des missions</h1>
                    <div class="separator"></div>
                    <p class="split-paragraph">Profitez de notre flexibilité pour trouver des missions qui correspondent
                        à vos besoins. Que vous recherchiez des opportunités en freelance à court terme ou des
                        engagements à long terme.</p>
                    <a href="/inscription.php" class="cta-button"><span>Explorer</span><i class="arrow-icon"></i></a>
                </div>
                <div class="slide-indicator">04</div>
            </div>
        </div>
        <div class="slider-item">
            <div class="slider-image-container">
                <img src="/image/Quand-la-participation.webp" alt="Boostez votre flexibilité">
                <div class="slider-overlay"></div>
                <div class="floating-icons">
                    <div class="floating-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-medal"></i></div>
                    <div class="floating-icon"><i class="fas fa-crown"></i></div>
                    <div class="floating-icon"><i class="fas fa-award"></i></div>
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content-box">
                    <h1 class="split-text">Boostez votre flexibilité</h1>
                    <div class="separator"></div>
                    <p class="split-paragraph">Optimisez votre productivité et augmentez vos bénéfices en devenant une
                        source incontournable grâce à notre expertise en référencement.</p>
                    <a href="/inscription.php" class="cta-button"><span>En savoir plus</span><i
                            class="arrow-icon"></i></a>
                </div>
                <div class="slide-indicator">05</div>
            </div>
        </div>
    </div>


    <section class="partie-box">
        <div class="box1 scroll-fade-bottom">
            <h1>
                Trouvez le candidat idéal pour votre offre d'emploi
            </h1>
            <p>
                Work-Flexer est une plateforme qui permet aux recruteurs de
                trouver et de se connecter facilement avec des candidats qualifiés pour leurs offres d'emploi.
            </p>
            <a href="/inscription.php">Commencer dès maintenant!</a>
            <div class="div4"></div>
        </div>
        <div class="box2 scroll-fade-top">
            <img src="/image/rain_background.png" alt="" class="img1">
            <img src="/image/doresse4.jpg" alt="" class="img2">
        </div>
    </section>



    <section class="reference">
        <div class="container scroll-fade-left">
            <div class="box1">
                <img src="/image/defi.png" alt="">
            </div>
            <div class="box2">
                <h1>Notre Vision : </h1>
                <p>Permettre à chaque individu de construire un avenir professionnel prometteur et de devenir
                    l'architecte de sa propre réussite.</p>
            </div>
        </div>

        <div class="container scroll-fade-right">
            <div class="box1">
                <img src="/image/ambitio.png" alt="">
            </div>
            <div class="box2">
                <h1>Notre Engagement : </h1>
                <p>Faire croître votre stature professionnelle et positionner votre entreprise comme un acteur de
                    premier plan dans votre secteur.</p>
            </div>
        </div>
    </section>



    <div class="div_section div_section-blue">
        <div class="box scroll-fade-left">
            <div class="img-container">
                <img src="/image/image-2.webp" alt="">
            </div>
            <div class="item">
                <h1>Adoptez un ton affirmatif et confiant</h1>
                <p>
                    Découvrez les meilleurs freelances avec Work-Flexer !
                    Trouvez rapidement le talent idéal pour vos projets,
                    que ce soit un développeur, un designer ou un expert en
                    marketing. Utilisez notre moteur de recherche intelligent pour des résultats précis.
                    Boostez vos projets en recrutant simplement le freelance parfait.
                </p>
            </div>
        </div>
    </div>

    <div class="div_section div_section-gray">
        <div class="box scroll-fade-right">
            <div class="item">
                <h1>Recrutez en Toute Confiance avec Notre Plateforme de Recrutement</h1>
                <p>
                    Simplifiez votre recrutement avec Work-Flexer ! Publiez vos offres
                    d'emploi en quelques clics, découvrez des candidats qualifiés qui
                    correspondent à votre entreprise et aux exigences du marché. Trouvez
                    les meilleurs talents rapidement et efficacement.
                    La recherche de candidats exceptionnels n'a jamais été aussi simple.
                </p>
            </div>
            <div class="img-container">
                <img src="/image/image3.webp" alt="">
            </div>
        </div>
    </div>
    <div class="div_section div_section-dark">
        <div class="box scroll-fade-right">
            <div class="img-container">
                <img src="/image/yan.webp" alt="">
            </div>
            <div class="item">
                <h1>Pourquoi nous choisir ?</h1>
                <p>
                    Nous offrons une plateforme intuitive et efficace qui connecte les professionnels et les recruteurs.
                    Avec Work-Flexer, bénéficiez d'une visibilité accrue, d'outils de gestion avancés, et d'un support
                    client dédié.
                    Notre engagement est de vous fournir des solutions sur mesure qui répondent à vos besoins
                    spécifiques,
                    tout en garantissant une expérience utilisateur optimale.
                </p>
            </div>
        </div>
    </div>



    <section class="n_section2">
        <div class="div">
            <h1>Application Android disponible</h1>
            <a href="/apk/work-flexer_2_2.0.apk">Telecharger</a>
        </div>
        <div class="box">
            <img class="img1" src="/image/android.png" alt="">
            <img class="img2" src="/image/resp1.png" alt="">
        </div>
    </section>


    <section class="service">
        <div class="container">
            <h1>Entreprise</h1>
            <h3>Services</h3>
            <div class="box scroll-fade-left">
                <ul>
                    <li><img src="/image/valider.png" alt=""> Compte gratuit</li>
                    <li><img src="/image/valider.png" alt=""> Publication d'offres illimitées</li>
                    <li><img src="/image/valider.png" alt=""> Mise à jour des publications
                        illimitées</li>
                    <li><img src="/image/valider.png" alt=""> Appel d'offres intégré et illimité
                    </li>
                    <li><img src="/image/valider.png" alt=""> Système de messagerie intégré</li>
                    <li><img src="/image/valider.png" alt=""> Système de suivi de candidature
                        intégré</li>
                    <li><img src="/image/valider.png" alt=""> Système de gestion d'offres complet
                    </li>
                    <li><img src="/image/valider.png" alt=""> Profil 100% modifiable</li>
                    <li><img src="/image/valider.png" alt=""> Outils d'analyse des candidatures
                    </li>
                    <li><img src="/image/valider.png" alt=""> Notifications automatiques des
                        nouvelles candidatures.</li>
                </ul>
                <a class="a" href="/compte_entreprise.php">Inscription gratuite</a>
            </div>
        </div>

        <div class="container container1">
            <h1>Professionnel</h1>
            <h3>Services</h3>
            <div class="box scroll-fade-right">
                <ul>
                    <li><img src="/image/valider.png" alt=""> Compte gratuit</li>
                    <li><img src="/image/valider.png" alt=""> CV virtuel intégré 100%
                        personnalisable</li>
                    <li><img src="/image/valider.png" alt=""> Profils connectés 24/24, 7/7 aux
                        recruteurs</li>
                    <li><img src="/image/valider.png" alt=""> Postulations simples et illimitées
                    </li>
                    <li><img src="/image/valider.png" alt=""> Création automatique de CV physiques
                        avec téléchargement gratuit</li>
                    <li><img src="/image/valider.png" alt=""> Système de suivi de postulation
                        intégré</li>
                    <li><img src="/image/valider.png" alt=""> Profil 100% modifiable</li>
                    <li><img src="/image/valider.png" alt=""> Portfolios en ligne</li>
                    <li><img src="/image/valider.png" alt=""> Recommandations et avis d'anciens
                        employeurs</li>
                </ul>
                <a href="/compte_travailleur.php">Inscription gratuite</a>
            </div>
        </div>
    </section>


    <section class="temoin">
        <div class="box">
            <span>"</span>
            <p>En tant qu'employeur, j'ai trouvé cette plateforme très efficace pour recruter
                des talents exceptionnels. Le processus de
                publication d'offres est simple et les résultats sont rapides.</p>
            <img class="img" src="/image/temoin.jpg" alt="">
        </div>

        <div class="box">
            <span>"</span>
            <p>Cette plateforme nous a aidé à trouver les candidats parfaits
                pour nos offres d'emploi. Fortement recommandé aux recruteurs.</p>
            <img class="img" src="/image/profil1.png" alt="">
        </div>

        <div class="box">
            <span>"</span>
            <p>La fonction de jumelage avec les offres d'emploi en fonction
                de mes compétences a été un énorme avantage. J'ai rapidement trouvé
                des opportunités qui correspondaient
                parfaitement à mes aspirations professionnelles.</p>
            <img class="img" src="/image/profil2.png" alt="">
        </div>

        <div class="box">
            <span>"</span>
            <p>Une expérience utilisateur exceptionnelle ! La navigation est intuitive,
                et j'ai trouvé le processus de candidature très simple.
                Merci de rendre la recherche d'emploi aussi efficace et agréable.</p>
            <img class="img" src="/image/profil3.png" alt="">
        </div>

        <div class="box">
            <span>"</span>
            <p>Notre expérience en tant qu'entreprise partenaire a été extrêmement
                positive. La plateforme offre une excellente
                visibilité et nous a connectés avec des professionnels qualifiés.</p>
            <img class="img" src="/image/profil4.png" alt="">
        </div>
    </section>



    <section class="slider">

        <div class=" slider1  owl-carousel">

            <div class="item">
                <img src="/image/bouste.webp" alt="">
                <div class="effect">

                </div>
                <span class="formes1"></span>
                <span class="formes2"></span>
                <h2>Boostez votre carrière en créant votre profil en ligne</h2>
                <p>Augmentez votre visibilité auprès des recruteurs et mettez toutes les chances de votre côté pour
                    décrocher votre emploi idéal. En créant votre profil sur notre plateforme, vous pouvez mettre en
                    avant vos compétences et votre parcours.</p>

            </div>

            <div class="item">
                <img src="/image/recruter.png" alt="">
                <div class="effect">
                </div>
                <span class="formes1"></span>
                <span class="formes2"></span>
                <h2>Recrutez les meilleurs talents en quelques clics.</h2>
                <p>Grâce à notre plateforme, publiez vos offres d'emploi et accédez à un vivier de candidats qualifiés
                    et motivés. Trouvez rapidement le profil idéal pour vos postes à pourvoir.
                </p>
            </div>

        </div>

    </section>

    <script>
    $(document).ready(function() {
        // Configuration du slider principal
        $('.slider-area').owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 8000,
            smartSpeed: 800, // Vitesse optimisée
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            margin: 0,
            nav: true,
            navText: ['<span></span>', '<span></span>'],
            mouseDrag: true,
            touchDrag: true,
            onInitialized: initSlider,
            onTranslate: resetProgress,
            onTranslated: startProgress
        });

        // Initialisation du slider
        function initSlider() {
            // Créer la barre de progression si elle n'existe pas
            if ($('.slide-progress').length === 0) {
                $('.slider-area').append('<div class="slide-progress"></div>');
            }

            // Initialiser le premier slide avec le numéro actif
            updateSlideNumbers(0);

            // Démarrer la progression
            startProgress();
        }

        // Démarrer la progression de la barre
        function startProgress() {
            var currentSlide = $('.slider-area .owl-item.active').index();
            updateSlideNumbers(currentSlide);

            $('.slide-progress').css({
                width: '0%',
                transition: 'none'
            }).animate({
                width: '100%'
            }, 8000, 'linear');
        }

        // Réinitialiser la progression lors du changement de slide
        function resetProgress() {
            $('.slide-progress').stop().css({
                width: '0%'
            });
        }

        // Mettre à jour les numéros de slide
        function updateSlideNumbers(currentIndex) {
            // Obtenir l'index réel (en tenant compte des clones)
            var realIndex = $('.slider-area .owl-item.active').find('.slider-item').attr('data-slide-index');
            if (!realIndex) realIndex = currentIndex + 1;

            // Formater le numéro avec un zéro devant si nécessaire
            var formattedNumber = (realIndex < 10) ? '0' + realIndex : realIndex;
            $('.slide-indicator').text(formattedNumber);
        }

        // Optimisation de l'animation parallaxe au scroll
        let ticking = false;
        $(window).scroll(function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    var scrollPosition = $(window).scrollTop();
                    if (scrollPosition < 800) {
                        $('.slider-image-container img').css({
                            'transform': 'scale(1.05) translateY(' + (scrollPosition *
                                0.05) + 'px)'
                        });
                    }
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Autres sliders
        $('.slider1').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 800,
            nav: true,
        });

        // Code existant pour les autres carrousels
        $('.carousel1').owlCarousel({
            items: 5,
            loop: true,
            autoplay: true,
            autoplayTimeout: 6000,
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            stagePadding: 10,
            smartSpeed: 450,
            margin: 10,
            nav: true,
            navText: ['<i class="fa-solid fa-chevron-left"></i>',
                '<i class="fa-solid fa-chevron-right"></i>'
            ]
        });

        var carousel1 = $('.carousel1').owlCarousel();

        $('.owl-next').click(function() {
            carousel1.trigger('next.owl.carousel');
        });

        $('.owl-prev').click(function() {
            carousel1.trigger('prev.owl.carousel');
        });

        // Configuration de la section "temoin"
        var sectionTemoin = document.querySelector('.temoin');
        if (sectionTemoin) {
            var enfantsSection = sectionTemoin.children;
            if (enfantsSection.length > 3) {
                $('.temoin').addClass('owl-carousel').owlCarousel({
                    items: 4,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 10,
                    smartSpeed: 650,
                    margin: 100,
                    nav: true,
                    responsive: {
                        0: {
                            items: 1,
                            margin: 20
                        },
                        550: {
                            items: 2
                        },
                        690: {
                            items: 3
                        },
                        890: {
                            items: 3
                        },
                        1200: {
                            items: 4
                        },
                        1400: {
                            items: 4
                        }
                    }
                });
            }
        }

        // Configuration pour owl-slider
        var owlSlider = document.querySelector('.owl-slider');
        if (owlSlider) {
            var enfantSection = owlSlider.children;
            if (enfantSection.length > 2) {
                $('.owl-slider').addClass('owl-carousel').owlCarousel({
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
                            margin: 0
                        },
                        460: {
                            items: 2
                        },
                        550: {
                            items: 2
                        },
                        890: {
                            items: 2
                        },
                        1200: {
                            items: 3
                        },
                        1400: {
                            items: 3
                        }
                    }
                });
            }
        }

        // Ajouter des attributs data-slide-index aux sliders
        $('.slider-area .slider-item').each(function(index) {
            $(this).attr('data-slide-index', index + 1);
        });
    });
    </script>

    <section class="explore">
        <div class="t1">
            <h1>Explorer les profils qui vous conviennent</h1>
        </div>

        <div class="profil">
            <div class="owl-slider owl-carousel ">
                <?php foreach ($afficheUsersLimit20 as $user): ?>

                <?php $name_users = $user['nom'];
                    $explode_name_users = explode(' ', $name_users);
                    $name = $explode_name_users[0] . " " . $explode_name_users[1];
                    ?>
                <div class="item">
                    <a href="/page/candidats.php?id=<?= $user['id'] ?>">
                        <img src="/upload/<?= $user['images']; ?>" alt="">
                        <h3>
                            <?= $name; ?>
                        </h3>
                        <p>
                            <?= $user['competences']; ?>
                        </p>
                    </a>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <?php include('footer.php') ?>





    <!--
ScrollSmoother.min.js, InertiaPlugin.min.js, ScrambleTextPlugin.min.js, and SplitText.min.js are Club GreenSock perks which are not available on a CDN. Download them from your GreenSock account and include them locally like this:

<script src="/[YOUR_DIRECTORY]/ScrollSmoother.min.js"></script>
<script src="/[YOUR_DIRECTORY]/InertiaPlugin.min.js"></script>
<script src="/[YOUR_DIRECTORY]/ScrambleTextPlugin.min.js"></script>
<script src="/[YOUR_DIRECTORY]/SplitText.min.js"></script>

Sign up at https://greensock.com/club or try them for free on CodePen or CodeSandbox
-->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/owl.animate.js"></script>
    <script src="js/owl.autoplay.js"></script>


    <div></div>

    <script>
    $(document).ready(function() {
        // Initialisation du carousel principal
        $('.slider-area').owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 7000,
            smartSpeed: 1200,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            margin: 0,
            nav: true,
            navText: ['<i class="fa-solid fa-chevron-left"></i>',
                '<i class="fa-solid fa-chevron-right"></i>'
            ],
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true,
            freeDrag: false,
            onInitialized: startProgressBar,
            onTranslate: resetProgressBar,
            onTranslated: startProgressBar
        });

        // Animation de la barre de progression
        function startProgressBar() {
            // On crée la barre de progression si elle n'existe pas
            if ($('.slide-progress').length === 0) {
                $('.slider-area').append('<div class="slide-progress"></div>');
            }

            // On anime la barre de progression
            $('.slide-progress').css({
                width: '0%',
                transition: 'none'
            }).animate({
                width: '100%'
            }, 7000, 'linear');
        }

        // Réinitialisation de la barre de progression
        function resetProgressBar() {
            $('.slide-progress').css({
                width: '0%',
                transition: 'width 0s'
            });
        }

        // Effets de parallaxe au défilement
        $(window).scroll(function() {
            var scrollPosition = $(this).scrollTop();

            // Parallaxe sur les images du slider
            $('.slider-item img').css({
                'transform': 'translateY(' + (scrollPosition * 0.15) + 'px)'
            });
        });

        // Animation des textes au chargement
        setTimeout(function() {
            $('.slider-area .slider-item:first-child h1').addClass('animated');
            $('.slider-area .slider-item:first-child p').addClass('animated');
            $('.slider-area .slider-item:first-child a').addClass('animated');
        }, 500);
    });
    </script>

    <script>
    AOS.init();


    // Animation au scroll
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll(
            '.scroll-fade-left, .scroll-fade-right, .scroll-fade-top, .scroll-fade-bottom, .scroll-fade-center'
        );
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                } else {
                    entry.target.classList.remove('animate');
                }
            });
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    });

    // Animation au survol
    document.querySelectorAll('.hover-animation').forEach(item => {
        item.addEventListener('mouseover', () => {
            item.classList.add('hovered');
        });
        item.addEventListener('mouseout', () => {
            item.classList.remove('hovered');
        });
    });
    </script>

    <script>
    // Fonction pour gérer les animations au défilement
    function handleScrollAnimations() {
        const scrollElements = document.querySelectorAll('.scroll-fade-left, .scroll-fade-right');

        const elementInView = (el, percentageScroll = 100) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <=
                ((window.innerHeight || document.documentElement.clientHeight) * (percentageScroll / 100))
            );
        };

        const displayScrollElement = (element) => {
            element.classList.add('animate');
        };

        const handleScrollAnimation = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 70)) {
                    displayScrollElement(el);
                }
            });
        };

        // Throttle pour optimiser les performances
        let throttleTimer;
        const throttle = (callback, time) => {
            if (throttleTimer) return;
            throttleTimer = true;
            setTimeout(() => {
                callback();
                throttleTimer = false;
            }, time);
        };

        // Event listener pour le scroll
        window.addEventListener('scroll', () => {
            throttle(handleScrollAnimation, 250);
        });

        // Vérification initiale des éléments
        handleScrollAnimation();
    }

    // Initialisation une fois que le DOM est chargé
    document.addEventListener('DOMContentLoaded', handleScrollAnimations);
    </script>

</body>

</html>