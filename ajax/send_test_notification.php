<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/fcm_tokens.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set headers
header('Content-Type: application/json');

// Log the request for debugging
error_log("Test notification request received");

// Check if user is logged in as an enterprise
if (!isset($_SESSION['compte_entreprise'])) {
    error_log("Unauthorized: User not logged in as enterprise");
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Not logged in as enterprise']);
    exit;
}

$entreprise_id = $_SESSION['compte_entreprise'];
error_log("Sending test notification for enterprise: " . $entreprise_id);

// Get FCM token for the enterprise
$token = getEnterpriseToken($db, $entreprise_id);

if (!$token) {
    error_log("No FCM token found for enterprise: " . $entreprise_id);
    echo json_encode(['success' => false, 'message' => 'Aucun token FCM trouvé pour votre entreprise. Veuillez d\'abord activer les notifications.']);
    exit;
}

// Include the FCM notification helper
require_once(__DIR__ . '/../model/fcm_notification.php');

try {
    // Path to your service account JSON file
    $serviceAccountPath = __DIR__ . '/../send-notification-257c0-274b9981c404.json';

    // Firebase project ID
    $projectId = 'send-notification-257c0';

    // Get access token - essayer d'abord avec la méthode cURL directe
    try {
        error_log("Tentative d'obtention du token avec cURL direct");
        $accessToken = getAccessTokenWithCurl($serviceAccountPath);
    } catch (Exception $e) {
        error_log("Échec de la méthode cURL directe, on essaie la méthode standard: " . $e->getMessage());
        $accessToken = getAccessToken($serviceAccountPath);
    }

    // Prepare test notification message
    $notification = [
        'title' => 'Test de notification 🔔',
        'body' => 'Ceci est une notification de test de WorkFlexer. Si vous voyez ceci, vos notifications fonctionnent correctement!'
    ];

    // Add data payload
    $data = [
        'type' => 'test',
        'timestamp' => (string) time(),
        'entreprise_id' => (string) $entreprise_id
    ];

    // Prepare message
    $message = [
        'token' => $token,
        'notification' => $notification,
        'data' => $data
    ];

    // Send the message
    $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['message' => $message]));

    // Désactiver la vérification SSL (uniquement pour le développement)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    error_log("Vérification SSL désactivée pour cURL");

    $response = curl_exec($ch);
    $err = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    error_log("FCM response status code: " . $httpCode);
    error_log("FCM response: " . $response);

    if ($err) {
        error_log("cURL Error: " . $err);
        echo json_encode(['success' => false, 'message' => 'Erreur cURL: ' . $err]);
        exit;
    }

    if ($httpCode !== 200) {
        $responseData = json_decode($response, true);
        $errorMessage = isset($responseData['error']['message']) ? $responseData['error']['message'] : 'Unknown error';
        error_log("FCM Error: " . $errorMessage);
        echo json_encode(['success' => false, 'message' => 'Erreur FCM: ' . $errorMessage]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Notification de test envoyée avec succès!']);

} catch (Exception $e) {
    error_log("Exception while sending test notification: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}