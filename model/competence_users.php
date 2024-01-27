
<?php

require_once(__DIR__ . '/../conn/conn.php');
// Fonction pour insérer une compétence dans la base de données
/**
 * Summary of insertCompetence
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $competence
 * @return mixed
 */
function insertCompetence($db, $users_id, $competence) {
    $sql = "INSERT INTO competence_users (users_id, competence) VALUES (:users_id, :competence)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':competence', $competence);
    return $stmt->execute();
}

// Fonction pour récupérer les compétences d'un utilisateur
/**
 * Summary of getCompetences
 * @param mixed $db
 * @param mixed $users_id
 * @return mixed
 */
function getCompetences($db, $users_id) {
    $sql = "SELECT id, competence FROM competence_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 

}
function countCompetences($db, $users_id) {
    $sql = "SELECT id, competence FROM competence_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

// Fonction pour supprimer une compétence
/**
 * Summary of deleteCompetence
 * @param mixed $db
 * @param mixed $id
 * @return mixed
 */
function deleteCompetence($db, $id) {
    $sql = "DELETE FROM competence_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>