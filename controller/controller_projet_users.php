<?php
require_once(__DIR__ . '/../model/projet_users.php');

// En tant qu'expert PHP, je vais réécrire et configurer correctement ce code pour une meilleure gestion des erreurs, de la sécurité et de la logique métier.

if (isset($_POST['valider'])) {

    // Vérification de la session utilisateur
    if (!isset($_SESSION['users_id'])) {
        $_SESSION['error_message'] = "Utilisateur non authentifié.";
        header("Location: user_profil.php");
        exit();
    }

    $user_id = $_SESSION['users_id'];
    $errors = [];

    // Initialisation et validation des variables
    $titre = isset($_POST['titre']) ? trim($_POST['titre']) : '';
    if (empty($titre)) {
        $errors[] = "Le titre du projet est obligatoire.";
    }

    $liens = isset($_POST['liens']) ? trim($_POST['liens']) : '';
    if (!empty($liens) && $liens !== 'https://' && !filter_var($liens, FILTER_VALIDATE_URL)) {
        $errors[] = "Le lien fourni n'est pas une URL valide.";
    }

    // La description est optionnelle, juste la nettoyer.
    // Utiliser htmlspecialchars pour la sécurité, et nl2br pour conserver les sauts de ligne.
    $projetdescription = isset($_POST['projetdescription']) ? nl2br(htmlspecialchars(trim($_POST['projetdescription']), ENT_QUOTES, 'UTF-8')) : '';
    
    $fileName = '';

    // Gestion de l'upload d'image
    if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $images = $_FILES['images'];
        $fileTmpName = $images['tmp_name'];
        $fileSize = $images['size'];
        
        // Vérification du type de fichier avec finfo pour plus de sécurité
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileType = $finfo->file($fileTmpName);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Format d'image non supporté. Formats acceptés : JPEG, PNG, GIF.";
        } elseif ($fileSize > 5 * 1024 * 1024) { // Limite à 5 Mo
            $errors[] = "L'image est trop volumineuse (max 5 Mo).";
        } else {
            // Générer un nom de fichier unique pour éviter les conflits
            $extension = pathinfo($images['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('projet_', true) . '.' . $extension;
            $targetFile = __DIR__ . '/../upload/' . $fileName;

            if (!move_uploaded_file($fileTmpName, $targetFile)) {
                $errors[] = "Erreur lors de l'upload de l'image.";
                $fileName = ''; // S'assurer que le nom de fichier est vide en cas d'échec
            }
        }
    } elseif (isset($_FILES['images']) && $_FILES['images']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload_errors = array(
            UPLOAD_ERR_INI_SIZE   => "Le fichier est trop volumineux (dépasse 'upload_max_filesize' dans php.ini).",
            UPLOAD_ERR_FORM_SIZE  => "Le fichier est trop volumineux (dépasse la limite du formulaire).",
            UPLOAD_ERR_PARTIAL    => "Le fichier n'a été que partiellement téléchargé. Veuillez réessayer.",
            UPLOAD_ERR_NO_TMP_DIR => "Erreur serveur : dossier temporaire manquant.",
            UPLOAD_ERR_CANT_WRITE => "Erreur serveur : impossible d'écrire le fichier sur le disque.",
            UPLOAD_ERR_EXTENSION  => "Une extension PHP a empêché l'envoi du fichier.",
        );
        $error_code = $_FILES['images']['error'];
        $message = $upload_errors[$error_code] ?? "Erreur inconnue lors de l'envoi du fichier (code: {$error_code}).";
        $errors[] = $message;
    }

    // Si aucune erreur, on enregistre le projet
    if (empty($errors)) {
        if (postProjetUsers($db, $user_id, $titre, $liens, $projetdescription, $fileName)) {
            $_SESSION['success_message'] = "Projet ajouté avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de l'ajout du projet.";
        }
    } else {
        // Stocker la première erreur dans la session pour l'afficher
        $_SESSION['error_message'] = $errors[0];
    }
    
    header("Location: user_profil.php#projets-section");
    exit();
}



if (isset($_GET['id'])) {
    $affichePojetUsers = getProjetUsers($db, $_GET['id']);
} else {
    $affichePojetUsers = getProjetUsers($db, $_SESSION['users_id']);
}


if (isset($_GET['projets'])) {

    $id = $_GET['projets'];

    if (deleteProjets($db, $id)) {
        $_SESSION['success_message'] = 'Opération réussie ';
        header('Location: user_profil.php#projets-section');
        exit;
    }
}
?>