<?php
require_once(__DIR__.'/../model/centre_interet.php');


if (isset($_POST['ajouter_interet'])) {

$erreurs = '' ;
    $users_id = $_SESSION['users_id'];

    if (empty($_POST['interet'])) {
       
         $_SESSION['error_message'] = "Ce champ ne doit pas être vide ! ";
    }else{
        $interet = $_POST['interet'];
    }

    if (empty($_SESSION['error_message'])) {
        if (posteCentreInteret($db,$users_id,$interet)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit();
        }
    }

}


if (isset($_GET['id'])){
    $afficheCentreInteret = getAllCentreInteretUsers ($db,$_GET['id']);
}else{
 if (isset($_SESSION['users_id'])){
    $afficheCentreInteret = getAllCentreInteretUsers ($db,$_SESSION['users_id']);

    if (isset($_GET['centreinteret'])) {

        $id = $_GET['centreinteret'];
    
        if (deleteInteret($db, $id)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit;
        }
    }
}   
}
 

?>