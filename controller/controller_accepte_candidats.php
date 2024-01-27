<?php 
require_once(__DIR__. '/../model/accepte_candidats.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_GET['accepter'])) {
$poste_id = $_GET['accepter'];
$statut='accepter';

$postulation = affichePostulant($db,$poste_id);

$nom = $postulation['nom'];
$poste = $postulation['poste'];

    if (AccepteCandidats($db,$statut,$poste_id)) {


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

       //     //   $infoEntreprises = getEntreprise($db,$entreprise_id);
             $destinataire = $postulation['mail'];
       //     //   $entreprise = $infoEntreprises['entreprise'];
                  
                    // Contenu de l'e-mail
              $sujet = 'Suivi de candidature';
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
   width: 100%;
   flex-direction: column;
 }
 .container .box1{
   width: 240px;
   margin: 20px auto;
   position: relative;
   height: 240px;
   background-image: url(/image/WF__2_.png);
   background-color: blue;
   background-position: center;
   background-size: cover;
   border-radius: 7px;

 }

 
 .container .box2 h1{
   margin: 0 auto;
   width: 70%;
   background-color: black;
   color: #ffffff;
   text-align: center;
   padding: 5px 30px;
   border-radius: 20px;
   font-size: 20px;
 }
 .container .box2{
   margin: 0 auto;
   background-color: #ebeaea;
   padding: 40px 0;
   border: 2px solid #c2c2c2;
   min-width: 400px;
   width: 700px;
   max-width: 600px;
   border-radius: 10px;
 }
 .container .box2 h2{
 text-align: center;
 padding:5px 40px;
   color: #ffffff;
   text-transform: uppercase;
   width: 50%;
   margin: 20px auto;
   font-size: 17px;
   border-radius: 10px;
   background-color: #6ce000;
 }
 .container .box2 P{
 text-align: start;
   
   width: 90%;
   margin: 0 auto;
   font-size: 16px;
   color: black;
   line-height: 25px;
 }
 .container .box2 h3{
 text-align: start;
   width: 40%;
   margin: 0 auto;
   font-size: 20px;
 }
 .container .box2 a{
 padding: 0px 15px;
 border-radius: 7px;
 background-color: rgb(23, 0, 201);
 color: #ffffff;
 text-decoration: none;
 font-size: 15px;
 }
 .container .box2 P strong {
   background-color: yellow;
 }

 @media only screen and (max-width: 400px) {

  .container .box2 h1{
   margin: 0 auto;
   width: 80%;
   
 }
 .container .box2{
   margin: 0 auto;
   background-color: #ebeaea;
   padding: 40px 0;
   border: 2px solid #c2c2c2;
   min-width: 300px;
   width: 400px;
   max-width: 600px;
  
 }
 
 
 
}
 </style>
              </head>
              <body>
              
              <div class='container'>
                <div class='box1'>
                </div>
              
                <div class='box2'>
                  <h1>helo! $nom  </h1>
                  <h2>Candidature recaler !!</h2>
                  <h3><strong>Poste :</strong> $poste </h3>
                  <p>Nous sommes heureux de vous annoncer que votre candidature au poste de <strong>$poste</strong> a ete accepter.</p>
                  <p> Connectez vous ici a l'address : <br><a href='https://work-flexer.com'>https://work-flexer.com</a><br> pour discuter des différentes demarche et rendez-vous</p>
                </div>
              </div>
              
              </body>
              </html> " ;

              $mail->setFrom('noreply-service@work-flexer.com', 'work-flexer');
              $mail->isHTML(true);
              $mail->Subject = $sujet;
              $mail->Body = $message;

                 
                  $mail->clearAddresses();
                  $mail->addAddress($destinataire);
                  $mail->send();
              
                  $_SESSION['success_message']='Candidat accepter avec succès!!';
       header('Location: ../page/candidature.php');
       exit();
              
          } catch (Exception $e) {
           header('Location: ../page/candidature.php');
                  exit();
          }
       
    }

}

