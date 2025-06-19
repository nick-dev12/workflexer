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
$mail->Host = 'mail.work-flexer.com';
$mail->SMTPAuth = true;
$mail->Username = 'service@work-flexer.com';
$mail->Password = 'Ludvanne12@gmail.com'; // À stocker de manière sécurisée dans un fichier de configuration
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('service@work-flexer.com', 'Work-Flexer');
$mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');
$mail->isHTML(true);
$mail->CharSet = 'UTF-8'; // Important pour l'affichage correct des caractères accentués

// Compteurs pour les statistiques
$emailsEnvoyes = 0;
$emailsEchoues = 0;
$maxTentativeParExecution = 5; // Nombre de tentatives maximum par email dans une même exécution

// Traiter chaque email
foreach ($emailsEnAttente as $email) {
    try {
        // Réinitialiser les destinataires pour chaque envoi
        $mail->clearAddresses();

        // Vérifier le nombre de tentatives pour cet email dans cette exécution
        if (isset($tentatives[$email['id']]) && $tentatives[$email['id']] >= $maxTentativeParExecution) {
            echo "Email ID {$email['id']} : nombre maximum de tentatives atteint pour cette exécution.\n";
            continue;
        }

        // Incrémenter le compteur de tentatives pour cet email
        if (!isset($tentatives[$email['id']])) {
            $tentatives[$email['id']] = 1;
        } else {
            $tentatives[$email['id']]++;
        }

        // Personnaliser l'email si c'est une notification de candidature
        $sujet = $email['sujet'];
        $message = $email['message'];

        // Configurer l'email
        $mail->addAddress($email['destinataire']);
        $mail->Subject = $sujet;
        $mail->Body = $message;

        // Ajouter le nom du destinataire si disponible
        if (!empty($email['nom_destinataire'])) {
            $mail->addAddress($email['destinataire'], $email['nom_destinataire']);
        } else {
            $mail->addAddress($email['destinataire']);
        }

        // Envoyer l'email
        if ($mail->send()) {
            // Mettre à jour le statut de l'email
            updateEmailStatus($db, $email['id'], 'sent');
            $emailsEnvoyes++;
            echo "Email ID {$email['id']} envoyé à {$email['destinataire']}.\n";

            // Mettre à jour les statistiques d'envoi dans la base de données
            // Cette fonction pourrait être implémentée pour suivre les performances d'envoi
            logEmailSuccess($db, $email['id']);
        } else {
            // En cas d'échec, mettre à jour le statut avec l'erreur
            updateEmailStatus($db, $email['id'], 'failed', $mail->ErrorInfo);
            $emailsEchoues++;
            echo "Échec de l'envoi de l'email ID {$email['id']} : {$mail->ErrorInfo}\n";
        }

        // Petite pause pour éviter de surcharger le serveur SMTP
        usleep(750000); // 750ms pour respecter les limites de débit du serveur SMTP

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

/**
 * Enregistre les statistiques de succès d'envoi d'email
 * Cette fonction est un exemple et devrait être implémentée dans email_queue.php
 */
function logEmailSuccess($db, $email_id)
{
    // Cette fonction pourrait être développée pour enregistrer des statistiques d'envoi
    // Par exemple, temps d'envoi, type d'email, etc.
    return true;
}

exit(0);