<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/fcm_tokens.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log incoming request for debugging
$requestLog = [
    'time' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'session' => isset($_SESSION['compte_entreprise']) ? $_SESSION['compte_entreprise'] : 'not set',
    'raw_input' => file_get_contents('php://input')
];
error_log('FCM Token Request: ' . json_encode($requestLog));

// Set headers
header('Content-Type: application/json');

// Check if user is logged in as an enterprise
if (!isset($_SESSION['compte_entreprise'])) {
    error_log('FCM Token Error: Not authenticated as enterprise');
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Not logged in as enterprise']);
    exit;
}

// Get input data
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

// Log the received data
error_log('FCM Token Input: ' . $rawInput);

// Validate input
if (!isset($input['token']) || empty($input['token'])) {
    error_log('FCM Token Error: Token not provided');
    echo json_encode(['success' => false, 'message' => 'Token is required']);
    exit;
}

// Use the token from input and enterprise ID from session
$token = $input['token'];
$entreprise_id = $_SESSION['compte_entreprise'];

error_log("FCM Token Processing: About to save token for enterprise $entreprise_id");

// Save token to database
try {
    $result = saveEnterpriseToken($db, $entreprise_id, $token);

    if ($result) {
        error_log("FCM Token Success: Token saved for enterprise $entreprise_id");
        echo json_encode(['success' => true, 'message' => 'Token saved successfully']);
    } else {
        error_log("FCM Token Error: Failed to save token for enterprise $entreprise_id");
        echo json_encode(['success' => false, 'message' => 'Failed to save token to database']);
    }
} catch (Exception $e) {
    $errorMsg = 'Error: ' . $e->getMessage();
    error_log("FCM Token Exception: $errorMsg");
    echo json_encode(['success' => false, 'message' => $errorMsg]);
}