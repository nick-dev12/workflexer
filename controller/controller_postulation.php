<?php

require_once(__DIR__ . '/../model/postulation.php');
require_once(__DIR__ . '/../model/profile_matching.php');

require '../vendor/autoload.php';


if (isset($_SESSION['compte_entreprise'])) {
    $countAllPostulation = countALLPostulation($db, $_SESSION['compte_entreprise']);
    $countPostulationAccepte = countALLPostulationAccept($db, $_SESSION['compte_entreprise']);
    $countPostulationRecqler = countALLPostulationRecaler($db, $_SESSION['compte_entreprise']);
    $getALLpostulations = getALLPostulations($db, $_SESSION['compte_entreprise']);
    // $offre_id = $getALLpostulation['offre_id'];
    $getAllcategorie = getALLcategorie($db);
    if (isset($_GET['id'])) {
        $getAllPostulation_users = getALLPostulation_users($db, $_SESSION['compte_entreprise'], $_GET['id']);
    }
    // $affichePostulant=affichePostulant($db,$offre_id);
}

if (isset($_GET['offres_id'])) {
    if (isset($_SESSION['users_id'])) {
        $getPostulation = getPostulation($db, $_SESSION['users_id'], $_GET['offres_id']);
    }
}


if (isset($_SESSION['users_id'])) {

    $getPostulationUsers = getPostulationUsers($db, $_SESSION['users_id']);
}

if (isset($_POST['postuler'])) {
    $entreprise_id = $offre_id = $users_id = $nom = $maile = $phone = $competances = $statut = $profession = '';

    $offre_id = $_GET['offres_id'];

    $Offres = getOffres($db, $offre_id);

    $poste = $Offres['poste'];

    $categorie = $Offres['categorie'];

    $entreprise_id = $Offres['entreprise_id'];

    $users_id = $_POST['id_users'];

    $nom = $_POST['nom_users'];

    $maile = $_POST['mail_users'];

    $phone = $_POST['phone_users'];

    $competences = $_POST['competence_users'];

    $profession = $_POST['profession_users'];

    $images = $_POST['images_users'];

    // Vérifier la correspondance entre le profil du candidat et l'offre
    $matchResult = checkProfileJobMatch($db, $users_id, $offre_id);

    // Vérifier si le niveau d'étude et d'expérience est suffisant
    if (!$matchResult['niveauEtudeMatch'] || !$matchResult['niveauExperienceMatch']) {
        $_SESSION['error_message'] = 'Vous devez avoir au moins ' . $Offres['n_etudes'] . ' années d\'études et ' . $Offres['n_experience'] . ' années d\'expérience pour postuler';
        header('Location: voir_offre.php?offres_id=' . $offre_id);
        exit();
    }

    // Si tout est OK, envoyer la candidature
    if (notification_postulation($db, $entreprise_id, $users_id, $offre_id, $poste)) {
        error_log("Notification envoyée avec succès pour la candidature de l'utilisateur $users_id à l'offre $offre_id");
        // Notification envoyée
    }

    if (postCandidature($db, $entreprise_id, $poste, $offre_id, $users_id, $nom, $maile, $phone, $competences, $profession, $statut, $images, $categorie)) {
        $_SESSION['success_message'] = 'Postulation réussie !';
        header('Location: ../page/user_profil.php');
        exit();
    }
}

// Si l'utilisateur consulte une offre, calculer le taux de correspondance
if (isset($_GET['offres_id']) && isset($_SESSION['users_id'])) {
    $offre_id = $_GET['offres_id'];
    $users_id = $_SESSION['users_id'];

    // Vérifier si le candidat a déjà postulé
    $getPostulation = getPostulation($db, $users_id, $offre_id);

    // Si non, calculer le taux de correspondance pour les niveau d'études et d'expérience seulement
    if (!$getPostulation) {
        $matchResult = checkProfileJobMatch($db, $users_id, $offre_id);
        // Stocker le résultat dans une variable de session pour l'afficher dans la vue
        $_SESSION['match_result'] = [
            'niveauEtudeMatch' => $matchResult['niveauEtudeMatch'],
            'niveauExperienceMatch' => $matchResult['niveauExperienceMatch']
        ];
    }
}


