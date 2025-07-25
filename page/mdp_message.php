<?php
session_start();

// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_SESSION['users'])) {
  // L'utilisateur est connecté, récupérez son ID
  $users_id = $_SESSION['users'];

  // Maintenant, vous pouvez utiliser $users_id pour récupérer les informations de l'utilisateur depuis la base de données
  // Écrivez votre requête SQL pour récupérer les informations nécessaires
  $conn = "SELECT * FROM users WHERE id = :users_id";
  $stmt = $db->prepare($conn);
  $stmt->bindParam(':users_id', $users_id);
  $stmt->execute();
  $users = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  // L'utilisateur n'est pas connecté, gérez ce cas ici (redirection, message d'erreur, etc.)
  // Par exemple, vous pouvez rediriger vers la page de connexion

}

if (isset($_GET['id'])) {
  $users_id = $_GET['id'];

  // Récupérer les informations de l'utilisateur
  $conn = "SELECT * FROM users WHERE id = :users_id";
  $stmt = $db->prepare($conn);
  $stmt->bindParam(':users_id', $users_id);
  $stmt->execute();
  $users = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($users) {
    $users_id = $users['id'];
    $code_verification = rand(100000, 999999);

    // Vérifier si un code de vérification existe déjà
    $sql_check = "SELECT * FROM verification_users WHERE users_id = :users_id";
    $stmt_check = $db->prepare($sql_check);
    $stmt_check->bindParam(':users_id', $users_id);
    $stmt_check->execute();
    $existing_code = $stmt_check->fetch(PDO::FETCH_ASSOC);

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
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        ]
      ];

      $mail->MessageID = "<" . md5(uniqid()) . "@work-flexer.com>";
      $mail->Host = gethostbyname('mail.work-flexer.com');


      $destinataire = $users['mail'];
      $nom = $users['nom'];

      // Contenu de l'e-mail
      $sujet = 'Récupération de mot de passe';
      $message = "
          <!DOCTYPE html>
          <html>
          <head>
              <meta charset='utf-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Récupération de mot de passe</title>
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
                  .verification-code {
                      background-color: #f0f7ff;
                      border-left: 4px solid #0671dc;
                      padding: 15px 20px;
                      margin: 25px 0;
                      font-size: 24px;
                      font-weight: 600;
                      letter-spacing: 2px;
                      color: #0671dc;
                      text-align: center;
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
                      .verification-code {
                          font-size: 20px;
                          padding: 12px 15px;
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
                      <div class='email-title'>Demande de réinitialisation de mot de passe</div>
                      <p class='email-text'>Nous avons reçu une demande de réinitialisation du mot de passe pour votre compte Work-Flexer. Pour poursuivre cette procédure, veuillez utiliser le code de vérification ci-dessous.</p>
                      
                      <div class='verification-code'>$code_verification</div>
                      
                      <p class='email-text'>Ce code est valable pendant 30 minutes. Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet e-mail en toute sécurité.</p>
                      
                      <p class='note'>Pour des raisons de sécurité, ne partagez jamais ce code avec qui que ce soit, y compris le personnel de Work-Flexer. Notre équipe ne vous demandera jamais votre code de vérification.</p>
                      
                      <div class='signature'>
                          <p class='email-text'>Cordialement,</p>
                          <p class='signature-name'>L'équipe Work-Flexer</p>
                          <p class='signature-title'>Support technique et sécurité</p>
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
          </html>";

      $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
      $mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');
      $mail->isHTML(true);
      $mail->Subject = $sujet;
      $mail->Body = $message;
      $mail->CharSet = 'UTF-8'; // Ajout pour l'encodage


      $mail->clearAddresses();
      $mail->addAddress($destinataire);
      $mail->send();


      if ($existing_code) {
        // Mettre à jour le code de vérification si l'entrée existe
        $sql = "UPDATE verification_users SET code = :code WHERE users_id = :users_id";
      } else {
        // Insérer un nouveau code de vérification si l'entrée n'existe pas
        $sql = "INSERT INTO verification_users (users_id, code) VALUES (:users_id, :code)";
      }
      $stmt = $db->prepare($sql);
      $stmt->bindParam(":users_id", $users_id, PDO::PARAM_INT);
      $stmt->bindParam(":code", $code_verification, PDO::PARAM_INT);
      $stmt->execute();

      header('Location: ../page/verification.php');
      exit();

    } catch (Exception $e) {
      // Gestion des erreurs d'envoi d'email
      $_SESSION['error_message'] = 'Une erreur est survenue lors de l\'envoi de l\'e-mail.';
      header('Location: mdp_message.php');
      exit();
    }
  } else {
    $_SESSION['error_message'] = 'Utilisateur non trouvé.';
    header('Location: mdp_message.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Tag Manager -->
  <script>(function (w, d, s, l, i) {
      w[l] = w[l] || []; w[l].push({
        'gtm.start':
          new Date().getTime(), event: 'gtm.js'
      }); var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
  <!-- End Google Tag Manager -->

  <title>Compte trouvé - Récupération de mot de passe</title>
  <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/navbare.css">
  <link rel="stylesheet" href="/css/connexion.css">
</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <?php include('../navbare.php') ?>

  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="error-message" id="errorMessage">
      <i class="fas fa-exclamation-circle"></i>
      <span><?php echo $_SESSION['error_message']; ?></span>
      <?php unset($_SESSION['error_message']); ?>
    </div>
  <?php endif; ?>

  <section class="login-section">
    <div class="login-container">


      <div class="login-form-container">
        <div class="login-header">
          <h2>Compte trouvé !</h2>
          <p>Nous avons trouvé votre compte. Confirmez qu'il s'agit bien de vous.</p>
        </div>

        <div class="account-found">
          <div class="user-profile">
            <img src="../upload/<?= $users['images'] ?>" alt="Photo de profil" class="profile-image">
            <h3><?= $users['nom'] ?></h3>
          </div>

          <div class="form-actions">
            <a href="?id=<?= $users['id'] ?>" class="submit-button">
              <i class="fas fa-key"></i>Réinitialiser le mot de passe
            </a>

            <div class="separator">ou</div>

            <a href="../page/mdp_oublier.php" class="register-button">
              <i class="fas fa-user-times"></i>Ce n'est pas mon compte
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    .account-found {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      padding: 20px 0;
    }

    .user-profile {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }

    .profile-image {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--primary-color);
      box-shadow: var(--shadow-md);
    }

    .user-profile h3 {
      font-size: 18px;
      font-weight: 600;
      color: var(--secondary-color);
    }
  </style>

  <script>
    // Animation pour les messages d'erreur en haut de page
    const errorMessage = document.getElementById('errorMessage');

    if (errorMessage) {
      setTimeout(() => {
        errorMessage.classList.add('visible');
      }, 200);
      setTimeout(() => {
        errorMessage.classList.remove('visible');
      }, 6000);
    }

    // Ajustement pour les appareils mobiles
    window.addEventListener('resize', function () {
      if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
        document.activeElement.scrollIntoView({ behavior: 'smooth' });
      }
    });
  </script>
</body>

</html>