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

    // Scope d'application pour les modifications
    const cvContainer = document.querySelector('.cv-container, #cv-container, #container,.container,.cv10,.cv11,.cv12,.cv13,.cv14,.cv15');
    const scope = cvContainer ? cvContainer : document;

    if (!cvContainer) {
        console.warn("Conteneur CV non trouvé (.cv-container, #cv-container, #container, etc.) pour la personnalisation d'image. Les modifications seront globales.");
    }

    // CSS à injecter pour le panneau de personnalisation d'images
    const customImageCSS = `
        .cv-image-editor-panel {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) translateY(100%);
            background-color: #f8f9fa;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px 12px 0 0;
            padding: 20px;
            z-index: 1001; /* Au-dessus du panneau de texte */
            width: 380px;
            display: block;
            font-family: 'Nunito', sans-serif;
            transition: transform 0.3s ease-out;
        }

        .cv-image-editor-panel.visible {
            transform: translateX(-50%) translateY(0);
        }

        .cv-image-editor-panel .editor-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .cv-image-editor-panel .option {
            margin-bottom: 15px;
        }

        .cv-image-editor-panel label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #495057;
        }

        .cv-image-editor-panel #imageWidthValue,
        .cv-image-editor-panel #imageHeightValue,
        .cv-image-editor-panel #imageBorderRadiusValue,
        .cv-image-editor-panel #imageOpacityValue,
        .cv-image-editor-panel #imageBrightnessValue,
        .cv-image-editor-panel #imageContrastValue {
            font-weight: 600;
            color: #007bff;
            margin-left: 10px;
        }

        .cv-image-editor-panel input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 6px;
            background: #dee2e6;
            border-radius: 5px;
            outline: none;
            opacity: 0.7;
            transition: opacity .2s;
        }

        .cv-image-editor-panel input[type="range"]:hover {
            opacity: 1;
        }

        .cv-image-editor-panel input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            background: #007bff;
            cursor: pointer;
            border-radius: 50%;
        }

        .cv-image-editor-panel input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: #007bff;
            cursor: pointer;
            border-radius: 50%;
        }

        .cv-image-editor-panel input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
        }

        .cv-image-editor-panel .size-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .cv-image-editor-panel .size-inputs div {
            flex: 1;
        }

        .cv-image-editor-panel .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #adb5bd;
            transition: color 0.2s;
        }
        
        .cv-image-editor-panel .close-btn:hover {
            color: #495057;
        }

        .cv-image-editor-panel .btn-apply {
            background-image: linear-gradient(to right, #007bff, #0056b3);
            color: #fff;
            border: none;
            padding: 12px 15px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .cv-image-editor-panel .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }

        .cv-image-editor-panel .action-buttons {
            display: flex;
            margin-top: 15px;
            gap: 10px;
        }
        
        .cv-image-editor-panel .action-buttons button {
            flex: 1;
            padding: 10px 5px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .cv-image-editor-panel .action-buttons button:hover {
            transform: translateY(-2px);
        }
        
        .cv-image-editor-panel .btn-hide {
            background-image: linear-gradient(to right, #ffc107, #e0a800);
            color: #212529;
        }
        
        .cv-image-editor-panel .btn-hide:hover {
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
        }
        
        .cv-image-editor-panel .btn-reset {
            background-image: linear-gradient(to right, #dc3545, #c82333);
            color: white;
        }
        
        .cv-image-editor-panel .btn-reset:hover {
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .editable-image {
            cursor: pointer;
            transition: outline 0.2s, filter 0.3s;
            box-sizing: border-box;
        }

        .editable-image:hover {
            outline: 2px dashed #3498db;
        }
        
        .editable-image.active {
            outline: 2px solid #3498db;
        }

        .editable-image.hidden {
            display: none !important;
        }

        .cv-image-editor-panel .image-position-control {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        
        .cv-image-editor-panel .image-position-control button {
            width: 36px;
            height: 36px;
            border: 1px solid #ced4da;
            background-color: #f8f9fa;
            margin: 0 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        
        .cv-image-editor-panel .image-position-control button:hover {
            background-color: #007bff;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        
        .cv-image-editor-panel .image-grayscale-container {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        
        .cv-image-editor-panel .image-grayscale-container input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }
        
        .cv-image-editor-panel .checkbox-option {
            display: block;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        
        .cv-image-editor-panel .checkbox-option input {
            width: auto;
            margin-right: 10px;
        }
        
        /* Responsive design for smaller screens */
        @media screen and (max-width: 768px) {
            .cv-image-editor-panel {
                width: 33.33%; /* Un tiers de l'écran */
                max-width: 300px;
                min-width: 250px;
                padding: 10px;
                left: 0;
                transform: translateX(-100%);
                border-radius: 0 12px 0 0;
                max-height: 70vh;
                overflow-y: auto;
            }
            
            .cv-image-editor-panel.visible {
                transform: translateX(0);
            }
            
            .cv-image-editor-panel .editor-title {
                font-size: 14px;
                margin-bottom: 10px;
            }
            
            .cv-image-editor-panel .option {
                margin-bottom: 8px;
            }
            
            .cv-image-editor-panel label {
                font-size: 12px;
            }
            
            .cv-image-editor-panel .size-inputs {
                flex-direction: column;
                gap: 5px;
            }
            
            .cv-image-editor-panel .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            
            .cv-image-editor-panel .image-position-control button {
                width: 30px;
                height: 30px;
                font-size: 14px;
                margin: 0 2px;
            }
            
            .cv-image-editor-panel input[type="number"] {
                padding: 6px;
                font-size: 12px;
            }
            
            .cv-image-editor-panel .btn-apply {
                padding: 8px;
                font-size: 12px;
            }
            
            .cv-image-editor-panel .action-buttons button {
                padding: 6px 5px;
                font-size: 11px;
            }
        }
        
        @media screen and (max-width: 480px) {
            .cv-image-editor-panel {
                width: 35%; /* Un peu plus sur très petit écran */
                max-width: 280px;
                min-width: 200px;
                padding: 8px;
                left: 0;
                transform: translateX(-100%);
                border-radius: 0 8px 0 0;
                max-height: 65vh;
                overflow-y: auto;
            }
            
            .cv-image-editor-panel.visible {
                transform: translateX(0);
            }
            
            .cv-image-editor-panel .editor-title {
                font-size: 12px;
                margin-bottom: 6px;
            }
            
            .cv-image-editor-panel .option {
                margin-bottom: 5px;
            }
            
            .cv-image-editor-panel label {
                font-size: 10px;
                margin-bottom: 3px;
            }
            
            .cv-image-editor-panel input[type="number"],
            .cv-image-editor-panel input[type="range"] {
                padding: 4px;
                font-size: 11px;
            }
            
            .cv-image-editor-panel .btn-apply {
                padding: 6px;
                font-size: 11px;
            }
            
            .cv-image-editor-panel .action-buttons button {
                padding: 5px 3px;
                font-size: 10px;
            }
            
            .cv-image-editor-panel .size-inputs {
                gap: 3px;
            }
            
            .cv-image-editor-panel .image-position-control {
                margin-top: 6px;
            }
            
            .cv-image-editor-panel .image-position-control button {
                width: 24px;
                height: 24px;
                font-size: 12px;
                margin: 0 1px;
            }
            
            .cv-image-editor-panel #imageWidthValue,
            .cv-image-editor-panel #imageHeightValue,
            .cv-image-editor-panel #imageBorderRadiusValue,
            .cv-image-editor-panel #imageOpacityValue,
            .cv-image-editor-panel #imageBrightnessValue,
            .cv-image-editor-panel #imageContrastValue {
                font-size: 9px;
                margin-left: 3px;
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
    const editableImages = scope.querySelectorAll('img:not([role="presentation"])');

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
            imageEditorPanel.classList.add('visible');
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
                display: currentImage.style.display,

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
                    if (styles.display === 'none') {
                        img.style.setProperty('display', 'none', 'important');
                    } else {
                        img.style.removeProperty('display');
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

        if (currentImage.style.display === 'none') {
            currentImage.style.removeProperty('display');
            this.textContent = "Cacher l'image";
        } else {
            currentImage.style.setProperty('display', 'none', 'important');
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
                currentImage.style.removeProperty('display');
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
        imageEditorPanel.classList.remove('visible');
        currentImage = null;

        // Réactualisation automatique de la page
        window.location.reload();
    });

    // Fermer l'éditeur
    closeImageEditor.addEventListener('click', function () {
        if (currentImage) {
            currentImage.classList.remove('active');
        }

        imageEditorPanel.classList.remove('visible');
        currentImage = null;
    });

    // Fermer l'éditeur en cliquant à l'extérieur
    document.addEventListener('click', function (e) {
        if (!imageEditorPanel.contains(e.target) && !e.target.classList.contains('editable-image')) {
            if (currentImage) {
                currentImage.classList.remove('active');
            }

            imageEditorPanel.classList.remove('visible');
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
                img.style.removeProperty('display');
            } else {
                img.style.width = '';
                img.style.height = '';
                img.style.borderRadius = '';
                img.style.opacity = '';
                img.style.filter = '';
                img.style.margin = '';
                img.style.removeProperty('display');
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