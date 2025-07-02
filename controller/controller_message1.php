<?php
include(__DIR__ . '../../model/message1.php');
require_once(__DIR__ . '/../model/appelle_offre.php');
include(__DIR__ . '/../entreprise/app/controller/controllerEntreprise.php');
require_once(__DIR__ . '/../model/fcm_notification.php');
require __DIR__ . '../../vendor/autoload.php';

// include('../model/vue_offre.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



if (isset($_GET['entreprise_id'])) {

  if (isset($_SESSION['compte_entreprise'])) {

    $afficheMessage2 = getMessage2($db, $_SESSION['compte_entreprise'], $_GET['users_id']);

    if (isset($_POST['envoyer1'])) {

      $entreprise_id = $_GET['entreprise_id'];
      $offre_id = '';
      $users_id = $_GET['users_id'];
      if (isset($_GET['statut'])) {
        $statut = $_GET['statut'];
      } else {
        $statut = '';
      }
      $messages = htmlspecialchars(nl2br($_POST['messages']));
      $indicatif = 'recruteur';
      $sujet = 'appel';
      $date_publication = new DateTime();
      $date_formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM y HH:mm'
      );
      $date = $date_formatter->format($date_publication);

      // Récupérer la date actuelle en format datetime
      $date_publications = new DateTime();
      $dates = $date_publications->format('Y-m-d H:i:s'); // Format pour MySQL

      if (updateDateAppelOffre($db, $entreprise_id, $users_id, $dates)) {

      }

      if (post_TMPMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date)) {

      }

      // Récupérer les informations de l'entreprise pour la notification
      $infoEntreprise = getEntreprise($db, $entreprise_id);
      $entrepriseName = isset($infoEntreprise['entreprise']) ? $infoEntreprise['entreprise'] : 'Recruteur';

      // Envoyer notification push Firebase
      sendMessageNotification($db, $users_id, $entrepriseName, true, $messages);

      // Ancienne méthode de notification conservée pour compatibilité
      if (notification_messageUsers($db, $entreprise_id, $users_id, $statut, $sujet)) {
        // code...
      }

      postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date);

      $_SESSION['success_message'] = 'Message envoyé';
      header("Location: message_entreprise2.php?entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id']);
      exit;
    }
  }
}

if (isset($_GET['users_id'])) {

  if (isset($_SESSION['users_id'])) {

    $afficheMessage2 = getMessage2($db, $_GET['entreprise_id'], $_GET['users_id']);

    if (isset($_POST['envoyer1'])) {

      $entreprise_id = $_GET['entreprise_id'];
      $offre_id = '';
      $users_id = $_GET['users_id'];
      if (isset($_GET['statut'])) {
        $statut = $_GET['statut'];
      } else {
        $statut = '';
      }
      $messages = htmlspecialchars(nl2br($_POST['messages']));
      $indicatif = 'candidat';
      $sujet = 'appel';
      $date_publication = new DateTime();
      $date_formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM y HH:mm'
      );
      $date = $date_formatter->format($date_publication);

      // Récupérer la date actuelle en format datetime
      $date_publications = new DateTime();
      $dates = $date_publications->format('Y-m-d H:i:s'); // Format pour MySQL

      if (updateDateAppelOffre($db, $entreprise_id, $users_id, $dates)) {

      }

      if (post_TMPMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date)) {
      }

      // Récupérer les informations du candidat pour la notification
      $infoUsers = infoUsers($db, $users_id);
      $userName = isset($infoUsers['nom']) ? $infoUsers['nom'] : 'Candidat';

      // Envoyer notification push Firebase
      sendMessageNotification($db, $entreprise_id, $userName, false, $messages);

      // Ancienne méthode de notification conservée pour compatibilité
      if (notification_message($db, $entreprise_id, $users_id)) {
        # code...
      }

      postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date);

      $_SESSION['success_message'] = 'Message envoyé';
      header("Location: get_message_users2.php?entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id']);
      exit;
    }
  }
}







