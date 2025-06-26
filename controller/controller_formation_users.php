<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusion du fichier de configuration de la base de données
require_once(__DIR__ . '/../model/formation_users.php');

// Action: Mettre à jour "mis_en_avant" (AJAX)
if (isset($_POST['action']) && $_POST['action'] === 'updateFormationHighlights') {
    header('Content-Type: application/json');
    if (isset($_SESSION['users_id'])) {
        $highlightedFormations = json_decode($_POST['highlighted_formations'], true);
        $userId = $_SESSION['users_id'];
        
        if (updateFormationHighlights($db, $highlightedFormations, $userId)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    }
    exit;
}

// Action: Ajouter une formation
if (isset($_POST['ajouter2'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $errors = [];

        $moisDebut = $_POST['moisDebut'] ?? '';
        $anneeDebut = $_POST['anneeDebut'] ?? '';
        if (empty($moisDebut) || empty($anneeDebut)) { $errors[] = "La date de début est obligatoire."; }

        $Filiere = isset($_POST['Filiere']) ? trim($_POST['Filiere']) : '';
        if(empty($Filiere)) { $errors[] = "La filière est obligatoire."; }
        
        $etablissement = isset($_POST['etablissement']) ? trim($_POST['etablissement']) : '';
        if(empty($etablissement)) { $errors[] = "L'établissement est obligatoire."; }

        $niveau = $_POST['niveau'] ?? '';
        if(empty($niveau)) { $errors[] = "Le niveau est obligatoire."; }
        
        if (isset($_POST['encours'])) {
            $encours = 'En cours';
            $moisFin = '';
            $anneeFin = '';
        } else {
            $encours = '';
            $moisFin = $_POST['moisFin'] ?? '';
            $anneeFin = $_POST['anneeFin'] ?? '';
            if (empty($moisFin) || empty($anneeFin)) { $errors[] = "La date de fin est obligatoire si la formation n'est pas 'en cours'."; }
        }

        if (empty($errors)) {
            if (insertFormation($db, $users_id, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $encours, $Filiere, $etablissement, $niveau)) {
                $_SESSION['success_message'] = "Formation ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la formation.";
            }
        } else {
            $_SESSION['error_message'] = $errors[0];
        }
    }
    header('Location: user_profil.php#formation-section');
    exit;
}

// Action: Modifier une formation
if (isset($_POST['Modifier_formation'])) {
    if (isset($_SESSION['users_id'])) {
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
            $_SESSION['success_message'] = "Formation modifiée avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour de la formation.";
        }
    }
    header('Location: user_profil.php#formation-section');
    exit;
}

// Action: Supprimer une formation
if (isset($_GET['supprimes'])) {
    if (isset($_SESSION['users_id'])) {
        $id_formation = $_GET['supprimes'];
        if (is_numeric($id_formation)) {
            if (deleteFormation($db, $id_formation)) {
                $_SESSION['success_message'] = "Formation supprimée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de la formation.";
            }
        }
    }
    header('Location: user_profil.php#formation-section');
    exit();
}

// Affichage des données
if (isset($_GET['id'])) {
    $formationUsers = getFormation($db, $_GET['id']);
} else {
    $formationUsers = getFormation($db, $_SESSION['users_id']);
}
?>