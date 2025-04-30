<?php

include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Vérifier si l'ID de l'offre est spécifié
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID de l'offre non spécifié ou invalide.";
    header('Location: offres.php');
    exit;
}

$offre_id = $_GET['id'];

// Récupérer les détails de l'offre avant suppression
$sql = "SELECT oe.*, ce.entreprise 
        FROM offre_emploi oe
        JOIN compte_entreprise ce ON oe.entreprise_id = ce.id
        WHERE oe.offre_id = :offre_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
$stmt->execute();
$offre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$offre) {
    $_SESSION['error_message'] = "L'offre d'emploi demandée n'existe pas.";
    header('Location: offres.php');
    exit;
}

// Récupérer la catégorie de l'offre pour rediriger l'utilisateur
$categorie = $offre['categorie'];

try {
    // Démarrer une transaction pour s'assurer que tout se passe bien
    $db->beginTransaction();

    // Copier l'offre dans la table offre_suprimer pour l'historique
    $sql_copy = "INSERT INTO offre_suprimer (entreprise_id, poste, mission, profil, contrat, etudes, experience, 
                n_etudes, n_experience, localite, langues, places, date_expiration, statut, categorie, date)
                SELECT entreprise_id, poste, mission, profil, contrat, etudes, experience, 
                n_etudes, n_experience, localite, langues, places, date_expiration, 'supprimée', categorie, NOW()
                FROM offre_emploi WHERE offre_id = :offre_id";
    $stmt_copy = $db->prepare($sql_copy);
    $stmt_copy->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt_copy->execute();

    // Supprimer les candidatures liées à cette offre
    $sql_delete_candidatures = "DELETE FROM postulation WHERE offre_id = :offre_id";
    $stmt_delete_candidatures = $db->prepare($sql_delete_candidatures);
    $stmt_delete_candidatures->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt_delete_candidatures->execute();

    // Supprimer les vues liées à cette offre
    $sql_delete_vues = "DELETE FROM vue_offre WHERE offre_id = :offre_id";
    $stmt_delete_vues = $db->prepare($sql_delete_vues);
    $stmt_delete_vues->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt_delete_vues->execute();

    // Supprimer l'offre
    $sql_delete = "DELETE FROM offre_emploi WHERE offre_id = :offre_id";
    $stmt_delete = $db->prepare($sql_delete);
    $stmt_delete->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Enregistrer l'action dans l'historique d'administration
    $admin_id = $_SESSION['admin'];
    $action = "Suppression de l'offre ID: " . $offre_id . " - Poste: " . $offre['poste'] . " - Entreprise: " . $offre['entreprise'];
    $sql_log = "INSERT INTO admin_actions (admin_id, action, date) VALUES (:admin_id, :action, NOW())";
    $stmt_log = $db->prepare($sql_log);
    $stmt_log->bindParam(':admin_id', $admin_id);
    $stmt_log->bindParam(':action', $action);
    $stmt_log->execute();

    // Valider la transaction
    $db->commit();

    $_SESSION['success_message'] = "L'offre d'emploi a été supprimée avec succès.";
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    $db->rollBack();
    $_SESSION['error_message'] = "Erreur lors de la suppression de l'offre: " . $e->getMessage();
}

// Rediriger vers la page des offres de la même catégorie
header("Location: offres_categorie.php?categorie=" . urlencode($categorie));
exit;
?>