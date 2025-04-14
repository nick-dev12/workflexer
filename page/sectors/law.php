<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Droit et Justice | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
    <style>
        /* Law sector specific styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1589391886645-d51941baf7fb?q=80&w=1920&h=1080&auto=format&fit=crop') center/cover no-repeat;
        }

        .trend-icon {
            background-color: rgba(142, 68, 173, 0.2);
        }

        .education-card .card-header {
            background: linear-gradient(135deg, #2c3e50, #8e44ad);
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
            <h1>Droit et Justice</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le domaine juridique</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur juridique</h2>
                <p>Le secteur du droit et de la justice regroupe des professionnels qui conseillent, représentent et
                    défendent les intérêts des individus, des entreprises et des institutions. Ces métiers essentiels au
                    fonctionnement de notre société permettent de garantir le respect des lois et l'équité du système
                    judiciaire.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-balance-scale"></i>
                        <h3>+5%</h3>
                        <p>Croissance annuelle des emplois</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-university"></i>
                        <h3>+50</h3>
                        <p>Spécialisations disponibles</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-gavel"></i>
                        <h3>70k</h3>
                        <p>Avocats en France</p>
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
                secteur juridique</p>

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
                                <p>Conseille et défend les clients devant les tribunaux dans diverses affaires
                                    juridiques.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit (Bac+5), examen d'entrée au CRFPA, 18 mois de formation, CAPA
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Argumentation, analyse juridique, rédaction, négociation, éloquence</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collaboration, association ou exercice individuel, salaire variable de 40
                                            000€ à 150 000€+</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-file-contract"></i></div>
                                <h3>Notaire</h3>
                                <p>Rédige et authentifie des actes juridiques, notamment en droit immobilier et
                                    familial.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit notarial, DSN (Diplôme Supérieur du Notariat), stage de 2 ans
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Rédaction d'actes, conseil juridique, connaissance du droit immobilier et
                                            familial</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Collaboration, association ou titularisation, revenus souvent élevés (60 000€
                                            à 200 000€+)</p>
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
                                <p>Juge qui préside les audiences et rend des décisions de justice en appliquant la loi.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit (Bac+5), concours d'entrée à l'ENM, 31 mois de formation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse juridique, rédaction, impartialité, sens de l'équité, psychologie</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers des fonctions supérieures, salaire progressif de 36 000€ à 80
                                            000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-landmark"></i></div>
                                <h3>Magistrat du Parquet</h3>
                                <p>Représente les intérêts de la société devant les tribunaux et dirige les enquêtes
                                    pénales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Identique au magistrat du siège, avec spécialisation au parquet</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Réquisitoire, gestion des enquêtes, procédure pénale, travail avec les forces
                                            de l'ordre</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers procureur, procureur général, salaire progressif de 36 000€ à
                                            80 000€</p>
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
                                <p>Conseille une entreprise sur les questions juridiques et gère les risques légaux.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit des affaires ou droit privé (Bac+5), spécialisation
                                            sectorielle appréciée</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Droit des sociétés, droit des contrats, propriété intellectuelle, conseil
                                            stratégique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution vers directeur juridique, salaire de 40 000€ à 120 000€ selon
                                            taille d'entreprise</p>
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
                                <h3>Juriste Territorial</h3>
                                <p>Assure la sécurité juridique des actes et décisions des collectivités territoriales.
                                </p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en droit public (Bac+5), concours de la fonction publique territoriale
                                        </p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Droit des collectivités, marchés publics, urbanisme, ressources humaines</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Évolution dans la hiérarchie territoriale, salaire de 30 000€ à 60 000€</p>
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
            <p class="section-description" data-aos="fade-up">Les différentes voies pour accéder aux métiers du droit
            </p>

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
                        <p>Master 1 et 2 en droit (2 ans) dans une spécialité choisie (affaires, pénal, public, etc.)
                        </p>
                        <span class="timeline-date">Années 4 à 5</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Examens et Concours Professionnels</h3>
                        <p>Selon le métier visé : CRFPA pour avocat, ENM pour magistrat, concours pour fonction publique
                        </p>
                        <span class="timeline-date">Après le Master</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formation Professionnelle</h3>
                        <p>Formation pratique en école professionnelle et/ou stage (18 mois à 3 ans selon le métier)</p>
                        <span class="timeline-date">Post-concours</span>
                    </div>
                </div>
            </div>

            <div class="education-cards" data-aos="fade-up">
                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>
                        <h3>Universités de Droit</h3>
                    </div>
                    <ul>
                        <li>Paris 1 Panthéon-Sorbonne, Paris 2 Assas</li>
                        <li>Aix-Marseille, Montpellier, Toulouse</li>
                        <li>Lyon, Bordeaux, Strasbourg</li>
                        <li>Masters spécialisés et doctorats</li>
                        <li>Doubles diplômes droit-sciences po, droit-commerce</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles Professionnelles</h3>
                    </div>
                    <ul>
                        <li>ENM (École Nationale de la Magistrature)</li>
                        <li>Écoles d'Avocats (EDA) régionales</li>
                        <li>INFN (Institut National des Formations Notariales)</li>
                        <li>ENSP (École Nationale Supérieure de Police)</li>
                        <li>ENAP (École Nationale d'Administration Pénitentiaire)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Formations Complémentaires</h3>
                    </div>
                    <ul>
                        <li>LL.M (Master of Laws) à l'étranger</li>
                        <li>Masters spécialisés en business schools</li>
                        <li>Diplômes universitaires (DU) de spécialisation</li>
                        <li>Certifications professionnelles</li>
                        <li>Formation continue obligatoire</li>
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
                droit</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Legaltech et IA Juridique</h3>
                    <p>Transformation digitale des cabinets et services juridiques, automatisation des tâches de
                        recherche et d'analyse, nouveaux métiers à l'interface droit-technologie.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Internationalisation du Droit</h3>
                    <p>Développement du droit transnational, importance croissante de l'anglais juridique, mobilité
                        internationale des juristes et avocats.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Droit de l'Environnement</h3>
                    <p>Essor du droit environnemental et de la RSE, nouvelles réglementations climatiques, contentieux
                        climatiques en forte hausse.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Protection des Données</h3>
                    <p>Renforcement des réglementations sur la vie privée et la sécurité des données, développement du
                        métier de DPO, enjeux juridiques de la cybersécurité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière juridique ?</h2>
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