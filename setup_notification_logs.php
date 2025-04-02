<?php
// Script pour installer la table de logs de notifications
header('Content-Type: text/html; charset=utf-8');
echo '<h1>Configuration des logs de notifications</h1>';

require_once(__DIR__ . '/migrations/create_notification_logs_table.php');

echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
?>