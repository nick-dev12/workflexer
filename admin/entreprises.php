<?php
include_once('includes/header.php');

// Pagination
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = !empty($search) ? "WHERE entreprise LIKE :search OR nom LIKE :search OR mail LIKE :search OR categorie LIKE :search" : "";

// Filtre par catégorie
$categoryFilter = isset($_GET['categorie']) && !empty($_GET['categorie']) ? $_GET['categorie'] : '';
$categoryCondition = !empty($categoryFilter) ? (!empty($searchCondition) ? " AND categorie = :categorie" : "WHERE categorie = :categorie") : "";

// Filtre par type
$typeFilter = isset($_GET['types']) && !empty($_GET['types']) ? $_GET['types'] : '';
$typeCondition = !empty($typeFilter) ? (!empty($searchCondition) || !empty($categoryCondition) ? " AND types = :types" : "WHERE types = :types") : "";

// Tri
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) && ($_GET['order'] == 'asc' || $_GET['order'] == 'desc') ? $_GET['order'] : 'desc';

// Construire la requête SQL
$conditions = $searchCondition . $categoryCondition . $typeCondition;
$sql = "SELECT * FROM compte_entreprise $conditions ORDER BY $sort $order LIMIT :limit OFFSET :offset";
$countSql = "SELECT COUNT(*) as total FROM compte_entreprise $conditions";

// Exécuter la requête pour obtenir le nombre total d'entreprises
$countStmt = $db->prepare($countSql);

if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $countStmt->bindParam(':search', $searchParam);
}

if (!empty($categoryFilter)) {
    $countStmt->bindParam(':categorie', $categoryFilter);
}

if (!empty($typeFilter)) {
    $countStmt->bindParam(':types', $typeFilter);
}

$countStmt->execute();
$totalEntreprises = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalEntreprises / $limit);

// Exécuter la requête pour obtenir les entreprises paginées
$stmt = $db->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $stmt->bindParam(':search', $searchParam);
}

if (!empty($categoryFilter)) {
    $stmt->bindParam(':categorie', $categoryFilter);
}

if (!empty($typeFilter)) {
    $stmt->bindParam(':types', $typeFilter);
}

$stmt->execute();
$entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les catégories pour le filtre
$categoriesQuery = "SELECT DISTINCT categorie FROM compte_entreprise WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie";
$categoriesStmt = $db->prepare($categoriesQuery);
$categoriesStmt->execute();
$categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les types pour le filtre
$typesQuery = "SELECT DISTINCT types FROM compte_entreprise WHERE types IS NOT NULL ORDER BY types";
$typesStmt = $db->prepare($typesQuery);
$typesStmt->execute();
$types = $typesStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Gestion des Entreprises</h1>
    <p class="dashboard-subtitle">Gérez toutes les entreprises inscrites sur la plateforme.</p>
