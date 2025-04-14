<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Design et Création | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Design sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(155, 89, 182, 0.2);
        }

        :root {
            --accent-color: #9b59b6;
            /* Purple accent for design sector */
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
            <h1>Design et Création</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde créatif et artistique</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur créatif</h2>
                <p>Le secteur du design et de la création regroupe des métiers variés qui allient sens artistique,
                    maîtrise technique et compréhension des besoins des utilisateurs. Ces professions permettent
                    d'exprimer
                    sa créativité tout en répondant à des problématiques concrètes dans de nombreux domaines :
                    communication
                    visuelle, architecture d'intérieur, mode, produits, interfaces numériques...</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-paint-brush"></i>
                        <h3>+12%</h3>
                        <p>Croissance annuelle des emplois créatifs</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+200</h3>
                        <p>Formations artistiques et créatives disponibles</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-lightbulb"></i>
                        <h3>75%</h3>
                        <p>Des entreprises recherchent des profils créatifs</p>
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
                secteur du design et de la création</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="graphic">Design Graphique</button>
                    <button class="tab-btn" data-tab="product">Design Produit</button>
                    <button class="tab-btn" data-tab="interior">Design d'Intérieur</button>
                    <button class="tab-btn" data-tab="fashion">Mode et Textile</button>
                </div>

                <div class="tab-content">
                    <!-- Graphic Design Tab -->
                    <div class="tab-pane active" id="graphic" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-object-group"></i></div>
                                <h3>Designer Graphique</h3>
                                <p>Conçoit des identités visuelles, supports imprimés et contenus digitaux pour
                                    communiquer des messages efficacement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en design graphique, arts appliqués ou communication visuelle
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Suite Adobe (Photoshop, Illustrator, InDesign), typographie, théorie des
                                            couleurs, UX/UI</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences de communication, services marketing, indépendant, salaire de 25 000€
                                            à 45 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-film"></i></div>
                                <h3>Motion Designer</h3>
                                <p>Crée des animations et effets visuels pour différents médias (web, TV, réseaux
                                    sociaux).</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en animation, motion design ou design numérique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>After Effects, Cinema 4D, animation, storyboarding, montage vidéo</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Studios d'animation, agences digitales, production audiovisuelle, salaire de
                                            28 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Design Tab -->
                    <div class="tab-pane" id="product" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-cube"></i></div>
                                <h3>Designer Produit</h3>
                                <p>Conçoit des objets et produits en tenant compte de l'esthétique, de la fonctionnalité
                                    et de l'expérience utilisateur.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en design produit, design industriel ou conception</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Logiciels CAO/DAO, prototypage, matériaux, ergonomie, design thinking</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Bureaux d'études, ateliers de design, services R&D, salaire de 30 000€ à 60
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interior Design Tab -->
                    <div class="tab-pane" id="interior" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-couch"></i></div>
                                <h3>Architecte d'Intérieur</h3>
                                <p>Conçoit et aménage des espaces intérieurs fonctionnels, esthétiques et adaptés aux
                                    besoins.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en architecture d'intérieur ou design d'espace</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>SketchUp, AutoCAD, gestion de projet, connaissance des matériaux, éclairage
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences d'architecture, décoration, freelance, salaire de 28 000€ à 55 000€
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fashion Design Tab -->
                    <div class="tab-pane" id="fashion" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-tshirt"></i></div>
                                <h3>Styliste / Designer de Mode</h3>
                                <p>Crée des collections de vêtements et accessoires en tenant compte des tendances et
                                    des contraintes techniques.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en stylisme, design de mode ou métiers de la mode</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Dessin, couture, connaissance des textiles, techniques de fabrication,
                                            logiciels de design textile</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Maisons de mode, marques de prêt-à-porter, créateur indépendant, salaire de
                                            25 000€ à 50 000€</p>
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
                design et de la création</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac général (spécialité arts) ou technologique (STD2A) recommandé, développement d'un
                            portfolio dès le lycée</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>BTS, DNA, DNMADE, Licence, Master en design selon la spécialité choisie</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formations Complémentaires</h3>
                        <p>Spécialisation technique, formations en logiciels spécifiques, workshops</p>
                        <span class="timeline-date">6 mois à 1 an</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Veille créative, cours en ligne, participation à des évènements du secteur</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Académiques</h3>
                    </div>
                    <ul>
                        <li>BTS Design Graphique, de Produit, d'Espace</li>
                        <li>DNA/DNSEP en écoles d'art</li>
                        <li>Licence et Master Arts Appliqués</li>
                        <li>DNMADE (Diplôme National des Métiers d'Art et du Design)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-palette"></i>
                        <h3>Types de Formations</h3>
                    </div>
                    <ul>
                        <li>Écoles d'arts appliqués</li>
                        <li>Écoles de design publiques ou privées</li>
                        <li>Formations universitaires en arts</li>
                        <li>Formations professionnelles spécialisées</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop-code"></i>
                        <h3>Formations Alternatives</h3>
                    </div>
                    <ul>
                        <li>Cours en ligne (Domestika, Udemy, LinkedIn Learning)</li>
                        <li>Bootcamps créatifs intensifs</li>
                        <li>Autodidaxie avec tutorat</li>
                        <li>Workshops et masterclasses professionnels</li>
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
                design et de la création</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h3>Design Durable</h3>
                    <p>Accent croissant sur l'éco-conception, les matériaux durables et l'économie circulaire dans tous
                        les domaines du design.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>IA Générative</h3>
                    <p>Outils d'intelligence artificielle qui révolutionnent les processus créatifs et offrent de
                        nouvelles possibilités d'expression.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-vr-cardboard"></i>
                    </div>
                    <h3>Réalité Étendue (XR)</h3>
                    <p>Expériences immersives en AR/VR qui ouvrent de nouveaux horizons pour le design d'expérience et
                        l'interaction.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Design Inclusif</h3>
                    <p>Conception pensée pour être accessible à tous, quelles que soient les capacités, l'âge ou la
                        culture des utilisateurs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière créative ?</h2>
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