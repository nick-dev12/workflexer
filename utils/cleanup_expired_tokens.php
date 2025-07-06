<?php
/**
 * Script de nettoyage des tokens remember_me expirés
 * Ce script peut être exécuté via cron job pour maintenir la base de données propre
 */

require_once(__DIR__ . '/../conn/conn.php');

try {
    echo "Début du nettoyage des tokens expirés...\n";
    
    // Supprimer tous les tokens expirés
    $cleanupQuery = "UPDATE users 
                     SET remember_token = NULL, remember_token_expires = NULL 
                     WHERE remember_token_expires IS NOT NULL 
                     AND remember_token_expires < NOW()";
    
    $stmt = $db->prepare($cleanupQuery);
    $stmt->execute();
    
    $affectedRows = $stmt->rowCount();
    
    if ($affectedRows > 0) {
        echo "✓ {$affectedRows} token(s) expiré(s) supprimé(s).\n";
    } else {
        echo "ℹ Aucun token expiré trouvé.\n";
    }
    
    echo "Nettoyage terminé avec succès !\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur lors du nettoyage : " . $e->getMessage() . "\n";
    exit(1);
}
?> 