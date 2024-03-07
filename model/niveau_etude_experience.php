<?php
include(__DIR__ . '/../conn/conn.php');

function postNiveau($db, $users_id, $etude, $experience)
{
    $sql = "INSERT INTO niveau_etude (users_id,etude, experience) VALUES (:users_id, :etude, :experience)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":users_id", $users_id, PDO::PARAM_STR);
    $stmt->bindParam(":etude", $etude, PDO::PARAM_STR);
    $stmt->bindParam(":experience", $experience, PDO::PARAM_STR);
    return $stmt->execute();
}

function updateNiveau($db, $users_id, $etude, $experience)
{
    $sql = "UPDATE niveau_etude SET etude = :etude, experience = :experience WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":users_id", $users_id, PDO::PARAM_STR);
    $stmt->bindParam(":etude", $etude, PDO::PARAM_STR);
    $stmt->bindParam(":experience", $experience, PDO::PARAM_STR);
    return $stmt->execute();
}

function gettNiveau($db, $users_id)
{
    $sql = "SELECT * FROM niveau_etude WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":users_id", $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



?>