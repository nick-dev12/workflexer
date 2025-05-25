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
    <link rel="stylesheet" href="/css/engineering-sector.css">
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
                en Afrique francophone
            </p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur de l'ingénierie en Afrique</h2>
                <p>Le secteur de l'ingénierie et de l'architecture en Afrique francophone connaît une croissance
                    remarquable, avec des professionnels qui conçoivent,
                    planifient et construisent l'environnement bâti adapté aux réalités africaines. Des infrastructures
                    aux bâtiments, ces métiers
                    façonnent le développement du continent tout en relevant les défis techniques spécifiques aux
                    contextes locaux, climatiques et socio-économiques.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-hard-hat"></i>
                        <h3>+11%</h3>
                        <p>Croissance annuelle des emplois en Afrique de l'Ouest</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-drafting-compass"></i>
                        <h3>+85</h3>
                        <p>Spécialisations adaptées au contexte africain</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-building"></i>
                        <h3>15%</h3>
                        <p>Du marché de l'emploi en Afrique francophone</p>
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
                secteur de l'ingénierie en Afrique francophone</p>

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
                                    infrastructures adaptées au contexte africain.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'ingénieur (Bac+5) spécialisé en génie civil des écoles africaines
                                            (2iE, ESTP Yamoussoukro, ESP Dakar)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Conception technique adaptée aux conditions locales, calculs structurels,
                                            gestion de projet, connaissance
                                            des normes africaines (UEMOA, CEMAC)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Secteur en pleine expansion avec grands projets d'infrastructure, salaire
                                            moyen de 400 000 FCFA à 1 200 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-users-cog"></i></div>
                                <h3>Chef de Chantier</h3>
                                <p>Coordonne et supervise les travaux sur le terrain, gérant les équipes locales et le
                                    planning dans le contexte africain.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, DUT ou licence pro en génie civil ou bâtiment des établissements
                                            africains (CFPT Sénégal, LBTP Côte d'Ivoire)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership adapté au contexte multiculturel, organisation, lecture de plans,
                                            gestion des ressources locales</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution possible vers conducteur de travaux, salaire moyen de 300 000 FCFA
                                            à 600 000 FCFA</p>
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
                                <p>Conçoit des bâtiments et espaces adaptés au climat et à la culture africaine,
                                    combinant aspects techniques, fonctionnels et
                                    esthétiques traditionnels et modernes.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'architecte (Bac+5) des écoles africaines (EAMAU Lomé, EAC Lomé,
                                            ESIAU Bamako)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Créativité intégrant les éléments culturels africains, dessin, modélisation
                                            3D, connaissance des matériaux locaux, gestion de projet</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Exercice libéral ou salarié, secteur en développement, salaire moyen de 350
                                            000 FCFA à 1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-city"></i></div>
                                <h3>Urbaniste</h3>
                                <p>Planifie et organise les espaces urbains africains en tenant compte des aspects
                                    sociaux, culturels,
                                    économiques et environnementaux spécifiques.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en urbanisme ou aménagement du territoire (EAMAU Lomé, ISAU Kinshasa,
                                            INAU Rabat)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Planification spatiale adaptée aux villes africaines, connaissance des
                                            réglementations locales, analyse
                                            territoriale et socioculturelle</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collectivités territoriales, bureaux d'études, ONG, salaire moyen de 350 000
                                            FCFA à 900 000 FCFA</p>
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
                                <p>Optimise les processus industriels et supervise la fabrication des produits dans le
                                    contexte des industries africaines émergentes.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'ingénieur (Bac+5) en génie industriel ou mécanique (INP-HB, ESP
                                            Dakar, Polytechnique Thiès)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de production adaptée aux réalités africaines, amélioration continue,
                                            management interculturel</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction industrielle, salaire moyen de 450 000
                                            FCFA à 1 000 000 FCFA</p>
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
                                <p>Développe des solutions pour limiter l'impact environnemental des activités humaines
                                    dans le contexte des défis écologiques africains.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'ingénieur (Bac+5) spécialisé en environnement (2iE Ouagadougou,
                                            UCAD, INPHB)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Évaluation environnementale adaptée aux écosystèmes africains, connaissances
                                            des réglementations régionales, gestion des
                                            risques climatiques spécifiques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Secteur prioritaire pour le développement durable africain, salaire moyen de
                                            400 000 FCFA à 950 000 FCFA</p>
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
                l'ingénierie en Afrique francophone</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Lycée</h3>
                        <p>Baccalauréat scientifique ou technique recommandé pour une bonne base en mathématiques et
                            physique</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Classes Préparatoires ou Parcours Universitaires</h3>
                        <p>CPGE scientifiques africaines, DUT, BTS ou licence en sciences pour l'ingénieur dans les
                            universités africaines</p>
                        <span class="timeline-date">Années 1 à 2</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>École d'Ingénieurs ou Master Spécialisé</h3>
                        <p>Formation en école d'ingénieurs africaine ou master spécialisé selon le domaine choisi</p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation et Formation Continue</h3>
                        <p>Mastères spécialisés, formations professionnelles adaptées aux besoins du marché africain</p>
                        <span class="timeline-date">Années 5+</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Grandes Écoles Africaines</h3>
                    </div>
                    <ul>
                        <li>Institut International d'Ingénierie de l'Eau et de l'Environnement (2iE) - Burkina Faso</li>
                        <li>École Supérieure Polytechnique (ESP) de Dakar - Sénégal</li>
                        <li>Institut National Polytechnique Houphouët-Boigny (INPHB) - Côte d'Ivoire</li>
                        <li>École Polytechnique de Thiès - Sénégal</li>
                        <li>École Nationale Supérieure des Travaux Publics (ENSTP) - Cameroun</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles d'Architecture Africaines</h3>
                    </div>
                    <ul>
                        <li>École Africaine des Métiers de l'Architecture et de l'Urbanisme (EAMAU) - Togo</li>
                        <li>École d'Architecture de Casablanca (EAC) - Maroc</li>
                        <li>École Supérieure d'Ingénierie, d'Architecture et d'Urbanisme (ESIAU) - Mali</li>
                        <li>Institut d'Architecture et d'Urbanisme (IAU) - Algérie</li>
                        <li>Département Architecture de l'INPHB - Côte d'Ivoire</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>Licences en sciences pour l'ingénieur (UCAD, UGB, UAC, UFHB)</li>
                        <li>Masters en génie civil, génie mécanique des universités africaines</li>
                        <li>Masters en urbanisme et aménagement (EAMAU, ISAU)</li>
                        <li>DUT Génie Civil, BTS Bâtiment des instituts techniques africains</li>
                        <li>Licences professionnelles spécialisées adaptées aux besoins locaux</li>
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
                l'ingénierie et de l'architecture en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Construction Durable Adaptée</h3>
                    <p>Développement de bâtiments utilisant des matériaux locaux écologiques, techniques traditionnelles
                        améliorées et conception bioclimatique adaptée au climat africain.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-solar-panel"></i>
                    </div>
                    <h3>Solutions Énergétiques Autonomes</h3>
                    <p>Intégration de systèmes solaires et autres énergies renouvelables dans les constructions pour
                        pallier les défis d'accès à l'électricité dans de nombreuses régions.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Ingénierie Communautaire</h3>
                    <p>Approches participatives impliquant les communautés locales dans la conception et réalisation des
                        projets d'infrastructure pour assurer leur durabilité et appropriation.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h3>Gestion Durable de l'Eau</h3>
                    <p>Solutions innovantes pour la collecte, le traitement et la distribution de l'eau adaptées aux
                        contraintes climatiques et d'urbanisation rapide en Afrique.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à construire l'avenir de l'Afrique dans l'ingénierie ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/engineering-sector.js"></script>
</body>

</html>