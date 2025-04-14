# Guide d'implémentation - Vérification d'appareil pour les modèles de CV

Ce guide détaille les étapes à suivre pour mettre en place la vérification d'appareil sur tous les modèles de CV.

## Fichiers créés

1. `check_device.php` - Contient les fonctions pour détecter le type d'appareil
2. `mobile_message.php` - Page stylisée affichée aux utilisateurs sur appareils mobiles
3. `apply_device_check.php` - Script pour appliquer la vérification à tous les modèles
4. `test_device_detection.php` - Page de test pour vérifier la détection d'appareil

## Étapes d'implémentation

### 1. Vérifier les fichiers créés

Assurez-vous que tous les fichiers listés ci-dessus ont été correctement créés dans le répertoire `model_cv`.

### 2. Tester la détection d'appareil

Avant d'appliquer les modifications à tous les modèles, testez la fonctionnalité de détection d'appareil :

1. Accédez à `test_device_detection.php` depuis un ordinateur
2. Accédez à `test_device_detection.php` depuis un appareil mobile (ou utilisez les outils de développement de votre navigateur pour simuler un appareil mobile)

### 3. Appliquer la vérification à tous les modèles

Il y a deux façons d'appliquer la vérification à tous les modèles :

#### Option A : Utiliser le script automatisé (recommandé)

1. Accédez à `apply_device_check.php` dans votre navigateur
2. Le script ajoutera automatiquement le code de vérification à tous les modèles
3. Vérifiez le résultat affiché pour vous assurer que tous les modèles ont été mis à jour

#### Option B : Modification manuelle

Si vous préférez modifier manuellement les fichiers, ajoutez le code suivant après `session_start();` dans chaque fichier de modèle CV :

```php
// Include device detection functionality
include_once('check_device.php');

// Check if user is on desktop
$isDesktop = isDesktop();
if (!$isDesktop) {
    // If not on desktop, redirect to mobile message page
    header("Location: mobile_message.php");
    exit;
}
```

### 4. Vérification finale

1. Testez l'accès à quelques modèles de CV depuis un ordinateur pour vérifier qu'ils fonctionnent normalement
2. Testez l'accès aux mêmes modèles depuis un appareil mobile (ou via un émulateur) pour vérifier que la redirection vers `mobile_message.php` fonctionne correctement

## Personnalisation (optionnel)

### Modifier le design de la page mobile

Vous pouvez personnaliser l'apparence de la page mobile en modifiant le fichier `mobile_message.php`. Le design actuel inclut :

- Une animation d'icônes flottantes
- Des éléments qui apparaissent progressivement
- Une illustration interactive montrant la différence entre mobile et ordinateur
- Des couleurs cohérentes avec votre charte graphique

### Ajuster les critères de détection

Si vous souhaitez affiner la détection d'appareil, vous pouvez modifier la fonction `isDesktop()` dans le fichier `check_device.php`. Par exemple, vous pourriez vouloir autoriser les tablettes tout en bloquant les smartphones.

## Maintenance

- Si vous ajoutez de nouveaux modèles de CV à l'avenir, n'oubliez pas de leur appliquer la vérification d'appareil
- Vous pouvez relancer le script `apply_device_check.php` à tout moment pour appliquer la vérification aux nouveaux modèles (les modèles déjà modifiés ne seront pas affectés)

## Dépannage

### Problème : La détection ne fonctionne pas correctement

1. Vérifiez que la fonction `isDesktop()` dans `check_device.php` détecte correctement votre appareil
2. Utilisez `test_device_detection.php` pour voir comment votre appareil est identifié

### Problème : Une erreur s'affiche lors de l'accès aux modèles

1. Vérifiez que le fichier `check_device.php` est bien présent dans le répertoire `model_cv`
2. Assurez-vous que la syntaxe du code ajouté est correcte
3. Vérifiez les chemins d'inclusion dans les fichiers modifiés 