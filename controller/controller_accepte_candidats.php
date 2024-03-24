<?php
require_once(__DIR__ . '/../model/accepte_candidats.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_GET['accepter'])) {
    $poste_id = $_GET['accepter'];
    $statut = 'accepter';

    $postulation = affichePostulant($db, $poste_id);

    $nom = $postulation['nom'];
    $poste = $postulation['poste'];


        // Créez l'instance PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Paramètres SMTP
            $mail->isSMTP();
            $mail->Host = 'mail.privateemail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'service@advantechgroup.online';
            $mail->Password = 'oyonoeffe11@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
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
              <h1>Bonjour $nom,</h1>
              <h2>Confirmation de réception de votre candidature</h2>
              <h3><strong>Poste :</strong> $poste</h3>
              <p>Nous sommes ravis de vous informer que votre candidature pour le poste de <strong>$poste</strong> a été retenue.</p>
              <p>Nous vous invitons à vous connecter à notre plateforme pour discuter des prochaines étapes et fixer un rendez-vous :</p>
              <p><a href='https://work-flexer.com'>Connectez-vous ici</a> pour discuter des démarches à suivre.</p>
          </div>
              
              </body>
              </html> ";

             $mail->setFrom('service@advantechgroup.online', 'work-flexer');
            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;


            $mail->clearAddresses();
            $mail->addAddress($destinataire);
            $mail->send();

            if (AccepteCandidats($db, $statut, $poste_id)){
                 $_SESSION['success_message'] = 'Candidat accepter avec succès!!';
            header('Location: ../page/candidature.php');
            exit();
            }

        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur !';
            header('Location: ../page/candidature.php');
            exit();
        }

    }

if (isset($_GET['recaler'])) {
    $poste_id = $_GET['recaler'];
    $statut = 'recaler';

    $postulation = affichePostulant($db, $poste_id);

    $nom = $postulation['nom'];
    $poste = $postulation['poste'];
        // Créez l'instance PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Paramètres SMTP
            $mail->isSMTP();
            $mail->Host = 'mail.privateemail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'service@advantechgroup.online';
            $mail->Password = 'oyonoeffe11@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
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
               <div class='box2'>
               <h1>Bonjour $nom,</h1>
               <h2>Confirmation de réception de votre candidature</h2>
               <h3><strong>Poste :</strong> $poste</h3>
               <p>Nous vous remercions d'avoir postulé au poste de <strong>$poste</strong>.</p>
               <p>Nous regrettons de vous informer que, après avoir examiné attentivement votre candidature, nous avons décidé de ne pas poursuivre avec votre profil pour ce poste.</p>
               <p>Nous vous encourageons à continuer à rechercher des opportunités d'emploi correspondant à votre profil. Connectez-vous à notre plateforme pour explorer d'autres offres disponibles :</p>
               <p><a href='https://work-flexer.com'>Cliquez ici</a> pour découvrir d'autres offres d'emploi.</p>
           </div>
            
               </body>
               </html> ";

             $mail->setFrom('service@advantechgroup.online', 'work-flexer');
            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;


            $mail->clearAddresses();
            $mail->addAddress($destinataire);
            $mail->send();

            if (recalerCandidats($db, $statut, $poste_id)) {
                 $_SESSION['success_message'] = 'Candidat recaler!';
            header('Location: ../page/candidature.php');
            exit();
            }

           

        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Candidat recaler!';
            header('Location: ../page/candidature.php');
            exit();
        }

    }

// $getAccepteCandidat= getAccepteCandidat($db,$_SESSION['compte_entreprise'])
?>