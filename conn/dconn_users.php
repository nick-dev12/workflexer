<?php

// Démarrez la session (s'il n'a pas déjà été démarré)
session_start();

// Si l'utilisateur est connecté, supprimer son token de la base de données
if (isset($_SESSION['users_id'])) {
    require_once(__DIR__ . '/conn.php');
    
    // Supprimer le token et sa date d'expiration de la base de données
    $sqlDeleteToken = "UPDATE users SET remember_token = NULL, remember_token_expires = NULL WHERE id = :userId";
    $stmtDeleteToken = $db->prepare($sqlDeleteToken);
    $stmtDeleteToken->bindParam(':userId', $_SESSION['users_id'], PDO::PARAM_INT);
    $stmtDeleteToken->execute();
}

// Effacer toutes les données de session
session_unset();

// Détruire la session en cours
session_destroy();

// Supprimer le cookie remember_me de manière plus complète
setcookie('remember_me', '', time() - 3600, '/'); // expiration dans le passé
setcookie('remember_me', '', time() - 3600, '/', '', false, true); // avec les mêmes paramètres que lors de la création

// Rediriger vers la page de connexion ou une autre page après la déconnexion
header('location: ../connection_compte.php');
exit();
?>