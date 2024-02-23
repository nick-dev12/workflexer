<?php
require_once(__DIR__ .'/../model/users.php');

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id'])) {
    // L'utilisateur est déjà connecté, pas besoin de vérifier le cookie
} elseif (isset($_COOKIE['remember_me'])) {
    // Le cookie remember_me est présent, essayons de reconnecter l'utilisateur

    $token = $_COOKIE['remember_me'];

    // Vérifier le jeton dans la base de données
    $sqlCheckToken = "SELECT id FROM users WHERE remember_token = :token";
    $stmtCheckToken = $db->prepare($sqlCheckToken);
    $stmtCheckToken->bindParam(':token', $token);
    $stmtCheckToken->execute();
    $userId = $stmtCheckToken->fetchColumn();

    if ($userId) {
        // Jeton valide, connecter l'utilisateur
        $_SESSION['users_id'] = $userId;
    }
}

if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {
   if ($totalUsers = getTotalUsers($db)) {

} 

}
$totalUsers = getTotalUsers($db);




if (isset($_SESSION['users_id'])) {
    $users = infoUsers($db,$_SESSION['users_id'] );
    $getVueProfil = GetVueProfil($db,$_SESSION['users_id']);
    $userss = infoUsers($db,$_SESSION['users_id'] );
}

if (isset($_GET['id'])) {
    $userss = infoUsers($db,$_GET['id'] ); 

    if (isset($_SESSION['users_id'])) {
        // Préparer la requête SQL pour vérifier si l'e-mail est déjà utilisé
        $query = $db->prepare("SELECT * FROM vue_profil WHERE id_users = :id_users AND profil_id=:profil_id");
        $query->bindParam(':id_users', $_SESSION['users_id']);
        $query->bindParam(':profil_id', $_GET['id']);
        $query->execute();
        if ($query->rowCount()>0) {
            
        }else{
            if (PostVueProfil($db,$_SESSION['users_id'],$_GET['id'])) {
              
            }
        }
    }

    if (isset($_SESSION['compte_entreprise'])) {
       

    // Préparer la requête SQL pour vérifier si l'e-mail est déjà utilisé
    $query = $db->prepare("SELECT * FROM vue_profil WHERE id_users = :id_users AND profil_id=:profil_id");
    $query->bindParam(':id_users', $_SESSION['compte_entreprise']);
    $query->bindParam(':profil_id', $_GET['id']);
    $query->execute();
    if ($query->rowCount()>0) {
        
    }else{
        if (PostVueProfil($db,$_SESSION['compte_entreprise'],$_GET['id'])) {
           
        }

        if( PostHistorique($db,$_SESSION['compte_entreprise'],$_GET['id'])){

        }
    }
    }
   
}

// if (isset($totalUsers)){
//     $categorieUsers = $totalUsers['categorie'];
// }


// affiches les utilisateur qui sont dans la categorie ingenieur 
$Usersingegneur = getUsersIngenieur($db);
shuffle($Usersingegneur);
// affiches les utilisateur qui sont dans la categorie Design
$UsersDesign = getUsersDesign($db);
shuffle($UsersDesign);
// affiches les utilisateur qui sont dans la categorie Rédaction
$UsersRédaction = getUsersRédaction($db);
shuffle($UsersRédaction);
// affiches les utilisateur qui sont dans la categorie marketing
$Usersmarketing = getUsersmarketing($db); 
shuffle($Usersmarketing);
// affiches les utilisateur qui sont dans la categorie business
$Usersbusiness = getUsersbusiness($db);
shuffle($Usersbusiness);
// affiches les utilisateur qui sont dans la categorie Juridique
$UsersJuridique = getUsersJuridique($db);
shuffle($UsersJuridique);
// Affiche les utilisateurs qui sont dans la catégorie Informatique
$UsersInformatique = getUsersInformatique($db);
shuffle($UsersInformatique);

$getUssersCategorie = getUsers($db);



if(isset($_GET['disponible'])){
    $statut = 'Disponible';
    $id = $_SESSION['users_id'];
    if(Disponible($db,$statut,$id)){
        header("Location: user_profil.php");
        exit();
    }
}

if(isset($_GET['occuper'])){
    $statut = 'Occuper';
    $id = $_SESSION['users_id'];
    if(Occuper($db,$statut,$id)){
        header("Location: user_profil.php");
        exit();
    }
}





if (isset($_POST['valide1'])) {
    $users_id = $_SESSION['users_id'];
    $nom = '';
    if (empty($_POST['nom'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $nom = $_POST['nom'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update11($db, $nom, $users_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}



if (isset($_POST['valide3'])) {
    $users_id = $_SESSION['users_id'];
    $mail = '';
    if (empty($_POST['mail'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $mail = $_POST['mail'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update33($db, $mail, $users_id)) {
            
        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valide4'])) {
    $users_id = $_SESSION['users_id'];
    $phone = '';
    if (empty($_POST['phone'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $phone = $_POST['phone'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update44($db, $phone, $users_id)) {
            
        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valide5'])) {
    $users_id = $_SESSION['users_id'];
    $competence = '';
    if (empty($_POST['competence'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $competence = $_POST['competence'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update55($db, $competence, $users_id)) {
            
        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valide6'])) {
    $users_id = $_SESSION['users_id'];
    $ville = '';
    if (empty($_POST['ville'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $ville = $_POST['ville'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update66($db, $ville, $users_id)) {
            
        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valide7'])) {
    $users_id = $_SESSION['users_id'];
    $profession = '';
    if (empty($_POST['profession'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $profession = $_POST['profession'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update77($db, $profession, $users_id)) {
            
        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valide8'])) {
    $users_id = $_SESSION['users_id'];
    $categorie = '';
    if (empty($_POST['categorie'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $categorie = $_POST['categorie'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update88($db, $categorie, $users_id)) {
            
        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if(isset($_POST['valide0'])){

    $users_id = $_SESSION['users_id'];

    $images = '';

    // Vérification de la ville
 if (empty($_FILES['images'])) {
    $_SESSION['error_message'] = 'erreur choisissez une autre image .';
} else {
    // Récupérer les données du formulaire
    $images = $_FILES['images'];
    // Vérifier qu'un fichier est uploadé
    if (empty( $_SESSION['error_message'])) {

        // Récupérer le nom et le chemin temporaire
        $fileName = $images['name'];
        $tmpName = $images['tmp_name'];

        // Ajouter l'identifiant unique au nom du fichier
        $uniqueFileName = $id . '_' . $fileName;

        // Déplacer le fichier dans le répertoire audio
        $targetFile = '../upload/' . $uniqueFileName;
        move_uploaded_file($tmpName, $targetFile);


        if (update00 ($db,$uniqueFileName, $users_id)) {
        }
    
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }


   
}
}
?>


