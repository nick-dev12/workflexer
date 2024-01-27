<?php
require_once( __DIR__.'/../model/appelle_offre.php');

if (isset($_SESSION['compte_entreprise'])) {
    $getAllAppel_offre = getAllAppelOffre($db,$_SESSION['compte_entreprise']);
    if (isset($_GET['id'])) {
        $getappelOffre = getAppelOffreUsers($db,$_GET['id'],$_SESSION['compte_entreprise']);
    }
    
}

if (isset($_SESSION['users_id'])) {
    $getAllAppel_offre = getAllAppelOffreUsers($db,$_SESSION['users_id']);
}

?>