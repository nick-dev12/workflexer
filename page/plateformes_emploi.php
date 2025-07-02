<?php
session_start();
include '../conn/conn.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les plateformes d'offres d'emploi partenaires de WorkFlexer. Accédez à des milliers d'opportunités professionnelles sur EmploiSenegal, EmploiDakar, SenJob et WorkFlexer.">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <title>Plateformes d'offres d'emploi | WorkFlexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/aos.css" />
    <script defer src="../js/aos.js"></script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <header class="hero-section">
        <div class="hero-content">
            <h1 data-aos="fade-up" data-aos-delay="100">Plateformes d'offres d'emploi</h1>
            <p data-aos="fade-up" data-aos-delay="200">Accédez à des milliers d'opportunités professionnelles sur une seule plateforme </p>
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
                <div class="stat">
                    <i class="fas fa-briefcase"></i>
                    <span class="count">2,000+</span>
                    <span class="label">Offres d'emploi</span>
                </div>
                <div class="stat">
                    <i class="fas fa-building"></i>
                    <span class="count">4</span>
                    <span class="label">Plateformes</span>
                </div>
                <div class="stat">
                    <i class="fas fa-users"></i>
                    <span class="count">5,000+</span>
                    <span class="label">Recruteurs</span>
                </div>
            </div>
        </div>
        <div class="wave-separator">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,186.7C672,213,768,235,864,229.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </header>

    <section class="platforms-section">
        <div class="container">
           
            <div class="platforms-grid">
                <div class="platform-card" data-aos="fade-up" data-aos-delay="150">
                    <div class="card-banner workflexer">
                        <div class="platform-logo">
                            <img src="../image/logo2.png" alt="WorkFlexer">
                        </div>
                        <div class="offer-count">
                            <span>500+ offres</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>WorkFlexer</h3>
                        <p>Notre plateforme principale propose des offres d'emploi vérifiées et adaptées à tous les profils professionnels. Accédez à des opportunités uniques publiées par des entreprises de confiance.</p>
                        <div class="card-actions">
                            <a href="Offres_d'emploi.php" class="btn-platform primary">
                                <i class="fas fa-briefcase"></i> Voir les offres
                            </a>
                        </div>
                    </div>
                </div>

                <div class="platform-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-banner emploisenegal">
                        <div class="platform-logo">
                            <span>Emploi Sénégal</span>
                        </div>
                        <div class="offer-count">
                            <span>300+ offres</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>EmploiSenegal</h3>
                        <p>EmploiSenegal est l'une des plus grandes plateformes d'emploi au Sénégal. Elle propose des milliers d'offres dans divers secteurs et pour tous niveaux d'expérience.</p>
                       
                        <div class="card-actions">
                            <a href="offres_emploi_senegal.php" class="btn-platform">
                                <i class="fas fa-briefcase"></i> Voir les offres
                            </a>
                        </div>
                    </div>
                </div>

                <div class="platform-card" data-aos="fade-up" data-aos-delay="250">
                    <div class="card-banner emploidakar">
                        <div class="platform-logo">
                            <span>Emploi Dakar</span>
                        </div>
                        <div class="offer-count">
                            <span>200+ offres</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>EmploiDakar</h3>
                        <p>EmploiDakar se concentre sur les opportunités professionnelles dans la région de Dakar. Idéal pour ceux qui cherchent un emploi dans la capitale sénégalaise.</p>
                       
                        <div class="card-actions">
                            <a href="offres_emploi_dakar.php" class="btn-platform">
                                <i class="fas fa-briefcase"></i> Voir les offres
                            </a>
                        </div>
                    </div>
                </div>

                <div class="platform-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-banner senjob">
                        <div class="platform-logo">
                            <span>SenJob</span>
                        </div>
                        <div class="offer-count">
                            <span>300+ offres</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>SenJob</h3>
                        <p>SenJob est spécialisé dans les offres d'emploi pour jeunes diplômés et les stages. Une excellente ressource pour démarrer sa carrière professionnelle au Sénégal.</p>
                       
                        <div class="card-actions">
                            <a href="offres_senjob.php" class="btn-platform">
                                <i class="fas fa-briefcase"></i> Voir les offres
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="comparison-section">
        <div class="container">
            <h2 data-aos="fade-up">Comparez les plateformes</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Caractéristiques des différentes plateformes pour vous aider à choisir celle qui correspond à vos besoins</p>
            
            <div class="comparison-table-wrapper" data-aos="fade-up" data-aos-delay="200">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Caractéristiques</th>
                            <th>WorkFlexer</th>
                            <th>EmploiSenegal</th>
                            <th>EmploiDakar</th>
                            <th>SenJob</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nombre d'offres</td>
                            <td>500+</td>
                            <td>3000+</td>
                            <td>2500+</td>
                            <td>2000+</td>
                        </tr>
                        <tr>
                            <td>Spécialisation</td>
                            <td>Tous secteurs</td>
                            <td>National</td>
                            <td>Dakar</td>
                            <td>Jeunes diplômés</td>
                        </tr>
                        <tr>
                            <td>Types de contrats</td>
                            <td>CDI, CDD, Stage, Freelance</td>
                            <td>CDI, CDD, Fonction publique</td>
                            <td>CDI, CDD, Stage</td>
                            <td>Stage, Alternance, Premier emploi</td>
                        </tr>
                        <tr>
                            <td>Profil recommandé</td>
                            <td>Tous profils</td>
                            <td>Expérimentés</td>
                            <td>Urbains</td>
                            <td>Débutants</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="faq-section">
        <div class="container">
            <h2 data-aos="fade-up">Questions fréquentes</h2>
            <div class="faq-list" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Comment postuler aux offres des différentes plateformes ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Lorsque vous consultez une offre d'emploi sur WorkFlexer, vous serez redirigé vers la plateforme d'origine pour compléter votre candidature. Chaque plateforme peut avoir son propre processus de candidature.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Faut-il créer un compte sur chaque plateforme ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Pour consulter les offres sur WorkFlexer, un seul compte suffit. Cependant, pour postuler sur certaines plateformes partenaires, vous pourriez avoir besoin de créer un compte spécifique à cette plateforme.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Les offres sont-elles mises à jour régulièrement ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Oui, notre système synchronise quotidiennement les offres d'emploi avec nos plateformes partenaires pour vous garantir l'accès aux opportunités les plus récentes.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Quelle est la meilleure plateforme pour les jeunes diplômés ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>SenJob est particulièrement adaptée aux jeunes diplômés et propose de nombreux stages et premiers emplois. WorkFlexer offre également des opportunités intéressantes pour démarrer votre carrière.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à trouver votre prochain emploi ?</h2>
                <p>Commencez à explorer les milliers d'offres disponibles sur nos plateformes partenaires</p>
                <div class="cta-buttons">
                    <a href="Offres_d'emploi.php" class="btn-cta primary">Explorer toutes les offres</a>
                    <a href="../connection_compte.php" class="btn-cta secondary">Créer un compte</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialisation de AOS (Animation On Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });

            // Animation des chiffres
            const countElements = document.querySelectorAll('.count');
            countElements.forEach(element => {
                const target = parseInt(element.textContent.replace(/,|\+/g, ''));
                let count = 0;
                const duration = 2000; // ms
                const frameDuration = 1000 / 60; // 60fps
                const totalFrames = Math.round(duration / frameDuration);
                const increment = target / totalFrames;
                
                const startCounting = () => {
                    const counter = setInterval(() => {
                        count += increment;
                        if (count >= target) {
                            element.textContent = target.toLocaleString() + '+';
                            clearInterval(counter);
                        } else {
                            element.textContent = Math.floor(count).toLocaleString() + '+';
                        }
                    }, frameDuration);
                };
                
                // Observer pour démarrer l'animation quand l'élément est visible
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            startCounting();
                            observer.unobserve(entry.target);
                        }
                    });
                });
                
                observer.observe(element);
            });

            // Gestion des FAQ
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', () => {
                    // Fermer toutes les autres questions
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    // Basculer l'état actuel
                    item.classList.toggle('active');
                });
            });
        });
    </script>

    <style>
        /* Styles généraux */
        :root {
            --primary-color: #007BFF;
            --secondary-color: #6c757d;
            --accent-color: #28a745;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --text-color: #212529;
            --border-radius: 8px;
            --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h1, h2, h3, h4 {
            font-weight: 700;
            line-height: 1.3;
            color: var(--dark-color);
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: var(--transition);
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        section {
            padding: 80px 0;
        }

        section h2 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: var(--secondary-color);
            margin-bottom: 3rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            background: linear-gradient(135deg, #0072ff 0%, #00c6ff 100%);
            color: white;
            padding: 120px 0 180px;
            text-align: center;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255, 255, 255, 0.1)" d="M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,186.7C672,213,768,235,864,229.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-position: bottom;
            background-size: cover;
            opacity: 0.4;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            color: white;
        }

        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .stat .count {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat .label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .wave-separator {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        /* Introduction Section */
        .introduction {
            background-color: white;
            padding-top: 20px;
        }

        .intro-content h2 {
            margin-bottom: 1.5rem;
        }

        .intro-content p {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 3rem;
            font-size: 1.1rem;
            color: var(--secondary-color);
        }

        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 3rem;
        }

        .step {
            flex: 1;
            min-width: 250px;
            padding: 2rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: var(--transition);
        }

        .step:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .step-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 50%;
            margin-bottom: 1.5rem;
        }

        .step-icon i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .step h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .step p {
            color: var(--secondary-color);
            margin-bottom: 0;
        }

        /* Platforms Section */
        .platforms-section {
            background-color: #f5f7fa;
        }

        .platforms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .platform-card {
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .platform-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-banner {
            position: relative;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 2rem;
        }

        .card-banner.workflexer {
            background: linear-gradient(135deg, #0072ff 0%, #00c6ff 100%);
        }

        .card-banner.emploisenegal {
            background: linear-gradient(135deg, #FF5722 0%, #FF9800 100%);
        }

        .card-banner.emploidakar {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
        }

        .card-banner.senjob {
            background: linear-gradient(135deg, #9C27B0 0%, #E91E63 100%);
        }

        .platform-logo {
            text-align: center;
        }

        .platform-logo img {
            max-height: 60px;
        }

        .platform-logo span {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .offer-count {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .card-content {
            padding: 2rem;
        }

        .card-content h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .card-content p {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            font-size: 12px;
        }

        .platform-features {
            margin-bottom: 1.5rem;
        }

        .platform-features li {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .platform-features i {
            color: var(--accent-color);
            margin-right: 0.5rem;
        }

        .card-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .btn-platform {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #e9ecef;
            color: var(--dark-color);
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-platform:hover {
            background-color: #dee2e6;
            transform: translateY(-3px);
        }

        .btn-platform.primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-platform.primary:hover {
            background-color: #0069d9;
        }

        .btn-platform i {
            margin-right: 8px;
        }

        /* Comparison Section */
        .comparison-section {
            background-color: white;
        }

        .comparison-table-wrapper {
            overflow-x: auto;
            margin-top: 2rem;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 1rem;
        }

        .comparison-table th,
        .comparison-table td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .comparison-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .comparison-table tr:hover {
            background-color: #f8f9fa;
        }

        .comparison-table th:first-child,
        .comparison-table td:first-child {
            font-weight: 600;
        }

        /* FAQ Section */
        .faq-section {
            background-color: #f5f7fa;
        }

        .faq-list {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background-color: white;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .faq-question h3 {
            font-size: 1.1rem;
            margin: 0;
        }

        .faq-question i {
            transition: var(--transition);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
        }

        .faq-answer p {
            padding: 0 1.5rem 1.5rem;
        }

        .faq-item.active .faq-question {
            background-color: #f8f9fa;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #0072ff 0%, #00c6ff 100%);
            color: white;
            text-align: center;
            padding: 80px 0;
        }

        .cta-content h2 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-cta {
            padding: 12px 30px;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-cta.primary {
            background-color: white;
            color: var(--primary-color);
        }

        .btn-cta.primary:hover {
            background-color: #f8f9fa;
            transform: translateY(-3px);
        }

        .btn-cta.secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-cta.secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-section h1 {
                font-size: 2.8rem;
            }

            .steps {
                flex-direction: column;
                max-width: 500px;
                margin-left: auto;
                margin-right: auto;
            }

            .platforms-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            section {
                padding: 60px 0;
            }

            .hero-section {
                padding: 100px 0 150px;
            }

            .hero-section h1 {
                font-size: 2.3rem;
            }

            .hero-section p {
                font-size: 1.1rem;
            }

            .hero-stats {
                gap: 2rem;
            }

            .stat i {
                font-size: 2rem;
            }

            .stat .count {
                font-size: 1.8rem;
            }

            section h2 {
                font-size: 2rem;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 0.75rem;
            }

            .cta-content h2 {
                font-size: 2rem;
            }

            .cta-content p {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1.5rem;
            }

            .platforms-grid {
                grid-template-columns: 1fr;
            }

            .faq-question h3 {
                font-size: 1rem;
            }
        }
    </style>

</body>

</html> 