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
    <title>CV Modèle 15</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Merriweather:wght@400;700&family=Montserrat:wght@400;700&family=Poppins:wght@400;700&family=Raleway:wght@400;700&family=Roboto:wght@400;700&family=Nunito:wght@400;700&family=Georgia&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/model15_1.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <script src="image_customizer.js"></script>
    <script src="cv_customizer.js"></script>
    
</head>

<body>
    <button id="toggle-customization-btn" class="button12">
        <i class="fa-solid fa-palette"></i> Personnaliser
    </button>

    <!-- Bouton de téléchargement fixe toujours visible -->
    <button id="fixed-download-btn" class="fixed-download-button" onclick="generatePDF()">
        <i class="fa-solid fa-download"></i>
        <span>Télécharger PDF</span>
    </button>
    <!-- Section de personnalisation -->
    <section class="section3">
        <div class="personnalisation" id="customization-panel">
            <button id="close-panel-btn" class="close-panel-btn">&times;</button>
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <button class="button-reset" onclick="resetStyles()">Réinitialiser les styles</button>

            <script>
                // Fonction pour remplacer temporairement les icônes Font Awesome par des SVG pour le PDF
                function replaceIconsWithSVG() {
                    const iconMap = {
                        'fa-phone': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path></svg>',
                        'fa-envelope': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg>',
                        'fa-map-marker-alt': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path></svg>',
                        'fa-briefcase': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"><path fill="currentColor" d="M320 336c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h416c25.6 0 48-22.4 48-48V288H320v48zm144-208h-80V80c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h512v-80c0-25.6-22.4-48-48-48zm-144 0H192V96h128v32z"></path></svg>',
                        'fa-graduation-cap': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16"><path fill="currentColor" d="M622.34 153.2L343.4 67.5c-15.2-4.67-31.6-4.67-46.79 0L17.66 153.2c-23.54 7.23-23.54 38.36 0 45.59l48.63 14.94c-10.67 13.19-17.23 29.28-17.88 46.9C38.78 266.15 32 276.11 32 288c0 10.78 5.68 19.85 13.86 25.65L20.33 428.53C18.11 438.52 25.71 448 35.94 448h56.11c10.24 0 17.84-9.48 15.62-19.47L82.14 313.65C90.32 307.85 96 298.78 96 288c0-11.57-6.47-21.25-15.66-26.87.76-15.02 8.44-28.3 20.69-36.72L296.6 284.5c9.06 2.78 26.44 6.25 46.79 0l278.95-85.7c23.55-7.24 23.55-38.36 0-45.6zM352.79 315.09c-28.53 8.76-52.84 3.92-65.59 0l-145.02-44.55L128 384c0 35.35 85.96 64 192 64s192-28.65 192-64l-14.18-113.47-145.03 44.56z"></path></svg>',
                        'fa-globe': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" width="16" height="16"><path fill="currentColor" d="M336.5 160C322 70.7 287.8 8 248 8s-74 62.7-88.5 152h177zM152 256c0 22.2 1.2 43.5 3.3 64h185.3c2.1-20.5 3.3-41.8 3.3-64s-1.2-43.5-3.3-64H155.3c-2.1 20.5-3.3 41.8-3.3 64zm324.7-96c-28.6-67.9-86.5-120.4-158-141.6 24.4 33.8 41.2 84.7 50 141.6h108zM177.2 18.4C105.8 39.6 47.8 92.1 19.3 160h108c8.7-56.9 25.5-107.8 49.9-141.6zM487.4 192H372.7c2.1 21 3.3 42.5 3.3 64s-1.2 43-3.3 64h114.6c5.5-20.5 8.6-41.8 8.6-64s-3.1-43.5-8.5-64zM120 256c0-21.5 1.2-43 3.3-64H8.6C3.2 212.5 0 233.8 0 256s3.2 43.5 8.6 64h114.6c-2-21-3.2-42.5-3.2-64zm39.5 96c14.5 89.3 48.7 152 88.5 152s74-62.7 88.5-152h-177zm159.3 141.6c71.4-21.2 129.4-73.7 158-141.6h-108c-8.8 56.9-25.6 107.8-50 141.6zM19.3 352c28.6 67.9 86.5 120.4 158 141.6-24.4-33.8-41.2-84.7-50-141.6h-108z"></path></svg>',
                        'fa-cogs': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16"><path fill="currentColor" d="M512.1 191l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1.1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0L552 6.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zm-10.5-58.8c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.7-82.4 14.3-52.8 52.8zM386.3 286.1l33.7 16.8c10.1 5.8 14.5 18.1 10.5 29.1-8.9 24.2-26.4 46.4-42.6 65.8-7.4 8.9-20.2 11.1-30.3 5.3l-29.1-16.8c-16 13.7-34.6 24.6-54.9 31.7v33.6c0 11.6-8.3 21.6-19.7 23.6-24.6 4.2-50.4 4.4-75.9 0-11.5-2-20-11.9-20-23.6V418c-20.3-7.2-38.9-18-54.9-31.7L74 403c-10 5.8-22.9 3.6-30.3-5.3-16.2-19.4-33.3-41.6-42.2-65.7-4-10.9.4-23.2 10.5-29.1l33.3-16.8c-3.9-20.9-3.9-42.4 0-63.4L12 205.8c-10.1-5.8-14.6-18.1-10.5-29 8.9-24.2 26-46.4 42.2-65.8 7.4-8.9 20.2-11.1 30.3-5.3l29.1 16.8c16-13.7 34.6-24.6 54.9-31.7V57.1c0-11.5 8.2-21.5 19.6-23.5 24.6-4.2 50.5-4.4 76-.1 11.5 2 20 11.9 20 23.6v33.6c20.3 7.2 38.9 18 54.9 31.7l29.1-16.8c10-5.8 22.9-3.6 30.3 5.3 16.2 19.4 33.2 41.6 42.1 65.8 4 10.9-.5 23.2-10.5 29.1l-33.2 16.8c3.9 20.9 3.9 42.4 0 63.4zm-175.3-92.1c-31.4-31.4-84.5-20.7-103.8 21.9-19.3 42.5 10.9 92.5 58.2 89.2 37.8-2.7 71.7-40.2 59.7-77.4-1.2-3.9-2.9-7.4-5.1-10.8-8.4-13-20.8-22.9-35.4-25.2-5.9-1-4.4-10.7 2.1-9.5 24.7 4.2 42.6 26.4 45.4 51.1 3.2 28.2-14.5 54.8-38.9 67-39.3 19.7-87.4-14.4-87.2-59.6-.1-28.9 20.1-53.5 46.7-62.6 35.9-12.2 73.6 11 81.3 51.5 1 5.7-7.3 8.5-9.1 3.2-15.5-37.3-63.4-49.4-93.9-21.8-20.7 18.9-20.7 49.4-4.9 70.6 19.9 26.7 59.2 28.5 81.4 4.8 20.3-21.6 16.8-59.6-8.9-76.6-5.9-3.8-.8-13.1 6.1-9.8 25.3 11.8 36.9 43.7 25 71.8-13.3 31.7-53.7 45.6-86.2 31.9-43.4-18.4-50.8-77.4-13.7-106.8 37.1-29.4 93.1-18.7 111.9 25.1 3 7-7.3 12.7-11.1 6.4-17.7-29.7-62-31.6-86.9-4.7-12.5 13.5-15.4 32.8-9.8 49.2z"></path></svg>',
                        'fa-heart': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"></path></svg>'
                    };

                    // Fonction pour remplacer une icône par son SVG
                    function replaceIcon(element) {
                        const classNames = Array.from(element.classList);
                        for (const className of classNames) {
                            if (iconMap[className]) {
                                const temp = document.createElement('div');
                                temp.innerHTML = iconMap[className];

                                // Récupérer la couleur courante de l'icône
                                const currentColor = window.getComputedStyle(element).color;

                                // Appliquer la couleur au SVG
                                const svg = temp.firstChild;
                                svg.style.color = currentColor;

                                // Stocker l'élément original
                                element.dataset.originalHtml = element.outerHTML;

                                // Remplacer l'élément par le SVG
                                element.parentNode.replaceChild(svg, element);
                                return;
                            }
                        }
                    }

                    // Rechercher et remplacer toutes les icônes
                    const icons = document.querySelectorAll('.fas, .far, .fab');
                    icons.forEach(replaceIcon);

                    return icons.length;
                }

                // Fonction pour restaurer les icônes originales
                function restoreIcons() {
                    const svgs = document.querySelectorAll('svg[viewBox]');
                    svgs.forEach(svg => {
                        const previousElement = svg.previousElementSibling;
                        if (previousElement && previousElement.dataset && previousElement.dataset.originalHtml) {
                            const temp = document.createElement('div');
                            temp.innerHTML = previousElement.dataset.originalHtml;
                            svg.parentNode.replaceChild(temp.firstChild, svg);
                        }
                    });
                }

                // Fonction pour précharger les polices avant la génération du PDF
                function preloadFonts() {
                    return new Promise((resolve) => {
                        // Créer un élément temporaire avec toutes les icônes utilisées
                        const tempDiv = document.createElement('div');
                        tempDiv.style.opacity = '0';
                        tempDiv.style.position = 'absolute';
                        tempDiv.style.top = '-9999px';
                        tempDiv.innerHTML = `
                            <i class="fas fa-phone"></i>
                            <i class="fas fa-envelope"></i>
                            <i class="fas fa-map-marker-alt"></i>
                            <i class="fas fa-briefcase"></i>
                            <i class="fas fa-graduation-cap"></i>
                            <i class="fas fa-globe"></i>
                            <i class="fas fa-cogs"></i>
                            <i class="fas fa-heart"></i>
                        `;
                        document.body.appendChild(tempDiv);

                        // Donner un peu de temps pour charger les polices
                        setTimeout(() => {
                            document.body.removeChild(tempDiv);
                            resolve();
                        }, 500);
                    });
                }

                // Fonction pour réinitialiser tous les styles
                function resetStyles() {
                    if (confirm("Êtes-vous sûr de vouloir réinitialiser tous les styles ?")) {
                        // Supprimer toutes les données du localStorage concernant le CV
                        localStorage.removeItem('cv15_theme');
                        localStorage.removeItem('cv15_primary_color');
                        localStorage.removeItem('cv15_secondary_color');
                        localStorage.removeItem('cv15_date_color');
                        localStorage.removeItem('cv15_font');

                        // Réinitialiser les variables CSS aux valeurs par défaut
                        document.documentElement.style.setProperty('--primary-color', '#e2bd5a');
                        document.documentElement.style.setProperty('--secondary-color', '#464a57');
                        document.documentElement.style.setProperty('--accent-color', '#e2bd5a');

                        // Réinitialiser la police
                        document.body.style.fontFamily = 'Montserrat, sans-serif';

                        // Réinitialiser la couleur des dates
                        const timelineDates = document.querySelectorAll('.timeline-date');
                        timelineDates.forEach(date => {
                            date.style.color = '#666';
                        });

                        // Réinitialiser l'état actif des cartes de thème
                        const themeCards = document.querySelectorAll('.theme-card');
                        themeCards.forEach(card => card.classList.remove('active'));
                        const defaultTheme = document.querySelector('.theme-card[data-theme="classique"]');
                        if (defaultTheme) {
                            defaultTheme.classList.add('active');
                        }

                        // Réinitialiser l'état actif des options de couleur
                        const colorOptions = document.querySelectorAll('.color-option');
                        colorOptions.forEach(option => option.classList.remove('active'));
                        const defaultColor = document.querySelector('.color-option[data-color="#464a57"]');
                        if (defaultColor) {
                            defaultColor.classList.add('active');
                        }

                        // Réinitialiser l'état actif des cartes de police
                        const fontCards = document.querySelectorAll('.font-card');
                        fontCards.forEach(card => card.classList.remove('active'));
                        const defaultFont = document.querySelector('.font-card[data-font="Montserrat"]');
                        if (defaultFont) {
                            defaultFont.classList.add('active');
                        }

                        alert("Les styles ont été réinitialisés avec succès.");
                    }
                }

                // PDF generation function
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
                        // Remplacer les icônes Font Awesome par des SVG avant la génération
                        const iconsReplaced = replaceIconsWithSVG();
                        console.log(`${iconsReplaced} icônes remplacées par des SVG`);

                        const { jsPDF } = window.jspdf;
                        // Utiliser querySelector au lieu de getElementById car la classe est utilisée
                        const element = document.querySelector("#cv-container-for-pdf");

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

                        // Attendre un délai pour la stabilité
                        setTimeout(() => {
                            domtoimage.toJpeg(element, options)
                                .then(function (dataUrl) {
                                    // Restaurer les icônes originales
                                    restoreIcons();

                                    // Supprimer le message d'attente
                                    if (document.body.contains(loadingMessage)) {
                                        document.body.removeChild(loadingMessage);
                                    }

                                    const pdf = new jsPDF('p', 'mm', 'a4');
                                    const imgProps = pdf.getImageProperties(dataUrl);
                                    const pdfWidth = pdf.internal.pageSize.getWidth();
                                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                                    pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                                    pdf.save("cv-model15-" + Date.now() + ".pdf");
                                })
                                .catch(function (error) {
                                    console.error('Une erreur est survenue lors de la génération du PDF:', error);
                                    // Restaurer les icônes originales en cas d'erreur
                                    restoreIcons();
                                    // Supprimer le message d'attente en cas d'erreur
                                    if (document.body.contains(loadingMessage)) {
                                        document.body.removeChild(loadingMessage);
                                    }
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
                    <div class="theme-card" data-theme="classique" data-primary="#464a57" data-secondary="#9a9a9a">
                        <div class="theme-preview">
                            <div style="background-color: #464a57; height: 20px;"></div>
                            <div style="background-color: #9a9a9a; height: 20px;"></div>
                        </div>
                        <span>Classique</span>
                    </div>
                    <div class="theme-card" data-theme="marine" data-primary="#1a487f" data-secondary="#4d79a8">
                        <div class="theme-preview">
                            <div style="background-color: #1a487f; height: 20px;"></div>
                            <div style="background-color: #4d79a8; height: 20px;"></div>
                        </div>
                        <span>Marine</span>
                    </div>
                    <div class="theme-card" data-theme="corporate" data-primary="#343b80" data-secondary="#7378c7">
                        <div class="theme-preview">
                            <div style="background-color: #343b80; height: 20px;"></div>
                            <div style="background-color: #7378c7; height: 20px;"></div>
                        </div>
                        <span>Corporate</span>
                    </div>
                    <div class="theme-card" data-theme="ardoise" data-primary="#395649" data-secondary="#7e8e88">
                        <div class="theme-preview">
                            <div style="background-color: #395649; height: 20px;"></div>
                            <div style="background-color: #7e8e88; height: 20px;"></div>
                        </div>
                        <span>Ardoise</span>
                    </div>
                </div>

                <h4>Couleurs vives</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="emeraude" data-primary="#076759" data-secondary="#2ea495">
                        <div class="theme-preview">
                            <div style="background-color: #076759; height: 20px;"></div>
                            <div style="background-color: #2ea495; height: 20px;"></div>
                        </div>
                        <span>Émeraude</span>
                    </div>
                    <div class="theme-card" data-theme="violet" data-primary="#6c3483" data-secondary="#b993d6">
                        <div class="theme-preview">
                            <div style="background-color: #6c3483; height: 20px;"></div>
                            <div style="background-color: #b993d6; height: 20px;"></div>
                        </div>
                        <span>Violet</span>
                    </div>
                    <div class="theme-card" data-theme="ocean" data-primary="#2874a6" data-secondary="#7fb3d5">
                        <div class="theme-preview">
                            <div style="background-color: #2874a6; height: 20px;"></div>
                            <div style="background-color: #7fb3d5; height: 20px;"></div>
                        </div>
                        <span>Océan</span>
                    </div>
                    <div class="theme-card" data-theme="rubis" data-primary="#922b21" data-secondary="#e6b0aa">
                        <div class="theme-preview">
                            <div style="background-color: #922b21; height: 20px;"></div>
                            <div style="background-color: #e6b0aa; height: 20px;"></div>
                        </div>
                        <span>Rubis</span>
                    </div>
                </div>

                <h4>Nouveaux Thèmes</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="graphite-gold" data-primary="#2c3e50" data-secondary="#f39c12">
                         <div class="theme-preview">
                            <div style="background-color: #2c3e50; height: 20px;"></div>
                            <div style="background-color: #f39c12; height: 20px;"></div>
                        </div>
                        <span>Graphite & Or</span>
                    </div>
                    <div class="theme-card" data-theme="forest-beige" data-primary="#285430" data-secondary="#A3B18A">
                        <div class="theme-preview">
                            <div style="background-color: #285430; height: 20px;"></div>
                            <div style="background-color: #A3B18A; height: 20px;"></div>
                        </div>
                        <span>Forêt & Sauge</span>
                    </div>
                    <div class="theme-card" data-theme="sapphire-silver" data-primary="#0f4c81" data-secondary="#bdc3c7">
                        <div class="theme-preview">
                            <div style="background-color: #0f4c81; height: 20px;"></div>
                            <div style="background-color: #bdc3c7; height: 20px;"></div>
                        </div>
                        <span>Saphir & Argent</span>
                    </div>
                     <div class="theme-card" data-theme="ruby-pearl" data-primary="#9B1B30" data-secondary="#e0e0e0">
                        <div class="theme-preview">
                            <div style="background-color: #9B1B30; height: 20px;"></div>
                            <div style="background-color: #e0e0e0; height: 20px;"></div>
                        </div>
                        <span>Rubis & Perle</span>
                    </div>
                    <div class="theme-card" data-theme="mocha-latte" data-primary="#6f4e37" data-secondary="#c7b8ae">
                        <div class="theme-preview">
                            <div style="background-color: #6f4e37; height: 20px;"></div>
                            <div style="background-color: #c7b8ae; height: 20px;"></div>
                        </div>
                        <span>Moka & Latte</span>
                    </div>
                </div>

                <h4>Couleur des dates</h4>
                <div class="color-date-selector">
                    <div class="color-option" data-color="#919191" style="background-color: #919191;"></div>
                    <div class="color-option active" data-color="#464a57" style="background-color: #464a57;"></div>
                    <div class="color-option" data-color="#767676" style="background-color: #767676;"></div>
                    <div class="color-option" data-color="#333333" style="background-color: #333333;"></div>
                    <div class="color-option" data-color="#555555" style="background-color: #555555;"></div>
                </div>

                <h4>Polices de caractères</h4>
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



        <div id="cv-container-visible" class="cv-container">
            <!-- Header with name and contact -->
            <div class="header">
                <div class="personal-info">
                    <?php if (isset($userss['nom'])): ?>
                        <h1 class="name"><?= strtoupper(explode(' ', $userss['nom'])[0] ?? 'PRÉNOM') ?></h1>
                        <h1 class="surname"><?= strtoupper(explode(' ', $userss['nom'])[1] ?? 'NOM') ?></h1>
                        <h3 class="profession"><?= $userss['competences'] ?></h3>
                    <?php else: ?>
                        <h1 class="name">PRÉNOM</h1>
                        <h1 class="surname">NOM</h1>
                    <?php endif; ?>
                </div>
                <div class="contact-info">
                    <div class="contact-item">
                        <div>
                            <div class="contact-value">
                                <?php if (isset($userss['phone'])): ?>
                                    <?= $userss['phone'] ?>
                                <?php else: ?>
                                    + 00 1234 56789
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div>
                            <div class="contact-value">
                                <?php if (isset($userss['mail'])): ?>
                                    <?= $userss['mail'] ?>
                                <?php else: ?>
                                    info@example.com
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div>
                            <div class="contact-value">
                                <?php if (isset($userss['ville'])): ?>
                                    <?= $userss['ville'] ?>
                                <?php else: ?>
                                    Address here, City, 1234
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile section -->
            <div class="section-profile">
                <div class="profile-content">
                    <h2 class="section-title">PROFIL</h2>
                    <p class="profile-text">
                        <?php if (isset($descriptions) && !empty($descriptions['description'])): ?>
                            <?= $descriptions['description'] ?>
                        <?php else: ?>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the
                            industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                            type
                            and scrambled it to make a type specimen book.
                        <?php endif; ?>
                    </p>
                </div>
                <div class="profile-photo">
                    <?php if (isset($userss['images'])): ?>
                        <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil">
                    <?php else: ?>
                        <img src="../image/image-2.webp" alt="Profile Photo">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Main content -->
            <div class="main-content">
                <!-- Left column - Experience and Education -->
                <div class="left-column">
                    <!-- Work Experience -->
                    <div class="section">
                        <div class="section-header">
                            <h2>EXPERIENCES PROFESSIONNELLES</h2>
                            <div class="section-icon">
                                <i class="fas fa-briefcase" style="color: var(--primary-color);"></i>
                            </div>
                        </div>
                        <div class="timeline">
                            <?php if (isset($afficheMetier) && !empty($afficheMetier)): ?>
                                <?php foreach ($afficheMetier as $metier): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <span class="timeline-date">
                                            <?= $metier['moisDebut'] ?>         <?= $metier['anneeDebut'] ?> -
                                            <?= $metier['moisFin'] ?>         <?= $metier['anneeFin'] ?>
                                        </span>
                                        <h3 class="timeline-title"><?= $metier['metier'] ?></h3>
                                        <p class="timeline-description">
                                            <?= $metier['description'] ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune expérience professionnelle trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Languages Section -->
                    <div class="section">
                        <div class="section-header">
                            <h2>LANGUES</h2>
                            <div class="section-icon">
                                <i class="fas fa-globe" style="color: var(--primary-color);"></i>
                            </div>
                        </div>
                        <div class="languages">
                            <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                <?php foreach ($afficheLangue as $langue): ?>
                                    <div class="language-item">
                                        
                                        <div class="language-name"><?= $langue['langue'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                               <p>Aucune langue pour le moment</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right column - Education, Skills, Languages -->
                <div class="right-column">
                    <!-- Education -->
                    <div class="section">
                        <div class="section-header">
                            <h2>FORMATIONS</h2>
                            <div class="section-icon">
                                <i class="fas fa-graduation-cap" style="color: var(--primary-color);"></i>
                            </div>
                        </div>
                        <div class="timeline">
                            <?php if (isset($formationUsers) && !empty($formationUsers)): ?>
                                <?php foreach ($formationUsers as $formation): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <span class="timeline-date">
                                            <?= $formation['moisDebut'] ?>         <?= $formation['anneeDebut'] ?> -
                                            <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                        </span>
                                        <h3 class="timeline-title"><?= $formation['Filiere'] ?></h3>
                                        <p class="timeline-company"><?= $formation['etablissement'] ?>
                                            <strong><?= $formation['niveau'] ?></strong>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune formation trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Skills Section -->
                    <div class="section">
                        <div class="section-header">
                            <h2>COMPETENCES</h2>
                            <div class="section-icon">
                                <i class="fas fa-cogs" style="color: var(--primary-color);"></i>
                            </div>
                        </div>
                        <div class="skills-content">
                            <?php if (isset($competencesUtilisateurLimit7) && !empty($competencesUtilisateurLimit7)): ?>
                                <?php foreach ($competencesUtilisateurLimit7 as $index => $competence): ?>
                                    <?php
                                    $niveau = isset($competence['niveau']) ? intval($competence['niveau']) : 4;
                                    $stars = min(5, max(1, $niveau));
                                    ?>
                                    <div class="skills-item">
                                        <div class="skill-name">
                                            <span><?= strtoupper($competence['competence']) ?></span>
                                            <div class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= $stars): ?>
                                                        <span class="star">★</span>
                                                    <?php else: ?>
                                                        <span class="star-empty">★</span>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune compétence trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Interests Section -->
                </div>
            </div>
        </div>

        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div id="cv-container-for-pdf" class="cv-container">
                <!-- Header with name and contact -->
                <div class="header">
                    <div class="personal-info">
                        <?php if (isset($userss['nom'])): ?>
                            <h1 class="name"><?= strtoupper(explode(' ', $userss['nom'])[0] ?? 'PRÉNOM') ?></h1>
                            <h1 class="surname"><?= strtoupper(explode(' ', $userss['nom'])[1] ?? 'NOM') ?></h1>
                            <h3 class="profession"><?= $userss['competences'] ?></h3>
                        <?php else: ?>
                           <p>Aucun nom pour le moment</p>
                        <?php endif; ?>
                    </div>
                    <div class="contact-info">
                        <div class="contact-item">
                            <div>
                                <div class="contact-value">
                                    <?php if (isset($userss['phone'])): ?>
                                        <?= $userss['phone'] ?>
                                    <?php else: ?>
                                       <p>Aucune téléphone pour le moment</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div>
                                <div class="contact-value">
                                    <?php if (isset($userss['mail'])): ?>
                                        <?= $userss['mail'] ?>
                                    <?php else: ?>
                                       <p>Aucune email pour le moment</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div>
                                <div class="contact-value">
                                    <?php if (isset($userss['ville'])): ?>
                                        <?= $userss['ville'] ?>
                                    <?php else: ?>
                                       <p>Aucune ville pour le moment</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile section -->
                <div class="section-profile">
                    <div class="profile-content">
                        <h2 class="section-title">PROFIL</h2>
                        <p class="profile-text">
                            <?php if (isset($descriptions) && !empty($descriptions['description'])): ?>
                                <?= $descriptions['description'] ?>
                            <?php else: ?>
                              <p>Aucun description pour le moment</p>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="profile-photo">
                        <?php if (isset($userss['images'])): ?>
                            <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil">
                        <?php else: ?>
                            <img src="../image/image-2.webp" alt="Profile Photo">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Main content -->
                <div class="main-content">
                    <!-- Left column - Experience and Education -->
                    <div class="left-column">
                        <!-- Work Experience -->
                        <div class="section">
                            <div class="section-header">
                                <h2>EXPERIENCES PROFESSIONNELLES</h2>
                                <div class="section-icon">
                                    <i class="fas fa-briefcase" style="color: var(--primary-color);"></i>
                                </div>
                            </div>
                            <div class="timeline">
                                <?php if (isset($afficheMetier) && !empty($afficheMetier)): ?>
                                    <?php foreach ($afficheMetier as $metier): ?>
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <span class="timeline-date">
                                                <?= $metier['moisDebut'] ?>         <?= $metier['anneeDebut'] ?> -
                                                <?= $metier['moisFin'] ?>         <?= $metier['anneeFin'] ?>
                                            </span>
                                            <h3 class="timeline-title"><?= $metier['metier'] ?></h3>
                                            <p class="timeline-description">
                                                <?= $metier['description'] ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune expérience professionnelle trouvée</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Languages Section -->
                        <div class="section">
                            <div class="section-header">
                                <h2>LANGUES</h2>
                                <div class="section-icon">
                                    <i class="fas fa-globe" style="color: var(--primary-color);"></i>
                                </div>
                            </div>
                            <div class="languages">
                                <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                    <?php foreach ($afficheLangue as $langue): ?>
                                        <div class="language-item">
                                            <div class="language-name"><?= $langue['langue'] ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                   <p>Aucune langue pour le moment</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right column - Education, Skills, Languages -->
                    <div class="right-column">
                        <!-- Education -->
                        <div class="section">
                            <div class="section-header">
                                <h2>FORMATIONS</h2>
                                <div class="section-icon">
                                    <i class="fas fa-graduation-cap" style="color: var(--primary-color);"></i>
                                </div>
                            </div>
                            <div class="timeline">
                                <?php if (isset($formationUsers) && !empty($formationUsers)): ?>
                                    <?php foreach ($formationUsers as $formation): ?>
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <span class="timeline-date">
                                                <?= $formation['moisDebut'] ?>         <?= $formation['anneeDebut'] ?> -
                                                <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                            </span>
                                            <h3 class="timeline-title"><?= $formation['Filiere'] ?></h3>
                                            <p class="timeline-company"><?= $formation['etablissement'] ?>
                                                <strong><?= $formation['niveau'] ?></strong>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune formation trouvée</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Skills Section -->
                        <div class="section">
                            <div class="section-header">
                                <h2>COMPETENCES</h2>
                                <div class="section-icon">
                                    <i class="fas fa-cogs" style="color: var(--primary-color);"></i>
                                </div>
                            </div>
                            <div class="skills-content">
                                <?php if (isset($competencesUtilisateurLimit7) && !empty($competencesUtilisateurLimit7)): ?>
                                    <?php foreach ($competencesUtilisateurLimit7 as $index => $competence): ?>
                                        <?php
                                        $niveau = isset($competence['niveau']) ? intval($competence['niveau']) : 4;
                                        $stars = min(5, max(1, $niveau));
                                        ?>
                                        <div class="skills-item">
                                            <div class="skill-name">
                                                <span><?= strtoupper($competence['competence']) ?></span>
                                                <div class="stars">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <?php if ($i <= $stars): ?>
                                                            <span class="star">★</span>
                                                        <?php else: ?>
                                                            <span class="star-empty">★</span>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune compétence trouvée</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Interests Section -->
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Required scripts for PDF generation and themes -->
    <script>
        // Script pour changer les thèmes et sauvegarder dans localStorage
        document.addEventListener('DOMContentLoaded', function () {
            // Sélection des éléments DOM
            const themeCards = document.querySelectorAll('.theme-card');
            const colorOptions = document.querySelectorAll('.color-option');
            const fontCards = document.querySelectorAll('.font-card');
            const root = document.documentElement;

            // Fonction pour appliquer le thème depuis localStorage
            function applyStoredTheme() {
                const storedPrimaryColor = localStorage.getItem('cv15_primary_color');
                const storedSecondaryColor = localStorage.getItem('cv15_secondary_color');
                const storedDateColor = localStorage.getItem('cv15_date_color');
                const storedFont = localStorage.getItem('cv15_font');
                const storedTheme = localStorage.getItem('cv15_theme');

                // Appliquer les couleurs si elles sont stockées
                if (storedPrimaryColor) {
                    root.style.setProperty('--primary-color', storedPrimaryColor);
                    root.style.setProperty('--accent-color', storedPrimaryColor);
                }

                if (storedSecondaryColor) {
                    root.style.setProperty('--secondary-color', storedSecondaryColor);
                }

                // Appliquer la couleur des dates
                if (storedDateColor) {
                    const timelineDates = document.querySelectorAll('.timeline-date');
                    timelineDates.forEach(date => {
                        date.style.color = storedDateColor;
                    });

                    // Mettre à jour l'état actif
                    colorOptions.forEach(option => {
                        if (option.getAttribute('data-color') === storedDateColor) {
                            option.classList.add('active');
                        } else {
                            option.classList.remove('active');
                        }
                    });
                }

                // Appliquer la police
                if (storedFont) {
                    document.body.style.fontFamily = storedFont;

                    // Mettre à jour l'état actif
                    fontCards.forEach(card => {
                        if (card.getAttribute('data-font') === storedFont) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });
                }

                // Mettre à jour l'état actif du thème
                if (storedTheme) {
                    themeCards.forEach(card => {
                        if (card.getAttribute('data-theme') === storedTheme) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });
                }
            }

            // Changer le thème lors du clic sur une carte de thème
            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Supprimer la classe active de toutes les cartes
                    themeCards.forEach(c => c.classList.remove('active'));

                    // Ajouter la classe active à la carte cliquée
                    this.classList.add('active');

                    // Récupérer les données du thème
                    const theme = this.getAttribute('data-theme');
                    const primaryColor = this.getAttribute('data-primary');
                    const secondaryColor = this.getAttribute('data-secondary');

                    // Appliquer les couleurs du thème
                    root.style.setProperty('--primary-color', primaryColor);
                    root.style.setProperty('--accent-color', primaryColor);
                    root.style.setProperty('--secondary-color', secondaryColor);

                    // Enregistrer dans localStorage
                    localStorage.setItem('cv15_theme', theme);
                    localStorage.setItem('cv15_primary_color', primaryColor);
                    localStorage.setItem('cv15_secondary_color', secondaryColor);
                });
            });

            // Changer la couleur des dates
            colorOptions.forEach(option => {
                option.addEventListener('click', function () {
                    // Supprimer la classe active de toutes les options
                    colorOptions.forEach(o => o.classList.remove('active'));

                    // Ajouter la classe active à l'option cliquée
                    this.classList.add('active');

                    // Récupérer la couleur
                    const color = this.getAttribute('data-color');

                    // Appliquer la couleur à toutes les dates
                    const timelineDates = document.querySelectorAll('.timeline-date');
                    timelineDates.forEach(date => {
                        date.style.color = color;
                    });

                    // Enregistrer dans localStorage
                    localStorage.setItem('cv15_date_color', color);
                });
            });

            // Changer la police
            fontCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Supprimer la classe active de toutes les cartes
                    fontCards.forEach(c => c.classList.remove('active'));

                    // Ajouter la classe active à la carte cliquée
                    this.classList.add('active');

                    // Récupérer la police
                    const font = this.getAttribute('data-font');

                    // Appliquer la police
                    document.body.style.fontFamily = font;

                    // Enregistrer dans localStorage
                    localStorage.setItem('cv15_font', font);
                });
            });

            // Appliquer les styles stockés au chargement
            applyStoredTheme();

            // Définir le thème par défaut si aucun n'est stocké
            if (!localStorage.getItem('cv15_theme')) {
                // Simuler un clic sur le thème classique
                const defaultTheme = document.querySelector('.theme-card[data-theme="classique"]');
                if (defaultTheme) {
                    defaultTheme.click();
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-customization-btn');
            const customPanel = document.getElementById('customization-panel');
            const closeBtn = document.getElementById('close-panel-btn');

            if (toggleBtn && customPanel && closeBtn) {
                // Ouvre le panneau
                toggleBtn.addEventListener('click', function(event) {
                    event.stopPropagation();
                    customPanel.classList.add('active');
                });

                // Ferme le panneau avec la croix
                closeBtn.addEventListener('click', function() {
                    customPanel.classList.remove('active');
                });

                // Ferme le panneau si on clique en dehors
                document.addEventListener('click', function(event) {
                    if (customPanel.classList.contains('active') && !customPanel.contains(event.target) && !toggleBtn.contains(event.target)) {
                        customPanel.classList.remove('active');
                    }
                });
            }
        });
    </script>

    <style>
        /* Styles pour les options de personnalisation */
        .theme-selector {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            max-width: 800px;
        }

        .theme-selector h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .theme-selector h4 {
            font-size: 16px;
            color: #555;
            margin: 20px 0 10px;
            font-weight: 500;
        }

        .themes-container {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .theme-card {
            width: 80px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .theme-card.active {
            box-shadow: 0 0 0 2px #3498db;
        }

        .theme-preview {
            height: 40px;
            overflow: hidden;
        }

        .theme-card span {
            display: block;
            text-align: center;
            padding: 5px 0;
            font-size: 12px;
            background-color: #f9f9f9;
        }

        .color-date-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .color-option.active {
            border-color: #3498db;
        }

        .font-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .font-card {
            padding: 8px 15px;
            border-radius: 4px;
            background-color: #f5f5f5;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .font-card.active {
            background-color: #3498db;
            color: white;
        }

        /* Style pour le bouton de téléchargement */
        .button12 {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .button12:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Style pour le bouton de réinitialisation */
        .button-reset {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 20px;
            margin-left: 10px;
            font-size: 14px;
        }

        .button-reset:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>

  
</body>

</html>