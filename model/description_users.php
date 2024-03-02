<?php
include(__DIR__.'/../conn/conn.php');



/**
 * Summary of insertDescription
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $description
 * @return mixed
 */
function insertDescription($db, $users_id, $description)
{
    // Préparation de la requête SQL
    $sql = "INSERT INTO description_users (users_id, description ) 
     VALUES (:users_id, :description)";

    // Préparation de la requête 
    $stmt = $db->prepare($sql);

    // Association des paramètres
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':description', $description);

    // Exécution de la requête
    return $stmt->execute();
}
;

/**
 * Summary of modifierDescription
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $nouvelleDescription
 * @return mixed
 */
function modifierDescription ($db, $users_id, $nouvelleDescription){
    $sql = "UPDATE description_users SET description = :nouvelleDescription WHERE users_id = :users_id"; // Correction ici

    // Préparation de la requête 
    $stmt = $db->prepare($sql);

    // Association des paramètres
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':nouvelleDescription', $nouvelleDescription); // Correction ici, en enlevant l'espace

    // Exécution de la requête
   return $stmt->execute();
}


/**
 * Summary of afficheDescription
 * @param mixed $db
 * @param mixed $users_id
 * @return mixed
 */
function afficheDescription($db, $users_id ){
    $conn = "SELECT  * FROM description_users WHERE users_id = :users_id";
$stm = $db->prepare($conn);
$stm->bindvalue(':users_id', $users_id);
$stm->execute();
return $stm->fetch(PDO::FETCH_ASSOC);
}
?>