<?php
include ('../conn/conn.php');


/**
 * Summary of postCandidature
 * @param mixed $db
 * @param mixed $entreprise_id
 * @param mixed $poste
 * @param mixed $offre_id
 * @param mixed $users_id
 * @param mixed $nom
 * @param mixed $mail
 * @param mixed $phone
 * @param mixed $competences
 * @param mixed $profession
 * @param mixed $images
 * @param mixed $categorie
 * @return mixed
 */
function postCandidature($db, $entreprise_id, $poste, $offre_id, $users_id, $nom, $maile, $phone, $competences, $profession, $images ,$categorie)
{
    $sql = "INSERT INTO postulation (entreprise_id,poste,offre_id,users_id,nom,mail,phone,competences,profession,images,categorie) 
    VALUES (:entreprise_id,:poste,:offre_id,:users_id,:nom,:mail,:phone,:competences,:profession,:images,:categorie)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':poste', $poste);
    $stmt->bindParam(':offre_id', $offre_id);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mail', $maile);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':competences', $competences);
    $stmt->bindParam(':profession', $profession);
    $stmt->bindParam(':images', $images);
    $stmt->bindParam(':categorie', $categorie);
    return $stmt->execute();
}



/**
 * Summary of getPostulation
 * @param mixed $db
 * @param mixed $users_id
 * @param mixed $offre_id
 * @return mixed
 */
function getPostulation($db, $users_id, $offre_id)
{
    $sql = "SELECT * FROM postulation WHERE users_id=:users_id AND offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



/**
 * Summary of getALLPostulation
 * @param mixed $db
 * @param mixed $entreprise_id
 * @return mixed
 */
function getALLPostulation($db, $entreprise_id)
{
    $sql = "SELECT * FROM postulation WHERE entreprise_id=:entreprise_id ORDER BY (statut = 'accepter') DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countALLPostulationAccept($db, $entreprise_id)
{
    $sql = "SELECT * FROM postulation WHERE entreprise_id = :entreprise_id AND statut = 'accepter'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->rowCount();
}

function countALLPostulationRecaler($db, $entreprise_id)
{
    $sql = "SELECT * FROM postulation WHERE entreprise_id = :entreprise_id AND statut = 'recaler'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->rowCount();
}
function countALLPostulation($db, $entreprise_id)
{
    $sql = "SELECT * FROM postulation WHERE entreprise_id = :entreprise_id AND statut = '' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->rowCount();
}



/**
 * Summary of affichePostulant
 * @param mixed $db
 * @param mixed $poste_id
 * @return mixed
 */
function affichePostulant($db, $poste_id)
{
    $sql = "SELECT * FROM postulation WHERE poste_id=:poste_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':poste_id', $poste_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getPostulationUsers($db, $users_id)
{
    $sql = "SELECT * FROM postulation WHERE users_id=:users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getPostulation_categorie($db, $entreprise_id)
{
    // Sélection des postulations avec les informations des offres d'emploi associées
    $sql = "SELECT postulation.*, offre_emploi.categorie
              FROM postulation
              INNER JOIN offre_emploi ON postulation.offre_id = offre_emploi.offre_id
              WHERE postulation.entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


