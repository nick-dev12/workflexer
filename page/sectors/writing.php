<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Rédaction et Traduction | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Writing sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(52, 152, 219, 0.2);
        }

        :root {
            --accent-color: #3498db;
            /* Blue accent for writing sector */
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
            <h1>Rédaction et Traduction</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le monde des mots et de la communication
                écrite</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur de l'écrit</h2>
                <p>Le secteur de la rédaction et de la traduction englobe un vaste éventail de métiers centrés sur la
                    manipulation experte du langage. Ces professions exigent une excellente maîtrise linguistique, une
                    capacité d'adaptation aux différents contextes de communication et une sensibilité aux nuances
                    culturelles. Du journalisme à la traduction littéraire, ces métiers permettent de transmettre des
                    idées, des informations et des émotions à travers les mots.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-pen-nib"></i>
                        <h3>+14%</h3>
                        <p>Croissance du contenu numérique chaque année</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-globe"></i>
                        <h3>+7000</h3>
                        <p>Langues parlées dans le monde</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-laptop"></i>
                        <h3>65%</h3>
                        <p>Des métiers de l'écrit exercés en freelance</p>
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
                secteur de la rédaction et de la traduction</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="content">Rédaction Web</button>
                    <button class="tab-btn" data-tab="journalism">Journalisme</button>
                    <button class="tab-btn" data-tab="translation">Traduction</button>
                    <button class="tab-btn" data-tab="copywriting">Copywriting</button>
                </div>

                <div class="tab-content">
                    <!-- Content Writing Tab -->
                    <div class="tab-pane active" id="content" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-edit"></i></div>
                                <h3>Rédacteur Web</h3>
                                <p>Crée du contenu informatif et engageant pour les sites internet, blogs et réseaux
                                    sociaux.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en lettres, communication, journalisme ou marketing digital</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Rédaction SEO, CMS (WordPress), storytelling, veille informationnelle,
                                            réseaux sociaux</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences web, services marketing, freelance, salaire de 25 000€ à 45 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-newspaper"></i></div>
                                <h3>Content Manager</h3>
                                <p>Définit et supervise la stratégie de contenu d'une entreprise sur tous ses canaux de
                                    communication.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en marketing digital, communication ou journalisme</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Stratégie éditoriale, analyse de données, coordination d'équipe, SEO,
                                            planification</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Entreprises digitales, médias en ligne, e-commerce, salaire de 35 000€ à 60
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Journalism Tab -->
                    <div class="tab-pane" id="journalism" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-microphone"></i></div>
                                <h3>Journaliste</h3>
                                <p>Recherche, vérifie et rapporte l'information sous forme d'articles, reportages ou
                                    enquêtes.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en journalisme, sciences politiques ou communication</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Investigation, vérification des sources, écriture claire, déontologie,
                                            adaptabilité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Presse écrite, médias audiovisuels, pure players, salaire de 24 000€ à 60
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Translation Tab -->
                    <div class="tab-pane" id="translation" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-language"></i></div>
                                <h3>Traducteur</h3>
                                <p>Transpose des textes d'une langue à une autre en préservant leur sens, style et
                                    nuances culturelles.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en langues étrangères, traduction ou linguistique appliquée</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Bilinguisme ou plurilinguisme, maîtrise des outils TAO, spécialisation
                                            thématique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences de traduction, organisations internationales, freelance, salaire de
                                            25 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-headset"></i></div>
                                <h3>Interprète</h3>
                                <p>Traduit oralement et en temps réel des discours d'une langue à une autre lors de
                                    réunions ou conférences.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en interprétation de conférence ou traduction</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Excellente mémoire, réactivité, résistance au stress, connaissance des
                                            cultures</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Institutions européennes, ONU, événementiel international, salaire de 35 000€
                                            à 80 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Copywriting Tab -->
                    <div class="tab-pane" id="copywriting" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-ad"></i></div>
                                <h3>Copywriter</h3>
                                <p>Conçoit des textes publicitaires percutants et persuasifs pour vendre produits et
                                    services.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en communication, marketing, publicité ou lettres</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Créativité, persuasion, connaissance des techniques marketing, adaptabilité
                                            aux cibles</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Agences de publicité, services marketing, freelance, salaire de 30 000€ à 55
                                            000€</p>
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
            <p class="section-description" data-aos="fade-up">Les différentes voies pour accéder aux métiers de la
                rédaction et de la traduction</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Bac général (spécialités littéraires, langues) recommandé, développement de la pratique de
                            l'écriture</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures</h3>
                        <p>Licence, Master en lettres, langues, communication, journalisme selon le domaine visé</p>
                        <span class="timeline-date">Années 1 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation</h3>
                        <p>Formation complémentaire technique, stages professionnels, immersion linguistique</p>
                        <span class="timeline-date">6 mois à 1 an</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Continue</h3>
                        <p>Perfectionnement linguistique, veille sur les nouveaux outils, adaptation aux évolutions du
                            marché</p>
                        <span class="timeline-date">Tout au long de la carrière</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Académiques</h3>
                    </div>
                    <ul>
                        <li>Licence Lettres, Information-Communication</li>
                        <li>Master Journalisme, Communication</li>
                        <li>Master LLCER, Traduction Spécialisée</li>
                        <li>Écoles de journalisme reconnues par la profession</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-book"></i>
                        <h3>Types de Formations</h3>
                    </div>
                    <ul>
                        <li>Formations universitaires en langues et communication</li>
                        <li>Écoles spécialisées en journalisme et traduction</li>
                        <li>IUT Information-Communication</li>
                        <li>Doubles diplômes littéraires-communication</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-laptop"></i>
                        <h3>Formations Alternatives</h3>
                    </div>
                    <ul>
                        <li>MOOC et cours en ligne de rédaction web</li>
                        <li>Certifications en marketing de contenu</li>
                        <li>Formations courtes en communication digitale</li>
                        <li>Ateliers d'écriture et résidences littéraires</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Trends -->
    <section class="trends-section">
        <div class="container">
            <h2 class="section-title light" data-aos="fade-up">Tendances du Secteur</h2>
            <p class="section-description light" data-aos="fade-up">Les évolutions majeures qui façonnent l'avenir des
                métiers de l'écrit</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>IA et Rédaction</h3>
                    <p>Intégration croissante des outils d'intelligence artificielle comme assistants à la rédaction et
                        à la traduction.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3>Contenus Multiformat</h3>
                    <p>Évolution vers des compétences pluridisciplinaires intégrant texte, audio, vidéo et formats
                        interactifs.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-globe-americas"></i>
                    </div>
                    <h3>Localisation</h3>
                    <p>Adaptation des contenus aux spécificités culturelles locales pour des marchés internationaux.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Spécialisation Technique</h3>
                    <p>Demande croissante pour des rédacteurs et traducteurs spécialisés dans des domaines techniques
                        pointus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière dans le monde des mots ?</h2>
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