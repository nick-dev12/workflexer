<?php
// Vérification de l'appareil au tout début
include_once('check_device.php');
// Démarre la session
session_start();


// Check if user is on desktop
$isDesktop = isDesktop();
if (!$isDesktop) {
    // If not on desktop, redirect to mobile message page
    header("Location: mobile_message.php");
    exit;
}

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

    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="/css/model5.css" />
    <link rel="stylesheet" href="../css/navbare.css">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>




    <section class="section3">
        <div class="personnalisation">

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
                    const { jsPDF } = window.jspdf;
                    const element = document.querySelector(".container");

                    // Définir une échelle plus élevée pour une meilleure qualité
                    const scale = 2;
                    const options = {
                        scale: scale,
                        quality: 2,
                        width: element.offsetWidth * scale,
                        height: element.offsetHeight * scale,
                        style: {
                            transform: 'scale(' + scale + ')',
                            transformOrigin: 'top left',
                            width: element.offsetWidth + "px",
                            height: element.offsetHeight + "px"
                        }
                    };

                    domtoimage.toJpeg(element, options)
                        .then(function (dataUrl) {
                            const pdf = new jsPDF('p', 'mm', 'a4');
                            const imgProps = pdf.getImageProperties(dataUrl);
                            const pdfWidth = pdf.internal.pageSize.getWidth();
                            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                            pdf.addImage(dataUrl, 'PNG', 0, 0, pdfWidth, pdfHeight);
                            pdf.save("cv.pdf");
                        })
                        .catch(function (error) {
                            console.error('Une erreur est survenue lors de la génération du PDF:', error);
                            alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                        });
                }
            </script>

            <div class="theme-selector">
                <h3>Thèmes de couleurs</h3>
                <div class="themes-section">
                    <h4>Classiques</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="classic">
                            <div class="theme-preview">
                                <div style="background-color: #4A4A4A; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #333333; height: 20px;"></div>
                            </div>
                            <span>Classique</span>
                        </div>
                        <div class="theme-card" data-theme="professional">
                            <div class="theme-preview">
                                <div style="background-color: #1D3557; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #457B9D; height: 20px;"></div>
                            </div>
                            <span>Marine</span>
                        </div>
                        <div class="theme-card" data-theme="corporate">
                            <div class="theme-preview">
                                <div style="background-color: #1A237E; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #5C6BC0; height: 20px;"></div>
                            </div>
                            <span>Corporate</span>
                        </div>
                        <div class="theme-card" data-theme="slate">
                            <div class="theme-preview">
                                <div style="background-color: #2F4F4F; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #708090; height: 20px;"></div>
                            </div>
                            <span>Ardoise</span>
                        </div>
                    </div>

                    <h4>Couleurs vives</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="elegant">
                            <div class="theme-preview">
                                <div style="background-color: #0E3B43; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #328590; height: 20px;"></div>
                            </div>
                            <span>Émeraude</span>
                        </div>
                        <div class="theme-card" data-theme="creative">
                            <div class="theme-preview">
                                <div style="background-color: #845EC2; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #B39CD0; height: 20px;"></div>
                            </div>
                            <span>Violet</span>
                        </div>
                        <div class="theme-card" data-theme="modern">
                            <div class="theme-preview">
                                <div style="background-color: #3D5A80; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #98C1D9; height: 20px;"></div>
                            </div>
                            <span>Océan</span>
                        </div>
                        <div class="theme-card" data-theme="mint">
                            <div class="theme-preview">
                                <div style="background-color: #21897E; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #69B7A8; height: 20px;"></div>
                            </div>
                            <span>Menthe</span>
                        </div>
                    </div>

                    <h4>Tons chauds</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="earthy">
                            <div class="theme-preview">
                                <div style="background-color: #5F4B32; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #A1887F; height: 20px;"></div>
                            </div>
                            <span>Terracotta</span>
                        </div>
                        <div class="theme-card" data-theme="burgundy">
                            <div class="theme-preview">
                                <div style="background-color: #800020; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #AD8A8E; height: 20px;"></div>
                            </div>
                            <span>Bordeaux</span>
                        </div>
                        <div class="theme-card" data-theme="amber">
                            <div class="theme-preview">
                                <div style="background-color: #B86E00; height: 20px;"></div>
                                <div style="background-color: #000000; height: 20px;"></div>
                                <div style="background-color: #F0A858; height: 20px;"></div>
                            </div>
                            <span>Ambre</span>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .theme-selector {
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f9f9f9;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }

                .theme-selector h3 {
                    text-align: center;
                    margin-bottom: 15px;
                    color: #333;
                    font-size: 18px;
                }

                .theme-selector h4 {
                    border-bottom: 1px solid #e0e0e0;
                    padding-bottom: 8px;
                    margin: 15px 0 10px;
                    color: #555;
                    font-size: 16px;
                }

                .themes-section {
                    max-height: 400px;
                    overflow-y: auto;
                    padding-right: 5px;
                }

                .themes-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: flex-start;
                    gap: 12px;
                    margin-bottom: 15px;
                }

                .theme-card {
                    width: calc(25% - 12px);
                    min-width: 85px;
                    border-radius: 6px;
                    overflow: hidden;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    cursor: pointer;
                    transition: transform 0.2s, box-shadow 0.2s;
                }

                .theme-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }

                .theme-card.active {
                    border: 2px solid #0089be;
                    transform: translateY(-2px);
                }

                .theme-preview {
                    width: 100%;
                }

                .theme-card span {
                    display: block;
                    text-align: center;
                    padding: 6px 0;
                    font-size: 12px;
                    background-color: white;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                /* Styles pour tablette */
                @media (max-width: 768px) {
                    .theme-card {
                        width: calc(33.33% - 12px);
                    }

                    .themes-section {
                        max-height: 350px;
                    }
                }

                /* Styles pour mobile */
                @media (max-width: 480px) {
                    .theme-card {
                        width: calc(50% - 8px);
                        min-width: 60px;
                    }

                    .themes-container {
                        gap: 8px;
                    }

                    .theme-selector {
                        padding: 10px;
                    }

                    .theme-selector h3 {
                        font-size: 16px;
                    }

                    .theme-selector h4 {
                        font-size: 14px;
                    }

                    .theme-card span {
                        font-size: 11px;
                        padding: 4px 0;
                    }

                    .themes-section {
                        max-height: 250px;
                    }
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Définition des thèmes
                    const themes = {
                        elegant: {
                            fontColorSection: '#0E3B43',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#90D7E0',  // Bleu clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(50, 133, 144, 0.4)'
                        },
                        professional: {
                            fontColorSection: '#1D3557',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#A8DADC',  // Bleu clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(69, 123, 157, 0.4)'
                        },
                        creative: {
                            fontColorSection: '#845EC2',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#D7BDF8',  // Violet clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(179, 156, 208, 0.4)'
                        },
                        classic: {
                            fontColorSection: '#4A4A4A',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#CCCCCC',  // Gris clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(51, 51, 51, 0.3)'
                        },
                        modern: {
                            fontColorSection: '#3D5A80',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#E0FBFC',  // Bleu très clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(152, 193, 217, 0.4)'
                        },
                        earthy: {
                            fontColorSection: '#5F4B32',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#E6CCB2',  // Beige clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(161, 136, 127, 0.4)'
                        },
                        // Nouveaux thèmes
                        corporate: {
                            fontColorSection: '#1A237E',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#C5CAE9',  // Bleu clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(92, 107, 192, 0.4)'
                        },
                        burgundy: {
                            fontColorSection: '#800020',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#F8C3CB',  // Rose clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(173, 138, 142, 0.4)'
                        },
                        mint: {
                            fontColorSection: '#21897E',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#A8E6CF',  // Vert menthe clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(105, 183, 168, 0.4)'
                        },
                        slate: {
                            fontColorSection: '#2F4F4F',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#A9BEC9',  // Gris bleuté clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(112, 128, 144, 0.4)'
                        },
                        amber: {
                            fontColorSection: '#B86E00',
                            texteColor: '#FFFFFF',  // Blanc pour un bon contraste avec le fond foncé
                            texteColor2: '#FFD699',  // Ambre clair pour l'accentuation sur fond foncé
                            lightText: 'rgba(255, 255, 255, 0.7)',
                            itemBg: 'rgba(240, 168, 88, 0.4)'
                        }
                    };

                    // Récupérer le numéro du modèle à partir de l'URL
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '5';
                    const storagePrefix = `model${modelNumber}-`;

                    // Ajouter les écouteurs d'événements aux cartes de thème
                    const themeCards = document.querySelectorAll('.theme-card');
                    themeCards.forEach(card => {
                        card.addEventListener('click', function () {
                            // Retirer la classe active de toutes les cartes
                            themeCards.forEach(c => c.classList.remove('active'));

                            // Ajouter la classe active à la carte cliquée
                            this.classList.add('active');

                            // Appliquer le thème
                            const themeName = this.getAttribute('data-theme');
                            applyTheme(themes[themeName]);
                        });
                    });

                    // Fonction pour appliquer un thème
                    function applyTheme(theme) {
                        // Appliquer les couleurs CSS
                        document.documentElement.style.setProperty('--font-color-m5', theme.fontColorSection);
                        document.documentElement.style.setProperty('--text-color-m5', theme.texteColor);
                        document.documentElement.style.setProperty('--text-color2-m5', theme.texteColor2);
                        document.documentElement.style.setProperty('--light-text-m5', theme.lightText);
                        document.documentElement.style.setProperty('--item-bg-m5', theme.itemBg);

                        // Mettre à jour les valeurs des inputs de couleur
                        document.getElementById('fontColor_m52').value = theme.fontColorSection;
                        document.getElementById('fontColor_m53').value = theme.texteColor;
                        document.getElementById('fontColor_m54').value = theme.texteColor2;

                        // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                        localStorage.setItem(`${storagePrefix}font_color_section_m5`, theme.fontColorSection);
                        localStorage.setItem(`${storagePrefix}texte_color_m5`, theme.texteColor);
                        localStorage.setItem(`${storagePrefix}texte_color2_m5`, theme.texteColor2);
                        localStorage.setItem(`${storagePrefix}light_text_m5`, theme.lightText);
                        localStorage.setItem(`${storagePrefix}item_bg_m5`, theme.itemBg);
                    }

                    // Vérifier s'il y a un thème sauvegardé et l'appliquer
                    const savedTheme = {
                        fontColorSection: localStorage.getItem(`${storagePrefix}font_color_section_m5`),
                        texteColor: localStorage.getItem(`${storagePrefix}texte_color_m5`),
                        texteColor2: localStorage.getItem(`${storagePrefix}texte_color2_m5`),
                        lightText: localStorage.getItem(`${storagePrefix}light_text_m5`),
                        itemBg: localStorage.getItem(`${storagePrefix}item_bg_m5`)
                    };

                    if (savedTheme.fontColorSection) {
                        // Appliquer le thème sauvegardé
                        document.documentElement.style.setProperty('--font-color-m5', savedTheme.fontColorSection);
                        document.documentElement.style.setProperty('--text-color-m5', savedTheme.texteColor);
                        document.documentElement.style.setProperty('--text-color2-m5', savedTheme.texteColor2);
                        document.documentElement.style.setProperty('--light-text-m5', savedTheme.lightText || 'rgba(0, 0, 0, 0.6)');
                        document.documentElement.style.setProperty('--item-bg-m5', savedTheme.itemBg || 'rgba(195, 193, 193, 0.5)');

                        // Mettre à jour les valeurs des inputs
                        document.getElementById('fontColor_m52').value = savedTheme.fontColorSection;
                        document.getElementById('fontColor_m53').value = savedTheme.texteColor;
                        document.getElementById('fontColor_m54').value = savedTheme.texteColor2;

                        // Retrouver quel thème correspond aux couleurs sauvegardées
                        for (const [themeName, theme] of Object.entries(themes)) {
                            if (theme.fontColorSection === savedTheme.fontColorSection &&
                                theme.texteColor === savedTheme.texteColor &&
                                theme.texteColor2 === savedTheme.texteColor2) {
                                // Marquer le thème comme actif
                                const themeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                                if (themeCard) themeCard.classList.add('active');
                                break;
                            }
                        }
                    }
                });
            </script>

            <div class="color-control-section">
                <h4>Personnalisation manuelle des couleurs</h4>
                <div class="color-box">
                    <label for="fontColor_m52">
                        <span class="color-label">Couleur de fond</span>
                        <span class="color-desc">(Arrière-plan de la barre latérale)</span>
                    </label>
                    <div class="color-preview-wrapper">
                        <div class="color-preview bg-preview" id="preview-bg"></div>
                        <input type="color" name="fontColor_m52" id="fontColor_m52">
                    </div>
                </div>

                <div class="color-box">
                    <label for="fontColor_m53">
                        <span class="color-label">Couleur du texte principal</span>
                        <span class="color-desc">(Texte sur fond coloré)</span>
                    </label>
                    <div class="color-preview-wrapper">
                        <div class="color-preview text-preview" id="preview-text">Aa</div>
                        <input type="color" name="fontColor_m53" id="fontColor_m53">
                    </div>
                </div>

                <div class="color-box">
                    <label for="fontColor_m54">
                        <span class="color-label">Couleur d'accentuation</span>
                        <span class="color-desc">(Titres et éléments importants)</span>
                    </label>
                    <div class="color-preview-wrapper">
                        <div class="color-preview accent-preview" id="preview-accent">Aa</div>
                        <input type="color" name="fontColor_m54" id="fontColor_m54">
                    </div>
                </div>
            </div>

            <style>
                .color-control-section {
                    margin-top: 20px;
                    background-color: #f5f5f5;
                    padding: 15px;
                    border-radius: 8px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                }

                .color-control-section h4 {
                    margin-top: 0;
                    margin-bottom: 15px;
                    color: #333;
                    font-size: 16px;
                    text-align: center;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 8px;
                }

                .color-box {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 12px;
                    background-color: white;
                    padding: 8px 12px;
                    border-radius: 4px;
                    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                }

                .color-box label {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                }

                .color-label {
                    font-weight: bold;
                    font-size: 14px;
                    color: #333;
                }

                .color-desc {
                    font-size: 12px;
                    color: #777;
                    margin-top: 2px;
                }

                .color-preview-wrapper {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                .color-preview {
                    width: 40px;
                    height: 40px;
                    border-radius: 4px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    font-size: 16px;
                }

                .bg-preview {
                    background-color: var(--font-color-m5);
                }

                .text-preview {
                    color: var(--text-color-m5);
                    border: 1px solid #ddd;
                    background-color: white;
                }

                .accent-preview {
                    color: var(--text-color2-m5);
                    border: 1px solid #ddd;
                    background-color: white;
                }

                .color-box input[type="color"] {
                    width: 40px;
                    height: 40px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Récupérer le numéro du modèle à partir de l'URL
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '5';
                    const storagePrefix = `model${modelNumber}-`;

                    // Fonction pour initialiser un contrôle de couleur
                    function initColorControl(inputId, cssVar, storageKey, defaultColor, previewId) {
                        const input = document.getElementById(inputId);
                        const preview = document.getElementById(previewId);
                        const fullStorageKey = `${storagePrefix}${storageKey}`;
                        const savedColor = localStorage.getItem(fullStorageKey);

                        // Appliquer la couleur sauvegardée ou la couleur par défaut
                        const color = savedColor || defaultColor;
                        document.documentElement.style.setProperty(cssVar, color);
                        input.value = color;

                        // Mettre à jour la prévisualisation
                        if (previewId === 'preview-bg') {
                            preview.style.backgroundColor = color;
                        } else {
                            preview.style.color = color;
                        }

                        // Ajouter l'écouteur d'événements
                        input.addEventListener('input', function () {
                            const selectedColor = this.value;
                            document.documentElement.style.setProperty(cssVar, selectedColor);
                            localStorage.setItem(fullStorageKey, selectedColor);

                            // Mettre à jour la prévisualisation
                            if (previewId === 'preview-bg') {
                                preview.style.backgroundColor = selectedColor;
                            } else {
                                preview.style.color = selectedColor;
                            }

                            // Mettre à jour les couleurs dérivées si nécessaire
                            if (cssVar === '--text-color2-m5') {
                                // Créer une couleur d'arrière-plan semi-transparente basée sur la couleur d'accentuation
                                const rgba = hexToRgba(selectedColor, 0.2);
                                document.documentElement.style.setProperty('--item-bg-m5', rgba);
                                localStorage.setItem(`${storagePrefix}item_bg_m5`, rgba);
                            }
                        });
                    }

                    // Fonction pour convertir une couleur hex en rgba
                    function hexToRgba(hex, alpha = 1) {
                        const r = parseInt(hex.slice(1, 3), 16);
                        const g = parseInt(hex.slice(3, 5), 16);
                        const b = parseInt(hex.slice(5, 7), 16);
                        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                    }

                    // Initialiser les contrôles de couleur
                    initColorControl('fontColor_m52', '--font-color-m5', 'font_color_section_m5', '#ebebeb', 'preview-bg');
                    initColorControl('fontColor_m53', '--text-color-m5', 'texte_color_m5', '#000000', 'preview-text');
                    initColorControl('fontColor_m54', '--text-color2-m5', 'texte_color2_m5', '#0089be', 'preview-accent');

                    // Initialiser les variables dérivées si elles ne sont pas déjà définies
                    const lightText = localStorage.getItem(`${storagePrefix}light_text_m5`) || 'rgba(0, 0, 0, 0.6)';
                    const itemBg = localStorage.getItem(`${storagePrefix}item_bg_m5`) || 'rgba(195, 193, 193, 0.5)';

                    document.documentElement.style.setProperty('--light-text-m5', lightText);
                    document.documentElement.style.setProperty('--item-bg-m5', itemBg);
                });
            </script>
        </div>

        <div class="container-model">
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

    </section>


</body>

</html>