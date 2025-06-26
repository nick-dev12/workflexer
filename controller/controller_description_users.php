<?php

require_once(__DIR__ . '/../model/description_users.php');

// Traitement de l'ajout de description
if (isset($_POST['ajouter'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        if (empty($description)) {
            $_SESSION['error_message'] = "Veuillez saisir votre description.";
        } else {
            $description = htmlspecialchars(nl2br($description), ENT_QUOTES, 'UTF-8');
            if (insertDescription($db, $users_id, $description)) {
                $_SESSION['success_message'] = "Description ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la description.";
            }
        }
    } else {
        $_SESSION['error_message'] = "Utilisateur non authentifié.";
    }
    header('Location: user_profil.php#a-propos-section');
    exit;
}

// Traitement de la modification de description
if (isset($_POST['Modifier'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $nouvelleDescription = isset($_POST['nouvelleDescription']) ? trim($_POST['nouvelleDescription']) : '';

        if (empty($nouvelleDescription)) {
            $_SESSION['error_message'] = "Veuillez saisir votre nouvelle description.";
        } else {
            $nouvelleDescription = htmlspecialchars(nl2br($nouvelleDescription), ENT_QUOTES, 'UTF-8');
            if (modifierDescription($db, $users_id, $nouvelleDescription)) {
                $_SESSION['success_message'] = "Description modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification de la description.";
            }
        }
    } else {
        $_SESSION['error_message'] = "Utilisateur non authentifié.";
    }
    header('Location: user_profil.php#a-propos-section');
    exit;
}

if (isset($_GET['id'])) {
    $descriptions = afficheDescription($db, $_GET['id']);
} else {
    $descriptions = afficheDescription($db, $_SESSION['users_id']);
}

?>