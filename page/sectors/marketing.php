<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Marketing et Communication | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Marketing sector specific styles */
        .hero-section {
            background: url('../../image/Marketing et Communication.png') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(218, 68, 83, 0.15);
        }

        .education-card .card-header {
            background: linear-gradient(135deg, #e74c3c, #9b59b6);
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
            <h1>Marketing et Communication</h1>
            <p>Découvrez les opportunités, formations et perspectives dans l'univers créatif et stratégique</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur marketing et communication</h2>
                <p>Le secteur du marketing et de la communication regroupe l'ensemble des métiers qui conçoivent,
                    développent et mettent en œuvre des stratégies pour promouvoir produits, services et marques. Entre
                    créativité, analyse de données et connaissance fine des comportements consommateurs, ces professions
                    sont en constante réinvention.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-bullhorn"></i>
                        <h3>+12%</h3>
                        <p>Croissance du secteur digital</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-briefcase"></i>
                        <h3>+250 000</h3>
                        <p>Professionnels en France</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-globe"></i>
                        <h3>48%</h3>
                        <p>Des emplois en agence</p>
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
                secteur du marketing et de la communication</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="marketing">Marketing</button>
                    <button class="tab-btn" data-tab="communication">Communication</button>
                    <button class="tab-btn" data-tab="digital">Digital</button>
                    <button class="tab-btn" data-tab="creative">Création</button>
                </div>

                <div class="tab-content">
                    <!-- Marketing Tab -->
                    <div class="tab-pane active" id="marketing" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chart-line"></i></div>
                                <h3>Chef de Produit</h3>
                                <p>Définit la stratégie produit, de sa conception à sa commercialisation.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 école de commerce, marketing ou université spécialisée</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de marché, gestion de projet, orientation client, négociation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers Chef de Groupe, Directeur Marketing, salaire de 35 000€ à 60
                                            000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-search"></i></div>
                                <h3>Analyste Marketing</h3>
                                <p>Étudie les tendances du marché et le comportement des consommateurs.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+4/5 en marketing, statistiques ou data science</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de données, statistiques, logiciels d'analyse, reporting</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des postes de Data Marketing, Consumer Insights, salaire de 32
                                            000€ à 55 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Communication Tab -->
                    <div class="tab-pane" id="communication" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-comments"></i></div>
                                <h3>Chargé de Communication</h3>
                                <p>Conçoit et met en œuvre les actions de communication interne et externe.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en communication, relations publiques ou sciences politiques
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Rédaction, relations presse, gestion d'événements, stratégie de communication
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers Responsable Communication, Directeur de la Communication,
                                            salaire de 30 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-newspaper"></i></div>
                                <h3>Attaché de Presse</h3>
                                <p>Assure les relations avec les médias et valorise l'image de l'entreprise ou des
                                    clients.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en communication, journalisme ou relations publiques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Rédaction de communiqués, relations médias, organisation de conférences de
                                            presse, networking</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers Responsable Relations Presse, Consultant RP, salaire de 28
                                            000€ à 45 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Digital Tab -->
                    <div class="tab-pane" id="digital" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-hashtag"></i></div>
                                <h3>Community Manager</h3>
                                <p>Anime et développe la présence d'une marque sur les réseaux sociaux.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+2 à Bac+5 en marketing digital, communication ou médias sociaux</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Maîtrise des réseaux sociaux, content marketing, réactivité, créativité,
                                            veille</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers Social Media Manager, Responsable Marketing Digital, salaire
                                            de 25 000€ à 40 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-laptop-code"></i></div>
                                <h3>Growth Hacker</h3>
                                <p>Développe la croissance rapide d'une entreprise par des techniques innovantes et
                                    data-driven.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+5 en marketing digital, data science ou développement web</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse de données, SEO/SEA, A/B testing, programmation, créativité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Métier en forte demande, salaire de 35 000€ à 65 000€, évolution vers des
                                            postes stratégiques</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Creative Tab -->
                    <div class="tab-pane" id="creative" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-pencil-alt"></i></div>
                                <h3>Concepteur-Rédacteur</h3>
                                <p>Imagine et rédige les messages publicitaires et contenus de marque.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en communication, lettres, écoles de publicité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Excellent niveau rédactionnel, créativité, culture publicitaire, storytelling
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution en agence ou freelance, salaire de 28 000€ à 50 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-paint-brush"></i></div>
                                <h3>Directeur Artistique</h3>
                                <p>Conçoit l'identité visuelle des campagnes et supports de communication.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Bac+3 à Bac+5 en arts graphiques, design ou école de publicité</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Maîtrise des logiciels de création, sens esthétique, connaissance des
                                            tendances graphiques</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers Directeur de Création, salaire de 35 000€ à 70 000€ selon
                                            l'expérience</p>
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
                marketing et de la communication</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Initiale</h3>
                        <p>Baccalauréat général ou technologique (STMG recommandé)</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Supérieure</h3>
                        <p>BTS, BUT ou Licence en communication, marketing, commerce ou médias</p>
                        <span class="timeline-date">Années 1 à 3</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Spécialisation</h3>
                        <p>Master en marketing, communication, publicité ou écoles spécialisées</p>
                        <span class="timeline-date">Années 4 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Professionnalisation</h3>
                        <p>Stages, alternance, certifications professionnelles</p>
                        <span class="timeline-date">Tout au long du cursus</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Formations Courtes</h3>
                    </div>
                    <ul>
                        <li>BTS Communication</li>
                        <li>BTS NDRC (Négociation et Digitalisation de la Relation Client)</li>
                        <li>BUT Information-Communication</li>
                        <li>BUT Techniques de Commercialisation</li>
                        <li>Formations professionnelles (Bac+2/3)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Écoles Spécialisées</h3>
                    </div>
                    <ul>
                        <li>ISCOM, ISTC, SUP DE PUB (écoles de communication)</li>
                        <li>CELSA, Sciences Po (communication et médias)</li>
                        <li>ISEG, INSEEC (marketing et communication)</li>
                        <li>Écoles de commerce avec spécialisation marketing</li>
                        <li>Écoles du digital (HETIC, GOBELINS, ESD)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-certificate"></i>
                        <h3>Formations Universitaires</h3>
                    </div>
                    <ul>
                        <li>Licence Information-Communication</li>
                        <li>Licence Marketing</li>
                        <li>Master Communication des Organisations</li>
                        <li>Master Marketing et Stratégie</li>
                        <li>Master Publicité et Communication Digitale</li>
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
                marketing et de la communication</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Intelligence Artificielle</h3>
                    <p>Personnalisation avancée, chatbots intelligents, génération de contenu automatisée et analyse
                        prédictive du comportement client.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-vr-cardboard"></i>
                    </div>
                    <h3>Réalité Augmentée et Virtuelle</h3>
                    <p>Expériences immersives, showrooms virtuels, essayages numériques et marketing expérientiel
                        nouvelle génération.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-microphone-alt"></i>
                    </div>
                    <h3>Marketing Conversationnel</h3>
                    <p>Optimisation pour la recherche vocale, assistants personnels, podcasts et stratégies audio pour
                        les marques.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3>Marketing Responsable</h3>
                    <p>Communication transparente, engagement écologique, valeurs sociétales et authenticité comme
                        piliers des stratégies de marque.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière en marketing et communication ?</h2>
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