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

// Inclusion du fichier de connexion à la BDD


// Déclaration d'un tableau pour stocker les erreurs
$erreurs = ''; // Initialisez un tableau pour stocker les erreurs

// Vérification si le bouton valider est cliqué
if (isset($_POST['valider'])) {
    // Récupération des données du formulaire
    // Déclaration des variables 
    $nom = $email = $phone = $competences = $profession = $images = $ville = $categorie = $passe = $cpasse = '';

    $id = uniqid();

    // Vérification du nom
    if (empty($_POST['nom'])) {
        $erreurs = "Le nom est obligatoire";
    } else {
        $nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'); // Échapper les caractères spéciaux
    }

    // Vérification du mail
    if (empty($_POST['mail'])) {
        $erreurs = "email est obligatoire";
    } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $erreurs = "L'email n'est pas valide";
    } else {
        $email = $_POST['mail'];

        // Préparer la requête SQL pour vérifier si l'e-mail est déjà utilisé
        $query = $db->prepare("SELECT * FROM users WHERE mail = :mail");
        $query->bindParam(':mail', $email);
        $query->execute();

        // Vérifier si des résultats ont été trouvés
        if ($query->rowCount() > 0) {
            $erreurs = "L'e-mail est déjà utilisé";
        }
    }

    // Vérification du téléphone  
    if (empty($_POST['phone'])) {
        $erreurs = "Le téléphone est obligatoire";
    } else {
        $phone = $_POST['phone'];
    }

    // Vérification de la ville
    if (empty($_POST['ville'])) {
        $erreurs = "La ville est obligatoire";
    } else {
        $ville = htmlspecialchars($_POST['ville']);
    }
    // Vérification du nom de boutique
    if (empty($_POST['competences'])) {
        $erreurs = "ce champ ne dois pas être vide";
    } else {
        $competences = htmlspecialchars($_POST['competences']);
    }

    if (empty($_POST['profession'])) {
        $erreurs = "Veiller sélectionner un profession!!";
    } else {
        $profession = htmlspecialchars($_POST['profession']);
    }



    // Vérification de la ville
    if (empty($_POST['categorie'])) {
        $erreurs = "La ville est obligatoire";
    } else {
        $categorie = htmlspecialchars($_POST['categorie']);
    }

    // Vérification de la ville
    if (empty($_FILES['images'])) {
        $erreurs = "Choisissez une photo de profil";
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
            if (in_array($imageFileType, $allowedTypes)) {

                // Ajouter l'identifiant unique au nom du fichier
                $uniqueFileName = $id . '_' . $fileName;

                // Déplacer le fichier dans le répertoire des images
                $targetFile = 'upload/' . $uniqueFileName;
                move_uploaded_file($tmpName, $targetFile);
            } else {
                $erreurs = "Seules les images JPEG, PNG et GIF sont autorisées";
            }
        }
    }


    // Vérification du mot de passe
    if (empty($_POST['passe'])) {
        $erreurs = "Le mot de passe est obligatoire";
    } else {
        $passe = $_POST['passe'];
    }

    // Vérification de la confirmation du mot de passe
    if (empty($_POST['cpasse'])) {
        $erreurs = "La confirmation du mot de passe est obligatoire";
    } else {
        $cpasse = $_POST['cpasse'];
    }

    // Vérification de la correspondance des mots de passe
    if ($passe !== $cpasse) {
        $erreurs = "Les mots de passe ne correspondent pas !";
    }

    // Si aucune erreur n'est détectée, procédez à l'insertion
    if (empty($erreurs)) {
        // Hachage du mot de passe
        $passe = password_hash($passe, PASSWORD_DEFAULT);

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

        $verification = generateSecurityCode();


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

            $mail->setFrom('service@advantechgroup.online', 'work-flexer');
            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;


            $mail->clearAddresses();
            $mail->addAddress($destinataire);
            $mail->send();

              // Préparation de la requête SQL
        $sql = "INSERT INTO users ( nom, mail, phone, competences,profession, ville, categorie ,images,verification, passe) 
        VALUES ( :nom, :mail, :phone, :competences,:profession, :ville, :categorie, :images,:verification, :passe)";

  // Préparation de la requête 
  $stmt = $db->prepare($sql);

  // Association des paramètres
  $stmt->bindParam(':nom', $nom);
  $stmt->bindParam(':mail', $email);
  $stmt->bindParam(':phone', $phone);
  $stmt->bindParam(':competences', $competences);
  $stmt->bindParam(':profession', $profession);
  $stmt->bindParam(':ville', $ville);
  $stmt->bindParam(':categorie', $categorie);
  $stmt->bindParam(':images', $uniqueFileName);
  $stmt->bindParam(':verification', $verification);
  $stmt->bindParam(':passe', $passe);
  // Exécution de la requête
  $stmt->execute();

            header('Location: verification_users.php');
            exit();            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'une erreure c\'est produit';
            header('Location: compte_travailleur.php');
            exit();
        }

    }
}


?>









