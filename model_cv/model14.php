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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV - Modèle 14</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/model14_1.css" />
    <link rel="stylesheet" href="../css/personnalisation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>
    <script src="image_customizer.js" defer></script>
    <script src="cv_customizer.js" defer></script>
</head>

<body>
    <button id="toggle-customization-btn" class="button12">
        <i class="fa-solid fa-palette"></i> Personnaliser
    </button>

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
            <button class="close-info"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <style>
        .info-bubble {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-width: 400px;
            opacity: 1;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease;
        }

        .info-bubble.hidden {
            opacity: 0;
            transform: translateX(100%);
        }

        .info-content {
            padding: 20px;
            position: relative;
        }

        .info-content i.fa-circle-info {
            color: #2196F3;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .info-content h3 {
            color: #333;
            margin: 10px 0;
            font-size: 18px;
        }

        .info-content p {
            color: #666;
            margin: 10px 0;
            line-height: 1.5;
        }

        .info-content ul {
            margin: 15px 0;
            padding-left: 20px;
        }

        .info-content li {
            color: #666;
            margin: 8px 0;
            line-height: 1.4;
        }

        .info-content .highlight {
            color: #2196F3;
            font-weight: 500;
        }

        .close-info {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #2196F3;
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px;
            font-size: 18px;
            transition: all 0.3s;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-info:hover {
            background: #1976D2;
            transform: scale(1.1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 480px) {
            .info-bubble {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const infoBubble = document.querySelector('.info-bubble');
            const closeButton = document.querySelector('.close-info');

            if (closeButton && infoBubble) {
                closeButton.addEventListener('click', function () {
                    infoBubble.classList.add('hidden');
                    setTimeout(() => {
                        infoBubble.style.display = 'none';
                    }, 300);
                });
            }
        });
    </script>

    <!-- Bouton de téléchargement fixe toujours visible -->
    <button id="fixed-download-btn" class="fixed-download-button" onclick="generatePDF()">
        <i class="fa-solid fa-download"></i>
        <span>Télécharger PDF</span>
    </button>
    <section class="section3">
        <div class="personnalisation" id="customization-panel">
            <button id="close-panel-btn" class="close-panel-btn">&times;</button>
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>

            <div class="customization-panel">
                <div class="section">
                    <h3>Thèmes de couleurs</h3>


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

                    <div class="subsection">
                        <h4>Tons chauds & naturels</h4>
                        <div class="themes-container">
                            <div class="theme-card" data-theme="coucher-soleil">
                                <div class="theme-preview">
                                    <div style="background-color: #c94b4b; height: 20px;"></div>
                                    <div style="background-color: #4b134f; height: 20px;"></div>
                                </div>
                                <span>Coucher de Soleil</span>
                            </div>
                            <div class="theme-card" data-theme="foret-enchantee">
                                <div class="theme-preview">
                                    <div style="background-color: #004d40; height: 20px;"></div>
                                    <div style="background-color: #4caf50; height: 20px;"></div>
                                </div>
                                <span>Forêt Enchantée</span>
                            </div>
                            <div class="theme-card" data-theme="ambre-miel">
                                <div class="theme-preview">
                                    <div style="background-color: #ff8f00; height: 20px;"></div>
                                    <div style="background-color: #ffecb3; height: 20px;"></div>
                                </div>
                                <span>Ambre et Miel</span>
                            </div>
                            <div class="theme-card" data-theme="vintage-sepia">
                                <div class="theme-preview">
                                    <div style="background-color: #5d4037; height: 20px;"></div>
                                    <div style="background-color: #f5deb3; height: 20px;"></div>
                                </div>
                                <span>Sépia Vintage</span>
                            </div>
                        </div>
                    </div>
                    <div class="subsection">
                        <h4>Tons froids & modernes</h4>
                        <div class="themes-container">
                            <div class="theme-card" data-theme="bleu-mineral">
                                <div class="theme-preview">
                                    <div style="background-color: #37474f; height: 20px;"></div>
                                    <div style="background-color: #b0bec5; height: 20px;"></div>
                                </div>
                                <span>Bleu Minéral</span>
                            </div>
                            <div class="theme-card" data-theme="petales-rose">
                                <div class="theme-preview">
                                    <div style="background-color: #ad1457; height: 20px;"></div>
                                    <div style="background-color: #f8bbd0; height: 20px;"></div>
                                </div>
                                <span>Pétales de Rose</span>
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

        <div class="container" id="cv14-visible">
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
                        <?php if (empty($descriptions)): ?>
                        <p>Aucune description trouvée</p>
                    <?php else: ?>
                        <p><?= $descriptions['description'] ?></p>
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
                        <?php if (empty($competencesUtilisateur)): ?>
                            <p>Aucune compétence trouvée</p>
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

                            $percentages = [95, 90, 85, 80, 75, 70, 65];
                            $index = 0;
                            ?>
                            <div class="skill-item">
                                <?php foreach ($competences_a_afficher as $competence): ?>
                                    <?php $percentage = isset($percentages[$index]) ? $percentages[$index] : 75; ?>
                                    <span class="skill-name"><?= $competence['competence']; ?></span>
                                    <?php $index++; ?>
                                <?php endforeach; ?>
                            </div>
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
                                <?php if (empty($formationUsers)): ?>
                                    <p>Aucune formation trouvée</p>
                                <?php else: ?>
                                    <?php
                                    // Séparer les formations en deux groupes
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
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Experiences -->
                    <div class="experiences">
                        <h3 class="section-title">Expérience professionnelle</h3>
                        <div class="timeline-container">
                            <?php if (empty($afficheMetier)): ?>
                                <p>Aucune expérience professionnelle trouvée</p>
                            <?php else: ?>
                                <?php
                                // Séparer les expériences en deux groupes
                                $experiences_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                    return isset($exp['mis_en_avant']) && $exp['mis_en_avant'] == 1;
                                });
                                $experiences_non_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                    return !isset($exp['mis_en_avant']) || $exp['mis_en_avant'] != 1;
                                });

                                // Mélanger les expériences non mises en avant
                                shuffle($experiences_non_mises_en_avant);

                                // Nombre maximum d'expériences à afficher
                                $nombre_experiences = 3;

                                // Combiner les expériences en donnant priorité aux mises en avant
                                $experiences_a_afficher = array_slice(array_merge(
                                    $experiences_mises_en_avant,
                                    $experiences_non_mises_en_avant
                                ), 0, $nombre_experiences);

                                foreach ($experiences_a_afficher as $metier):
                                    ?>
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div> <!-- Fin de #box -->

        <!-- Conteneur caché pour le clone PDF -->
        <div style="position: absolute; left: -9999px; top:0;">
            <div class="container" id="container-for-pdf">
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
                            <?php if (empty($descriptions)): ?>
                            <p>Aucune description trouvée</p>
                        <?php else: ?>
                            <p><?= $descriptions['description'] ?></p>

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
                            <?php if (empty($competencesUtilisateur)): ?>
                                <p>Aucune compétence trouvée</p>
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

                                $percentages = [95, 90, 85, 80, 75, 70, 65];
                                $index = 0;
                                ?>
                                <div class="skill-item">
                                    <?php foreach ($competences_a_afficher as $competence): ?>
                                        <?php $percentage = isset($percentages[$index]) ? $percentages[$index] : 75; ?>
                                        <span class="skill-name"><?= $competence['competence']; ?></span>
                                        <?php $index++; ?>
                                    <?php endforeach; ?>
                                </div>
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
                                    <?php if (empty($formationUsers)): ?>
                                        <p>Aucune formation trouvée</p>
                                    <?php else: ?>
                                        <?php
                                        // Séparer les formations en deux groupes
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
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Experiences -->
                        <div class="experiences">
                            <h3 class="section-title">Expérience professionnelle</h3>
                            <div class="timeline-container">
                                <?php if (empty($afficheMetier)): ?>
                                    <p>Aucune expérience professionnelle trouvée</p>
                                <?php else: ?>
                                    <?php
                                    // Séparer les expériences en deux groupes
                                    $experiences_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                        return isset($exp['mis_en_avant']) && $exp['mis_en_avant'] == 1;
                                    });
                                    $experiences_non_mises_en_avant = array_filter($afficheMetier, function ($exp) {
                                        return !isset($exp['mis_en_avant']) || $exp['mis_en_avant'] != 1;
                                    });

                                    // Mélanger les expériences non mises en avant
                                    shuffle($experiences_non_mises_en_avant);

                                    // Nombre maximum d'expériences à afficher
                                    $nombre_experiences = 3;

                                    // Combiner les expériences en donnant priorité aux mises en avant
                                    $experiences_a_afficher = array_slice(array_merge(
                                        $experiences_mises_en_avant,
                                        $experiences_non_mises_en_avant
                                    ), 0, $nombre_experiences);

                                    foreach ($experiences_a_afficher as $metier):
                                        ?>
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
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    const {
                        jsPDF
                    } = window.jspdf;
                    const element = document.querySelector("#container-for-pdf");

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
                                // Supprimer le message d'attente
                                if (document.body.contains(loadingMessage)) {
                                    document.body.removeChild(loadingMessage);
                                }

                                const pdf = new jsPDF('p', 'mm', 'a4');
                                const imgProps = pdf.getImageProperties(dataUrl);
                                const pdfWidth = pdf.internal.pageSize.getWidth();
                                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                                pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                                pdf.save("cv-model14-" + Date.now() + ".pdf");
                            })
                            .catch(function (error) {
                                console.error('Une erreur est survenue lors de la génération du PDF:',
                                    error);
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
                    },
                    'coucher-soleil': {
                        primaryColor: '#c94b4b',
                        secondaryColor: '#4b134f',
                        accentColor: '#ff8a65',
                        darkText: '#3e2723',
                        lightText: '#795548'
                    },
                    'foret-enchantee': {
                        primaryColor: '#004d40',
                        secondaryColor: '#4caf50',
                        accentColor: '#81c784',
                        darkText: '#00382e',
                        lightText: '#388e3c'
                    },
                    'ambre-miel': {
                        primaryColor: '#ff8f00',
                        secondaryColor: '#ffecb3',
                        accentColor: '#ffca28',
                        darkText: '#e65100',
                        lightText: '#f57c00'
                    },
                    'vintage-sepia': {
                        primaryColor: '#5d4037',
                        secondaryColor: '#f5deb3',
                        accentColor: '#a1887f',
                        darkText: '#4e342e',
                        lightText: '#795548'
                    },
                    'bleu-mineral': {
                        primaryColor: '#37474f',
                        secondaryColor: '#b0bec5',
                        accentColor: '#607d8b',
                        darkText: '#263238',
                        lightText: '#546e7a'
                    },
                    'petales-rose': {
                        primaryColor: '#ad1457',
                        secondaryColor: '#f8bbd0',
                        accentColor: '#f06292',
                        darkText: '#880e4f',
                        lightText: '#c2185b'
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
                    document.documentElement.style.setProperty('--gradient-1',
                        `linear-gradient(135deg, ${theme.primaryColor} 0%, ${theme.accentColor} 100%)`);
                    document.documentElement.style.setProperty('--gradient-2',
                        `linear-gradient(135deg, ${theme.secondaryColor} 0%, ${theme.accentColor} 100%)`);

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
                        if (customPanel.classList.contains('active') && !customPanel.contains(event
                            .target) && !toggleBtn.contains(event.target)) {
                            customPanel.classList.remove('active');
                        }
                    });
                }
            });
        </script>
</body>

</html>