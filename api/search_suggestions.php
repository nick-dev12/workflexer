<?php
// Démarrer la session pour accéder aux variables de session
session_start();

// Inclusions nécessaires
require_once '../controller/controller_users.php';
require_once '../controller/controller_competence_users.php';
require_once '../controller/controller_categorie_users.php';

// Vérifier si une requête est envoyée
if (!isset($_GET['query']) || empty($_GET['query'])) {
    // Renvoyer une réponse vide si pas de requête
    echo json_encode([
        'success' => false,
        'message' => 'Aucune requête fournie',
        'suggestions' => []
    ]);
    exit;
}

// Récupérer et nettoyer le terme de recherche
$query = htmlspecialchars($_GET['query']);
$min_length = 2; // Longueur minimale pour commencer les suggestions

// Vérifier si la requête a une longueur suffisante
if (strlen($query) < $min_length) {
    echo json_encode([
        'success' => true,
        'message' => 'Requête trop courte',
        'suggestions' => []
    ]);
    exit;
}

// Récupérer les suggestions
try {
    $suggestions = [];

    // 1. Recherche dans les compétences (utilisation de DISTINCT pour éviter les doublons)
    $sql_competences = "SELECT DISTINCT competence FROM competence_users 
                        WHERE competence LIKE :query 
                        ORDER BY competence ASC 
                        LIMIT 5";
    $stmt_competences = $db->prepare($sql_competences);
    $stmt_competences->bindValue(':query', "%$query%", PDO::PARAM_STR);
    $stmt_competences->execute();
    $competences = $stmt_competences->fetchAll(PDO::FETCH_ASSOC);

    foreach ($competences as $competence) {
        $suggestions[] = [
            'type' => 'competence',
            'title' => $competence['competence'],
            'subtitle' => 'Compétence',
            'url' => '/page/search.php?search=' . urlencode($competence['competence']),
            'icon' => 'fa-tools'
        ];
    }

    // 2. Recherche dans les noms d'utilisateurs
    $sql_users = "SELECT id, nom, ville, categorie FROM users 
                 WHERE nom LIKE :query OR competences LIKE :query
                 LIMIT 5";
    $stmt_users = $db->prepare($sql_users);
    $stmt_users->bindValue(':query', "%$query%", PDO::PARAM_STR);
    $stmt_users->execute();
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $suggestions[] = [
            'type' => 'user',
            'title' => $user['nom'],
            'subtitle' => $user['ville'],
            'category' => $user['categorie'],
            'url' => '/page/candidats.php?id=' . $user['id'],
            'icon' => 'fa-user'
        ];
    }

    // 3. Recherche dans les catégories
    $sql_categories = "SELECT categorie FROM categorie_user 
                      WHERE categorie LIKE :query 
                      ORDER BY categorie ASC 
                      LIMIT 3";
    $stmt_categories = $db->prepare($sql_categories);
    $stmt_categories->bindValue(':query', "%$query%", PDO::PARAM_STR);
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        $suggestions[] = [
            'type' => 'category',
            'title' => $category['categorie'],
            'subtitle' => 'Catégorie',
            'url' => '/page/categorie.php?categorie=' . urlencode($category['categorie']),
            'icon' => 'fa-briefcase'
        ];
    }

    // Réponse JSON
    echo json_encode([
        'success' => true,
        'message' => 'Suggestions trouvées',
        'query' => $query,
        'suggestions' => $suggestions
    ]);

} catch (PDOException $e) {
    // En cas d'erreur
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de la recherche: ' . $e->getMessage(),
        'suggestions' => []
    ]);
}
exit;
?>