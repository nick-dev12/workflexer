<?php
require_once(__DIR__.'/../model/langue_users.php');


if (isset($_POST['ajoutss'])) {
    $langue = '';
    $niveau = '';
    $user_id = $_SESSION['users_id'];

    if (empty($_POST['langue'])) {
        $_SESSION['error_message'] = "Ajouter une langue ";
    } else {
        $langue = $_POST['langue'];
    }
    if (empty($_POST['niveau'])) {
        $_SESSION['error_message'] = "choisissez un niveau ";
    } else {
        $niveau = $_POST['niveau'];
    }


    if (empty( $_SESSION['error_message'])) {
        if (postLangue($db, $users_id, $langue, $niveau)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit;
        }
    }
}


if (isset($_GET['id'])) {
    $afficheLangues = getLangue($db, $_GET['id']);
}
if (isset($_SESSION['users_id'])) {
    $afficheLangue = getLangue($db, $_SESSION['users_id']);
} 
   


if (isset($_GET['suprimer'])) {

    $id = $_GET['suprimer'];

    if (deleteLangue($db, $id)) {
        $_SESSION['success_message'] = 'Opération réussie ';
        header('Location: user_profil.php');
        exit;
    }
}

?>