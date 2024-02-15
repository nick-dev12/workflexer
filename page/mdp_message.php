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

if(isset($_GET['id'])){
   

$users_id = $_GET['id'];
      // Écrivez votre requête SQL pour récupérer les informations nécessaires
  $conn = "SELECT * FROM users WHERE id = :users_id";
  $stmt = $db->prepare($conn);
  $stmt->bindParam(':users_id', $users_id);
  $stmt->execute();
  $users = $stmt->fetch(PDO::FETCH_ASSOC);

  $users_id = $users['id'];
  $code_verification = rand(100000, 999999);

  $sql = "INSERT INTO verification_users (users_id , code) VALUES (:users_id,:code)";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":users_id", $users_id);
  $stmt->bindParam(":code", $code_verification);
  $stmt->execute();

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
       
         $destinataire = $users['mail'];
         $nom = $users['nom'];
              
                // Contenu de l'e-mail
          $sujet = 'Recuperation de mo de passe';
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
          .container .box1{
            width: 200px;
            margin: 20px auto;
            position: relative;
            height: 180px;
            background-image: url(/image/WF__2_.png);
            background-color: blue;
            background-position: center;
            background-size: cover;
            border-radius: 7px;
        
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
            font-size: 25px;
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
            font-size: 20px;
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
            font-size: 16px;
            color: black;
            line-height: 23px;
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
              <h1>helo! $nom </h1>
              <h2>demande de réinitialisation de mot d passe</h2>
              <p>Vous avez demandé une réinitialisation de mot de passe au nom de $nom</p>
              <br><p> Entrer le code suivant : <strong>$code_verification</strong> </p>
            </div>
          </div>
          
          </body>
          </html>  " ;

          $mail->setFrom('noreply-service@work-flexer.com', 'work-flexer');
          $mail->isHTML(true);
          $mail->Subject = $sujet;
          $mail->Body = $message;
             
              $mail->clearAddresses();
              $mail->addAddress($destinataire);
              $mail->send();
         
   
          header('Location: ../page/verification.php');
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
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5JBWCPV7');</script>
<!-- End Google Tag Manager -->

  <title>Recuperation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/navbare.css">
  <link rel="stylesheet" href="/css/mdp_message.css">
</head>

<body>
  
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php include ('../navbare.php') ?>
  

  <section class="section2">

  <div class="container">
    <h2>Compte trouver !</h2>

    <div class="box">
        <img src="../upload/<?= $users['images'] ?>" alt="">
        <p><?= $users['nom'] ?></p>
    </div>

    <p class="p">ce n'est pas votre compte ?</p>

    <a href="?id=<?= $users['id'] ?>">Modifier le mot de passe</a>
  </div>

  </section>


</body>

</html>