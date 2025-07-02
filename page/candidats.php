<?php
session_start();
include '../conn/conn.php';


if (isset($_GET['id'])) {
    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_GET['id'];


    $erreurs = '';

    $message = '';



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
    include_once('../controller/controller_appel_offre.php');
    include_once('../controller/controller_centre_interet.php');
    include_once('../controller/controller_niveau_etude_experience.php');
    include_once('../controller/controller_postulation.php');

}

?>






<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez le profil professionnel de <?php echo $userss['nom']; ?>, <?php echo $userss['competences']; ?> sur Work-Flexer. Compétences, expériences et réalisations.">
    <link rel="canonical" href="https://www.work-flexer.com/page/candidats.php?id=<?php echo $users_id; ?>">

    <!-- Open Graph / Facebook / LinkedIn / WhatsApp / Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.work-flexer.com/page/candidats.php?id=<?php echo $users_id; ?>">
    <meta property="og:title"
        content="<?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($userss['competences'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($userss['competences'], ENT_QUOTES, 'UTF-8'); ?> expérimenté(e) en recherche active. Découvrez le profil complet de <?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?> sur Work-Flexer.">
    <!-- Image optimisée pour LinkedIn (ratio 1.91:1 exactement comme recommandé) -->
    <meta property="og:image" content="https://www.work-flexer.com/image/logo1200x795.png?v=4">
    <meta property="og:image:secure_url" content="https://www.work-flexer.com/image/logo1200x795.png?v=4">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="795">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="<?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?> - Profil Work-Flexer">
    <meta property="og:site_name" content="Work-Flexer">
    <meta property="og:locale" content="fr_FR">

    <!-- LinkedIn spécifique -->
    <meta name="linkedin:owner" content="Work-Flexer">
    <meta name="author" content="<?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="article:published_time" content="<?php echo date('c'); ?>">
    <meta name="article:author" content="<?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="article:section" content="Profil Professionnel">
    <meta name="article:tag" content="<?php echo htmlspecialchars($userss['competences'], ENT_QUOTES, 'UTF-8'); ?>, Emploi, Recrutement, Work-Flexer">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
        content="<?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($userss['competences'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($userss['nom'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($userss['competences'], ENT_QUOTES, 'UTF-8'); ?> recherche activement de nouvelles opportunités professionnelles. Découvrez son profil complet sur Work-Flexer.">
    <meta name="twitter:image" content="https://www.work-flexer.com/image/logo1200x795.png?v=4">
    <meta name="twitter:image:alt" content="Logo Work-Flexer">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <title><?php echo $userss['nom']; ?> - <?php echo $userss['competences']; ?> | Work-Flexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



    <link rel="stylesheet" href="/css/user_profil.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/section2.css">
    <link rel="stylesheet" href="../css/candidat-profile.css">
    <link rel="stylesheet" href="../css/experience_highlight.css">
    <link rel="stylesheet" href="../css/competence_highlight.css">
    <link rel="stylesheet" href="../css/formation_highlight.css">
    <link rel="stylesheet" href="../css/outil_highlight.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <style>
        #none {
            display: none;
        }
    </style>

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles pour les indicateurs de mise en avant -->
    <style>
        .highlight-indicator {
            background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
            border-left: 4px solid #4caf50;
            padding: 12px 16px;
            margin: 15px 0 20px 0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.1);
            animation: fadeInSlide 0.5s ease-out;
        }

        .highlight-indicator i {
            color: #4caf50;
            font-size: 16px;
        }

        .highlight-indicator span {
            color: #2e7d32;
            font-weight: 500;
            font-size: 14px;
            line-height: 1.4;
        }

        @keyframes fadeInSlide {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Style responsive pour les petits écrans */
        @media (max-width: 768px) {
            .highlight-indicator {
                padding: 10px 12px;
                margin: 10px 0 15px 0;
            }

            .highlight-indicator span {
                font-size: 13px;
            }

            .highlight-indicator i {
                font-size: 14px;
            }
        }
    </style>

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>



    <section class="candidat-profile" id="ste">
        <div class="profile-header">
            <div class="profile-background"></div>

            <div class="profile-content">
                <div class="profile-image-container">
                    <div class="profile-image-wrapper">
                        <img class="profile-image" src="/upload/<?= $userss['images'] ?>" alt="Photo de profil">
                        <span class="profile-status online" title="Disponible"></span>
                    </div>
                </div>

                <div class="profile-info">
                    <h1 class="profile-name">
                        <?php $nom = explode(' ', $userss['nom']); ?>
                        <span class="first-name"><?php echo $nom[0]; ?></span>
                        <span class="last-name"><?php echo $nom[1]; ?></span>
                        <?php if (isset($nom[2])): ?>
                            <span class="last-name"><?php echo $nom[2]; ?></span>
                        <?php endif; ?>
                    </h1>

                    <div class="profile-title">
                        <span class="profession"><?php echo $userss['competences']; ?></span>
                    </div>

                </div>

                <div class="profile-metrics">
                    <?php if (isset($competencesCount)): ?>
                        <div class="metric">
                            <span class="metric-value"><?= $competencesCount ?></span>
                            <span class="metric-label">Compétences</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>




    <script>
        // Sélectionne l'élément avec la classe 'img' et l'assigne à img222
        let cache = document.getElementById('img23');

        let section = document.querySelector('.section2')
        // Sélectionne l'élément avec la classe 'ste' et l'assigne à section2
        let section2 = document.getElementById('ste');

        // Sélectionne l'élément avec la classe 'menu' et l'assigne à menu
        let menu1 = document.getElementById('menu');

        // Sélectionne l'élément avec la classe 'img111' et l'assigne à img111
        let img111 = document.getElementById('img24');

        // Ajoute un événement de clic à img222
        cache.addEventListener('click', () => {
            // Lorsque img222 est cliqué, déplace section2 à gauche (visible) et cache menu
            section2.style.left = '0';
            menu1.style.left = '-400px';
        });

        // Ajoute un événement de clic à img111
        img111.addEventListener('click', () => {
            // Lorsque img111 est cliqué, cache section2 et montre menu
            section2.style.left = '-100%';
            menu1.style.left = '0';
        });

    </script>


    <section class="section3" id="candidat">


        <?php if (isset($_SESSION['compte_entreprise'])): ?>
            <?php $contGetAllpostulation_users = count($getAllPostulation_users); ?>
            <?php if ($contGetAllpostulation_users > 0): ?>
                <button class="contactes"> <strong> Alerte!</strong> ce candidat a déjà postulé à une de vos offres d'emploi
                </button>
            <?php else: ?>
                <?php if ($getappelOffre): ?>
                    <button class="contactes"> <strong> Alerte!</strong> Ce candidat a déjà été contacté par votre entreprise
                    </button>
                    </div>
                <?php else: ?>
                    <div class="contact">
                        <button class="contacte"><span></span> Contacter ce candidat</button>
                    </div>

                    <form action="" method="post" class="form_appel" enctype="multipart/form-data">
                        <h1>Formulaire d'Appel d'Offres</h1>
                        <img class="fermer" src="../image/croix.png" alt="">
                        <div class="div">
                            <label for="titre">Poste Disponible:</label>
                            <input class="input1" type="text" name="titre" id="titre" required>
                        </div>
                        <div class="div">
                            <label for="message">Description du poste:</label>
                            <textarea name="message" id="summernote" cols="30" rows="10" required></textarea>
                        </div>

                        <input class="input" type="submit" name="sende" value="Envoyer">
                    </form>

                    <script>
                        let contacte = document.querySelector('.contacte');
                        let form_appel = document.querySelector('.form_appel');
                        let fermer = document.querySelector('.fermer')



                        contacte.addEventListener('click', () => {
                            if (form_appel.style.left = '260%') {
                                form_appel.style.left = '60%'
                            } else {
                                form_appel.style.left = '260%'
                            }

                            contacte.style.opacity = '0';
                        })
                        fermer.addEventListener('click', () => {
                            if (form_appel.style.left = '60%') {
                                form_appel.style.left = '260%'
                            } else {
                                form_appel.style.left = '60%'
                            }

                            contacte.style.opacity = '1';
                        })


                        $(document).ready(function () {
                            $('#summernote').summernote({
                                placeholder: 'ajoute une description!!',
                                tabsize: 6,
                                height: 120,
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ]

                            });
                        });
                    </script>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>



        <div class="container_box1" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out">
            <div class="box1">
                <h2>A propos de moi !</h2>

                <div class="description">
                    <?php
                    // Vérifier si la description de l'utilisateur est vide
                    if (empty($descriptions['description'])):
                        ?>
                        <p class="p">Ce profil n'a pas encore de description.</p>
                    <?php else: ?>
                        <?php echo $descriptions['description']; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>





        <div class="container_box2" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out">
            <div class="box1">
                <h1 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-brain"></i>
                    </div>
                    Expertise et compétences
                </h1>
            </div>
            <div class="box2">
                <h2 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span>Expérience professionnelle</span>
                </h2>
                
                <?php 
                // Vérifier s'il y a des expériences mises en avant
                $hasHighlightedExperiences = false;
                if (!empty($afficheMetier)) {
                    foreach ($afficheMetier as $metier) {
                        if (isset($metier['mis_en_avant']) && $metier['mis_en_avant'] == 1) {
                            $hasHighlightedExperiences = true;
                            break;
                        }
                    }
                }
                ?>
                
                <?php if ($hasHighlightedExperiences): ?>
                    <div class="highlight-indicator">
                        <i class="fas fa-star"></i>
                        <span>Expériences clés mises en valeur par le candidat</span>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($afficheMetier)): ?>
                    <p class="p">Aucune expérience professionnelle enregistrée !</p>
                <?php else: ?>
                    <div class="experiences-list">
                        <?php foreach ($afficheMetier as $metiers): ?>
                            <div class="experience-card <?php echo (isset($metiers['mis_en_avant']) && $metiers['mis_en_avant'] == 1) ? 'highlighted' : ''; ?>">
                                <?php if (isset($metiers['mis_en_avant']) && $metiers['mis_en_avant'] == 1): ?>
                                    <div class="highlighted-badge">
                                        <i class="fas fa-star"></i> Mis en avant
                                    </div>
                                <?php endif; ?>
                                <div class="experience-header">
                                    <div class="experience-title">
                                        <h3><?php echo $metiers['metier']; ?></h3>
                                    </div>
                                </div>

                                <div class="experience-period">
                                    <div class="period-start">
                                        <span><?php echo $metiers['moisDebut']; ?>
                                            <?php echo $metiers['anneeDebut']; ?></span>
                                    </div>
                                    <div class="period-separator">
                                        <span>-</span>
                                    </div>
                                    <?php if (isset($metiers['en_cours']) && $metiers['en_cours'] == 'En cours'): ?>
                                        <div class="period-end">
                                            <span>En cours</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="period-end">
                                            <span><?php echo $metiers['moisFin']; ?>
                                                <?php echo $metiers['anneeFin']; ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($metiers['description'])): ?>
                                    <div class="experience-description">
                                        <p><?php echo $metiers['description']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>



            <div class="box3">
                <h2 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span>Compétences</span>
                </h2>
                
                <?php 
                // Vérifier s'il y a des compétences mises en avant
                $hasHighlightedCompetences = false;
                if (!empty($competencesUtilisateur)) {
                    foreach ($competencesUtilisateur as $competence) {
                        if (isset($competence['mis_en_avant']) && $competence['mis_en_avant'] == 1) {
                            $hasHighlightedCompetences = true;
                            break;
                        }
                    }
                }
                ?>
                
                <?php if ($hasHighlightedCompetences): ?>
                    <div class="highlight-indicator">
                        <i class="fas fa-star"></i>
                        <span>Compétences principales valorisées par le candidat</span>
                    </div>
                <?php endif; ?>
                
                <div class="container_comp">
                    <?php if (empty($competencesUtilisateur)): ?>
                        <p class="p">
                            Aucune compétence pour votre profil
                        </p>
                    <?php else: ?>
                        <?php foreach ($competencesUtilisateur as $competence): ?>
                            <p class="comp <?php echo (isset($competence['mis_en_avant']) && $competence['mis_en_avant'] == 1) ? 'highlighted' : ''; ?>">
                                <i class="fas fa-star competence-star-icon"></i>
                                <?php echo $competence['competence']; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>


            <div class="box3">
                <h2 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Niveau d'expérience et d'étude</span>
                </h2>
                <div class="container_comp b2">

                    <?php if (empty($getNiveauEtude)): ?>
                        <p class="p">
                            Aucun niveau d'etude ajouter a votre profil
                        </p>
                    <?php else: ?>

                        <p data-aos="fade-up" data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out"
                            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
                            <strong>Niveau D'etude:</strong> <?php echo $getNiveauEtude['etude'] ?>
                        </p>
                        <p data-aos="fade-up" data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out"
                            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
                            <strong>Niveau d'expérience :</strong> <?php echo $getNiveauEtude['experience'] ?>
                        </p>

                    <?php endif; ?>

                </div>




            </div>
        </div>



        </div>


        </div>







        <div class="container_box3" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out">

            <div class="box4">
                <h1 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span>Formation</span>
                </h1>
            </div>
            <div class="box5">
                <?php 
                // Vérifier s'il y a des formations mises en avant
                $hasHighlightedFormations = false;
                if (!empty($formationUsers)) {
                    foreach ($formationUsers as $formation) {
                        if (isset($formation['mis_en_avant']) && $formation['mis_en_avant'] == 1) {
                            $hasHighlightedFormations = true;
                            break;
                        }
                    }
                }
                ?>
                
                <?php if ($hasHighlightedFormations): ?>
                    <div class="highlight-indicator">
                        <i class="fas fa-star"></i>
                        <span>Formations stratégiques sélectionnées par le candidat</span>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($formationUsers)): ?>
                    <p class="p">Aucune formation enregistrée pour votre profil!</p>
                <?php else: ?>
                    <div class="formations-list">
                        <?php foreach ($formationUsers as $formations): ?>
                            <div class="formation-card <?php echo (isset($formations['mis_en_avant']) && $formations['mis_en_avant'] == 1) ? 'highlighted' : ''; ?>">
                                <div class="formation-content">
                                    <div class="formation-header">
                                        <div class="formation-period">
                                            <?php if (isset($formations['en_cours']) && $formations['en_cours'] == 'En cours'): ?>
                                                <span class="date">
                                                    <?php echo $formations['moisDebut']; ?>             <?php echo $formations['anneeDebut']; ?>
                                                    -
                                                    En cours
                                                </span>
                                            <?php else: ?>
                                                <span class="date">
                                                    <?php echo $formations['moisDebut']; ?>             <?php echo $formations['anneeDebut']; ?>
                                                    -
                                                    <?php echo $formations['moisFin']; ?>             <?php echo $formations['anneeFin']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="formation-details">
                                        <div class="formation-main-info">
                                            <h3 class="formation-title">
                                                <i class="fas fa-star formation-star-icon"></i>
                                                <?php echo htmlspecialchars($formations['Filiere']); ?>
                                            </h3>
                                            <p class="formation-school">
                                                <?php echo htmlspecialchars($formations['etablissement']); ?>
                                            </p>
                                        </div>
                                        <div class="formation-level">
                                            <span
                                                class="level-badge"><?php echo htmlspecialchars($formations['niveau']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>





        <div class="container_box7" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out">

            <div class="box1">
                <h1 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <span>Projets et réalisations</span>
                </h1>
            </div>

            <div class="box2">
                <?php if (empty($affichePojetUsers)): ?>
                    <p class="p">Aucun projet ajouté pour votre profil !</p>
                <?php else: ?>
                    <?php foreach ($affichePojetUsers as $projets): ?>
                        <div class="info_projet">
                            <h2>
                                <?php echo $projets['titre'] ?>
                            </h2>
                            <p>
                                <?php echo $projets['projetdescription'] ?>
                            </p>

                            <a href="<?php echo $projets['liens'] ?>">Click sur ce lien</a>

                            <img src="../upload/<?php echo $projets['images'] ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>




        <div class="container_box5" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out">
            <div class="box1">
                <h1 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <span>Maîtrise des outils informatiques</span>
                </h1>
            </div>

            <div class="box2">
                <?php 
                // Vérifier s'il y a des outils mis en avant
                $hasHighlightedOutils = false;
                if (!empty($afficheOutil)) {
                    foreach ($afficheOutil as $outil) {
                        if (isset($outil['mis_en_avant']) && $outil['mis_en_avant'] == 1) {
                            $hasHighlightedOutils = true;
                            break;
                        }
                    }
                }
                ?>
                
                <?php if ($hasHighlightedOutils): ?>
                    <div class="highlight-indicator">
                        <i class="fas fa-star"></i>
                        <span>Outils de prédilection mis en valeur par le candidat</span>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($afficheOutil)): ?>
                    <p class="p">Aucun outil informatique ajouté à votre profil</p>
                <?php else: ?>
                    <div class="tools-list">
                        <?php foreach ($afficheOutil as $outils): ?>
                            <div class="tool-item <?php echo (isset($outils['mis_en_avant']) && $outils['mis_en_avant'] == 1) ? 'highlighted' : ''; ?>">
                                <div class="tool-info">
                                    <span class="tool-name">
                                        <i class="fas fa-star outil-star-icon"></i>
                                        <?php echo $outils['outil'] ?>
                                    </span>
                                    <span
                                        class="tool-level <?php echo strtolower($outils['niveau']) ?>"><?php echo $outils['niveau'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>








        <div class="container_box5" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out">
            <div class="box1">
                <h1 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-language"></i>
                    </div>
                    <span>Maîtrise des langues</span>
                </h1>
            </div>

            <div class="box2">
                <?php if (empty($afficheLangues)): ?>
                    <p class="p">Aucune langue ajoutée à votre profil</p>
                <?php else: ?>
                    <div class="languages-list">
                        <?php foreach ($afficheLangues as $langues): ?>
                            <div class="language-item">
                                <div class="language-info">
                                    <span class="language-name"><?php echo $langues['langue']; ?></span>
                                    <span
                                        class="language-level <?php echo strtolower($langues['niveau']) ?>"><?php echo $langues['niveau']; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>


        </div>




        <div class="container_box8">
            <div class="box1">
                <h1 class="header-with-icon">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-heart"></i>
                    </div>
                    <span>Centre d'intérêt</span>
                </h1>
            </div>

            <div class="box2">
                <?php if (empty($afficheCentreInteret)): ?>
                    <p class="p">Aucun centre d'intérêt ajouté à votre profil</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($afficheCentreInteret as $centreInteret): ?>
                            <li>
                                <?= $centreInteret['interet'] ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>




    </section>


    <script>
        // ..
        AOS.init();

        // You can also pass an optional settings object
        // below listed default settings
        AOS.init({
            // Global settings:
            disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
            initClassName: 'aos-init', // class applied after initialization
            animatedClassName: 'aos-animate', // class applied on animation
            useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 400, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    </script>

    <script>




        $(document).ready(function () {
            $('#description').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function () {
            $('#projetdescription').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <!-- Script pour l'animation de l'en-tête des compétences -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animation de l'en-tête des compétences
            const skillsHeader = document.querySelector('.skills-header');

            if (skillsHeader) {
                // Créer un observateur d'intersection pour déclencher l'animation au défilement
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Ajouter une classe pour déclencher l'animation
                            skillsHeader.classList.add('animated');

                            // Ajouter un effet d'apparition progressive pour les points de décoration
                            const dots = skillsHeader.querySelectorAll('.decoration-dot');
                            dots.forEach((dot, index) => {
                                setTimeout(() => {
                                    dot.style.opacity = '1';
                                }, 300 * (index + 1));
                            });

                            // Effet spécial pour l'icône
                            const icon = skillsHeader.querySelector('.header-icon');
                            if (icon) {
                                icon.style.transform = 'scale(1.1)';
                                setTimeout(() => {
                                    icon.style.transform = 'scale(1)';
                                }, 300);
                            }

                            // Arrêter d'observer une fois animé
                            observer.disconnect();
                        }
                    });
                }, { threshold: 0.3 });

                // Commencer à observer l'en-tête
                observer.observe(skillsHeader);

                // Ajouter un effet au survol pour les points de décoration
                const dots = skillsHeader.querySelectorAll('.decoration-dot');
                dots.forEach(dot => {
                    dot.addEventListener('mouseover', function () {
                        this.style.transform = 'scale(1.5)';
                    });

                    dot.addEventListener('mouseout', function () {
                        this.style.transform = '';
                    });
                });
            }
        });
    </script>

    <!-- Liens vers les nouveaux fichiers CSS et JS -->
    <link rel="stylesheet" href="../css/candidat-profile.css">
    <script src="../js/candidat-profile.js"></script>
</body>

</html>