<?php

include('../conn/conn.php');

function postMessage1($db,$entreprise_id,$users_id,$offre_id,$statut,$messages, $indicatif){
$sql="INSERT INTO message1 (entreprise_id,users_id,offre_id,statut,messages,indicatif)
VALUES (:entreprise_id,:users_id,:offre_id,:statut,:messages,:indicatif)";
$stmt=$db->prepare($sql);
$stmt->bindParam(":entreprise_id",$entreprise_id,);
$stmt->bindParam(":users_id",$users_id,);
$stmt->bindParam(":offre_id",$offre_id,);
$stmt->bindParam(":statut",$statut,);
$stmt->bindParam(":messages",$messages,);
$stmt->bindParam(":indicatif",$indicatif,);
$stmt->execute();
}

function getMessage1($db,$entreprise_id,$offre_id,$users_id){
    $sql= "SELECT * FROM message1 WHERE 
    entreprise_id=:entreprise_id AND offre_id =:offre_id AND users_id=:users_id ORDER BY date DESC";
    $stmt= $db->prepare($sql);
    $stmt->bindValue(':entreprise_id',$entreprise_id,PDO::PARAM_INT);
    $stmt->bindValue(':offre_id',$offre_id,PDO::PARAM_INT);
    $stmt->bindValue(':users_id',$users_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getMessage2($db,$entreprise_id,$users_id){
    $sql= "SELECT * FROM message1 WHERE 
    entreprise_id=:entreprise_id AND users_id=:users_id ORDER BY date DESC";
    $stmt= $db->prepare($sql);
    $stmt->bindValue(':entreprise_id',$entreprise_id,PDO::PARAM_INT);
    $stmt->bindValue(':users_id',$users_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAutreMessageEntreprise($db){
    $sql= "SELECT * FROM message1 ";
    $stmt= $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Summary of deletMessage
 * @param mixed $db
 * @param mixed $message_id
 * @return mixed
 */
function deletMessage ( $db, $message_id){
$sql= "DELETE  FROM message1 WHERE message_id = :message_id";
$stmt= $db->prepare($sql);
$stmt->bindValue(':message_id',$message_id,PDO::PARAM_INT);
return  $stmt->execute();
}

?>