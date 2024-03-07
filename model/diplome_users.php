<?php
include('../conn/conn.php');

/**
 * Summary of postDiplome
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $diplome
 * @return mixed
 */
function postDiplome($db, $users_id, $diplome)
{
    $sql = "INSERT INTO diplome (users_id, diplome) VALUES (:users_id, :diplome) ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':diplome', $diplome);
    return $stmt->execute();
}


function getDiplomes($db, $users_id)
{
    $sql = "SELECT id , diplome FROM diplome WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteDiplome($db, $id)
{
    $sql = "DELETE FROM diplome WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>