<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Administration et Services Publics | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Administration sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(41, 128, 185, 0.2);
        }

        .education-card .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
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
            <h1>Administration et Services Publics</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le domaine de l'administration publique</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur administratif</h2>
                <p>Le secteur de l'administration et des services publics regroupe l'ensemble des métiers qui
                    contribuent au fonctionnement de l'État, des collectivités territoriales et des services publics.
                    Ces professions sont essentielles pour garantir l'accès aux services de base, mettre en œuvre les
                    politiques publiques et assurer la continuité du service public.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-building"></i>
                        <h3>5,6M</h3>
                        <p>Agents publics en France</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-briefcase"></i>
                        <h3>+300</h3>
                        <p>Métiers différents</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-handshake"></i>
                        <h3>20%</h3>
                        <p>De l'emploi total en France</p>
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
                secteur administratif</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="state">Administration d'État</button>
                    <button class="tab-btn" data-tab="territorial">Collectivités Territoriales</button>
                    <button class="tab-btn" data-tab="hospital">Fonction Publique Hospitalière</button>
                    <button class="tab-btn" data-tab="international">Organisations Internationales</button>
                </div>

                <div class="tab-content">
                    <!-- State Administration Tab -->
                    <div class="tab-pane active" id="state" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-user-tie"></i></div>
                                <h3>Administrateur Civil</h3>
                                <p>Conçoit, élabore et met en œuvre les politiques publiques au sein des ministères.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme de grande école (Sciences Po, ENA/INSP), Master en droit public ou
                                            administration (Bac+5)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse stratégique, droit public, finances publiques, management public,
                                            communication</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction, salaire progressif de 45 000€ à 120
                                            000€+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-tasks"></i></div>
                                <h3>Attaché d'Administration</h3>
                                <p>Gère et met en œuvre les politiques publiques à un niveau intermédiaire dans les
                                    services de l'État.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit, administration publique, sciences politiques (Bac+5),
                                            concours de la fonction publique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion administrative, droit public, management d'équipe, analyse de données
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers attaché principal, directeur de service, salaire progressif de
                                            30 000€ à 60 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Territorial Administration Tab -->
                    <div class="tab-pane" id="territorial" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-city"></i></div>
                                <h3>Directeur Général des Services</h3>
                                <p>Dirige l'ensemble des services d'une collectivité territoriale et met en œuvre les
                                    orientations politiques.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit public, sciences politiques ou administration territoriale
                                            (Bac+5), expérience significative</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Management stratégique, connaissances juridiques, finances locales, vision
                                            politique, gestion de projet</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des collectivités plus importantes, salaire variable selon la
                                            taille de la collectivité (60 000€ à 150 000€+)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-users"></i></div>
                                <h3>Responsable des Ressources Humaines</h3>
                                <p>Gère le personnel d'une collectivité territoriale, le recrutement et la formation.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en RH, droit social ou administration publique (Bac+5), concours
                                            territorial</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Droit de la fonction publique, gestion du personnel, recrutement, GPEEC,
                                            dialogue social</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers DRH de grandes collectivités, salaire de 35 000€ à 80 000€
                                            selon la taille</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hospital Public Service Tab -->
                    <div class="tab-pane" id="hospital" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-hospital-alt"></i></div>
                                <h3>Directeur d'Hôpital</h3>
                                <p>Assure la direction stratégique, administrative et financière d'un établissement
                                    hospitalier.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Concours de l'EHESP, formation spécifique à Rennes, Bac+5 requis</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion hospitalière, management médical, finances, droit de la santé,
                                            gestion de crise</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers la direction de CHU, salaire progressif de 45 000€ à 100 000€+
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-clipboard-list"></i></div>
                                <h3>Attaché d'Administration Hospitalière</h3>
                                <p>Gère les services administratifs d'un établissement de santé public.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en management des organisations sanitaires, droit de la santé (Bac+5),
                                            concours</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Administration hospitalière, finances, gestion des ressources humaines, droit
                                            hospitalier</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction adjointe, salaire progressif de 30
                                            000€ à 60 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- International Organizations Tab -->
                    <div class="tab-pane" id="international" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-globe-europe"></i></div>
                                <h3>Administrateur à l'Union Européenne</h3>
                                <p>Élabore, met en œuvre et évalue les politiques européennes dans divers domaines.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit européen, relations internationales, sciences politiques
                                            (Bac+5), concours EPSO</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Langues étrangères, droit européen, négociation internationale, analyse
                                            politique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers chef d'unité, directeur, salaire attractif de 50 000€ à 150
                                            000€+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-hands-helping"></i></div>
                                <h3>Spécialiste de Programme (ONU)</h3>
                                <p>Conçoit et gère des programmes internationaux dans des domaines comme le
                                    développement, les droits humains ou l'environnement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou doctorat en relations internationales, développement ou domaine
                                            spécialisé, expérience internationale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de projet, langues étrangères, expertise thématique, compétences
                                            interculturelles</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction de programme, salaire de 60 000$ à 120
                                            000$+</p>
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
    <section class="education-pathways">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Parcours de Formation</h2>
            <p class="section-description" data-aos="fade-up">Les voies éducatives pour intégrer le secteur de
                l'administration</p>

            <div class="education-grid">
                <div class="education-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Licence Administration Publique</strong> - Fondamentaux du droit public et de
                                l'administration</li>
                            <li><strong>Master Droit Public</strong> - Approfondissement des connaissances juridiques
                                administratives</li>
                            <li><strong>Master Administration Publique</strong> - Préparation spécifique aux carrières
                                administratives</li>
                            <li><strong>Master Politiques Publiques</strong> - Analyse et conception des politiques
                                publiques</li>
                            <li><strong>Master Management Public</strong> - Gestion et pilotage des organisations
                                publiques</li>
                        </ul>
                    </div>
                </div>

                <div class="education-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Grandes Écoles</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Sciences Po</strong> - Préparation privilégiée aux concours administratifs</li>
                            <li><strong>INSP (ex-ENA)</strong> - Formation des hauts fonctionnaires de l'État</li>
                            <li><strong>INET</strong> - Formation des administrateurs territoriaux</li>
                            <li><strong>EHESP</strong> - Spécialisation dans la fonction publique hospitalière</li>
                            <li><strong>ENS</strong> - Préparation à l'enseignement et la recherche en administration
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="education-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header">
                        <i class="fas fa-book"></i>
                        <h3>Concours et Préparations</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Classes Préparatoires Intégrées</strong> - Préparation aux concours pour public
                                diversifié</li>
                            <li><strong>IPAG/CPAG</strong> - Instituts spécialisés dans la préparation aux concours</li>
                            <li><strong>Concours Externes</strong> - Accessibles selon le niveau d'études (catégories A,
                                B, C)</li>
                            <li><strong>Concours Internes</strong> - Réservés aux agents déjà en poste</li>
                            <li><strong>Troisième Voie</strong> - Pour les candidats avec expérience professionnelle
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Trends -->
    <section class="industry-trends">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Tendances du Secteur</h2>
            <p class="section-description" data-aos="fade-up">Les évolutions et innovations qui transforment
                l'administration publique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Transformation Numérique</h3>
                    <p>La dématérialisation des procédures administratives et le développement de l'e-administration
                        transforment profondément les méthodes de travail et les relations avec les usagers. Les
                        compétences numériques sont désormais essentielles pour les agents publics.</p>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>Management Participatif</h3>
                    <p>L'administration évolue vers des modèles de gestion plus horizontaux et participatifs, favorisant
                        l'implication des agents, l'innovation et l'intelligence collective. Les méthodes agiles et le
                        design thinking font leur entrée dans le secteur public.</p>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Pilotage par la Performance</h3>
                    <p>Les administrations adoptent une culture du résultat avec des indicateurs de performance, des
                        évaluations régulières et une recherche d'efficience. La maîtrise des outils d'analyse de
                        données devient un atout majeur.</p>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Administration Écoresponsable</h3>
                    <p>La prise en compte des enjeux environnementaux dans les politiques publiques et le fonctionnement
                        interne des administrations crée de nouveaux métiers et compétences liés au développement
                        durable et à la transition écologique.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à explorer les opportunités dans l'administration publique?</h2>
                <p>Découvrez les formations adaptées à votre profil et lancez-vous dans une carrière au service de
                    l'intérêt général.</p>
                <div class="cta-buttons">
                    <a href="/formations.php" class="btn btn-primary">Trouver une formation</a>
                    <a href="/orientation.php" class="btn btn-secondary">Test d'orientation</a>
                </div>
            </div>
        </div>
    </section>



    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset: 120,
            once: true
        });

        // Tab functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons and panes
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                // Add active class to clicked button
                btn.classList.add('active');

                // Show corresponding pane
                const tabId = btn.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>

</html>