<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orientation Professionnelle | Work-Flexer</title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/orientation.css">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content" data-aos="fade-up">
            <h1>Explorez Votre Avenir Professionnel</h1>
            <p>Découvrez les opportunités de carrière qui s'offrent à vous et trouvez votre voie professionnelle idéale
            </p>
            <a href="#sectors" class="cta-button">Commencer l'Exploration</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Sector Navigation -->
        <section class="sector-navigation" id="sectors">
            <h2 data-aos="fade-up">Secteurs d'Activité</h2>
            <p data-aos="fade-up">Explorez les différents domaines professionnels et trouvez celui qui correspond à vos
                aspirations et compétences</p>
            <div class="sector-grid">
                <div class="sector-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="sector-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3>Santé et Médecine</h3>
                    <p>Des carrières dédiées au bien-être et à la santé des individus</p>
                    <a href="sectors/health.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="sector-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Technologie et Informatique</h3>
                    <p>Innovation et développement dans le monde numérique</p>
                    <a href="sectors/technology.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="sector-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Ingénierie et Architecture</h3>
                    <p>Conception et construction pour un monde meilleur</p>
                    <a href="sectors/engineering.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="sector-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>Droit et Justice</h3>
                    <p>Protection des droits et résolution des litiges juridiques</p>
                    <a href="sectors/law.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="sector-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Économie et Finance</h3>
                    <p>Gestion des ressources financières et développement économique</p>
                    <a href="sectors/economics.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="sector-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>Administration et Services Publics</h3>
                    <p>Carrières au service de l'intérêt général et des citoyens</p>
                    <a href="sectors/administration.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="700">
                    <div class="sector-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Design et Création</h3>
                    <p>Métiers de la création artistique et du design</p>
                    <a href="sectors/design.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="800">
                    <div class="sector-icon">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <h3>Rédaction et Traduction</h3>
                    <p>Communication écrite et transfert linguistique</p>
                    <a href="sectors/writing.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="900">
                    <div class="sector-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Conseil et Gestion d'Entreprise</h3>
                    <p>Stratégie et optimisation des organisations</p>
                    <a href="sectors/consulting.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="1000">
                    <div class="sector-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Éducation et Formation</h3>
                    <p>Transmission du savoir et développement des compétences</p>
                    <a href="sectors/education.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="1100">
                    <div class="sector-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3>Tourisme et Hôtellerie</h3>
                    <p>Accueil, services et expériences de voyage</p>
                    <a href="sectors/tourism.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="1200">
                    <div class="sector-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>Commerce et Vente</h3>
                    <p>Distribution et négociation commerciale</p>
                    <a href="sectors/commerce.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="1300">
                    <div class="sector-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Transport et Logistique</h3>
                    <p>Organisation des flux de marchandises et de personnes</p>
                    <a href="sectors/transport.php" class="sector-link">Explorer</a>
                </div>
                <div class="sector-card" data-aos="fade-up" data-aos-delay="1400">
                    <div class="sector-icon">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <h3>Agriculture et Agroalimentaire</h3>
                    <p>Production, transformation et distribution alimentaire</p>
                    <a href="sectors/agriculture.php" class="sector-link">Explorer</a>
                </div>
            </div>
        </section>

        <!-- Health Sector -->
        <section id="health" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Santé et Médecine</h2>
                <p>Un domaine en constante évolution offrant des opportunités variées et enrichissantes</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1578496479763-c21c718af028?q=80&w=600&auto=format&fit=crop"
                        alt="Infirmier">
                    <div class="career-info">
                        <h3>Infirmier/Infirmière</h3>
                        <p>Dispenser des soins directs aux patients et collaborer avec l'équipe médicale</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Diplôme d'État d'Infirmier (3 ans)</p>
                            <p><strong>Compétences :</strong> Soins médicaux, Communication, Empathie</p>
                        </div>
                    </div>
                </div>
                <!-- Add more career cards for health sector -->
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/health.php" class="explore-btn">Découvrir toutes les carrières dans la santé <i
                        class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Tech Sector -->
        <section id="tech" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Technologie et Informatique</h2>
                <p>Un secteur dynamique à la pointe de l'innovation</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1580927752452-89d86da3fa0a?q=80&w=600&auto=format&fit=crop"
                        alt="Développeur Web">
                    <div class="career-info">
                        <h3>Développeur Web</h3>
                        <p>Création et maintenance de sites web et applications</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Licence, Master ou Formation spécialisée en informatique</p>
                            <p><strong>Compétences :</strong> HTML, CSS, JavaScript, Frameworks</p>
                        </div>
                    </div>
                </div>
                <!-- Add more career cards for tech sector -->
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/technology.php" class="explore-btn">Découvrir toutes les carrières dans la technologie
                    <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Engineering Sector -->
        <section id="engineering" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Ingénierie et Architecture</h2>
                <p>Concevoir et construire l'avenir</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=600&auto=format&fit=crop"
                        alt="Ingénieur Civil">
                    <div class="career-info">
                        <h3>Ingénieur Civil</h3>
                        <p>Conception et supervision de projets d'infrastructure</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Diplôme d'ingénieur (Bac+5) ou Master en génie civil</p>
                            <p><strong>Compétences :</strong> Conception, Gestion de projet, Calculs techniques</p>
                        </div>
                    </div>
                </div>
                <!-- Add more career cards for engineering sector -->
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/engineering.php" class="explore-btn">Découvrir toutes les carrières dans l'ingénierie
                    <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Design Sector Preview -->
        <section id="design" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Design et Création</h2>
                <p>Libérez votre créativité dans des carrières innovantes et expressives</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=600&auto=format&fit=crop"
                        alt="Designer Graphique">
                    <div class="career-info">
                        <h3>Designer Graphique</h3>
                        <p>Création d'identités visuelles et de supports de communication</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Diplôme en design graphique (BTS, BUT, École d'art)</p>
                            <p><strong>Compétences :</strong> Créativité, Logiciels de design, Communication visuelle
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Add more career cards for design sector -->
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/design.php" class="explore-btn">Découvrir toutes les carrières dans le design et la
                    création <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Writing Sector Preview -->
        <section id="writing" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Rédaction et Traduction</h2>
                <p>Maîtrisez l'art des mots et de la communication écrite</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=600&auto=format&fit=crop"
                        alt="Rédacteur Web">
                    <div class="career-info">
                        <h3>Rédacteur Web</h3>
                        <p>Création de contenus optimisés pour le web et les médias numériques</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Licence en lettres, communication ou journalisme</p>
                            <p><strong>Compétences :</strong> Rédaction SEO, Veille informationnelle, Adaptabilité</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/writing.php" class="explore-btn">Découvrir toutes les carrières dans la rédaction et
                    traduction <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Consulting Sector Preview -->
        <section id="consulting" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Conseil et Gestion d'Entreprise</h2>
                <p>Accompagnez les organisations dans leur développement et leur transformation</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=600&auto=format&fit=crop"
                        alt="Consultant en Stratégie">
                    <div class="career-info">
                        <h3>Consultant en Stratégie</h3>
                        <p>Analyse et conseil pour optimiser les performances des entreprises</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Master en management, école de commerce ou d'ingénieur</p>
                            <p><strong>Compétences :</strong> Analyse, Problem-solving, Communication, Leadership</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/consulting.php" class="explore-btn">Découvrir toutes les carrières dans le conseil et
                    la gestion <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Education Sector Preview -->
        <section id="education" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Éducation et Formation</h2>
                <p>Formez les générations futures et contribuez à l'évolution des connaissances</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=600&auto=format&fit=crop"
                        alt="Enseignant">
                    <div class="career-info">
                        <h3>Enseignant</h3>
                        <p>Transmission du savoir et accompagnement des apprenants</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Master MEEF ou diplôme selon le niveau d'enseignement visé
                            </p>
                            <p><strong>Compétences :</strong> Pédagogie, Expertise dans un domaine, Communication</p>
                        </div>
                    </div>
                </div>
                <!-- Add more career cards for education sector -->
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/education.php" class="explore-btn">Découvrir toutes les carrières dans l'éducation <i
                        class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Tourism Sector Preview -->
        <section id="tourism" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Tourisme et Hôtellerie</h2>
                <p>Créez des expériences mémorables dans l'industrie de l'accueil et du voyage</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=600&auto=format&fit=crop"
                        alt="Directeur d'Hôtel">
                    <div class="career-info">
                        <h3>Directeur d'Hôtel</h3>
                        <p>Gestion et développement d'un établissement hôtelier</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Bac+3 à Bac+5 en management hôtelier</p>
                            <p><strong>Compétences :</strong> Leadership, Gestion, Relation client, Multilinguisme</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/tourism.php" class="explore-btn">Découvrir toutes les carrières dans le tourisme et
                    l'hôtellerie <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Commerce Sector Preview -->
        <section id="commerce" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Commerce et Vente</h2>
                <p>Développez votre sens commercial dans un secteur dynamique et varié</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1610374792793-f016b77ca51a?q=80&w=600&auto=format&fit=crop"
                        alt="Responsable de Magasin">
                    <div class="career-info">
                        <h3>Responsable de Magasin</h3>
                        <p>Gestion d'un point de vente et animation d'une équipe commerciale</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Bac+2 à Bac+5 en commerce ou management</p>
                            <p><strong>Compétences :</strong> Gestion commerciale, Leadership, Analyse des ventes</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/commerce.php" class="explore-btn">Découvrir toutes les carrières dans le commerce et la
                    vente <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Transport Sector Preview -->
        <section id="transport" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Transport et Logistique</h2>
                <p>Optimisez les flux de marchandises et de personnes dans un monde connecté</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1494522855154-9297ac14b55f?q=80&w=600&auto=format&fit=crop"
                        alt="Supply Chain Manager">
                    <div class="career-info">
                        <h3>Supply Chain Manager</h3>
                        <p>Pilotage des chaînes d'approvisionnement et d'optimisation logistique</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Bac+5 en logistique ou supply chain management</p>
                            <p><strong>Compétences :</strong> Gestion des flux, Optimisation, Systèmes d'information</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/transport.php" class="explore-btn">Découvrir toutes les carrières dans le transport et
                    la logistique <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <!-- Agriculture Sector Preview -->
        <section id="agriculture" class="sector-details">
            <div class="sector-header" data-aos="fade-up">
                <h2>Agriculture et Agroalimentaire</h2>
                <p>Contribuez à l'alimentation mondiale à travers des métiers essentiels et innovants</p>
            </div>
            <div class="career-grid">
                <div class="career-card" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=600&auto=format&fit=crop"
                        alt="Ingénieur Agronome">
                    <div class="career-info">
                        <h3>Ingénieur Agronome</h3>
                        <p>Expertise technique et scientifique au service de l'agriculture et de l'environnement</p>
                        <div class="career-details">
                            <p><strong>Formation :</strong> Diplôme d'ingénieur agronome (Bac+5)</p>
                            <p><strong>Compétences :</strong> Connaissances scientifiques, Analyse, Innovation durable
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-explore" data-aos="fade-up">
                <a href="sectors/agriculture.php" class="explore-btn">Découvrir toutes les carrières dans l'agriculture
                    et l'agroalimentaire <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>
    </main>

    <?php include('../footer.php') ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>