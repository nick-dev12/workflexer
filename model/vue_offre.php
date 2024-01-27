<?php 
include ('../conn/conn.php');

function getVueOffre($db,$users_id,$offre_id){
    $sql = " SELECT * FROM vue_offre WHERE users_id=:users_id AND offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id',$users_id,PDO::PARAM_INT);
    $stmt->bindValue(':offre_id',$offre_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function countOffre($db,$entreprise_id,$offre_id){
    $sql = " SELECT * FROM vue_offre WHERE entreprise_id=:entreprise_id AND offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id',$entreprise_id,PDO::PARAM_INT);
    $stmt->bindValue(':offre_id',$offre_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}
?>