<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include 'conn/conn.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: index.php');
    exit();
}

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['compte_entreprise']) && $_SESSION['compte_entreprise']) {

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: index.php');
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

    <title>Connexion - Choisissez votre type de compte</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/connexion_compte.css">
    <link rel="stylesheet" href="../css/navbare.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('navbare.php') ?>

    <section class="login-section">
        <h1>Choisissez votre compte</h1>

        <div class="account-options">
            <!-- Carte pour le compte particulier -->
            <div class="account-card">
                <span class="account-badge">Professionnel</span>
                <div class="account-image">
                    <img src="/image/travail.png" alt="Compte professionnel">
                </div>
                <div class="account-info">
                    <h2 class="account-title">Professionnel</h2>
                    <p class="account-description">
                        Trouvez des opportunités d'emploi et développez votre carrière.
                    </p>
                    <div class="account-features">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Recherche d'emploi</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>CV et candidatures</span>
                        </div>
                    </div>
                    <a href="/connexion.php" class="account-button">
                        <i class="fas fa-user-tie"></i> Se connecter
                    </a>
                </div>
            </div>

            <!-- Carte pour le compte recruteur -->
            <div class="account-card">
                <span class="account-badge enterprise-badge">Recruteur</span>
                <div class="account-image">
                    <img src="/image/entreprise.jpg" alt="Compte recruteur">
                </div>
                <div class="account-info">
                    <h2 class="account-title">Recruteur</h2>
                    <p class="account-description">
                        Publiez des offres et découvrez des talents qualifiés.
                    </p>
                    <div class="account-features">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Publication d'offres</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Recherche de candidats</span>
                        </div>
                    </div>
                    <a href="/entreprise/connexion.php" class="account-button">
                        <i class="fas fa-building"></i> Se connecter
                    </a>
                </div>
            </div>

        </div>
    </section>

</body>

</html>