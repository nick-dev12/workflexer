<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Vérifier si des critères de recherche existent
if (!isset($_SESSION['criteres_recherche'])) {
    header('Location: Offres_d\'emploi.php');
    exit();
}

// Configuration de la pagination
$offresParTable = 6; // Nombre d'offres par table
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $offresParTable;

// Récupération des critères de recherche
$recherche = $_SESSION['criteres_recherche']['search'];
$categorie = $_SESSION['criteres_recherche']['categorie'];
$experience = $_SESSION['criteres_recherche']['experience'];
$etude = $_SESSION['criteres_recherche']['etude'];

// Initialisation du tableau de résultats
$resultats = [
    'offre_emploi' => [],
    'emploi_emploi' => [],
    'emploi_dakar' => [],
    'senjob' => []
];

// Requête pour offre_emploi avec pagination
$sqlOffresEmploi = "
    SELECT 'offre_emploi' as source, u.offre_id, u.poste, u.contrat, u.date, 
           u.experience, u.etudes, u.mission, u.localite, e.entreprise 
    FROM offre_emploi u 
    LEFT JOIN compte_entreprise e ON u.entreprise_id = e.id 
    WHERE 1=1
";

if (!empty($recherche)) {
    $sqlOffresEmploi .= " AND (u.poste LIKE :recherche OR e.entreprise LIKE :recherche)";
}
if (!empty($categorie)) {
    $sqlOffresEmploi .= " AND u.categorie = :categorie";
}
if (!empty($experience)) {
    $sqlOffresEmploi .= " AND u.experience = :experience";
}
if (!empty($etude)) {
    $sqlOffresEmploi .= " AND u.etudes = :etude";
}

$sqlOffresEmploi .= " ORDER BY u.date DESC LIMIT :offset, :limit";

$stmtOffresEmploi = $db->prepare($sqlOffresEmploi);

if (!empty($recherche)) {
    $stmtOffresEmploi->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
}
if (!empty($categorie)) {
    $stmtOffresEmploi->bindValue(':categorie', $categorie, PDO::PARAM_STR);
}
if (!empty($experience)) {
    $stmtOffresEmploi->bindValue(':experience', $experience, PDO::PARAM_STR);
}
if (!empty($etude)) {
    $stmtOffresEmploi->bindValue(':etude', $etude, PDO::PARAM_STR);
}

$stmtOffresEmploi->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtOffresEmploi->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtOffresEmploi->execute();
$resultats['offre_emploi'] = $stmtOffresEmploi->fetchAll(PDO::FETCH_ASSOC);

// Requête pour emploi_emploi avec pagination
$sqlEmploiEmploi = "
    SELECT 'emploi_emploi' as source, offre_id, titre, type_contrat, 
           date_publication, entreprise, localisation 
    FROM scrap_emploi_emploisenegal 
    WHERE 1=1
";

if (!empty($recherche)) {
    $sqlEmploiEmploi .= " AND (titre LIKE :recherche OR entreprise LIKE :recherche)";
}

$sqlEmploiEmploi .= " ORDER BY date_publication DESC LIMIT :offset, :limit";

$stmtEmploiEmploi = $db->prepare($sqlEmploiEmploi);

if (!empty($recherche)) {
    $stmtEmploiEmploi->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
}

$stmtEmploiEmploi->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtEmploiEmploi->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtEmploiEmploi->execute();
$resultats['emploi_emploi'] = $stmtEmploiEmploi->fetchAll(PDO::FETCH_ASSOC);

// Requête pour emploi_dakar avec pagination
$sqlEmploiDakar = "
    SELECT 'emploi_dakar' as source, offre_id, titre, type_contrat, 
           date_publication, entreprise, localisation 
    FROM scrap_emploi_emploidakar 
    WHERE 1=1
";

if (!empty($recherche)) {
    $sqlEmploiDakar .= " AND (titre LIKE :recherche OR entreprise LIKE :recherche)";
}

$sqlEmploiDakar .= " ORDER BY date_publication DESC LIMIT :offset, :limit";

$stmtEmploiDakar = $db->prepare($sqlEmploiDakar);

if (!empty($recherche)) {
    $stmtEmploiDakar->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
}

$stmtEmploiDakar->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtEmploiDakar->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtEmploiDakar->execute();
$resultats['emploi_dakar'] = $stmtEmploiDakar->fetchAll(PDO::FETCH_ASSOC);

