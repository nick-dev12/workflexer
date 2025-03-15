<?php

require_once(__DIR__ . '/../model/postulation.php');

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

        if (isset($db)) {

            $sql = "SELECT * FROM offre_emploi WHERE offre_id = :offre_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':offre_id', $offre_id);
            $stmt->execute();
            $info_offre = $stmt->fetch(PDO::FETCH_ASSOC);

            // recuperer les informations du candidat
            $sql = "SELECT * FROM niveau_etude WHERE users_id = :users_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':users_id', $users_id);
            $stmt->execute();
            $info_users = $stmt->fetch(PDO::FETCH_ASSOC);

            // recuperer la catégorie du candidat
            // Récupérer la catégorie du candidat
            $sql = "SELECT * FROM users WHERE id = :users_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
            $stmt->execute();
            $infoUsers = $stmt->fetch(PDO::FETCH_ASSOC);

        }


        // Vérifie si le candidat est dans la même catégorie que l'offre
        $categorieUsers = $infoUsers['categorie'];



        if ($info_users['n_etude'] >= $info_offre['n_etudes'] && $info_users['n_experience'] >= $info_offre['n_experience']) {
            if (notification_postulation($db, $entreprise_id, $users_id)) {

            }


            if (postCandidature($db, $entreprise_id, $poste, $offre_id, $users_id, $nom, $maile, $phone, $competences, $profession, $statut, $images, $categorie)) {
                $_SESSION['success_message'] = 'Postulation réussi !!';

                header('Location: ../page/user_profil.php');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Vous devez avoir au moins ' . $info_offre['n_etudes'] . ' années d\'études et ' . $info_offre['n_experience'] . ' années d\'expérience pour postuler';
            header('Location: voir_offre.php?offres_id=' . $offre_id);
            exit();
        }

    }



    $getPostulationUsers = getPostulationUsers($db, $_SESSION['users_id']);

}


