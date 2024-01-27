<?php 

require_once(__DIR__. '/../model/postulation.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';


if (isset($_SESSION['compte_entreprise'])) {
    $getALLpostulation= getALLPostulation($db,$_SESSION['compte_entreprise']);
    
    // $offre_id = $getALLpostulation['offre_id'];

    // $affichePostulant=affichePostulant($db,$offre_id);
}

if (isset($_GET['id'])) {
    if (isset($_SESSION['users_id'])) {
        $getPostulation=getPostulation($db,$_SESSION['users_id'],$_GET['id']);
    }
}


if (isset($_SESSION['users_id'])) {

  if(isset($_POST['postuler'])){
    $entreprise_id=$offre_id=$users_id=$nom=$mail=$phone=$competances=$profession='';

    $offre_id = $_GET['id'] ;

    $Offres =getOffres($db, $offre_id );

    $poste = $Offres['poste'];

    $entreprise_id= $Offres['entreprise_id'];

    $users_id = $_POST['id_users'];

    $nom = $_POST['nom_users'];

    $mail = $_POST['mail_users'];

    $phone = $_POST['phone_users'];

    $competences= $_POST['competence_users'];

    $profession = $_POST['profession_users'];

    $images = $_POST['images_users'];

    if (postCandidature($db,$entreprise_id,$poste,$offre_id,$users_id,$nom,$mail,$phone,$competences,$profession, $images)) {
        

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

              $infoEntreprises = getEntreprise($db,$entreprise_id);
              $destinataire = $infoEntreprises['mail'];
              $entreprise = $infoEntreprises['entreprise'];
                   
                     // Contenu de l'e-mail
               $sujet = 'Postulation : Nouveau candidat pour votre offre';
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
                }
                .container .box2{
                  margin: 0 auto;
                 
                }
                .container .box2 h2{
                text-align: center;
                padding:5px 40px;
                  color: blue;
                  text-transform: uppercase;
                  width: 50%;
                  margin: 20px auto;
                  font-size: 20px;
                  border-radius: 20px;
                  background-color: red;
                }
                .container .box2 P{
                text-align: start;
                  padding: 5px 19px;
                  width: 60%;
                  margin: 0 auto;
                  font-size: 17px;
                  color: black;
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
                background-color: rgb(23, 0, 201);
                color: #ffffff;
                text-decoration: none;
                font-size: 15px;
                }
                .container .box2 P strong {
                  background-color: yellow;
                }
                </style>
               </head>
               <body>
               
               <div class='container'>
                 <div class='box1'>
                 </div>
               
                 <div class='box2'>
                   <h1>helo! $entreprise  </h1>
                   <h2>Nouvelle postulation</h2>
                   <h3><strong>Poste :</strong> $poste </h3>
                   <p>Un candidat potentiel vient de postuler a votre offre d'emploi au poste de </strong> $poste </h3>  connecter vous vite  et traiter cette demande en un click </p>
                   <p> Connectez vous a l'address <a href='https://work-flexer.com/entreprise/entreprise_profil.php'>https://work-flexer.com/entreprise/entreprise_profil</a></p>
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
               

               $_SESSION['success_message']='Postulation réussi !!';
        
        header('Location: ../page/user_profil.php');
        exit();
               
           } catch (Exception $e) {
            header('Location: ../page/user_profil.php');
               exit();
           }
       
       
       
    }
    
}
    
    $getPostulationUsers=getPostulationUsers($db,$_SESSION['users_id']);
}
?>