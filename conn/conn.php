<?php

// Paramètres de connexion 
$db_host = "180.149.197.146";
$db_name = "jomas_work_flexer";

// Identifiants fournis par CPanel
$db_user = "jomas_jomas";
$db_pass = "Ludvanne12@gmail.com";

try {
  // Connexion à la base avec PDO
  $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

  // Gestion des erreurs
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  echo $e->getMessage();
}

?>