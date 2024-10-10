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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>model7</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/model7.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>
    <?php include('../navbare.php') ?>


    <section class="section3">

        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>


            <div class="box">
                <p>Couleur de fond</p>
                <input type="color" name="" id="fontColor2">
            </div>

            <div class="box">
                <p>Couleur du texte</p>
                <input type="color" name="" id="fontColor3">
            </div>

        </div>

        <div id="container">
            <div id="model7">
                <div class="box-float">
                </div>
                <div class="header">
                    <h1><?= $userss['nom'] ?></h1>
                    <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    <h2><?= $userss['competences'] ?></h2>
                </div>
                <div class="content">
                    <div class="left-column">
                        <section class="about">
                            <h3><img src="../image/a propos.png" alt=""> À PROPOS DE MOI</h3>
                            <?php if (empty($descriptions)): ?>
                                <p>Aucune donnée trouvée</p>
                            <?php else: ?>
                                <p class="p">
                                    <?= $descriptions['description'] ?>
                                </p>
                            <?php endif; ?>
                            <ul class="contact-info">
                                <li><img src="../image/phone.png" alt="phone"> <?= $userss['phone'] ?></li>
                                <li> <img src="../image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></li>
                                <li> <img src="../image/address.png" alt=""> <?= $userss['ville'] ?></li>
                                <li><img src="../image/nationaliet.png" alt="">*********</li>
                            </ul>
                        </section>
                        <section class="education">
                            <h3><img src="../image/etude.png" alt=""> FORMATION</h3>
                            <ul>
                                <?php if (empty($formationUsers)): ?>
                                    <h4>Aucune donnée trouvée</h4>
                                <?php else: ?>
                                    <?php
                                    shuffle($formationUsers);
                                    $nombre_formation = 3;
                                    ?>
                                    <?php foreach ($formationUsers as $key => $formation): ?>
                                        <?php if ($key < $nombre_formation): ?>
                                            <li>
                                                <span class="date"><?= $formation['moisDebut'] ?> /
                                                    <?= $formation['anneeDebut'] ?> , <?= $formation['moisFin'] ?> /
                                                    <?= $formation['anneeFin'] ?></span>
                                                <span><?= $formation['Filiere'] ?></span>
                                                <span><?= $formation['etablissement'] ?></span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </section>
                        <section class="skills">
                            <h3><img src="../image/compétences.png" alt=""> COMPÉTENCES</h3>
                            <div class="skills-columns">
                                <div>
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
                        </section>
                    </div>
                    <div class="right-column">
                        <section class="experience">
                            <h3><img src="../image/experience.png" alt=""> EXPÉRIENCE</h3>
                            <ul>
                                <?php if (empty($afficheMetier)): ?>
                                    <h4>Aucune donnée trouvée</h4>
                                <?php else: ?>
                                    <?php
                                    shuffle($afficheMetier);
                                    $nombre_metier = 3
                                        ?>
                                    <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                        <?php if ($key < $nombre_metier): ?>
                                            <li>
                                                <span class="date1"><?= $Metiers['moisDebut'] ?> /
                                                    <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                                    <?= $Metiers['anneeFin'] ?></span>
                                                <span><?= $Metiers['metier'] ?></span>
                                                <p><?= $Metiers['description'] ?></p>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </ul>
                        </section>

                        <section class="outils">
                            <h3><img src="../image/outil.png" alt=""> OUTILS</h3>
                            <div class="outils-columns">
                                <div>
                                    <ul>
                                        <?php if ($afficheOutil): ?>
                                            <?php foreach ($afficheOutil as $outils): ?>
                                                <li> <?= $outils['outil'] ?></li>
                                            <?php endforeach; ?>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="box-float"></div>
            <div class="header">
                <h1><?= $userss['nom'] ?></h1>
                <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                <h2><?= $userss['competences'] ?></h2>
            </div>
            <div class="content">
                <div class="left-column">
                    <section class="about">
                        <h3><img src="../image/a propos.png" alt=""> À PROPOS DE MOI</h3>
                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                        <ul class="contact-info">
                            <li><img src="../image/phone.png" alt="phone"> <?= $userss['phone'] ?></li>
                            <li> <img src="../image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></li>
                            <li> <img src="../image/address.png" alt=""> <?= $userss['ville'] ?></li>
                            <li><img src="../image/nationaliet.png" alt="">*********</li>
                        </ul>
                    </section>
                    <section class="education">
                        <h3><img src="../image/etude.png" alt=""> FORMATION</h3>
                        <ul>
                            <?php if (empty($formationUsers)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($formationUsers);
                                $nombre_formation = 3;
                                ?>
                                <?php foreach ($formationUsers as $key => $formation): ?>
                                    <?php if ($key < $nombre_formation): ?>
                                        <li>
                                            <span class="date"><?= $formation['moisDebut'] ?> /
                                                <?= $formation['anneeDebut'] ?> , <?= $formation['moisFin'] ?> /
                                                <?= $formation['anneeFin'] ?></span>
                                            <span><?= $formation['Filiere'] ?></span>
                                            <span><?= $formation['etablissement'] ?></span>
                                            <strong><?= $formation['niveau'] ?></strong>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </section>
                    <section class="skills">
                        <h3><img src="../image/compétences.png" alt=""> COMPÉTENCES</h3>
                        <div class="skills-columns">
                            <div>
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
                    </section>
                </div>
                <div class="right-column">
                    <section class="experience">
                        <h3><img src="../image/experience.png" alt=""> EXPÉRIENCE</h3>
                        <ul>
                            <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 3
                                    ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <li>
                                            <span class="date1"><?= $Metiers['moisDebut'] ?> /
                                                <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                                <?= $Metiers['anneeFin'] ?></span>
                                            <span><?= $Metiers['metier'] ?></span>
                                            <p><?= $Metiers['description'] ?></p>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </section>

                    <section class="outils">
                        <h3><img src="../image/outil.png" alt=""> OUTILS</h3>
                        <div class="outils-columns">
                            <div>
                                <ul>
                                    <?php if ($afficheOutil): ?>
                                        <?php foreach ($afficheOutil as $outils): ?>
                                            <li> <?= $outils['outil'] ?></li>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </section>

    <script>
        // Importez la bibliothèque jsPDF
        function generatePDF() {
            const element = document.querySelector("#model7");
            // Hypothétiquement, si resolution et imageMode étaient des options valides
            // vous pourriez les fusionner avec les options existantes de cette manière :
            const mergedOptions = {
                filename: 'cv.pdf',
                image: { type: 'jpeg', quality: 0.98 }, // Qualité JPEG de l'image
                html2canvas: { scale: 2 }, // Échelle de rendu HTML2Canvas
            };

            // Utiliser les options fusionnées pour la conversion HTML vers PDF
            html2pdf().set(mergedOptions).from(element).save("cv.pdf");
        }



        const color_de_fond7 = document.getElementById('fontColor2');
        const color_de_fond_7 = localStorage.getItem('color_de_fond_7');

        document.documentElement.style.setProperty('--font-color7', color_de_fond_7 || '#c0faf9');
        color_de_fond7.value = color_de_fond_7 || '#c0faf9'; // Mettre à jour la valeur du champ input

        color_de_fond7.addEventListener('input', function () {
            const select_font_color7 = color_de_fond7.value;
            document.documentElement.style.setProperty('--font-color7', select_font_color7);
            localStorage.setItem('color_de_fond_7', select_font_color7);
        });



        const texte_inpute3 = document.getElementById('fontColor3');
        const texte_color7 = localStorage.getItem('texte_color7');

        document.documentElement.style.setProperty('--text-color7', texte_color7 || '#000000');
        texte_inpute3.value = texte_color7 || '#000000'; // Mettre à jour la valeur du champ input

        texte_inpute3.addEventListener('input', function () {
            const selecte_texte_color7 = texte_inpute3.value;
            document.documentElement.style.setProperty('--text-color7', selecte_texte_color7);
            localStorage.setItem('texte_color7', selecte_texte_color7);
        });

    </script>

</body>

</html>