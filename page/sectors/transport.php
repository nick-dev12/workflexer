<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Transport et Logistique | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Transport sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1494522855154-9297ac14b55f?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(41, 128, 185, 0.2);
        }

        :root {
            --accent-color: #2980b9;
            /* Blue accent for transport sector */
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
            <h1>Transport et Logistique</h1>
            <p>Découvrez les opportunités, formations et perspectives dans les métiers de la chaîne logistique et du
                transport</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur logistique</h2>
                <p>Le secteur du transport et de la logistique constitue un pilier essentiel de l'économie moderne,
                    assurant la continuité des flux de marchandises et de personnes à travers les territoires. De la
                    gestion des entrepôts à l'organisation des transports multimodaux, en passant par l'optimisation des
                    chaînes d'approvisionnement, ce domaine mobilise des compétences variées et s'appuie sur des
                    technologies de pointe. En constante évolution pour répondre aux défis de la mondialisation, du
                    développement durable et de la transformation numérique, le secteur offre de nombreuses opportunités
                    de carrière et d'évolution professionnelle.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-truck-moving"></i>
                        <h3>1,8 million</h3>
                        <p>Emplois dans le transport et la logistique en France</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-industry"></i>
                        <h3>10%</h3>
                        <p>Du PIB français généré par le secteur</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-chart-line"></i>
                        <h3>+15%</h3>
                        <p>De croissance prévue pour les métiers de la supply chain d'ici 2025</p>
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
                secteur du transport et de la logistique</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="logistics">Logistique et Supply Chain</button>
                    <button class="tab-btn" data-tab="road">Transport Routier</button>
                    <button class="tab-btn" data-tab="multimodal">Transport Multimodal</button>
                    <button class="tab-btn" data-tab="planning">Planification et Exploitation</button>
                </div>

                <div class="tab-content">
                    <!-- Logistics Tab -->
                    <div class="tab-pane active" id="logistics" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-warehouse"></i></div>
                                <h3>Responsable Logistique</h3>
                                <p>Supervise l'ensemble des activités logistiques d'une entreprise, de la gestion des
                                    stocks à la distribution, en optimisant les flux et les coûts.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en logistique, supply chain ou transport</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de projet, management d'équipe, maîtrise des ERP/WMS, optimisation
                                            des flux, anglais professionnel</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de directeur supply chain, directeur des
                                            opérations, salaire de 35 000€ à 70 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-boxes"></i></div>
                                <h3>Supply Chain Manager</h3>
                                <p>Conçoit et pilote la chaîne d'approvisionnement globale, de l'achat des matières
                                    premières à la livraison au client final.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en supply chain management, école d'ingénieur ou école de commerce avec
                                            spécialisation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Vision stratégique, gestion des risques, maîtrise des systèmes d'information,
                                            connaissance des marchés internationaux</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction de la supply chain mondiale, consultant en optimisation logistique,
                                            salaire de 50 000€ à 90 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Road Transport Tab -->
                    <div class="tab-pane" id="road" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-truck"></i></div>
                                <h3>Conducteur Routier</h3>
                                <p>Assure le transport de marchandises ou de personnes par voie routière, en respectant
                                    les réglementations et les délais de livraison.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>CAP, Bac Pro Conducteur Routier, permis spécifiques (C, CE, D), FIMO et FCO
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Conduite sécuritaire, connaissances techniques, gestion des temps de
                                            conduite, relation client, autonomie</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de chef d'équipe, formateur, exploitant, salaire de
                                            22 000€ à 35 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-sitemap"></i></div>
                                <h3>Responsable de Flotte</h3>
                                <p>Gère l'ensemble des véhicules d'une entreprise, optimise leur utilisation, supervise
                                    la maintenance et assure la conformité réglementaire.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, BUT ou Licence professionnelle en transport et logistique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion budgétaire, connaissance technique des véhicules, maîtrise de la
                                            réglementation, négociation, planification</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction des opérations de transport, gestion de parc multi-sites, salaire
                                            de 35 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multimodal Transport Tab -->
                    <div class="tab-pane" id="multimodal" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-ship"></i></div>
                                <h3>Commissionnaire de Transport</h3>
                                <p>Organise et coordonne le transport de marchandises pour le compte de clients, en
                                    sélectionnant et combinant les différents modes de transport.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, BUT ou Bac+3/5 en transport international et logistique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Maîtrise de la chaîne documentaire, connaissance des incoterms, négociation,
                                            anglais professionnel, réactivité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Directeur d'agence de transit, responsable grands comptes, salaire de 30 000€
                                            à 60 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-plane"></i></div>
                                <h3>Responsable Transport International</h3>
                                <p>Définit et met en œuvre la stratégie de transport international d'une entreprise, en
                                    optimisant les coûts, délais et qualité de service.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en commerce international, logistique internationale ou école de
                                            commerce</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Connaissance des marchés internationaux, compétences juridiques, gestion des
                                            risques, maîtrise de plusieurs langues</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction logistique internationale, consultant en commerce extérieur,
                                            salaire de 45 000€ à 80 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Planning Tab -->
                    <div class="tab-pane" id="planning" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-tasks"></i></div>
                                <h3>Planificateur Transport</h3>
                                <p>Organise et optimise les tournées de livraison et les plans de chargement pour
                                    maximiser l'efficacité des opérations de transport.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+3 en transport et logistique, exploitation des transports</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Maîtrise des outils de planification (TMS), sens de l'organisation,
                                            réactivité, gestion du stress, résolution de problèmes</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Responsable d'exploitation, gestionnaire de flux, salaire de 25 000€ à 40
                                            000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chart-bar"></i></div>
                                <h3>Analyste Supply Chain</h3>
                                <p>Collecte et analyse les données opérationnelles pour identifier les points
                                    d'amélioration et optimiser les performances de la chaîne logistique.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en data science, statistiques ou logistique avec spécialisation en
                                            analyse de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de données, modélisation statistique, connaissance des processus
                                            logistiques, maîtrise des outils BI, esprit critique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Data scientist supply chain, responsable amélioration continue, salaire de 35
                                            000€ à 55 000€</p>
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
                transport et de la logistique</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>CAP, Bac Pro Logistique, Bac Pro Transport, Bac technologique STMG ou bac général</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Professionnalisantes</h3>
                        <p>BTS GTLA, BUT GLT, Licences professionnelles en logistique et transport</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Masters en logistique internationale, supply chain management, écoles d'ingénieurs ou de
                            commerce avec spécialisation</p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>FIMO/FCO pour les conducteurs, certifications professionnelles (APICS, ISCEA),
                            spécialisations en management logistique</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Techniques</h3>
                    </div>
                    <ul>
                        <li>CAP Opérateur Logistique</li>
                        <li>Bac Pro Logistique ou Transport</li>
                        <li>BTS Gestion des Transports et Logistique Associée (GTLA)</li>
                        <li>BUT Gestion Logistique et Transport (GLT)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Supérieures</h3>
                    </div>
                    <ul>
                        <li>Licence Pro Management des Processus Logistiques</li>
                        <li>Master Logistique et Transport International</li>
                        <li>Diplôme d'ingénieur en génie logistique</li>
                        <li>MBA Supply Chain Management</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Certifications Professionnelles</h3>
                    </div>
                    <ul>
                        <li>Certificats de capacité professionnelle (transport routier)</li>
                        <li>Certifications APICS (CPIM, CSCP, CLTD)</li>
                        <li>Lean Six Sigma (Green Belt, Black Belt)</li>
                        <li>Certifications spécifiques aux logiciels (SAP, Oracle SCM)</li>
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
                transport et de la logistique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Logistique Verte</h3>
                    <p>Développement de solutions de transport plus écologiques, optimisation des emballages, réduction
                        de l'empreinte carbone et économie circulaire dans les chaînes d'approvisionnement.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Automatisation et Robotisation</h3>
                    <p>Intégration de robots dans les entrepôts, véhicules autonomes, drones de livraison et systèmes
                        automatisés pour optimiser les opérations et réduire les coûts.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Supply Chain 4.0</h3>
                    <p>Utilisation de l'Internet des Objets (IoT), de l'Intelligence Artificielle et du Big Data pour
                        créer des chaînes d'approvisionnement intelligentes, connectées et prédictives.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <h3>Logistique Urbaine</h3>
                    <p>Nouveaux modèles de distribution en milieu urbain, micro-hubs logistiques, livraison du dernier
                        kilomètre écologique et solutions de mobilité innovantes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière logistique ?</h2>
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