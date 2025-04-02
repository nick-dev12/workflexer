<?php
// Script pour installer la table des tokens FCM pour les candidats
header('Content-Type: text/html; charset=utf-8');
echo '<h1>Configuration des notifications pour les candidats</h1>';

require_once(__DIR__ . '/migrations/create_fcm_tokens_users_table.php');

echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
?>