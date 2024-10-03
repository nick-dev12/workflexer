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
    <title>model6</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/model6.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <?php include('../navbare.php') ?>

    <?php include('../include/header_users.php') ?>

    <section class="section3">

        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <script>
                // Importez la bibliothèque jsPDF
                function generatePDF() {
                    const element = document.querySelector("#model6");
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
            </script>
            <div class="box">
                <p>Couleur des dates </p>
                <input type="color" name="" id="fontColor1">
            </div>

            <div class="box">
                <p>Couleur de fond</p>
                <input type="color" name="" id="fontColor2">
            </div>

            <div class="box">
                <p>Couleur du texte</p>
                <input type="color" name="" id="fontColor3">
            </div>

            <script>
                const color_date = document.getElementById('fontColor1');
                // Récupérer la valeur sauvegardée dans le stockage local (si elle existe)
                const saved_color_date6 = localStorage.getItem('color_date6');
                // Appliquer la couleur sauvegardée ou une valeur par défaut si aucune couleur n'a été sauvegardée
                document.documentElement.style.setProperty('--date-color6', saved_color_date6 || '#019fcf');
                color_date.value = saved_color_date6 || '#019fcf'; // Mettre à jour la valeur du champ input
                // Écouter les changements sur le champ input
                color_date.addEventListener('input', function () {
                    // Mettre à jour la valeur de la variable CSS en fonction de la couleur choisie par l'utilisateur
                    const select_color_date = color_date.value;
                    document.documentElement.style.setProperty('--date-color6', select_color_date);

                    // Sauvegarder la couleur sélectionnée dans le stockage local
                    localStorage.setItem('color_date6', select_color_date);
                });



                const color_de_fond6 = document.getElementById('fontColor2');
                const color_de_fond_6 = localStorage.getItem('color_de_fond_6');

                document.documentElement.style.setProperty('--font-color6', color_de_fond_6 || '#e3e3e3');
                color_de_fond6.value = color_de_fond_6 || '#e3e3e3'; // Mettre à jour la valeur du champ input

                color_de_fond6.addEventListener('input', function () {
                    const select_font_color6 = color_de_fond6.value;
                    document.documentElement.style.setProperty('--font-color6', select_font_color6);
                    localStorage.setItem('color_de_fond_6', select_font_color6);
                });



                const texte_inpute3 = document.getElementById('fontColor3');
                const texte_color6 = localStorage.getItem('texte_color6');

                document.documentElement.style.setProperty('--text-color6', texte_color6 || '#000000');
                texte_inpute3.value = texte_color6 || '#000000'; // Mettre à jour la valeur du champ input

                texte_inpute3.addEventListener('input', function () {
                    const selecte_texte_color6 = texte_inpute3.value;
                    document.documentElement.style.setProperty('--text-color6', selecte_texte_color6);
                    localStorage.setItem('texte_color6', selecte_texte_color6);
                });

            </script>
        </div>

        <div class="model6">
            <div id="model6">
                <div class="box1">
                    <div class="item1">
                        <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    </div>

                    <div class="item2">
                        <h1><?= $userss['nom'] ?></h1>
                        <h2><?= $userss['competences'] ?></h2>
                        <div>
                            <ul>
                                <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                                <li><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></li>
                                <li><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></li>
                            </ul>

                            <?php if (empty($afficheLangue)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>

                                <ul id="langue">
                                    <?php foreach ($afficheLangue as $langues): ?>
                                        <li>
                                            <?php echo $langues['langue']; ?> <span><?= $langues['niveau']; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <div class="box2">

                </div>
                <div class="box3">
                    <div class="item1">
                        <div class="edu">
                            <h2> <img src="/image/etude.png" alt=""> Éducation</h2>
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
                                            <h3><?= $formations['etablissement'] ?></h3>
                                            <span> <?= $formations['moisDebut'] ?> /
                                                <?= $formations['anneeDebut'] ?> , <?= $formations['moisFin'] ?> /
                                                <?= $formations['anneeFin'] ?></span>
                                            <p><?= $formations['Filiere'] ?> , <strong>
                                                    <?= $formations['niveau'] ?></strong> </p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="comp">
                            <h2><img src="/image/compétences.png" alt=""> Compétences</h2>
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

                        <div class="outils">
                            <h2><img src="/image/outil.png" alt=""> Outils</h2>
                            <ul>
                                <?php if ($afficheOutil): ?>
                                    <?php foreach ($afficheOutil as $outils): ?>
                                        <li> <?= $outils['outil'] ?></li>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>

                    <div class="item2">
                        <div class="moi">
                            <h2><img src="/image/a propos.png" alt=""> À propos</h2>
                            <?php if (empty($descriptions)): ?>
                                <p>Aucune donnée trouvée</p>
                            <?php else: ?>
                                <p class="p">
                                    <?= $descriptions['description'] ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="exp">
                            <h2><img src="/image/experience.png" alt=""> Expériences</h2>
                            <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 3
                                    ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <div>
                                            <span><?= $Metiers['moisDebut'] ?> /
                                                <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                                <?= $Metiers['anneeFin'] ?></span>
                                            <h3><?= $Metiers['metier'] ?></h3>
                                            <p><?= $Metiers['description'] ?></p>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="box1">
                <div class="item1">
                    <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                </div>

                <div class="item2">
                    <h1><?= $userss['nom'] ?></h1>
                    <h2><?= $userss['competences'] ?></h2>
                    <div>
                        <ul>
                            <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                            <li><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></li>
                            <li><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></li>
                        </ul>

                        <?php if (empty($afficheLangue)): ?>
                            <ul>
                                <li>Aucune donnée trouvée</li>
                            </ul>
                        <?php else: ?>
                            <ul id="langue">
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <li>
                                        <?php echo $langues['langue']; ?> <span><?= $langues['niveau']; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="box2">

            </div>
            <div class="box3">
                <div class="item1">
                    <div class="edu">
                        <h2> <img src="/image/etude.png" alt=""> Éducation</h2>
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
                                        <h3><?= $formations['etablissement'] ?></h3>
                                        <span> <?= $formations['moisDebut'] ?> /
                                            <?= $formations['anneeDebut'] ?> , <?= $formations['moisFin'] ?> /
                                            <?= $formations['anneeFin'] ?></span>
                                        <p><?= $formations['Filiere'] ?> , <strong>
                                                <?= $formations['niveau'] ?></strong> </p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="comp">
                        <h2><img src="/image/compétences.png" alt=""> Compétences</h2>
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

                    <div class="outils">
                        <h2><img src="/image/outil.png" alt=""> Outils</h2>
                        <ul>
                            <?php if ($afficheOutil): ?>
                                <?php foreach ($afficheOutil as $outils): ?>
                                    <li> <?= $outils['outil'] ?></li>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>

                <div class="item2">
                    <div class="moi">
                        <h2><img src="/image/a propos.png" alt=""> À propos</h2>
                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="exp">
                        <h2><img src="/image/experience.png" alt=""> Expériences</h2>
                        <?php if (empty($afficheMetier)): ?>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            shuffle($afficheMetier);
                            $nombre_metier = 3
                                ?>
                            <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                <?php if ($key < $nombre_metier): ?>
                                    <div>
                                        <span><?= $Metiers['moisDebut'] ?> /
                                            <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                            <?= $Metiers['anneeFin'] ?></span>
                                        <h3><?= $Metiers['metier'] ?></h3>
                                        <p><?= $Metiers['description'] ?></p>
                                    </div>

                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>


                </div>

            </div>
        </div>
    </section>
</body>

</html>