<?php
session_start();
header('Content-Type: application/json');

// Augmenter le temps d'exécution maximum pour cet appel API
set_time_limit(120); // 2 minutes

require_once '../conn/conn.php';
require_once '../controller/MatchingController.php';

// Fonction de log pour le débogage de cet endpoint
function async_debug_log($message, $data = null) {
    $log = date('Y-m-d H:i:s') . " [ASYNC] - " . $message;
    if ($data !== null) {
        $log .= "\nData: " . print_r($data, true);
    }
    error_log($log . "\n", 3, __DIR__ . '/../logs/emploi_details.log');
}

// Vérifications de sécurité et de session
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

async_debug_log("Début de l'analyse asynchrone", ['user_id' => $users_id, 'offre_id' => $offre_id]);

try {
    $matchingController = new MatchingController($db);
    $compatibilite = $matchingController->analyserCompatibilite($users_id, $offre_id);
    
    async_debug_log("Analyse de compatibilité terminée", $compatibilite);

    echo json_encode($compatibilite);

} catch (Exception $e) {
    async_debug_log("ERREUR lors de l'analyse asynchrone", [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    http_response_code(500); // Erreur serveur
    echo json_encode(['error' => 'internal_server_error', 'message' => 'Une erreur est survenue lors de l\'analyse.']);
} 