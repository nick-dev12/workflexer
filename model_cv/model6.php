<?php
// Vérification de l'appareil au tout début

// Démarre la session
session_start();





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
    <title>model6</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="../css/model6_1.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
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
    </script>s

    <section class="section3">

        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>

            <script>
                function generatePDF() {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const element = document.querySelector(".container");

                    domtoimage.toJpeg(element, {
                        quality: 1.5,
                        bgcolor: '#fff'
                    })
                        .then(function (dataUrl) {
                            const pdf = new jsPDF('p', 'mm', 'a4');
                            const imgProps = pdf.getImageProperties(dataUrl);
                            const pdfWidth = pdf.internal.pageSize.getWidth();
                            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                            pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);
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
                            fontColorTitre: '#0E3B43',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#328590',
                            texteColorSection: '#ffffff',
                            texteColor: '#000000'
                        },
                        professional: {
                            fontColorTitre: '#1D3557',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#457B9D',
                            texteColorSection: '#ffffff',
                            texteColor: '#000000'
                        },
                        creative: {
                            fontColorTitre: '#845EC2',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#B39CD0',
                            texteColorSection: '#ffffff',
                            texteColor: '#000000'
                        },
                        classic: {
                            fontColorTitre: '#4A4A4A',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#7A7A7A',
                            texteColorSection: '#ffffff',
                            texteColor: '#000000'
                        },
                        modern: {
                            fontColorTitre: '#3D5A80',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#98C1D9',
                            texteColorSection: '#ffffff',
                            texteColor: '#000000'
                        },
                        earthy: {
                            fontColorTitre: '#5F4B32',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#A1887F',
                            texteColorSection: '#ffffff',
                            texteColor: '#000000'
                        },
                        // Nouveaux thèmes
                        corporate: {
                            fontColorTitre: '#1A237E',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#5C6BC0',
                            texteColorSection: '#FFFFFF',
                            texteColor: '#000000'
                        },
                        burgundy: {
                            fontColorTitre: '#800020',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#AD8A8E',
                            texteColorSection: '#FFFFFF',
                            texteColor: '#000000'
                        },
                        mint: {
                            fontColorTitre: '#21897E',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#69B7A8',
                            texteColorSection: '#FFFFFF',
                            texteColor: '#000000'
                        },
                        slate: {
                            fontColorTitre: '#2F4F4F',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#708090',
                            texteColorSection: '#FFFFFF',
                            texteColor: '#000000'
                        },
                        amber: {
                            fontColorTitre: '#B86E00',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#F0A858',
                            texteColorSection: '#FFFFFF',
                            texteColor: '#000000'
                        }
                    };

                    // Récupérer le numéro du modèle à partir de l'URL
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '6';
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
                        document.documentElement.style.setProperty('--font-color_titre', theme.fontColorTitre);
                        document.documentElement.style.setProperty('--texte-color_titre', theme.texteColorTitre);
                        document.documentElement.style.setProperty('--font-color_section', theme.fontColorSection);
                        document.documentElement.style.setProperty('--texte-color_section', theme
                            .texteColorSection);
                        document.documentElement.style.setProperty('--text-color6', theme.texteColor);
                        document.documentElement.style.setProperty('--font-color6', theme.fontColorSection);

                        // Mettre à jour les valeurs des inputs de couleur (si existants)
                        if (document.getElementById('fontColor1')) {
                            document.getElementById('fontColor1').value = theme.texteColorTitre;
                        }
                        if (document.getElementById('fontColor2')) {
                            document.getElementById('fontColor2').value = theme.fontColorSection;
                        }
                        if (document.getElementById('fontColor3')) {
                            document.getElementById('fontColor3').value = theme.texteColor;
                        }

                        // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                        localStorage.setItem(`${storagePrefix}font_color_titre`, theme.fontColorTitre);
                        localStorage.setItem(`${storagePrefix}texte_color_titre`, theme.texteColorTitre);
                        localStorage.setItem(`${storagePrefix}font_color_section`, theme.fontColorSection);
                        localStorage.setItem(`${storagePrefix}texte_color_section`, theme.texteColorSection);
                        localStorage.setItem('texte_color6', theme.texteColor);
                        localStorage.setItem('color_de_fond_6', theme.fontColorSection);
                    }

                    // Vérifier s'il y a un thème sauvegardé et l'appliquer
                    const savedTheme = {
                        fontColorTitre: localStorage.getItem(`${storagePrefix}font_color_titre`),
                        texteColorTitre: localStorage.getItem(`${storagePrefix}texte_color_titre`),
                        fontColorSection: localStorage.getItem(`${storagePrefix}font_color_section`),
                        texteColorSection: localStorage.getItem(`${storagePrefix}texte_color_section`),
                        texteColor: localStorage.getItem('texte_color6')
                    };

                    if (savedTheme.fontColorTitre) {
                        // Appliquer le thème sauvegardé
                        document.documentElement.style.setProperty('--font-color_titre', savedTheme.fontColorTitre);
                        document.documentElement.style.setProperty('--texte-color_titre', savedTheme
                            .texteColorTitre);
                        document.documentElement.style.setProperty('--font-color_section', savedTheme
                            .fontColorSection);
                        document.documentElement.style.setProperty('--texte-color_section', savedTheme
                            .texteColorSection);
                        document.documentElement.style.setProperty('--text-color6', savedTheme.texteColor ||
                            '#000000');
                        document.documentElement.style.setProperty('--font-color6', savedTheme.fontColorSection);

                        // Mettre à jour les valeurs des inputs (si existants)
                        if (document.getElementById('fontColor1')) {
                            document.getElementById('fontColor1').value = savedTheme.texteColorTitre;
                        }
                        if (document.getElementById('fontColor2')) {
                            document.getElementById('fontColor2').value = savedTheme.fontColorSection;
                        }
                        if (document.getElementById('fontColor3')) {
                            document.getElementById('fontColor3').value = savedTheme.texteColor || '#000000';
                        }

                        // Retrouver quel thème correspond aux couleurs sauvegardées
                        for (const [themeName, theme] of Object.entries(themes)) {
                            if (theme.fontColorTitre === savedTheme.fontColorTitre &&
                                theme.texteColorTitre === savedTheme.texteColorTitre) {
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
                <p>Couleur des dates </p>
                <input type="color" name="" id="fontColor1">
                <div class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc;">
                </div>
            </div>

            <div class="box">
                <p>Couleur de fond</p>
                <input type="color" name="" id="fontColor2">
                <div class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc;">
                </div>
            </div>

            <div class="box">
                <p>Couleur du texte</p>
                <input type="color" name="" id="fontColor3">
                <div class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc; position: relative;">
                    <span
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 12px;">Aa</span>
                </div>
            </div>

            <script>
                const color_date = document.getElementById('fontColor1');
                const color_preview1 = color_date.nextElementSibling;

                // Récupérer la valeur sauvegardée dans le stockage local (si elle existe)
                const saved_color_date6 = localStorage.getItem('color_date6');

                // Appliquer la couleur sauvegardée ou une valeur par défaut si aucune couleur n'a été sauvegardée
                document.documentElement.style.setProperty('--date-color6', saved_color_date6 || '#019fcf');
                color_date.value = saved_color_date6 || '#019fcf'; // Mettre à jour la valeur du champ input
                color_preview1.style.backgroundColor = saved_color_date6 || '#019fcf';

                // Écouter les changements sur le champ input
                color_date.addEventListener('input', function () {
                    // Mettre à jour la valeur de la variable CSS en fonction de la couleur choisie par l'utilisateur
                    const select_color_date = color_date.value;
                    document.documentElement.style.setProperty('--date-color6', select_color_date);
                    color_preview1.style.backgroundColor = select_color_date;

                    // Sauvegarder la couleur sélectionnée dans le stockage local
                    localStorage.setItem('color_date6', select_color_date);
                });



                const color_de_fond6 = document.getElementById('fontColor2');
                const color_preview2 = color_de_fond6.nextElementSibling;
                const color_de_fond_6 = localStorage.getItem('color_de_fond_6');

                document.documentElement.style.setProperty('--font-color6', color_de_fond_6 || '#e3e3e3');
                document.documentElement.style.setProperty('--font-color_section', color_de_fond_6 || '#328590');
                color_de_fond6.value = color_de_fond_6 || '#328590'; // Mettre à jour la valeur du champ input
                color_preview2.style.backgroundColor = color_de_fond_6 || '#328590';

                color_de_fond6.addEventListener('input', function () {
                    const select_font_color6 = color_de_fond6.value;
                    document.documentElement.style.setProperty('--font-color6', select_font_color6);
                    document.documentElement.style.setProperty('--font-color_section', select_font_color6);
                    color_preview2.style.backgroundColor = select_font_color6;
                    localStorage.setItem('color_de_fond_6', select_font_color6);
                });



                const texte_inpute3 = document.getElementById('fontColor3');
                const color_preview3 = texte_inpute3.nextElementSibling;
                const texte_color6 = localStorage.getItem('texte_color6');

                document.documentElement.style.setProperty('--text-color6', texte_color6 || '#000000');
                texte_inpute3.value = texte_color6 || '#000000'; // Mettre à jour la valeur du champ input
                color_preview3.style.backgroundColor = '#ffffff';
                color_preview3.querySelector('span').style.color = texte_color6 || '#000000';

                texte_inpute3.addEventListener('input', function () {
                    const selecte_texte_color6 = texte_inpute3.value;
                    document.documentElement.style.setProperty('--text-color6', selecte_texte_color6);
                    color_preview3.querySelector('span').style.color = selecte_texte_color6;
                    localStorage.setItem('texte_color6', selecte_texte_color6);
                });
            </script>
        </div>


        <div class="container-model">
            <div class="container">
                <div class="box1">
                    <div class="item1">
                        <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    </div>

                    <div class="item2">
                        <h1><?= $userss['nom'] ?></h1>
                        <h2><?= $userss['competences'] ?></h2>
                        <div>
                            <ul>
                                <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                                <li><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></li>
                                <li><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></li>
                            </ul>

                            <?php if (empty($afficheLangue)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>
                                <ul id="langue">
                                    <?php foreach ($afficheLangue as $langues): ?>
                                        <li>
                                            <?php echo $langues['langue']; ?> <span><?= $langues['niveau']; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <div class="box2">

                </div>
                <div class="box3">
                    <div class="item1">
                        <div class="edu">
                            <h2> <img src="/image/etude.png" alt=""> Éducation</h2>
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
                                $formations_a_afficher = array_slice(array_merge(
                                    $formations_mises_en_avant,
                                    $formations_non_mises_en_avant
                                ), 0, $nombre_formation);

                                foreach ($formations_a_afficher as $formations): ?>
                                    <div>
                                        <h3><?= $formations['etablissement'] ?></h3>
                                        <span> <?= $formations['moisDebut'] ?> /
                                            <?= $formations['anneeDebut'] ?> , <?= $formations['moisFin'] ?> /
                                            <?= $formations['anneeFin'] ?></span>
                                        <p><?= $formations['Filiere'] ?> , <strong>
                                                <?= $formations['niveau'] ?></strong> </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="comp">
                            <h2><img src="/image/compétences.png" alt=""> Compétences</h2>
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

                                // Combiner les compétences en donnant priorité aux mises en avant
                                $competences_a_afficher = array_slice(array_merge(
                                    $competences_mises_en_avant,
                                    $competences_non_mises_en_avant
                                ), 0, $nombre_competences);
                                ?>
                                <ul>
                                    <?php foreach ($competences_a_afficher as $competence): ?>
                                        <li> <?php echo $competence['competence']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php endif ?>
                        </div>

                    </div>

                    <div class="item2">
                        <div class="moi">
                            <h2><img src="/image/a propos.png" alt=""> À propos</h2>
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
                                $experiences_a_afficher = array_slice(array_merge(
                                    $experiences_mises_en_avant,
                                    $experiences_non_mises_en_avant
                                ), 0, $nombre_metier);

                                foreach ($experiences_a_afficher as $Metiers): ?>
                                    <div>
                                        <span><?= $Metiers['moisDebut'] ?> /
                                            <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                            <?= $Metiers['anneeFin'] ?></span>
                                        <h3><?= $Metiers['metier'] ?></h3>
                                        <p><?= $Metiers['description'] ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>


                        <div class="outils">
                            <h2><img src="/image/outil.png" alt=""> Maitrise des outils </h2>
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

                                // Combiner les outils en donnant priorité aux mis en avant
                                $outils_a_afficher = array_slice(array_merge(
                                    $outils_mis_en_avant,
                                    $outils_non_mis_en_avant
                                ), 0, $nombre_outils);
                                ?>
                                <ul>
                                    <?php foreach ($outils_a_afficher as $outils): ?>
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