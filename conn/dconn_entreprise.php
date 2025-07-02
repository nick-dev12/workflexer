<?php
// Démarrez la session (s'il n'a pas déjà été démarré)
session_start();
// Si l'entreprise est connectée, supprimer son token de la base de données
if (isset($_SESSION['compte_entreprise'])) {
    require_once(__DIR__ . '/conn.php');
    $remember_token = '';
    // Supprimer le token de la base de données
    $sqlDeleteToken = "UPDATE compte_entreprise SET remember_token = :remember_token WHERE id = :entrepriseId";
    $stmtDeleteToken = $db->prepare($sqlDeleteToken);
    $stmtDeleteToken->bindParam(':entrepriseId', $_SESSION['compte_entreprise']);
    $stmtDeleteToken->bindParam(':remember_token', $remember_token);
    $stmtDeleteToken->execute();
}


// Effacer toutes les données de session
session_unset();

// Détruire la session en cours
session_destroy();

// Supprimer le cookie remember_me

setcookie('compte_entreprises', '', time() - 3600, '/'); // expiration dans le passé
setcookie('compte_entreprises', '', time() - 3600, '/', '', false, true); // avec les mêmes paramètres que lors de la création


// Rediriger vers la page de connexion ou une autre page après la déconnexion
header('location: ../connection_compte.php');
exit();


?>