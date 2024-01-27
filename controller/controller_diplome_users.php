<?php 
require_once('../model/diplome_users.php');

if (isset($_POST['ajouteer1'])) {

    $diplome='';

    $user_id = $_SESSION['user_id'];

    if (empty($_POST['diplome'])) {
        $_SESSION['error_message'] = " veuillez ajouter un diplôme";
    }else{
        $diplome = $_POST['diplome'];
    }


    if (empty( $_SESSION['error_message'])) {
        
        if (postDiplome($db,$users_id,$diplome)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit;
        }


    }
}



if (isset($_GET['id'])) {
    $afficheDiplome = getDiplomes($db,$_GET['id'] );
    }else{
        $afficheDiplome = getDiplomes($db, $_SESSION['users_id']);
    }


    if (isset($_GET['diplomes'])) {

        $id = $_GET['diplomes'];
    
        if ( deleteDiplome ( $db, $id)) {
            $_SESSION['success_message'] = 'Opération réussie ';
            header('Location: user_profil.php');
            exit;
        }
    }

?>