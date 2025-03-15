<?php
/**
 * Fichier de connexion à la base de données
 * 
 * Ce fichier établit une connexion sécurisée à la base de données MySQL
 * avec support UTF-8 pour les caractères spéciaux.
 */

// Paramètres de connexion 
$db_host = "localhost";
$db_name = "workflexer";

// Identifiants fournis par CPanel
$db_user = "root";
$db_pass = "";

try {
  // Connexion à la base avec PDO et configuration UTF-8
  $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_PERSISTENT => true // Connexion persistante pour améliorer la performance
  ];

  $db = new PDO($dsn, $db_user, $db_pass, $options);

} catch (PDOException $e) {
  // Gestion des erreurs améliorée
  error_log("Erreur de connexion à la base de données: " . $e->getMessage());
  die("Une erreur est survenue lors de la connexion à la base de données. Veuillez contacter l'administrateur.");
}
