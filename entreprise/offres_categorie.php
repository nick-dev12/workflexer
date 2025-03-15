<?php
session_start();

if (!isset($_GET['pageoffecategorie']) || empty($_GET['pageoffecategorie'])) {
    header('Location: ../entreprise/entreprise_profil.php');
    exit;
}

if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: ../index.php');
    exit;
}

include('../entreprise/app/controller/controllerEntreprise.php');
include('../entreprise/app/controller/controllerDescription.php');
include('../entreprise/app/controller/controllerOffre_emploi.php');
include('../controller/controller_postulation.php');

// Récupérer la catégorie depuis l'URL
$categorie = $_GET['pageoffecategorie'];

// Récupérer les offres de cette catégorie
$offresCategorie = [];
$offresCategorie = get_poste($db, $_SESSION['compte_entreprise'], $categorie);


// Supprimer une offre si demandé
if (isset($_GET['offresss_id'])) {
    $offre_id = $_GET['offresss_id'];
    $getOffres = getOffres($db, $offre_id);

    $entreprise_id = $getOffres['entreprise_id'];
    $poste = $getOffres['poste'];
    $mission = $getOffres['mission'];
    $profil = $getOffres['profil'];
    $contrat = $getOffres['contrat'];
    $etudes = $getOffres['etudes'];
    $experience = $getOffres['experience'];
    $n_etudes = $getOffres['n_etudes'];
    $n_experience = $getOffres['n_experience'];
    $localite = $getOffres['localite'];
    $langues = $getOffres['langues'];
    $places = $getOffres['places'];
    $date_expiration = $getOffres['date_expiration'];
    $statut = 'supprimer';
    $categorie = $getOffres['categorie'];
    $date = $getOffres['date'];

    $post_suprime_offre = post_suprime_offre($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $statut, $categorie, $date);

    if ($post_suprime_offre) {
        $deleteOffresEmploit = deleteOffresEmploit($db, $offre_id);
        $deletePostulation = deletePostulation($db, $offre_id);

        if ($deleteOffresEmploit) {
            $_SESSION['success_message'] = "Offre supprimée avec succès";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'offre";
        }
    }

    header("Location: offres_categorie.php?pageoffecategorie=" . urlencode($categorie));
    exit();
}
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

    <title>Offres <?= htmlspecialchars($categorie) ?> | WorkFlexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/offres_categorie.css">
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
        <!-- Notifications -->

        <!-- En-tête de la page -->
        <div class="page-header">
            <div class="header-content">
                <div class="back-button">
                    <a href="entreprise_profil.php" title="Retour aux catégories">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h1>Offres d'emploi : <span><?= htmlspecialchars($categorie) ?></span></h1>
                <div class="header-actions">
                    <a href="entreprise_profil.php#container_box1" class="add-offer-btn">
                        <i class="fas fa-plus"></i>
                        <span>Ajouter une offre</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Liste des offres -->
        <div class="offers-container">
            <?php if (empty($offresCategorie)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Aucune offre disponible</h3>
                    <p>Vous n'avez pas encore publié d'offres dans cette catégorie.</p>
                    <a href="entreprise_profil.php#container_box1" class="add-offer-btn">
                        <i class="fas fa-plus"></i>
                        <span>Ajouter une offre</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="offers-grid">
                    <?php foreach ($offresCategorie as $offre):
                        $count_vue_offre = get_vue_offre_entreprise($db, $offre['entreprise_id'], $offre['offre_id']);
                        $countOffre = count($count_vue_offre);
                        ?>
                        <div class="offer-card">
                            <div class="offer-header">
                                <div class="offer-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span><?= $offre['date'] ?></span>
                                </div>
                                <div class="offer-views">
                                    <i class="far fa-eye"></i>
                                    <span><?= $countOffre ?> vues</span>
                                </div>
                            </div>

                            <div class="offer-content">
                                <div class="offer-title">
                                    <h3><?= htmlspecialchars($offre['poste']) ?></h3>
                                    <span class="offer-contract"><?= htmlspecialchars($offre['contrat']) ?></span>
                                </div>

                                <div class="offer-details">
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?= htmlspecialchars($offre['localite']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span><?= htmlspecialchars($offre['etudes']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-briefcase"></i>
                                        <span><?= htmlspecialchars($offre['experience']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-language"></i>
                                        <span><?= htmlspecialchars($offre['langues']) ?></span>
                                    </div>
                                </div>

                                <div class="offer-actions">
                                    <a href="../entreprise/updat_offre.php?id=<?= $offre['offre_id'] ?>"
                                        class="action-btn view-btn">
                                        <i class="fas fa-eye"></i>
                                        <span>Voir l'offre</span>
                                    </a>
                                    <a href="candidatures_poste.php?poste=<?= urlencode($offre['poste']) ?>&poste_id=<?= urlencode($offre['offre_id']) ?>"
                                        class="action-btn candidates-btn">
                                        <i class="fas fa-users"></i>
                                        <span>Candidatures</span>
                                    </a>
                                    <a href="?pageoffecategorie=<?= urlencode($categorie) ?>&offresss_id=<?= $offre['offre_id'] ?>"
                                        class="action-btn delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Supprimer</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Bouton pour remonter en haut de la page -->
        <button class="back-to-top" title="Retour en haut">
            <i class="fas fa-arrow-up"></i>
        </button>
    </section>

    <script>
        // Gestion des notifications


        // Auto-fermeture des notifications après 6 secondes


        // Bouton pour remonter en haut de la page
        const backToTopButton = document.querySelector('.back-to-top');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>