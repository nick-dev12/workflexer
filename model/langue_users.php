<?php
include(__DIR__.'/../conn/conn.php');


function postLangue ($db, $users_id, $langue, $niveau){
    $sql = "INSERT INTO langue_users (users_id, langue, niveau) 
    VALUES (:users_id, :langue, :niveau)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':langue', $langue);
    $stmt->bindParam(':niveau', $niveau);
    return $stmt->execute();
}


function getLangue($db, $user_id){
$sql = "SELECT * FROM langue_users WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':users_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function deleteLangue ( $db, $id){
    $sql = "DELETE FROM langue_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

?>