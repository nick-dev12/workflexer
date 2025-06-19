<?php
include(__DIR__ . '/../conn/conn.php');

function postOutil($db, $users_id, $outil, $niveau)
{
    $sql = "INSERT INTO outil_users (users_id, outil, niveau, mis_en_avant) VALUES (:users_id, :outil, :niveau, 0)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':outil', $outil);
    $stmt->bindParam(':niveau', $niveau);
    return $stmt->execute();
}

function getOutil($db, $user_id)
{
    $sql = "SELECT * FROM outil_users WHERE users_id = :users_id ORDER BY mis_en_avant DESC, outil ASC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteOutils($db, $id)
{
    $sql = "DELETE FROM outil_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function selectOutilLimit5($db, $users_id)
{
    $sql = "SELECT * FROM outil_users WHERE users_id = :users_id ORDER BY mis_en_avant DESC, outil ASC LIMIT 5";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Met à jour les outils mis en avant
 * @param mixed $db
 * @param array $outilIds
 * @param int $userId
 * @return bool
 */
function updateOutilHighlights($db, $outilIds, $userId) {
    try {
        // Log pour le débogage
        error_log("Début de updateOutilHighlights");
        error_log("User ID: " . $userId);
        error_log("Outil IDs: " . print_r($outilIds, true));
        
        // D'abord, réinitialiser tous les outils de l'utilisateur
        $resetSql = "UPDATE outil_users SET mis_en_avant = 0 WHERE users_id = :users_id";
        $resetStmt = $db->prepare($resetSql);
        $resetStmt->bindParam(':users_id', $userId);
        $resetResult = $resetStmt->execute();
        
        error_log("Réinitialisation: " . ($resetResult ? "réussie" : "échouée"));

        // Ensuite, mettre à jour les outils sélectionnés
        if (!empty($outilIds)) {
            // Utiliser une requête préparée plus simple avec des boucles
            $updateSql = "UPDATE outil_users SET mis_en_avant = 1 
                         WHERE id = :id AND users_id = :users_id";
            $updateStmt = $db->prepare($updateSql);
            
            foreach ($outilIds as $id) {
                $updateStmt->bindParam(':id', $id);
                $updateStmt->bindParam(':users_id', $userId);
                $updateResult = $updateStmt->execute();
                error_log("Mise à jour de l'outil ID " . $id . ": " . ($updateResult ? "réussie" : "échouée"));
            }
        }
        
        error_log("Fin de updateOutilHighlights avec succès");
        return true;
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour des outils mis en avant: " . $e->getMessage());
        return false;
    }
}
