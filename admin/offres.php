<?php
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');



// Récupération des informations de l'administrateur

// Récupération des statistiques globales en une seule requête
$sql_stats = "SELECT 
    (SELECT COUNT(*) FROM offre_emploi) as total_offres,
    (SELECT COUNT(*) FROM offre_emploi WHERE statut = 'active') as offres_actives,
    (SELECT COUNT(*) FROM offre_emploi WHERE statut = 'expirée') as offres_expirees,
    (SELECT COUNT(*) FROM offre_emploi WHERE date_expiration < CURDATE()) as offres_expirant,
    (SELECT COUNT(DISTINCT entreprise_id) FROM offre_emploi) as nb_entreprises";
$stats = $db->query($sql_stats)->fetch(PDO::FETCH_ASSOC);

// Récupération des statistiques par catégorie
$sql_categories = "SELECT 
    categorie,
    COUNT(*) as nb_offres,
    SUM(CASE WHEN statut = 'active' THEN 1 ELSE 0 END) as offres_actives,
    COUNT(DISTINCT entreprise_id) as nb_entreprises
    FROM offre_emploi 
    GROUP BY categorie 
    ORDER BY nb_offres DESC";
$categories = $db->query($sql_categories)->fetchAll(PDO::FETCH_ASSOC);

// Récupération des offres récentes avec informations entreprise
$sql_recent = "SELECT 
    oe.offre_id, 
    oe.poste, 
    oe.statut, 
    oe.date, 
    oe.categorie,
    ce.entreprise, 
    ce.images as logo
    FROM offre_emploi oe
    JOIN compte_entreprise ce ON oe.entreprise_id = ce.id
    ORDER BY oe.date DESC
    LIMIT 5";
$recent_offres = $db->query($sql_recent)->fetchAll(PDO::FETCH_ASSOC);

// Récupération des données pour le graphique (6 derniers mois)
$sql_postulations = "SELECT 
    DATE_FORMAT(date, '%Y-%m') as mois,
    COUNT(*) as nb_postulations
    FROM postulation
    WHERE date >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(date, '%Y-%m')
    ORDER BY mois";
$postulations = $db->query($sql_postulations)->fetchAll(PDO::FETCH_ASSOC);

// Formatage des données pour le graphique
$chart_data = [
    'months' => array_map(function ($data) {
        return (new DateTime($data['mois'] . '-01'))->format('M Y');
    }, $postulations),
    'counts' => array_column($postulations, 'nb_postulations')
];

include('includes/header.php');
?>

<!-- En-tête du tableau de bord -->
<div class="dashboard-header">
    <h1>Gestion des offres d'emploi</h1>
    <p>Vue d'ensemble et statistiques</p>
</div>

<!-- Messages de notification -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['success_message'];
        unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<!-- Statistiques globales -->
<div class="stats-grid">
    <div class="stat-card">
        <i class="fas fa-briefcase"></i>
        <div>
            <h3><?php echo $stats['total_offres']; ?></h3>
            <p>Offres totales</p>
        </div>
    </div>
    <div class="stat-card">
        <i class="fas fa-check-circle"></i>
        <div>
            <h3><?php echo $stats['offres_actives']; ?></h3>
            <p>Offres actives</p>
        </div>
    </div>
    <div class="stat-card">
        <i class="fas fa-clock"></i>
        <div>
            <h3><?php echo $stats['offres_expirees']; ?></h3>
            <p>Offres expirées</p>
        </div>
    </div>
    <div class="stat-card">
        <i class="fas fa-building"></i>
        <div>
            <h3><?php echo $stats['nb_entreprises']; ?></h3>
            <p>Entreprises</p>
        </div>
    </div>
</div>

<!-- Graphique et catégories -->
<div class="dashboard-grid">
    <!-- Graphique des postulations -->
    <div class="dashboard-card chart-container">
        <h2>Évolution des candidatures</h2>
        <canvas id="postulationsChart"></canvas>
    </div>

    <!-- Liste des catégories -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Offres par catégorie</h2>
            <a href="offres_categorie.php" class="btn-link">Voir tout</a>
        </div>
        <div class="categories-list">
            <?php foreach ($categories as $cat): ?>
                <a href="offres_categorie.php?categorie=<?php echo urlencode($cat['categorie']); ?>" class="category-item">
                    <div class="category-info">
                        <h3><?php echo htmlspecialchars($cat['categorie']); ?></h3>
                        <div class="category-stats">
                            <span><?php echo $cat['nb_offres']; ?> offres</span>
                            <span><?php echo $cat['offres_actives']; ?> actives</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Offres récentes -->
