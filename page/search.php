<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session

include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');

// Vérifier si les résultats de la recherche sont disponibles dans la session
if (isset($_SESSION['resultats_recherche'])) {
    // Récupérer les résultats de la recherche
    $resultats = $_SESSION['resultats_recherche'];

    // Configuration de la pagination
    $resultats_par_page = 20; // Nombre de résultats par page
    $page_courante = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $nombre_total_resultats = count($resultats);
    $nombre_total_pages = ceil($nombre_total_resultats / $resultats_par_page);

    // S'assurer que la page courante est valide
    if ($page_courante < 1) {
        $page_courante = 1;
    } elseif ($page_courante > $nombre_total_pages && $nombre_total_pages > 0) {
        $page_courante = $nombre_total_pages;
    }

    // Calculer l'index de début pour la pagination
    $index_debut = ($page_courante - 1) * $resultats_par_page;

    // Sélectionner uniquement les résultats pour la page courante
    $resultats_page = array_slice($resultats, $index_debut, $resultats_par_page);

    // Mélanger les résultats de la page courante (si désiré)
    shuffle($resultats_page);
} else {
    // Aucun résultat n'est disponible
    $resultats_page = [];
    $nombre_total_resultats = 0;
    $nombre_total_pages = 0;
    $page_courante = 1;
}
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
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <title>Recherche</title>
    <link rel="stylesheet" href="/css/slick.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/voir_profil.css">
    <link rel="stylesheet" href="/css/owl.theme.default.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/animate.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <!-- <div class="affiche">
        <img src="/image/webdesign.jpg" alt="">
    </div> -->
    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Resultats</h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/recherche.png" alt=""> -->
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <!-- Compteur de résultats -->
        <div class="search-results-count">
            <?php if ($nombre_total_resultats > 0): ?>
                <p>
                    <?= $nombre_total_resultats ?> candidat<?= $nombre_total_resultats > 1 ? 's' : '' ?>
                    trouvé<?= $nombre_total_resultats > 1 ? 's' : '' ?>
                </p>
            <?php endif; ?>
        </div>

        <article class="articles owl-carousel carousel1">
            <?php if (empty($resultats_page)): ?>

                <h1 class="message">Aucun resultat trouvé pour cette recherche !</h1>

            <?php else: ?>
                <?php foreach ($resultats_page as $ingenieurs): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $ingenieurs['id']);
                    $niveauEtude = gettNiveau($db, $ingenieurs['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                        <?php if ($ingenieurs['statut'] == 'Occuper'): ?>

                        <?php else: ?>
                            <div class="carousel">

                                <?php if ($ingenieurs['statut'] == 'Disponible'): ?>
                                    <p class="statut"><span></span>
                                        <?= $ingenieurs['statut'] ?>
                                    </p>
                                <?php else: ?>
                                    <?php if ($ingenieurs['statut'] == 'Occuper'): ?>
                                        <p class="statut2"><span></span>
                                            <?= $ingenieurs['statut'] ?>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <img src="../upload/<?php echo $ingenieurs['images'] ?>" alt="">

                                <div class="info-box">
                                    <h4>
                                        <?php echo $ingenieurs['competences']; ?>
                                    </h4>

                                    <div class="vendu">
                                        <?php $afficheCompetences = getCompetences($db, $ingenieurs['id']) ?>
                                        <?php if (empty($afficheCompetences)): ?>
                                            <span>Competences indisponibles</span>
                                        <?php else: ?>
                                            <?php
                                            $competencesAffichees = 0; // Initialiser le compteur de compétences affichées
                        
                                            foreach ($afficheCompetences as $compe):
                                                if ($competencesAffichees < 4):
                                                    ?>
                                                    <span>
                                                        <?= $compe['competence'] ?>
                                                    </span>
                                                    <?php
                                                    $competencesAffichees++;
                                                endif;
                                            endforeach;
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="nom">
                                        <?php
                                        $fullName = $ingenieurs['nom'];
                                        // Utilisez la fonction explode pour diviser le nom en mots
                                        $words = explode(' ', $fullName);
                                        // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                        $nameUsers = isset($words[1]) ? $words[0] . ' ' . $words[1] : $words[0];
                                        ?>
                                        <?php echo $nameUsers ?>
                                    </p>

                                    <p class="ville">
                                        <?php echo $ingenieurs['ville']; ?>
                                    </p>

                                    <div class="divpp"></div>
                                    <p class="pp"><strong>Niveau :</strong>
                                        <?php if (empty($niveauEtude['etude'])): ?>
                                            indisponibles
                                        <?php else: ?>
                                            <?php echo $niveauEtude['etude'] ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="pp"><strong>Experience :</strong>
                                        <?php if (empty($niveauEtude['etude'])): ?>
                                            indisponibles
                                        <?php else: ?>
                                            <?php echo $niveauEtude['experience'] ?>
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <a href="/page/candidats.php?id=<?php echo $ingenieurs['id']; ?>">
                                    <i class="fa-solid fa-eye"></i>Profil
                                </a>
                            </div>

                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <!-- Système de pagination -->
        <?php if ($nombre_total_pages > 1): ?>
            <div class="pagination-container">
                <div class="pagination">
                    <?php if ($page_courante > 1): ?>
                        <a href="?page=<?= $page_courante - 1 ?>" class="pagination-arrow">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php
                    // Afficher les liens de pagination
                    $start = max(1, $page_courante - 2);
                    $end = min($nombre_total_pages, $page_courante + 2);

                    // Toujours afficher la première page
                    if ($start > 1) {
                        echo '<a href="?page=1">1</a>';
                        if ($start > 2) {
                            echo '<span class="pagination-ellipsis">...</span>';
                        }
                    }

                    // Afficher les pages autour de la page courante
                    for ($i = $start; $i <= $end; $i++) {
                        if ($i == $page_courante) {
                            echo '<span class="current-page">' . $i . '</span>';
                        } else {
                            echo '<a href="?page=' . $i . '">' . $i . '</a>';
                        }
                    }

                    // Toujours afficher la dernière page
                    if ($end < $nombre_total_pages) {
                        if ($end < $nombre_total_pages - 1) {
                            echo '<span class="pagination-ellipsis">...</span>';
                        }
                        echo '<a href="?page=' . $nombre_total_pages . '">' . $nombre_total_pages . '</a>';
                    }
                    ?>

                    <?php if ($page_courante < $nombre_total_pages): ?>
                        <a href="?page=<?= $page_courante + 1 ?>" class="pagination-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </section>

    <?php include('../footer.php') ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>
    <script src="/js/silder_offres.js"></script>

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

    <script>
        // Animation de scroll fluide pour les liens de pagination
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    // On laisse le comportement normal du lien mais on ajoute une animation
                    setTimeout(() => {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 5);
                });
            });
        });

        $(document).ready(function () {
            $('.boot').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 450,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel2 = $('.carousel2').owlCarousel();
            $('.owl-next2').click(function () {
                carousel2.trigger('next.owl.carousel');
            })
            $('.owl-prev2').click(function () {
                carousel2.trigger('prev.owl.carousel');
            })
        });

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
    </script>

</body>

</html>