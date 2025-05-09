<?php
include(__DIR__ . '/../conn/conn.php');

/**
 * Summary of getTotalUsers
 * @param mixed $db
 * @return mixed
 */
function getTotalUsers($db, $offset = 0, $limit = 20)
{
    $sql = "SELECT * FROM users LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalUsersCount($db)
{
    $sql = "SELECT COUNT(*) as total FROM users";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

/**
 * Summary of getUsers
 * @param mixed $db
 * @param mixed $categorie
 * @return mixed
 */
function getUsers($db)
{
    $sql = "SELECT * FROM users ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserslimit20($db)
{
    $sql = "SELECT * FROM users LIMIT 20";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function infoUsers($db, $users_id)
{
    $sql = "SELECT * FROM users WHERE id = :id ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Summary of getUsersInformatique
 * @param mixed $db
 * @return mixed
 */


function getInfoUsers($db, $id)
{
    $sql = "SELECT * FROM users WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function Occuper($db, $statut, $id)
{
    $sql = "UPDATE users SET statut=:statut WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':statut', $statut);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
}


/**
 * Summary of recalerCandidats
 * @param mixed $db
 * @param mixed $statut
 * @param mixed $poste_id
 * @return mixed
 */
function Disponible($db, $statut, $id)
{
    $sql = "UPDATE users  SET statut=:statut WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':statut', $statut);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
}



function update11($db, $nom, $users_id)
{
    $sql = " UPDATE users SET nom = :nom WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function update33($db, $mail, $users_id)
{
    $sql = " UPDATE users SET mail = :mail WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update44($db, $phone, $users_id)
{
    $sql = " UPDATE users SET phone = :phone WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update55($db, $competence, $users_id)
{
    $sql = " UPDATE users SET competences = :competences WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':competences', $competence, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update66($db, $ville, $users_id)
{
    $sql = " UPDATE users SET ville = :ville WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update77($db, $profession, $users_id)
{
    $sql = " UPDATE users SET profession = :profession WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':profession', $profession, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update88($db, $categorie, $users_id)
{
    $sql = " UPDATE users SET categorie = :categorie WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update99($db, $hashedPass1, $users_id)
{
    $sql = " UPDATE users SET passe = :pass1 WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pass1', $hashedPass1, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update00($db, $images, $users_id)
{
    $sql = " UPDATE users SET images = :images WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':images', $images, PDO::PARAM_STR);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



function PostHistorique($db, $entreprise_id, $users_id)
{
    $sql = "INSERT INTO historique(entreprise_id,users_id) VALUES(:entreprise_id,:users_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':users_id', $users_id);
    return $stmt->execute();
}

function GetVueProfil($db, $profil_id)
{
    $sql = "SELECT * FROM vue_profil WHERE profil_id=:profil_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':profil_id', $profil_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->rowCount();
}
?>