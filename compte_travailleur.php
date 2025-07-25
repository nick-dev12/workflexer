<?php
// Démarre la session
session_start();

include 'conn/conn.php';

// $_SESSION['users_id'] = true;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {

    //   Rediriger l'utilisateur vers la page d'accueil
    header('Location: index.php');
    exit();

}

// Initialiser toutes les variables
$nom = $email = $phone = $competences = $statut = $remember_token = $verification_statut = $profession = $ville = $categorie = $passe = $cpasse = '';
$erreurs = '';
$hasError = false;

$verification_statut = '';
$remember_token = '';
$statut = '';

// Vérification si le bouton valider est cliqué
if (isset($_POST['valider'])) {
    // Récupération des données du formulaire
    $id = uniqid();

    // Vérification du nom
    if (empty($_POST['nom'])) {
        $erreurs = "Le nom est obligatoire";
        $hasError = true;
    } else {
        $nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'); // Échapper les caractères spéciaux
    }

    // Vérification du mail
    if (empty($_POST['mail'])) {
        $erreurs = "L'email est obligatoire";
        $hasError = true;
    } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $erreurs = "L'email n'est pas valide";
        $hasError = true;
    } else {
        $email = $_POST['mail'];

        // Préparer la requête SQL pour vérifier si l'e-mail est déjà utilisé
        $query = $db->prepare("SELECT * FROM users WHERE mail = :mail");
        $query->bindParam(':mail', $email);
        $query->execute();

        // Vérifier si des résultats ont été trouvés
        if ($query->rowCount() > 0) {
            $erreurs = "L'e-mail est déjà utilisé";
            $hasError = true;
        }
    }

    // Vérification du téléphone  
    if (empty($_POST['phone'])) {
        $erreurs = "Le numéro de téléphone est obligatoire";
        $hasError = true;
    } else {
        $phone = $_POST['full_phone'];
    }

    // Vérification de la ville
    if (empty($_POST['ville'])) {
        $erreurs = "La ville est obligatoire";
        $hasError = true;
    } else {
        $ville = htmlspecialchars($_POST['ville']);
    }

    // Vérification des compétences
    if (empty($_POST['competences'])) {
        $erreurs = "Le domaine de compétences est obligatoire";
        $hasError = true;
    } else {
        $competences = htmlspecialchars($_POST['competences']);
    }

    // Vérification de la profession
    if (empty($_POST['profession'])) {
        $erreurs = "Veuillez sélectionner une profession !";
        $hasError = true;
    } else {
        $profession = htmlspecialchars($_POST['profession']);
    }

    // Vérification de la catégorie
    if (empty($_POST['categorie']) || $_POST['categorie'] === "") {
        $erreurs = "Le secteur d'activité est obligatoire";
        $hasError = true;
    } else {
        $categorie = htmlspecialchars($_POST['categorie']);
    }

    // Vérification de l'image
    $uniqueFileName = '';
    if (!isset($_FILES['images']) || $_FILES['images']['error'] == 4) {
        $erreurs = "Une photo de profil est obligatoire";
        $hasError = true;
    } else {
        // Récupérer les données du formulaire
        $images = $_FILES['images'];
        // Vérifier qu'un fichier est uploadé
        if ($images['error'] == 0) {
            // Récupérer le nom et le chemin temporaire
            $fileName = $images['name'];
            $tmpName = $images['tmp_name'];

            // Obtenir le type MIME de l'image
            $imageFileType = exif_imagetype($tmpName);

            // Définir les types MIME autorisés
            $allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);

            // Vérifier si le type MIME est autorisé
            if (!in_array($imageFileType, $allowedTypes)) {
                $erreurs = "Seules les images JPEG, PNG et GIF sont autorisées";
                $hasError = true;
            } else {
                // Ajouter l'identifiant unique au nom du fichier
                $uniqueFileName = $id . '_' . $fileName;

                // Déplacer le fichier dans le répertoire des images
                $targetFile = 'upload/' . $uniqueFileName;
                move_uploaded_file($tmpName, $targetFile);
            }
        } else {
            $erreurs = "Une erreur s'est produite lors du téléchargement de l'image";
            $hasError = true;
        }
    }

    // Vérification du mot de passe
    if (empty($_POST['passe'])) {
        $erreurs = "Le mot de passe est obligatoire";
        $hasError = true;
    } else {
        $passe = $_POST['passe'];
        // Vérification des critères du mot de passe
        if (strlen($passe) < 8) {
            $erreurs = "Le mot de passe doit contenir au moins 8 caractères";
            $hasError = true;
        } elseif (!preg_match('/[A-Z]/', $passe)) {
            $erreurs = "Le mot de passe doit contenir au moins une lettre majuscule";
            $hasError = true;
        }
    }

    // Vérification de la confirmation du mot de passe
    if (empty($_POST['cpasse'])) {
        $erreurs = "La confirmation du mot de passe est obligatoire";
        $hasError = true;
    } else {
        $cpasse = $_POST['cpasse'];
    }

    // Vérification de la correspondance des mots de passe
    if ($passe !== $cpasse) {
        $erreurs = "Les mots de passe ne correspondent pas !";
        $hasError = true;
    }

    // Si aucune erreur n'est détectée, procédez à l'inscription
    if (!$hasError) {
        // Hachage du mot de passe
        $passe = password_hash($passe, PASSWORD_DEFAULT);

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

        // Envoi de l'e-mail de vérification
        $mail = new PHPMailer(true);
        try {
            // Configuration SMTP améliorée
            $mail->isSMTP();
            $mail->Host = 'mail.work-flexer.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'service@work-flexer.com';
            $mail->Password = 'Ludvanne12@gmail.com';

            // Configuration SSL/TLS améliorée
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Options SSL robustes pour contourner les problèmes de certificat
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->MessageID = "<" . md5(uniqid()) . "@work-flexer.com>";
            $mail->Host = gethostbyname('mail.work-flexer.com');


            // Configuration supplémentaire pour le débogage
            $mail->SMTPDebug = 0; // Mettre à 2 pour déboguer en cas de problème
            $mail->Debugoutput = 'html';

            // Timeout et configuration de connexion
            $mail->Timeout = 60;
            $mail->SMTPKeepAlive = true;
            $mail->SMTPAutoTLS = false; // Désactiver l'auto-négociation TLS

            $destinataire = $email;

            // Contenu de l'e-mail
            $sujet = 'Confirmation de compte';
            $message = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Confirmation de compte professionnel</title>
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
                    .verification-code {
                        background-color: #f0f7ff;
                        border-left: 4px solid #0671dc;
                        padding: 15px 20px;
                        margin: 25px 0;
                        font-size: 24px;
                        font-weight: 600;
                        letter-spacing: 2px;
                        color: #0671dc;
                        text-align: center;
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
                        <div class='email-title'>Bienvenue sur Work-Flexer !</div>
                        <p class='email-text'>Merci d'avoir créé votre compte professionnel. Pour activer votre compte et commencer à postuler aux offres d'emploi, veuillez utiliser le code de vérification ci-dessous.</p>
                        
                        <div class='verification-code'>$verification</div>
                        
                        <p class='email-text'>Ce code est valable pendant 24 heures. Si vous n'avez pas créé de compte sur Work-Flexer, vous pouvez ignorer cet e-mail en toute sécurité.</p>
                        
                        <p class='note'>Pour des raisons de sécurité, ne partagez jamais ce code avec qui que ce soit, y compris le personnel de Work-Flexer. Notre équipe ne vous demandera jamais votre code de vérification.</p>
                        
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
            </html>";

            $mail->setFrom('service@work-flexer.com', 'Work-Flexer');
            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;
            $mail->CharSet = 'UTF-8';

            $mail->clearAddresses();
            $mail->addAddress($destinataire);
            $mail->send();

            // Préparation de la requête SQL
            $sql = "INSERT INTO users ( nom, mail, phone, competences, profession, statut, remember_token, verification_statut, ville, categorie, images , verification, passe) 
            VALUES ( :nom, :mail, :phone, :competences, :profession, :statut, :remember_token, :verification_statut, :ville, :categorie, :images, :verification, :passe)";

            // Préparation de la requête 
            $stmt = $db->prepare($sql);

            // Association des paramètres
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':mail', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':competences', $competences);
            $stmt->bindParam(':profession', $profession);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':remember_token', $remember_token);
            $stmt->bindParam(':verification_statut', $verification_statut);
            $stmt->bindParam(':ville', $ville);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':images', $uniqueFileName);
            $stmt->bindParam(':verification', $verification);
            $stmt->bindParam(':passe', $passe);
            // Exécution de la requête
            $stmt->execute();

            $_SESSION['mail_users'] = $email;
            $_SESSION['nom'] = $nom;
            $_SESSION['success_message'] = 'Inscription réussie !';
            header('Location: verification_users.php');
            exit();
        } catch (Exception $e) {
            $erreurs = 'Une erreur s\'est produite lors de l\'envoi du mail : ' . $mail->ErrorInfo;
            $hasError = true;
        }
    }
} else {
    // Si le formulaire n'a pas été soumis, initialiser les variables avec les valeurs par défaut
    $profession = "Etudiant"; // Valeur par défaut pour la profession
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->

    <title>Inscription - Compte Professionnel</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/formulaire_inscription.css">
    <link rel="stylesheet" href="../css/navbare.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('navbare.php') ?>

    <section class="form-section">
        <div class="form-container">
            <div class="form-header">
                <h2>Inscription - Compte Professionnel</h2>
                <p>Créez votre compte pour accéder à toutes les fonctionnalités et trouver les meilleures opportunités
                    d'emploi.</p>
            </div>

            <?php if ($hasError): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $erreurs; ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="" enctype="multipart/form-data" class="form-content">
                <div class="form-group full-width image-upload">
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <img src="/image/user-avatar.png" alt="Photo de profil" class="default-avatar"
                            id="imagePreview">
                        <div class="change-image-btn" id="changeImageBtn">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <label for="images" class="image-upload-label">Sélectionner une photo de profil</label>
                    <input type="file" name="images" id="images" class="image-upload-input"
                        accept="image/jpeg,image/jpg,image/png,image/gif">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom" class="form-label">Nom et Prénom</label>
                        <input type="text" name="nom" id="nom" class="form-input" placeholder="Ex: Jean Dupont"
                            value="<?php echo htmlspecialchars($nom); ?>">
                    </div>

                    <div class="form-group">
                        <label for="mail" class="form-label">Adresse e-mail</label>
                        <input type="email" name="mail" id="mail" class="form-input"
                            placeholder="Ex: jean.dupont@exemple.fr" value="<?php echo htmlspecialchars($email); ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" name="phone" id="phone" class="form-input" placeholder="Ex: 06 12 34 56 78">
                        <input type="hidden" id="full_phone" name="full_phone"
                            value="<?php echo htmlspecialchars($phone); ?>">
                    </div>

                    <div class="form-group">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" name="ville" id="ville" class="form-input"
                            placeholder="Ex: Paris, Lyon, Marseille" value="<?php echo htmlspecialchars($ville); ?>">
                    </div>

                    <div class="form-group">
                        <label for="competences" class="form-label">Domaine de compétences</label>
                        <input type="text" name="competences" id="competences" class="form-input"
                            placeholder="Ex: Développement web, Marketing digital"
                            value="<?php echo htmlspecialchars($competences); ?>">
                    </div>

                    <div class="form-group">
                        <label for="profession" class="form-label">Profession</label>
                        <select name="profession" id="profession" class="form-input form-select">
                            <option value="Etudiant" <?php echo ($profession === 'Etudiant') ? 'selected' : ''; ?>>
                                Étudiant</option>
                            <option value="Professionnel" <?php echo ($profession === 'Professionnel') ? 'selected' : ''; ?>>Professionnel
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="categorie" class="form-label">Secteur d'activité</label>
                        <select id="categorie" name="categorie" class="form-input form-select">
                            <option value="" <?php echo ($categorie === '') ? 'selected' : ''; ?>>Sélectionnez une
                                catégorie</option>
                            <option value="Informatique et tech" <?php echo ($categorie === 'Informatique et tech') ? 'selected' : ''; ?>>Informatique et
                                tech</option>
                            <option value="Design et création" <?php echo ($categorie === 'Design et création') ? 'selected' : ''; ?>>Design et
                                création</option>
                            <option value="Rédaction et traduction" <?php echo ($categorie === 'Rédaction et traduction') ? 'selected' : ''; ?>>Rédaction et
                                traduction</option>
                            <option value="Marketing et communication" <?php echo ($categorie === 'Marketing et communication') ? 'selected' : ''; ?>>Marketing
                                et communication</option>
                            <option value="Conseil et gestion d'entreprise" <?php echo ($categorie === 'Conseil et gestion d\'entreprise') ? 'selected' : ''; ?>>
                                Conseil et gestion d'entreprise</option>
                            <option value="Juridique" <?php echo ($categorie === 'Juridique') ? 'selected' : ''; ?>>
                                Juridique</option>
                            <option value="Ingénierie et architecture" <?php echo ($categorie === 'Ingénierie et architecture') ? 'selected' : ''; ?>>
                                Ingénierie et architecture</option>
                            <option value="Finance et comptabilité" <?php echo ($categorie === 'Finance et comptabilité') ? 'selected' : ''; ?>>Finance et
                                comptabilité</option>
                            <option value="Santé et bien-être" <?php echo ($categorie === 'Santé et bien-être') ? 'selected' : ''; ?>>Santé et
                                bien-être</option>
                            <option value="Éducation et formation" <?php echo ($categorie === 'Éducation et formation') ? 'selected' : ''; ?>>Éducation et
                                formation</option>
                            <option value="Tourisme et hôtellerie" <?php echo ($categorie === 'Tourisme et hôtellerie') ? 'selected' : ''; ?>>Tourisme et
                                hôtellerie</option>
                            <option value="Commerce et vente" <?php echo ($categorie === 'Commerce et vente') ? 'selected' : ''; ?>>Commerce et vente
                            </option>
                            <option value="Transport et logistique" <?php echo ($categorie === 'Transport et logistique') ? 'selected' : ''; ?>>Transport et
                                logistique</option>
                            <option value="Agriculture et agroalimentaire" <?php echo ($categorie === 'Agriculture et agroalimentaire') ? 'selected' : ''; ?>>
                                Agriculture et agroalimentaire</option>
                            <option value="Autre" <?php echo ($categorie === 'Autre') ? 'selected' : ''; ?>>Autre
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="passe" class="form-label">Mot de passe</label>
                        <input type="password" name="passe" id="passe" class="form-input"
                            placeholder="Minimum 8 caractères avec une majuscule">
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        <div class="password-requirements">
                            <div class="requirement" id="length-requirement">
                                <i class="fas fa-times-circle requirement-icon"></i>
                                <span>Au moins 8 caractères</span>
                            </div>
                            <div class="requirement" id="uppercase-requirement">
                                <i class="fas fa-times-circle requirement-icon"></i>
                                <span>Au moins une lettre majuscule</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cpasse" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="cpasse" id="cpasse" class="form-input"
                            placeholder="Confirmez votre mot de passe">
                        <label class="show-password">
                            <input type="checkbox" id="showPassword">
                            <span class="checkmark"></span>
                            Afficher les mots de passe
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="valider" class="submit-button">
                        <i class="fas fa-user-plus"></i>Créer mon compte
                    </button>

                    <div class="login-link">
                        Vous avez déjà un compte? <a href="/connexion.php">Connectez-vous ici</a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        // Initialisation du plugin de téléphone
        const phoneInputField = document.querySelector("#phone");
        const fullPhoneInput = document.querySelector("#full_phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            preferredCountries: ["fr", "us", "gb"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            geoIpLookup: function (callback) {
                fetch("https://ipapi.co/json")
                    .then(function (res) {
                        return res.json();
                    })
                    .then(function (data) {
                        callback(data.country_code);
                    })
                    .catch(function () {
                        callback("fr");
                    });
            }
        });

        // Mettre à jour le numéro complet lorsque l'utilisateur tape
        phoneInputField.addEventListener("blur", function () {
            fullPhoneInput.value = phoneInput.getNumber();
        });

        // Si une valeur existante pour le téléphone, l'afficher
        <?php if (!empty($phone)): ?>
            phoneInputField.value = "<?php echo $phone; ?>";
        <?php endif; ?>

        // Gestion de l'aperçu de l'image
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const changeImageBtn = document.getElementById('changeImageBtn');

        // Événement lors du changement de l'image
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('default-avatar');
                }
                reader.readAsDataURL(file);
            }
        });

        // Cliquer sur le bouton pour changer l'image
        changeImageBtn.addEventListener('click', function () {
            imageInput.click();
        });

        // Gestion de l'affichage du mot de passe
        const showPasswordCheckbox = document.getElementById('showPassword');
        const passwordField = document.getElementById('passe');
        const confirmPasswordField = document.getElementById('cpasse');
        const togglePasswordIcon = document.getElementById('togglePassword');

        showPasswordCheckbox.addEventListener('change', function () {
            togglePasswordVisibility(this.checked);
        });

        togglePasswordIcon.addEventListener('click', function () {
            showPasswordCheckbox.checked = !showPasswordCheckbox.checked;
            togglePasswordVisibility(showPasswordCheckbox.checked);
        });

        function togglePasswordVisibility(show) {
            passwordField.type = show ? 'text' : 'password';
            confirmPasswordField.type = show ? 'text' : 'password';
            togglePasswordIcon.className = show ? 'fas fa-eye-slash password-toggle' : 'fas fa-eye password-toggle';
        }

        // Validation en temps réel du mot de passe
        const passwordInput = document.getElementById('passe');
        const lengthRequirement = document.getElementById('length-requirement');
        const uppercaseRequirement = document.getElementById('uppercase-requirement');

        passwordInput.addEventListener('input', function () {
            const password = this.value;

            // Vérification de la longueur
            if (password.length >= 8) {
                lengthRequirement.querySelector('.requirement-icon').className =
                    'fas fa-check-circle requirement-icon valid';
                lengthRequirement.classList.add('met');
            } else {
                lengthRequirement.querySelector('.requirement-icon').className =
                    'fas fa-times-circle requirement-icon';
                lengthRequirement.classList.remove('met');
            }

            // Vérification de la présence d'une majuscule
            if (/[A-Z]/.test(password)) {
                uppercaseRequirement.querySelector('.requirement-icon').className =
                    'fas fa-check-circle requirement-icon valid';
                uppercaseRequirement.classList.add('met');
            } else {
                uppercaseRequirement.querySelector('.requirement-icon').className =
                    'fas fa-times-circle requirement-icon';
                uppercaseRequirement.classList.remove('met');
            }
        });
    </script>
</body>

</html>