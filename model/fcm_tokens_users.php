<?php
/**
 * FCM token management functions for users/candidates
 */

/**
 * Save or update FCM token for a user/candidate
 * @param PDO $db Database connection
 * @param string $users_id User ID
 * @param string $token FCM token
 * @return bool Success status
 */
function saveUserToken($db, $users_id, $token)
{
    if (empty($users_id) || empty($token)) {
        error_log("FCM Token Error: Empty users_id or token passed to saveUserToken");
        return false;
    }

    try {
        // First check if token already exists
        $sql = "SELECT token FROM fcm_tokens_users WHERE users_id = :users_id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
        $stmt->execute();

        $exists = $stmt->rowCount() > 0;
        error_log("FCM Token Check: Token for user $users_id exists: " . ($exists ? 'yes' : 'no'));

        if ($exists) {
            // Update existing token
            $sql = "UPDATE fcm_tokens_users SET token = :token, updated_at = NOW() WHERE users_id = :users_id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':token', $token, PDO::PARAM_STR);
            $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
            $result = $stmt->execute();
            error_log("FCM Token Update: Result for user $users_id: " . ($result ? 'success' : 'failed'));
            return $result;
        } else {
            // Insert new token
            $sql = "INSERT INTO fcm_tokens_users (users_id, token, created_at, updated_at) 
                    VALUES (:users_id, :token, NOW(), NOW())";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
            $stmt->bindValue(':token', $token, PDO::PARAM_STR);
            $result = $stmt->execute();
            error_log("FCM Token Insert: Result for user $users_id: " . ($result ? 'success' : 'failed'));
            return $result;
        }
    } catch (PDOException $e) {
        error_log("FCM Token DB Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get FCM token for a user/candidate
 * @param PDO $db Database connection
 * @param string $users_id User ID
 * @return string|null FCM token or null if not found
 */
function getUserToken($db, $users_id)
{
    $sql = "SELECT token FROM fcm_tokens_users WHERE users_id = :users_id LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['token'] : null;
}

/**
 * Delete FCM token for a user/candidate
 * @param PDO $db Database connection
 * @param string $users_id User ID
 * @return bool Success status
 */
function deleteUserToken($db, $users_id)
{
    $sql = "DELETE FROM fcm_tokens_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    return $stmt->execute();
}