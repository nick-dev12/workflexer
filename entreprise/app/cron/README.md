# Système d'envoi d'emails asynchrone pour Work-Flexer

Ce système permet d'envoyer des emails en arrière-plan sans bloquer l'interface utilisateur, ce qui est particulièrement important lorsque vous avez de nombreux destinataires.

## Fonctionnement

1. Les emails sont stockés dans une file d'attente (table `email_queue` dans la base de données).
2. Un script exécuté par un cron job (ou une tâche planifiée sous Windows) envoie les emails en attente toutes les 5 minutes.
3. Les emails sont envoyés par lots pour éviter de surcharger le serveur SMTP.
4. Les emails qui échouent sont marqués comme tels et peuvent être réessayés jusqu'à 3 fois.
5. Les emails anciens sont automatiquement nettoyés après 30 jours.

## Installation

### 1. Créer la table email_queue

Exécutez le script SQL suivant pour créer la table `email_queue` dans votre base de données:

```sql
CREATE TABLE IF NOT EXISTS `email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destinataire` varchar(255) NOT NULL,
  `nom_destinataire` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `statut` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `tentatives` int(11) NOT NULL DEFAULT 0,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_envoi` timestamp NULL DEFAULT NULL,
  `erreur` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statut` (`statut`),
  KEY `date_creation` (`date_creation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

Vous pouvez également exécuter le script `test_email_queue.php` qui créera la table si elle n'existe pas.

### 2. Configurer le cron job

#### Sous Linux/Unix

Exécutez la commande suivante pour ajouter le cron job:

```bash
(crontab -l 2>/dev/null; echo "*/5 * * * * php /chemin/vers/send_emails.php >> /chemin/vers/email_logs.log 2>&1") | crontab -
```

Remplacez `/chemin/vers/` par le chemin absolu vers les fichiers.

#### Sous Windows

1. Ouvrez le Planificateur de tâches
2. Créez une nouvelle tâche de base
3. Configurez-la pour qu'elle s'exécute toutes les 5 minutes
4. Commande à exécuter : `php C:\chemin\vers\send_emails.php`

### 3. Tester le système

Exécutez le script `test_email_queue.php` pour ajouter un email de test à la file d'attente:

```bash
php test_email_queue.php
```

Puis exécutez manuellement le script `send_emails.php` pour envoyer les emails en attente:

```bash
php send_emails.php
```

## Utilisation

Pour ajouter un email à la file d'attente, utilisez la fonction `ajouterEmailQueue`:

```php
require_once('path/to/email_queue.php');

$destinataire = 'user@example.com';
$nom = 'John Doe';
$sujet = 'Sujet de l\'email';
$message = '<html><body><h1>Hello World!</h1></body></html>';

ajouterEmailQueue($db, $destinataire, $nom, $sujet, $message);
```

## Surveillance et maintenance

- Les logs d'envoi d'emails sont stockés dans le fichier `email_logs.log`.
- Vous pouvez consulter la table `email_queue` pour voir les emails en attente, envoyés ou en échec.
- Les emails qui ont échoué 3 fois ne seront plus réessayés.
- Les emails anciens (envoyés ou en échec définitif) sont automatiquement supprimés après 30 jours.

## Sécurité

- Les informations sensibles comme les mots de passe SMTP devraient être stockées dans un fichier de configuration sécurisé, pas directement dans le code.
- Assurez-vous que les fichiers de script ne sont pas accessibles publiquement via le web.
- Utilisez des connexions sécurisées (SSL/TLS) pour l'envoi d'emails. 