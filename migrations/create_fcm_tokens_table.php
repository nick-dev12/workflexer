<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

error_log("Starting FCM tokens table migration");

try {
    require_once(__DIR__ . '/../conn/conn.php');

    // Check if we have a valid database connection
    if (!isset($db) || !($db instanceof PDO)) {
        throw new Exception("Database connection not available");
    }

    error_log("Database connection successful");

    // Check if table already exists
    $stmt = $db->query("SHOW TABLES LIKE 'fcm_tokens'");
    $tableExists = $stmt->rowCount() > 0;

    error_log("FCM tokens table exists: " . ($tableExists ? 'yes' : 'no'));

    if (!$tableExists) {
        // Table doesn't exist, create it
        $sql = "CREATE TABLE fcm_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            entreprise_id VARCHAR(255) NOT NULL,
            token TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY unique_entreprise (entreprise_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $result = $db->exec($sql);
        error_log("FCM tokens table creation result: " . ($result !== false ? 'success' : 'failed'));
        echo "FCM tokens table created successfully!";
    } else {
        // Verify table structure
        $sql = "DESCRIBE fcm_tokens";
        $result = $db->query($sql);
        $columns = $result->fetchAll(PDO::FETCH_ASSOC);

        $expectedColumns = [
            'id',
            'entreprise_id',
            'token',
            'created_at',
            'updated_at'
        ];

        $missingColumns = [];
        $foundColumns = array_column($columns, 'Field');

        foreach ($expectedColumns as $column) {
            if (!in_array($column, $foundColumns)) {
                $missingColumns[] = $column;
            }
        }

        if (!empty($missingColumns)) {
            error_log("FCM tokens table missing columns: " . implode(', ', $missingColumns));
            echo "FCM tokens table exists but is missing columns: " . implode(', ', $missingColumns);

            // Add missing columns
            foreach ($missingColumns as $column) {
                switch ($column) {
                    case 'id':
                        $db->exec("ALTER TABLE fcm_tokens ADD id INT AUTO_INCREMENT PRIMARY KEY");
                        break;
                    case 'entreprise_id':
                        $db->exec("ALTER TABLE fcm_tokens ADD entreprise_id VARCHAR(255) NOT NULL");
                        break;
                    case 'token':
                        $db->exec("ALTER TABLE fcm_tokens ADD token TEXT NOT NULL");
                        break;
                    case 'created_at':
                        $db->exec("ALTER TABLE fcm_tokens ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                        break;
                    case 'updated_at':
                        $db->exec("ALTER TABLE fcm_tokens ADD updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                        break;
                }
            }

            // Check for unique key
            $uniqueKeyMissing = true;
            foreach ($columns as $column) {
                if ($column['Field'] === 'entreprise_id' && $column['Key'] === 'UNI') {
                    $uniqueKeyMissing = false;
                    break;
                }
            }

            if ($uniqueKeyMissing) {
                $db->exec("ALTER TABLE fcm_tokens ADD UNIQUE KEY unique_entreprise (entreprise_id)");
                error_log("Added unique key for entreprise_id");
            }

            echo " - Missing columns added.";
        } else {
            echo "FCM tokens table already exists and has the correct structure.";
        }
    }
} catch (Exception $e) {
    $errorMsg = "Error in FCM tokens migration: " . $e->getMessage();
    error_log($errorMsg);
    echo $errorMsg;
}