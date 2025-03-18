<?php
/**
 * Script de test pour le système d'envoi d'emails asynchrone
 * 
 * Ce script permet de tester le système en ajoutant un email de test à la file d'attente
 * et en vérifiant que le script d'envoi fonctionne correctement.
 */

// Définir le chemin absolu vers la racine du projet
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));

// Inclure les fichiers nécessaires
require_once($rootPath . '/conn/conn.php');
require_once($rootPath . '/entreprise/app/model/email_queue.php');

// Vérifier si la table email_queue existe
try {
    $stmt = $db->query("SHOW TABLES LIKE 'email_queue'");
    $tableExists = $stmt->rowCount() > 0;

    if (!$tableExists) {
        echo "La table email_queue n'existe pas. Création de la table...\n";

        // Créer la table email_queue
        $sql = "CREATE TABLE IF NOT EXISTS `email_queue` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `destinataire` varchar(255) NOT NULL,
            `nom_destinataire` varchar(255) DEFAULT NULL,
            `sujet` varchar(255) NOT NULL,
            `message` text NOT NULL,
            `statut` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
            `tentatives` int(11) NOT NULL DEFAULT 0,
            `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
            `date_envoi` timestamp NULL DEFAULT NULL,
            `erreur` text DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `statut` (`statut`),
            KEY `date_creation` (`date_creation`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $db->exec($sql);
        echo "Table email_queue créée avec succès.\n";
    } else {
        echo "La table email_queue existe déjà.\n";
    }

    // Ajouter un email de test à la file d'attente
    $destinataire = 'test@example.com'; // Remplacez par une adresse email valide pour les tests
    $nom = 'Utilisateur Test';
    $sujet = 'Test du système d\'envoi d\'emails asynchrone';
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Test du système d\'envoi d\'emails asynchrone</title>
    </head>
    <body>
        <h1>Test du système d\'envoi d\'emails asynchrone</h1>
        <p>Ceci est un email de test pour vérifier que le système d\'envoi d\'emails asynchrone fonctionne correctement.</p>
        <p>Date et heure du test : ' . date('Y-m-d H:i:s') . '</p>
    </body>
    </html>';

    if (ajouterEmailQueue($db, $destinataire, $nom, $sujet, $message)) {
        echo "Email de test ajouté à la file d'attente avec succès.\n";
    } else {
        echo "Erreur lors de l'ajout de l'email de test à la file d'attente.\n";
    }

    // Afficher les emails en attente
    $emailsEnAttente = getEmailsEnAttente($db, 10);
    echo "Emails en attente : " . count($emailsEnAttente) . "\n";

    foreach ($emailsEnAttente as $email) {
        echo "ID: {$email['id']}, Destinataire: {$email['destinataire']}, Statut: {$email['statut']}, Date de création: {$email['date_creation']}\n";
    }

    echo "\nPour envoyer les emails en attente, exécutez le script send_emails.php :\n";
    echo "php " . dirname(__FILE__) . "/send_emails.php\n";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>