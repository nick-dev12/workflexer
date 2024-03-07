<?php
include(__DIR__ . '/../conn/conn.php');

/**
 * Summary of postAppelOffre
 * @param mixed $db
 * @param mixed $entreprise_id
 * @param mixed $users_id
 * @return mixed
 */
function postAppelOffre($db, $entreprise_id, $users_id, $titre, $messages)
{
    $sql = " INSERT INTO appel_offre (entreprise_id,users_id,titre,messages) VALUES (:entreprise_id,:users_id,:titre,:messages)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':messages', $messages);
    return $stmt->execute();
}

function getAllAppelOffre($db, $id)
{
    $sql = "SELECT * FROM appel_offre WHERE entreprise_id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllAppelOffreUsers($db, $id)
{
    $sql = "SELECT * FROM appel_offre WHERE users_id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAppelOffreUsers($db, $users_id, $entreprise_id)
{
    $sql = "SELECT * FROM appel_offre WHERE users_id=:users_id AND entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":users_id", $users_id, PDO::PARAM_STR);
    $stmt->bindValue(":entreprise_id", $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>