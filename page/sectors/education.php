<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Éducation et Formation | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Education sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(241, 196, 15, 0.2);
        }

        :root {
            --accent-color: #f1c40f;
            /* Yellow accent for education sector */
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
            <h1>Éducation et Formation</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde de l'enseignement et du
                développement des compétences</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur éducatif</h2>
                <p>Le secteur de l'éducation et de la formation joue un rôle fondamental dans notre société en
                    transmettant les savoirs, compétences et valeurs aux générations futures. Ces métiers permettent de
                    contribuer au développement personnel et professionnel des individus à tous les âges de la vie. Que
                    ce soit dans l'enseignement primaire, secondaire, supérieur ou la formation professionnelle, ces
                    carrières offrent l'opportunité d'avoir un impact durable sur le parcours des apprenants.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-user-graduate"></i>
                        <h3>+900 000</h3>
                        <p>Professionnels de l'éducation en France</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h3>+7%</h3>
                        <p>Croissance du marché de la formation professionnelle</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-laptop"></i>
                        <h3>+120%</h3>
                        <p>Augmentation des formations en ligne depuis 2020</p>
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
                secteur de l'éducation et de la formation</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="primary">Enseignement Primaire</button>
                    <button class="tab-btn" data-tab="secondary">Enseignement Secondaire</button>
                    <button class="tab-btn" data-tab="higher">Enseignement Supérieur</button>
                    <button class="tab-btn" data-tab="professional">Formation Professionnelle</button>
                </div>

                <div class="tab-content">
                    <!-- Primary Education Tab -->
                    <div class="tab-pane active" id="primary" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-child"></i></div>
                                <h3>Professeur des Écoles</h3>
                                <p>Enseigne toutes les matières aux enfants de maternelle et d'élémentaire et participe
                                    à leur développement global.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master MEEF 1er degré, réussite au concours CRPE</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Pédagogie, polyvalence disciplinaire, gestion de classe, psychologie de
                                            l'enfant</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Écoles publiques et privées, évolution vers la direction d'école, salaire de
                                            24 000€ à 45 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-puzzle-piece"></i></div>
                                <h3>Éducateur Spécialisé</h3>
                                <p>Accompagne des enfants en situation de handicap ou en difficulté dans leur parcours
                                    scolaire et social.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'État d'Éducateur Spécialisé (DEES, Bac+3)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Écoute active, adaptation aux besoins spécifiques, travail en équipe
                                            pluridisciplinaire</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Établissements spécialisés, ULIS, services d'aide à l'inclusion, salaire de
                                            22 000€ à 38 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Education Tab -->
                    <div class="tab-pane" id="secondary" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-book"></i></div>
                                <h3>Professeur en Collège/Lycée</h3>
                                <p>Enseigne une discipline spécifique aux élèves de la 6ème à la Terminale, prépare aux
                                    examens nationaux.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master MEEF 2nd degré dans la discipline, réussite au CAPES/CAFEP ou
                                            Agrégation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Expertise disciplinaire, didactique, transmission des savoirs, évaluation,
                                            adaptation à l'adolescence</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Établissements publics et privés, évolution vers les fonctions de direction,
                                            salaire de 25 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-compass"></i></div>
                                <h3>Conseiller Principal d'Éducation</h3>
                                <p>Organise la vie scolaire, accompagne les élèves dans leur parcours et assure le lien
                                    entre l'établissement et les familles.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master MEEF Encadrement Éducatif, réussite au concours CPE</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Gestion de conflits, coordination d'équipe, connaissance du système éducatif,
                                            écoute et médiation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collèges, lycées, internats, possibilité d'évolution vers l'inspection,
                                            salaire de 26 000€ à 48 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Higher Education Tab -->
                    <div class="tab-pane" id="higher" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-microscope"></i></div>
                                <h3>Maître de Conférences</h3>
                                <p>Dispense des enseignements à l'université, conduit des travaux de recherche et
                                    participe à la vie universitaire.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat, qualification CNU, publications scientifiques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Expertise avancée dans une discipline, méthodologie de recherche, pédagogie
                                            universitaire, rédaction scientifique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Universités, grandes écoles, progression vers le statut de professeur,
                                            salaire de 30 000€ à 65 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chalkboard"></i></div>
                                <h3>Professeur en École Spécialisée</h3>
                                <p>Enseigne des disciplines spécifiques et pratiques dans les écoles professionnelles,
                                    d'art, de commerce ou d'ingénieurs.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou diplôme équivalent, expérience professionnelle significative dans
                                            le domaine enseigné</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Expertise technique, lien avec le monde professionnel, capacité à articuler
                                            théorie et pratique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Écoles de commerce, d'ingénieurs, d'art, écoles professionnelles, salaire de
                                            28 000€ à 60 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Training Tab -->
                    <div class="tab-pane" id="professional" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-briefcase"></i></div>
                                <h3>Formateur Professionnel</h3>
                                <p>Conçoit et anime des formations pour adultes dans un domaine d'expertise spécifique,
                                    en présentiel ou en ligne.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Titre professionnel Formateur Professionnel d'Adultes ou diplôme dans le
                                            domaine d'expertise + formation pédagogique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Ingénierie pédagogique, animation de groupe, expertise technique, adaptation
                                            aux publics adultes</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Organismes de formation, entreprises, indépendant, salaire de 25 000€ à 60
                                            000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-route"></i></div>
                                <h3>Conseiller en Évolution Professionnelle</h3>
                                <p>Accompagne les personnes dans leur orientation, leur reconversion ou leur
                                    développement de compétences.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en sciences de l'éducation, psychologie du travail ou
                                            ressources humaines</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Techniques d'entretien, connaissance du marché du travail, des métiers et des
                                            formations, bilan de compétences</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>France Travail, OPCO, Transition Pro, cabinets de conseil, salaire de 24 000€
                                            à 45 000€</p>
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
                l'éducation et de la formation</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac général ou technologique, avec idéalement des spécialités en sciences humaines ou dans la
                            discipline à enseigner</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Licence disciplinaire, Master MEEF ou diplôme spécialisé selon le métier visé, concours pour
                            l'enseignement public</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Pratique</h3>
                        <p>Stages en établissement, année de fonctionnaire stagiaire, formation continue aux nouvelles
                            méthodes</p>
                        <span class="timeline-date">1 à 2 ans</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Développement Professionnel</h3>
                        <p>Formation continue, spécialisation, préparation aux certifications complémentaires</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>Licence dans la discipline à enseigner</li>
                        <li>Master MEEF (Métiers de l'Enseignement, de l'Éducation et de la Formation)</li>
                        <li>Doctorat pour l'enseignement supérieur</li>
                        <li>Master en sciences de l'éducation</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-award"></i>
                        <h3>Concours et Certificats</h3>
                    </div>
                    <ul>
                        <li>CRPE (Professeur des écoles)</li>
                        <li>CAPES/CAFEP (Professeur en collège/lycée)</li>
                        <li>CAPLP (Professeur en lycée professionnel)</li>
                        <li>Agrégation (Enseignement secondaire et supérieur)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop"></i>
                        <h3>Voies Alternatives</h3>
                    </div>
                    <ul>
                        <li>Diplôme d'État d'Éducateur (DEES, DEEJE)</li>
                        <li>Titre Professionnel Formateur pour Adultes</li>
                        <li>VAE (Validation des Acquis de l'Expérience)</li>
                        <li>Contrats spécifiques pour reconversion professionnelle</li>
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
                l'éducation et de la formation</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <h3>Enseignement Hybride</h3>
                    <p>Combinaison de présentiel et distanciel, intégration des outils numériques et adaptation des
                        méthodes pédagogiques.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Neurosciences et Éducation</h3>
                    <p>Intégration des découvertes en neurosciences cognitives pour optimiser les processus
                        d'apprentissage et la mémorisation.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Inclusion et Accessibilité</h3>
                    <p>Développement de méthodes et d'outils adaptés à tous les profils d'apprenants, y compris ceux à
                        besoins spécifiques.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3>Certification des Compétences</h3>
                    <p>Évolution vers la valorisation des compétences acquises plutôt que des diplômes, avec
                        micro-certifications et badges numériques.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière éducative ?</h2>
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