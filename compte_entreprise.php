<?php

// Démarre la session
session_start();

include 'conn/conn.php';
if (isset($_SESSION['compte_entreprise'])) {
    header('location: ../index.php'); // Rediriger vers la page du tableau de bord
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Inclusion du fichier de connexion à la BDD


// Déclaration d'un tableau pour stocker les erreurs
$erreurs = ''; // Initialisez un tableau pour stocker les erreurs

// Vérification si le bouton valider est cliqué
if (isset($_POST['valider'])) {
    // Récupération des données du formulaire
    // Déclaration des variables 
    $nom = $email = $phone = $types = $taille = $entreprise = $images = $ville = $categorie = $passe = $cpasse = '';

    $id = uniqid();


    // Vérification du nom
    if (empty($_POST['nom'])) {
        $erreurs = "Le nom est obligatoire";
    } else {
        $nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'); // Échapper les caractères spéciaux
    }
    // Vérification du nom de boutique
    if (empty($_POST['entreprise'])) {
        $erreurs = "Le nom de l'entreprise est obligatoire";
    } else {
        $entreprise = ($_POST['entreprise']);
    }
    // Vérification du mail
    if (empty($_POST['mail'])) {
        $erreurs = "L'email est obligatoire";
    } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $erreurs = "L'email n'est pas valide";
    } else {
        $email = $_POST['mail'];

        // Préparer la requête SQL pour vérifier si l'e-mail est déjà utilisé
        $query = $db->prepare("SELECT * FROM compte_entreprise WHERE mail = :mail");
        $query->bindParam(':mail', $email);
        $query->execute();

        // Vérifier si des résultats ont été trouvés
        if ($query->rowCount() > 0) {
            $erreurs = "L'e-mail est déjà utilisé";
        }
    }

    // Vérification du téléphone  
    if (empty($_POST['phone'])) {
        $erreurs = "Le Numéro de téléphone est obligatoire";
    } else {
        $phone = $_POST['full_phone'];
    }

    // Vérification du téléphone  
    if (empty($_POST['types'])) {
        $erreurs = "Le téléphone est obligatoire";
    } else {
        $types = $_POST['types'];
    }

    // Vérification du nom de boutique
    if (empty($_POST['taille'])) {
        $erreurs = "La taille de l'entreprise est obligatoire";
    } else {
        $taille = htmlspecialchars($_POST['taille']);
    }

    // Vérification de la ville
    if (empty($_POST['categorie'])) {
        $erreurs = "La catégorie est obligatoire";
    } else {
        $categorie = htmlspecialchars($_POST['categorie']);
    }

    // Vérification de la ville
    if (empty($_POST['ville'])) {
        $erreurs = "La ville est obligatoire";
    } else {
        $ville = htmlspecialchars($_POST['ville']);
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

            // Ajouter l'identifiant unique au nom du fichier
            $uniqueFileName = $id . '_' . $fileName;

            // Déplacer le fichier dans le répertoire audio
            $targetFile = 'upload/' . $uniqueFileName;
            move_uploaded_file($tmpName, $targetFile);
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
            <img src='https://work-flexer.com/image/logo 2.png' alt='Logo de l'entreprise'>
        </div>
        <div class='box2'>
            <h1>Bonjour $nom,</h1>
            <h2>Nouveau compte créé !</h2>
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
            $mail->CharSet = 'UTF-8'; // Ajout pour l'encodage


            $mail->clearAddresses();
            $mail->addAddress($destinataire);
            $mail->send();

            // Requête SQL pour l'insertion des données
            $sql = "INSERT INTO compte_entreprise (nom, mail, phone,types, taille, entreprise, ville, categorie, images,verification , passe) 
        VALUES (:nom, :mail, :phone,:types, :taille, :entreprise, :ville, :categorie, :images,:verification , :passe)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':mail', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':types', $types);
            $stmt->bindParam(':taille', $taille);
            $stmt->bindParam(':entreprise', $entreprise);
            $stmt->bindParam(':ville', $ville);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':images', $uniqueFileName);
            $stmt->bindParam(':verification', $verification);
            $stmt->bindParam(':passe', $passe);
            // Exécution de la requête
            $stmt->execute();

            $_SESSION['success_message'] = 'Inscription réussie !';
            $_SESSION['mail'] = $email;
            $_SESSION['nom'] = $nom;
            header('Location: ../entreprise/verification_entreprise.php');
            exit();

        } catch (Exception $e) {
            header('Location: compte_entreprise.php');
            exit();
        }

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
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <title>inscription entreprise</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
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
                            <label for="entreprise">Nom de votre entreprise</label>
                            <input type="text" name="entreprise" id="entreprise" placeholder="Ex: ABC Company">
                        </div>

                        <div class="box1">
                            <label for="mail">Adresse e-mail</label>
                            <input type="email" name="mail" id="mail" placeholder="Ex: john.doe@example.com">
                        </div>

                        <div class="box1">
                            <label for="phone">Téléphone</label>
                            <input type="texte" name="phone" id="phone" placeholder="Ex: 0123456789">
                            <input type="hidden" id="full_phone" name="full_phone">
                        </div>

                        <div class="box1">
                            <label for="type">Type d'entreprise ou d'activité</label>
                            <input type="text" name="types" id="type"
                                placeholder="Ex: Technologie, Finance, Consultation">
                        </div>


                        <div class="box1">
                            <p>Photo de profil</p>
                            <div class="ab">
                                <div>
                                    <label class="label" for="images"> <img src="/image/caméra.png" alt=""></label>
                                    <input type="file" name="images" id="images"
                                        accept="image/jpeg,image/jpg, image/png, image/gif">
                                </div>
                                <div class="im">
                                    <img id="imagePreview" src="" alt="view">
                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="container">

                        <div class="box1">
                            <label for="taille">Taille de l'entreprise</label>
                            <select name="taille" id="taille">
                                <option value="1">1 personne</option>
                                <option value="2_10">Entre 2 et 10</option>
                                <option value="11_49">Entre 11 et 49</option>
                                <option value="femme">Entre 250 et 999</option>
                                <option value="femme">Entre 1000 et 4999</option>
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
                            <label for="ville">Ville</label>
                            <input type="text" name="ville" id="ville" placeholder="Ex: Paris">
                        </div>

                        <div class="box1">
                            <label for="passe">Mot de passe</label>
                            <input type="password" name="passe" id="passe" placeholder="Ex: ********">
                        </div>
                        <div class="box1">
                            <label for="cpasse">Confirmer mot de passe</label>
                            <input type="password" name="cpasse" id="cpasse" placeholder="Ex: ********">
                            <div class="view">
                                <p>Afficher le mot de passe</p>
                                <input type="checkbox" id="voirCPasse" onclick="showPassword()">
                            </div>
                        </div>


                        <input type="submit" name="valider" value="valider" id="valider">
                    </div>

                </div>

            </form>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

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

    <script>

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
                        callback("us");
                    });
            }
        });

        phoneInputField.addEventListener("blur", function () {
            fullPhoneInput.value = phoneInput.getNumber();
        });



        // Masquer la liste au clic sur le champ de téléphone
        phoneInputField.addEventListener('click', function () {
            phoneInput.closeDropdown();
        });

        // Masquer au clic en dehors du champ de téléphone
        document.addEventListener('click', function (e) {
            if (!phoneInputField.contains(e.target) && !phoneInput.container.contains(e.target)) {
                phoneInput.closeDropdown();
            }
        });
    </script>
</body>

</html>