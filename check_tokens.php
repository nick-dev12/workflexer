<?php
// Script pour vérifier les tokens FCM des entreprises
try {
    require_once('conn/conn.php');
    require_once('model/fcm_tokens.php');
    require_once('model/fcm_tokens_users.php');

    // Vérifier la structure des tables
    echo "=== Structure des tables ===\n";

    echo "Table fcm_tokens:\n";
    $sql = "SHOW COLUMNS FROM fcm_tokens";
    $stmt = $db->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo " - {$column['Field']} ({$column['Type']})\n";
    }

    echo "\nTable fcm_tokens_users:\n";
    $sql = "SHOW COLUMNS FROM fcm_tokens_users";
    $stmt = $db->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo " - {$column['Field']} ({$column['Type']})\n";
    }

    // Vérifier les tokens des entreprises
    echo "\n=== Tokens des entreprises ===\n";
    try {
        $sql = "SELECT id, entreprise FROM compte_entreprise LIMIT 5";
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $token = getEnterpriseToken($db, $row['id']);
            $token_preview = $token ? (substr($token, 0, 20) . '...') : "Pas de token";
            echo "Entreprise #{$row['id']} ({$row['entreprise']}): $token_preview\n";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la vérification des tokens d'entreprise: " . $e->getMessage() . "\n";
    }

    // Vérifier les tokens des utilisateurs
    echo "\n=== Tokens des utilisateurs ===\n";
    try {
        $sql = "SELECT id, nom FROM users LIMIT 5";
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $token = getUserToken($db, $row['id']);
            $token_preview = $token ? (substr($token, 0, 20) . '...') : "Pas de token";
            echo "Utilisateur #{$row['id']} ({$row['nom']}): $token_preview\n";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la vérification des tokens d'utilisateur: " . $e->getMessage() . "\n";
    }

    // Afficher le nombre total de tokens
    try {
        $sql = "SELECT COUNT(*) FROM fcm_tokens";
        $count_entreprises = $db->query($sql)->fetchColumn();

        $sql = "SELECT COUNT(*) FROM fcm_tokens_users";
        $count_users = $db->query($sql)->fetchColumn();

        echo "\nNombre total de tokens entreprises: $count_entreprises\n";
        echo "Nombre total de tokens utilisateurs: $count_users\n";
    } catch (Exception $e) {
        echo "Erreur lors du comptage des tokens: " . $e->getMessage() . "\n";
    }
} catch (Exception $e) {
    echo "Erreur principale: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}