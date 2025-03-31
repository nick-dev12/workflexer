<?php
// Démarre la session
session_start();


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['users_id']) || empty($_SESSION['users_id'])) {
    // Rediriger vers la page de connexion ou une autre page appropriée
    header('Location: ../connection_compte.php');
    exit();
}

if (isset($_GET['id'])) {
    // Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_GET['id'];

    // Vous pouvez maintenant utiliser $commercant_id pour récupérer les informations de l'utilisateur depuis la base de données
    // Écrivez votre requête SQL pour récupérer les informations nécessaires
    $conn = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $erreurs = '';

    $message = '';


    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_centre_interet.php');
    include_once('../controller/controller_niveau_etude_experience.php');
} else {




    $erreurs = '';

    $message = '';




    // Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session

    // Récupérer l'id du métier à supprimer (via lien ou formulaire par exemple)

    include_once('../controller/controller_document_users.php');
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_centre_interet.php');
    include_once('../entreprise/app/controller/controllerOffre_emploi.php');
    include_once('../entreprise/app/controller/controllerEntreprise.php');
    include_once('../controller/controller_niveau_etude_experience.php');
}

?>





<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/cv_users.css">
    <link rel="stylesheet" href="../css/navbare.css">

</head>

<body>

    <?php include('../navbare.php') ?>

    <?php include('../include/header_users.php') ?>



    <section class="section3">
        <div class="page-intro">
            <h2>Modèles de CV Professionnels</h2>
            <p>Choisissez parmi notre collection de modèles de CV élégants et professionnels pour mettre en valeur vos
                compétences et votre expérience.</p>
            <p>Cliquez sur un modèle pour le visualiser et l'utiliser pour créer votre CV personnalisé.</p>
        </div>

        <div class="model">
            <a href="../model_cv/model1.php" target="_blank">
                <img src="../image/cv1.png" alt="CV Modèle Classique">
                <div class="model-info">
                    <h3>Modèle Classique</h3>
                    <p>Design épuré et professionnel</p>
                </div>
            </a>
            <a href="../model_cv/model10.php" target="_blank">
                <img src="../image/cv11.png" alt="CV Modèle Turquoise">
                <div class="model-info">
                    <h3>Modèle Turquoise</h3>
                    <p>Design moderne avec accents turquoise</p>
                </div>
            </a>
            <a href="../model_cv/model7.php" target="_blank">
                <img src="../image/cv8.png" alt="CV Modèle Moderne">
                <div class="model-info">
                    <h3>Modèle Moderne</h3>
                    <p>Style contemporain avec accents de couleur</p>
                </div>
            </a>
            <a href="../model_cv/model3.php" target="_blank">
                <img src="../image/cv3.png" alt="CV Modèle Créatif">
                <div class="model-info">
                    <h3>Modèle Créatif</h3>
                    <p>Mise en page originale pour se démarquer</p>
                </div>
            </a>
            <a href="../model_cv/model5.php" target="_blank">
                <img src="../image/cv6.png" alt="CV Modèle Exécutif">
                <div class="model-info">
                    <h3>Modèle Exécutif</h3>
                    <p>Style sobre et élégant pour cadres</p>
                </div>
            </a>
            <a href="../model_cv/model8.php" target="_blank">
                <img src="../image/cv9.png" alt="CV Modèle Moderne professionnel">
                <div class="model-info">
                    <h3>Modèle Moderne professionnel</h3>
                    <p>Design épuré et moderne avec des touches de vert</p>
                </div>
            </a>
            <a href="../model_cv/model2.php" target="_blank">
                <img src="../image/cv2.png" alt="CV Modèle Minimaliste">
                <div class="model-info">
                    <h3>Modèle Minimaliste</h3>
                    <p>Design simple et efficace</p>
                </div>
            </a>
            <a href="../model_cv/model6.php" target="_blank">
                <img src="../image/cv7.png" alt="CV Modèle Chronologique">
                <div class="model-info">
                    <h3>Modèle Chronologique</h3>
                    <p>Parfait pour mettre en avant votre parcours</p>
                </div>
            </a>
            <a href="../model_cv/model4.php" target="_blank">
                <img src="../image/cv4.png" alt="CV Modèle Technique">
                <div class="model-info">
                    <h3>Modèle Technique</h3>
                    <p>Idéal pour les profils IT et ingénierie</p>
                </div>
            </a>

            <a href="../model_cv/model9.php" target="_blank">
                <img src="../image/cv10.png" alt="CV Modèle Blue Header">
                <div class="model-info">
                    <h3>Modèle Blue Header</h3>
                    <p>Style professionnel avec bannière bleue</p>
                </div>
            </a>

        </div>

        <div class="cta-section">
            <h3>Besoin d'aide pour créer votre CV?</h3>
            <p>Nos modèles sont conçus pour vous aider à mettre en valeur vos compétences et votre expérience de la
                meilleure façon possible.</p>
            <a href="#" class="cta-button">Commencer mon CV</a>
        </div>
    </section>

</body>

</html>