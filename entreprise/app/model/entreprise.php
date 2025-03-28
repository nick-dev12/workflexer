<?php

include(__DIR__ . '/../../../conn/conn.php');

/**
 * Summary of getEntreprise
 * @param mixed $db
 * @param mixed $id
 * @return mixed
 */
function getEntreprise($db, $id)
{
    $sql = " SELECT * FROM compte_entreprise WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function geAlltEntreprise($db)
{
    $sql = " SELECT * FROM compte_entreprise";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}


/**
 * Summary of postOffres
 * @param mixed $db
 * @param mixed $entreprise_id
 * @param mixed $poste
 * @param mixed $mission
 * @param mixed $profil
 * @param mixed $metier
 * @param mixed $contrat
 * @param mixed $etude
 * @param mixed $region
 * @param mixed $experience
 * @param mixed $langues
 * @param mixed $categorie
 * @param mixed $date
 * @return mixed
 */
function postOffres($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $statut, $categorie, $date)
{

    $sql = "INSERT INTO offre_emploi (entreprise_id,poste,mission,profil,contrat,etudes,experience,n_etudes,n_experience,localite,langues, places, date_expiration,statut,categorie,date)
    VALUES (:entreprise_id, :poste,:mission,:profil,:contrat,:etudes,:experience,:n_etudes,:n_experience,:localite,:langues, :places, :date_expiration,:statut,:categorie,:date)";
    $stmt = $db->prepare($sql);
    // Bind de chaque paramètre
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':poste', $poste);
    $stmt->bindParam(':mission', $mission);
    $stmt->bindParam(':profil', $profil);
    $stmt->bindParam(':contrat', $contrat);
    $stmt->bindParam(':etudes', $etudes);
    $stmt->bindParam(':experience', $experience);
    $stmt->bindParam(':n_etudes', $n_etudes);
    $stmt->bindParam(':n_experience', $n_experience);
    $stmt->bindParam(':localite', $localite);
    $stmt->bindParam(':langues', $langues);
    $stmt->bindParam(':places', $places);
    $stmt->bindParam(':date_expiration', $date_expiration);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':date', $date);
    return $stmt->execute();
}

function posteCategorie($db, $categorie, $entreprise_id)
{
    $sql = "INSERT INTO categorie (categori, entreprise_id) VALUES (:categori, :entreprise_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':categori', $categorie);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    return $stmt->execute();
}


function Categorie($db, $entreprise_id, $categorie)
{
    $sql_c = "SELECT categori FROM categorie WHERE categori = :categori AND entreprise_id = :entreprise_id";
    $stmt_c = $db->prepare($sql_c);
    $stmt_c->bindParam(':categori', $categorie);
    $stmt_c->bindParam(':entreprise_id', $entreprise_id);
    $stmt_c->execute();
    return $stmt_c->fetch(PDO::FETCH_ASSOC);
}

function PostCategorie($db, $entreprise_id, $categorie)
{
    $sql_c = "INSERT INTO categorie (categori, entreprise_id) VALUES (:categori, :entreprise_id)";
    $stmt_c = $db->prepare($sql_c);
    $stmt_c->bindParam(':categori', $categorie);
    $stmt_c->bindParam(':entreprise_id', $entreprise_id);
    return $stmt_c->execute();

}

/**
 * Summary of getOffresEmplois
 * @param mixed $db
 * @param mixed $entreprise_id
 * @return mixed
 */
function getOffresEmplois($db, $entreprise_id)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t1.entreprise_id = t2.id
     WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

function getOffresEmplois_suprimer($db, $entreprise_id)
{
    $sql = "SELECT * FROM offre_suprimer t1
    JOIN compte_entreprise t2 ON t1.entreprise_id = t2.id
     WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

function getOffresEmplois_suprimer_categorie($db, $entreprise_id, $categorie)
{
    $sql = "SELECT * FROM offre_suprimer WHERE entreprise_id = :entreprise_id AND categorie = :categorie";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

function selectOffre($db, $entreprise_id)
{
    $sql = "SELECT * FROM offre_emploi WHERE entreprise_id = :entreprise_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function AllUsers($db)
{
    $sql = "SELECT * FROM users ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function update1($db, $nom, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET nom = :nom WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update2($db, $entreprise, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET entreprise = :entreprise WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise', $entreprise, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update3($db, $mail, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET mail = :mail WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update4($db, $phone, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET phone = :phone WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update5($db, $types, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET types = :types WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':types', $types, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update6($db, $ville, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET ville = :ville WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update7($db, $taille, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET taille = :taille WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':taille', $taille, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update8($db, $categorie, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET categorie = :categorie WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update9($db, $hashedPass1, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET passe = :pass1 WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pass1', $hashedPass1, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function update0($db, $images, $entreprise_id)
{
    $sql = " UPDATE compte_entreprise SET images = :images WHERE id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':images', $images, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getHistorique($db, $entreprise_id)
{
    $sql = "SELECT * FROM historique WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>