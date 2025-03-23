<?php

// Démarre la session
session_start();


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
    <title>model4</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/model4.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>


    <?php include('../navbare.php') ?>




    <div class="section3">


        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <script>
                // Importez la bibliothèque jsPDF
                function generatePDF() {
                    const element = document.querySelector("#containe");

                    // Hypothétiquement, si resolution et imageMode étaient des options valides
                    // vous pourriez les fusionner avec les options existantes de cette manière :
                    const mergedOptions = {
                        filename: 'cv.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        }, // Qualité JPEG de l'image
                        html2canvas: {
                            scale: 2
                        }, // Échelle de rendu HTML2Canvas
                    };

                    // Utiliser les options fusionnées pour la conversion HTML vers PDF
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
                            fontColorTitre: '#0E3B43',
                            texteColorTitre: '#ffffff',
                            fontColorSection: '#328590',
                            texteColorSection: '#ffffff'
                        },
                        professional: {
                            fontColorTitre: '#1D3557',
                            texteColorTitre: '#F1FAEE',
                            fontColorSection: '#457B9D',
                            texteColorSection: '#F1FAEE'
                        },
                        creative: {
                            fontColorTitre: '#845EC2',
                            texteColorTitre: '#FBEAFF',
                            fontColorSection: '#B39CD0',
                            texteColorSection: '#FBEAFF'
                        },
                        classic: {
                            fontColorTitre: '#4A4A4A',
                            texteColorTitre: '#F5F5F5',
                            fontColorSection: '#7A7A7A',
                            texteColorSection: '#F5F5F5'
                        },
                        modern: {
                            fontColorTitre: '#3D5A80',
                            texteColorTitre: '#E0FBFC',
                            fontColorSection: '#98C1D9',
                            texteColorSection: '#E0FBFC'
                        },
                        earthy: {
                            fontColorTitre: '#5F4B32',
                            texteColorTitre: '#F0EAE2',
                            fontColorSection: '#A1887F',
                            texteColorSection: '#F0EAE2'
                        },
                        // Nouveaux thèmes
                        corporate: {
                            fontColorTitre: '#1A237E',
                            texteColorTitre: '#FFFFFF',
                            fontColorSection: '#5C6BC0',
                            texteColorSection: '#FFFFFF'
                        },
                        burgundy: {
                            fontColorTitre: '#800020',
                            texteColorTitre: '#F2F2F2',
                            fontColorSection: '#AD8A8E',
                            texteColorSection: '#F2F2F2'
                        },
                        mint: {
                            fontColorTitre: '#21897E',
                            texteColorTitre: '#F4FFF8',
                            fontColorSection: '#69B7A8',
                            texteColorSection: '#F4FFF8'
                        },
                        slate: {
                            fontColorTitre: '#2F4F4F',
                            texteColorTitre: '#E8ECEE',
                            fontColorSection: '#708090',
                            texteColorSection: '#E8ECEE'
                        },
                        amber: {
                            fontColorTitre: '#B86E00',
                            texteColorTitre: '#FFFBF0',
                            fontColorSection: '#F0A858',
                            texteColorSection: '#FFFBF0'
                        }
                    };

                    // Récupérer le numéro du modèle à partir de l'URL
                    const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '4';
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
                        });
                    });

                    // Fonction pour appliquer un thème
                    function applyTheme(theme) {
                        // Appliquer les couleurs CSS
                        document.documentElement.style.setProperty('--font-color_section', theme.fontColorSection);
                        document.documentElement.style.setProperty('--texte-color_section', theme.texteColorSection);

                        // Mettre à jour les valeurs des inputs de couleur
                        document.getElementById('fontColor2').value = theme.fontColorSection;
                        document.getElementById('fontColor3').value = theme.texteColorSection;

                        // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                        localStorage.setItem(`${storagePrefix}font_color_section4`, theme.fontColorSection);
                        localStorage.setItem(`${storagePrefix}texte_color_section4`, theme.texteColorSection);
                    }

                    // Vérifier s'il y a un thème sauvegardé et l'appliquer
                    const savedTheme = {
                        fontColorSection: localStorage.getItem(`${storagePrefix}font_color_section4`),
                        texteColorSection: localStorage.getItem(`${storagePrefix}texte_color_section4`)
                    };

                    if (savedTheme.fontColorSection) {
                        // Appliquer le thème sauvegardé
                        document.documentElement.style.setProperty('--font-color_section', savedTheme.fontColorSection);
                        document.documentElement.style.setProperty('--texte-color_section', savedTheme.texteColorSection);

                        // Mettre à jour les valeurs des inputs
                        document.getElementById('fontColor2').value = savedTheme.fontColorSection;
                        document.getElementById('fontColor3').value = savedTheme.texteColorSection;

                        // Retrouver quel thème correspond aux couleurs sauvegardées
                        for (const [themeName, theme] of Object.entries(themes)) {
                            if (theme.fontColorSection === savedTheme.fontColorSection &&
                                theme.texteColorSection === savedTheme.texteColorSection) {
                                // Marquer le thème comme actif
                                const themeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                                if (themeCard) themeCard.classList.add('active');
                                break;
                            }
                        }
                    }
                });
            </script>

            <div class="box">
                <p>Couleur de de fond (section informations personnel)</p>
                <input type="color" name="" id="fontColor2">
            </div>

            <div class="box">
                <p>Couleur du texte (section informations personnel)</p>
                <input type="color" name="" id="fontColor3">
            </div>

            <script>
                const colorInput1 = document.getElementById('fontColor2');
                const font_color_section4 = localStorage.getItem('font_color_section4');

                document.documentElement.style.setProperty('--font-color_section', font_color_section4 || '#e6e6e6');
                colorInput1.value = font_color_section4 || '#e6e6e6'; // Mettre à jour la valeur du champ input

                colorInput1.addEventListener('input', function () {
                    const selectedColor = colorInput1.value;
                    document.documentElement.style.setProperty('--font-color_section', selectedColor);
                    localStorage.setItem('font_color_section4', selectedColor);
                });


                const colorInput2 = document.getElementById('fontColor3');
                const texte_color_section4 = localStorage.getItem('texte_color_section4');

                document.documentElement.style.setProperty('--texte-color_section', texte_color_section4 || '#000000');
                colorInput2.value = texte_color_section4 || '#000000'; // Mettre à jour la valeur du champ input

                colorInput2.addEventListener('input', function () {
                    const selectedColor = colorInput2.value;
                    document.documentElement.style.setProperty('--texte-color_section', selectedColor);
                    localStorage.setItem('texte_color_section4', selectedColor);
                });
            </script>
        </div>


        <div class="containers">
            <div class="decor"></div>

            <div class="box1">
                <div class="item1">
                    <img src="../upload/<?= $userss['images'] ?>" alt="">
                    <div>
                        <h1> <?= $userss['nom'] ?></h1>
                        <h2> <?= $userss['competences'] ?></h2>
                    </div>
                </div>

                <div class="item2">
                    <?php if (empty($descriptions)): ?>
                        <p class="a_propos">Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p class="a_propos">
                            <?= $descriptions['description'] ?>
                        </p>
                    <?php endif; ?>

                    <div>
                        <h2>Contacts</h2>
                        <p> <img src="/image/address.png" alt=""> <?= $userss['ville'] ?></p>
                        <p><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></p>
                        <p><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></p>
                    </div>
                </div>


                <div class="div item3">
                    <div>
                        <h2>Langues</h2>
                        <?php if (empty($afficheLangue)): ?>
                            <ul>
                                <li>Aucune donnée trouvée</li>
                            </ul>
                        <?php else: ?>

                            <ul>
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <li>
                                        <?php echo $langues['langue']; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        <?php endif; ?>
                    </div>

                    <div>
                        <h2>Centres d'intérêts</h2>
                        <?php if (empty($afficheCentreInteret)): ?>
                            <ul>
                                <li>Aucune donnée trouvée</li>
                            </ul>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($afficheCentreInteret as $interet): ?>
                                    <li>
                                        <?= $interet['interet'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        <?php endif; ?>
                    </div>

                </div>
            </div>



            <div class="box2">
                <div class="item1">

                    <div class="exp">
                        <h2>Expériences Professionnelles <img src="/image/experience.png" alt=""></h2>

                        <?php if (empty($afficheMetier)): ?>
                            <h3>Aucune donnée trouvée</h3>
                        <?php else: ?>
                            <?php
                            shuffle($afficheMetier);
                            $nombre_metier = 2
                                ?>
                            <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                <?php if ($key < $nombre_metier): ?>
                                    <div class="box">

                                        <div>
                                            <span> <?= $Metiers['moisDebut'] ?> /<?= $Metiers['anneeDebut'] ?> au
                                                <?= $Metiers['moisFin'] ?> /<?= $Metiers['anneeFin'] ?> </span>
                                            <h3> <?= $Metiers['metier'] ?></h3>
                                        </div>
                                        <p class="desc">
                                            <?= $Metiers['description'] ?>
                                        </p>


                                    </div>

                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>


                    <div class="educ">
                        <h2>Éducation <img src="/image/etude.png" alt=""></h2>
                        <div class="box">
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
                                        <div>
                                            <span> <?= $formations['moisDebut'] ?> /<?= $formations['anneeDebut'] ?> au
                                                <?= $formations['moisFin'] ?> /<?= $formations['anneeFin'] ?> </span>
                                            <h3> <?= $formations['etablissement'] ?></h3>
                                            <p> <?= $formations['Filiere'] ?> , <strong> <?= $formations['niveau'] ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>


                        </div>
                    </div>

                    <!-- <div class="logiciel">
                   <div>
                    <h2>Outils</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                   <div id="compe">
                    <h2>Compétences</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                </div> -->

                </div>

                <div class="item2">
                    <div class="logiciel">
                        <div>
                            <h2>Outils <img src="/image/outil.png" alt=""></h2>
                            <ul>
                                <?php if ($afficheOutil): ?>
                                    <?php foreach ($afficheOutil as $outils): ?>
                                        <li> <?= $outils['outil'] ?></li>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </ul>
                        </div>
                        <div id="compe">
                            <h2>Compétences <img src="/image/compétences.png" alt=""></h2>
                            <ul>
                                <?php if ($competencesUtilisateur): ?>
                                    <?php foreach ($competencesUtilisateur as $competence): ?>
                                        <li> <?php echo $competence['competence']; ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>

                                    <h4>Aucune donnée trouvée</h4>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cv">
            <div class="containers" id="containe">
                <div class="decor"></div>

                <div class="box1">
                    <div class="item1">
                        <img src="../upload/<?= $userss['images'] ?>" alt="">
                        <div>
                            <h1> <?= $userss['nom'] ?></h1>
                            <h2> <?= $userss['competences'] ?></h2>
                        </div>
                    </div>

                    <div class="item2">
                        <?php if (empty($descriptions)): ?>
                            <p class="a_propos">Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="a_propos">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>

                        <div>
                            <h2>Contacts</h2>
                            <p> <img src="/image/address.png" alt=""> <?= $userss['ville'] ?></p>
                            <p><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></p>
                            <p><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></p>
                        </div>
                    </div>


                    <div class="div item3">
                        <div>
                            <h2>Langues</h2>
                            <?php if (empty($afficheLangue)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>

                                <ul>
                                    <?php foreach ($afficheLangue as $langues): ?>
                                        <li>
                                            <?php echo $langues['langue']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            <?php endif; ?>
                        </div>

                        <div>
                            <h2>Centres d'intérêts</h2>
                            <?php if (empty($afficheCentreInteret)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>
                                <ul>
                                    <?php foreach ($afficheCentreInteret as $interet): ?>
                                        <li>
                                            <?= $interet['interet'] ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            <?php endif; ?>
                        </div>

                    </div>
                </div>



                <div class="box2">
                    <div class="item1">

                        <div class="exp">
                            <h2>Expériences Professionnelles <img src="/image/experience.png" alt=""></h2>

                            <?php if (empty($afficheMetier)): ?>
                                <h3>Aucune donnée trouvée</h3>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 2
                                    ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <div class="box">

                                            <div>
                                                <span> <?= $Metiers['moisDebut'] ?> /<?= $Metiers['anneeDebut'] ?> au
                                                    <?= $Metiers['moisFin'] ?> /<?= $Metiers['anneeFin'] ?> </span>
                                                <h3> <?= $Metiers['metier'] ?></h3>
                                            </div>
                                            <p class="desc">
                                                <?= $Metiers['description'] ?>
                                            </p>


                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>


                        <div class="educ">
                            <h2>Éducation <img src="/image/etude.png" alt=""></h2>
                            <div class="box">
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
                                            <div>
                                                <span> <?= $formations['moisDebut'] ?> /<?= $formations['anneeDebut'] ?> au
                                                    <?= $formations['moisFin'] ?> /<?= $formations['anneeFin'] ?> </span>
                                                <h3> <?= $formations['etablissement'] ?></h3>
                                                <p> <?= $formations['Filiere'] ?> , <strong> <?= $formations['niveau'] ?></strong>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>


                            </div>
                        </div>

                        <!-- <div class="logiciel">
                   <div>
                    <h2>Outils</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                   <div id="compe">
                    <h2>Compétences</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                </div> -->

                    </div>

                    <div class="item2">
                        <div class="logiciel">
                            <div>
                                <h2>Outils <img src="/image/outil.png" alt=""></h2>
                                <ul>
                                    <?php if ($afficheOutil): ?>
                                        <?php foreach ($afficheOutil as $outils): ?>
                                            <li> <?= $outils['outil'] ?></li>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <div id="compe">
                                <h2>Compétences <img src="/image/compétences.png" alt=""></h2>
                                <ul>
                                    <?php if ($competencesUtilisateur): ?>
                                        <?php foreach ($competencesUtilisateur as $competence): ?>
                                            <li> <?php echo $competence['competence']; ?></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>

                                        <h4>Aucune donnée trouvée</h4>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                // scripts.js
                const colorPickers = document.querySelectorAll('.color-picker input');

                colorPickers.forEach(picker => {
                    picker.addEventListener('input', (e) => {
                        const propertyName = `--${e.target.id}`;
                        document.documentElement.style.setProperty(propertyName, e.target.value);
                    });
                });
            </script>
</body>

</html>