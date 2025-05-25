<?php
require_once(__DIR__ . '/../model/fcm_tokens.php');
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../model/notification_logs.php');
require_once(__DIR__ . '/../model/fcm_tokens_users.php');

use Google\Client;

/**
 * Get access token from Firebase service account
 * @param string $serviceAccountPath Path to service account JSON file
 * @return string Access token
 */
function getAccessToken($serviceAccountPath)
{
    // Créer une instance du client Google
    $client = new Client();
    $client->setAuthConfig($serviceAccountPath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $client->useApplicationDefaultCredentials();

    // Désactiver la vérification SSL en environnement de développement
    // Note: Cette approche n'est pas recommandée en production
    if (
        strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
        strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false
    ) {
        $client->setHttpClient(
            new \GuzzleHttp\Client([
                'verify' => false,
                'timeout' => 10,
            ])
        );
        error_log("Environnement de développement détecté - Vérification SSL désactivée");
    }

    // Obtenir le token
    try {
        $token = $client->fetchAccessTokenWithAssertion();
        if (!isset($token['access_token'])) {
            throw new Exception("Le token d'accès n'a pas pu être obtenu");
        }
        error_log("Token d'accès Firebase obtenu avec succès");
        return $token['access_token'];
    } catch (Exception $e) {
        error_log("Erreur lors de l'obtention du token d'accès: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Simple alternative function to get access token using cURL directly
 * @param string $serviceAccountPath Path to service account JSON file (default: null to use built-in path)
 * @return string|bool JWT token or false on error
 */
function getAccessTokenWithCurl($serviceAccountPath = null)
{
    // Use provided path or default
    if ($serviceAccountPath === null) {
        $serviceAccountPath = __DIR__ . '/../send-notification-257c0-274b9981c404.json';
    }

    // Check if service account file exists
    if (!file_exists($serviceAccountPath)) {
        error_log("Service account file not found at: $serviceAccountPath");
        return false;
    }

    // Read and parse service account file
    $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
    if (!$serviceAccount) {
        error_log("Failed to parse service account JSON");
        return false;
    }

    // Log auth start
    error_log("Starting OAuth token generation with curl method");
    $startTime = microtime(true);

    try {
        // Required parameters from service account
        $clientEmail = $serviceAccount['client_email'];
        $privateKey = $serviceAccount['private_key'];
        $tokenUri = $serviceAccount['token_uri'];

        // Create JWT header and claim set
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $now = time();
        $claimSet = [
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $tokenUri,
            'exp' => $now + 3600,
            'iat' => $now
        ];

        // Encode JWT header and claim set
        $encodedHeader = base64url_encode(json_encode($header));
        $encodedClaimSet = base64url_encode(json_encode($claimSet));

        // Create signature
        $dataToSign = $encodedHeader . '.' . $encodedClaimSet;
        $signature = '';

        // Create signature using OpenSSL
        openssl_sign(
            $dataToSign,
            $signature,
            $privateKey,
            'SHA256'
        );

        $encodedSignature = base64url_encode($signature);

        // Create JWT
        $jwt = $dataToSign . '.' . $encodedSignature;

        // Request access token using JWT
        $ch = curl_init($tokenUri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("cURL error when getting auth token: $error");
            return false;
        }

        $result = json_decode($response, true);

        // Calculate time taken
        $timeTaken = (microtime(true) - $startTime) * 1000;
        error_log(sprintf("OAuth token obtained in %.2f ms", $timeTaken));

        if (isset($result['access_token'])) {
            return $result['access_token'];
        } else {
            error_log("OAuth error: " . json_encode($result));
            return false;
        }
    } catch (Exception $e) {
        error_log("Exception in getAccessTokenWithCurl: " . $e->getMessage());
        return false;
    }
}

/**
 * Base64URL encoding (URL-safe version of base64)
 * @param string $data Data to encode
 * @return string Base64URL encoded string
 */
function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Send FCM notification using HTTP v1 API
 * @param PDO $db Database connection
 * @param string $entreprise_id Enterprise ID
 * @param array $notification Notification data (title, body)
 * @param array $data Additional data for the notification
 * @return bool|string Success status or error message
 */
function sendFCMNotification($db, $entreprise_id, $notification, $data = [])
{
    error_log("Sending FCM notification to enterprise $entreprise_id");

    // Get enterprise token
    $token = getEnterpriseToken($db, $entreprise_id);

    if (!$token) {
        $error_message = "No FCM token found for enterprise $entreprise_id";
        error_log($error_message);

        // Log notification attempt with error
        if (isset($data['type'])) {
            logNotification(
                $db,
                $entreprise_id,
                isset($data['candidat_id']) ? $data['candidat_id'] : '',
                $data['type'],
                $notification,
                $data,
                'failed',
                null,
                null,
                null,
                $error_message
            );
        }

        return false;
    }

    error_log("FCM token found for enterprise $entreprise_id");

    // Get access token for FCM
    $accessToken = getAccessTokenWithCurl();
    if (!$accessToken) {
        $error_message = "Failed to get access token for FCM notification";
        error_log($error_message);

        // Log notification attempt with error
        if (isset($data['type'])) {
            logNotification(
                $db,
                $entreprise_id,
                isset($data['candidat_id']) ? $data['candidat_id'] : '',
                $data['type'],
                $notification,
                $data,
                'failed',
                null,
                null,
                $token,
                $error_message
            );
        }

        return false;
    }

    // Limiter la taille du titre si nécessaire
    if (isset($notification['title']) && strlen($notification['title']) > 50) {
        $notification['title'] = substr($notification['title'], 0, 47) . '...';
    }

    // Ensure all data values are strings
    foreach ($data as $key => $value) {
        $data[$key] = (string) $value;
    }

    // Si le type de notification n'est pas spécifié, définir une valeur par défaut
    if (!isset($data['notification_type'])) {
        $data['notification_type'] = 'recruteur';
    }

    // Prepare FCM message
    $message = [
        'message' => [
            'token' => $token,
            'notification' => $notification,
            'data' => $data
        ]
    ];

    // API endpoint
    $url = 'https://fcm.googleapis.com/v1/projects/send-notification-257c0/messages:send';

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

    // Log detailed request info for debugging
    error_log("FCM Request URL: $url");
    error_log("FCM Request Headers: Bearer " . substr($accessToken, 0, 15) . "...");
    error_log("FCM Request Body: " . json_encode($message));

    // Execute request
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    error_log("FCM Response Code: $http_code");
    error_log("FCM Response: $response");
    if ($curl_error) {
        error_log("FCM cURL Error: $curl_error");
    }

    // Close cURL
    curl_close($ch);

    // Process response
    $success = ($http_code >= 200 && $http_code < 300);
    $status = $success ? 'sent' : 'failed';
    $error_message = !$success ? ($curl_error ?: $response) : null;

    // Log the notification with a message if success
    if ($success) {
        error_log("Notification envoyée avec succès à l'entreprise $entreprise_id");
    } else {
        error_log("Échec de l'envoi de notification à l'entreprise $entreprise_id: $error_message");
    }

    // Log the notification in the database
    if (isset($data['type'])) {
        logNotification(
            $db,
            $entreprise_id,
            isset($data['candidat_id']) ? $data['candidat_id'] : '',
            $data['type'],
            $notification,
            $data,
            $status,
            $http_code,
            $response,
            $token,
            $error_message
        );
    }

    return $success;
}

/**
 * Send notification for a new job application
 * 
 * @param PDO $db Database connection
 * @param string $entreprise_id Enterprise ID
 * @param string $users_id User ID 
 * @param string $offre_id Job offer ID
 * @param string $poste Job title
 * @return bool Success status
 */
function sendApplicationNotification($db, $entreprise_id, $users_id, $offre_id = '', $poste = '')
{
    // Get user details if needed
    $user_info = getUserInfo($db, $users_id);
    $user_name = $user_info ? $user_info['nom'] : 'Un candidat';

    // Get job details if needed
    $job_title = $poste ? $poste : 'une offre';

    // Create notification
    $notification = [
        'title' => 'Nouvelle candidature',
        'body' => "$user_name a postulé pour $job_title"
    ];

    // Add additional data
    $data = [
        'type' => 'application',
        'candidat_id' => (string) $users_id,
        'offre_id' => (string) $offre_id,
    ];

    // Log the attempt to send a notification
    error_log("Tentative d'envoi d'une notification de candidature pour l'utilisateur $users_id à l'entreprise $entreprise_id");

    // Send notification
    $result = sendFCMNotification($db, $entreprise_id, $notification, $data);

    // Log le résultat
    if ($result) {
        error_log("Notification envoyée avec succès pour l'utilisateur $users_id à l'entreprise $entreprise_id");
    } else {
        error_log("Échec de l'envoi de notification pour l'utilisateur $users_id à l'entreprise $entreprise_id");
    }

    return $result;
}

/**
 * Helper function to get user info
 * @param PDO $db Database connection
 * @param string $users_id User ID
 * @return array|null User information or null if not found
 */
function getUserInfo($db, $users_id)
{
    $sql = "SELECT nom FROM users WHERE id = :users_id LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Send a notification to a user/candidate
 * @param PDO $db Database connection
 * @param string $users_id User ID
 * @param array $notification Notification title and body
 * @param array $data Additional data to send
 * @return bool Success status
 */
function sendUserFCMNotification($db, $users_id, $notification, $data = [])
{
    error_log("Sending FCM notification to user $users_id");

    // Get user token
    $token = getUserToken($db, $users_id);

    if (!$token) {
        $error_message = "No FCM token found for user $users_id";
        error_log($error_message);

        // Log notification attempt with error
        logNotification(
            $db,
            '', // No enterprise ID for user notifications
            $users_id,
            'status_update',
            $notification,
            $data,
            'failed',
            null,
            null,
            null,
            $error_message
        );

        return false;
    }

    error_log("FCM token found for user $users_id");

    // Get access token for FCM
    $accessToken = getAccessTokenWithCurl();
    if (!$accessToken) {
        $error_message = "Failed to get access token for FCM notification";
        error_log($error_message);

        // Log notification attempt with error
        logNotification(
            $db,
            '',
            $users_id,
            'status_update',
            $notification,
            $data,
            'failed',
            null,
            null,
            $token,
            $error_message
        );

        return false;
    }

    // Limiter la taille du titre si nécessaire
    if (isset($notification['title']) && strlen($notification['title']) > 50) {
        $notification['title'] = substr($notification['title'], 0, 47) . '...';
    }

    // Ensure all data values are strings
    foreach ($data as $key => $value) {
        $data[$key] = (string) $value;
    }

    // Ajouter le type de notification pour le service worker
    $data['notification_type'] = 'candidat';

    // Prepare FCM message
    $message = [
        'message' => [
            'token' => $token,
            'notification' => $notification,
            'data' => $data
        ]
    ];

    // API endpoint
    $url = 'https://fcm.googleapis.com/v1/projects/send-notification-257c0/messages:send';

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

    // Log detailed request info for debugging
    error_log("FCM User Request URL: $url");
    error_log("FCM User Request Headers: Bearer " . substr($accessToken, 0, 15) . "...");
    error_log("FCM User Request Body: " . json_encode($message));

    // Execute request
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    error_log("FCM User Response Code: $http_code");
    error_log("FCM User Response: $response");
    if ($curl_error) {
        error_log("FCM User cURL Error: $curl_error");
    }

    // Close cURL
    curl_close($ch);

    // Process response
    $success = ($http_code >= 200 && $http_code < 300);
    $status = $success ? 'sent' : 'failed';
    $error_message = !$success ? ($curl_error ?: $response) : null;

    // Log the notification
    logNotification(
        $db,
        '',
        $users_id,
        'status_update',
        $notification,
        $data,
        $status,
        $http_code,
        $response,
        $token,
        $error_message
    );

    return $success;
}

/**
 * Send notification when application status changes (accepted/rejected)
 * @param PDO $db Database connection
 * @param string $users_id User ID
 * @param string $statut Status (accepter/recaler)
 * @param string $poste Job title
 * @param string $entreprise Enterprise name
 * @return bool Success status
 */
function sendApplicationStatusNotification($db, $users_id, $statut, $poste, $entreprise = '')
{
    // Limiter la taille du titre du poste pour éviter les titres trop longs
    $poste_court = (strlen($poste) > 30) ? substr($poste, 0, 27) . '...' : $poste;

    // Create notification based on status
    if ($statut == 'accepter') {
        $notification = [
            'title' => 'Bonne nouvelle!',
            'body' => "Votre candidature pour le poste \"$poste_court\" a été acceptée!"
        ];
    } else {
        $notification = [
            'title' => 'Mise à jour candidature',
            'body' => "Votre candidature pour le poste \"$poste_court\" n'a pas été retenue."
        ];
    }

    // Add additional data
    $data = [
        'type' => 'application_status',
        'statut' => $statut,
        'poste' => $poste,
        'entreprise' => $entreprise,
        'notification_type' => 'candidat',
        'url' => '/page/user_profil.php'
    ];

    // Send notification
    return sendUserFCMNotification($db, $users_id, $notification, $data);
}

/**
 * Send notification for new message
 * @param PDO $db Database connection
 * @param string $receiver_id User or Enterprise ID that will receive the notification
 * @param string $sender_name Name of the sender
 * @param bool $is_user_receiver True if the receiver is a user (candidat), false if it's an enterprise
 * @param string $message_preview First words of the message 
 * @return bool Success status
 */
function sendMessageNotification($db, $receiver_id, $sender_name, $is_user_receiver = true, $message_preview = '')
{
    // Trim message preview if needed
    if (strlen($message_preview) > 50) {
        $message_preview = substr(strip_tags($message_preview), 0, 47) . '...';
    } else {
        $message_preview = strip_tags($message_preview);
    }

    // Log start of notification process with type info
    $receiver_type = $is_user_receiver ? "utilisateur" : "entreprise";
    error_log("⚠️ Début d'envoi de notification à $receiver_type #$receiver_id de $sender_name");

    // Check if token exists before trying to send
    if ($is_user_receiver) {
        $token = getUserToken($db, $receiver_id);
        if (!$token) {
            error_log("❌ Pas de token FCM pour l'utilisateur #$receiver_id - Impossible d'envoyer la notification");
            return false;
        }
    } else {
        $token = getEnterpriseToken($db, $receiver_id);
        if (!$token) {
            error_log("❌ Pas de token FCM pour l'entreprise #$receiver_id - Impossible d'envoyer la notification");
            return false;
        }
    }
    error_log("✅ Token FCM trouvé pour $receiver_type #$receiver_id");

    // Create notification based on receiver type
    $notification = [
        'title' => 'Nouveau message de ' . $sender_name,
        'body' => !empty($message_preview) ? $message_preview : 'Vous avez reçu un nouveau message'
    ];

    // Create data payload with URL to redirect user
    $data = [
        'type' => 'message',
        'url' => $is_user_receiver ? '/page/user_profil.php' : '/entreprise/entreprise_profil.php',
        'sender_name' => $sender_name,
        'notification_type' => $is_user_receiver ? 'candidat' : 'recruteur'
    ];

    // Log attempt details
    error_log("📤 Tentative d'envoi de notification: " . json_encode([
        'to' => "$receiver_type #$receiver_id",
        'title' => $notification['title'],
        'body' => $notification['body'],
        'data' => $data
    ]));

    // Send notification based on receiver type
    $result = false;
    if ($is_user_receiver) {
        $result = sendUserFCMNotification($db, $receiver_id, $notification, $data);
    } else {
        // Pour l'entreprise, s'assurer que data['notification_type'] est défini correctement pour le service worker
        $data['notification_type'] = 'recruteur';
        // Pour l'entreprise, on utilise sendFCMNotification qui attend un entreprise_id
        $result = sendFCMNotification($db, $receiver_id, $notification, $data);
    }

    // Log final result
    if ($result) {
        error_log("✅ Notification envoyée avec succès à $receiver_type #$receiver_id");
    } else {
        error_log("❌ Échec de l'envoi de notification à $receiver_type #$receiver_id");
    }

    return $result;
}