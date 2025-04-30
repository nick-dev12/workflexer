<?php
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');
include_once('../entreprise/app/model/offre_emploi.php');



// Vérifier si l'ID de l'offre est spécifié
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID de l'offre non spécifié ou invalide.";
    header('Location: offres.php');
    exit;
}

$offre_id = $_GET['id'];

// Récupérer les détails de l'offre
$sql = "SELECT oe.*, ce.entreprise, ce.images as logo, ce.mail as email_entreprise, ce.phone as tel_entreprise, ce.ville as ville_entreprise
        FROM offre_emploi oe
        JOIN compte_entreprise ce ON oe.entreprise_id = ce.id
        WHERE oe.offre_id = :offre_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
$stmt->execute();
$offre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$offre) {
    $_SESSION['error_message'] = "L'offre d'emploi demandée n'existe pas.";
    header('Location: offres.php');
    exit;
}

// Récupérer le nombre de candidatures pour cette offre
$sql_candidatures = "SELECT COUNT(*) as nb_candidatures FROM postulation WHERE offre_id = :offre_id";
$stmt_candidatures = $db->prepare($sql_candidatures);
$stmt_candidatures->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
$stmt_candidatures->execute();
$candidatures = $stmt_candidatures->fetch(PDO::FETCH_ASSOC);

// Récupérer le nombre de vues de l'offre
$sql_vues = "SELECT COUNT(*) as nb_vues FROM vue_offre WHERE offre_id = :offre_id";
$stmt_vues = $db->prepare($sql_vues);
$stmt_vues->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
$stmt_vues->execute();
$vues = $stmt_vues->fetch(PDO::FETCH_ASSOC);

// Traitement du changement de statut si demandé
if (isset($_POST['changer_statut']) && isset($_POST['nouveau_statut'])) {
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

            // Rafraîchir les données de l'offre
            header("Location: offre_details.php?id=" . $offre_id);
            exit;
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification du statut de l'offre.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données: " . $e->getMessage();
    }
}

