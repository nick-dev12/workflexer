<?php
require_once(__DIR__ . '/../model/outil_users.php');


if (isset($_POST['ajouts'])) {

    $outil = '';
    $niveau = '';

    $users_id = $_SESSION['users_id'];

    if (empty($_POST['outil'])) {
        $_SESSION['error_message'] = " champs vide ";
    } else {
        $outil = $_POST['outil'];
    }

    if (empty($_POST['niveau'])) {
        $erreurs = 'veuiller entrer un niveau.';
        $_SESSION['error_message'] = " choisissez un niveau";
    } else {
        $niveau = $_POST['niveau'];
    }

    if (empty($_SESSION['error_message'])) {
        if (postOutil($db, $users_id, $outil, $niveau)) {
            $_SESSION['success_message'] = " success!";
            header('Location: user_profil.php');
            exit;
        }
    }
}



if (isset($_GET['id'])) {
    $afficheOutil = getOutil($db, $_GET['id']);
    $afficheOutilLimit5 = selectOutilLimit5($db, $_GET['id']);
} else {
    if (isset($_SESSION['users_id'])) {
        $afficheOutil = getOutil($db, $_SESSION['users_id']);
        $afficheOutilLimit5 = selectOutilLimit5($db, $_SESSION['users_id']);
    }

}


if (isset($_GET['suprimerOutils'])) {

    $id = $_GET['suprimerOutils'];

    if (deleteOutils($db, $id)) {
        $_SESSION['success_message'] = 'Opération réussie ';
        header('Location: user_profil.php');
        exit;
    }
}
?>