if (isset($_GET['recaler']) ) {
    $poste_id = $_GET['recaler'];
    $statut='recaler';

    $postulation = affichePostulant($db,$poste_id);

    $nom = $postulation['nom'];
    $poste = $postulation['poste'];
        if (recalerCandidats($db,$statut,$poste_id)) {
           
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

        //     //   $infoEntreprises = getEntreprise($db,$entreprise_id);
              $destinataire = $postulation['mail'];
        //     //   $entreprise = $infoEntreprises['entreprise'];
                   
                     // Contenu de l'e-mail
               $sujet = 'Suivi de candidature';
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
                 width: 100%;
                 flex-direction: column;
               }
               .container .box1{
                 width: 240px;
                 margin: 20px auto;
                 position: relative;
                 height: 240px;
                 background-image: url(/image/WF__2_.png);
                 background-color: blue;
                 background-position: center;
                 background-size: cover;
                 border-radius: 7px;
              
               }
              
               
               .container .box2 h1{
                 margin: 0 auto;
                 width: 70%;
                 background-color: black;
                 color: #ffffff;
                 text-align: center;
                 padding: 5px 30px;
                 border-radius: 20px;
                 font-size: 20px;
               }
               .container .box2{
                 margin: 0 auto;
                 background-color: #ebeaea;
                 padding: 40px 0;
                 border: 2px solid #c2c2c2;
                 min-width: 400px;
                 width: 700px;
                 max-width: 600px;
                 border-radius: 10px;
               }
               .container .box2 h2{
               text-align: center;
               padding:5px 40px;
                 color: #ffffff;
                 text-transform: uppercase;
                 width: 50%;
                 margin: 20px auto;
                 font-size: 17px;
                 border-radius: 10px;
                 background-color: #f80000;
               }
               .container .box2 P{
               text-align: start;
                 
                 width: 90%;
                 margin: 0 auto;
                 font-size: 16px;
                 color: black;
                 line-height: 25px;
               }
               .container .box2 h3{
               text-align: start;
                 width: 40%;
                 margin: 0 auto;
                 font-size: 20px;
               }
               .container .box2 a{
               padding: 0px 15px;
               border-radius: 7px;
               background-color: rgb(23, 0, 201);
               color: #ffffff;
               text-decoration: none;
               font-size: 15px;
               }
               .container .box2 P strong {
                 background-color: yellow;
               }
              
               @media only screen and (max-width: 400px) {
              
                .container .box2 h1{
                 margin: 0 auto;
                 width: 80%;
                 
               }
               .container .box2{
                 margin: 0 auto;
                 background-color: #ebeaea;
                 padding: 40px 0;
                 border: 2px solid #c2c2c2;
                 min-width: 300px;
                 width: 400px;
                 max-width: 600px;
                
               }
               
               
               
              }
               </style>
               </head>
               <body>
               
               <div class='container'>
                 <div class='box1'>
                 </div>
               
                 <div class='box2'>
                   <h1>Helo! $nom  </h1>
                   <h2>Candidature recaler !!</h2>
                   <h3><strong>Poste :</strong> $poste </h3>
                   <p>Nous sommes dans le regret de vous annoncer que votre candidature au poste de <strong>$poste</strong> a ete recaler.</p>
                   <p> Connectez vous ici a l'address : <br><a href='https://work-flexer.com'>https://work-flexer.com</a><br> pour postuler a d'autre offre d'emploie correspondant a votre profil </p>
                 </div>
               </div>
               
               </body>
               </html> " ;

               $mail->setFrom('noreply-service@work-flexer.com', 'work-flexer');
               $mail->isHTML(true);
               $mail->Subject = $sujet;
               $mail->Body = $message;

                  
                   $mail->clearAddresses();
                   $mail->addAddress($destinataire);
                   $mail->send();
               
                   $_SESSION['success_message']='Candidat recaler avec succès!!';
                   header('Location: ../page/candidature.php');
                   exit();
               
           } catch (Exception $e) {
            header('Location: ../page/candidature.php');
                   exit();
           }
          
        }
    
    }

// $getAccepteCandidat= getAccepteCandidat($db,$_SESSION['compte_entreprise'])
?>