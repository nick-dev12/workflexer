/**
 * Système de personnalisation d'images pour CV
 * Complément au script cv_customizer.js
 */

document.addEventListener('DOMContentLoaded', function () {
    // Identifier le modèle de CV actuel basé sur l'URL
    const currentModelPath = window.location.pathname;
    const modelMatch = currentModelPath.match(/model(\d+)\.php/);
    const modelNumber = modelMatch ? modelMatch[1] : 'unknown';

    // Clé unique pour chaque modèle de CV (images)
    const CV_IMAGE_STORAGE_KEY = `cv-image-styles-model-${modelNumber}`;

    console.log(`Module de personnalisation d'image activé pour le modèle ${modelNumber}`);

    // CSS à injecter pour le panneau de personnalisation d'images
    const customImageCSS = `
        .cv-image-editor-panel {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px 8px 0 0;
            padding: 15px;
            z-index: 1001; /* Au-dessus du panneau de texte */
            width: 340px;
            display: none;
        }

        .cv-image-editor-panel .editor-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #444;
        }

        .cv-image-editor-panel .option {
            margin-bottom: 12px;
        }

        .cv-image-editor-panel label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .cv-image-editor-panel input[type="range"] {
            width: 100%;
            padding: 8px 0;
        }

        .cv-image-editor-panel .size-inputs {
            display: flex;
            gap: 10px;
        }

        .cv-image-editor-panel .size-inputs div {
            flex: 1;
        }

        .cv-image-editor-panel .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #777;
        }

        .cv-image-editor-panel .btn-apply {
            background-color: #0089be;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            font-weight: bold;
        }
        
        .cv-image-editor-panel .action-buttons {
            display: flex;
            margin-top: 15px;
            gap: 10px;
        }
        
        .cv-image-editor-panel .action-buttons button {
            flex: 1;
            padding: 8px 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        
        .cv-image-editor-panel .btn-hide {
            background-color: #ff9800;
            color: white;
        }
        
        .cv-image-editor-panel .btn-reset {
            background-color: #f44336;
            color: white;
        }

        .cv-image-editor-panel .btn-apply:hover,
        .cv-image-editor-panel .action-buttons button:hover {
            opacity: 0.9;
        }

        .editable-image {
            cursor: pointer;
            transition: outline 0.2s, filter 0.3s;
            box-sizing: border-box;
        }

        .editable-image:hover {
            outline: 2px dashed #ff9800;
        }
        
        .editable-image.active {
            outline: 2px solid #ff9800;
        }
        
        .editable-image.hidden {
            display: none !important;
        }
        
        .image-position-control {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        
        .image-position-control button {
            width: 36px;
            height: 36px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            margin: 0 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border-radius: 4px;
        }
        
        .image-grayscale-container {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        
        .image-grayscale-container input[type="checkbox"] {
            margin-right: 8px;
        }
        
        /* Responsive design for smaller screens */
        @media screen and (max-width: 768px) {
            .cv-image-editor-panel {
                width: 90%;
                padding: 12px;
            }
        }
        
        @media screen and (max-width: 480px) {
            .cv-image-editor-panel {
                width: 100%;
                border-radius: 0;
            }
        }
    `;

    // Injecter le CSS
    const styleEl = document.createElement('style');
    styleEl.textContent = customImageCSS;
    document.head.appendChild(styleEl);

    // Créer le panneau d'édition d'images
    const imageEditorPanel = document.createElement('div');
    imageEditorPanel.className = 'cv-image-editor-panel';
    imageEditorPanel.id = 'imageEditorPanel';
    imageEditorPanel.innerHTML = `
        <button class="close-btn" id="closeImageEditor">&times;</button>
        <div class="editor-title">Personnaliser l'image</div>
        
        <div class="option size-inputs">
            <div>
                <label for="imageWidth">Largeur</label>
                <input type="number" id="imageWidth" min="20" max="500" step="5">
                <span id="imageWidthUnit">px</span>
            </div>
            <div>
                <label for="imageHeight">Hauteur</label>
                <input type="number" id="imageHeight" min="20" max="500" step="5">
                <span id="imageHeightUnit">px</span>
            </div>
        </div>
        
        <div class="option">
            <label for="imageBorderRadius">Coins arrondis</label>
            <input type="range" id="imageBorderRadius" min="0" max="50" value="0" step="1">
            <span id="imageBorderRadiusValue">0%</span>
        </div>
        
        <div class="option">
            <label for="imageOpacity">Opacité</label>
            <input type="range" id="imageOpacity" min="10" max="100" value="100" step="5">
            <span id="imageOpacityValue">100%</span>
        </div>
        
        <div class="option">
            <label for="imageBrightness">Luminosité</label>
            <input type="range" id="imageBrightness" min="50" max="150" value="100" step="5">
            <span id="imageBrightnessValue">100%</span>
        </div>
        
        <div class="option">
            <label for="imageContrast">Contraste</label>
            <input type="range" id="imageContrast" min="50" max="150" value="100" step="5">
            <span id="imageContrastValue">100%</span>
        </div>
        
        <div class="option image-grayscale-container">
            <input type="checkbox" id="imageGrayscale">
            <label for="imageGrayscale">Noir et blanc</label>
        </div>
        
        <div class="option">
            <label>Position de l'image</label>
            <div class="image-position-control">
                <button id="moveLeft" title="Déplacer à gauche">←</button>
                <button id="moveUp" title="Déplacer vers le haut">↑</button>
                <button id="moveDown" title="Déplacer vers le bas">↓</button>
                <button id="moveRight" title="Déplacer à droite">→</button>
            </div>
        </div>
        
        <div class="action-buttons">
            <button class="btn-hide" id="toggleImageVisibility">Cacher l'image</button>
            <button class="btn-reset" id="resetImageStyles">Réinitialiser</button>
        </div>
        
        <button class="btn-apply" id="applyImageChanges">Appliquer</button>
    `;
    document.body.appendChild(imageEditorPanel);

    // Sélectionner toutes les images éditables
    const editableImages = document.querySelectorAll('img:not([role="presentation"])');

    let currentImage = null;
    let currentImageId = '';
    let originalStyles = {};

    // Références aux éléments du panneau
    const closeImageEditor = document.getElementById('closeImageEditor');
    const imageWidthInput = document.getElementById('imageWidth');
    const imageHeightInput = document.getElementById('imageHeight');
    const imageBorderRadiusInput = document.getElementById('imageBorderRadius');
    const imageBorderRadiusValue = document.getElementById('imageBorderRadiusValue');
    const imageOpacityInput = document.getElementById('imageOpacity');
    const imageOpacityValue = document.getElementById('imageOpacityValue');
    const imageBrightnessInput = document.getElementById('imageBrightness');
    const imageBrightnessValue = document.getElementById('imageBrightnessValue');
    const imageContrastInput = document.getElementById('imageContrast');
    const imageContrastValue = document.getElementById('imageContrastValue');
    const imageGrayscaleInput = document.getElementById('imageGrayscale');
    const toggleImageVisibilityBtn = document.getElementById('toggleImageVisibility');
    const resetImageStylesBtn = document.getElementById('resetImageStyles');
    const applyImageChangesBtn = document.getElementById('applyImageChanges');
    const moveLeftBtn = document.getElementById('moveLeft');
    const moveRightBtn = document.getElementById('moveRight');
    const moveUpBtn = document.getElementById('moveUp');
    const moveDownBtn = document.getElementById('moveDown');

    // Ajouter la classe editable-image à toutes les images
    editableImages.forEach((image, index) => {
        // Assurer que l'image a un ID unique
        if (!image.id) {
            image.id = `cv-image-${index}`;
        }

        image.classList.add('editable-image');

        image.addEventListener('click', function (e) {
            e.stopPropagation();

            // Fermer d'abord l'éditeur de texte s'il est ouvert
            const textEditor = document.getElementById('editorPanel');
            if (textEditor && textEditor.style.display === 'block') {
                textEditor.style.display = 'none';
            }

            // Supprimer la classe active de l'image précédente
            if (currentImage) {
                currentImage.classList.remove('active');
            }

            currentImage = image;
            currentImageId = image.id;
            currentImage.classList.add('active');

            // Sauvegarder les styles originaux pour pouvoir les réinitialiser
            if (!originalStyles[currentImageId]) {
                originalStyles[currentImageId] = {
                    width: image.style.width || image.width + 'px',
                    height: image.style.height || image.height + 'px',
                    borderRadius: image.style.borderRadius || '0px',
                    opacity: image.style.opacity || '1',
                    filter: image.style.filter || 'none',
                    margin: image.style.margin || '0px',
                    display: image.style.display || 'inline-block'
                };
            }

            // Mettre à jour l'éditeur avec les valeurs actuelles
            updateEditorValues();

            // Afficher l'éditeur d'images
            imageEditorPanel.style.display = 'block';
        });
    });

    // Fonction pour mettre à jour les valeurs de l'éditeur en fonction de l'image sélectionnée
    function updateEditorValues() {
        if (!currentImage) return;

        const computedStyle = window.getComputedStyle(currentImage);

        // Dimensions
        const width = parseInt(currentImage.style.width) || currentImage.width;
        const height = parseInt(currentImage.style.height) || currentImage.height;
        imageWidthInput.value = width;
        imageHeightInput.value = height;

        // Border radius
        const borderRadius = parseInt(computedStyle.borderRadius) || 0;
        imageBorderRadiusInput.value = borderRadius;
        imageBorderRadiusValue.textContent = borderRadius + '%';

        // Opacité
        const opacity = (parseFloat(computedStyle.opacity) || 1) * 100;
        imageOpacityInput.value = opacity;
        imageOpacityValue.textContent = opacity + '%';

        // Extraire les valeurs de filtre
        const filterStr = computedStyle.filter;

        // Luminosité
        let brightness = 100;
        const brightnessMatch = filterStr.match(/brightness\((\d+)%\)/);
        if (brightnessMatch) {
            brightness = parseInt(brightnessMatch[1]);
        }
        imageBrightnessInput.value = brightness;
        imageBrightnessValue.textContent = brightness + '%';

        // Contraste
        let contrast = 100;
        const contrastMatch = filterStr.match(/contrast\((\d+)%\)/);
        if (contrastMatch) {
            contrast = parseInt(contrastMatch[1]);
        }
        imageContrastInput.value = contrast;
        imageContrastValue.textContent = contrast + '%';

        // Niveaux de gris
        const isGrayscale = filterStr.includes('grayscale(1)');
        imageGrayscaleInput.checked = isGrayscale;

        // Mise à jour du bouton de visibilité
        if (currentImage.classList.contains('hidden') || computedStyle.display === 'none') {
            toggleImageVisibilityBtn.textContent = "Afficher l'image";
        } else {
            toggleImageVisibilityBtn.textContent = "Cacher l'image";
        }
    }

    // Fonction pour appliquer les styles à l'image
    function applyImageStyles() {
        if (!currentImage) return;

        // Appliquer les dimensions
        currentImage.style.width = imageWidthInput.value + 'px';
        currentImage.style.height = imageHeightInput.value + 'px';

        // Appliquer le border-radius
        currentImage.style.borderRadius = imageBorderRadiusInput.value + '%';

        // Appliquer l'opacité
        currentImage.style.opacity = imageOpacityInput.value / 100;

        // Construire la chaîne de filtre
        let filterValue = '';

        // Luminosité
        filterValue += `brightness(${imageBrightnessInput.value}%) `;

        // Contraste
        filterValue += `contrast(${imageContrastInput.value}%) `;

        // Niveaux de gris
        if (imageGrayscaleInput.checked) {
            filterValue += 'grayscale(1) ';
        }

        currentImage.style.filter = filterValue.trim() || 'none';
    }

    // Fonction pour sauvegarder les styles de l'image dans localStorage
    function saveImageStyles() {
        if (!currentImage) return;

        try {
            // Récupérer les styles actuels
            let imageStyles = JSON.parse(localStorage.getItem(CV_IMAGE_STORAGE_KEY) || '{}');

            // Sauvegarder les styles pour l'image actuelle
            imageStyles[currentImageId] = {
                width: currentImage.style.width,
                height: currentImage.style.height,
                borderRadius: currentImage.style.borderRadius,
                opacity: currentImage.style.opacity,
                filter: currentImage.style.filter,
                margin: currentImage.style.margin,
                hidden: currentImage.classList.contains('hidden'),

                // Valeurs de l'éditeur pour faciliter la restauration
                borderRadiusValue: imageBorderRadiusInput.value,
                opacityValue: imageOpacityInput.value,
                brightnessValue: imageBrightnessInput.value,
                contrastValue: imageContrastInput.value,
                grayscale: imageGrayscaleInput.checked
            };

            localStorage.setItem(CV_IMAGE_STORAGE_KEY, JSON.stringify(imageStyles));
            console.log(`Styles d'image sauvegardés pour ${currentImageId}`);

        } catch (e) {
            console.error('Erreur lors de la sauvegarde des styles d\'image:', e);
        }
    }

    // Fonction pour appliquer les styles sauvegardés aux images
    function loadSavedImageStyles() {
        try {
            const imageStyles = JSON.parse(localStorage.getItem(CV_IMAGE_STORAGE_KEY) || '{}');

            // Pour chaque image sauvegardée
            Object.keys(imageStyles).forEach(imageId => {
                const img = document.getElementById(imageId);
                if (img) {
                    const styles = imageStyles[imageId];

                    // Appliquer les styles sauvegardés
                    img.style.width = styles.width || '';
                    img.style.height = styles.height || '';
                    img.style.borderRadius = styles.borderRadius || '';
                    img.style.opacity = styles.opacity || '';
                    img.style.filter = styles.filter || '';
                    img.style.margin = styles.margin || '';

                    // Gérer la visibilité
                    if (styles.hidden) {
                        img.classList.add('hidden');
                    } else {
                        img.classList.remove('hidden');
                    }
                }
            });

            console.log('Styles d\'images chargés avec succès');
        } catch (e) {
            console.error('Erreur lors du chargement des styles d\'image:', e);
        }
    }

    // Mise à jour en temps réel des valeurs
    imageWidthInput.addEventListener('input', function () {
        if (currentImage) {
            currentImage.style.width = this.value + 'px';
        }
    });

    imageHeightInput.addEventListener('input', function () {
        if (currentImage) {
            currentImage.style.height = this.value + 'px';
        }
    });

    imageBorderRadiusInput.addEventListener('input', function () {
        imageBorderRadiusValue.textContent = this.value + '%';
        if (currentImage) {
            currentImage.style.borderRadius = this.value + '%';
        }
    });

    imageOpacityInput.addEventListener('input', function () {
        imageOpacityValue.textContent = this.value + '%';
        if (currentImage) {
            currentImage.style.opacity = this.value / 100;
        }
    });

    imageBrightnessInput.addEventListener('input', function () {
        imageBrightnessValue.textContent = this.value + '%';
        updateImageFilter();
    });

    imageContrastInput.addEventListener('input', function () {
        imageContrastValue.textContent = this.value + '%';
        updateImageFilter();
    });

    imageGrayscaleInput.addEventListener('change', function () {
        updateImageFilter();
    });

    // Fonction pour mettre à jour les filtres de l'image
    function updateImageFilter() {
        if (!currentImage) return;

        let filterValue = '';
        filterValue += `brightness(${imageBrightnessInput.value}%) `;
        filterValue += `contrast(${imageContrastInput.value}%) `;

        if (imageGrayscaleInput.checked) {
            filterValue += 'grayscale(1) ';
        }

        currentImage.style.filter = filterValue.trim();
    }

    // Gestion des déplacements
    moveLeftBtn.addEventListener('click', function () {
        if (!currentImage) return;
        const currentMargin = parseFloat(currentImage.style.marginLeft || '0');
        currentImage.style.marginLeft = (currentMargin - 5) + 'px';
    });

    moveRightBtn.addEventListener('click', function () {
        if (!currentImage) return;
        const currentMargin = parseFloat(currentImage.style.marginLeft || '0');
        currentImage.style.marginLeft = (currentMargin + 5) + 'px';
    });

    moveUpBtn.addEventListener('click', function () {
        if (!currentImage) return;
        const currentMargin = parseFloat(currentImage.style.marginTop || '0');
        currentImage.style.marginTop = (currentMargin - 5) + 'px';
    });

    moveDownBtn.addEventListener('click', function () {
        if (!currentImage) return;
        const currentMargin = parseFloat(currentImage.style.marginTop || '0');
        currentImage.style.marginTop = (currentMargin + 5) + 'px';
    });

    // Gestion de la visibilité de l'image
    toggleImageVisibilityBtn.addEventListener('click', function () {
        if (!currentImage) return;

        if (currentImage.classList.contains('hidden')) {
            currentImage.classList.remove('hidden');
            this.textContent = "Cacher l'image";
        } else {
            currentImage.classList.add('hidden');
            this.textContent = "Afficher l'image";
        }
    });

    // Réinitialiser les styles de l'image
    resetImageStylesBtn.addEventListener('click', function () {
        if (!currentImage || !currentImageId) return;

        if (originalStyles[currentImageId]) {
            const origStyle = originalStyles[currentImageId];

            currentImage.style.width = origStyle.width;
            currentImage.style.height = origStyle.height;
            currentImage.style.borderRadius = origStyle.borderRadius;
            currentImage.style.opacity = origStyle.opacity;
            currentImage.style.filter = origStyle.filter;
            currentImage.style.margin = origStyle.margin;

            if (origStyle.display !== 'none') {
                currentImage.classList.remove('hidden');
                toggleImageVisibilityBtn.textContent = "Cacher l'image";
            }

            // Mettre à jour les valeurs de l'éditeur
            updateEditorValues();
        }
    });

    // Appliquer et sauvegarder les modifications
    applyImageChangesBtn.addEventListener('click', function () {
        if (!currentImage) return;

        applyImageStyles();
        saveImageStyles();

        currentImage.classList.remove('active');
        imageEditorPanel.style.display = 'none';
        currentImage = null;
    });

    // Fermer l'éditeur
    closeImageEditor.addEventListener('click', function () {
        if (currentImage) {
            currentImage.classList.remove('active');
        }

        imageEditorPanel.style.display = 'none';
        currentImage = null;
    });

    // Fermer l'éditeur en cliquant à l'extérieur
    document.addEventListener('click', function (e) {
        if (!imageEditorPanel.contains(e.target) && !e.target.classList.contains('editable-image')) {
            if (currentImage) {
                currentImage.classList.remove('active');
            }

            imageEditorPanel.style.display = 'none';
            currentImage = null;
        }
    });

    // Fonction globale pour réinitialiser tous les styles d'image
    window.resetAllImageStyles = function () {
        localStorage.removeItem(CV_IMAGE_STORAGE_KEY);

        editableImages.forEach(img => {
            if (originalStyles[img.id]) {
                const origStyle = originalStyles[img.id];

                img.style.width = origStyle.width;
                img.style.height = origStyle.height;
                img.style.borderRadius = origStyle.borderRadius;
                img.style.opacity = origStyle.opacity;
                img.style.filter = origStyle.filter;
                img.style.margin = origStyle.margin;
                img.classList.remove('hidden');
            } else {
                img.style.width = '';
                img.style.height = '';
                img.style.borderRadius = '';
                img.style.opacity = '';
                img.style.filter = '';
                img.style.margin = '';
                img.classList.remove('hidden');
            }
        });
    };

    // Ajouter un bouton de réinitialisation des images au panneau de personnalisation existant
    const personnalisationDiv = document.querySelector('.personnalisation');
    if (personnalisationDiv) {
        const resetImagesButton = document.createElement('button');
        resetImagesButton.className = 'button12';
        resetImagesButton.textContent = 'Réinitialiser les images';
        resetImagesButton.style.marginTop = '10px';
        resetImagesButton.style.backgroundColor = '#ff9800';
        resetImagesButton.onclick = function () {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser toutes les personnalisations d\'images?')) {
                resetAllImageStyles();
            }
        };
        personnalisationDiv.appendChild(resetImagesButton);
    }

    // Charger les styles sauvegardés au chargement de la page
    setTimeout(loadSavedImageStyles, 500);
}); 