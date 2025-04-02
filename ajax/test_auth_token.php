<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set headers
header('Content-Type: application/json');

// Log request
error_log("Test autorisation OAuth reçu");

// Vérifier l'authentification
if (!isset($_SESSION['compte_entreprise'])) {
    error_log("Test OAuth: Non authentifié");
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Not logged in as enterprise']);
    exit;
}

// Include FCM notification helper
require_once(__DIR__ . '/../model/fcm_notification.php');

// Chemin vers le fichier de service account
$serviceAccountPath = __DIR__ . '/../send-notification-257c0-274b9981c404.json';

// Tester la génération du token avec curl
try {
    error_log("Test OAuth: Essai avec méthode cURL");
    $startTime = microtime(true);

    // Afficher le contenu du fichier pour débogage
    error_log("Contenu du fichier de service account: ");
    $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
    if (!$serviceAccount) {
        error_log("Impossible de lire le fichier ou JSON invalide");
    } else {
        error_log("Fichier lu avec succès, contient les clés: " . implode(", ", array_keys($serviceAccount)));
    }

    // Générer le token
    $accessToken = getAccessTokenWithCurl($serviceAccountPath);
    $endTime = microtime(true);
    $timeTaken = round(($endTime - $startTime) * 1000);

    error_log("Test OAuth: Token obtenu avec curl en {$timeTaken}ms");
    echo json_encode([
        'success' => true,
        'method' => 'curl',
        'token_length' => strlen($accessToken),
        'token_preview' => substr($accessToken, 0, 20) . '...',
        'time_ms' => $timeTaken,
        'message' => 'Token généré avec succès via cURL'
    ]);
} catch (Exception $e) {
    error_log("Test OAuth: Échec méthode cURL - " . $e->getMessage());

    // Essayer avec la méthode Google Client
    try {
        error_log("Test OAuth: Essai avec Google Client");
        $startTime = microtime(true);
        $accessToken = getAccessToken($serviceAccountPath);
        $endTime = microtime(true);
        $timeTaken = round(($endTime - $startTime) * 1000);

        error_log("Test OAuth: Token obtenu avec Google Client en {$timeTaken}ms");
        echo json_encode([
            'success' => true,
            'method' => 'google_client',
            'token_length' => strlen($accessToken),
            'token_preview' => substr($accessToken, 0, 20) . '...',
            'time_ms' => $timeTaken,
            'message' => 'Token généré avec succès via Google Client'
        ]);
    } catch (Exception $e2) {
        error_log("Test OAuth: Échec total - " . $e2->getMessage());
        echo json_encode([
            'success' => false,
            'curl_error' => $e->getMessage(),
            'google_client_error' => $e2->getMessage(),
            'message' => 'Impossible de générer le token d\'autorisation'
        ]);
    }
}