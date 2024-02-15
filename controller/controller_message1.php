<?php
include(__DIR__ . ' /../model/message1.php');
require_once(__DIR__ . '/../model/appelle_offre.php');
include('../entreprise/app/controller/controllerEntreprise.php');

// include('../model/vue_offre.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

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

      if (postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif)) {
        // Assurez-vous de terminer le script après la redirection
      }
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

      if (postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif)) {
        // Assurez-vous de terminer le script après la redirection
      }
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

      if (postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif)) {
        // Assurez-vous de terminer le script après la redirection
      }
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

      if (postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif)) {

      }
      header("Location: get_message_users.php?offres_id=" . $_GET['offres_id'] . "&entreprise_id=" . $_GET['entreprise_id'] . "&users_id=" . $_GET['users_id'] . "&statut=" . $_GET['statut']);
      exit();
    }
  }
}

if (isset($_GET['id'])) {
  if (isset($_POST['send'])) {

    $entreprise_id = $_SESSION['compte_entreprise'];
    $offre_id = '';
    $users_id = $_GET['id'];
    $statut = '';
    $messages = nl2br($_POST['message']);
    $indicatif = 'recruteur';

    if (postMessage1($db, $entreprise_id, $users_id, $offre_id, $statut, $messages, $indicatif)) {

    }

    $titre = htmlspecialchars($_POST['titre']);
    if (postAppelOffre($db, $entreprise_id, $users_id, $titre, $messages)) {

      $infoUsers = infoUsers($db, $users_id);
      $utilisateur = $infoUsers['nom'];
      $destinataire = $infoUsers['mail'];

      // Créez l'instance PHPMailer
      $mail = new PHPMailer(true);

      try {
        // Paramètres SMTP
        $mail->isSMTP();
        $mail->Host = 'work-flexer.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply-service@work-flexer.com';
        $mail->Password = 'Ludvanne12'; // Remplacez par le mot de passe de votre compte e-mail
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $infoEntreprises = getEntreprise($db, $entreprise_id);
        $destinataire = $infoUsers['mail'];
        $entreprise = $infoEntreprises['entreprise'];

        // Contenu de l'e-mail
        $sujet = 'Félicitations ! Vous avez été sélectionné';
        $message = "
               <!DOCTYPE html>
               <html>
               <head><meta charset='utf-8'>
               <style>
               body{
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .box1 {
                width: 300px;
                text-align: center;
                margin: 0 auto;
                border-radius: 10px;
            }
            
            .box1 img {
                max-width: 100%;
                height: auto;
                border-radius: 10px;
            }
            
            .box2 {
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 10px;
                border: 1px solid #ccc;
                width: 60%;
                margin: 0 auto;
            }
            
            h1 {
                font-size: 24px;
                margin-bottom: 10px;
            }
            
            h2 {
                font-size: 20px;
                color: #007bff;
                margin-bottom: 15px;
            }
            
            h3 {
                font-size: 18px;
                margin-bottom: 15px;
            }
            
            p {
                font-size: 16px;
                margin-bottom: 15px;
            }
            
            a {
                background-color: #007bff;
                color: #ffffff;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                font-size: 16px;
                margin-bottom: 15px;
            }
    
            @media only screen and (max-width: 1000px) {
                .box2 {
                    padding: 15px;
                    width: 80%;
                }
               
            }
            
            @media only screen and (max-width: 600px) {
                .box2 {
                    padding: 15px;
                }
            
                h1 {
                    font-size: 20px;
                    margin-bottom: 8px;
                }
            
                h2 {
                    font-size: 18px;
                    margin-bottom: 12px;
                }
            
                h3 {
                    font-size: 16px;
                    margin-bottom: 12px;
                }
            
                p {
                    font-size: 13px;
                    margin-bottom: 12px;
                }
            
                a {
                    padding: 8px 16px;
                    font-size: 13px;
                    margin-bottom: 12px;
                }
            }
            
               </style>
               </head>
               <body>
              
               <div class='box1'>
    <img src='https://example.com/logo.png' alt='Logo de l'entreprise'>
</div>
<div class='box2'>
    <h1>Bonjour $utilisateur,</h1>
    <h2>Félicitations ! Vous avez été sélectionné pour un poste.</h2>
    <h3><strong>Poste :</strong> $titre</h3>
    <p>Nous avons le plaisir de vous informer que vous avez été sélectionné pour le poste de <strong>$titre</strong> au sein de notre entreprise.</p>
    <p>Nous apprécions votre intérêt pour cette opportunité et nous sommes impatients de vous accueillir dans notre équipe.</p>
    <p>Veuillez vous connecter à votre compte sur Work-Flexer pour consulter les détails de l'offre et accepter notre proposition :</p>
    <p><a href='https://work-flexer.com/candidat/mon_compte.php'>Accéder à votre compte</a></p>
    <p>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Nous sommes là pour vous aider à faciliter le processus d'intégration.</p>
    <p>Cordialement,<br>L'équipe de recrutement de $entreprise</p>
</div>
               </body>
               </html> ";

        $mail->setFrom('noreply-service@work-flexer.com', 'work-flexer');
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $message;


        $mail->clearAddresses();
        $mail->addAddress($destinataire);
        $mail->send();


        $_SESSION['success_message'] = 'Postulation réussi !!';

        header('Location: ../entreprise/message.php');
        exit();

      } catch (Exception $e) {
        $_SESSION['error_message'] = 'Une erreur c\'est produit !!';
        header('Location: ../page/user_profil.php');
        exit();
      }

    }

  }
}

if (isset($_GET['suprime'])) {
  $message_id = $_GET['suprime'];
  if (deletMessage($db, $message_id)) {

    header("Location: ../page/message_users.php");
    exit();
  }
}


$afficheAutreMessageEntreprise = getAutreMessageEntreprise($db, );

?>