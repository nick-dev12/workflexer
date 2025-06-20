<?php
require_once(__DIR__ . '/../model/users.php');

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id'])) {
    // L'utilisateur est déjà connecté, pas besoin de vérifier le cookie
} 
if (isset($_COOKIE['remember_me'])) {
    // Le cookie remember_me est présent, essayons de reconnecter l'utilisateur
    $token = $_COOKIE['remember_me'];

    // Vérifier le jeton dans la base de données avec une requête plus sécurisée
    $sqlCheckToken = "SELECT id, remember_token FROM users WHERE remember_token = :token AND remember_token IS NOT NULL";
    $stmtCheckToken = $db->prepare($sqlCheckToken);
    $stmtCheckToken->bindParam(':token', $token);
    $stmtCheckToken->execute();
    $userData = $stmtCheckToken->fetch(PDO::FETCH_ASSOC);

    if ($userData && $userData['remember_token'] === $token) {
        // Jeton valide, connecter l'utilisateur
        $_SESSION['users_id'] = $userData['id'];
        
        // Renouveler le cookie pour prolonger la session
        setcookie('remember_me', $token, time() + 60 * 60 * 24 * 365 * 10, '/', '', false, true);
    }
}

if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {
    if ($totalUsers = getTotalUsers($db)) {

    }

}

$afficheUsersLimit20 = getUserslimit20($db);
shuffle($afficheUsersLimit20);


if (isset($_SESSION['users_id'])) {
    $users = infoUsers($db, $_SESSION['users_id']);
    $getVueProfil = GetVueProfil($db, $_SESSION['users_id']);
    $userss = infoUsers($db, $_SESSION['users_id']);
}
if (isset($_GET['id'])) {
    $userss = infoUsers($db, $_GET['id']);
}


// if (isset($totalUsers)){
//     $categorieUsers = $totalUsers['categorie'];
// }


// Affiche les utilisateurs qui sont dans la catégorie Informatique
$getUssersCategorie = getUsers($db);
shuffle($getUssersCategorie);



if (isset($_GET['disponible'])) {
    $statut = 'Disponible';
    $id = $_SESSION['users_id'];
    if (Disponible($db, $statut, $id)) {
        header("Location: user_profil.php");
        exit();
    }
}

if (isset($_GET['occuper'])) {
    $statut = 'Occuper';
    $id = $_SESSION['users_id'];
    if (Occuper($db, $statut, $id)) {
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
        $_SESSION['success_message'] = 'Modifié avec succès';
        header('Location: modifier.php');
        exit();
    }
}



if (isset($_POST['valide3'])) {
    $users_id = $_SESSION['users_id'];
    $mail = '';
    $pass = '';
    if (empty($_POST['mail'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
    } else {
        $mail = $_POST['mail'];
    }
    if (empty($_POST['pass'])) {
        $_SESSION['error_message'] = 'Mot de passe actuel obligatoire';
    } else {
        $pass = $_POST['pass'];
    }
    // Vérifier le mot de passe actuel
    $sql = "SELECT passe FROM users WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && password_verify($pass, $result['passe'])) {
        if (update33($db, $mail, $users_id)) {

        }
        $_SESSION['success_message'] = 'Modifié avec succès';
        header('Location: modifier.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'Mot de passe actuel incorrect';
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
        $_SESSION['success_message'] = 'Modifié avec succès';
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
        $_SESSION['success_message'] = 'Modifié avec succès';
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
        $_SESSION['success_message'] = 'Modifié avec succès';
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
        $_SESSION['success_message'] = 'Modifié avec succès';
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
        $_SESSION['success_message'] = 'Modifié avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valide9'])) {
    $users_id = $_SESSION['users_id'];
    $pass = '';
    $pass1 = '';
    if (empty($_POST['pass'])) {
        $_SESSION['error_message'] = 'Mot de passe actuel obligatoire';
    } else {
        $pass = $_POST['pass'];
    }
    if (empty($_POST['pass1'])) {
        $_SESSION['error_message'] = 'Nouveau mot de passe obligatoire';
    } else {
        $pass1 = $_POST['pass1'];
    }

    if (empty($_SESSION['error_message'])) {
        // Vérifier le mot de passe actuel
        $sql = "SELECT passe FROM users WHERE id = :users_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($pass, $result['passe'])) {
            // Hacher le nouveau mot de passe
            $hashedPass1 = password_hash($pass1, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            if (update99($db, $hashedPass1, $users_id)) {
            }

            $_SESSION['success_message'] = 'Mot de passe modifié avec succès';
            header('Location: modifier.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Mot de passe actuel incorrect';
            header('Location: modifier.php');
            exit();
        }
    }
}

if (isset($_POST['valide0'])) {

    $users_id = $_SESSION['users_id'];

    $images = '';

    // Vérification de la ville
    if (empty($_FILES['images'])) {
        $_SESSION['error_message'] = 'erreur choisissez une autre image .';
    } else {
        // Récupérer les données du formulaire
        $images = $_FILES['images'];
        // Vérifier qu'un fichier est uploadé
        if (empty($_SESSION['error_message'])) {

            // Récupérer le nom et le chemin temporaire
            $fileName = $images['name'];
            $tmpName = $images['tmp_name'];

            // Ajouter l'identifiant unique au nom du fichier
            $uniqueFileName = $id . '_' . $fileName;

            // Déplacer le fichier dans le répertoire audio
            $targetFile = '../upload/' . $uniqueFileName;
            move_uploaded_file($tmpName, $targetFile);


            if (update00($db, $uniqueFileName, $users_id)) {
            }

            $_SESSION['success_message'] = 'Modifiée avec succès';
            header('Location: modifier.php');
            exit();
        }



    }
}


if (isset($_POST['send'])) {
    if (isset($_SESSION['users_id'])) {
        $utilisateur = $_SESSION['users_id'];
        $compte = 'compte professionnel';
        $mail = $users['mail'];
        $nom = $users['nom'];
    } else {
        if (isset($_SESSION['compte_entreprise'])) {
            $utilisateur = $_SESSION['compte_entreprise'];
            $compte = 'compte entreprise';
            $mail = $getEntreprise['mail'];
            $nom = $getEntreprise['nom'];
        }
    }
    if (empty($_POST['message'])) {
        $_SESSION['error_message'] = 'Ce champ de doit pas etre vide';
    } else {
        $message = htmlspecialchars($_POST['message']);
    }

    if (empty($_SESSION['error_message'])) {
        $sql = "INSERT INTO admin_message (utilisateur_id, compte,message,mail,nom) VALUES (:utilisateur_id, :compte,:message,:mail,:nom)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":utilisateur_id", $utilisateur);
        $stmt->bindValue(":compte", $compte);
        $stmt->bindValue(":message", $message);
        $stmt->bindValue(":mail", $mail);
        $stmt->bindValue(":nom", $nom);
        $stmt->execute();

        $_SESSION['success_message'] = 'Message envoyer';
        header('Location: user_profil.php');
        exit;

    }


}

