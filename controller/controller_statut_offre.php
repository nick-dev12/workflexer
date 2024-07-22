<?php

require_once(__DIR__ . '/../model/statut_offre.php');
include(__DIR__. '/../conn/conn.php');

// Récupérer toutes les offres dont le statut n'est pas expiré
$getAllOffres = getOffresExpirer($db);

// Date du jour
$date_aujourdhui = date('Y-m-d');

foreach ($getAllOffres as $offre) {
    // Comparer la date d'expiration avec la date du jour
    if ($offre['date_expiration'] <= $date_aujourdhui) {
        // Mettre à jour le statut de l'offre en "expirée"
        $sql_update = "UPDATE offre_emploi SET statut = 'expirée' WHERE offre_id = :offre_id";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->bindParam(':offre_id', $offre['offre_id']);
        $stmt_update->execute();
    }
}

