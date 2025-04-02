<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/fcm_tokens_users.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log incoming request for debugging
$requestLog = [
    'time' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'session' => isset($_SESSION['users_id']) ? $_SESSION['users_id'] : 'not set',
    'raw_input' => file_get_contents('php://input')
];
error_log('FCM Token User Request: ' . json_encode($requestLog));

// Set headers
header('Content-Type: application/json');

// Check if user is logged in as a candidate
if (!isset($_SESSION['users_id'])) {
    error_log('FCM Token User Error: Not authenticated as user');
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Not logged in as user']);
    exit;
}

// Get input data
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

// Log the received data
error_log('FCM Token Input: ' . $rawInput);

// Validate input
if (!isset($input['token']) || empty($input['token'])) {
    error_log('FCM Token User Error: Token not provided');
    echo json_encode(['success' => false, 'message' => 'Token is required']);
    exit;
}

// Use the token from input and user ID from session
$token = $input['token'];
$users_id = $_SESSION['users_id'];
$device_info = isset($input['device_info']) ? $input['device_info'] : '';

error_log("FCM Token User Processing: About to save token for user $users_id");

// Save token to database
try {
    $result = saveUserToken($db, $users_id, $token, $device_info);

    if ($result) {
        error_log("FCM Token User Success: Token saved for user $users_id");
        echo json_encode(['success' => true, 'message' => 'Token saved successfully']);
    } else {
        error_log("FCM Token User Error: Failed to save token for user $users_id");
        echo json_encode(['success' => false, 'message' => 'Failed to save token to database']);
    }
} catch (Exception $e) {
    $errorMsg = 'Error: ' . $e->getMessage();
    error_log("FCM Token User Exception: $errorMsg");
    echo json_encode(['success' => false, 'message' => $errorMsg]);
}