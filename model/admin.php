<?php
include(__DIR__ . '/../conn/conn.php');

function infoAdmin($db, $admin_id)
{
    $conn = "SELECT * FROM admin WHERE id = :admin";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':admin', $admin_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function postMessage($db, $utilisateur, $compte, $message, $mail, $nom)
{
    $sql = "INSERT INTO admin_message (utilisateur_id, compte,message,mail,nom) VALUES (:utilisateur_id, :compte,:message,:mail,:nom)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":utilisateur_id", $utilisateur);
    $stmt->bindValue(":compte", $compte);
    $stmt->bindValue(":message", $message);
    $stmt->bindValue(":mail", $mail);
    $stmt->bindValue(":nom", $nom);
    return $stmt->execute();
}

?>