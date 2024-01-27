<?php
include( __DIR__.' /../model/message1.php');
require_once( __DIR__.'/../model/appelle_offre.php');

if (isset($_GET['entreprise_id'])) {

  if(isset($_SESSION['compte_entreprise'])){

  $afficheMessage2 = getMessage2($db,$_SESSION['compte_entreprise'],$_GET['users_id']);

  if (isset($_POST['envoyer1'])) {

    $entreprise_id = $_GET['entreprise_id'];
    $offre_id = '';
    $users_id = $_GET['users_id'];
    if(isset($_GET['statut'])){
      $statut = $_GET['statut'];
    }else{
      $statut = '';
    }
    $messages = nl2br($_POST['messages']) ;
    $indicatif= 'recruteur';
  
    if (postMessage1($db,$entreprise_id,$users_id,$offre_id,$statut,$messages,$indicatif)) {
     // Assurez-vous de terminer le script après la redirection
    }
       header("Location: message_entreprise2.php?entreprise_id=".$_GET['entreprise_id']."&users_id=".$_GET['users_id']);
      exit; 
  }
}
}

if (isset($_GET['users_id'])) {
  
  if(isset($_SESSION['users_id'])){

  $afficheMessage2 = getMessage2($db,$_GET['entreprise_id'],$_GET['users_id']);

  if (isset($_POST['envoyer1'])) {

    $entreprise_id = $_GET['entreprise_id'];
    $offre_id = '';
    $users_id = $_GET['users_id'];
    if(isset($_GET['statut'])){
      $statut = $_GET['statut'];
    }else{
      $statut = '';
    }
    $messages = nl2br($_POST['messages']) ;
    $indicatif= 'candidat';
  
    if (postMessage1($db,$entreprise_id,$users_id,$offre_id,$statut,$messages,$indicatif)) {
     // Assurez-vous de terminer le script après la redirection
    }
       header("Location: get_message_users2.php?entreprise_id=".$_GET['entreprise_id']."&users_id=".$_GET['users_id']);
      exit; 
  }
}
}







if (isset($_GET['offres_id'])) {

   if(isset($_SESSION['compte_entreprise'])){
   $afficheMessage1 = getMessage1($db,$_SESSION['compte_entreprise'],$_GET['offres_id'],$_GET['users_id']);
   
    if (isset($_POST['envoyer'])) {

      $entreprise_id = $_GET['entreprise_id'];
      $offre_id = $_GET['offres_id'];
      $users_id = $_GET['users_id'];
      if(isset($_GET['statut'])){
        $statut = $_GET['statut'];
      }else{
        $statut = '';
      }
      $messages = nl2br($_POST['messages']) ;
      $indicatif= 'recruteur';
    
      if (postMessage1($db,$entreprise_id,$users_id,$offre_id,$statut,$messages,$indicatif)) {
       // Assurez-vous de terminer le script après la redirection
      }
         header("Location: message_entreprise.php?offres_id=".$_GET['offres_id']."&entreprise_id=".$_GET['entreprise_id']."&users_id=".$_GET['users_id']."&statut=".$_GET['statut']);
        exit; 
    }
}


if(isset($_SESSION['users_id'])){
  $afficheMessage1 = getMessage1($db,$_GET['entreprise_id'],$_GET['offres_id'],$_GET['users_id']);

   if (isset($_POST['envoyer'])) {

     $entreprise_id = $_GET['entreprise_id'];
     $offre_id = $_GET['offres_id'];
     $users_id = $_GET['users_id'];
    if(isset($_GET['statut'])){
      $statut = $_GET['statut'];
    }else{
      $statut = '';
    }
    $messages = nl2br($_POST['messages']) ;
     $indicatif= 'candidat';
   
     if (postMessage1($db,$entreprise_id,$users_id,$offre_id,$statut,$messages,$indicatif)) {
       
     }
       header("Location: get_message_users.php?offres_id=".$_GET['offres_id']."&entreprise_id=".$_GET['entreprise_id']."&users_id=".$_GET['users_id']."&statut=".$_GET['statut']);
       exit();
   }
}
}

if(isset($_GET['id'])){
  if (isset($_POST['send'])) {

    $entreprise_id = $_SESSION['compte_entreprise'];
    $offre_id = '';
    $users_id = $_GET['id'];
     $statut = '';
    $messages = nl2br($_POST['message']) ;
    $indicatif= 'recruteur';
  
    if (postMessage1($db,$entreprise_id,$users_id,$offre_id,$statut,$messages,$indicatif)) {
     
    }

    $titre = $_POST['titre'];
    if(postAppelOffre ($db,$entreprise_id,$users_id,$titre,$messages)){
      header('Location: ../entreprise/message.php');
      exit;
    }
     
  }
}

if (isset($_GET['suprime'])) {
  $message_id = $_GET['suprime'];
  if(deletMessage ( $db, $message_id)){

header("Location: ../page/message_users.php" );
exit();
  }
}


$afficheAutreMessageEntreprise = getAutreMessageEntreprise($db,);

?>