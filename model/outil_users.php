<?php
include('../conn/conn.php');

function postOutil($db,$users_id,$outil,$niveau ){
    $sql = "INSERT INTO outil_users (users_id, outil, niveau) VALUES (:users_id, :outil, :niveau )";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':outil', $outil);
    $stmt->bindParam(':niveau', $niveau);
    return $stmt->execute();
}

function getOutil($db,$user_id){
    $sql = "SELECT * FROM outil_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteOutils ( $db, $id){
    $sql = "DELETE FROM outil_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>