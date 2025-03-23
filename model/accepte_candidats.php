<?php
include(__DIR__ . '/../conn/conn.php');


/**
 * Summary of AccepteCandidats
 * @param mixed $db
 * @param mixed $statut
 * @param mixed $poste_id
 * @return mixed
 */
function AccepteCandidats($db, $statut, $poste_id)
{
    $sql = "UPDATE postulation SET statut=:statut WHERE poste_id=:poste_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':statut', $statut);
    $stmt->bindValue(':poste_id', $poste_id);
    return $stmt->execute();
}

/**
 * Summary of recalerCandidats
 * @param mixed $db
 * @param mixed $statut
 * @param mixed $poste_id
 * @return mixed
 */
function recalerCandidats($db, $statut, $poste_id)
{
    $sql = "UPDATE postulation SET statut=:statut WHERE poste_id=:poste_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':statut', $statut);
    $stmt->bindValue(':poste_id', $poste_id);
    return $stmt->execute();
}



function notification_suivi($db, $entreprise_id, $users_id, $statut)
{
    $sql = "INSERT INTO notification_suivi (entreprise_id,users_id,statut)
    VALUES (:entreprise_id,:users_id,:statut)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":entreprise_id", $entreprise_id, );
    $stmt->bindParam(":users_id", $users_id, );
    $stmt->bindParam(":statut", $statut, );
    return $stmt->execute();
}
