<?Php
include('../conn/conn.php');

function PostDocumentUsers($db, $users_id, $document)
{
    $sql = "INSERT INTO document_users (users_id,document) VALUES (:users_id,:document)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':document', $document);
    return $stmt->execute();
}


function GetDocumentUsers($db, $users_id)
{
    $sql = "SELECT * FROM  document_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function DeleteDocument($db, $document_id)
{
    $sql = "DELETE FROM  document_users WHERE document_id = :document_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':document_id', $document_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function GetDocumentById($db, $document_id)
{
    $sql = "SELECT * FROM document_users WHERE document_id = :document_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':document_id', $document_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>