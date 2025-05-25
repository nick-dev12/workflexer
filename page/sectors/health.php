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
    <link rel="stylesheet" href="/css/health-sector.css">
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
            <p>Découvrez les opportunités, formations et perspectives dans le domaine médical en Afrique francophone</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-content" data-aos="fade-up">
                <h2>À propos du secteur de la santé en Afrique</h2>
                <p>Le secteur de la santé est un domaine vital qui offre des carrières diversifiées dédiées au bien-être
                    et aux soins des populations africaines. Ce secteur en pleine transformation propose de nombreuses
                    opportunités
                    professionnelles allant des soins directs aux patients à la recherche médicale adaptée aux défis
                    sanitaires spécifiques du continent.</p>
                <div class="sector-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-user-md"></i>
                        <h3>+8,4%</h3>
                        <p>Croissance annuelle du marché de la santé en Afrique</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>+250</h3>
                        <p>Formations médicales disponibles en Afrique francophone</p>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-hospital"></i>
                        <h3>2,4M</h3>
                        <p>Déficit estimé de professionnels de santé en Afrique</p>
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
                secteur de la santé en Afrique</p>

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
                                    médicaux complets adaptés au contexte sanitaire africain.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat en médecine (7-10 ans) dans les facultés africaines (FMPO Dakar,
                                            FMPOS Bamako, etc.)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Diagnostic, connaissance des pathologies tropicales, empathie, communication,
                                            adaptation aux ressources limitées</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Opportunités dans les hôpitaux publics et privés, ONG, salaire moyen de 500
                                            000 FCFA à 2 500 000 FCFA selon spécialité</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-heartbeat"></i></div>
                                <h3>Infirmier/Infirmière</h3>
                                <p>Fournit des soins directs aux patients, administre des médicaments et travaille en
                                    collaboration avec les médecins dans divers contextes sanitaires africains.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme d'Infirmier (3-4 ans) dans les écoles africaines (ENDSS Dakar, INFAS
                                            Abidjan, etc.)</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Soins aux patients, organisation, adaptabilité aux ressources limitées,
                                            communication interculturelle</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Forte demande, évolution vers des postes spécialisés, salaire moyen de 150
                                            000 FCFA à 450 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-tooth"></i></div>
                                <h3>Dentiste</h3>
                                <p>Spécialiste de la santé bucco-dentaire, diagnostique et traite les problèmes
                                    dentaires dans un contexte où ces soins sont souvent peu accessibles.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Diplôme de Chirurgie Dentaire (6-7 ans) à la FMPO Dakar, Faculté
                                            d'Odontostomatologie de Bamako, etc.</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Précision, dextérité manuelle, adaptabilité aux équipements disponibles,
                                            prévention</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Exercice libéral ou salarié, opportunités dans les programmes de santé
                                            communautaire, salaire moyen de 400 000 FCFA à 1 500 000 FCFA</p>
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
                                <p>Conduit des recherches sur les maladies tropicales et endémiques pour développer des
                                    traitements adaptés au contexte africain.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat en sciences ou médecine (8-10 ans) dans des instituts africains ou
                                            internationaux</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse scientifique, méthodologie de recherche, connaissance des pathologies
                                            locales</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Instituts de recherche africains, centres régionaux, ONG, salaire moyen de
                                            350 000 FCFA à 1 200 000 FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <div class="career-card">
                                <div class="career-icon"><i class="fas fa-pills"></i></div>
                                <h3>Pharmacologue</h3>
                                <p>Étudie les effets des médicaments et développe des traitements adaptés aux besoins et
                                    ressources locales.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Doctorat en pharmacologie ou sciences pharmaceutiques (5-8 ans) à
                                            l'Université de Dakar, Yaoundé, etc.</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Connaissances en biochimie, recherche sur les plantes médicinales africaines,
                                            analyse de données</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Industrie pharmaceutique émergente, laboratoires de recherche, salaire moyen
                                            de 400 000 FCFA à 1 000 000 FCFA</p>
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
                                <p>Gère les opérations d'un établissement médical et optimise l'utilisation des
                                    ressources souvent limitées.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master en gestion de la santé, ISED Dakar, IRSP Cotonou, CESAG, etc.</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Leadership, gestion des ressources limitées, connaissance des systèmes de
                                            santé africains</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Hôpitaux publics et privés, ONG, salaire moyen de 600 000 FCFA à 2 000 000
                                            FCFA</p>
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
                                <p>Étudie les maladies endémiques et épidémiques africaines pour développer des
                                    stratégies de prévention adaptées.</p>
                                <div class="career-details">
                                    <div class="detail-item">
                                        <h4>Formation Requise</h4>
                                        <p>Master ou Doctorat en épidémiologie ou santé publique (5-8 ans) à l'ISED,
                                            IRSP, etc.</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Compétences Clés</h4>
                                        <p>Analyse statistique, surveillance des maladies tropicales, connaissance des
                                            contextes locaux</p>
                                    </div>
                                    <div class="detail-item">
                                        <h4>Perspectives</h4>
                                        <p>Ministères de la Santé, OMS-Afrique, ONG, salaire moyen de 400 000 FCFA à 1
                                            500 000 FCFA</p>
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
                en Afrique</p>

            <div class="timeline" data-aos="fade-up">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Secondaires</h3>
                        <p>Baccalauréat scientifique ou équivalent avec de bonnes notes en sciences</p>
                        <span class="timeline-date">Années -3 à 0</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Concours d'Entrée</h3>
                        <p>Concours d'accès aux facultés de médecine, pharmacie et écoles paramédicales africaines</p>
                        <span class="timeline-date">Année 0-1</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Études Supérieures Spécialisées</h3>
                        <p>Selon la voie choisie : médecine (7-10 ans), pharmacie (6 ans), soins infirmiers (3-4 ans),
                            etc.</p>
                        <span class="timeline-date">Années 1 à 10</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Formations Complémentaires</h3>
                        <p>Spécialisations, CES, DU, masters, doctorats selon le métier visé</p>
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
                        <li>Faculté de Médecine, Pharmacie et Odontologie (FMPO) - Université Cheikh Anta Diop (Sénégal)
                        </li>
                        <li>Faculté de Médecine et des Sciences Biomédicales - Université de Yaoundé I (Cameroun)</li>
                        <li>Faculté de Médecine - Université Félix Houphouët-Boigny (Côte d'Ivoire)</li>
                        <li>Faculté de Médecine, Pharmacie et Odontostomatologie (FMPOS) - Université de Bamako (Mali)
                        </li>
                        <li>Faculté des Sciences de la Santé - Université d'Abomey-Calavi (Bénin)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-school"></i>
                        <h3>Écoles Spécialisées</h3>
                    </div>
                    <ul>
                        <li>École Nationale de Développement Sanitaire et Social (ENDSS) - Dakar (Sénégal)</li>
                        <li>Institut National de Formation des Agents de Santé (INFAS) - Abidjan (Côte d'Ivoire)</li>
                        <li>École Nationale de Santé Publique (ENSP) - Ouagadougou (Burkina Faso)</li>
                        <li>Institut de Formation en Sciences Infirmières et Obstétricales (IFSIO) - Libreville (Gabon)
                        </li>
                        <li>École des Techniciens Supérieurs de la Santé (ETSS) - Lomé (Togo)</li>
                    </ul>
                </div>

                <div class="education-card">
                    <div class="card-header">
                        <i class="fas fa-certificate"></i>
                        <h3>Instituts de Santé Publique</h3>
                    </div>
                    <ul>
                        <li>Institut de Santé et Développement (ISED) - Université Cheikh Anta Diop (Sénégal)</li>
                        <li>Institut Régional de Santé Publique (IRSP) - Cotonou (Bénin)</li>
                        <li>École de Santé Publique - Université de Kinshasa (RDC)</li>
                        <li>Institut National d'Administration Sanitaire (INAS) - Rabat (Maroc)</li>
                        <li>Centre Inter-États d'Enseignement Supérieur en Santé Publique d'Afrique Centrale (CIESPAC) -
                            Brazzaville (Congo)</li>
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
                santé en Afrique</p>

            <div class="trends-grid">
                <div class="trend-card" data-aos="zoom-in">
                    <div class="trend-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Santé Mobile (mHealth)</h3>
                    <p>L'utilisation des technologies mobiles pour améliorer l'accès aux soins dans les zones rurales
                        africaines, avec des applications de téléconsultation et de suivi des patients adaptées au
                        contexte local.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="trend-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Médecine Traditionnelle Intégrée</h3>
                    <p>Reconnaissance et intégration croissantes des pratiques médicales traditionnelles africaines dans
                        les systèmes de santé modernes, créant des opportunités pour la recherche ethnopharmacologique.
                    </p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="trend-icon">
                        <i class="fas fa-clinic-medical"></i>
                    </div>
                    <h3>Renforcement des Systèmes de Santé</h3>
                    <p>Investissement croissant dans les centres de santé communautaires et la médecine préventive pour
                        répondre aux besoins des populations africaines, notamment dans les zones rurales et
                        périurbaines.</p>
                </div>

                <div class="trend-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="trend-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h3>Recherche sur les Maladies Tropicales</h3>
                    <p>Développement de la recherche médicale africaine sur les maladies endémiques comme le paludisme,
                        la tuberculose et les maladies tropicales négligées, avec des opportunités croissantes pour les
                        chercheurs locaux.</p>
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
                        <p>"Après mes études à la Faculté de Médecine de Dakar, j'ai choisi de travailler dans un centre
                            de santé rural au Sénégal. Les défis sont nombreux mais la satisfaction d'améliorer
                            concrètement la santé des communautés est incomparable. Les jeunes médecins africains ont un
                            rôle crucial à jouer dans le développement de notre système de santé."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="../../image/doctor-profile.jpg" alt="Dr. Aminata Diallo">
                        <div>
                            <h4>Dr. Aminata Diallo</h4>
                            <p>Médecin généraliste, Centre de Santé de Kaffrine, Sénégal</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"La formation en soins infirmiers à l'INFAS d'Abidjan m'a donné les compétences nécessaires
                            pour travailler dans différents contextes sanitaires. Aujourd'hui, je coordonne une équipe
                            d'infirmiers dans un programme de vaccination communautaire. Les opportunités d'évolution
                            sont réelles pour ceux qui s'engagent pleinement dans ce secteur essentiel."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="../../image/nurse-profile.jpg" alt="Jean-Baptiste Koné">
                        <div>
                            <h4>Jean-Baptiste Koné</h4>
                            <p>Infirmier chef, Programme Élargi de Vaccination, Côte d'Ivoire</p>
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
                <h2>Prêt à vous lancer dans une carrière en santé en Afrique ?</h2>
                <p>Découvrez nos ressources d'orientation et prenez contact avec nos conseillers</p>
                <div class="cta-buttons">
                    <a href="#" class="cta-primary">Consulter le guide complet</a>
                    <a href="#" class="cta-secondary">Prendre rendez-vous</a>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../../js/health-sector.js"></script>
</body>

</html>