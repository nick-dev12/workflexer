<?php
// Inclusion du fichier de configuration de la base de données
require_once(__DIR__ . '/../model/formation_users.php');


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
        $moisFin = null;
        $anneeFin = null;
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
    $moisDebut = htmlspecialchars($_POST['moisDebut2']);
    $anneeDebut = htmlspecialchars($_POST['anneeDebut2']);
    $Filiere = htmlspecialchars($_POST['Filiere2']);
    $etablissement = htmlspecialchars($_POST['etablissement2']);
    $niveau = htmlspecialchars($_POST['niveau2']);
    $encours = ($_POST['encours2']) ? 'En cours' : null;

    if ($encours) {
        $moisFin = null;
        $anneeFin = null;
    } else {
        $moisFin = htmlspecialchars($_POST['moisFin2']);
        $anneeFin = htmlspecialchars($_POST['anneeFin2']);
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