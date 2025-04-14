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
                    essentiel à l'économie. De la petite entreprise locale aux grands groupes internationaux, ces
                    métiers constituent le moteur des échanges commerciaux et de la relation client. Ce secteur offre
                    des perspectives d'évolution rapide et permet de développer des compétences valorisées dans tous les
                    domaines professionnels : négociation, conseil, analyse, stratégie, gestion... L'évolution des
                    comportements d'achat et la transformation digitale ont profondément renouvelé ces métiers, créant
                    de nouvelles opportunités.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-chart-line"></i>
                        <h3>3,5 millions</h3>
                        <p>Emplois dans le commerce en France</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-store"></i>
                        <h3>+800 000</h3>
                        <p>Entreprises commerciales</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>+12%</h3>
                        <p>Croissance du e-commerce par an</p>
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
                                        <p>Bac+2 à Bac+5 en commerce, vente ou management commercial</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, gestion commerciale, animation d'équipe, sens du service client,
                                            analyse de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des responsabilités régionales, direction de réseau de
                                            magasins, salaire de 30 000€ à 60 000€</p>
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
                                        <p>CAP Vente, Bac Pro Commerce ou BTS MCO (Management Commercial Opérationnel)
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
                                            magasin, salaire de 20 000€ à 30 000€</p>
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
                                        <p>BTS NDRC, BUT TC, Licence pro ou Master en commerce/vente</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Négociation, prospection, gestion de portefeuille, connaissance sectorielle,
                                            résistance au stress</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de responsable commercial, directeur des ventes,
                                            business developer, salaire de 30 000€ à 70 000€ (fixe + variable)</p>
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
                                        <p>Bac+4/5 en école de commerce, management ou marketing</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Négociation complexe, vision stratégique, gestion de projet, sens business,
                                            communication interpersonnelle</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction commerciale, direction de business unit, stratégie d'entreprise,
                                            salaire de 45 000€ à 90 000€ (fixe + variable)</p>
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
                                        <p>Bac+4/5 en marketing, école de commerce ou IAE</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de marché, stratégie marketing, gestion de projet, connaissance
                                            client, créativité commerciale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Responsable marketing, directeur marketing, brand manager, salaire de 35 000€
                                            à 60 000€</p>
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
                                        <p>BTS MCO, Licence pro ou Master en merchandising/marketing</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse des ventes, design d'espaces commerciaux, connaissance produits, sens
                                            esthétique, innovation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Direction merchandising, direction de catégorie, consultant retail, salaire
                                            de 30 000€ à 50 000€</p>
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
                                        <p>Bac+4/5 en commerce électronique, marketing digital ou école de commerce</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de site web, acquisition de trafic, conversion, analyse de données,
                                            management de projet digital</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Directeur digital, directeur omnicanal, entrepreneur web, salaire de 40 000€
                                            à 80 000€</p>
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
                                        <p>Bac+3 à Bac+5 en marketing digital, webmarketing ou communication</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>SEA, SEO, réseaux sociaux, affiliation, analytics, gestion de budgets
                                            publicitaires</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Responsable acquisition, directeur marketing digital, consultant digital,
                                            salaire de 30 000€ à 55 000€</p>
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
                        <p>Bac technologique STMG (Sciences et Technologies du Management et de la Gestion) ou bac
                            professionnel commerce/vente</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Professionnalisantes</h3>
                        <p>BTS MCO, BTS NDRC, BUT TC, Licences professionnelles en commerce, vente ou marketing</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Masters en marketing, commerce, management commercial, écoles de commerce, IAE</p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Certifications professionnelles, spécialisations sectorielles, programmes en négociation,
                            vente complexe, management commercial</p>
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
                        <li>CAP Équipier polyvalent du commerce</li>
                        <li>Bac Pro Métiers du commerce et de la vente</li>
                        <li>BTS MCO (Management Commercial Opérationnel)</li>
                        <li>BTS NDRC (Négociation et Digitalisation de la Relation Client)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>BUT Techniques de Commercialisation</li>
                        <li>Licence professionnelle Commerce et Distribution</li>
                        <li>Master Marketing et Vente</li>
                        <li>Master Commerce International ou E-business</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Formations Complémentaires</h3>
                    </div>
                    <ul>
                        <li>Certifications en vente et négociation (CCIP)</li>
                        <li>Programmes spécialisés en digital business</li>
                        <li>Formations en techniques de vente avancées</li>
                        <li>MOOC et e-learning en commerce et marketing</li>
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
                commerce et de la vente</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Commerce Omnicanal</h3>
                    <p>Intégration fluide entre points de vente physiques et canaux digitaux, parcours client sans
                        couture et expérience d'achat unifiée.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Commerce Intelligent</h3>
                    <p>Utilisation de l'intelligence artificielle et des données clients pour personnaliser l'offre,
                        prédire les comportements d'achat et optimiser les prix.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h3>Commerce Responsable</h3>
                    <p>Développement de la vente de produits durables, circuits courts, économie circulaire et
                        transparence sur les conditions de production.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Commerce Expérientiel</h3>
                    <p>Transformation des points de vente en lieux d'expérience, utilisation de la réalité augmentée et
                        mise en avant du conseil plutôt que de la transaction.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière commerciale ?</h2>
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