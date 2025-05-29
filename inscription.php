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

    <title>Inscription - Créez votre compte</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/inscription_compte.css">
    <link rel="stylesheet" href="../css/navbare.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('navbare.php') ?>

    <section class="signup-section">
        <h1>Créez votre compte</h1>
        <p class="signup-description">
            Rejoignez notre plateforme et accédez à des fonctionnalités personnalisées.
            Choisissez le type de compte qui correspond à votre profil professionnel.
        </p>

        <div class="account-options">

            <!-- Carte pour le compte professionnel -->
            <div class="account-card">
                <span class="account-badge">Professionnel</span>
                <span class="new-tag">Gratuit</span>
                <div class="account-image">
                    <img src="/image/travail.png" alt="Compte professionnel">
                </div>
                <div class="account-info">
                    <h2 class="account-title">Compte Professionnel</h2>
                    <p class="account-description">
                        Créez votre profil, postulez aux offres d'emploi, mettez en valeur vos
                        compétences et développez votre carrière.
                    </p>
                    <div class="account-features">
                        <div class="feature-item">
                            <i class="fas fa-id-card"></i>
                            <span>CV en ligne personnalisable</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-search"></i>
                            <span>Recherche d'emploi avancée</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-bell"></i>
                            <span>Alertes emploi personnalisées</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Suivi de candidatures</span>
                        </div>
                    </div>
                    <a href="/compte_travailleur.php" class="account-button">
                        <i class="fas fa-plus-circle"></i> Créer un compte
                    </a>
                </div>
            </div>
            <!-- Carte pour le compte entreprise -->
            <div class="account-card enterprise">
                <span class="account-badge enterprise-badge">Recruteur</span>
                <div class="account-image">
                    <img src="/image/entreprise.jpg" alt="Compte d'entreprise">
                </div>
                <div class="account-info">
                    <h2 class="account-title">Compte Recruteur</h2>
                    <p class="account-description">
                        Publiez des offres d'emploi, recherchez des candidats qualifiés
                        et gérez efficacement vos recrutements.
                    </p>
                    <div class="account-features">
                        <div class="feature-item">
                            <i class="fas fa-building"></i>
                            <span>Profil d'entreprise personnalisé</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-bullhorn"></i>
                            <span>Publication d'offres illimitées</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-users"></i>
                            <span>Accès à notre base de talents</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Statistiques de recrutement</span>
                        </div>
                    </div>
                    <a href="/compte_entreprise.php" class="account-button">
                        <i class="fas fa-plus-circle"></i> Créer un compte
                    </a>
                </div>
            </div>

        </div>

        <p class="signup-description" style="margin-top: 30px;">
            Vous avez déjà un compte ? <a href="/connection_compte.php"
                style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Connectez-vous ici</a>
        </p>
    </section>

</body>

</html>