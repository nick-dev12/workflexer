<?php 
require_once('../model/document_users.php');


if (isset($_POST['téléverser'])) {
    $users_id = $_SESSION['users_id'];
    $document ='';
    if (empty($_FILES['document'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter un document';
    } else {
        // Récupérer les données du formulaire
        $document = $_FILES['document'];
        $fileName = $document['name'];
        $tmpName = $document['tmp_name'];
    
        // Obtenir le type MIME du document
        $documentFileType = mime_content_type($tmpName);
    
        // Définir les types MIME autorisés pour les documents
        $allowedDocumentTypes = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    
        // Vérifier si le type MIME est autorisé
        if (in_array($documentFileType, $allowedDocumentTypes)) {
            // Déplacer le fichier dans le répertoire des documents
            $targetFile = '../document/' . $fileName;
            move_uploaded_file($tmpName, $targetFile);
    
            // Ajouter le document à la base de données (vous devez implémenter votre propre fonction PostDocumentUsers)
            if (PostDocumentUsers($db, $users_id, $fileName)) {
                $_SESSION['success_message'] = 'Document Ajouter';
                header('Location: user_profil.php');
                exit;
                
            }
        } else {
            $_SESSION['error_message'] = 'Seuls les documents PDF et Word sont autorisés';
        }

        
       
    }

   
}


if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];
    if (DeleteDocument ($db, $document_id)) {
        $_SESSION['success_message'] = 'Document supprimé';
        header('Location: user_profil.php');
        exit;
    }
}
$GetDocumentUsers = GetDocumentUsers( $db, $_SESSION['users_id']);
$rowCount = count($GetDocumentUsers);


?>