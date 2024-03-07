<?php
include(__DIR__ . '/../conn/conn.php');

/**
 * Summary of posteCentreInteret
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $interet
 * @return mixed
 */
function posteCentreInteret($db, $users_id, $interet)
{
    $sql = 'INSERT INTO centre_interet (users_id,interet) VALUES  (:users_id,:interet)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':interet', $interet);
    return $stmt->execute();
}

function getAllCentreInteretUsers($db, $users_id)
{
    $sql = 'SELECT * FROM centre_interet WHere users_id = :users_id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function deleteInteret($db, $id)
{
    $sql = "DELETE FROM centre_interet WHERE interet_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

?>