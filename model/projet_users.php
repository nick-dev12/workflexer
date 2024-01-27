<?php
include('../conn/conn.php');


/**
 * Summary of postProjetUsers
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $titre
 * @param mixed $liens
 * @param mixed $projetdescription
 * @param mixed $images
 * @return mixed
 */
function postProjetUsers($db,$users_id,$titre,$liens,$projetdescription,$image){

    $sql = "INSERT INTO projet_users (users_id, titre, liens, projetdescription, images) 
    VALUES (:users_id, :titre, :liens, :projetdescription, :images)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id',$users_id);
    $stmt->bindParam(':titre',$titre);
    $stmt->bindParam(':liens',$liens);
    $stmt->bindParam(':projetdescription',$projetdescription);
    $stmt->bindParam(':images',$image);
    return $stmt->execute();

}


function getProjetUsers($db,$users_id){
    $sql = "SELECT * FROM projet_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function deleteProjets ( $db, $id){
    $sql = "DELETE FROM projet_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

?>