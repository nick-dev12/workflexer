<?php
// Vérifie si un id est présent dans l'URL
if (isset($_GET['id'])) {
    header("Location: user_profil.php"); 
    exit();
  } 

?>