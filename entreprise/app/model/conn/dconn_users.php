<?php
// Démarrez la session (s'il n'a pas déjà été démarré)
session_start();

// Effacer toutes les données de session
session_unset();

// Détruire la session en cours
session_destroy();

// Rediriger vers la page de connexion ou une autre page après la déconnexion
header('location: ../entreprise/connexion.php');
exit();
?>