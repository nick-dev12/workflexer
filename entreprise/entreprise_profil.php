<?php
session_start();
include('../conn/conn.php');

include('app/controller/controllerEntreprise.php');
include('app/controller/controllerDescription.php');
include('app/controller/controllerOffre_emploi.php');

$afficheCategorie_entreprise = getALLcategorieEntreprise($db, $_SESSION['compte_entreprise']);
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Manifest pour PWA -->
    <link rel="manifest" href="../manifest.json">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>
        <?= $getEntreprise['entreprise']; ?>
    </title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <!-- Charger une seule version de jQuery (version complète) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote CSS et JS (version plus récente) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Owl Carousel CSS avec chemins corrects -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">

    <link rel="stylesheet" href="../css/entreprise_profil.css">
    <link rel="stylesheet" href="../css/statistiques.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/notifications.css">
    <link rel="stylesheet" href="../css/forms_entreprise.css">
    <!-- Utiliser la bibliothèque HTML5-QRCode depuis CDN au lieu du fichier local -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/dist/html5-qrcode.min.js"></script>

    <!-- Chart.js pour les graphiques -->
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Script pour les fonctionnalités avancées des statistiques -->
    <script defer src="../js/statistiques.js"></script>
    <!-- Bibliothèques pour l'exportation des données -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- Firebase App (the core Firebase SDK) -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>

    <!-- Firebase Messaging -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js"></script>

    <!-- Custom Firebase initialization -->
    <!-- <script src="../js/firebase-init.js"></script> COMMENTED OUT -->

    <!-- Firebase notification styles -->
    <style>
        #enable-notifications {
            position: fixed;
            right: 20px;
            bottom: 150px;
            z-index: 1000;
            padding: 12px 18px;
            border-radius: 30px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            color: #495057;
        }

        #enable-notifications:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.18);
        }

        #enable-notifications.notifications-enabled {
            background-color: #4caf50;
            color: white;
        }

        #enable-notifications.notifications-disabled {
            background-color: #f44336;
            color: white;
        }

        #enable-notifications i {
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include('../include/header_entreprise.php') ?>
    <?php include('../include/notifications.php') ?>


    <section class="section3">

        <!-- <div class="section2-div ">
            <div class="slider1 owl-carousel">

                <img src="../image/cc1.webp" alt="">

                <img src="../image/cc3.jpg" alt="">

                <img src="../image/cc4.png" alt="">

                <img src="../image/cc5.jpeg" alt="">

            </div>

            <div class="box1">
                <h1>Bienvenue au Centre de Gestion des Offres et Appels d'Offre de Work-Flexer</h1>

                <p>
                    <span>
                        Nous sommes heureux de vous accueillir dans notre plateforme exclusive de gestion des offres et
                        appels d'offre. Work-Flexer, votre partenaire privilégié, met à votre disposition un outil de
                        gestion avancé pour simplifier le processus de recrutement et trouver les talents les plus
                        qualifiés
                        pour votre organisation.
                    </span>
                </p>

            </div>
        </div> -->



        <!-- Section des statistiques -->
        <?php
        // Inclure le fichier des fonctions de statistiques
        include_once('app/model/statistiques.php');

        // Récupérer toutes les statistiques
        $stats = getAllStatistiques($db, $_SESSION['compte_entreprise']);

        // Calculer le taux d'acceptation
        $tauxAcceptation = 0;
        if ($stats['candidatures_total'] > 0) {
            $tauxAcceptation = round(($stats['candidats_acceptes'] / $stats['candidatures_total']) * 100);
        }

        // Calculer le taux de refus
        $tauxRefus = 0;
        if ($stats['candidatures_total'] > 0) {
            $tauxRefus = round(($stats['candidats_refuses'] / $stats['candidatures_total']) * 100);
        }
        ?>

        <div class="stats-section stats-summary">
            <div class="stats-section-header">
                <h2>Aperçu des statistiques</h2>
                <div class="stats-actions">
                    <a href="donnee_statistique.php" class="btn-view-stats">
                        <i class="fas fa-chart-line"></i>
                        <span>Voir les statistiques détaillées</span>
                    </a>
                </div>
            </div>

            <div class="stats-cards">
                <div class="stats-card">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stats-card-title">Offres publiées</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['offres_publiees'] ?></div>
                </div>

                <div class="stats-card success">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-card-title">Candidatures reçues</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['candidatures_total'] ?></div>
                </div>

                <div class="stats-card info">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stats-card-title">Vues des offres</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['vues_total'] ?></div>
                </div>

                <div class="stats-card success">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-card-title">Candidats acceptés</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['candidats_acceptes'] ?></div>
                    <div class="stats-card-trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span><?= $tauxAcceptation ?>% de taux d'acceptation</span>
                    </div>
                </div>
            </div>

            <div class="stats-footer">
                <p>Pour accéder à toutes les statistiques et analyses détaillées, cliquez sur le bouton "Voir les
                    statistiques détaillées".</p>
            </div>
        </div>

        <!-- Afficher le QR code -->
        <div class="qr-code">
            <!-- Bouton pour ouvrir le scanner de QR code -->
            <button id="open-scanner">Scanner le QR Code d'un candidat <img src="../image/scanner.png" alt=""></button>
        </div>


        <!-- Conteneur pour le scanner de QR code -->
        <div id="qr-reader"></div>

        <!-- Add notification button with a clear data-entreprise-id attribute -->
        <button id="enable-notifications"
            data-entreprise-id="<?php echo htmlspecialchars($_SESSION['compte_entreprise']); ?>">
            <i class="fas fa-bell"></i> Activer les notifications
        </button>
        <div id="notification-status-entreprise" style="text-align: right; margin-top: 5px;"></div>
        <!-- Conteneur pour messages d'état -->

        <script>
            let scannerActive = false;

            // Vérifier si la classe Html5Qrcode est disponible
            if (typeof Html5Qrcode !== 'undefined') {
                const html5QrCode = new Html5Qrcode("qr-reader");

                document.getElementById('open-scanner').addEventListener('click', function () {
                    if (scannerActive) {
                        html5QrCode.stop().then(ignore => {
                            document.getElementById('qr-reader').style.display = 'none';
                            scannerActive = false;
                            console.log("Scanner arrêté.");
                        }).catch(err => {
                            console.log(`Erreur lors de l'arrêt du scanner: ${err}`);
                        });
                    } else {
                        document.getElementById('qr-reader').style.display = 'block';
                        html5QrCode.start(
                            { facingMode: "environment" }, // Utiliser la caméra arrière
                            {
                                fps: 10,    // Fréquence d'images par seconde
                                qrbox: 250  // Taille de la boîte de scan
                            },
                            qrCodeMessage => {
                                // Ouvrir le lien scanné dans un nouvel onglet
                                window.open(qrCodeMessage, '_blank');
                                // Arrêter le scanner
                                html5QrCode.stop().then(ignore => {
                                    document.getElementById('qr-reader').style.display = 'none';
                                    scannerActive = false;
                                    console.log("Scanner arrêté.");
                                }).catch(err => {
                                    console.log(`Erreur lors de l'arrêt du scanner: ${err}`);
                                });
                            },
                            errorMessage => {
                                console.log(`Erreur de scan: ${errorMessage}`);
                            }
                        ).catch(err => {
                            console.log(`Erreur de démarrage du scanner: ${err}`);
                        });
                        scannerActive = true;
                    }
                });
            } else {
                console.warn("La bibliothèque Html5Qrcode n'est pas chargée. La fonctionnalité de scan QR est désactivée.");
                const openScannerBtn = document.getElementById('open-scanner');
                if (openScannerBtn) {
                    openScannerBtn.disabled = true;
                    openScannerBtn.title = "Scanner QR désactivé - Bibliothèque non chargée";
                }
            }
        </script>

        <div class="container_box3">
            <div class="box1">
                <h2>Description !</h2>
                <?php if (isset($afficheDescriptionentreprise['descriptions'])): ?>
                    <p>
                        <?= $afficheDescriptionentreprise['descriptions'] ?>
                    </p>
                <?php else: ?>
                    <p class="p"> Ajouter une description pour que votre entreprise soit connue </p>
                <?php endif; ?>
            </div>
            <?php if (isset($afficheDescriptionentreprise['descriptions'])): ?>
                <button class="btn1"><img src="../image/ajouters.png" alt=""></button>

                <div class="form_desc">
                    <form method="post" action="" class="enterprise-form form-animate-in">
                        <button type="button" class="form-close-btn close-desc-form">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="form-header">
                            <h2>Description de l'entreprise</h2>
                            <p>Présentez votre entreprise de manière attractive et professionnelle</p>
                        </div>
                        <div class="form-group">
                            <textarea name="descriptions" id="summernote" class="form-control"
                                placeholder="Décrivez votre entreprise, sa culture, ses valeurs et sa mission..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="site" class="form-label">Site web de l'entreprise (facultatif)</label>
                            <input type="text" name="liens" id="site" class="form-control"
                                placeholder="https://www.votre-entreprise.com">
                        </div>
                        <button type="submit" name="modifiers" class="form-button">
                            Modifier
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <button class="btn1"><img src="../image/ajouter2.png" alt=""></button>

                <div class="form_desc">

                    <form method="post" action="" class="enterprise-form form-animate-in">
                        <button type="button" class="form-close-btn close-desc-form">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="form-header">
                            <h2>Description de l'entreprise</h2>
                            <p>Présentez votre entreprise de manière attractive et professionnelle</p>
                        </div>
                        <div class="form-group">
                            <textarea name="descriptions" id="summernote" class="form-control"
                                placeholder="Décrivez votre entreprise, sa culture, ses valeurs et sa mission..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="site" class="form-label">Site web de l'entreprise (facultatif)</label>
                            <input type="text" name="liens" id="site" class="form-control"
                                placeholder="https://www.votre-entreprise.com">
                        </div>
                        <button type="submit" name="ajouter" class="form-button">
                            Ajouter
                        </button>
                    </form>
                </div>
            <?php endif; ?>



            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Gestion du formulaire de description
                    const btn1 = document.querySelector('.btn1');
                    const formDesc = document.querySelector('.form_desc');
                    const closeDescBtn = document.querySelector('.close-desc-form');

                    if (btn1 && formDesc && closeDescBtn) {
                        btn1.addEventListener('click', () => {
                            formDesc.classList.toggle('active');
                            if (formDesc.classList.contains('active')) {
                                // Ajuster la hauteur automatiquement
                                const formHeight = formDesc.querySelector('.enterprise-form').offsetHeight;
                                formDesc.style.height = formHeight + 40 + 'px'; // Ajouter un peu d'espace
                            } else {
                                formDesc.style.height = '0';
                            }
                        });

                        closeDescBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            formDesc.querySelector('.enterprise-form').classList.add('form-animate-out');
                            setTimeout(() => {
                                formDesc.classList.remove('active');
                                formDesc.style.height = '0';
                                formDesc.querySelector('.enterprise-form').classList.remove('form-animate-out');
                            }, 300);
                        });
                    }

                    // Initialisation de Summernote
                    $('#summernote').summernote({
                        placeholder: 'Décrivez votre entreprise de manière détaillée...',
                        tabsize: 2,
                        height: 200, // Augmenter la hauteur par défaut
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ],
                        callbacks: {
                            onChange: function (contents, $editable) {
                                // Réajuster la hauteur du conteneur quand l'éditeur change
                                if (formDesc.classList.contains('active')) {
                                    const formHeight = formDesc.querySelector('.enterprise-form').offsetHeight;
                                    formDesc.style.height = formHeight + 40 + 'px';
                                }
                            }
                        }
                    });
                });
            </script>
        </div>


        <!-- Publication d'une offre -->
        <div class="container_box1 publication-offre">
            <div class="box1">
                <h1>Publier une offre!!</h1>
            </div>

            <div class="box2">
                <button class="btn2"><img src="../image/ajouter2.png" alt=""></button>
            </div>
            <div class="form_off">
                <form method="post" action="" class="enterprise-form form-animate-in">
                    <button type="button" class="form-close-btn close-off-form">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="form-header">
                        <h2>Publication d'une nouvelle offre</h2>
                        <p>Créez une offre d'emploi attractive pour trouver les meilleurs talents</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="poste" class="form-label">Poste disponible</label>
                            <input type="text" name="poste" id="poste" class="form-control" required
                                placeholder="Ex: Développeur Full-Stack">
                        </div>
                        <div class="form-group">
                            <label for="places" class="form-label">Nombre de postes</label>
                            <input type="number" name="places" id="places" class="form-control" required
                                placeholder="Ex: 2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mission" class="form-label">Missions et responsabilités</label>
                        <textarea name="mission" id="mission" class="form-control" required
                            placeholder="Décrivez les principales missions et responsabilités du poste..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="profil" class="form-label">Profil recherché</label>
                        <textarea name="profil" id="profil" class="form-control" required
                            placeholder="Décrivez les compétences et qualités requises pour le poste..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contrat" class="form-label">Type de contrat</label>
                            <select name="contrat" id="contrat" class="form-control" required>
                                <option value="">Sélectionnez un type de contrat</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="INTERIM">Intérim</option>
                                <option value="FREELANCE">Freelance</option>
                                <option value="APPRENTISSAGE">Apprentissage</option>
                                <option value="STAGE">Stage</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="etude" class="form-label">Niveau d'études requis</label>
                            <select name="etude" id="etude" class="form-control" required>
                                <option value="">Sélectionnez un niveau d'études</option>
                                <option value="Bac+1an">Bac+1</option>
                                <option value="Bac+2ans">Bac+2</option>
                                <option value="Bac+3ans">Bac+3</option>
                                <option value="Bac+4ans">Bac+4</option>
                                <option value="Bac+5ans">Bac+5</option>
                                <option value="Bac+6ans">Bac+6</option>
                                <option value="Bac+7ans">Bac+7</option>
                                <option value="Bac+8ans">Bac+8</option>
                                <option value="Bac+9ans">Bac+9</option>
                                <option value="Bac+10ans">Bac+10</option>
                                <option value="Aucun">Aucun diplôme requis</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="experience" class="form-label">Expérience requise</label>
                            <select name="experience" id="experience" class="form-control" required>
                                <option value="">Sélectionnez le niveau d'expérience</option>
                                <option value="Debutant">Débutant</option>
                                <option value="1an">1 an</option>
                                <option value="2ans">2 ans</option>
                                <option value="3ans">3 ans</option>
                                <option value="4ans">4 ans</option>
                                <option value="5ans">5 ans</option>
                                <option value="6ans">6 ans</option>
                                <option value="7ans">7 ans</option>
                                <option value="8ans">8 ans</option>
                                <option value="9ans">9 ans</option>
                                <option value="10ans">10 ans</option>
                                <option value="Aucun">Aucune expérience requise</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duree" class="form-label">Durée de publication</label>
                            <input type="number" name="duree" id="duree" class="form-control" required
                                placeholder="Nombre de jours">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="localite" class="form-label">Localisation</label>
                            <input type="text" name="localite" id="localite" class="form-control" required
                                placeholder="Ex: Paris, Lyon, Remote">
                        </div>
                        <div class="form-group">
                            <label for="Langues" class="form-label">Langues requises</label>
                            <input type="text" name="langues" id="Langues" class="form-control" required
                                placeholder="Ex: Français, Anglais">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="categorie" class="form-label">Secteur d'activité</label>
                        <select name="categorie" id="categorie" class="form-control" required>
                            <option value="">Sélectionnez un secteur</option>
                            <option value="Informatique et tech">Informatique et tech</option>
                            <option value="Design et création">Design et création</option>
                            <option value="Rédaction et traduction">Rédaction et traduction</option>
                            <option value="Marketing et communication">Marketing et communication</option>
                            <option value="Finance et comptabilité">Finance et comptabilité</option>
                            <option value="Juridique">Juridique</option>
                            <option value="Ingénierie et architecture">Ingénierie et architecture</option>
                            <option value="Santé et bien-être">Santé et bien-être</option>
                            <option value="Éducation et formation">Éducation et formation</option>
                            <option value="Tourisme et hôtellerie">Tourisme et hôtellerie</option>
                            <option value="Commerce et vente">Commerce et vente</option>
                            <option value="Transport et logistique">Transport et logistique</option>
                            <option value="Agriculture et agroalimentaire">Agriculture et agroalimentaire</option>
                            <option value="Ressources humaines">Ressources humaines</option>
                            <option value="Conseil et gestion d'entreprise">Conseil et gestion d'entreprise</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <button type="submit" name="publier" class="form-button">Publier l'offre</button>
                </form>

            </div>

            <script>
                let btn2 = document.querySelector('.btn2')
                let form_off = document.querySelector('.form_off')
                let img1 = document.querySelector('.img1')

                btn2.addEventListener('click', () => {
                    form_off.style.height = 'auto'
                })

                // Vérifier si img1 existe avant d'ajouter un écouteur d'événement
                if (img1) {
                    img1.addEventListener('click', () => {
                        form_off.style.height = '0'
                    })
                }
            </script>
        </div>

        <!-- Mes offres publiées -->
        <div class="container_box2">
            <div class="box1">
                <h1>Catégories d'offres</h1>
                <span>
                    <?php
                    $countOffre = count($afficheOffreEmplois);
                    echo $countOffre;

                    // Récupérer les catégories uniques
                    $categories = [];
                    foreach ($afficheOffreEmplois as $offre) {
                        if (!empty($offre['categorie']) && !in_array($offre['categorie'], $categories)) {
                            $categories[] = $offre['categorie'];
                        }
                    }
                    ?>
                </span>
            </div>

            <div class="categories-grid">
                <?php
                if (empty($afficheCategorie_entreprise)):
                    ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3>Aucune catégorie</h3>
                        <p>Vous n'avez pas encore publié d'offres d'emploi. Veuillez ajouter une offre pour créer des
                            catégories.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($afficheCategorie_entreprise as $categorieentreprise):
                        // Compter les offres dans cette catégorie
                        $countOffreCategorie = 0;
                        $offres_categorie = getOffre_categorie($db, $categorieentreprise['categori'], $_SESSION['compte_entreprise']);
                        foreach ($offres_categorie as $offre) {
                            if ($offre['categorie'] === $categorieentreprise['categori']) {
                                $countOffreCategorie++;
                            }
                        }

                        // Définir une icône par défaut ou selon la catégorie
                        $categoryIcon = 'fa-briefcase'; // icône par défaut
                        switch (strtolower($categorieentreprise['categori'])) {
                            case 'informatique et tech':
                                $categoryIcon = 'fa-laptop-code';
                                break;
                            case 'design et création':
                                $categoryIcon = 'fa-palette';
                                break;
                            case 'rédaction et traduction':
                                $categoryIcon = 'fa-language';
                                break;
                            case 'marketing et communication':
                                $categoryIcon = 'fa-bullhorn';
                                break;
                            case 'conseil et gestion d\'entreprise':
                                $categoryIcon = 'fa-chart-line';
                                break;
                            case 'juridique':
                                $categoryIcon = 'fa-balance-scale';
                                break;
                            case 'ingénierie et architecture':
                                $categoryIcon = 'fa-drafting-compass';
                                break;
                            case 'finance et comptabilité':
                                $categoryIcon = 'fa-coins';
                                break;
                            case 'santé et bien-être':
                                $categoryIcon = 'fa-heartbeat';
                                break;
                            case 'éducation et formation':
                                $categoryIcon = 'fa-graduation-cap';
                                break;
                            case 'tourisme et hôtellerie':
                                $categoryIcon = 'fa-hotel';
                                break;
                            case 'commerce et vente':
                                $categoryIcon = 'fa-shopping-cart';
                                break;
                            case 'transport et logistique':
                                $categoryIcon = 'fa-truck';
                                break;
                            case 'agriculture et agroalimentaire':
                                $categoryIcon = 'fa-seedling';
                                break;
                        }

                        if ($countOffreCategorie > 0):
                            ?>
                            <a href="../entreprise/offres_categorie.php?pageoffecategorie=<?= urlencode($categorieentreprise['categori']) ?>"
                                class="category-card">
                                <div class="category-icon">
                                    <i class="fas <?= $categoryIcon ?>"></i>
                                </div>
                                <div class="category-info">
                                    <h3><?= $categorieentreprise['categori'] ?></h3>
                                    <div class="category-count">
                                        <span class="count"><?= $countOffreCategorie ?></span>
                                        <span class="label"><?= $countOffreCategorie > 1 ? 'offres' : 'offre' ?></span>
                                    </div>
                                </div>
                                <div class="category-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="box_assistance">
            <div>
                <a href="#container_box6"><button id="contacte"><img src="../image/service.png" alt=""></button></a>
                <a class="whatsapp" href="https://api.whatsapp.com/send?phone=785303879" target="_blank"><img
                        src="../image/whatsapp.png" alt=""></a>
                <a class="mail" href="mailto:workflexer.service@gmail.com"><img src="../image/icons8-gmail-48.png"
                        alt=""> </a>
            </div>
        </div>

        <div class="container_box6" id="container_box6">
            <form action="" method="post" class="enterprise-form form-animate-in">
                <button type="button" class="form-close-btn close-assistance-form">
                    <i class="fas fa-times"></i>
                </button>
                <div class="form-header">
                    <h2>Besoin d'assistance ?</h2>
                    <p>Notre équipe est là pour vous aider. Écrivez-nous !</p>
                </div>

                <div class="form-group">
                    <textarea name="message" id="message" class="form-control" required
                        placeholder="Décrivez votre question ou problème..."></textarea>
                </div>

                <button type="submit" name="send" class="form-button">Envoyer</button>
            </form>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    <script src="../js/notifications-entreprise.js" defer></script>



    <script>
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
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function () {
            $('#mission').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function () {
            $('#profil').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Initialiser le carrousel 1 avec la portée appropriée
            $('.slider1').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 700,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel1 = $('.slider').owlCarousel();
            $('.owl-next').click(function () {
                carousel1.trigger('next.owl.carousel');
            })
            $('.owl-prev').click(function () {
                carousel1.trigger('prev.owl.carousel');
            })


        });
    </script>

    <!-- Script pour l'exportation des statistiques -->
    <script src="../js/statistiques-export.js"></script>

    <script>
        // Ajouter les attributs data aux cartes de statistiques pour l'exportation
        document.addEventListener('DOMContentLoaded', function () {
            // Récupérer les cartes de statistiques
            const statsCards = document.querySelectorAll('.stats-card');

            // Ajouter les attributs data
            statsCards.forEach(card => {
                const title = card.querySelector('.stats-card-title').textContent.trim().toLowerCase();
                const value = card.querySelector('.stats-card-value').textContent.trim();

                // Déterminer le type de statistique
                let type = '';
                if (title.includes('offres publiées')) {
                    type = 'offres_publiees';
                } else if (title.includes('candidatures')) {
                    type = 'candidatures_total';
                } else if (title.includes('candidats acceptés')) {
                    type = 'candidats_acceptes';
                } else if (title.includes('vues')) {
                    type = 'vues_total';
                }

                // Ajouter les attributs data
                if (type) {
                    card.setAttribute('data-type', type);
                    card.setAttribute('data-value', value.replace(/\D/g, ''));
                }
            });
        });
    </script>

    <script>
        // Gestion des formulaires
        document.addEventListener('DOMContentLoaded', function () {
            // Formulaire de description
            const formDesc = document.querySelector('.form_desc');
            const closeDescBtn = document.querySelector('.close-desc-form');
            const btn1 = document.querySelector('.btn1');

            if (closeDescBtn && formDesc && btn1) {
                closeDescBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    formDesc.querySelector('form').classList.add('form-animate-out');
                    setTimeout(() => {
                        formDesc.style.height = '0px';
                        formDesc.querySelector('form').classList.remove('form-animate-out');
                    }, 300);
                });

                btn1.addEventListener('click', () => {
                    if (formDesc.style.height === '0px' || !formDesc.style.height) {
                        formDesc.style.height = 'auto';
                        formDesc.querySelector('form').classList.add('form-animate-in');
                    }
                });
            }

            // Formulaire d'offre
            const formOff = document.querySelector('.form_off');
            const closeOffBtn = document.querySelector('.close-off-form');
            const btn2 = document.querySelector('.btn2');

            if (closeOffBtn && formOff && btn2) {
                closeOffBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    formOff.querySelector('form').classList.add('form-animate-out');
                    setTimeout(() => {
                        formOff.style.height = '0px';
                        formOff.querySelector('form').classList.remove('form-animate-out');
                    }, 300);
                });

                btn2.addEventListener('click', () => {
                    if (formOff.style.height === '0px' || !formOff.style.height) {
                        formOff.style.height = 'auto';
                        formOff.querySelector('form').classList.add('form-animate-in');
                    }
                });
            }

            // Formulaire d'assistance
            const formAssistance = document.querySelector('#container_box6');
            const closeAssistanceBtn = document.querySelector('.close-assistance-form');
            const contactBtn = document.querySelector('#contacte');

            if (closeAssistanceBtn && formAssistance && contactBtn) {
                closeAssistanceBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    formAssistance.querySelector('form').classList.add('form-animate-out');
                    setTimeout(() => {
                        formAssistance.style.display = 'none';
                        formAssistance.querySelector('form').classList.remove('form-animate-out');
                    }, 300);
                });

                contactBtn.addEventListener('click', () => {
                    formAssistance.style.display = 'block';
                    formAssistance.querySelector('form').classList.add('form-animate-in');
                });
            }
        });
    </script>

    <!-- Conteneur pour les messages de statut des notifications -->
    <div id="notification-status-entreprise" class="notification-status-container"></div>

</body>

</html>