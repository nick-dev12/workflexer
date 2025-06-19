<?php
/**
 * Script pour l'envoi d'emails de partage de profil via PHPMailer
 */

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données du formulaire
$recipient = filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8');
$textBody = htmlspecialchars($_POST['textBody'] ?? '', ENT_QUOTES, 'UTF-8');
$htmlBody = $_POST['htmlBody']; // On garde le HTML tel quel
$senderName = htmlspecialchars($_POST['senderName'] ?? '', ENT_QUOTES, 'UTF-8');
$profileUrl = filter_input(INPUT_POST, 'profileUrl', FILTER_SANITIZE_URL);

// Vérifier que les données requises sont présentes
if (empty($recipient) || empty($subject) || (empty($textBody) && empty($htmlBody))) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

// Vérifier que l'email est valide
if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide']);
    exit;
}

// Charger PHPMailer
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Créer une nouvelle instance de PHPMailer
$mail = new PHPMailer(true); // true active les exceptions

try {
    // Configuration du serveur (utilisation des mêmes paramètres que dans compte_entreprise.php)
    $mail->isSMTP();
    $mail->Host = 'mail.work-flexer.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'service@work-flexer.com';
    $mail->Password = 'Ludvanne12@gmail.com';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    // Optionnel : autoriser certificat auto-signé
$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true,
    ],
];

    // Destinataires
    $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
    $mail->addAddress($recipient);
    $mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');

    // Traitement des pièces jointes
    $attachments = [];
    $attachmentInfo = "";

    // Traitement du CV
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
        $cvFile = $_FILES['cv_file'];

        // Vérifier le type de fichier
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $cvFile['tmp_name']);
        finfo_close($fileInfo);

        if ($mimeType === 'application/pdf') {
            $mail->addAttachment($cvFile['tmp_name'], 'CV_' . $senderName . '.pdf');
            $attachments[] = 'CV';
        } else {
            // Ignorer les fichiers non PDF
            $attachmentInfo .= "<p style='color: #ef4444;'>Le CV n'a pas été joint car ce n'est pas un fichier PDF valide.</p>";
        }
    }

    // Traitement de la lettre de motivation
    if (isset($_FILES['motivation_file']) && $_FILES['motivation_file']['error'] === UPLOAD_ERR_OK) {
        $motivationFile = $_FILES['motivation_file'];

        // Vérifier le type de fichier
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $motivationFile['tmp_name']);
        finfo_close($fileInfo);

        if ($mimeType === 'application/pdf') {
            $mail->addAttachment($motivationFile['tmp_name'], 'Lettre_de_motivation_' . $senderName . '.pdf');
            $attachments[] = 'Lettre de motivation';
        } else {
            // Ignorer les fichiers non PDF
            $attachmentInfo .= "<p style='color: #ef4444;'>La lettre de motivation n'a pas été jointe car ce n'est pas un fichier PDF valide.</p>";
        }
    }

    // Ajouter l'information sur les pièces jointes au corps du message
    if (!empty($attachments)) {
        $attachmentText = "<div style='margin-top: 20px; padding: 15px; background-color: #f0f9ff; border-left: 4px solid #3b82f6; border-radius: 4px;'>";
        $attachmentText .= "<p style='font-weight: 600; color: #1e40af; margin-bottom: 10px;'>Pièces jointes :</p>";
        $attachmentText .= "<ul style='margin: 0; padding-left: 20px;'>";

        foreach ($attachments as $attachment) {
            $attachmentText .= "<li style='margin-bottom: 5px;'>" . htmlspecialchars($attachment) . " (PDF)</li>";
        }

        $attachmentText .= "</ul>";
        $attachmentText .= $attachmentInfo;
        $attachmentText .= "</div>";
    } else {
        $attachmentText = "";
    }

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = $subject;

    // Création d'un template HTML amélioré pour l'email
    $emailTemplate = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Profil Work-Flexer</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            body {
                background-color: #f5f5f5;
                color: #333333;
                line-height: 1.6;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            }
            .email-header {
                background-color: #3b82f6;
                padding: 30px 20px;
                text-align: center;
            }
            .email-header img {
                max-width: 180px;
                height: auto;
            }
            .email-body {
                padding: 40px 30px;
            }
            .greeting {
                font-size: 22px;
                font-weight: 600;
                color: #3b82f6;
                margin-bottom: 20px;
            }
            .email-title {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 20px;
                color: #333333;
            }
            .email-text {
                font-size: 15px;
                margin-bottom: 20px;
                color: #555555;
            }
            .profile-button {
                display: inline-block;
                background-color: #3b82f6;
                color: #ffffff !important;
                text-decoration: none;
                padding: 12px 30px;
                border-radius: 4px;
                font-weight: 500;
                margin: 20px 0;
                text-align: center;
            }
            .note {
                font-size: 14px;
                color: #777777;
                margin-top: 30px;
                font-style: italic;
            }
            .email-footer {
                background-color: #f9f9f9;
                padding: 30px;
                text-align: center;
                border-top: 1px solid #eeeeee;
            }
            .social-links {
                margin-bottom: 20px;
            }
            .social-links a {
                display: inline-block;
                margin: 0 10px;
                color: #3b82f6;
                text-decoration: none;
            }
            .footer-text {
                font-size: 13px;
                color: #999999;
                margin-bottom: 10px;
            }
            .signature {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eeeeee;
            }
            .signature-name {
                font-weight: 600;
                color: #333333;
                margin-bottom: 5px;
            }
            .signature-title {
                font-size: 14px;
                color: #777777;
            }
            @media only screen and (max-width: 600px) {
                .email-body {
                    padding: 30px 20px;
                }
                .greeting {
                    font-size: 20px;
                }
                .email-title {
                    font-size: 16px;
                }
                .email-text {
                    font-size: 14px;
                }
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='email-header'>
                <img src='https://work-flexer.com/image/logo 2.png' alt='Work-Flexer Logo'>
            </div>
            <div class='email-body'>
                <div class='greeting'>Bonjour,</div>
                <div class='email-title'>Profil professionnel de {$senderName}</div>
                
                <p class='email-text'>" . nl2br($textBody) . "</p>
                
                <center>
                    <a href='{$profileUrl}' class='profile-button'>Voir le profil complet</a>
                </center>
                
                {$attachmentText}
                
                <div class='signature'>
                    <p class='email-text'>Cordialement,</p>
                    <p class='signature-name'>{$senderName}</p>
                    <p class='signature-title'>Via Work-Flexer</p>
                </div>
            </div>
            <div class='email-footer'>
                <div class='social-links'>
                    <a href='#'>Facebook</a>
                    <a href='#'>Twitter</a>
                    <a href='#'>LinkedIn</a>
                </div>
                <p class='footer-text'>© " . date('Y') . " Work-Flexer. Tous droits réservés.</p>
                <p class='footer-text'>Pour toute question, contactez-nous à <a href='mailto:info@advantech-group.space'>info@advantech-group.space</a></p>
            </div>
        </div>
    </body>
    </html>";

    $mail->Body = $emailTemplate;
    $mail->AltBody = $textBody . "\n\n" . (!empty($attachments) ? "Pièces jointes: " . implode(", ", $attachments) : "");

    // Envoyer l'email
    $mail->send();

    // Répondre avec un succès
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Email envoyé avec succès']);
} catch (Exception $e) {
    // Gérer les erreurs
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}"
    ]);
}