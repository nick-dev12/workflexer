<?php
require_once(__DIR__ . '/../model/document_users.php');


if (isset($_POST['téléverser'])) {
    $users_id = $_SESSION['users_id'];
    $document = '';
    if (empty($_FILES['document']['name'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter un document';
    } else {
        // Récupérer les données du formulaire
        $document = $_FILES['document'];
        $fileName = $document['name'];
        $tmpName = $document['tmp_name'];

        // Obtenir l'extension du fichier
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Définir les extensions autorisées pour les documents
        $allowedExtensions = array('pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ods', 'odp', 'rtf', 'csv');

        // Vérifier si l'extension est autorisée
        if (in_array($fileExtension, $allowedExtensions)) {
            // Générer un nom de fichier unique pour éviter les doublons
            $uniqueFileName = uniqid() . '_' . $fileName;

            // Déplacer le fichier dans le répertoire des documents
            $targetFile = '../document/' . $uniqueFileName;
            move_uploaded_file($tmpName, $targetFile);

            // Ajouter le document à la base de données (vous devez implémenter votre propre fonction PostDocumentUsers)
            if (PostDocumentUsers($db, $users_id, $uniqueFileName)) {
                $_SESSION['success_message'] = 'Document ajouté';
                header('Location: user_profil.php');
                exit;
            }
        } else {
            $_SESSION['error_message'] = 'Seuls les documents de type PDF, Word, Excel, PowerPoint, OpenOffice, texte et CSV sont autorisés';
        }
    }
}


if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];

    // Récupérer le nom du fichier associé au document
    $document = GetDocumentById($db, $document_id);
    $fileName = $document['document'];

    // Supprimer le fichier du répertoire des documents
    $filePath = '../document/' . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Supprimer le document de la base de données
    if (DeleteDocument($db, $document_id)) {
        $_SESSION['success_message'] = 'Document supprimé';
        header('Location: user_profil.php');
        exit;
    }
}
$GetDocumentUsers = GetDocumentUsers($db, $_SESSION['users_id']);
$rowCount = count($GetDocumentUsers);


?>