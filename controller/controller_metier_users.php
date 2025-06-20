<?php

require_once(__DIR__ . '/../model/metier_users.php');

// Vérification si le bouton valider est cliqué
if (isset($_POST['Ajouter'])) {
    // Récupération des données du formulaire
    $users_id = $_SESSION['users_id'];

    // Déclaration des variables 

    $description =  nl2br( htmlspecialchars($_POST['Metierdescription']));


    // Vérification du nom
    if (empty($_POST['metier'])) {
        $_SESSION['error_message'] = "Veiller saisir votre metier";
    } else {
        $metier = $_POST['metier']; // Échapper les caractères spéciaux
    }


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



    if (isset($_POST['encours'])) {
        $moisFin = '';
        $anneeFin = '';
        $encours = 'En cours';
    } else {
        if (empty($_POST['anneeFin'])) {
            $_SESSION['error_message'] = "Veiller entrer une date";
        } else {
            $anneeFin = $_POST['anneeFin'];
        }
        if (empty($_POST['moisFin'])) {
            $_SESSION['error_message'] = "Veiller entrer un mois";
        } else {
            $moisFin = $_POST['moisFin'];
        }
        $encours = '';
    }




    // Si aucune erreur n'est détectée, procédez à l'insertion
    if (empty($_SESSION['error_message'])) {

        if (insertMetier($db, $users_id, $metier, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $encours, $description)) {
            $_SESSION['success_message'] = "Operation réussie ";
        }
        // Redirection vers une page de confirmation
        header('Location: user_profil.php');
        exit;
    }
}

if (isset($_POST['Modifier_metier'])) {
    // Validate and sanitize input
    $users_id = $_SESSION['users_id'];
    $id = $_POST['id_metier'];
    $metier1 = htmlspecialchars(trim($_POST['metier']), ENT_QUOTES, 'UTF-8');
    $moisDebut1 = htmlspecialchars(trim($_POST['moisDebut1']), ENT_QUOTES, 'UTF-8');
    $anneeDebut1 = filter_input(INPUT_POST, 'anneeDebut1', FILTER_VALIDATE_INT);
    $description1 = nl2br(htmlspecialchars(trim($_POST['Metierdescription1']), ENT_QUOTES, 'UTF-8'));
   

    // Check if 'encours' is set and handle accordingly
    if (isset($_POST['encours'])) {
        $encours = 'En cours';
        $moisFin1 = '';
        $anneeFin1 = '';
    } else {
        $moisFin1 = htmlspecialchars(trim($_POST['moisFin1']), ENT_QUOTES, 'UTF-8');
        $anneeFin1 = filter_input(INPUT_POST, 'anneeFin1', FILTER_VALIDATE_INT);
        $encours = '';
    }

    // Update the metier without requiring all fields
    if (updateMetier($db, $id, $metier1, $moisDebut1, $anneeDebut1, $encours, $moisFin1, $anneeFin1, $description1)) {
        $_SESSION['success_message'] = "Operation réussie";
    } else {
        $_SESSION['error_message'] = "Erreur lors de la mise à jour du métier.";
    }

    // Redirect to the user profile page
    header('Location: user_profil.php');
    exit;
}

// Traitement pour mettre à jour le statut "mis_en_avant"
if (isset($_POST['update_mis_en_avant'])) {
    if (isset($_SESSION['users_id']) && isset($_POST['experience_id']) && isset($_POST['mis_en_avant'])) {
        $id = intval($_POST['experience_id']);
        $mis_en_avant = intval($_POST['mis_en_avant']);
        
        if (updateMisEnAvant($db, $id, $mis_en_avant)) {
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
        exit;
    }
}

if (isset($_SESSION['users_id'])) {
    $users_id = $_SESSION['users_id'];
    $afficheMetier = getMetier($db, $users_id);
} else {
    if (isset($_GET['id'])) {
        $users_id = $_GET['id'];
        $afficheMetier = getMetier($db, $users_id);
    }
}

// Récupération des compétences de l'utilisateur


// Traitement de la suppression
if (isset($_GET['supprimer'])) {

    $id = $_GET['supprimer'];

    if (is_numeric($id)) {

        // Requête DELETE
        if (suprimeMetier($db, $id)) {
            $_SESSION['success_message'] = "Le métier a bien été supprimé.";
        }
        // Redirection
        header("Location: user_profil.php?msg_key=success_message");
        exit();
    }
}
?>