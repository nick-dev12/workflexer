<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Technologie et Informatique | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
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

<body>
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
            <h1>Technologie et Informatique</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde du numérique</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur technologique</h2>
                <p>Le secteur de la technologie est à la pointe de l'innovation et offre des opportunités sans précédent
                    pour ceux qui cherchent à façonner l'avenir numérique. Des startups aux géants de la tech, ce
                    domaine recherche constamment des talents créatifs et techniques.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-laptop-code"></i>
                        <h3>+15%</h3>
                        <p>Croissance annuelle des emplois</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+250</h3>
                        <p>Formations disponibles</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-euro-sign"></i>
                        <h3>+30%</h3>
                        <p>Salaires supérieurs à la moyenne</p>
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
                secteur technologique</p>

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
                                <p>Crée et maintient des sites web et applications web pour diverses plateformes.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en développement web, informatique, ou formation autodidacte
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>HTML/CSS, JavaScript, frameworks (React, Vue.js), PHP, bases de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Forte demande, nombreuses opportunités freelance et en entreprise, salaire de
                                            30 000€ à 60 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-mobile-alt"></i></div>
                                <h3>Développeur Mobile</h3>
                                <p>Conçoit et développe des applications pour smartphones et tablettes.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en développement mobile ou informatique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Swift (iOS), Kotlin/Java (Android), React Native, Flutter</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Marché en forte croissance, évolution vers des postes de lead developer,
                                            salaire de 35 000€ à 65 000€</p>
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
                                <p>Analyse des ensembles de données complexes pour identifier des tendances et aider à
                                    la prise de décision.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en data science, statistiques, mathématiques ou informatique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Python, R, SQL, machine learning, statistiques, visualisation de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Secteur en plein essor, excellentes perspectives, salaire de 40 000€ à 80
                                            000€</p>
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
                                <p>Protège les systèmes informatiques et les réseaux contre les menaces et les attaques.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en sécurité informatique, certifications (CISSP, CEH)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Sécurité des réseaux, cryptographie, tests d'intrusion, analyse des
                                            vulnérabilités</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Demande croissante avec l'augmentation des cybermenaces, salaire de 40 000€ à
                                            90 000€</p>
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
                                <p>Conçoit des interfaces utilisateur intuitives et des expériences utilisateur
                                    optimales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en design numérique, interaction homme-machine ou formation
                                            spécialisée</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Figma, Adobe XD, recherche utilisateur, prototypage, design thinking</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Rôle de plus en plus valorisé dans les entreprises tech, salaire de 30 000€ à
                                            70 000€</p>
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
                numérique</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac général ou technologique (STI2D) recommandé avec bonne maîtrise des mathématiques</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>BTS, DUT, Licences, Écoles d'ingénieurs ou spécialisées selon le domaine visé</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formations Alternatives</h3>
                        <p>Bootcamps intensifs, formations en ligne (MOOCs), certifications spécialisées</p>
                        <span class="timeline-date">6 mois à 2 ans</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Veille technologique, certifications à jour, spécialisations tout au long de la carrière</p>
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
                        <li>Licence Informatique</li>
                        <li>Masters spécialisés (Développement, Data, Sécurité)</li>
                        <li>BUT Informatique</li>
                        <li>Doctorat en Informatique ou IA</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles Spécialisées</h3>
                    </div>
                    <ul>
                        <li>Écoles d'ingénieurs (EPITA, EPITECH, etc.)</li>
                        <li>Écoles de design numérique</li>
                        <li>42, Web@cadémie et autres écoles innovantes</li>
                        <li>BTS Services Informatiques aux Organisations</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop-code"></i>
                        <h3>Formations Alternatives</h3>
                    </div>
                    <ul>
                        <li>Bootcamps (Le Wagon, Ironhack, etc.)</li>
                        <li>Plateformes en ligne (Udemy, Coursera, OpenClassrooms)</li>
                        <li>Certifications professionnelles (AWS, Google, Microsoft)</li>
                        <li>Autoformation via les ressources open source</li>
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
                numérique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Intelligence Artificielle</h3>
                    <p>Démocratisation de l'IA générative, automatisation intelligente et nouveaux outils transformant
                        tous les secteurs professionnels.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3>Blockchain & Web3</h3>
                    <p>Développement de solutions décentralisées, NFTs, cryptomonnaies et applications pour une nouvelle
                        économie numérique.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>Cloud & Edge Computing</h3>
                    <p>Expansion continue du cloud et émergence du edge computing pour traiter les données au plus près
                        des utilisateurs.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-vr-cardboard"></i>
                    </div>
                    <h3>Réalité Augmentée/Virtuelle</h3>
                    <p>Développement de nouvelles interfaces immersives pour le divertissement, la formation et la
                        collaboration professionnelle.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière technologique ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            once: true
        });

        // Tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Remove active class from all buttons and panes
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Show the corresponding tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
</body>

</html>