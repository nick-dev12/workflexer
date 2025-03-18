<?php
/**
 * Script pour envoyer les emails en attente
 * Ce script doit être exécuté par un cron job toutes les 5 minutes
 */

// Définir le chemin absolu vers la racine du projet
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));

// Inclure les fichiers nécessaires
require_once($rootPath . '/conn/conn.php');
require_once($rootPath . '/entreprise/app/model/email_queue.php');

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require $rootPath . '/vendor/autoload.php';

// Définir le nombre maximum d'emails à envoyer par exécution
$maxEmails = 50;

// Récupérer les emails en attente
$emailsEnAttente = getEmailsEnAttente($db, $maxEmails);

// Si aucun email en attente, terminer le script
if (empty($emailsEnAttente)) {
    echo "Aucun email en attente.\n";
    exit(0);
}

// Configurer PHPMailer
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'advantech-group.space';
$mail->SMTPAuth = true;
$mail->Username = 'info@advantech-group.space';
$mail->Password = 'Ludvanne12@gmail.com'; // À stocker de manière sécurisée dans un fichier de configuration
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom('info@advantech-group.space', 'Work-Flexer');
$mail->isHTML(true);

// Compteurs pour les statistiques
$emailsEnvoyes = 0;
$emailsEchoues = 0;

// Traiter chaque email
foreach ($emailsEnAttente as $email) {
    try {
        // Réinitialiser les destinataires pour chaque envoi
        $mail->clearAddresses();

        // Configurer l'email
        $mail->addAddress($email['destinataire']);
        $mail->Subject = $email['sujet'];
        $mail->Body = $email['message'];

        // Envoyer l'email
        if ($mail->send()) {
            // Mettre à jour le statut de l'email
            updateEmailStatus($db, $email['id'], 'sent');
            $emailsEnvoyes++;
            echo "Email ID {$email['id']} envoyé à {$email['destinataire']}.\n";
        } else {
            // En cas d'échec, mettre à jour le statut avec l'erreur
            updateEmailStatus($db, $email['id'], 'failed', $mail->ErrorInfo);
            $emailsEchoues++;
            echo "Échec de l'envoi de l'email ID {$email['id']} : {$mail->ErrorInfo}\n";
        }

        // Petite pause pour éviter de surcharger le serveur SMTP
        usleep(500000); // 500ms

    } catch (Exception $e) {
        // En cas d'exception, mettre à jour le statut avec l'erreur
        updateEmailStatus($db, $email['id'], 'failed', $e->getMessage());
        $emailsEchoues++;
        echo "Exception lors de l'envoi de l'email ID {$email['id']} : {$e->getMessage()}\n";
    }
}

// Nettoyer les emails anciens
nettoyerEmailsAnciens($db);

// Afficher les statistiques
echo "Traitement terminé. Emails envoyés: $emailsEnvoyes, Échecs: $emailsEchoues\n";
exit(0);