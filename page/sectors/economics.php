<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Économie et Finance | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <link rel="stylesheet" href="/css/economics-sector.css">
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
            <h1>Économie et Finance</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde économique et financier africain</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur économique et financier en Afrique</h2>
                <p>Le secteur de l'économie et de la finance est au cœur du développement des entreprises, des marchés
                    et des politiques publiques en Afrique. Ces métiers, en pleine expansion sur le continent, offrent
                    de nombreuses opportunités
                    aux profils analytiques et stratégiques qui souhaitent contribuer au développement économique et
                    financier de l'Afrique francophone.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-chart-line"></i>
                        <h3>+8.5%</h3>
                        <p>Croissance annuelle des emplois financiers en Afrique de l'Ouest</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-university"></i>
                        <h3>+70</h3>
                        <p>Institutions financières majeures en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-money-bill-wave"></i>
                        <h3>12%</h3>
                        <p>Du PIB de l'UEMOA</p>
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
                secteur économique et financier en Afrique francophone</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="banking">Banque</button>
                    <button class="tab-btn" data-tab="finance">Finance d'Entreprise</button>
                    <button class="tab-btn" data-tab="markets">Marchés Financiers</button>
                    <button class="tab-btn" data-tab="economics">Économie</button>
                </div>

                <div class="tab-content">
                    <!-- Banking Tab -->
                    <div class="tab-pane active" id="banking" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-user-tie"></i></div>
                                <h3>Conseiller en Gestion de Patrimoine</h3>
                                <p>Guide les clients dans leurs investissements et la gestion optimale de leur
                                    patrimoine.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en finance, gestion de patrimoine ou banque au CESAG, UCAD ou
                                            FASEG</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Conseil financier, connaissance des produits d'investissement africains,
                                            relation
                                            client, maîtrise des réglementations UEMOA/CEMAC</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de banque privée, salaire de 400 000 FCFA à 1 200
                                            000 FCFA +
                                            commissions</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-handshake"></i></div>
                                <h3>Chargé d'Affaires Entreprises</h3>
                                <p>Accompagne les entreprises africaines dans leurs besoins financiers et leur
                                    développement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en finance, économie ou école de commerce (ISM, CESAG, INPHB)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse financière, négociation, connaissance des secteurs économiques
                                            africains, gestion de
                                            portefeuille</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Possibilité d'évolution vers des postes de direction, salaire de 500 000 FCFA
                                            à 1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Corporate Finance Tab -->
                    <div class="tab-pane" id="finance" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-calculator"></i></div>
                                <h3>Directeur Financier</h3>
                                <p>Supervise la stratégie financière d'une entreprise et optimise sa performance
                                    économique dans le contexte africain.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance ou école de commerce (CESAG, ISM, IAM), expérience
                                            significative en finance
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Stratégie financière, contrôle de gestion, comptabilité SYSCOHADA, management
                                            d'équipe
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution possible vers des postes de direction générale, salaire de 1 500
                                            000 FCFA
                                            à 5 000 000 FCFA+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chart-pie"></i></div>
                                <h3>Contrôleur de Gestion</h3>
                                <p>Analyse les performances financières de l'entreprise et propose des optimisations
                                    adaptées au marché africain.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en contrôle de gestion, finance ou comptabilité (UCAD, CESAG, ENCG)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de données, reporting, budgétisation, maîtrise du SYSCOHADA, outils
                                            informatiques financiers
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers directeur du contrôle de gestion, DAF, salaire de 600 000 FCFA
                                            à 1 200 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Markets Tab -->
                    <div class="tab-pane" id="markets" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-exchange-alt"></i></div>
                                <h3>Trader</h3>
                                <p>Achète et vend des actifs financiers sur les marchés africains et internationaux pour
                                    générer des profits.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance de marché, mathématiques financières (ESP, ENSAE Dakar, 2iE)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse technique et fondamentale, gestion du risque, connaissance des
                                            marchés africains (BRVM, NSE), réactivité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Métier sélectif, salaire très variable avec partie fixe et bonus (800 000
                                            FCFA à 10 000 000 FCFA+)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-search-dollar"></i></div>
                                <h3>Analyste Financier</h3>
                                <p>Étudie les entreprises et les marchés africains pour formuler des recommandations
                                    d'investissement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance, économie (CESAG, ISM, ENCG), certification CFA appréciée
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Modélisation financière, analyse sectorielle, valorisation d'entreprise,
                                            connaissance des marchés africains</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de gérant de portefeuille, salaire de 700 000 FCFA
                                            à 1 800 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Economics Tab -->
                    <div class="tab-pane" id="economics" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-globe-africa"></i></div>
                                <h3>Économiste</h3>
                                <p>Analyse les tendances économiques africaines et formule des prévisions et
                                    recommandations.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou Doctorat en économie, économétrie ou statistiques (UCAD, ENSEA,
                                            CERDI)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse macroéconomique, modélisation, statistiques, connaissance des
                                            économies africaines
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Postes en institutions (BCEAO, BAD, BEAC), ministères, banques, salaire de
                                            800 000 FCFA à 2 000 000 FCFA</p>
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
                l'économie et de la finance en Afrique</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Baccalauréat général avec spécialité mathématiques ou sciences économiques</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Licence en économie, gestion, finance dans les universités africaines ou classes
                            préparatoires</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation</h3>
                        <p>Master en finance, économie dans les grandes écoles africaines ou internationales</p>
                        <span class="timeline-date">Années 4 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Certifications Professionnelles</h3>
                        <p>CFA, ACCA, DESCOGEF ou autres certifications spécialisées selon le métier visé</p>
                        <span class="timeline-date">En parallèle ou post-diplôme</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Universités</h3>
                    </div>
                    <ul>
                        <li>Licences et Masters en économie à l'UCAD (Sénégal)</li>
                        <li>FASEG (Bénin, Togo, Cameroun)</li>
                        <li>Université Félix Houphouët-Boigny (Côte d'Ivoire)</li>
                        <li>Université Mohammed V (Maroc)</li>
                        <li>Doctorats en sciences économiques (NPTCI)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Grandes Écoles</h3>
                    </div>
                    <ul>
                        <li>CESAG (Centre Africain d'Études Supérieures en Gestion)</li>
                        <li>ISM (Institut Supérieur de Management)</li>
                        <li>ENSAE Dakar (École Nationale de la Statistique et de l'Analyse Économique)</li>
                        <li>ENCG (École Nationale de Commerce et de Gestion)</li>
                        <li>2iE (Institut International d'Ingénierie de l'Eau et de l'Environnement)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-certificate"></i>
                        <h3>Certifications Professionnelles</h3>
                    </div>
                    <ul>
                        <li>CFA (Chartered Financial Analyst)</li>
                        <li>DESCOGEF (Diplôme d'Expertise Comptable et de Gestion Financière)</li>
                        <li>Certification CREPMF (Conseil Régional de l'Épargne Publique et des Marchés Financiers)</li>
                        <li>ACCA (Association of Chartered Certified Accountants)</li>
                        <li>Certification OHADA (Organisation pour l'Harmonisation en Afrique du Droit des Affaires)
                        </li>
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
                l'économie et de la finance en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Finance Mobile</h3>
                    <p>Expansion rapide des services financiers mobiles, solutions de paiement innovantes et inclusion
                        financière à travers le mobile money et les fintechs africaines.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Finance Durable</h3>
                    <p>Développement de la finance climatique, investissements dans les énergies renouvelables et
                        projets agricoles durables adaptés aux défis environnementaux africains.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>Intégration Financière Régionale</h3>
                    <p>Harmonisation des marchés financiers africains, développement des bourses régionales (BRVM,
                        BVMAC) et renforcement des unions monétaires (UEMOA, CEMAC).</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Microfinance et Inclusion</h3>
                    <p>Expansion des institutions de microfinance, développement de produits financiers adaptés aux
                        populations non bancarisées et aux PME africaines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière en économie ou finance en Afrique ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/economics-sector.js"></script>
</body>

</html>