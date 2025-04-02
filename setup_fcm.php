<?php
// FCM setup script
echo "Starting FCM setup...\n";

// Run database migration
require_once(__DIR__ . '/migrations/create_fcm_tokens_table.php');

echo "\nFCM setup completed.\n";
echo "Make sure you have installed the Google API Client Library for PHP:\n";
echo "composer require google/apiclient:^2.12.0\n";
echo "\nNow you can activate FCM notifications on your enterprise profile page.\n";