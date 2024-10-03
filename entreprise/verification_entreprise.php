<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['compte_entreprise']) && $_SESSION['compte_entreprise']) {

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: ../index.php');
    exit();
}




if (isset($_POST['valider'])) {
    $code = '';

    if (empty($_POST['code'])) {
        $erreurs = 'Ce champ ne doit pas être vide.';
    } else {
        $code = htmlspecialchars($_POST['code']);
    }

    if (empty($erreurs)) {

        $sql = "SELECT * FROM compte_entreprise
            WHERE verification = :verification ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':verification', $code);
        $stmt->execute();
        $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($code && !$entreprise) {
            $erreurs = "Code incorrect";
        } else {

            // Générer un nouveau jeton unique
            $token = bin2hex(random_bytes(16)); // 16 octets donne 32 caractères hexadécimaux
            $verified_statut = 'verified';
            // Stocker le jeton dans la base de données avec l'ID de l'utilisateur
            $sqlUpdateToken = "UPDATE compte_entreprise SET remember_token = :token ,  verification_statut = :verified_statut WHERE id = :entreprise";
            $stmtUpdateToken = $db->prepare($sqlUpdateToken);
            $stmtUpdateToken->bindParam(':token', $token);
            $stmtUpdateToken->bindParam(':verified_statut', $verified_statut);
            $stmtUpdateToken->bindParam(':entreprise', $entreprise['id']);
            $stmtUpdateToken->execute();

            setcookie('compte_entreprise', $token, time() + 60 * 60 * 24 * 30, '/');
            $_SESSION['compte_entreprise'] = $entreprise['id']; // Initialisation de la variable de session
            unset($_SESSION['mail']);
            unset($_SESSION['nom']);
            header('location: entreprise_profil.php');
            exit();
        }
    }
}




if (isset($_POST['renvoyer'])) {

    $email = $_SESSION['mail'];

    $nom = $_SESSION['nom'];
    function generateSecurityCode($length = 9)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[mt_rand(0, $max)];
        }
        return $code;
    }

    // Génération du code de sécurité
    $verification = generateSecurityCode();


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

        // Fonction pour générer un code de sécurité aléatoire

        // Obtenez la liste des candidats (remplacez le champ 'mail' par le champ approprié dans votre base de données)

        $destinataire = $email;

        // Contenu de l'e-mail
        $sujet = 'Confirmation de compte';
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
    <img src='../../../image/ambition.png' alt='Logo de l'entreprise'>
</div>
<div class='box2'>
    <h1>Bonjour $nom,</h1>
    <h2>Nouveau compte cree !</h2>
    <p>Votre compte a été créé avec succès pour des raisons de sécurité, nous vous avons envoyé un code de sécurité, veuillez saisir ce code de sécurité dans le champ correspondant.</p>
    <p> Code de confirmation : <strong> $verification </strong></p>
    <p>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Nous sommes là pour vous aider dans votre recherche d'emploi.</p>
    <p>Cordialement,<br>L'équipe Work-Flexer</p>
</div>
    
    </body>
    </html> ";

        $mail->setFrom('info@advantechgroup.online', 'work-flexer');
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $message;


        $mail->clearAddresses();
        $mail->addAddress($destinataire);
        $mail->send();

        // Requête SQL pour l'insertion des données
        $sql = "UPDATE compte_entreprise SET verification = :verification  WHERE mail = :mail";
        $stmtUpdateToken = $db->prepare($sql);
        $stmtUpdateToken->bindParam(':verification', $verification);
        $stmtUpdateToken->bindParam(':mail', $email);
        $stmtUpdateToken->execute();

        $_SESSION['success_message'] = 'Code de vérification envoyé!';
        header('Location: ../entreprise/verification_entreprise.php');
        exit();

    } catch (Exception $e) {
        header('Location: ../compte_entreprise.php');
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


    <title>Verification</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="/css/connexion.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="message">
            <p>
                <span></span>
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </p>
        </div>
    <?php else: ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="erreurs" id="messageErreur">
                <span></span>
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <script>
        let success = document.querySelector('.message')
        setTimeout(() => {
            success.classList.add('visible');
        }, 200);
        setTimeout(() => {
            success.classList.remove('visible');
        }, 6000);

        // Sélectionnez l'élément contenant le message d'erreur
        var messageErreur = document.getElementById('messageErreur');

        // Fonction pour afficher le message avec une transition de fondu
        setTimeout(function () {
            messageErreur.classList.add('visible');
        }, 200); // 1000 millisecondes équivalent à 1 seconde

        // Fonction pour masquer le message avec une transition de fondu
        setTimeout(function () {
            messageErreur.classList.remove('visible');
        }, 6000); // 6000 millisecondes équivalent à 6 secondes
    </script>


    <section class="section2">

        <div class="formulaire1  ">
            <img src="/image/undraw_secure_login_pdn4.svg" alt="">
            <form method="post" action="">
                <h3>Confirmation de compte</h3>

                <?php if (isset($erreurs)): ?>
                    <div class="erreur"><?php echo $erreurs; ?></div>
                <?php endif; ?>


                <div class="box1">
                    <label for="code">Entrez le code de vérification envoyé à votre boîte mail.</label>
                    <input type="text" name="code" id="code">
                </div>
                <input type="submit" name="valider" value="Valider" id="valider">

                <div class="bo">
                    <p>Vous avez reçu un code de vérification par mail ? <span id="email"></span></p>
                    <input type="submit" name="renvoyer" value="Renvoyer le code !" id="renvoyer">
                </div>
            </form>
        </div>
    </section>


</body>

</html>