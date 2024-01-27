<?php

include(__DIR__. '/conn/conn.php');

/**
 * Summary of getOffres
 * @param mixed $db
 * @param mixed $offre_id
 * @return mixed
 */


function getOffres($db, $offre_id) {
    $sql = "SELECT * FROM offre_emploi WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
        
    
}
function getAllOffres($db){
    $sql = "SELECT * FROM offre_emploi LIMIT 10";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    
}


function updatOffre($db,$poste,$mission,$profil,$contrat,$etudes,$experience,$localite,$langues, $offre_id ){
    $sql = "UPDATE offre_emploi SET poste = :poste, mission = :mission, profil = :profil,  contrat = :contrat, etudes = :etudes, experience = :experience, localite = :localite, langues = :langues WHERE offre_id = :offre_id";
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
    $stmt->bindValue(':offre_id', $offre_id, PDO::PARAM_INT);
     return  $stmt->execute();
}

// function getTotalOffres($db){
//     $sql = " SELECT * FROM offre_emploi WHERE";
// }


function getOffreIngenieur($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Ingénierie' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffreDesign($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'design' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffreRédaction($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Rédaction' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffremarketing($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'marketing' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOffrebusiness($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'business' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOffreJuridique($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Juridique' 
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getOffreInformatique($db){
    $sql = "SELECT * FROM offre_emploi t1
    JOIN compte_entreprise t2 ON t2.id = t1.entreprise_id
    WHERE t1.categorie = 'Informatique' 
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
function getOffresEmploit($db,$offre_id){
    $sql= "SELECT * FROM offre_emploi WHERE offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id',$offre_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function postVue ($db,$offre_id,$users_id, $entreprise_id,$nom,$mail){
    $sql = "INSERT INTO vue_offre (offre_id,users_id,entreprise_id,nom,mail) 
    VALUES (:offre_id,:users_id,:entreprise_id,:nom,:mail)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':offre_id',$offre_id);
    $stmt->bindParam(':users_id',$users_id);
    $stmt->bindParam(':entreprise_id',$entreprise_id);
    $stmt->bindParam(':nom',$nom);
    $stmt->bindParam(':mail',$mail);
    return $stmt->execute();
}

/**
 * Summary of deleteOffresEmploit
 * @param mixed $db
 * @param mixed $offre_id
 * @return mixed
 */
function deleteOffresEmploit($db,$offre_id){
    $sql= "DELETE FROM offre_emploi WHERE offre_id=:offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offre_id',$offre_id, PDO::PARAM_INT);
    return  $stmt->execute();
}
?>