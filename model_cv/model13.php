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
    <title>Modèle 13 - CV Moderne Grid</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="css/model13.css">
    <script src="cv_customizer.js" defer></script>
    <script src="image_customizer.js" defer></script>

    <!-- Vérification du chargement du CSS -->
    <script>
        window.addEventListener('load', function () {
            // Vérifier si le CSS est correctement chargé
            const styleSheets = document.styleSheets;
            let model13CssLoaded = false;

            for (let i = 0; i < styleSheets.length; i++) {
                if (styleSheets[i].href && styleSheets[i].href.includes('model13.css')) {
                    model13CssLoaded = true;
                    console.log('Model13 CSS chargé avec succès');
                    break;
                }
            }

            if (!model13CssLoaded) {
                console.error('Model13 CSS non chargé. Vérifiez le chemin du fichier.');
                alert('Attention: Le style du CV n\'a pas été correctement chargé. Veuillez contacter l\'administrateur.');
            }
        });
    </script>
</head>

<body>
    <section class="section3">
        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <script>
                // Fonction pour précharger les polices avant la génération du PDF
                function preloadFonts() {
                    return new Promise((resolve) => {
                        // Créer un élément temporaire avec toutes les icônes utilisées
                        const tempDiv = document.createElement('div');
                        tempDiv.style.opacity = '0';
                        tempDiv.style.position = 'absolute';
                        tempDiv.style.top = '-9999px';
                        tempDiv.innerHTML = `
                            <i class="fas fa-envelope"></i>
                            <i class="fas fa-phone"></i>
                            <i class="fas fa-map-marker-alt"></i>
                            <i class="fab fa-linkedin"></i>
                        `;
                        document.body.appendChild(tempDiv);

                        // Donner un peu de temps pour charger les polices
                        setTimeout(() => {
                            document.body.removeChild(tempDiv);
                            resolve();
                        }, 500);
                    });
                }

                // Fonction pour remplacer temporairement les icônes Font Awesome par des SVG pour le PDF
                function replaceIconsWithSVG() {
                    const iconMap = {
                        'fa-envelope': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg>',
                        'fa-phone': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path></svg>',
                        'fa-map-marker-alt': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path></svg>',
                        'fa-linkedin': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>'
                    };

                    // Fonction pour remplacer une icône par son SVG
                    function replaceIcon(element) {
                        const classNames = Array.from(element.classList);
                        for (const className of classNames) {
                            if (iconMap[className]) {
                                // Création d'un élément temporaire pour insérer le SVG
                                const temp = document.createElement('div');
                                temp.innerHTML = iconMap[className];

                                // Récupérer la couleur courante de l'icône
                                const currentColor = window.getComputedStyle(element).color;

                                // Appliquer la couleur au SVG
                                const svg = temp.firstChild;
                                svg.style.fill = currentColor;

                                // Stocker l'élément original
                                element.dataset.originalHtml = element.outerHTML;

                                // Remplacer l'élément par le SVG
                                element.parentNode.replaceChild(svg, element);
                                return;
                            }
                        }
                    }

                    // Rechercher et remplacer toutes les icônes
                    const icons = document.querySelectorAll('.fas, .fab');
                    icons.forEach(replaceIcon);

                    return icons.length;
                }

                // Fonction pour restaurer les icônes originales
                function restoreIcons() {
                    const svgs = document.querySelectorAll('svg[viewBox]');
                    svgs.forEach(svg => {
                        const parent = svg.parentNode;
                        if (parent && svg.previousElementSibling && svg.previousElementSibling.dataset.originalHtml) {
                            const temp = document.createElement('div');
                            temp.innerHTML = svg.previousElementSibling.dataset.originalHtml;
                            parent.replaceChild(temp.firstChild, svg);
                        }
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
                        // Remplacer les icônes Font Awesome par des SVG
                        const iconsReplaced = replaceIconsWithSVG();
                        console.log(`${iconsReplaced} icônes remplacées par des SVG`);

                        const { jsPDF } = window.jspdf;
                        const element = document.querySelector(".cv13");

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
                            },
                            // Assurez-vous que les polices et les icônes sont chargées avant de générer l'image
                            fontFaces: true,
                            // Inclure les styles externes
                            useCORS: true
                        };

                        // Ajouter une classe temporaire pour optimiser le rendu PDF
                        element.classList.add('pdf-rendering');

                        // Capture les icônes Font Awesome explicitement avant de générer le PDF
                        const fontAwesomeStyle = document.createElement('style');
                        fontAwesomeStyle.textContent = `
                            .pdf-rendering .fas::before, .pdf-rendering .fab::before {
                                font-family: 'Font Awesome 5 Free' !important;
                                font-weight: 900 !important;
                                display: inline-block !important;
                                visibility: visible !important;
                            }
                            .pdf-rendering .fab::before {
                                font-family: 'Font Awesome 5 Brands' !important;
                            }
                        `;
                        document.head.appendChild(fontAwesomeStyle);

                        // Attendre un court instant pour que les styles soient appliqués
                        setTimeout(() => {
                            domtoimage.toJpeg(element, options)
                                .then(function (dataUrl) {
                                    // Supprimer la classe temporaire
                                    element.classList.remove('pdf-rendering');
                                    // Supprimer le style temporaire
                                    document.head.removeChild(fontAwesomeStyle);
                                    // Supprimer le message d'attente
                                    document.body.removeChild(loadingMessage);
                                    // Restaurer les icônes originales
                                    restoreIcons();

                                    const pdf = new jsPDF('p', 'mm', 'a4');
                                    const imgProps = pdf.getImageProperties(dataUrl);
                                    const pdfWidth = pdf.internal.pageSize.getWidth();
                                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                                    pdf.addImage(dataUrl, 'PNG', 0, 0, pdfWidth, pdfHeight);
                                    pdf.save("cv.pdf");
                                })
                                .catch(function (error) {
                                    // Nettoyer en cas d'erreur
                                    element.classList.remove('pdf-rendering');
                                    document.head.removeChild(fontAwesomeStyle);
                                    document.body.removeChild(loadingMessage);
                                    // Restaurer les icônes originales
                                    restoreIcons();

                                    console.error('Une erreur est survenue lors de la génération du PDF:', error);
                                    alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                                });
                        }, 300);
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
                        <div class="theme-card" data-theme="marine">
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
                        <div class="theme-card" data-theme="emerald">
                            <div class="theme-preview">
                                <div style="background-color: #0E3B43; height: 20px;"></div>
                                <div style="background-color: #328590; height: 20px;"></div>
                                <div style="background-color: #F0F0F0; height: 20px;"></div>
                            </div>
                            <span>Émeraude</span>
                        </div>
                        <div class="theme-card" data-theme="violet">
                            <div class="theme-preview">
                                <div style="background-color: #845EC2; height: 20px;"></div>
                                <div style="background-color: #B39CD0; height: 20px;"></div>
                                <div style="background-color: #FBEAFF; height: 20px;"></div>
                            </div>
                            <span>Violet</span>
                        </div>
                        <div class="theme-card" data-theme="ocean">
                            <div class="theme-preview">
                                <div style="background-color: #3D5A80; height: 20px;"></div>
                                <div style="background-color: #98C1D9; height: 20px;"></div>
                                <div style="background-color: #E0FBFC; height: 20px;"></div>
                            </div>
                            <span>Océan</span>
                        </div>
                        <div class="theme-card" data-theme="ruby">
                            <div class="theme-preview">
                                <div style="background-color: #A31621; height: 20px;"></div>
                                <div style="background-color: #DB5461; height: 20px;"></div>
                                <div style="background-color: #F0EFF4; height: 20px;"></div>
                            </div>
                            <span>Rubis</span>
                        </div>
                    </div>
                </div>

                <h3>Couleur des dates</h3>
                <div class="date-color-selector">
                    <div class="color-option" data-color="#888" style="background-color: #888;"></div>
                    <div class="color-option" data-color="#555" style="background-color: #555;"></div>
                    <div class="color-option active" data-color="#777" style="background-color: #777;"></div>
                    <div class="color-option" data-color="#333" style="background-color: #333;"></div>
                    <div class="color-option" data-color="#666" style="background-color: #666;"></div>
                </div>

                <h3>Personnalisation manuelle</h3>
                <div class="manual-color-options">
                    <div class="color-option">
                        <label for="primary-color">Couleur principale:</label>
                        <input type="color" id="primary-color" class="color-picker">
                    </div>
                    <div class="color-option">
                        <label for="accent-color">Couleur d'accent:</label>
                        <input type="color" id="accent-color" class="color-picker">
                    </div>
                    <div class="color-option">
                        <label for="secondary-color">Couleur secondaire:</label>
                        <input type="color" id="secondary-color" class="color-picker">
                    </div>
                    <div class="color-option">
                        <label for="date-color">Couleur des dates:</label>
                        <input type="color" id="date-color" class="color-picker">
                    </div>
                    <button id="resetColors">Réinitialiser les couleurs</button>
                </div>

                <h3>Polices de caractères</h3>
                <div class="font-selector">
                    <div class="font-card" data-font="Arial">
                        <span style="font-family: Arial;">Arial</span>
                    </div>
                    <div class="font-card" data-font="Roboto">
                        <span style="font-family: Roboto;">Roboto</span>
                    </div>
                    <div class="font-card active" data-font="Montserrat">
                        <span style="font-family: Montserrat;">Montserrat</span>
                    </div>
                    <div class="font-card" data-font="Poppins">
                        <span style="font-family: Poppins;">Poppins</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-model">
            <div class="cv13 theme-blue">
                <!-- CV Header -->
                <div class="cv-header">
                    <div class="profile-container">
                        <img src="../upload/<?= isset($userss['images']) && $userss['images'] ? $userss['images'] : 'default-profile.jpg' ?>"
                            alt="Photo de profil" class="profile-photo cv-editable-image">
                    </div>
                    <div class="identity-container">
                        <h1 class="name cv-editable">
                            <?= $userss['nom'] ?>
                        </h1>
                        <p class="job-title cv-editable">
                            <?= isset($userss['competences']) ? $userss['competences'] : "Développeur Full Stack" ?>
                        </p>
                        <p class="summary cv-editable">
                            <?= $descriptions['description'] ?>
                        </p>
                    </div>
                </div>

                <!-- CV Body -->
                <div class="cv-body">
                    <!-- Left Column -->
                    <div class="left-column">
                        <!-- Contact Information -->
                        <div class="contact-info">
                            <h2 class="section-title cv-editable">Contact</h2>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span
                                    class="contact-text cv-editable"><?= isset($userss['mail']) ? $userss['mail'] : "thomas.dupont@gmail.com" ?></span>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span
                                    class="contact-text cv-editable"><?= isset($userss['phone']) ? $userss['phone'] : "06 12 34 56 78" ?></span>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span
                                    class="contact-text cv-editable"><?= isset($userss['ville']) ? $userss['ville'] : "Paris, France" ?></span>
                            </div>
                        </div>

                        <!-- Skills Section -->
                        <div class="skills-section">
                            <h2 class="section-title cv-editable">Compétences</h2>

                            <?php if (isset($competencesUtilisateurLimit7) && !empty($competencesUtilisateurLimit7)): ?>
                                <?php foreach ($competencesUtilisateurLimit7 as $competence): ?>
                                    <div class="skill-item">
                                        <span class="skill-name cv-editable"><?= $competence['competence'] ?></span>
                                        <div class="skill-level">
                                            <div class="skill-progress p-<?= rand(60, 95) ?>"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucune compétence trouvée</p>
                            <?php endif; ?>
                        </div>

                        <!-- Languages Section -->
                        <div class="languages-section">
                            <h2 class="section-title cv-editable">Langues</h2>

                            <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                <?php foreach ($afficheLangue as $langue): ?>
                                    <div class="language-item">
                                        <span class="language-name cv-editable"><?= $langue['langue'] ?></span>
                                        <div class="language-level">
                                            <div class="language-progress p-<?= rand(60, 95) ?>"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucune langue trouvée</p>
                            <?php endif; ?>
                        </div>

                        <!-- Interests Section -->
                        <div class="interests-section">
                            <h2 class="section-title cv-editable">Centres d'intérêt</h2>
                            <div class="interests-list">
                                <?php if (isset($afficheCentreInteret) && !empty($afficheCentreInteret)): ?>
                                    <?php foreach ($afficheCentreInteret as $interet): ?>
                                        <span class="interest-item cv-editable"><?= $interet['interet'] ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="texte">Aucun centre d'intérêt trouvé</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="right-column">
                        <!-- Experience Section -->
                        <div class="experience-section">
                            <h2 class="section-title cv-editable">Expérience professionnelle</h2>

                            <?php if (isset($afficheMetier) && !empty($afficheMetier)): ?>
                                <?php foreach ($afficheMetier as $metier): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-header">
                                            <h3 class="timeline-title cv-editable"><?= $metier['metier'] ?></h3>
                                            <span
                                                class="timeline-date cv-editable"><?= $metier['moisDebut'] ?>/<?= $metier['anneeDebut'] ?>
                                                -
                                                <?= $metier['moisFin'] ?>/<?= $metier['anneeFin'] ?></span>
                                        </div>
                                        <div class="timeline-content cv-editable">
                                            <?= $metier['description'] ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Placeholder experiences -->
                                <p class="texte">Aucune expérience professionnelle trouvée</p>
                            <?php endif; ?>
                        </div>

                        <!-- Education Section -->
                        <div class="education-section">
                            <h2 class="section-title cv-editable">Formation</h2>

                            <?php if (isset($formationUsers) && !empty($formationUsers)): ?>
                                <?php foreach ($formationUsers as $formation): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-header">
                                            <h3 class="timeline-title cv-editable"><?= $formation['Filiere'] ?></h3>
                                            <span
                                                class="timeline-date cv-editable"><?= $formation['moisDebut'] ?>/<?= $formation['anneeDebut'] ?>
                                                -
                                                <?= $formation['moisFin'] ?>/<?= $formation['anneeFin'] ?></span>

                                            <p class="timeline-subtitle cv-editable"><?= $formation['etablissement'] ?>
                                                <strong><?= $formation['niveau'] ?></strong>
                                            </p>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Placeholder education -->
                                <p class="texte">Aucune formation trouvée</p>
                            <?php endif; ?>
                        </div>

                        <!-- Projects Section -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Script for color theme switching
        document.addEventListener('DOMContentLoaded', function () {
            // Functions to save and load preferences from localStorage
            function savePreference(key, value) {
                localStorage.setItem('cv13_' + key, value);
            }

            function getPreference(key, defaultValue) {
                return localStorage.getItem('cv13_' + key) || defaultValue;
            }

            // Convertit une couleur hex CSS en composantes RGB et retourne l'objet
            function hexToRgb(hex) {
                // On enlève le # si présent
                hex = hex.replace(/^#/, '');

                // Convertit les raccourcis (ex: #abc) en forme complète (ex: #aabbcc)
                if (hex.length === 3) {
                    hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                }

                // Convertit en valeurs décimales
                const r = parseInt(hex.substring(0, 2), 16);
                const g = parseInt(hex.substring(2, 4), 16);
                const b = parseInt(hex.substring(4, 6), 16);

                // Retourne un objet avec les valeurs r, g, b
                return { r, g, b };
            }

            // Convertit des composantes RGB en notation hexadécimale
            function rgbToHex(r, g, b) {
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
            }

            // Theme cards
            const themeCards = document.querySelectorAll('.theme-card');
            const cv = document.querySelector('.cv13');

            // Initialize color pickers
            const primaryColorPicker = document.getElementById('primary-color');
            const accentColorPicker = document.getElementById('accent-color');
            const secondaryColorPicker = document.getElementById('secondary-color');
            const dateColorPicker = document.getElementById('date-color');

            // Theme color maps
            const themeColors = {
                'classic': {
                    primary: '#4A4A4A',
                    accent: '#7A7A7A',
                    secondary: '#F5F5F5',
                    date: '#7A7A7A'
                },
                'marine': {
                    primary: '#1D3557',
                    accent: '#457B9D',
                    secondary: '#F1FAEE',
                    date: '#457B9D'
                },
                'corporate': {
                    primary: '#1A237E',
                    accent: '#5C6BC0',
                    secondary: '#FFFFFF',
                    date: '#5C6BC0'
                },
                'slate': {
                    primary: '#2F4F4F',
                    accent: '#708090',
                    secondary: '#E8ECEE',
                    date: '#708090'
                },
                'emerald': {
                    primary: '#0E3B43',
                    accent: '#328590',
                    secondary: '#F0F0F0',
                    date: '#328590'
                },
                'violet': {
                    primary: '#845EC2',
                    accent: '#B39CD0',
                    secondary: '#FBEAFF',
                    date: '#B39CD0'
                },
                'ocean': {
                    primary: '#3D5A80',
                    accent: '#98C1D9',
                    secondary: '#E0FBFC',
                    date: '#98C1D9'
                },
                'ruby': {
                    primary: '#A31621',
                    accent: '#DB5461',
                    secondary: '#F0EFF4',
                    date: '#DB5461'
                }
            };

            // Function to apply colors to the CV
            function applyColors(primary, accent, secondary, dateColor) {
                // Vérification que les couleurs sont au format hexadécimal
                if (!primary.startsWith('#')) primary = '#' + primary;
                if (!accent.startsWith('#')) accent = '#' + accent;
                if (!secondary.startsWith('#')) secondary = '#' + secondary;
                if (!dateColor.startsWith('#')) dateColor = '#' + dateColor;

                document.documentElement.style.setProperty('--primary-color', primary);
                document.documentElement.style.setProperty('--accent-color', accent);
                document.documentElement.style.setProperty('--secondary-color', secondary);

                const headerBg = document.querySelector('.cv-header');
                const leftColumnBg = document.querySelector('.left-column');

                if (headerBg) {
                    headerBg.style.backgroundColor = primary;
                }

                if (leftColumnBg) {
                    leftColumnBg.style.backgroundColor = secondary;
                }

                // Apply accent color to all accent elements
                const accentElements = document.querySelectorAll('.timeline-dot, .skill-progress, .language-progress, .contact-icon');
                accentElements.forEach(el => {
                    el.style.backgroundColor = accent;
                });

                // Apply accent color to pseudo-elements with CSS variable
                document.documentElement.style.setProperty('--accent-color', accent);

                // Apply date color
                const dateElements = document.querySelectorAll('.timeline-date');
                dateElements.forEach(el => {
                    el.style.color = dateColor;
                });

                // Update color pickers (sans déclencher d'événements)
                if (primaryColorPicker) primaryColorPicker.value = primary;
                if (accentColorPicker) accentColorPicker.value = accent;
                if (secondaryColorPicker) secondaryColorPicker.value = secondary;
                if (dateColorPicker) dateColorPicker.value = dateColor;

                // Save colors
                savePreference('primary-color', primary);
                savePreference('accent-color', accent);
                savePreference('secondary-color', secondary);
                savePreference('date-color', dateColor);
            }

            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    const theme = this.getAttribute('data-theme');

                    // Remove all theme classes
                    themeCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Remove all theme classes from CV
                    cv.classList.remove('theme-classic', 'theme-marine', 'theme-corporate', 'theme-slate',
                        'theme-emerald', 'theme-violet', 'theme-ocean', 'theme-ruby');

                    // Add the selected theme class
                    cv.classList.add('theme-' + theme);

                    // Save the selected theme
                    savePreference('theme', theme);

                    // Apply theme colors
                    if (themeColors[theme]) {
                        const colors = themeColors[theme];
                        applyColors(colors.primary, colors.accent, colors.secondary, colors.date);
                    }
                });
            });

            // Manual color customization
            if (primaryColorPicker) {
                primaryColorPicker.addEventListener('input', function () {
                    const primary = this.value;
                    const accent = accentColorPicker ? accentColorPicker.value : '#7A7A7A';
                    const secondary = secondaryColorPicker ? secondaryColorPicker.value : '#F5F5F5';
                    const dateColor = dateColorPicker ? dateColorPicker.value : accent;

                    // Remove theme selection
                    themeCards.forEach(c => c.classList.remove('active'));

                    // Apply custom colors
                    applyColors(primary, accent, secondary, dateColor);

                    // Save custom mode
                    savePreference('theme', 'custom');
                });
            }

            if (accentColorPicker) {
                accentColorPicker.addEventListener('input', function () {
                    const primary = primaryColorPicker ? primaryColorPicker.value : '#4A4A4A';
                    const accent = this.value;
                    const secondary = secondaryColorPicker ? secondaryColorPicker.value : '#F5F5F5';
                    const dateColor = dateColorPicker ? dateColorPicker.value : accent;

                    // Remove theme selection
                    themeCards.forEach(c => c.classList.remove('active'));

                    // Apply custom colors
                    applyColors(primary, accent, secondary, dateColor);

                    // Save custom mode
                    savePreference('theme', 'custom');
                });
            }

            if (secondaryColorPicker) {
                secondaryColorPicker.addEventListener('input', function () {
                    const primary = primaryColorPicker ? primaryColorPicker.value : '#4A4A4A';
                    const accent = accentColorPicker ? accentColorPicker.value : '#7A7A7A';
                    const secondary = this.value;
                    const dateColor = dateColorPicker ? dateColorPicker.value : accent;

                    // Remove theme selection
                    themeCards.forEach(c => c.classList.remove('active'));

                    // Apply custom colors
                    applyColors(primary, accent, secondary, dateColor);

                    // Save custom mode
                    savePreference('theme', 'custom');
                });
            }

            if (dateColorPicker) {
                dateColorPicker.addEventListener('input', function () {
                    const primary = primaryColorPicker ? primaryColorPicker.value : '#4A4A4A';
                    const accent = accentColorPicker ? accentColorPicker.value : '#7A7A7A';
                    const secondary = secondaryColorPicker ? secondaryColorPicker.value : '#F5F5F5';
                    const dateColor = this.value;

                    // Remove theme selection
                    themeCards.forEach(c => c.classList.remove('active'));

                    // Apply custom colors
                    applyColors(primary, accent, secondary, dateColor);

                    // Save custom mode
                    savePreference('theme', 'custom');
                });
            }

            // Reset colors button
            const resetColorsButton = document.getElementById('resetColors');
            if (resetColorsButton) {
                resetColorsButton.addEventListener('click', function () {
                    // Reset to classic theme
                    const classicThemeCard = document.querySelector('.theme-card[data-theme="classic"]');
                    if (classicThemeCard) {
                        classicThemeCard.click();
                    } else {
                        // Fallback if button not found
                        applyColors('#4A4A4A', '#7A7A7A', '#F5F5F5', '#7A7A7A');
                        savePreference('theme', 'classic');
                    }
                });
            }

            // Accent color selection
            const colorOptions = document.querySelectorAll('.date-color-selector .color-option');

            colorOptions.forEach(option => {
                option.addEventListener('click', function () {
                    const color = this.getAttribute('data-color');

                    // Remove active class from all options
                    colorOptions.forEach(o => o.classList.remove('active'));
                    this.classList.add('active');

                    // Save the selected date color
                    savePreference('dateColor', color);

                    // Apply the selected color to date elements
                    const dateElements = document.querySelectorAll('.timeline-date');
                    dateElements.forEach(el => {
                        el.style.color = color;
                    });

                    // Update the date color picker
                    document.getElementById('date-color').value = color;
                    savePreference('date-color', color);
                });
            });

            // Font selection
            const fontCards = document.querySelectorAll('.font-card');

            fontCards.forEach(card => {
                card.addEventListener('click', function () {
                    const font = this.getAttribute('data-font');

                    // Remove active class from all cards
                    fontCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Save the selected font
                    savePreference('font', font);

                    // Apply the font to the CV
                    document.querySelector('.cv13').style.fontFamily = `'${font}', sans-serif`;

                    // Apply the font to headers specifically
                    const headerElements = document.querySelectorAll('.name, .job-title, .section-title, .timeline-title');
                    headerElements.forEach(el => {
                        el.style.fontFamily = `'${font}', sans-serif`;
                    });
                });
            });

            // Load saved preferences or initialize with defaults
            const savedTheme = getPreference('theme', 'classic');
            const savedDateColor = getPreference('dateColor', '#777');
            const savedFont = getPreference('font', 'Montserrat');

            // Load saved custom colors
            const savedPrimaryColor = getPreference('primary-color', '#4A4A4A');
            const savedAccentColor = getPreference('accent-color', '#7A7A7A');
            const savedSecondaryColor = getPreference('secondary-color', '#F5F5F5');
            const savedDateColorValue = getPreference('date-color', '#7A7A7A');

            // Apply saved theme or custom colors
            if (savedTheme === 'custom') {
                // Apply custom colors
                applyColors(savedPrimaryColor, savedAccentColor, savedSecondaryColor, savedDateColorValue);
            } else {
                // Apply saved theme
                const themeCard = document.querySelector(`.theme-card[data-theme="${savedTheme}"]`);
                if (themeCard) {
                    themeCard.click();
                } else {
                    document.querySelector('.theme-card[data-theme="classic"]').click();
                }
            }

            // Apply saved date color from predefined options
            const colorOption = document.querySelector(`.color-option[data-color="${savedDateColor}"]`);
            if (colorOption) {
                colorOption.click();
            } else {
                const activeColorOption = document.querySelector('.color-option.active');
                if (activeColorOption) {
                    activeColorOption.click();
                }
            }

            // Apply saved font
            const fontCard = document.querySelector(`.font-card[data-font="${savedFont}"]`);
            if (fontCard) {
                fontCard.click();
            } else {
                const activeFontCard = document.querySelector('.font-card.active');
                if (activeFontCard) {
                    activeFontCard.click();
                }
            }
        });
    </script>
</body>

</html>