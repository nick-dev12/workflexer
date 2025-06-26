<?php

require_once(__DIR__ . '/../model/metier_users.php');

// Action: Ajouter une expérience
if (isset($_POST['Ajouter'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $errors = [];

        $metier = isset($_POST['metier']) ? trim($_POST['metier']) : '';
        if (empty($metier)) { $errors[] = "Le titre du métier est obligatoire."; }

        $moisDebut = $_POST['moisDebut'] ?? '';
        $anneeDebut = $_POST['anneeDebut'] ?? '';
        if (empty($moisDebut) || empty($anneeDebut)) { $errors[] = "La date de début est obligatoire."; }

        $description = isset($_POST['Metierdescription']) ? nl2br(htmlspecialchars(trim($_POST['Metierdescription']), ENT_QUOTES, 'UTF-8')) : '';

        if (isset($_POST['encours'])) {
            $encours = 'En cours';
            $moisFin = '';
            $anneeFin = '';
        } else {
            $encours = '';
            $moisFin = $_POST['moisFin'] ?? '';
            $anneeFin = $_POST['anneeFin'] ?? '';
            if (empty($moisFin) || empty($anneeFin)) { $errors[] = "La date de fin est obligatoire si l'expérience n'est pas 'en cours'."; }
        }

        if (empty($errors)) {
            if (insertMetier($db, $users_id, $metier, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $encours, $description)) {
                $_SESSION['success_message'] = "Expérience ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de l'expérience.";
            }
        } else {
            $_SESSION['error_message'] = $errors[0];
        }
    }
    header('Location: user_profil.php#experience-section');
    exit;
}

// Action: Modifier une expérience
if (isset($_POST['Modifier_metier'])) {
    if (isset($_SESSION['users_id'])) {
        $id = $_POST['id_metier'];
        $metier1 = htmlspecialchars(trim($_POST['metier']), ENT_QUOTES, 'UTF-8');
        $moisDebut1 = htmlspecialchars(trim($_POST['moisDebut1']), ENT_QUOTES, 'UTF-8');
        $anneeDebut1 = filter_input(INPUT_POST, 'anneeDebut1', FILTER_VALIDATE_INT);
        $description1 = nl2br(htmlspecialchars(trim($_POST['Metierdescription1']), ENT_QUOTES, 'UTF-8'));

        if (isset($_POST['encours'])) {
            $encours = 'En cours';
            $moisFin1 = '';
            $anneeFin1 = '';
        } else {
            $encours = '';
            $moisFin1 = htmlspecialchars(trim($_POST['moisFin1']), ENT_QUOTES, 'UTF-8');
            $anneeFin1 = filter_input(INPUT_POST, 'anneeFin1', FILTER_VALIDATE_INT);
        }

        if (updateMetier($db, $id, $metier1, $moisDebut1, $anneeDebut1, $encours, $moisFin1, $anneeFin1, $description1)) {
            $_SESSION['success_message'] = "Expérience modifiée avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour de l'expérience.";
        }
    }
    header('Location: user_profil.php#experience-section');
    exit;
}

// Action: Mettre à jour "mis_en_avant" (AJAX)
if (isset($_POST['update_mis_en_avant'])) {
    header('Content-Type: application/json');
    if (isset($_SESSION['users_id'], $_POST['experience_id'], $_POST['mis_en_avant'])) {
        $id = intval($_POST['experience_id']);
        $mis_en_avant = intval($_POST['mis_en_avant']);
        
        if (updateMisEnAvant($db, $id, $mis_en_avant)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
    }
    exit;
}

// Action: Supprimer une expérience
if (isset($_GET['supprimer'])) {
    if (isset($_SESSION['users_id'])) {
        $id = $_GET['supprimer'];
        if (is_numeric($id)) {
            if (suprimeMetier($db, $id)) {
                $_SESSION['success_message'] = "L'expérience a bien été supprimée.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de l'expérience.";
            }
        }
    }
    header("Location: user_profil.php#experience-section");
    exit();
}

// Affichage des données
if (isset($_SESSION['users_id'])) {
    $users_id = $_SESSION['users_id'];
    $afficheMetier = getMetier($db, $users_id);
} elseif (isset($_GET['id'])) {
    $users_id = $_GET['id'];
    $afficheMetier = getMetier($db, $users_id);
}

?>