<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/fcm_tokens_users.php');
require_once(__DIR__ . '/../model/fcm_notification.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['users_id'])) {
    header('Location: login.php');
    exit;
}

$users_id = $_SESSION['users_id'];
$token = getUserToken($db, $users_id);
$hasToken = !empty($token);

// Traiter l'envoi du formulaire de test
if (isset($_POST['send_test'])) {
    $title = htmlspecialchars($_POST['title']);
    $message = htmlspecialchars($_POST['message']);

    // Créer et envoyer la notification
    $notification = [
        'title' => $title,
        'body' => $message
    ];

    $data = [
        'type' => 'test',
        'timestamp' => time()
    ];

    $result = sendUserFCMNotification($db, $users_id, $notification, $data);

    if ($result) {
        $success_message = "Notification envoyée avec succès!";
    } else {
        $error_message = "Échec de l'envoi de la notification.";
    }
}

// Récupérer les logs de notifications pour cet utilisateur
$stmt = $db->prepare("SELECT * FROM notification_logs WHERE users_id = :users_id ORDER BY sent_at DESC LIMIT 10");
$stmt->bindParam(':users_id', $users_id);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test des notifications - Work-Flexer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #0671dc;
            color: white;
            font-weight: bold;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #0671dc;
            border-color: #0671dc;
        }

        .btn-primary:hover {
            background-color: #045cb9;
            border-color: #045cb9;
        }

        .log-item {
            border-left: 4px solid #0671dc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }

        .log-failed {
            border-left-color: #dc3545;
        }

        .log-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .token-info {
            word-break: break-all;
            font-size: 0.8rem;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4"><i class="fas fa-bell"></i> Test des notifications push</h2>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informations
            </div>
            <div class="card-body">
                <p>Cette page vous permet de tester les notifications push pour votre compte.</p>

                <?php if ($hasToken): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Les notifications sont activées pour votre compte.
                    </div>
                    <p><strong>Token FCM:</strong></p>
                    <div class="token-info">
                        <?php echo $token; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Les notifications ne sont pas encore activées pour votre
                        compte.
                    </div>
                    <p>Pour activer les notifications, retournez sur <a href="user_profil.php">votre profil</a> et cliquez
                        sur le bouton "Activer les notifications".</p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($hasToken): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-paper-plane"></i> Envoyer une notification de test
                </div>
                <div class="card-body">
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle"></i> <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="form-group">
                            <label for="title">Titre de la notification</label>
                            <input type="text" class="form-control" id="title" name="title" value="Notification de test"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"
                                required>Ceci est une notification de test pour vérifier que tout fonctionne correctement.</textarea>
                        </div>
                        <button type="submit" name="send_test" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Envoyer la notification
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> Historique des notifications
            </div>
            <div class="card-body">
                <?php if (empty($logs)): ?>
                    <p>Aucune notification n'a encore été envoyée à votre compte.</p>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <div class="log-item <?php echo $log['status'] === 'failed' ? 'log-failed' : ''; ?>">
                            <div class="log-time">
                                <i class="fas fa-clock"></i> <?php echo date('d/m/Y H:i:s', strtotime($log['sent_at'])); ?>
                                -
                                <?php if ($log['status'] === 'sent'): ?>
                                    <span class="badge badge-success">Envoyée</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Échec</span>
                                <?php endif; ?>
                            </div>
                            <h5><?php echo htmlspecialchars($log['title']); ?></h5>
                            <p><?php echo htmlspecialchars($log['body']); ?></p>
                            <?php if ($log['status'] === 'failed' && !empty($log['error_message'])): ?>
                                <div class="text-danger">
                                    <small><i class="fas fa-exclamation-circle"></i> Erreur:
                                        <?php echo htmlspecialchars($log['error_message']); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="user_profil.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour au profil
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>