</div>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" data-auto-dismiss="5000">
        <i class="fas fa-check-circle"></i>
        <?php echo $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-error" data-auto-dismiss="5000">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $_SESSION['error_message']; ?>
        <?php unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<div class="data-table-container">
    <div class="data-table-header">
        <div class="data-table-title">Liste des entreprises (<?php echo $totalEntreprises; ?>)</div>
        <div class="data-table-actions">
            <button class="export-btn" onclick="exportTableToCSV('entreprisesTable', 'entreprises.csv')">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
    </div>

    <div class="filters">
        <form action="" method="get" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Rechercher une entreprise..." class="table-search-input"
                    data-table-target="entreprisesTable">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>

            <div class="filter-selects">
                <div class="filter-select">
                    <label for="categorie">Catégorie:</label>
                    <select name="categorie" id="categorie" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $categoryFilter === $cat ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-select">
                    <label for="types">Type:</label>
                    <select name="types" id="types" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?php echo htmlspecialchars($type); ?>" <?php echo $typeFilter === $type ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <table class="data-table" id="entreprisesTable" data-pagination="10">
        <thead>
            <tr>
                <th class="sortable <?php echo $sort === 'id' ? $order : ''; ?>" data-sort="id">ID</th>
                <th>Entreprise</th>
                <th class="sortable <?php echo $sort === 'mail' ? $order : ''; ?>" data-sort="mail">Email</th>
                <th>Téléphone</th>
                <th class="sortable <?php echo $sort === 'types' ? $order : ''; ?>" data-sort="types">Type</th>
                <th class="sortable <?php echo $sort === 'categorie' ? $order : ''; ?>" data-sort="categorie">Catégorie
                </th>
                <th>Ville</th>
                <th>Taille</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($entreprises)): ?>
                <tr>
                    <td colspan="9" style="text-align: center;">Aucune entreprise trouvée</td>
                </tr>
            <?php else: ?>
                <?php foreach ($entreprises as $entreprise): ?>
                    <tr>
                        <td><?php echo $entreprise['id']; ?></td>
                        <td class="user-info">
                            <img src="<?php echo !empty($entreprise['images']) ? '../upload/' . $entreprise['images'] : 'assets/images/default-company.png'; ?>"
                                alt="<?php echo $entreprise['entreprise']; ?>" class="user-avatar">
                            <div>
                                <div class="user-name"><?php echo $entreprise['entreprise']; ?></div>
                                <div class="user-email"><?php echo $entreprise['nom']; ?></div>
                            </div>
                        </td>
                        <td><?php echo $entreprise['mail']; ?></td>
                        <td><?php echo $entreprise['phone']; ?></td>
                        <td><?php echo $entreprise['types']; ?></td>
                        <td><?php echo $entreprise['categorie']; ?></td>
                        <td><?php echo $entreprise['ville']; ?></td>
                        <td><?php echo $entreprise['taille']; ?></td>
                        <td class="actions">
                            <button class="view-btn"
                                onclick="window.location.href='view_entreprise.php?id=<?php echo $entreprise['id']; ?>'">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="edit-btn"
                                onclick="window.location.href='edit_entreprise.php?id=<?php echo $entreprise['id']; ?>'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn"
                                data-confirm-delete="Êtes-vous sûr de vouloir supprimer cette entreprise ?"
                                onclick="if(confirm(this.dataset.confirmDelete)) window.location.href='delete_entreprise.php?id=<?php echo $entreprise['id']; ?>'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination" data-pagination-for="entreprisesTable">
        <div class="pagination-info">
            Affichage de
            <?php echo min(($page - 1) * $limit + 1, $totalEntreprises); ?>-<?php echo min($page * $limit, $totalEntreprises); ?>
            sur <?php echo $totalEntreprises; ?> entrées
        </div>
        <div class="pagination-controls">
            <button <?php echo $page <= 1 ? 'disabled' : ''; ?>
                onclick="window.location.href='?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&categorie=<?php echo urlencode($categoryFilter); ?>&types=<?php echo urlencode($typeFilter); ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>'">
                <i class="fas fa-chevron-left"></i>
            </button>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <button class="<?php echo $page === $i ? 'active' : ''; ?>"
                    onclick="window.location.href='?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&categorie=<?php echo urlencode($categoryFilter); ?>&types=<?php echo urlencode($typeFilter); ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>'">
                    <?php echo $i; ?>
                </button>
            <?php endfor; ?>

            <button <?php echo $page >= $totalPages ? 'disabled' : ''; ?>
                onclick="window.location.href='?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&categorie=<?php echo urlencode($categoryFilter); ?>&types=<?php echo urlencode($typeFilter); ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>'">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .filters {
        margin-bottom: 20px;
    }

    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    .search-box {
        flex: 1;
        display: flex;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 14px;
    }

    .search-box button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--light-text);
        cursor: pointer;
    }

    .filter-selects {
        display: flex;
        gap: 15px;
    }

    .filter-select {
        display: flex;
        flex-direction: column;
    }

    .filter-select label {
        font-size: 12px;
        margin-bottom: 5px;
        color: var(--light-text);
    }

    .filter-select select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: var(--light-bg);
        min-width: 150px;
    }

    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-selects {
            flex-direction: column;
        }
    }
</style>

<?php
include_once('includes/footer.php');
?>