# 🚀 Guide d'implémentation wkhtmltopdf pour WorkFlexer

## Vue d'ensemble

Ce guide vous explique comment implémenter **wkhtmltopdf** dans votre projet WorkFlexer pour générer des PDF de haute qualité à partir de vos modèles de CV.

## 📋 Prérequis

- **Système d'exploitation** : Windows 7/10/11 (64-bit)
- **PHP** : Version 8.2+ avec extensions `exec` et `shell_exec` activées
- **Composer** : Pour la gestion des dépendances PHP
- **Droits administrateur** : Nécessaires pour l'installation

## 🔧 Installation

### Étape 1 : Installation automatique

1. **Ouvrez votre navigateur** et accédez à :
   ```
   http://localhost/workflexer/install_wkhtmltopdf.php
   ```

2. **Cliquez sur "Installer wkhtmltopdf"** et suivez les instructions

3. **Vérifiez l'installation** en actualisant la page

### Étape 2 : Installation manuelle (si nécessaire)

Si l'installation automatique échoue :

1. **Téléchargez** l'installateur depuis GitHub
2. **Exécutez l'installateur** avec les droits administrateur
3. **Installez dans le répertoire par défaut** : `C:\Program Files\wkhtmltopdf`

## 📁 Structure des fichiers créés

```
workflexer/
├── model_cv/
│   ├── WkhtmltopdfGenerator.php      # Classe principale
│   ├── WkhtmltopdfConfig.php         # Configuration
│   ├── generate_pdf_model1.php       # Générateur pour modèle 1
│   └── generate_pdf_model[X].php     # Générateurs pour autres modèles
├── install_wkhtmltopdf.php           # Script d'installation
└── generated_pdf/                    # Dossier des PDF générés
```

## 🎯 Utilisation

### Génération PDF basique

```php
<?php
require_once 'model_cv/WkhtmltopdfGenerator.php';

try {
    $generator = new WkhtmltopdfGenerator();
    
    // Données utilisateur
    $userData = [
        'userss' => $userss,
        'descriptions' => $descriptions,
        // ... autres données
    ];
    
    // Générer le PDF
    $pdfPath = $generator->generateCvPdf('1', $userData);
    echo "PDF généré : " . $pdfPath;
    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
```

### Téléchargement direct

```php
<?php
// Dans vos modèles de CV, remplacez le bouton existant par :
?>
<button onclick="generatePDFWkhtmltopdf()">Télécharger CV (Haute Qualité)</button>

<script>
function generatePDFWkhtmltopdf() {
    window.location.href = 'generate_pdf_model1.php';
}
</script>
```

## ⚙️ Configuration avancée

### Options de qualité

```php
$customOptions = [
    'dpi' => 300,                    // Résolution élevée
    'image-quality' => 100,          // Qualité d'image maximale
    'javascript-delay' => 3000,      // Délai pour le JavaScript
    'zoom' => 1.0,                   // Zoom par défaut
    'enable-javascript' => true      // Support JavaScript
];

$pdfPath = $generator->generateCvPdf('1', $userData, $customOptions);
```

## 🔍 Diagnostic et dépannage

### Vérification de l'installation

```php
$generator = new WkhtmltopdfGenerator();
$status = $generator->checkInstallation();

if ($status['installed']) {
    echo "✅ wkhtmltopdf installé : " . $status['version'];
} else {
    echo "❌ Erreur : " . $status['error'];
}
```

### Problèmes courants

#### 1. Erreur "wkhtmltopdf introuvable"
**Solution** : Vérifiez le chemin d'installation

#### 2. PDF vide ou incomplet
**Solution** : Augmentez le délai JavaScript

#### 3. Images manquantes
**Solution** : Activez l'accès aux fichiers locaux

## 📊 Comparaison des méthodes

| Critère | wkhtmltopdf | jsPDF + dom-to-image |
|---------|-------------|---------------------|
| **Qualité** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Vitesse** | ⭐⭐⭐⭐ | ⭐⭐ |
| **Compatibilité CSS** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |

## 🎉 Conclusion

Avec cette implémentation, vous disposez maintenant d'un système de génération PDF professionnel pour WorkFlexer.

---

**Développé pour WorkFlexer** - Système de CV personnalisables
*Version 1.0 - Décembre 2024* 