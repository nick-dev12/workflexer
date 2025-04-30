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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model 12 - Artistique & Élégant</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <link rel="stylesheet" href="css/model12.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Cormorant+Garamond:wght@300;400;500&family=Montserrat:wght@300;400;500&family=Poppins:wght@300;400;500;700&family=Roboto:wght@300;400;500&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>

    <section class="section3">
        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>

            <div class="theme-selector">
                <h3>Thèmes de couleurs</h3>
                <div class="themes-section">
                    <h4>Classiques</h4>
                    <div class="themes-container">
                        <div class="theme-card active" data-theme="elegant">
                            <div class="theme-preview">
                                <div style="background-color: #755c4b; height: 20px;"></div>
                                <div style="background-color: #f5f1ec; height: 20px;"></div>
                                <div style="background-color: #d4af37; height: 20px;"></div>
                            </div>
                            <span>Élégant</span>
                        </div>
                        <div class="theme-card" data-theme="creative">
                            <div class="theme-preview">
                                <div style="background-color: #845EC2; height: 20px;"></div>
                                <div style="background-color: #FBEAFF; height: 20px;"></div>
                                <div style="background-color: #B39CD0; height: 20px;"></div>
                            </div>
                            <span>Créatif</span>
                        </div>
                        <div class="theme-card" data-theme="modern">
                            <div class="theme-preview">
                                <div style="background-color: #3D5A80; height: 20px;"></div>
                                <div style="background-color: #E0FBFC; height: 20px;"></div>
                                <div style="background-color: #98C1D9; height: 20px;"></div>
                            </div>
                            <span>Moderne</span>
                        </div>
                        <div class="theme-card" data-theme="mint">
                            <div class="theme-preview">
                                <div style="background-color: #21897E; height: 20px;"></div>
                                <div style="background-color: #F4FFF8; height: 20px;"></div>
                                <div style="background-color: #69B7A8; height: 20px;"></div>
                            </div>
                            <span>Menthe</span>
                        </div>
                    </div>

                    <h4>Tons chauds</h4>
                    <div class="themes-container">
                        <div class="theme-card" data-theme="earthy">
                            <div class="theme-preview">
                                <div style="background-color: #5F4B32; height: 20px;"></div>
                                <div style="background-color: #F0EAE2; height: 20px;"></div>
                                <div style="background-color: #A1887F; height: 20px;"></div>
                            </div>
                            <span>Terre</span>
                        </div>
                        <div class="theme-card" data-theme="ruby">
                            <div class="theme-preview">
                                <div style="background-color: #A31621; height: 20px;"></div>
                                <div style="background-color: #DB5461; height: 20px;"></div>
                                <div style="background-color: #F0EFF4; height: 20px;"></div>
                            </div>
                            <span>Rubis</span>
                        </div>
                        <div class="theme-card" data-theme="autumn">
                            <div class="theme-preview">
                                <div style="background-color: #B85C38; height: 20px;"></div>
                                <div style="background-color: #FDF0D5; height: 20px;"></div>
                                <div style="background-color: #E09F3E; height: 20px;"></div>
                            </div>
                            <span>Automne</span>
                        </div>
                        <div class="theme-card" data-theme="coral">
                            <div class="theme-preview">
                                <div style="background-color: #FF8C61; height: 20px;"></div>
                                <div style="background-color: #FFF8E8; height: 20px;"></div>
                                <div style="background-color: #FFB380; height: 20px;"></div>
                            </div>
                            <span>Corail</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="font-selector-section">
                <h3>Polices de caractères</h3>
                <div class="font-selector">
                    <div class="font-card active" data-font="Cormorant Garamond">
                        <span style="font-family: 'Cormorant Garamond';">Cormorant</span>
                    </div>
                    <div class="font-card" data-font="Playfair Display">
                        <span style="font-family: 'Playfair Display';">Playfair</span>
                    </div>
                    <div class="font-card" data-font="Montserrat">
                        <span style="font-family: 'Montserrat';">Montserrat</span>
                    </div>
                    <div class="font-card" data-font="Roboto">
                        <span style="font-family: 'Roboto';">Roboto</span>
                    </div>
                    <div class="font-card" data-font="Poppins">
                        <span style="font-family: 'Poppins';">Poppins</span>
                    </div>
                    <div class="font-card" data-font="Lato">
                        <span style="font-family: 'Lato';">Lato</span>
                    </div>
                </div>
            </div>

            <div class="text-color-section">
                <h3>Couleur du texte secondaire</h3>
                <div class="text-color-selector">
                    <div class="color-option active" data-color="#777" style="background-color: #777;"></div>
                    <div class="color-option" data-color="#555" style="background-color: #555;"></div>
                    <div class="color-option" data-color="#888" style="background-color: #888;"></div>
                    <div class="color-option" data-color="#333" style="background-color: #333;"></div>
                    <div class="color-option" data-color="#666" style="background-color: #666;"></div>
                    <div class="color-option" data-color="#999" style="background-color: #999;"></div>
                </div>
            </div>

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
                        'fa-phone': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path></svg>',
                        'fa-envelope': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg>',
                        'fa-globe': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M336.5 160C322 70.7 287.8 8 248 8s-74 62.7-88.5 152h177zM152 256c0 22.2 1.2 43.5 3.3 64h185.3c2.1-20.5 3.3-41.8 3.3-64s-1.2-43.5-3.3-64H155.3c-2.1 20.5-3.3 41.8-3.3 64zm324.7-96c-28.6-67.9-86.5-120.4-158-141.6 24.4 33.8 41.2 84.7 50 141.6h108zM177.2 18.4C105.8 39.6 47.8 92.1 19.3 160h108c8.7-56.9 25.5-107.8 49.9-141.6zM487.4 192H372.7c2.1 21 3.3 42.5 3.3 64s-1.2 43-3.3 64h114.6c5.5-20.5 8.6-41.8 8.6-64s-3.1-43.5-8.5-64zM120 256c0-21.5 1.2-43 3.3-64H8.6C3.2 212.5 0 233.8 0 256s3.2 43.5 8.6 64h114.6c-2-21-3.2-42.5-3.2-64zm39.5 96c14.5 89.3 48.7 152 88.5 152s74-62.7 88.5-152h-177zm159.3 141.6c71.4-21.2 129.4-73.7 158-141.6h-108c-8.8 56.9-25.6 107.8-50 141.6zM19.3 352c28.6 67.9 86.5 120.4 158 141.6-24.4-33.8-41.2-84.7-50-141.6h-108z"></path></svg>',
                        'fa-linkedin': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>',
                        'fa-calendar-alt': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"></path></svg>',
                        'fa-map-pin': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512" width="16" height="16" style="margin-right: 10px;"><path fill="currentColor" d="M112 316.94v156.69l22.02 33.02c4.75 7.12 15.22 7.12 19.97 0L176 473.63V316.94c-10.39 1.92-21.06 3.06-32 3.06s-21.61-1.14-32-3.06zM144 0C64.47 0 0 64.47 0 144s64.47 144 144 144 144-64.47 144-144S223.53 0 144 0zm0 76c-37.5 0-68 30.5-68 68 0 6.62-5.38 12-12 12s-12-5.38-12-12c0-50.73 41.28-92 92-92 6.62 0 12 5.38 12 12s-5.38 12-12 12z"></path></svg>'
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
                    const icons = document.querySelectorAll('.fas, .far, .fab');
                    icons.forEach(replaceIcon);

                    return icons.length;
                }

                // Fonction pour restaurer les icônes originales
                function restoreIcons() {
                    const svgs = document.querySelectorAll('svg[viewBox]');
                    svgs.forEach(svg => {
                        if (svg.previousElementSibling && svg.previousElementSibling.dataset && svg.previousElementSibling.dataset.originalHtml) {
                            const temp = document.createElement('div');
                            temp.innerHTML = svg.previousElementSibling.dataset.originalHtml;
                            svg.parentNode.replaceChild(temp.firstChild, svg);
                        } else if (svg.previousSibling && svg.previousSibling.nodeType === Node.ELEMENT_NODE && svg.previousSibling.dataset && svg.previousSibling.dataset.originalHtml) {
                            const temp = document.createElement('div');
                            temp.innerHTML = svg.previousSibling.dataset.originalHtml;
                            svg.parentNode.replaceChild(temp.firstChild, svg);
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
                        const element = document.querySelector(".cv-container");

                        // Définir une échelle plus élevée pour une meilleure qualité
                        const scale = 2;
                        const options = {
                            scale: scale,
                            quality: 2,
                            bgcolor: '#fff',
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
                            .pdf-rendering .fas::before, .pdf-rendering .far::before, .pdf-rendering .fab::before {
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
                                    document.body.removeChild(loadingMessage);
                                    // Restaurer les icônes originales
                                    restoreIcons();

                                    const pdf = new jsPDF('p', 'mm', 'a4');
                                    const imgProps = pdf.getImageProperties(dataUrl);
                                    const pdfWidth = pdf.internal.pageSize.getWidth();
                                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                                    pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                                    pdf.save("cv.pdf");
                                })
                                .catch(function (error) {
                                    console.error('Une erreur est survenue lors de la génération du PDF:', error);
                                    // Supprimer le message d'attente en cas d'erreur
                                    document.body.removeChild(loadingMessage);
                                    // Restaurer les icônes originales en cas d'erreur
                                    restoreIcons();
                                    alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
                                });
                        }, 500);
                    });
                }
            </script>
        </div>

        <div class="cv-container" id="cv-container">
            <div class="artistic-element"></div>

            <div class="cv-header">
                <div class="profile-container">

                    <?php if (isset($userss['images'])): ?>
                        <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil" class="profile-photo"
                            id="profile-image">
                    <?php endif; ?>
                </div>

                <div class="header-content">
                    <h1 class="name-title">
                        <?php if (isset($userss['nom'])): ?>
                            <?= $userss['nom'] ?>
                        <?php else: ?>
                            <p class="texte">Aucune donnée trouvée</p>
                        <?php endif; ?>
                    </h1>
                    <p class="job-title">
                        <?php if (isset($userss['competences'])): ?>
                            <?= $userss['competences'] ?>
                        <?php else: ?>
                        <p class="texte">Aucune compétence trouvée</p>
                    <?php endif; ?>
                    </p>

                    <?php if (isset($descriptions)): ?>
                        <p class="bio"><?= $descriptions['description'] ?></p>
                    <?php else: ?>
                        <p class="bio">Aucune description trouvée</p>
                    <?php endif; ?>

                </div>
            </div>

            <div class="cv-body">
                <div class="left-column">
                    <div class="section contact-section">
                        <h3 class="section-title">Contact</h3>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i>
                                <?php if (isset($userss['ville'])): ?>
                                    <?= $userss['ville'] ?>
                                <?php else: ?>
                                <p class="texte">Aucune ville trouvée</p>
                            <?php endif; ?>
                            </p>
                            <p><i class="fas fa-envelope"></i>
                                <?php if (isset($userss['mail'])): ?>
                                    <?= $userss['mail'] ?>
                                <?php else: ?>
                                <p class="texte">Aucune email trouvée</p>
                            <?php endif; ?>
                            </p>
                            <p><i class="fas fa-phone"></i>
                                <?php if (isset($userss['phone'])): ?>
                                    <?= $userss['phone'] ?>
                                <?php else: ?>
                                <p class="texte">Aucun numéro de téléphone trouvé</p>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <div class="section skills-section">
                        <h3 class="section-title">Compétences</h3>
                        <ul class="skills-list">
                            <?php if (isset($competencesUtilisateurLimit7) && !empty($competencesUtilisateurLimit7)): ?>
                                <?php foreach ($competencesUtilisateurLimit7 as $competence): ?>
                                    <li>
                                        <span class="skill-name" contenteditable="true"><?= $competence['competence']; ?></span>
                                        <div class="skill-bar">
                                            <div class="skill-level" style="width: <?= min(90, 100); ?>%"></div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucune compétence trouvée</p>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="section languages-section">
                        <h3 class="section-title">Langues</h3>
                        <ul class="languages-list">
                            <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                <?php foreach ($afficheLangue as $langue): ?>
                                    <li>
                                        <span contenteditable="true"><?= $langue['langue']; ?></span>
                                        <span class="language-level"
                                            contenteditable="true"><?php echo $langue['niveau']; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucune langue trouvée</p>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="section interests-section">
                        <h3 class="section-title">Centres d'intérêt</h3>
                        <ul class="interests-list">
                            <?php if (isset($afficheCentreInteret) && !empty($afficheCentreInteret)): ?>
                                <?php foreach ($afficheCentreInteret as $interet): ?>
                                    <li contenteditable="true"><?= $interet['interet']; ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucun centre d'intérêt trouvé</p>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="right-column">
                    <div class="section experience-section">
                        <h3 class="section-title">Expérience Professionnelle</h3>

                        <div class="timeline-container">
                            <?php if (isset($afficheMetier) && !empty($afficheMetier)): ?>
                                <?php foreach ($afficheMetier as $metier): ?>
                                    <div class="experience-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-line"></div>
                                        <h4 class="experience-title" contenteditable="true"><?= $metier['metier']; ?></h4>
                                        </p>
                                        <p class="date-location">
                                            <i class="far fa-calendar-alt"></i> <span
                                                contenteditable="true"><?= $metier['moisDebut'] ?>         <?= $metier['anneeDebut'] ?>
                                                à
                                                <?= $metier['moisFin'] ?>         <?= $metier['anneeFin'] ?></span>
                                            <span style="margin: 0 10px">|</span>
                                        </p>
                                        <p class="experience-description" contenteditable="true">
                                            <?= $metier['description']; ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="texte">Aucune expérience professionnelle trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="section education-section">
                        <h3 class="section-title">Formation</h3>

                        <div class="timeline-container">
                            <?php if (isset($formationUsers) && !empty($formationUsers)): ?>
                                <?php foreach ($formationUsers as $formation): ?>
                                    <div class="education-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-line"></div>
                                        <h4 class="education-title" contenteditable="true">
                                            <?php echo $formation['Filiere']; ?>
                                        </h4>
                                        <p class="institution-name" contenteditable="true">
                                            <?php echo $formation['etablissement']; ?>
                                        </p>
                                        <p class="date-location">
                                            <i class="far fa-calendar-alt"></i> <span
                                                contenteditable="true"><?= $formation['moisDebut'] ?>
                                                <?= $formation['anneeDebut'] ?> à
                                                <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?></span>
                                            <span style="margin: 0 10px">|</span>
                                        </p>

                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="education-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-line"></div>
                                    <h4 class="education-title">Master en Direction Artistique</h4>
                                    <p class="institution-name">École Supérieure d'Art et Design</p>
                                    <p class="date-location">
                                        <i class="far fa-calendar-alt"></i> 2012 - 2014
                                        <span style="margin: 0 10px">|</span>
                                        <i class="fas fa-map-pin"></i> Lyon
                                    </p>
                                    <p class="education-description">
                                        Spécialisation en conception visuelle et stratégie de marque. Projet de fin d'études
                                        récompensé par le Prix de l'Innovation Créative.
                                    </p>
                                </div>

                                <div class="education-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-line"></div>
                                    <h4 class="education-title">Licence en Arts Appliqués</h4>
                                    <p class="institution-name">Université des Arts Visuels</p>
                                    <p class="date-location">
                                        <i class="far fa-calendar-alt"></i> 2009 - 2012
                                        <span style="margin: 0 10px">|</span>
                                        <i class="fas fa-map-pin"></i> Paris
                                    </p>
                                    <p class="education-description">
                                        Formation pluridisciplinaire en design graphique, typographie, photographie et
                                        techniques d'illustration.
                                    </p>
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
            // Theme switching functionality
            const themeCards = document.querySelectorAll('.theme-card');
            const cvContainer = document.querySelector('.cv-container');
            const fontCards = document.querySelectorAll('.font-card');
            const colorOptions = document.querySelectorAll('.color-option');

            // Appliquer les paramètres enregistrés au chargement de la page
            function applyStoredSettings() {
                // Récupérer et appliquer le thème
                const storedTheme = localStorage.getItem('cv12_theme');
                if (storedTheme) {
                    // Supprimer toutes les classes de thème
                    cvContainer.classList.remove('theme-elegant', 'theme-creative', 'theme-modern', 'theme-mint', 'theme-earthy', 'theme-ruby', 'theme-autumn', 'theme-coral');

                    // Ajouter la classe du thème enregistré
                    cvContainer.classList.add('theme-' + storedTheme);

                    // Mettre à jour l'état actif de la carte correspondante
                    themeCards.forEach(card => {
                        if (card.getAttribute('data-theme') === storedTheme) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });
                }

                // Récupérer et appliquer la police
                const storedFont = localStorage.getItem('cv12_font');
                if (storedFont) {
                    // Supprimer toutes les classes de police
                    document.body.classList.remove('font-cormorant-garamond', 'font-playfair-display', 'font-montserrat', 'font-roboto', 'font-poppins', 'font-lato');

                    // Ajouter la classe de la police enregistrée
                    document.body.classList.add('font-' + storedFont.toLowerCase().replace(' ', '-'));

                    // Mettre à jour l'état actif de la carte correspondante
                    fontCards.forEach(card => {
                        if (card.getAttribute('data-font') === storedFont) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });

                    // Appliquer la police au conteneur CV
                    document.documentElement.style.setProperty('--main-font', storedFont);
                }

                // Récupérer et appliquer la couleur du texte
                const storedTextColor = localStorage.getItem('cv12_textColor');
                if (storedTextColor) {
                    // Appliquer la couleur au texte secondaire
                    document.documentElement.style.setProperty('--light-text', storedTextColor);

                    // Mettre à jour l'état actif de l'option de couleur
                    colorOptions.forEach(option => {
                        if (option.getAttribute('data-color') === storedTextColor) {
                            option.classList.add('active');
                        } else {
                            option.classList.remove('active');
                        }
                    });
                }
            }

            // Appliquer les paramètres enregistrés au chargement
            applyStoredSettings();

            themeCards.forEach(card => {
                card.addEventListener('click', function () {
                    const theme = this.getAttribute('data-theme');

                    // Remove all theme classes
                    cvContainer.classList.remove('theme-elegant', 'theme-creative', 'theme-modern', 'theme-mint', 'theme-earthy', 'theme-ruby', 'theme-autumn', 'theme-coral');

                    // Add selected theme class
                    cvContainer.classList.add('theme-' + theme);

                    // Update active state
                    themeCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Enregistrer le thème dans localStorage
                    localStorage.setItem('cv12_theme', theme);
                });
            });

            // Font switching functionality
            fontCards.forEach(card => {
                card.addEventListener('click', function () {
                    const font = this.getAttribute('data-font');

                    // Remove all font classes
                    document.body.classList.remove('font-cormorant-garamond', 'font-playfair-display', 'font-montserrat', 'font-roboto', 'font-poppins', 'font-lato');

                    // Add selected font class
                    document.body.classList.add('font-' + font.toLowerCase().replace(' ', '-'));

                    // Update active state
                    fontCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Apply font to CV container
                    document.documentElement.style.setProperty('--main-font', font);

                    // Enregistrer la police dans localStorage
                    localStorage.setItem('cv12_font', font);
                });
            });

            // Text color switching functionality
            colorOptions.forEach(option => {
                option.addEventListener('click', function () {
                    const color = this.getAttribute('data-color');

                    // Apply selected color to secondary text
                    document.documentElement.style.setProperty('--light-text', color);

                    // Update active state
                    colorOptions.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Enregistrer la couleur dans localStorage
                    localStorage.setItem('cv12_textColor', color);
                });
            });
        });
    </script>

</body>

</html>