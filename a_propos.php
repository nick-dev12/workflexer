

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Work-Flexer - À Propos</title>
    <link rel="stylesheet" href="./css/a_propos.css" />
</head>
<body>

<?php include('navbare.php') ?>

<header>
    <h1>Work-Flexer</h1>
    <p>Votre plateforme emploi flexible</p>
</header>

<main>
    <section class="about-us">
        <h2>Qui sommes-nous ?</h2>
        <p>
            Créée en 2024, Work-Flexer est une plateforme emploi innovante qui révolutionne le monde du travail en offrant aux entreprises et aux professionnels une solution flexible et accessible pour répondre à leurs besoins en matière d'emploi et de recrutement.
        </p>
        <p>
            Que vous soyez à la recherche d'un CDD, d'une mission freelance, d'un poste en télétravail ou d'une opportunité à temps partiel, Work-Flexer vous met en relation avec les meilleures offres d'emploi flexibles du marché.
        </p>
        <p>
            Guidés par les valeurs d'innovation, de flexibilité et d'accessibilité, nous nous engageons à offrir une expérience optimale à tous nos utilisateurs.
        </p>
    </section>

    <section class="creator">
        <h2>Notre Créateur</h2>
        <p>
            Work-Flexer est née de l'imagination et du talent de <strong>Nick Effé Oyono</strong>, entrepreneur passionné par les solutions de développement numérique. Fort de son expérience dans le domaine, Nick a eu la vision de créer une plateforme innovante et flexible pour répondre aux besoins en constante évolution du marché du travail.
        </p>
        <p>
            Grâce à son leadership et à sa détermination, Work-Flexer est aujourd'hui une plateforme incontournable pour les entreprises et les professionnels à la recherche d'opportunités d'emploi flexibles.
        </p>
        <p>
            Vous pouvez contacter Nick Ludvann OYONO EFFE par email à l'adresse <strong><a href="mailto:webgeniuses12@email.com">webgeniuses12@email.com</a></strong>.
        </p>
        <p>
            Suivez Nick sur les réseaux sociaux :
            <ul>
                <li><a href="#">LinkedIn</a></li>
                <li><a href="#">Twitter</a></li>
            </ul>
        </p>
    </section>

    <section class="services">
        <h2>Nos Services</h2>
        <div class="service-item">
            <h3>Dépôt d'annonces d'emploi</h3>
            <p>Publiez vos offres d'emploi en quelques clics et ciblez les candidats les plus qualifiés.</p>
            <ul>
                <li>Filtres avancés pour une recherche précise</li>
                <li>Diffusion sur plusieurs canaux</li>
                <li>Suivi des candidatures</li>
            </ul>
        </div>
        <div class="service-item">
            <h3>Création de profils professionnels avec CV virtuel</h3>
            <p>Créez un profil professionnel complet et personnalisable et valorisez vos compétences.</p>
            <ul>
                <li>CV virtuel facile à mettre à jour</li>
                <li>Téléchargement de votre CV en format PDF</li>
                <li>Intégration de vos réseaux sociaux</li>
            </ul>
        </div>
        <div class="service-item">
            <h3>Outils de Gestion</h3>
            <p>Des outils pour vous aider à gérer vos offres et vos candidatures plus efficacement.</p>
            <ul>
                <li>Tableau de bord personnalisé</li>
                <li>Notifications automatiques</li>
                <li>Statistiques et analyses</li>
            </ul>
        </div>
    </section>

    <section class="benefits">
        <h2>Pourquoi choisir Work-Flexer ?</h2>
        <div class="benefit-item">
            <h3>Gain de temps et d'efficacité</h3>
            <p>Work-Flexer vous permet de gagner du temps et d'améliorer votre efficacité dans vos démarches de recherche d'emploi et de recrutement.</p>
            <ul>
                <li>Recherche d'offres d'emploi simplifiée</li>
                <li>Candidature en ligne en quelques clics</li>
                <li>Suivi des candidatures en temps réel</li>
                <li>Sauvegarde de documents intégrée</li>
            </ul>
        </div>
        <div class="benefit-item">
            <h3>Meilleure visibilité</h3>
            <p>Work-Flexer vous permet d'augmenter votre visibilité auprès des meilleurs candidats et des entreprises les plus attractives.</p>
            <ul>
                <li>Diffusion de votre profil à un large réseau</li>
                <li>Mise en relation avec des entreprises en recherche de talents</li>
                <li>Amélioration de vos chances de trouver un emploi</li>
            </ul>
        </div>
        <div class="testimonials">
            <h3>Témoignages</h3>
            <p><em>"Work-Flexer m'a permis de trouver un emploi en freelance en seulement quelques semaines."</em> - Jean Dupont, Développeur web</p>
            <p><em>"Notre équipe a pu recruter le candidat parfait pour notre poste grâce à Work-Flexer."</em> - Marie Durand, DRH</p>
            <p><strong>Plus de 10 000 utilisateurs font déjà confiance à Work-Flexer pour trouver leur emploi idéal.</strong></p>
        </div>
    </section>

    <section class="contact">
        <h2>Contactez-nous</h2>
        <p>Pour plus d'informations, n'hésitez pas à nous contacter via notre <a href="#">formulaire de contact</a>.</p>
    </section>
</main>

<footer>
    <p>&copy; Work-Flexer 2024</p>
