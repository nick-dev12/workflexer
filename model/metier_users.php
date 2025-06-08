<?php
include(__DIR__ . '/../conn/conn.php');


/**
 * Summary of insertMetier
 * @param mixed $users_id
 * @param mixed $metier
 * @param mixed $description
 * @return void
 */
function insertMetier($db, $users_id, $metier, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $encours, $description)
{
    // Préparation de la requête SQL
    $sql = "INSERT INTO metier_users (users_id, metier,moisDebut, anneeDebut, moisFin,anneeFin, en_cours, description ) 
     VALUES (:users_id, :metier,:moisDebut, :anneeDebut, :moisFin, :anneeFin, :en_cours, :description)";
    // Préparation de la requête 
    $stmt = $db->prepare($sql);
    // Association des paramètres
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':metier', $metier);
    $stmt->bindParam(':moisDebut', $moisDebut);
    $stmt->bindParam(':anneeDebut', $anneeDebut);
    $stmt->bindParam(':moisFin', $moisFin);
    $stmt->bindParam(':anneeFin', $anneeFin);
    $stmt->bindParam(':en_cours', $encours);
    $stmt->bindParam(':description', $description);
    // Exécution de la requête
    return $stmt->execute();
}

function updateMetier($db, $id, $metier, $moisDebut, $anneeDebut, $encours, $moisFin, $anneeFin, $description)
{
    $sql = "UPDATE metier_users SET metier = :metier, moisDebut = :moisDebut, anneeDebut = :anneeDebut,en_cours = :en_cours, moisFin = :moisFin, anneeFin = :anneeFin, description = :description WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':metier', $metier);
    $stmt->bindParam(':moisDebut', $moisDebut);
    $stmt->bindParam(':anneeDebut', $anneeDebut);
    $stmt->bindParam(':en_cours', $encours);
    $stmt->bindParam(':moisFin', $moisFin);
    $stmt->bindParam(':anneeFin', $anneeFin);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

/**
 * Summary of getMetier
 * @param mixed $db
 * @param mixed $users_id
 * @return mixed
 */
function getMetier($db, $users_id)
{
    // Requête pour récupérer les métiers
    $sql = "SELECT * FROM metier_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function suprimeMetier($db, $id)
{
    // Requête DELETE
    $sql = "DELETE FROM metier_users WHERE id = :id";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

}
;
?>