<?php
include(__DIR__ . '/../conn/conn.php');

// model.php

// Fonction pour insérer une formation dans la base de données
/**
 * Summary of insertFormation
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $annee
 * @param mixed $annees
 * @param mixed $Filiere
 * @param mixed $etablissement
 * @param mixed $niveau
 * @return mixed
 */
function insertFormation($db, $users_id, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $encours, $Filiere, $etablissement, $niveau)
{
    // Préparation de la requête SQL
    $sql = "INSERT INTO formation_users (users_id,moisDebut,anneeDebut,moisFin,anneeFin, en_cours, Filiere, etablissement, niveau, mis_en_avant) 
            VALUES (:users_id, :moisDebut, :anneeDebut, :moisFin, :anneeFin, :en_cours, :Filiere, :etablissement, :niveau, 0)";

    // Préparation de la requête 
    $stmt = $db->prepare($sql);

    // Association des paramètres
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':moisDebut', $moisDebut);
    $stmt->bindParam(':anneeDebut', $anneeDebut);
    $stmt->bindParam(':moisFin', $moisFin);
    $stmt->bindParam(':anneeFin', $anneeFin);
    $stmt->bindParam(':en_cours', $encours);
    $stmt->bindParam(':Filiere', $Filiere);
    $stmt->bindParam(':etablissement', $etablissement);
    $stmt->bindParam(':niveau', $niveau);
    // Exécution de la requête
    return $stmt->execute();
}

function updateFormation($db, $id, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $Filiere, $etablissement, $niveau, $encours)
{
    $sql = "UPDATE formation_users SET moisDebut = :moisDebut, anneeDebut = :anneeDebut, moisFin = :moisFin, anneeFin = :anneeFin, Filiere = :Filiere, etablissement = :etablissement, niveau = :niveau, en_cours = :en_cours WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':moisDebut', $moisDebut);
    $stmt->bindParam(':anneeDebut', $anneeDebut);
    $stmt->bindParam(':moisFin', $moisFin);
    $stmt->bindParam(':anneeFin', $anneeFin);
    $stmt->bindParam(':Filiere', $Filiere);
    $stmt->bindParam(':etablissement', $etablissement);
    $stmt->bindParam(':niveau', $niveau);
    $stmt->bindParam(':en_cours', $encours);
    return $stmt->execute();
}

/**
 * Summary of getFormation
 * @param mixed $db
 * @param mixed $users_id
 * @return mixed
 */
function getFormation($db, $users_id)
{
    $sql = "SELECT * FROM formation_users WHERE users_id = :users_id ORDER BY mis_en_avant DESC, anneeDebut DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Summary of deleteFormation
 * @param mixed $db
 * @param mixed $id
 * @return mixed
 */
function deleteFormation($db, $id)
{
    $sql = "DELETE FROM formation_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Met à jour les formations mises en avant
 * @param mixed $db
 * @param array $formationIds
 * @param int $userId
 * @return bool
 */
function updateFormationHighlights($db, $formationIds, $userId) {
    try {
        // Log pour le débogage
        error_log("Début de updateFormationHighlights");
        error_log("User ID: " . $userId);
        error_log("Formation IDs: " . print_r($formationIds, true));
        
        // D'abord, réinitialiser toutes les formations de l'utilisateur
        $resetSql = "UPDATE formation_users SET mis_en_avant = 0 WHERE users_id = :users_id";
        $resetStmt = $db->prepare($resetSql);
        $resetStmt->bindParam(':users_id', $userId);
        $resetResult = $resetStmt->execute();
        
        error_log("Réinitialisation: " . ($resetResult ? "réussie" : "échouée"));

        // Ensuite, mettre à jour les formations sélectionnées
        if (!empty($formationIds)) {
            // Utiliser une requête préparée plus simple avec des boucles
            $updateSql = "UPDATE formation_users SET mis_en_avant = 1 
                         WHERE id = :id AND users_id = :users_id";
            $updateStmt = $db->prepare($updateSql);
            
            foreach ($formationIds as $id) {
                $updateStmt->bindParam(':id', $id);
                $updateStmt->bindParam(':users_id', $userId);
                $updateResult = $updateStmt->execute();
                error_log("Mise à jour de la formation ID " . $id . ": " . ($updateResult ? "réussie" : "échouée"));
            }
        }
        
        error_log("Fin de updateFormationHighlights avec succès");
        return true;
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour des formations mises en avant: " . $e->getMessage());
        return false;
    }
}
?>