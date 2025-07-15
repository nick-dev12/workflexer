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
    <title>CV - Modèle 11</title>
    <!-- Charger Font Awesome en version web font avec le CSS -->
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Merriweather:wght@400;700&family=Montserrat:wght@400;700&family=Poppins:wght@400;700&family=Raleway:wght@400;700&family=Roboto:wght@400;700&family=Nunito:wght@400;700&family=Georgia&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <script src="cv_customizer.js" defer></script>
    <script src="image_customizer.js" defer></script>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/model11_1.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
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
                // Fonction pour précharger les polices avant la génération du PDF
                function preloadFonts() {
                    return new Promise((resolve) => {
                        // Créer un élément temporaire avec toutes les icônes utilisées
                        const tempDiv = document.createElement('div');
                        tempDiv.style.opacity = '0';
                        tempDiv.style.position = 'absolute';
                        tempDiv.style.top = '-9999px';
                        tempDiv.innerHTML = `
                            <i class="fas fa-user"></i>
                            <i class="fas fa-briefcase"></i>
                            <i class="fas fa-graduation-cap"></i>
                            <i class="fas fa-info-circle"></i>
                            <i class="fas fa-language"></i>
                            <i class="fas fa-tools"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-map-marker-alt"></i>
                            <i class="fas fa-book"></i>
                            <i class="fas fa-dumbbell"></i>
                            <i class="fas fa-plane"></i>
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
                        'fa-user': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>',
                        'fa-briefcase': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M320 336c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h416c25.6 0 48-22.4 48-48V288H320v48zm144-208h-80V80c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h512v-80c0-25.6-22.4-48-48-48zm-144 0H192V96h128v32z"></path></svg>',
                        'fa-graduation-cap': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M622.34 153.2L343.4 67.5c-15.2-4.67-31.6-4.67-46.79 0L17.66 153.2c-23.54 7.23-23.54 38.36 0 45.59l48.63 14.94c-10.67 13.19-17.23 29.28-17.88 46.9C38.78 266.15 32 276.11 32 288c0 10.78 5.68 19.85 13.86 25.65L20.33 428.53C18.11 438.52 25.71 448 35.94 448h56.11c10.24 0 17.84-9.48 15.62-19.47L82.14 313.65C90.32 307.85 96 298.78 96 288c0-11.57-6.47-21.25-15.66-26.87.76-15.02 8.44-28.3 20.69-36.72L296.6 284.5c9.06 2.78 26.44 6.25 46.79 0l278.95-85.7c23.55-7.24 23.55-38.36 0-45.6zM352.79 315.09c-28.53 8.76-52.84 3.92-65.59 0l-145.02-44.55L128 384c0 35.35 85.96 64 192 64s192-28.65 192-64l-14.18-113.47-145.03 44.56z"></path></svg>',
                        'fa-info-circle': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>',
                        'fa-language': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M152.1 236.2c-3.5-12.1-7.8-33.2-7.8-33.2h-.5s-4.3 21.1-7.8 33.2l-11.1 37.5H163l-11-37.5zM616 96H24C10.7 96 0 106.7 0 120v272c0 13.3 10.7 24 24 24h592c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24zM233.6 371.3l-11.2 33.4h-56.6l66.5-192h56.6l66.5 192h-56.6l-11.2-33.4h-54zM404 288h56v64h32v-64h56v-32h-56v-64h-32v64h-56v32zm176-128v192h32v-192h-32z"></path></svg>',
                        'fa-tools': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M501.1 395.7L384 278.6c-23.1-23.1-57.6-27.6-85.4-13.9L192 158.1V96L64 0 0 64l96 128h62.1l106.6 106.6c-13.6 27.8-9.2 62.3 13.9 85.4l117.1 117.1c14.6 14.6 38.2 14.6 52.7 0l52.7-52.7c14.5-14.6 14.5-38.2 0-52.7zM331.7 225c28.3 0 54.9 11 74.9 31l19.4 19.4c15.8-6.9 30.8-16.5 43.8-29.5 37.1-37.1 49.7-89.3 37.9-136.7-2.2-9-13.5-12.1-20.1-5.5l-74.4 74.4-67.9-11.3L334 98.9l74.4-74.4c6.6-6.6 3.4-17.9-5.7-20.2-47.4-11.7-99.6.9-136.6 37.9-28.5 28.5-41.9 66.1-41.2 103.6l82.1 82.1c8.1-1.9 16.5-2.9 24.7-2.9zm-103.9 82l-56.7-56.7L18.7 402.8c-25 25-25 65.5 0 90.5s65.5 25 90.5 0l123.6-123.6c-7.6-19.9-9.9-41.6-5-62.7zM64 472c-13.2 0-24-10.8-24-24 0-13.3 10.7-24 24-24s24 10.7 24 24c0 13.2-10.7 24-24 24z"></path></svg>',
                        'fa-heart': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"></path></svg>',
                        'fa-map-marker-alt': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path></svg>',
                        'fa-book': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M448 360V24c0-13.3-10.7-24-24-24H96C43 0 0 43 0 96v320c0 53 43 96 96 96h328c13.3 0 24-10.7 24-24v-16c0-7.5-3.5-14.3-8.9-18.7-4.2-15.4-4.2-59.3 0-74.7 5.4-4.3 8.9-11.1 8.9-18.6zM128 134c0-3.3 2.7-6 6-6h212c3.3 0 6 2.7 6 6v20c0 3.3-2.7 6-6 6H134c-3.3 0-6-2.7-6-6v-20zm0 64c0-3.3 2.7-6 6-6h212c3.3 0 6 2.7 6 6v20c0 3.3-2.7 6-6 6H134c-3.3 0-6-2.7-6-6v-20zm253.4 250H96c-17.7 0-32-14.3-32-32 0-17.6 14.4-32 32-32h285.4c-1.9 17.1-1.9 46.9 0 64z"></path></svg>',
                        'fa-dumbbell': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M104 96H56c-13.3 0-24 10.7-24 24v104H8c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h24v104c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24zm528 128h-24V120c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v272c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V288h24c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM456 32h-48c-13.3 0-24 10.7-24 24v168H256V56c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v400c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V288h128v168c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24z"></path></svg>',
                        'fa-plane': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M480 192H365.71L260.61 8.06A16.014 16.014 0 0 0 246.71 0h-65.5c-10.63 0-18.3 10.17-15.38 20.39L214.86 192H112l-43.2-57.6c-3.02-4.03-7.77-6.4-12.8-6.4H16.01C5.6 128-2.04 137.78.49 147.88L32 256 .49 364.12C-2.04 374.22 5.6 384 16.01 384H56c5.04 0 9.78-2.37 12.8-6.4L112 320h102.86l-49.03 171.6c-2.92 10.22 4.75 20.4 15.38 20.4h65.5c5.74 0 11.04-3.08 13.89-8.06L365.71 320H480c35.35 0 96-28.65 96-64s-60.65-64-96-64z"></path></svg>'
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
                    const icons = document.querySelectorAll('.fas');
                    icons.forEach(replaceIcon);

                    return icons.length;
                }

                // Fonction pour restaurer les icônes originales
                function restoreIcons() {
                    const svgs = document.querySelectorAll('svg[viewBox]');
                    svgs.forEach(svg => {
                        const parent = svg.parentNode;
                        if (parent && svg.previousElementSibling && svg.previousElementSibling.dataset
                            .originalHtml) {
                            const temp = document.createElement('div');
                            temp.innerHTML = svg.previousElementSibling.dataset.originalHtml;
                            parent.replaceChild(temp.firstChild, svg);
                        }
                    });
                }

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

                    // Précharger les polices puis générer le PDF
                    preloadFonts().then(() => {
                        // Remplacer les icônes Font Awesome par des SVG
                        const iconsReplaced = replaceIconsWithSVG();
                        console.log(`${iconsReplaced} icônes remplacées par des SVG`);

                        const {
                            jsPDF
                        } = window.jspdf;
                        const element = document.querySelector("#container-for-pdf");

                        // Optimisations légères pour une meilleure qualité
                        const options = {
                            scale: 2.2,
                            quality: 0.95,
                            bgcolor: '#ffffff',
                            useCORS: true,
                            fontFaces: true
                        };

                        // Ajouter une classe temporaire pour optimiser le rendu PDF
                        element.classList.add('pdf-rendering');

                        // Capture les icônes Font Awesome explicitement avant de générer le PDF
                        const fontAwesomeStyle = document.createElement('style');
                        fontAwesomeStyle.textContent = `
                            .pdf-rendering .fas::before {
                                font-family: 'Font Awesome 5 Free' !important;
                                font-weight: 900 !important;
                                display: inline-block !important;
                                visibility: visible !important;
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
                                    if (document.body.contains(loadingMessage)) {
                                        document.body.removeChild(loadingMessage);
                                    }
                                    // Restaurer les icônes originales
                                    restoreIcons();

                                    const pdf = new jsPDF('p', 'mm', 'a4');
                                    const imgProps = pdf.getImageProperties(dataUrl);
                                    const pdfWidth = pdf.internal.pageSize.getWidth();
                                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                                    pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);

                                    // Nom de fichier avec timestamp
                                    const timestamp = new Date().toISOString().slice(0, 19).replace(
                                        /:/g, '-');
                                    pdf.save(`cv-model11-${timestamp}.pdf`);
                                })
                                .catch(function (error) {
                                    // Nettoyer en cas d'erreur
                                    element.classList.remove('pdf-rendering');
                                    document.head.removeChild(fontAwesomeStyle);
                                    if (document.body.contains(loadingMessage)) {
                                        document.body.removeChild(loadingMessage);
                                    }
                                    // Restaurer les icônes originales
                                    restoreIcons();

                                    console.error(
                                        'Une erreur est survenue lors de la génération du PDF:',
                                        error);
                                    alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                                });
                        }, 600);
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

                <h4>Nouveaux Thèmes</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="graphite-gold">
                        <div class="theme-preview">
                            <div style="background-color: #2c3e50; height: 20px;"></div>
                            <div style="background-color: #f39c12; height: 20px;"></div>
                        </div>
                        <span>Graphite & Or</span>
                    </div>
                    <div class="theme-card" data-theme="forest-beige">
                        <div class="theme-preview">
                            <div style="background-color: #285430; height: 20px;"></div>
                            <div style="background-color: #F5F5DC; height: 20px;"></div>
                        </div>
                        <span>Forêt & Beige</span>
                    </div>
                    <div class="theme-card" data-theme="sapphire-silver">
                        <div class="theme-preview">
                            <div style="background-color: #0f4c81; height: 20px;"></div>
                            <div style="background-color: #bdc3c7; height: 20px;"></div>
                        </div>
                        <span>Saphir & Argent</span>
                    </div>
                    <div class="theme-card" data-theme="ruby-pearl">
                        <div class="theme-preview">
                            <div style="background-color: #9B1B30; height: 20px;"></div>
                            <div style="background-color: #FDEEF4; height: 20px;"></div>
                        </div>
                        <span>Rubis & Perle</span>
                    </div>
                    <div class="theme-card" data-theme="mocha-latte">
                        <div class="theme-preview">
                            <div style="background-color: #6f4e37; height: 20px;"></div>
                            <div style="background-color: #f3e9e4; height: 20px;"></div>
                        </div>
                        <span>Moka & Latte</span>
                    </div>
                </div>

                <h3>Couleur des dates</h3>
                <div class="date-color-selector">
                    <div class="color-option" data-color="#888" style="background-color: #888;"></div>
                    <div class="color-option" data-color="#555" style="background-color: #555;"></div>
                    <div class="color-option" data-color="#777" style="background-color: #777;"></div>
                    <div class="color-option" data-color="#333" style="background-color: #333;"></div>
                    <div class="color-option" data-color="#666" style="background-color: #666;"></div>
                </div>

                <h3>Polices de caractères</h3>
                <div class="font-selector">
                    <div class="font-card" data-font="Arial">
                        <span style="font-family: Arial;">Arial</span>
                    </div>
                    <div class="font-card" data-font="Roboto">
                        <span style="font-family: Roboto;">Roboto</span>
                    </div>
                    <div class="font-card" data-font="Montserrat">
                        <span style="font-family: Montserrat;">Montserrat</span>
                    </div>
                    <div class="font-card" data-font="Poppins">
                        <span style="font-family: Poppins;">Poppins</span>
                    </div>
                    <div class="font-card" data-font="Georgia">
                        <span style="font-family: Georgia;">Georgia</span>
                    </div>
                    <div class="font-card" data-font="Lato">
                        <span style="font-family: 'Lato', sans-serif;">Lato</span>
                    </div>
                    <div class="font-card" data-font="Raleway">
                        <span style="font-family: 'Raleway', sans-serif;">Raleway</span>
                    </div>
                    <div class="font-card" data-font="'Merriweather', serif">
                        <span style="font-family: 'Merriweather', serif;">Merriweather</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container du CV -->
        <div class="container" id="cv-container">
            <!-- Entête du CV avec photo, nom, et informations de contact -->
            <div class="cv-header">
                <div class="photo-section">
                    <div class="profile-photo">
                        <?php if (isset($userss['images'])): ?>
                            <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil" class="customizable-image"
                                id="profile-image">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="header-info">
                    <h1><?= $userss['nom'] ?></h1>
                    <div class="contact-info">
                        <span><i class="fas fa-briefcase"></i>
                            <?php if (isset($userss['competences'])): ?>
                                <?= $userss['competences'] ?>
                            <?php else: ?>
                                <p class="texte">Aucune compétence trouvée</p>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenu du CV avec colonnes gauche et droite -->
            <div class="cv-content">
                <!-- Colonne gauche -->
                <div class="left-column">
                    <!-- Profil -->
                    <div class="section">
                        <h2><i class="fas fa-user"></i> Profil</h2>
                        <?php if (empty($descriptions)): ?>
                            <p class="texte">Aucune description trouvée</p>
                        <?php else: ?>
                            <p class="texte"><?= $descriptions['description'] ?></p>
                        <?php endif; ?>

                    </div>

                    <!-- Expérience professionnelle -->
                    <div class="section">
                        <h2><i class="fas fa-briefcase"></i> Expérience professionnelle</h2>

                        <?php if (empty($afficheMetier)): ?>
                            <p class="texte">Aucune expérience professionnelle trouvée</p>
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
                            $nombre_metier = 2;

                            // Combiner les expériences en donnant priorité aux mises en avant
                            $experiences_a_afficher = array_slice(array_merge(
                                $experiences_mises_en_avant,
                                $experiences_non_mises_en_avant
                            ), 0, $nombre_metier);

                            foreach ($experiences_a_afficher as $Metiers):
                                ?>
                                <div class="experience">
                                    <h3><?= $Metiers['metier'] ?></h3>
                                    <p class="period"><?= $Metiers['moisDebut'] ?>         <?= $Metiers['anneeDebut'] ?> à
                                        <?= $Metiers['moisFin'] ?>         <?= $Metiers['anneeFin'] ?>
                                    </p>
                                    <p class="texte"><?= $Metiers['description'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Formation -->
                    <div class="section">
                        <h2><i class="fas fa-graduation-cap"></i> Formation</h2>
                        <?php if (empty($formationUsers)): ?>
                            <p class="texte">Aucune formation trouvée</p>
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
                            $nombre_formations = 3;

                            // Combiner les formations en donnant priorité aux mises en avant
                            $formations_a_afficher = array_slice(array_merge(
                                $formations_mises_en_avant,
                                $formations_non_mises_en_avant
                            ), 0, $nombre_formations);

                            foreach ($formations_a_afficher as $formation):
                                ?>
                                <div class="education">
                                    <h3><?= $formation['Filiere'] ?></h3>
                                    <p class="texte"><?= $formation['etablissement'] ?>,
                                        <strong><?= $formation['niveau'] ?></strong>
                                    </p>
                                    <p class="period"><?= $formation['moisDebut'] ?>         <?= $formation['anneeDebut'] ?> à
                                        <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="right-column">
                    <!-- Informations personnelles -->
                    <div class="section">
                        <h2><i class="fas fa-info-circle"></i> Informations personnelles</h2>
                        <div class="info-item">
                            <?php if (isset($userss['ville'])): ?>
                                <span class="info-value"><i class="fas fa-map-marker-alt"></i>
                                    <?= $userss['ville'] ?></span>
                            <?php endif; ?>

                            <?php if (isset($userss['phone'])): ?>
                                <span class="info-value"><i class="fas fa-phone"></i> <?= $userss['phone'] ?></span>
                            <?php endif; ?>

                            <?php if (isset($userss['mail'])): ?>
                                <span class="info-value"><i class="fas fa-envelope"></i> <?= $userss['mail'] ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Langues -->
                    <div class="section">
                        <h2><i class="fas fa-language"></i> Langues</h2>
                        <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                            <?php foreach ($afficheLangue as $langue): ?>
                                <div class="skill-item">
                                    <span class="skill-name"><?= $langue['langue'] ?>
                                        <span>(<?= $langue['niveau'] ?>)</span></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="texte">Aucune langue trouvée</p>
                        <?php endif; ?>
                    </div>

                    <!-- Compétences -->
                    <div class="section">
                        <h2><i class="fas fa-tools"></i> Compétences</h2>
                        <?php if (empty($competencesUtilisateur)): ?>
                            <p class="texte">Aucune compétence trouvée</p>
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

                            // Combiner les compétences en donnant priorité aux mises en avant
                            $competences_a_afficher = array_slice(array_merge(
                                $competences_mises_en_avant,
                                $competences_non_mises_en_avant
                            ), 0, $nombre_competences);

                            foreach ($competences_a_afficher as $competence):
                                ?>
                                <div class="skill-item">
                                    <span class="skill-name"><?= $competence['competence'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Centres d'intérêt -->
                    <div class="section">
                        <h2><i class="fas fa-heart"></i> Centres d'intérêt</h2>
                        <?php if (isset($afficheCentreInteret) && !empty($afficheCentreInteret)): ?>
                            <?php foreach ($afficheCentreInteret as $interet): ?>
                                <div class="interest-item">
                                    <i class="fas fa-circle"></i> <?= $interet['interet'] ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="texte">Aucun centre d'intérêt trouvé</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div id="container-for-pdf" class="container">
                <!-- Entête du CV avec photo, nom, et informations de contact -->
                <div class="cv-header">
                    <div class="photo-section">
                        <div class="profile-photo">
                            <?php if (isset($userss['images'])): ?>
                                <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil"
                                    class="customizable-image" id="profile-image">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="header-info">
                        <h1><?= $userss['nom'] ?></h1>
                        <div class="contact-info">
                            <span><i class="fas fa-briefcase"></i>
                                <?php if (isset($userss['competences'])): ?>
                                    <?= $userss['competences'] ?>
                                <?php else: ?>
                                    <p class="texte">Aucune compétence trouvée</p>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contenu du CV avec colonnes gauche et droite -->
                <div class="cv-content">
                    <!-- Colonne gauche -->
                    <div class="left-column">
                        <!-- Profil -->
                        <div class="section">
                            <h2><i class="fas fa-user"></i> Profil</h2>
                            <?php if (empty($descriptions)): ?>
                                <p class="texte">Aucune description trouvée</p>
                            <?php else: ?>
                                <p class="texte"><?= $descriptions['description'] ?></p>
                            <?php endif; ?>

                        </div>

                        <!-- Expérience professionnelle -->
                        <div class="section">
                            <h2><i class="fas fa-briefcase"></i> Expérience professionnelle</h2>

                            <?php if (empty($afficheMetier)): ?>
                                <p class="texte">Aucune expérience professionnelle trouvée</p>
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
                                $nombre_metier = 2;

                                // Combiner les expériences en donnant priorité aux mises en avant
                                $experiences_a_afficher = array_slice(array_merge(
                                    $experiences_mises_en_avant,
                                    $experiences_non_mises_en_avant
                                ), 0, $nombre_metier);

                                foreach ($experiences_a_afficher as $Metiers):
                                    ?>
                                    <div class="experience">
                                        <h3><?= $Metiers['metier'] ?></h3>
                                        <p class="period"><?= $Metiers['moisDebut'] ?>         <?= $Metiers['anneeDebut'] ?> à
                                            <?= $Metiers['moisFin'] ?>         <?= $Metiers['anneeFin'] ?>
                                        </p>
                                        <p class="texte"><?= $Metiers['description'] ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Formation -->
                        <div class="section">
                            <h2><i class="fas fa-graduation-cap"></i> Formation</h2>
                            <?php if (empty($formationUsers)): ?>
                                <p class="texte">Aucune formation trouvée</p>
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
                                $nombre_formations = 3;

                                // Combiner les formations en donnant priorité aux mises en avant
                                $formations_a_afficher = array_slice(array_merge(
                                    $formations_mises_en_avant,
                                    $formations_non_mises_en_avant
                                ), 0, $nombre_formations);

                                foreach ($formations_a_afficher as $formation):
                                    ?>
                                    <div class="education">
                                        <h3><?= $formation['Filiere'] ?></h3>
                                        <p class="texte"><?= $formation['etablissement'] ?>,
                                            <strong><?= $formation['niveau'] ?></strong>
                                        </p>
                                        <p class="period"><?= $formation['moisDebut'] ?>         <?= $formation['anneeDebut'] ?> à
                                            <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="right-column">
                        <!-- Informations personnelles -->
                        <div class="section">
                            <h2><i class="fas fa-info-circle"></i> Informations personnelles</h2>
                            <div class="info-item">
                                <?php if (isset($userss['ville'])): ?>
                                    <span class="info-value"><i class="fas fa-map-marker-alt"></i>
                                        <?= $userss['ville'] ?></span>
                                <?php endif; ?>

                                <?php if (isset($userss['phone'])): ?>
                                    <span class="info-value"><i class="fas fa-phone"></i> <?= $userss['phone'] ?></span>
                                <?php endif; ?>

                                <?php if (isset($userss['mail'])): ?>
                                    <span class="info-value"><i class="fas fa-envelope"></i> <?= $userss['mail'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Langues -->
                        <div class="section">
                            <h2><i class="fas fa-language"></i> Langues</h2>
                            <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                <?php foreach ($afficheLangue as $langue): ?>
                                    <div class="skill-item">
                                        <span class="skill-name"><?= $langue['langue'] ?>
                                            <span>(<?= $langue['niveau'] ?>)</span></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucune langue trouvée</p>
                            <?php endif; ?>
                        </div>

                        <!-- Compétences -->
                        <div class="section">
                            <h2><i class="fas fa-tools"></i> Compétences</h2>
                            <?php if (empty($competencesUtilisateur)): ?>
                                <p class="texte">Aucune compétence trouvée</p>
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

                                // Combiner les compétences en donnant priorité aux mises en avant
                                $competences_a_afficher = array_slice(array_merge(
                                    $competences_mises_en_avant,
                                    $competences_non_mises_en_avant
                                ), 0, $nombre_competences);

                                foreach ($competences_a_afficher as $competence):
                                    ?>
                                    <div class="skill-item">
                                        <span class="skill-name"><?= $competence['competence'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Centres d'intérêt -->
                        <div class="section">
                            <h2><i class="fas fa-heart"></i> Centres d'intérêt</h2>
                            <?php if (isset($afficheCentreInteret) && !empty($afficheCentreInteret)): ?>
                                <?php foreach ($afficheCentreInteret as $interet): ?>
                                    <div class="interest-item">
                                        <i class="fas fa-circle"></i> <?= $interet['interet'] ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucun centre d'intérêt trouvé</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Fonction pour appliquer un thème de couleur
        function applyTheme(themeName) {
            const containers = document.querySelectorAll('#cv-container, #container-for-pdf');
            containers.forEach(container => {
                // Retirer toutes les classes de thème existantes
                container.className = 'container';
                // Ajouter la classe du nouveau thème
                if (themeName) {
                    container.classList.add('theme-' + themeName);
                }
            });
            // Sauvegarder le thème dans le stockage local
            localStorage.setItem('selectedTheme', themeName);
        }

        // Fonction pour appliquer une police
        function applyFont(fontName) {
            const containers = document.querySelectorAll('#cv-container, #container-for-pdf');
            containers.forEach(container => {
                container.style.fontFamily = fontName;
            });
            // Sauvegarder la police dans le stockage local
            localStorage.setItem('selectedFont', fontName);
        }

        // Fonction pour changer la couleur des dates
        function applyDateColor(color) {
            const periods = document.querySelectorAll('#cv-container .period, #container-for-pdf .period');
            periods.forEach(period => {
                period.style.color = color;
            });
            // Sauvegarder la couleur dans le stockage local
            localStorage.setItem('selectedDateColor', color);
        }

        // Initialiser les écouteurs d'événements pour les cartes de thème
        document.addEventListener('DOMContentLoaded', function () {
            // Écouteurs pour les thèmes
            const themeCards = document.querySelectorAll('.theme-card');
            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    const theme = this.getAttribute('data-theme');
                    applyTheme(theme);
                    // Mettre en évidence la carte sélectionnée
                    themeCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Écouteurs pour les polices
            const fontCards = document.querySelectorAll('.font-card');
            fontCards.forEach(card => {
                card.addEventListener('click', function () {
                    const font = this.getAttribute('data-font');
                    applyFont(font);
                    // Mettre en évidence la carte sélectionnée
                    fontCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Écouteurs pour les couleurs de date
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function () {
                    const color = this.getAttribute('data-color');
                    applyDateColor(color);
                    // Mettre en évidence l'option sélectionnée
                    colorOptions.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Restaurer les préférences sauvegardées
            const savedTheme = localStorage.getItem('selectedTheme');
            if (savedTheme) {
                applyTheme(savedTheme);
                const selectedThemeCard = document.querySelector(`.theme-card[data-theme="${savedTheme}"]`);
                if (selectedThemeCard) {
                    selectedThemeCard.classList.add('selected');
                }
            }

            const savedFont = localStorage.getItem('selectedFont');
            if (savedFont) {
                applyFont(savedFont);
                const selectedFontCard = document.querySelector(`.font-card[data-font="${savedFont}"]`);
                if (selectedFontCard) {
                    selectedFontCard.classList.add('selected');
                }
            }

            const savedDateColor = localStorage.getItem('selectedDateColor');
            if (savedDateColor) {
                applyDateColor(savedDateColor);
                const selectedColorOption = document.querySelector(`.color-option[data-color="${savedDateColor}"]`);
                if (selectedColorOption) {
                    selectedColorOption.classList.add('selected');
                }
            }
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