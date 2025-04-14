<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Tourisme et Hôtellerie | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Tourism sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(26, 188, 156, 0.2);
        }

        :root {
            --accent-color: #1abc9c;
            /* Turquoise accent for tourism sector */
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
            <h1>Tourisme et Hôtellerie</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde de l'accueil, du voyage et de
                l'expérience client</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur touristique</h2>
                <p>Le secteur du tourisme et de l'hôtellerie est un pilier majeur de l'économie mondiale, offrant une
                    multitude d'opportunités professionnelles variées. Ces métiers permettent de créer des expériences
                    mémorables pour les voyageurs, de promouvoir les richesses culturelles et naturelles d'un
                    territoire, et de développer des compétences transversales précieuses dans un environnement
                    international. Du luxe à l'écotourisme, de la restauration gastronomique à l'événementiel, ce
                    domaine en constante évolution s'adapte aux nouvelles attentes des clients et aux enjeux
                    contemporains.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-globe-americas"></i>
                        <h3>+10%</h3>
                        <p>Du PIB mondial généré par le tourisme</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-users"></i>
                        <h3>+1,5 million</h3>
                        <p>Emplois en France dans le secteur touristique</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+200</h3>
                        <p>Formations spécialisées dans l'hôtellerie et le tourisme</p>
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
                secteur du tourisme et de l'hôtellerie</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="hotel">Hôtellerie</button>
                    <button class="tab-btn" data-tab="resto">Restauration</button>
                    <button class="tab-btn" data-tab="tour">Tourisme</button>
                    <button class="tab-btn" data-tab="event">Événementiel</button>
                </div>

                <div class="tab-content">
                    <!-- Hotel Management Tab -->
                    <div class="tab-pane active" id="hotel" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-hotel"></i></div>
                                <h3>Directeur d'Hôtel</h3>
                                <p>Supervise l'ensemble des opérations d'un établissement hôtelier et définit sa
                                    stratégie commerciale et financière.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en management hôtelier ou école hôtelière</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, gestion d'équipe, compétences financières, relation client,
                                            multilinguisme</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Hôtels indépendants ou chaînes hôtelières, progression vers la direction
                                            régionale, salaire de 45 000€ à 120 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-concierge-bell"></i></div>
                                <h3>Responsable Hébergement</h3>
                                <p>Coordonne les services liés à l'accueil et à l'hébergement des clients, supervise les
                                    équipes de réception et d'étages.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>BTS, BUT ou Licence professionnelle en hôtellerie-restauration</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion opérationnelle, sens du service, organisation, langues étrangères,
                                            résolution de problèmes</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Établissements hôteliers de toutes catégories, évolution vers la direction
                                            d'hôtel, salaire de 30 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Restaurant Management Tab -->
                    <div class="tab-pane" id="resto" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-utensils"></i></div>
                                <h3>Chef de Cuisine</h3>
                                <p>Dirige la brigade de cuisine, élabore les menus, supervise la préparation des plats
                                    et gère les approvisionnements.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>CAP, BP, BTS en cuisine ou formation en école hôtelière</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Techniques culinaires, créativité, gestion de la production, management
                                            d'équipe, hygiène et sécurité alimentaire</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Restaurants gastronomiques, hôtels, restauration collective, entrepreneuriat,
                                            salaire de 35 000€ à 80 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-glass-cheers"></i></div>
                                <h3>Maître d'Hôtel</h3>
                                <p>Accueille les clients, supervise le service en salle, coordonne le travail des
                                    serveurs et veille à la satisfaction des clients.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac professionnel, BTS ou Mention Complémentaire en service en restauration
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Techniques de service, relationnel client, oenologie, management d'équipe,
                                            langues étrangères</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Restaurants de tous niveaux, établissements hôteliers, salaire de 25 000€ à
                                            45 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tourism Tab -->
                    <div class="tab-pane" id="tour" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-route"></i></div>
                                <h3>Chef de Produit Touristique</h3>
                                <p>Conçoit, développe et commercialise des voyages et séjours touristiques pour
                                    différentes destinations.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en tourisme, commerce ou marketing touristique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Connaissance des destinations, négociation, marketing, gestion de projet,
                                            langues étrangères</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Tour-opérateurs, agences de voyages, offices de tourisme, salaire de 28 000€
                                            à 45 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-map-marked-alt"></i></div>
                                <h3>Guide-Conférencier</h3>
                                <p>Accompagne et informe des groupes de visiteurs lors de circuits touristiques, visites
                                    de sites ou de monuments.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Licence professionnelle ou Master en guide-conférencier, carte
                                            professionnelle nationale</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Culture générale, histoire de l'art, techniques de guidage, langues
                                            étrangères, pédagogie</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Offices de tourisme, musées, sites touristiques, freelance, salaire variable
                                            selon l'activité, en moyenne 25 000€ à 35 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Management Tab -->
                    <div class="tab-pane" id="event" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-calendar-check"></i></div>
                                <h3>Responsable MICE</h3>
                                <p>Organise et commercialise des événements professionnels (séminaires, congrès,
                                    incentives) dans des établissements hôteliers.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en événementiel, tourisme d'affaires ou hôtellerie</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Organisation événementielle, négociation commerciale, connaissance du secteur
                                            MICE, gestion de projet</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Hôtels haut de gamme, centres de congrès, agences événementielles, salaire de
                                            35 000€ à 60 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-user-tie"></i></div>
                                <h3>Wedding Planner</h3>
                                <p>Conçoit et organise des mariages et cérémonies pour des particuliers, de la
                                    planification à la coordination le jour J.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Formation en événementiel, certification spécifique en wedding planning ou
                                            reconversion</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Organisation, créativité, gestion du stress, négociation, sens relationnel,
                                            réactivité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences spécialisées, établissements hôteliers, indépendant, salaire de 25
                                            000€ à 50 000€ (variable selon l'activité)</p>
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
                tourisme et de l'hôtellerie</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac technologique STHR (Sciences et Technologies de l'Hôtellerie et de la Restauration) ou
                            bac général</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Professionnalisantes</h3>
                        <p>BTS Tourisme, BTS MHR, BUT TC, Licences professionnelles en hôtellerie-tourisme selon la
                            spécialisation</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Masters en management du tourisme, écoles de commerce avec spécialisation hôtelière, MBA
                            spécialisés</p>
                        <span class="timeline-date">Années 3 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Certifications complémentaires, langues étrangères, spécialisations en fonction de
                            l'évolution du secteur</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Académiques</h3>
                    </div>
                    <ul>
                        <li>BTS Tourisme ou Management en Hôtellerie-Restauration</li>
                        <li>Licence professionnelle Hôtellerie-Tourisme</li>
                        <li>Master en Management du Tourisme</li>
                        <li>MBA spécialisé en Hospitality Management</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Écoles Spécialisées</h3>
                    </div>
                    <ul>
                        <li>Écoles hôtelières françaises et internationales</li>
                        <li>IAE avec spécialisation tourisme</li>
                        <li>Écoles de commerce avec filière hospitality</li>
                        <li>Instituts de formation en arts culinaires</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Formations Professionnalisantes</h3>
                    </div>
                    <ul>
                        <li>Certifications professionnelles (RNCP)</li>
                        <li>Certifications en sommellerie, œnologie</li>
                        <li>Programmes de formation continue proposés par les groupes hôteliers</li>
                        <li>VAE (Validation des Acquis de l'Expérience)</li>
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
                tourisme et de l'hôtellerie</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Tourisme Durable</h3>
                    <p>Développement d'offres éco-responsables, réduction de l'empreinte carbone, valorisation des
                        initiatives locales et préservation des patrimoines.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-vr-cardboard"></i>
                    </div>
                    <h3>Expériences Immersives</h3>
                    <p>Personnalisation de l'expérience client, développement de la réalité virtuelle et augmentée,
                        tourisme expérientiel et émotionnel.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Technologies Hôtelières</h3>
                    <p>Digitalisation des services, intelligence artificielle dans la relation client, automatisation,
                        smart hotels et nouveaux modes de réservation.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Nouveaux Formats d'Hébergement</h3>
                    <p>Essor des hébergements alternatifs, concept hôtels, workation (travail et vacances), glamping et
                        solutions hybrides adaptées aux nouvelles clientèles.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière touristique ?</h2>
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