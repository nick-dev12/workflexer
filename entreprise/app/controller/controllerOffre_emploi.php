<?php

require_once(__DIR__ . '/../model/offre_emploi.php');
if (isset($_SESSION['compte_entreprise'])) {
    include('../model/users.php');
}


if (isset($_SESSION['users_id'])) {
    if (isset($_GET['entreprise_id']) && isset($_GET['id'])) {
    include('../model/users.php');
}
}

if (isset($_SESSION['users_id'])) {

    if (isset($_GET['entreprise_id']) && isset($_GET['users_id'])) {
    include('../model/users.php');
}

}

require('../model/vue_offre.php');


if (isset($_get['id'])) {
    $offre_id = $_GET['id'];
}


if (isset($_POST['modifier'])) {

      
    $poste = $_POST['poste'];


    $mission = $_POST['mission'];



    $profil = $_POST['profil'];



    $contrat = $_POST['contrat'];


    $etudes = $_POST['etude'];



    $experience = $_POST['experience'];



    $localite = $_POST['localite'];



    $langues = $_POST['langues'];


    if (updatOffre($db, $poste, $mission, $profil, $contrat, $etudes, $experience, $localite, $langues, $offre_id)) {
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



if (isset($_GET['id'])) {

    $afficheOffres = getOffresEmploit($db, $_GET['id']);

    if (isset($_SESSION['users_id'])) {

        $getVueOffre= getVueOffre($db,$_SESSION['users_id'],$_GET['id']);

        if($getVueOffre){
  
        }else{
           $users_id = $_SESSION['users_id'];

        $getInfo = getInfoUsers($db, $_SESSION['users_id']);

        $entreprise_id = $_GET['entreprise_id'];
        $nom = $getInfo['nom'];
        $mail = $getInfo['mail'];
        $offre_id = $_GET['id'];

        if (postVue ($db,$offre_id,$users_id, $entreprise_id,$nom,$mail)) {
           
        }
        }
       

    }


}

if (isset($_SESSION['compte_entreprise'])) {
   if(isset($_GET['offre_id'])){

    $offre_id= $_GET['offre_id'];
    if(deleteOffresEmploit($db,$offre_id)){
        $_SESSION['delete_message']='offre suprimer avec succet';
        header('Location: ../entreprise/entreprise_profil.php');
        exit();
    }

}
}


$afficheAllOffre = getAllOffres($db);
shuffle($afficheAllOffre);

?>