<?php

include(__DIR__ . '/../conn/conn.php');

function postCertificat($db, $users_id, $certificat)
{
    $sql = "INSERT INTO certificat_users (users_id, certificat) VALUES (:users_id, :certificat)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':certificat', $certificat);
    return $stmt->execute();
}


function getCertificat($db, $user_id)
{
    $sql = "SELECT id , certificat FROM certificat_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteCertificats($db, $id)
{
    $sql = "DELETE FROM certificat_users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>