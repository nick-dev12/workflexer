<?php
// Démarre la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secteur Santé et Médecine | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/sectors.css">
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
            <h1>Santé et Médecine</h1>
            <p>Découvrez les opportunités, formations et perspectives dans le domaine médical</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur de la santé</h2>
                <p>Le secteur de la santé est un domaine vital qui offre des carrières diversifiées dédiées au bien-être
                    et aux soins des individus. Ce secteur en croissance constante propose de nombreuses opportunités
                    professionnelles allant des soins directs aux patients à la recherche médicale de pointe.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-user-md"></i>
                        <h3>+10%</h3>
                        <p>Croissance annuelle des emplois</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+300</h3>
                        <p>Formations disponibles</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-hospital"></i>
                        <h3>25%</h3>
                        <p>Du marché de l'emploi</p>
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
                secteur de la santé</p>

            <div class="career-tabs">
                <div class="tabs-navigation" data-aos="fade-up">
                    <button class="tab-btn active" data-tab="clinical">Pratique Clinique</button>
                    <button class="tab-btn" data-tab="research">Recherche Médicale</button>
                    <button class="tab-btn" data-tab="admin">Administration</button>
                    <button class="tab-btn" data-tab="public">Santé Publique</button>
                </div>

                <div class="tab-content">
                    <!-- Clinical Practice Tab -->
                    <div class="tab-pane active" id="clinical" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-stethoscope"></i></div>
                                <h3>Médecin</h3>
                                <p>Diagnostique et traite les maladies, prescrit des médicaments et fournit des soins
                                    médicaux complets.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat en médecine (6-10 ans), spécialisation (3-5 ans supplémentaires
                                            selon la spécialité)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Diagnostic, analyse, empathie, communication, prise de décision</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Excellentes opportunités d'emploi, salaire moyen de 60 000€ à 150 000€ selon
                                            spécialité</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-heartbeat"></i></div>
                                <h3>Infirmier/Infirmière</h3>
                                <p>Fournit des soins directs aux patients, administre des médicaments et travaille en
                                    collaboration avec les médecins.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'État d'Infirmier (3 ans), possibilité de spécialisation</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Soins aux patients, organisation, observation, communication, travail
                                            d'équipe</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Haute demande, évolution possible vers des postes spécialisés, salaire moyen
                                            de 25 000€ à 45 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-tooth"></i></div>
                                <h3>Dentiste</h3>
                                <p>Spécialiste de la santé bucco-dentaire, diagnostique et traite les problèmes
                                    dentaires.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'État de Docteur en Chirurgie Dentaire (6 ans)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Précision, dextérité manuelle, diagnostic, relation patient</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Possibilité d'exercice libéral ou en tant que salarié, salaire moyen de 50
                                            000€ à 100 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Tab -->
                    <div class="tab-pane" id="research" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-microscope"></i></div>
                                <h3>Chercheur Médical</h3>
                                <p>Conduit des recherches pour développer de nouveaux traitements, médicaments et
                                    technologies médicales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat en sciences ou médecine (8-10 ans), post-doctorat recommandé</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse scientifique, méthodologie de recherche, rédaction scientifique</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Postes en laboratoires publics ou privés, instituts de recherche, salaire
                                            moyen de 35 000€ à 70 000€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-pills"></i></div>
                                <h3>Pharmacologue</h3>
                                <p>Étudie les effets des médicaments sur les organismes vivants et développe de nouveaux
                                    traitements.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat en pharmacologie ou sciences pharmaceutiques (5-8 ans)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Connaissances en biochimie, expérimentation, analyse de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Industrie pharmaceutique, laboratoires de recherche, salaire moyen de 40 000€
                                            à 80 000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Administration Tab -->
                    <div class="tab-pane" id="admin" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-hospital-user"></i></div>
                                <h3>Directeur d'Établissement de Santé</h3>
                                <p>Gère les opérations quotidiennes d'un établissement médical et supervise le
                                    personnel.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en gestion de la santé, École des Hautes Études en Santé Publique
                                            (EHESP)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, gestion, connaissance du système de santé, finances</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Postes dans les hôpitaux publics et privés, salaire moyen de 50 000€ à 120
                                            000€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Public Health Tab -->
                    <div class="tab-pane" id="public" data-aos="fade-up">
                        <div class="tab-grid">
                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-chart-line"></i></div>
                                <h3>Épidémiologiste</h3>
                                <p>Étudie la distribution et les déterminants des maladies pour développer des
                                    stratégies de prévention.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou Doctorat en épidémiologie ou santé publique (5-8 ans)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse statistique, méthodologie de recherche, surveillance sanitaire</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Organismes de santé publique, ONG, instituts de recherche, salaire moyen de
                                            35 000€ à 65 000€</p>
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
            <p class="section-description" data-aos="fade-up">Les différentes voies pour accéder aux métiers de la santé
            </p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Secondaires</h3>
                        <p>Baccalauréat scientifique recommandé (Bac S) avec de bonnes notes en sciences</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>PASS ou L.AS</h3>
                        <p>Parcours Accès Spécifique Santé ou Licence avec Accès Santé pour les filières médicales</p>
                        <span class="timeline-date">Année 1</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures Spécialisées</h3>
                        <p>Selon la voie choisie : médecine (9 ans min.), pharmacie (6 ans), soins infirmiers (3 ans),
                            etc.</p>
                        <span class="timeline-date">Années 2 à 10</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formations Complémentaires</h3>
                        <p>Spécialisations, DU (Diplôme Universitaire), masters, doctorats selon le métier visé</p>
                        <span class="timeline-date">Années variables</span>
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
                        <li>Études de médecine (PASS/L.AS puis cycle médical)</li>
                        <li>Études de pharmacie</li>
                        <li>Études d'odontologie (dentaire)</li>
                        <li>Études de maïeutique (sage-femme)</li>
                        <li>Licences et Masters en sciences de la santé</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles Spécialisées</h3>
                    </div>
                    <ul>
                        <li>Instituts de Formation en Soins Infirmiers (IFSI)</li>
                        <li>Écoles de kinésithérapie</li>
                        <li>Écoles d'orthophonie</li>
                        <li>Écoles de psychomotricité</li>
                        <li>Écoles d'audioprothèse</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-certificate"></i>
                        <h3>Formations Professionnelles</h3>
                    </div>
                    <ul>
                        <li>BTS/DUT dans les domaines paramédicaux</li>
                        <li>Formations d'aides-soignants</li>
                        <li>Formations d'auxiliaires de puériculture</li>
                        <li>Formations continues et VAE</li>
                        <li>Diplômes d'État spécialisés</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Trends -->
    <section class="trends-section">
        <div class="container">
            <h2 class="section-title light" data-aos="fade-up">Tendances du Secteur</h2>
            <p class="section-description light" data-aos="fade-up">Les évolutions majeures qui façonnent l'avenir de la
                santé</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Intelligence Artificielle</h3>
                    <p>L'IA révolutionne le diagnostic médical, les traitements personnalisés et l'analyse de données de
                        santé, créant de nouveaux métiers à l'intersection de la technologie et de la médecine.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-dna"></i>
                    </div>
                    <h3>Médecine Personnalisée</h3>
                    <p>Développement de traitements sur mesure basés sur le profil génétique du patient, offrant des
                        débouchés dans la génomique et les thérapies ciblées.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-laptop-medical"></i>
                    </div>
                    <h3>Télémédecine</h3>
                    <p>L'essor des consultations à distance et du suivi médical connecté transforme la pratique médicale
                        et crée une demande pour des compétences numériques en santé.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Santé Mentale</h3>
                    <p>Reconnaissance croissante de l'importance de la santé mentale, créant des opportunités pour les
                        psychologues, psychiatres et autres professionnels spécialisés.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Témoignages de Professionnels</h2>

            <div class="testimonials-slider" data-aos="fade-up">
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Après mes études de médecine, j'ai choisi la spécialité de cardiologie. C'est un parcours
                            exigeant mais extrêmement gratifiant. Chaque jour, je contribue concrètement à sauver des
                            vies et à améliorer la qualité de vie de mes patients."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="../../image/doctor-profile.jpg" alt="Dr. Sophie Martin">
                        <div>
                            <h4>Dr. Sophie Martin</h4>
                            <p>Cardiologue, CHU de Lyon</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Le métier d'infirmier demande beaucoup d'empathie et de résistance, mais l'impact que nous
                            avons sur nos patients est incomparable. La formation est complète et permet d'accéder à de
                            nombreuses spécialisations par la suite."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="../../image/nurse-profile.jpg" alt="Thomas Dubois">
                        <div>
                            <h4>Thomas Dubois</h4>
                            <p>Infirmier en soins intensifs</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-nav" data-aos="fade-up">
                <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
                <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Prêt à vous lancer dans une carrière en santé ?</h2>
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

            // Testimonial slider
            const testimonials = document.querySelectorAll('.testimonial');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            let currentIndex = 0;

            function showTestimonial(index) {
                testimonials.forEach((testimonial, i) => {
                    testimonial.style.display = i === index ? 'block' : 'none';
                });
            }

            // Show first testimonial on load
            showTestimonial(0);

            // Event listeners for navigation
            prevBtn.addEventListener('click', function () {
                currentIndex = (currentIndex === 0) ? testimonials.length - 1 : currentIndex - 1;
                showTestimonial(currentIndex);
            });

            nextBtn.addEventListener('click', function () {
                currentIndex = (currentIndex === testimonials.length - 1) ? 0 : currentIndex + 1;
                showTestimonial(currentIndex);
            });
        });
    </script>
</body>

</html>