<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Commerce et Vente | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Commerce sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1610374792793-f016b77ca51a?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(231, 76, 60, 0.2);
        }

        :root {
            --accent-color: #e74c3c;
            /* Red accent for commerce sector */
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
            <h1>Commerce et Vente</h1>
            <p>Découvrez les opportunités, formations et perspectives dans l'univers de la vente, du marketing et du
                commerce</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur commercial</h2>
                <p>Le secteur du commerce et de la vente représente un domaine d'activité dynamique et diversifié,
                    essentiel à l'économie africaine. Des petites entreprises locales aux grands groupes panafricains,
                    ces
                    métiers constituent le moteur des échanges commerciaux et de la relation client. Ce secteur offre
                    des perspectives d'évolution rapide et permet de développer des compétences valorisées dans tous les
                    domaines professionnels : négociation, conseil, analyse, stratégie, gestion... L'évolution des
                    comportements d'achat et la transformation digitale ont profondément renouvelé ces métiers, créant
                    de nouvelles opportunités en Afrique francophone.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-chart-line"></i>
                        <h3>25%</h3>
                        <p>Du PIB en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-store"></i>
                        <h3>+2 millions</h3>
                        <p>Entreprises commerciales formelles et informelles</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>+30%</h3>
                        <p>Croissance du e-commerce africain par an</p>
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
                secteur du commerce et de la vente</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="retail">Commerce de Détail</button>
                    <button class="tab-btn" data-tab="biz">Commerce B2B</button>
                    <button class="tab-btn" data-tab="market">Marketing Commercial</button>
                    <button class="tab-btn" data-tab="ecom">E-Commerce</button>
                </div>

                <div class="tab-content">
                    <!-- Retail Tab -->
                    <div class="tab-pane active" id="retail" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-store-alt"></i></div>
                                <h3>Responsable de Magasin</h3>
                                <p>Dirige et coordonne l'activité commerciale d'un point de vente, gère les équipes et
                                    assure l'atteinte des objectifs.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en commerce, vente ou management commercial (CESAG, ISM, UCAD)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, gestion commerciale, animation d'équipe, sens du service client,
                                            analyse de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des responsabilités régionales, direction de réseau de
                                            magasins, salaire de 600 000 FCFA à 1 200 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-user-tie"></i></div>
                                <h3>Conseiller de Vente</h3>
                                <p>Accueille, conseille et accompagne les clients dans leur parcours d'achat pour
                                    répondre à leurs besoins.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>CAP Vente, Bac Pro Commerce ou BTS Management Commercial (ISTA, CFPT, ISEP)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Sens du contact, techniques de vente, connaissance produits, écoute active,
                                            persuasion</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de responsable de rayon, adjoint, manager de
                                            magasin, salaire de 150 000 FCFA à 400 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- B2B Commerce Tab -->
                    <div class="tab-pane" id="biz" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-briefcase"></i></div>
                                <h3>Commercial B2B</h3>
                                <p>Développe un portefeuille clients professionnels, négocie des contrats et entretient
                                    une relation commerciale de long terme.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS Commerce, DUT TC, Licence pro ou Master en commerce/vente (CESAG, ISM,
                                            ETICCA)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Négociation, prospection, gestion de portefeuille, connaissance sectorielle,
                                            résistance au stress</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de responsable commercial, directeur des ventes,
                                            business developer, salaire de 500 000 FCFA à 1 500 000 FCFA (fixe +
                                            variable)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chart-pie"></i></div>
                                <h3>Key Account Manager</h3>
                                <p>Gère les relations commerciales avec les clients stratégiques de l'entreprise et
                                    développe des partenariats à forte valeur ajoutée.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en école de commerce, management ou marketing (CESAG, ISM, IAM)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Négociation complexe, vision stratégique, gestion de projet, sens business,
                                            communication interpersonnelle</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction commerciale, direction de business unit, stratégie d'entreprise,
                                            salaire de 900 000 FCFA à 2 000 000 FCFA (fixe + variable)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Marketing Commercial Tab -->
                    <div class="tab-pane" id="market" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-bullhorn"></i></div>
                                <h3>Chef de Produit</h3>
                                <p>Définit et met en œuvre la stratégie marketing d'un produit ou d'une gamme, du
                                    développement à la commercialisation.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en marketing, école de commerce (CESAG, UCAD, IAM)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de marché, stratégie marketing, gestion de projet, connaissance
                                            client, créativité commerciale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Responsable marketing, directeur marketing, brand manager, salaire de 700 000
                                            FCFA
                                            à 1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-shopping-bag"></i></div>
                                <h3>Responsable Merchandising</h3>
                                <p>Optimise la présentation des produits en point de vente pour maximiser les ventes et
                                    améliorer l'expérience client.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS Commerce, Licence pro ou Master en merchandising/marketing (SUPDECO, ESP,
                                            ISM)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse des ventes, design d'espaces commerciaux, connaissance produits, sens
                                            esthétique, innovation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction merchandising, direction de catégorie, consultant retail, salaire
                                            de 500 000 FCFA à 1 000 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- E-Commerce Tab -->
                    <div class="tab-pane" id="ecom" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-laptop"></i></div>
                                <h3>Responsable E-Commerce</h3>
                                <p>Pilote l'activité et le développement d'un site marchand, définit la stratégie
                                    digitale et assure la rentabilité.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en commerce électronique, marketing digital ou école de commerce
                                            (ESMT, ISM, IAM)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de site web, acquisition de trafic, conversion, analyse de données,
                                            management de projet digital</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Directeur digital, directeur omnicanal, entrepreneur web, salaire de 800 000
                                            FCFA
                                            à 1 800 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-search-dollar"></i></div>
                                <h3>Traffic Manager</h3>
                                <p>Génère et optimise le trafic sur un site e-commerce pour maximiser les conversions et
                                    le retour sur investissement.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en marketing digital, webmarketing ou communication (ESMT,
                                            SUPDECO, ISTIC)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>SEA, SEO, réseaux sociaux, affiliation, analytics, gestion de budgets
                                            publicitaires</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Responsable acquisition, directeur marketing digital, consultant digital,
                                            salaire de 500 000 FCFA à 1 200 000 FCFA</p>
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
                commerce et de la vente</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac technologique Sciences de Gestion ou bac
                            professionnel commerce/vente dans les lycées techniques d'Afrique francophone</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Professionnalisantes</h3>
                        <p>BTS Commerce, BTS Action Commerciale, DUT Techniques de Commercialisation, Licences
                            professionnelles en commerce (CESAG, ISM, ISTA)</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Masters en marketing, commerce, management commercial dans les grandes écoles africaines
                            (CESAG, IAM, UCAD, ESP)</p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Certifications professionnelles, spécialisations sectorielles, programmes en négociation
                            offerts par les chambres de commerce africaines et centres de formation professionnelle</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Courtes</h3>
                    </div>
                    <ul>
                        <li>CAP Vente et Commerce (ONFP, CFPT)</li>
                        <li>Bac Pro Métiers du commerce et de la vente</li>
                        <li>BTS Management Commercial (CFPT, ISTA)</li>
                        <li>BTS Action Commerciale (ISEP, CFPA)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>DUT Techniques de Commercialisation (ESP, UCAD)</li>
                        <li>Licence professionnelle Commerce et Distribution (CESAG, ISM)</li>
                        <li>Master Marketing et Vente (UCAD, CESAG)</li>
                        <li>Master Commerce International ou E-business (ESMT, IAM)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Formations Complémentaires</h3>
                    </div>
                    <ul>
                        <li>Certifications en vente et négociation (Chambres de Commerce Africaines)</li>
                        <li>Programmes spécialisés en digital business (ESMT, Orange Digital Center)</li>
                        <li>Formations en techniques de vente adaptées au marché africain</li>
                        <li>MOOC et e-learning en commerce et marketing (CESAG, AUF)</li>
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
                commerce et de la vente en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Commerce Mobile</h3>
                    <p>Développement du m-commerce et des paiements mobiles (Mobile Money, Orange Money, Wave) qui
                        révolutionnent l'accès aux services commerciaux dans les zones urbaines et rurales.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Commerce Inclusif</h3>
                    <p>Intégration du secteur informel dans les écosystèmes commerciaux formels grâce aux technologies
                        numériques, permettant aux petits commerçants d'accéder à de nouveaux marchés.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h3>Commerce Panafricain</h3>
                    <p>Expansion des échanges intra-africains favorisée par la Zone de Libre-Échange Continentale
                        Africaine (ZLECAf), créant de nouvelles opportunités pour les entreprises commerciales locales.
                    </p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Commerce Innovant</h3>
                    <p>Émergence de solutions adaptées au contexte africain comme les plateformes de livraison du
                        dernier kilomètre, les marketplaces spécialisées et les modèles commerciaux hybrides entre
                        traditionnel et digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière commerciale en Afrique ?</h2>
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