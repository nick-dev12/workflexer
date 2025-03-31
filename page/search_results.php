<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Vérifier si des critères de recherche existent
if (!isset($_SESSION['recherche_offre_emploi'])) {
    header('Location: Offres_d\'emploi.php');
    exit();
}

// Configuration de la pagination
$offresParPage = 12;
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $offresParPage;

// Récupération des critères de recherche
$rechercheData = $_SESSION['recherche_offre_emploi'];
$sql = $rechercheData['sql'];
$bindParams = $rechercheData['params']; // Maintenant les paramètres sont déjà dans un tableau indexé
$criteres = $rechercheData['criteres'];

// Ajout de la pagination à la requête
$sql .= " ORDER BY u.date DESC LIMIT ?, ?";
$bindParams[] = $offset;
$bindParams[] = $offresParPage;

// Exécution de la requête
$stmt = $db->prepare($sql);

// Liaison des paramètres (positionnels)
for ($i = 0; $i < count($bindParams); $i++) {
    $paramType = is_int($bindParams[$i]) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $stmt->bindParam($i + 1, $bindParams[$i], $paramType);
}

$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Requête pour compter le nombre total de résultats
$countSql = str_replace("u.*, e.entreprise", "COUNT(*) as total", $rechercheData['sql']);

$countStmt = $db->prepare($countSql);

// Liaison des paramètres pour le comptage (uniquement les paramètres de recherche, pas de pagination)
$countParams = array_slice($bindParams, 0, count($bindParams) - 2);
for ($i = 0; $i < count($countParams); $i++) {
    $paramType = is_int($countParams[$i]) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $countStmt->bindParam($i + 1, $countParams[$i], $paramType);
}

$countStmt->execute();
$totalOffres = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalPages = ceil($totalOffres / $offresParPage);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche | WorkFlexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">
</head>

<body>
    <?php include('../navbare.php'); ?>

    <div class="container_resultat">
        <h1 class="titre_resultat">Résultats de la recherche</h1>

        <?php if ($totalOffres === 0): ?>
            <div class="no-results">
                <p>Aucun résultat ne correspond à votre recherche.</p>
                <a href="Offres_d'emploi.php" class="back-btn">Retour aux offres</a>
            </div>
        <?php else: ?>
            <div class="search-info">
                <p>Nombre de résultats trouvés : <?php echo $totalOffres; ?></p>
                <a href="Offres_d'emploi.php" class="back-btn">Nouvelle recherche</a>
            </div>

            <div class="source-navigation">
                <a href="Offres_d'emploi.php" class="source-btn active">WorkFlexer</a>
                <a href="offres_emploi_senegal.php" class="source-btn">EmploiSenegal</a>
                <a href="offres_emploi_dakar.php" class="source-btn">EmploiDakar</a>
                <a href="offres_senjob.php" class="source-btn">SenJob</a>
            </div>

            <h2 class="table-title">Offres de notre plateforme</h2>

            <div class="search-criteria">
                <p><strong>Vous avez recherché:</strong>
                    <?php if (!empty($criteres['search'])): ?>
                        <span class="criteria-tag">Termes: <?php echo htmlspecialchars($criteres['search']); ?></span>
                    <?php endif; ?>

                    <?php if (!empty($criteres['categorie'])): ?>
                        <span class="criteria-tag">Catégorie: <?php echo htmlspecialchars($criteres['categorie']); ?></span>
                    <?php endif; ?>

                    <?php if (!empty($criteres['experience'])): ?>
                        <span class="criteria-tag">Expérience: <?php echo htmlspecialchars($criteres['experience']); ?></span>
                    <?php endif; ?>

                    <?php if (!empty($criteres['etude'])): ?>
                        <span class="criteria-tag">Niveau d'étude: <?php echo htmlspecialchars($criteres['etude']); ?></span>
                    <?php endif; ?>

                    <?php if (empty($criteres['search']) && empty($criteres['categorie']) && empty($criteres['experience']) && empty($criteres['etude'])): ?>
                        <span class="criteria-tag">Tous les postes</span>
                    <?php endif; ?>
                </p>
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
                    <?php foreach ($offres as $offre): ?>
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
                                <a href="../entreprise/voir_offre.php?offres_id=<?= $offre['offre_id']; ?>"
                                    class="details-btn">Voir
                                    les détails</a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </article>

                <div class="search-other-sources">
                    <h3>Vous cherchez plus d'offres?</h3>
                    <p>Consultez nos autres sources d'offres d'emploi pour trouver la meilleure opportunité:</p>
                    <div class="other-sources-buttons">
                        <a href="offres_emploi_senegal.php" class="source-link">
                            <i class="fas fa-briefcase"></i> EmploiSenegal
                        </a>
                        <a href="offres_emploi_dakar.php" class="source-link">
                            <i class="fas fa-briefcase"></i> EmploiDakar
                        </a>
                        <a href="offres_senjob.php" class="source-link">
                            <i class="fas fa-briefcase"></i> SenJob
                        </a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php if ($pageActuelle > 1): ?>
            <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link prev-link"><i class="fas fa-chevron-left"></i>
                Précédent</a>
        <?php endif; ?>

        <?php
        $start = max(1, $pageActuelle - 2);
        $end = min($totalPages, $start + 4);
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
        /* Style pour les résultats */
        .container_resultat {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .titre_resultat {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            color: #333;
        }

        .search-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }

        .search-criteria {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .criteria-tag {
            display: inline-block;
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 5px 10px;
            border-radius: 4px;
            margin: 5px;
            font-size: 0.9em;
        }

        .no-results {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .no-results p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .table-title {
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007BFF;
            color: #333;
            font-size: 24px;
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

        /* Style pour la navigation entre sources */
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

        /* Section pour les autres sources */
        .search-other-sources {
            margin-top: 50px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .search-other-sources h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #333;
        }

        .search-other-sources p {
            color: #666;
            margin-bottom: 20px;
        }

        .other-sources-buttons {
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
            transition: all 0.3s ease;
        }

        .source-link:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .source-navigation {
                flex-direction: column;
                align-items: center;
            }

            .source-btn {
                width: 100%;
                text-align: center;
            }

            .other-sources-buttons {
                flex-direction: column;
            }

            .source-link {
                width: 100%;
            }
        }
    </style>
</body>

</html>