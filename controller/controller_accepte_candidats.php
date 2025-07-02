<?php
require_once(__DIR__ . '/../model/accepte_candidats.php');
require_once(__DIR__ . '/../model/fcm_notification.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_GET['accepter'])) {
    $poste_id = $_GET['accepter'];
    $statut = 'accepter';

    $postulation = affichePostulant($db, $poste_id);

    $entreprise_id = $postulation['entreprise_id'];
    $user_id = $postulation['users_id'];

    $nom = $postulation['nom'];
    $poste = $postulation['poste'];

    // Récupération du nom de l'entreprise si disponible
    $entreprise_name = '';
    try {
        $stmt = $db->prepare("SELECT entreprise FROM compte_entreprise WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $entreprise_id);
        $stmt->execute();
        $ent = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($ent) {
            $entreprise_name = $ent['entreprise'];
        }
    } catch (Exception $e) {
        error_log("Erreur lors de la récupération du nom de l'entreprise: " . $e->getMessage());
    }

    // Créez l'instance PHPMailer
    $mail = new PHPMailer(true);


    try {
        $mail->isSMTP();
        $mail->Host = 'mail.work-flexer.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'service@work-flexer.com';
        $mail->Password = 'Ludvanne12@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];
        

        //     //   $infoEntreprises = getEntreprise($db,$entreprise_id);
        $destinataire = $postulation['mail'];
        //     //   $entreprise = $infoEntreprises['entreprise'];

        // Contenu de l'e-mail
        $sujet = 'Suivi de candidature';
        $message = "
              <!DOCTYPE html>
              <html>
              <head>
                  <meta charset='utf-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Candidature acceptée</title>
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
                          background-color: #0671dc;
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
                          color: #0671dc;
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
                      .highlight-box {
                          background-color: #f0f7ff;
                          border-left: 4px solid #0671dc;
                          padding: 15px 20px;
                          margin: 25px 0;
                          color: #333333;
                      }
                      .highlight-box h3 {
                          font-size: 16px;
                          margin-bottom: 10px;
                          color: #0671dc;
                      }
                      .button {
                          display: inline-block;
                          background-color: #0671dc;
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
                          color: #0671dc;
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
                          <div class='greeting'>Bonjour $nom,</div>
                          <div class='email-title'>Bonne nouvelle ! Votre candidature a été retenue</div>
                          
                          <div class='highlight-box'>
                              <h3>Poste : $poste</h3>
                          </div>
                          
                          <p class='email-text'>Nous sommes ravis de vous informer que votre candidature pour le poste de <strong>$poste</strong> a été retenue par le recruteur.</p>
                          
                          <p class='email-text'>Prochaines étapes :</p>
                          <ol style='margin-left: 20px; margin-bottom: 20px; color: #555555;'>
                              <li style='margin-bottom: 8px;'>Connectez-vous à votre compte Work-Flexer</li>
                              <li style='margin-bottom: 8px;'>Consultez les détails de l'offre et les messages du recruteur</li>
                              <li style='margin-bottom: 8px;'>Préparez-vous pour un éventuel entretien</li>
                          </ol>
                          
                          <a href='https://work-flexer.com/page/user_profil.php' class='button'>Accéder à mon compte</a>
                          
                          <p class='note'>Félicitations pour cette étape franchie dans votre recherche d'emploi ! Nous vous souhaitons beaucoup de succès pour la suite du processus.</p>
                          
                          <div class='signature'>
                              <p class='email-text'>Cordialement,</p>
                              <p class='signature-name'>L'équipe Work-Flexer</p>
                              <p class='signature-title'>Service recrutement</p>
                          </div>
                      </div>
                      <div class='email-footer'>
                          <div class='social-links'>
                              <a href='#'>Facebook</a>
                              <a href='#'>Twitter</a>
                              <a href='#'>LinkedIn</a>
                          </div>
                          <p class='footer-text'>© 2023 Work-Flexer. Tous droits réservés.</p>
                          <p class='footer-text'>Pour toute question, contactez-nous à <a href='mailto:service@work-flexer.com'>service@work-flexer.com</a></p>
                      </div>
                  </div>
              </body>
              </html> ";

        $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
        $mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $message;

        $mail->CharSet = 'UTF-8'; // Ajout pour l'encodage

        $mail->clearAddresses();
        $mail->addAddress($destinataire);
        $mail->send();

        // Envoyer notification push si le candidat a un token FCM
        sendApplicationStatusNotification($db, $user_id, $statut, $poste, $entreprise_name);
        error_log("Notification push envoyée au candidat $user_id pour le poste $poste (accepté)");

        if (AccepteCandidats($db, $statut, $poste_id)) {
            if (notification_suivi($db, $postulation['entreprise_id'], $postulation['users_id'], $statut)) {
                $_SESSION['success_message'] = 'Candidat accepté';
                header('Location: ../page/candidature.php');
            }
            exit();
        }

    } catch (Exception $e) {
        error_log("Erreur lors de l'envoi de l'email/notification: " . $e->getMessage());
        $_SESSION['error_message'] = 'Erreur !';
        header('Location: ../page/candidature.php');
        exit();
    }

}

if (isset($_GET['recaler'])) {
    $poste_id = $_GET['recaler'];
    $statut = 'recaler';

    $postulation = affichePostulant($db, $poste_id);

    $entreprise_id = $postulation['entreprise_id'];
    $user_id = $postulation['users_id'];

    $nom = $postulation['nom'];
    $poste = $postulation['poste'];

    // Récupération du nom de l'entreprise si disponible
    $entreprise_name = '';
    try {
        $stmt = $db->prepare("SELECT entreprise FROM compte_entreprise WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $entreprise_id);
        $stmt->execute();
        $ent = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($ent) {
            $entreprise_name = $ent['entreprise'];
        }
    } catch (Exception $e) {
        error_log("Erreur lors de la récupération du nom de l'entreprise: " . $e->getMessage());
    }

    // Créez l'instance PHPMailer

    $mail = new PHPMailer(true);

    try {
        // Paramètres SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.work-flexer.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'service@work-flexer.com';
        $mail->Password = 'Ludvanne12@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];
        

        //     //   $infoEntreprises = getEntreprise($db,$entreprise_id);
        $destinataire = $postulation['mail'];
        //     //   $entreprise = $infoEntreprises['entreprise'];

        // Contenu de l'e-mail
        $sujet = 'Suivi de candidature';
        $message = "
               <!DOCTYPE html>
               <html>
               <head>
                   <meta charset='utf-8'>
                   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                   <title>Candidature non retenue</title>
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
                           background-color: #0671dc;
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
                           color: #0671dc;
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
                       .highlight-box {
                           background-color: #f0f7ff;
                           border-left: 4px solid #0671dc;
                           padding: 15px 20px;
                           margin: 25px 0;
                           color: #333333;
                       }
                       .highlight-box h3 {
                           font-size: 16px;
                           margin-bottom: 10px;
                           color: #0671dc;
                       }
                       .button {
                           display: inline-block;
                           background-color: #0671dc;
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
                           color: #0671dc;
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
                           <div class='greeting'>Bonjour $nom,</div>
                           <div class='email-title'>Concernant votre candidature</div>
                           
                           <div class='highlight-box'>
                               <h3>Poste : $poste</h3>
                           </div>
                           
                           <p class='email-text'>Nous vous remercions pour l'intérêt que vous avez porté à ce poste et pour le temps que vous avez consacré à votre candidature.</p>
                           
                           <p class='email-text'>Après étude attentive de votre profil, nous sommes au regret de vous informer que votre candidature n'a pas été retenue pour ce poste.</p>
                           
                           <p class='email-text'>Nous vous encourageons à continuer votre recherche sur notre plateforme, où de nombreuses autres opportunités correspondant à votre profil sont disponibles.</p>
                           
                           <a href='https://work-flexer.com/page/user_profil.php' class='button'>Découvrir d'autres opportunités</a>
                           
                           <p class='note'>Nous vous souhaitons beaucoup de succès dans votre recherche d'emploi et espérons vous revoir bientôt sur Work-Flexer.</p>
                           
                           <div class='signature'>
                               <p class='email-text'>Cordialement,</p>
                               <p class='signature-name'>L'équipe Work-Flexer</p>
                               <p class='signature-title'>Service recrutement</p>
                           </div>
                       </div>
                       <div class='email-footer'>
                           <div class='social-links'>
                               <a href='#'>Facebook</a>
                               <a href='#'>Twitter</a>
                               <a href='#'>LinkedIn</a>
                           </div>
                           <p class='footer-text'>© 2023 Work-Flexer. Tous droits réservés.</p>
                           <p class='footer-text'>Pour toute question, contactez-nous à <a href='mailto:service@work-flexer.com'>service@work-flexer.com</a></p>
                       </div>
                   </div>
               </body>
               </html> ";

        $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
        $mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $message;

        $mail->CharSet = 'UTF-8'; // Ajout pour l'encodage

        $mail->clearAddresses();
        $mail->addAddress($destinataire);
        $mail->send();

        // Envoyer notification push si le candidat a un token FCM
        sendApplicationStatusNotification($db, $user_id, $statut, $poste, $entreprise_name);
        error_log("Notification push envoyée au candidat $user_id pour le poste $poste (refusé)");

        if (recalerCandidats($db, $statut, $poste_id)) {

            if (notification_suivi($db, $postulation['entreprise_id'], $postulation['users_id'], $statut)) {
                $_SESSION['success_message'] = 'Candidat recalé !'; // Correction de l'orthographe
                header('Location: ../page/candidature.php');
                exit();
            }

        }

    } catch (Exception $e) {
        error_log("Erreur lors de l'envoi de l'email/notification: " . $e->getMessage());
        $_SESSION['error_message'] = 'Une erreur s\'est produite !'; // Correction de l'orthographe
        header('Location: ../page/candidature.php');
        exit();
    }

}

// $getAccepteCandidat= getAccepteCandidat($db,$_SESSION['compte_entreprise'])
