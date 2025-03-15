<?php
session_start();
include('../conn/conn.php');

include('app/controller/controllerEntreprise.php');
include('app/controller/controllerDescription.php');
include('app/controller/controllerOffre_emploi.php');

$categorie_entreprise = getALLcategorieEntreprise($db, $_SESSION['compte_entreprise']);
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <title>
        <?= $getEntreprise['entreprise']; ?>
    </title>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/offre_suprimer.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/notifications.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include('../include/header_entreprise.php') ?>
    <?php include('../include/notifications.php') ?>

    <section class="section3">


        <div class="container_box2">
            <div class="box1">
                <h1>Mes offres suprimées</h1>
                <span>
                    <?php $countOffre = count($afficheOffreEmplois_suprimer);
                    echo $countOffre
                        ?>
                </span>
            </div>

            <div class="categories-grid">
                <?php
                if (empty($categorie_entreprise)):
                    ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3>Aucune catégorie</h3>
                        <p>
                            vous n'avez pas encore supprimer d'offre
                        </p>
                    </div>
                <?php else: ?>
                    <?php foreach ($categorie_entreprise as $categorie):
                        // Compter les offres dans cette catégorie
                        $offres_categorie = getOffresEmplois_suprimer_categorie($db, $_SESSION['compte_entreprise'], $categorie['categori']);
                        $countOffreCategorie = count($offres_categorie);
                        // Définir une icône par défaut ou selon la catégorie
                        $categoryIcon = 'fa-briefcase'; // icône par défaut
                        switch (strtolower($categorie['categori'])) {
                            case 'informatique et tech':
                                $categoryIcon = 'fa-laptop-code';
                                break;
                            case 'design et création':
                                $categoryIcon = 'fa-palette';
                                break;
                            case 'rédaction et traduction':
                                $categoryIcon = 'fa-language';
                                break;
                            case 'marketing et communication':
                                $categoryIcon = 'fa-bullhorn';
                                break;
                            case 'conseil et gestion d\'entreprise':
                                $categoryIcon = 'fa-chart-line';
                                break;
                            case 'juridique':
                                $categoryIcon = 'fa-balance-scale';
                                break;
                            case 'ingénierie et architecture':
                                $categoryIcon = 'fa-drafting-compass';
                                break;
                            case 'finance et comptabilité':
                                $categoryIcon = 'fa-coins';
                                break;
                            case 'santé et bien-être':
                                $categoryIcon = 'fa-heartbeat';
                                break;
                            case 'éducation et formation':
                                $categoryIcon = 'fa-graduation-cap';
                                break;
                            case 'tourisme et hôtellerie':
                                $categoryIcon = 'fa-hotel';
                                break;
                            case 'commerce et vente':
                                $categoryIcon = 'fa-shopping-cart';
                                break;
                            case 'transport et logistique':
                                $categoryIcon = 'fa-truck';
                                break;
                            case 'agriculture et agroalimentaire':
                                $categoryIcon = 'fa-seedling';
                                break;
                        }

                        if ($countOffreCategorie > 0):
                            ?>

                            <a href="/entreprise/offres_supprimer_categorie.php?pageCategorie=<?= urlencode($categorie['categori']) ?>"
                                class="category-card">
                                <div class="category-icon">
                                    <i class="fas <?= $categoryIcon ?>"></i>
                                </div>
                                <div class="category-info">
                                    <h3><?= htmlspecialchars($categorie['categori']) ?></h3>
                                    <div class="category-count">
                                        <span class="count"><?= $countOffreCategorie ?></span>
                                        <span class="label"><?= $countOffreCategorie > 1 ? 'offres' : 'offre' ?></span>
                                    </div>
                                </div>
                                <div class="category-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>



    </section>





</body>

</html>