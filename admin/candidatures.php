<?php
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');
include_once('../model/postulation.php');



// Paramètres de filtrage
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$offre_id = isset($_GET['offre_id']) ? intval($_GET['offre_id']) : 0;
$statut = isset($_GET['statut']) ? $_GET['statut'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$date_order = isset($_GET['date_order']) ? $_GET['date_order'] : 'DESC';

// Récupération de toutes les catégories pour le filtre
$sql_categories = "SELECT DISTINCT categorie FROM offre_emploi ORDER BY categorie";
$categories = $db->query($sql_categories)->fetchAll(PDO::FETCH_COLUMN);

// Construction de la requête SQL avec les filtres
$sql = "SELECT p.*, oe.poste, oe.categorie, ce.entreprise, ce.images as logo 
        FROM postulation p
        JOIN offre_emploi oe ON p.offre_id = oe.offre_id
        JOIN compte_entreprise ce ON oe.entreprise_id = ce.id
        WHERE 1=1";
$params = [];

if (!empty($categorie)) {
    $sql .= " AND oe.categorie = :categorie";
    $params[':categorie'] = $categorie;
}

if ($offre_id > 0) {
    $sql .= " AND oe.offre_id = :offre_id";
    $params[':offre_id'] = $offre_id;
}

if (!empty($statut)) {
    $sql .= " AND p.statut = :statut";
    $params[':statut'] = $statut;
}

if (!empty($search)) {
    $sql .= " AND (p.nom LIKE :search OR p.mail LIKE :search OR p.competences LIKE :search 
              OR p.profession LIKE :search OR oe.poste LIKE :search OR ce.entreprise LIKE :search)";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY p.date " . ($date_order == 'ASC' ? 'ASC' : 'DESC');

// Préparation et exécution de la requête
$stmt = $db->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si une catégorie est sélectionnée, récupérer les offres d'emploi correspondantes
$offres = [];
if (!empty($categorie)) {
    $sql_offres = "SELECT offre_id, poste FROM offre_emploi WHERE categorie = :categorie ORDER BY poste";
    $stmt_offres = $db->prepare($sql_offres);
    $stmt_offres->bindValue(':categorie', $categorie);
    $stmt_offres->execute();
    $offres = $stmt_offres->fetchAll(PDO::FETCH_ASSOC);
}

// Traitement des actions sur les candidatures
if (isset($_POST['action']) && isset($_POST['candidature_id'])) {
    $action = $_POST['action'];
    $candidature_id = $_POST['candidature_id'];
    $candidature_statut = '';

    if ($action === 'accepter') {
        $candidature_statut = 'accepter';
    } elseif ($action === 'rejeter') {
        $candidature_statut = 'recaler';
    }

    try {
        $stmt = $db->prepare("UPDATE postulation SET statut = :statut WHERE id = :id");
        $stmt->bindParam(':statut', $candidature_statut);
        $stmt->bindParam(':id', $candidature_id);

        if ($stmt->execute()) {
            // Enregistrement de l'action dans l'historique
            $admin_id = $_SESSION['admin'];
            $action_text = "Modification du statut de la candidature ID: " . $candidature_id . " - Nouveau statut: " . $candidature_statut;
            $stmt = $db->prepare("INSERT INTO admin_actions (admin_id, action, date) VALUES (:admin_id, :action, NOW())");
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->bindParam(':action', $action_text);
            $stmt->execute();

            $_SESSION['success_message'] = "Le statut de la candidature a été modifié avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification du statut de la candidature.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données: " . $e->getMessage();
    }

    // Redirection pour éviter les soumissions multiples
    header("Location: candidatures.php?" . http_build_query($_GET));
    exit;
}

// Statistiques des candidatures
$stats = [
    'total' => count($candidatures),
    'acceptees' => 0,
    'rejetees' => 0,
    'en_attente' => 0
];

foreach ($candidatures as $c) {
    if ($c['statut'] === 'accepter') {
        $stats['acceptees']++;
    } elseif ($c['statut'] === 'recaler') {
        $stats['rejetees']++;
    } else {
        $stats['en_attente']++;
    }
}

include_once('includes/header.php');
?>

<div class="dashboard-header">
    <h1>Gestion des candidatures</h1>
    <p>Visualisation et traitement des candidatures par offre et catégorie</p>
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

<!-- Statistiques des candidatures -->
<div class="stats-grid">
    <div class="stat-card">
        <i class="fas fa-users"></i>
        <div>
            <h3><?php echo $stats['total']; ?></h3>
            <p>Candidatures totales</p>
        </div>
    </div>
    <div class="stat-card">
        <i class="fas fa-check-circle"></i>
        <div>
            <h3><?php echo $stats['acceptees']; ?></h3>
            <p>Acceptées</p>
        </div>
    </div>
    <div class="stat-card">
        <i class="fas fa-times-circle"></i>
        <div>
            <h3><?php echo $stats['rejetees']; ?></h3>
            <p>Rejetées</p>
        </div>
    </div>
    <div class="stat-card">
        <i class="fas fa-clock"></i>
        <div>
            <h3><?php echo $stats['en_attente']; ?></h3>
            <p>En attente</p>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="filters-container">
    <form method="GET" action="" class="filters-form">
        <div class="form-row">
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $cat === $categorie ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="offre_id">Offre d'emploi</label>
                <select id="offre_id" name="offre_id" <?php echo empty($categorie) ? 'disabled' : ''; ?>>
                    <option value="0">Toutes les offres</option>
                    <?php foreach ($offres as $offre): ?>
                        <option value="<?php echo $offre['offre_id']; ?>" <?php echo $offre_id == $offre['offre_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($offre['poste']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="statut">Statut</label>
                <select id="statut" name="statut">
                    <option value="">Tous</option>
                    <option value="" <?php echo $statut === '' ? 'selected' : ''; ?>>En attente</option>
                    <option value="accepter" <?php echo $statut === 'accepter' ? 'selected' : ''; ?>>Acceptées</option>
                    <option value="recaler" <?php echo $statut === 'recaler' ? 'selected' : ''; ?>>Rejetées</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date_order">Tri par date</label>
                <select id="date_order" name="date_order">
                    <option value="DESC" <?php echo $date_order === 'DESC' ? 'selected' : ''; ?>>Plus récentes</option>
                    <option value="ASC" <?php echo $date_order === 'ASC' ? 'selected' : ''; ?>>Plus anciennes</option>
                </select>
            </div>
        </div>

        <div class="form-row search-row">
            <div class="form-group search-group">
                <input type="text" id="search" name="search" placeholder="Rechercher..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </div>
            <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
        </div>
    </form>
</div>

<!-- Liste des candidatures -->
<div class="candidatures-container">
    <?php if (empty($candidatures)): ?>
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <p>Aucune candidature ne correspond à vos critères de recherche.</p>
            <p class="sub-message">Essayez de modifier vos filtres ou d'élargir votre recherche.</p>
        </div>
    <?php else: ?>
        <div class="candidatures-grid">
            <?php foreach ($candidatures as $candidature): ?>
                <div class="candidature-card <?php echo $candidature['statut'] ? 'status-' . $candidature['statut'] : ''; ?>">
                    <div class="candidature-header">
                        <div class="candidate-info">
                            <h3><?php echo htmlspecialchars($candidature['nom']); ?></h3>
                            <p class="profession"><?php echo htmlspecialchars($candidature['profession']); ?></p>
                        </div>
                        <?php if ($candidature['statut']): ?>
                            <div class="status-badge status-<?php echo $candidature['statut']; ?>">
                                <?php echo $candidature['statut'] === 'accepter' ? 'Acceptée' : 'Rejetée'; ?>
                            </div>
                        <?php else: ?>
                            <div class="status-badge status-pending">En attente</div>
                        <?php endif; ?>
                    </div>

                    <div class="candidature-body">
                        <div class="offer-info">
                            <div class="company-logo">
                                <img src="../upload/<?php echo !empty($candidature['logo']) ? htmlspecialchars($candidature['logo']) : 'default-company.png'; ?>"
                                    alt="Logo entreprise">
                            </div>
                            <div class="offer-details">
                                <h4><?php echo htmlspecialchars($candidature['poste']); ?></h4>
                                <p><?php echo htmlspecialchars($candidature['entreprise']); ?></p>
                                <span class="offer-category"><?php echo htmlspecialchars($candidature['categorie']); ?></span>
                            </div>
                        </div>

                        <div class="contact-info">
                            <div class="info-item">
                                <i class="fas fa-envelope"></i>
                                <span><?php echo htmlspecialchars($candidature['mail']); ?></span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <span><?php echo htmlspecialchars($candidature['phone']); ?></span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <span>Postuléle <?php echo date('d/m/Y', strtotime($candidature['date'])); ?></span>
                            </div>
                        </div>

                        <div class="skills">
                            <h5>Compétences</h5>
                            <p><?php echo htmlspecialchars($candidature['competences']); ?></p>
                        </div>
                    </div>

                    <div class="candidature-actions">
                        <a href="cv_preview.php?candidature_id=<?php echo $candidature['poste_id']; ?>" class="btn btn-view">
                            <i class="fas fa-eye"></i> Voir CV
                        </a>

                        <?php if ($candidature['statut'] !== 'accepter'): ?>
                            <form method="POST" action="" class="action-form">
                                <input type="hidden" name="candidature_id" value="<?php echo $candidature['poste_id']; ?>">
                                <input type="hidden" name="action" value="accepter">
                                <button type="submit" class="btn btn-accept">
                                    <i class="fas fa-check"></i> Accepter
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if ($candidature['statut'] !== 'recaler'): ?>
                            <form method="POST" action="" class="action-form">
                                <input type="hidden" name="candidature_id" value="<?php echo $candidature['id']; ?>">
                                <input type="hidden" name="action" value="rejeter">
                                <button type="submit" class="btn btn-reject">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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

    /* Styles pour les statistiques */
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

    /* Styles pour les filtres */
    .filters-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .form-group select,
    .form-group input {
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }

    .search-group {
        position: relative;
        flex: 2;
    }

    .search-btn {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
    }

    .search-row {
        align-items: stretch;
    }

    .btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    /* Styles pour les candidatures */
    .candidatures-container {
        margin-bottom: 2rem;
    }

    .candidatures-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .candidatures-grid {
            grid-template-columns: 1fr;
        }
    }

    .candidature-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .candidature-card:hover {
        transform: translateY(-0.25rem);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .candidature-card.status-accepter {
        border-left: 4px solid var(--success-color);
    }

    .candidature-card.status-recaler {
        border-left: 4px solid var(--danger-color);
    }

    .candidature-header {
        padding: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
    }

    .candidate-info h3 {
        margin: 0;
        font-size: 1.125rem;
        color: var(--text-color);
    }

    .profession {
        margin: 0.25rem 0 0 0;
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-accepter {
        background: #dcfce7;
        color: var(--success-color);
    }

    .status-recaler {
        background: #fee2e2;
        color: var(--danger-color);
    }

    .status-pending {
        background: #f3f4f6;
        color: var(--text-light);
    }

    .candidature-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .offer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .company-logo {
        width: 3rem;
        height: 3rem;
        border-radius: 0.375rem;
        overflow: hidden;
        background: var(--bg-light);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .company-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .offer-details h4 {
        margin: 0;
        font-size: 1rem;
        color: var(--primary-color);
    }

    .offer-details p {
        margin: 0.25rem 0;
        color: var(--text-color);
        font-size: 0.875rem;
    }

    .offer-category {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        background: var(--bg-light);
        border-radius: 0.25rem;
        font-size: 0.75rem;
        color: var(--text-light);
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-light);
    }

    .info-item i {
        color: var(--primary-color);
        font-size: 0.75rem;
        width: 1rem;
        text-align: center;
    }

    .skills {
        margin-top: 0.5rem;
    }

    .skills h5 {
        margin: 0 0 0.5rem 0;
        font-size: 0.875rem;
        color: var(--text-color);
    }

    .skills p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-light);
        line-height: 1.5;
    }

    .candidature-actions {
        padding: 1.25rem;
        background: var(--bg-light);
        display: flex;
        gap: 0.75rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
    }

    .btn-view:hover {
        background: var(--primary-dark);
    }

    .btn-accept {
        background: var(--success-color);
        color: white;
    }

    .btn-accept:hover {
        background: #16a34a;
    }

    .btn-reject {
        background: var(--danger-color);
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
    }

    /* État vide */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 1.125rem;
        color: var(--text-color);
    }

    .sub-message {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-light);
    }

    /* Alertes */
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
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
        // Gestion du changement de catégorie pour filtrer les offres
        const categorieSelect = document.getElementById('categorie');
        const offreSelect = document.getElementById('offre_id');

        categorieSelect.addEventListener('change', function () {
            if (this.value === '') {
                offreSelect.disabled = true;
                offreSelect.value = 0;
            } else {
                offreSelect.disabled = false;
                // On pourrait ajouter un appel AJAX ici pour charger les offres de la catégorie sélectionnée
            }
        });

        // Confirmation pour les actions sur les candidatures
        const actionForms = document.querySelectorAll('.action-form');
        actionForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const action = this.querySelector('[name="action"]').value;
                const confirmMessage = action === 'accepter'
                    ? 'Êtes-vous sûr de vouloir accepter cette candidature ?'
                    : 'Êtes-vous sûr de vouloir rejeter cette candidature ?';

                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>