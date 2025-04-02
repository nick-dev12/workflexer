<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/notification_logs.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: login.php');
    exit;
}

// Entreprise ID
$entreprise_id = $_SESSION['compte_entreprise'];

// Pagination
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Filtre par statut
$status_filter = isset($_GET['status']) ? $_GET['status'] : null;

// Récupérer les logs
if ($status_filter) {
    // Si un filtre est appliqué, récupérer les logs filtrés
    $where = "WHERE entreprise_id = :entreprise_id AND status = :status";
    $params = [
        ':entreprise_id' => $entreprise_id,
        ':status' => $status_filter,
        ':limit' => $limit,
        ':offset' => $offset
    ];

    $sql = "SELECT * FROM notification_logs 
            $where
            ORDER BY sent_at DESC 
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);

    foreach ($params as $key => $value) {
        if (strpos($key, 'limit') !== false || strpos($key, 'offset') !== false) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value);
        }
    }

    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compter le total pour la pagination
    $countSql = "SELECT COUNT(*) FROM notification_logs WHERE entreprise_id = :entreprise_id AND status = :status";
    $countStmt = $db->prepare($countSql);
    $countStmt->bindParam(':entreprise_id', $entreprise_id);
    $countStmt->bindParam(':status', $status_filter);
    $countStmt->execute();
    $total = $countStmt->fetchColumn();
} else {
    // Sinon, récupérer tous les logs
    $logs = getEnterpriseNotificationLogs($db, $entreprise_id, $limit, $offset);

    // Compter le total pour la pagination
    $countSql = "SELECT COUNT(*) FROM notification_logs WHERE entreprise_id = :entreprise_id";
    $countStmt = $db->prepare($countSql);
    $countStmt->bindParam(':entreprise_id', $entreprise_id);
    $countStmt->execute();
    $total = $countStmt->fetchColumn();
}

// Statistiques
$stats = getNotificationStats($db, $entreprise_id);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs des notifications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .table-responsive {
            margin-top: 20px;
        }

        .badge-sent {
            background-color: #28a745;
        }

        .badge-failed {
            background-color: #dc3545;
        }

        .stats-card {
            margin-bottom: 20px;
        }

        .pagination {
            margin-top: 20px;
            justify-content: center;
        }

        .json-preview {
            max-width: 250px;
            max-height: 50px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .details-panel {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                <li class="breadcrumb-item active" aria-current="page">Logs des notifications</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-bell"></i> Logs des notifications</h1>
                <p>Consultez l'historique des notifications envoyées et leur statut.</p>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row">
            <?php foreach ($stats as $stat): ?>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <?php if ($stat['status'] == 'sent'): ?>
                                    <span class="badge badge-success">Envoyées</span>
                                <?php elseif ($stat['status'] == 'failed'): ?>
                                    <span class="badge badge-danger">Échouées</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= htmlspecialchars($stat['status']) ?></span>
                                <?php endif; ?>
                            </h5>
                            <p class="card-text display-4"><?= htmlspecialchars($stat['count']) ?></p>
                            <a href="?status=<?= urlencode($stat['status']) ?>"
                                class="btn btn-sm btn-outline-primary">Filtrer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <span class="badge badge-info">Total</span>
                        </h5>
                        <p class="card-text display-4"><?= $total ?></p>
                        <a href="?" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($status_filter): ?>
            <div class="alert alert-info">
                <i class="fas fa-filter"></i> Filtrage actif:
                <?php if ($status_filter == 'sent'): ?>
                    <strong>Notifications envoyées</strong>
                <?php elseif ($status_filter == 'failed'): ?>
                    <strong>Notifications échouées</strong>
                <?php else: ?>
                    <strong><?= htmlspecialchars($status_filter) ?></strong>
                <?php endif; ?>
                <a href="?" class="btn btn-sm btn-outline-dark ml-2">Supprimer le filtre</a>
            </div>
        <?php endif; ?>

        <!-- Tableau des logs -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Titre</th>
                        <th>Destinataire</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune notification trouvée</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($log['sent_at'])) ?></td>
                                <td><?= htmlspecialchars($log['notification_type']) ?></td>
                                <td><?= htmlspecialchars($log['title']) ?></td>
                                <td>Utilisateur #<?= htmlspecialchars($log['users_id']) ?></td>
                                <td>
                                    <?php if ($log['status'] == 'sent'): ?>
                                        <span class="badge badge-success">Envoyée</span>
                                    <?php elseif ($log['status'] == 'failed'): ?>
                                        <span class="badge badge-danger">Échouée</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary"><?= htmlspecialchars($log['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info show-details" data-id="<?= $log['id'] ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div class="details-panel" id="details-<?= $log['id'] ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Détails de la notification</h5>
                                                <p><strong>Message:</strong> <?= htmlspecialchars($log['body']) ?></p>
                                                <p><strong>Type:</strong> <?= htmlspecialchars($log['notification_type']) ?></p>
                                                <p><strong>Date d'envoi:</strong>
                                                    <?= date('d/m/Y H:i:s', strtotime($log['sent_at'])) ?></p>
                                                <p><strong>ID Notification:</strong> <?= $log['id'] ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Données techniques</h5>
                                                <?php if (!empty($log['data'])): ?>
                                                    <p><strong>Données:</strong> <code><?= htmlspecialchars($log['data']) ?></code>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (!empty($log['response_code'])): ?>
                                                    <p><strong>Code de réponse:</strong>
                                                        <?= htmlspecialchars($log['response_code']) ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($log['error_message'])): ?>
                                                    <div class="alert alert-danger">
                                                        <strong>Erreur:</strong> <?= htmlspecialchars($log['error_message']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total > $limit): ?>
            <nav aria-label="Pagination des notifications">
                <ul class="pagination">
                    <?php
                    $totalPages = ceil($total / $limit);
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);

                    // Lien précédent
                    if ($page > 1):
                        ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="?page=<?= $page - 1 ?><?= $status_filter ? '&status=' . urlencode($status_filter) : '' ?>"
                                aria-label="Précédent">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $i ?><?= $status_filter ? '&status=' . urlencode($status_filter) : '' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="?page=<?= $page + 1 ?><?= $status_filter ? '&status=' . urlencode($status_filter) : '' ?>"
                                aria-label="Suivant">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Afficher/masquer les détails d'une notification
        document.querySelectorAll('.show-details').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const details = document.getElementById('details-' + id);

                // Toggle visibility
                if (details.style.display === 'block') {
                    details.style.display = 'none';
                } else {
                    // Hide all other details first
                    document.querySelectorAll('.details-panel').forEach(panel => {
                        panel.style.display = 'none';
                    });
                    details.style.display = 'block';
                }
            });
        });
    </script>
</body>

</html>