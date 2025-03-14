<?php
// require_once('..//entreprise/app/model/entreprise.php');
require_once(__DIR__ . '/../model/entreprise.php');
include(__DIR__ . '../../../../controller/controller_competence_users.php');

// include('../model/vue_offre.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '../../../../vendor/autoload.php';

if (isset($_SESSION['compte_entreprise'])) {
    $getEntreprise = getEntreprise($db, $_SESSION['compte_entreprise']);

    $selecteOffre = selectOffre($db, $getEntreprise['id']);

    $afficheOffreEmplois = getOffresEmplois($db, $getEntreprise['id']);
    $afficheOffreEmplois_suprimer = getOffresEmplois_suprimer($db, $getEntreprise['id']);

}

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['compte_entreprise'])) {
    // L'utilisateur est déjà connecté, pas besoin de vérifier le cookie
} elseif (isset($_COOKIE['compte_entreprise'])) {
    // Le cookie remember_me est présent, essayons de reconnecter l'utilisateur

    $token = $_COOKIE['compte_entreprise'];

    // Vérifier le jeton dans la base de données
    $sqlCheckToken = "SELECT id FROM compte_entreprise WHERE remember_token = :token";
    $stmtCheckToken = $db->prepare($sqlCheckToken);
    $stmtCheckToken->bindParam(':token', $token);
    $stmtCheckToken->execute();
    $userId = $stmtCheckToken->fetchColumn();

    if ($userId) {
        // Jeton valide, connecter l'utilisateur
        $_SESSION['compte_entreprise'] = $userId;
    }
}


