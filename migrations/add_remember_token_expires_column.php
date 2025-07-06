<?php
/**
 * Migration pour ajouter la colonne remember_token_expires à la table users
 * Ce script doit être exécuté une seule fois pour mettre à jour la structure de la base de données
 */

require_once(__DIR__ . '/../conn/conn.php');

try {
    echo "Début de la migration : Ajout de la colonne remember_token_expires...\n";
    
    // Vérifier si la colonne existe déjà
    $checkColumn = "SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'users' 
                    AND COLUMN_NAME = 'remember_token_expires'";
    
    $stmt = $db->prepare($checkColumn);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // La colonne n'existe pas, l'ajouter
        $addColumn = "ALTER TABLE users ADD COLUMN remember_token_expires DATETIME NULL AFTER remember_token";
        $db->exec($addColumn);
        echo "✓ Colonne remember_token_expires ajoutée avec succès.\n";
    } else {
        echo "ℹ La colonne remember_token_expires existe déjà.\n";
    }
    
    // Vérifier si l'index existe déjà
    $checkIndex = "SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.STATISTICS 
                   WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = 'users' 
                   AND INDEX_NAME = 'idx_remember_token'";
    
    $stmt = $db->prepare($checkIndex);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // L'index n'existe pas, l'ajouter
        $addIndex = "CREATE INDEX idx_remember_token ON users(remember_token)";
        $db->exec($addIndex);
        echo "✓ Index idx_remember_token ajouté avec succès.\n";
    } else {
        echo "ℹ L'index idx_remember_token existe déjà.\n";
    }
    
    echo "Migration terminée avec succès !\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur lors de la migration : " . $e->getMessage() . "\n";
    exit(1);
}
?> 