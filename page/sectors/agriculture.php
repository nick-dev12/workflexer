<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Agriculture et Agroalimentaire | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Agriculture sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(46, 204, 113, 0.2);
        }

        :root {
            --accent-color: #27ae60;
            /* Green accent for agriculture sector */
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
            <h1>Agriculture et Agroalimentaire</h1>
            <p>Découvrez les opportunités, formations et perspectives dans les métiers de la production agricole et de
                la transformation alimentaire</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur agricole et agroalimentaire</h2>
                <p>Le secteur de l'agriculture et de l'agroalimentaire constitue un pilier fondamental de l'économie
                    africaine, allant de la production des matières premières agricoles à la transformation
                    des aliments jusqu'à leur distribution. Ce domaine stratégique, à la croisée des enjeux de
                    souveraineté alimentaire, de développement durable et d'innovation technologique, offre une grande
                    diversité de métiers et de parcours professionnels. Face aux défis de la transition écologique, de
                    la sécurité alimentaire et des attentes croissantes des consommateurs, le secteur connaît de
                    profondes mutations et recherche des talents capables d'allier savoir-faire traditionnel et
                    compétences innovantes.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-tractor"></i>
                        <h3>60%</h3>
                        <p>De la population active travaille dans le secteur agricole en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-industry"></i>
                        <h3>24%</h3>
                        <p>Du PIB de l'Afrique subsaharienne</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-chart-line"></i>
                        <h3>+15%</h3>
                        <p>De croissance pour les produits agroécologiques et durables</p>
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
                secteur de l'agriculture et de l'agroalimentaire</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="production">Production Agricole</button>
                    <button class="tab-btn" data-tab="transform">Transformation Alimentaire</button>
                    <button class="tab-btn" data-tab="quality">Qualité et R&D</button>
                    <button class="tab-btn" data-tab="business">Commerce et Conseil</button>
                </div>

                <div class="tab-content">
                    <!-- Production Tab -->
                    <div class="tab-pane active" id="production" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-leaf"></i></div>
                                <h3>Agriculteur / Exploitant Agricole</h3>
                                <p>Dirige une exploitation agricole en assurant la production végétale ou animale, la
                                    gestion technique, économique et humaine de l'entreprise.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac Pro agricole, BTSA, Licence Pro ou Ingénieur agricole (ISRA, ENSA, IAV
                                            Hassan II)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Connaissances techniques agricoles, gestion d'entreprise, adaptabilité,
                                            maîtrise des outils numériques, sensibilité environnementale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Installation, reprise d'exploitation, diversification, développement de
                                            circuits courts, revenus variables selon la production</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-seedling"></i></div>
                                <h3>Technicien Agricole</h3>
                                <p>Accompagne les exploitants dans l'optimisation de leur production, propose des
                                    solutions techniques et suit les cultures ou élevages.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, Licence Pro ou DUT en agronomie, productions animales ou végétales
                                            (ISFAR, ENSA, UCAD)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Expertise technique, conseil, analyse de données, suivi de terrain,
                                            connaissances réglementaires</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de conseiller spécialisé, responsable technique,
                                            salaire de 300 000 FCFA à 700 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transformation Tab -->
                    <div class="tab-pane" id="transform" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-cogs"></i></div>
                                <h3>Responsable de Production Agroalimentaire</h3>
                                <p>Pilote les lignes de production alimentaire, optimise les processus et assure le
                                    respect des normes de qualité et de sécurité.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, DUT, Licence Pro ou Ingénieur en agroalimentaire (ESP, UCAD, 2iE)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Management d'équipe, gestion de production, maîtrise des procédés,
                                            connaissance des normes HACCP, amélioration continue</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Directeur d'usine, responsable industriel, consultant en optimisation,
                                            salaire de 700 000 FCFA à 1 500 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-cookie-bite"></i></div>
                                <h3>Artisan des Métiers de Bouche</h3>
                                <p>Transforme les produits agricoles en produits alimentaires finis, en maîtrisant des
                                    savoir-faire spécifiques et traditionnels.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>CAP, BP, BTM ou formation professionnelle (ONFP, CFPT, centres de formation
                                            professionnelle)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Techniques artisanales, créativité, gestion de production, connaissance des
                                            matières premières, relation client</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Création ou reprise d'entreprise, développement de produits, formation,
                                            salaire de 200 000 FCFA à 800 000 FCFA (variable pour les indépendants)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quality & R&D Tab -->
                    <div class="tab-pane" id="quality" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-microscope"></i></div>
                                <h3>Ingénieur R&D Agroalimentaire</h3>
                                <p>Conçoit et développe de nouveaux produits alimentaires, améliore les formulations
                                    existantes et innove en matière de procédés.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou diplôme d'ingénieur en agroalimentaire (ESP, IAV Hassan II, INPHB)
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Innovation, formulation, analyse sensorielle, connaissance des ingrédients,
                                            gestion de projet, veille technologique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Responsable R&D, chef de projet innovation, direction scientifique, salaire
                                            de 800 000 FCFA à 1 800 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-clipboard-check"></i></div>
                                <h3>Responsable Qualité</h3>
                                <p>Assure la conformité des produits aux normes sanitaires et réglementaires, met en
                                    place et suit les systèmes de management de la qualité.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Licence Pro à Master en qualité agroalimentaire (UCAD, CESAG, ESP)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Maîtrise des normes (ISO, UEMOA, CEDEAO), audit, analyse des risques,
                                            réglementation alimentaire, gestion documentaire</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Directeur qualité, auditeur, consultant en sécurité alimentaire, salaire de
                                            600 000 FCFA à 1 200 000 FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Tab -->
                    <div class="tab-pane" id="business" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-handshake"></i></div>
                                <h3>Conseiller Agricole</h3>
                                <p>Accompagne les exploitants dans leur développement technique, économique ou
                                    environnemental, en proposant des solutions adaptées.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, Licence Pro ou diplôme d'ingénieur agricole (ISRA, ANCAR, ENSA)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Expertise agricole, relation client, pédagogie, analyse technico-économique,
                                            connaissances réglementaires</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Consultant spécialisé, responsable de service, formateur, salaire de 400 000
                                            FCFA
                                            à 900 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-globe"></i></div>
                                <h3>Responsable Commercial Agroalimentaire</h3>
                                <p>Développe les ventes de produits agricoles ou alimentaires, gère les relations avec
                                    la distribution et élabore les stratégies commerciales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, DUT, Licence ou Master commerce (CESAG, ISM, SUPDECO)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Négociation, connaissance des marchés agricoles/alimentaires, gestion de
                                            portefeuille, anglais, stratégie commerciale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Directeur commercial, responsable grands comptes, export manager, salaire de
                                            700 000 FCFA à 1 800 000 FCFA (fixe + variable)</p>
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
                l'agriculture et de l'agroalimentaire</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>CAP agricole, Bac Pro agricole, Bac technologique Sciences Agronomiques</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Professionnalisantes</h3>
                        <p>BTS, DUT, Licences professionnelles spécialisées en agriculture, agroalimentaire ou
                            environnement (ISFAR, ENSA, UCAD, ESP)</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Masters spécialisés, écoles d'ingénieurs agronomes ou agroalimentaires (IAV Hassan II, ENSA,
                            INPHB, 2iE)
                        </p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Certificats de spécialisation, formations pour l'installation agricole, certifications
                            en agroécologie et agriculture durable (ANCAR, ISRA, centres de formation)</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Agricoles</h3>
                    </div>
                    <ul>
                        <li>Bac Pro Conduite et Gestion de l'Entreprise Agricole</li>
                        <li>BTS Productions Animales ou Végétales (ISFAR)</li>
                        <li>Licence Pro Analyse et Conduite des Systèmes d'Exploitation (UCAD)</li>
                        <li>Diplôme d'ingénieur agronome (ENSA, IAV Hassan II)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Agroalimentaires</h3>
                    </div>
                    <ul>
                        <li>BTS Qualité dans les Industries Agroalimentaires</li>
                        <li>DUT Génie Biologique option industries alimentaires (ESP)</li>
                        <li>Licence Pro Industries Agroalimentaires (UCAD)</li>
                        <li>Master Innovation en Industries Alimentaires (INPHB, ESP)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Formations Complémentaires</h3>
                    </div>
                    <ul>
                        <li>Certificat de Spécialisation en Agroécologie (ISRA)</li>
                        <li>Formation à l'entrepreneuriat agricole (ANIDA, ADEPME)</li>
                        <li>Certifications en agriculture durable et permaculture</li>
                        <li>Formations en transformation des produits locaux (ONFP, CFPT)</li>
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
                l'agriculture et de l'agroalimentaire en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3>Agriculture Résiliente</h3>
                    <p>Développement de l'agroécologie, de l'agriculture intelligente face au climat, et des
                        techniques agricoles adaptées aux conditions sahéliennes pour lutter contre la désertification.
                    </p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3>Agriculture Numérique</h3>
                    <p>Utilisation des technologies mobiles, systèmes d'information géographique et solutions adaptées
                        aux petits producteurs pour améliorer les rendements et l'accès aux marchés.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-carrot"></i>
                    </div>
                    <h3>Souveraineté Alimentaire</h3>
                    <p>Valorisation des cultures vivrières locales, développement des chaînes de valeur inclusives et
                        promotion des produits à haute valeur nutritionnelle adaptés aux besoins locaux.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3>Intégration Régionale</h3>
                    <p>Renforcement des échanges commerciaux intra-africains, développement des plateformes numériques
                        connectant producteurs et marchés, et harmonisation des normes au sein de la CEDEAO et de
                        l'UEMOA.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière agricole ou agroalimentaire en Afrique ?</h2>
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