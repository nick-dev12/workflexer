<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../model/outil_users.php');

// Action: Mettre à jour "mis_en_avant" (AJAX)
if (isset($_POST['action']) && $_POST['action'] === 'updateOutilHighlights') {
    header('Content-Type: application/json');
    if (isset($_SESSION['users_id'])) {
        $highlightedOutils = json_decode($_POST['highlighted_outils'], true);
        $userId = $_SESSION['users_id'];
        
        if (updateOutilHighlights($db, $highlightedOutils, $userId)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des outils.']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    }
    exit;
}

// Action: Ajouter un outil
if (isset($_POST['ajouts'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $outil = isset($_POST['outil']) ? trim($_POST['outil']) : '';
        $niveau = isset($_POST['niveau']) ? trim($_POST['niveau']) : '';

        if (empty($outil) || empty($niveau)) {
            $_SESSION['error_message'] = "Le nom de l'outil et le niveau sont obligatoires.";
        } else {
            if (postOutil($db, $users_id, htmlspecialchars($outil, ENT_QUOTES, 'UTF-8'), htmlspecialchars($niveau, ENT_QUOTES, 'UTF-8'))) {
                $_SESSION['success_message'] = "Outil ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de l'outil.";
            }
        }
    }
    header('Location: user_profil.php#outils-section');
    exit;
}

// Action: Supprimer un outil
if (isset($_GET['suprimerOutils'])) {
    if (isset($_SESSION['users_id'])) {
        $id = $_GET['suprimerOutils'];
        if (is_numeric($id) && deleteOutils($db, $id)) {
            $_SESSION['success_message'] = 'Outil supprimé avec succès.';
        } else {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'outil.";
        }
    }
    header('Location: user_profil.php#outils-section');
    exit;
}

// Affichage des données
if (isset($_GET['id'])) {
    $afficheOutil = getOutil($db, $_GET['id']);
    $afficheOutilLimit5 = selectOutilLimit5($db, $_GET['id']);
} else {
    if (isset($_SESSION['users_id'])) {
        $afficheOutil = getOutil($db, $_SESSION['users_id']);
        $afficheOutilLimit5 = selectOutilLimit5($db, $_SESSION['users_id']);
    }
}
?>