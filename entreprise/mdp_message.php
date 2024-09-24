<?php
session_start();

// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_SESSION['entreprise'])) {
  // L'utilisateur est connecté, récupérez son ID
  $entreprise_id = $_SESSION['entreprise'];

  // Maintenant, vous pouvez utiliser $users_id pour récupérer les informations de l'utilisateur depuis la base de données
  // Écrivez votre requête SQL pour récupérer les informations nécessaires
  $conn = "SELECT * FROM compte_entreprise WHERE id = :entreprise_id";
  $stmt = $db->prepare($conn);
  $stmt->bindParam(':entreprise_id', $entreprise_id);
  $stmt->execute();
  $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);
} else {

}

if (isset($_GET['id'])) {


  $entreprise_id = $_GET['id'];
  // Écrivez votre requête SQL pour récupérer les informations nécessaires
  $conn = "SELECT * FROM compte_entreprise WHERE id = :entreprise_id";
  $stmt = $db->prepare($conn);
  $stmt->bindParam(':entreprise_id', $entreprise_id);
  $stmt->execute();
  $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);

  $entreprise_id = $entreprise['id'];
  $code_verification = rand(100000, 999999);


  // Vérifier si un code de vérification existe déjà
  $sql_check = "SELECT * FROM verification_entreprise WHERE entreprise_id = :entreprise_id";
  $stmt_check = $db->prepare($sql_check);
  $stmt_check->bindParam(':entreprise_id', $entreprise_id);
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

    $destinataire = $entreprise['mail'];
    $nom = $entreprise['nom'];

    // Contenu de l'e-mail
    $sujet = 'Récupération de mot de passe'; // Correction de l'orthographe
    $message = "
          <!DOCTYPE html>
          <html>
          <head><meta charset='utf-8'>
          <style>
          *{
            padding: 0;
            margin: 0%;
          font-family: Verdana, Geneva, Tahoma, sans-serif;
          }
        
          .container{
            width: 600px;
            margin:0 auto;
            border: 1px solid #6b6a6a;
            border-radius: 10px;
            padding: 40px;
          }
        
          .container .box2{
              width: 500px;
          }
          .container .box2 h1{
            width: 100%;
            background-color: rgb(255, 255, 255);
            color: #000000;
            text-align: center;
            padding: 5px 20px;
            border-radius: 10px;
            font-size: 18px;
            border: 1px solid #6b6a6a;
          }
          .container .box2{
            margin: 0 auto;
           
          }
          .container .box2 h2{
          text-align: center;
          padding:5px 20px;
            text-transform: uppercase;
            width: 50%;
            margin: 20px auto;
            font-size: 14px;
            border-radius: 10px;
            background-color: rgb(149, 149, 149);
            color: #ffffff;
            font-weight: 400;
          }
          .container .box2 P{
          text-align: start;
            padding: 5px 19px;
            width: 100%;
            margin: 0 auto;
            font-size: 13px;
            color: black;
            line-height: 23px;
          }
            .container .box2 p strong{
            color: #0044ff; 
            font-weight: bold;  
        }
          .container .box2 h3{
          text-align: start;
            padding: 20px;
            width: 40%;
            margin: 0 auto;
            font-size: 20px;
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
            <div class='box1'>
            </div>
          
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
          </html>  ";

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
      $sql = "UPDATE verification_entreprise SET code = :code WHERE entreprise_id = :entreprise_id";
    } else {
      // Insérer un nouveau code de vérification si l'entrée n'existe pas
      $sql = "INSERT INTO verification_entreprise (entreprise_id , code) VALUES (:entreprise_id,:code)";
    }
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":entreprise_id", $entreprise_id);
    $stmt->bindParam(":code", $code_verification);
    $stmt->execute();


    header('Location: verification.php');
    exit();

  } catch (Exception $e) {
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


  <section class="section2">

    <div class="container">
      <h2>Compte trouvé !</h2> // Correction de l'orthographe

      <div class="box">
        <img src="../upload/<?= $entreprise['images'] ?>" alt="">
        <p><?= $entreprise['nom'] ?></p>
      </div>

      <a href="../entreprise/mdp_oublier.php">
        <p class="p">Ce n'est pas votre compte ?</p>
      </a> // Correction de l'orthographe

      <a class="aa" href="?id=<?= $entreprise['id'] ?>">Modifier le mot de passe</a>
    </div>

  </section>


</body>

</html>