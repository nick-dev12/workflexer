<?php
include(__DIR__ . '../../../../model/vue_offre.php');
require_once(__DIR__ . '/../model/offre_emploi.php');
include('controllerEntreprise.php');
if (isset($_SESSION['compte_entreprise'])) {
    include('../controller/controller_users.php');

    $categorie_offre = get_categorieOffre($db, $_SESSION['compte_entreprise']);
    if (isset($_GET['categorie'])) {
        $categorie = $_GET['categorie'];
        $OffresEmplois = get_poste($db, $_SESSION['compte_entreprise'], $categorie);
    }
}


if (isset($_SESSION['users_id'])) {
    include(__DIR__ . '../../../../controller/controller_niveau_etude_experience.php');
    include(__DIR__ . '../../../../controller/controller_description_users.php');
    if (isset($_GET['entreprise_id']) && isset($_GET['offres_id'])) {
        include('../controller/controller_users.php');
    }
}

if (isset($_SESSION['users_id'])) {
    if (isset($_GET['entreprise_id']) && isset($_GET['users_id'])) {
        include('../controller/controller_users.php');
    }
}



if (isset($_get['offres_id'])) {
    $offre_id = $_GET['offres_id'];
}


if (isset($_POST['modifier'])) {

    $poste = $_POST['poste'];

    $mission = $_POST['mission'];

    $profil = $_POST['profil'];


    $contrat = htmlspecialchars($_POST['contrat']);


    $etudes = htmlspecialchars($_POST['etude']);


    $experience = htmlspecialchars($_POST['experience']);


    $localite = htmlspecialchars($_POST['localite']);


    $langues = htmlspecialchars($_POST['langues']);

    $categorie = htmlspecialchars($_POST['categorie']);

    if (updatOffre($db, $poste, $mission, $profil, $contrat, $etudes, $experience, $localite, $langues, $categorie, $offre_id)) {
        $_SESSION['success_message'] = 'modification réussit !!!';
        header('Location: updat_offre.php');
        exit();
    }
}






$offreInformatique = getOffreInformatique($db);
shuffle($offreInformatique);

$offreMarcketing = getOffremarketing($db);
shuffle($offreMarcketing);

$offreJuridique = getOffreJuridique($db);
shuffle($offreJuridique);

$offreBusiness = getOffrebusiness($db);
shuffle($offreBusiness);

$offreRedaction = getOffreRédaction($db);
shuffle($offreRedaction);

$offreDesing = getOffreDesign($db);
shuffle($offreDesing);

$offreIngenierie = getOffreIngenieur($db);
shuffle($offreIngenierie);



if (isset($_GET['entreprise_id'])) {

    $afficheOffres = getOffresEmploit($db, $_GET['entreprise_id']);

}



if (isset($_GET['offres_id']) and isset($_GET['entreprise_id'])) {

    $afficheOffres = getOffresEmploit($db, $_GET['offres_id']);

    $offre_id = $afficheOffres['offre_id'];

    if (isset($_SESSION['users_id'])) {

        $getVueOffre = getVueOffre($db, $_SESSION['users_id'], $_GET['offres_id']);
        if ($getVueOffre) {

        } else {
            $users_id = $_SESSION['users_id'];

            $getInfo = getInfoUsers($db, $_SESSION['users_id']);

            $entreprise_id = $_GET['entreprise_id'];
            $nom = $getInfo['nom'];
            $mail = $getInfo['mail'];
            $offre_id = $_GET['offres_id'];

            if (postVue($db, $offre_id, $users_id, $entreprise_id, $nom, $mail)) {

            }

            if (PostHistoriqueUsers($db, $entreprise_id, $users_id, $offre_id)) {

            }
        }

    }


}

