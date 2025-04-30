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
    <title>CV - Modèle 14</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/model14.css" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
</head>

<body>
    <section class="section3">
        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>

            <div class="customization-panel">
                <div class="section">
                    <h3>Thèmes de couleurs</h3>
                    <div class="subsection">
                        <h4>Classiques</h4>
                        <div class="themes-container">
                            <div class="theme-card" data-theme="classique">
                                <div class="theme-preview">
                                    <div style="background-color: #333333; height: 20px;"></div>
                                    <div style="background-color: #666666; height: 20px;"></div>
                                </div>
                                <span>Classique</span>
                            </div>
                            <div class="theme-card" data-theme="marine">
                                <div class="theme-preview">
                                    <div style="background-color: #1a3c5e; height: 20px;"></div>
                                    <div style="background-color: #3a6a98; height: 20px;"></div>
                                </div>
                                <span>Marine</span>
                            </div>
                            <div class="theme-card" data-theme="corporate">
                                <div class="theme-preview">
                                    <div style="background-color: #283593; height: 20px;"></div>
                                    <div style="background-color: #5f5fc4; height: 20px;"></div>
                                </div>
                                <span>Corporate</span>
                            </div>
                            <div class="theme-card" data-theme="ardoise">
                                <div class="theme-preview">
                                    <div style="background-color: #2f4f4f; height: 20px;"></div>
                                    <div style="background-color: #5f7f7f; height: 20px;"></div>
                                </div>
                                <span>Ardoise</span>
                            </div>
                        </div>
                    </div>

                    <div class="subsection">
                        <h4>Couleurs vives</h4>
                        <div class="themes-container">
                            <div class="theme-card" data-theme="emeraude">
                                <div class="theme-preview">
                                    <div style="background-color: #00695c; height: 20px;"></div>
                                    <div style="background-color: #33ab9f; height: 20px;"></div>
                                </div>
                                <span>Émeraude</span>
                            </div>
                            <div class="theme-card" data-theme="violet">
                                <div class="theme-preview">
                                    <div style="background-color: #673ab7; height: 20px;"></div>
                                    <div style="background-color: #b39ddb; height: 20px;"></div>
                                </div>
                                <span>Violet</span>
                            </div>
                            <div class="theme-card" data-theme="ocean">
                                <div class="theme-preview">
                                    <div style="background-color: #1565c0; height: 20px;"></div>
                                    <div style="background-color: #90caf9; height: 20px;"></div>
                                </div>
                                <span>Océan</span>
                            </div>
                            <div class="theme-card" data-theme="rubis">
                                <div class="theme-preview">
                                    <div style="background-color: #b71c1c; height: 20px;"></div>
                                    <div style="background-color: #e57373; height: 20px;"></div>
                                </div>
                                <span>Rubis</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <h3>Couleur des dates</h3>
                    <div class="color-options">
                        <div class="color-circle" data-date-color="#757575"></div>
                        <div class="color-circle active" data-date-color="#455a64"></div>
                        <div class="color-circle" data-date-color="#607d8b"></div>
                        <div class="color-circle" data-date-color="#333333"></div>
                        <div class="color-circle" data-date-color="#555555"></div>
                    </div>
                </div>

                <div class="section">
                    <h3>Polices de caractères</h3>
                    <div class="font-options">
                        <div class="font-card" data-font="Arial">
                            <span style="font-family: Arial">Arial</span>
                        </div>
                        <div class="font-card" data-font="Roboto">
                            <span style="font-family: Roboto">Roboto</span>
                        </div>
                        <div class="font-card" data-font="Montserrat">
                            <span style="font-family: Montserrat">Montserrat</span>
                        </div>
                        <div class="font-card" data-font="Poppins">
                            <span style="font-family: Poppins">Poppins</span>
                        </div>
                        <div class="font-card" data-font="Georgia">
                            <span style="font-family: Georgia">Georgia</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <button id="reset-styles" class="reset-button">Réinitialiser tous les styles</button>
                </div>
            </div>
        </div>

        <div class="container" id="cv-container">
            <!-- Background Elements -->
            <div class="background-element circle-1"></div>
            <div class="background-element circle-2"></div>
            <div class="background-element zigzag"></div>

            <!-- Header Section -->
            <div class="header">
                <div class="profile-section">
                    <div class="profile-frame">
                        <?php if (isset($userss['images'])): ?>
                            <img class="profile-img" src="../upload/<?= $userss['images'] ?>" alt="Photo de profil" />
                        <?php else: ?>
                            <img class="profile-img" src="../image/image-2.png" alt="Photo de profil" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="name-title">
                    <h1 class="name">
                        <?php if (isset($userss['nom'])): ?>
                            <?= $userss['nom'] ?>
                        <?php else: ?>
                            Marie Laurent
                        <?php endif; ?>
                    </h1>
                    <h2 class="profession">
                        <?php if (isset($userss['competences'])): ?>
                            <?= $userss['competences'] ?>
                        <?php else: ?>
                            Designer Graphique
                        <?php endif; ?>
                    </h2>
                    <p class="about-text">
                        <?php if (isset($descriptions)): ?>
                            <?= $descriptions['description'] ?>
                        <?php else: ?>
                            Designer graphique créative avec plus de 6 ans d'expérience dans la
                            conception visuelle et la direction artistique. Spécialisée dans
                            l'identité de marque, la typographie et l'illustration numérique.
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content">
                <!-- Contact Info -->
                <div class="contact-info">
                    <h3 class="section-title">Contact</h3>
                    <div class="contact-box">
                        <div class="contact-item">
                            <img class="contact-icon" src="../image/address.png" alt="Adresse" />
                            <p>
                                <?php if (isset($userss['ville'])): ?>
                                    <?= $userss['ville'] ?>
                                <?php else: ?>
                                    aucune ville trouvée
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="contact-item">
                            <img class="contact-icon" src="../image/icons8-gmail-48.png" alt="Email" />
                            <p>
                                <?php if (isset($userss['mail'])): ?>
                                    <?= $userss['mail'] ?>
                                <?php else: ?>
                                <p>aucun email trouvé</p>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="contact-item">
                            <img class="contact-icon" src="../image/phone.png" alt="Téléphone" />
                            <p>
                                <?php if (isset($userss['phone'])): ?>
                                    <?= $userss['phone'] ?>
                                <?php else: ?>
                                    aucun numéro de téléphone trouvé
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="skills">
                    <h3 class="skills-title">Compétences</h3>
                    <div class="skills-grid">
                        <?php if (isset($competencesUtilisateurLimit7) && !empty($competencesUtilisateurLimit7)): ?>
                            <?php
                            $percentages = [95, 90, 85, 80, 75, 70, 65];
                            $index = 0;
                            ?>

                            <div class="skill-item">
                                <?php foreach ($competencesUtilisateurLimit7 as $competence): ?>
                                    <?php $percentage = isset($percentages[$index]) ? $percentages[$index] : 75; ?>
                                    <span class="skill-name"><?= $competence['competence']; ?></span>
                                    <?php $index++; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>Aucune compétence trouvée</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="box">
                    <div>
                        <!-- Languages -->
                        <div class="languages">
                            <h3 class="section-title">Langues</h3>
                            <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                <?php
                                $niveaux = [
                                    'Débutant' => 30,
                                    'Intermédiaire' => 60,
                                    'Courant' => 80,
                                    'Bilingue' => 95,
                                    'Langue maternelle' => 100
                                ];
                                ?>
                                <?php foreach ($afficheLangue as $langue): ?>
                                    <?php
                                    $pourcentage = 80; // Par défaut
                                    foreach ($niveaux as $niveau => $pct) {
                                        if (stripos($langue['niveau'], $niveau) !== false) {
                                            $pourcentage = $pct;
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="language-item">
                                        <span class="language-name"><?= $langue['langue']; ?></span>
                                        <div class="language-level-bar">
                                            <div class="language-level-fill" style="width: <?= $pourcentage ?>%"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune langue trouvée</p>
                            <?php endif; ?>
                        </div>

                        <div class="education">
                            <h3 class="section-title">Formation</h3>
                            <div class="education-container">
                                <?php if (isset($formationUsers) && !empty($formationUsers)): ?>
                                    <?php foreach ($formationUsers as $formation): ?>
                                        <div class="education-item">
                                            <h3 class="education-title"><?= $formation['Filiere']; ?></h3>
                                            <div class="education-subtitle"><?= $formation['etablissement']; ?> <strong>
                                                    <?= $formation['niveau']; ?></strong></div>
                                            <div class="education-date">
                                                <?= $formation['moisDebut'] ?>         <?= $formation['anneeDebut'] ?> à
                                                <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune formation trouvée</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Experiences -->
                    <div class="experiences">
                        <h3 class="section-title">Expérience professionnelle</h3>
                        <div class="timeline-container">
                            <?php if (isset($afficheMetier) && !empty($afficheMetier)): ?>
                                <?php foreach ($afficheMetier as $metier): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-content">
                                            <h3 class="timeline-title"><?= $metier['metier']; ?></h3>
                                            <div class="timeline-subtitle">
                                                <?= isset($metier['entreprise']) ? $metier['entreprise'] : ''; ?>
                                            </div>
                                            <div class="timeline-date">
                                                <?= $metier['moisDebut'] ?>         <?= $metier['anneeDebut'] ?> à
                                                <?= $metier['moisFin'] ?>         <?= $metier['anneeFin'] ?>
                                            </div>
                                            <p class="timeline-description">
                                                <?= $metier['description']; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune expérience professionnelle trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Fonction pour précharger les polices avant la génération du PDF
        function preloadFonts() {
            return new Promise((resolve) => {
                // Donner un peu de temps pour charger les polices
                setTimeout(() => {
                    resolve();
                }, 500);
            });
        }

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

            // Précharger les polices puis générer le PDF
            preloadFonts().then(() => {
                const { jsPDF } = window.jspdf;
                const element = document.getElementById("cv-container");

                // Définir une échelle plus élevée pour une meilleure qualité
                const scale = 2;
                const options = {
                    scale: scale,
                    quality: 1,
                    bgcolor: '#fff',
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

                domtoimage.toJpeg(element, options)
                    .then(function (dataUrl) {
                        // Supprimer le message d'attente
                        document.body.removeChild(loadingMessage);

                        const pdf = new jsPDF('p', 'mm', 'a4');
                        const imgProps = pdf.getImageProperties(dataUrl);
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                        pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                        pdf.save("cv-model14.pdf");
                    })
                    .catch(function (error) {
                        console.error('Une erreur est survenue lors de la génération du PDF:', error);
                        // Supprimer le message d'attente en cas d'erreur
                        document.body.removeChild(loadingMessage);
                        alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                    });
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Définition des thèmes
            const themes = {
                // Classiques
                classique: {
                    primaryColor: '#333333',
                    secondaryColor: '#666666',
                    accentColor: '#999999',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                marine: {
                    primaryColor: '#1a3c5e',
                    secondaryColor: '#3a6a98',
                    accentColor: '#70a9dd',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                corporate: {
                    primaryColor: '#283593',
                    secondaryColor: '#5f5fc4',
                    accentColor: '#3f51b5',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                ardoise: {
                    primaryColor: '#2f4f4f',
                    secondaryColor: '#5f7f7f',
                    accentColor: '#8fbfbf',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                // Couleurs vives
                emeraude: {
                    primaryColor: '#00695c',
                    secondaryColor: '#33ab9f',
                    accentColor: '#4db6ac',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                violet: {
                    primaryColor: '#673ab7',
                    secondaryColor: '#b39ddb',
                    accentColor: '#9575cd',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                ocean: {
                    primaryColor: '#1565c0',
                    secondaryColor: '#90caf9',
                    accentColor: '#42a5f5',
                    darkText: '#333333',
                    lightText: '#777777'
                },
                rubis: {
                    primaryColor: '#b71c1c',
                    secondaryColor: '#e57373',
                    accentColor: '#ef5350',
                    darkText: '#333333',
                    lightText: '#777777'
                }
            };

            // Préfixe pour les clés de localStorage
            const storagePrefix = 'cv14_';

            // Sélecteurs DOM
            const themeCards = document.querySelectorAll('.theme-card');
            const colorCircles = document.querySelectorAll('.color-circle');
            const fontCards = document.querySelectorAll('.font-card');
            const resetButton = document.getElementById('reset-styles');

            // Fonction pour appliquer un thème
            function applyTheme(themeName) {
                const theme = themes[themeName];
                if (!theme) return;

                // Appliquer les couleurs CSS avec des variables personnalisées
                document.documentElement.style.setProperty('--primary-color', theme.primaryColor);
                document.documentElement.style.setProperty('--secondary-color', theme.secondaryColor);
                document.documentElement.style.setProperty('--accent-color', theme.accentColor);
                document.documentElement.style.setProperty('--dark-text', theme.darkText);
                document.documentElement.style.setProperty('--light-text', theme.lightText);
                document.documentElement.style.setProperty('--gradient-1', `linear-gradient(135deg, ${theme.primaryColor} 0%, ${theme.accentColor} 100%)`);
                document.documentElement.style.setProperty('--gradient-2', `linear-gradient(135deg, ${theme.secondaryColor} 0%, ${theme.accentColor} 100%)`);

                // Sauvegarder dans localStorage
                localStorage.setItem(`${storagePrefix}theme`, themeName);
            }

            // Fonction pour appliquer la couleur des dates
            function applyDateColor(color) {
                document.documentElement.style.setProperty('--date-color', color);
                localStorage.setItem(`${storagePrefix}dateColor`, color);
            }

            // Fonction pour appliquer la police
            function applyFont(fontName) {
                document.documentElement.style.setProperty('--main-font', fontName);
                document.body.style.fontFamily = fontName;
                localStorage.setItem(`${storagePrefix}font`, fontName);
            }

            // Écouteurs d'événements pour les cartes de thème
            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    const themeName = this.getAttribute('data-theme');

                    // Mettre à jour l'état actif visuel
                    themeCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Appliquer le thème
                    applyTheme(themeName);
                });
            });

            // Écouteurs d'événements pour les cercles de couleur des dates
            colorCircles.forEach(circle => {
                circle.addEventListener('click', function () {
                    const dateColor = this.getAttribute('data-date-color');

                    // Mettre à jour l'état actif visuel
                    colorCircles.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Appliquer la couleur
                    applyDateColor(dateColor);
                });
            });

            // Écouteurs d'événements pour les polices
            fontCards.forEach(card => {
                card.addEventListener('click', function () {
                    const fontName = this.getAttribute('data-font');

                    // Mettre à jour l'état actif visuel
                    fontCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Appliquer la police
                    applyFont(fontName);
                });
            });

            // Fonction pour réinitialiser tous les styles
            function resetAllStyles() {
                // Effacer toutes les entrées du localStorage commençant par cv14_
                Object.keys(localStorage).forEach(key => {
                    if (key.startsWith(storagePrefix)) {
                        localStorage.removeItem(key);
                    }
                });

                // Réappliquer les styles par défaut
                applyTheme('classique');
                applyDateColor('#455a64');
                applyFont('Raleway');

                // Mettre à jour visuellement les éléments actifs
                themeCards.forEach(card => {
                    card.classList.remove('active');
                    if (card.getAttribute('data-theme') === 'classique') {
                        card.classList.add('active');
                    }
                });

                colorCircles.forEach(circle => {
                    circle.classList.remove('active');
                    if (circle.getAttribute('data-date-color') === '#455a64') {
                        circle.classList.add('active');
                    }
                });

                fontCards.forEach(card => {
                    card.classList.remove('active');
                    if (card.getAttribute('data-font') === 'Raleway') {
                        card.classList.add('active');
                    }
                });

                // Notifier l'utilisateur
                alert('Tous les styles ont été réinitialisés avec succès.');
            }

            // Écouteur d'événement pour le bouton de réinitialisation
            resetButton.addEventListener('click', resetAllStyles);

            // Récupérer et appliquer les paramètres sauvegardés
            function loadSavedSettings() {
                // Thème
                const savedTheme = localStorage.getItem(`${storagePrefix}theme`);
                if (savedTheme && themes[savedTheme]) {
                    applyTheme(savedTheme);
                    themeCards.forEach(card => {
                        if (card.getAttribute('data-theme') === savedTheme) {
                            card.classList.add('active');
                        }
                    });
                } else {
                    // Thème par défaut: classique
                    themeCards[0].classList.add('active');
                    applyTheme('classique');
                }

                // Couleur des dates
                const savedDateColor = localStorage.getItem(`${storagePrefix}dateColor`);
                if (savedDateColor) {
                    applyDateColor(savedDateColor);
                    colorCircles.forEach(circle => {
                        if (circle.getAttribute('data-date-color') === savedDateColor) {
                            circle.classList.add('active');
                        }
                    });
                } else {
                    // Couleur par défaut: slate blue
                    applyDateColor('#455a64');
                }

                // Police
                const savedFont = localStorage.getItem(`${storagePrefix}font`);
                if (savedFont) {
                    applyFont(savedFont);
                    fontCards.forEach(card => {
                        if (card.getAttribute('data-font') === savedFont) {
                            card.classList.add('active');
                        }
                    });
                } else {
                    // Police par défaut: Raleway (déjà définie dans le CSS)
                }
            }

            // Charger les paramètres sauvegardés au chargement de la page
            loadSavedSettings();
        });
    </script>
</body>

</html>