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
    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session


    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
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
    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_SESSION['users_id'];


    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>model5</title>

    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Merriweather:wght@400;700&family=Montserrat:wght@400;700&family=Poppins:wght@400;700&family=Raleway:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="../css/model5.css" />
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
    <button id="toggle-customization-btn" class="button12">
        <i class="fa-solid fa-palette"></i> Personnaliser
    </button>

    <!-- Bouton de téléchargement fixe toujours visible -->
    <button id="fixed-download-btn" class="fixed-download-button" onclick="generatePDF()">
        <i class="fa-solid fa-download"></i>
        <span>Télécharger PDF</span>
    </button>
    <section class="section3">
        <div class="personnalisation" id="customization-panel">
            <button id="close-panel-btn" class="close-panel-btn">&times;</button>
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <button class="button12 reset-button" onclick="resetStyles()">Réinitialiser le style</button>
            <script>
                function resetStyles() {
                    // Récupérer le numéro du modèle
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '5';
                    const storagePrefix = `model${modelNumber}-`;

                    // Liste des clés à supprimer
                    const keysToRemove = [
                        `${storagePrefix}font_color_section_m5`,
                        `${storagePrefix}texte_color_m5`,
                        `${storagePrefix}texte_color2_m5`,
                        `${storagePrefix}light_text_m5`,
                        `${storagePrefix}item_bg_m5`
                    ];

                    // Supprimer toutes les clés
                    keysToRemove.forEach(key => {
                        localStorage.removeItem(key);
                    });

                    // Appliquer les couleurs par défaut
                    document.documentElement.style.setProperty('--font-color-m5', '#ebebeb');
                    document.documentElement.style.setProperty('--text-color-m5', '#000000');
                    document.documentElement.style.setProperty('--text-color2-m5', '#0089be');
                    document.documentElement.style.setProperty('--light-text-m5', 'rgba(0, 0, 0, 0.6)');
                    document.documentElement.style.setProperty('--item-bg-m5', 'rgba(195, 193, 193, 0.5)');

                    // Mettre à jour les valeurs des inputs de couleur
                    document.getElementById('fontColor_m52').value = '#ebebeb';
                    document.getElementById('fontColor_m53').value = '#000000';
                    document.getElementById('fontColor_m54').value = '#0089be';

                    // Retirer la classe active de toutes les cartes de thème
                    document.querySelectorAll('.theme-card').forEach(card => {
                        card.classList.remove('active');
                    });

                    // Trouver la carte du thème par défaut et la marquer comme active
                    const defaultThemeCard = document.querySelector('.theme-card[data-theme="classic"]');
                    if (defaultThemeCard) {
                        defaultThemeCard.classList.add('active');
                    }

                    // Message de confirmation
                    alert('Les styles ont été réinitialisés avec succès !');
                }

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
                    const scale = 2.2;
                    const options = {
                        scale: scale,
                        quality: 0.95,
                        bgcolor: '#ffffff',
                        width: element.offsetWidth * scale,
                        height: element.offsetHeight * scale,
                        style: {
                            transform: 'scale(' + scale + ')',
                            transformOrigin: 'top left',
                            width: element.offsetWidth + "px",
                            height: element.offsetHeight + "px"
                        },
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
                                pdf.save(`cv-model5-${timestamp}.pdf`);
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
                <h3>Thèmes de couleurs</h3>
                    <h4>Classiques</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="classic">
                            <div class="theme-preview">
                                <div style="background-color: #2F4F4F; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #708090; height: 15px;"></div>
                            </div>
                            <span>Classique</span>
                        </div>
                        <div class="theme-card" data-theme="professional">
                            <div class="theme-preview">
                                <div style="background-color: #1D3557; height: 15px;"></div>
                                <div style="background-color: #F1FAEE; height: 15px;"></div>
                                <div style="background-color: #457B9D; height: 15px;"></div>
                            </div>
                            <span>Professionnel</span>
                        </div>
                        <div class="theme-card" data-theme="corporate">
                            <div class="theme-preview">
                                <div style="background-color: #1A237E; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #5C6BC0; height: 15px;"></div>
                            </div>
                            <span>Corporate</span>
                        </div>
                         <div class="theme-card" data-theme="slate">
                            <div class="theme-preview">
                                <div style="background-color: #4A4A4A; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #CCCCCC; height: 15px;"></div>
                            </div>
                            <span>Ardoise</span>
                        </div>
                    </div>

                    <h4>Couleurs vives</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="elegant">
                            <div class="theme-preview">
                                <div style="background-color: #0E3B43; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #328590; height: 15px;"></div>
                            </div>
                            <span>Élégant</span>
                        </div>
                        <div class="theme-card" data-theme="creative">
                            <div class="theme-preview">
                                <div style="background-color: #845EC2; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #D7BDF8; height: 15px;"></div>
                            </div>
                            <span>Créatif</span>
                        </div>
                        <div class="theme-card" data-theme="modern">
                            <div class="theme-preview">
                                <div style="background-color: #3D5A80; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #98C1D9; height: 15px;"></div>
                            </div>
                            <span>Moderne</span>
                        </div>
                        <div class="theme-card" data-theme="mint">
                            <div class="theme-preview">
                                <div style="background-color: #21897E; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #A8E6CF; height: 15px;"></div>
                            </div>
                            <span>Menthe</span>
                        </div>
                    </div>

                    <h4>Tons chauds</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="earthy">
                            <div class="theme-preview">
                                <div style="background-color: #5F4B32; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #E6CCB2; height: 15px;"></div>
                            </div>
                            <span>Terreux</span>
                        </div>
                        <div class="theme-card" data-theme="burgundy">
                            <div class="theme-preview">
                                <div style="background-color: #800020; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #F8C3CB; height: 15px;"></div>
                            </div>
                            <span>Bordeaux</span>
                        </div>
                        <div class="theme-card" data-theme="amber">
                            <div class="theme-preview">
                                <div style="background-color: #B86E00; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #FFD699; height: 15px;"></div>
                            </div>
                            <span>Ambre</span>
                        </div>
                    </div>

                    <h4>Nouveaux Thèmes Originaux</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="azure-sky">
                            <div class="theme-preview">
                                <div style="background-color: #87CEEB; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #4682B4; height: 15px;"></div>
                            </div>
                            <span>Ciel d'Azur</span>
                        </div>
                        <div class="theme-card" data-theme="olive-grove">
                            <div class="theme-preview">
                                <div style="background-color: #556B2F; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #808000; height: 15px;"></div>
                            </div>
                            <span>Oliveraie</span>
                        </div>
                        <div class="theme-card" data-theme="crimson-night">
                            <div class="theme-preview">
                                <div style="background-color: #1C1C1C; height: 15px;"></div>
                                <div style="background-color: #FFFFFF; height: 15px;"></div>
                                <div style="background-color: #DC143C; height: 15px;"></div>
                            </div>
                            <span>Nuit Carmin</span>
                        </div>
                        <div class="theme-card" data-theme="lavender-mist">
                            <div class="theme-preview">
                                <div style="background-color: #E6E6FA; height: 15px;"></div>
                                <div style="background-color: #333333; height: 15px;"></div>
                                <div style="background-color: #9370DB; height: 15px;"></div>
                            </div>
                            <span>Brume Lavande</span>
                        </div>
                        <div class="theme-card" data-theme="royal-gold">
                            <div class="theme-preview">
                                <div style="background-color: #4B0082; height: 15px;"></div>
                                <div style="background-color: #FFD700; height: 15px;"></div>
                                <div style="background-color: #FFD700; height: 15px;"></div>
                            </div>
                            <span>Or Royal</span>
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

            <style>
                .theme-selector { margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                .theme-selector h3 { text-align: center; margin-bottom: 15px; color: #333; font-size: 18px; }
                .theme-selector h4 { border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin: 15px 0 10px; color: #555; font-size: 16px; }
                .themes-section { max-height: 400px; overflow-y: auto; padding-right: 5px; }
                .themes-container { display: flex; flex-wrap: wrap; justify-content: flex-start; gap: 12px; margin-bottom: 15px; }
                .theme-card { width: calc(25% - 12px); min-width: 85px; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
                .theme-card:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
                .theme-card.active { border: 2px solid #0089be; transform: translateY(-2px); }
                .theme-preview { width: 100%; }
                .theme-card span { display: block; text-align: center; padding: 6px 0; font-size: 12px; background-color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

                .font-selector { margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                .font-selector h3 { text-align: center; margin-bottom: 15px; color: #333; font-size: 18px; }
                .style-select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: white; font-size: 14px; -webkit-appearance: none; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%236c757d%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right .7em top 50%; background-size: .65em auto; cursor: pointer; }
            </style>
            
            <div class="color-control-section">
                <h4>Personnalisation manuelle</h4>
                <div class="color-box">
                    <label for="fontColor_m52">
                        <span class="color-label">Couleur de fond (barre latérale)</span>
                    </label>
                    <input type="color" id="fontColor_m52">
                </div>
                <div class="color-box">
                    <label for="fontColor_m53">
                        <span class="color-label">Texte sur fond coloré</span>
                    </label>
                    <input type="color" id="fontColor_m53">
                </div>
                <div class="color-box">
                    <label for="fontColor_m54">
                        <span class="color-label">Couleur d'accentuation (titres)</span>
                    </label>
                    <input type="color" id="fontColor_m54">
                </div>
            </div>
            <style>
                .color-control-section { margin-top: 20px; background-color: #f5f5f5; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                .color-control-section h4 { margin-top: 0; margin-bottom: 15px; color: #333; font-size: 16px; text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 8px; }
                .color-box { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; background-color: white; padding: 8px 12px; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
                .color-box label { flex: 1; font-weight: bold; font-size: 14px; color: #333; }
                .color-box input[type="color"] { width: 40px; height: 40px; border: none; border-radius: 4px; cursor: pointer; background: none; }
            </style>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ---- CONFIGURATION ----
                const modelNumber = '5';
                const storagePrefix = `model${modelNumber}-`;

                const themes = {
                    classic:    { bgPrimary: '#2F4F4F', textOnPrimary: '#FFFFFF', accent: '#708090' },
                    professional:{ bgPrimary: '#1D3557', textOnPrimary: '#F1FAEE', accent: '#457B9D' },
                    corporate:  { bgPrimary: '#1A237E', textOnPrimary: '#FFFFFF', accent: '#5C6BC0' },
                    slate:      { bgPrimary: '#4A4A4A', textOnPrimary: '#FFFFFF', accent: '#CCCCCC' },
                    elegant:    { bgPrimary: '#0E3B43', textOnPrimary: '#FFFFFF', accent: '#328590' },
                    creative:   { bgPrimary: '#845EC2', textOnPrimary: '#FFFFFF', accent: '#D7BDF8' },
                    modern:     { bgPrimary: '#3D5A80', textOnPrimary: '#FFFFFF', accent: '#98C1D9' },
                    mint:       { bgPrimary: '#21897E', textOnPrimary: '#FFFFFF', accent: '#A8E6CF' },
                    earthy:     { bgPrimary: '#5F4B32', textOnPrimary: '#FFFFFF', accent: '#E6CCB2' },
                    burgundy:   { bgPrimary: '#800020', textOnPrimary: '#FFFFFF', accent: '#F8C3CB' },
                    amber:      { bgPrimary: '#B86E00', textOnPrimary: '#FFFFFF', accent: '#FFD699' },
                    'azure-sky': { bgPrimary: '#87CEEB', textOnPrimary: '#000000', accent: '#4682B4' },
                    'olive-grove': { bgPrimary: '#556B2F', textOnPrimary: '#FFFFFF', accent: '#808000' },
                    'crimson-night':{ bgPrimary: '#1C1C1C', textOnPrimary: '#FFFFFF', accent: '#DC143C' },
                    'lavender-mist':{ bgPrimary: '#E6E6FA', textOnPrimary: '#483D8B', accent: '#9370DB' },
                    'royal-gold': { bgPrimary: '#4B0082', textOnPrimary: '#FFD700', accent: '#FFD700' }
                };

                const defaultColors = {
                    bgPrimary: '#ebebeb',
                    textOnPrimary: '#2c3e50',
                    accent: '#0089be'
                };

                // ---- DOM ELEMENTS ----
                const themeCards = document.querySelectorAll('.theme-card');
                const bgPrimaryPicker = document.getElementById('fontColor_m52');
                const textOnPrimaryPicker = document.getElementById('fontColor_m53');
                const accentPicker = document.getElementById('fontColor_m54');
                const resetButton = document.querySelector('.reset-button');
                const fontSelect = document.getElementById('font-family-select');
                const cvContainer = document.querySelector('.container');
                const fontStorageKey = `${storagePrefix}fontFamily`;

                // ---- FUNCTIONS ----
                function applyColors(colors) {
                    const root = document.documentElement;
                    const itemBg = hexToRgba(colors.accent, 0.15);
                    const iconFilter = isColorLight(colors.textOnPrimary) 
                        ? 'invert(15%) sepia(21%) saturate(1249%) hue-rotate(169deg) brightness(92%) contrast(91%)' // for light text -> dark icon
                        : 'invert(99%) sepia(3%) saturate(538%) hue-rotate(193deg) brightness(119%) contrast(100%)'; // for dark text -> light icon

                    root.style.setProperty('--m5-bg-primary', colors.bgPrimary);
                    root.style.setProperty('--m5-text-on-primary', colors.textOnPrimary);
                    root.style.setProperty('--m5-accent', colors.accent);
                    root.style.setProperty('--m5-item-bg', itemBg);
                    root.style.setProperty('--m5-icon-filter', iconFilter);

                    bgPrimaryPicker.value = colors.bgPrimary;
                    textOnPrimaryPicker.value = colors.textOnPrimary;
                    accentPicker.value = colors.accent;
                }

                function saveColors(colors) {
                    localStorage.setItem(`${storagePrefix}bgPrimary`, colors.bgPrimary);
                    localStorage.setItem(`${storagePrefix}textOnPrimary`, colors.textOnPrimary);
                    localStorage.setItem(`${storagePrefix}accent`, colors.accent);
                }

                function applyFont(fontFamily) {
                    if (cvContainer) cvContainer.style.fontFamily = fontFamily;
                    if (fontSelect) fontSelect.value = fontFamily;
                    localStorage.setItem(fontStorageKey, fontFamily);
                }

                function isColorLight(hexColor) {
                    const r = parseInt(hexColor.slice(1, 3), 16);
                    const g = parseInt(hexColor.slice(3, 5), 16);
                    const b = parseInt(hexColor.slice(5, 7), 16);
                    // HSP formula
                    const hsp = Math.sqrt(0.299 * (r * r) + 0.587 * (g * g) + 0.114 * (b * b));
                    return hsp > 127.5;
                }

                function hexToRgba(hex, alpha = 1) {
                    const r = parseInt(hex.slice(1, 3), 16);
                    const g = parseInt(hex.slice(3, 5), 16);
                    const b = parseInt(hex.slice(5, 7), 16);
                    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                }

                // ---- EVENT LISTENERS ----
                themeCards.forEach(card => {
                    card.addEventListener('click', function() {
                        const themeName = this.dataset.theme;
                        const themeColors = themes[themeName];
                        if (themeColors) {
                            applyColors(themeColors);
                            saveColors(themeColors);
                            localStorage.setItem(`${storagePrefix}activeTheme`, themeName);
                            themeCards.forEach(c => c.classList.remove('active'));
                            this.classList.add('active');
                        }
                    });
                });

                [bgPrimaryPicker, textOnPrimaryPicker, accentPicker].forEach(picker => {
                    picker.addEventListener('input', function() {
                        const currentColors = {
                            bgPrimary: bgPrimaryPicker.value,
                            textOnPrimary: textOnPrimaryPicker.value,
                            accent: accentPicker.value
                        };
                        applyColors(currentColors);
                        saveColors(currentColors);
                        localStorage.setItem(`${storagePrefix}activeTheme`, 'custom');
                        themeCards.forEach(c => c.classList.remove('active'));
                    });
                });

                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        applyColors(defaultColors);
                        saveColors(defaultColors);
                        localStorage.removeItem(`${storagePrefix}activeTheme`);
                        themeCards.forEach(c => c.classList.remove('active'));
                    });
                }
                
                // ---- INITIALIZATION ----
                function loadPreferences() {
                    const activeTheme = localStorage.getItem(`${storagePrefix}activeTheme`);
                    if (activeTheme && themes[activeTheme] && activeTheme !== 'custom') {
                        applyColors(themes[activeTheme]);
                        const themeCard = document.querySelector(`.theme-card[data-theme="${activeTheme}"]`);
                        if(themeCard) themeCard.classList.add('active');
                    } else {
                        const savedColors = {
                            bgPrimary: localStorage.getItem(`${storagePrefix}bgPrimary`),
                            textOnPrimary: localStorage.getItem(`${storagePrefix}textOnPrimary`),
                            accent: localStorage.getItem(`${storagePrefix}accent`)
                        };
                        if (savedColors.bgPrimary) {
                            applyColors(savedColors);
                        } else {
                            applyColors(defaultColors);
                        }
                    }

                    const savedFont = localStorage.getItem(fontStorageKey);
                    if (savedFont) {
                        applyFont(savedFont);
                    }
                }

                // Attach font change listener
                if(fontSelect) {
                    fontSelect.addEventListener('change', function() {
                        applyFont(this.value);
                    });
                }

                loadPreferences();
            });
            </script>
        </div>

        <div class="container-model" id="box">
            <div class="container">
                <div class="box1">
                    <div class="item1">
                        <ul>
                            <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                            <li><img src="/image/phone.png" alt=""><?= $userss['phone'] ?></li>
                            <li><img src="/image/icons8-gmail-48.png" alt=""><?= $userss['mail'] ?></li>
                        </ul>

                        <h3><?= $userss['competences'] ?></h3>
                        <h1> <?= $userss['nom'] ?></h1>
                    </div>
                    <div class="item2">
                        <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    </div>
                </div>

                <div class="box2">
                    <div class="item1">
                        <div class="box">
                            <h2> <img src="/image/a_propos.png" alt=""> À propos</h2>
                            <?php if (empty($descriptions)): ?>
                                <p>Aucune donnée trouvée</p>
                            <?php else: ?>
                                <p class="p">
                                    <?= $descriptions['description'] ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="exp">
                            <h2><img src="/image/experience.png" alt=""> Expériences</h2>
                            <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 3
                                    ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <div>
                                            <h3> <?= $Metiers['metier'] ?></h3>
                                            <span><?= $Metiers['moisDebut'] ?> /
                                                <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                                <?= $Metiers['anneeFin'] ?></span>
                                            <p> <?= $Metiers['description'] ?></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item2">

                        <div class="exp">
                            <h2><img src="/image/etude.png" alt=""> Éducation</h2>

                            <?php if (empty($formationUsers)): ?>
                                <strong></strong>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($formationUsers);
                                $nombre_formation = 3;
                                ?>
                                <?php foreach ($formationUsers as $key => $formations): ?>
                                    <?php if ($key < $nombre_formation): ?>
                                        <div>
                                            <h3><?= $formations['etablissement'] ?></h3>
                                            <span> <?= $formations['moisDebut'] ?> /
                                                <?= $formations['anneeDebut'] ?> , <?= $formations['moisFin'] ?> /
                                                <?= $formations['anneeFin'] ?></span>
                                            <p><?= $formations['Filiere'] ?> , <strong>
                                                    <?= $formations['niveau'] ?></strong> </p>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="comp">
                            <h2>COMPÉTENCES</h2>
                            <?php if ($competencesUtilisateurLimit7): ?>
                                <ul>
                                    <?php foreach ($competencesUtilisateurLimit7 as $competence): ?>
                                        <li> <?php echo $competence['competence']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php endif ?>
                        </div>

                        <div class="outils">
                            <h2>OUTILS</h2>
                            <?php if ($afficheOutilLimit5): ?>
                                <ul>
                                    <?php foreach ($afficheOutilLimit5 as $outils): ?>
                                        <li> <?= $outils['outil'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div id="container-for-pdf" class="container">
                <div class="box1">
                    <div class="item1">
                        <ul>
                            <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                            <li><img src="/image/phone.png" alt=""><?= $userss['phone'] ?></li>
                            <li><img src="/image/icons8-gmail-48.png" alt=""><?= $userss['mail'] ?></li>
                        </ul>

                        <h3><?= $userss['competences'] ?></h3>
                        <h1> <?= $userss['nom'] ?></h1>
                    </div>
                    <div class="item2">
                        <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    </div>
                </div>

                <div class="box2">
                    <div class="item1">
                        <div class="box">
                            <h2> <img src="/image/a_propos.png" alt=""> À propos</h2>
                            <?php if (empty($descriptions)): ?>
                                <p>Aucune donnée trouvée</p>
                            <?php else: ?>
                                <p class="p">
                                    <?= $descriptions['description'] ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="exp">
                            <h2><img src="/image/experience.png" alt=""> Expériences</h2>
                            <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 3
                                    ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <div>
                                            <h3> <?= $Metiers['metier'] ?></h3>
                                            <span><?= $Metiers['moisDebut'] ?> /
                                                <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                                <?= $Metiers['anneeFin'] ?></span>
                                            <p> <?= $Metiers['description'] ?></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item2">

                        <div class="exp">
                            <h2><img src="/image/etude.png" alt=""> Éducation</h2>

                            <?php if (empty($formationUsers)): ?>
                                <strong></strong>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($formationUsers);
                                $nombre_formation = 3;
                                ?>
                                <?php foreach ($formationUsers as $key => $formations): ?>
                                    <?php if ($key < $nombre_formation): ?>
                                        <div>
                                            <h3><?= $formations['etablissement'] ?></h3>
                                            <span> <?= $formations['moisDebut'] ?> /
                                                <?= $formations['anneeDebut'] ?> , <?= $formations['moisFin'] ?> /
                                                <?= $formations['anneeFin'] ?></span>
                                            <p><?= $formations['Filiere'] ?> , <strong>
                                                    <?= $formations['niveau'] ?></strong> </p>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="comp">
                            <h2>COMPÉTENCES</h2>
                            <?php if ($competencesUtilisateurLimit7): ?>
                                <ul>
                                    <?php foreach ($competencesUtilisateurLimit7 as $competence): ?>
                                        <li> <?php echo $competence['competence']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php endif ?>
                        </div>

                        <div class="outils">
                            <h2>OUTILS</h2>
                            <?php if ($afficheOutilLimit5): ?>
                                <ul>
                                    <?php foreach ($afficheOutilLimit5 as $outils): ?>
                                        <li> <?= $outils['outil'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-customization-btn');
            const customPanel = document.getElementById('customization-panel');
            const closeBtn = document.getElementById('close-panel-btn');

            if (toggleBtn && customPanel && closeBtn) {
                // Ouvre le panneau
                toggleBtn.addEventListener('click', function(event) {
                    event.stopPropagation();
                    customPanel.classList.add('active');
                });

                // Ferme le panneau avec la croix
                closeBtn.addEventListener('click', function() {
                    customPanel.classList.remove('active');
                });

                // Ferme le panneau si on clique en dehors
                document.addEventListener('click', function(event) {
                    if (customPanel.classList.contains('active') && !customPanel.contains(event.target) && !toggleBtn.contains(event.target)) {
                        customPanel.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>

</html>