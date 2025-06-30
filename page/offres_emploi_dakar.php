<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Configuration de la pagination
$offresParPage = 12; // Nombre d'offres par page
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $offresParPage;

// Récupération des critères de recherche
$recherche = isset($_POST['search']) ? $_POST['search'] : '';

// Si une recherche est soumise, stocker les critères en session
if (isset($_POST['recherche'])) {
    $_SESSION['criteres_emploi_dakar'] = [
        'search' => $recherche
    ];
    // Rediriger vers la page de résultats spécifique à EmploiDakar
    header('Location: resultats_emploi_dakar.php?page=1');
    exit();
}

// Réinitialiser la recherche si on accède directement à la page principale
// ou si le paramètre reset est présent
if (isset($_GET['reset']) || (!isset($_POST['recherche']) && !isset($_GET['page']))) {
    unset($_SESSION['criteres_emploi_dakar']);
    $recherche = '';
}

// Construction de la requête
$sql = "
    SELECT * 
    FROM scrap_emploi_emploidakar
    WHERE 1=1
";

$bindParams = [];

if (!empty($recherche)) {
    $sql .= " AND (titre LIKE ? OR description_poste LIKE ? OR entreprise LIKE ?)";
    $searchParam = "%$recherche%";
    $bindParams[] = $searchParam;
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
    error_log("Erreur lors de l'exécution de la requête EmploiDakar: " . $e->getMessage());
    $offres = [];
}

// Comptage du nombre total d'offres pour la pagination
$sqlCount = "SELECT COUNT(*) FROM scrap_emploi_emploidakar WHERE 1=1";
$countParams = [];

if (!empty($recherche)) {
    $sqlCount .= " AND (titre LIKE ? OR description_poste LIKE ? OR entreprise LIKE ?)";
    $countParams[] = "%$recherche%";
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
    error_log("Erreur lors du comptage des résultats EmploiDakar: " . $e->getMessage());
    $totalOffres = 0;
}

$totalPages = ceil($totalOffres / $offresParPage);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Consultez les offres d'emploi d'EmploiDakar sur Work-Flexer. Trouvez le poste qui correspond à vos compétences et ambitions.">
    <title>Offres d'emploi EmploiDakar | WorkFlexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">
    <link rel="stylesheet" href="../css/job-card.css">
</head>

<body class="emploidakar-theme">
    <?php include('../navbare.php') ?>

    <section class="hero-search-section">
        <div class="slider">
            <div class="box">
                <div class="img">
                    <img src="/image/offre3.webp" alt="Emploi Dakar">
                </div>
                <div class="text">
                    <h1>Offres d'emploi d'EmploiDakar</h1>
                    <p>Découvrez les dernières opportunités d'emploi de la plateforme EmploiDakar</p>

                    <form action="" method="post" class="search-form">
                        <div class="search">
                            <input type="search" name="search" id="search"
                                placeholder="Rechercher par titre, description ou entreprise..."
                                value="<?php echo htmlspecialchars($recherche); ?>">
                            <label for="recherche"><i class="fa-solid fa-magnifying-glass fa-xs"></i></label>
                            <input type="submit" name="recherche" value="recherche" id="recherche">
                        </div>

                        <div class="source-navigation">
                            <a href="Offres_d'emploi.php" class="source-btn">WorkFlexer</a>
                            <a href="offres_emploi_senegal.php" class="source-btn">EmploiSenegal</a>
                            <a href="offres_emploi_dakar.php" class="source-btn active">EmploiDakar</a>
                            <a href="offres_senjob.php" class="source-btn">SenJob</a>
                        </div>
                        
                        <?php if (!empty($recherche)): ?>
                        <div class="search-actions">
                            <a href="offres_emploi_dakar.php?reset=1" class="btn-reset-search">Voir toutes les offres</a>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

   

    <h1 class="titre_emploi">
        <?php if (!empty($recherche)): ?>
            Résultats de recherche pour "<?php echo htmlspecialchars($recherche); ?>" sur EmploiDakar
        <?php else: ?>
            Offres d'emploi sur EmploiDakar
        <?php endif; ?>
    </h1>

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
                <div class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</div>
            <?php else: ?>
                <?php foreach ($offres as $offre): ?>
                    <!-- Nouvelle carte d'offre d'emploi -->
                    <div class="job-card-new" data-type="<?php echo strtolower($offre['type_contrat']); ?>">
                        <div class="card-header">
                            <span class="card-company-logo">
                                <img src="../image/immeuble.png" alt="Logo de l'entreprise">
                            </span>
                            <div class="card-title-group">
                                <h2 class="card-title"><?php echo htmlspecialchars(substr($offre['titre'], 0, 50) . (strlen($offre['titre']) > 50 ? '...' : '')); ?></h2>
                                <p class="card-company"><?php echo htmlspecialchars($offre['entreprise']); ?></p>
                            </div>
                        </div>

                        <div class="card-details">
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($offre['localisation']); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-file-contract"></i>
                                <span><?php echo htmlspecialchars($offre['type_contrat']); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="far fa-calendar-alt"></i>
                                <span><?php echo htmlspecialchars($offre['date_publication']); ?></span>
                            </div>
                        </div>

                        <div class="card-tags">
                            <?php
                                $tags = ['Télétravail', 'Hybride', 'Temps plein'];
                                $randomTag = $tags[array_rand($tags)];
                            ?>
                            <span class="tag"><?php echo $randomTag; ?></span>
                            <span class="tag">Expérience requise</span>
                        </div>

                        <div class="card-footer">
                            <a href="/page/emploi_details2.php?id=<?php echo $offre['offre_id']; ?>" class="card-details-btn">Voir les détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

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

        /* Style pour les actions de recherche */
        .search-actions {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .btn-reset-search {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid #1e7e34;
        }

        .btn-reset-search:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
    </style>
</body>

</html>