if (isset($_SESSION['compte_entreprise'])) {
    if (isset($_GET['offre_id'])) {

        $offre_id = $_GET['offre_id'];

        $get_info_offre = getOffres($db, $offre_id);


        $poste = $mission = $profil = $metier = $contrat = $etudes = $regions = $experience = $langues = '';

        $entreprise_id = $_SESSION['compte_entreprise'];

        $poste = $get_info_offre['poste'];

        $mission = $get_info_offre['mission'];

        $profil = $get_info_offre['profil'];

        $contrat = $get_info_offre['contrat'];

        $etudes = $get_info_offre['etudes'];

        $n_etudes = $get_info_offre['n_etudes'];

        $experience = $get_info_offre['experience'];

        $n_experience = $get_info_offre['n_experience'];

        $localite = $get_info_offre['localite'];

        $langues = $get_info_offre['langues'];

        $places = $get_info_offre['places'];

        $date_expiration = $get_info_offre['date_expiration'];

        $categorie = $get_info_offre['categorie'];

        $date = $get_info_offre['date'];



        if (post_suprime_offre($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $categorie, $date)) {

        }
        if (deleteOffresEmploit($db, $offre_id)) {
            if (deletePostulation($db, $offre_id)) {
                $sql = "DELETE FROM historique_users WHERE offre_id= :offre_id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(":offre_id", $offre_id, PDO::PARAM_STR);
                $stmt->execute();
                $_SESSION['success_message'] = 'Offre suprimé';
                header('Location: ../entreprise/entreprise_profil.php');
                exit();
            }

        }

    }
}


$afficheAllOffre = getAllOffres($db);
shuffle($afficheAllOffre);

if (isset($_SESSION['users_id'])) {
    $historique_users = getHistoriqueUsers($db, $_SESSION['users_id']);

}

$getAlloffres_emploi = getAllOffres($db);

if (isset($_GET['restore'])) {
    $offre_id = $_GET['restore'];
    $info_offre = getOffresEmploit($db, $offre_id);
    $date_aujourdhui = date('Y-m-d');
    $new_date_expiration = date('Y-m-d', strtotime($date_aujourdhui . ' +14 days'));
    if (restoreOffre($db, $offre_id, $_SESSION['compte_entreprise'], $new_date_expiration)) {
        $_SESSION['success_message'] = 'L\'offre a été republiée';
        header('Location: ../entreprise/offre_expirer.php');
        exit();
    }
}

if (isset($_GET['restorer'])) {
    $offre_id = $_GET['restorer'];
    $info_offre = getOffres_suprimer($db, $offre_id);
    $date_aujourdhui = date('Y-m-d');
    $new_date_expiration = date('Y-m-d', strtotime($date_aujourdhui . ' +14 days'));
    if (restorerOffre($db, $offre_id, $_SESSION['compte_entreprise'], $new_date_expiration)) {

    }

    $get_info_offre = getOffres_suprimer($db, $offre_id);


    $poste = $mission = $profil = $metier = $contrat = $etudes = $regions = $experience = $langues = '';

    $entreprise_id = $_SESSION['compte_entreprise'];

    $poste = $get_info_offre['poste'];

    $mission = $get_info_offre['mission'];

    $profil = $get_info_offre['profil'];

    $contrat = $get_info_offre['contrat'];

    $etudes = $get_info_offre['etudes'];

    $n_etudes = $get_info_offre['n_etudes'];

    $experience = $get_info_offre['experience'];

    $n_experience = $get_info_offre['n_experience'];

    $localite = $get_info_offre['localite'];

    $langues = $get_info_offre['langues'];

    $places = $get_info_offre['places'];

    $date_expiration = $get_info_offre['date_expiration'];

    $categorie = $get_info_offre['categorie'];

    $date = $get_info_offre['date'];

    if (postOffres($db, $entreprise_id, $poste, $mission, $profil, $contrat, $etudes, $experience, $n_etudes, $n_experience, $localite, $langues, $places, $date_expiration, $categorie, $date)) {

    }


    if (deleteOffresEmploit_suprimer($db, $offre_id)) {
        $_SESSION['success_message'] = 'L\'offre a été republiée';
        header('Location: ../entreprise/entreprise_profil.php');
        exit();
    }

}

if (isset($_GET['offre_id_suprime'])) {
    $offre_id = $_GET['offre_id_suprime'];
    if (deleteOffresEmploit_suprimer($db, $offre_id)) {
        $_SESSION['success_message'] = 'L\'offre a été suprimée';
        header('Location: ../entreprise/entreprise_profil.php');
        exit();
    }
}

