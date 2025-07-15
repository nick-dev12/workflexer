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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/model9_1.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
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
            <p class="highlight">Les éléments que vous avez mis en avant dans votre profil seront affichés en priorité.
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

            <script>
                function generatePDF() {
                    // Afficher un message de chargement
                    const loadingMessage = document.createElement('div');
                    loadingMessage.id = 'loading-message';
                    loadingMessage.innerHTML = `
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                                    background: rgba(0,0,0,0.8); display: flex; align-items: center; 
                                    justify-content: center; z-index: 99999; color: white; font-size: 18px;">
                            <div style="text-align: center;">
                                <div style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; 
                                           border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; 
                                           margin: 0 auto 20px;"></div>
                                <div>Génération du PDF en cours...</div>
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

                    const {
                        jsPDF
                    } = window.jspdf;
                    const element = document.querySelector("#container-for-pdf");

                    // Optimisations légères pour une meilleure qualité
                    const options = {
                        scale: 2.2,
                        quality: 0.95,
                        bgcolor: '#ffffff',
                        useCORS: true
                    };

                    // Attendre un court instant pour que le message s'affiche
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

                                // Nom de fichier avec timestamp
                                const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
                                pdf.save(`cv-model9-${timestamp}.pdf`);
                            })
                            .catch(function (error) {
                                console.error('Une erreur est survenue lors de la génération du PDF:', error);
                                // Supprimer le message d'attente en cas d'erreur
                                if (document.body.contains(loadingMessage)) {
                                    document.body.removeChild(loadingMessage);
                                }
                                alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                            });
                    }, 600);
                }
            </script>

            <div class="theme-selector">
                <h3>Thèmes de couleurs</h3>
                <div class="themes-container">
                    <div class="theme-card" data-theme="elegant-marine">
                        <div class="theme-preview">
                            <div style="background-color: #2c3e50; height: 20px;"></div>
                            <div style="background-color: #3498db; height: 20px;"></div>
                        </div>
                        <span>Élégant Marine</span>
                    </div>
                    <div class="theme-card" data-theme="sobre-ardoise">
                        <div class="theme-preview">
                            <div style="background-color: #424949; height: 20px;"></div>
                            <div style="background-color: #7f8c8d; height: 20px;"></div>
                        </div>
                        <span>Sobre Ardoise</span>
                    </div>
                    <div class="theme-card" data-theme="pro-foret">
                        <div class="theme-preview">
                            <div style="background-color: #186a3b; height: 20px;"></div>
                            <div style="background-color: #58d68d; height: 20px;"></div>
                        </div>
                        <span>Pro Forêt</span>
                    </div>
                    <div class="theme-card" data-theme="chaud-bordeaux">
                        <div class="theme-preview">
                            <div style="background-color: #922b21; height: 20px;"></div>
                            <div style="background-color: #e74c3c; height: 20px;"></div>
                        </div>
                        <span>Chaud Bordeaux</span>
                    </div>
                    <div class="theme-card" data-theme="moderne-violine">
                        <div class="theme-preview">
                            <div style="background-color: #4a235a; height: 20px;"></div>
                            <div style="background-color: #a569bd; height: 20px;"></div>
                        </div>
                        <span>Moderne Violine</span>
                    </div>
                    <div class="theme-card" data-theme="dynamique-orange">
                        <div class="theme-preview">
                            <div style="background-color: #d35400; height: 20px;"></div>
                            <div style="background-color: #f39c12; height: 20px;"></div>
                        </div>
                        <span>Dynamique Orange</span>
                    </div>
                    <div class="theme-card" data-theme="royal-amethyste">
                        <div class="theme-preview">
                            <div style="background-color: #4a148c; height: 20px;"></div>
                            <div style="background-color: #ab47bc; height: 20px;"></div>
                        </div>
                        <span>Royal Améthyste</span>
                    </div>
                    <div class="theme-card" data-theme="cuivre-poli">
                        <div class="theme-preview">
                            <div style="background-color: #b96a43; height: 20px;"></div>
                            <div style="background-color: #d79b7d; height: 20px;"></div>
                        </div>
                        <span>Cuivre Poli</span>
                    </div>
                    <div class="theme-card" data-theme="acier-saphir">
                        <div class="theme-preview">
                            <div style="background-color: #37474f; height: 20px;"></div>
                            <div style="background-color: #1976d2; height: 20px;"></div>
                        </div>
                        <span>Acier & Saphir</span>
                    </div>
                    <div class="theme-card" data-theme="vert-luxueux">
                        <div class="theme-preview">
                            <div style="background-color: #004d40; height: 20px;"></div>
                            <div style="background-color: #26a69a; height: 20px;"></div>
                        </div>
                        <span>Vert Luxueux</span>
                    </div>
                    <div class="theme-card" data-theme="graphite-or">
                        <div class="theme-preview">
                            <div style="background-color: #212121; height: 20px;"></div>
                            <div style="background-color: #fbc02d; height: 20px;"></div>
                        </div>
                        <span>Graphite & Or</span>
                    </div>
                </div>
            </div>

            <div class="manual-color-options">
                <h3>Personnalisation manuelle</h3>

                <div class="color-option">
                    <label for="headerBgColor">Couleur de l'en-tête</label>
                    <input type="color" id="headerBgColor" data-variable="--header-bg">
                </div>
                <div class="color-option">
                    <label for="headerTextColor">Texte de l'en-tête</label>
                    <input type="color" id="headerTextColor" data-variable="--header-text">
                </div>
                <div class="color-option">
                    <label for="accentColor">Couleur des accents</label>
                    <input type="color" id="accentColor" data-variable="--accent-color">
                </div>
                <div class="color-option">
                    <label for="leftColumnBgColor">Fond colonne gauche</label>
                    <input type="color" id="leftColumnBgColor" data-variable="--left-column-bg">
                </div>

                <button id="resetColors">Réinitialiser</button>
            </div>

            <style>
                .theme-selector,
                .manual-color-options {
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f9f9f9;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }

                .theme-selector h3,
                .manual-color-options h3 {
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
                    justify-content: space-around;
                    gap: 12px;
                    margin-bottom: 15px;
                }

                .theme-card {
                    width: calc(33.33% - 10px);
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
                    display: flex;
                    height: 40px;
                }

                .theme-preview>div {
                    flex: 1;
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

                /* Style pour les sélecteurs de couleur */
                .manual-color-options .color-option {
                    margin-bottom: 12px;
                }

                .manual-color-options label {
                    display: block;
                    margin-bottom: 6px;
                    font-size: 14px;
                    font-weight: 500;
                    color: #444;
                }

                .manual-color-options input[type="color"] {
                    -webkit-appearance: none;
                    border: none;
                    width: 100%;
                    height: 35px;
                    cursor: pointer;
                    border-radius: 4px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                }

                .manual-color-options input[type="color"]::-webkit-color-swatch-wrapper {
                    padding: 0;
                }

                .manual-color-options input[type="color"]::-webkit-color-swatch {
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }

                #resetColors {
                    width: 100%;
                    margin-top: 15px;
                    padding: 10px;
                    background-color: #e74c3c;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-weight: bold;
                    transition: background-color 0.3s ease;
                }

                #resetColors:hover {
                    background-color: #c0392b;
                }

                /* Styles pour tablette */
                @media (max-width: 768px) {
                    .theme-card {
                        width: calc(50% - 12px);
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
                }
            </style>
        </div>


        <div class="cv-container" id="cv9-visible">
            <!-- En-tête du CV avec photo et présentation -->
            <div class="cv-header">
                <div class="header-content">
                    <h1 class="name-title">
                        <?= $userss['nom'] ?>
                    </h1>
                    <p class="job-title"><?= $userss['competences'] ?? "Gestionnaire administratif" ?></p>
                    <p class="header-text">
                        <?php if (empty($descriptions)): ?>
                        <p>Aucune description trouvée</p>
                    <?php else: ?>
                        <?= $descriptions['description'] ?>
                    <?php endif; ?>
                    </p>
                </div>
                <img src="../upload/<?= $userss['images'] ? $userss['images'] : 'default-profile.jpg' ?>"
                    alt="Photo de profil" class="profile-photo">
            </div>

            <!-- Corps du CV avec deux colonnes -->
            <div class="cv-body">
                <!-- Colonne gauche pour contact, langues et compétences -->
                <div class="left-column">
                    <div class="section contact-section">
                        <h3 class="section-title">CONTACT</h3>
                        <div class="contact-info">
                            <p><img src="../image/address.png" alt="Adresse"><?= $userss['ville'] ?? "Genève, Suisse" ?>
                            </p>
                            <p><img src="../image/icons8-gmail-48.png"
                                    alt="Email"><?= $userss['mail'] ?? "Contact99@gmail.com" ?>
                            </p>
                            <p><img src="../image/phone.png"
                                    alt="Téléphone"><?= $userss['phone'] ?? "+41 55.31.00.12" ?></p>
                            <p><img src="../image/linkedin.png"
                                    alt="LinkedIn">www.linkedin.com/in/<?= strtolower($userss['prenom'] ?? 'albert') ?>
                            </p>
                        </div>
                    </div>

                    <div class="section languages-section">
                        <h3 class="section-title">LANGUES</h3>
                        <ul class="languages-list">
                            <?php if (empty($afficheLangue)): ?>
                                <p>Aucune langue trouvée</p>
                            <?php else: ?>
                                <?php foreach ($afficheLangue as $index => $langues): ?>
                                    <li>
                                        <span><?= strtoupper($langues['langue']) ?></span>
                                        <div class="language-level">
                                            <?php
                                            $niveauMap = [
                                                'Debutant' => 1,
                                                'Intermédiaire' => 2,
                                                'Professionnel' => 3,
                                                'Avancé' => 4,
                                            ];
                                            $niveau = isset($niveauMap[$langues['niveau']]) ? $niveauMap[$langues['niveau']] : 3;

                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $niveau) {
                                                    echo '<span class="level-dot"></span>';
                                                } else {
                                                    echo '<span class="level-dot empty"></span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>



                    <div class="section">
                        <h3 class="section-title">INFORMATIQUE</h3>
                        <ul class="skills-list">
                            <?php if (!empty($afficheOutilLimit5)): ?>

                                <?php foreach ($afficheOutilLimit5 as $index => $outil): ?>
                                    <li>
                                        <span><?= strtoupper($outil['outil']) ?></span>
                                        <div class="language-level">
                                            <?php
                                            $niveauMap = [
                                                'Debutant' => 1,
                                                'Intermédiaire' => 2,
                                                'Professionnel' => 3,
                                                'Avancer' => 4,
                                            ];
                                            $niveau = isset($niveauMap[$outil['niveau']]) ? $niveauMap[$outil['niveau']] : 3;

                                            for ($i = 1; $i <= 4; $i++) {
                                                if ($i <= $niveau) {
                                                    echo '<span class="level-dot"></span>';
                                                } else {
                                                    echo '<span class="level-dot empty"></span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune compétence trouvée</p>
                            <?php endif; ?>
                        </ul>
                    </div>



                    <div class="section skills-section">
                        <h3 class="section-title">COMPÉTENCES</h3>
                        <ul class="skills-list">
                            <?php if ($competencesUtilisateurLimit7): ?>
                                <?php foreach ($competencesUtilisateurLimit7 as $index => $competence): ?>
                                    <li>
                                        <?= $competence['competence'] ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune compétence trouvée</p>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <!-- Colonne droite pour expériences et formations -->
                <div class="right-column">
                    <div class="section experiences-section">
                        <h3 class="section-title">EXPÉRIENCES</h3>

                        <?php if (empty($afficheMetier)): ?>
                            <p>Aucune expérience trouvée</p>
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
                            $experiences_a_afficher = array_slice($experiences_mises_en_avant, 0, $nombre_metier);
                            if (count($experiences_a_afficher) < $nombre_metier) {
                                $experiences_a_afficher = array_merge(
                                    $experiences_a_afficher,
                                    array_slice($experiences_non_mises_en_avant, 0, $nombre_metier - count($experiences_a_afficher))
                                );
                            }
                            ?>
                            <?php foreach ($experiences_a_afficher as $Metiers): ?>
                                <div class="experience-item">
                                    <h4><?= $Metiers['metier'] ?></h4>
                                    <p class="date"><img src="../image/position.png"
                                            alt="Date"><?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                        <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?>
                                    </p>
                                    <ul>
                                        <li>
                                            <?= $Metiers['description'] ?>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="section education-section">
                        <h3 class="section-title">FORMATIONS</h3>

                        <?php if (empty($formationUsers)): ?>
                            <p>Aucune formation trouvée</p>
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
                            $formations_a_afficher = array_slice($formations_mises_en_avant, 0, $nombre_formation);
                            if (count($formations_a_afficher) < $nombre_formation) {
                                $formations_a_afficher = array_merge(
                                    $formations_a_afficher,
                                    array_slice($formations_non_mises_en_avant, 0, $nombre_formation - count($formations_a_afficher))
                                );
                            }
                            ?>
                            <?php foreach ($formations_a_afficher as $formations): ?>
                                <div class="education-item">
                                    <h4><?= $formations['Filiere'] ?></h4>
                                    <p class="school"><?= $formations['etablissement'] ?> - <?= $formations['niveau'] ?></p>
                                    <p class="date"><img src="../image/position.png"
                                            alt="Date"><?= $formations['moisDebut'] ?>/<?= $formations['anneeDebut'] ?> -
                                        <?= $formations['moisFin'] ?>/<?= $formations['anneeFin'] ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div id="container-for-pdf" class="cv-container">
                <!-- En-tête du CV avec photo et présentation -->
                <div class="cv-header">
                    <div class="header-content">
                        <h1 class="name-title">
                            <?= $userss['nom'] ?>
                        </h1>
                        <p class="job-title"><?= $userss['competences'] ?? "Gestionnaire administratif" ?></p>
                        <p class="header-text">
                            <?php if (empty($descriptions)): ?>
                            <p>Aucune description trouvée</p>
                        <?php else: ?>
                            <?= $descriptions['description'] ?>
                        <?php endif; ?>
                        </p>
                    </div>
                    <img src="../upload/<?= $userss['images'] ? $userss['images'] : 'default-profile.jpg' ?>"
                        alt="Photo de profil" class="profile-photo">
                </div>

                <!-- Corps du CV avec deux colonnes -->
                <div class="cv-body">
                    <!-- Colonne gauche pour contact, langues et compétences -->
                    <div class="left-column">
                        <div class="section contact-section">
                            <h3 class="section-title">CONTACT</h3>
                            <div class="contact-info">
                                <p><img src="../image/address.png"
                                        alt="Adresse"><?= $userss['ville'] ?? "Genève, Suisse" ?>
                                </p>
                                <p><img src="../image/icons8-gmail-48.png"
                                        alt="Email"><?= $userss['mail'] ?? "Contact99@gmail.com" ?>
                                </p>
                                <p><img src="../image/phone.png"
                                        alt="Téléphone"><?= $userss['phone'] ?? "+41 55.31.00.12" ?></p>
                                <p><img src="../image/linkedin.png"
                                        alt="LinkedIn">www.linkedin.com/in/<?= strtolower($userss['prenom'] ?? 'albert') ?>
                                </p>
                            </div>
                        </div>

                        <div class="section languages-section">
                            <h3 class="section-title">LANGUES</h3>
                            <ul class="languages-list">
                                <?php if (empty($afficheLangue)): ?>
                                    <p>Aucune langue trouvée</p>
                                <?php else: ?>
                                    <?php foreach ($afficheLangue as $index => $langues): ?>
                                        <li>
                                            <span><?= strtoupper($langues['langue']) ?></span>
                                            <div class="language-level">
                                                <?php
                                                $niveauMap = [
                                                    'Debutant' => 1,
                                                    'Intermédiaire' => 2,
                                                    'Professionnel' => 3,
                                                    'Avancé' => 4,
                                                ];
                                                $niveau = isset($niveauMap[$langues['niveau']]) ? $niveauMap[$langues['niveau']] : 3;

                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $niveau) {
                                                        echo '<span class="level-dot"></span>';
                                                    } else {
                                                        echo '<span class="level-dot empty"></span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>



                        <div class="section">
                            <h3 class="section-title">INFORMATIQUE</h3>
                            <ul class="skills-list">
                                <?php if (!empty($afficheOutilLimit5)): ?>
                                    <?php
                                    // Séparer les outils en deux groupes : mis en avant et non mis en avant
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

                                    // Combiner les outils en donnant priorité aux mis en avant
                                    $outils_a_afficher = array_slice($outils_mis_en_avant, 0, $nombre_outils);
                                    if (count($outils_a_afficher) < $nombre_outils) {
                                        $outils_a_afficher = array_merge(
                                            $outils_a_afficher,
                                            array_slice($outils_non_mis_en_avant, 0, $nombre_outils - count($outils_a_afficher))
                                        );
                                    }
                                    ?>
                                    <?php foreach ($outils_a_afficher as $outil): ?>
                                        <li>
                                            <span><?= strtoupper($outil['outil']) ?></span>
                                            <div class="language-level">
                                                <?php
                                                $niveauMap = [
                                                    'Debutant' => 1,
                                                    'Intermédiaire' => 2,
                                                    'Professionnel' => 3,
                                                    'Avancer' => 4,
                                                ];
                                                $niveau = isset($niveauMap[$outil['niveau']]) ? $niveauMap[$outil['niveau']] : 3;

                                                for ($i = 1; $i <= 4; $i++) {
                                                    if ($i <= $niveau) {
                                                        echo '<span class="level-dot"></span>';
                                                    } else {
                                                        echo '<span class="level-dot empty"></span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune compétence trouvée</p>
                                <?php endif; ?>
                            </ul>
                        </div>



                        <div class="section skills-section">
                            <h3 class="section-title">COMPÉTENCES</h3>
                            <ul class="skills-list">
                                <?php if ($competencesUtilisateurLimit7): ?>
                                    <?php
                                    // Séparer les compétences en deux groupes : mises en avant et non mises en avant
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

                                    // Combiner les compétences en donnant priorité aux mises en avant
                                    $competences_a_afficher = array_slice($competences_mises_en_avant, 0, $nombre_competences);
                                    if (count($competences_a_afficher) < $nombre_competences) {
                                        $competences_a_afficher = array_merge(
                                            $competences_a_afficher,
                                            array_slice($competences_non_mises_en_avant, 0, $nombre_competences - count($competences_a_afficher))
                                        );
                                    }
                                    ?>
                                    <?php foreach ($competences_a_afficher as $competence): ?>
                                        <li>
                                            <?= $competence['competence'] ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune compétence trouvée</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Colonne droite pour expériences et formations -->
                    <div class="right-column">
                        <div class="section experiences-section">
                            <h3 class="section-title">EXPÉRIENCES</h3>

                            <?php if (empty($afficheMetier)): ?>
                                <p>Aucune expérience trouvée</p>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 3;
                                ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <div class="experience-item">
                                            <h4><?= $Metiers['metier'] ?></h4>
                                            <p class="date"><img src="../image/position.png"
                                                    alt="Date"><?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                                <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?>
                                            </p>
                                            <ul>
                                                <li>
                                                    <?= $Metiers['description'] ?>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="section education-section">
                            <h3 class="section-title">FORMATIONS</h3>

                            <?php if (empty($formationUsers)): ?>
                                <p>Aucune formation trouvée</p>
                            <?php else: ?>
                                <?php
                                shuffle($formationUsers);
                                $nombre_formation = 3;
                                ?>
                                <?php foreach ($formationUsers as $key => $formations): ?>
                                    <?php if ($key < $nombre_formation): ?>
                                        <div class="education-item">
                                            <h4><?= $formations['Filiere'] ?></h4>
                                            <p class="school"><?= $formations['etablissement'] ?> - <?= $formations['niveau'] ?></p>
                                            <p class="date"><img src="../image/position.png"
                                                    alt="Date"><?= $formations['moisDebut'] ?>/<?= $formations['anneeDebut'] ?> -
                                                <?= $formations['moisFin'] ?>/<?= $formations['anneeFin'] ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        // JavaScript pour changer les thèmes
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.documentElement;
            const themeCards = document.querySelectorAll('.theme-card');
            const colorPickers = document.querySelectorAll('.manual-color-options input[type="color"]');
            const resetButton = document.getElementById('resetColors');

            const themes = {
                'elegant-marine': {
                    name: 'Élégant Marine',
                    colors: {
                        '--header-bg': '#2c3e50',
                        '--header-text': '#ffffff',
                        '--accent-color': '#3498db',
                        '--left-column-bg': '#f4f6f7',
                        '--main-text-color': '#34495e',
                    }
                },
                'sobre-ardoise': {
                    name: 'Sobre Ardoise',
                    colors: {
                        '--header-bg': '#424949',
                        '--header-text': '#ffffff',
                        '--accent-color': '#7f8c8d',
                        '--left-column-bg': '#f8f9f9',
                        '--main-text-color': '#2e3031',
                    }
                },
                'pro-foret': {
                    name: 'Professionnel Forêt',
                    colors: {
                        '--header-bg': '#186a3b',
                        '--header-text': '#ffffff',
                        '--accent-color': '#58d68d',
                        '--left-column-bg': '#f2fdf6',
                        '--main-text-color': '#204a31',
                    }
                },
                'chaud-bordeaux': {
                    name: 'Chaud Bordeaux',
                    colors: {
                        '--header-bg': '#922b21',
                        '--header-text': '#ffffff',
                        '--accent-color': '#e74c3c',
                        '--left-column-bg': '#fdf2f1',
                        '--main-text-color': '#5c1b14',
                    }
                },
                'moderne-violine': {
                    name: 'Moderne Violine',
                    colors: {
                        '--header-bg': '#4a235a',
                        '--header-text': '#ffffff',
                        '--accent-color': '#a569bd',
                        '--left-column-bg': '#f6f3f7',
                        '--main-text-color': '#32183e',
                    }
                },
                'dynamique-orange': {
                    name: 'Dynamique Orange',
                    colors: {
                        '--header-bg': '#d35400',
                        '--header-text': '#ffffff',
                        '--accent-color': '#f39c12',
                        '--left-column-bg': '#fef5e7',
                        '--main-text-color': '#783000',
                    }
                },
                'royal-amethyste': {
                    name: 'Royal Améthyste',
                    colors: {
                        '--header-bg': '#4a148c',
                        '--header-text': '#ffffff',
                        '--accent-color': '#ab47bc',
                        '--left-column-bg': '#f3e5f5',
                        '--main-text-color': '#311b92',
                    }
                },
                'cuivre-poli': {
                    name: 'Cuivre Poli',
                    colors: {
                        '--header-bg': '#b96a43',
                        '--header-text': '#ffffff',
                        '--accent-color': '#d79b7d',
                        '--left-column-bg': '#fdf6f2',
                        '--main-text-color': '#5d4037',
                    }
                },
                'acier-saphir': {
                    name: 'Acier & Saphir',
                    colors: {
                        '--header-bg': '#37474f',
                        '--header-text': '#ffffff',
                        '--accent-color': '#1976d2',
                        '--left-column-bg': '#eceff1',
                        '--main-text-color': '#263238',
                    }
                },
                'vert-luxueux': {
                    name: 'Vert Luxueux',
                    colors: {
                        '--header-bg': '#004d40',
                        '--header-text': '#ffffff',
                        '--accent-color': '#26a69a',
                        '--left-column-bg': '#e0f2f1',
                        '--main-text-color': '#00382e',
                    }
                },
                'graphite-or': {
                    name: 'Graphite & Or',
                    colors: {
                        '--header-bg': '#212121',
                        '--header-text': '#ffffff',
                        '--accent-color': '#fbc02d',
                        '--left-column-bg': '#fafafa',
                        '--main-text-color': '#313131',
                    }
                }
            };

            function applyTheme(themeKey, save = true) {
                const theme = themes[themeKey];
                if (!theme) return;

                const colors = theme.colors;
                for (const [key, value] of Object.entries(colors)) {
                    root.style.setProperty(key, value);
                }

                updateColorPickers(colors);

                if (save) {
                    localStorage.setItem('cv9_theme', themeKey);
                    Object.keys(colors).forEach(key => localStorage.removeItem(`cv9_custom_${key}`));
                }

                themeCards.forEach(c => c.classList.remove('active'));
                const activeCard = document.querySelector(`.theme-card[data-theme="${themeKey}"]`);
                if (activeCard) activeCard.classList.add('active');
            }

            function updateColorPickers(colors) {
                colorPickers.forEach(picker => {
                    const variable = picker.dataset.variable;
                    if (colors[variable]) {
                        picker.value = colors[variable];
                    }
                });
            }

            function applyCustomColor(variable, value) {
                root.style.setProperty(variable, value);
                localStorage.setItem(`cv9_custom_${variable}`, value);
                localStorage.removeItem('cv9_theme');
                themeCards.forEach(c => c.classList.remove('active'));
            }

            function loadSettings() {
                const savedTheme = localStorage.getItem('cv9_theme');
                if (savedTheme && themes[savedTheme]) {
                    applyTheme(savedTheme, false);
                } else {
                    let customColorsApplied = false;
                    colorPickers.forEach(picker => {
                        const variable = picker.dataset.variable;
                        const savedColor = localStorage.getItem(`cv9_custom_${variable}`);
                        if (savedColor) {
                            customColorsApplied = true;
                            root.style.setProperty(variable, savedColor);
                            picker.value = savedColor;
                        }
                    });
                    if (!customColorsApplied) {
                        applyTheme('elegant-marine', false); // Thème par défaut
                    }
                }
            }

            function resetToDefault() {
                // Supprimer toutes les clés de personnalisation
                colorPickers.forEach(picker => {
                    const variable = picker.dataset.variable;
                    localStorage.removeItem(`cv9_custom_${variable}`);
                });
                localStorage.removeItem('cv9_theme');

                // Appliquer le thème par défaut
                applyTheme('elegant-marine', true);
            }

            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    const themeKey = this.dataset.theme;
                    applyTheme(themeKey);
                });
            });

            colorPickers.forEach(picker => {
                picker.addEventListener('input', function () {
                    const variable = this.dataset.variable;
                    const value = this.value;
                    applyCustomColor(variable, value);
                });
            });

            resetButton.addEventListener('click', resetToDefault);

            loadSettings();
        });
    </script>
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
</body>

</html>