if (isset($_GET['offres_id'])) {

  if (isset($_SESSION['compte_entreprise'])) {

    $afficheMessage1 = getMessage1($db, $_SESSION['compte_entreprise'], $_GET['offres_id'], $_GET['users_id']);

    if (isset($_POST['envoyer'])) {

      $entreprise_id = $_GET['entreprise_id'];
      $offre_id = $_GET['offres_id'];
      $users_id = $_GET['users_id'];
      if (isset($_GET['statut'])) {
        $statut = $_GET['statut'];
      } else {
        $statut = '';
      }
      $messages = htmlspecialchars(nl2br($_POST['messages']));
      $indicatif = 'recruteur';
      $sujet = 'postulation';
      $date_publication = new DateTime();
      $date_formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM y HH:mm'
      );
      $date = $date_formatter->format($date_publication);

      // Récupérer la date actuelle en format datetime
      $date_publications = new DateTime();
      $dates = $date_publications->format('Y-m-d H:i:s'); // Format pour MySQL

      if (updateDatePostulation($db, $entreprise_id, $users_id, $offre_id, $dates)) {

      }


      if (post_TMPMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date)) {

      }

      // Récupérer les informations de l'entreprise pour la notification
      $infoEntreprise = getEntreprise($db, $entreprise_id);
      $entrepriseName = isset($infoEntreprise['entreprise']) ? $infoEntreprise['entreprise'] : 'Recruteur';

      // Envoyer notification push Firebase
      sendMessageNotification($db, $users_id, $entrepriseName, true, $messages);

      // Ancienne méthode de notification conservée pour compatibilité
      if (notification_messageUsers($db, $entreprise_id, $users_id, $statut, $sujet)) {
        # code...
      }

      postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date);

      $_SESSION['success_message'] = 'Message envoyé';
      header("Location: message_entreprise.php?offres_id=" . $_GET['offres_id'] . "&entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id'] . "&statut=" . $_GET['statut']);
      exit;
    }
  }


  if (isset($_SESSION['users_id'])) {
    $afficheMessage1 = getMessage1($db, $_GET['entreprise_id'], $_GET['offres_id'], $_GET['users_id']);

    if (isset($_POST['envoyer'])) {

      $entreprise_id = $_GET['entreprise_id'];
      $offre_id = $_GET['offres_id'];
      $users_id = $_GET['users_id'];
      if (isset($_GET['statut'])) {
        $statut = $_GET['statut'];
      } else {
        $statut = '';
      }
      $messages = htmlspecialchars(nl2br($_POST['messages']));
      $indicatif = 'candidat';
      $sujet = 'postulation';
      $date_publication = new DateTime();
      $date_formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM y HH:mm'
      );
      $date = $date_formatter->format($date_publication);

      // Récupérer la date actuelle en format datetime
      $date_publications = new DateTime();
      $dates = $date_publications->format('Y-m-d H:i:s'); // Format pour MySQL

      if (updateDatePostulation($db, $entreprise_id, $users_id, $offre_id, $dates)) {

      }

      if (post_TMPMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date)) {

      }

      // Récupérer les informations du candidat pour la notification
      $infoUsers = infoUsers($db, $users_id);
      $userName = isset($infoUsers['nom']) ? $infoUsers['nom'] : 'Candidat';

      // Envoyer notification push Firebase
      sendMessageNotification($db, $entreprise_id, $userName, false, $messages);

      // Ancienne méthode de notification conservée pour compatibilité
      if (notification_message($db, $entreprise_id, $users_id)) {
        # code...
      }
      // Enregistrer le message dans la base de données
      if (postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date)) {
        $_SESSION['success_message'] = 'Message envoyé';
        ob_start();
        header("Location: get_message_users.php?users_id=" . $_GET['users_id'] . "&offres_id=" . $_GET['offres_id'] . "&entreprise_id=" . $_GET['entreprise_id'] . "&statut=" . $_GET['statut']);
        exit();
      } else {
        $_SESSION['error_message'] = 'Erreur lors de l\'enregistrement du message';
        ob_start();
        header("Location: get_message_users.php?users_id=" . $_GET['users_id'] . "&offres_id=" . $_GET['offres_id'] . "&entreprise_id=" . $_GET['entreprise_id'] . "&statut=" . $_GET['statut']);
        exit();
      }
    }
  }
}

