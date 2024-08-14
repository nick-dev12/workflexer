<?php

include(__DIR__.'../../conn/conn.php');

function postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif,$sujet, $date)
{
    $sql = "INSERT INTO message1 (entreprise_id,users_id,offre_id,statut,messages,indicatif,sujet ,date)
VALUES (:entreprise_id,:users_id,:offre_id,:statut,:messages,:indicatif,:sujet,:date)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":entreprise_id", $entreprise_id, );
    $stmt->bindParam(":users_id", $users_id, );
    $stmt->bindParam(":offre_id", $offre_id, );
    $stmt->bindParam(":statut", $statut, );
    $stmt->bindParam(":messages", $messages, );
    $stmt->bindParam(":indicatif", $indicatif, );
    $stmt->bindParam(":sujet", $sujet, );
    $stmt->bindParam(":date", $date, );
    return $stmt->execute();
}

function post_TMPMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif,$sujet, $date )
{
    $sql = "INSERT INTO tmp_message1 (entreprise_id,users_id,offre_id,statut,messages,indicatif,sujet ,date)
VALUES (:entreprise_id,:users_id,:offre_id,:statut,:messages,:indicatif,:sujet,:date)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":entreprise_id", $entreprise_id, );
    $stmt->bindParam(":users_id", $users_id, );
    $stmt->bindParam(":offre_id", $offre_id, );
    $stmt->bindParam(":statut", $statut, );
    $stmt->bindParam(":messages", $messages, );
    $stmt->bindParam(":indicatif", $indicatif, );
    $stmt->bindParam(":sujet", $sujet, );
    $stmt->bindParam(":date", $date, );
    return  $stmt->execute();
}

function getMessage1($db, $entreprise_id, $offre_id, $users_id)
{
    $sql = "SELECT * FROM message1 WHERE 
    entreprise_id=:entreprise_id AND offre_id =:offre_id AND users_id=:users_id ORDER BY dates DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getTMP1_Message1($db, $entreprise_id, $offre_id, $users_id)
{
    $sql = "SELECT * FROM tmp_message1 WHERE 
    entreprise_id=:entreprise_id AND offre_id =:offre_id AND users_id=:users_id AND indicatif= 'recruteur' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getTMP1_Message2($db, $entreprise_id, $offre_id, $users_id)
{
    $sql = "SELECT * FROM tmp_message1 WHERE 
    entreprise_id=:entreprise_id AND offre_id =:offre_id AND users_id=:users_id AND indicatif= 'candidat' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getMessage2($db, $entreprise_id, $users_id)
{
    $sql = "SELECT * FROM message1 WHERE 
    entreprise_id=:entreprise_id AND users_id=:users_id AND sujet='appel' ORDER BY dates DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getTMP2_Message2($db, $entreprise_id, $users_id)
{
    $sql = "SELECT * FROM tmp_message1 WHERE 
    entreprise_id=:entreprise_id AND users_id=:users_id AND indicatif= 'candidat' AND sujet='appel'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTMP2_Message3($db, $entreprise_id, $users_id)
{
    $sql = "SELECT * FROM tmp_message1 WHERE 
    entreprise_id=:entreprise_id AND users_id=:users_id AND indicatif= 'recruteur' AND sujet='appel'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAppelOffre($db, $entreprise_id, $users_id)
{
    $sql = "SELECT * FROM appel_offre WHERE 
    entreprise_id=:entreprise_id AND users_id=:users_id ORDER BY date DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAutreMessageEntreprise($db)
{
    $sql = "SELECT * FROM message1 ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Summary of deletMessage
 * @param mixed $db
 * @param mixed $message_id
 * @return mixed
 */
function deletMessage($db, $message_id)
{
    $sql = "DELETE  FROM message1 WHERE message_id = :message_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':message_id', $message_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function deletTMP_Message($db, $entreprise_id, $offre_id, $users_id)
{
    $sql = "DELETE  FROM tmp_message1 WHERE entreprise_id=:entreprise_id AND offre_id =:offre_id AND users_id=:users_id AND indicatif= 'recruteur' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    return $stmt->execute();
}

function deletTMP_Message2($db, $entreprise_id, $offre_id, $users_id)
{
    $sql = "DELETE  FROM tmp_message1 WHERE entreprise_id=:entreprise_id AND offre_id =:offre_id AND users_id=:users_id AND indicatif= 'candidat' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    return  $stmt->execute();
}

function deletTMP_Message3($db, $entreprise_id, $users_id)
{
    $sql = "DELETE  FROM tmp_message1 WHERE entreprise_id=:entreprise_id AND users_id=:users_id AND indicatif= 'candidat' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    return  $stmt->execute();
}

function deletTMP_Message4($db, $entreprise_id, $users_id)
{
    $sql = "DELETE  FROM tmp_message1 WHERE entreprise_id=:entreprise_id  AND users_id=:users_id AND indicatif= 'recruteur' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    return $stmt->execute();
}

function notification_message($db,$entreprise_id,$users_id) {
    $sql = "INSERT INTO notification_message (entreprise_id,users_id)
    VALUES (:entreprise_id,:users_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":entreprise_id", $entreprise_id, );
        $stmt->bindParam(":users_id", $users_id, );
        return $stmt->execute();
}

function notification_messageUsers($db,$entreprise_id,$users_id ,$sujet) {
    $sql = "INSERT INTO notification_message_users (entreprise_id,users_id,sujet)
    VALUES (:entreprise_id,:users_id,:sujet)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":entreprise_id", $entreprise_id, );
        $stmt->bindParam(":users_id", $users_id, );
        $stmt->bindParam(":sujet", $sujet, );
        return $stmt->execute();
}

function get_message($db,$entreprise_id) {
    $sql = "SELECT * from notification_message WHERE entreprise_id = :entreprise_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":entreprise_id", $entreprise_id, );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_notificationPostulation($db,$entreprise_id) {
    $sql = "SELECT * from notification_postulation WHERE entreprise_id = :entreprise_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":entreprise_id", $entreprise_id, );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_messageUsers($db,$users_id) {
    $sql = "SELECT * from notification_message_users WHERE users_id = :users_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":users_id", $users_id, );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_notif_suiviAccepter($db,$users_id) {
    $sql = "SELECT * from notification_suivi WHERE users_id = :users_id  AND statut = 'accepter' ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":users_id", $users_id, );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_notif_suiviRecaler($db,$users_id) {
    $sql = "SELECT * from notification_suivi WHERE users_id = :users_id AND statut = 'recaler'";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":users_id", $users_id, );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateDatePostulation($db,$entreprise_id,$users_id,$offre_id , $dates) {
        $sql = "UPDATE postulation SET date = :date WHERE entreprise_id = :entreprise_id AND users_id = :users_id AND offre_id = :offre_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":date", $dates, );
        $stmt->bindParam(":entreprise_id", $entreprise_id, );
        $stmt->bindParam(":users_id", $users_id, );
        $stmt->bindParam(":offre_id", $offre_id, );
        return $stmt->execute();
}

function updateDateAppelOffre($db,$entreprise_id,$users_id , $dates) {
    $sql = "UPDATE postulation SET date = :date WHERE entreprise_id = :entreprise_id AND users_id = :users_id AND sujet = 'appel'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":date", $dates, );
    $stmt->bindParam(":entreprise_id", $entreprise_id, );
    $stmt->bindParam(":users_id", $users_id, );
    return $stmt->execute();
}
