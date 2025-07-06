<?php
/**
 * Fichier de connexion à la base de données
 * 
 * Ce fichier établit une connexion sécurisée à la base de données MySQL
 * avec support UTF-8 pour les caractères spéciaux et gère les sessions.
 */

// Configuration des sessions sécurisées
if (session_status() == PHP_SESSION_NONE) {
    // Configuration de sécurité pour les sessions
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Mettre à 1 si HTTPS
    ini_set('session.cookie_lifetime', 0); // Session expire à la fermeture du navigateur
    ini_set('session.gc_maxlifetime', 3600); // 1 heure de durée de vie
    
    session_start();
    
    // Régénérer l'ID de session périodiquement pour la sécurité
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 300) { // Toutes les 5 minutes
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// Paramètres de connexion 
$db_host = "localhost";
$db_name = "projet1";

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
