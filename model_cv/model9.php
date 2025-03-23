<?php
// Démarre la session
session_start();

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
    <title>CV Modèle 9</title>
    <link rel="stylesheet" href="../css/model9.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
    <div class="personnalisation" style="padding: 20px; margin-bottom: 20px;">
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
                    // Nouveaux thèmes
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
                const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '9';
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
                    // Appliquer les couleurs CSS avec des variables personnalisées
                    document.documentElement.style.setProperty('--header-bg', theme.headerBg);
                    document.documentElement.style.setProperty('--header-color', theme.headerColor);
                    document.documentElement.style.setProperty('--accent-color', theme.accentColor);

                    // Appliquer directement aux éléments si nécessaire
                    const headers = document.querySelectorAll('.cv-header, header, .header-section');
                    headers.forEach(header => {
                        if (header) {
                            header.style.backgroundColor = theme.headerBg;
                            header.style.color = theme.headerColor;
                        }
                    });

                    const accents = document.querySelectorAll('h3, .section-title, .skill-title');
                    accents.forEach(accent => {
                        if (accent) {
                            accent.style.color = theme.accentColor;
                        }
                    });

                    // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                    localStorage.setItem(`${storagePrefix}headerBg`, theme.headerBg);
                    localStorage.setItem(`${storagePrefix}headerColor`, theme.headerColor);
                    localStorage.setItem(`${storagePrefix}accentColor`, theme.accentColor);
                }

                // Vérifier s'il y a un thème sauvegardé et l'appliquer
                const savedTheme = {
                    headerBg: localStorage.getItem(`${storagePrefix}headerBg`),
                    headerColor: localStorage.getItem(`${storagePrefix}headerColor`),
                    accentColor: localStorage.getItem(`${storagePrefix}accentColor`)
                };

                if (savedTheme.headerBg) {
                    // Appliquer le thème sauvegardé
                    document.documentElement.style.setProperty('--header-bg', savedTheme.headerBg);
                    document.documentElement.style.setProperty('--header-color', savedTheme.headerColor);
                    document.documentElement.style.setProperty('--accent-color', savedTheme.accentColor);

                    // Appliquer directement aux éléments
                    const headers = document.querySelectorAll('.cv-header, header, .header-section');
                    headers.forEach(header => {
                        if (header) {
                            header.style.backgroundColor = savedTheme.headerBg;
                            header.style.color = savedTheme.headerColor;
                        }
                    });

                    const accents = document.querySelectorAll('h3, .section-title, .skill-title');
                    accents.forEach(accent => {
                        if (accent) {
                            accent.style.color = savedTheme.accentColor;
                        }
                    });

                    // Retrouver quel thème correspond aux couleurs sauvegardées
                    for (const [themeName, theme] of Object.entries(themes)) {
                        if (theme.headerBg === savedTheme.headerBg &&
                            theme.headerColor === savedTheme.headerColor) {
                            // Marquer le thème comme actif
                            const themeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                            if (themeCard) themeCard.classList.add('active');
                            break;
                        }
                    }
                }
            });
        </script>
    </div>

    <div class="cv-container" id="cv-content">
        <div class="header">
            <div class="profile">
                <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil">
                <div class="info">
                    <h1><?= $userss['nom'] ?></h1>
                    <h2><?= $userss['competences'] ?></h2>
                </div>
            </div>
            <div class="contact">
                <p><img src="../image/phone.png" alt=""> <?= $userss['phone'] ?></p>
                <p><img src="../image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></p>
                <p><img src="../image/address.png" alt=""> <?= $userss['ville'] ?></p>
            </div>
        </div>

        <div class="main-content">
            <div class="left-column">
                <section class="about">
                    <h3>À PROPOS</h3>
                    <?php if (empty($descriptions)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p><?= $descriptions['description'] ?></p>
                    <?php endif; ?>
                </section>

                <section class="skills">
                    <h3>COMPÉTENCES</h3>
                    <ul>
                        <?php if ($competencesUtilisateur): ?>
                            <?php foreach ($competencesUtilisateur as $competence): ?>
                                <li><?= $competence['competence'] ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Aucune donnée trouvée</li>
                        <?php endif; ?>
                    </ul>
                </section>

                <section class="languages">
                    <h3>LANGUES</h3>
                    <ul>
                        <?php if ($afficheLangue): ?>
                            <?php foreach ($afficheLangue as $langue): ?>
                                <li><?= $langue['langue'] ?> (<?= $langue['niveau'] ?>)</li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Aucune donnée trouvée</li>
                        <?php endif; ?>
                    </ul>
                </section>
            </div>

            <div class="right-column">
                <section class="experience">
                    <h3>EXPÉRIENCES</h3>
                    <?php if ($afficheMetier): ?>
                        <?php foreach ($afficheMetier as $metier): ?>
                            <div class="experience-item">
                                <h4><?= $metier['metier'] ?></h4>
                                <span class="date"><?= $metier['moisDebut'] ?>/<?= $metier['anneeDebut'] ?> -
                                    <?= $metier['moisFin'] ?>/<?= $metier['anneeFin'] ?></span>
                                <p><?= $metier['description'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune donnée trouvée</p>
                    <?php endif; ?>
                </section>

                <section class="education">
                    <h3>FORMATIONS</h3>
                    <?php if ($formationUsers): ?>
                        <?php foreach ($formationUsers as $formation): ?>
                            <div class="education-item">
                                <h4><?= $formation['etablissement'] ?></h4>
                                <span class="date"><?= $formation['moisDebut'] ?>/<?= $formation['anneeDebut'] ?> -
                                    <?= $formation['moisFin'] ?>/<?= $formation['anneeFin'] ?></span>
                                <p><?= $formation['Filiere'] ?> (<?= $formation['niveau'] ?>)</p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune donnée trouvée</p>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>

    <script>
        function generatePDF() {
            const element = document.getElementById('cv-content');
            const options = {
                margin: [10, 10, 10, 10],
                filename: 'cv.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(options).from(element).save();
        }
    </script>
</body>

</html>