<div class="dashboard-card">
    <div class="card-header">
        <h2>Offres récentes</h2>
        <a href="offres_categorie.php" class="btn-link">Voir tout</a>
    </div>
    <div class="recent-offers">
        <?php if (empty($recent_offres)): ?>
            <p class="empty-state">Aucune offre récente</p>
        <?php else: ?>
            <?php foreach ($recent_offres as $offre): ?>
                <a href="offre_details.php?id=<?php echo $offre['offre_id']; ?>" class="offer-item">
                    <img src="../upload/<?php echo !empty($offre['logo']) ? htmlspecialchars($offre['logo']) : 'default-company.png'; ?>"
                        alt="Logo" class="offer-logo">
                    <div class="offer-info">
                        <h3><?php echo htmlspecialchars($offre['poste']); ?></h3>
                        <p><?php echo htmlspecialchars($offre['entreprise']); ?></p>
                        <div class="offer-meta">
                            <span><?php echo htmlspecialchars($offre['categorie']); ?></span>
                            <span>Publié le <?php echo date('d/m/Y', strtotime($offre['date'])); ?></span>
                        </div>
                    </div>
                    <span class="status-badge <?php echo strtolower($offre['statut']); ?>">
                        <?php echo htmlspecialchars($offre['statut']); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Actions rapides -->
<div class="quick-actions">
    <a href="recherche_offres.php" class="action-btn">
        <i class="fas fa-search"></i>
        <span>Recherche avancée</span>
    </a>
    <a href="offres_expirees.php" class="action-btn">
        <i class="fas fa-calendar-times"></i>
        <span>Offres expirées</span>
    </a>
    <a href="offres_categorie.php" class="action-btn">
        <i class="fas fa-th-list"></i>
        <span>Toutes les offres</span>
    </a>
    <a href="statistiques_offres.php" class="action-btn">
        <i class="fas fa-chart-pie"></i>
        <span>Statistiques</span>
    </a>
</div>

<style>
    /* Variables CSS */
    :root {
        --primary-color: #2563eb;
        --primary-dark: #1d4ed8;
        --success-color: #22c55e;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --text-color: #1f2937;
        --text-light: #6b7280;
        --border-color: #e5e7eb;
        --bg-light: #f9fafb;
    }

    /* Layout général */
    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        font-size: 1.875rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0;
    }

    .dashboard-header p {
        color: var(--text-light);
        margin-top: 0.5rem;
    }

    /* Grille des statistiques */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card i {
        font-size: 1.5rem;
        color: var(--primary-color);
        background: var(--bg-light);
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .stat-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-color);
    }

    .stat-card p {
        margin: 0;
        color: var(--text-light);
    }

    /* Grille du tableau de bord */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Cartes du tableau de bord */
    .dashboard-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-color);
    }

    .btn-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    /* Liste des catégories */
    .categories-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: 0.5rem;
        text-decoration: none;
        color: var(--text-color);
        transition: transform 0.2s;
    }

    .category-item:hover {
        transform: translateX(0.25rem);
    }

    .category-info h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 500;
    }

    .category-stats {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }

    /* Offres récentes */
    .recent-offers {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .offer-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: 0.5rem;
        text-decoration: none;
        color: var(--text-color);
    }

    .offer-logo {
        width: 3rem;
        height: 3rem;
        border-radius: 0.375rem;
        object-fit: contain;
    }

    .offer-info {
        flex: 1;
    }

    .offer-info h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 500;
    }

    .offer-info p {
        margin: 0.25rem 0;
        color: var(--primary-color);
        font-size: 0.875rem;
    }

    .offer-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: var(--text-light);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: #dcfce7;
        color: var(--success-color);
    }

    .status-badge.expirée {
        background: #fee2e2;
        color: var(--danger-color);
    }

    /* Actions rapides */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.5rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: var(--text-color);
        transition: transform 0.2s;
    }

    .action-btn:hover {
        transform: translateY(-0.25rem);
    }

    .action-btn i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    /* Graphique */
    .chart-container {
        height: 400px;
    }

    /* États vides */
    .empty-state {
        text-align: center;
        color: var(--text-light);
        padding: 2rem;
    }

    /* Alertes */
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        animation: fadeOut 0.5s ease-in-out 4.5s forwards;
    }

    .alert-success {
        background: #dcfce7;
        color: var(--success-color);
    }

    .alert-danger {
        background: #fee2e2;
        color: var(--danger-color);
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
            visibility: hidden;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Configuration du graphique
        const ctx = document.getElementById('postulationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chart_data['months']); ?>,
                datasets: [{
                    label: 'Candidatures',
                    data: <?php echo json_encode($chart_data['counts']); ?>,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>