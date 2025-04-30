<?php
include_once('includes/header.php');

// Récupérer les statistiques générales
$stats = [
    'users' => 0,
    'entreprises' => 0,
    'offres' => 0,
    'candidatures' => 0
];

// Nombre total d'utilisateurs
$sql = "SELECT COUNT(*) as total FROM users";
$stmt = $db->prepare($sql);
$stmt->execute();
$stats['users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Nombre total d'entreprises
$sql = "SELECT COUNT(*) as total FROM compte_entreprise";
$stmt = $db->prepare($sql);
$stmt->execute();
$stats['entreprises'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Nombre total d'offres d'emploi
$sql = "SELECT COUNT(*) as total FROM offre_emploi";
$stmt = $db->prepare($sql);
$stmt->execute();
$stats['offres'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Nombre total de candidatures
$sql = "SELECT COUNT(*) as total FROM postulation";
$stmt = $db->prepare($sql);
$stmt->execute();
$stats['candidatures'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Derniers utilisateurs inscrits
$sql = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
$stmt = $db->prepare($sql);
$stmt->execute();
$latestUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Dernières entreprises inscrites
$sql = "SELECT * FROM compte_entreprise ORDER BY id DESC LIMIT 5";
$stmt = $db->prepare($sql);
$stmt->execute();
$latestCompanies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Données pour le graphique d'inscription des utilisateurs
$months = [];
$userCounts = [];

for ($i = 6; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $months[] = date('M Y', strtotime("-$i months"));

    $startDate = $month . '-01';
    $endDate = date('Y-m-t', strtotime($startDate));

    $sql = "SELECT COUNT(*) as count FROM users WHERE DATE(date) BETWEEN :start AND :end";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':start', $startDate);
    $stmt->bindParam(':end', $endDate);
    $stmt->execute();
    $userCounts[] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}

// Données pour le graphique de répartition des catégories
$sql = "SELECT categorie, COUNT(*) as count FROM users GROUP BY categorie ORDER BY count DESC LIMIT 6";
$stmt = $db->prepare($sql);
$stmt->execute();
$categoriesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categoryLabels = [];
$categoryCounts = [];

foreach ($categoriesData as $category) {
    $categoryLabels[] = $category['categorie'] ?: 'Non spécifié';
    $categoryCounts[] = $category['count'];
}
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Tableau de bord</h1>
    <p class="dashboard-subtitle">Bienvenue, <?php echo $admin['nom']; ?>! Voici un aperçu de votre plateforme.</p>
</div>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" data-auto-dismiss="5000">
        <i class="fas fa-check-circle"></i>
        <?php echo $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<div class="stats-grid">
    <div class="stat-card users">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>Professionnels</h3>
        <div class="stat-value"><?php echo $stats['users']; ?></div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i> +5% ce mois
        </div>
    </div>

    <div class="stat-card entreprises">
        <div class="stat-icon">
            <i class="fas fa-building"></i>
        </div>
        <h3>Entreprises</h3>
        <div class="stat-value"><?php echo $stats['entreprises']; ?></div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i> +3% ce mois
        </div>
    </div>

    <div class="stat-card offres">
        <div class="stat-icon">
            <i class="fas fa-briefcase"></i>
        </div>
        <h3>Offres d'emploi</h3>
        <div class="stat-value"><?php echo $stats['offres']; ?></div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i> +7% ce mois
        </div>
    </div>

    <div class="stat-card candidatures">
        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <h3>Candidatures</h3>
        <div class="stat-value"><?php echo $stats['candidatures']; ?></div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i> +12% ce mois
        </div>
    </div>
</div>

<div class="row">
    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">Inscriptions des utilisateurs</div>
            <div class="chart-filters">
                <select>
                    <option value="7">7 derniers mois</option>
                    <option value="12">12 derniers mois</option>
                    <option value="24">24 derniers mois</option>
                </select>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="usersChart"></canvas>
        </div>
    </div>

    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">Répartition par catégorie</div>
        </div>
        <div class="chart-body">
            <canvas id="categoriesChart"></canvas>
        </div>
    </div>
</div>

<div class="row">
    <div class="data-table-container">
        <div class="data-table-header">
            <div class="data-table-title">Derniers utilisateurs inscrits</div>
            <div class="data-table-actions">
                <button onclick="window.location.href='users.php'">
                    <i class="fas fa-eye"></i> Voir tous
                </button>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($latestUsers as $user): ?>
                    <tr>
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
            </tbody>
        </table>
    </div>

    <div class="data-table-container">
        <div class="data-table-header">
            <div class="data-table-title">Dernières entreprises inscrites</div>
            <div class="data-table-actions">
                <button onclick="window.location.href='entreprises.php'">
                    <i class="fas fa-eye"></i> Voir toutes
                </button>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Catégorie</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($latestCompanies as $company): ?>
                    <tr>
                        <td class="user-info">
                            <img src="<?php echo !empty($company['images']) ? '../upload/' . $company['images'] : 'assets/images/default-company.png'; ?>"
                                alt="<?php echo $company['entreprise']; ?>" class="user-avatar">
                            <div>
                                <div class="user-name"><?php echo $company['entreprise']; ?></div>
                                <div class="user-email"><?php echo $company['types']; ?></div>
                            </div>
                        </td>
                        <td><?php echo $company['mail']; ?></td>
                        <td><?php echo $company['phone']; ?></td>
                        <td><?php echo $company['categorie']; ?></td>
                        <td><?php echo $company['ville']; ?></td>
                        <td class="actions">
                            <button class="view-btn"
                                onclick="window.location.href='view_entreprise.php?id=<?php echo $company['id']; ?>'">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="edit-btn"
                                onclick="window.location.href='edit_entreprise.php?id=<?php echo $company['id']; ?>'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn"
                                data-confirm-delete="Êtes-vous sûr de vouloir supprimer cette entreprise ?"
                                onclick="if(confirm(this.dataset.confirmDelete)) window.location.href='delete_entreprise.php?id=<?php echo $company['id']; ?>'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Données pour les graphiques
    const userChartData = {
        labels: <?php echo json_encode($months); ?>,
        data: <?php echo json_encode($userCounts); ?>
    };

    const categoriesChartData = {
        labels: <?php echo json_encode($categoryLabels); ?>,
        data: <?php echo json_encode($categoryCounts); ?>
    };

    // Initialiser les graphiques
    document.addEventListener('DOMContentLoaded', function () {
        initCharts();
    });
</script>

<?php
include_once('includes/footer.php');
?>