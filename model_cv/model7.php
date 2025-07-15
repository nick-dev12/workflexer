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
    <title>model7</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="../css/model7_1.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>



    <section class="section3">

        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>

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
                    <p class="highlight">Les éléments que vous avez mis en avant dans votre profil seront affichés en
                        priorité.</p>
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
            document.addEventListener('DOMContentLoaded', function() {
                const closeInfoBtn = document.querySelector('.close-info-btn');
                const infoBubble = document.querySelector('.info-bubble');

                if (closeInfoBtn && infoBubble) {
                    closeInfoBtn.addEventListener('click', function() {
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
            document.addEventListener('DOMContentLoaded', function() {
                // Définition des thèmes
                const themes = {
                    elegant: {
                        fontColorTitre: '#0E3B43',
                        texteColorTitre: '#ffffff',
                        fontColorSection: '#328590',
                        texteColorSection: '#ffffff'
                    },
                    professional: {
                        fontColorTitre: '#1D3557',
                        texteColorTitre: '#F1FAEE',
                        fontColorSection: '#457B9D',
                        texteColorSection: '#F1FAEE'
                    },
                    creative: {
                        fontColorTitre: '#845EC2',
                        texteColorTitre: '#FBEAFF',
                        fontColorSection: '#B39CD0',
                        texteColorSection: '#FBEAFF'
                    },
                    classic: {
                        fontColorTitre: '#4A4A4A',
                        texteColorTitre: '#F5F5F5',
                        fontColorSection: '#7A7A7A',
                        texteColorSection: '#F5F5F5'
                    },
                    modern: {
                        fontColorTitre: '#3D5A80',
                        texteColorTitre: '#E0FBFC',
                        fontColorSection: '#98C1D9',
                        texteColorSection: '#E0FBFC'
                    },
                    earthy: {
                        fontColorTitre: '#5F4B32',
                        texteColorTitre: '#F0EAE2',
                        fontColorSection: '#A1887F',
                        texteColorSection: '#F0EAE2'
                    },
                    // Nouveaux thèmes
                    corporate: {
                        fontColorTitre: '#1A237E',
                        texteColorTitre: '#FFFFFF',
                        fontColorSection: '#5C6BC0',
                        texteColorSection: '#FFFFFF'
                    },
                    burgundy: {
                        fontColorTitre: '#800020',
                        texteColorTitre: '#F2F2F2',
                        fontColorSection: '#AD8A8E',
                        texteColorSection: '#F2F2F2'
                    },
                    mint: {
                        fontColorTitre: '#21897E',
                        texteColorTitre: '#F4FFF8',
                        fontColorSection: '#69B7A8',
                        texteColorSection: '#F4FFF8'
                    },
                    slate: {
                        fontColorTitre: '#2F4F4F',
                        texteColorTitre: '#E8ECEE',
                        fontColorSection: '#708090',
                        texteColorSection: '#E8ECEE'
                    },
                    amber: {
                        fontColorTitre: '#B86E00',
                        texteColorTitre: '#FFFBF0',
                        fontColorSection: '#F0A858',
                        texteColorSection: '#FFFBF0'
                    }
                };

                // Récupérer le numéro du modèle à partir de l'URL
                const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?. [1] || '7';
                const storagePrefix = `model${modelNumber}-`;

                // Ajouter les écouteurs d'événements aux cartes de thème
                const themeCards = document.querySelectorAll('.theme-card');
                themeCards.forEach(card => {
                    card.addEventListener('click', function() {
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

                    // Appliquer aussi aux variables du modèle 7
                    document.documentElement.style.setProperty('--font-color7', theme.fontColorSection);
                    document.documentElement.style.setProperty('--text-color7', theme.texteColorSection);

                    // Mettre à jour les valeurs des inputs de couleur (si existants)
                    if (document.getElementById('fontColor')) {
                        document.getElementById('fontColor').value = theme.fontColorTitre;
                    }
                    if (document.getElementById('fontColor1')) {
                        document.getElementById('fontColor1').value = theme.texteColorTitre;
                    }
                    if (document.getElementById('fontColor2')) {
                        document.getElementById('fontColor2').value = theme.fontColorSection;
                        // Mettre à jour la prévisualisation
                        if (document.getElementById('color-preview2')) {
                            document.getElementById('color-preview2').style.backgroundColor = theme
                                .fontColorSection;
                        }
                    }
                    if (document.getElementById('fontColor3')) {
                        document.getElementById('fontColor3').value = theme.texteColorSection;
                        // Mettre à jour la prévisualisation
                        if (document.getElementById('color-preview3')) {
                            const preview = document.getElementById('color-preview3').querySelector('span');
                            if (preview) {
                                preview.style.color = theme.texteColorSection;
                            }
                        }
                    }

                    // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                    localStorage.setItem(`${storagePrefix}font_color_titre`, theme.fontColorTitre);
                    localStorage.setItem(`${storagePrefix}texte_color_titre`, theme.texteColorTitre);
                    localStorage.setItem(`${storagePrefix}font_color_section`, theme.fontColorSection);
                    localStorage.setItem(`${storagePrefix}texte_color_section`, theme.texteColorSection);
                }

                // Vérifier s'il y a un thème sauvegardé et l'appliquer
                const savedTheme = {
                    fontColorTitre: localStorage.getItem(`${storagePrefix}font_color_titre`),
                    texteColorTitre: localStorage.getItem(`${storagePrefix}texte_color_titre`),
                    fontColorSection: localStorage.getItem(`${storagePrefix}font_color_section`),
                    texteColorSection: localStorage.getItem(`${storagePrefix}texte_color_section`)
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

                    // Appliquer aussi aux variables du modèle 7
                    document.documentElement.style.setProperty('--font-color7', savedTheme.fontColorSection);
                    document.documentElement.style.setProperty('--text-color7', savedTheme.texteColorSection);

                    // Mettre à jour les valeurs des inputs (si existants)
                    if (document.getElementById('fontColor')) {
                        document.getElementById('fontColor').value = savedTheme.fontColorTitre;
                    }
                    if (document.getElementById('fontColor1')) {
                        document.getElementById('fontColor1').value = savedTheme.texteColorTitre;
                    }
                    if (document.getElementById('fontColor2')) {
                        document.getElementById('fontColor2').value = savedTheme.fontColorSection;
                        // Mettre à jour la prévisualisation
                        if (document.getElementById('color-preview2')) {
                            document.getElementById('color-preview2').style.backgroundColor = savedTheme
                                .fontColorSection;
                        }
                    }
                    if (document.getElementById('fontColor3')) {
                        document.getElementById('fontColor3').value = savedTheme.texteColorSection;
                        // Mettre à jour la prévisualisation
                        if (document.getElementById('color-preview3')) {
                            const preview = document.getElementById('color-preview3').querySelector('span');
                            if (preview) {
                                preview.style.color = savedTheme.texteColorSection;
                            }
                        }
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
                <p>Couleur de fond</p>
                <input type="color" name="" id="fontColor2">
                <div id="color-preview2" class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc;">
                </div>
            </div>

            <div class="box">
                <p>Couleur du texte</p>
                <input type="color" name="" id="fontColor3">
                <div id="color-preview3" class="color-preview"
                    style="display: inline-block; margin-left: 10px; width: 30px; height: 20px; border: 1px solid #ccc; position: relative;">
                    <span
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 12px;">Aa</span>
                </div>
            </div>

        </div>



        <div class="container-model">

            <div class="container">
                <div class="box-float"></div>
                <div class="header">
                    <h1><?= $userss['nom'] ?></h1>
                    <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    <h2><?= $userss['competences'] ?></h2>
                </div>
                <div class="content">
                    <div class="left-column">
                        <section class="about">
                            <h3><img src="../image/a propos.png" alt=""> À PROPOS DE MOI</h3>
                            <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                            <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                            <?php endif; ?>
                            <ul class="contact-info">
                                <li><img src="../image/phone.png" alt="phone"> <?= $userss['phone'] ?></li>
                                <li> <img src="../image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></li>
                                <li> <img src="../image/address.png" alt=""> <?= $userss['ville'] ?></li>
                                <li><img src="../image/nationaliet.png" alt="">*********</li>
                            </ul>
                        </section>
                        <section class="education">
                            <h3><img src="../image/etude.png" alt=""> FORMATION</h3>
                            <ul>
                                <?php if (empty($formationUsers)): ?>
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
                                <?php foreach ($formations_a_afficher as $formation): ?>
                                <li>
                                    <span class="date"><?= $formation['moisDebut'] ?> /
                                        <?= $formation['anneeDebut'] ?> , <?= $formation['moisFin'] ?> /
                                        <?= $formation['anneeFin'] ?></span>
                                    <span><?= $formation['Filiere'] ?></span>
                                    <span><?= $formation['etablissement'] ?></span>
                                    <strong><?= $formation['niveau'] ?></strong>
                                </li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </section>
                        <section class="skills">
                            <h3><img src="../image/compétences.png" alt=""> COMPÉTENCES</h3>
                            <div class="skills-columns">
                                <div>
                                    <ul>
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

                                            foreach ($competences_a_afficher as $competence): ?>
                                        <li><?php echo $competence['competence']; ?></li>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="right-column">
                        <section class="experience">
                            <h3><img src="../image/experience.png" alt=""> EXPÉRIENCE</h3>
                            <ul>
                                <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
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
                                <li>
                                    <span class="date1"><?= $Metiers['moisDebut'] ?> /
                                        <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                        <?= $Metiers['anneeFin'] ?></span>
                                    <span><?= $Metiers['metier'] ?></span>
                                    <p><?= $Metiers['description'] ?></p>
                                </li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </section>

                        <section class="outils">
                            <h3><img src="../image/outil.png" alt=""> OUTILS</h3>
                            <div class="outils-columns">
                                <div>
                                    <ul>
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

                                            foreach ($outils_a_afficher as $outils): ?>
                                        <li><?= $outils['outil'] ?></li>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <script>
    // Récupérer le numéro du modèle à partir de l'URL
    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?. [1] || '7';
    const storagePrefix = `model${modelNumber}-`;

    // Sélecteurs d'éléments
    const colorInput2 = document.getElementById('fontColor2');
    const colorPreview2 = document.getElementById('color-preview2');
    const colorInput3 = document.getElementById('fontColor3');
    const colorPreview3 = document.getElementById('color-preview3');

    // Récupération des couleurs sauvegardées
    const fontColor = localStorage.getItem(`${storagePrefix}font_color_section`) || '#c0faf9';
    const textColor = localStorage.getItem(`${storagePrefix}texte_color_section`) || '#000000';

    // Appliquer les couleurs
    document.documentElement.style.setProperty('--font-color7', fontColor);
    document.documentElement.style.setProperty('--text-color7', textColor);

    // Initialiser les valeurs des inputs et prévisualisations
    colorInput2.value = fontColor;
    colorPreview2.style.backgroundColor = fontColor;
    colorInput3.value = textColor;
    if (colorPreview3.querySelector('span')) {
        colorPreview3.querySelector('span').style.color = textColor;
    }

    // Événement pour la couleur de fond
    colorInput2.addEventListener('input', function() {
        const selectedColor = this.value;
        document.documentElement.style.setProperty('--font-color7', selectedColor);
        colorPreview2.style.backgroundColor = selectedColor;
        localStorage.setItem(`${storagePrefix}font_color_section`, selectedColor);
    });

    // Événement pour la couleur de texte
    colorInput3.addEventListener('input', function() {
        const selectedColor = this.value;
        document.documentElement.style.setProperty('--text-color7', selectedColor);
        if (colorPreview3.querySelector('span')) {
            colorPreview3.querySelector('span').style.color = selectedColor;
        }
        localStorage.setItem(`${storagePrefix}texte_color_section`, selectedColor);
    });
    </script>

</body>

</html>