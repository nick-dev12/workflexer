<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orientation Professionnelle en Afrique | Work-Flexer</title>
    <meta name="description"
        content="Découvrez les opportunités de carrière adaptées au marché africain et trouvez votre voie professionnelle idéale avec Work-Flexer">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/orientation.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="orientation-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <!-- Hero Section avec animation et contexte africain -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-pattern"></div>
        <div class="hero-content" data-aos="fade-up">
            <h1>Explorez Votre Avenir Professionnel en Afrique</h1>
            <p>Découvrez les opportunités de carrière adaptées au marché africain et trouvez votre voie professionnelle
                idéale</p>
            <div class="hero-buttons">
                <a href="#sectors" class="cta-button primary">Explorer les Secteurs</a>
                <a href="#career-guide" class="cta-button secondary">Guide d'Orientation</a>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <a href="#sectors"><i class="fas fa-chevron-down"></i></a>
        </div>
    </section>

    <!-- Introduction avec statistiques du marché africain -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content">
                <h2 class="section-title" data-aos="fade-up">Orientation Professionnelle en Afrique</h2>
                <p class="section-description" data-aos="fade-up">Notre plateforme vous aide à naviguer dans le paysage
                    professionnel africain en pleine évolution, en vous connectant aux opportunités les plus pertinentes
                    pour votre parcours.</p>

                <div class="stats-container" data-aos="fade-up">
                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
                        <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                        <div class="stat-number">+15M</div>
                        <div class="stat-label">Emplois créés en Afrique chaque année</div>
                    </div>
                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="200">
                        <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="stat-number">60%</div>
                        <div class="stat-label">De la population a moins de 25 ans</div>
                    </div>
                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="stat-number">+5.4%</div>
                        <div class="stat-label">Croissance économique moyenne</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Tendances du marché africain -->
    <section class="trends-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Tendances du Marché</h2>
            <p class="section-description" data-aos="fade-up">Restez informé des évolutions du marché du travail et
                des compétences recherchées en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="fade-up">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Transformation Digitale</h3>
                    <p>L'adoption rapide des technologies mobiles et numériques crée de nouvelles opportunités</p>
                    <div class="trend-stats">
                        <span>+47% de croissance</span>
                    </div>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Économie Verte</h3>
                    <p>Développement de solutions durables adaptées aux défis environnementaux du continent</p>
                    <div class="trend-stats">
                        <span>+32% de croissance</span>
                    </div>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Entrepreneuriat Social</h3>
                    <p>Création d'entreprises à impact qui répondent aux besoins sociaux et économiques</p>
                    <div class="trend-stats">
                        <span>+25% de croissance</span>
                    </div>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3>Intégration Régionale</h3>
                    <p>Développement des compétences transfrontalières avec la ZLECAF</p>
                    <div class="trend-stats">
                        <span>+18% de croissance</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Sector Navigation avec design modernisé -->
        <section class="sector-navigation" id="sectors">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Secteurs d'Activité</h2>
                <p class="section-description" data-aos="fade-up">Explorez les domaines professionnels adaptés au marché
                    africain et trouvez celui qui correspond à vos aspirations</p>

                <div class="sector-filter" data-aos="fade-up">
                    <button class="filter-btn active" data-filter="all">Tous les secteurs</button>
                    <button class="filter-btn" data-filter="emerging">Émergents</button>
                    <button class="filter-btn" data-filter="traditional">Traditionnels</button>
                    <button class="filter-btn" data-filter="digital">Économie numérique</button>
                </div>

                <div class="sector-categories-legend" data-aos="fade-up">
                    <div class="category-item">
                        <span class="category-dot emerging"></span>
                        <span>Secteurs émergents</span>
                    </div>
                    <div class="category-item">
                        <span class="category-dot digital"></span>
                        <span>Économie numérique</span>
                    </div>
                    <div class="category-item">
                        <span class="category-dot traditional"></span>
                        <span>Secteurs traditionnels</span>
                    </div>
                </div>

                <div class="sector-grid">
                    <div class="sector-card" data-aos="fade-up" data-aos-delay="100"
                        data-category="traditional emerging">
                        <div class="sector-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Santé et Médecine</h3>
                            <p>Carrières dédiées au bien-être et à la santé, adaptées aux défis sanitaires africains</p>
                            <div class="sector-meta">
                                <span class="growth-tag">12% croissance</span>
                                <span class="region-tag">Toute l'Afrique</span>
                            </div>
                            <a href="sectors/health.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="150" data-category="digital emerging">
                        <div class="sector-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Technologie et Informatique</h3>
                            <p>Innovation et développement numérique pour résoudre les défis spécifiques du continent
                            </p>
                            <div class="sector-meta">
                                <span class="growth-tag">24% croissance</span>
                                <span class="region-tag">Zones urbaines</span>
                            </div>
                            <a href="sectors/technology.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="200" data-category="traditional">
                        <div class="sector-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Ingénierie et Architecture</h3>
                            <p>Conception et construction adaptées aux besoins d'infrastructures durables en Afrique</p>
                            <div class="sector-meta">
                                <span class="growth-tag">15% croissance</span>
                                <span class="region-tag">Grandes villes</span>
                            </div>
                            <a href="sectors/engineering.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="250" data-category="traditional">
                        <div class="sector-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Droit et Justice</h3>
                            <p>Protection des droits et résolution des litiges juridiques dans le contexte africain</p>
                            <div class="sector-meta">
                                <span class="growth-tag">8% croissance</span>
                                <span class="region-tag">Capitales</span>
                            </div>
                            <a href="sectors/law.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="300" data-category="emerging">
                        <div class="sector-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Économie et Finance</h3>
                            <p>Gestion des ressources financières et développement économique pour l'émergence africaine
                            </p>
                            <div class="sector-meta">
                                <span class="growth-tag">14% croissance</span>
                                <span class="region-tag">Centres financiers</span>
                            </div>
                            <a href="sectors/economics.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="350" data-category="traditional">
                        <div class="sector-icon">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Administration Publique</h3>
                            <p>Carrières au service de l'intérêt général et du développement des nations africaines</p>
                            <div class="sector-meta">
                                <span class="growth-tag">6% croissance</span>
                                <span class="region-tag">Toute l'Afrique</span>
                            </div>
                            <a href="sectors/administration.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="400" data-category="digital emerging">
                        <div class="sector-icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Design et Création</h3>
                            <p>Métiers de la création artistique valorisant le patrimoine culturel et esthétique
                                africain</p>
                            <div class="sector-meta">
                                <span class="growth-tag">18% croissance</span>
                                <span class="region-tag">Centres culturels</span>
                            </div>
                            <a href="sectors/design.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="450" data-category="digital">
                        <div class="sector-icon">
                            <i class="fas fa-pen-fancy"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Rédaction et Traduction</h3>
                            <p>Communication écrite et transfert linguistique entre les langues africaines et
                                internationales</p>
                            <div class="sector-meta">
                                <span class="growth-tag">16% croissance</span>
                                <span class="region-tag">International</span>
                            </div>
                            <a href="sectors/writing.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="500" data-category="emerging">
                        <div class="sector-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Conseil et Gestion</h3>
                            <p>Stratégie et optimisation des organisations pour accompagner la croissance africaine</p>
                            <div class="sector-meta">
                                <span class="growth-tag">20% croissance</span>
                                <span class="region-tag">Pôles économiques</span>
                            </div>
                            <a href="sectors/consulting.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="550"
                        data-category="traditional emerging">
                        <div class="sector-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Éducation et Formation</h3>
                            <p>Transmission du savoir et développement des compétences pour la jeunesse africaine</p>
                            <div class="sector-meta">
                                <span class="growth-tag">10% croissance</span>
                                <span class="region-tag">Toute l'Afrique</span>
                            </div>
                            <a href="sectors/education.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="600" data-category="emerging">
                        <div class="sector-icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Tourisme et Hôtellerie</h3>
                            <p>Accueil, services et expériences de voyage valorisant le patrimoine africain</p>
                            <div class="sector-meta">
                                <span class="growth-tag">22% croissance</span>
                                <span class="region-tag">Zones touristiques</span>
                            </div>
                            <a href="sectors/tourism.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="650" data-category="traditional">
                        <div class="sector-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Commerce et Vente</h3>
                            <p>Distribution et négociation commerciale adaptées aux marchés africains</p>
                            <div class="sector-meta">
                                <span class="growth-tag">13% croissance</span>
                                <span class="region-tag">Toute l'Afrique</span>
                            </div>
                            <a href="sectors/commerce.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="700"
                        data-category="traditional emerging">
                        <div class="sector-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Transport et Logistique</h3>
                            <p>Organisation des flux de marchandises et de personnes pour connecter l'Afrique</p>
                            <div class="sector-meta">
                                <span class="growth-tag">17% croissance</span>
                                <span class="region-tag">Corridors commerciaux</span>
                            </div>
                            <a href="sectors/transport.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="sector-card" data-aos="fade-up" data-aos-delay="750"
                        data-category="traditional emerging">
                        <div class="sector-icon">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="sector-content">
                            <h3>Agriculture</h3>
                            <p>Production, transformation et distribution alimentaire pour la sécurité nutritionnelle
                            </p>
                            <div class="sector-meta">
                                <span class="growth-tag">19% croissance</span>
                                <span class="region-tag">Zones rurales</span>
                            </div>
                            <a href="sectors/agriculture.php" class="sector-link">Explorer <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Guide d'orientation avec approche par étapes -->
        <section id="career-guide" class="career-guide-section">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Guide d'Orientation</h2>
                <p class="section-description" data-aos="fade-up">Suivez notre approche structurée pour découvrir et
                    construire votre parcours professionnel en Afrique</p>

                <div class="guide-steps">
                    <div class="guide-step" data-aos="fade-right">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Découverte de soi</h3>
                            <p>Identifiez vos talents, passions et valeurs pour orienter votre choix de carrière</p>
                            <a href="#" class="step-link">Faire le test d'orientation <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="guide-step" data-aos="fade-right" data-aos-delay="100">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Exploration des secteurs</h3>
                            <p>Découvrez les opportunités dans différents domaines d'activité en Afrique</p>
                            <a href="#sectors" class="step-link">Explorer les secteurs <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="guide-step" data-aos="fade-right" data-aos-delay="200">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Formation et compétences</h3>
                            <p>Identifiez les parcours de formation adaptés à vos objectifs professionnels</p>
                            <a href="#" class="step-link">Parcours de formation <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="guide-step" data-aos="fade-right" data-aos-delay="300">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>Insertion professionnelle</h3>
                            <p>Préparez votre entrée sur le marché du travail africain avec nos conseils pratiques</p>
                            <a href="#" class="step-link">Guide d'insertion <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Témoignages de professionnels africains -->
        <section class="testimonials-section">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Témoignages</h2>
                <p class="section-description" data-aos="fade-up">Découvrez les parcours inspirants de professionnels
                    qui ont réussi leur carrière en Afrique</p>

                <div class="testimonials-slider" data-aos="fade-up">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="https://images.unsplash.com/photo-1508002366005-75a695ee2d17?q=80&w=300&auto=format&fit=crop"
                                alt="Aminata Diallo">
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-left"></i>
                                <p>Après ma formation en ingénierie à l'École Polytechnique de Dakar, j'ai rejoint un
                                    projet d'infrastructures durables qui transforme l'accès à l'eau dans ma région.
                                    L'orientation professionnelle m'a aidée à trouver ma voie dans un secteur à fort
                                    impact.</p>
                            </div>
                            <div class="testimonial-author">
                                <h4>Aminata Diallo</h4>
                                <p>Ingénieure Civile, Sénégal</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="https://images.unsplash.com/photo-1507152832244-10d45c7eda57?q=80&w=300&auto=format&fit=crop"
                                alt="Kofi Mensah">
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-left"></i>
                                <p>Le secteur technologique africain est en pleine expansion. Après mes études en
                                    informatique à l'Université de Lomé, j'ai créé une startup qui développe des
                                    solutions de paiement mobile adaptées aux besoins locaux. L'avenir est dans
                                    l'innovation africaine.</p>
                            </div>
                            <div class="testimonial-author">
                                <h4>Kofi Mensah</h4>
                                <p>Entrepreneur Tech, Ghana</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=300&auto=format&fit=crop"
                                alt="Fatima Ouedraogo">
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-left"></i>
                                <p>Ma passion pour la santé publique m'a conduite à étudier la médecine à l'Université
                                    de Ouagadougou. Aujourd'hui, je dirige un programme de santé communautaire qui a
                                    amélioré l'accès aux soins dans les zones rurales du Burkina Faso.</p>
                            </div>
                            <div class="testimonial-author">
                                <h4>Fatima Ouedraogo</h4>
                                <p>Médecin en Santé Publique, Burkina Faso</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-nav">
                    <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
                    <div class="testimonial-dots">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                    <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>



        <!-- Section Ressources et Outils -->
        <section class="resources-section">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Ressources</h2>
                <p class="section-description" data-aos="fade-up">Accédez à des outils pratiques pour vous aider dans
                    votre parcours d'orientation professionnelle</p>

                <div class="resources-grid">
                    <div class="resource-card" data-aos="fade-up">
                        <div class="resource-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3>Guide des Métiers d'Avenir</h3>
                        <p>Un catalogue complet des professions émergentes en Afrique</p>
                        <a href="#" class="resource-link">Télécharger <i class="fas fa-download"></i></a>
                    </div>

                    <div class="resource-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="resource-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Test d'Orientation</h3>
                        <p>Découvrez les secteurs qui correspondent à vos compétences</p>
                        <a href="#" class="resource-link">Commencer <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="resource-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="resource-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Calendrier des Formations</h3>
                        <p>Planifiez votre parcours avec notre calendrier des programmes</p>
                        <a href="#" class="resource-link">Consulter <i class="fas fa-external-link-alt"></i></a>
                    </div>

                    <div class="resource-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="resource-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Conseil Personnalisé</h3>
                        <p>Bénéficiez d'un accompagnement sur-mesure avec nos conseillers</p>
                        <a href="#" class="resource-link">Rendez-vous <i class="fas fa-calendar-check"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content" data-aos="fade-up">
                    <h2>Prêt à Construire Votre Avenir Professionnel?</h2>
                    <p>Rejoignez notre communauté et accédez à des ressources exclusives pour développer votre carrière
                    </p>
                    <div class="cta-buttons">
                        <a href="#" class="cta-button primary">Créer un compte</a>
                        <a href="#" class="cta-button secondary">En savoir plus</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('../footer.php') ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/orientation.js"></script>
</body>

</html>