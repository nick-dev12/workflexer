<?php
// Démarre la session
session_start();

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
    <link href="https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/model8.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
    <section class="section3">
        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()"
                style="padding: 10px 20px; background-color: #0089be; color: white; border: none; border-radius: 5px; cursor: pointer; margin-bottom: 15px;">Télécharger
                mon CV</button>

            <script>
                // Fonction pour générer un PDF
                function generatePDF() {
                    const element = document.querySelector(".cv-container");
                    const mergedOptions = {
                        filename: 'cv.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                    };
                    html2pdf().set(mergedOptions).from(element).save("cv.pdf");
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
                        <div class="theme-card" data-theme="green">
                            <div class="theme-preview">
                                <div style="background-color: #388e3c; height: 20px;"></div>
                                <div style="background-color: #c8e6c9; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Vert</span>
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
                    </div>
                </div>
            </div>

            <div class="manual-color-options"
                style="margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                <h3 style="text-align: center; margin-bottom: 15px; color: #333; font-size: 18px;">Personnalisation
                    manuelle
                </h3>

                <div class="color-option">
                    <label for="bgColorLeft">Couleur de fond colonne gauche</label>
                    <input type="color" id="bgColorLeft" class="color-picker" data-target="left-column"
                        data-property="background-color" value="#e3f1e2">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="bgColorValue">#e3f1e2</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="textColorLeft">Couleur du texte colonne gauche</label>
                    <input type="color" id="textColorLeft" class="color-picker" data-target="left-column"
                        data-property="color" value="#333333">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="textColorValue">#333333</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="borderColor">Couleur des bordures</label>
                    <input type="color" id="borderColor" class="color-picker" data-target="borders"
                        data-property="border-color" value="#dddddd">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="borderColorValue">#dddddd</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="accentColor">Couleur d'accentuation (titres)</label>
                    <input type="color" id="accentColor" class="color-picker" data-target="accent" data-property="color"
                        value="#333333">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="accentColorValue">#333333</span>
                    </div>
                </div>

                <button id="resetColors"
                    style="width: 100%; margin-top: 15px; padding: 10px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">Réinitialiser
                    les couleurs</button>
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

                /* Ajouter des styles pour la lisibilité des icônes */
                .left-column img {
                    filter: brightness(1);
                    transition: filter 0.3s ease;
                }

                /* Style pour les sélecteurs de couleur */
                .color-picker {
                    border: none;
                    border-radius: 4px;
                    height: 35px;
                    width: 100%;
                    padding: 5px;
                    cursor: pointer;
                    transition: transform 0.2s ease;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .color-picker:hover {
                    transform: scale(1.05);
                }

                .color-option {
                    margin-bottom: 16px;
                }

                .color-option label {
                    display: block;
                    margin-bottom: 8px;
                    font-size: 14px;
                    font-weight: 500;
                    color: #444;
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
                }
            </style>
        </div>

        <div class="cv-container">
            <div class="left-column">
                <h1 class="name-title">PRÉNOM<br>NOM</h1>
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
                    <p>linkedin.com/prénom-nom</p>
                </div>

                <div class="languages">
                    <h3>LANGUES</h3>
                    <?php if (empty($afficheLangue)): ?>
                        <p>Français : Langue maternelle</p>
                        <p>Anglais : Niveau intermédiaire</p>
                        <p>Espagnol : Niveau avancé</p>
                    <?php else: ?>
                        <?php foreach ($afficheLangue as $langues): ?>
                            <p><?= $langues['langue'] ?> : <?= $langues['niveau'] ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="skills">
                    <h3>COMPÉTENCES</h3>
                    <?php if ($competencesUtilisateur): ?>
                        <ul>
                            <?php foreach ($competencesUtilisateur as $competence): ?>
                                <li><?= $competence['competence'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <ul>
                            <li>Sens du travail d'équipe</li>
                            <li>À l'écoute</li>
                            <li>Esprit d'analyse</li>
                            <li>Travail en équipe</li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="right-column">
                <div class="profile">
                    <h3>PROFIL</h3>
                    <?php if (empty($descriptions)): ?>
                        <p>Étudiante en Licence Éco-Gestion, je souhaite approfondir mes études en intégrant votre Master.
                            Cette formation précède des cours et apprentissages qui me permettront d'approfondir
                            spécifiquement mon futur domaine professionnel.</p>
                    <?php else: ?>
                        <p><?= $descriptions['description'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="section">
                    <h3>FORMATION</h3>
                    <?php if (empty($formationUsers)): ?>
                        <div class="education-item">
                            <h4>Licence Éco-Gestion | La Sorbonne</h4>
                            <p class="date">Sept 2020 - Juin 2023 | Paris</p>
                            <p>• Cours de gestion, économie, logiciels, droit...</p>
                            <p>• Licence validée avec mention Bien.</p>
                            <p>• Membre du bureau des étudiants. Réalisation de plusieurs projets et soutien à des
                                associations.</p>
                        </div>
                        <div class="education-item">
                            <h4>Baccalauréat ES</h4>
                            <p class="date">Sept 2020 | Paris</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($formationUsers as $formations): ?>
                            <div class="education-item">
                                <h4><?= $formations['etablissement'] ?></h4>
                                <p class="date">
                                    <?= $formations['moisDebut'] ?>/<?= $formations['anneeDebut'] ?> -
                                    <?= $formations['moisFin'] ?>/<?= $formations['anneeFin'] ?>
                                    <?php if (!empty($formations['ville'])): ?> | <?= $formations['ville'] ?><?php endif; ?>
                                </p>
                                <p><?= $formations['Filiere'] ?> (<?= $formations['niveau'] ?>)</p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="section">
                    <h3>EXPÉRIENCES PROFESSIONNELLES</h3>
                    <?php if (empty($afficheMetier)): ?>
                        <div class="experience-item">
                            <h4>CHARGÉE DE CLIENTÈLE (Stage) | BNP</h4>
                            <p class="date">Janvier 2023 - Avril 2023 | Paris</p>
                            <p>• Mise en place des dossiers clients et réalisation du suivi.</p>
                            <p>• Création et présentation des offres clients et proposition du produit le plus adapté à
                                l'image de marque.</p>
                        </div>
                        <div class="experience-item">
                            <h4>BARISTA | Starbucks</h4>
                            <p class="date">Juin 2022 - Sept 2022 | Paris</p>
                            <p>• Préparation des boissons signatures de la marque et service des clients.</p>
                            <p>• Respect des règles liées à l'hygiène et à la qualité.</p>
                        </div>
                        <div class="experience-item">
                            <h4>AGENTE D'ACCUEIL | Festival d'Avignon</h4>
                            <p class="date">Juin 2021 - Août 2021 | Avignon</p>
                            <p>• Accueil du public et aide au bon déroulement des représentations.</p>
                            <p>• Contrôle des billets et ventes de spectacle.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($afficheMetier as $Metiers): ?>
                            <div class="experience-item">
                                <h4><?= $Metiers['metier'] ?>
                                    <?php if (!empty($Metiers['entreprise'])): ?> | <?= $Metiers['entreprise'] ?><?php endif; ?>
                                </h4>
                                <p class="date">
                                    <?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                    <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?>
                                    <?php if (!empty($Metiers['ville'])): ?> | <?= $Metiers['ville'] ?><?php endif; ?>
                                </p>
                                <p><?= nl2br($Metiers['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Personnalisation manuelle des couleurs -->


    </section>
    <script>
        // JavaScript pour changer les thèmes
        document.addEventListener('DOMContentLoaded', function () {
            const themeCards = document.querySelectorAll('.theme-card');
            const leftColumn = document.querySelector('.left-column');
            const rightColumn = document.querySelector('.right-column');
            const headings = document.querySelectorAll('.section h3');
            const contactHeadings = document.querySelectorAll('.contact h3, .languages h3, .skills h3');
            const experienceHeadings = document.querySelectorAll('.experience-item h4, .education-item h4');
            const colorPickers = document.querySelectorAll('.color-picker');
            const resetButton = document.getElementById('resetColors');
            const allLeftTexts = document.querySelectorAll('.left-column p, .left-column h1, .left-column h3, .left-column li');
            const experienceItems = document.querySelectorAll('.experience-item, .education-item');
            const checkMarks = document.querySelectorAll('.skills ul li:before');
            const leftColumnIcons = document.querySelectorAll('.left-column img');

            // Éléments d'affichage de la valeur des couleurs
            const bgColorValue = document.getElementById('bgColorValue');
            const textColorValue = document.getElementById('textColorValue');
            const borderColorValue = document.getElementById('borderColorValue');
            const accentColorValue = document.getElementById('accentColorValue');

            // Définition des thèmes complets avec couleurs de texte adaptées
            const themes = {
                'classic': {
                    bgColor: '#e6e6e6',
                    textColor: '#333333',
                    borderColor: '#e6e6e6',
                    accentColor: '#555555'
                },
                'professional': {
                    bgColor: '#1D3557',
                    textColor: '#FFFFFF',
                    borderColor: '#457B9D',
                    accentColor: '#E63946'
                },
                'corporate': {
                    bgColor: '#1A237E',
                    textColor: '#FFFFFF',
                    borderColor: '#5C6BC0',
                    accentColor: '#C5CAE9'
                },
                'slate': {
                    bgColor: '#2F4F4F',
                    textColor: '#FFFFFF',
                    borderColor: '#708090',
                    accentColor: '#A9A9A9'
                },
                'green': {
                    bgColor: '#e3f1e2',
                    textColor: '#333333',
                    borderColor: '#dddddd',
                    accentColor: '#333333'
                },
                'creative': {
                    bgColor: '#845EC2',
                    textColor: '#FFFFFF',
                    borderColor: '#B39CD0',
                    accentColor: '#FBEAFF'
                },
                'modern': {
                    bgColor: '#3D5A80',
                    textColor: '#FFFFFF',
                    borderColor: '#98C1D9',
                    accentColor: '#E0FBFC'
                }
            };

            // Fonction pour appliquer un thème et sauvegarder en localStorage
            function applyTheme(theme) {
                const themeColors = themes[theme];

                if (!themeColors) return;

                // Réinitialiser les styles
                resetStyles();

                // Appliquer les couleurs du thème
                leftColumn.style.backgroundColor = themeColors.bgColor;
                leftColumn.style.color = themeColors.textColor;

                // Appliquer la couleur à tous les textes de la colonne gauche
                allLeftTexts.forEach(el => {
                    el.style.color = themeColors.textColor;
                });

                // Appliquer la couleur de bordure aux en-têtes de section
                headings.forEach(h => {
                    h.style.borderBottomColor = themeColors.borderColor;
                });

                // Appliquer les couleurs de bordure aux en-têtes de la colonne gauche
                contactHeadings.forEach(h => {
                    h.style.color = themeColors.textColor;
                });

                // Appliquer la couleur d'accentuation
                experienceHeadings.forEach(h => {
                    h.style.color = themeColors.accentColor;
                });

                // Bordures des items d'expérience et éducation
                experienceItems.forEach(item => {
                    item.style.borderLeftColor = themeColors.borderColor;
                });

                // Ajuster les icônes pour les fonds sombres
                if (isColorDark(themeColors.bgColor)) {
                    document.documentElement.style.setProperty('--skills-checkmark-color', '#FFFFFF');
                    leftColumnIcons.forEach(icon => {
                        icon.style.filter = 'brightness(2) invert(0.2)';
                    });
                } else {
                    document.documentElement.style.setProperty('--skills-checkmark-color', '#333333');
                    leftColumnIcons.forEach(icon => {
                        icon.style.filter = 'brightness(1)';
                    });
                }

                // Mettre à jour les valeurs des color pickers
                document.getElementById('bgColorLeft').value = themeColors.bgColor;
                document.getElementById('textColorLeft').value = themeColors.textColor;
                document.getElementById('borderColor').value = themeColors.borderColor;
                document.getElementById('accentColor').value = themeColors.accentColor;

                // Mettre à jour les valeurs affichées
                updateColorDisplays(themeColors.bgColor, themeColors.textColor, themeColors.borderColor, themeColors.accentColor);

                // Sauvegarder le thème dans localStorage
                localStorage.setItem('cv8_theme', theme);
                saveColorSettings(themeColors);
            }

            // Fonction pour mettre à jour les valeurs affichées des couleurs
            function updateColorDisplays(bg, text, border, accent) {
                if (bgColorValue) bgColorValue.textContent = bg;
                if (textColorValue) textColorValue.textContent = text;
                if (borderColorValue) borderColorValue.textContent = border;
                if (accentColorValue) accentColorValue.textContent = accent;
            }

            // Déterminer si une couleur est sombre (pour adapter le texte)
            function isColorDark(color) {
                // Convertir la couleur hex en RGB
                const r = parseInt(color.substring(1, 3), 16);
                const g = parseInt(color.substring(3, 5), 16);
                const b = parseInt(color.substring(5, 7), 16);

                // Calcul de la luminosité (formule standard)
                const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

                // Retourne true si la couleur est sombre
                return luminance < 0.6;
            }

            // Sauvegarder les couleurs personnalisées
            function saveColorSettings(colors) {
                localStorage.setItem('cv8_bgColor', colors.bgColor);
                localStorage.setItem('cv8_textColor', colors.textColor);
                localStorage.setItem('cv8_borderColor', colors.borderColor);
                localStorage.setItem('cv8_accentColor', colors.accentColor);
            }

            // Fonction pour appliquer les couleurs personnalisées
            function applyCustomColors() {
                const bgColor = localStorage.getItem('cv8_bgColor') || '#e3f1e2';
                const textColor = localStorage.getItem('cv8_textColor') || '#333333';
                const borderColor = localStorage.getItem('cv8_borderColor') || '#dddddd';
                const accentColor = localStorage.getItem('cv8_accentColor') || '#333333';

                // Appliquer les couleurs personnalisées
                leftColumn.style.backgroundColor = bgColor;
                leftColumn.style.color = textColor;

                // Appliquer la couleur à tous les textes de la colonne gauche
                allLeftTexts.forEach(el => {
                    el.style.color = textColor;
                });

                headings.forEach(h => {
                    h.style.borderBottomColor = borderColor;
                });

                contactHeadings.forEach(h => {
                    h.style.color = textColor;
                });

                experienceHeadings.forEach(h => {
                    h.style.color = accentColor;
                });

                experienceItems.forEach(item => {
                    item.style.borderLeftColor = borderColor;
                });

                // Ajuster les icônes pour les fonds sombres
                if (isColorDark(bgColor)) {
                    document.documentElement.style.setProperty('--skills-checkmark-color', '#FFFFFF');
                    leftColumnIcons.forEach(icon => {
                        icon.style.filter = 'brightness(2) invert(0.2)';
                    });
                } else {
                    document.documentElement.style.setProperty('--skills-checkmark-color', '#333333');
                    leftColumnIcons.forEach(icon => {
                        icon.style.filter = 'brightness(1)';
                    });
                }

                // Mettre à jour les couleurs des pickers
                document.getElementById('bgColorLeft').value = bgColor;
                document.getElementById('textColorLeft').value = textColor;
                document.getElementById('borderColor').value = borderColor;
                document.getElementById('accentColor').value = accentColor;

                // Mettre à jour les valeurs affichées
                updateColorDisplays(bgColor, textColor, borderColor, accentColor);
            }

            // Fonction pour réinitialiser tous les styles
            function resetStyles() {
                leftColumn.removeAttribute('style');
                rightColumn.removeAttribute('style');
                headings.forEach(h => h.removeAttribute('style'));
                contactHeadings.forEach(h => h.removeAttribute('style'));
                experienceHeadings.forEach(h => h.removeAttribute('style'));
                allLeftTexts.forEach(el => el.removeAttribute('style'));
                leftColumnIcons.forEach(icon => icon.removeAttribute('style'));
                document.documentElement.style.removeProperty('--skills-checkmark-color');

                experienceItems.forEach(item => {
                    item.removeAttribute('style');
                });
            }

            // Gestionnaires d'événements pour les sélecteurs de thème
            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Supprimer la classe active de toutes les cartes
                    themeCards.forEach(c => c.classList.remove('active'));

                    // Ajouter la classe active à la carte cliquée
                    this.classList.add('active');

                    // Appliquer le thème en fonction de l'attribut data-theme
                    const theme = this.getAttribute('data-theme');
                    applyTheme(theme);
                });
            });

            // Gestionnaires d'événements pour les color pickers
            colorPickers.forEach(picker => {
                picker.addEventListener('input', function () {
                    const target = this.getAttribute('data-target');
                    const property = this.getAttribute('data-property');
                    const value = this.value;

                    if (target === 'left-column') {
                        if (property === 'background-color') {
                            leftColumn.style.backgroundColor = value;
                            localStorage.setItem('cv8_bgColor', value);

                            // Adapter automatiquement la couleur du texte si le fond est sombre
                            if (isColorDark(value)) {
                                document.documentElement.style.setProperty('--skills-checkmark-color', '#FFFFFF');
                                leftColumnIcons.forEach(icon => {
                                    icon.style.filter = 'brightness(2) invert(0.2)';
                                });
                            } else {
                                document.documentElement.style.setProperty('--skills-checkmark-color', '#333333');
                                leftColumnIcons.forEach(icon => {
                                    icon.style.filter = 'brightness(1)';
                                });
                            }

                            // Mettre à jour la valeur affichée
                            if (bgColorValue) bgColorValue.textContent = value;

                        } else if (property === 'color') {
                            leftColumn.style.color = value;

                            // Appliquer à tous les textes de la colonne gauche
                            allLeftTexts.forEach(el => {
                                el.style.color = value;
                            });

                            contactHeadings.forEach(h => {
                                h.style.color = value;
                                h.style.borderBottomColor = value;
                            });
                            localStorage.setItem('cv8_textColor', value);

                            // Mettre à jour la valeur affichée
                            if (textColorValue) textColorValue.textContent = value;
                        }
                    } else if (target === 'borders') {
                        headings.forEach(h => {
                            h.style.borderBottomColor = value;
                        });

                        experienceItems.forEach(item => {
                            item.style.borderLeftColor = value;
                        });

                        localStorage.setItem('cv8_borderColor', value);

                        // Mettre à jour la valeur affichée
                        if (borderColorValue) borderColorValue.textContent = value;

                    } else if (target === 'accent') {
                        experienceHeadings.forEach(h => {
                            h.style.color = value;
                        });

                        localStorage.setItem('cv8_accentColor', value);

                        // Mettre à jour la valeur affichée
                        if (accentColorValue) accentColorValue.textContent = value;
                    }

                    // Désactiver la sélection de thème
                    themeCards.forEach(c => c.classList.remove('active'));
                    localStorage.removeItem('cv8_theme');
                });
            });

            // Gestionnaire d'événement pour réinitialiser les couleurs
            resetButton.addEventListener('click', function () {
                localStorage.removeItem('cv8_theme');
                localStorage.removeItem('cv8_bgColor');
                localStorage.removeItem('cv8_textColor');
                localStorage.removeItem('cv8_borderColor');
                localStorage.removeItem('cv8_accentColor');

                resetStyles();

                // Réinitialiser les couleurs des pickers
                document.getElementById('bgColorLeft').value = '#e3f1e2';
                document.getElementById('textColorLeft').value = '#333333';
                document.getElementById('borderColor').value = '#dddddd';
                document.getElementById('accentColor').value = '#333333';

                // Mettre à jour les valeurs affichées
                updateColorDisplays('#e3f1e2', '#333333', '#dddddd', '#333333');

                // Définir le thème par défaut (vert)
                document.querySelector('[data-theme="green"]').classList.add('active');
                applyTheme('green');
            });

            // Au chargement de la page, vérifier s'il y a un thème sauvegardé
            const savedTheme = localStorage.getItem('cv8_theme');

            if (savedTheme) {
                // Appliquer le thème sauvegardé
                const themeCard = document.querySelector(`[data-theme="${savedTheme}"]`);
                if (themeCard) {
                    themeCard.classList.add('active');
                    applyTheme(savedTheme);
                }
            } else if (localStorage.getItem('cv8_bgColor')) {
                // Appliquer les couleurs personnalisées sauvegardées
                applyCustomColors();
            } else {
                // Définir le thème par défaut (vert)
                document.querySelector('[data-theme="green"]').classList.add('active');
                applyTheme('green');
            }
        });
    </script>
</body>

</html>