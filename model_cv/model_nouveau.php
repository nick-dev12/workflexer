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
    <link href="https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/model_nouveau.css">
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
                    <div class="theme-card" data-theme="green">
                        <div class="theme-preview">
                            <div style="background-color: #388e3c; height: 20px;"></div>
                            <div style="background-color: #c8e6c9; height: 20px;"></div>
                            <div style="background-color: #FFFFFF; height: 20px;"></div>
                        </div>
                        <span>Vert</span>
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
            }
        </style>
    </div>

    <div class="cv-container">
        <div class="left-column">
            <div>
                <h1 class="name-title"><?= $userss['nom'] ?></h1>
                <p class="subtitle"><?= $userss['competences'] ?></p>
            </div>

            <div class="contact">
                <h3>CONTACT</h3>
                <p><?= $userss['phone'] ?></p>
                <p><?= $userss['ville'] ?></p>
                <p><?= $userss['mail'] ?></p>
                <p>linkedin.com/<?= strtolower(str_replace(' ', '-', $userss['nom'])) ?></p>
            </div>

            <div class="languages">
                <h3>LANGUES</h3>
                <?php if (empty($afficheLangue)): ?>
                    <p>Aucune donnée trouvée</p>
                <?php else: ?>
                    <?php foreach ($afficheLangue as $langues): ?>
                        <p><?= $langues['langue'] ?> : <?= $langues['niveau'] ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="skills">
                <h3>COMPÉTENCES</h3>
                <?php if ($competencesUtilisateur): ?>
                    <ul>
                        <?php foreach ($competencesUtilisateur as $competence): ?>
                            <li><?= $competence['competence'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucune donnée trouvée</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="right-column">
            <div class="profile">
                <h3>PROFIL</h3>
                <?php if (empty($descriptions)): ?>
                    <p>Aucune donnée trouvée</p>
                <?php else: ?>
                    <p><?= $descriptions['description'] ?></p>
                <?php endif; ?>
            </div>

            <div class="section">
                <h3>FORMATION</h3>
                <?php if (empty($formationUsers)): ?>
                    <p>Aucune donnée trouvée</p>
                <?php else: ?>
                    <?php foreach ($formationUsers as $formations): ?>
                        <div class="education-item">
                            <h4><?= $formations['etablissement'] ?></h4>
                            <p class="date"><?= $formations['moisDebut'] ?>/<?= $formations['anneeDebut'] ?> -
                                <?= $formations['moisFin'] ?>/<?= $formations['anneeFin'] ?> | <?= $formations['ville'] ?>
                            </p>
                            <p><?= $formations['Filiere'] ?> (<?= $formations['niveau'] ?>)</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="section">
                <h3>EXPÉRIENCES PROFESSIONNELLES</h3>
                <?php if (empty($afficheMetier)): ?>
                    <p>Aucune donnée trouvée</p>
                <?php else: ?>
                    <?php foreach ($afficheMetier as $Metiers): ?>
                        <div class="experience-item">
                            <h4><?= $Metiers['metier'] ?> | <?= $Metiers['entreprise'] ?></h4>
                            <p class="date"><?= $Metiers['moisDebut'] ?>/<?= $Metiers['anneeDebut'] ?> -
                                <?= $Metiers['moisFin'] ?>/<?= $Metiers['anneeFin'] ?> | <?= $Metiers['ville'] ?>
                            </p>
                            <p><?= $Metiers['description'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($afficheOutil)): ?>
                <div class="section">
                    <h3>OUTILS INFORMATIQUES</h3>
                    <div class="skills">
                        <ul>
                            <?php foreach ($afficheOutil as $outils): ?>
                                <li><?= $outils['outil'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($afficheCentreInteret)): ?>
                <div class="section">
                    <h3>CENTRES D'INTÉRÊT</h3>
                    <div class="skills">
                        <ul>
                            <?php foreach ($afficheCentreInteret as $interet): ?>
                                <li><?= $interet['interet'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // JavaScript pour changer les thèmes
        document.addEventListener('DOMContentLoaded', function () {
            const themeCards = document.querySelectorAll('.theme-card');
            const leftColumn = document.querySelector('.left-column');
            const rightColumn = document.querySelector('.right-column');
            const headings = document.querySelectorAll('.section h3');

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

            function applyTheme(theme) {
                // Réinitialiser tous les styles
                resetStyles();

                // Appliquer le thème choisi
                switch (theme) {
                    case 'classic':
                        leftColumn.style.backgroundColor = '#e6e6e6';
                        leftColumn.style.color = '#333333';
                        headings.forEach(h => h.style.borderBottomColor = '#e6e6e6');
                        break;
                    case 'professional':
                        leftColumn.style.backgroundColor = '#1D3557';
                        leftColumn.style.color = '#FFFFFF';
                        headings.forEach(h => h.style.borderBottomColor = '#457B9D');
                        break;
                    case 'corporate':
                        leftColumn.style.backgroundColor = '#1A237E';
                        leftColumn.style.color = '#FFFFFF';
                        headings.forEach(h => h.style.borderBottomColor = '#5C6BC0');
                        break;
                    case 'slate':
                        leftColumn.style.backgroundColor = '#2F4F4F';
                        leftColumn.style.color = '#FFFFFF';
                        headings.forEach(h => h.style.borderBottomColor = '#708090');
                        break;
                    case 'green':
                        leftColumn.style.backgroundColor = '#c8e6c9';
                        leftColumn.style.color = '#212121';
                        headings.forEach(h => h.style.borderBottomColor = '#c8e6c9');
                        break;
                    case 'creative':
                        leftColumn.style.backgroundColor = '#845EC2';
                        leftColumn.style.color = '#FFFFFF';
                        headings.forEach(h => h.style.borderBottomColor = '#B39CD0');
                        break;
                    case 'modern':
                        leftColumn.style.backgroundColor = '#3D5A80';
                        leftColumn.style.color = '#FFFFFF';
                        headings.forEach(h => h.style.borderBottomColor = '#98C1D9');
                        break;
                    default:
                        // Thème par défaut (vert)
                        leftColumn.style.backgroundColor = '#c8e6c9';
                        leftColumn.style.color = '#212121';
                        headings.forEach(h => h.style.borderBottomColor = '#c8e6c9');
                }
            }

            function resetStyles() {
                // Réinitialiser styles
                leftColumn.removeAttribute('style');
                rightColumn.removeAttribute('style');
                headings.forEach(h => h.removeAttribute('style'));
            }

            // Définir le thème par défaut au chargement (vert)
            document.querySelector('[data-theme="green"]').classList.add('active');
            applyTheme('green');
        });
    </script>
</body>

</html>