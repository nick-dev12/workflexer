# Système de Gestion des Candidatures - WorkFlexer

![Logo WorkFlexer](https://work-flexer.com/image/logo%202.png)

## Description

Ce module fait partie de la plateforme WorkFlexer et permet aux entreprises de gérer efficacement les candidatures reçues pour leurs offres d'emploi. Il offre une interface intuitive pour visualiser, rechercher, filtrer et traiter (accepter ou refuser) les candidatures individuellement ou en lot.

## Fonctionnalités

### Interface de Gestion

- **Vue d'ensemble** : Statistiques par poste (total, non traités, acceptés, refusés)
- **Visualisation** : Mode grille/liste pour afficher les candidatures
- **Recherche** : Filtrage par nom ou compétences du candidat
- **Filtrage** : Par statut (tous, non traités, acceptés, refusés)

### Traitement des Candidatures

- **Actions individuelles** : Accepter/refuser un candidat avec un clic
- **Actions en lot** : Sélectionner plusieurs candidats et les traiter simultanément
- **Notifications automatiques** : Emails personnalisés envoyés aux candidats

### Système d'Emails en Arrière-plan

- **File d'attente d'emails** : Évite de surcharger le serveur SMTP
- **Traitement asynchrone** : Envoi via une tâche planifiée (toutes les 5 minutes)
- **Gestion des erreurs** : Tentatives multiples en cas d'échec d'envoi

## Installation

### Prérequis

- PHP 7.4 ou supérieur
- MySQL/MariaDB
- Un serveur web (Apache, Nginx, etc.)
- Accès pour configurer des tâches planifiées

### Configuration

1. Clonez le dépôt dans votre environnement web
2. Importez la structure de base de données depuis `database/schema.sql`
3. Configurez les paramètres de connexion dans `conn/conn.php`
4. Configurez les paramètres SMTP dans `entreprise/app/cron/send_emails.php`

### Mise en place de la tâche planifiée

#### Windows

1. Exécutez `entreprise/app/cron/setup_windows_task.bat` en tant qu'administrateur
2. OU utilisez le Planificateur de tâches Windows pour exécuter `send_emails.php` toutes les 5 minutes

#### Linux/Unix

Ajoutez cette ligne à votre crontab :

```bash
*/5 * * * * php /chemin/complet/vers/entreprise/app/cron/send_emails.php
```

## Guide d'utilisation

### Accès à l'interface

1. Connectez-vous en tant qu'entreprise
2. Accédez à la section "Postulation" du tableau de bord
3. Sélectionnez un poste pour voir les candidatures associées

### Traitement individuel

- Visualisez les informations d'un candidat sur sa carte
- Cliquez sur "Accepter" ou "Refuser" pour traiter la candidature
- Un email sera automatiquement mis en file d'attente pour notifier le candidat

### Traitement en lot

1. Utilisez les cases à cocher pour sélectionner plusieurs candidats
   - Le bouton "Sélectionner tous les non traités" permet une sélection rapide
2. Le compteur indique le nombre de candidats sélectionnés
3. Cliquez sur "Accepter la sélection" ou "Refuser la sélection"
4. Confirmez votre action

## Structure du Code

### Fichiers Principaux

- `entreprise/candidatures_poste.php` : Interface principale
- `entreprise/traiter_candidatures.php` : Traitement des actions en lot
- `entreprise/app/model/email_templates.php` : Modèles d'emails
- `entreprise/app/model/email_queue.php` : Gestion de la file d'attente
- `entreprise/app/cron/send_emails.php` : Script d'envoi des emails

### Base de Données

- Table `postulation` : Informations sur les candidatures
- Table `email_queue` : File d'attente des emails
- Table `notification_suivi` : Notifications internes

## Personnalisation

### Modèles d'Emails

Pour modifier les emails envoyés aux candidats, éditez les fonctions dans `entreprise/app/model/email_templates.php` :

- `generateAcceptEmail()` : Email d'acceptation
- `generateRejectEmail()` : Email de refus

### Interface Utilisateur

Modifiez le fichier `css/candidatures_poste.css` pour personnaliser l'apparence de l'interface.

## Dépannage

### Emails non envoyés

1. Vérifiez que la tâche planifiée est correctement configurée
2. Contrôlez les paramètres SMTP dans `send_emails.php`
3. Consultez les logs d'erreur du serveur

### Problèmes de mise à jour de statut

1. Vérifiez la connexion à la base de données
2. Contrôlez les droits d'accès aux tables concernées
3. Assurez-vous que les fonctions dans `model/accepte_candidats.php` sont correctement appelées

## Sécurité

- Requêtes préparées pour prévenir les injections SQL
- Échappement des données affichées pour éviter les XSS
- Vérification de session pour l'authentification

## Licence

Ce logiciel est propriétaire et fait partie de la plateforme WorkFlexer.

## Contact

Pour toute question ou assistance, contactez-nous à [info@advantech-group.space](mailto:info@advantech-group.space).
