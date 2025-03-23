# WorkFlexer - Système de personnalisation des CV

Ce document explique comment intégrer et utiliser le système de personnalisation de CV dans de nouveaux modèles.

## Vue d'ensemble

Le système de personnalisation permet aux utilisateurs de modifier les styles des éléments textuels et des images dans les modèles de CV. Les fonctionnalités incluent:

### Pour les éléments textuels:
- Modification de la taille du texte
- Changement de la couleur du texte
- Modification de la couleur d'arrière-plan
- Changement de la police

### Pour les images:
- Redimensionnement (largeur et hauteur)
- Ajustement des coins arrondis
- Contrôle de l'opacité
- Réglage de la luminosité et du contraste
- Option noir et blanc (niveaux de gris)
- Déplacement de l'image
- Option pour masquer/afficher l'image

## Intégration du système dans un nouveau modèle de CV

### 1. Inclure les scripts de personnalisation

Ajoutez les scripts suivants dans la section `<head>` de votre modèle:

```html
<script src="../cv_customizer.js" defer></script>
<script src="../image_customizer.js" defer></script>
```

### 2. Structure HTML requise

Pour que le système fonctionne correctement, votre modèle doit avoir la structure suivante:

```html
<body>
    <!-- Bouton de téléchargement PDF et autres boutons -->
    <div class="download-container">
        <button id="download-btn" class="download-btn">Télécharger en PDF</button>
    </div>
    
    <!-- Votre modèle de CV ici -->
    <div class="cv-container">
        <!-- Contenu du CV -->
    </div>
    
    <!-- Script pour la génération PDF -->
    <script>
        document.getElementById('download-btn').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
```

### 3. Personnalisation des sélecteurs

Par défaut, le système rend éditables les éléments suivants:
- Tous les éléments de texte (`h1`, `h2`, `h3`, `p`, `span`, etc.)
- Toutes les images qui ne sont pas décoratives

Vous pouvez personnaliser les éléments éditables en modifiant les sélecteurs dans les fichiers `cv_customizer.js` et `image_customizer.js` selon vos besoins.

## Fonctionnement du système

### Personnalisation de texte

1. L'utilisateur clique sur un élément de texte dans le CV
2. Le panneau d'édition apparaît en bas de l'écran
3. L'utilisateur peut modifier:
   - La taille du texte
   - La couleur du texte
   - La couleur d'arrière-plan 
   - La police
4. Options pour appliquer les changements:
   - À l'élément spécifique uniquement
   - À tous les éléments de la même classe
   - À tous les éléments du même type

### Personnalisation d'image

1. L'utilisateur clique sur une image dans le CV
2. Le panneau d'édition d'image apparaît en bas de l'écran
3. L'utilisateur peut ajuster:
   - La largeur et hauteur de l'image
   - Les coins arrondis
   - L'opacité
   - La luminosité et le contraste
   - Appliquer un effet noir et blanc
   - Déplacer l'image (haut, bas, gauche, droite)
   - Masquer l'image

## Tester l'implémentation

Après avoir intégré le système, testez les fonctionnalités suivantes:

1. Cliquez sur différents éléments de texte pour vérifier que le panneau d'édition apparaît
2. Essayez de modifier les styles et vérifiez que les changements sont appliqués
3. Cliquez sur des images et testez les options de redimensionnement et de filtres
4. Rechargez la page pour vérifier que les styles persistent grâce au localStorage
5. Testez sur différents appareils pour vérifier la responsivité

## Résolution des problèmes

### Le panneau d'édition ne s'affiche pas
- Vérifiez que les scripts sont correctement inclus et chargés
- Assurez-vous que les éléments sont correctement identifiés par les sélecteurs

### Les styles ne persistent pas après actualisation
- Vérifiez que localStorage est disponible dans votre navigateur
- Contrôlez que l'identifiant du modèle est correctement extrait de l'URL

### Problèmes de style avec le panneau d'édition
- Examinez les styles injectés pour détecter d'éventuels conflits
- Ajustez les valeurs de z-index si le panneau est caché par d'autres éléments

## Hiérarchie d'application des styles

Le système applique les styles dans l'ordre suivant:

1. Styles par type d'élément (ex: tous les h1)
2. Styles par classe d'élément (ex: tous les .title)
3. Styles par élément spécifique (identifié par son chemin unique)

Cette hiérarchie permet une personnalisation précise tout en maintenant une cohérence visuelle. 