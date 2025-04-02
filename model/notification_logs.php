<?php
/**
 * Fonctions pour gérer les logs de notifications
 */

/**
 * Enregistre une notification dans les logs
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $entreprise_id ID de l'entreprise destinataire
 * @param string $users_id ID de l'utilisateur concerné
 * @param string $notification_type Type de notification (application, message, etc.)
 * @param array $notification Tableau contenant title et body de la notification
 * @param array $data Données additionnelles de la notification
 * @param string $status Statut de l'envoi (sent, failed, etc.)
 * @param string $response_code Code de réponse de l'API FCM
 * @param string $response_message Message de réponse de l'API FCM
 * @param string $token_used Token FCM utilisé pour l'envoi
 * @param string $error_message Message d'erreur éventuel
 * @return bool Succès de l'opération
 */
function logNotification($db, $entreprise_id, $users_id, $notification_type, $notification, $data = null, $status = 'sent', $response_code = null, $response_message = null, $token_used = null, $error_message = null)
{
    try {
        // Convertir les tableaux en JSON pour le stockage
        $title = isset($notification['title']) ? $notification['title'] : '';
        $body = isset($notification['body']) ? $notification['body'] : '';
        $data_json = ($data !== null) ? json_encode($data) : null;

        $sql = "INSERT INTO notification_logs (
                entreprise_id, 
                users_id, 
                notification_type, 
                title, 
                body, 
                data, 
                status, 
                response_code, 
                response_message, 
                token_used, 
                error_message
            ) VALUES (
                :entreprise_id, 
                :users_id, 
                :notification_type, 
                :title, 
                :body, 
                :data, 
                :status, 
                :response_code, 
                :response_message, 
                :token_used, 
                :error_message
            )";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':entreprise_id', $entreprise_id);
        $stmt->bindParam(':users_id', $users_id);
        $stmt->bindParam(':notification_type', $notification_type);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':data', $data_json);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':response_code', $response_code);
        $stmt->bindParam(':response_message', $response_message);
        $stmt->bindParam(':token_used', $token_used);
        $stmt->bindParam(':error_message', $error_message);

        $result = $stmt->execute();

        if ($result) {
            error_log("Notification logged successfully: $notification_type for user $users_id to entreprise $entreprise_id");
        } else {
            error_log("Failed to log notification: " . json_encode($stmt->errorInfo()));
        }

        return $result;
    } catch (PDOException $e) {
        error_log("Database error when logging notification: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Error when logging notification: " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère toutes les notifications envoyées à une entreprise
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $entreprise_id ID de l'entreprise
 * @param int $limit Nombre maximum de résultats
 * @param int $offset Décalage pour la pagination
 * @return array Tableau des notifications
 */
function getEnterpriseNotificationLogs($db, $entreprise_id, $limit = 50, $offset = 0)
{
    $sql = "SELECT * FROM notification_logs 
            WHERE entreprise_id = :entreprise_id 
            ORDER BY sent_at DESC 
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les notifications concernant un utilisateur
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $users_id ID de l'utilisateur
 * @param int $limit Nombre maximum de résultats
 * @param int $offset Décalage pour la pagination
 * @return array Tableau des notifications
 */
function getUserNotificationLogs($db, $users_id, $limit = 50, $offset = 0)
{
    $sql = "SELECT * FROM notification_logs 
            WHERE users_id = :users_id 
            ORDER BY sent_at DESC 
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les statistiques des notifications par statut
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $entreprise_id ID de l'entreprise (optionnel)
 * @return array Tableau des statistiques
 */
function getNotificationStats($db, $entreprise_id = null)
{
    $where = "";
    $params = [];

    if ($entreprise_id !== null) {
        $where = "WHERE entreprise_id = :entreprise_id";
        $params[':entreprise_id'] = $entreprise_id;
    }

    $sql = "SELECT status, COUNT(*) as count 
            FROM notification_logs 
            $where
            GROUP BY status";

    $stmt = $db->prepare($sql);

    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les notifications avec erreurs
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $entreprise_id ID de l'entreprise (optionnel)
 * @param int $limit Nombre maximum de résultats
 * @param int $offset Décalage pour la pagination
 * @return array Tableau des notifications avec erreurs
 */
function getFailedNotifications($db, $entreprise_id = null, $limit = 50, $offset = 0)
{
    $where = "WHERE status = 'failed'";
    $params = [
        ':limit' => $limit,
        ':offset' => $offset
    ];

    if ($entreprise_id !== null) {
        $where .= " AND entreprise_id = :entreprise_id";
        $params[':entreprise_id'] = $entreprise_id;
    }

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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}