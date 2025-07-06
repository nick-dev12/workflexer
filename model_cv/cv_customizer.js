/**
 * Système de personnalisation de CV
 * Script réutilisable pour tous les modèles de CV
 */

document.addEventListener('DOMContentLoaded', function () {
    // Identifier le modèle de CV actuel basé sur l'URL ou un attribut data
    const currentModelPath = window.location.pathname;
    const modelMatch = currentModelPath.match(/model(\d+)\.php/);
    const modelNumber = modelMatch ? modelMatch[1] : 'unknown';

    // Clé unique pour chaque modèle de CV
    const CV_STORAGE_KEY = `cv-styles-model-${modelNumber}`;

    console.log(`Modèle de CV détecté: ${modelNumber}, utilisant la clé de stockage: ${CV_STORAGE_KEY}`);

    // Scope d'application pour les modifications
    const cvContainer = document.querySelector('.cv-container, #cv-container, #container,.container,.cv10,.cv11,.cv12,.cv13,.cv14,.cv15');
    const scope = cvContainer ? cvContainer : document;

    if (!cvContainer) {
        console.warn("Conteneur CV non trouvé (.cv-container, #cv-container, #container,.container,.cv10,.cv11,.cv12,.cv13,.cv14,.cv15). Les modifications seront globales pour assurer la compatibilité ascendante.");
    }

    // CSS à injecter pour le panneau de personnalisation
    const customCSS = `
        .cv-editor-panel {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) translateY(100%);
            background-color: #f8f9fa;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px 12px 0 0;
            padding: 20px;
            z-index: 1000;
            width: 380px;
            display: block;
            font-family: 'Nunito', sans-serif;
            transition: transform 0.3s ease-out;
        }

        .cv-editor-panel.visible {
            transform: translateX(-50%) translateY(0);
        }

        .cv-editor-panel .editor-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .cv-editor-panel .option {
            margin-bottom: 15px;
        }

        .cv-editor-panel label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #495057;
        }
        
        .cv-editor-panel #fontSizeValue {
            font-weight: 600;
            color: #007bff;
            margin-left: 10px;
        }

        .cv-editor-panel input[type="range"] {
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

        .cv-editor-panel input[type="range"]:hover {
            opacity: 1;
        }

        .cv-editor-panel input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            background: #007bff;
            cursor: pointer;
            border-radius: 50%;
        }

        .cv-editor-panel input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: #007bff;
            cursor: pointer;
            border-radius: 50%;
        }

        .cv-editor-panel input[type="color"] {
            -webkit-appearance: none;
            border: none;
            width: 100%;
            height: 35px;
            cursor: pointer;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .cv-editor-panel input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        .cv-editor-panel input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 4px;
        }
        
        .cv-editor-panel select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
        }

        .cv-editor-panel .close-btn {
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

        .cv-editor-panel .close-btn:hover {
            color: #495057;
        }

        .cv-editor-panel .btn-apply {
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
        
        .cv-editor-panel .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        
        .cv-editor-panel .btn-apply-bg {
            background-color: #ff9800;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            font-size: 12px;
            transition: background-color 0.2s;
        }

        .cv-editor-panel .btn-apply-bg:hover {
            background-color: #fb8c00;
        }

        .editable-element {
            cursor: pointer;
            transition: outline 0.2s;
        }

        .editable-element:hover {
            outline: 2px dashed #3498db;
        }
        
        .editable-element.active {
            outline: 2px solid #3498db;
        }
        
        .cv-editor-panel .checkbox-option {
            display: block;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        
        .cv-editor-panel .checkbox-option input {
            width: auto;
            margin-right: 10px;
        }
        
        .cv-editor-panel .bg-color-container {
            display: flex;
            align-items: center;
        }
        
        .cv-editor-panel .bg-color-container input {
            flex: 1;
        }
        
        /* Responsive design for smaller screens */
        @media screen and (max-width: 768px) {
            .cv-editor-panel {
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
            
            .cv-editor-panel.visible {
                transform: translateX(0);
            }
            
            .cv-editor-panel .editor-title {
                font-size: 14px;
                margin-bottom: 10px;
            }
            
            .cv-editor-panel .option {
                margin-bottom: 8px;
            }
            
            .cv-editor-panel label {
                font-size: 12px;
            }
            
            .cv-editor-panel input,
            .cv-editor-panel select {
                padding: 6px;
                font-size: 12px;
            }
            
            .cv-editor-panel .btn-apply {
                padding: 8px;
                font-size: 12px;
            }
            
            .cv-editor-panel .btn-apply-bg {
                padding: 4px 8px;
                font-size: 11px;
            }
        }
        
        @media screen and (max-width: 480px) {
            .cv-editor-panel {
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
            
            .cv-editor-panel.visible {
                transform: translateX(0);
            }
            
            .cv-editor-panel .editor-title {
                font-size: 12px;
                margin-bottom: 6px;
            }
            
            .cv-editor-panel .option {
                margin-bottom: 5px;
            }
            
            .cv-editor-panel label {
                font-size: 10px;
                margin-bottom: 3px;
            }
            
            .cv-editor-panel input,
            .cv-editor-panel select {
                padding: 4px;
                font-size: 11px;
            }
            
            .cv-editor-panel .btn-apply {
                padding: 6px;
                font-size: 11px;
            }
            
            .cv-editor-panel .btn-apply-bg {
                padding: 3px 6px;
                font-size: 10px;
                margin-left: 5px;
            }
            
            .cv-editor-panel .checkbox-option {
                display: block;
                width: 100%;
                margin-top: 3px;
                margin-bottom: 6px;
            }
            
            .cv-editor-panel .checkbox-option label {
                font-size: 9px;
            }
            
            .cv-editor-panel #fontSizeValue {
                font-size: 9px;
                margin-left: 3px;
            }
        }
    `;

    // Injecter le CSS
    const styleEl = document.createElement('style');
    styleEl.textContent = customCSS;
    document.head.appendChild(styleEl);

    // Créer le panneau d'édition
    const editorPanel = document.createElement('div');
    editorPanel.className = 'cv-editor-panel';
    editorPanel.id = 'editorPanel';
    editorPanel.innerHTML = `
        <button class="close-btn" id="closeEditor">&times;</button>
        <div class="editor-title">Personnaliser l'élément</div>
        <div class="option">
            <label for="fontSize">Taille du texte</label>
            <input type="range" id="fontSize" min="8" max="24" value="14" step="1">
            <span id="fontSizeValue">14px</span>
        </div>
        <div class="option">
            <label for="textColor">Couleur du texte</label>
            <input type="color" id="textColor" value="#000000">
        </div>
        <div class="option">
            <label for="bgColor">Couleur de fond</label>
            <div class="bg-color-container">
                <input type="color" id="bgColor" value="#ffffff">
                <button class="btn-apply-bg" id="applyBgColor">Appliquer</button>
            </div>
        </div>
        <div class="option">
            <label for="fontFamily">Police d'écriture</label>
            <select id="fontFamily">
                <option value="Nunito, sans-serif">Nunito (Défaut)</option>
                <option value="Arial, sans-serif">Arial</option>
                <option value="Georgia, serif">Georgia</option>
                <option value="Verdana, sans-serif">Verdana</option>
                <option value="Helvetica, sans-serif">Helvetica</option>
                <option value="Times New Roman, serif">Times New Roman</option>
                <option value="Courier New, monospace">Courier New</option>
            </select>
        </div>
        <div class="checkbox-option">
            <input type="checkbox" id="applyToSame" checked>
            <label for="applyToSame">Appliquer à tous les éléments de même classe</label>
        </div>
        <div class="checkbox-option">
            <input type="checkbox" id="applyToAllType" checked>
            <label for="applyToAllType">Appliquer à tous les éléments de même type (h1, p, etc.)</label>
        </div>
        <button class="btn-apply" id="applyChanges">Appliquer</button>
    `;
    document.body.appendChild(editorPanel);

    // Sélectionner tous les éléments éditables
    // Ces sélecteurs peuvent être ajustés selon le modèle de CV
    const editableElements = [
        // Éléments de contenu basiques
        ...scope.querySelectorAll('p, span, h1, h2, h3, h4, h5, h6, li, strong, em'),
        // Classes spécifiques pour certains modèles
        ...scope.querySelectorAll('.text, .nom, .profession, .item, .skill, .experience-item, .education-item')
    ];

    let currentElement = null;
    let currentElementClass = '';
    let currentElementType = '';

    const closeEditor = document.getElementById('closeEditor');
    const fontSizeInput = document.getElementById('fontSize');
    const fontSizeValue = document.getElementById('fontSizeValue');
    const textColorInput = document.getElementById('textColor');
    const bgColorInput = document.getElementById('bgColor');
    const applyBgColorBtn = document.getElementById('applyBgColor');
    const fontFamilySelect = document.getElementById('fontFamily');
    const applyToSameCheck = document.getElementById('applyToSame');
    const applyToAllTypeCheck = document.getElementById('applyToAllType');
    const applyChangesBtn = document.getElementById('applyChanges');

    // Ajouter la classe editable-element à tous les éléments
    editableElements.forEach(element => {
        // Éviter les éléments d'image et les éléments non affichés
        if (element.tagName !== 'IMG' &&
            getComputedStyle(element).display !== 'none' &&
            !element.closest('#editorPanel')) {
            element.classList.add('editable-element');

            element.addEventListener('click', function (e) {
                e.stopPropagation();

                // Supprimer la classe active de l'élément précédent
                if (currentElement) {
                    currentElement.classList.remove('active');
                }

                currentElement = element;
                // Stocker la classe principale de l'élément (si présente)
                currentElementClass = element.classList.length > 1 ?
                    Array.from(element.classList).filter(cls => cls !== 'editable-element' && cls !== 'active')[0] || '' : '';

                // Stocker le type d'élément
                currentElementType = element.tagName.toLowerCase();

                currentElement.classList.add('active');

                // Mettre à jour l'éditeur avec les valeurs actuelles
                const computedStyle = window.getComputedStyle(element);

                // Définir la taille de police
                const currentSize = parseInt(computedStyle.fontSize);
                fontSizeInput.value = currentSize;
                fontSizeValue.textContent = currentSize + 'px';

                // Définir la couleur du texte
                const currentColor = computedStyle.color;
                // Convertir RGB en HEX
                const rgb = currentColor.match(/\d+/g);
                if (rgb && rgb.length === 3) {
                    const hex = '#' + ((1 << 24) + (parseInt(rgb[0]) << 16) + (parseInt(rgb[1]) << 8) + parseInt(rgb[2])).toString(16).slice(1);
                    textColorInput.value = hex;
                }

                // Définir la couleur de fond
                const currentBgColor = computedStyle.backgroundColor;
                if (currentBgColor && currentBgColor !== 'rgba(0, 0, 0, 0)' && currentBgColor !== 'transparent') {
                    const bgRgb = currentBgColor.match(/\d+/g);
                    if (bgRgb && bgRgb.length >= 3) {
                        const bgHex = '#' + ((1 << 24) + (parseInt(bgRgb[0]) << 16) + (parseInt(bgRgb[1]) << 8) + parseInt(bgRgb[2])).toString(16).slice(1);
                        bgColorInput.value = bgHex;
                    }
                } else {
                    bgColorInput.value = '#ffffff';
                }

                // Définir la famille de police
                const currentFont = computedStyle.fontFamily;
                // Essayer de faire correspondre avec les options disponibles
                const fontOptions = Array.from(fontFamilySelect.options);
                const matchingOption = fontOptions.find(option => currentFont.includes(option.value.split(',')[0]));
                if (matchingOption) {
                    fontFamilySelect.value = matchingOption.value;
                }

                // Afficher l'éditeur
                editorPanel.classList.add('visible');
            });
        }
    });

    // Mettre à jour la taille de police en temps réel
    fontSizeInput.addEventListener('input', function () {
        fontSizeValue.textContent = this.value + 'px';
        if (currentElement) {
            applyStyle('fontSize', this.value + 'px');
        }
    });

    // Appliquer les changements de couleur en temps réel
    textColorInput.addEventListener('input', function () {
        if (currentElement) {
            applyStyle('color', this.value);
        }
    });

    // Appliquer les changements de couleur de fond uniquement avec le bouton
    applyBgColorBtn.addEventListener('click', function () {
        if (currentElement) {
            applyStyle('backgroundColor', bgColorInput.value);
        }
    });

    // Appliquer les changements de police en temps réel
    fontFamilySelect.addEventListener('change', function () {
        if (currentElement) {
            applyStyle('fontFamily', this.value);
        }
    });

    // Fonction pour appliquer un style à un élément ou plusieurs éléments selon les options
    function applyStyle(property, value) {
        if (!currentElement) return;

        // Les éléments auxquels appliquer le style
        const targetsToUpdate = [];

        // Cas 1: Appliquer à tous les éléments de même classe (si l'option est cochée et l'élément a une classe)
        if (applyToSameCheck.checked && currentElementClass) {
            scope.querySelectorAll('.' + currentElementClass).forEach(el => {
                if (el.classList.contains('editable-element')) {
                    targetsToUpdate.push(el);
                }
            });
        }

        // Cas 2: Appliquer à tous les éléments de même type (si l'option est cochée)
        else if (applyToAllTypeCheck.checked) {
            scope.querySelectorAll(currentElementType).forEach(el => {
                if (el.classList.contains('editable-element')) {
                    targetsToUpdate.push(el);
                }
            });
        }

        // Cas 3: Appliquer uniquement à l'élément courant
        else {
            targetsToUpdate.push(currentElement);
        }

        // Appliquer le style à tous les éléments cibles
        targetsToUpdate.forEach(el => {
            el.style[property] = value;
        });
    }

    // Fermer l'éditeur
    closeEditor.addEventListener('click', function () {
        if (currentElement) {
            currentElement.classList.remove('active');

            // Enregistrer l'état actuel dans localStorage
            saveCurrentElementStyle();
        }

        editorPanel.classList.remove('visible');
        currentElement = null;
    });

    // Fermer l'éditeur en cliquant à l'extérieur
    document.addEventListener('click', function (e) {
        if (!editorPanel.contains(e.target) && !e.target.classList.contains('editable-element')) {
            if (currentElement) {
                currentElement.classList.remove('active');

                // Enregistrer l'état actuel dans localStorage
                saveCurrentElementStyle();
            }

            editorPanel.classList.remove('visible');
            currentElement = null;
        }
    });

    // Appliquer les changements et sauvegarder dans localStorage
    applyChangesBtn.addEventListener('click', function () {
        if (currentElement) {
            saveCurrentElementStyle();
            currentElement.classList.remove('active');
            editorPanel.classList.remove('visible');
            currentElement = null;
        }
    });

    // Fonction pour sauvegarder le style actuel dans localStorage
    function saveCurrentElementStyle() {
        if (!currentElement) return;

        // Récupérer les paramètres actuels du panneau
        const fontSize = fontSizeInput.value + 'px';
        const color = textColorInput.value;
        const bgColor = currentElement.style.backgroundColor || '';
        const fontFamily = fontFamilySelect.value;

        // Créer l'objet de style
        const styleObject = {
            fontSize: fontSize,
            color: color,
            backgroundColor: bgColor,
            fontFamily: fontFamily
        };

        try {
            // Récupérer tous les styles personnalisés pour ce CV
            let cvStyles = JSON.parse(localStorage.getItem(CV_STORAGE_KEY) || '{}');

            // Cas 1: Appliquer à tous les éléments de même classe
            if (applyToSameCheck.checked && currentElementClass) {
                if (!cvStyles.classes) {
                    cvStyles.classes = {};
                }
                cvStyles.classes[currentElementClass] = styleObject;

                console.log(`Styles sauvegardés pour la classe: ${currentElementClass}`, styleObject);
            }
            // Cas 2: Appliquer à tous les éléments de même type
            else if (applyToAllTypeCheck.checked) {
                if (!cvStyles.elementTypes) {
                    cvStyles.elementTypes = {};
                }
                cvStyles.elementTypes[currentElementType] = styleObject;

                console.log(`Styles sauvegardés pour le type: ${currentElementType}`, styleObject);
            }
            // Cas 3: Appliquer uniquement à l'élément courant
            else {
                const elementPath = getElementPath(currentElement);

                if (!cvStyles.specificElements) {
                    cvStyles.specificElements = {};
                }

                // Stocker à la fois le chemin d'accès et l'identifiant plus précis
                cvStyles.specificElements[elementPath] = {
                    ...styleObject,
                    elementType: currentElementType,
                    elementClass: currentElementClass,
                    // Ajout d'informations supplémentaires pour aider l'identification
                    innerText: currentElement.innerText ?
                        currentElement.innerText.substring(0, 20) : '',
                    innerHTML: currentElement.innerHTML ?
                        currentElement.innerHTML.substring(0, 50) : ''
                };

                console.log(`Styles sauvegardés pour l'élément spécifique: ${elementPath}`,
                    cvStyles.specificElements[elementPath]);
            }

            // Sauvegarder dans localStorage
            localStorage.setItem(CV_STORAGE_KEY, JSON.stringify(cvStyles));
            console.log(`Styles sauvegardés avec succès pour le modèle ${modelNumber}`);
        } catch (e) {
            console.error('Erreur lors de la sauvegarde des styles:', e);
        }
    }

    // Fonction pour créer un identifiant unique pour les éléments
    function getElementPath(element) {
        let path = element.tagName.toLowerCase();
        if (element.id) {
            path += '#' + element.id;
        } else if (element.className) {
            const classes = Array.from(element.classList)
                .filter(cls => cls !== 'editable-element' && cls !== 'active');
            if (classes.length > 0) {
                path += '.' + classes.join('.');
            }
        }

        // Ajouter l'indice de position pour une meilleure unicité
        // Créer un chemin plus précis en incluant tous les parents
        let parent = element.parentNode;
        let currentElement = element;
        let positionPath = '';

        while (parent && parent.tagName && parent.tagName !== 'BODY' && parent.tagName !== 'HTML') {
            const siblings = Array.from(parent.children)
                .filter(el => el.tagName === currentElement.tagName);
            const index = siblings.indexOf(currentElement);
            positionPath = `/${currentElement.tagName.toLowerCase()}:nth-of-type(${index + 1})` + positionPath;

            currentElement = parent;
            parent = parent.parentNode;
        }

        // Ajouter le chemin complet pour une identification plus précise
        path += positionPath;

        return path;
    }

    // Appliquer les styles sauvegardés au chargement de la page
    function applySavedStyles() {
        try {
            // Récupérer tous les styles stockés
            const cvStyles = JSON.parse(localStorage.getItem(CV_STORAGE_KEY) || '{}');
            console.log('Styles chargés:', cvStyles);

            // 1. D'abord appliquer les styles de type d'élément (comme tous les h1, tous les p, etc.)
            if (cvStyles.elementTypes) {
                Object.keys(cvStyles.elementTypes).forEach(elementType => {
                    const styles = cvStyles.elementTypes[elementType];
                    console.log(`Application des styles au type d'élément: ${elementType}`, styles);

                    scope.querySelectorAll(elementType).forEach(el => {
                        if (el.classList.contains('editable-element')) {
                            applyStylesToElement(el, styles);
                        }
                    });
                });
            }

            // 2. Ensuite, appliquer les styles aux classes d'éléments (ils remplacent les styles de type)
            if (cvStyles.classes) {
                Object.keys(cvStyles.classes).forEach(className => {
                    const styles = cvStyles.classes[className];
                    console.log(`Application des styles à la classe: ${className}`, styles);

                    scope.querySelectorAll('.' + className).forEach(el => {
                        if (el.classList.contains('editable-element')) {
                            applyStylesToElement(el, styles);
                        }
                    });
                });
            }

            // 3. Enfin, appliquer les styles aux éléments spécifiques (ils remplacent les deux précédents)
            if (cvStyles.specificElements) {
                // Créer un tableau de tous les éléments éditables avec leurs chemins
                const allEditableElements = [];
                scope.querySelectorAll('.editable-element').forEach(el => {
                    const path = getElementPath(el);
                    allEditableElements.push({
                        element: el,
                        path: path,
                        type: el.tagName.toLowerCase(),
                        class: el.classList.length > 1 ?
                            Array.from(el.classList).filter(cls => cls !== 'editable-element' && cls !== 'active')[0] || '' : '',
                        innerText: el.innerText ? el.innerText.substring(0, 20) : '',
                        innerHTML: el.innerHTML ? el.innerHTML.substring(0, 50) : ''
                    });
                });

                console.log("Éléments éditables trouvés:", allEditableElements.length);

                // Pour chaque chemin stocké, chercher l'élément correspondant
                Object.keys(cvStyles.specificElements).forEach(elementPath => {
                    const styles = cvStyles.specificElements[elementPath];
                    console.log(`Recherche de l'élément spécifique avec le chemin: ${elementPath}`, styles);

                    // Trouver l'élément qui correspond le mieux au chemin
                    let bestMatch = null;
                    let bestMatchScore = 0;

                    allEditableElements.forEach(({ element, path, type, class: className, innerText, innerHTML }) => {
                        // Calculer un score de correspondance (plus élevé = meilleure correspondance)
                        let score = 0;

                        // Correspondance de chemin
                        const pathParts = elementPath.split('/');
                        const currentPathParts = path.split('/');

                        // Si les types de base correspondent (h1, p, etc.)
                        if (pathParts[0] === currentPathParts[0]) {
                            score += 2;

                            // Vérifier les parties communes du chemin
                            for (let i = 1; i < Math.min(pathParts.length, currentPathParts.length); i++) {
                                if (pathParts[i] === currentPathParts[i]) {
                                    score += 1;
                                }
                            }
                        }

                        // Utiliser les informations supplémentaires pour améliorer la correspondance
                        if (styles.elementType && type === styles.elementType) {
                            score += 3;
                        }

                        if (styles.elementClass && className === styles.elementClass) {
                            score += 4;
                        }

                        // Comparaison du contenu texte
                        if (styles.innerText && innerText && styles.innerText.includes(innerText)) {
                            score += 5;
                        }

                        if (styles.innerHTML && innerHTML && styles.innerHTML.includes(innerHTML)) {
                            score += 2;
                        }

                        // Si ce score est meilleur que le précédent, mettre à jour
                        if (score > bestMatchScore) {
                            bestMatchScore = score;
                            bestMatch = element;
                        }
                    });

                    // Si on a trouvé une correspondance, appliquer les styles
                    if (bestMatch && bestMatchScore > 2) {
                        console.log(`Correspondance trouvée pour ${elementPath} avec score ${bestMatchScore}:`, bestMatch);
                        applyStylesToElement(bestMatch, styles);
                    } else {
                        console.log(`Aucune bonne correspondance trouvée pour ${elementPath} (meilleur score: ${bestMatchScore})`);

                        // Essais avec d'autres méthodes de sélection
                        if (styles.elementClass) {
                            console.log(`Tentative avec la classe: ${styles.elementClass}`);
                            const classMatches = scope.querySelectorAll('.' + styles.elementClass);
                            if (classMatches.length > 0) {
                                console.log(`${classMatches.length} éléments trouvés avec la classe`);
                                classMatches.forEach(el => {
                                    if (el.classList.contains('editable-element')) {
                                        applyStylesToElement(el, styles);
                                    }
                                });
                            }
                        } else if (styles.elementType) {
                            console.log(`Tentative avec le type: ${styles.elementType}`);
                            const typeMatches = scope.querySelectorAll(styles.elementType);
                            if (typeMatches.length > 0) {
                                console.log(`${typeMatches.length} éléments trouvés avec le type`);
                                // On prend le premier élément qui contient du texte similaire
                                for (const el of typeMatches) {
                                    if (el.classList.contains('editable-element') &&
                                        styles.innerText &&
                                        el.innerText.includes(styles.innerText.substring(0, 10))) {
                                        console.log("Correspondance par contenu textuel trouvée:", el);
                                        applyStylesToElement(el, styles);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            console.log(`Styles appliqués avec succès pour le modèle ${modelNumber}`);
        } catch (e) {
            console.error('Erreur lors de l\'application des styles:', e);
        }
    }

    // Fonction d'aide pour appliquer différents styles à un élément
    function applyStylesToElement(element, styles) {
        if (styles.fontSize) element.style.fontSize = styles.fontSize;
        if (styles.color) element.style.color = styles.color;
        if (styles.backgroundColor) element.style.backgroundColor = styles.backgroundColor;
        if (styles.fontFamily) element.style.fontFamily = styles.fontFamily;
    }

    // Appliquer les styles sauvegardés au chargement avec un délai pour s'assurer que tous les éléments sont chargés
    setTimeout(applySavedStyles, 300);

    // Si les styles ne sont pas appliqués correctement au premier délai, essayer à nouveau
    setTimeout(() => {
        console.log("Vérification supplémentaire des styles...");
        applySavedStyles();
    }, 1000);

    // Fonction pour réinitialiser tous les styles
    window.resetAllCVStyles = function () {
        localStorage.removeItem(CV_STORAGE_KEY);
        window.location.reload();
    };

    // Ajouter un bouton de réinitialisation dans le panneau de personnalisation existant
    const personnalisationDiv = document.querySelector('.personnalisation');
    if (personnalisationDiv) {
        const resetButton = document.createElement('button');
        resetButton.className = 'button12';
        resetButton.textContent = 'Réinitialiser les styles';
        resetButton.style.marginTop = '10px';
        resetButton.style.backgroundColor = '#ff5252';
        resetButton.onclick = function () {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser tous les styles personnalisés?')) {
                resetAllCVStyles();
            }
        };
        personnalisationDiv.appendChild(resetButton);
    }
}); 