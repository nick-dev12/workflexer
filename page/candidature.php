<?php
session_start();
include('../conn/conn.php');

if (isset($_SESSION['compte_entreprise'])) {

} else {
    header('Location: ../index.php');
}


if (isset($_GET['supp2'])) {
    $entreprise_id = $_GET['supp2'];
    $sql = "DELETE FROM notification_postulation WHERE entreprise_id=:entreprise_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: candidature.php");

    exit();
}

include_once('../entreprise/app/controller/controllerEntreprise.php');
include_once('../entreprise/app/controller/controllerDescription.php');
include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_postulation.php');
include_once('../controller/controller_accepte_candidats.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');
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

    <title>Candidature | WorkFlexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/candidature.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/categories.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php
    include('../navbare.php')
        ?>

    <?php include('../include/header_entreprise.php') ?>


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
        <!-- <div class="box1">
            <h1>Bienvenu au centre de gestion des offres postuler !</h1>
            <div class="container_slider owl-carousel ">
            <img src="../image/gse.png" alt="">
            <img src="../image/gse2.jpg" alt="">
                <img src="../image/gestion_off1.jpg" alt="">
                <img src="../image/gestion_off2.jpg" alt="">
                <img src="../image/GestionOffre.png" alt="">
            </div>
        </div> -->

        <div class="box2">
            <p> <span>1</span><strong>Gérez vos candidatures :</strong> Suivez
                facilement les postulants à vos offres d'emploi et simplifiez le processus de sélection
            </p>
            <p>
                <span>2</span><strong>Consultez vos candidats :</strong>Accédez
                aux profils des personnes qui ont répondu à vos offres, explorez leurs compétences et expériences.
            </p>
        </div>


        <div class="categories-section">
            <div class="categories-header">
                <h2>Liste des catégories</h2>
                <p class="categories-subtitle">Explorez vos offres d'emploi par catégorie</p>
            </div>

            <?php if (empty($getAllcategorie)): ?>
                <div class="categories-empty">
                    <i class="fas fa-folder-open"></i>
                    <p>Aucune catégorie d'offres trouvée</p>
                </div>
            <?php else: ?>
                <div class="categories-grid">
                    <?php foreach ($getAllcategorie as $categories): ?>
                        <?php
                        $categorie = $categories['categori'];
                        $sql_o = " SELECT * FROM offre_emploi WHERE entreprise_id = :entreprise_id AND categorie = :categorie";
                        $stmt_o = $db->prepare($sql_o);
                        $stmt_o->bindValue(':entreprise_id', $_SESSION['compte_entreprise'], PDO::PARAM_INT);
                        $stmt_o->bindValue(':categorie', $categorie, PDO::PARAM_STR);
                        $stmt_o->execute();
                        $offre = $stmt_o->fetchAll(PDO::FETCH_ASSOC);
                        $countOffre = count($offre);

                        // Définir une icône par défaut ou selon la catégorie
                        $categoryIcon = 'fa-briefcase'; // icône par défaut
                        switch (strtolower($categorie)) {
                            case 'informatique':
                                $categoryIcon = 'fa-laptop-code';
                                break;
                            case 'marketing':
                                $categoryIcon = 'fa-chart-line';
                                break;
                            case 'finance':
                                $categoryIcon = 'fa-coins';
                                break;
                            case 'ressources humaines':
                                $categoryIcon = 'fa-users';
                                break;
                            case 'vente':
                                $categoryIcon = 'fa-shopping-cart';
                                break;
                            case 'administration':
                                $categoryIcon = 'fa-building';
                                break;
                            case 'design':
                                $categoryIcon = 'fa-palette';
                                break;
                            case 'education':
                                $categoryIcon = 'fa-graduation-cap';
                                break;
                        }
                        ?>
                        <a href="../entreprise/postulation.php?categorie=<?= $categories['categori'] ?>" class="category-card">
                            <div class="category-icon">
                                <i class="fas <?= $categoryIcon ?>"></i>
                            </div>
                            <div class="category-info">
                                <h3><?= $categories['categori'] ?></h3>
                                <div class="category-count">
                                    <span class="count"><?= $countOffre ?></span>
                                    <span class="label"><?= $countOffre > 1 ? 'offres' : 'offre' ?></span>
                                </div>
                            </div>
                            <div class="category-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>



    </section>








    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>

</body>

</html>