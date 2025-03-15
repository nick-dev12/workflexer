<?php
session_start();

if (!isset($_GET['pageExpireeCategorie']) || empty($_GET['pageExpireeCategorie'])) {
    header('Location: ../entreprise/offre_expirer.php');
    exit;
}

if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: ../index.php');
    exit;
}

include('../conn/conn.php');
include('app/controller/controllerEntreprise.php');
include('app/controller/controllerDescription.php');
include('app/controller/controllerOffre_emploi.php');

// Récupérer la catégorie depuis l'URL
$categorie = $_GET['pageExpireeCategorie'];

// Récupérer les offres supprimées de cette catégorie
$offresExpireeCategorie = getOffreExpiree($db, $_SESSION['compte_entreprise'], $categorie);

// Supprimer définitivement une offre si demandé
if (isset($_GET['offre_id_suprime'])) {
    $offre_id = $_GET['offre_id_suprime'];
    $deleteOffresEmploit_suprimer = deleteOffresEmploit_suprimer($db, $offre_id);

    if ($deleteOffresEmploit_suprimer) {
        $_SESSION['success_message'] = "Offre supprimée définitivement avec succès";
    } else {
        $_SESSION['error_message'] = "Erreur lors de la suppression définitive de l'offre";
    }

    header("Location: offres_supprimer_categorie.php?pageCategorie=" . urlencode($categorie));
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

    <title>Offres supprimées : <?= htmlspecialchars($categorie) ?> | WorkFlexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/offres_expirer_categorie.css">
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
                    <a href="offre_suprimer.php" title="Retour aux catégories">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h1>Offres supprimées : <span><?= htmlspecialchars($categorie) ?></span></h1>
            </div>
        </div>

        <!-- Liste des offres -->
        <div class="offers-container">
            <?php if (empty($offresExpireeCategorie)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h3>Aucune offre supprimée</h3>
                    <p>Vous n'avez pas encore supprimé d'offres dans cette catégorie.</p>
                    <a href="offre_suprimer.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour aux catégories</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="offers-grid">
                    <?php foreach ($offresExpireeCategorie as $offre):
                        $countOffre = countOffre($db, $offre['entreprise_id'], $offre['offre_id']);
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
                                    <a href="../entreprise/updat_offre.php?restore=<?= $offre['offre_id'] ?>"
                                        class="action-btn restore-btn"
                                        onclick="return confirm('Êtes-vous sûr de vouloir restaurer cette offre ?');">
                                        <i class="fas fa-undo-alt"></i>
                                        <span>Republier</span>
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