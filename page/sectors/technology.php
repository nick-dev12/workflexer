<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Technologie et Informatique en Afrique | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <link rel="stylesheet" href="/css/technology-sector.css">
    <style>
        /* Technology sector specific styles */
        .hero-section {
            background: url('../../image/Technologie.png') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(52, 152, 219, 0.2);
        }
    </style>
</head>

<body class="technology-sector-container">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../../navbare.php') ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up">
            <span class="sector-badge">Secteur Professionnel</span>
            <h1>Technologie et Informatique en Afrique</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde du numérique africain</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur technologique en Afrique</h2>
                <p>Le secteur de la technologie en Afrique connaît une croissance exceptionnelle et représente un levier
                    majeur de développement pour le continent. Des hubs d'innovation comme le Silicon Savannah au Kenya
                    aux écosystèmes tech d'Abidjan, Dakar ou Kigali, l'Afrique façonne ses propres solutions numériques
                    adaptées aux défis locaux.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-laptop-code"></i>
                        <h3>+22%</h3>
                        <p>Croissance annuelle des emplois tech en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+180</h3>
                        <p>Formations disponibles dans la région</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-coins"></i>
                        <h3>+45%</h3>
                        <p>Salaires supérieurs à la moyenne locale</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Paths -->
    <section class="career-paths">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Parcours Professionnels</h2>
            <p class="section-description" data-aos="fade-up">Explorez les différentes voies professionnelles dans le
                secteur technologique africain</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="development">Développement</button>
                    <button class="tab-btn" data-tab="data">Data & IA</button>
                    <button class="tab-btn" data-tab="security">Cybersécurité</button>
                    <button class="tab-btn" data-tab="design">UX/UI Design</button>
                </div>

                <div class="tab-content">
                    <!-- Development Tab -->
                    <div class="tab-pane active" id="development" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-code"></i></div>
                                <h3>Développeur Web</h3>
                                <p>Crée et maintient des sites web et applications web adaptés aux besoins des
                                    entreprises et utilisateurs africains.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en développement web, informatique à l'IAI, ESATIC, EMIT, ou
                                            formation dans les bootcamps africains (Simplon, Orange Digital Center)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>HTML/CSS, JavaScript, frameworks (React, Vue.js), PHP, bases de données,
                                            adaptation aux contraintes de connectivité locales</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Forte demande, nombreuses opportunités freelance et en entreprise, salaire de
                                            300 000 FCFA à 1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-mobile-alt"></i></div>
                                <h3>Développeur Mobile</h3>
                                <p>Conçoit et développe des applications mobiles optimisées pour les réalités africaines
                                    (bande passante limitée, appareils variés).</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en développement mobile ou informatique (ESMT, 3FPT, UCAD)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Java (Android), Flutter, React Native, développement d'applications légères,
                                            compatibilité multi-appareils</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Marché en forte croissance avec l'explosion du mobile en Afrique, salaire de
                                            350 000 FCFA à 1 800 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data & AI Tab -->
                    <div class="tab-pane" id="data" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-database"></i></div>
                                <h3>Data Scientist</h3>
                                <p>Analyse des ensembles de données pour résoudre des problématiques africaines (santé,
                                    agriculture, éducation, finance mobile).</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en data science, statistiques, mathématiques (AIMS, ENSAE, ESP, IMSP)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Python, R, SQL, machine learning, statistiques, visualisation de données,
                                            adaptation aux données locales</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Secteur émergent avec fort potentiel, salaire de 600 000 FCFA à 2 500 000
                                            FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane" id="security" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-shield-alt"></i></div>
                                <h3>Expert en Cybersécurité</h3>
                                <p>Protège les infrastructures numériques africaines contre les cybermenaces croissantes
                                    sur le continent.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en sécurité informatique (ESMT, EMIT, IAI), certifications
                                            (ANSSI, CISSP)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Sécurité des réseaux mobiles, cryptographie, tests d'intrusion, protection
                                            des systèmes de paiement mobile</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Demande critique avec la digitalisation rapide des services essentiels,
                                            salaire de 500 000 FCFA à 2 200 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Design Tab -->
                    <div class="tab-pane" id="design" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-paint-brush"></i></div>
                                <h3>Designer UX/UI</h3>
                                <p>Conçoit des interfaces adaptées aux utilisateurs africains, tenant compte des
                                    spécificités culturelles et techniques locales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en design numérique (ESAD, Institut Supérieur de Design, ISCOM)
                                            ou formation spécialisée (Incubateurs tech)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Figma, Adobe XD, recherche utilisateur contextualisée, design inclusif,
                                            interfaces adaptées aux faibles débits</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Rôle de plus en plus valorisé dans les startups africaines, salaire de 350
                                            000 FCFA à 1 800 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Pathways -->
    <section class="education-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Parcours de Formation</h2>
            <p class="section-description" data-aos="fade-up">Les différentes voies pour accéder aux métiers du
                numérique en Afrique francophone</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac scientifique ou technique (série C, D, E, F2) avec bonnes compétences en mathématiques
                        </p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>BTS, DUT, Licences dans les établissements africains spécialisés en informatique</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formations Alternatives</h3>
                        <p>Bootcamps tech africains, formations en ligne adaptées, incubateurs locaux</p>
                        <span class="timeline-date">6 mois à 2 ans</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Veille technologique, certifications internationales, participation aux événements tech
                            africains</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>Licence Informatique (UCAD, UVS, UAC, USTTB)</li>
                        <li>Masters spécialisés (ESP, ESMT, ENSAE)</li>
                        <li>DUT Informatique (IUT, ISET)</li>
                        <li>Doctorat en Informatique ou IA (AIMS, IMSP)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles Spécialisées</h3>
                    </div>
                    <ul>
                        <li>IAI (Institut Africain d'Informatique)</li>
                        <li>ESATIC (Côte d'Ivoire)</li>
                        <li>EMIT (École Supérieure Multinationale des Télécommunications)</li>
                        <li>3FPT (Fonds de Financement de la Formation Professionnelle et Technique)</li>
                        <li>ESMT (École Supérieure Multinationale des Télécommunications)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop-code"></i>
                        <h3>Formations Alternatives</h3>
                    </div>
                    <ul>
                        <li>Orange Digital Centers (plusieurs pays africains)</li>
                        <li>Simplon.co (Sénégal, Côte d'Ivoire, Burkina Faso)</li>
                        <li>CTIC Dakar, Jokkolabs (incubateurs avec formations)</li>
                        <li>Plateformes en ligne adaptées (Coursera, Udemy avec options hors-ligne)</li>
                        <li>Certifications professionnelles accessibles en Afrique</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Trends -->
    <section class="trends-section">
        <div class="container">
            <h2 class="section-title light" data-aos="fade-up">Tendances du Secteur</h2>
            <p class="section-description light" data-aos="fade-up">Les évolutions majeures qui façonnent l'avenir du
                numérique en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Solutions Mobile-First</h3>
                    <p>Développement centré sur le mobile, applications légères fonctionnant avec peu de données et sur
                        des appareils d'entrée de gamme.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>Fintech & Mobile Money</h3>
                    <p>Innovations dans les paiements mobiles, services financiers pour les non-bancarisés et
                        technologies blockchain adaptées au contexte africain.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-sun"></i>
                    </div>
                    <h3>Tech Durable & Hors-ligne</h3>
                    <p>Solutions fonctionnant avec l'énergie solaire, applications avec modes hors-ligne, et
                        technologies adaptées aux zones à connectivité limitée.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>IA & Données Locales</h3>
                    <p>Intelligence artificielle adaptée aux langues et contextes africains, solutions de reconnaissance
                        vocale multilingue et applications dans la santé et l'agriculture.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière technologique en Afrique ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../../js/technology-sector.js"></script>
</body>

</html>