<?php
/**
 * Script pour l'envoi d'emails de partage de profil via PHPMailer
 */

// Activer la gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 0); // Ne pas afficher les erreurs à l'écran
ini_set('log_errors', 1); // Enregistrer les erreurs dans le log

// Démarrer la capture de sortie pour éviter les interférences
ob_start();

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données du formulaire
$recipient = filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8');
$textBody = htmlspecialchars($_POST['textBody'] ?? '', ENT_QUOTES, 'UTF-8');
// $htmlBody = $_POST['htmlBody']; // On ignore le HTML envoyé depuis JavaScript
$senderName = htmlspecialchars($_POST['senderName'] ?? '', ENT_QUOTES, 'UTF-8');
$profileUrl = filter_input(INPUT_POST, 'profileUrl', FILTER_SANITIZE_URL);
$skillsJson = $_POST['skills'] ?? '[]';
$skills = json_decode($skillsJson, true);
$userEmail = htmlspecialchars($_POST['userEmail'] ?? '', ENT_QUOTES, 'UTF-8');
$userPhone = htmlspecialchars($_POST['userPhone'] ?? '', ENT_QUOTES, 'UTF-8');
$userCompetence = htmlspecialchars($_POST['userCompetence'] ?? '', ENT_QUOTES, 'UTF-8');

// Debug: Enregistrer les valeurs reçues
error_log("DEBUG - userCompetence: " . $userCompetence);
error_log("DEBUG - userEmail: " . $userEmail);
error_log("DEBUG - senderName: " . $senderName);

// Debug: Vérifier le contenu final du template
$debugTemplate = "
                <div class='email-header'>
                    <div class='email-title'>Profil Professionnel</div>
                    <div class='email-subtitle'>{$senderName}</div>
                    " . (!empty($userCompetence) ? "<div class='email-job'>{$userCompetence}</div>" : "") . "
                </div>";
error_log("DEBUG - Template header: " . $debugTemplate);

// Debug: Vérifier toutes les variables POST
error_log("DEBUG - POST data: " . print_r($_POST, true));

