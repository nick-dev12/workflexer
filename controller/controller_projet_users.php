<?php
require_once('../model/projet_users.php');


if(isset($_POST['valider'])){


    $user_id = $_SESSION['users_id'];

    $titre = $liens = $projetdescription = $images ='';

    if(empty($_POST['titre'])) {
        $_SESSION['error_message'] = " titre vide";
    }else{
        $titre = $_POST['titre'];
    }

    $liens = $_POST['liens'];

    $projetdescription = nl2br($_POST['projetdescription']) ;

    $images = $_FILES['images'];

    if ($images ['error']==0) {
        
        $fileName = $images['name'];
        $tmpName = $images['tmp_name'];

        $targetFile = '../upload/'. $fileName;
        move_uploaded_file($tmpName, $targetFile);
    }

    if (empty( $_SESSION['error_message'])) {
        if (postProjetUsers($db,$users_id,$titre,$liens,$projetdescription,$fileName)) {
            $_SESSION['success_message'] = "projet ajouter avec succès";

            header("Location: user_profil.php");
            exit();
        }
    }

}



if (isset($_GET['id'])) {
    $affichePojetUsers = getProjetUsers($db, $_GET['id']);
     }else{
        $affichePojetUsers = getProjetUsers($db, $_SESSION['users_id']);
     }


     if (isset($_GET['projets'])) {

        $id = $_GET['projets'];
    
        if (deleteProjets($db, $id)) {
            $_SESSION['success_message'] = 'Opération réussie ';
            header('Location: user_profil.php');
            exit;
        }
    }
?>