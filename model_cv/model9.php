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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/model9.css">
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
                        <div class="theme-card" data-theme="default">
                            <div class="theme-preview">
                                <div style="background-color: #14396e; height: 20px;"></div>
                                <div style="background-color: #3498db; height: 20px;"></div>
                                <div style="background-color: #F5F5F5; height: 20px;"></div>
                            </div>
                            <span>Marine</span>
                        </div>
                        <div class="theme-card" data-theme="slate">
                            <div class="theme-preview">
                                <div style="background-color: #1a5276; height: 20px;"></div>
                                <div style="background-color: #2e86c1; height: 20px;"></div>
                                <div style="background-color: #F5F5F5; height: 20px;"></div>
                            </div>
                            <span>Bleu Nuit</span>
                        </div>
                        <div class="theme-card" data-theme="corporate">
                            <div class="theme-preview">
                                <div style="background-color: #424949; height: 20px;"></div>
                                <div style="background-color: #7f8c8d; height: 20px;"></div>
                                <div style="background-color: #F5F5F5; height: 20px;"></div>
                            </div>
                            <span>Gris</span>
                        </div>
                    </div>

                    <h4>Couleurs vives</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="green">
                            <div class="theme-preview">
                                <div style="background-color: #186a3b; height: 20px;"></div>
                                <div style="background-color: #58d68d; height: 20px;"></div>
                                <div style="background-color: #F5F5F5; height: 20px;"></div>
                            </div>
                            <span>Vert</span>
                        </div>
                        <div class="theme-card" data-theme="red">
                            <div class="theme-preview">
                                <div style="background-color: #922b21; height: 20px;"></div>
                                <div style="background-color: #e74c3c; height: 20px;"></div>
                                <div style="background-color: #F5F5F5; height: 20px;"></div>
                            </div>
                            <span>Rouge</span>
                        </div>
                        <div class="theme-card" data-theme="purple">
                            <div class="theme-preview">
                                <div style="background-color: #4a235a; height: 20px;"></div>
                                <div style="background-color: #a569bd; height: 20px;"></div>
                                <div style="background-color: #F5F5F5; height: 20px;"></div>
                            </div>
                            <span>Violet</span>
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
                    <label for="headerColor">Couleur de l'en-tête</label>
                    <input type="color" id="headerColor" class="color-picker" data-target="header"
                        data-property="background-color" value="#14396e">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="headerColorValue">#14396e</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="textColor">Couleur du texte de l'en-tête</label>
                    <input type="color" id="textColor" class="color-picker" data-target="header-text"
                        data-property="color" value="#ffffff">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="textColorValue">#ffffff</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="accentColor">Couleur des titres et accents</label>
                    <input type="color" id="accentColor" class="color-picker" data-target="accent" data-property="color"
                        value="#14396e">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="accentColorValue">#14396e</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="bgColorLeft">Couleur de fond colonne gauche</label>
                    <input type="color" id="bgColorLeft" class="color-picker" data-target="left-column"
                        data-property="background-color" value="#f5f5f5">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="bgColorValue">#f5f5f5</span>
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
                    width: calc(33.33% - 12px);
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

        <div class="cv-container">
            <!-- En-tête du CV avec photo et présentation -->
            <div class="cv-header">
                <div class="header-content">
                    <h1 class="name-title">
                        <?= isset($userss['prenom'], $userss['nom']) ? $userss['prenom'] . " " . $userss['nom'] : "Albert DUMON" ?>
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
                            <?php if (!empty($afficheOutil)): ?>

                                <?php foreach ($afficheOutil as $index => $outil): ?>
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

                    <div class="section">
                        <h3 class="section-title">ACTIVITÉS SOCIALES</h3>
                        <ul class="activities-list">
                            <?php if (!empty($afficheCentres)): ?>
                                <?php foreach ($afficheCentres as $centre): ?>
                                    <li><img src="../image/interests.png" alt="Intérêt"><?= $centre['centre'] ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune activité trouvée</p>
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
                            <?php foreach ($afficheMetier as $Metiers): ?>
                                <div class="experience-item">
                                    <h4><?= $Metiers['metier'] ?></h4>
                                    <p class="date"><img src="../image/position.png"
                                            alt="Date"><?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                        <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?>
                                    </p>
                                    <ul>
                                        <?php
                                        $description = nl2br($Metiers['description']);
                                        $points = explode('<br />', $description);
                                        foreach ($points as $point) {
                                            $point = trim($point);
                                            if (!empty($point)) {
                                                echo "<li>" . $point . "</li>";
                                            }
                                        }
                                        ?>
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
                            <?php foreach ($formationUsers as $formations): ?>
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

                    <div class="section skills-section">
                        <h3 class="section-title">COMPÉTENCES</h3>
                        <ul class="skills-list">
                            <?php if ($competencesUtilisateur): ?>
                                <?php foreach ($competencesUtilisateur as $index => $competence): ?>
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
            </div>
        </div>
    </section>

    <script>
        // JavaScript pour changer les thèmes
        document.addEventListener('DOMContentLoaded', function () {
            const themeCards = document.querySelectorAll('.theme-card');
            const header = document.querySelector('.cv-header');
            const leftColumn = document.querySelector('.left-column');
            const sectionTitles = document.querySelectorAll('.section-title');
            const skillLevels = document.querySelectorAll('.skill-level');
            const dots = document.querySelectorAll('.level-dot:not(.empty)');
            const emptyDots = document.querySelectorAll('.level-dot.empty');
            const colorPickers = document.querySelectorAll('.color-picker');
            const resetButton = document.getElementById('resetColors');

            // Éléments d'affichage de la valeur des couleurs
            const headerColorValue = document.getElementById('headerColorValue');
            const textColorValue = document.getElementById('textColorValue');
            const accentColorValue = document.getElementById('accentColorValue');
            const bgColorValue = document.getElementById('bgColorValue');

            // Définition des thèmes complets avec couleurs
            const themes = {
                'default': {
                    headerColor: '#14396e',
                    headerTextColor: '#FFFFFF',
                    accentColor: '#14396e',
                    bgLeftColor: '#f5f5f5'
                },
                'slate': {
                    headerColor: '#1a5276',
                    headerTextColor: '#FFFFFF',
                    accentColor: '#1a5276',
                    bgLeftColor: '#f5f5f5'
                },
                'corporate': {
                    headerColor: '#424949',
                    headerTextColor: '#FFFFFF',
                    accentColor: '#424949',
                    bgLeftColor: '#f5f5f5'
                },
                'green': {
                    headerColor: '#186a3b',
                    headerTextColor: '#FFFFFF',
                    accentColor: '#186a3b',
                    bgLeftColor: '#f5f5f5'
                },
                'red': {
                    headerColor: '#922b21',
                    headerTextColor: '#FFFFFF',
                    accentColor: '#922b21',
                    bgLeftColor: '#f5f5f5'
                },
                'purple': {
                    headerColor: '#4a235a',
                    headerTextColor: '#FFFFFF',
                    accentColor: '#4a235a',
                    bgLeftColor: '#f5f5f5'
                }
            };

            // Fonction pour appliquer un thème et sauvegarder en localStorage
            function applyTheme(theme) {
                const themeColors = themes[theme];

                if (!themeColors) return;

                // Réinitialiser les styles
                resetStyles();

                // Appliquer les couleurs du thème
                header.style.backgroundColor = themeColors.headerColor;
                header.style.color = themeColors.headerTextColor;
                leftColumn.style.backgroundColor = themeColors.bgLeftColor;

                // Appliquer les couleurs des titres et accents
                sectionTitles.forEach(title => {
                    title.style.color = themeColors.accentColor;
                    title.style.borderBottomColor = themeColors.accentColor;
                });

                skillLevels.forEach(level => {
                    level.style.backgroundColor = themeColors.accentColor;
                });

                dots.forEach(dot => {
                    dot.style.backgroundColor = themeColors.accentColor;
                });

                emptyDots.forEach(dot => {
                    dot.style.borderColor = themeColors.accentColor;
                });

                // Mettre à jour les valeurs des color pickers
                document.getElementById('headerColor').value = themeColors.headerColor;
                document.getElementById('textColor').value = themeColors.headerTextColor;
                document.getElementById('accentColor').value = themeColors.accentColor;
                document.getElementById('bgColorLeft').value = themeColors.bgLeftColor;

                // Mettre à jour les valeurs affichées
                updateColorDisplays(themeColors.headerColor, themeColors.headerTextColor, themeColors.accentColor, themeColors.bgLeftColor);

                // Sauvegarder le thème dans localStorage
                localStorage.setItem('cv9_theme', theme);
                saveColorSettings(themeColors);
            }

            // Fonction pour mettre à jour les valeurs affichées des couleurs
            function updateColorDisplays(headerColor, textColor, accentColor, bgLeftColor) {
                if (headerColorValue) headerColorValue.textContent = headerColor;
                if (textColorValue) textColorValue.textContent = textColor;
                if (accentColorValue) accentColorValue.textContent = accentColor;
                if (bgColorValue) bgColorValue.textContent = bgLeftColor;
            }

            // Sauvegarder les couleurs personnalisées
            function saveColorSettings(colors) {
                localStorage.setItem('cv9_headerColor', colors.headerColor);
                localStorage.setItem('cv9_headerTextColor', colors.headerTextColor);
                localStorage.setItem('cv9_accentColor', colors.accentColor);
                localStorage.setItem('cv9_bgLeftColor', colors.bgLeftColor);
            }

            // Fonction pour appliquer les couleurs personnalisées
            function applyCustomColors() {
                const headerColor = localStorage.getItem('cv9_headerColor') || '#14396e';
                const headerTextColor = localStorage.getItem('cv9_headerTextColor') || '#FFFFFF';
                const accentColor = localStorage.getItem('cv9_accentColor') || '#14396e';
                const bgLeftColor = localStorage.getItem('cv9_bgLeftColor') || '#f5f5f5';

                // Appliquer les couleurs personnalisées
                header.style.backgroundColor = headerColor;
                header.style.color = headerTextColor;
                leftColumn.style.backgroundColor = bgLeftColor;

                sectionTitles.forEach(title => {
                    title.style.color = accentColor;
                    title.style.borderBottomColor = accentColor;
                });

                skillLevels.forEach(level => {
                    level.style.backgroundColor = accentColor;
                });

                dots.forEach(dot => {
                    dot.style.backgroundColor = accentColor;
                });

                emptyDots.forEach(dot => {
                    dot.style.borderColor = accentColor;
                });

                // Mettre à jour les couleurs des pickers
                document.getElementById('headerColor').value = headerColor;
                document.getElementById('textColor').value = headerTextColor;
                document.getElementById('accentColor').value = accentColor;
                document.getElementById('bgColorLeft').value = bgLeftColor;

                // Mettre à jour les valeurs affichées
                updateColorDisplays(headerColor, headerTextColor, accentColor, bgLeftColor);
            }

            // Fonction pour réinitialiser tous les styles
            function resetStyles() {
                header.removeAttribute('style');
                leftColumn.removeAttribute('style');
                sectionTitles.forEach(title => title.removeAttribute('style'));
                skillLevels.forEach(level => level.removeAttribute('style'));
                dots.forEach(dot => dot.removeAttribute('style'));
                emptyDots.forEach(dot => dot.removeAttribute('style'));
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

                    if (target === 'header') {
                        header.style.backgroundColor = value;
                        localStorage.setItem('cv9_headerColor', value);
                        if (headerColorValue) headerColorValue.textContent = value;

                    } else if (target === 'header-text') {
                        header.style.color = value;
                        localStorage.setItem('cv9_headerTextColor', value);
                        if (textColorValue) textColorValue.textContent = value;

                    } else if (target === 'accent') {
                        sectionTitles.forEach(title => {
                            title.style.color = value;
                            title.style.borderBottomColor = value;
                        });

                        skillLevels.forEach(level => {
                            level.style.backgroundColor = value;
                        });

                        dots.forEach(dot => {
                            dot.style.backgroundColor = value;
                        });

                        emptyDots.forEach(dot => {
                            dot.style.borderColor = value;
                        });

                        localStorage.setItem('cv9_accentColor', value);
                        if (accentColorValue) accentColorValue.textContent = value;

                    } else if (target === 'left-column') {
                        leftColumn.style.backgroundColor = value;
                        localStorage.setItem('cv9_bgLeftColor', value);
                        if (bgColorValue) bgColorValue.textContent = value;
                    }

                    // Désactiver la sélection de thème
                    themeCards.forEach(c => c.classList.remove('active'));
                    localStorage.removeItem('cv9_theme');
                });
            });

            // Gestionnaire d'événement pour réinitialiser les couleurs
            resetButton.addEventListener('click', function () {
                localStorage.removeItem('cv9_theme');
                localStorage.removeItem('cv9_headerColor');
                localStorage.removeItem('cv9_headerTextColor');
                localStorage.removeItem('cv9_accentColor');
                localStorage.removeItem('cv9_bgLeftColor');

                resetStyles();

                // Réinitialiser les couleurs des pickers
                document.getElementById('headerColor').value = '#14396e';
                document.getElementById('textColor').value = '#FFFFFF';
                document.getElementById('accentColor').value = '#14396e';
                document.getElementById('bgColorLeft').value = '#f5f5f5';

                // Mettre à jour les valeurs affichées
                updateColorDisplays('#14396e', '#FFFFFF', '#14396e', '#f5f5f5');

                // Définir le thème par défaut
                document.querySelector('[data-theme="default"]').classList.add('active');
                applyTheme('default');
            });

            // Au chargement de la page, vérifier s'il y a un thème sauvegardé
            const savedTheme = localStorage.getItem('cv9_theme');

            if (savedTheme) {
                // Appliquer le thème sauvegardé
                const themeCard = document.querySelector(`[data-theme="${savedTheme}"]`);
                if (themeCard) {
                    themeCard.classList.add('active');
                    applyTheme(savedTheme);
                }
            } else if (localStorage.getItem('cv9_headerColor')) {
                // Appliquer les couleurs personnalisées sauvegardées
                applyCustomColors();
            } else {
                // Définir le thème par défaut
                document.querySelector('[data-theme="default"]').classList.add('active');
                applyTheme('default');
            }
        });
    </script>
</body>

</html>