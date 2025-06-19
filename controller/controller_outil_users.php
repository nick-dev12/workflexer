<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../model/outil_users.php');

// Gestion de la mise en avant des outils
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateOutilHighlights') {
    // Activer l'affichage des erreurs pour le débogage
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    // Log pour le débogage
    error_log("Requête AJAX reçue pour updateOutilHighlights");
    
    if (isset($_SESSION['users_id'])) {
        $highlightedOutils = json_decode($_POST['highlighted_outils'], true);
        $userId = $_SESSION['users_id'];
        
        error_log("ID utilisateur: " . $userId);
        error_log("Outils sélectionnés: " . print_r($highlightedOutils, true));
        
        if (updateOutilHighlights($db, $highlightedOutils, $userId)) {
            error_log("Mise à jour réussie");
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            error_log("Échec de la mise à jour");
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
        exit;
    } else {
        error_log("Session utilisateur non définie");
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
        exit;
    }
}

if (isset($_POST['ajouts'])) {

    $outil = '';
    $niveau = '';

    $users_id = $_SESSION['users_id'];

    if (empty($_POST['outil'])) {
        $_SESSION['error_message'] = " champs vide ";
    } else {
        $outil = $_POST['outil'];
    }

    if (empty($_POST['niveau'])) {
        $erreurs = 'veuiller entrer un niveau.';
        $_SESSION['error_message'] = " choisissez un niveau";
    } else {
        $niveau = $_POST['niveau'];
    }

    if (empty($_SESSION['error_message'])) {
        if (postOutil($db, $users_id, $outil, $niveau)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit;
        }
    }
}



if (isset($_GET['id'])) {
    $afficheOutil = getOutil($db, $_GET['id']);
    $afficheOutilLimit5 = selectOutilLimit5($db, $_GET['id']);
} else {
    if (isset($_SESSION['users_id'])) {
        $afficheOutil = getOutil($db, $_SESSION['users_id']);
        $afficheOutilLimit5 = selectOutilLimit5($db, $_SESSION['users_id']);
    }

}


if (isset($_GET['suprimerOutils'])) {

    $id = $_GET['suprimerOutils'];

    if (deleteOutils($db, $id)) {
        $_SESSION['success_message'] = 'Opération réussie ';
        header('Location: user_profil.php');
        exit;
    }
}
?>