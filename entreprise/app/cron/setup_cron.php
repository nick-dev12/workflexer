<?php
/**
 * Script pour configurer le cron job
 * 
 * Ce script est destiné à être exécuté une seule fois pour configurer le cron job
 * qui enverra les emails en attente toutes les 5 minutes.
 * 
 * Note: Ce script doit être exécuté sur un serveur Linux avec accès au crontab.
 * Pour Windows, vous devrez configurer une tâche planifiée manuellement.
 */

// Chemin absolu vers le script d'envoi d'emails
$scriptPath = dirname(__FILE__) . '/send_emails.php';

// Commande cron à ajouter
$cronCommand = "*/5 * * * * php $scriptPath >> " . dirname(__FILE__) . "/email_logs.log 2>&1";

// Afficher les instructions
echo "=================================================================\n";
echo "Configuration du cron job pour l'envoi d'emails en arrière-plan\n";
echo "=================================================================\n\n";

echo "Pour configurer le cron job automatiquement sur un serveur Linux, exécutez :\n\n";
echo "(crontab -l 2>/dev/null; echo \"$cronCommand\") | crontab -\n\n";

echo "Pour configurer manuellement :\n\n";
echo "1. Exécutez 'crontab -e' pour éditer votre crontab\n";
echo "2. Ajoutez la ligne suivante :\n";
echo "$cronCommand\n\n";

echo "Pour Windows, configurez une tâche planifiée :\n\n";
echo "1. Ouvrez le Planificateur de tâches\n";
echo "2. Créez une nouvelle tâche de base\n";
echo "3. Configurez-la pour qu'elle s'exécute toutes les 5 minutes\n";
echo "4. Commande à exécuter : php $scriptPath\n\n";

echo "=================================================================\n";
echo "Vérifiez que la table email_queue existe dans votre base de données.\n";
echo "Si ce n'est pas le cas, exécutez le script SQL fourni.\n";
echo "=================================================================\n";
?>