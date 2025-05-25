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
    <link rel="stylesheet" href="/css/design-sector.css">
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
            <p>Découvrez les opportunités, formations et perspectives dans le monde créatif et artistique africain</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur créatif en Afrique</h2>
                <p>Le secteur du design et de la création en Afrique regroupe des métiers variés qui allient sens
                    artistique,
                    maîtrise technique et compréhension des besoins des utilisateurs. Ces professions permettent
                    d'exprimer sa créativité tout en répondant à des problématiques concrètes dans de nombreux domaines
                    :
                    communication visuelle, architecture d'intérieur, mode, produits, interfaces numériques, tout en
                    intégrant
                    les riches traditions artistiques et culturelles africaines.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-paint-brush"></i>
                        <h3>+15%</h3>
                        <p>Croissance annuelle des emplois créatifs en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+120</h3>
                        <p>Formations artistiques et créatives disponibles sur le continent</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-lightbulb"></i>
                        <h3>68%</h3>
                        <p>Des entreprises africaines recherchent des profils créatifs</p>
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
                secteur du design et de la création en Afrique</p>

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
                                        <p>Bac+2 à Bac+5 en design graphique, arts appliqués ou communication visuelle à
                                            l'Institut Supérieur des Arts et Métiers du Numérique (SUP'IMAX), École des
                                            Beaux-Arts de Dakar ou CESAG</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Suite Adobe (Photoshop, Illustrator, InDesign), typographie, théorie des
                                            couleurs, UX/UI, connaissance des motifs et symboles africains</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences de communication, services marketing, indépendant, salaire de 150 000
                                            FCFA
                                            à 300 000 FCFA</p>
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
                                        <p>Bac+2 à Bac+5 en animation, motion design ou design numérique à l'Institut
                                            Supérieur des Arts et Métiers du Numérique (SUP'IMAX) ou à l'ESMA Bénin</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>After Effects, Cinema 4D, animation, storyboarding, montage vidéo</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Studios d'animation, agences digitales, production audiovisuelle, salaire de
                                            180 000 FCFA à 350 000 FCFA</p>
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
                                    et de l'expérience utilisateur, souvent en intégrant des matériaux et techniques
                                    traditionnels africains.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en design produit, design industriel ou conception à l'ESP
                                            (École Supérieure Polytechnique) de Dakar ou 2iE au Burkina Faso</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Logiciels CAO/DAO, prototypage, connaissance des matériaux locaux, ergonomie,
                                            design thinking</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Bureaux d'études, ateliers de design, services R&D, salaire de 200 000 FCFA à
                                            400 000 FCFA</p>
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
                                    besoins, en intégrant des éléments de design africain contemporain.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en architecture d'intérieur ou design d'espace à l'ESAM (École
                                            Supérieure d'Architecture et de Design) ou à l'INPHB en Côte d'Ivoire</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>SketchUp, AutoCAD, gestion de projet, connaissance des matériaux locaux,
                                            éclairage
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences d'architecture, décoration, freelance, salaire de 180 000 FCFA à 350
                                            000 FCFA
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
                                    des contraintes techniques, souvent en valorisant les textiles et motifs africains.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en stylisme, design de mode ou métiers de la mode à l'Institut
                                            Supérieur de Mode (ISM Mode) au Sénégal ou à l'Académie Internationale de
                                            Coupe (AIC) à Abidjan</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Dessin, couture, connaissance des textiles africains (wax, bogolan, kente),
                                            techniques de fabrication,
                                            logiciels de design textile</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Maisons de mode, marques de prêt-à-porter, créateur indépendant, salaire de
                                            150 000 FCFA à 300 000 FCFA</p>
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
                design et de la création en Afrique</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac général (spécialité arts) ou technique, développement d'un
                            portfolio dès le lycée dans les établissements spécialisés</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>BTS, Licence, Master en design selon la spécialité choisie dans les écoles spécialisées
                            d'Afrique francophone</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formations Complémentaires</h3>
                        <p>Spécialisation technique, formations en logiciels spécifiques, workshops, apprentissage
                            auprès d'artisans traditionnels</p>
                        <span class="timeline-date">6 mois à 1 an</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Veille créative, cours en ligne, participation à des évènements du secteur comme Africa
                            Design Days ou Design Indaba</p>
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
                        <li>BTS Design Graphique à SUP'IMAX (Dakar)</li>
                        <li>Licence en Arts Visuels à l'École des Beaux-Arts de Dakar</li>
                        <li>Master en Design à l'ESAM (Bénin)</li>
                        <li>Licence en Design Produit à l'ESP (Dakar)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-palette"></i>
                        <h3>Types de Formations</h3>
                    </div>
                    <ul>
                        <li>Écoles d'arts appliqués (ESMA, École des Beaux-Arts)</li>
                        <li>Écoles de design publiques ou privées (SUP'IMAX, CESAG)</li>
                        <li>Formations universitaires en arts (UCAD, Université Félix Houphouët-Boigny)</li>
                        <li>Formations professionnelles spécialisées (Kabakoo Academies, YUX Design Academy)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop-code"></i>
                        <h3>Formations Alternatives</h3>
                    </div>
                    <ul>
                        <li>Cours en ligne (Domestika, Udemy, LinkedIn Learning)</li>
                        <li>Bootcamps créatifs intensifs (YUX Design, LocalHost Academy)</li>
                        <li>Apprentissage auprès de maîtres artisans</li>
                        <li>Workshops et masterclasses professionnels (Africa Design Days)</li>
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
                design et de la création en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h3>Design Durable et Upcycling</h3>
                    <p>Accent croissant sur l'éco-conception, les matériaux durables et l'économie circulaire, avec une
                        forte tradition de réutilisation créative des matériaux locaux.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Fusion Tradition-Modernité</h3>
                    <p>Intégration des techniques artisanales traditionnelles avec les technologies modernes, créant une
                        esthétique africaine contemporaine unique et authentique.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Design Mobile-First</h3>
                    <p>Adaptation aux réalités africaines où le mobile est le principal outil numérique, avec des
                        interfaces spécifiquement conçues pour les utilisateurs du continent.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Design Communautaire</h3>
                    <p>Approche collaborative du design impliquant les communautés locales, valorisant les savoir-faire
                        traditionnels et répondant aux besoins spécifiques des populations africaines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière créative en Afrique ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/design-sector.js"></script>
</body>

</html>