// Vérifier que les données requises sont présentes
if (empty($recipient) || empty($subject) || (empty($textBody) && empty($htmlBody))) {
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

// Vérifier que l'email est valide
if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
    ob_end_clean();
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

    // Configuration anti-spam
    $mail->XMailer = ' '; // Masquer la version de PHPMailer
    $mail->Encoding = 'base64'; // Encodage plus fiable
    $mail->Priority = 3; // Priorité normale

    // Optionnel : autoriser certificat auto-signé
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    // Identifiants uniques pour le message
    $mail->MessageID = "<" . md5(uniqid(time())) . "@work-flexer.com>";
    $mail->Host = gethostbyname('mail.work-flexer.com');

    // Destinataires
    $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
    $mail->addAddress($recipient);

    // Configuration de la réponse vers l'email du candidat si disponible
    if (!empty($userEmail)) {
        $mail->addReplyTo($userEmail, $senderName);
    } else {
        $mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');
    }

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

    // Construction du style élégant et compatible des compétences pour PHPMailer
    $emailSafeSkillsHtml = '';
    if (!empty($skills) && is_array($skills)) {
        // 1. Séparer les compétences
        $highlightedSkills = array_filter($skills, fn($s) => isset($s['mis_en_avant']) && $s['mis_en_avant'] == 1);
        $otherSkills = array_filter($skills, fn($s) => !isset($s['mis_en_avant']) || $s['mis_en_avant'] != 1);

        // 2. Créer la liste finale (7 max)
        $skillsForDisplay = array_slice(array_merge(array_values($highlightedSkills), array_values($otherSkills)), 0, 7);

        // 3. Générer le HTML en tableau
        if (!empty($skillsForDisplay)) {
            $emailSafeSkillsHtml .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">';

            $i = 0;
            foreach ($skillsForDisplay as $skill) {
                if ($i % 3 == 0)
                    $emailSafeSkillsHtml .= '<tr>';

                $isHighlighted = isset($skill['mis_en_avant']) && $skill['mis_en_avant'] == 1;

                if ($isHighlighted) {
                    // Compétences mises en avant - Style doré élégant
                    $bgColor = '#fef3c7';
                    $borderColor = '#f59e0b';
                    $textColor = '#92400e';
                    $fontWeight = '700';
                    $star = '⭐';
                    $shadowColor = 'rgba(245, 158, 11, 0.3)';
                } else {
                    // Autres compétences - Style bleu professionnel
                    $bgColor = '#dbeafe';
                    $borderColor = '#3b82f6';
                    $textColor = '#1e40af';
                    $fontWeight = '600';
                    $star = '🔹';
                    $shadowColor = 'rgba(59, 130, 246, 0.2)';
                }

                $emailSafeSkillsHtml .= '<td align="center" width="250px !important" style="padding: 4px;">';
                $emailSafeSkillsHtml .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr>';
                $emailSafeSkillsHtml .= '<td align="center" bgcolor="' . $bgColor . '" style="padding: 4px 12px; border-radius: 20px; border: 2px solid ' . $borderColor . '; box-shadow: 0 3px 6px ' . $shadowColor . ';">';
                $emailSafeSkillsHtml .= '<span style="font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; color: ' . $textColor . '; font-weight: ' . $fontWeight . '; text-shadow: 0 1px 2px rgba(0,0,0,0.1); line-height: 1.2;">';
                $emailSafeSkillsHtml .= $star . ' ' . htmlspecialchars($skill['competence'], ENT_QUOTES, 'UTF-8');
                $emailSafeSkillsHtml .= '</span></td></tr></table></td>';

                if ($i % 3 == 2 || $i == count($skillsForDisplay) - 1) {
                    // Compléter la ligne si nécessaire
                    $remaining = 3 - (($i % 3) + 1);
                    for ($j = 0; $j < $remaining; $j++) {
                        $emailSafeSkillsHtml .= '<td width="33.33%"></td>';
                    }
                    $emailSafeSkillsHtml .= '</tr>';
                }
                $i++;
            }
            $emailSafeSkillsHtml .= '</table>';
        }
    }

    // Remplacer le placeholder des compétences dans le HTML
    if (!empty($emailSafeSkillsHtml)) {
        // Les compétences sont déjà intégrées dans le template PHP
        // Pas besoin de remplacement car le template PHP gère tout
    }

    // Préparer le contenu final
    $finalTextBody = $textBody . $attachmentText;
    // Le template PHP gère tout le HTML

    // Template de l'email
    $emailTemplate = "
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Profil Work-Flexer</title>
        <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .email-wrapper {
            padding: 40px 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>') repeat;
        }

        .email-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .email-subtitle {
            font-size: 16px;
            margin: 10px 0 0 0;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .email-job {
            font-size: 14px;
            margin: 8px  0;
            position: relative;
            padding: 7px 10px;
            background-color: #f0f9ff;
            border-radius: 10px;
            border: 1px solid #3b82f6;
            z-index: 1;
            color: #3b82f6;
            font-style: italic;
            font-weight: 600;
        }

        .email-content {
            padding: 50px 40px;
            line-height: 1.7;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .intro-text {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .contact-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #93c5fd;
        }

        .contact-title {
            font-size: 20px;
            font-weight: 600;
            color: #0c4a6e;
            margin-bottom: 20px;
            text-align: center;
        }

        .contact-info {
            display: table;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .contact-row {
            display: table-row;
        }

        .contact-label {
            display: table-cell;
            padding: 8px 15px;
            color: #1e40af;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
        }

        .contact-value {
            display: table-cell;
            padding: 8px 15px;
            color: #1e3a8a;
            font-size: 14px;
        }

        .contact-icon {
            margin-right: 8px;
            color: #3b82f6;
        }

        .skills-section {
            background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .skills-title {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            text-align: center;
        }

        .cta-section {
            text-align: center;
            margin: 40px 0;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
        }

        .closing {
            font-size: 16px;
            color: #4a5568;
            margin-top: 35px;
            line-height: 1.6;
        }

        .signature {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-top: 25px;
        }

        .email-footer {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .footer-text {
            font-size: 14px;
            opacity: 0.8;
            margin: 0;
        }

        .footer-subtext {
            font-size: 12px;
            opacity: 0.6;
            margin: 8px 0 0 0;
        }

        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 10px;
            }

            .email-container {
                border-radius: 15px;
                margin: 0 5px;
            }

            .email-header {
                padding: 30px 20px;
            }

            .email-title {
                font-size: 24px;
            }

            .email-subtitle {
                font-size: 14px;
            }

            .email-job {
                font-size: 12px;
            }

            .email-content {
                padding: 30px 20px;
            }

            .greeting {
                font-size: 16px;
                margin-bottom: 20px;
            }

            .intro-text {
                font-size: 14px;
                margin-bottom: 25px;
            }

            .contact-section {
                padding: 20px;
                margin: 20px 0;
            }

            .contact-title {
                font-size: 18px;
                margin-bottom: 15px;
            }

            .contact-info {
                max-width: 100%;
            }

            .contact-label,
            .contact-value {
                font-size: 13px;
                padding: 6px 10px;
            }

            .skills-section {
                padding: 20px 15px;
                margin: 20px 0;
                border-radius: 12px;
            }

            .skills-title {
                font-size: 18px;
                margin-bottom: 15px;
            }

            .cta-section {
                margin: 30px 0;
            }

            .cta-button {
                padding: 14px 30px;
                font-size: 14px;
                border-radius: 40px;
            }

            .closing {
                font-size: 14px;
                margin-top: 25px;
            }

            .signature {
                font-size: 16px;
                margin-top: 20px;
            }

            .email-footer {
                padding: 20px 15px;
            }

            .footer-text {
                font-size: 12px;
            }

            .footer-subtext {
                font-size: 11px;
            }
        }

        @media only screen and (max-width: 480px) {
            .email-wrapper {
                padding: 15px 5px;
            }

            .email-title {
                font-size: 20px;
            }

            .email-job {
                font-size: 11px;
            }

            .email-content {
                padding: 25px 15px;
            }

            .contact-section {
                padding: 8px 15px;
            }

            .contact-info {
                display: block;
            }

            .contact-row {
                display: block;
                margin-bottom: 10px;
            }

            .contact-label,
            .contact-value {
                display: block;
                padding: 4px 0;
            }

            .skills-section {
                padding: 15px 10px;
            }

            .cta-button {
                padding: 12px 25px;
                font-size: 13px;
            }
        }
        </style>
    </head>

    <body>
        <div class='email-wrapper'>
            <div class='email-container'>
                <div class='email-header'>
                    <div class='email-title'>Profil Professionnel</div>
                    <div class='email-subtitle'>{$senderName}</div>
                    " . (!empty($userCompetence) ? "<div class='email-job'>{$userCompetence}</div>" : "") . "
                </div>

                <div class='email-content'>
                    <div class='greeting'>Bonjour, Mr/Mme !</div>

                    " . (!empty($userPhone) ? "
                    <div class='contact-section'>
                        <div class='contact-info'>
                            <div class='contact-row'>
                                <div class='contact-label'><span class='contact-icon'>📱</span>Téléphone:</div>
                                <div class='contact-value'>{$userPhone}</div>
                            </div>
                        </div>
                    </div>" : "") . "

                    <div class='intro-text'>
                        En tant que professionnel passionné, je recherche activement de nouveaux défis où mettre à
                        profit mon expertise.
                        Voici un aperçu de mes compétences principales :
                    </div>

                    <div class='skills-section'>
                        <div class='skills-title'>💼 Compétences Clés</div>
                        {$emailSafeSkillsHtml}
                    </div>

                    {$attachmentText}

                    <div class='cta-section'>
                        <a href='{$profileUrl}' class='cta-button'>
                            🔍 Découvrir mon profil complet
                        </a>
                    </div>

                    <div class='closing'>
                        Mon profil détaillé contient l'ensemble de mes expériences, formations et réalisations.
                        Je serais ravi d'échanger avec vous sur les opportunités de collaboration.
                    </div>

                    <div class='signature'>
                        Cordialement,<br>
                        {$senderName}
                    </div>
                </div>

                <div class='email-footer'>
                    <div class='footer-text'>© " . date('Y') . " Work-Flexer - Plateforme Professionnelle</div>
                    <div class='footer-subtext'>Profil partagé via Work-Flexer</div>
                </div>
            </div>
        </div>
    </body>

    </html>";

    // Ajouter des en-têtes anti-spam
    $mail->addCustomHeader('List-Unsubscribe', '<mailto:unsubscribe@work-flexer.com>');
    $mail->addCustomHeader('Precedence', 'bulk');
    $mail->addCustomHeader('X-Auto-Response-Suppress', 'OOF, AutoReply');

    // Définir le contenu de l'email
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mail->Body = $emailTemplate;
    $mail->AltBody = $finalTextBody . "\n\n" . (!empty($attachments) ? "Pièces jointes: " . implode(
        ", ",
        $attachments
    )
        : "");

    // Debug: Vérifier le contenu final de l'email
    error_log("DEBUG - Email template final: " . substr($emailTemplate, 0, 1000));

    // Envoyer l'email
    $mail->send();

    // Nettoyer la sortie et répondre avec un succès
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Email envoyé avec succès']);

} catch (Exception $e) {
    // Gérer les erreurs
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => "L'email n'a pas pu être envoyé. Erreur: " . $e->getMessage()
    ]);
} catch (Error $e) {
    // Gérer les erreurs fatales PHP
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => "Erreur PHP: " . $e->getMessage()
    ]);
}