<!DOCTYPE html>
<html lang="en">

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

    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/inscription.css">
    <link rel="stylesheet" href="../css/navbare.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('navbare.php') ?>
    
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
        <img class="img" src="/image/work.jpeg" alt="">
        <div class="formulaire1  ">
            <form method="post" action="" enctype="multipart/form-data">
                <h3>Inscription</h3>
                <?php if (isset($erreurs)): ?>
                    <div class="erreur">
                        <?php echo $erreurs; ?>
                    </div>
                <?php endif; ?>

                <div class="container_form">
                    <div class="container">
                        <div class="box1">
                            <label for="nom">Nom et Prénom</label>
                            <input type="text" name="nom" id="nom" placeholder="Ex: John Doe">
                        </div>

                        <div class="box1">
                            <label for="mail">Adresse e-mail</label>
                            <input type="email" name="mail" id="mail" placeholder="Ex: john.doe@example.com">
                        </div>

                        <div class="box1">
                            <label for="phone">Téléphone</label>
                            <input type="tel" name="phone" id="phone" placeholder="Ex: 0123456789">
                        </div>

                        <div class="box1">
                            <label for="ville">Ville</label>
                            <input type="text" name="ville" id="ville" placeholder="Ex: Paris">
                        </div>

                        <div class="box1">
                            <p>Photo de profile</p>
                            <div class="ab">
                                <div>
                                    <label class="label" for="images"> <img src="/image/galerie.jpg" alt=""></label>
                                    <input type="file" name="images" id="images"
                                        accept="image/jpeg,image/jpg, image/png, image/gif">
                                </div>
                                <div>
                                    <img id="imagePreview" src="" alt="view">
                                </div>

                                <script>
                                    // Récupérer l'élément input type file
                                    const inputImage = document.getElementById('images');

                                    // Écouter le changement de fichier sélectionné
                                    inputImage.addEventListener('change', () => {

                                        // Récupérer le premier fichier sélectionné
                                        const file = inputImage.files[0];

                                        // Afficher l'aperçu dans l'élément img
                                        const previewImg = document.getElementById('imagePreview');
                                        previewImg.src = URL.createObjectURL(file);

                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="container">

                        <div class="box1">
                            <label for="competences">Domaine de compétences</label>
                            <input type="text" name="competences" id="competences"
                                placeholder="Ex: Développement web, Marketing digital, Design graphique">
                        </div>


                        <div class="box1">
                            <label for="profession">Profession</label>
                            <select name="profession" id="profession">
                                <option value="Etudiant">Étudiant</option>
                                <option value="Professionnel">Professionnel</option>
                            </select>
                        </div>

                        <div class="box1">
                            <label for="categorie">Secteur d'activité</label>
                            <select id="categorie" name="categorie">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="Informatique et tech">Informatique et tech</option>
                                <option value="Design et création">Design et création</option>
                                <option value="Rédaction et traduction">Rédaction et traduction</option>
                                <option value="Marketing et communication">Marketing et communication</option>
                                <option value="Conseil et gestion d'entreprise">Conseil et gestion d'entreprise</option>
                                <option value="Juridique">Juridique</option>
                                <option value="Ingénierie et architecture">Ingénierie et architecture</option>
                                <option value="Finance et comptabilité">Finance et comptabilité</option>
                                <option value="Santé et bien-être">Santé et bien-être</option>
                                <option value="Éducation et formation">Éducation et formation</option>
                                <option value="Tourisme et hôtellerie">Tourisme et hôtellerie</option>
                                <option value="Commerce et vente">Commerce et vente</option>
                                <option value="Transport et logistique">Transport et logistique</option>
                                <option value="Agriculture et agroalimentaire">Agriculture et agroalimentaire</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>



                        <div class="box1">
                            <label for="passe">Mot de passe</label>
                            <input type="password" name="passe" id="passe" placeholder="Ex: ********">
                            <div class="view">
                            </div>
                        </div>
                        <div class="box1">
                            <label for="cpasse">Confirmer le mot de passe</label>
                            <input type="password" name="cpasse" id="cpasse" placeholder="Ex: ********">
                            <div class="view">
                                <p>Afficher le mot de passe</p>
                                <input type="checkbox" id="voirCPasse" onclick="showPassword()">
                            </div>
                        </div>


                        <script>
                            function showPassword() {
                                var x = document.getElementById("passe");
                                var y = document.getElementById("cpasse");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }

                                if (y.type === "password") {
                                    y.type = "text";
                                } else {
                                    y.type = "password";
                                }
                            }
                        </script>

                        <input type="submit" name="valider" value="valider" id="valider">
                    </div>
                </div>

            </form>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        const input = document.querySelector("#phone");
        const iti = window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            separateDialCode: true,
            autoHideDialCode: false,
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                fetch("https://ipapi.co/json")
                    .then(function (res) {
                        return res.json();
                    })
                    .then(function (data) {
                        callback(data.country_code);
                    })
                    .catch(function () {
                        callback("us");
                    });
            }
        });



        // Masquer la liste au clic sur le champ de téléphone
        input.addEventListener('click', function () {
            iti.closeDropdown();
        });

        // Masquer au clic en dehors du champ de téléphone
        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !iti.container.contains(e.target)) {
                iti.closeDropdown();
            }
        });
    </script>


</body>

</html>