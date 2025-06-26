<?php
require_once(__DIR__.'/../model/langue_users.php');

// Action: Ajouter une langue
if (isset($_POST['ajoutss'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $langue = isset($_POST['langue']) ? trim($_POST['langue']) : '';
        $niveau = isset($_POST['niveau']) ? trim($_POST['niveau']) : '';

        if (empty($langue) || empty($niveau)) {
            $_SESSION['error_message'] = "La langue et le niveau sont obligatoires.";
        } else {
            if (postLangue($db, $users_id, htmlspecialchars($langue, ENT_QUOTES, 'UTF-8'), htmlspecialchars($niveau, ENT_QUOTES, 'UTF-8'))) {
                $_SESSION['success_message'] = "Langue ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la langue.";
            }
        }
    }
    header('Location: user_profil.php#langues-section');
    exit;
}

// Action: Supprimer une langue
if (isset($_GET['suprimer'])) { // Attention: 'suprimer' avec un seul 'p'
    if (isset($_SESSION['users_id'])) {
        $id = $_GET['suprimer'];
        if (is_numeric($id) && deleteLangue($db, $id)) {
            $_SESSION['success_message'] = 'Langue supprimée avec succès.';
        } else {
            $_SESSION['error_message'] = 'Erreur lors de la suppression de la langue.';
        }
    }
    header('Location: user_profil.php#langues-section');
    exit;
}

// Affichage des données
if (isset($_GET['id'])) {
    $afficheLangue = getLangue($db, $_GET['id']);
} elseif (isset($_SESSION['users_id'])) {
    $afficheLangue = getLangue($db, $_SESSION['users_id']);
}
?>