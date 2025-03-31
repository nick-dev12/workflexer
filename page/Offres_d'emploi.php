<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Définir le nombre d'offres par page
$offresParPage = 12;

// Obtenir la page actuelle à partir de l'URL, par défaut 1
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$pageActuelle = max(1, $pageActuelle);

// Calculer l'offset pour la requête SQL
$offset = ($pageActuelle - 1) * $offresParPage;

// Requête SQL pour récupérer uniquement les offres de offre_emploi
$sqlOffresEmploi = "
    SELECT *
    FROM offre_emploi u 
    LEFT JOIN compte_entreprise e ON u.entreprise_id = e.id 
    WHERE 1=1
    ORDER BY u.date DESC
    LIMIT :offset, :limit
";

$stmtOffresEmploi = $db->prepare($sqlOffresEmploi);
$stmtOffresEmploi->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtOffresEmploi->bindValue(':limit', $offresParPage, PDO::PARAM_INT);
$stmtOffresEmploi->execute();

$afficheOffresEmploi = $stmtOffresEmploi->fetchAll(PDO::FETCH_ASSOC);

// Calculer le nombre total de pages pour offre_emploi seulement
$totalOffres = $db->query("SELECT COUNT(*) FROM offre_emploi")->fetchColumn();
$totalPages = ceil($totalOffres / $offresParPage);

