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
    <title>Model10</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/model10.css">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
    <section class="section3">
        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <script>
                function generatePDF() {
                    const { jsPDF } = window.jspdf;
                    const element = document.querySelector(".cv10");

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
                                <div style="background-color: #008080; height: 20px;"></div>
                                <div style="background-color: #ebf5f7; height: 20px;"></div>
                                <div style="background-color: #ffffff; height: 20px;"></div>
                            </div>
                            <span>Classique</span>
                        </div>
                        <div class="theme-card" data-theme="professional">
                            <div class="theme-preview">
                                <div style="background-color: #1D3557; height: 20px;"></div>
                                <div style="background-color: #e3f0f7; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Marine</span>
                        </div>
                        <div class="theme-card" data-theme="corporate">
                            <div class="theme-preview">
                                <div style="background-color: #1A237E; height: 20px;"></div>
                                <div style="background-color: #e8eaf6; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Corporate</span>
                        </div>
                        <div class="theme-card" data-theme="slate">
                            <div class="theme-preview">
                                <div style="background-color: #2F4F4F; height: 20px;"></div>
                                <div style="background-color: #e0e5e8; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Ardoise</span>
                        </div>
                    </div>

                    <h4>Couleurs vives</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="elegant">
                            <div class="theme-preview">
                                <div style="background-color: #0E3B43; height: 20px;"></div>
                                <div style="background-color: #e0f2f1; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Émeraude</span>
                        </div>
                        <div class="theme-card" data-theme="creative">
                            <div class="theme-preview">
                                <div style="background-color: #845EC2; height: 20px;"></div>
                                <div style="background-color: #f3e5f5; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Violet</span>
                        </div>
                        <div class="theme-card" data-theme="modern">
                            <div class="theme-preview">
                                <div style="background-color: #3D5A80; height: 20px;"></div>
                                <div style="background-color: #e0f7fa; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Océan</span>
                        </div>
                        <div class="theme-card" data-theme="mint">
                            <div class="theme-preview">
                                <div style="background-color: #21897E; height: 20px;"></div>
                                <div style="background-color: #e0f2f1; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Menthe</span>
                        </div>
                    </div>

                    <h4>Tons chauds</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="earthy">
                            <div class="theme-preview">
                                <div style="background-color: #5F4B32; height: 20px;"></div>
                                <div style="background-color: #efebe9; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Terracotta</span>
                        </div>
                        <div class="theme-card" data-theme="burgundy">
                            <div class="theme-preview">
                                <div style="background-color: #800020; height: 20px;"></div>
                                <div style="background-color: #f8eaed; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Bordeaux</span>
                        </div>
                        <div class="theme-card" data-theme="amber">
                            <div class="theme-preview">
                                <div style="background-color: #B86E00; height: 20px;"></div>
                                <div style="background-color: #fff8e1; height: 20px;"></div>
                                <div style="background-color: #FFFFFF; height: 20px;"></div>
                            </div>
                            <span>Ambre</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="manual-color-options">
                <h3>Personnalisation manuelle</h3>

                <div class="color-option">
                    <label for="headerColor">Couleur d'en-tête</label>
                    <input type="color" id="headerColor" class="color-picker" value="#008080">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="headerColorValue">#008080</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="sidebarColor">Couleur de la barre latérale</label>
                    <input type="color" id="sidebarColor" class="color-picker" value="#ebf5f7">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="sidebarColorValue">#ebf5f7</span>
                    </div>
                </div>

                <div class="color-option">
                    <label for="accentColor">Couleur des titres et accents</label>
                    <input type="color" id="accentColor" class="color-picker" value="#333333">
                    <div class="color-preview" style="margin-top: 5px; font-size: 12px; color: #666;">
                        Valeur: <span id="accentColorValue">#333333</span>
                    </div>
                </div>

                <button id="resetColors">Réinitialiser les couleurs</button>
            </div>
        </div>

        <div class="container-model">
            <div class="cv10">
                <!-- Header with photo and name -->
                <div class="cv-header">
                    <div class="profile-photo-container">
                        <img src="../upload/<?= $userss['images'] ? $userss['images'] : 'default-profile.jpg' ?>"
                            alt="Photo de profil" class="profile-photo">
                    </div>
                    <div class="header-text">
                        <h1 class="prenom"><?= isset($userss['prenom']) ?></h1>
                        <h1 class="nom"><?= isset($userss['nom']) ? $userss['nom'] : "NOM" ?></h1>
                        <p class="post"><?= $userss['competences'] ?></p>
                    </div>
                </div>

                <!-- CV body with two columns -->
                <div class="cv-body">
                    <!-- Left sidebar with contact info and skills -->
                    <div class="left-sidebar">
                        <div class="contact-section">
                            <h2>CONTACT</h2>
                            <div class="contact-info">
                                <p><span class="icon email-icon"></span>
                                    <?= $userss['mail'] ?? "prenom.nom@gmail.com" ?>
                                </p>
                                <p><span class="icon phone-icon"></span> <?= $userss['phone'] ?? "+33 6 66 66 66 66" ?>
                                </p>
                                <p><span class="icon location-icon"></span> <?= $userss['ville'] ?? "Ville, Pays" ?></p>
                                <p><span class="icon linkedin-icon"></span> url.linkedin</p>
                            </div>
                        </div>

                        <div class="profile-section">
                            <h2>MON PROFIL</h2>
                            <p class="profile-text">
                                <?php if (empty($descriptions)): ?>
                                <p>Aucune description trouvée</p>
                            <?php else: ?>
                                <?= $descriptions['description'] ?>
                            <?php endif; ?>
                            </p>
                        </div>

                        <div class="skills-section">
                            <h2>LOGICIELS</h2>
                            <ul>
                                <?php if (!empty($afficheOutilLimit5)): ?>
                                    <?php foreach ($afficheOutilLimit5 as $outil): ?>
                                        <li><span class="checkmark">✓</span> <?= $outil['outil'] ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucun logiciel trouvé</p>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="languages-section">
                            <h2>LANGUES</h2>
                            <ul>
                                <?php if (empty($afficheLangue)): ?>
                                    <p>Aucune langue trouvée</p>
                                <?php else: ?>
                                    <?php foreach ($afficheLangue as $langue): ?>
                                        <li><span class="checkmark">✓</span> <?= $langue['langue'] ?> : <?= $langue['niveau'] ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Main content with experience, education, etc. -->
                    <div class="main-content">
                        <div class="experiences-section">
                            <h2>EXPÉRIENCES PROFESSIONNELLES</h2>

                            <?php if (empty($afficheMetier)): ?>
                                <p>Aucune expérience professionnelle trouvée</p>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 3;
                                ?>
                                <?php foreach ($afficheMetier as $key => $metier): ?>
                                    <?php if ($key < $nombre_metier): ?> <div class="experience-item">
                                            <h3><?= strtoupper($metier['metier']) ?></h3>
                                            <p class="job-location">
                                                <?= $metier['moisDebut'] ?>/<?= $metier['anneeDebut'] ?> -
                                                <?= $metier['moisFin'] ?>/<?= $metier['anneeFin'] ?>
                                                </p>
                                                <ul class="job-description">
                                                    <?php
                                                    $description = nl2br($metier['description']);
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
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>



                    <div class="education-section">
                        <h2>FORMATION</h2>

                        <?php if (empty($formationUsers)): ?>
                            <p>Aucune formation trouvée</p>
                        <?php else: ?>
                            <?php
                            shuffle($formationUsers);
                            $nombre_formation = 3;
                            ?>
                            <?php foreach ($formationUsers as $key => $formation): ?>
                                <?php if ($key < $nombre_formation): ?>
                                        <div class="education-item">
                                            <h3><?= strtoupper($formation['etablissement'] ?? 'DIPLÔME OU ÉTUDES') ?></h3>
                                            <p class="education-location">
                                                <?= $formation['moisDebut'] ?>/<?= $formation['anneeDebut'] ?> -
                                                <?= $formation['moisFin'] ?>/<?= $formation['anneeFin'] ?>
                                            </p>
                                            <p class="education-school"><?= $formation['Filiere'] ?> (<?= $formation['niveau'] ?>)
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                            <?php endif; ?>
                    </div>

                    <div class="competences-section">
                        <h2>COMPÉTENCES</h2>
                        <?php if (!empty($competencesUtilisateurLimit7)): ?>
                            <div class="competences-grid">
                                <?php foreach ($competencesUtilisateurLimit7 as $competence): ?>
                                    <div class="competence-item">
                                        <span class="competence-name"><?= $competence['competence'] ?></span>
                                        <?php
                                        // Afficher le niveau de compétence avec des points
                                        $niveau = isset($competence['niveau']) ? intval($competence['niveau']) : 4;
                                        echo '<div class="competence-level">';
                                        for ($i = 1; $i <= 4; $i++) {
                                            if ($i <= $niveau) {
                                                echo '<span class="dot filled"></span>';
                                            } else {
                                                echo '<span class="dot"></span>';
                                            }
                                        }
                                        echo '</div>';
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="competences-grid">
                                <div class="competence-item">
                                    <span class="competence-name">Travail d'équipe</span>
                                    <div class="competence-level">
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot"></span>
                                    </div>
                                </div>
                                <div class="competence-item">
                                    <span class="competence-name">Communication</span>
                                    <div class="competence-level">
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                    </div>
                                </div>
                                <div class="competence-item">
                                    <span class="competence-name">Gestion de projet</span>
                                    <div class="competence-level">
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                    </div>
                                </div>
                                <div class="competence-item">
                                    <span class="competence-name">Analyse de données</span>
                                    <div class="competence-level">
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot filled"></span>
                                        <span class="dot"></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeCards = document.querySelectorAll('.theme-card');
            const headerColorPicker = document.getElementById('headerColor');
            const sidebarColorPicker = document.getElementById('sidebarColor');
            const accentColorPicker = document.getElementById('accentColor');
            const resetButton = document.getElementById('resetColors');

            // Éléments d'affichage de la valeur des couleurs
            const headerColorValue = document.getElementById('headerColorValue');
            const sidebarColorValue = document.getElementById('sidebarColorValue');
            const accentColorValue = document.getElementById('accentColorValue');

            // Définition des thèmes
            const themes = {
                'classic': {
                    headerBg: '#008080',
                    sidebarBg: '#ebf5f7',
                    mainBg: '#ffffff',
                    textColor: '#333333',
                    accentColor: '#333333'
                },
                'professional': {
                    headerBg: '#1D3557',
                    sidebarBg: '#e3f0f7',
                    mainBg: '#ffffff',
                    textColor: '#1D3557',
                    accentColor: '#1D3557'
                },
                'corporate': {
                    headerBg: '#1A237E',
                    sidebarBg: '#e8eaf6',
                    mainBg: '#ffffff',
                    textColor: '#1A237E',
                    accentColor: '#1A237E'
                },
                'slate': {
                    headerBg: '#2F4F4F',
                    sidebarBg: '#e0e5e8',
                    mainBg: '#ffffff',
                    textColor: '#2F4F4F',
                    accentColor: '#2F4F4F'
                },
                'elegant': {
                    headerBg: '#0E3B43',
                    sidebarBg: '#e0f2f1',
                    mainBg: '#ffffff',
                    textColor: '#0E3B43',
                    accentColor: '#0E3B43'
                },
                'creative': {
                    headerBg: '#845EC2',
                    sidebarBg: '#f3e5f5',
                    mainBg: '#ffffff',
                    textColor: '#845EC2',
                    accentColor: '#845EC2'
                },
                'modern': {
                    headerBg: '#3D5A80',
                    sidebarBg: '#e0f7fa',
                    mainBg: '#ffffff',
                    textColor: '#3D5A80',
                    accentColor: '#3D5A80'
                },
                'mint': {
                    headerBg: '#21897E',
                    sidebarBg: '#e0f2f1',
                    mainBg: '#ffffff',
                    textColor: '#21897E',
                    accentColor: '#21897E'
                },
                'earthy': {
                    headerBg: '#5F4B32',
                    sidebarBg: '#efebe9',
                    mainBg: '#ffffff',
                    textColor: '#5F4B32',
                    accentColor: '#5F4B32'
                },
                'burgundy': {
                    headerBg: '#800020',
                    sidebarBg: '#f8eaed',
                    mainBg: '#ffffff',
                    textColor: '#800020',
                    accentColor: '#800020'
                },
                'amber': {
                    headerBg: '#B86E00',
                    sidebarBg: '#fff8e1',
                    mainBg: '#ffffff',
                    textColor: '#B86E00',
                    accentColor: '#B86E00'
                }
            };

            // Mettre à jour les valeurs affichées
            function updateColorValues(headerColor, sidebarColor, accentColor) {
                if (headerColorValue) headerColorValue.textContent = headerColor;
                if (sidebarColorValue) sidebarColorValue.textContent = sidebarColor;
                if (accentColorValue) accentColorValue.textContent = accentColor;

                // Mettre à jour les pickers
                headerColorPicker.value = headerColor;
                sidebarColorPicker.value = sidebarColor;
                accentColorPicker.value = accentColor;
            }

            // Sauvegarder les couleurs personnalisées
            function saveCustomColors(headerColor, sidebarColor, accentColor) {
                localStorage.setItem('cv10_headerColor', headerColor);
                localStorage.setItem('cv10_sidebarColor', sidebarColor);
                localStorage.setItem('cv10_accentColor', accentColor);
            }

            // Application du thème
            function applyTheme(themeName) {
                const theme = themes[themeName];
                if (!theme) return;

                const cvHeader = document.querySelector('.cv-header');
                const leftSidebar = document.querySelector('.left-sidebar');
                const mainContent = document.querySelector('.main-content');
                const headings = document.querySelectorAll('h2');
                const prenom = document.querySelector('.prenom');
                const nom = document.querySelector('.nom');
                const post = document.querySelector('.post');

                cvHeader.style.backgroundColor = theme.headerBg;
                leftSidebar.style.backgroundColor = theme.sidebarBg;
                mainContent.style.backgroundColor = theme.mainBg;

                // Make sure header text is white
                prenom.style.color = "#ffffff";
                nom.style.color = "#ffffff";
                post.style.color = "#ffffff";

                headings.forEach(heading => {
                    heading.style.borderBottomColor = theme.accentColor;
                    heading.style.color = theme.textColor;
                });

                // Mettre à jour les valeurs affichées
                updateColorValues(theme.headerBg, theme.sidebarBg, theme.accentColor);

                // Sauvegarder le thème dans localStorage
                localStorage.setItem('cv10_theme', themeName);
                saveCustomColors(theme.headerBg, theme.sidebarBg, theme.accentColor);
            }

            // Application de couleurs personnalisées
            function applyCustomColors() {
                const headerColor = localStorage.getItem('cv10_headerColor') || '#008080';
                const sidebarColor = localStorage.getItem('cv10_sidebarColor') || '#ebf5f7';
                const accentColor = localStorage.getItem('cv10_accentColor') || '#333333';

                const cvHeader = document.querySelector('.cv-header');
                const leftSidebar = document.querySelector('.left-sidebar');
                const headings = document.querySelectorAll('h2');
                const prenom = document.querySelector('.prenom');
                const nom = document.querySelector('.nom');
                const post = document.querySelector('.post');

                cvHeader.style.backgroundColor = headerColor;
                leftSidebar.style.backgroundColor = sidebarColor;

                // Ensure header text is white
                prenom.style.color = "#ffffff";
                nom.style.color = "#ffffff";
                post.style.color = "#ffffff";

                headings.forEach(heading => {
                    heading.style.borderBottomColor = accentColor;
                    heading.style.color = accentColor;
                });

                // Mettre à jour les valeurs affichées
                updateColorValues(headerColor, sidebarColor, accentColor);
            }

            // Écouteurs d'événements pour les cartes de thème
            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    const themeName = this.getAttribute('data-theme');
                    applyTheme(themeName);

                    // Marquer la carte active
                    themeCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Gestionnaires d'événements pour les sélecteurs de couleur
            headerColorPicker.addEventListener('input', function () {
                const headerColor = this.value;
                const cvHeader = document.querySelector('.cv-header');
                cvHeader.style.backgroundColor = headerColor;

                // Ensure header text is white
                const prenom = document.querySelector('.prenom');
                const nom = document.querySelector('.nom');
                const post = document.querySelector('.post');
                prenom.style.color = "#ffffff";
                nom.style.color = "#ffffff";
                post.style.color = "#ffffff";

                headerColorValue.textContent = headerColor;
                localStorage.setItem('cv10_headerColor', headerColor);
                localStorage.removeItem('cv10_theme');
                themeCards.forEach(c => c.classList.remove('active'));
            });

            sidebarColorPicker.addEventListener('input', function () {
                const sidebarColor = this.value;
                const leftSidebar = document.querySelector('.left-sidebar');
                leftSidebar.style.backgroundColor = sidebarColor;

                sidebarColorValue.textContent = sidebarColor;
                localStorage.setItem('cv10_sidebarColor', sidebarColor);
                localStorage.removeItem('cv10_theme');
                themeCards.forEach(c => c.classList.remove('active'));
            });

            accentColorPicker.addEventListener('input', function () {
                const accentColor = this.value;
                const headings = document.querySelectorAll('h2');

                headings.forEach(heading => {
                    heading.style.borderBottomColor = accentColor;
                    heading.style.color = accentColor;
                });

                accentColorValue.textContent = accentColor;
                localStorage.setItem('cv10_accentColor', accentColor);
                localStorage.removeItem('cv10_theme');
                themeCards.forEach(c => c.classList.remove('active'));
            });

            // Réinitialiser les couleurs
            resetButton.addEventListener('click', function () {
                localStorage.removeItem('cv10_headerColor');
                localStorage.removeItem('cv10_sidebarColor');
                localStorage.removeItem('cv10_accentColor');
                localStorage.removeItem('cv10_theme');

                // Appliquer le thème par défaut
                applyTheme('classic');

                // Marquer la carte active
                themeCards.forEach(c => c.classList.remove('active'));
                const defaultCard = document.querySelector('.theme-card[data-theme="classic"]');
                if (defaultCard) defaultCard.classList.add('active');
            });

            // Appliquer le thème sauvegardé ou par défaut
            const savedTheme = localStorage.getItem('cv10_theme');
            if (savedTheme && themes[savedTheme]) {
                applyTheme(savedTheme);
                const activeCard = document.querySelector(`.theme-card[data-theme="${savedTheme}"]`);
                if (activeCard) activeCard.classList.add('active');
            } else if (localStorage.getItem('cv10_headerColor')) {
                applyCustomColors();
                themeCards.forEach(c => c.classList.remove('active'));
            } else {
                applyTheme('classic');
                const defaultCard = document.querySelector('.theme-card[data-theme="classic"]');
                if (defaultCard) defaultCard.classList.add('active');
            }
        });
    </script>
</body>

</html>