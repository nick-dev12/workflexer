<?php

include(__DIR__ . '/../../conn/conn.php');

/**
 * Summary of getOffres
 * @param mixed $db
 * @param mixed $offre_id
 * @return mixed
 */


function getOffres($db, $offre_id)
{
    $sql = "SELECT * FROM offre_emploi WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getOffres_suprimer($db, $offre_id)
{
    $sql = "SELECT * FROM offre_suprimer WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getAllOffres($db)
{
    $sql = "SELECT * FROM offre_emploi ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updatOffre($db, $poste, $mission, $profil, $contrat, $etudes, $experience, $localite, $langues, $categorie, $offre_id)
{
    $sql = "UPDATE offre_emploi SET poste = :poste, mission = :mission, profil = :profil,  contrat = :contrat, etudes = :etudes, experience = :experience, localite = :localite, langues = :langues, categorie = :categorie WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    // Liez les valeurs aux paramètres de la requête
    $stmt->bindValue(':poste', $poste, PDO::PARAM_STR);
    $stmt->bindValue(':mission', $mission, PDO::PARAM_STR);
    $stmt->bindValue(':profil', $profil, PDO::PARAM_STR);
    $stmt->bindValue(':contrat', $contrat, PDO::PARAM_STR);
    $stmt->bindValue(':etudes', $etudes, PDO::PARAM_STR);
    $stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
    $stmt->bindValue(':localite', $localite, PDO::PARAM_STR);
    $stmt->bindValue(':langues', $langues, PDO::PARAM_STR);
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function post_suprime_offre($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $statut, $categorie, $date)
{

    $sql = "INSERT INTO offre_suprimer (entreprise_id,poste,mission,profil,contrat,etudes,experience,n_etudes,n_experience,localite,langues, places, date_expiration,statut,categorie,date)
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



function post_vue_offre($db, $users_id, $offres_id, $entreprise_id)
{
    $sql = "INSERT INTO vue_des_offres(id_users, id_offre, id_entreprise) VALUES(:id_users, :id_offre, :id_entreprise)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id_users', $users_id);
    $stmt->bindValue(':id_offre', $offres_id);
    $stmt->bindValue(':id_entreprise', $entreprise_id);
    return $stmt->execute();
}

function get_vue_offre_users($db, $users_id, $offres_id)
{
    $sql = "SELECT * FROM vue_des_offres WHERE id_users = :id_users AND id_offre = :id_offre";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id_users', $users_id);
    $stmt->bindValue(':id_offre', $offres_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_vue_offre_entreprise($db, $entreprise_id, $offres_id)
{
    $sql = "SELECT * FROM vue_des_offres WHERE id_entreprise = :id_entreprise AND id_offre = :id_offre";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id_entreprise', $entreprise_id);
    $stmt->bindValue(':id_offre', $offres_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// function getTotalOffres($db){
//     $sql = " SELECT * FROM offre_emploi WHERE";
// }


function getOffreIngenieur($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Ingénierie et architecture' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffreDesign($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Design et création' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffreRédaction($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Rédaction et traduction' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffremarketing($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Marketing et communication' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOffrebusiness($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Conseil et gestion d\'entreprise' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOffreJuridique($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Juridique' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffreInformatique($db)
{
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Informatique et tech' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Summary of getOffresEmploit
 * @param mixed $db
 * @param mixed $offre_id
 * @return mixed
 */
function getOffresEmploit($db, $offre_id)
{
    $sql = "SELECT * FROM offre_emploi WHERE offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function updateOffreEmploit($db, $statut, $date_expiration, $offre_id)
{
    $sql = "UPDATE offre_emploi SET statut = :statut, date_expiration = :date_expiration WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
    $stmt->bindValue(':date_expiration', $date_expiration, PDO::PARAM_STR);
    return $stmt->execute();
}

function getOffresEmploitId($db)
{
    $sql = "SELECT * FROM offre_emploi WHERE offre_id=24";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function postVue($db, $offre_id, $users_id, $entreprise_id, $nom, $mail)
{
    $sql = "INSERT INTO vue_offre (offre_id,users_id,entreprise_id,nom,mail) 
    VALUES (:offre_id,:users_id,:entreprise_id,:nom,:mail)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':offre_id', $offre_id);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mail', $mail);
    return $stmt->execute();
}

/**
 * Summary of deleteOffresEmploit
 * @param mixed $db
 * @param mixed $offre_id
 * @return mixed
 */
function deleteOffresEmploit($db, $offre_id)
{
    $sql = "DELETE FROM offre_emploi WHERE offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    return $stmt->execute();
}
function deleteOffresEmploit_suprimer($db, $offre_id)
{
    $sql = "DELETE FROM offre_suprimer WHERE offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    return $stmt->execute();
}
function deletePostulation($db, $offre_id)
{
    $sql = "DELETE FROM postulation WHERE offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function PostHistoriqueUsers($db, $entreprise_id, $users_id, $offre_id)
{
    $sql = "INSERT INTO historique_users(entreprise_id,users_id,offre_id) VALUES(:entreprise_id,:users_id,:offre_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':offre_id', $offre_id);
    return $stmt->execute();
}
function getHistoriqueUsers($db, $users_id)
{
    $sql = "SELECT * FROM historique_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_categorieOffre($db, $entreprise_id)
{
    $sql = " SELECT categorie FROM offre_emploi WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countOffreExpirees($db, $entreprise_id)
{
    $sql = " SELECT COUNT(*) FROM offre_emploi WHERE entreprise_id = :entreprise_id AND statut = 'expirée'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getOffreExpiree($db, $entreprise_id, $categorie)
{
    $sql = " SELECT * FROM offre_emploi WHERE entreprise_id = :entreprise_id AND statut = 'expirée' AND categorie = :categorie";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffre_categorie($db, $categorie, $entreprise_id)
{
    $sql = " SELECT * FROM offre_emploi WHERE categorie = :categorie AND entreprise_id = :entreprise_id AND (statut = 'publier' OR statut = '')";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getALLcategorieEntreprise($db, $entreprise_id)
{
    $sql = " SELECT * FROM categorie WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_poste($db, $entreprise_id, $categorie)
{
    $sql = " SELECT * FROM offre_emploi WHERE entreprise_id = :entreprise_id AND categorie = :categorie";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function restoreOffre($db, $offre_id, $entreprise_id, $new_date_expiration)
{
    $sql = "UPDATE offre_emploi SET statut = 'publier' , date_expiration = :date_expiration WHERE offre_id = :offre_id AND entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->bindValue(':date_expiration', $new_date_expiration);
    $stmt->execute();
    return $stmt->rowCount();
}

function restorerOffre($db, $offre_id, $entreprise_id, $new_date_expiration)
{
    $sql = "UPDATE offre_suprimer SET statut = 'publier' , date_expiration = :date_expiration WHERE offre_id = :offre_id AND entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->bindValue(':date_expiration', $new_date_expiration);
    $stmt->execute();
    return $stmt->rowCount();
}



function getDetails_emploi($db, $offre_id)
{
    $sql = "SELECT * FROM scrap_emploi_emploisenegal WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getDetails_emploi2($db, $offre_id)
{
    $sql = "SELECT * FROM scrap_emploi_emploidakar WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getDetails_emploi3($db, $offre_id)
{
    $sql = "SELECT * FROM senjob WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fonction pour restaurer une offre supprimée dans la table des offres actives
 * @param mixed $db
 * @param mixed $entreprise_id
 * @param mixed $poste
 * @param mixed $mission
 * @param mixed $profil
 * @param mixed $contrat
 * @param mixed $etudes
 * @param mixed $experience
 * @param mixed $n_etudes
 * @param mixed $n_experience
 * @param mixed $localite
 * @param mixed $langues
 * @param mixed $places
 * @param mixed $date_expiration
 * @param mixed $categorie
 * @param mixed $date
 * @param mixed $ville
 * @param mixed $images
 * @return mixed
 */
function post_offre($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $categorie, $date, $ville, $images)
{
    $sql = "INSERT INTO offre_emploi (entreprise_id, poste, mission, profil, contrat, etudes, experience, n_etudes, n_experience, localite, langues, places, date_expiration, categorie, date, ville, images)
    VALUES (:entreprise_id, :poste, :mission, :profil, :contrat, :etudes, :experience, :n_etudes, :n_experience, :localite, :langues, :places, :date_expiration, :categorie, :date, :ville, :images)";
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
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':ville', $ville);
    $stmt->bindParam(':images', $images);
    return $stmt->execute();
}