if (isset($_GET['id'])) {
  if (isset($_POST['sende'])) {

    $entreprise_id = $_SESSION['compte_entreprise'];
    $offre_id = '';
    $users_id = $_GET['id'];
    $statut = '';
    $messages = nl2br($_POST['message']);
    $indicatif = 'recruteur';
    $sujet = 'appel';
    $date_publication = new DateTime();
    $date_formatter = new IntlDateFormatter(
      'fr_FR',
      IntlDateFormatter::LONG,
      IntlDateFormatter::NONE,
      'Europe/Paris',
      IntlDateFormatter::GREGORIAN,
      'EEEE d MMMM y HH:mm'
    );
    $date = $date_formatter->format($date_publication);


    $titre = htmlspecialchars($_POST['titre']);
    if (postAppelOffre($db, $entreprise_id, $users_id, $titre, $messages, $sujet)) {

      $infoUsers = infoUsers($db, $users_id);
      $utilisateur = $infoUsers['nom'];
      $destinataire = $infoUsers['mail'];

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

        $infoEntreprises = getEntreprise($db, $entreprise_id);
        $infoUsers = infoUsers($db, $users_id);
        $utilisateur = $infoUsers['nom'];
        $destinataire = $infoUsers['mail'];
        $entreprise = $infoEntreprises['entreprise'];

        // Contenu de l'e-mail
        $sujet = 'Appel d\'offre';
        $message = "
               <!DOCTYPE html>
               <html>
               <head>
                   <meta charset='utf-8'>
                   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                   <title>Appel d'offre</title>
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
                           background-color: #ff6b35;
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
                           color: #ff6b35;
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
                           background-color: #fff5f0;
                           border-left: 4px solid #ff6b35;
                           padding: 15px 20px;
                           margin: 25px 0;
                           color: #333333;
                       }
                       .highlight-box h3 {
                           font-size: 16px;
                           margin-bottom: 10px;
                           color: #ff6b35;
                       }
                       .button {
                           display: inline-block;
                           background-color: #ff6b35;
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
                           color: #ff6b35;
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
                           <div class='greeting'>Bonjour $utilisateur,</div>
                           <div class='email-title'>Félicitations ! Vous avez été sélectionné pour un poste</div>
                           
                           <div class='highlight-box'>
                               <h3>Poste : $titre</h3>
                           </div>
                           
                           <p class='email-text'>Nous avons le plaisir de vous informer que vous avez été sélectionné pour le poste de <strong>$titre</strong> au sein de notre entreprise.</p>
                           
                           <p class='email-text'>Nous apprécions votre intérêt pour cette opportunité et nous sommes impatients de vous accueillir dans notre équipe.</p>
                           
                           <p class='email-text'>Veuillez vous connecter à votre compte sur Work-Flexer pour consulter les détails de l'offre et accepter notre proposition :</p>
                           
                           <a href='https://work-flexer.com/page/user_profil.php' class='button'>Accéder à mon compte</a>
                           
                           <p class='note'>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Nous sommes là pour vous aider à faciliter le processus d'intégration.</p>
                           
                           <div class='signature'>
                               <p class='email-text'>Cordialement,</p>
                               <p class='signature-name'>L'équipe de recrutement de $entreprise</p>
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


        $mail->clearAddresses();
        $mail->addAddress($destinataire);
        $mail->send();

        if (post_TMPMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date)) {

        }

        // Envoyer une notification push en plus de l'email
        sendMessageNotification($db, $users_id, $entreprise, true, "Appel d'offre: $titre");

        // Ancienne méthode de notification conservée pour compatibilité
        if (notification_messageUsers($db, $entreprise_id, $users_id, $statut, $sujet)) {
          # code...
        }

        postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif, $sujet, $date);

        $_SESSION['success_message'] = " Appel D'offres envoyé!";
        header('Location: ../entreprise/message.php');
        exit();
      } catch (Exception $e) {
        $_SESSION['error_message'] = 'Une erreur c\'est produit !!';
        header('Location: ../entreprise/message.php');
        exit();
      }
    }
  }
}

