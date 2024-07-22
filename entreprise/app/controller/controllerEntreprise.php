<?php
// require_once('..//entreprise/app/model/entreprise.php');
require_once(__DIR__ . '/../model/entreprise.php');
include(__DIR__ .'../../../../controller/controller_competence_users.php');

// include('../model/vue_offre.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ .'../../../../vendor/autoload.php';

if (isset($_SESSION['compte_entreprise'])) {
    $getEntreprise = getEntreprise($db, $_SESSION['compte_entreprise']);

    $selecteOffre = selectOffre($db, $getEntreprise['id']);

    $afficheOffreEmplois = getOffresEmplois($db, $getEntreprise['id']);

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
        $_SESSION['error_message'] = 'veuiller ajouter le poste disponible !!!';
    } else {
        $poste = $_POST['poste'];
    }

    if (empty($_POST['mission'])) {
        $_SESSION['error_message'] = 'veuiller ajouter les mission correspondant au prolil !!!';
    } else {
        $mission = $_POST['mission'];
    }

    if (empty($_POST['profil'])) {
        $_SESSION['error_message'] = 'veuiller ajouter les criteres du profil rechercher  !!!';
    } else {
        $profil = $_POST['profil'];
    }


    if (empty($_POST['contrat'])) {
        $_SESSION['error_message'] = 'veuiller ajouter le type de contrat  !!!';
    } else {
        $contrat = $_POST['contrat'];
    }

    if (empty($_POST['etude'])) {
        $_SESSION['error_message'] = 'veuiller ajouter le niveau de etude  !!!';
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
        $_SESSION['error_message'] = 'veuiller ajouter un niveau d\'experience  !!!';
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
        $_SESSION['error_message'] = 'veuiller ajouter une localiter !!!';
    } else {
        $localite = $_POST['localite'];
    }

    if (empty($_POST['langues'])) {
        $_SESSION['error_message'] = 'veuiller ajouter la ou les langues exiger  !!!';
    } else {
        $langues = $_POST['langues'];
    }

    if(empty($_POST['places'])){
        $_SESSION['error_message'] = 'veuiller ajouter le nombre de places disponible  !!!';    
    }else{
        $places = $_POST['places'];
    }

    if(empty($_POST['duree'])){
        $_SESSION['error_message'] = 'veuiller ajouter la duree de l\'offre avant expiration  !!!';    
    }else{
        $duree = $_POST['duree'];
         // Calculer la date d'expiration
    $date_expiration = date('Y-m-d', strtotime("+$duree days"));
    }

    
    if (empty($_POST['categorie'])) {
        $_SESSION['error_message'] = 'veuiller sélectionner une catégorie !!!';
    }else{
        $categorie = $_POST['categorie'];

       $T_categorie = Categorie ($db,$categorie);

       if ($T_categorie > 0) {
        
       }else {
        PostCategorie ($db,$categorie);
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
            $mail->Host = 'advantechgroup.online';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@advantechgroup.online';
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
                <h2>Nouvelle offre d'emploi disponible !</h2>
                <h3><strong>Poste :</strong> $poste</h3>
                <p>Nous sommes ravis de vous informer qu'une nouvelle offre d'emploi correspondant à vos critères est disponible sur Work-Flexer.</p>
                <p>Cette offre présente une opportunité passionnante pour vous. Nous vous encourageons à vous connecter dès que possible, à discuter avec les recruteurs et à postuler à l'offre pour saisir cette chance.</p>
                <p>Connectez-vous dès maintenant pour ne rien rater :</p>
                <a href='https://work-flexer.com/page/user_profil.php'>Accéder à l'offre</a>
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
                }

                if (postOffres($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $categorie, $date)) {

                     $_SESSION['success_message'] = 'Offre d\'emploi publiée avec succès';
                header('Location: entreprise_profil.php');
                exit();
                }

            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Une erreur c\'est produit';
                header('Location: entreprise_profil.php');
                exit();
            }
        }
    }



if (isset($_SESSION['users_id'])) {

}




if (isset($_POST['valide1'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $nom = '';
    if (empty($_POST['nom'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide2'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $entreprise = '';
    if (empty($_POST['entreprise'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide3'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $mail = '';
    if (empty($_POST['mail'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide4'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $phone = '';
    if (empty($_POST['phone'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide5'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $types = '';
    if (empty($_POST['types'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide6'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $ville = '';
    if (empty($_POST['ville'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide7'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $taille = '';
    if (empty($_POST['taille'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide8'])) {
    $entreprise_id = $_SESSION['compte_entreprise'];
    $categorie = '';
    if (empty($_POST['categorie'])) {
        $_SESSION['error_message'] = 'nom obligatoire';
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

if (isset($_POST['valide0'])) {

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

        $_SESSION['success_message'] = 'Message envoyer';

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