<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Vérifier si des critères de recherche existent pour SenJob
if (!isset($_SESSION['criteres_senjob'])) {
    header('Location: offres_senjob.php');
    exit();
}

// Configuration de la pagination
$offresParPage = 12;
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $offresParPage;

// Récupération des critères de recherche
$recherche = $_SESSION['criteres_senjob']['search'];

// Construction de la requête
$sql = "
    SELECT * 
    FROM senjob
    WHERE 1=1
";

$params = [];
$bindParams = [];

if (!empty($recherche)) {
    $sql .= " AND (titre LIKE ? OR description_poste LIKE ?)";
    $searchParam = "%$recherche%";
    $bindParams[] = $searchParam;
    $bindParams[] = $searchParam;
}

// Tri et pagination
$sql .= " ORDER BY date_publication DESC LIMIT ?, ?";
$bindParams[] = $offset;
$bindParams[] = $offresParPage;

// Exécution de la requête
$stmt = $db->prepare($sql);

// Liaison des paramètres
if (!empty($bindParams)) {
    for ($i = 0; $i < count($bindParams); $i++) {
        $paramType = is_int($bindParams[$i]) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindParam($i + 1, $bindParams[$i], $paramType);
    }
}

try {
    $stmt->execute();
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur lors de l'exécution de la requête SenJob: " . $e->getMessage());
    $offres = [];
}

// Comptage du nombre total d'offres pour la pagination
$sqlCount = "SELECT COUNT(*) FROM senjob WHERE 1=1";
$countParams = [];

if (!empty($recherche)) {
    $sqlCount .= " AND (titre LIKE ? OR description_poste LIKE ?)";
    $countParams[] = "%$recherche%";
    $countParams[] = "%$recherche%";
}

$stmtCount = $db->prepare($sqlCount);

// Liaison des paramètres pour le comptage
if (!empty($countParams)) {
    for ($i = 0; $i < count($countParams); $i++) {
        $stmtCount->bindParam($i + 1, $countParams[$i]);
    }
}

try {
    $stmtCount->execute();
    $totalOffres = $stmtCount->fetchColumn();
} catch (PDOException $e) {
    error_log("Erreur lors du comptage des résultats SenJob: " . $e->getMessage());
    $totalOffres = 0;
}

$totalPages = ceil($totalOffres / $offresParPage);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Résultats de recherche pour les offres de SenJob sur Work-Flexer.">
    <title>Résultats de recherche - SenJob | WorkFlexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">
</head>

