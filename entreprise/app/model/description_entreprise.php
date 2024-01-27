<?php
include(__DIR__. '/conn/conn.php');


/**
 * Summary of postDescription
 * @param mixed $db
 * @param mixed $entreprise_id
 * @param mixed $descriptions
 * @param mixed $liens
 * @return mixed
 */
function postDescription ($db,$entreprise_id , $descriptions, $liens){
$sql = " INSERT INTO description_entreprise (entreprise_id, descriptions, liens) VALUES ( :entreprise_id, :descriptions, :liens) ";
$stmt = $db->prepare($sql);
$stmt->bindParam(':entreprise_id', $entreprise_id);
$stmt->bindParam(':descriptions', $descriptions);
$stmt->bindParam(':liens', $liens);
return $stmt->execute();
}

/**
 * Summary of getDescriptionEntreprise
 * @param mixed $db
 * @param mixed $entreprise_id
 * @return mixed
 */
function getDescriptionEntreprise ($db,$entreprise_id){
    $sql = " SELECT * FROM description_entreprise WHERE entreprise_id=:entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt-> bindValue(':entreprise_id',$entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Summary of updatDescristion
 * @param mixed $db
 * @param mixed $descriptions
 * @param mixed $liens
 * @return mixed
 */
function updatDescristion($db,$descriptions,$liens){
    $sql = " UPDATE description_entreprise SET descriptions=:descriptions, liens=:liens";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':descriptions',$descriptions,PDO::PARAM_STR);
    $stmt->bindValue(':liens',$liens,PDO::PARAM_STR);
    return $stmt->execute();
}
 ?>