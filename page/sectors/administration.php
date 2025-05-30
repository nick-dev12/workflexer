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
                        <h3>3,2M</h3>
                        <p>Agents publics en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-briefcase"></i>
                        <h3>+250</h3>
                        <p>Métiers différents</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-handshake"></i>
                        <h3>15%</h3>
                        <p>De l'emploi formel en Afrique francophone</p>
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
                    <button class="tab-btn" data-tab="international">Organisations Régionales</button>
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
                                        <p>Diplôme de grande école (ENA du Sénégal, ENAM du Bénin), Master en droit
                                            public ou
                                            administration (Bac+5)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse stratégique, droit public, finances publiques, management public,
                                            communication</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction, salaire progressif de 800 000 FCFA à
                                            3 000 000 FCFA+</p>
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
                                            500 000 FCFA à 1 500 000 FCFA</p>
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
                                <h3>Secrétaire Général de Collectivité</h3>
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
                                            taille de la collectivité (700 000 FCFA à 2 500 000 FCFA+)</p>
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
                                        <p>Évolution vers DRH de grandes collectivités, salaire de 600 000 FCFA à 1 800
                                            000 FCFA
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
                                        <p>Concours spécifique, formation à l'ISED (Sénégal) ou CESAG, Bac+5 requis</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion hospitalière, management médical, finances, droit de la santé,
                                            gestion de crise</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers la direction de CHU, salaire progressif de 900 000 FCFA à 2
                                            500 000 FCFA+
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
                                        <p>Évolution vers des postes de direction adjointe, salaire progressif de 600
                                            000 FCFA à 1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- International Organizations Tab -->
                    <div class="tab-pane" id="international" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-globe-africa"></i></div>
                                <h3>Administrateur à l'Union Africaine</h3>
                                <p>Élabore, met en œuvre et évalue les politiques africaines dans divers domaines.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit international, relations internationales, sciences politiques
                                            (Bac+5), concours spécifiques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Langues étrangères, droit international, négociation internationale, analyse
                                            politique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers chef d'unité, directeur, salaire attractif de 2 500 000 FCFA à
                                            5 000 000 FCFA+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-hands-helping"></i></div>
                                <h3>Spécialiste de Programme (CEDEAO/UEMOA)</h3>
                                <p>Conçoit et gère des programmes régionaux dans des domaines comme le
                                    développement, les droits humains ou l'environnement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou doctorat en relations internationales, développement ou domaine
                                            spécialisé, expérience régionale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de projet, langues étrangères, expertise thématique, compétences
                                            interculturelles</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de direction de programme, salaire de 2 000 000
                                            FCFA à 4 000 000 FCFA+</p>
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
                            <li><strong>Master Droit Public</strong> - Université Cheikh Anta Diop (Sénégal), Université
                                Félix Houphouët-Boigny (Côte d'Ivoire)</li>
                            <li><strong>Master Administration Publique</strong> - Université de Yaoundé II (Cameroun),
                                Université d'Abomey-Calavi (Bénin)</li>
                            <li><strong>Master Politiques Publiques</strong> - Université Mohammed V (Maroc), Université
                                de Lomé (Togo)</li>
                            <li><strong>Master Management Public</strong> - Université Gaston Berger (Sénégal),
                                Université de Ouagadougou (Burkina Faso)</li>
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
                            <li><strong>ENA Sénégal</strong> - Formation des hauts fonctionnaires sénégalais</li>
                            <li><strong>ENAM Bénin</strong> - École Nationale d'Administration et de Magistrature</li>
                            <li><strong>ISCAE Maroc</strong> - Institut Supérieur de Commerce et d'Administration des
                                Entreprises</li>
                            <li><strong>CESAG</strong> - Centre Africain d'Études Supérieures en Gestion (Dakar)</li>
                            <li><strong>CAFRAD</strong> - Centre Africain de Formation et de Recherche Administratives
                                pour le Développement (Maroc)</li>
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
                            <li><strong>Cycles Préparatoires</strong> - Préparation aux concours administratifs dans
                                plusieurs pays</li>
                            <li><strong>Instituts de Formation Administrative</strong> - Centres spécialisés dans la
                                préparation aux concours</li>
                            <li><strong>Concours Directs</strong> - Accessibles selon le niveau d'études (catégories A,
                                B, C)</li>
                            <li><strong>Concours Professionnels</strong> - Réservés aux agents déjà en poste</li>
                            <li><strong>Recrutements sur Titre</strong> - Pour les candidats avec qualifications
                                spécifiques</li>
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
                l'administration publique en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Transformation Numérique</h3>
                    <p>Le développement de l'e-gouvernance et la digitalisation des services publics révolutionnent
                        l'administration africaine. Des initiatives comme Smart Africa et les programmes nationaux
                        d'identité numérique créent de nouvelles opportunités professionnelles et améliorent l'accès aux
                        services pour les citoyens.</p>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>Décentralisation</h3>
                    <p>Le renforcement des collectivités locales et la décentralisation administrative créent de
                        nouveaux besoins en compétences dans la gestion territoriale. L'intelligence territoriale
                        devient un enjeu majeur pour le développement local durable et la gouvernance participative.</p>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Modernisation de la Gestion Publique</h3>
                    <p>L'adoption progressive de la gestion axée sur les résultats (GAR) et la budgétisation par
                        programme transforment les administrations africaines. Ces approches favorisent la transparence,
                        l'efficacité et la redevabilité dans la gestion des ressources publiques.</p>
                </div>

                <div class="trend-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Développement Durable</h3>
                    <p>L'intégration des Objectifs de Développement Durable (ODD) dans les politiques publiques crée de
                        nouvelles fonctions administratives liées à l'environnement, l'énergie renouvelable et la
                        résilience climatique. Les compétences en gestion de projets durables sont particulièrement
                        recherchées.</p>
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