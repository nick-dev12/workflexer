<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Ingénierie et Architecture | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Engineering sector specific styles */
        .hero-section {
            background: url('../../image/Ingénierie et Architecture.png') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(46, 204, 113, 0.2);
        }

        .education-card .card-header {
            background: linear-gradient(135deg, #2c3e50, #27ae60);
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
            <h1>Ingénierie et Architecture</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le domaine de la conception et construction
            </p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur de l'ingénierie</h2>
                <p>Le secteur de l'ingénierie et de l'architecture regroupe des professionnels qui conçoivent,
                    planifient et construisent notre environnement bâti. Des infrastructures aux bâtiments, ces métiers
                    façonnent le monde dans lequel nous vivons tout en relevant les défis techniques complexes de notre
                    époque.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-hard-hat"></i>
                        <h3>+8%</h3>
                        <p>Croissance annuelle des emplois</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-drafting-compass"></i>
                        <h3>+150</h3>
                        <p>Spécialisations disponibles</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-building"></i>
                        <h3>12%</h3>
                        <p>Du marché de l'emploi français</p>
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
                secteur de l'ingénierie</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="civil">Génie Civil</button>
                    <button class="tab-btn" data-tab="architect">Architecture</button>
                    <button class="tab-btn" data-tab="industrial">Génie Industriel</button>
                    <button class="tab-btn" data-tab="environmental">Environnement</button>
                </div>

                <div class="tab-content">
                    <!-- Civil Engineering Tab -->
                    <div class="tab-pane active" id="civil" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-bridge"></i></div>
                                <h3>Ingénieur Civil</h3>
                                <p>Conçoit et supervise la construction de routes, ponts, barrages et autres
                                    infrastructures.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'ingénieur (Bac+5) spécialisé en génie civil</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Conception technique, calculs structurels, gestion de projet, connaissance
                                            des normes</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Secteur stable avec projets d'infrastructure constants, salaire moyen de 35
                                            000€ à 70 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-users-cog"></i></div>
                                <h3>Chef de Chantier</h3>
                                <p>Coordonne et supervise les travaux sur le terrain, gérant les équipes et le planning.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, DUT ou licence pro en génie civil ou bâtiment, éventuellement formation
                                            interne</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, organisation, lecture de plans, gestion des ressources</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution possible vers conducteur de travaux, salaire moyen de 28 000€ à 45
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Architecture Tab -->
                    <div class="tab-pane" id="architect" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-pencil-ruler"></i></div>
                                <h3>Architecte</h3>
                                <p>Conçoit des bâtiments et espaces en combinant aspects techniques, fonctionnels et
                                    esthétiques.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'État d'architecte (Bac+5), HMONP pour exercer en libéral</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Créativité, dessin, modélisation 3D, connaissance technique, gestion de
                                            projet</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Exercice libéral ou salarié, secteur compétitif, salaire moyen de 30 000€ à
                                            80 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-city"></i></div>
                                <h3>Urbaniste</h3>
                                <p>Planifie et organise les espaces urbains en tenant compte des aspects sociaux,
                                    économiques et environnementaux.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en urbanisme ou aménagement du territoire (Bac+5)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Planification spatiale, connaissance des réglementations, analyse
                                            territoriale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collectivités territoriales, bureaux d'études, salaire moyen de 30 000€ à 60
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Industrial Engineering Tab -->
                    <div class="tab-pane" id="industrial" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-industry"></i></div>
                                <h3>Ingénieur de Production</h3>
                                <p>Optimise les processus industriels et supervise la fabrication des produits.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'ingénieur (Bac+5) en génie industriel ou mécanique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de production, amélioration continue, lean management</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction industrielle, salaire moyen de 40 000€
                                            à 70 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Environmental Engineering Tab -->
                    <div class="tab-pane" id="environmental" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-leaf"></i></div>
                                <h3>Ingénieur Environnement</h3>
                                <p>Développe des solutions pour limiter l'impact environnemental des activités humaines.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'ingénieur (Bac+5) spécialisé en environnement ou master spécialisé
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Évaluation environnementale, connaissances réglementaires, gestion des
                                            risques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Secteur en forte croissance, salaire moyen de 35 000€ à 65 000€</p>
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
            <p class="section-description" data-aos="fade-up">Les différentes voies pour accéder aux métiers de
                l'ingénierie</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Lycée</h3>
                        <p>Baccalauréat scientifique ou STI2D recommandé pour une bonne base en mathématiques et
                            physique</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Classes Préparatoires ou Parcours Universitaires</h3>
                        <p>CPGE scientifiques, IUT, BTS ou licence en sciences pour l'ingénieur</p>
                        <span class="timeline-date">Années 1 à 2</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>École d'Ingénieurs ou Master Spécialisé</h3>
                        <p>Formation en école d'ingénieurs ou master spécialisé selon le domaine choisi</p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation et Formation Continue</h3>
                        <p>Mastères spécialisés, MBA, formations professionnelles pour se spécialiser</p>
                        <span class="timeline-date">Années 5+</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Grandes Écoles</h3>
                    </div>
                    <ul>
                        <li>Écoles Centrales (Paris, Lyon, Nantes, etc.)</li>
                        <li>Écoles des Mines</li>
                        <li>INSA (Lyon, Toulouse, Strasbourg, etc.)</li>
                        <li>École des Ponts ParisTech</li>
                        <li>ENPC, ESTP, ENSAM</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles d'Architecture</h3>
                    </div>
                    <ul>
                        <li>Écoles Nationales Supérieures d'Architecture (ENSA)</li>
                        <li>École Spéciale d'Architecture (ESA)</li>
                        <li>INSA département Architecture</li>
                        <li>Écoles d'architecture à l'étranger (accréditations requises)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>Licences en sciences pour l'ingénieur</li>
                        <li>Masters en génie civil, génie mécanique, etc.</li>
                        <li>Masters en urbanisme et aménagement</li>
                        <li>DUT Génie Civil, BTS Bâtiment</li>
                        <li>Licences professionnelles spécialisées</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Trends -->
    <section class="trends-section">
        <div class="container">
            <h2 class="section-title light" data-aos="fade-up">Tendances du Secteur</h2>
            <p class="section-description light" data-aos="fade-up">Les évolutions majeures qui façonnent l'avenir de
                l'ingénierie et de l'architecture</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Construction Durable</h3>
                    <p>Développement de bâtiments à faible impact environnemental, utilisation de matériaux écologiques
                        et conception bioclimatique.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <h3>BIM (Building Information Modeling)</h3>
                    <p>Généralisation de la maquette numérique collaborative pour tous les projets d'envergure,
                        transformant les métiers de la construction.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3>Impression 3D et Préfabrication</h3>
                    <p>Nouvelles techniques de construction utilisant l'impression 3D et les éléments préfabriqués pour
                        plus d'efficacité et moins de déchets.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Bâtiments Intelligents</h3>
                    <p>Intégration de technologies IoT dans les constructions pour optimiser la gestion énergétique et
                        améliorer le confort des occupants.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à construire votre avenir dans l'ingénierie ?</h2>
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