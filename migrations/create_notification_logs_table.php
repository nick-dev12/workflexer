<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

error_log("Starting notification_logs table migration");

try {
    require_once(__DIR__ . '/../conn/conn.php');

    // Check if we have a valid database connection
    if (!isset($db) || !($db instanceof PDO)) {
        throw new Exception("Database connection not available");
    }

    error_log("Database connection successful");

    // Check if table already exists
    $stmt = $db->query("SHOW TABLES LIKE 'notification_logs'");
    $tableExists = $stmt->rowCount() > 0;

    error_log("notification_logs table exists: " . ($tableExists ? 'yes' : 'no'));

    if (!$tableExists) {
        // Table doesn't exist, create it
        $sql = "CREATE TABLE notification_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            entreprise_id VARCHAR(255) NOT NULL,
            users_id VARCHAR(255) NOT NULL,
            notification_type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            body TEXT NOT NULL,
            data TEXT,
            sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status VARCHAR(50) DEFAULT 'sent',
            response_code VARCHAR(10),
            response_message TEXT,
            token_used TEXT,
            error_message TEXT,
            INDEX idx_entreprise (entreprise_id),
            INDEX idx_user (users_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $result = $db->exec($sql);
        error_log("notification_logs table creation result: " . ($result !== false ? 'success' : 'failed'));
        echo "notification_logs table created successfully!";
    } else {
        // Verify table structure
        $sql = "DESCRIBE notification_logs";
        $result = $db->query($sql);
        $columns = $result->fetchAll(PDO::FETCH_ASSOC);

        $expectedColumns = [
            'id',
            'entreprise_id',
            'users_id',
            'notification_type',
            'title',
            'body',
            'data',
            'sent_at',
            'status',
            'response_code',
            'response_message',
            'token_used',
            'error_message'
        ];

        $missingColumns = [];
        $foundColumns = array_column($columns, 'Field');

        foreach ($expectedColumns as $column) {
            if (!in_array($column, $foundColumns)) {
                $missingColumns[] = $column;
            }
        }

        if (!empty($missingColumns)) {
            error_log("notification_logs table missing columns: " . implode(', ', $missingColumns));
            echo "notification_logs table exists but is missing columns: " . implode(', ', $missingColumns);

            // Add missing columns
            foreach ($missingColumns as $column) {
                switch ($column) {
                    case 'id':
                        $db->exec("ALTER TABLE notification_logs ADD id INT AUTO_INCREMENT PRIMARY KEY");
                        break;
                    case 'entreprise_id':
                        $db->exec("ALTER TABLE notification_logs ADD entreprise_id VARCHAR(255) NOT NULL");
                        break;
                    case 'users_id':
                        $db->exec("ALTER TABLE notification_logs ADD users_id VARCHAR(255) NOT NULL");
                        break;
                    case 'notification_type':
                        $db->exec("ALTER TABLE notification_logs ADD notification_type VARCHAR(50) NOT NULL");
                        break;
                    case 'title':
                        $db->exec("ALTER TABLE notification_logs ADD title VARCHAR(255) NOT NULL");
                        break;
                    case 'body':
                        $db->exec("ALTER TABLE notification_logs ADD body TEXT NOT NULL");
                        break;
                    case 'data':
                        $db->exec("ALTER TABLE notification_logs ADD data TEXT");
                        break;
                    case 'sent_at':
                        $db->exec("ALTER TABLE notification_logs ADD sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                        break;
                    case 'status':
                        $db->exec("ALTER TABLE notification_logs ADD status VARCHAR(50) DEFAULT 'sent'");
                        break;
                    case 'response_code':
                        $db->exec("ALTER TABLE notification_logs ADD response_code VARCHAR(10)");
                        break;
                    case 'response_message':
                        $db->exec("ALTER TABLE notification_logs ADD response_message TEXT");
                        break;
                    case 'token_used':
                        $db->exec("ALTER TABLE notification_logs ADD token_used TEXT");
                        break;
                    case 'error_message':
                        $db->exec("ALTER TABLE notification_logs ADD error_message TEXT");
                        break;
                }
            }

            echo " - Missing columns added.";
        } else {
            echo "notification_logs table already exists and has the correct structure.";
        }
    }
} catch (Exception $e) {
    $errorMsg = "Error in notification_logs migration: " . $e->getMessage();
    error_log($errorMsg);
    echo $errorMsg;
}