<?php
// Inclusion du fichier de configuration de la base de données
if (!isset($db)) {
    require_once(__DIR__ . '/../model/database.php');
}

/**
 * Récupère toutes les catégories d'utilisateurs de la base de données
 * 
 * @param PDO $db Connexion à la base de données
 * @return array Tableau contenant toutes les catégories
 */
function getAllCategories($db)
{
    try {
        $query = "SELECT id, categorie FROM categorie_user ORDER BY categorie ASC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log l'erreur et retourne un tableau vide
        error_log("Erreur lors de la récupération des catégories: " . $e->getMessage());
        return [];
    }
}

/**
 * Récupère les utilisateurs par catégorie
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $categorie La catégorie recherchée
 * @param int $offset Décalage pour la pagination
 * @param int $limit Nombre d'utilisateurs à récupérer
 * @return array Tableau d'utilisateurs appartenant à la catégorie spécifiée
 */
function getUsersByCategory($db, $categorie, $offset = 0, $limit = 20)
{
    try {
        $query = "SELECT u.* FROM users u 
                  WHERE u.categorie = :categorie 
                  LIMIT :offset, :limit";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log l'erreur et retourne un tableau vide
        error_log("Erreur lors de la récupération des utilisateurs par catégorie: " . $e->getMessage());
        return [];
    }
}

/**
 * Compte le nombre total d'utilisateurs dans une catégorie
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $categorie La catégorie recherchée
 * @return int Nombre total d'utilisateurs dans la catégorie
 */
function countUsersByCategory($db, $categorie)
{
    try {
        $query = "SELECT COUNT(*) as total FROM users WHERE categorie = :categorie";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
        error_log("Erreur lors du comptage des utilisateurs par catégorie: " . $e->getMessage());
        return 0;
    }
}
?>