// Traitement de la modification de la date d'expiration
if (isset($_POST['modifier_expiration']) && isset($_POST['nouvelle_date'])) {
    $nouvelle_date = $_POST['nouvelle_date'];

    try {
        $stmt = $db->prepare("UPDATE offre_emploi SET date_expiration = :date_expiration WHERE offre_id = :offre_id");
        $stmt->bindParam(':date_expiration', $nouvelle_date);
        $stmt->bindParam(':offre_id', $offre_id);

        if ($stmt->execute()) {
            // Enregistrer dans l'historique d'administration
            $admin_id = $_SESSION['admin'];
            $action = "Modification de la date d'expiration de l'offre ID: " . $offre_id . " - Nouvelle date: " . $nouvelle_date;
            $stmt = $db->prepare("INSERT INTO admin_actions (admin_id, action, date) VALUES (:admin_id, :action, NOW())");
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->bindParam(':action', $action);
            $stmt->execute();

            $_SESSION['success_message'] = "La date d'expiration de l'offre a été modifiée avec succès.";

            // Rafraîchir les données de l'offre
            header("Location: offre_details.php?id=" . $offre_id);
            exit;
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification de la date d'expiration.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données: " . $e->getMessage();
    }
}

include_once('includes/header.php');
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Détails de l'offre d'emploi</h1>
    <p class="dashboard-subtitle"><?php echo htmlspecialchars($offre['poste']); ?> -
        <?php echo htmlspecialchars($offre['entreprise']); ?>
    </p>

    <div class="action-buttons">
        <a href="offres_categorie.php?categorie=<?php echo urlencode($offre['categorie']); ?>" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Retour aux offres
        </a>

        <div class="status-actions">
            <form method="POST" action="" class="status-form">
                <input type="hidden" name="changer_statut" value="1">
                <select name="nouveau_statut" class="status-select">
                    <option value="active" <?php echo $offre['statut'] === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="expirée" <?php echo $offre['statut'] === 'expirée' ? 'selected' : ''; ?>>Expirée
                    </option>
                </select>
                <button type="submit" class="btn btn-status">
                    <i class="fas fa-sync-alt"></i> Changer le statut
                </button>
            </form>

            <a href="#" class="btn btn-danger" onclick="confirmDelete(<?php echo $offre_id; ?>)">
                <i class="fas fa-trash-alt"></i> Supprimer l'offre
            </a>
        </div>
    </div>
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

<div class="job-detail-container">
    <!-- En-tête avec informations principales -->
    <div class="job-header-card">
        <div class="company-info">
            <div class="company-logo">
                <img src="../upload/<?php echo !empty($offre['logo']) ? htmlspecialchars($offre['logo']) : 'default-company.png'; ?>"
                    alt="<?php echo htmlspecialchars($offre['entreprise']); ?>">
            </div>
            <div class="company-details">
                <h2><?php echo htmlspecialchars($offre['entreprise']); ?></h2>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($offre['ville_entreprise']); ?></p>
                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($offre['email_entreprise']); ?></p>
                <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($offre['tel_entreprise']); ?></p>
            </div>
        </div>

        <div class="job-status-info">
            <div class="status-badge <?php echo strtolower($offre['statut']); ?>">
                <?php echo htmlspecialchars($offre['statut']); ?>
            </div>
            <div class="job-stats">
                <div class="stat-item">
                    <i class="fas fa-eye"></i>
                    <span><?php echo $vues['nb_vues']; ?> vues</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-tie"></i>
                    <span><?php echo $candidatures['nb_candidatures']; ?> candidatures</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Publiée le <?php echo date('d/m/Y', strtotime($offre['date'])); ?></span>
                </div>
            </div>

            <div class="expiration-date">
                <div class="expiration-label">Date d'expiration :</div>
                <div
                    class="expiration-value <?php echo strtotime($offre['date_expiration']) < time() ? 'expired' : ''; ?>">
                    <?php echo date('d/m/Y', strtotime($offre['date_expiration'])); ?>
                </div>
                <button class="btn btn-edit-date" onclick="showDateModal()">
                    <i class="fas fa-edit"></i> Modifier
                </button>
            </div>
        </div>
    </div>

    <!-- Détails du poste -->
    <div class="job-details-section">
        <div class="section-title">
            <i class="fas fa-briefcase"></i>
            <h3>Détails du poste</h3>
        </div>

        <div class="job-key-info">
            <div class="key-info-item">
                <div class="info-label">Intitulé du poste</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['poste']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Catégorie</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['categorie']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Type de contrat</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['contrat']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Lieu</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['localite']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Études requises</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['etudes']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Niveau d'études</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['n_etudes']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Expérience requise</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['experience']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Niveau d'expérience</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['n_experience']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Langues</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['langues']); ?></div>
            </div>
            <div class="key-info-item">
                <div class="info-label">Nombre de postes</div>
                <div class="info-value"><?php echo htmlspecialchars($offre['places']); ?></div>
            </div>
        </div>
    </div>

    <!-- Description du poste -->
    <div class="job-content-section">
        <div class="section-title">
            <i class="fas fa-tasks"></i>
            <h3>Mission</h3>
        </div>

        <div class="section-content">
            <?php echo nl2br(htmlspecialchars($offre['mission'])); ?>
        </div>
    </div>

    <!-- Profil recherché -->
    <div class="job-content-section">
        <div class="section-title">
            <i class="fas fa-user-check"></i>
            <h3>Profil recherché</h3>
        </div>

        <div class="section-content">
            <?php echo nl2br(htmlspecialchars($offre['profil'])); ?>
        </div>
    </div>

    <!-- Actions disponibles -->
    <div class="job-actions-section">
        <a href="candidatures_offre.php?offre_id=<?php echo $offre_id; ?>" class="btn btn-primary">
            <i class="fas fa-users"></i> Voir les candidatures (<?php echo $candidatures['nb_candidatures']; ?>)
        </a>

        <a href="entreprise_details.php?id=<?php echo $offre['entreprise_id']; ?>" class="btn btn-secondary">
            <i class="fas fa-building"></i> Profil de l'entreprise
        </a>

        <a href="#" class="btn btn-warning" onclick="confirmDelete(<?php echo $offre_id; ?>)">
            <i class="fas fa-trash-alt"></i> Supprimer cette offre
        </a>
    </div>
</div>

