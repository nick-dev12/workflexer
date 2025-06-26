<?php
session_start();
require_once '../conn/conn.php';
require_once '../controller/MatchingControllerSenjob.php';

header('Content-Type: application/json');

if (!isset($_SESSION['users_id']) || !isset($_GET['offre_id'])) {
    echo json_encode(['error' => 'missing_params', 'message' => 'Utilisateur non connecté ou ID de l\'offre manquant.']);
    exit();
}

$users_id = $_SESSION['users_id'];
$offre_id = $_GET['offre_id'];

try {
    $controller = new MatchingControllerSenjob($db);
    $result = $controller->analyserCompatibilite($users_id, $offre_id);
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'server_error', 'message' => $e->getMessage()]);
} 