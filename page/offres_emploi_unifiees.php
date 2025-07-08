<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Configuration de la pagination
$offresParPage = 15;
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $offresParPage;

// Récupération des critères de recherche
$recherche = isset($_GET['search']) ? trim($_GET['search']) : '';
$plateforme = isset($_GET['plateforme']) ? $_GET['plateforme'] : '';
$type_contrat = isset($_GET['type_contrat']) ? $_GET['type_contrat'] : '';
$localisation = isset($_GET['localisation']) ? trim($_GET['localisation']) : '';
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$experience = isset($_GET['experience']) ? $_GET['experience'] : '';
$etude = isset($_GET['etude']) ? $_GET['etude'] : '';

// Fonction pour récupérer les offres de toutes les plateformes avec mélange aléatoire
function getAllOffersFromAllPlatforms($db, $recherche = '', $plateforme = '', $type_contrat = '', $localisation = '', $categorie = '', $experience = '', $etude = '', $offset = 0, $limit = 15)
{
    $allOffers = [];

    try {
        // 1. Offres WorkFlexer
        if (empty($plateforme) || $plateforme === 'workflexer') {
            $sql = "SELECT 
                        o.offre_id,
                        o.poste AS titre,
                        o.mission AS description_poste,
                        c.nom AS entreprise,
                        o.localite AS localisation,
                        o.contrat AS type_contrat,
                        o.date AS date_publication,
                        'WorkFlexer' as source_plateforme,
                        'workflexer' as source_type
                    FROM offre_emploi o
                    JOIN compte_entreprise c ON o.entreprise_id = c.id
                    WHERE (o.statut = 'publier' OR o.statut = '')";

            $params = [];

            if (!empty($recherche)) {
                $sql .= " AND (o.poste LIKE ? OR o.mission LIKE ? OR c.nom LIKE ?)";
                $searchParam = "%$recherche%";
                $params[] = $searchParam;
                $params[] = $searchParam;
                $params[] = $searchParam;
            }

            if (!empty($type_contrat)) {
                $sql .= " AND o.contrat = ?";
                $params[] = $type_contrat;
            }

            if (!empty($localisation)) {
                $sql .= " AND o.localite LIKE ?";
                $params[] = "%$localisation%";
            }

            if (!empty($categorie)) {
                $sql .= " AND o.categorie = ?";
                $params[] = $categorie;
            }

            if (!empty($experience)) {
                $sql .= " AND o.experience = ?";
                $params[] = $experience;
            }

            if (!empty($etude)) {
                $sql .= " AND o.etudes = ?";
                $params[] = $etude;
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $workflexerOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allOffers = array_merge($allOffers, $workflexerOffers);
        }

        // 2. Offres EmploiSenegal
        if (empty($plateforme) || $plateforme === 'emploisenegal') {
            $sql = "SELECT 
                        offre_id,
                        titre,
                        description_poste,
                        entreprise,
                        localisation,
                        type_contrat,
                        date_publication,
                        'EmploiSenegal' as source_plateforme,
                        'emploisenegal' as source_type
                    FROM scrap_emploi_emploisenegal 
                    WHERE 1=1";

            $params = [];

            if (!empty($recherche)) {
                $sql .= " AND (titre LIKE ? OR description_poste LIKE ? OR entreprise LIKE ?)";
                $params[] = "%$recherche%";
                $params[] = "%$recherche%";
                $params[] = "%$recherche%";
            }

            if (!empty($type_contrat)) {
                $sql .= " AND type_contrat LIKE ?";
                $params[] = "%$type_contrat%";
            }

            if (!empty($localisation)) {
                $sql .= " AND localisation LIKE ?";
                $params[] = "%$localisation%";
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $emploiSenegalOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allOffers = array_merge($allOffers, $emploiSenegalOffers);
        }

        // 3. Offres EmploiDakar
        if (empty($plateforme) || $plateforme === 'emploidakar') {
            $sql = "SELECT 
                        offre_id,
                        titre,
                        description_poste,
                        entreprise,
                        localisation,
                        type_contrat,
                        date_publication,
                        'EmploiDakar' as source_plateforme,
                        'emploidakar' as source_type
                    FROM scrap_emploi_emploidakar 
                    WHERE 1=1";

            $params = [];

            if (!empty($recherche)) {
                $sql .= " AND (titre LIKE ? OR description_poste LIKE ? OR entreprise LIKE ?)";
                $params[] = "%$recherche%";
                $params[] = "%$recherche%";
                $params[] = "%$recherche%";
            }

            if (!empty($type_contrat)) {
                $sql .= " AND type_contrat LIKE ?";
                $params[] = "%$type_contrat%";
            }

            if (!empty($localisation)) {
                $sql .= " AND localisation LIKE ?";
                $params[] = "%$localisation%";
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $emploiDakarOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allOffers = array_merge($allOffers, $emploiDakarOffers);
        }

        // 4. Offres SenJob
        if (empty($plateforme) || $plateforme === 'senjob') {
            $sql = "SELECT 
                        offre_id,
                        titre,
                        description_poste,
                        entreprise,
                        localisation,
                        type_contrat,
                        date_publication,
                        'SenJob' as source_plateforme,
                        'senjob' as source_type
                    FROM senjob 
                    WHERE 1=1";

            $params = [];

            if (!empty($recherche)) {
                $sql .= " AND (titre LIKE ? OR description_poste LIKE ? OR entreprise LIKE ?)";
                $params[] = "%$recherche%";
                $params[] = "%$recherche%";
                $params[] = "%$recherche%";
            }

            if (!empty($type_contrat)) {
                $sql .= " AND type_contrat LIKE ?";
                $params[] = "%$type_contrat%";
            }

            if (!empty($localisation)) {
                $sql .= " AND localisation LIKE ?";
                $params[] = "%$localisation%";
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $senjobOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allOffers = array_merge($allOffers, $senjobOffers);
        }

        // 5. Offres OffreEmploiSN
        if (empty($plateforme) || $plateforme === 'offreemploisn') {
            $sql = "SELECT 
                        id as offre_id,
                        titre,
                        description_courte as description_poste,
                        entreprise,
                        lieu as localisation,
                        type_contrat,
                        date_publication,
                        'OffreEmploiSN' as source_plateforme,
                        'offreemploisn' as source_type
                    FROM scrap_emploi_offreemploisn 
                    WHERE 1=1";

            $params = [];

            if (!empty($recherche)) {
                $sql .= " AND (titre LIKE ? OR description_courte LIKE ? OR entreprise LIKE ?)";
                $searchParam = "%$recherche%";
                $params[] = $searchParam;
                $params[] = $searchParam;
                $params[] = $searchParam;
            }

            if (!empty($type_contrat)) {
                $sql .= " AND type_contrat LIKE ?";
                $params[] = "%$type_contrat%";
            }

            if (!empty($localisation)) {
                $sql .= " AND lieu LIKE ?";
                $params[] = "%$localisation%";
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $offreEmploiSnOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allOffers = array_merge($allOffers, $offreEmploiSnOffers);
        }

    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des offres: " . $e->getMessage());
    }

    // MÉLANGE ALÉATOIRE des offres avant pagination
    shuffle($allOffers);

    // Appliquer la pagination après le mélange
    $totalOffers = count($allOffers);
    $paginatedOffers = array_slice($allOffers, $offset, $limit);

    return [
        'offers' => $paginatedOffers,
        'total' => $totalOffers
    ];
}

// Récupération des offres
$result = getAllOffersFromAllPlatforms($db, $recherche, $plateforme, $type_contrat, $localisation, $categorie, $experience, $etude, $offset, $offresParPage);
$offres = $result['offers'];
$totalOffres = $result['total'];
$totalPages = ceil($totalOffres / $offresParPage);

// Fonction pour obtenir le lien de détail selon la plateforme
function getDetailLink($offre)
{
    switch ($offre['source_type']) {
        case 'workflexer':
            return "../entreprise/voir_offre.php?offres_id=" . $offre['offre_id'];
        case 'emploisenegal':
            return "/page/emploi_details1.php?id=" . $offre['offre_id'];
        case 'emploidakar':
            return "/page/emploi_details2.php?id=" . $offre['offre_id'];
        case 'senjob':
            return "/page/emploi_details3.php?id=" . $offre['offre_id'];
        case 'offreemploisn':
            return "/page/emploi_details4.php?id=" . $offre['offre_id'];
        default:
            return "#";
    }
}

// Fonction pour obtenir la couleur de la plateforme
function getPlatformColor($source_type)
{
    switch ($source_type) {
        case 'workflexer':
            return '#007BFF';
        case 'emploisenegal':
            return '#FF5722';
        case 'emploidakar':
            return '#4CAF50';
        case 'senjob':
            return '#9C27B0';
        case 'offreemploisn':
            return '#E67E22'; // Orange
        default:
            return '#6c757d';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Toutes les offres d'emploi des plateformes WorkFlexer, EmploiSenegal, EmploiDakar et SenJob réunies en un seul endroit. Recherchez facilement parmi des milliers d'opportunités professionnelles.">
    <title>Toutes les offres d'emploi | WorkFlexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">
    <link rel="stylesheet" href="../css/job-card.css">
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="../css/offres_unifiees.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="unified-theme">
    <?php include('../navbare.php') ?>

    <section class="hero-search-section unified-hero">
        <div class="slider">
            <div class="box">
                <div class="img">
                    <img src="/image/offre1.webp" alt="Toutes les offres d'emploi">
                </div>
                <div class="text">
                    <h1>Toutes les offres d'emploi en un seul endroit</h1>

                    <form action="" method="get" class="search-form unified-search">
                        <div class="search-row">
                            <div class="search-field">
                                <input type="search" name="search" id="search"
                                    placeholder="Poste, entreprise, mots-clés..."
                                    value="<?php echo htmlspecialchars($recherche); ?>">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div class="filter-row">
                            <div class="filter-field">
                                <select name="type_contrat" id="type_contrat">
                                    <option value="">Type de contrat</option>
                                    <option value="CDI" <?php echo $type_contrat === 'CDI' ? 'selected' : ''; ?>>CDI
                                    </option>
                                    <option value="CDD" <?php echo $type_contrat === 'CDD' ? 'selected' : ''; ?>>CDD
                                    </option>
                                    <option value="Stage" <?php echo $type_contrat === 'Stage' ? 'selected' : ''; ?>>
                                        Stage
                                    </option>
                                    <option value="Freelance"
                                        <?php echo $type_contrat === 'Freelance' ? 'selected' : ''; ?>>Freelance
                                    </option>
                                </select>
                            </div>
                            <div class="filter-field">
                                <input type="text" name="localisation" id="localisation" placeholder="Localisation"
                                    value="<?php echo htmlspecialchars($localisation); ?>">
                            </div>
                        </div>

                        <div class="search-actions">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                            <?php if (!empty($recherche) || !empty($type_contrat) || !empty($localisation)): ?>
                            <a href="offres_emploi_unifiees.php" class="btn-reset-search">
                                <i class="fas fa-times"></i> Réinitialiser
                            </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-briefcase"></i>
                    <div class="stat-info">
                        <span class="stat-number"><?php echo number_format($totalOffres); ?></span>
                        <span class="stat-label">Offres trouvées</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-layer-group"></i>
                    <div class="stat-info">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Plateformes</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <span class="stat-number">Temps réel</span>
                        <span class="stat-label">Mise à jour</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="titre_emploi">
        <?php if (!empty($recherche) || !empty($plateforme) || !empty($type_contrat) || !empty($localisation)): ?>
        Résultats de recherche
        <?php if (!empty($recherche)): ?>
        pour "<?php echo htmlspecialchars($recherche); ?>"
        <?php endif; ?>
        <?php if (!empty($plateforme)): ?>
        sur <?php echo ucfirst($plateforme); ?>
        <?php endif; ?>
        <?php else: ?>
        Toutes les offres d'emploi
        <?php endif; ?>
    </h1>

    <section class="tous_les_offres" id="resultats-section">
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
            <div class="job-card-new" data-type="<?php echo strtolower(htmlspecialchars($offre['type_contrat'])); ?>"
                data-platform="<?php echo htmlspecialchars($offre['source_type']); ?>"
                style="border-left: 5px solid <?php echo getPlatformColor($offre['source_type']); ?>;">
                <div class="card-header">
                    <span class="card-company-logo">
                        <img src="../image/immeuble.png" alt="Logo de l'entreprise">
                    </span>
                    <div class="card-title-group">
                        <h2 class="card-title">
                            <?php echo htmlspecialchars(substr($offre['titre'], 0, 50) . (strlen($offre['titre']) > 50 ? '...' : '')); ?>
                        </h2>
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
                        <span><?php echo htmlspecialchars(date('d/m/Y', strtotime($offre['date_publication']))); ?></span>
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
                    <a href="<?php echo getDetailLink($offre); ?>" class="card-details-btn">Voir les détails</a>
                </div>
            </div>
            <?php endforeach ?>
            <?php endif; ?>
        </article>

        <!-- Système de pagination amélioré avec compteur de pages -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination-container">
            <p class="pagination-info">Page <?php echo $pageActuelle; ?> sur <?php echo $totalPages; ?></p>
            <div class="pagination">
                <?php
                    // Créer la chaîne de requête pour la pagination
                    $queryParams = http_build_query([
                        'search' => $recherche,
                        'plateforme' => $plateforme,
                        'type_contrat' => $type_contrat,
                        'localisation' => $localisation,
                        'categorie' => $categorie,
                        'experience' => $experience,
                        'etude' => $etude
                    ]);
                    ?>
                <?php if ($pageActuelle > 1): ?>
                <a href="?page=<?= $pageActuelle - 1 ?>&<?= $queryParams ?>" class="page-link prev-link">
                    <i class="fas fa-chevron-left"></i> Précédent
                </a>
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
                <a href="?page=<?= $i ?>&<?= $queryParams ?>"
                    class="page-link <?= (int) $i === (int) $pageActuelle ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>

                <?php if ($pageActuelle < $totalPages): ?>
                <a href="?page=<?= $pageActuelle + 1 ?>&<?= $queryParams ?>" class="page-link next-link">
                    Suivant <i class="fas fa-chevron-right"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>

    <script>
    // Filtrage des offres par type de contrat et plateforme
    document.addEventListener('DOMContentLoaded', function() {
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
                offerLink.addEventListener('click', function() {
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

        // Filtrage par type de contrat
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Supprimer la classe active de tous les boutons
                filterButtons.forEach(btn => btn.classList.remove('active'));

                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');

                const category = this.getAttribute('data-category');

                // Filtrer les offres
                jobCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-type').includes(
                            category)) {
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

    <?php if (!empty($recherche) || !empty($type_contrat) || !empty($localisation)): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const resultsSection = document.getElementById('resultats-section');
        if (resultsSection) {
            resultsSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
    </script>
    <?php endif; ?>

    <style>
    /* Styles pour la page unifiée */
    .unified-theme {
        background-color: #f8f9fa;
    }

    .unified-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .unified-search .search-row,
    .unified-search .filter-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .search-field {
        position: relative;
        flex: 3;
        min-width: 300px;
    }

    .search-field input {
        width: 100%;
        padding: 12px 45px 12px 15px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.9);
        font-size: 16px;
    }

    .search-field i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
    }

    .filter-field {
        flex: 1;
        min-width: 150px;
    }

    .filter-field select,
    .filter-field input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        background: #fff;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-btn,
    .btn-reset-search {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        font-size: 14px;
    }

    .search-btn {
        background: #007bff;
        color: white;
        flex-shrink: 0;
    }

    .search-btn:hover {
        background: #0056b3;
    }

    .search-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        width: 100%;
        margin-top: 10px;
    }

    .advanced-filters .filter-field select {
        background-color: #e9ecef;
        font-style: italic;
    }

    .stats-section {
        padding: 40px 0;
        background: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }

    .stat-card i {
        font-size: 2.5rem;
        color: #667eea;
        margin-right: 15px;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .platform-filters {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .platform-btn {
        padding: 10px 20px;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .platform-btn:hover {
        border-color: var(--platform-color, #667eea);
        color: var(--platform-color, #667eea);
    }

    .platform-btn.active {
        background: var(--platform-color, #667eea);
        color: white;
        border-color: var(--platform-color, #667eea);
    }

    .job-card-unified {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    .job-card-unified:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .job-card-unified.visited {
        opacity: 0.8;
        background: #f8f9fa;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .platform-badge {
        padding: 5px 12px;
        border-radius: 15px;
        color: white;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .card-date {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .card-content {
        padding: 20px;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .card-company {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        color: #495057;
    }

    .card-company i {
        margin-right: 8px;
        color: #6c757d;
    }

    .card-details {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .detail-item {
        display: flex;
        align-items: center;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .detail-item i {
        margin-right: 5px;
    }

    .card-description {
        color: #6c757d;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .card-footer {
        padding: 0 20px 20px;
    }

    .card-details-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .card-details-btn:hover {
        background: #5a6fd8;
        transform: translateY(-2px);
    }

    .card-details-btn i {
        margin-right: 8px;
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-results i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #dee2e6;
    }

    .no-results h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .btn-view-all {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 500;
    }

    .btn-reset-search {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: #dc3545;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-reset-search:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .btn-reset-search i {
        margin-right: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .unified-search .search-row {
            flex-direction: column;
            gap: 10px;
        }

        .search-field,
        .filter-field {
            min-width: 100%;
        }

        .platform-filters {
            flex-direction: column;
            align-items: center;
        }

        .card-details {
            flex-direction: column;
            gap: 10px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
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

    .source-btn.compare-btn {
        background-color: #28a745;
        color: white;
        border-color: #1e7e34;
        margin-left: 5px;
    }

    .source-btn.compare-btn:hover {
        background-color: #218838;
    }

    .source-btn.unified-btn {
        background-color: #6f42c1;
        color: white;
        border-color: #5a2d91;
        margin-right: 5px;
    }

    .source-btn.unified-btn:hover {
        background-color: #5a2d91;
    }
    </style>
</body>

</html>