<!-- Modal pour modifier la date d'expiration -->
<div id="dateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDateModal()">&times;</span>
        <h3>Modifier la date d'expiration</h3>
        <form method="POST" action="">
            <input type="hidden" name="modifier_expiration" value="1">
            <div class="form-group">
                <label for="nouvelle_date">Nouvelle date d'expiration :</label>
                <input type="date" id="nouvelle_date" name="nouvelle_date"
                    value="<?php echo date('Y-m-d', strtotime($offre['date_expiration'])); ?>"
                    min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="closeDateModal()">Annuler</button>
                <button type="submit" class="btn btn-save">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* En-tête avec les boutons d'action */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn-back {
        background: var(--light-bg);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-actions {
        display: flex;
        gap: 10px;
    }

    .status-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-select {
        padding: 8px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: white;
    }

    .btn-status {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-danger {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Conteneur principal */
    .job-detail-container {
        margin-top: 20px;
    }

    /* En-tête avec logo et infos de l'entreprise */
    .job-header-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .company-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .company-logo {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
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

    .company-details h2 {
        margin-top: 0;
        margin-bottom: 10px;
        color: var(--text-color);
        font-size: 20px;
    }

    .company-details p {
        margin: 5px 0;
        color: var(--light-text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .job-status-info {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 15px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: #e3f7ec;
        color: #27ae60;
    }

    .status-badge.expirée {
        background: #fbe9e7;
        color: #e74c3c;
    }

    .job-stats {
        display: flex;
        gap: 15px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--light-text);
        font-size: 14px;
    }

    .expiration-date {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .expiration-label {
        font-weight: 500;
        color: var(--text-color);
    }

    .expiration-value {
        font-weight: 600;
        color: #27ae60;
    }

    .expiration-value.expired {
        color: #e74c3c;
    }

    .btn-edit-date {
        background: #f4f6f8;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        padding: 4px 8px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    /* Sections de détails */
    .job-details-section,
    .job-content-section,
    .job-actions-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 18px;
    }

    .section-title h3 {
        margin: 0;
        color: var(--text-color);
        font-size: 18px;
    }

    .job-key-info {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .key-info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .info-label {
        font-size: 14px;
        color: var(--light-text);
    }

    .info-value {
        font-weight: 500;
        color: var(--text-color);
    }

    .section-content {
        color: var(--text-color);
        line-height: 1.6;
    }

    /* Actions en bas de page */
    .job-actions-section {
        display: flex;
        justify-content: space-between;
        gap: 15px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        border: none;
    }

    .btn-secondary {
        background: #f4f6f8;
        color: var(--text-color);
        border: 1px solid var(--border-color);
    }

    .btn-warning {
        background: #fdf1f0;
        color: #e74c3c;
        border: 1px solid #fadbd8;
    }

    /* Modal pour modifier la date */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 25px;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
        position: relative;
    }

    .close {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal h3 {
        margin-top: 0;
        margin-bottom: 20px;
        color: var(--text-color);
    }

    .modal .form-group {
        margin-bottom: 20px;
    }

    .modal label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .modal input[type="date"] {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel {
        background: #f4f6f8;
        color: var(--text-color);
        border: 1px solid var(--border-color);
    }

    .btn-save {
        background: var(--primary-color);
        color: white;
        border: none;
    }

    @media (max-width: 768px) {
        .job-header-card {
            flex-direction: column;
            gap: 20px;
        }

        .job-status-info {
            align-items: flex-start;
        }

        .company-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .job-actions-section {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    // Fonctions pour le modal de modification de date
    function showDateModal() {
        document.getElementById('dateModal').style.display = 'block';
    }

    function closeDateModal() {
        document.getElementById('dateModal').style.display = 'none';
    }

    // Fonction pour confirmer la suppression
    function confirmDelete(offre_id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette offre d\'emploi ? Cette action est irréversible.')) {
            window.location.href = 'supprimer_offre.php?id=' + offre_id;
        }
    }

    // Fermer le modal si on clique en dehors
    window.onclick = function (event) {
        const modal = document.getElementById('dateModal');
        if (event.target == modal) {
            closeDateModal();
        }
    }

    // Fermeture automatique des alertes après 5 secondes
    document.addEventListener('DOMContentLoaded', function () {
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