if (isset($_GET['suprime'])) {

  if (isset($_SESSION['users_id'])) {
    $message_id = $_GET['suprime'];
    if (deletMessage($db, $message_id)) {
      $_SESSION['success_message'] = 'Message supprimé';

      if (isset($_GET['offres_id']) && isset($_GET['entreprise_id']) && isset($_GET['statut']) && isset($_GET['users_id'])) {
        // Retirer 'suprime' du tableau $_GET
        unset($_GET['suprime']);
        header("Location: get_message_users.php?offres_id=" . $_GET['offres_id'] . "&entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id'] . "&statut=" . $_GET['statut']);
        exit();
      }

      if (isset($_GET['entreprise_id']) && isset($_GET['users_id'])) {
        // Retirer 'suprime' du tableau $_GET
        unset($_GET['suprime']);
        header("Location: get_message_users2.php?entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id']);
        exit();
      }
    }
  }


  if (isset($_SESSION['compte_entreprise'])) {
    $message_id = $_GET['suprime'];
    if (deletMessage($db, $message_id)) {
      $_SESSION['success_message'] = 'Message supprimé';
      if (isset($_GET['offres_id']) && isset($_GET['entreprise_id']) && isset($_GET['statut']) && isset($_GET['users_id'])) {
        // Retirer 'suprime' du tableau $_GET
        unset($_GET['suprime']);
        header("Location: message_entreprise.php?offres_id=" . $_GET['offres_id'] . "&entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id'] . "&statut=" . $_GET['statut']);
        exit();
      }

      if (isset($_GET['entreprise_id']) && isset($_GET['users_id'])) {
        // Retirer 'suprime' du tableau $_GET
        unset($_GET['suprime']);
        header("Location: message_entreprise2.php?entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id']);
        exit();
      }
    }
  }
}

if (isset($_SESSION['compte_entreprise'])) {
  $afficheNotificationMessage = get_message($db, $_SESSION['compte_entreprise']);
  $countafficheNotificationMessage = count($afficheNotificationMessage);

  $afficheNotificationPostulation = get_notificationPostulation($db, $_SESSION['compte_entreprise']);
  $countnotificationPostulation = count($afficheNotificationPostulation);
}

if (isset($_SESSION['users_id'])) {
  $notif_users = get_messageUsers($db, $_SESSION['users_id']);
  $count_notif_users = count($notif_users);

  $notif_suivi = get_notif_suiviAccepter($db, $_SESSION['users_id']);
  $count_notif_suivi = count($notif_suivi);


  $notif_suiviRecaler = get_notif_suiviRecaler($db, $_SESSION['users_id']);
  $count_notif_suiviRecaler = count($notif_suiviRecaler);
}

$afficheAutreMessageEntreprise = getAutreMessageEntreprise($db, );


if (isset($_GET['users_id']) and isset($_GET['entreprise_id'])) {

  if (isset($_SESSION['users_id'])) {
    deletTMP_Message4($db, $_GET['entreprise_id'], $_GET['users_id']);
  }

  if (isset($_SESSION['compte_entreprise'])) {
    deletTMP_Message3($db, $_GET['entreprise_id'], $_GET['users_id']);
  }


}
