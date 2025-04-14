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
    <style>
        /* Economics sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(39, 174, 96, 0.2);
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
            <h1>Économie et Finance</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde économique et financier</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur économique et financier</h2>
                <p>Le secteur de l'économie et de la finance est au cœur du fonctionnement des entreprises, des marchés
                    et des politiques publiques. Ces métiers, en constante évolution, offrent de nombreuses opportunités
                    aux profils analytiques et stratégiques qui souhaitent contribuer au développement économique et
                    financier.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-chart-line"></i>
                        <h3>+7%</h3>
                        <p>Croissance annuelle des emplois</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-university"></i>
                        <h3>+100</h3>
                        <p>Institutions financières majeures</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-euro-sign"></i>
                        <h3>15%</h3>
                        <p>Du PIB français</p>
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
                secteur économique et financier</p>

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
                                        <p>Bac+3 à Bac+5 en finance, gestion de patrimoine ou banque</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Conseil financier, connaissance des produits d'investissement, relation
                                            client</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de banque privée, salaire de 35 000€ à 80 000€ +
                                            commissions</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-handshake"></i></div>
                                <h3>Chargé d'Affaires Entreprises</h3>
                                <p>Accompagne les entreprises dans leurs besoins financiers et leur développement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en finance, économie ou école de commerce</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse financière, négociation, connaissance sectorielle, gestion de
                                            portefeuille</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Possibilité d'évolution vers des postes de direction, salaire de 40 000€ à 70
                                            000€</p>
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
                                    économique.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance ou école de commerce, expérience significative en finance
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Stratégie financière, contrôle de gestion, comptabilité, management d'équipe
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution possible vers des postes de direction générale, salaire de 80 000€
                                            à 200 000€+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chart-pie"></i></div>
                                <h3>Contrôleur de Gestion</h3>
                                <p>Analyse les performances financières de l'entreprise et propose des optimisations.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en contrôle de gestion, finance ou comptabilité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de données, reporting, budgétisation, outils informatiques financiers
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers directeur du contrôle de gestion, DAF, salaire de 35 000€ à 70
                                            000€</p>
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
                                <p>Achète et vend des actifs financiers sur les marchés pour générer des profits.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance de marché, mathématiques financières ou école d'ingénieur
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse technique et fondamentale, gestion du risque, réactivité, résistance
                                            au stress</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Métier sélectif, salaire très variable avec partie fixe et bonus (50 000€ à
                                            500 000€+)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-search-dollar"></i></div>
                                <h3>Analyste Financier</h3>
                                <p>Étudie les entreprises et les marchés pour formuler des recommandations
                                    d'investissement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en finance, économie ou école de commerce, certification CFA appréciée
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Modélisation financière, analyse sectorielle, valorisation d'entreprise</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de gérant de portefeuille, salaire de 45 000€ à 90
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Economics Tab -->
                    <div class="tab-pane" id="economics" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-globe-europe"></i></div>
                                <h3>Économiste</h3>
                                <p>Analyse les tendances économiques et formule des prévisions et recommandations.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou Doctorat en économie, économétrie ou statistiques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse macroéconomique, modélisation, statistiques, rédaction de rapports
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Postes en institutions (Banque de France, BCE), ministères, banques, salaire
                                            de 40 000€ à 80 000€</p>
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
                l'économie et de la finance</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Baccalauréat général avec spécialité mathématiques recommandée</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Licence en économie, gestion, finance ou classes préparatoires économiques</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation</h3>
                        <p>Master en finance, économie, grandes écoles de commerce ou d'ingénieurs</p>
                        <span class="timeline-date">Années 4 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Certifications Professionnelles</h3>
                        <p>CFA, FRM, AMF, ACCA ou autres certifications spécialisées selon le métier visé</p>
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
                        <li>Licences et Masters en économie</li>
                        <li>Masters spécialisés en finance</li>
                        <li>IAE (Instituts d'Administration des Entreprises)</li>
                        <li>Paris-Dauphine, Paris 1 Panthéon-Sorbonne</li>
                        <li>Doctorats en sciences économiques</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Grandes Écoles</h3>
                    </div>
                    <ul>
                        <li>HEC, ESSEC, ESCP, EM Lyon, EDHEC</li>
                        <li>Sciences Po (Master Finance et Stratégie)</li>
                        <li>ENSAE Paris (École d'ingénieurs statisticiens)</li>
                        <li>École Polytechnique (filière économie)</li>
                        <li>ENS (École Normale Supérieure) Paris-Saclay</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-certificate"></i>
                        <h3>Certifications Professionnelles</h3>
                    </div>
                    <ul>
                        <li>CFA (Chartered Financial Analyst)</li>
                        <li>FRM (Financial Risk Manager)</li>
                        <li>Certification AMF (Autorité des Marchés Financiers)</li>
                        <li>CIIA (Certified International Investment Analyst)</li>
                        <li>ACCA (Association of Chartered Certified Accountants)</li>
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
                l'économie et de la finance</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Finance Digitale</h3>
                    <p>Transformation numérique des services financiers, émergence des fintechs, automatisation des
                        processus financiers et nouveaux modes de paiement.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Finance Durable</h3>
                    <p>Essor des investissements ESG (Environnement, Social, Gouvernance), finance verte et prise en
                        compte des enjeux climatiques dans les décisions financières.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>Blockchain et Cryptomonnaies</h3>
                    <p>Développement des actifs numériques, technologies blockchain dans les transactions financières et
                        émergence de la finance décentralisée (DeFi).</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Régulation et Conformité</h3>
                    <p>Renforcement du cadre réglementaire suite aux crises financières, importance croissante des
                        métiers de la conformité et de la gestion des risques.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière en économie ou finance ?</h2>
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