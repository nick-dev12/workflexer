<?php

require_once('../model/metier_users.php');

// Vérification si le bouton valider est cliqué
if (isset($_POST['Ajouter'])) {
    // Récupération des données du formulaire
    $users_id = $_SESSION['users_id'];
   
    // Déclaration des variables 

    $description = $_POST['Metierdescription'];


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


    // Si aucune erreur n'est détectée, procédez à l'insertion
    if (empty($_SESSION['error_message'])) {

        if (insertMetier($db, $users_id, $metier, $moisDebut, $anneeDebut, $moisFin, $anneeFin, $description)) {
            $_SESSION['success_message'] = "Operation réussie ";
        }
        // Redirection vers une page de confirmation
        header('Location: user_profil.php');
        exit;
    }
}

if(isset($_SESSION['users_id'])){
    $users_id=$_SESSION['users_id'];
    $afficheMetier = getMetier($db, $users_id);
}else{
    if(isset($_GET['id'])){
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