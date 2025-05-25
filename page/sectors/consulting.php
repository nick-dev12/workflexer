<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Conseil et Gestion d'Entreprise | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Consulting sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(39, 174, 96, 0.2);
        }

        :root {
            --accent-color: #27ae60;
            /* Green accent for consulting sector */
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
            <h1>Conseil et Gestion d'Entreprise</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde du conseil et des stratégies
                d'entreprise</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur du conseil</h2>
                <p>Le secteur du conseil et de la gestion d'entreprise regroupe des professionnels dont la mission est
                    d'accompagner les organisations africaines dans leur développement, leur transformation et
                    l'optimisation de
                    leurs processus. Ces métiers mobilisent des compétences analytiques, relationnelles et stratégiques
                    pour résoudre des problématiques variées et répondre aux défis des entreprises en Afrique, qu'il
                    s'agisse de stratégie, d'organisation, de finances ou de ressources humaines.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-chart-pie"></i>
                        <h3>+12%</h3>
                        <p>Croissance annuelle du secteur du conseil en Afrique</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-user-tie"></i>
                        <h3>+45 000</h3>
                        <p>Professionnels du conseil en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-coins"></i>
                        <h3>+35%</h3>
                        <p>Des salaires supérieurs à la moyenne régionale</p>
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
                secteur du conseil et de la gestion d'entreprise</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="strategy">Conseil en Stratégie</button>
                    <button class="tab-btn" data-tab="management">Management</button>
                    <button class="tab-btn" data-tab="financial">Conseil Financier</button>
                    <button class="tab-btn" data-tab="hr">Ressources Humaines</button>
                </div>

                <div class="tab-content">
                    <!-- Strategy Consulting Tab -->
                    <div class="tab-pane active" id="strategy" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chess"></i></div>
                                <h3>Consultant en Stratégie</h3>
                                <p>Accompagne les dirigeants dans l'élaboration et la mise en œuvre de leur vision
                                    stratégique et de leurs objectifs de développement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en école de commerce (CESAG, ISM, IAM), ingénieur ou Master en
                                            stratégie/management</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse stratégique, business modeling, résolution de problèmes complexes,
                                            présentation client</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Cabinets de conseil africains et internationaux, départements stratégie des
                                            grands groupes,
                                            salaire de 800 000 FCFA à 3 000 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-cogs"></i></div>
                                <h3>Consultant en Organisation</h3>
                                <p>Optimise les structures, processus et méthodes de travail pour améliorer l'efficacité
                                    opérationnelle des organisations.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en management, organisation, école d'ingénieurs (2iE, ESP, ESMT) ou
                                            sciences de gestion
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Lean management, gestion du changement, modélisation de processus,
                                            facilitation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Cabinets de conseil en organisation, services internes, freelance, salaire de
                                            700 000 FCFA à 2 000 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Management Tab -->
                    <div class="tab-pane" id="management" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-tasks"></i></div>
                                <h3>Directeur Général</h3>
                                <p>Dirige et coordonne l'ensemble des activités d'une entreprise ou d'une unité
                                    d'affaires selon la stratégie définie.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en école de commerce (CESAG, IAM, UCAD), MBA ou formation équivalente
                                            avec expérience
                                            significative</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, vision stratégique, gestion d'équipe, prise de décision,
                                            négociation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Entreprises de toutes tailles, possibilité d'évolution vers la présidence,
                                            salaire de 2 000 000 FCFA à 6 000 000 FCFA+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-project-diagram"></i></div>
                                <h3>Chef de Projet</h3>
                                <p>Pilote des projets d'entreprise de A à Z en coordonnant les équipes et les ressources
                                    pour atteindre les objectifs définis.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en gestion de projet, management (ISM, SUPDECO, UCAD) ou
                                            domaine spécifique au
                                            secteur</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Méthodologies de gestion de projet, planification, budgétisation, gestion
                                            d'équipe</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Entreprises de tous secteurs, cabinets de conseil, PMO, salaire de 600 000
                                            FCFA à
                                            1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Consulting Tab -->
                    <div class="tab-pane" id="financial" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-calculator"></i></div>
                                <h3>Consultant Financier</h3>
                                <p>Conseille les entreprises sur leurs stratégies financières, fusions-acquisitions,
                                    investissements et optimisation fiscale.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance, école de commerce (CESAG, ISM) ou Master finance
                                            d'entreprise</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse financière, modélisation, évaluation d'entreprise, due diligence,
                                            réglementation OHADA</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Cabinets de conseil financier, banques d'affaires, Big Four en Afrique,
                                            salaire de 900 000 FCFA à 2 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-balance-scale"></i></div>
                                <h3>Contrôleur de Gestion</h3>
                                <p>Analyse les performances financières de l'entreprise et fournit des indicateurs et
                                    recommandations pour la prise de décision.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en contrôle de gestion, finance ou comptabilité (UCAD, CESAG,
                                            INTEC)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse budgétaire, comptabilité analytique, reporting, outils informatiques,
                                            ERP</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Entreprises de tous secteurs, direction financière, DAF, salaire de 600 000
                                            FCFA à
                                            1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HR Consulting Tab -->
                    <div class="tab-pane" id="hr" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-users-cog"></i></div>
                                <h3>Consultant RH</h3>
                                <p>Accompagne les entreprises dans leurs problématiques de ressources humaines,
                                    recrutement, formation et développement des talents.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4 à Bac+5 en ressources humaines, psychologie du travail ou management
                                            (ISM, CESAG, UCAD)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>GPEC, recrutement, assessment, droit social africain, SIRH, conduite du
                                            changement</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Cabinets de conseil RH, cabinets de recrutement, services RH, salaire de 700
                                            000 FCFA à 1 800 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-user-graduate"></i></div>
                                <h3>Responsable Formation</h3>
                                <p>Définit et met en œuvre la politique de formation de l'entreprise pour développer les
                                    compétences des collaborateurs.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en ressources humaines, ingénierie de formation ou sciences de
                                            l'éducation (FASTEF, CESAG)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Ingénierie pédagogique, gestion de budget formation, réglementation du
                                            travail UEMOA, digital
                                            learning</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Entreprises, organismes de formation, direction RH, salaire de 700 000 FCFA à
                                            1 500 000 FCFA</p>
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
                conseil et de la gestion d'entreprise</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac général (spécialités économie, mathématiques) dans les lycées d'Afrique francophone,
                            développement de compétences
                            analytiques</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Écoles de commerce africaines (CESAG, ISM, IAM), Masters en management, gestion ou conseil,
                            écoles d'ingénieurs (ESP, 2iE, INPHB) avec
                            spécialisation</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation & Expérience</h3>
                        <p>MBA africains ou internationaux, spécialisation sectorielle, certifications professionnelles,
                            stages en cabinets</p>
                        <span class="timeline-date">1 à 3 ans</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Développement des compétences techniques et soft skills, veille sectorielle, networking
                            africain et international</p>
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
                        <li>Écoles de commerce africaines (CESAG, ISM, IAM, SUPDECO)</li>
                        <li>Masters en management, stratégie ou conseil (UCAD, CESAG)</li>
                        <li>Écoles d'ingénieurs avec spécialisation management (ESP, 2iE, INPHB)</li>
                        <li>Master en finance ou ressources humaines (UCAD, CESAG, ISM)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-certificate"></i>
                        <h3>Certifications Professionnelles</h3>
                    </div>
                    <ul>
                        <li>MBA africains et internationaux (CESAG, IAM, ESCA)</li>
                        <li>Certifications en gestion de projet (PMP, Prince2)</li>
                        <li>Certifications en conseil (CMC)</li>
                        <li>Certifications UEMOA et OHADA</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop"></i>
                        <h3>Formations Alternatives</h3>
                    </div>
                    <ul>
                        <li>Executive Education africaine (AUF, CESAG Executive)</li>
                        <li>MOOC en business et management adaptés au contexte africain</li>
                        <li>Learning expeditions et business cases sur des problématiques africaines</li>
                        <li>Mentorat et coaching professionnel par des experts africains</li>
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
                conseil et de la gestion d'entreprise en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-digital-tachograph"></i>
                    </div>
                    <h3>Transformation Digitale Africaine</h3>
                    <p>Accompagnement des entreprises africaines dans leur digitalisation, intégration de solutions
                        technologiques
                        adaptées au contexte local et développement de l'économie numérique.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Développement Durable et Impact</h3>
                    <p>Conseil en stratégies durables adaptées aux défis environnementaux africains, économie circulaire
                        et
                        développement de projets à impact social positif.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3>Intégration Économique Régionale</h3>
                    <p>Accompagnement des entreprises dans le cadre de la ZLECAf, développement de stratégies
                        panafricaines
                        et optimisation des chaînes de valeur continentales.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-people-arrows"></i>
                    </div>
                    <h3>Innovation Entrepreneuriale</h3>
                    <p>Soutien aux startups africaines, développement de l'écosystème entrepreneurial et adaptation
                        des modèles d'affaires aux spécificités des marchés africains.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière en conseil et gestion d'entreprise en Afrique ?</h2>
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