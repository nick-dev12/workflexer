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

$erreurs = '';

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
    function generateSecurityCode($length = 6)
    {
        $characters = '0123456789';
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
        $mail->Host = 'mail.work-flexer.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'service@work-flexer.com';
        $mail->Password = 'Ludvanne12@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Obtenez la liste des candidats (remplacez le champ 'mail' par le champ approprié dans votre base de données)
        $destinataire = $email;

        // Contenu de l'e-mail
        $sujet = 'Confirmation de compte';
        $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Confirmation de compte entreprise</title>
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
                background-color: #2c3e50;
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
                color: #2c3e50;
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
                border-left: 4px solid #2c3e50;
                padding: 15px 20px;
                margin: 25px 0;
                font-size: 24px;
                font-weight: 600;
                letter-spacing: 2px;
                color: #2c3e50;
                text-align: center;
            }
            .button {
                display: inline-block;
                background-color: #2c3e50;
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
                color: #2c3e50;
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
                <div class='email-title'>Confirmation de votre compte entreprise</div>
                <p class='email-text'>Merci d'avoir créé un compte entreprise sur Work-Flexer. Pour activer votre compte et accéder à toutes nos fonctionnalités, veuillez utiliser le code de vérification ci-dessous.</p>
                
                <div class='verification-code'>$verification</div>
                
                <p class='email-text'>Saisissez ce code sur la page de vérification pour finaliser la création de votre compte entreprise.</p>
                
                <p class='email-text'>Avec Work-Flexer, votre entreprise pourra :</p>
                <ul style='margin-left: 20px; margin-bottom: 20px; color: #555555;'>
                    <li style='margin-bottom: 8px;'>Publier des offres d'emploi ciblées</li>
                    <li style='margin-bottom: 8px;'>Accéder à une base de candidats qualifiés</li>
                    <li style='margin-bottom: 8px;'>Gérer efficacement vos processus de recrutement</li>
                    <li style='margin-bottom: 8px;'>Communiquer directement avec les candidats</li>
                </ul>
                
                <p class='note'>Si vous n'avez pas créé de compte entreprise sur Work-Flexer, veuillez ignorer cet e-mail.</p>
                
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
    </html> ";

        $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
        $mail->addReplyTo('service@work-flexer.com', 'Service Client Work-Flexer');
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
        $_SESSION['error_message'] = 'Une erreur s\'est produite';
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

    <title>Vérification de compte entreprise - Work-Flexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/navbare.css">
    <link rel="stylesheet" href="/css/connexion.css">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
        <div class="<?php echo isset($_SESSION['success_message']) ? 'message' : 'erreurs'; ?>" id="notification-message">
            <i
                class="fas <?php echo isset($_SESSION['success_message']) ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            <span>
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                } else {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
                ?>
            </span>
        </div>
    <?php endif; ?>

    <section class="login-section">
        <div class="login-container">
            <div class="login-image">
                <img src="/image/undraw_secure_login_pdn4.svg" alt="Illustration de vérification de compte">
            </div>

            <div class="login-form-container">
                <div class="login-header">
                    <h2>Vérification de compte entreprise</h2>
                    <p>Veuillez saisir le code de vérification envoyé à votre adresse e-mail pour activer votre compte
                        entreprise</p>
                </div>

                <?php if (!empty($erreurs)): ?>
                    <div class="error-message" id="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $erreurs; ?></span>
                    </div>
                <?php endif; ?>

                <form method="post" action="" class="login-form">
                    <div class="form-group">
                        <label for="code">Code de vérification</label>
                        <input type="text" name="code" id="code" class="form-input"
                            placeholder="Entrez le code reçu par e-mail">
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="valider" class="submit-button"
                            style="background-color: var(--secondary-color);">
                            <i class="fas fa-check-circle"></i>Vérifier
                        </button>

                        <div class="separator">ou</div>

                        <button type="submit" name="renvoyer" class="register-button"
                            style="background-color: var(--secondary-color);">
                            <i class="fas fa-paper-plane"></i>Renvoyer le code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Animation pour les messages d'erreur
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.classList.add('shake');

            // Supprimer la classe après l'animation
            errorMessage.addEventListener('animationend', function () {
                this.classList.remove('shake');
            });
        }

        // Animation pour les notifications
        const notificationMessage = document.getElementById('notification-message');
        if (notificationMessage) {
            notificationMessage.classList.add('visible');

            // Masquer après 6 secondes
            setTimeout(function () {
                notificationMessage.classList.remove('visible');
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