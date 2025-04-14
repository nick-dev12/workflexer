<?php
// Démarre la session
session_start();

// Include device detection functionality
include_once('check_device.php');

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV1</title>
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">

    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <script src="cv_customizer.js" defer></script>
    <script src="image_customizer.js" defer></script>

    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/model1.css">

</head>

<body>


    <section class="section3">



        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <script>
                function generatePDF() {
                    const { jsPDF } = window.jspdf;
                    const element = document.querySelector("#container");

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
                    margin-bottom: 20px;
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
                document.addEventListener('DOMContentLoaded', function () {
                    // Définition des thèmes
                    const themes = {
                        elegant: {
                            headerBg: '#0E3B43',
                            headerColor: '#ffffff',
                            accentColor: '#328590'
                        },
                        professional: {
                            headerBg: '#1D3557',
                            headerColor: '#F1FAEE',
                            accentColor: '#457B9D'
                        },
                        creative: {
                            headerBg: '#845EC2',
                            headerColor: '#FBEAFF',
                            accentColor: '#B39CD0'
                        },
                        classic: {
                            headerBg: '#4A4A4A',
                            headerColor: '#FFFFFF',
                            accentColor: '#7A7A7A'
                        },
                        modern: {
                            headerBg: '#3D5A80',
                            headerColor: '#E0FBFC',
                            accentColor: '#98C1D9'
                        },
                        earthy: {
                            headerBg: '#5F4B32',
                            headerColor: '#F0EAE2',
                            accentColor: '#A1887F'
                        },
                        corporate: {
                            headerBg: '#1A237E',
                            headerColor: '#FFFFFF',
                            accentColor: '#5C6BC0'
                        },
                        burgundy: {
                            headerBg: '#800020',
                            headerColor: '#F2F2F2',
                            accentColor: '#AD8A8E'
                        },
                        mint: {
                            headerBg: '#21897E',
                            headerColor: '#F4FFF8',
                            accentColor: '#69B7A8'
                        },
                        slate: {
                            headerBg: '#2F4F4F',
                            headerColor: '#E8ECEE',
                            accentColor: '#708090'
                        },
                        amber: {
                            headerBg: '#B86E00',
                            headerColor: '#FFFBF0',
                            accentColor: '#F0A858'
                        }
                    };

                    // Récupérer le numéro du modèle à partir de l'URL
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '1';
                    const storagePrefix = `model${modelNumber}-`;

                    // Ajouter les écouteurs d'événements aux cartes de thème
                    const themeCards = document.querySelectorAll('.theme-card');
                    themeCards.forEach(card => {
                        card.addEventListener('click', function () {
                            // Retirer la classe active de toutes les cartes
                            themeCards.forEach(c => c.classList.remove('active'));

                            // Ajouter la classe active à la carte cliquée
                            this.classList.add('active');

                            // Appliquer le thème
                            const themeName = this.getAttribute('data-theme');
                            applyTheme(themes[themeName]);

                            // Mettre à jour les contrôles de couleur individuels
                            updateColorInputs(themes[themeName]);
                        });
                    });

                    // Fonction pour appliquer un thème
                    function applyTheme(theme) {
                        // Appliquer les couleurs CSS avec des variables personnalisées
                        document.documentElement.style.setProperty('--font-color_titre', theme.headerBg);
                        document.documentElement.style.setProperty('--texte_color_titre', theme.headerColor);
                        document.documentElement.style.setProperty('--font-color_section', theme.accentColor);
                        document.documentElement.style.setProperty('--texte_color_section', '#FFFFFF');

                        // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                        localStorage.setItem(`${storagePrefix}headerBg`, theme.headerBg);
                        localStorage.setItem(`${storagePrefix}headerColor`, theme.headerColor);
                        localStorage.setItem(`${storagePrefix}accentColor`, theme.accentColor);

                        // Sauvegarder pour les contrôles existants
                        localStorage.setItem('font_color_titre1', theme.headerBg);
                        localStorage.setItem('texte_color_titre', theme.headerColor);
                        localStorage.setItem('font_color_section', theme.accentColor);
                        localStorage.setItem('texte_color_section', '#FFFFFF');
                    }

                    // Fonction pour mettre à jour les contrôles de couleur individuels
                    function updateColorInputs(theme) {
                        document.getElementById('fontColor').value = theme.headerBg;
                        document.getElementById('fontColor1').value = theme.headerColor;
                        document.getElementById('fontColor2').value = theme.accentColor;
                        document.getElementById('fontColor3').value = '#FFFFFF';
                    }

                    // Vérifier s'il y a un thème sauvegardé et l'appliquer
                    const savedTheme = {
                        headerBg: localStorage.getItem(`${storagePrefix}headerBg`) || localStorage.getItem('font_color_titre1'),
                        headerColor: localStorage.getItem(`${storagePrefix}headerColor`) || localStorage.getItem('texte_color_titre'),
                        accentColor: localStorage.getItem(`${storagePrefix}accentColor`) || localStorage.getItem('font_color_section')
                    };

                    if (savedTheme.headerBg) {
                        // Retrouver quel thème correspond aux couleurs sauvegardées
                        let matchedTheme = false;
                        for (const [themeName, theme] of Object.entries(themes)) {
                            if (theme.headerBg === savedTheme.headerBg &&
                                theme.headerColor === savedTheme.headerColor) {
                                // Marquer le thème comme actif
                                const themeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                                if (themeCard) themeCard.classList.add('active');
                                matchedTheme = true;
                                break;
                            }
                        }
                    }
                });
            </script>

            <div class="box">
                <p>Couleur de fond des titres principaux </p>
                <input type="color" name="" id="fontColor">
            </div>

            <div class="box">
                <p>Couleur du texte des titres principaux </p>
                <input type="color" name="" id="fontColor1">
            </div>

            <div class="box">
                <p>Couleur de de fond (section informations personnel)</p>
                <input type="color" name="" id="fontColor2">
            </div>

            <div class="box">
                <p>Couleur du texte (section informations personnel)</p>
                <input type="color" name="" id="fontColor3">
            </div>

            <script>
                const colorInput = document.getElementById('fontColor');
                // Récupérer la valeur sauvegardée dans le stockage local (si elle existe)
                const saved_font_color_titre1 = localStorage.getItem('font_color_titre1');

                // Appliquer la couleur sauvegardée ou une valeur par défaut si aucune couleur n'a été sauvegardée
                document.documentElement.style.setProperty('--font-color_titre', saved_font_color_titre1 || '#00587b');
                colorInput.value = saved_font_color_titre1 || '#00587b'; // Mettre à jour la valeur du champ input

                // Écouter les changements sur le champ input
                colorInput.addEventListener('input', function () {
                    // Mettre à jour la valeur de la variable CSS en fonction de la couleur choisie par l'utilisateur
                    const selected_font_color_titre = colorInput.value;
                    document.documentElement.style.setProperty('--font-color_titre', selected_font_color_titre);

                    // Sauvegarder la couleur sélectionnée dans le stockage local
                    localStorage.setItem('font_color_titre1', selected_font_color_titre);
                });



                const colorInput1 = document.getElementById('fontColor2');
                const font_color_section = localStorage.getItem('font_color_section');

                document.documentElement.style.setProperty('--font-color_section', font_color_section || '#e6e6e6');
                colorInput1.value = font_color_section || '#e6e6e6'; // Mettre à jour la valeur du champ input

                colorInput1.addEventListener('input', function () {
                    const selectedColor = colorInput1.value;
                    document.documentElement.style.setProperty('--font-color_section', selectedColor);
                    localStorage.setItem('font_color_section', selectedColor);
                });



                const colorInput01 = document.getElementById('fontColor1');
                const texte_color_titre = localStorage.getItem('texte_color_titre');

                // Appliquer la couleur sauvegardée ou une valeur par défaut si aucune couleur n'a été sauvegardée
                document.documentElement.style.setProperty('--texte-color_titre', texte_color_titre || '#ededed');
                colorInput01.value = texte_color_titre || '#ededed'; // Mettre à jour la valeur du champ input

                // Écouter les changements sur le champ input
                colorInput01.addEventListener('input', function () {
                    const selectedColor = colorInput01.value;
                    document.documentElement.style.setProperty('--texte-color_titre', selectedColor);
                    localStorage.setItem('texte_color_titre', selectedColor);
                });


                const colorInput2 = document.getElementById('fontColor3');
                const texte_color_section = localStorage.getItem('texte_color_section');

                document.documentElement.style.setProperty('--texte-color_section', texte_color_section || '#000000');
                colorInput2.value = texte_color_section || '#000000'; // Mettre à jour la valeur du champ input

                colorInput2.addEventListener('input', function () {
                    const selectedColor = colorInput2.value;
                    document.documentElement.style.setProperty('--texte-color_section', selectedColor);
                    localStorage.setItem('texte_color_section', selectedColor);
                });

            </script>
        </div>

        <div id="box">
            <div id="container" class="container">
                <!-- <div class="haut"></div> -->

                <div class="container-box">

                    <div class="box1">
                        <div class="profil">
                            <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                            <h1 class="nom">
                                <?= $userss['nom'] ?>
                            </h1>
                            <h2 class="profession">
                                <?= $userss['competences'] ?>
                            </h2>
                        </div>

                        <div>
                            <h1 class="text">Profil</h1>
                            <div class="bb">
                                <img src="/image/address.png" alt="">
                                <p>
                                    <strong>
                                        ADRESSE
                                    </strong>
                                    <span>
                                        <?= $userss['ville'] ?>
                                    </span>
                                </p>
                            </div>

                            <div class="bb">
                                <img src="/image/icons8-gmail-48.png" alt="">
                                <p>
                                    <strong>
                                        E-mail
                                    </strong>
                                    <span>
                                        <?= $userss['mail'] ?>
                                    </span>
                                </p>
                            </div>

                            <div class="bb">
                                <img src="/image/phone.png" alt="">
                                <p>
                                    <strong>
                                        TÉLÉPHONE
                                    </strong>
                                    <span>
                                        <?= $userss['phone'] ?>
                                    </span>
                                </p>
                            </div>

                            <div class="bb">
                                <img src="/image/nationalite.png" alt="">
                                <p>
                                    <strong>
                                        NATIONALITÉ
                                    </strong>
                                    <span>*********</span>
                                </p>
                            </div>
                        </div>



                        <div>
                            <h1 class="text"><img src="../image/langue.png" alt=""> Langues</h1>
                            <?php if (empty($afficheLangue)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <ul>
                                        <li>
                                            <?php echo $langues['langue']; ?> <span>(<?php echo $langues['niveau']; ?>)</span>
                                        </li>
                                    </ul>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h1 class="text"> <img src="/image/compétences.png" alt=""> Compétences </h1>
                            <div class="div-comp">
                                <?php if ($competencesUtilisateur): ?>
                                    <?php foreach ($competencesUtilisateur as $competence): ?>
                                        <span class="comp">
                                            <?php echo $competence['competence']; ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>

                                    <h4>Aucune donnée trouvée</h4>
                                <?php endif ?>

                            </div>

                        </div>

                        <div>
                            <h1 class="text"><img src="../image/loisir.png" alt=""> Loisirs</h1>
                            <?php if (empty($afficheCentreInteret)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>
                                <?php foreach ($afficheCentreInteret as $interet): ?>
                                    <ul>
                                        <li>
                                            <?= $interet['interet'] ?>
                                        </li>
                                    </ul>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>



                    <div class="box2">

                        <div class="info_users">
                            <h1 class="text"> <img src="/image/a propos.png" alt=""> À PROPOS </h1>
                            <?php if (empty($descriptions)): ?>
                                <p>Aucune donnée trouvée</p>
                            <?php else: ?>
                                <p class="p">
                                    <?= $descriptions['description'] ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="experiences">
                            <h1 class="text"> <img src="/image/experience.png" alt=""> EXPÉRIENCES PROFESSIONNELLES
                            </h1>

                            <div class="div">
                                <?php if (empty($afficheMetier)): ?>
                                    <h4>Aucune donnée trouvée</h4>
                                <?php else: ?>
                                    <?php
                                    shuffle($afficheMetier);
                                    $nombre_metier = 2
                                        ?>
                                    <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                        <?php if ($key < $nombre_metier): ?>
                                            <div class="div1">
                                                <strong id="strong"></strong>
                                                <div class="info">
                                                    <h4>
                                                        <?= $Metiers['metier'] ?>
                                                    </h4>
                                                    <span><em>
                                                            <?= $Metiers['moisDebut'] ?> /
                                                            <?= $Metiers['anneeDebut'] ?>
                                                        </em> à <em>
                                                            <?= $Metiers['moisFin'] ?> /
                                                            <?= $Metiers['anneeFin'] ?>
                                                        </em></span>
                                                    <p>
                                                        <?= $Metiers['description'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>


                            </div>

                        </div>


                        <div class="experiences">
                            <h1 class="text"> <img src="/image/etude.png" alt=""> FORMATIONS </h1>

                            <div class="div formation">


                                <?php if (empty($formationUsers)): ?>
                                    <strong></strong>
                                    <h4>Aucune donnée trouvée</h4>
                                <?php else: ?>
                                    <?php
                                    shuffle($formationUsers);
                                    $nombre_formation = 3;
                                    ?>
                                    <?php foreach ($formationUsers as $key => $formations): ?>
                                        <?php if ($key < $nombre_formation): ?>
                                            <div class="div1 div2">
                                                <strong id="strong"></strong>

                                                <div class="info">
                                                    <h4>
                                                        <?= $formations['etablissement'] ?>
                                                    </h4>
                                                    <span><em>
                                                            <?= $formations['moisDebut'] ?> /
                                                            <?= $formations['anneeDebut'] ?>
                                                        </em> à <em>
                                                            <?= $formations['moisFin'] ?> /
                                                            <?= $formations['anneeFin'] ?>
                                                        </em>
                                                    </span>
                                                    <p>
                                                        <?= $formations['Filiere'] ?> , <strong>
                                                            <?= $formations['niveau'] ?></strong>
                                                    </p>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>

                        </div>


                        <div class="experiences">
                            <h1 class="text"> <img src="/image/outil.png" alt=""> Outils informatiques </h1>
                            <?php if ($afficheOutil): ?>
                                <div class="outils">
                                    <?php foreach ($afficheOutil as $outils): ?>
                                        <p><span></span>
                                            <?= $outils['outil'] ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <!-- <div class="bas"></div> -->
            </div>
        </div>



    </section>

    <script>
        // Editor functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Make CV elements editable
            const editableElements = [
                // Content text elements
                ...document.querySelectorAll('.box1 p, .box1 span, .box1 h2, .box1 li, .box2 p, .box2 h4, .box2 span'),
                // Headers
                ...document.querySelectorAll('.text, .nom, .profession')
            ];

            let currentElement = null;
            let currentElementType = '';
            const editorPanel = document.getElementById('editorPanel');
            const closeEditor = document.getElementById('closeEditor');
            const fontSizeInput = document.getElementById('fontSize');
            const fontSizeValue = document.getElementById('fontSizeValue');
            const textColorInput = document.getElementById('textColor');
            const bgColorInput = document.getElementById('bgColor');
            const fontFamilySelect = document.getElementById('fontFamily');
            const applyToSameCheck = document.getElementById('applyToSame');
            const applyChangesBtn = document.getElementById('applyChanges');

            // Add editable class to elements
            editableElements.forEach(element => {
                element.classList.add('editable-element');

                element.addEventListener('click', function (e) {
                    e.stopPropagation();

                    // Remove active class from previous element
                    if (currentElement) {
                        currentElement.classList.remove('active');
                    }

                    currentElement = element;
                    currentElementType = element.tagName.toLowerCase();
                    currentElement.classList.add('active');

                    // Update editor with current values
                    const computedStyle = window.getComputedStyle(element);

                    // Set font size (remove 'px' and convert to number)
                    const currentSize = parseInt(computedStyle.fontSize);
                    fontSizeInput.value = currentSize;
                    fontSizeValue.textContent = currentSize + 'px';

                    // Set text color
                    const currentColor = computedStyle.color;
                    // Convert RGB to HEX
                    const rgb = currentColor.match(/\d+/g);
                    if (rgb && rgb.length === 3) {
                        const hex = '#' + ((1 << 24) + (parseInt(rgb[0]) << 16) + (parseInt(rgb[1]) << 8) + parseInt(rgb[2])).toString(16).slice(1);
                        textColorInput.value = hex;
                    }

                    // Set background color
                    const currentBgColor = computedStyle.backgroundColor;
                    if (currentBgColor && currentBgColor !== 'rgba(0, 0, 0, 0)' && currentBgColor !== 'transparent') {
                        const bgRgb = currentBgColor.match(/\d+/g);
                        if (bgRgb && bgRgb.length >= 3) {
                            const bgHex = '#' + ((1 << 24) + (parseInt(bgRgb[0]) << 16) + (parseInt(bgRgb[1]) << 8) + parseInt(bgRgb[2])).toString(16).slice(1);
                            bgColorInput.value = bgHex;
                        }
                    } else {
                        bgColorInput.value = '#ffffff';
                    }

                    // Set font family
                    const currentFont = computedStyle.fontFamily;
                    // Try to match with available options
                    const fontOptions = Array.from(fontFamilySelect.options);
                    const matchingOption = fontOptions.find(option => currentFont.includes(option.value.split(',')[0]));
                    if (matchingOption) {
                        fontFamilySelect.value = matchingOption.value;
                    }

                    // Show editor
                    editorPanel.style.display = 'block';
                });
            });

            // Update font size display when slider changes and apply in real-time
            fontSizeInput.addEventListener('input', function () {
                fontSizeValue.textContent = this.value + 'px';
                if (currentElement) {
                    if (applyToSameCheck.checked) {
                        // Apply to all elements of the same type
                        document.querySelectorAll(currentElementType).forEach(el => {
                            if (el.classList.contains('editable-element')) {
                                el.style.fontSize = this.value + 'px';
                            }
                        });
                    } else {
                        currentElement.style.fontSize = this.value + 'px';
                    }
                }
            });

            // Apply color changes in real-time
            textColorInput.addEventListener('input', function () {
                if (currentElement) {
                    if (applyToSameCheck.checked) {
                        // Apply to all elements of the same type
                        document.querySelectorAll(currentElementType).forEach(el => {
                            if (el.classList.contains('editable-element')) {
                                el.style.color = this.value;
                            }
                        });
                    } else {
                        currentElement.style.color = this.value;
                    }
                }
            });

            // Apply background color changes in real-time
            bgColorInput.addEventListener('input', function () {
                if (currentElement) {
                    if (applyToSameCheck.checked) {
                        // Apply to all elements of the same type
                        document.querySelectorAll(currentElementType).forEach(el => {
                            if (el.classList.contains('editable-element')) {
                                el.style.backgroundColor = this.value;
                            }
                        });
                    } else {
                        currentElement.style.backgroundColor = this.value;
                    }
                }
            });

            // Apply font family changes in real-time
            fontFamilySelect.addEventListener('change', function () {
                if (currentElement) {
                    if (applyToSameCheck.checked) {
                        // Apply to all elements of the same type
                        document.querySelectorAll(currentElementType).forEach(el => {
                            if (el.classList.contains('editable-element')) {
                                el.style.fontFamily = this.value;
                            }
                        });
                    } else {
                        currentElement.style.fontFamily = this.value;
                    }
                }
            });

            // Close editor
            closeEditor.addEventListener('click', function () {
                if (currentElement) {
                    currentElement.classList.remove('active');

                    // Save current state to localStorage
                    saveCurrentElementStyle();
                }

                editorPanel.style.display = 'none';
                currentElement = null;
            });

            // Close editor when clicking outside
            document.addEventListener('click', function (e) {
                if (!editorPanel.contains(e.target) && !e.target.classList.contains('editable-element')) {
                    if (currentElement) {
                        currentElement.classList.remove('active');

                        // Save current state to localStorage
                        saveCurrentElementStyle();
                    }

                    editorPanel.style.display = 'none';
                    currentElement = null;
                }
            });

            // Apply changes and save to localStorage
            applyChangesBtn.addEventListener('click', function () {
                if (currentElement) {
                    saveCurrentElementStyle();
                    currentElement.classList.remove('active');
                    editorPanel.style.display = 'none';
                    currentElement = null;
                }
            });

            // Function to save current element style to localStorage
            function saveCurrentElementStyle() {
                if (!currentElement) return;

                // Grab the current settings from the panel
                const fontSize = fontSizeInput.value + 'px';
                const color = textColorInput.value;
                const bgColor = bgColorInput.value;
                const fontFamily = fontFamilySelect.value;

                try {
                    if (applyToSameCheck.checked) {
                        // Store settings for all elements of the same type
                        // Get all the custom styles for this CV
                        let cvStyles = JSON.parse(localStorage.getItem('cv-styles') || '{}');

                        // Create or update the styles for this element type
                        if (!cvStyles[currentElementType]) {
                            cvStyles[currentElementType] = {};
                        }

                        cvStyles[currentElementType].fontSize = fontSize;
                        cvStyles[currentElementType].color = color;
                        cvStyles[currentElementType].backgroundColor = bgColor;
                        cvStyles[currentElementType].fontFamily = fontFamily;

                        // Save back to localStorage
                        localStorage.setItem('cv-styles', JSON.stringify(cvStyles));
                    } else {
                        // Store settings for this specific element only
                        const elementPath = getElementPath(currentElement);

                        // Get all the custom styles for this CV
                        let cvStyles = JSON.parse(localStorage.getItem('cv-styles') || '{}');

                        // Create or update the styles for this specific element
                        if (!cvStyles.specificElements) {
                            cvStyles.specificElements = {};
                        }

                        cvStyles.specificElements[elementPath] = {
                            fontSize: fontSize,
                            color: color,
                            backgroundColor: bgColor,
                            fontFamily: fontFamily
                        };

                        // Save back to localStorage
                        localStorage.setItem('cv-styles', JSON.stringify(cvStyles));
                    }

                    console.log('Styles saved successfully');
                } catch (e) {
                    console.error('Error saving styles:', e);
                }
            }

            // Function to create a unique identifier for elements
            function getElementPath(element) {
                let path = element.tagName.toLowerCase();
                if (element.id) {
                    path += '#' + element.id;
                } else if (element.className) {
                    const classes = Array.from(element.classList)
                        .filter(cls => cls !== 'editable-element' && cls !== 'active');
                    if (classes.length > 0) {
                        path += '.' + classes.join('.');
                    }
                }

                // Add position index for better uniqueness
                const parent = element.parentNode;
                if (parent) {
                    const siblings = Array.from(parent.children)
                        .filter(el => el.tagName === element.tagName);
                    const index = siblings.indexOf(element);
                    path += `:nth-of-type(${index + 1})`;
                }

                return path;
            }

            // Apply saved styles on page load
            function applySavedStyles() {
                try {
                    // Get all stored styles
                    const cvStyles = JSON.parse(localStorage.getItem('cv-styles') || '{}');

                    // First apply element type styles (like all h1, all p, etc.)
                    Object.keys(cvStyles).forEach(type => {
                        if (type !== 'specificElements') {
                            const styles = cvStyles[type];

                            document.querySelectorAll(type).forEach(el => {
                                if (el.classList.contains('editable-element')) {
                                    if (styles.fontSize) el.style.fontSize = styles.fontSize;
                                    if (styles.color) el.style.color = styles.color;
                                    if (styles.backgroundColor) el.style.backgroundColor = styles.backgroundColor;
                                    if (styles.fontFamily) el.style.fontFamily = styles.fontFamily;
                                }
                            });
                        }
                    });

                    // Then apply specific element styles which will override type styles
                    if (cvStyles.specificElements) {
                        Object.keys(cvStyles.specificElements).forEach(elementPath => {
                            const styles = cvStyles.specificElements[elementPath];
                            const selector = elementPath.split(':nth-of-type')[0]; // Get the base selector
                            const indexMatch = elementPath.match(/:nth-of-type\((\d+)\)/);
                            const index = indexMatch ? parseInt(indexMatch[1]) - 1 : 0;

                            // Find all elements matching the selector
                            const matchingElements = document.querySelectorAll(selector);

                            // Apply styles to the specific element if found
                            if (matchingElements.length > index) {
                                const element = matchingElements[index];
                                if (element.classList.contains('editable-element')) {
                                    if (styles.fontSize) element.style.fontSize = styles.fontSize;
                                    if (styles.color) element.style.color = styles.color;
                                    if (styles.backgroundColor) element.style.backgroundColor = styles.backgroundColor;
                                    if (styles.fontFamily) element.style.fontFamily = styles.fontFamily;
                                }
                            }
                        });
                    }

                    console.log('Styles applied successfully');
                } catch (e) {
                    console.error('Error applying styles:', e);
                }
            }

            // Apply saved styles on load
            applySavedStyles();

            // Add a reset button if needed
            function resetAllStyles() {
                localStorage.removeItem('cv-styles');
                window.location.reload();
            }

            // Uncomment this to add a reset button to your page
            /*
            const resetButton = document.createElement('button');
            resetButton.textContent = 'Réinitialiser tous les styles';
            resetButton.style.marginTop = '10px';
            resetButton.addEventListener('click', resetAllStyles);
            document.querySelector('.personnalisation').appendChild(resetButton);
            */
        });
    </script>
</body>

</html>