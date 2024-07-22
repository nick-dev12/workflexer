<?php
require_once( __DIR__.'/../model/niveau_etude_experience.php');

if (isset($_POST['Ajouters'])) {
    $etude = $experience = $erreurs= '';

    
    $users_id = $_SESSION['users_id'];

    if (empty($_POST['etude'])) {
        $erreurs = 'Veuillez inserer un niveau d\'études ';
    }else{
        $etude = htmlspecialchars(htmlentities($_POST['etude']));
        $etude_valeurs = array(
            "Bac+1an" => 1,
            "Bac+2ans" => 2,
            "Bac+3ans" => 3,
            "Bac+4ans" => 4,
            "Bac+5ans" => 5,
            "Bac+6ans" => 6,
            "Bac+7ans" => 7,
            "Bac+8ans" => 8,
            "Bac+9ans" => 9,
            "Bac+10ans" => 10,
            "Aucun" => 0
        );
        $n_etude = $etude_valeurs[$etude];
    }

    if (empty($_POST['experience'])) {
        $erreurs = 'veuillez inserer un niveau d\'experience';
    }else{
        $experience = htmlspecialchars(htmlentities($_POST['experience']));
        $experience_valeurs = array(
            "1an" => 1,
            "2ans" => 2,
            "3ans" => 3,
            "4ans" => 4,
            "5ans" => 5,
            "6ans" => 6,
            "7ans" => 7,
            "8ans" => 8,
            "9ans" => 9,
            "10ans" => 10,
            "Aucun" => 0
        );
        $n_experience = $experience_valeurs[$experience];
    }
    if (empty($erreurs)) {
        if (postNiveau($db, $users_id, $etude, $experience , $n_etude, $n_experience)) {
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
        $etude_valeurs = array(
            "Bac+1an" => 1,
            "Bac+2ans" => 2,
            "Bac+3ans" => 3,
            "Bac+4ans" => 4,
            "Bac+5ans" => 5,
            "Bac+6ans" => 6,
            "Bac+7ans" => 7,
            "Bac+8ans" => 8,
            "Bac+9ans" => 9,
            "Bac+10ans" => 10,
            "Aucun" => 0
        );
        $n_etude = $etude_valeurs[$etude];
    }

    if (empty($_POST['experience'])) {
        $erreurs = 'veuillez inserer un niveau d\'experience';
    }else{
        $experience = htmlspecialchars(htmlentities($_POST['experience']));
        $experience_valeurs = array(
            "1an" => 1,
            "2ans" => 2,
            "3ans" => 3,
            "4ans" => 4,
            "5ans" => 5,
            "6ans" => 6,
            "7ans" => 7,
            "8ans" => 8,
            "9ans" => 9,
            "10ans" => 10,
            "Aucun" => 0
        );
        $n_experience = $experience_valeurs[$experience];
    }
    if (empty($erreurs)) {
        if ( updateNiveau($db, $users_id, $etude, $experience , $n_etude, $n_experience)) {
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