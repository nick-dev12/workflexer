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
<h1>Bonjour $entreprise,</h1>
<h2>Nouvelle candidature reçue !</h2>
<h3><strong>Poste :</strong> $poste</h3>
<p>Nous avons le plaisir de vous informer qu'un candidat potentiel vient de postuler à votre offre d'emploi pour le poste de <strong>$poste</strong>.</p>
<p>Nous vous encourageons à vous connecter dès maintenant pour examiner cette candidature et prendre les mesures appropriées.</p>
<p>Connectez-vous à votre espace entreprise sur Work-Flexer pour traiter cette candidature :</p>
<p><a href='https://work-flexer.com/entreprise/entreprise_profil.php'>Accéder à votre espace entreprise</a></p>
<p>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Nous sommes là pour vous aider dans votre processus de recrutement.</p>
<p>Cordialement,<br>L'équipe Work-Flexer</p>
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