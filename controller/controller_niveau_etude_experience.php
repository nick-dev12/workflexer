<?php
require_once( __DIR__.'/../model/niveau_etude_experience.php');

if (isset($_POST['Ajouters'])) {
    $etude = $experience = $erreurs= '';

    
    $users_id = $_SESSION['users_id'];

    if (empty($_POST['etude'])) {
        $erreurs = 'Veuillez inserer un niveau d\'études ';
    }else{
        $etude = htmlspecialchars(htmlentities($_POST['etude']));
    }

    if (empty($_POST['experience'])) {
        $erreurs = 'veuillez inserer un niveau d\'experience';
    }else{
        $experience = htmlspecialchars(htmlentities($_POST['experience']));
    }
    if (empty($erreurs)) {
        if (postNiveau($db, $users_id, $etude, $experience)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit();
        }
    }
}

if (isset($_POST['Ajouters1'])) {
    $etude = $experience = $erreurs= '';

    
    $users_id = $_SESSION['users_id'];

    if (empty($_POST['etude'])) {
        $erreurs = 'Veuillez inserer un niveau d\'études ';
    }else{
        $etude = htmlspecialchars(htmlentities($_POST['etude']));
    }

    if (empty($_POST['experience'])) {
        $erreurs = 'veuillez inserer un niveau d\'experience';
    }else{
        $experience = htmlspecialchars(htmlentities($_POST['experience']));
    }
    if (empty($erreurs)) {
        if ( updateNiveau($db, $users_id, $etude, $experience)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit();
        }
    }
}
if(isset($_GET['id'])){
    $getNiveauEtude =  gettNiveau($db,$_GET['id']);
}else{
    if(isset($_SESSION['users_id'])){
        $getNiveauEtude =  gettNiveau($db, $_SESSION['users_id']);
    }
}


?>