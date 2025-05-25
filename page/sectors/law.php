<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Droit et Justice en Afrique | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <link rel="stylesheet" href="/css/law-sector.css">
</head>

<body class="law-sector-container">
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
            <h1>Droit et Justice en Afrique</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le domaine juridique en Afrique francophone
            </p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur juridique en Afrique</h2>
                <p>Le secteur du droit et de la justice en Afrique regroupe des professionnels qui conseillent,
                    représentent et
                    défendent les intérêts des individus, des entreprises et des institutions. Ces métiers essentiels au
                    fonctionnement des sociétés africaines permettent de garantir le respect des lois, l'équité du
                    système
                    judiciaire et contribuent au développement socio-économique du continent.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-balance-scale"></i>
                        <h3>+7,5%</h3>
                        <p>Croissance annuelle des emplois juridiques en Afrique</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-university"></i>
                        <h3>+30</h3>
                        <p>Spécialisations adaptées au contexte africain</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-gavel"></i>
                        <h3>45k</h3>
                        <p>Avocats en Afrique francophone</p>
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
                secteur juridique africain</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="advocacy">Métiers du Barreau</button>
                    <button class="tab-btn" data-tab="magistracy">Magistrature</button>
                    <button class="tab-btn" data-tab="corporate">Juristes d'Entreprise</button>
                    <button class="tab-btn" data-tab="public">Fonction Publique</button>
                </div>

                <div class="tab-content">
                    <!-- Advocacy Tab -->
                    <div class="tab-pane active" id="advocacy" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-balance-scale"></i></div>
                                <h3>Avocat</h3>
                                <p>Conseille et défend les clients devant les tribunaux africains dans diverses affaires
                                    juridiques, avec une connaissance approfondie des systèmes juridiques locaux.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit (Bac+5), examen d'entrée au CAPA ou équivalent régional,
                                            formation professionnelle de 12-24 mois</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Argumentation, analyse juridique, connaissance du droit OHADA, droit
                                            coutumier, bilinguisme (français/anglais)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collaboration, association ou exercice individuel, salaire variable de 500
                                            000 FCFA à 5 000 000 FCFA selon l'expérience</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-file-contract"></i></div>
                                <h3>Notaire</h3>
                                <p>Rédige et authentifie des actes juridiques, notamment en droit immobilier et
                                    familial, avec une expertise des régimes fonciers africains.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit notarial, formation spécifique selon le pays, stage de 2-3
                                            ans</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Rédaction d'actes, conseil juridique, connaissance des régimes fonciers
                                            traditionnels et modernes</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collaboration, association ou titularisation, revenus souvent élevés (800 000
                                            FCFA à 7 000 000 FCFA)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Magistracy Tab -->
                    <div class="tab-pane" id="magistracy" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-gavel"></i></div>
                                <h3>Magistrat du Siège</h3>
                                <p>Juge qui préside les audiences et rend des décisions de justice en appliquant les
                                    lois nationales et régionales africaines.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit (Bac+5), concours d'entrée à l'ERSUMA, CFPJ ou écoles
                                            nationales, 24-36 mois de formation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse juridique, connaissance des droits traditionnels, impartialité, sens
                                            de l'équité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des fonctions supérieures, salaire progressif de 600 000 FCFA
                                            à 2 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-landmark"></i></div>
                                <h3>Magistrat du Parquet</h3>
                                <p>Représente les intérêts de la société devant les tribunaux africains et dirige les
                                    enquêtes pénales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Identique au magistrat du siège, avec spécialisation au parquet</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Réquisitoire, gestion des enquêtes, procédure pénale, travail avec les forces
                                            de l'ordre locales</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers procureur, procureur général, salaire progressif de 600 000
                                            FCFA à 2 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Corporate Tab -->
                    <div class="tab-pane" id="corporate" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-briefcase"></i></div>
                                <h3>Juriste d'Entreprise</h3>
                                <p>Conseille une entreprise sur les questions juridiques africaines et internationales,
                                    gère les risques légaux dans un contexte multiculturel.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit des affaires OHADA ou droit privé (Bac+5), spécialisation
                                            sectorielle appréciée</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Droit OHADA, droit des contrats, propriété intellectuelle, connaissance des
                                            marchés africains</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers directeur juridique, salaire de 700 000 FCFA à 4 000 000 FCFA
                                            selon taille d'entreprise</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Public Service Tab -->
                    <div class="tab-pane" id="public" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-city"></i></div>
                                <h3>Juriste de la Fonction Publique</h3>
                                <p>Assure la sécurité juridique des actes et décisions des administrations et
                                    collectivités territoriales africaines.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit public (Bac+5), concours de la fonction publique nationale
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Droit administratif africain, marchés publics, décentralisation, ressources
                                            humaines</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution dans la hiérarchie administrative, salaire de 350 000 FCFA à 1 500
                                            000 FCFA</p>
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
            <p class="section-description" data-aos="fade-up">Les différentes voies pour accéder aux métiers du droit en
                Afrique</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études de Droit</h3>
                        <p>Licence en droit (3 ans), fondamentale pour tous les métiers juridiques</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation</h3>
                        <p>Master 1 et 2 en droit (2 ans) dans une spécialité choisie (OHADA, affaires, pénal, public,
                            etc.)</p>
                        <span class="timeline-date">Années 4 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Examens et Concours Professionnels</h3>
                        <p>Selon le métier visé : CAPA pour avocat, concours de la magistrature, concours pour fonction
                            publique</p>
                        <span class="timeline-date">Après le Master</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Professionnelle</h3>
                        <p>Formation pratique en école professionnelle et/ou stage (12 mois à 3 ans selon le métier)</p>
                        <span class="timeline-date">Post-concours</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Universités de Droit en Afrique</h3>
                    </div>
                    <ul>
                        <li>Université Cheikh Anta Diop (Sénégal)</li>
                        <li>Université Félix Houphouët-Boigny (Côte d'Ivoire)</li>
                        <li>Université de Yaoundé II (Cameroun)</li>
                        <li>Université Mohammed V (Maroc)</li>
                        <li>Université d'Abomey-Calavi (Bénin)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles Professionnelles</h3>
                    </div>
                    <ul>
                        <li>CFPJ (Centre de Formation Professionnelle à la Justice) - plusieurs pays</li>
                        <li>ERSUMA (École Régionale Supérieure de la Magistrature) - OHADA</li>
                        <li>ENAM (École Nationale d'Administration et de Magistrature) - plusieurs pays</li>
                        <li>Centres de formation des barreaux nationaux</li>
                        <li>ENMSP (École Nationale de la Magistrature et des Professions Judiciaires) - Togo</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Complémentaires</h3>
                    </div>
                    <ul>
                        <li>Certificats en droit OHADA</li>
                        <li>Diplômes de l'ERSUMA (Porto-Novo, Bénin)</li>
                        <li>Formations en droit des affaires au CESAG (Dakar)</li>
                        <li>Diplômes universitaires (DU) de spécialisation</li>
                        <li>Formation continue obligatoire des barreaux africains</li>
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
                droit en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Digitalisation Juridique</h3>
                    <p>Adoption croissante des technologies numériques dans les cabinets et cours africaines,
                        développement de plateformes de justice en ligne, émergence des LegalTech adaptées au contexte
                        africain.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Harmonisation Juridique</h3>
                    <p>Renforcement du droit OHADA et autres systèmes d'intégration régionale, convergence des systèmes
                        juridiques africains, développement de jurisprudences communes.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Droit des Ressources Naturelles</h3>
                    <p>Développement du cadre juridique pour la protection des ressources naturelles africaines,
                        réglementations minières et environnementales, contentieux climatiques émergents.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Droit Coutumier et Moderne</h3>
                    <p>Intégration progressive des systèmes juridiques traditionnels dans les cadres légaux modernes,
                        reconnaissance des mécanismes alternatifs de règlement des conflits basés sur les traditions
                        africaines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière juridique en Afrique ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../../js/law-sector.js"></script>
</body>

</html>