// Système de recherche avancée pour offre_emploi uniquement
if (isset($_POST['recherche'])) {
    // Construction de la requête de recherche
    $sql = "SELECT u.*, e.entreprise 
            FROM offre_emploi u 
            LEFT JOIN compte_entreprise e ON u.entreprise_id = e.id 
            WHERE 1=1";

    $params = [];
    $paramValues = [];

    // Ajouter des conditions pour chaque critère
    if (!empty($_POST['search'])) {
        $sql .= " AND (u.poste LIKE ? OR e.entreprise LIKE ? OR u.mission LIKE ?)";
        $searchParam = "%" . $_POST['search'] . "%";
        $paramValues[] = $searchParam;
        $paramValues[] = $searchParam;
        $paramValues[] = $searchParam;
    }

    if (!empty($_POST['categorie'])) {
        $sql .= " AND u.categorie = ?";
        $paramValues[] = $_POST['categorie'];
    }

    if (!empty($_POST['experience'])) {
        $sql .= " AND u.experience = ?";
        $paramValues[] = $_POST['experience'];
    }

    if (!empty($_POST['etude'])) {
        $sql .= " AND u.etudes = ?";
        $paramValues[] = $_POST['etude'];
    }

    // Stocker la requête et les paramètres en session
    $_SESSION['recherche_offre_emploi'] = [
        'sql' => $sql,
        'params' => $paramValues,
        'criteres' => [
            'search' => $_POST['search'] ?? '',
            'categorie' => $_POST['categorie'] ?? '',
            'experience' => $_POST['experience'] ?? '',
            'etude' => $_POST['etude'] ?? ''
        ]
    ];

    // Rediriger vers la page des résultats avec pagination
    header('Location: search_results.php?page=1');
    exit();
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Consultez les dernières offres d'emploi sur Work-Flexer. Des opportunités dans tous les secteurs : IT, marketing, finance, ingénierie. Postulez facilement et suivez vos candidatures. Trouvez le poste qui correspond à vos compétences et ambitions.">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <title>Offres D'emploi | WorkFlexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <section class="hero-search-section">
        <div class="slider">
            <div class="box">
                <div class="img owl-carousel boot">
                    <img src="/image/offre1.webp" alt="Recherche d'emploi">
                    <img src="/image/offre-emploi-quebec.webp" alt="Opportunités professionnelles">
                    <img src="/image/offre3.webp" alt="Carrières">
                    <img src="/image/offre4.webp" alt="Emplois disponibles">
                </div>
                <div class="text">
                    <h1>Trouvez l'emploi idéal qui correspond à vos compétences</h1>
                    <p>Explorez nos offres d'emploi dans tous les secteurs et à tous les niveaux d'expérience pour faire
                        avancer votre carrière</p>

                    <form action="" method="post" class="search-form">
                        <div class="search">
                            <input type="search" name="search" id="search"
                                placeholder="Rechercher un poste, une entreprise, un secteur...">
                            <label for="recherche"><i class="fa-solid fa-magnifying-glass fa-xs"></i></label>
                            <input type="submit" name="recherche" value="recherche" id="recherche">
                        </div>

                        <div class="filtre">
                            <select id="categorie" name="categorie">
                                <option value="">Catégorie</option>
                                <option value="Informatique et tech">Informatique et tech</option>
                                <option value="Design et création">Design et création</option>
                                <option value="Rédaction et traduction">Rédaction et traduction</option>
                                <option value="Marketing et communication">Marketing et communication</option>
                                <option value="Conseil et gestion d'entreprise">Conseil et gestion</option>
                                <option value="Juridique">Juridique</option>
                                <option value="Ingénierie et architecture">Ingénierie</option>
                                <option value="Finance et comptabilité">Finance</option>
                                <option value="Santé et bien-être">Santé</option>
                                <option value="Éducation et formation">Éducation</option>
                                <option value="Tourisme et hôtellerie">Tourisme</option>
                                <option value="Commerce et vente">Commerce</option>
                                <option value="Transport et logistique">Transport</option>
                                <option value="Agriculture et agroalimentaire">Agriculture</option>
                                <option value="Autre">Autre</option>
                            </select>

                            <select name="experience" id="experience">
                                <option value="">Expérience</option>
                                <option value="1an">1 an</option>
                                <option value="2ans">2 ans</option>
                                <option value="3ans">3 ans</option>
                                <option value="4ans">4 ans</option>
                                <option value="5ans">5 ans</option>
                                <option value="6ans">6 ans</option>
                                <option value="7ans">7 ans</option>
                                <option value="8ans">8 ans</option>
                                <option value="9ans">9 ans</option>
                                <option value="10ans">10 ans+</option>
                            </select>

                            <select name="etude" id="etude">
                                <option value="">Niveau d'étude</option>
                                <option value="Bac+1an">Bac+1</option>
                                <option value="Bac+2ans">Bac+2</option>
                                <option value="Bac+3ans">Bac+3</option>
                                <option value="Bac+4ans">Bac+4</option>
                                <option value="Bac+5ans">Bac+5</option>
                                <option value="Bac+6ans">Bac+6</option>
                                <option value="Bac+7ans">Bac+7</option>
                                <option value="Bac+8ans">Bac+8</option>
                                <option value="Bac+9ans">Bac+9</option>
                                <option value="Bac+10ans">Bac+10</option>
                            </select>
                        </div>

                        <div class="source-navigation">
                            <a href="Offres_d'emploi.php" class="source-btn active">WorkFlexer</a>
                            <a href="offres_emploi_senegal.php" class="source-btn">EmploiSenegal</a>
                            <a href="offres_emploi_dakar.php" class="source-btn">EmploiDakar</a>
                            <a href="offres_senjob.php" class="source-btn">SenJob</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="job-stats-container">
        <div class="job-stats">
            <div class="stat-item">
                <i class="fas fa-briefcase"></i>
                <span class="count"><?php echo $totalOffres; ?></span>
                <span class="label">Offres d'emploi</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-building"></i>
                <span
                    class="count"><?php echo $db->query("SELECT COUNT(DISTINCT entreprise_id) FROM offre_emploi")->fetchColumn(); ?></span>
                <span class="label">Entreprises</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-map-marker-alt"></i>
                <span
                    class="count"><?php echo $db->query("SELECT COUNT(DISTINCT localite) FROM offre_emploi")->fetchColumn(); ?></span>
                <span class="label">Localisations</span>
            </div>
        </div>
    </div>

    <h1 class="titre_emploi">Offres d'emploi sur WorkFlexer</h1>

    <section class="tous_les_offres">
        <div class="job-categories">
            <button class="cat-btn active" data-category="all">Tous</button>
            <button class="cat-btn" data-category="cdi">CDI</button>
            <button class="cat-btn" data-category="cdd">CDD</button>
            <button class="cat-btn" data-category="stage">Stage</button>
            <button class="cat-btn" data-category="freelance">Freelance</button>
        </div>

        <article class="articles">
            <?php if (empty($afficheOffresEmploi)): ?>
                <div class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</div>
            <?php else: ?>
                <?php foreach ($afficheOffresEmploi as $offre): ?>
                    <div class="carousel job-card" data-type="<?php echo strtolower($offre['contrat']); ?>">
                        <div class="info-box">
                            <div class="header">
                                <span class="contrat"><?php echo $offre['contrat']; ?></span>
                                <span class="date"><i class="far fa-calendar-alt"></i> <?php echo $offre['date']; ?></span>
                            </div>
                            <h2 class="poste">
                                <?php echo substr($offre['poste'], 0, 100) . (strlen($offre['poste']) > 100 ? '...' : ''); ?>
                            </h2>
                            <div class="entreprise">
                                <img src="../image/immeuble.png" alt="Entreprise">
                                <span><?php echo $offre['entreprise']; ?></span>
                            </div>
                            <div class="localite">
                                <img src="../image/position.png" alt="Localisation">
                                <span><?php echo $offre['localite']; ?></span>
                            </div>
                            <div class="tags">
                                <?php
                                $tags = ['Expérience', 'Télétravail', 'Temps plein'];
                                $randomTag = $tags[array_rand($tags)];
                                ?>
                                <span class="tag"><?php echo $randomTag; ?></span>
                            </div>
                            <a href="../entreprise/voir_offre.php?offres_id=<?= $offre['offre_id']; ?>" class="details-btn">Voir
                                les détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <!-- Système de pagination amélioré avec compteur de pages -->
        <div class="pagination-container">
            <p class="pagination-info">Page <?php echo $pageActuelle; ?> sur <?php echo $totalPages; ?></p>
            <div class="pagination">
                <?php if ($pageActuelle > 1): ?>
                    <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link prev-link"><i class="fas fa-chevron-left"></i>
                        Précédent</a>
                <?php endif; ?>

                <?php
                // Calculer la plage de pages à afficher
                $start = max(1, $pageActuelle - 2);
                $end = min($totalPages, $start + 4);

                // Ajuster le début si on est proche de la fin
                if ($end - $start < 4) {
                    $start = max(1, $end - 4);
                }

                for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="?page=<?= $i ?>" class="page-link <?= (int) $i === (int) $pageActuelle ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($pageActuelle < $totalPages): ?>
                    <a href="?page=<?= $pageActuelle + 1 ?>" class="page-link next-link">Suivant <i
                            class="fas fa-chevron-right"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="other-platforms">
        <h2>Découvrez aussi les offres d'autres plateformes</h2>
        <div class="platform-cards">
            <div class="platform-card">
                <img src="/image/offre-emploi-quebec.webp" alt="Emploi Sénégal">
                <h3>EmploiSenegal</h3>
                <p>Accédez à des centaines d'offres d'emploi provenant d'EmploiSenegal</p>
                <a href="offres_emploi_senegal.php" class="platform-btn">Voir les offres</a>
            </div>
            <div class="platform-card">
                <img src="/image/offre3.webp" alt="Emploi Dakar">
                <h3>EmploiDakar</h3>
                <p>Consultez les opportunités d'emploi de la plateforme EmploiDakar</p>
                <a href="offres_emploi_dakar.php" class="platform-btn">Voir les offres</a>
            </div>
            <div class="platform-card">
                <img src="/image/offre1.webp" alt="SenJob">
                <h3>SenJob</h3>
                <p>Explorez les dernières annonces d'emploi publiées sur SenJob</p>
                <a href="offres_senjob.php" class="platform-btn">Voir les offres</a>
            </div>
        </div>
    </section>

    <section class="job-alert">
        <div class="alert-container">
            <h2><i class="fas fa-bell"></i> Recevez les nouvelles offres par email</h2>
            <p>Soyez informé des nouvelles opportunités correspondant à votre profil</p>
            <form class="alert-form">
                <input type="email" placeholder="Votre adresse email" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </section>

    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    <script src="../js/silder_offres.js"></script>

    <script>
        // Filtrage des offres par type de contrat
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.cat-btn');
            const jobCards = document.querySelectorAll('.job-card');

            // Système pour marquer les offres déjà visitées
            function markVisitedOffers() {
                // Récupérer les offres visitées du localStorage
                const visitedOffers = JSON.parse(localStorage.getItem('visitedOffers')) || [];

                // Marquer chaque carte visitée
                jobCards.forEach(card => {
                    const offerLink = card.querySelector('.details-btn');
                    const offerId = offerLink.href.split('?')[1]; // Récupérer l'ID de l'offre depuis l'URL

                    // Si l'offre est dans la liste des offres visitées
                    if (visitedOffers.includes(offerId)) {
                        card.classList.add('visited');
                    }

                    // Ajouter un écouteur d'événements pour marquer comme visité lors du clic
                    offerLink.addEventListener('click', function () {
                        const newOfferId = this.href.split('?')[1];

                        // Ajouter l'ID de l'offre aux offres visitées si pas déjà présent
                        if (!visitedOffers.includes(newOfferId)) {
                            visitedOffers.push(newOfferId);
                            localStorage.setItem('visitedOffers', JSON.stringify(visitedOffers));
                        }

                        // Marquer la carte comme visitée
                        card.classList.add('visited');
                    });
                });
            }

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Supprimer la classe active de tous les boutons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Ajouter la classe active au bouton cliqué
                    this.classList.add('active');

                    const category = this.getAttribute('data-category');

                    // Filtrer les offres
                    jobCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-type').includes(category)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Animation d'apparition des offres
            jobCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                }, 100 * index);
            });

            // Marquer les offres déjà visitées
            markVisitedOffers();
        });
    </script>

    <style>
        /* Style pour les offres déjà visitées */
        .job-card.visited {
            background-color: #f5f5f5 !important;
            border-top-color: #9e9e9e !important;
            position: relative;
        }

        .job-card.visited::after {
            content: "Déjà consulté";
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(120, 120, 120, 0.8);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            z-index: 10;
        }

        .job-card.visited .info-box {
            opacity: 0.8;
        }

        .job-card.visited .poste {
            color: #666;
        }

        .job-card.visited .header {
            opacity: 0.85;
        }

        .job-card.visited .details-btn {
            background-color: #878787;
        }

        .job-card.visited .details-btn:hover {
            background-color: #6d6d6d;
        }

        /* Style pour la navigation entre sources */
        .source-navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .source-btn {
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .source-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .source-btn.active {
            background-color: #007BFF;
            color: white;
            border-color: #0056b3;
        }

        /* Style pour la section des autres plateformes */
        .other-platforms {
            padding: 60px 0;
            background-color: #f9f9f9;
            text-align: center;
        }

        .other-platforms h2 {
            font-size: 28px;
            margin-bottom: 40px;
            color: #333;
        }

        .platform-cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .platform-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .platform-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.15);
        }

        .platform-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .platform-card h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .platform-card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .platform-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .platform-btn:hover {
            background-color: #0056b3;
        }
    </style>

</body>

</html>