<?php

// Démarre la session
session_start();

include '../conn/conn.php';
if (isset($_SESSION['admin'])) {
    header('location: ../index.php'); // Rediriger vers la page du tableau de bord
    exit();
}
// Inclusion du fichier de connexion à la BDD


// Déclaration d'un tableau pour stocker les erreurs
$erreurs = ''; // Initialisez un tableau pour stocker les erreurs

// Vérification si le bouton valider est cliqué
if (isset($_POST['valider'])) {
    // Récupération des données du formulaire
    // Déclaration des variables 
    $nom = $email = $phone = $types = $taille = $entreprise = $images = $ville = $categorie = $passe = $cpasse = '';

    $id = uniqid();

    $id2 = uniqid();

    // Vérification du nom
    if (empty($_POST['nom'])) {
        $erreurs = "Le nom est obligatoire";
    } else {
        $nom = htmlspecialchars($_POST['nom']); // Échapper les caractères spéciaux
    }

    // Vérification du mail
    if (empty($_POST['mail'])) {
        $erreurs = "email est obligatoire";
    } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $erreurs = "L'email n'est pas valide";
    } else {
        $email = $_POST['mail'];

        // Préparer la requête SQL pour vérifier si l'e-mail est déjà utilisé
        $query = $db->prepare("SELECT * FROM admin WHERE mail = :mail");
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



    // $nom = $_POST['nom'];
    // $entreprise = $_POST['entreprise'];
    // $mail = $_POST['mail'];
    // $phone = $_POST['phone'];
    // $taille = $_POST['taille'];
    // $categorie = $_POST['categorie'];
    // $ville = $_POST['ville'];
    // $passe = $_POST['passe'];
    // $cpasse = $_POST['cpasse'];

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
            $targetFile = '../upload/' . $uniqueFileName;
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


        // Requête SQL pour l'insertion des données
        $sql = "INSERT INTO admin (nom, mail, phone, image, passe) 
                VALUES ( :nom, :mail, :phone,:image,:passe)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':image', $uniqueFileName);
        $stmt->bindParam(':passe', $passe);
        // Exécution de la requête
        $stmt->execute();

        header('Location: connexion.php');
        exit;
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
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
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

    <?php include('../navbare.php') ?>


    <section class="section2">
        <img class="img" src="/image/work.jpeg" alt="">
        <div class="formulaire1  ">
            <form method="post" action="" enctype="multipart/form-data">
                <h3>Admin</h3>
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
                            <p>Photo de profile</p>
                            <div class="ab">
                                <div>
                                    <label class="label" for="images"> <img src="/image/galerie.jpg" alt=""></label>
                                    <input type="file" name="images" id="images">
                                </div>
                                <div class="im">
                                    <img id="imagePreview" src="" alt="view">
                                </div>

                            </div>
                        </div>

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
</body>

</html>