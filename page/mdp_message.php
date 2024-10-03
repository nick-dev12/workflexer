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
      $mail->Host = 'advantechgroup.online';
      $mail->SMTPAuth = true;
      $mail->Username = 'info@advantechgroup.online';
      $mail->Password = 'Ludvanne12@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

      $destinataire = $users['mail'];
      $nom = $users['nom'];

      // Contenu de l'e-mail
      $sujet = 'Récupération de mot de passe';
      $message = "
          <!DOCTYPE html>
          <html >
          <head><meta charset='utf-8'>
          <style>
          *{
              padding: 0;
              margin: 0;
              font-family: Verdana, Geneva, Tahoma, sans-serif;
          }
          .container{
              width: 600px;
              margin: 0 auto;
              border: 1px solid #6b6a6a;
              border-radius: 10px;
              padding: 40px;
          }
          
          .container .box2{
              width: 500px;
              margin: 20px 0;
          }
          .container .box2 h1{
              width: 100%;
              background-color: rgb(255, 255, 255);
              color: #000000;
              text-align: center;
              padding: 5px 20px;
              border-radius: 10px;
              font-size: 16px;
              border: 1px solid #6b6a6a;
          }
          .container .box2 h2{
              text-align: center;
              padding: 5px 20px;
              text-transform: uppercase;
              width: 50%;
              margin: 20px auto;
              font-size: 20px;
              border-radius: 10px;
              background-color: rgb(149, 149, 149);
              color: #ffffff;
              font-weight: 400;
              font-size: 14px;
          }
          .container .box2 p{
              text-align: start;
              padding: 5px 19px;
              width: 100%;
              margin: 0 auto;
              font-size: 16px;
              color: black;
              line-height: 20px;
              font-size: 13px;
          }
              .container .box2 p strong{
            color: #0044ff; 
            font-weight: bold;  
        }
          .container .box2 a{
              padding: 5px 15px;
              border-radius: 7px;
              color: #0044ff;
              text-decoration: none;
              font-size: 15px;
          }
          </style>
          </head>
          <body>
          <div class='container'>
              <div class='box1'></div>
              <div class='box2'>
                <h1>Bonjour $nom</h1>
                <h2>Demande de réinitialisation de mot de passe</h2>
                <p>Nous avons reçu une demande de réinitialisation du mot de passe pour votre compte. Si vous êtes à l'origine de cette demande, veuillez utiliser le code de vérification ci-dessous.</p>
                <br><p>Code de vérification : <strong>$code_verification</strong></p>
                <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet e-mail.</p>
                <p>Pour toute question, n'hésitez pas à nous contacter.</p>
                <p>Cordialement,<br>L'équipe de support</p>
              </div>
          </div>
          </body>
          </html>";

      $mail->setFrom('info@advantechgroup.online', 'work-flexer');
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
<html lang="en">

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

  <title>Recuperation</title>
  <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/navbare.css">
  <link rel="stylesheet" href="/css/mdp_message.css">
</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <?php include('../navbare.php') ?>


  <section class="section2">

    <div class="container">
      <h2>Compte trouvé !</h2>

      <div class="box">
        <img src="../upload/<?= $users['images'] ?>" alt="">
        <p><?= $users['nom'] ?></p>
      </div>

      <a href="../page/mdp_oublier.php">
        <p class="p">Ce n'est pas votre compte ?</p>
      </a>

      <a class="aa" href="?id=<?= $users['id'] ?>">Modifier le mot de passe ?</a>
    </div>

  </section>


</body>

</html>