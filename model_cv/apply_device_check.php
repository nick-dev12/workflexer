<?php
/**
 * Script to add device check code to all model files
 */

// The code to add after session_start()
$codeToAdd = '

// Include device detection functionality
include_once(\'check_device.php\');

// Check if user is on desktop
$isDesktop = isDesktop();
if (!$isDesktop) {
    // If not on desktop, redirect to mobile message page
    header("Location: mobile_message.php");
    exit;
}
';

// Get all model files
$modelFiles = glob('model*.php');
$count = 0;

foreach ($modelFiles as $file) {
    // Skip the model_nouveau.php file if it exists and has a different structure
    if ($file === 'model_nouveau.php') {
        continue;
    }

    // Read the file content
    $content = file_get_contents($file);

    // If the check is already present, skip this file
    if (strpos($content, 'check_device.php') !== false) {
        echo "Device check already exists in $file. Skipping.<br>";
        continue;
    }

    // Check if the file has session_start()
    if (strpos($content, 'session_start') !== false) {
        // Add the code after session_start
        $content = str_replace('session_start();', 'session_start();' . $codeToAdd, $content);

        // Write the modified content back to the file
        file_put_contents($file, $content);
        $count++;
        echo "Added device check to $file<br>";
    } else {
        echo "Could not find session_start() in $file. Skipping.<br>";
    }
}

echo "<p>Added device check to $count model files.</p>";
echo "<p><a href='../'>Return to homepage</a></p>";
?>