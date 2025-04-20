<?php

// Inclusion du fichier de configuration de la base de données
require_once(__DIR__ . '/../model/competence_users.php');


// Vérification si le bouton valider est cliqué
if (isset($_POST['Ajouter1'])) {
    // Récupération des données du formulaire
    // Déclaration des variables 
    $competence = '';
    $users_id = $_SESSION['users_id'];

    // Vérification du nom
    if (empty($_POST['competence'])) {
        $_SESSION['error_message'] = "Veuillez saisir votre compétence";
    } else {
        $competence = $_POST['competence']; // Échapper les caractères spéciaux
    }

    // Si aucune erreur n'est détectée, procédez à l'insertion
    if (empty($_SESSION['error_message'])) {
        if (insertCompetence($db, $users_id, $competence)) {
            // Redirection vers une page de confirmation
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit;
        }
    }
}

// Traitement de la suppression
if (isset($_GET['supprime'])) {
    $Supprimer = $_GET['supprime'];

    if (is_numeric($Supprimer)) {
        if (deleteCompetence($db, $Supprimer)) {
            $_SESSION['success_message'] = " success!";
            // Redirection
            header('Location: user_profil.php');
            exit();
        }
    }
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