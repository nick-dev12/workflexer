<?php
session_start();
header('Content-Type: application/json');

set_time_limit(120);

require_once '../conn/conn.php';
require_once '../controller/MatchingControllerDakar.php'; // On utilise le nouveau contrôleur

function async_dakar_log($message, $data = null) {
    $log = date('Y-m-d H:i:s') . " [DAKAR ASYNC] - " . $message;
    if ($data !== null) {
        $log .= "\nData: " . print_r($data, true);
    }
    error_log($log . "\n", 3, __DIR__ . '/../logs/emploi_details.log');
}

if (!isset($_SESSION['users_id'])) {
    echo json_encode(['error' => 'authentication_required', 'message' => 'Utilisateur non connecté.']);
    exit();
}

if (!isset($_GET['offre_id'])) {
    echo json_encode(['error' => 'missing_parameter', 'message' => 'ID de l\'offre manquant.']);
    exit();
}

$users_id = $_SESSION['users_id'];
$offre_id = $_GET['offre_id'];

async_dakar_log("Début de l'analyse asynchrone pour l'offre Dakar", ['user_id' => $users_id, 'offre_id' => $offre_id]);

try {
    $matchingController = new MatchingControllerDakar($db);
    $compatibilite = $matchingController->analyserCompatibilite($users_id, $offre_id);
    
    async_dakar_log("Analyse Dakar terminée", $compatibilite);

    echo json_encode($compatibilite);

} catch (Exception $e) {
    async_dakar_log("ERREUR lors de l'analyse asynchrone Dakar", [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    http_response_code(500);
    echo json_encode(['error' => 'internal_server_error', 'message' => 'Une erreur est survenue lors de l\'analyse.']);
} 