# Guide d'implémentation des notifications Firebase (FCM)

Ce guide explique comment configurer et utiliser le système de notifications push avec Firebase Cloud Messaging (FCM) dans votre application web.

## Table des matières

1. [Prérequis](#prérequis)
2. [Configuration Firebase](#configuration-firebase)
3. [Structure des fichiers](#structure-des-fichiers)
4. [Installation](#installation)
5. [Utilisation](#utilisation)
6. [Dépannage](#dépannage)

## Prérequis

- Compte Google Firebase
- PHP 7.4 ou supérieur
- Base de données MySQL/MariaDB
- Serveur web (Apache/Nginx)
- Composer (pour les dépendances PHP)
- HTTPS configuré sur votre domaine (obligatoire pour les notifications web)

## Configuration Firebase

1. **Créer un projet Firebase**

   - Allez sur [Firebase Console](https://console.firebase.google.com/)
   - Créez un nouveau projet ou sélectionnez un projet existant
   - Notez l'ID du projet
2. **Configurer le projet web**

   - Dans la console Firebase, cliquez sur l'icône "Web" (</>)
   - Enregistrez votre application web
   - Copiez la configuration Firebase fournie
3. **Générer la clé VAPID**

   - Dans la console Firebase, allez dans Project Settings > Cloud Messaging
   - Générez une paire de clés web push
   - Copiez la clé publique VAPID
4. **Générer le fichier de service**

   - Dans Project Settings > Service Accounts
   - Générez une nouvelle clé privée
   - Sauvegardez le fichier JSON dans votre projet

## Structure des fichiers

```
├── js/
│   └── firebase-init.js         # Configuration Firebase côté client
├── model/
│   ├── fcm_tokens.php          # Gestion des tokens FCM
│   └── fcm_tokens_users.php    # Gestion des tokens utilisateurs
├── ajax/
│   ├── save_fcm_token.php      # Endpoint pour sauvegarder les tokens entreprise
│   └── save_fcm_token_user.php # Endpoint pour sauvegarder les tokens utilisateur
├── firebase-messaging-sw.js    # Service Worker pour les notifications
└── send-notification-257c0-xxxxx.json  # Fichier de service Firebase
```

## Installation

1. **Configuration de la base de données**

Créez les tables nécessaires :

```sql
CREATE TABLE fcm_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entreprise_id VARCHAR(255) NOT NULL,
    token TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_entreprise (entreprise_id)
);

CREATE TABLE fcm_tokens_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id VARCHAR(255) NOT NULL,
    token TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user (users_id)
);
```

2. **Installation des dépendances**

```bash
composer require google/cloud-firebase-messaging
```

3. **Configuration du fichier firebase-init.js**

Remplacez la configuration Firebase par la vôtre :

```javascript
const firebaseConfig = {
    apiKey: "VOTRE_API_KEY",
    authDomain: "VOTRE_AUTH_DOMAIN",
    projectId: "VOTRE_PROJECT_ID",
    storageBucket: "VOTRE_STORAGE_BUCKET",
    messagingSenderId: "VOTRE_MESSAGING_SENDER_ID",
    appId: "VOTRE_APP_ID"
};
```

4. **Configuration du Service Worker**

Placez le fichier `firebase-messaging-sw.js` à la racine de votre domaine.

## Utilisation

### 1. Ajout du bouton de notification

```html
<!-- Pour les entreprises -->
<button id="enable-notifications" data-entreprise-id="ID_ENTREPRISE">
    Activer les notifications
</button>

<!-- Pour les utilisateurs -->
<button id="enable-notifications">
    Activer les notifications
</button>
```

### 2. Envoi de notifications

```php
// Pour envoyer une notification à une entreprise
require_once('model/fcm_notification.php');

$notification = [
    'title' => 'Titre de la notification',
    'body' => 'Corps de la notification'
];

$data = [
    'type' => 'application',
    'candidat_id' => '123',
    // Autres données personnalisées
];

sendFCMNotification($db, $entreprise_id, $notification, $data);

// Pour envoyer une notification à un utilisateur
sendUserFCMNotification($db, $users_id, $notification, $data);
```

## Dépannage

### Problèmes courants

1. **Les notifications ne s'affichent pas**

   - Vérifiez que HTTPS est correctement configuré
   - Vérifiez les permissions du navigateur
   - Consultez la console du navigateur pour les erreurs
2. **Erreurs de token**

   - Vérifiez que le token FCM est correctement sauvegardé
   - Assurez-vous que la configuration Firebase est correcte
3. **Service Worker non installé**

   - Vérifiez que le fichier est accessible à la racine
   - Vérifiez la console pour les erreurs d'installation

### Logs et débogage

- Activez la journalisation détaillée dans PHP :

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

- Consultez les logs Firebase dans la console Firebase
- Utilisez la console du navigateur pour déboguer le JavaScript

### Support des navigateurs

Le système est compatible avec :

- Chrome (desktop & mobile)
- Firefox (desktop & mobile)
- Edge
- Safari (support limité)
- Opera

## Sécurité

- Ne partagez jamais vos clés Firebase publiquement
- Stockez le fichier de service de manière sécurisée
- Validez toujours les tokens côté serveur
- Implémentez une authentification appropriée
