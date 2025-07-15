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
    <link rel="stylesheet" href="css/model12_1.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/personnalisation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Cormorant+Garamond:wght@300;400;500&family=Montserrat:wght@300;400;500&family=Poppins:wght@300;400;500;700&family=Roboto:wght@300;400;500&family=Lato:wght@300;400;700&family=Raleway:wght@400;700&family=Nunito:wght@400;700&display=swap"
        rel="stylesheet">
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
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
        <i class="fas fa-palette"></i> Personnaliser
    </button>

    <!-- Bouton de téléchargement fixe toujours visible -->
    <button id="fixed-download-btn" class="fixed-download-button" onclick="generatePDF()">
        <i class="fas fa-download"></i>
        <span>Télécharger PDF</span>
    </button>
    <section class="section3">
        <div class="personnalisation" id="customization-panel">
            <button id="close-panel-btn" class="close-panel-btn">&times;</button>
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>

            <div class="theme-selector">
                <h3>Thèmes de couleurs</h3>
                <div class="themes-section">
                    <div class="themes-container">
                        <div class="theme-card" data-theme="midnight_blue">
                            <div class="theme-preview">
                                <div style="background-color: #2c3e50;"></div>
                                <div style="background-color: #3498db;"></div>
                                <div style="background-color: #ecf0f1;"></div>
                            </div>
                            <span>Bleu Nuit</span>
                        </div>
                        <div class="theme-card" data-theme="forest_green">
                            <div class="theme-preview">
                                <div style="background-color: #22573b;"></div>
                                <div style="background-color: #3a916a;"></div>
                                <div style="background-color: #f0f5f1;"></div>
                            </div>
                            <span>Vert Forêt</span>
                        </div>
                        <div class="theme-card" data-theme="modern_slate">
                            <div class="theme-preview">
                                <div style="background-color: #34495e;"></div>
                                <div style="background-color: #95a5a6;"></div>
                                <div style="background-color: #eaeaeb;"></div>
                            </div>
                            <span>Ardoise</span>
                        </div>
                        <div class="theme-card" data-theme="burgundy">
                            <div class="theme-preview">
                                <div style="background-color: #6d213c;"></div>
                                <div style="background-color: #a34a69;"></div>
                                <div style="background-color: #f4eef0;"></div>
                            </div>
                            <span>Bordeaux</span>
                        </div>
                        <div class="theme-card" data-theme="professional_navy">
                            <div class="theme-preview">
                                <div style="background-color: #001f3f;"></div>
                                <div style="background-color: #0074d9;"></div>
                                <div style="background-color: #f4f6f7;"></div>
                            </div>
                            <span>Navy Pro</span>
                        </div>
                        <div class="theme-card" data-theme="warm_taupe">
                            <div class="theme-preview">
                                <div style="background-color: #5d534b;"></div>
                                <div style="background-color: #b8a698;"></div>
                                <div style="background-color: #f5f3f1;"></div>
                            </div>
                            <span>Taupe</span>
                        </div>
                        <div class="theme-card" data-theme="ruby_cream">
                            <div class="theme-preview">
                                <div style="background-color: #9B111E;"></div>
                                <div style="background-color: #FFFDD0;"></div>
                                <div style="background-color: #D2B48C;"></div>
                            </div>
                            <span>Rubis & Crème</span>
                        </div>
                        <div class="theme-card" data-theme="lavender_ash">
                            <div class="theme-preview">
                                <div style="background-color: #483C67;"></div>
                                <div style="background-color: #E6E6FA;"></div>
                                <div style="background-color: #B2BEB5;"></div>
                            </div>
                            <span>Lavande & Cendre</span>
                        </div>
                        <div class="theme-card" data-theme="sunny_day">
                            <div class="theme-preview">
                                <div style="background-color: #00A3E0;"></div>
                                <div style="background-color: #FFFACD;"></div>
                                <div style="background-color: #FFD700;"></div>
                            </div>
                            <span>Jour Ensoleillé</span>
                        </div>
                        <div class="theme-card" data-theme="vintage_sepia">
                            <div class="theme-preview">
                                <div style="background-color: #5D4037;"></div>
                                <div style="background-color: #F5DEB3;"></div>
                                <div style="background-color: #A1887F;"></div>
                            </div>
                            <span>Sépia Vintage</span>
                        </div>
                        <div class="theme-card" data-theme="emerald_city">
                            <div class="theme-preview">
                                <div style="background-color: #004D40;"></div>
                                <div style="background-color: #E0F2F1;"></div>
                                <div style="background-color: #009688;"></div>
                            </div>
                            <span>Cité d'Émeraude</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="font-selector-section">
                <h3>Polices de caractères</h3>
                <div class="font-selector">
                    <div class="font-card" data-font-main="'Lato', sans-serif"
                        data-font-header="'Playfair Display', serif">
                        <span style="font-family: 'Lato', sans-serif;">Classique</span>
                    </div>
                    <div class="font-card" data-font-main="'Montserrat', sans-serif"
                        data-font-header="'Montserrat', sans-serif">
                        <span style="font-family: 'Montserrat', sans-serif;">Moderne</span>
                    </div>
                    <div class="font-card" data-font-main="'Roboto', sans-serif"
                        data-font-header="'Roboto', sans-serif">
                        <span style="font-family: 'Roboto', sans-serif;">Roboto</span>
                    </div>
                    <div class="font-card" data-font-main="'Poppins', sans-serif"
                        data-font-header="'Poppins', sans-serif">
                        <span style="font-family: 'Poppins', sans-serif;">Poppins</span>
                    </div>
                    <div class="font-card" data-font-main="'Cormorant Garamond', serif"
                        data-font-header="'Playfair Display', serif">
                        <span style="font-family: 'Cormorant Garamond', serif;">Sérif</span>
                    </div>
                    <div class="font-card" data-font-main="'Raleway', sans-serif"
                        data-font-header="'Raleway', sans-serif">
                        <span style="font-family: 'Raleway', sans-serif;">Raleway</span>
                    </div>
                    <div class="font-card" data-font-main="'Nunito', sans-serif"
                        data-font-header="'Nunito', sans-serif">
                        <span style="font-family: 'Nunito', sans-serif;">Nunito</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="cv-container" id="cv12-visible">
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
                        <?php if (isset($userss['nom']) && !empty($userss['nom'])): ?>
                            <?= $userss['nom'] ?>
                        <?php else: ?>
                            <p class="texte">Aucune donnée trouvée</p>
                        <?php endif; ?>
                    </h1>
                    <p class="job-title">
                        <?php if (isset($userss['competences']) && !empty($userss['competences'])): ?>
                            <?= $userss['competences'] ?>
                        <?php else: ?>
                        <p class="texte">Aucune compétence trouvée</p>
                    <?php endif; ?>
                    </p>

                    <?php if (isset($descriptions) && !empty($descriptions['description'])): ?>
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
                                <?php if (isset($userss['ville']) && !empty($userss['ville'])): ?>
                                    <?= $userss['ville'] ?>
                                <?php else: ?>
                                <p class="texte">Aucune ville trouvée</p>
                            <?php endif; ?>
                            </p>
                            <p><i class="fas fa-envelope"></i>
                                <?php if (isset($userss['mail']) && !empty($userss['mail'])): ?>
                                    <?= $userss['mail'] ?>
                                <?php else: ?>
                                <p class="texte">Aucune email trouvée</p>
                            <?php endif; ?>
                            </p>
                            <p><i class="fas fa-phone"></i>
                                <?php if (isset($userss['phone']) && !empty($userss['phone'])): ?>
                                    <?= $userss['phone'] ?>
                                <?php else: ?>
                                <p class="texte">Aucun numéro trouvé</p>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <div class="section skills-section">
                        <h3 class="section-title">Compétences</h3>
                        <ul class="skills-list">
                            <?php if (empty($competencesUtilisateurLimit7)): ?>
                                <p class="texte">Aucune compétence</p>
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
                                $competences_a_afficher = array_slice($competences_mises_en_avant, 0, $nombre_competences);
                                if (count($competences_a_afficher) < $nombre_competences) {
                                    $competences_a_afficher = array_merge(
                                        $competences_a_afficher,
                                        array_slice($competences_non_mises_en_avant, 0, $nombre_competences - count($competences_a_afficher))
                                    );
                                }

                                foreach ($competences_a_afficher as $competence): ?>
                                    <li>
                                        <span class="skill-name"><?= $competence['competence']; ?></span>
                                        <div class="skill-bar">
                                            <div class="skill-level" style="width: 85%;"></div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
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
                                <p class="texte">Aucune langue</p>
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
                                <p class="texte">Aucun intérêt</p>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="right-column">
                    <div class="section experience-section">
                        <h3 class="section-title">Expérience</h3>
                        <div class="timeline-container">
                            <?php if (empty($afficheMetier)): ?>
                                <p class="texte">Aucune expérience</p>
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
                                $nombre_metier = 3;

                                // Combiner les expériences en donnant priorité aux mises en avant
                                $experiences_a_afficher = array_slice($experiences_mises_en_avant, 0, $nombre_metier);
                                if (count($experiences_a_afficher) < $nombre_metier) {
                                    $experiences_a_afficher = array_merge(
                                        $experiences_a_afficher,
                                        array_slice($experiences_non_mises_en_avant, 0, $nombre_metier - count($experiences_a_afficher))
                                    );
                                }

                                foreach ($experiences_a_afficher as $metier): ?>
                                    <div class="experience-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-line"></div>
                                        <h4 class="experience-title"><?= $metier['metier']; ?>
                                            <span class="date-location">
                                                <i class="far fa-calendar-alt"></i> <?= $metier['moisDebut'] ?>
                                                <?= $metier['anneeDebut'] ?> <br>
                                                <?= $metier['moisFin'] ?>         <?= $metier['anneeFin'] ?>
                                            </span>
                                        </h4>
                                        <p class="experience-description">
                                            <?= $metier['description']; ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="section education-section">
                        <h3 class="section-title">Formation</h3>
                        <div class="timeline-container">
                            <?php if (empty($formationUsers)): ?>
                                <p class="texte">Aucune formation</p>
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
                                $nombre_formation = 3;

                                // Combiner les formations en donnant priorité aux mises en avant
                                $formations_a_afficher = array_slice($formations_mises_en_avant, 0, $nombre_formation);
                                if (count($formations_a_afficher) < $nombre_formation) {
                                    $formations_a_afficher = array_merge(
                                        $formations_a_afficher,
                                        array_slice($formations_non_mises_en_avant, 0, $nombre_formation - count($formations_a_afficher))
                                    );
                                }

                                foreach ($formations_a_afficher as $formation): ?>
                                    <div class="education-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-line"></div>
                                        <h4 class="education-title">
                                            <?php echo $formation['Filiere']; ?>
                                        </h4>
                                        <p class="institution-name">
                                            <?php echo $formation['etablissement']; ?>
                                            <strong> <?= $formation['niveau'] ?></strong>
                                            <span class="date-location">
                                                <i class="far fa-calendar-alt"></i> <?= $formation['moisDebut'] ?>
                                                <?= $formation['anneeDebut'] ?> <br>
                                                <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                            </span>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div class="cv-container" id="container-for-pdf">
                <div class="artistic-element"></div>
                <div class="cv-header">
                    <div class="profile-container">
                        <?php if (isset($userss['images'])): ?>
                            <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil" class="profile-photo"
                                id="profile-image-pdf">
                        <?php endif; ?>
                    </div>
                    <div class="header-content">
                        <h1 class="name-title">
                            <?php if (isset($userss['nom']) && !empty($userss['nom'])): ?>
                                <?= $userss['nom'] ?>
                            <?php else: ?>
                                <p class="texte">Aucune donnée trouvée</p>
                            <?php endif; ?>
                        </h1>
                        <p class="job-title">
                            <?php if (isset($userss['competences']) && !empty($userss['competences'])): ?>
                                <?= $userss['competences'] ?>
                            <?php else: ?>
                            <p class="texte">Aucune compétence trouvée</p>
                        <?php endif; ?>
                        </p>
                        <?php if (isset($descriptions) && !empty($descriptions['description'])): ?>
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
                                    <?php if (isset($userss['ville']) && !empty($userss['ville'])): ?>
                                        <?= $userss['ville'] ?>
                                    <?php else: ?>
                                    <p class="texte">Aucune ville trouvée</p>
                                <?php endif; ?>
                                </p>
                                <p><i class="fas fa-envelope"></i>
                                    <?php if (isset($userss['mail']) && !empty($userss['mail'])): ?>
                                        <?= $userss['mail'] ?>
                                    <?php else: ?>
                                    <p class="texte">Aucune email trouvée</p>
                                <?php endif; ?>
                                </p>
                                <p><i class="fas fa-phone"></i>
                                    <?php if (isset($userss['phone']) && !empty($userss['phone'])): ?>
                                        <?= $userss['phone'] ?>
                                    <?php else: ?>
                                    <p class="texte">Aucun numéro trouvé</p>
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
                                            <span class="skill-name"><?= $competence['competence']; ?></span>
                                            <div class="skill-bar">
                                                <div class="skill-level" style="width: 85%;"></div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="texte">Aucune compétence</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="section languages-section">
                            <h3 class="section-title">Langues</h3>
                            <ul class="languages-list">
                                <?php if (isset($afficheLangue) && !empty($afficheLangue)): ?>
                                    <?php foreach ($afficheLangue as $langue): ?>
                                        <li>
                                            <span><?= $langue['langue']; ?></span>
                                            <span class="language-level"><?php echo $langue['niveau']; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="texte">Aucune langue</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="section interests-section">
                            <h3 class="section-title">Centres d'intérêt</h3>
                            <ul class="interests-list">
                                <?php if (isset($afficheCentreInteret) && !empty($afficheCentreInteret)): ?>
                                    <?php foreach ($afficheCentreInteret as $interet): ?>
                                        <li><?= $interet['interet']; ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="texte">Aucun intérêt</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="section experience-section">
                            <h3 class="section-title">Expérience</h3>
                            <div class="timeline-container">
                                <?php if (isset($afficheMetier) && !empty($afficheMetier)): ?>
                                    <?php foreach ($afficheMetier as $metier): ?>
                                        <div class="experience-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-line"></div>
                                            <h4 class="experience-title"><?= $metier['metier']; ?>
                                                <span class="date-location">
                                                    <i class="far fa-calendar-alt"></i> <?= $metier['moisDebut'] ?>
                                                    <?= $metier['anneeDebut'] ?> <br>
                                                    <?= $metier['moisFin'] ?>         <?= $metier['anneeFin'] ?>
                                                </span>
                                            </h4>
                                            <p class="experience-description">
                                                <?= $metier['description']; ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="texte">Aucune expérience</p>
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
                                            <h4 class="education-title">
                                                <?php echo $formation['Filiere']; ?>
                                            </h4>
                                            <p class="institution-name">
                                                <?php echo $formation['etablissement']; ?>
                                                <strong> <?= $formation['niveau'] ?></strong>
                                                <span class="date-location">
                                                    <i class="far fa-calendar-alt"></i> <?= $formation['moisDebut'] ?>
                                                    <?= $formation['anneeDebut'] ?> <br>
                                                    <?= $formation['moisFin'] ?>         <?= $formation['anneeFin'] ?>
                                                </span>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="texte">Aucune formation</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function generatePDF() {
            const loadingMessage = document.createElement('div');
            loadingMessage.id = 'loading-message';
            loadingMessage.textContent = 'Génération du PDF en cours...';
            document.body.appendChild(loadingMessage);

            const element = document.getElementById("container-for-pdf");

            // Optimisations légères pour une meilleure qualité
            const scale = 2.2;
            const options = {
                scale: scale,
                useCORS: true,
                logging: false,
                width: element.offsetWidth,
                height: element.offsetHeight,
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight,
                backgroundColor: '#ffffff'
            };

            // Attendre un délai pour la stabilité
            setTimeout(() => {
                html2canvas(element, options).then(canvas => {
                    const imgData = canvas.toDataURL('image/jpeg', 0.95);

                    const {
                        jsPDF
                    } = window.jspdf;
                    // Format A4: 210 x 297 mm
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4'
                    });

                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = pdf.internal.pageSize.getHeight();

                    const canvasWidth = canvas.width;
                    const canvasHeight = canvas.height;
                    const canvasAspectRatio = canvasWidth / canvasHeight;
                    const pdfAspectRatio = pdfWidth / pdfHeight;

                    let imgWidth, imgHeight;

                    // Ajuster l'image pour qu'elle remplisse la page A4 sans déborder
                    if (canvasAspectRatio > pdfAspectRatio) {
                        imgWidth = pdfWidth;
                        imgHeight = imgWidth / canvasAspectRatio;
                    } else {
                        imgHeight = pdfHeight;
                        imgWidth = imgHeight * canvasAspectRatio;
                    }

                    // Centrer l'image si elle est plus petite que la page
                    const x = (pdfWidth - imgWidth) / 2;
                    const y = (pdfHeight - imgHeight) / 2;

                    pdf.addImage(imgData, 'JPEG', x, y, imgWidth, imgHeight);
                    pdf.save("cv-modèle-12-" + Date.now() + ".pdf");

                    if (document.body.contains(loadingMessage)) {
                        document.body.removeChild(loadingMessage);
                    }

                }).catch(err => {
                    console.error("Erreur lors de la génération du PDF : ", err);
                    if (document.body.contains(loadingMessage)) {
                        document.body.removeChild(loadingMessage);
                    }
                    alert("Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.");
                });
            }, 600);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themes = {
                midnight_blue: {
                    '--m12-primary-color': '#2c3e50',
                    '--m12-secondary-color': '#ecf0f1',
                    '--m12-accent-color': '#3498db',
                    '--m12-text-color': '#34495e',
                    '--m12-light-text-color': '#7f8c8d',
                    '--m12-bg-color': '#ffffff'
                },
                forest_green: {
                    '--m12-primary-color': '#22573b',
                    '--m12-secondary-color': '#f0f5f1',
                    '--m12-accent-color': '#3a916a',
                    '--m12-text-color': '#1d4732',
                    '--m12-light-text-color': '#5c8374',
                    '--m12-bg-color': '#ffffff'
                },
                modern_slate: {
                    '--m12-primary-color': '#34495e',
                    '--m12-secondary-color': '#eaeaeb',
                    '--m12-accent-color': '#95a5a6',
                    '--m12-text-color': '#2c3e50',
                    '--m12-light-text-color': '#7f8c8d',
                    '--m12-bg-color': '#ffffff'
                },
                burgundy: {
                    '--m12-primary-color': '#6d213c',
                    '--m12-secondary-color': '#f4eef0',
                    '--m12-accent-color': '#a34a69',
                    '--m12-text-color': '#591b31',
                    '--m12-light-text-color': '#8e6274',
                    '--m12-bg-color': '#ffffff'
                },
                professional_navy: {
                    '--m12-primary-color': '#001f3f',
                    '--m12-secondary-color': '#f4f6f7',
                    '--m12-accent-color': '#0074d9',
                    '--m12-text-color': '#111111',
                    '--m12-light-text-color': '#777777',
                    '--m12-bg-color': '#ffffff'
                },
                warm_taupe: {
                    '--m12-primary-color': '#5d534b',
                    '--m12-secondary-color': '#f5f3f1',
                    '--m12-accent-color': '#b8a698',
                    '--m12-text-color': '#4a423d',
                    '--m12-light-text-color': '#8a7e76',
                    '--m12-bg-color': '#ffffff'
                },
                ruby_cream: {
                    '--m12-primary-color': '#9B111E', // Ruby
                    '--m12-secondary-color': '#FFFDD0', // Cream
                    '--m12-accent-color': '#D2B48C', // Tan
                    '--m12-text-color': '#4E0000',
                    '--m12-light-text-color': '#800000',
                    '--m12-bg-color': '#ffffff'
                },
                lavender_ash: {
                    '--m12-primary-color': '#483C67', // Dark Lavender
                    '--m12-secondary-color': '#E6E6FA', // Light Lavender
                    '--m12-accent-color': '#B2BEB5', // Ash Grey
                    '--m12-text-color': '#33294A',
                    '--m12-light-text-color': '#6A5ACD', // Slate Blue
                    '--m12-bg-color': '#ffffff'
                },
                sunny_day: {
                    '--m12-primary-color': '#00A3E0', // Sky Blue
                    '--m12-secondary-color': '#FFFACD', // Lemon Chiffon
                    '--m12-accent-color': '#FFD700', // Gold
                    '--m12-text-color': '#005A7D',
                    '--m12-light-text-color': '#007B9E',
                    '--m12-bg-color': '#ffffff'
                },
                vintage_sepia: {
                    '--m12-primary-color': '#5D4037', // Dark Brown
                    '--m12-secondary-color': '#F5DEB3', // Wheat
                    '--m12-accent-color': '#A1887F', // Brownish Grey
                    '--m12-text-color': '#4E342E',
                    '--m12-light-text-color': '#795548',
                    '--m12-bg-color': '#FFF8E1' // Lighter Cream
                },
                emerald_city: {
                    '--m12-primary-color': '#004D40', // Dark Teal
                    '--m12-secondary-color': '#E0F2F1', // Very Light Teal
                    '--m12-accent-color': '#009688', // Teal
                    '--m12-text-color': '#00382E',
                    '--m12-light-text-color': '#00695C',
                    '--m12-bg-color': '#ffffff'
                }
            };

            const fontCards = document.querySelectorAll('.font-card');
            const themeCards = document.querySelectorAll('.theme-card');
            const root = document.documentElement;

            function applyTheme(themeName) {
                const theme = themes[themeName];
                for (const [key, value] of Object.entries(theme)) {
                    root.style.setProperty(key, value);
                }
                localStorage.setItem('model12_theme', themeName);

                themeCards.forEach(c => c.classList.remove('active'));
                const activeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                if (activeCard) {
                    activeCard.classList.add('active');
                }
            }

            function applyFont(fontMain, fontHeader) {
                root.style.setProperty('--m12-main-font', fontMain);
                root.style.setProperty('--m12-header-font', fontHeader);
                localStorage.setItem('model12_font_main', fontMain);
                localStorage.setItem('model12_font_header', fontHeader);

                fontCards.forEach(c => c.classList.remove('active'));
                const activeCard = document.querySelector(`.font-card[data-font-main="${fontMain}"]`);
                if (activeCard) {
                    activeCard.classList.add('active');
                }
            }

            themeCards.forEach(card => {
                card.addEventListener('click', () => {
                    const themeName = card.dataset.theme;
                    applyTheme(themeName);
                });
            });

            fontCards.forEach(card => {
                card.addEventListener('click', () => {
                    const fontMain = card.dataset.fontMain;
                    const fontHeader = card.dataset.fontHeader;
                    applyFont(fontMain, fontHeader);
                });
            });

            // Load saved settings
            const savedTheme = localStorage.getItem('model12_theme') || 'midnight_blue';
            const savedFontMain = localStorage.getItem('model12_font_main') || "'Lato', sans-serif";
            const savedFontHeader = localStorage.getItem('model12_font_header') || "'Playfair Display', serif";

            applyTheme(savedTheme);
            applyFont(savedFontMain, savedFontHeader);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggle-customization-btn');
            const customPanel = document.getElementById('customization-panel');
            const closeBtn = document.getElementById('close-panel-btn');

            if (toggleBtn && customPanel && closeBtn) {
                toggleBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    customPanel.classList.toggle('active');
                });

                closeBtn.addEventListener('click', function () {
                    customPanel.classList.remove('active');
                });

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