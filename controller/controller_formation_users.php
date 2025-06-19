<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusion du fichier de configuration de la base de données
require_once(__DIR__ . '/../model/formation_users.php');

// Gestion de la mise en avant des formations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateFormationHighlights') {
    // Activer l'affichage des erreurs pour le débogage
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    // Log pour le débogage
    error_log("Requête AJAX reçue pour updateFormationHighlights");
    
    if (isset($_SESSION['users_id'])) {
        $highlightedFormations = json_decode($_POST['highlighted_formations'], true);
        $userId = $_SESSION['users_id'];
        
        error_log("ID utilisateur: " . $userId);
        error_log("Formations sélectionnées: " . print_r($highlightedFormations, true));
        
        if (updateFormationHighlights($db, $highlightedFormations, $userId)) {
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

// Vérification si le bouton valider est cliqué
if (isset($_POST['ajouter2'])) {
    $erreurs = '';
    $users_id = $_SESSION['users_id'];


    if (empty($_POST['moisDebut'])) {
        $_SESSION['error_message'] = "Veiller entrer un mois";
    } else {
        $moisDebut = $_POST['moisDebut'];
    }

    if (empty($_POST['anneeDebut'])) {
        $_SESSION['error_message'] = "Veiller entrer une date";
    } else {
        $anneeDebut = $_POST['anneeDebut'];
    }

    // Vérification de la date de fin
    if (isset($_POST['encours'])) {
        $moisFin = '';
        $anneeFin = '';
        $encours = 'En cours';
    } else {
        if (empty($_POST['moisFin'])) {
            $_SESSION['error_message'] = "Veiller entrer un mois";
        } else {
            $moisFin = $_POST['moisFin'];
        }
        if (empty($_POST['anneeFin'])) {
            $_SESSION['error_message'] = "Veiller entrer une date";
        } else {
            $anneeFin = $_POST['anneeFin'];
        }
        $encours = '';
    }

    // Vérification de la filiere
    if (empty($_POST['Filiere'])) {
        $_SESSION['error_message'] = "Veiller ajouter une filière";
    } else {
        $Filiere = $_POST['Filiere']; // Échapper les caractères spéciaux
    }
    // Vérification de l'etablissement
    if (empty($_POST['etablissement'])) {
        $_SESSION['error_message'] = "Veiller entrer un etablissement";
    } else {
        $etablissement = $_POST['etablissement']; // Échapper les caractères spéciaux
    }
    // Vérification du niveau
    if (empty($_POST['niveau'])) {
        $_SESSION['error_message'] = "Veiller entrer un niveau";
    } else {
        $niveau = $_POST['niveau']; // Échapper les caractères spéciaux
    }

    // Si aucune erreur n'est détectée, procédez à l'insertion
    if (empty($_SESSION['error_message'])) {
        if (insertFormation($db, $users_id, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $encours, $Filiere, $etablissement, $niveau)) {
            $_SESSION['success_message'] = " success!";
            // Redirection vers une page de confirmation
            header('Location: user_profil.php');
            exit;
        }
    }
}


if (isset($_POST['Modifier_formation'])) {
    $erreurs = '';
    $users_id = $_SESSION['users_id'];
    $id_formation = $_POST['id_formation'];
    $moisDebut = htmlspecialchars(trim($_POST['moisDebut2']), ENT_QUOTES, 'UTF-8');
    $anneeDebut = htmlspecialchars(trim($_POST['anneeDebut2']), ENT_QUOTES, 'UTF-8');
    $Filiere = htmlspecialchars(trim($_POST['Filiere2']), ENT_QUOTES, 'UTF-8');
    $etablissement = htmlspecialchars(trim($_POST['etablissement2']), ENT_QUOTES, 'UTF-8');
    $niveau = htmlspecialchars(trim($_POST['niveau2']), ENT_QUOTES, 'UTF-8');

    if (isset($_POST['encours2'])) {
        $encours = 'En cours';
        $moisFin = '';
        $anneeFin = '';
    } else {
        $moisFin = htmlspecialchars(trim($_POST['moisFin2']), ENT_QUOTES, 'UTF-8');
        $anneeFin = htmlspecialchars(trim($_POST['anneeFin2']), ENT_QUOTES, 'UTF-8');
        $encours = '';
    }

    if (updateFormation($db, $id_formation, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $Filiere, $etablissement, $niveau, $encours)) {
        $_SESSION['success_message'] = "Operation réussie";
    } else {
        $_SESSION['error_message'] = "Erreur lors de la mise à jour de la formation.";
    }

    header('Location: user_profil.php');
    exit;
}

if (isset($_GET['id'])) {
    $formationUsers = getFormation($db, $_GET['id']);
} else {
    $formationUsers = getFormation($db, $_SESSION['users_id']);
}

// Traitement de la suppression
if (isset($_GET['supprimes'])) {
    $Supprimers = $_GET['supprimes'];

    if (is_numeric($Supprimers)) {
        if (deleteFormation($db, $Supprimers)) {
            $_SESSION['success_message'] = " success!";
            // Redirection
            header('Location: user_profil.php');
            exit();
        }
    }
}
?>