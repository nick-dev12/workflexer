<?php
include_once('includes/header.php');

// Pagination
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = !empty($search) ? "WHERE nom LIKE :search OR mail LIKE :search OR competences LIKE :search OR categorie LIKE :search" : "";

// Filtre par catégorie
$categoryFilter = isset($_GET['categorie']) && !empty($_GET['categorie']) ? $_GET['categorie'] : '';
$categoryCondition = !empty($categoryFilter) ? (!empty($searchCondition) ? " AND categorie = :categorie" : "WHERE categorie = :categorie") : "";

// Filtre par statut
$statusFilter = isset($_GET['statut']) && !empty($_GET['statut']) ? $_GET['statut'] : '';
$statusCondition = !empty($statusFilter) ? (!empty($searchCondition) || !empty($categoryCondition) ? " AND statut = :statut" : "WHERE statut = :statut") : "";

// Tri
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) && ($_GET['order'] == 'asc' || $_GET['order'] == 'desc') ? $_GET['order'] : 'desc';

// Construire la requête SQL
$conditions = $searchCondition . $categoryCondition . $statusCondition;
$sql = "SELECT * FROM users $conditions ORDER BY $sort $order LIMIT :limit OFFSET :offset";
$countSql = "SELECT COUNT(*) as total FROM users $conditions";

// Exécuter la requête pour obtenir le nombre total d'utilisateurs
$countStmt = $db->prepare($countSql);

if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $countStmt->bindParam(':search', $searchParam);
}

if (!empty($categoryFilter)) {
    $countStmt->bindParam(':categorie', $categoryFilter);
}

if (!empty($statusFilter)) {
    $countStmt->bindParam(':statut', $statusFilter);
}

$countStmt->execute();
$totalUsers = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalUsers / $limit);

// Exécuter la requête pour obtenir les utilisateurs paginés
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

if (!empty($statusFilter)) {
    $stmt->bindParam(':statut', $statusFilter);
}

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les catégories pour le filtre
$categoriesQuery = "SELECT DISTINCT categorie FROM users WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie";
$categoriesStmt = $db->prepare($categoriesQuery);
$categoriesStmt->execute();
$categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les statuts pour le filtre
$statusQuery = "SELECT DISTINCT statut FROM users WHERE statut IS NOT NULL ORDER BY statut";
$statusStmt = $db->prepare($statusQuery);
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Gestion des Professionnels</h1>
    <p class="dashboard-subtitle">Gérez tous les utilisateurs professionnels de la plateforme.</p>
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
        <div class="data-table-title">Liste des professionnels (<?php echo $totalUsers; ?>)</div>
        <div class="data-table-actions">
            <button class="export-btn" onclick="exportTableToCSV('usersTable', 'professionnels.csv')">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
    </div>

    <div class="filters">
        <form action="" method="get" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Rechercher un professionnel..." class="table-search-input"
                    data-table-target="usersTable">
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
                    <label for="statut">Statut:</label>
                    <select name="statut" id="statut" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <?php foreach ($statuses as $stat): ?>
                            <option value="<?php echo htmlspecialchars($stat); ?>" <?php echo $statusFilter === $stat ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($stat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <table class="data-table" id="usersTable" data-pagination="10">
        <thead>
            <tr>
                <th class="sortable <?php echo $sort === 'id' ? $order : ''; ?>" data-sort="id">ID</th>
                <th>Utilisateur</th>
                <th class="sortable <?php echo $sort === 'mail' ? $order : ''; ?>" data-sort="mail">Email</th>
                <th>Téléphone</th>
                <th class="sortable <?php echo $sort === 'categorie' ? $order : ''; ?>" data-sort="categorie">Catégorie
                </th>
                <th class="sortable <?php echo $sort === 'statut' ? $order : ''; ?>" data-sort="statut">Statut</th>
                <th class="sortable <?php echo $sort === 'date' ? $order : ''; ?>" data-sort="date">Date d'inscription
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Aucun utilisateur trouvé</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td class="user-info">
                            <img src="<?php echo !empty($user['images']) ? '../upload/' . $user['images'] : 'assets/images/default-avatar.png'; ?>"
                                alt="<?php echo $user['nom']; ?>" class="user-avatar">
                            <div>
                                <div class="user-name"><?php echo $user['nom']; ?></div>
                                <div class="user-email"><?php echo $user['ville']; ?></div>
                            </div>
                        </td>
                        <td><?php echo $user['mail']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo $user['categorie']; ?></td>
                        <td>
                            <span class="status <?php echo $user['statut'] == 'Disponible' ? 'active' : 'inactive'; ?>">
                                <?php echo $user['statut']; ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($user['date'])); ?></td>
                        <td class="actions">
                            <button class="view-btn"
                                onclick="window.location.href='view_user.php?id=<?php echo $user['id']; ?>'">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="edit-btn"
                                onclick="window.location.href='edit_user.php?id=<?php echo $user['id']; ?>'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn"
                                data-confirm-delete="Êtes-vous sûr de vouloir supprimer cet utilisateur ?"
                                onclick="if(confirm(this.dataset.confirmDelete)) window.location.href='delete_user.php?id=<?php echo $user['id']; ?>'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination" data-pagination-for="usersTable">
        <div class="pagination-info">
            Affichage de
            <?php echo min(($page - 1) * $limit + 1, $totalUsers); ?>-<?php echo min($page * $limit, $totalUsers); ?>
            sur <?php echo $totalUsers; ?> entrées
        </div>
        <div class="pagination-controls">
            <button <?php echo $page <= 1 ? 'disabled' : ''; ?>
                onclick="window.location.href='?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&categorie=<?php echo urlencode($categoryFilter); ?>&statut=<?php echo urlencode($statusFilter); ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>'">
                <i class="fas fa-chevron-left"></i>
            </button>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <button class="<?php echo $page === $i ? 'active' : ''; ?>"
                    onclick="window.location.href='?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&categorie=<?php echo urlencode($categoryFilter); ?>&statut=<?php echo urlencode($statusFilter); ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>'">
                    <?php echo $i; ?>
                </button>
            <?php endfor; ?>

            <button <?php echo $page >= $totalPages ? 'disabled' : ''; ?>
                onclick="window.location.href='?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&categorie=<?php echo urlencode($categoryFilter); ?>&statut=<?php echo urlencode($statusFilter); ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>'">
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