if (isset($_POST['publier'])) {


    $poste = $mission = $profil = $metier = $contrat = $etudes = $regions = $experience = $langues = '';

    $entreprise_id = $getEntreprise['id'];



    if (empty($_POST['poste'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter le poste disponible !';
    } else {
        $poste = $_POST['poste'];
    }

    if (empty($_POST['mission'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter les missions correspondant au profil !';
    } else {
        $mission = $_POST['mission'];
    }

    if (empty($_POST['profil'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter les critères du profil recherché !';
    } else {
        $profil = $_POST['profil'];
    }


    if (empty($_POST['contrat'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter le type de contrat !';
    } else {
        $contrat = $_POST['contrat'];
    }

    if (empty($_POST['etude'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter le niveau d\'étude !';
    } else {
        $etudes = $_POST['etude'];
        // Convertir les niveaux d'étude et d'expérience en valeurs numériques
        $etude_valeurs = array(
            "Bac+1an" => 1,
            "Bac+2ans" => 2,
            "Bac+3ans" => 3,
            "Bac+4ans" => 4,
            "Bac+5ans" => 5,
            "Bac+6ans" => 6,
            "Bac+7ans" => 7,
            "Bac+8ans" => 8,
            "Bac+9ans" => 9,
            "Bac+10ans" => 10,
            "Aucun" => 0
        );
        $n_etudes = $etude_valeurs[$etudes];
    }

    if (empty($_POST['experience'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter un niveau d\'expérience !';
    } else {
        $experience = $_POST['experience'];
        // Convertir les niveaux d'étude et d'expérience en valeurs numériques
        $experience_valeurs = array(
            "1an" => 1,
            "2ans" => 2,
            "3ans" => 3,
            "4ans" => 4,
            "5ans" => 5,
            "6ans" => 6,
            "7ans" => 7,
            "8ans" => 8,
            "9ans" => 9,
            "10ans" => 10,
            "Aucun" => 0
        );
        $n_experience = $experience_valeurs[$experience];
    }

    if (empty($_POST['localite'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter une localité !';
    } else {
        $localite = $_POST['localite'];
    }

    if (empty($_POST['langues'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter la ou les langues exigées !';
    } else {
        $langues = $_POST['langues'];
    }

    if (empty($_POST['places'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter le nombre de places disponibles !';
    } else {
        $places = $_POST['places'];
    }

    if (empty($_POST['duree'])) {
        $_SESSION['error_message'] = 'Veuillez ajouter la durée de l\'offre avant expiration !';
    } else {
        $duree = $_POST['duree'];
        // Calculer la date d'expiration
        $date_expiration = date('Y-m-d', strtotime("+$duree days"));
    }


    if (empty($_POST['categorie'])) {
        $_SESSION['error_message'] = 'Veuillez sélectionner une catégorie !';
    } else {
        $categorie = $_POST['categorie'];

        $T_categorie = Categorie($db, $categorie);

        if ($T_categorie > 0) {

        } else {
            PostCategorie($db, $categorie);
        }
    }


    $date_publication = new DateTime();
    $date_formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM y '
    );
    $date = $date_formatter->format($date_publication);



    if (empty($_SESSION['error_message'])) {

        // Créez l'instance PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Paramètres SMTP
            $mail->isSMTP();
            $mail->Host = 'advantech-group.space';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@advantech-group.space';
            $mail->Password = 'Ludvanne12@gmail.com'; // Remplacez par le mot de passe de votre compte e-mail
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Obtenez la liste des candidats (remplacez le champ 'mail' par le champ approprié dans votre base de données)

            $sql = "SELECT * FROM users WHERE categorie = :categorie";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":categorie", $categorie);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $candidate) {
                $destinataire = $candidate['mail'];
                $nom = $candidate['nom'];
                // Contenu de l'e-mail
                $sujet = 'Nouvelle offre d\'emploi correspondant à vos critères';
                $message = "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Nouvelle offre d'emploi</title>
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
                            <div class='email-title'>Nouvelle offre d'emploi disponible !</div>
                            
                            <div class='highlight-box'>
                                <h3>Poste : $poste</h3>
                            </div>
                            
                            <p class='email-text'>Nous sommes ravis de vous informer qu'une nouvelle offre d'emploi correspondant à vos critères est disponible sur Work-Flexer.</p>
                            
                            <p class='email-text'>Cette offre présente une opportunité passionnante pour vous. Nous vous encourageons à vous connecter dès que possible, à consulter les détails de l'offre et à postuler pour saisir cette chance.</p>
                            
                            <a href='https://work-flexer.com/page/user_profil.php' class='button'>Découvrir l'offre</a>
                            
                            <p class='note'>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Nous sommes là pour vous aider dans votre recherche d'emploi.</p>
                            
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
                            <p class='footer-text'>Pour toute question, contactez-nous à <a href='mailto:info@advantech-group.space'>info@advantech-group.space</a></p>
                        </div>
                    </div>
                </body>
                </html> ";

                $mail->setFrom('info@advantech-group.space', 'Work-Flexer');
                $mail->isHTML(true);
                $mail->Subject = $sujet;
                $mail->Body = $message;


                $mail->clearAddresses();
                $mail->addAddress($destinataire);
                $mail->send();
            }

            if (postOffres($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $categorie, $date)) {

                $_SESSION['success_message'] = 'Offre d\'emploi publiée avec succès';
                header('Location: entreprise_profil.php');
                exit();
            }

        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Une erreur s\'est produite';
            header('Location: entreprise_profil.php');
            exit();
        }
    }
}



if (isset($_SESSION['users_id'])) {

}




if (isset($_POST['valider1'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $nom = '';
    if (empty($_POST['nom'])) {
        $_SESSION['error_message'] = 'votre nom obligatoire';
    } else {
        $nom = $_POST['nom'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update1($db, $nom, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider2'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $entreprise = '';
    if (empty($_POST['entreprise'])) {
        $_SESSION['error_message'] = 'le nom de l\'entreprise obligatoire';
    } else {
        $entreprise = $_POST['entreprise'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update2($db, $entreprise, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider3'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $mail = '';
    if (empty($_POST['mail'])) {
        $_SESSION['error_message'] = 'l\'adresse mail obligatoire';
    } else {
        $mail = $_POST['mail'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update3($db, $mail, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider4'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $phone = '';
    if (empty($_POST['phone'])) {
        $_SESSION['error_message'] = 'numéro de téléphone obligatoire';
    } else {
        $phone = $_POST['phone'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update4($db, $phone, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider5'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $types = '';
    if (empty($_POST['types'])) {
        $_SESSION['error_message'] = 'type d\'entreprise obligatoire';
    } else {
        $types = $_POST['types'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update5($db, $types, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider6'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $ville = '';
    if (empty($_POST['ville'])) {
        $_SESSION['error_message'] = 'ville obligatoire';
    } else {
        $ville = $_POST['ville'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update6($db, $ville, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider7'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $taille = '';
    if (empty($_POST['taille'])) {
        $_SESSION['error_message'] = 'taille de l\'entreprise obligatoire';
    } else {
        $taille = $_POST['taille'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update7($db, $taille, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider8'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $categorie = '';
    if (empty($_POST['categorie'])) {
        $_SESSION['error_message'] = 'secteur d\'activité obligatoire';
    } else {
        $categorie = $_POST['categorie'];
    }
    if (empty($_SESSION['error_message'])) {
        if (update8($db, $categorie, $entreprise_id)) {

        }
        $_SESSION['success_message'] = 'Modifier avec succès';
        header('Location: modifier.php');
        exit();
    }
}

if (isset($_POST['valider9'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $pass = '';
    $pass1 = '';
    if (empty($_POST['pass'])) {
        $_SESSION['error_message'] = 'Mot de passe actuel obligatoire';
    } else {
        $pass = $_POST['pass'];
    }
    if (empty($_POST['pass1'])) {
        $_SESSION['error_message'] = 'Nouveau mot de passe obligatoire';
    } else {
        $pass1 = $_POST['pass1'];
    }

    if (empty($_SESSION['error_message'])) {
        // Vérifier le mot de passe actuel
        $sql = "SELECT passe FROM compte_entreprise WHERE id = :entreprise_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($pass, $result['passe'])) {
            // Hacher le nouveau mot de passe
            $hashedPass1 = password_hash($pass1, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            if (update9($db, $hashedPass1, $entreprise_id)) {
            }

            $_SESSION['success_message'] = 'Mot de passe modifié avec succès';
            header('Location: modifier.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Mot de passe actuel incorrect';
            header('Location: modifier.php');
            exit();
        }
    }
}

if (isset($_POST['valider0'])) {

    $entreprise_id = $_SESSION['compte_entreprise'];

    $images = '';

    // Vérification de la ville
    if (empty($_FILES['images'])) {
        $_SESSION['error_message'] = 'erreur choisissez une autre image .';
    } else {
        // Récupérer les données du formulaire
        $images = $_FILES['images'];
        // Vérifier qu'un fichier est uploadé
        if (empty($_SESSION['error_message'])) {

            // Récupérer le nom et le chemin temporaire
            $fileName = $images['name'];
            $tmpName = $images['tmp_name'];

            // Ajouter l'identifiant unique au nom du fichier
            $uniqueFileName = $id . '_' . $fileName;

            // Déplacer le fichier dans le répertoire audio
            $targetFile = '../upload/' . $uniqueFileName;
            move_uploaded_file($tmpName, $targetFile);


            if (update0($db, $uniqueFileName, $entreprise_id)) {
            }

            $_SESSION['success_message'] = 'Modifier avec succès';
            header('Location: modifier.php');
            exit();
        }



    }
}

if (isset($_SESSION['compte_entreprise'])) {
    $historiques = getHistorique($db, $_SESSION['compte_entreprise']);
}


if (isset($_POST['send'])) {
    if (isset($_SESSION['users_id'])) {
        $utilisateur = $_SESSION['users_id'];
        $compte = 'compte professionnel';
        $mail = $users['mail'];
        $nom = $users['nom'];
    } else {
        if (isset($_SESSION['compte_entreprise'])) {
            $utilisateur = $_SESSION['compte_entreprise'];
            $compte = 'compte entreprise';
            $mail = $getEntreprise['mail'];
            $nom = $getEntreprise['nom'];
        }
    }
    if (empty($_POST['message'])) {
        $_SESSION['error_message'] = 'Ce champ de doit pas etre vide';
    } else {
        $message = htmlspecialchars($_POST['message']);
    }

    if (empty($_SESSION['error_message'])) {
        $sql = "INSERT INTO admin_message (utilisateur_id, compte,message,mail,nom) VALUES (:utilisateur_id, :compte,:message,:mail,:nom)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":utilisateur_id", $utilisateur);
        $stmt->bindValue(":compte", $compte);
        $stmt->bindValue(":message", $message);
        $stmt->bindValue(":mail", $mail);
        $stmt->bindValue(":nom", $nom);
        $stmt->execute();

        $_SESSION['success_message'] = 'Message envoyé';

        if (isset($_SESSION['compte_entreprise'])) {
            header('Location: entreprise_profil.php');
        } else {
            if (isset($_SESSION['users_id'])) {
                header('Location: user_profil.php');
            }
        }
        exit;

    }

}
$getAllentreprise = geAlltEntreprise($db);


?>