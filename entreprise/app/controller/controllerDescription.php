<?php
require_once('..//entreprise/app/model/description_entreprise.php');

if (isset($_POST['ajouter'])) {

    $entreprise_id = $_SESSION['compte_entreprise'];

    $liens = $_POST['liens'];

    if (isset($_POST['descriptions'])) {
        $descriptions = $_POST['descriptions'];
    } else {
        $_SESSION['error_message'] = 'veuiller ajouter UNE DESCRIPTION  !!!';
    }

    if (empty($_SESSION['error_message'])) {
        if (postDescription($db, $entreprise_id, $descriptions, $liens)) {
            $_SESSION['success_message'] = ' Description ajouter avec succes !!';
            header('Location: entreprise_profil.php');
        }
    }
}

if (isset($_SESSION['compte_entreprise'])) {
    $afficheDescriptionentreprise=getDescriptionEntreprise ($db,$_SESSION['compte_entreprise']);
}



if (isset($_POST['modifiers'])) {

    $descriptions=$liens='';

    if (empty($_POST['descriptions'])) {
        $_SESSION['error_message'] = 'Le champ DESCRIPTION ne dois pas etre vide !!!';
    }else{
        $descriptions=$_POST['descriptions'];
    }
   
        $liens=$_POST['liens'];

        if (empty( $_SESSION['error_message'])) {
            if (updatDescristion($db,$descriptions,$liens)) {
                $_SESSION['success_message'] = ' Description modifier avec succes !!';
                header('Location: entreprise_profil.php');
            }
        }

}
?>