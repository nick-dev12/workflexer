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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>model3</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="../css/model3_1.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
    <script src="../script/jquery-3.6.0.min.js"></script>
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
            <p class="highlight">Les éléments que vous avez mis en avant dans votre profil seront affichés en priorité !
            </p>
            <button class="close-info-btn">&times;</button>
        </div>
    </div>

    <style>
        .info-bubble {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            border-left: 5px solid #0089be;
            animation: slideIn 0.5s ease-out;
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

        .info-content {
            position: relative;
        }

        .info-bubble .fa-circle-info {
            color: #0089be;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .info-bubble h3 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-bubble p {
            color: #34495e;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .info-bubble ul {
            padding-left: 20px;
            margin: 10px 0;
        }

        .info-bubble li {
            color: #34495e;
            font-size: 14px;
            margin-bottom: 8px;
            list-style-type: none;
            position: relative;
        }

        .info-bubble li:before {
            content: "•";
            color: #0089be;
            font-weight: bold;
            position: absolute;
            left: -15px;
        }

        .info-bubble .highlight {
            background: #f0f9ff;
            padding: 10px;
            border-radius: 8px;
            border-left: 3px solid #0089be;
            margin-top: 15px;
            font-weight: 500;
        }

        .close-info-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #fff;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #666;
            transition: all 0.3s ease;
        }

        .close-info-btn:hover {
            background: #f1f1f1;
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .info-bubble {
                top: auto;
                bottom: 20px;
                right: 10px;
                left: 10px;
                max-width: none;
                margin: 0 auto;
                font-size: 14px;
            }

            .info-bubble h3 {
                font-size: 16px;
            }

            .info-bubble p,
            .info-bubble li {
                font-size: 13px;
            }
        }

        @media screen and (max-width: 480px) {
            .info-bubble {
                padding: 15px;
            }

            .info-bubble h3 {
                font-size: 15px;
            }

            .info-bubble p,
            .info-bubble li {
                font-size: 12px;
            }
        }
    </style>

    <script>
        // Script pour la bulle d'information
        document.addEventListener('DOMContentLoaded', function () {
            const closeInfoBtn = document.querySelector('.close-info-btn');
            const infoBubble = document.querySelector('.info-bubble');

            if (closeInfoBtn && infoBubble) {
                closeInfoBtn.addEventListener('click', function () {
                    infoBubble.style.animation = 'slideOut 0.5s ease-out forwards';
                    setTimeout(() => {
                        infoBubble.style.display = 'none';
                    }, 500);
                });

                // Ajouter l'animation de sortie
                const style = document.createElement('style');
                style.textContent = `
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
                `;
                document.head.appendChild(style);
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

            <script>
                function generatePDF() {
                    // Afficher un message d'attente
                    const loadingMessage = document.createElement('div');
                    loadingMessage.className = 'loading-message';
                    loadingMessage.textContent = 'Génération du PDF en cours...';
                    loadingMessage.style.position = 'fixed';
                    loadingMessage.style.top = '50%';
                    loadingMessage.style.left = '50%';
                    loadingMessage.style.transform = 'translate(-50%, -50%)';
                    loadingMessage.style.padding = '20px';
                    loadingMessage.style.backgroundColor = 'rgba(0,0,0,0.7)';
                    loadingMessage.style.color = 'white';
                    loadingMessage.style.borderRadius = '10px';
                    loadingMessage.style.zIndex = '9999';
                    document.body.appendChild(loadingMessage);

                    // Fonction pour précharger les polices
                    function preloadFonts() {
                        return new Promise((resolve) => {
                            // Créer un élément temporaire pour précharger les polices
                            const tempDiv = document.createElement('div');
                            tempDiv.style.opacity = '0';
                            tempDiv.style.position = 'absolute';
                            tempDiv.style.top = '-9999px';
                            document.body.appendChild(tempDiv);

                            // Donner un peu de temps pour charger les polices
                            setTimeout(() => {
                                document.body.removeChild(tempDiv);
                                resolve();
                            }, 500);
                        });
                    }

                    // Précharger les polices puis générer le PDF
                    preloadFonts().then(() => {
                        const {
                            jsPDF
                        } = window.jspdf;
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
                                    const timestamp = new Date().toISOString().slice(0, 19).replace(
                                        /[:.]/g, '-');
                                    pdf.save(`cv-model3-${timestamp}.pdf`);
                                })
                                .catch(function (error) {
                                    console.error(
                                        'Une erreur est survenue lors de la génération du PDF:',
                                        error);
                                    // Supprimer le message d'attente en cas d'erreur
                                    if (document.body.contains(loadingMessage)) {
                                        document.body.removeChild(loadingMessage);
                                    }
                                    alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                                });
                        }, 600); // Délai léger pour stabilité
                    });
                }
            </script>

            <div class="theme-selector">
                <h3>Thèmes de couleurs</h3>
                <h4>Classiques</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="classic">
                        <div class="theme-preview">
                            <div style="background-color: #4A4A4A; height: 20px;"></div>
                            <div style="background-color: #7A7A7A; height: 20px;"></div>
                            <div style="background-color: #F5F5F5; height: 20px;"></div>
                        </div>
                        <span>Classique</span>
                    </div>
                    <div class="theme-card" data-theme="professional">
                        <div class="theme-preview">
                            <div style="background-color: #1D3557; height: 20px;"></div>
                            <div style="background-color: #457B9D; height: 20px;"></div>
                            <div style="background-color: #F1FAEE; height: 20px;"></div>
                        </div>
                        <span>Marine</span>
                    </div>
                    <div class="theme-card" data-theme="corporate">
                        <div class="theme-preview">
                            <div style="background-color: #1A237E; height: 20px;"></div>
                            <div style="background-color: #5C6BC0; height: 20px;"></div>
                            <div style="background-color: #FFFFFF; height: 20px;"></div>
                        </div>
                        <span>Corporate</span>
                    </div>
                    <div class="theme-card" data-theme="slate">
                        <div class="theme-preview">
                            <div style="background-color: #2F4F4F; height: 20px;"></div>
                            <div style="background-color: #708090; height: 20px;"></div>
                            <div style="background-color: #E8ECEE; height: 20px;"></div>
                        </div>
                        <span>Ardoise</span>
                    </div>
                </div>

                <h4>Couleurs vives</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="elegant">
                        <div class="theme-preview">
                            <div style="background-color: #0E3B43; height: 20px;"></div>
                            <div style="background-color: #328590; height: 20px;"></div>
                            <div style="background-color: #F0F0F0; height: 20px;"></div>
                        </div>
                        <span>Émeraude</span>
                    </div>
                    <div class="theme-card" data-theme="creative">
                        <div class="theme-preview">
                            <div style="background-color: #845EC2; height: 20px;"></div>
                            <div style="background-color: #B39CD0; height: 20px;"></div>
                            <div style="background-color: #FBEAFF; height: 20px;"></div>
                        </div>
                        <span>Violet</span>
                    </div>
                    <div class="theme-card" data-theme="modern">
                        <div class="theme-preview">
                            <div style="background-color: #3D5A80; height: 20px;"></div>
                            <div style="background-color: #98C1D9; height: 20px;"></div>
                            <div style="background-color: #E0FBFC; height: 20px;"></div>
                        </div>
                        <span>Océan</span>
                    </div>
                    <div class="theme-card" data-theme="mint">
                        <div class="theme-preview">
                            <div style="background-color: #21897E; height: 20px;"></div>
                            <div style="background-color: #69B7A8; height: 20px;"></div>
                            <div style="background-color: #F4FFF8; height: 20px;"></div>
                        </div>
                        <span>Menthe</span>
                    </div>
                </div>

                <h4>Tons chauds</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="earthy">
                        <div class="theme-preview">
                            <div style="background-color: #5F4B32; height: 20px;"></div>
                            <div style="background-color: #A1887F; height: 20px;"></div>
                            <div style="background-color: #F0EAE2; height: 20px;"></div>
                        </div>
                        <span>Terracotta</span>
                    </div>
                    <div class="theme-card" data-theme="burgundy">
                        <div class="theme-preview">
                            <div style="background-color: #800020; height: 20px;"></div>
                            <div style="background-color: #AD8A8E; height: 20px;"></div>
                            <div style="background-color: #F2F2F2; height: 20px;"></div>
                        </div>
                        <span>Bordeaux</span>
                    </div>
                    <div class="theme-card" data-theme="amber">
                        <div class="theme-preview">
                            <div style="background-color: #B86E00; height: 20px;"></div>
                            <div style="background-color: #F0A858; height: 20px;"></div>
                            <div style="background-color: #FFFBF0; height: 20px;"></div>
                        </div>
                        <span>Ambre</span>
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
                    // Récupérer le numéro du modèle à partir de l'URL
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '3';
                    const storagePrefix = `model${modelNumber}-`;

                    // Fonction pour déterminer si une couleur est claire ou foncée
                    function isLightColor(color) {
                        // Convertir la couleur hex en RGB
                        let r, g, b;
                        if (color.startsWith('#')) {
                            color = color.substring(1);
                            r = parseInt(color.substr(0, 2), 16);
                            g = parseInt(color.substr(2, 2), 16);
                            b = parseInt(color.substr(4, 2), 16);
                        } else if (color.startsWith('rgb')) {
                            const rgbValues = color.match(/\d+/g);
                            if (rgbValues && rgbValues.length >= 3) {
                                r = parseInt(rgbValues[0]);
                                g = parseInt(rgbValues[1]);
                                b = parseInt(rgbValues[2]);
                            } else {
                                return true; // Par défaut, considérer comme clair
                            }
                        } else {
                            return true; // Par défaut, considérer comme clair
                        }

                        // Calcul de la luminosité (formule standard)
                        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                        return luminance > 0.5; // Si > 0.5, c'est une couleur claire
                    }

                    // Définition des thèmes
                    const themes = {
                        elegant: {
                            fontColorTitre: '#0E3B43',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#328590',
                            texteColorSection: '#000000',
                            textColorM3: '#343434'
                        },
                        professional: {
                            fontColorTitre: '#1D3557',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#457B9D',
                            texteColorSection: '#000000',
                            textColorM3: '#343434'
                        },
                        creative: {
                            fontColorTitre: '#845EC2',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#B39CD0',
                            texteColorSection: '#000000',
                            textColorM3: '#343434'
                        },
                        classic: {
                            fontColorTitre: '#4A4A4A',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#7A7A7A',
                            texteColorSection: '#ffffff',
                            textColorM3: '#343434'
                        },
                        modern: {
                            fontColorTitre: '#3D5A80',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#98C1D9',
                            texteColorSection: '#000000',
                            textColorM3: '#343434'
                        },
                        earthy: {
                            fontColorTitre: '#5F4B32',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#A1887F',
                            texteColorSection: '#ffffff',
                            textColorM3: '#343434'
                        },
                        // Nouveaux thèmes
                        corporate: {
                            fontColorTitre: '#1A237E',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#5C6BC0',
                            texteColorSection: '#ffffff',
                            textColorM3: '#343434'
                        },
                        burgundy: {
                            fontColorTitre: '#800020',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#AD8A8E',
                            texteColorSection: '#ffffff',
                            textColorM3: '#343434'
                        },
                        mint: {
                            fontColorTitre: '#21897E',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#69B7A8',
                            texteColorSection: '#000000',
                            textColorM3: '#343434'
                        },
                        slate: {
                            fontColorTitre: '#2F4F4F',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#708090',
                            texteColorSection: '#ffffff',
                            textColorM3: '#343434'
                        },
                        amber: {
                            fontColorTitre: '#B86E00',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#F0A858',
                            texteColorSection: '#000000',
                            textColorM3: '#343434'
                        }
                    };

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
                        document.documentElement.style.setProperty('--font-color_section', theme.fontColorSection);

                        // Déterminer la couleur du texte en fonction de la luminosité du fond
                        const isLight = isLightColor(theme.fontColorSection);
                        const textColor = isLight ? '#000000' : '#ffffff';

                        document.documentElement.style.setProperty('--texte-color_section', textColor);
                        document.documentElement.style.setProperty('--text-color-m3', theme.textColorM3);

                        // Mettre à jour les valeurs des inputs de couleur
                        document.getElementById('fontColor2').value = theme.fontColorSection;
                        document.getElementById('fontColor3').value = textColor;

                        // Mettre à jour les prévisualisations
                        if (document.getElementById('color-preview2')) {
                            document.getElementById('color-preview2').style.backgroundColor = theme
                                .fontColorSection;
                        }
                        if (document.getElementById('color-preview3')) {
                            document.getElementById('color-preview3').querySelector('span').style.color = textColor;
                        }

                        // Mettre à jour l'état automatique
                        const autoTextColorCheckbox = document.getElementById('autoTextColor');
                        if (autoTextColorCheckbox) {
                            autoTextColorCheckbox.checked = true;
                            localStorage.setItem(`${storagePrefix}auto_text_color`, true);
                            document.getElementById('fontColor3').disabled = true;
                        }

                        // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                        localStorage.setItem(`${storagePrefix}font_color_section2`, theme.fontColorSection);
                        localStorage.setItem(`${storagePrefix}texte_color_section2`, textColor);
                        localStorage.setItem(`${storagePrefix}text_color_m3`, theme.textColorM3);
                    }

                    // Vérifier s'il y a un thème sauvegardé et l'appliquer
                    const savedTheme = {
                        fontColorSection: localStorage.getItem(`${storagePrefix}font_color_section2`),
                        texteColorSection: localStorage.getItem(`${storagePrefix}texte_color_section2`),
                        textColorM3: localStorage.getItem(`${storagePrefix}text_color_m3`)
                    };

                    if (savedTheme.fontColorSection) {
                        // Appliquer le thème sauvegardé
                        document.documentElement.style.setProperty('--font-color_section', savedTheme
                            .fontColorSection);
                        document.documentElement.style.setProperty('--texte-color_section', savedTheme
                            .texteColorSection);
                        document.documentElement.style.setProperty('--text-color-m3', savedTheme.textColorM3 ||
                            '#343434');

                        // Mettre à jour les valeurs des inputs
                        document.getElementById('fontColor2').value = savedTheme.fontColorSection;
                        document.getElementById('fontColor3').value = savedTheme.texteColorSection;

                        // Mettre à jour les prévisualisations
                        if (document.getElementById('color-preview2')) {
                            document.getElementById('color-preview2').style.backgroundColor = savedTheme
                                .fontColorSection;
                        }
                        if (document.getElementById('color-preview3')) {
                            document.getElementById('color-preview3').querySelector('span').style.color = savedTheme
                                .texteColorSection;
                        }

                        // Retrouver quel thème correspond aux couleurs sauvegardées
                        for (const [themeName, theme] of Object.entries(themes)) {
                            if (theme.fontColorSection === savedTheme.fontColorSection) {
                                // Marquer le thème comme actif
                                const themeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                                if (themeCard) themeCard.classList.add('active');
                                break;
                            }
                        }
                    }
                });
            </script>

            <div class="box">
                <p>Couleur de fond (section informations personnel)</p>
                <input type="color" name="" id="fontColor2">
                <div id="color-preview2" class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc;">
                </div>
            </div>

            <div class="box">
                <p>Couleur du texte (section informations personnel)</p>
                <input type="color" name="" id="fontColor3">
                <div id="color-preview3" class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc; position: relative;">
                    <span
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 12px;">Aa</span>
                </div>
                <label style="margin-top: 5px; display: block; font-size: 10px;">
                    <input type="checkbox" id="autoTextColor" checked>
                </label>
            </div>

            <script>
                const colorInput1 = document.getElementById('fontColor2');
                const colorPreview2 = document.getElementById('color-preview2');
                const colorInput3 = document.getElementById('fontColor3');
                const colorPreview3 = document.getElementById('color-preview3');
                const autoTextColorCheckbox = document.getElementById('autoTextColor');

                // Récupérer le numéro du modèle à partir de l'URL
                const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '3';
                const storagePrefix = `model${modelNumber}-`;

                // Utiliser le même préfixe pour la récupération des données du localStorage
                const font_color_section2 = localStorage.getItem(`${storagePrefix}font_color_section2`) || '#ffe600';
                const texte_color_section2 = localStorage.getItem(`${storagePrefix}texte_color_section2`) || '#000000';
                const auto_text_color_value = localStorage.getItem(`${storagePrefix}auto_text_color`);
                const auto_text_color = auto_text_color_value === null ? true : auto_text_color_value !== 'false';

                document.documentElement.style.setProperty('--font-color_section', font_color_section2);
                colorInput1.value = font_color_section2;
                colorPreview2.style.backgroundColor = font_color_section2;

                // Initialiser l'état de la case à cocher
                autoTextColorCheckbox.checked = auto_text_color;

                // Activer/désactiver le sélecteur de couleur de texte en fonction de l'état de la case à cocher
                colorInput3.disabled = auto_text_color;

                // Fonction pour déterminer si une couleur est claire ou foncée
                function isLightColor(color) {
                    // Convertir la couleur hex en RGB
                    let r, g, b;
                    if (color.startsWith('#')) {
                        color = color.substring(1);
                        r = parseInt(color.substr(0, 2), 16);
                        g = parseInt(color.substr(2, 2), 16);
                        b = parseInt(color.substr(4, 2), 16);
                    } else if (color.startsWith('rgb')) {
                        const rgbValues = color.match(/\d+/g);
                        if (rgbValues && rgbValues.length >= 3) {
                            r = parseInt(rgbValues[0]);
                            g = parseInt(rgbValues[1]);
                            b = parseInt(rgbValues[2]);
                        } else {
                            return true; // Par défaut, considérer comme clair
                        }
                    } else {
                        return true; // Par défaut, considérer comme clair
                    }

                    // Calcul de la luminosité (formule standard)
                    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                    return luminance > 0.5; // Si > 0.5, c'est une couleur claire
                }

                function updateTextColor(bgColor, manualColor) {
                    if (autoTextColorCheckbox.checked) {
                        const isLight = isLightColor(bgColor);
                        const textColor = isLight ? '#000000' : '#ffffff';

                        document.documentElement.style.setProperty('--texte-color_section', textColor);
                        colorInput3.value = textColor;
                        colorPreview3.querySelector('span').style.color = textColor;
                        localStorage.setItem(`${storagePrefix}texte_color_section2`, textColor);
                    } else {
                        const colorToUse = manualColor || colorInput3.value;
                        document.documentElement.style.setProperty('--texte-color_section', colorToUse);
                        colorInput3.value = colorToUse;
                        colorPreview3.querySelector('span').style.color = colorToUse;
                        localStorage.setItem(`${storagePrefix}texte_color_section2`, colorToUse);
                    }
                }

                // Événement pour la couleur de fond
                colorInput1.addEventListener('input', function () {
                    const selectedColor = colorInput1.value;
                    document.documentElement.style.setProperty('--font-color_section', selectedColor);
                    colorPreview2.style.backgroundColor = selectedColor;
                    localStorage.setItem(`${storagePrefix}font_color_section2`, selectedColor);

                    if (autoTextColorCheckbox.checked) {
                        updateTextColor(selectedColor);
                    }
                });

                // Événement pour la couleur de texte manuel
                colorInput3.addEventListener('input', function () {
                    if (!autoTextColorCheckbox.checked) {
                        const selectedColor = colorInput3.value;
                        document.documentElement.style.setProperty('--texte-color_section', selectedColor);
                        colorPreview3.querySelector('span').style.color = selectedColor;
                        localStorage.setItem(`${storagePrefix}texte_color_section2`, selectedColor);
                    }
                });

                // Événement pour la case à cocher d'adaptation automatique
                autoTextColorCheckbox.addEventListener('change', function () {
                    // Activer/désactiver le sélecteur de couleur de texte
                    colorInput3.disabled = this.checked;

                    if (this.checked) {
                        updateTextColor(colorInput1.value);
                    } else {
                        // Si désactivé, on garde la couleur manuelle actuelle
                        const manualColor = colorInput3.value;
                        document.documentElement.style.setProperty('--texte-color_section', manualColor);
                        localStorage.setItem(`${storagePrefix}texte_color_section2`, manualColor);
                    }
                    localStorage.setItem(`${storagePrefix}auto_text_color`, this.checked);
                });

                // Initialiser les couleurs au chargement
                if (auto_text_color) {
                    updateTextColor(font_color_section2);
                } else {
                    document.documentElement.style.setProperty('--texte-color_section', texte_color_section2);
                    colorInput3.value = texte_color_section2;
                    colorPreview3.querySelector('span').style.color = texte_color_section2;
                }

                // Appliquer la couleur du texte global
                const textColorM3 = localStorage.getItem(`${storagePrefix}text_color_m3`);
                document.documentElement.style.setProperty('--text-color-m3', textColorM3 || '#343434');
            </script>
        </div>


        <div class="containers" id="cv3-visible">
            <div class="box1">
                <div class="item">
                    <h1>
                        <?= $userss['nom'] ?>
                    </h1>
                    <img src="../upload/<?= $userss['images'] ?>" alt="">
                    <h2> <?= $userss['competences'] ?></h2>
                    <span>******</span>

                    <?php if (empty($descriptions)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p class="p">
                            <?= $descriptions['description'] ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="items">
                    <h1>Contact</h1>
                    <div>
                        <img src="../image/address.png" alt="">
                        <span>Adresse</span>
                        <p> <?= $userss['ville'] ?></p>
                    </div>

                    <div>
                        <img src="../image/phone.png" alt="">
                        <span>Téléphone</span>
                        <p><?= $userss['phone'] ?></p>
                    </div>

                    <div>
                        <img src="../image/icons8-gmail-48.png" alt="">
                        <span>E-mail</span>
                        <p><?= $userss['mail'] ?></p>
                    </div>
                </div>

                <div class="itemss">

                    <h1>Langues</h1>
                    <div>
                        <?php if ($afficheLangue): ?>
                            <?php foreach ($afficheLangue as $langues): ?>
                                <p> <?= $langues['langue'] ?> <span> (<?= $langues['niveau'] ?>)</span></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune donnée trouvée</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="box2">
                <div class="decor1"></div>
                <div class="decor2"></div>

                <div class="item">
                    <h1><strong><img src="../image/experience.png" alt=""></strong>Expériences</h1>
                    <?php if (empty($afficheMetier)): ?>
                        <h4>Aucune donnée trouvée</h4>
                    <?php else: ?>
                        <?php
                        // Séparer les expériences en deux groupes : mis en avant et non mis en avant
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

                        // Combiner les expériences en donnant priorité aux mises en avant
                        $experiences_a_afficher = array_merge(
                            array_slice($experiences_mises_en_avant, 0, $nombre_metier),
                            array_slice($experiences_non_mises_en_avant, 0, max(0, $nombre_metier - count($experiences_mises_en_avant)))
                        );
                        ?>
                        <?php foreach ($experiences_a_afficher as $Metiers): ?>
                            <div class="exp">
                                <span class="part"></span>
                                <div class="exper">
                                    <h3><?= $Metiers['metier'] ?> <em> <?= $Metiers['moisDebut'] ?> /
                                            <?= $Metiers['anneeDebut'] ?> // <?= $Metiers['moisFin'] ?> /
                                            <?= $Metiers['anneeFin'] ?></em> </h3>
                                    <p> <?= $Metiers['description'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>


                <div class="items">
                    <h1><strong><img src="../image/etude.png" alt=""></strong>Éducation</h1>

                    <div class="containe-exp">
                        <?php if (empty($formationUsers)): ?>
                            <strong></strong>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            // Séparer les formations en deux groupes : mises en avant et non mises en avant
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

                            // Combiner les formations en donnant priorité aux mises en avant
                            $formations_a_afficher = array_merge(
                                array_slice($formations_mises_en_avant, 0, $nombre_formation),
                                array_slice($formations_non_mises_en_avant, 0, max(0, $nombre_formation - count($formations_mises_en_avant)))
                            );
                            ?>
                            <?php foreach ($formations_a_afficher as $formations): ?>
                                <div class="exp">
                                    <span class="part"></span>
                                    <div class="exper">
                                        <h3><?= $formations['etablissement'] ?> <em><?= $formations['moisDebut'] ?> /
                                                <?= $formations['anneeDebut'] ?> // <?= $formations['moisFin'] ?> /
                                                <?= $formations['anneeFin'] ?></em> </h3>
                                        <p><?= $formations['Filiere'] ?> <span class="titre"> <strong>
                                                    <?= $formations['niveau'] ?></strong></span> </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="itemss">
                    <h1><strong><img src="../image/compétences.png" alt=""></strong>Compétences</h1>


                    <ul>
                        <?php if ($competencesUtilisateurLimit7): ?>
                            <?php
                            // Séparer les compétences en deux groupes
                            $competences_mises_en_avant = array_filter($competencesUtilisateurLimit7, function ($comp) {
                                return isset($comp['mis_en_avant']) && $comp['mis_en_avant'] == 1;
                            });
                            $competences_non_mises_en_avant = array_filter($competencesUtilisateurLimit7, function ($comp) {
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

                            foreach ($competences_a_afficher as $competence): ?>
                                <li> <?php echo $competence['competence']; ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>

                            <h4>Aucune donnée trouvée</h4>
                        <?php endif ?>
                    </ul>
                </div>


                <div class="itemsss">
                    <h1><strong><img src="../image/outil.png" alt=""></strong>Outils informatiques</h1>

                    <ul>
                        <?php if ($afficheOutilLimit5): ?>
                            <?php
                            // Séparer les outils en deux groupes
                            $outils_mis_en_avant = array_filter($afficheOutilLimit5, function ($outil) {
                                return isset($outil['mis_en_avant']) && $outil['mis_en_avant'] == 1;
                            });
                            $outils_non_mis_en_avant = array_filter($afficheOutilLimit5, function ($outil) {
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

                            foreach ($outils_a_afficher as $outils): ?>
                                <li> <?= $outils['outil'] ?></li>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>



        <div style="position: absolute; left: -9999px; top:0;">
            <div class="containers" id="container-for-pdf">
                <div class="box1">
                    <div class="item">
                        <h1>
                            <?= $userss['nom'] ?>
                        </h1>
                        <img src="../upload/<?= $userss['images'] ?>" alt="">
                        <h2> <?= $userss['competences'] ?></h2>
                        <span>******</span>

                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="items">
                        <h1>Contact</h1>
                        <div>
                            <img src="../image/address.png" alt="">
                            <span>Adresse</span>
                            <p> <?= $userss['ville'] ?></p>
                        </div>

                        <div>
                            <img src="../image/phone.png" alt="">
                            <span>Téléphone</span>
                            <p><?= $userss['phone'] ?></p>
                        </div>

                        <div>
                            <img src="../image/icons8-gmail-48.png" alt="">
                            <span>E-mail</span>
                            <p><?= $userss['mail'] ?></p>
                        </div>
                    </div>

                    <div class="itemss">

                        <h1>Langues</h1>
                        <div>
                            <?php if ($afficheLangue): ?>
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <p> <?= $langues['langue'] ?> <span> (<?= $langues['niveau'] ?>)</span></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune donnée trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="box2">
                    <div class="decor1"></div>
                    <div class="decor2"></div>

                    <div class="item">
                        <h1><strong><img src="../image/experience.png" alt=""></strong>Expériences</h1>
                        <?php if (empty($afficheMetier)): ?>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            // Séparer les expériences en deux groupes : mis en avant et non mis en avant
                            $experiences_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                return isset($exp['mis_en_avant']) && $exp['mis_en_avant'] == 1;
                            });
                            $experiences_non_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                return !isset($exp['mis_en_avant']) || $exp['mis_en_avant'] != 1;
                            });

                            // Mélanger les expériences non mises en avant
                            shuffle($experiences_non_mises_en_avant);

                            // Nombre maximum d'expériences à afficher
                            $nombre_metier = 3
                                ?>
                            <?php foreach ($experiences_a_afficher as $key => $Metiers): ?>
                                <?php if ($key < $nombre_metier): ?>
                                    <div class="exp">
                                        <span class="part"></span>
                                        <div class="exper">
                                            <h3><?= $Metiers['metier'] ?> <em> <?= $Metiers['moisDebut'] ?> /
                                                    <?= $Metiers['anneeDebut'] ?> // <?= $Metiers['moisFin'] ?> /
                                                    <?= $Metiers['anneeFin'] ?></em> </h3>
                                            <p> <?= $Metiers['description'] ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>


                    <div class="items">
                        <h1><strong><img src="../image/etude.png" alt=""></strong>Éducation</h1>

                        <div class="containe-exp">
                            <?php if (empty($formationUsers)): ?>
                                <strong></strong>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                // Séparer les formations en deux groupes : mises en avant et non mises en avant
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

                                // Combiner les formations en donnant priorité aux mises en avant
                                $formations_a_afficher = array_merge(
                                    array_slice($formations_mises_en_avant, 0, $nombre_formation),
                                    array_slice($formations_non_mises_en_avant, 0, max(0, $nombre_formation - count($formations_mises_en_avant)))
                                );
                                ?>
                                <?php foreach ($formations_a_afficher as $key => $formations): ?>
                                    <?php if ($key < $nombre_formation): ?>
                                        <div class="exp">
                                            <span class="part"></span>
                                            <div class="exper">
                                                <h3><?= $formations['etablissement'] ?> <em><?= $formations['moisDebut'] ?> /
                                                        <?= $formations['anneeDebut'] ?> // <?= $formations['moisFin'] ?> /
                                                        <?= $formations['anneeFin'] ?></em> </h3>
                                                <p><?= $formations['Filiere'] ?> <span class="titre"> <strong>
                                                            <?= $formations['niveau'] ?></strong></span> </p>

                                            </div>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="itemss">
                        <h1><strong><img src="../image/compétences.png" alt=""></strong>Compétences</h1>


                        <ul>
                            <?php if ($competencesUtilisateurLimit7): ?>
                                <?php
                                // Séparer les compétences en deux groupes
                                $competences_mises_en_avant = array_filter($competencesUtilisateurLimit7, function ($comp) {
                                    return isset($comp['mis_en_avant']) && $comp['mis_en_avant'] == 1;
                                });
                                $competences_non_mises_en_avant = array_filter($competencesUtilisateurLimit7, function ($comp) {
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

                                foreach ($competences_a_afficher as $competence): ?>
                                    <li> <?php echo $competence['competence']; ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>

                                <h4>Aucune donnée trouvée</h4>
                            <?php endif ?>
                        </ul>
                    </div>


                    <div class="itemsss">
                        <h1><strong><img src="../image/outil.png" alt=""></strong>Outils informatiques</h1>

                        <ul>
                            <?php if ($afficheOutilLimit5): ?>
                                <?php
                                // Séparer les outils en deux groupes
                                $outils_mis_en_avant = array_filter($afficheOutilLimit5, function ($outil) {
                                    return isset($outil['mis_en_avant']) && $outil['mis_en_avant'] == 1;
                                });
                                $outils_non_mis_en_avant = array_filter($afficheOutilLimit5, function ($outil) {
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

                                foreach ($outils_a_afficher as $outils): ?>
                                    <li> <?= $outils['outil'] ?></li>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </ul>
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
                    if (customPanel.classList.contains('active') && !customPanel.contains(event.target) && !
                        toggleBtn.contains(event.target)) {
                        customPanel.classList.remove('active');
                    }
                });
            }
        });
    </script>
    <!-- Conteneur caché pour le clone PDF -->
    <div style="position: absolute; left: -9999px; top:0;">
        <div id="container-for-pdf" class="containers">
            <div class="box1">
                <div class="item">
                    <h1>
                        <?= $userss['nom'] ?>
                    </h1>
                    <img src="../upload/<?= $userss['images'] ?>" alt="">
                    <h2> <?= $userss['competences'] ?></h2>
                    <span>******</span>

                    <?php if (empty($descriptions)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p class="p">
                            <?= $descriptions['description'] ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="items">
                    <h1>Contact</h1>
                    <div>
                        <img src="../image/address.png" alt="">
                        <span>Adresse</span>
                        <p> <?= $userss['ville'] ?></p>
                    </div>

                    <div>
                        <img src="../image/phone.png" alt="">
                        <span>Téléphone</span>
                        <p><?= $userss['phone'] ?></p>
                    </div>

                    <div>
                        <img src="../image/icons8-gmail-48.png" alt="">
                        <span>E-mail</span>
                        <p><?= $userss['mail'] ?></p>
                    </div>
                </div>

                <div class="itemss">

                    <h1>Langues</h1>
                    <div>
                        <?php if ($afficheLangue): ?>
                            <?php foreach ($afficheLangue as $langues): ?>
                                <p> <?= $langues['langue'] ?> <span> (<?= $langues['niveau'] ?>)</span></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune donnée trouvée</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="box2">
                <div class="decor1"></div>
                <div class="decor2"></div>

                <div class="item">
                    <h1><strong><img src="../image/experience.png" alt=""></strong>Expériences</h1>
                    <?php if (empty($afficheMetier)): ?>
                        <h4>Aucune donnée trouvée</h4>
                    <?php else: ?>
                        <?php
                        // Séparer les expériences en deux groupes : mis en avant et non mis en avant
                        $experiences_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                            return isset($exp['mis_en_avant']) && $exp['mis_en_avant'] == 1;
                        });
                        $experiences_non_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                            return !isset($exp['mis_en_avant']) || $exp['mis_en_avant'] != 1;
                        });

                        // Mélanger les expériences non mises en avant
                        shuffle($experiences_non_mises_en_avant);

                        // Nombre maximum d'expériences à afficher
                        $nombre_metier = 3
                            ?>
                        <?php foreach ($experiences_a_afficher as $key => $Metiers): ?>
                            <?php if ($key < $nombre_metier): ?>
                                <div class="exp">
                                    <span class="part"></span>
                                    <div class="exper">
                                        <h3><?= $Metiers['metier'] ?> <em> <?= $Metiers['moisDebut'] ?> /
                                                <?= $Metiers['anneeDebut'] ?> // <?= $Metiers['moisFin'] ?> /
                                                <?= $Metiers['anneeFin'] ?></em> </h3>
                                        <p> <?= $Metiers['description'] ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>


                <div class="items">
                    <h1><strong><img src="../image/etude.png" alt=""></strong>Éducation</h1>

                    <div class="containe-exp">
                        <?php if (empty($formationUsers)): ?>
                            <strong></strong>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            // Séparer les formations en deux groupes : mises en avant et non mises en avant
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

                            // Combiner les formations en donnant priorité aux mises en avant
                            $formations_a_afficher = array_merge(
                                array_slice($formations_mises_en_avant, 0, $nombre_formation),
                                array_slice($formations_non_mises_en_avant, 0, max(0, $nombre_formation - count($formations_mises_en_avant)))
                            );
                            ?>
                            <?php foreach ($formations_a_afficher as $key => $formations): ?>
                                <?php if ($key < $nombre_formation): ?>
                                    <div class="exp">
                                        <span class="part"></span>
                                        <div class="exper">
                                            <h3><?= $formations['etablissement'] ?> <em><?= $formations['moisDebut'] ?> /
                                                    <?= $formations['anneeDebut'] ?> // <?= $formations['moisFin'] ?> /
                                                    <?= $formations['anneeFin'] ?></em> </h3>
                                            <p><?= $formations['Filiere'] ?> <span class="titre"> <strong>
                                                        <?= $formations['niveau'] ?></strong></span> </p>

                                        </div>
                                    </div>

                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="itemss">
                    <h1><strong><img src="../image/compétences.png" alt=""></strong>Compétences</h1>


                    <ul>
                        <?php if ($competencesUtilisateurLimit7): ?>
                            <?php
                            // Séparer les compétences en deux groupes
                            $competences_mises_en_avant = array_filter($competencesUtilisateurLimit7, function ($comp) {
                                return isset($comp['mis_en_avant']) && $comp['mis_en_avant'] == 1;
                            });
                            $competences_non_mises_en_avant = array_filter($competencesUtilisateurLimit7, function ($comp) {
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

                            foreach ($competences_a_afficher as $competence): ?>
                                <li> <?php echo $competence['competence']; ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>

                            <h4>Aucune donnée trouvée</h4>
                        <?php endif ?>
                    </ul>
                </div>


                <div class="itemsss">
                    <h1><strong><img src="../image/outil.png" alt=""></strong>Outils informatiques</h1>

                    <ul>
                        <?php if ($afficheOutilLimit5): ?>
                            <?php
                            // Séparer les outils en deux groupes
                            $outils_mis_en_avant = array_filter($afficheOutilLimit5, function ($outil) {
                                return isset($outil['mis_en_avant']) && $outil['mis_en_avant'] == 1;
                            });
                            $outils_non_mis_en_avant = array_filter($afficheOutilLimit5, function ($outil) {
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

                            foreach ($outils_a_afficher as $outils): ?>
                                <li> <?= $outils['outil'] ?></li>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>