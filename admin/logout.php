<?php
session_start();

// Supprimer le cookie de connexion
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

// Détruire la session
unset($_SESSION['admin']);
session_destroy();

// Rediriger vers la page de connexion
header('Location: ad_min.php');
exit;
?>