// Requête pour senjob avec pagination
$sqlSenjob = "
    SELECT 'senjob' as source, offre_id, titre, type_contrat, 
           date_publication, entreprise, localisation 
    FROM senjob 
    WHERE 1=1
";

if (!empty($recherche)) {
    $sqlSenjob .= " AND (titre LIKE :recherche OR entreprise LIKE :recherche)";
}

$sqlSenjob .= " ORDER BY date_publication DESC LIMIT :offset, :limit";

$stmtSenjob = $db->prepare($sqlSenjob);

if (!empty($recherche)) {
    $stmtSenjob->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
}

$stmtSenjob->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtSenjob->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtSenjob->execute();
$resultats['senjob'] = $stmtSenjob->fetchAll(PDO::FETCH_ASSOC);

// Calculer le nombre total d'offres pour la pagination
$sqlCount = "
    SELECT 
    (SELECT COUNT(*) FROM offre_emploi u LEFT JOIN compte_entreprise e ON u.entreprise_id = e.id WHERE 1=1 
    " . (!empty($recherche) ? "AND (u.poste LIKE :recherche1 OR e.entreprise LIKE :recherche1)" : "") . ") as count1,
    (SELECT COUNT(*) FROM scrap_emploi_emploisenegal WHERE 1=1 
    " . (!empty($recherche) ? "AND (titre LIKE :recherche2 OR entreprise LIKE :recherche2)" : "") . ") as count2,
    (SELECT COUNT(*) FROM scrap_emploi_emploidakar WHERE 1=1 
    " . (!empty($recherche) ? "AND (titre LIKE :recherche3 OR entreprise LIKE :recherche3)" : "") . ") as count3,
    (SELECT COUNT(*) FROM senjob WHERE 1=1 
    " . (!empty($recherche) ? "AND (titre LIKE :recherche4 OR entreprise LIKE :recherche4)" : "") . ") as count4
";

$stmtCount = $db->prepare($sqlCount);

if (!empty($recherche)) {
    $stmtCount->bindValue(':recherche1', "%$recherche%", PDO::PARAM_STR);
    $stmtCount->bindValue(':recherche2', "%$recherche%", PDO::PARAM_STR);
    $stmtCount->bindValue(':recherche3', "%$recherche%", PDO::PARAM_STR);
    $stmtCount->bindValue(':recherche4', "%$recherche%", PDO::PARAM_STR);
}

$stmtCount->execute();
$counts = $stmtCount->fetch(PDO::FETCH_ASSOC);

$totalOffres = array_sum($counts);
$totalPages = ceil($totalOffres / ($offresParTable * 4)); // 4 tables * 6 offres

// Affichage de la pagination
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
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

        <?php
        $total_resultats = 0;
        foreach ($resultats as $table => $offres) {
            $total_resultats += count($offres);
        }
        ?>

        <?php if ($total_resultats === 0): ?>
            <div class="no-results">
                <p>Aucun résultat ne correspond à votre recherche.</p>
                <a href="Offres_d'emploi.php" class="back-btn">Retour aux offres</a>
            </div>
        <?php else: ?>
            <div class="search-info">
                <p>Nombre de résultats trouvés : <?php echo $total_resultats; ?></p>
                <a href="Offres_d'emploi.php" class="back-btn">Nouvelle recherche</a>
            </div>

            <?php foreach ($resultats as $table => $offres): ?>
                <?php if (!empty($offres)): ?>
                    <h2 class="table-title">
                        <?php
                        switch ($table) {
                            case 'offre_emploi':
                                echo 'Offres de notre plateforme';
                                break;
                            case 'emploi_emploi':
                                echo 'Offres de Emploi Sénégal';
                                break;
                            case 'emploi_dakar':
                                echo 'Offres de Emploi Dakar';
                                break;
                            case 'senjob':
                                echo 'Offres de Senjob';
                                break;
                        }
                        ?>
                    </h2>
                    <section class="tous_les_offres">
                        <?php foreach ($offres as $offre): ?>
                            <div class="carousel">
                                <div class="info-box">
                                    <?php include 'includes/offre_template.php'; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php if ($pageActuelle > 1): ?>
            <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link">Précédent</a>
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
            <a href="?page=<?= $pageActuelle + 1 ?>" class="page-link">Suivant</a>
        <?php endif; ?>
    </div>


</body>

</html>