<?php
include(__DIR__ . '../../../../model/vue_offre.php');
require_once(__DIR__ . '/../model/offre_emploi.php');
include('controllerEntreprise.php');
if (isset($_SESSION['compte_entreprise'])) {
    include('../controller/controller_users.php');

    $categorie_offre = get_categorieOffre ($db, $_SESSION['compte_entreprise']);
    if (isset($_GET['categorie'])) {
        $categorie = $_GET['categorie'];
        $OffresEmplois =  get_poste($db, $_SESSION['compte_entreprise'] , $categorie);
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
        if (deleteOffresEmploit($db, $offre_id)) {
            if (deletePostulation($db, $offre_id)) {
                $sql = "DELETE FROM historique_users WHERE offre_id= :offre_id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(":offre_id", $offre_id, PDO::PARAM_STR);
                $stmt->execute();
                $_SESSION['success_message'] = 'Offre suprimer';
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

?>