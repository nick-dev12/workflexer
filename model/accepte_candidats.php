<?php
include ('../conn/conn.php');


/**
 * Summary of AccepteCandidats
 * @param mixed $db
 * @param mixed $statut
 * @param mixed $poste_id
 * @return mixed
 */
function AccepteCandidats($db,$statut,$poste_id){
    $sql = "UPDATE postulation SET statut=:statut WHERE poste_id=:poste_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':statut',$statut);
    $stmt->bindValue(':poste_id',$poste_id);
    return $stmt->execute();
}

/**
 * Summary of recalerCandidats
 * @param mixed $db
 * @param mixed $statut
 * @param mixed $poste_id
 * @return mixed
 */
function recalerCandidats($db,$statut,$poste_id){
    $sql = "UPDATE postulation SET statut=:statut WHERE poste_id=:poste_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':statut',$statut);
    $stmt->bindValue(':poste_id',$poste_id);
    return $stmt->execute();
}



/**
 * Summary of getAccepteCandidat
 * @param mixed $db
 * @param mixed $entreprise_id
 * @return mixed
 */


?>