</footer>

</body>
</html>

<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Work-Flexer - À Propos</title>
    <link rel="stylesheet" href="./css/a_propos.css" />
</head>
<body>

<?php include('navbare.php') ?>

<header>
    <h1>Work-Flexer</h1>
    <p>Votre plateforme emploi flexible</p>
</header>

<main>
    <section class="about-us">
        <h2>Qui sommes-nous ?</h2>
        <p>
            Créée en 2024, Work-Flexer est une plateforme emploi innovante qui révolutionne le monde du travail en offrant aux entreprises et aux professionnels une solution flexible et accessible pour répondre à leurs besoins en matière d'emploi et de recrutement.
        </p>
        <p>
            Que vous soyez à la recherche d'un CDD, d'une mission freelance, d'un poste en télétravail ou d'une opportunité à temps partiel, Work-Flexer vous met en relation avec les meilleures offres d'emploi flexibles du marché.
        </p>
        <p>
            Guidés par les valeurs d'innovation, de flexibilité et d'accessibilité, nous nous engageons à offrir une expérience optimale à tous nos utilisateurs.
        </p>
    </section>

    <section class="creator">
        <h2>Notre Créateur</h2>
        <p>
            Work-Flexer est née de l'imagination et du talent de <strong>Nick Effé Oyono</strong>, entrepreneur passionné par les solutions de développement numérique. Fort de son expérience dans le domaine, Nick a eu la vision de créer une plateforme innovante et flexible pour répondre aux besoins en constante évolution du marché du travail.
        </p>
        <p>
            Grâce à son leadership et à sa détermination, Work-Flexer est aujourd'hui une plateforme incontournable pour les entreprises et les professionnels à la recherche d'opportunités d'emploi flexibles.
        </p>
        <p>
            Vous pouvez contacter Nick Effé Oyono par email à l'adresse <strong><a href="mailto:webgeniuses12@email.com">webgeniuses12@email.com</a></strong>.
        </p>
        <p>
            Suivez Nick sur les réseaux sociaux :
            <ul>
                <li><a href="#">LinkedIn</a></li>
                <li><a href="#">Twitter</a></li>
            </ul>
        </p>
    </section>

    <section class="services">
        <h2>Nos Services</h2>
        <div class="service-item">
            <h3>Dépôt d'annonces d'emploi</h3>
            <p>Publiez vos offres d'emploi en quelques clics et ciblez les candidats les plus qualifiés.</p>
            <ul>
                <li>Filtres avancés pour une recherche précise</li>
                <li>Diffusion sur plusieurs canaux</li>
                <li>Suivi des candidatures</li>
            </ul>
        </div>
        <div class="service-item">
            <h3>Création de profils professionnels avec CV virtuel</h3>
            <p>Créez un profil professionnel complet et personnalisable et valorisez vos compétences.</p>
            <ul>
                <li>CV virtuel facile à mettre à jour</li>
                <li>Téléchargement de votre CV en format PDF</li>
                <li>Intégration de vos réseaux sociaux</li>
            </ul>
        </div>
        <div class="service-item">
            <h3>Outils de Gestion</h3>
            <p>Des outils pour vous aider à gérer vos offres et vos candidatures plus efficacement.</p>
            <ul>
                <li>Tableau de bord personnalisé</li>
                <li>Notifications automatiques</li>
                <li>Statistiques et analyses</li>
            </ul>
        </div>
    </section>

    <section class="benefits">
        <h2>Pourquoi choisir Work-Flexer ?</h2>
        <div class="benefit-item">
            <h3>Gain de temps et d'efficacité</h3>
            <p>Work-Flexer vous permet de gagner du temps et d'améliorer votre efficacité dans vos démarches de recherche d'emploi et de recrutement.</p>
            <ul>
                <li>Recherche d'offres d'emploi simplifiée</li>
                <li>Candidature en ligne en quelques clics</li>
                <li>Suivi des candidatures en temps réel</li>
                <li>Sauvegarde de documents intégrée</li>
            </ul>
        </div>
        <div class="benefit-item">
            <h3>Meilleure visibilité</h3>
            <p>Work-Flexer vous permet d'augmenter votre visibilité auprès des meilleurs candidats et des entreprises les plus attractives.</p>
            <ul>
                <li>Diffusion de votre profil à un large réseau</li>
                <li>Mise en relation avec des entreprises en recherche de talents</li>
                <li>Amélioration de vos chances de trouver un emploi</li>
            </ul>
        </div>
        <div class="testimonials">
            <h3>Témoignages</h3>
            <p><em>"Work-Flexer m'a permis de trouver un emploi en freelance en seulement quelques semaines."</em> - Jean Dupont, Développeur web</p>
            <p><em>"Notre équipe a pu recruter le candidat parfait pour notre poste grâce à Work-Flexer."</em> - Marie Durand, DRH</p>
            <p><strong>Plus de 10 000 utilisateurs font déjà confiance à Work-Flexer pour trouver leur emploi idéal.</strong></p>
        </div>
    </section>

    <section class="contact">
        <h2>Contactez-nous</h2>
        <p>Pour plus d'informations, n'hésitez pas à nous contacter via notre <a href="#">formulaire de contact</a>.</p>
    </section>
</main>

<footer>
    <p>&copy; Work-Flexer 2024</p>
</footer>

</body>
</html>

