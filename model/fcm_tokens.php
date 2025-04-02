<?php
/**
 * FCM token management functions
 */

/**
 * Save or update FCM token for an enterprise
 * @param PDO $db Database connection
 * @param string $entreprise_id Enterprise ID
 * @param string $token FCM token
 * @return bool Success status
 */
function saveEnterpriseToken($db, $entreprise_id, $token)
{
    if (empty($entreprise_id) || empty($token)) {
        error_log("FCM Token Error: Empty enterprise_id or token passed to saveEnterpriseToken");
        return false;
    }

    try {
        // First check if token already exists
        $sql = "SELECT * FROM fcm_tokens WHERE entreprise_id = :entreprise_id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
        $stmt->execute();

        $exists = $stmt->rowCount() > 0;
        error_log("FCM Token Check: Token for enterprise $entreprise_id exists: " . ($exists ? 'yes' : 'no'));

        if ($exists) {
            // Update existing token
            $sql = "UPDATE fcm_tokens SET token = :token, updated_at = NOW() WHERE entreprise_id = :entreprise_id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':token', $token, PDO::PARAM_STR);
            $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
            $result = $stmt->execute();
            error_log("FCM Token Update: Result for enterprise $entreprise_id: " . ($result ? 'success' : 'failed'));
            return $result;
        } else {
            // Insert new token
            $sql = "INSERT INTO fcm_tokens (entreprise_id, token, created_at, updated_at) 
                    VALUES (:entreprise_id, :token, NOW(), NOW())";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
            $stmt->bindValue(':token', $token, PDO::PARAM_STR);
            $result = $stmt->execute();
            error_log("FCM Token Insert: Result for enterprise $entreprise_id: " . ($result ? 'success' : 'failed'));
            return $result;
        }
    } catch (PDOException $e) {
        error_log("FCM Token DB Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get FCM token for an enterprise
 * @param PDO $db Database connection
 * @param string $entreprise_id Enterprise ID
 * @return string|null FCM token or null if not found
 */
function getEnterpriseToken($db, $entreprise_id)
{
    $sql = "SELECT token FROM fcm_tokens WHERE entreprise_id = :entreprise_id LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['token'] : null;
}

/**
 * Delete FCM token for an enterprise
 * @param PDO $db Database connection
 * @param string $entreprise_id Enterprise ID
 * @return bool Success status
 */
function deleteEnterpriseToken($db, $entreprise_id)
{
    $sql = "DELETE FROM fcm_tokens WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    return $stmt->execute();
}