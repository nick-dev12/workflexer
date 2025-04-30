<?php

include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');
include_once('../entreprise/app/model/offre_emploi.php');

// Récupérer les informations de l'administrateur


// Récupérer toutes les catégories
$sql_categories = "SELECT DISTINCT categorie FROM offre_emploi ORDER BY categorie";
$stmt_categories = $db->prepare($sql_categories);
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll(PDO::FETCH_COLUMN);

// Récupérer la catégorie sélectionnée (par défaut, prendre la première)
$selected_category = isset($_GET['categorie']) ? $_GET['categorie'] : (count($categories) > 0 ? $categories[0] : '');

// Récupérer les filtres
$statut = isset($_GET['statut']) ? $_GET['statut'] : '';
$date_order = isset($_GET['date_order']) ? $_GET['date_order'] : 'DESC';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Construction de la requête SQL avec les filtres
$sql = "SELECT oe.*, ce.entreprise, ce.images as logo
        FROM offre_emploi oe
        JOIN compte_entreprise ce ON oe.entreprise_id = ce.id
        WHERE oe.categorie = :categorie";

$params = [':categorie' => $selected_category];

if (!empty($statut)) {
    $sql .= " AND oe.statut = :statut";
    $params[':statut'] = $statut;
}

if (!empty($search)) {
    $sql .= " AND (oe.poste LIKE :search OR oe.mission LIKE :search OR oe.profil LIKE :search OR ce.entreprise LIKE :search)";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY oe.date " . ($date_order == 'ASC' ? 'ASC' : 'DESC');

$stmt = $db->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement de la suppression d'une offre si demandé
if (isset($_POST['supprimer_offre']) && isset($_POST['offre_id'])) {
    $offre_id = $_POST['offre_id'];

    try {
        // Récupérer les détails de l'offre avant suppression pour l'historique
        $stmt = $db->prepare("SELECT * FROM offre_emploi WHERE offre_id = :offre_id");
        $stmt->bindParam(':offre_id', $offre_id);
        $stmt->execute();
        $offre_details = $stmt->fetch(PDO::FETCH_ASSOC);

        // Supprimer l'offre
        $stmt = $db->prepare("DELETE FROM offre_emploi WHERE offre_id = :offre_id");
        $stmt->bindParam(':offre_id', $offre_id);

        if ($stmt->execute()) {
            // Enregistrer dans l'historique d'administration
            $admin_id = $_SESSION['admin'];
            $action = "Suppression de l'offre ID: " . $offre_id . " - Titre: " . $offre_details['poste'];
            $stmt = $db->prepare("INSERT INTO admin_actions (admin_id, action, date) VALUES (:admin_id, :action, NOW())");
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->bindParam(':action', $action);
            $stmt->execute();

            $_SESSION['success_message'] = "L'offre a été supprimée avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'offre.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données: " . $e->getMessage();
    }

    // Rediriger vers la même page pour éviter les soumissions multiples
    header("Location: offres_categorie.php?categorie=" . urlencode($selected_category));
    exit;
}

// Traitement du changement de statut d'une offre
if (isset($_POST['changer_statut']) && isset($_POST['offre_id']) && isset($_POST['nouveau_statut'])) {
    $offre_id = $_POST['offre_id'];
    $nouveau_statut = $_POST['nouveau_statut'];

    try {
        $stmt = $db->prepare("UPDATE offre_emploi SET statut = :statut WHERE offre_id = :offre_id");
        $stmt->bindParam(':statut', $nouveau_statut);
        $stmt->bindParam(':offre_id', $offre_id);

        if ($stmt->execute()) {
            // Enregistrer dans l'historique d'administration
            $admin_id = $_SESSION['admin'];
            $action = "Modification du statut de l'offre ID: " . $offre_id . " - Nouveau statut: " . $nouveau_statut;
            $stmt = $db->prepare("INSERT INTO admin_actions (admin_id, action, date) VALUES (:admin_id, :action, NOW())");
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->bindParam(':action', $action);
            $stmt->execute();

            $_SESSION['success_message'] = "Le statut de l'offre a été modifié avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification du statut de l'offre.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données: " . $e->getMessage();
    }

    // Rediriger vers la même page
    header("Location: offres_categorie.php?categorie=" . urlencode($selected_category));
    exit;
}

// Récupérer les statistiques de la catégorie sélectionnée
$sql_stats = "SELECT 
                COUNT(*) as total_offres,
                SUM(CASE WHEN statut = 'active' THEN 1 ELSE 0 END) as offres_actives,
                SUM(CASE WHEN statut = 'expirée' THEN 1 ELSE 0 END) as offres_expirees,
                SUM(CASE WHEN date_expiration < CURDATE() THEN 1 ELSE 0 END) as offres_expirant,
                COUNT(DISTINCT entreprise_id) as nb_entreprises
              FROM offre_emploi
              WHERE categorie = :categorie";
$stmt_stats = $db->prepare($sql_stats);
$stmt_stats->bindParam(':categorie', $selected_category);
$stmt_stats->execute();
$stats = $stmt_stats->fetch(PDO::FETCH_ASSOC);

include_once('includes/header.php');
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Offres d'emploi par catégorie</h1>
    <p class="dashboard-subtitle">Gestion des offres d'emploi pour la catégorie
        "<?php echo htmlspecialchars($selected_category); ?>"</p>
</div>

<!-- Messages de confirmation/erreur -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message'];
        unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<!-- Statistiques de la catégorie -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['total_offres']; ?></div>
            <div class="stat-label">Offres totales</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['offres_actives']; ?></div>
            <div class="stat-label">Offres actives</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['offres_expirees']; ?></div>
            <div class="stat-label">Offres expirées</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-building"></i></div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['nb_entreprises']; ?></div>
            <div class="stat-label">Entreprises publiantes</div>
        </div>
    </div>
</div>

<!-- Filtres et sélection de catégorie -->
<div class="filters-container">
    <div class="category-selector">
        <form method="GET" action="">
            <div class="form-group">
                <label for="categorie">Catégorie :</label>
                <select id="categorie" name="categorie" onchange="this.form.submit()">
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo htmlspecialchars($categorie); ?>" <?php echo $categorie === $selected_category ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categorie); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <div class="filters">
        <form method="GET" action="">
            <input type="hidden" name="categorie" value="<?php echo htmlspecialchars($selected_category); ?>">

            <div class="form-group">
                <label for="statut">Statut :</label>
                <select id="statut" name="statut">
                    <option value="">Tous</option>
                    <option value="active" <?php echo $statut === 'active' ? 'selected' : ''; ?>>Actives</option>
                    <option value="expirée" <?php echo $statut === 'expirée' ? 'selected' : ''; ?>>Expirées</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date_order">Tri par date :</label>
                <select id="date_order" name="date_order">
                    <option value="DESC" <?php echo $date_order === 'DESC' ? 'selected' : ''; ?>>Plus récentes</option>
                    <option value="ASC" <?php echo $date_order === 'ASC' ? 'selected' : ''; ?>>Plus anciennes</option>
                </select>
            </div>

            <div class="form-group search-group">
                <input type="text" id="search" name="search" placeholder="Rechercher..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
            </div>

            <button type="submit" class="btn btn-apply-filters">Appliquer les filtres</button>
        </form>
    </div>
</div>

<!-- Liste des offres -->
<div class="job-listings">
    <?php if (empty($offres)): ?>
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <p>Aucune offre d'emploi trouvée pour la catégorie "<?php echo htmlspecialchars($selected_category); ?>".</p>
            <p class="sub-message">Essayez de modifier vos critères de recherche ou sélectionnez une autre catégorie.</p>
        </div>
    <?php else: ?>
        <?php foreach ($offres as $offre): ?>
            <div class="job-card <?php echo $offre['statut'] === 'expirée' ? 'expired' : ''; ?>">
                <div class="job-header">
                    <div class="company-logo">
                        <img src="../upload/<?php echo !empty($offre['logo']) ? htmlspecialchars($offre['logo']) : 'default-company.png'; ?>"
                            alt="<?php echo htmlspecialchars($offre['entreprise']); ?>">
                    </div>
                    <div class="job-title-company">
                        <h3 class="job-title"><?php echo htmlspecialchars($offre['poste']); ?></h3>
                        <div class="company-name"><?php echo htmlspecialchars($offre['entreprise']); ?></div>
                    </div>
                    <div class="job-status <?php echo strtolower($offre['statut']); ?>">
                        <?php echo htmlspecialchars($offre['statut']); ?>
                    </div>
                </div>

                <div class="job-details">
                    <div class="job-info">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($offre['localite']); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-briefcase"></i>
                            <span><?php echo htmlspecialchars($offre['contrat']); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span><?php echo htmlspecialchars($offre['etudes']); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-history"></i>
                            <span><?php echo htmlspecialchars($offre['experience']); ?></span>
                        </div>
                    </div>

                    <div class="job-dates">
                        <div class="date-item">
                            <span class="date-label">Publiée le:</span>
                            <span class="date-value"><?php echo date('d/m/Y', strtotime($offre['date'])); ?></span>
                        </div>
                        <div class="date-item">
                            <span class="date-label">Expire le:</span>
                            <span class="date-value"><?php echo date('d/m/Y', strtotime($offre['date_expiration'])); ?></span>
                        </div>
                    </div>
                </div>

                <div class="job-description">
                    <div class="description-title">Description</div>
                    <div class="description-content">
                        <?php echo nl2br(htmlspecialchars(substr($offre['mission'], 0, 200) . (strlen($offre['mission']) > 200 ? '...' : ''))); ?>
                    </div>
                </div>

                <div class="job-actions">
                    <a href="offre_details.php?id=<?php echo $offre['offre_id']; ?>" class="btn btn-view">
                        <i class="fas fa-eye"></i> Voir détails
                    </a>

                    <form method="POST" action="" class="status-form">
                        <input type="hidden" name="offre_id" value="<?php echo $offre['offre_id']; ?>">
                        <input type="hidden" name="changer_statut" value="1">
                        <select name="nouveau_statut" class="status-select">
                            <option value="active" <?php echo $offre['statut'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="expirée" <?php echo $offre['statut'] === 'expirée' ? 'selected' : ''; ?>>Expirée
                            </option>
                        </select>
                        <button type="submit" class="btn btn-status">
                            <i class="fas fa-sync-alt"></i> Changer
                        </button>
                    </form>

                    <form method="POST" action="" class="delete-form"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">
                        <input type="hidden" name="offre_id" value="<?php echo $offre['offre_id']; ?>">
                        <input type="hidden" name="supprimer_offre" value="1">
                        <button type="submit" class="btn btn-delete">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    /* Styles pour les statistiques */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        display: flex;
        align-items: center;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 600;
        color: var(--text-color);
    }

    .stat-label {
        font-size: 14px;
        color: var(--light-text);
    }

    /* Styles pour les filtres */
    .filters-container {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-end;
    }

    .category-selector {
        flex: 1;
        min-width: 250px;
    }

    .filters {
        flex: 3;
        min-width: 300px;
    }

    .filters form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        min-width: 150px;
        flex: 1;
    }

    .form-group label {
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-group select,
    .form-group input {
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }

    .search-group {
        position: relative;
        flex: 2;
    }

    .search-group input {
        width: 100%;
        padding-right: 40px;
    }

    .btn-search {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
    }

    .btn-apply-filters {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-apply-filters:hover {
        background: var(--primary-dark);
    }

    /* Styles pour les annonces d'emploi */
    .job-listings {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .job-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .job-card.expired {
        border-left: 4px solid #e74c3c;
        opacity: 0.8;
    }

    .job-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .company-logo {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        margin-right: 15px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .company-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .job-title-company {
        flex: 1;
    }

    .job-title {
        margin: 0;
        font-size: 18px;
        color: var(--text-color);
    }

    .company-name {
        color: var(--primary-color);
        font-weight: 500;
    }

    .job-status {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .job-status.active {
        background: #e3f7ec;
        color: #27ae60;
    }

    .job-status.expirée {
        background: #fbe9e7;
        color: #e74c3c;
    }

    .job-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .job-info {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        flex: 3;
    }

    .info-item {
        display: flex;
        align-items: center;
        color: var(--light-text);
        font-size: 14px;
        margin-right: 15px;
    }

    .info-item i {
        margin-right: 5px;
        color: var(--primary-color);
    }

    .job-dates {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
    }

    .date-item {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }

    .date-label {
        color: var(--light-text);
    }

    .date-value {
        font-weight: 500;
        color: var(--text-color);
    }

    .job-description {
        margin-bottom: 20px;
    }

    .description-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-color);
    }

    .description-content {
        color: var(--light-text);
        font-size: 14px;
        line-height: 1.5;
    }

    .job-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 15px;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s;
    }

    .btn i {
        font-size: 12px;
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
        border: none;
    }

    .btn-view:hover {
        background: var(--primary-dark);
    }

    .status-form {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .status-select {
        padding: 8px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }

    .btn-status {
        background: #f4f6f8;
        color: var(--text-color);
        border: 1px solid var(--border-color);
    }

    .btn-status:hover {
        background: #e9ecef;
    }

    .btn-delete {
        background: #fdf1f0;
        color: #e74c3c;
        border: 1px solid #fadbd8;
    }

    .btn-delete:hover {
        background: #fadbd8;
    }

    /* Etat vide */
    .empty-state {
        text-align: center;
        padding: 50px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .empty-state i {
        font-size: 48px;
        color: var(--light-text);
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 18px;
        color: var(--text-color);
        margin-bottom: 5px;
    }

    .empty-state .sub-message {
        font-size: 14px;
        color: var(--light-text);
    }

    @media (max-width: 768px) {
        .job-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .company-logo {
            margin-bottom: 10px;
        }

        .job-status {
            margin-top: 10px;
        }

        .job-details {
            flex-direction: column;
        }

        .job-actions {
            flex-direction: column;
        }

        .btn,
        .status-form {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-submit des formulaires quand on change de statut
        const statusForms = document.querySelectorAll('.status-form select');
        statusForms.forEach(select => {
            select.addEventListener('change', function () {
                this.closest('form').submit();
            });
        });

        // Fermeture automatique des alertes après 5 secondes
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            }, 5000);
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>