<?php
require_once(__DIR__ . '/../model/admin.php');

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['admin'])) {
    $admin = infoAdmin($db, $_SESSION['admin']);
    // L'utilisateur est déjà connecté, pas besoin de vérifier le cookie
} elseif (isset($_COOKIE['remember_me'])) {
    // Le cookie remember_me est présent, essayons de reconnecter l'utilisateur

    $token = $_COOKIE['remember_me'];

    // Vérifier le jeton dans la base de données
    $sqlCheckToken = "SELECT id FROM admin WHERE remember_token = :token";
    $stmtCheckToken = $db->prepare($sqlCheckToken);
    $stmtCheckToken->bindParam(':token', $token);
    $stmtCheckToken->execute();
    $admin = $stmtCheckToken->fetchColumn();

    if ($admin) {
        // Jeton valide, connecter l'utilisateur
        $_SESSION['admin'] = $admin;
    }
}

if (isset($_POST['envoyer'])) {
    $info_admin = infoAdmin($db, $_SESSION['admin']);
    $mail = $info_admin['mail'];
    $nom = $info_admin['nom'];
    $message = htmlspecialchars($_POST['messages']);
    $utilisateur = $_GET['utilisateur_id'];
    $compte = 'admin';
    if (postMessage($db, $utilisateur, $compte, $message, $mail, $nom)) {
        $_SESSION['success_message'] = 'Message envoyer';
        header('Location: message_admin.php');
        exit;
    }

}


?>