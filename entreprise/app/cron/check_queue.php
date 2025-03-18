<?php
/**
 * Script pour vérifier l'état de la file d'attente des emails
 */

// Définir le chemin absolu vers la racine du projet
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));

// Inclure les fichiers nécessaires
require_once($rootPath . '/conn/conn.php');

try {
    // Vérifier si la table email_queue existe
    $stmt = $db->query("SHOW TABLES LIKE 'email_queue'");
    $tableExists = $stmt->rowCount() > 0;

    if (!$tableExists) {
        echo "La table email_queue n'existe pas.\n";
        exit(1);
    }

    // Récupérer tous les emails de la file d'attente
    $stmt = $db->query("SELECT id, destinataire, nom_destinataire, sujet, statut, tentatives, date_creation, date_envoi FROM email_queue");
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "État de la file d'attente des emails (" . count($emails) . " emails):\n";
    echo "=================================================================\n";

    foreach ($emails as $email) {
        echo "ID: {$email['id']}\n";
        echo "Destinataire: {$email['destinataire']}\n";
        echo "Nom: {$email['nom_destinataire']}\n";
        echo "Sujet: {$email['sujet']}\n";
        echo "Statut: {$email['statut']}\n";
        echo "Tentatives: {$email['tentatives']}\n";
        echo "Date de création: {$email['date_creation']}\n";
        echo "Date d'envoi: " . ($email['date_envoi'] ? $email['date_envoi'] : 'Non envoyé') . "\n";
        echo "-----------------------------------------------------------------\n";
    }

    // Compter les emails par statut
    $stmt = $db->query("SELECT statut, COUNT(*) as count FROM email_queue GROUP BY statut");
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nRésumé par statut:\n";
    foreach ($stats as $stat) {
        echo "{$stat['statut']}: {$stat['count']} emails\n";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>