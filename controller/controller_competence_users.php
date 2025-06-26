<?php

// Inclusion du fichier de configuration de la base de données
require_once(__DIR__ . '/../model/competence_users.php');


// Action: Ajouter une compétence
if (isset($_POST['Ajouter1'])) {
    if (isset($_SESSION['users_id'])) {
        $users_id = $_SESSION['users_id'];
        $competence = isset($_POST['competence']) ? trim($_POST['competence']) : '';

        if (empty($competence)) {
            $_SESSION['error_message'] = "Veuillez saisir une compétence.";
        } else {
            if (insertCompetence($db, $users_id, htmlspecialchars($competence, ENT_QUOTES, 'UTF-8'))) {
                $_SESSION['success_message'] = "Compétence ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la compétence.";
            }
        }
    }
    header('Location: user_profil.php#competences-section');
    exit;
}

// Action: Supprimer une compétence
if (isset($_GET['supprime'])) {
    if (isset($_SESSION['users_id'])) {
        $id_competence = $_GET['supprime'];
        if (is_numeric($id_competence)) {
            if (deleteCompetence($db, $id_competence)) {
                $_SESSION['success_message'] = "Compétence supprimée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de la compétence.";
            }
        }
    }
    header('Location: user_profil.php#competences-section');
    exit();
}

// Action: Mettre à jour "mis_en_avant" (AJAX)
if (isset($_POST['update_competence_mis_en_avant'])) {
    header('Content-Type: application/json');
    if (isset($_SESSION['users_id'], $_POST['competence_id'], $_POST['mis_en_avant'])) {
        $id = intval($_POST['competence_id']);
        $mis_en_avant = intval($_POST['mis_en_avant']);
        
        if (updateCompetenceMisEnAvant($db, $id, $mis_en_avant)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètres manquants.']);
    }
    exit;
}

// Récupération des compétences de l'utilisateur

if (isset($_GET['id'])) {
    $competencesUtilisateur = getCompetences($db, $_GET['id']);
    shuffle($competencesUtilisateur);

    // Récupération des 7 premières compétences de l'utilisateur
    $competencesUtilisateurLimit7 = selectCompetenceLimit7($db, $_GET['id']);
    shuffle($competencesUtilisateurLimit7);

} else {
    if (isset($_SESSION['users_id'])) {
        $competencesUtilisateur = getCompetences($db, $_SESSION['users_id']);
        shuffle($competencesUtilisateur);
        $competencesUtilisateurLimit7 = selectCompetenceLimit7($db, $_SESSION['users_id']);
        shuffle($competencesUtilisateurLimit7);
    }
}

?>