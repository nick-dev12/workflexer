<?php
// Vérification de l'appareil au tout début

// Démarre la session
session_start();



// Check if user is on desktop
/* $isDesktop = isDesktop();
if (!$isDesktop) {
    // If not on desktop, redirect to mobile message page
    header("Location: mobile_message.php");
    exit;
} */

if (isset($_GET['id'])) {
    include '../conn/conn.php';
    // Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_GET['id'];

    include_once('../controller/controller_users.php');
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_message1.php');
    include_once('../controller/controller_appel_offre.php');
    include_once('../controller/controller_centre_interet.php');
}

if (isset($_SESSION['users_id'])) {
    include '../conn/conn.php';
    // Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_SESSION['users_id'];

    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_centre_interet.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Lato:wght@400;700&family=Montserrat:wght@400;700&family=Raleway:wght@400;700&family=Poppins:wght@400;700&family=Merriweather:wght@400;700&family=Nunito:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/model8_1.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
    <button id="toggle-customization-btn" class="button12">
        <i class="fa-solid fa-palette"></i> Personnaliser
    </button>

    <!-- Bulle d'information -->
    <div class="info-bubble">
        <div class="info-content">
            <i class="fa-solid fa-circle-info"></i>
            <h3>Informations importantes sur l'affichage de votre CV</h3>
            <p>Pour garantir une présentation optimale de votre profil, certaines sections sont limitées :</p>
            <ul>
                <li><strong>Expériences professionnelles :</strong> 3 expériences maximum</li>
                <li><strong>Formations :</strong> 3 formations maximum</li>
                <li><strong>Compétences :</strong> 7 compétences maximum</li>
                <li><strong>Outils informatiques :</strong> 5 outils maximum</li>
            </ul>
            <p class="highlight">Les éléments que vous avez mis en avant dans votre profil seront affichés en priorité.
            </p>
            <button class="close-info">&times;</button>
        </div>
    </div>

    <style>
        .info-bubble {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            max-width: 400px;
            animation: slideIn 0.5s ease-out forwards;
        }

        .info-content {
            padding: 20px;
            position: relative;
        }

        .info-content i {
            color: #2196F3;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .info-content h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-content ul {
            margin: 15px 0;
            padding-left: 20px;
        }

        .info-content li {
            margin-bottom: 8px;
            color: #555;
        }

        .highlight {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            color: #1976D2;
            font-weight: 500;
        }

        .close-info {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #2196F3;
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px;
            font-size: 18px;
            transition: all 0.3s;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-info:hover {
            background: #1976D2;
            transform: scale(1.1);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        @media (max-width: 480px) {
            .info-bubble {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const closeBtn = document.querySelector('.close-info');
            const infoBubble = document.querySelector('.info-bubble');

            if (closeBtn && infoBubble) {
                closeBtn.addEventListener('click', function () {
                    infoBubble.style.animation = 'slideOut 0.5s ease-out forwards';
                    setTimeout(() => {
                        infoBubble.style.display = 'none';
                    }, 500);
                });
            }
        });
    </script>

    <!-- Bouton de téléchargement fixe toujours visible -->
    <button id="fixed-download-btn" class="fixed-download-button" onclick="generatePDF()">
        <i class="fa-solid fa-download"></i>
        <span>Télécharger PDF</span>
    </button>
    <section class="section3">
        <div class="personnalisation" id="customization-panel">
            <button id="close-panel-btn" class="close-panel-btn">&times;</button>
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <button class="button12 reset-button">Réinitialiser</button>

            <script>
                function generatePDF() {
                    // Afficher un message de chargement
                    const loadingMessage = document.createElement('div');
                    loadingMessage.innerHTML = `
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                                    background: rgba(0,0,0,0.8); display: flex; align-items: center; 
                                    justify-content: center; z-index: 99999; color: white; font-size: 18px;">
                            <div style="text-align: center;">
                                <div style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; 
                                           border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; 
                                           margin: 0 auto 15px;"></div>
                                Génération du PDF en cours...
                            </div>
                        </div>
                    `;
                    // Ajouter l'animation CSS pour le spinner
                    const style = document.createElement('style');
                    style.textContent = `
                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                    `;
                    document.head.appendChild(style);
                    document.body.appendChild(loadingMessage);

                    const { jsPDF } = window.jspdf;
                    const element = document.querySelector("#container-for-pdf");

                    // Optimisations légères pour une meilleure qualité
                    const options = {
                        scale: 2.2,
                        quality: 0.95,
                        bgcolor: '#ffffff',
                        useCORS: true
                    };

                    setTimeout(() => {
                        domtoimage.toJpeg(element, options)
                            .then(function (dataUrl) {
                                // Supprimer le message d'attente
                                if (document.body.contains(loadingMessage)) {
                                    document.body.removeChild(loadingMessage);
                                }

                                const pdf = new jsPDF('p', 'mm', 'a4');
                                const imgProps = pdf.getImageProperties(dataUrl);
                                const pdfWidth = pdf.internal.pageSize.getWidth();
                                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                                pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);

                                // Nom de fichier avec timestamp pour éviter les conflits
                                const timestamp = new Date().toISOString().slice(0, 19).replace(/[:.]/g, '-');
                                pdf.save(`cv-model8-${timestamp}.pdf`);
                            })
                            .catch(function (error) {
                                console.error('Une erreur est survenue lors de la génération du PDF:', error);
                                // Supprimer le message d'attente en cas d'erreur
                                if (document.body.contains(loadingMessage)) {
                                    document.body.removeChild(loadingMessage);
                                }
                                alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                            });
                    }, 600); // Délai léger pour stabilité
                }
            </script>

            <div class="theme-selector">
                <h3>Thèmes</h3>
                <div class="themes-container">
                    <div class="theme-card" data-theme="default">
                        <div class="theme-preview">
                            <div style="background-color: #e3f1e2; height: 20px;"></div>
                            <div style="background-color: #388e3c; height: 20px;"></div>
                        </div>
                        <span>Défaut</span>
                    </div>
                    <div class="theme-card" data-theme="midnight_blue">
                        <div class="theme-preview">
                            <div style="background-color: #003366; height: 20px;"></div>
                            <div style="background-color: #99ccff; height: 20px;"></div>
                        </div>
                        <span>Bleu Nuit</span>
                    </div>
                    <div class="theme-card" data-theme="slate_grey">
                        <div class="theme-preview">
                            <div style="background-color: #464E59; height: 20px;"></div>
                            <div style="background-color: #AAB3BE; height: 20px;"></div>
                        </div>
                        <span>Ardoise</span>
                    </div>
                    <div class="theme-card" data-theme="burgundy">
                        <div class="theme-preview">
                            <div style="background-color: #6D214F; height: 20px;"></div>
                            <div style="background-color: #B33771; height: 20px;"></div>
                        </div>
                        <span>Bordeaux</span>
                    </div>
                    <div class="theme-card" data-theme="forest_green">
                        <div class="theme-preview">
                            <div style="background-color: #194D33; height: 20px;"></div>
                            <div style="background-color: #27AE60; height: 20px;"></div>
                        </div>
                        <span>Forêt</span>
                    </div>
                    <div class="theme-card" data-theme="professional_navy">
                        <div class="theme-preview">
                            <div style="background-color: #2c3e50; height: 20px;"></div>
                            <div style="background-color: #3498db; height: 20px;"></div>
                        </div>
                        <span>Navy</span>
                    </div>
                    <div class="theme-card" data-theme="teal_grey">
                        <div class="theme-preview">
                            <div style="background-color: #F4F4F4; height: 20px;"></div>
                            <div style="background-color: #008080; height: 20px;"></div>
                        </div>
                        <span>Gris Sarcelle</span>
                    </div>
                    <div class="theme-card" data-theme="crimson_gold">
                        <div class="theme-preview">
                            <div style="background-color: #FFF8DC; height: 20px;"></div>
                            <div style="background-color: #DC143C; height: 20px;"></div>
                        </div>
                        <span>Or Cramoisi</span>
                    </div>
                    <div class="theme-card" data-theme="oceanic_deep">
                        <div class="theme-preview">
                            <div style="background-color: #F0F8FF; height: 20px;"></div>
                            <div style="background-color: #000080; height: 20px;"></div>
                        </div>
                        <span>Océan Profond</span>
                    </div>
                    <div class="theme-card" data-theme="modern_graphite">
                        <div class="theme-preview">
                            <div style="background-color: #36454F; height: 20px;"></div>
                            <div style="background-color: #FF7F50; height: 20px;"></div>
                        </div>
                        <span>Graphite Moderne</span>
                    </div>
                    <div class="theme-card" data-theme="earthy_olive">
                        <div class="theme-preview">
                            <div style="background-color: #F5F5DC; height: 20px;"></div>
                            <div style="background-color: #808000; height: 20px;"></div>
                        </div>
                        <span>Olive Terrestre</span>
                    </div>
                </div>
            </div>

            <div class="font-selector">
                <h3>Police d'écriture</h3>
                <select id="font-family-select" class="style-select">
                    <option value="'Nunito', sans-serif">Nunito (Défaut)</option>
                    <option value="'Roboto', sans-serif">Roboto</option>
                    <option value="'Lato', sans-serif">Lato</option>
                    <option value="'Montserrat', sans-serif">Montserrat</option>
                    <option value="'Raleway', sans-serif">Raleway</option>
                    <option value="'Poppins', sans-serif">Poppins</option>
                    <option value="'Merriweather', serif">Merriweather (Serif)</option>
                </select>
            </div>

            <div class="color-control-section">
                <h4>Personnalisation Manuelle</h4>
                <div class="color-box"><label>Fond (gauche)</label><input type="color" id="bgLeftPicker"></div>
                <div class="color-box"><label>Texte (gauche)</label><input type="color" id="textLeftPicker"></div>
                <div class="color-box"><label>Accentuation</label><input type="color" id="accentPicker"></div>
                <div class="color-box"><label>Bordures</label><input type="color" id="borderPicker"></div>
                <div class="color-box"><label>Dates</label><input type="color" id="textLightPicker"></div>
            </div>

            <style>
                .theme-selector,
                .color-control-section {
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f9f9f9;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }

                .theme-selector h3,
                .color-control-section h4 {
                    text-align: center;
                    margin-bottom: 15px;
                    color: #333;
                    font-size: 18px;
                    border-bottom: 1px solid #e0e0e0;
                    padding-bottom: 8px;
                }

                .themes-container {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 10px;
                }

                .theme-card {
                    border-radius: 6px;
                    overflow: hidden;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    cursor: pointer;
                    transition: transform 0.2s, box-shadow 0.2s;
                    border: 2px solid transparent;
                }

                .theme-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }

                .theme-card.active {
                    border-color: #0089be;
                }

                .theme-card span {
                    display: block;
                    text-align: center;
                    padding: 6px 0;
                    font-size: 12px;
                    background-color: white;
                }

                .color-box {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 12px;
                    background-color: white;
                    padding: 8px 12px;
                    border-radius: 4px;
                }

                .color-box label {
                    font-size: 14px;
                    color: #333;
                }

                .color-box input[type="color"] {
                    width: 35px;
                    height: 35px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    background: none;
                }

                .reset-button {
                    background-color: #e74c3c;
                }

                .reset-button:hover {
                    background-color: #c0392b;
                }

                .font-selector {
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f9f9f9;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }

                .font-selector h3 {
                    text-align: center;
                    margin-bottom: 15px;
                    color: #333;
                    font-size: 18px;
                }

                .style-select {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    background-color: white;
                    font-size: 14px;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const modelNumber = '8';
                    const storagePrefix = `model${modelNumber}-`;
                    const themes = {
                        'default': { bgLeft: '#e3f1e2', textLeft: '#333333', accent: '#388e3c', border: '#dddddd', textLight: '#6c757d' },
                        'midnight_blue': { bgLeft: '#003366', textLeft: '#FFFFFF', accent: '#4a90e2', border: '#5c7a99', textLight: '#7F8C8D' },
                        'slate_grey': { bgLeft: '#464E59', textLeft: '#F5F7FA', accent: '#778899', border: '#79818A', textLight: '#95A5A6' },
                        'burgundy': { bgLeft: '#6D214F', textLeft: '#F5F7FA', accent: '#B33771', border: '#8c4369', textLight: '#95A5A6' },
                        'forest_green': { bgLeft: '#194D33', textLeft: '#F5F7FA', accent: '#27AE60', border: '#2e694a', textLight: '#95A5A6' },
                        'professional_navy': { bgLeft: '#2c3e50', textLeft: '#ecf0f1', accent: '#3498db', border: '#5d6d7e', textLight: '#95A5A6' },
                        'teal_grey': { bgLeft: '#F4F4F4', textLeft: '#333333', accent: '#008080', border: '#D3D3D3', textLight: '#696969' },
                        'crimson_gold': { bgLeft: '#FFF8DC', textLeft: '#5d4037', accent: '#DC143C', border: '#F0E68C', textLight: '#b8860b' },
                        'oceanic_deep': { bgLeft: '#F0F8FF', textLeft: '#000080', accent: '#1E90FF', border: '#ADD8E6', textLight: '#4682B4' },
                        'modern_graphite': { bgLeft: '#36454F', textLeft: '#FFFFFF', accent: '#FF7F50', border: '#708090', textLight: '#A9A9A9' },
                        'earthy_olive': { bgLeft: '#F5F5DC', textLeft: '#556B2F', accent: '#808000', border: '#BDB76B', textLight: '#6B8E23' }
                    };
                    const defaultColors = themes.default;

                    const themeCards = document.querySelectorAll('.theme-card');
                    const bgLeftPicker = document.getElementById('bgLeftPicker');
                    const textLeftPicker = document.getElementById('textLeftPicker');
                    const accentPicker = document.getElementById('accentPicker');
                    const borderPicker = document.getElementById('borderPicker');
                    const textLightPicker = document.getElementById('textLightPicker');
                    const resetButton = document.querySelector('.reset-button');
                    const root = document.documentElement;
                    const fontSelect = document.getElementById('font-family-select');

                    function applyColors(colors) {
                        root.style.setProperty('--m8-bg-left', colors.bgLeft);
                        root.style.setProperty('--m8-text-left', colors.textLeft);
                        root.style.setProperty('--m8-accent', colors.accent);
                        root.style.setProperty('--m8-border', colors.border);
                        root.style.setProperty('--m8-text-light', colors.textLight);

                        bgLeftPicker.value = colors.bgLeft;
                        textLeftPicker.value = colors.textLeft;
                        accentPicker.value = colors.accent;
                        borderPicker.value = colors.border;
                        textLightPicker.value = colors.textLight;
                    }

                    function saveColors(colors) {
                        Object.keys(colors).forEach(key => {
                            localStorage.setItem(`${storagePrefix}${key}`, colors[key]);
                        });
                    }

                    function applyFont(fontFamily) {
                        root.style.setProperty('--m8-main-font', fontFamily);
                        localStorage.setItem(`${storagePrefix}fontFamily`, fontFamily);
                    }

                    themeCards.forEach(card => {
                        card.addEventListener('click', function () {
                            const themeName = this.dataset.theme;
                            if (themes[themeName]) {
                                applyColors(themes[themeName]);
                                saveColors(themes[themeName]);
                                localStorage.setItem(`${storagePrefix}activeTheme`, themeName);
                                themeCards.forEach(c => c.classList.remove('active'));
                                this.classList.add('active');
                            }
                        });
                    });

                    [bgLeftPicker, textLeftPicker, accentPicker, borderPicker, textLightPicker].forEach(picker => {
                        picker.addEventListener('input', () => {
                            const currentColors = {
                                bgLeft: bgLeftPicker.value,
                                textLeft: textLeftPicker.value,
                                accent: accentPicker.value,
                                border: borderPicker.value,
                                textLight: textLightPicker.value
                            };
                            applyColors(currentColors);
                            saveColors(currentColors);
                            localStorage.setItem(`${storagePrefix}activeTheme`, 'custom');
                            themeCards.forEach(c => c.classList.remove('active'));
                        });
                    });

                    resetButton.addEventListener('click', () => {
                        applyColors(defaultColors);
                        Object.keys(defaultColors).forEach(key => localStorage.removeItem(`${storagePrefix}${key}`));
                        localStorage.removeItem(`${storagePrefix}activeTheme`);
                        themeCards.forEach(c => c.classList.remove('active'));
                        document.querySelector('.theme-card[data-theme="default"]').classList.add('active');
                    });

                    function loadPreferences() {
                        const activeTheme = localStorage.getItem(`${storagePrefix}activeTheme`);
                        if (activeTheme && themes[activeTheme] && activeTheme !== 'custom') {
                            applyColors(themes[activeTheme]);
                            document.querySelector(`.theme-card[data-theme="${activeTheme}"]`).classList.add('active');
                        } else {
                            const savedColors = {
                                bgLeft: localStorage.getItem(`${storagePrefix}bgLeft`),
                                textLeft: localStorage.getItem(`${storagePrefix}textLeft`),
                                accent: localStorage.getItem(`${storagePrefix}accent`),
                                border: localStorage.getItem(`${storagePrefix}border`),
                                textLight: localStorage.getItem(`${storagePrefix}textLight`)
                            };
                            if (savedColors.bgLeft) {
                                applyColors(savedColors);
                            } else {
                                applyColors(defaultColors);
                                document.querySelector('.theme-card[data-theme="default"]').classList.add('active');
                            }
                        }

                        const savedFont = localStorage.getItem(`${storagePrefix}fontFamily`);
                        if (savedFont) {
                            applyFont(savedFont);
                            fontSelect.value = savedFont;
                        }
                    }
                    loadPreferences();
                });
            </script>
        </div>

        <div class="cv-container" id="cv8-visible">
            <div class="left-column">
                <h1 class="name-title"><?= $userss['nom'] ?></h1>
                <p class="subtitle" style="margin-top: 5px; font-style: italic; text-transform: none;">
                    <?= $userss['competences'] ?>
                </p>
                <img src="../upload/<?= $userss['images'] ? $userss['images'] : 'default-profile.jpg' ?>"
                    alt="Photo de profil" class="profile-image">

                <div class="contact">
                    <h3>CONTACT</h3>
                    <p><?= $userss['phone'] ?></p>
                    <p><?= $userss['ville'] ?></p>
                    <p><?= $userss['mail'] ?></p>
                </div>

                <div class="languages">
                    <h3>LANGUES</h3>
                    <?php if (empty($afficheLangue)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <?php foreach ($afficheLangue as $langues): ?>
                            <p><?= $langues['langue'] ?> : <?= $langues['niveau'] ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="skills">
                    <h3>COMPÉTENCES</h3>
                    <?php if (empty($competencesUtilisateur)): ?>
                        <h4>Aucune donnée trouvée</h4>
                    <?php else: ?>
                        <?php
                        // Séparer les compétences en deux groupes
                        $competences_mises_en_avant = array_filter($competencesUtilisateur, function ($comp) {
                            return isset($comp['mis_en_avant']) && $comp['mis_en_avant'] == 1;
                        });
                        $competences_non_mises_en_avant = array_filter($competencesUtilisateur, function ($comp) {
                            return !isset($comp['mis_en_avant']) || $comp['mis_en_avant'] != 1;
                        });

                        // Mélanger les compétences non mises en avant
                        shuffle($competences_non_mises_en_avant);

                        // Nombre maximum de compétences à afficher
                        $nombre_competences = 7;

                        // Combiner les compétences
                        $competences_a_afficher = array_merge(
                            array_slice($competences_mises_en_avant, 0, $nombre_competences),
                            array_slice($competences_non_mises_en_avant, 0, max(0, $nombre_competences - count($competences_mises_en_avant)))
                        );
                        ?>
                        <ul>
                            <?php foreach ($competences_a_afficher as $competence): ?>
                                <li><?php echo $competence['competence']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="skills">
                    <h3>OUTILS</h3>
                    <?php if (empty($afficheOutil)): ?>
                        <h4>Aucune donnée trouvée</h4>
                    <?php else: ?>
                        <?php
                        // Séparer les outils en deux groupes
                        $outils_mis_en_avant = array_filter($afficheOutil, function ($outil) {
                            return isset($outil['mis_en_avant']) && $outil['mis_en_avant'] == 1;
                        });
                        $outils_non_mis_en_avant = array_filter($afficheOutil, function ($outil) {
                            return !isset($outil['mis_en_avant']) || $outil['mis_en_avant'] != 1;
                        });

                        // Mélanger les outils non mis en avant
                        shuffle($outils_non_mis_en_avant);

                        // Nombre maximum d'outils à afficher
                        $nombre_outils = 5;

                        // Combiner les outils
                        $outils_a_afficher = array_merge(
                            array_slice($outils_mis_en_avant, 0, $nombre_outils),
                            array_slice($outils_non_mis_en_avant, 0, max(0, $nombre_outils - count($outils_mis_en_avant)))
                        );
                        ?>
                        <ul>
                            <?php foreach ($outils_a_afficher as $outils): ?>
                                <li><?= $outils['outil'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="right-column">
                <div class="profile">
                    <h3>PROFIL</h3>
                    <?php if (empty($descriptions)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p><?= $descriptions['description'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="section">
                    <h3>FORMATION</h3>
                    <?php if (empty($formationUsers)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <?php
                        // Séparer les formations en deux groupes
                        $formations_mises_en_avant = array_filter($formationUsers, function ($form) {
                            return isset($form['mis_en_avant']) && $form['mis_en_avant'] == 1;
                        });
                        $formations_non_mises_en_avant = array_filter($formationUsers, function ($form) {
                            return !isset($form['mis_en_avant']) || $form['mis_en_avant'] != 1;
                        });

                        // Mélanger les formations non mises en avant
                        shuffle($formations_non_mises_en_avant);

                        // Nombre maximum de formations à afficher
                        $nombre_formation = 3;

                        // Combiner les formations
                        $formations_a_afficher = array_merge(
                            array_slice($formations_mises_en_avant, 0, $nombre_formation),
                            array_slice($formations_non_mises_en_avant, 0, max(0, $nombre_formation - count($formations_mises_en_avant)))
                        );
                        ?>
                        <?php foreach ($formations_a_afficher as $formations): ?>
                            <div class="education-item">
                                <h4><?= $formations['etablissement'] ?> <span class="date">
                                        <?= $formations['moisDebut'] ?>/<?= $formations['anneeDebut'] ?> -
                                        <?= $formations['moisFin'] ?>/<?= $formations['anneeFin'] ?>
                                    </span></h4>
                                <p><?= $formations['Filiere'] ?> (<?= $formations['niveau'] ?>)</p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="section">
                    <h3>EXPÉRIENCES PROFESSIONNELLES</h3>
                    <?php if (empty($afficheMetier)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <?php
                        // Séparer les expériences en deux groupes
                        $experiences_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                            return isset($exp['mis_en_avant']) && $exp['mis_en_avant'] == 1;
                        });
                        $experiences_non_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                            return !isset($exp['mis_en_avant']) || $exp['mis_en_avant'] != 1;
                        });

                        // Mélanger les expériences non mises en avant
                        shuffle($experiences_non_mises_en_avant);

                        // Nombre maximum d'expériences à afficher
                        $nombre_metier = 3;

                        // Combiner les expériences
                        $experiences_a_afficher = array_merge(
                            array_slice($experiences_mises_en_avant, 0, $nombre_metier),
                            array_slice($experiences_non_mises_en_avant, 0, max(0, $nombre_metier - count($experiences_mises_en_avant)))
                        );
                        ?>
                        <?php foreach ($experiences_a_afficher as $Metiers): ?>
                            <div class="experience-item">
                                <h4><?= $Metiers['metier'] ?>
                                    <?php if (!empty($Metiers['entreprise'])): ?> |
                                        <?= $Metiers['entreprise'] ?>         <?php endif; ?>
                                </h4>
                                <p class="date">
                                    <?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                    <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?>
                                    <?php if (!empty($Metiers['ville'])): ?> | <?= $Metiers['ville'] ?><?php endif; ?>
                                </p>
                                <p><?= $Metiers['description'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>


            </div>
        </div>


        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div id="container-for-pdf" class="cv-container">
                <div class="left-column">
                    <h1 class="name-title"><?= $userss['nom'] ?></h1>
                    <p class="subtitle" style="margin-top: 5px; font-style: italic; text-transform: none;">
                        <?= $userss['competences'] ?>
                    </p>
                    <img src="../upload/<?= $userss['images'] ? $userss['images'] : 'default-profile.jpg' ?>"
                        alt="Photo de profil" class="profile-image">

                    <div class="contact">
                        <h3>CONTACT</h3>
                        <p><?= $userss['phone'] ?></p>
                        <p><?= $userss['ville'] ?></p>
                        <p><?= $userss['mail'] ?></p>
                    </div>

                    <div class="languages">
                        <h3>LANGUES</h3>
                        <?php if (empty($afficheLangue)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <?php foreach ($afficheLangue as $langues): ?>
                                <p><?= $langues['langue'] ?> : <?= $langues['niveau'] ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="skills">
                        <h3>COMPÉTENCES</h3>
                        <?php if (empty($competencesUtilisateur)): ?>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            // Séparer les compétences en deux groupes
                            $competences_mises_en_avant = array_filter($competencesUtilisateur, function ($comp) {
                                return isset($comp['mis_en_avant']) && $comp['mis_en_avant'] == 1;
                            });
                            $competences_non_mises_en_avant = array_filter($competencesUtilisateur, function ($comp) {
                                return !isset($comp['mis_en_avant']) || $comp['mis_en_avant'] != 1;
                            });

                            // Mélanger les compétences non mises en avant
                            shuffle($competences_non_mises_en_avant);

                            // Nombre maximum de compétences à afficher
                            $nombre_competences = 7;

                            // Combiner les compétences
                            $competences_a_afficher = array_merge(
                                array_slice($competences_mises_en_avant, 0, $nombre_competences),
                                array_slice($competences_non_mises_en_avant, 0, max(0, $nombre_competences - count($competences_mises_en_avant)))
                            );
                            ?>
                            <ul>
                                <?php foreach ($competences_a_afficher as $competence): ?>
                                    <li><?php echo $competence['competence']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="skills">
                        <h3>OUTILS</h3>
                        <?php if (empty($afficheOutil)): ?>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            // Séparer les outils en deux groupes
                            $outils_mis_en_avant = array_filter($afficheOutil, function ($outil) {
                                return isset($outil['mis_en_avant']) && $outil['mis_en_avant'] == 1;
                            });
                            $outils_non_mis_en_avant = array_filter($afficheOutil, function ($outil) {
                                return !isset($outil['mis_en_avant']) || $outil['mis_en_avant'] != 1;
                            });

                            // Mélanger les outils non mis en avant
                            shuffle($outils_non_mis_en_avant);

                            // Nombre maximum d'outils à afficher
                            $nombre_outils = 5;

                            // Combiner les outils
                            $outils_a_afficher = array_merge(
                                array_slice($outils_mis_en_avant, 0, $nombre_outils),
                                array_slice($outils_non_mis_en_avant, 0, max(0, $nombre_outils - count($outils_mis_en_avant)))
                            );
                            ?>
                            <ul>
                                <?php foreach ($outils_a_afficher as $outils): ?>
                                    <li><?= $outils['outil'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="right-column">
                    <div class="profile">
                        <h3>PROFIL</h3>
                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p><?= $descriptions['description'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="section">
                        <h3>FORMATION</h3>
                        <?php if (empty($formationUsers)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <?php
                            // Séparer les formations en deux groupes
                            $formations_mises_en_avant = array_filter($formationUsers, function ($form) {
                                return isset($form['mis_en_avant']) && $form['mis_en_avant'] == 1;
                            });
                            $formations_non_mises_en_avant = array_filter($formationUsers, function ($form) {
                                return !isset($form['mis_en_avant']) || $form['mis_en_avant'] != 1;
                            });

                            // Mélanger les formations non mises en avant
                            shuffle($formations_non_mises_en_avant);

                            // Nombre maximum de formations à afficher
                            $nombre_formation = 3;

                            // Combiner les formations
                            $formations_a_afficher = array_merge(
                                array_slice($formations_mises_en_avant, 0, $nombre_formation),
                                array_slice($formations_non_mises_en_avant, 0, max(0, $nombre_formation - count($formations_mises_en_avant)))
                            );
                            ?>
                            <?php foreach ($formations_a_afficher as $formations): ?>
                                <div class="education-item">
                                    <h4><?= $formations['etablissement'] ?> <span class="date">
                                            <?= $formations['moisDebut'] ?>/<?= $formations['anneeDebut'] ?> -
                                            <?= $formations['moisFin'] ?>/<?= $formations['anneeFin'] ?>
                                        </span></h4>
                                    <p><?= $formations['Filiere'] ?> (<?= $formations['niveau'] ?>)</p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="section">
                        <h3>EXPÉRIENCES PROFESSIONNELLES</h3>
                        <?php if (empty($afficheMetier)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <?php
                            // Séparer les expériences en deux groupes
                            $experiences_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                return isset($exp['mis_en_avant']) && $exp['mis_en_avant'] == 1;
                            });
                            $experiences_non_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                return !isset($exp['mis_en_avant']) || $exp['mis_en_avant'] != 1;
                            });

                            // Mélanger les expériences non mises en avant
                            shuffle($experiences_non_mises_en_avant);

                            // Nombre maximum d'expériences à afficher
                            $nombre_metier = 3;

                            // Combiner les expériences
                            $experiences_a_afficher = array_merge(
                                array_slice($experiences_mises_en_avant, 0, $nombre_metier),
                                array_slice($experiences_non_mises_en_avant, 0, max(0, $nombre_metier - count($experiences_mises_en_avant)))
                            );
                            ?>
                            <?php foreach ($experiences_a_afficher as $Metiers): ?>
                                <div class="experience-item">
                                    <h4><?= $Metiers['metier'] ?>
                                        <?php if (!empty($Metiers['entreprise'])): ?> |
                                            <?= $Metiers['entreprise'] ?>         <?php endif; ?>
                                    </h4>
                                    <p class="date">
                                        <?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                        <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?>
                                        <?php if (!empty($Metiers['ville'])): ?> | <?= $Metiers['ville'] ?><?php endif; ?>
                                    </p>
                                    <p><?= $Metiers['description'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggle-customization-btn');
            const customPanel = document.getElementById('customization-panel');
            const closeBtn = document.getElementById('close-panel-btn');

            if (toggleBtn && customPanel && closeBtn) {
                // Ouvre le panneau
                toggleBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    customPanel.classList.add('active');
                });

                // Ferme le panneau avec la croix
                closeBtn.addEventListener('click', function () {
                    customPanel.classList.remove('active');
                });

                // Ferme le panneau si on clique en dehors
                document.addEventListener('click', function (event) {
                    if (customPanel.classList.contains('active') && !customPanel.contains(event.target) && !toggleBtn.contains(event.target)) {
                        customPanel.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>

</html>