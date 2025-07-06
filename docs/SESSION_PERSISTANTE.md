# Configuration de la Session Persistante

## Vue d'ensemble

Le système de session persistante permet aux utilisateurs de rester connectés même après la fermeture de leur navigateur, grâce à un système de tokens sécurisés.

## Fonctionnalités

### ✅ Sécurité renforcée
- Tokens générés avec `random_bytes()` pour une sécurité maximale
- Expiration automatique des tokens après 30 jours
- Nettoyage automatique des tokens expirés
- Sessions sécurisées avec régénération d'ID périodique

### ✅ Gestion automatique
- Vérification automatique des tokens à chaque chargement de page
- Renouvellement automatique des cookies avant expiration
- Nettoyage automatique lors de la déconnexion

## Installation

### 1. Exécuter la migration
```bash
php migrations/add_remember_token_expires_column.php
```

### 2. Vérifier la structure de la base de données
La table `users` doit contenir ces colonnes :
- `remember_token` (VARCHAR/TEXT)
- `remember_token_expires` (DATETIME)

## Utilisation

### Connexion automatique
Le système fonctionne automatiquement :
1. L'utilisateur se connecte normalement
2. Un token est généré et stocké dans un cookie `remember_me`
3. À chaque visite, le token est vérifié automatiquement
4. Si valide, l'utilisateur est reconnecté automatiquement

### Déconnexion
Lors de la déconnexion :
1. Le token est supprimé de la base de données
2. Le cookie `remember_me` est effacé
3. La session est détruite

## Maintenance

### Nettoyage automatique des tokens expirés
Exécuter périodiquement (via cron job) :
```bash
php utils/cleanup_expired_tokens.php
```

### Configuration cron recommandée
```bash
# Nettoyer les tokens expirés tous les jours à 2h du matin
0 2 * * * /usr/bin/php /chemin/vers/votre/projet/utils/cleanup_expired_tokens.php
```

## Paramètres de configuration

### Durée de vie des tokens
- **Défaut** : 30 jours
- **Modifiable dans** : `connexion.php` et `controller_users.php`

### Sécurité des sessions
- **Cookie HttpOnly** : Activé (protection XSS)
- **Régénération d'ID** : Toutes les 5 minutes
- **Durée de vie session** : 1 heure d'inactivité

## Fichiers modifiés

1. **`controller/controller_users.php`** - Logique principale de vérification des tokens
2. **`conn/conn.php`** - Configuration sécurisée des sessions
3. **`navbare.php`** - Initialisation des sessions
4. **`connexion.php`** - Génération des tokens lors de la connexion
5. **`conn/dconn_users.php`** - Nettoyage lors de la déconnexion

## Dépannage

### L'utilisateur est déconnecté fréquemment
- Vérifier que la colonne `remember_token_expires` existe
- Vérifier les paramètres de cookies (domaine, chemin)
- Vérifier les logs d'erreurs PHP

### Tokens non supprimés
- Exécuter le script de nettoyage manuellement
- Vérifier la configuration cron

### Problèmes de sécurité
- S'assurer que `session.cookie_secure` est activé en production (HTTPS)
- Vérifier que les cookies sont bien en `HttpOnly`

## Sécurité

⚠️ **Important** : En production, assurez-vous de :
- Activer HTTPS et mettre `session.cookie_secure = 1`
- Configurer un domaine spécifique pour les cookies
- Surveiller les logs pour détecter les tentatives d'intrusion 