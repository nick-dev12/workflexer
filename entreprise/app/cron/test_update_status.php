<?php
/**
 * Script pour tester la fonction updateEmailStatus
 */

// Définir le chemin absolu vers la racine du projet
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));

// Inclure les fichiers nécessaires
require_once($rootPath . '/conn/conn.php');
require_once($rootPath . '/entreprise/app/model/email_queue.php');

// ID de l'email à mettre à jour (premier email de la file d'attente)
$emailId = 1;

// Afficher l'état actuel de l'email
$stmt = $db->prepare("SELECT * FROM email_queue WHERE id = :id");
$stmt->bindParam(':id', $emailId, PDO::PARAM_INT);
$stmt->execute();
$email = $stmt->fetch(PDO::FETCH_ASSOC);

echo "État actuel de l'email ID $emailId :\n";
echo "Statut: {$email['statut']}\n";
echo "Tentatives: {$email['tentatives']}\n";
echo "Date d'envoi: " . ($email['date_envoi'] ? $email['date_envoi'] : 'Non envoyé') . "\n";
echo "Erreur: " . ($email['erreur'] ? $email['erreur'] : 'Aucune') . "\n";
echo "-----------------------------------------------------------------\n";

// Tester la mise à jour du statut
echo "Mise à jour du statut à 'sent'...\n";
$result = updateEmailStatus($db, $emailId, 'sent');

if ($result) {
    echo "Mise à jour réussie.\n";
} else {
    echo "Échec de la mise à jour.\n";
}

// Vérifier l'état après la mise à jour
$stmt->execute();
$emailUpdated = $stmt->fetch(PDO::FETCH_ASSOC);

echo "\nÉtat après la mise à jour :\n";
echo "Statut: {$emailUpdated['statut']}\n";
echo "Tentatives: {$emailUpdated['tentatives']}\n";
echo "Date d'envoi: " . ($emailUpdated['date_envoi'] ? $emailUpdated['date_envoi'] : 'Non envoyé') . "\n";
echo "Erreur: " . ($emailUpdated['erreur'] ? $emailUpdated['erreur'] : 'Aucune') . "\n";

// Vérifier si la mise à jour a bien été effectuée
if ($email['statut'] != $emailUpdated['statut'] || $email['tentatives'] != $emailUpdated['tentatives']) {
    echo "\nLa mise à jour a bien été effectuée dans la base de données.\n";
} else {
    echo "\nLa mise à jour n'a pas été effectuée dans la base de données malgré le succès de la fonction.\n";

    // Essayer une mise à jour directe avec PDO
    echo "\nTentative de mise à jour directe avec PDO...\n";
    $sql = "UPDATE email_queue 
            SET statut = 'sent', 
                tentatives = tentatives + 1,
                date_envoi = NOW()
            WHERE id = :id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $emailId, PDO::PARAM_INT);
    $result = $stmt->execute();

    if ($result) {
        echo "Mise à jour directe réussie.\n";

        // Vérifier à nouveau
        $stmt = $db->prepare("SELECT * FROM email_queue WHERE id = :id");
        $stmt->bindParam(':id', $emailId, PDO::PARAM_INT);
        $stmt->execute();
        $emailDirectUpdate = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "\nÉtat après la mise à jour directe :\n";
        echo "Statut: {$emailDirectUpdate['statut']}\n";
        echo "Tentatives: {$emailDirectUpdate['tentatives']}\n";
        echo "Date d'envoi: " . ($emailDirectUpdate['date_envoi'] ? $emailDirectUpdate['date_envoi'] : 'Non envoyé') . "\n";
    } else {
        echo "Échec de la mise à jour directe.\n";
    }
}
?>