/**
 * CV Customizer - Core System
 * A modular and reusable customization system for CV templates
 */

class CVCustomizer {
    constructor(options = {}) {
        this.options = {
            saveToLocalStorage: true,
            storageKey: 'cv-customizer-data',
            ...options
        };

        this.currentElement = null;
        this.editModeActive = false;
        this.initialize();
    }

    /**
     * Initialize the customizer system
     */
    initialize() {
        this.initializeUI();
        this.initializeEventListeners();
        this.loadSavedStyles();
    }

    /**
     * Create and inject the customizer UI
     */
    initializeUI() {
        // Create preview button
        const previewBtn = document.createElement('button');
        previewBtn.className = 'cv-preview-btn';
        previewBtn.innerHTML = `
            <i class="fas fa-eye"></i>
            <span>Aperçu & Télécharger</span>
        `;
        document.body.appendChild(previewBtn);

        // Create customizer panel
        const customizer = document.createElement('div');
        customizer.className = 'cv-customizer';
        customizer.innerHTML = `
            <div class="cv-element-info">
                <div class="cv-element-type">
                    Élément: <span>Aucun élément sélectionné</span>
                </div>
                <button class="cv-close-customizer">&times;</button>
            </div>

            <div class="cv-customizer-tabs">
                <button class="cv-tab active" data-tab="text">
                    <i class="fas fa-font"></i>
                    Texte
                </button>
                <button class="cv-tab" data-tab="colors">
                    <i class="fas fa-palette"></i>
                    Couleurs
                </button>
                <button class="cv-tab" data-tab="layout">
                    <i class="fas fa-columns"></i>
                    Mise en page
                </button>
                <button class="cv-tab" data-tab="themes">
                    <i class="fas fa-brush"></i>
                    Thèmes
                </button>
            </div>

            <div class="cv-customizer-content">
                <!-- Text Panel -->
                <div class="cv-tab-panel active" id="text-panel">
                    <div class="cv-option-group">
                        <h3>Police de caractères</h3>
                        <div class="cv-control">
                            <label>Famille de police</label>
                            <select class="cv-select" id="font-family">
                                <option value="'Roboto', sans-serif">Roboto</option>
                                <option value="'Open Sans', sans-serif">Open Sans</option>
                                <option value="'Lato', sans-serif">Lato</option>
                                <option value="'Poppins', sans-serif">Poppins</option>
                                <option value="'Montserrat', sans-serif">Montserrat</option>
                            </select>
                        </div>
                        <div class="cv-control">
                            <label>Taille du texte</label>
                            <div class="cv-slider">
                                <input type="range" min="8" max="72" value="16" id="font-size">
                                <span class="cv-slider-value">16px</span>
                            </div>
                        </div>
                    </div>

                    <div class="cv-option-group">
                        <h3>Style du texte</h3>
                        <div class="cv-button-group">
                            <button data-style="bold"><i class="fas fa-bold"></i></button>
                            <button data-style="italic"><i class="fas fa-italic"></i></button>
                            <button data-style="underline"><i class="fas fa-underline"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Colors Panel -->
                <div class="cv-tab-panel" id="colors-panel">
                    <div class="cv-option-group">
                        <h3>Couleurs principales</h3>
                        <div class="cv-control">
                            <label>Couleur du texte</label>
                            <input type="color" class="cv-color-picker" id="text-color" value="#2c3e50">
                        </div>
                        <div class="cv-control">
                            <label>Couleur de fond</label>
                            <input type="color" class="cv-color-picker" id="bg-color" value="#ffffff">
                        </div>
                    </div>

                    <div class="cv-option-group">
                        <h3>Couleurs d'accent</h3>
                        <div class="cv-control">
                            <label>Couleur primaire</label>
                            <input type="color" class="cv-color-picker" id="primary-color" value="#3498db">
                        </div>
                        <div class="cv-control">
                            <label>Couleur secondaire</label>
                            <input type="color" class="cv-color-picker" id="secondary-color" value="#2ecc71">
                        </div>
                    </div>
                </div>

                <!-- Layout Panel -->
                <div class="cv-tab-panel" id="layout-panel">
                    <div class="cv-option-group">
                        <h3>Espacement</h3>
                        <div class="cv-control">
                            <label>Marge intérieure</label>
                            <div class="cv-slider">
                                <input type="range" min="0" max="40" value="15" id="padding">
                                <span class="cv-slider-value">15px</span>
                            </div>
                        </div>
                        <div class="cv-control">
                            <label>Marge extérieure</label>
                            <div class="cv-slider">
                                <input type="range" min="0" max="40" value="15" id="margin">
                                <span class="cv-slider-value">15px</span>
                            </div>
                        </div>
                    </div>

                    <div class="cv-option-group">
                        <h3>Alignement</h3>
                        <div class="cv-button-group">
                            <button data-align="left"><i class="fas fa-align-left"></i></button>
                            <button data-align="center"><i class="fas fa-align-center"></i></button>
                            <button data-align="right"><i class="fas fa-align-right"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Themes Panel -->
                <div class="cv-tab-panel" id="themes-panel">
                    <div class="cv-option-group">
                        <h3>Thèmes prédéfinis</h3>
                        <div class="cv-theme-presets">
                            <div class="cv-theme-preset active" style="background: linear-gradient(135deg, #3498db 50%, #ffffff 50%);" data-theme="classic"></div>
                            <div class="cv-theme-preset" style="background: linear-gradient(135deg, #2c3e50 50%, #ecf0f1 50%);" data-theme="dark"></div>
                            <div class="cv-theme-preset" style="background: linear-gradient(135deg, #27ae60 50%, #f9f9f9 50%);" data-theme="nature"></div>
                            <div class="cv-theme-preset" style="background: linear-gradient(135deg, #8e44ad 50%, #f0f0f0 50%);" data-theme="creative"></div>
                            <div class="cv-theme-preset" style="background: linear-gradient(135deg, #e74c3c 50%, #f5f5f5 50%);" data-theme="dynamic"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cv-action-bar">
                <button class="cv-action-btn cv-reset-btn">
                    <i class="fas fa-undo"></i>
                    Réinitialiser
                </button>
                <button class="cv-action-btn cv-save-btn">
                    <i class="fas fa-save"></i>
                    Enregistrer
                </button>
            </div>
        `;
        document.body.appendChild(customizer);

        // Add edit indicators to editable elements
        document.querySelectorAll('.cv-editable').forEach(element => {
            const indicator = document.createElement('span');
            indicator.className = 'cv-edit-indicator';
            indicator.textContent = 'Éditer';
            element.appendChild(indicator);
        });
    }

