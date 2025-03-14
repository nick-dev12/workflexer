<?php
session_start();

if (isset($_GET['categorie'])) {

} else {
    header('Location: ../page/candidature.php');
}

if (isset($_SESSION['compte_entreprise'])) {

} else {
    header('Location: ../index.php');
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

    <title>Gestion des candidatures | WorkFlexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/postulation.css">
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

        <div class="postulation">
            <h1>Gestion des candidatures</h1>

            <div class="postes-container">
                <?php foreach ($OffresEmplois as $poste): ?>
                    <?php
                    $getALLpostulation = getALLPostulation($db, $_SESSION['compte_entreprise'], $poste['poste']);
                    $countAllposte = count($getALLpostulation);

                    // Compter les candidats non traités
                    $untreatedCount = 0;
                    foreach ($getALLpostulation as $postulant) {
                        if (empty($postulant['statut'])) {
                            $untreatedCount++;
                        }
                    }
                    ?>
                    <div class="poste-card">
                        <div class="poste-info">
                            <h3 class="poste-title"><?= htmlspecialchars($poste['poste']) ?></h3>
                            <div class="poste-stats">
                                <div class="stat">
                                    <span class="stat-value"><?= $countAllposte ?></span>
                                    <span class="stat-label">Total</span>
                                </div>
                                <?php if ($untreatedCount > 0): ?>
                                    <div class="stat new">
                                        <span class="stat-value"><?= $untreatedCount ?></span>
                                        <span class="stat-label">Nouveaux</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="poste-actions">
                            <a href="candidatures_poste.php?poste=<?= urlencode($poste['poste']) ?> & poste_id=<?= urlencode($poste['offre_id']) ?>"
                                class="view-btn">
                                <i class="fas fa-eye"></i>
                                <span>Voir les candidatures</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($OffresEmplois)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>Aucun poste disponible</h3>
                        <p>Vous n'avez pas encore créé d'offres d'emploi.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bouton pour remonter en haut de la page -->
        <div class="back-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        // Gestion des messages
        let success = document.querySelector('.message');
        let messageErreur = document.getElementById('messageErreur');

        if (success) {
            setTimeout(() => {
                success.classList.add('visible');
            }, 200);
            setTimeout(() => {
                success.classList.remove('visible');
            }, 6000);
        }

        if (messageErreur) {
            setTimeout(() => {
                messageErreur.classList.add('visible');
            }, 200);
            setTimeout(() => {
                messageErreur.classList.remove('visible');
            }, 6000);
        }

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