<body>
    <?php include('../navbare.php') ?>

    <div class="results-header">
        <div class="container">
            <h1>Résultats de recherche - SenJob</h1>
            <div class="search-summary">
                <p>Votre recherche : <span class="search-term"><?php echo htmlspecialchars($recherche); ?></span></p>
                <p class="results-count"><?php echo $totalOffres; ?> résultat(s) trouvé(s)</p>
            </div>
            <div class="actions">
                <a href="offres_senjob.php?reset=1" class="btn-new-search">Nouvelle recherche</a>
                <a href="offres_senjob.php" class="btn-all-jobs">Voir toutes les offres</a>
            </div>
            <div class="source-navigation">
                <a href="Offres_d'emploi.php" class="source-btn">WorkFlexer</a>
                <a href="offres_emploi_senegal.php" class="source-btn">EmploiSenegal</a>
                <a href="offres_emploi_dakar.php" class="source-btn">EmploiDakar</a>
                <a href="offres_senjob.php" class="source-btn active">SenJob</a>
            </div>
        </div>
    </div>

    <section class="tous_les_offres">
        <div class="job-categories">
            <button class="cat-btn active" data-category="all">Tous</button>
            <button class="cat-btn" data-category="cdi">CDI</button>
            <button class="cat-btn" data-category="cdd">CDD</button>
            <button class="cat-btn" data-category="stage">Stage</button>
            <button class="cat-btn" data-category="freelance">Freelance</button>
        </div>

        <article class="articles">
            <?php if (empty($offres)): ?>
                <div class="message">Aucune offre d'emploi ne correspond à votre recherche.</div>
                <div class="suggestions">
                    <h3>Suggestions :</h3>
                    <ul>
                        <li>Vérifiez l'orthographe des termes de recherche.</li>
                        <li>Essayez des mots-clés plus généraux.</li>
                        <li>Essayez d'autres sources d'offres d'emploi.</li>
                    </ul>
                </div>
            <?php else: ?>
                <?php foreach ($offres as $offre): ?>
                    <div class="carousel job-card" data-type="<?php echo strtolower($offre['type_contrat']); ?>">
                        <div class="info-box">
                            <div class="header">
                                <span class="contrat"><?php echo $offre['type_contrat']; ?></span>
                                <span class="date"><i class="far fa-calendar-alt"></i>
                                    <?php echo $offre['date_publication']; ?></span>
                            </div>
                            <h2 class="poste">
                                <?php echo substr($offre['titre'], 0, 100) . (strlen($offre['titre']) > 100 ? '...' : ''); ?>
                            </h2>
                            <div class="entreprise">
                                <img src="../image/immeuble.png" alt="Entreprise">
                                <span><?php echo $offre['entreprise']; ?></span>
                            </div>
                            <div class="localite">
                                <img src="../image/position.png" alt="Localisation">
                                <span><?php echo $offre['localisation']; ?></span>
                            </div>
                            <div class="tags">
                                <?php
                                $tags = ['Expérience', 'Télétravail', 'Temps plein'];
                                $randomTag = $tags[array_rand($tags)];
                                ?>
                                <span class="tag"><?php echo $randomTag; ?></span>
                            </div>
                            <a href="/page/emploi_details3.php?id=<?php echo $offre['offre_id']; ?>" class="details-btn">Voir
                                les détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <?php if (!empty($offres)): ?>
            <!-- Système de pagination -->
            <div class="pagination-container">
                <p class="pagination-info">Page <?php echo $pageActuelle; ?> sur <?php echo $totalPages; ?></p>
                <div class="pagination">
                    <?php if ($pageActuelle > 1): ?>
                        <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link prev-link"><i class="fas fa-chevron-left"></i>
                            Précédent</a>
                    <?php endif; ?>

                    <?php
                    $start = max(1, $pageActuelle - 2);
                    $end = min($totalPages, $start + 4);
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
        <?php endif; ?>

        <!-- Autres sources -->
        <div class="other-sources">
            <h3>Vous n'avez pas trouvé ce que vous cherchez ?</h3>
            <p>Essayez de rechercher dans nos autres sources d'offres d'emploi :</p>
            <div class="sources-links">
                <a href="Offres_d'emploi.php" class="source-link">
                    <i class="fas fa-search"></i> Rechercher sur WorkFlexer
                </a>
                <a href="offres_emploi_senegal.php" class="source-link">
                    <i class="fas fa-search"></i> Rechercher sur EmploiSenegal
                </a>
                <a href="offres_emploi_dakar.php" class="source-link">
                    <i class="fas fa-search"></i> Rechercher sur EmploiDakar
                </a>
            </div>
        </div>
    </section>

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
        /* Style pour les résultats de recherche */
        .results-header {
            background-color: #f8f9fa;
            padding: 30px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .results-header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .results-header h1 {
            margin-bottom: 15px;
            color: #333;
            font-size: 28px;
        }

        .search-summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #e9f5fe;
            border-radius: 5px;
        }

        .search-term {
            font-weight: bold;
            color: #007bff;
        }

        .results-count {
            margin-top: 5px;
            font-size: 16px;
            color: #666;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .btn-new-search,
        .btn-all-jobs {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-new-search:hover,
        .btn-all-jobs:hover {
            background-color: #0056b3;
        }

        .btn-all-jobs {
            background-color: #6c757d;
        }

        .btn-all-jobs:hover {
            background-color: #5a6268;
        }

        .suggestions {
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            border-radius: 0 5px 5px 0;
        }

        .suggestions h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .suggestions ul {
            margin-left: 20px;
            color: #666;
        }

        .suggestions li {
            margin-bottom: 5px;
        }

        .source-navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .source-btn {
            padding: 10px 15px;
            background-color: #f0f0f0;
            color: #333;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        .source-btn:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
        }

        .source-btn.active {
            background-color: #007BFF;
            color: white;
            border-color: #0056b3;
        }

        /* Style pour les autres sources */
        .other-sources {
            margin-top: 50px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            text-align: center;
        }

        .other-sources h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .other-sources p {
            margin-bottom: 20px;
            color: #666;
        }

        .sources-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .source-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .source-link:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .actions {
                flex-direction: column;
            }

            .source-navigation {
                flex-direction: column;
            }

            .sources-links {
                flex-direction: column;
            }
        }
    </style>
</body>

</html>