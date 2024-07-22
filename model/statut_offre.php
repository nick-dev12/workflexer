<?php

include(__DIR__. '/../conn/conn.php');

/**
 * Récupère toutes les offres dont le statut n'est pas expiré.
 * 
 * @param PDO $db
 * @return array
 */
function getOffresExpirer($db) {
    $sql = "SELECT * FROM offre_emploi WHERE statut != 'expirée'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