    /**
     * Initialize all event listeners
     */
    initializeEventListeners() {
        // Toggle edit mode with preview button
        document.querySelector('.cv-preview-btn').addEventListener('click', () => {
            this.toggleEditMode();
        });

        // Close customizer
        document.querySelector('.cv-close-customizer').addEventListener('click', () => {
            this.closeCustomizer();
        });

        // Tab switching
        document.querySelectorAll('.cv-tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                this.switchTab(e.currentTarget.dataset.tab);
            });
        });

        // Editable elements
        document.querySelectorAll('.cv-editable').forEach(element => {
            element.addEventListener('click', (e) => {
                if (!this.editModeActive) return;
                e.stopPropagation();
                this.selectElement(element);
            });
        });

        // Font family changes
        document.getElementById('font-family').addEventListener('change', (e) => {
            if (this.currentElement) {
                this.currentElement.style.fontFamily = e.target.value;
                this.saveStyles();
            }
        });

        // Font size changes
        document.getElementById('font-size').addEventListener('input', (e) => {
            if (this.currentElement) {
                this.currentElement.style.fontSize = `${e.target.value}px`;
                e.target.nextElementSibling.textContent = `${e.target.value}px`;
                this.saveStyles();
            }
        });

        // Color changes
        document.querySelectorAll('.cv-color-picker').forEach(picker => {
            picker.addEventListener('input', (e) => {
                this.handleColorChange(e.target.id, e.target.value);
            });
        });

        // Style buttons
        document.querySelectorAll('[data-style]').forEach(button => {
            button.addEventListener('click', (e) => {
                this.toggleStyle(e.currentTarget.dataset.style);
            });
        });

        // Alignment buttons
        document.querySelectorAll('[data-align]').forEach(button => {
            button.addEventListener('click', (e) => {
                this.setAlignment(e.currentTarget.dataset.align);
            });
        });

        // Theme presets
        document.querySelectorAll('.cv-theme-preset').forEach(preset => {
            preset.addEventListener('click', (e) => {
                this.applyTheme(e.currentTarget.dataset.theme);
            });
        });

        // Save and reset buttons
        document.querySelector('.cv-save-btn').addEventListener('click', () => {
            this.saveStyles();
        });

        document.querySelector('.cv-reset-btn').addEventListener('click', () => {
            this.resetStyles();
        });

        // Click outside to deselect
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.cv-customizer') && !e.target.closest('.cv-editable')) {
                this.deselectElement();
            }
        });
    }

    /**
     * Toggle edit mode
     */
    toggleEditMode() {
        this.editModeActive = !this.editModeActive;
        document.body.classList.toggle('cv-edit-mode', this.editModeActive);

        if (this.editModeActive) {
            document.querySelector('.cv-customizer').classList.add('active');
            document.querySelectorAll('.cv-editable').forEach(el => {
                el.classList.add('edit-mode-active');
            });
        } else {
            this.closeCustomizer();
        }
    }

    /**
     * Close the customizer panel
     */
    closeCustomizer() {
        document.querySelector('.cv-customizer').classList.remove('active');
        document.body.classList.remove('cv-edit-mode');
        document.querySelectorAll('.cv-editable').forEach(el => {
            el.classList.remove('edit-mode-active');
        });
        this.deselectElement();
        this.editModeActive = false;
    }

    /**
     * Switch between customizer tabs
     */
    switchTab(tabId) {
        document.querySelectorAll('.cv-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.tab === tabId);
        });

        document.querySelectorAll('.cv-tab-panel').forEach(panel => {
            panel.classList.toggle('active', panel.id === `${tabId}-panel`);
        });
    }

    /**
     * Select an element for editing
     */
    selectElement(element) {
        if (this.currentElement) {
            this.currentElement.classList.remove('editing');
        }

        this.currentElement = element;
        element.classList.add('editing');

        // Update element info
        const elementType = element.dataset.type || 'texte';
        const elementText = element.textContent.trim().substring(0, 30);
        document.querySelector('.cv-element-type span').textContent =
            `${elementType.charAt(0).toUpperCase() + elementType.slice(1)}: ${elementText}`;

        // Update controls
        this.updateControlsFromElement(element);
    }

    /**
     * Deselect the current element
     */
    deselectElement() {
        if (this.currentElement) {
            this.currentElement.classList.remove('editing');
            this.currentElement = null;
            document.querySelector('.cv-element-type span').textContent = 'Aucun élément sélectionné';
        }
    }

    /**
     * Update control values based on selected element
     */
    updateControlsFromElement(element) {
        // Font family
        const fontFamily = window.getComputedStyle(element).fontFamily;
        document.getElementById('font-family').value = fontFamily;

        // Font size
        const fontSize = parseInt(window.getComputedStyle(element).fontSize);
        document.getElementById('font-size').value = fontSize;
        document.querySelector('#font-size + .cv-slider-value').textContent = `${fontSize}px`;

        // Colors
        const textColor = this.rgb2hex(window.getComputedStyle(element).color);
        document.getElementById('text-color').value = textColor;

        const bgColor = this.rgb2hex(window.getComputedStyle(element).backgroundColor);
        document.getElementById('bg-color').value = bgColor;

        // Text alignment
        const textAlign = window.getComputedStyle(element).textAlign;
        document.querySelectorAll('[data-align]').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.align === textAlign);
        });

        // Text style
        const fontWeight = window.getComputedStyle(element).fontWeight;
        const fontStyle = window.getComputedStyle(element).fontStyle;
        const textDecoration = window.getComputedStyle(element).textDecoration;

        document.querySelector('[data-style="bold"]').classList.toggle('active', fontWeight >= 700);
        document.querySelector('[data-style="italic"]').classList.toggle('active', fontStyle === 'italic');
        document.querySelector('[data-style="underline"]').classList.toggle('active', textDecoration.includes('underline'));
    }

    /**
     * Handle color changes
     */
    handleColorChange(colorId, value) {
        if (!this.currentElement) return;

        switch (colorId) {
            case 'text-color':
                this.currentElement.style.color = value;
                break;
            case 'bg-color':
                this.currentElement.style.backgroundColor = value;
                break;
            case 'primary-color':
                document.documentElement.style.setProperty('--customizer-primary', value);
                break;
            case 'secondary-color':
                document.documentElement.style.setProperty('--customizer-secondary', value);
                break;
        }

        this.saveStyles();
    }

    /**
     * Toggle text style (bold, italic, underline)
     */
    toggleStyle(style) {
        if (!this.currentElement) return;

        const button = document.querySelector(`[data-style="${style}"]`);
        button.classList.toggle('active');

        switch (style) {
            case 'bold':
                this.currentElement.style.fontWeight = button.classList.contains('active') ? 'bold' : 'normal';
                break;
            case 'italic':
                this.currentElement.style.fontStyle = button.classList.contains('active') ? 'italic' : 'normal';
                break;
            case 'underline':
                this.currentElement.style.textDecoration = button.classList.contains('active') ? 'underline' : 'none';
                break;
        }

        this.saveStyles();
    }

    /**
     * Set text alignment
     */
    setAlignment(alignment) {
        if (!this.currentElement) return;

        document.querySelectorAll('[data-align]').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.align === alignment);
        });

        this.currentElement.style.textAlign = alignment;
        this.saveStyles();
    }

    /**
     * Apply theme preset
     */
    applyTheme(theme) {
        document.querySelectorAll('.cv-theme-preset').forEach(preset => {
            preset.classList.toggle('active', preset.dataset.theme === theme);
        });

        const themes = {
            classic: {
                primary: '#3498db',
                secondary: '#2ecc71',
                text: '#2c3e50',
                background: '#ffffff'
            },
            dark: {
                primary: '#2c3e50',
                secondary: '#34495e',
                text: '#ecf0f1',
                background: '#1a1a1a'
            },
            nature: {
                primary: '#27ae60',
                secondary: '#2ecc71',
                text: '#2c3e50',
                background: '#f9f9f9'
            },
            creative: {
                primary: '#8e44ad',
                secondary: '#9b59b6',
                text: '#2c3e50',
                background: '#f0f0f0'
            },
            dynamic: {
                primary: '#e74c3c',
                secondary: '#c0392b',
                text: '#2c3e50',
                background: '#f5f5f5'
            }
        };

        const selectedTheme = themes[theme];
        if (selectedTheme) {
            document.documentElement.style.setProperty('--customizer-primary', selectedTheme.primary);
            document.documentElement.style.setProperty('--customizer-secondary', selectedTheme.secondary);
            document.documentElement.style.setProperty('--customizer-text', selectedTheme.text);
            document.documentElement.style.setProperty('--customizer-bg', selectedTheme.background);

            document.getElementById('primary-color').value = selectedTheme.primary;
            document.getElementById('secondary-color').value = selectedTheme.secondary;
            document.getElementById('text-color').value = selectedTheme.text;
            document.getElementById('bg-color').value = selectedTheme.background;

            this.saveStyles();
        }
    }

    /**
     * Save current styles
     */
    saveStyles() {
        if (!this.options.saveToLocalStorage) return;

        const styles = {
            theme: {
                primary: document.documentElement.style.getPropertyValue('--customizer-primary'),
                secondary: document.documentElement.style.getPropertyValue('--customizer-secondary'),
                text: document.documentElement.style.getPropertyValue('--customizer-text'),
                background: document.documentElement.style.getPropertyValue('--customizer-bg')
            },
            elements: {}
        };

        document.querySelectorAll('.cv-editable').forEach(element => {
            const id = element.id || this.generateElementId(element);
            styles.elements[id] = {
                fontFamily: element.style.fontFamily,
                fontSize: element.style.fontSize,
                color: element.style.color,
                backgroundColor: element.style.backgroundColor,
                fontWeight: element.style.fontWeight,
                fontStyle: element.style.fontStyle,
                textDecoration: element.style.textDecoration,
                textAlign: element.style.textAlign
            };
        });

        localStorage.setItem(this.options.storageKey, JSON.stringify(styles));
    }

    /**
     * Load saved styles
     */
    loadSavedStyles() {
        if (!this.options.saveToLocalStorage) return;

        const savedStyles = JSON.parse(localStorage.getItem(this.options.storageKey));
        if (!savedStyles) return;

        // Apply theme
        if (savedStyles.theme) {
            document.documentElement.style.setProperty('--customizer-primary', savedStyles.theme.primary);
            document.documentElement.style.setProperty('--customizer-secondary', savedStyles.theme.secondary);
            document.documentElement.style.setProperty('--customizer-text', savedStyles.theme.text);
            document.documentElement.style.setProperty('--customizer-bg', savedStyles.theme.background);
        }

        // Apply element styles
        Object.entries(savedStyles.elements).forEach(([id, styles]) => {
            const element = document.getElementById(id);
            if (element) {
                Object.entries(styles).forEach(([property, value]) => {
                    if (value) element.style[property] = value;
                });
            }
        });
    }

    /**
     * Reset all styles
     */
    resetStyles() {
        if (confirm('Voulez-vous vraiment réinitialiser toutes les personnalisations ?')) {
            localStorage.removeItem(this.options.storageKey);
            location.reload();
        }
    }

    /**
     * Generate unique ID for an element
     */
    generateElementId(element) {
        const id = `cv-element-${Math.random().toString(36).substr(2, 9)}`;
        element.id = id;
        return id;
    }

    /**
     * Convert RGB color to hexadecimal
     */
    rgb2hex(rgb) {
        if (rgb.startsWith('#')) return rgb;

        const rgbMatch = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (!rgbMatch) return '#000000';

        const hex = x => ('0' + parseInt(x).toString(16)).slice(-2);
        return '#' + hex(rgbMatch[1]) + hex(rgbMatch[2]) + hex(rgbMatch[3]);
    }
}

// Initialize the customizer when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.cvCustomizer = new CVCustomizer();
}); 