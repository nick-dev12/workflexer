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
function insertCompetence($db, $users_id, $competence)
{
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
function getCompetences($db, $users_id)
{
    $sql = "SELECT id, competence, mis_en_avant FROM competence_users WHERE users_id = :users_id ORDER BY mis_en_avant DESC, id DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
function countCompetences($db, $users_id)
{
    $sql = "SELECT id, competence FROM competence_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
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
function deleteCompetence($db, $id)
{
    $sql = "DELETE FROM competence_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function selectCompetenceLimit7($db, $users_id)
{
    $sql = "SELECT id, competence, mis_en_avant FROM competence_users WHERE users_id = :users_id ORDER BY mis_en_avant DESC LIMIT 7";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Mettre à jour le statut "mis_en_avant" d'une compétence
 * @param mixed $db
 * @param mixed $id
 * @param mixed $mis_en_avant
 * @return bool
 */
function updateCompetenceMisEnAvant($db, $id, $mis_en_avant)
{
    $sql = "UPDATE competence_users SET mis_en_avant = :mis_en_avant WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':mis_en_avant', $mis_en_avant, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Récupérer les compétences mises en avant pour un utilisateur
 * @param mixed $db
 * @param mixed $users_id
 * @return mixed
 */
function getCompetencesMisEnAvant($db, $users_id)
{
    $sql = "SELECT id, competence FROM competence_users WHERE users_id = :users_id AND mis_en_avant = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}