// Contenu de l'e-mail
$sujet = 'Suivi de candidature';
$message = "
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Candidature en attente</title>
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

        .highlight-box {
            background-color: #f0f7ff;
            border-left: 4px solid #0671dc;
            padding: 15px 20px;
            margin: 25px 0;
            color: #333333;
        }

        .highlight-box h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #0671dc;
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
            <div class='email-title'>Mise à jour de votre candidature</div>

            <div class='highlight-box'>
                <h3>Poste : $poste</h3>
            </div>

            <p class='email-text'>Nous vous informons que votre candidature pour le poste de <strong>$poste</strong> est
                actuellement en cours d'examen.</p>

            <p class='email-text'>Le recruteur a placé votre profil en liste d'attente et pourrait vous contacter
                prochainement pour plus d'informations ou pour un entretien.</p>

            <p class='email-text'>Nous vous recommandons de :</p>
            <ul style='margin-left: 20px; margin-bottom: 20px; color: #555555;'>
                <li style='margin-bottom: 8px;'>Vérifier régulièrement votre compte pour d'éventuelles mises à jour</li>
                <li style='margin-bottom: 8px;'>Compléter votre profil si nécessaire pour augmenter vos chances</li>
                <li style='margin-bottom: 8px;'>Rester disponible pour un éventuel contact du recruteur</li>
            </ul>

            <a href='https://work-flexer.com/page/user_profil.php' class='button'>Accéder à mon compte</a>

            <p class='note'>Nous vous remercions pour votre patience et vous tiendrons informé de l'évolution de votre
                candidature.</p>

            <div class='signature'>
                <p class='email-text'>Cordialement,</p>
                <p class='signature-name'>L'équipe Work-Flexer</p>
                <p class='signature-title'>Service recrutement</p>
            </div>
        </div>
        <div class='email-footer'>
            <div class='social-links'>
                <a href='#'>Facebook</a>
                <a href='#'>Twitter</a>
                <a href='#'>LinkedIn</a>
            </div>
            <p class='footer-text'>© 2023 Work-Flexer. Tous droits réservés.</p>
            <p class='footer-text'>Pour toute question, contactez-nous à <a
                    href='mailto:info@advantech-group.space'>info@advantech-group.space</a></p>
        </div>
    </div>
</body>

</html> ";

$mail->setFrom('info@advantech-group.space', 'Work-Flexer');