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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>model5</title>

    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/model5.css" />
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
                    const element = document.querySelector("#cv-content");

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
                <p>Couleur de de fond </p>
                <input type="color" name="" id="fontColor_m52">
            </div>

            <div class="box">
                <p>Couleur du texte 1</p>
                <input type="color" name="" id="fontColor_m53">
            </div>

            <div class="box">
                <p>Couleur du texte 2</p>
                <input type="color" name="" id="fontColor_m54">
            </div>

            <script>

                const colorInput_m5 = document.getElementById('fontColor_m52');
                const font_color_section_m5 = localStorage.getItem('font_color_section_m5');

                document.documentElement.style.setProperty('--font-color-m5', font_color_section_m5 || '#ebebeb');
                colorInput_m5.value = font_color_section_m5 || '#ebebeb'; // Mettre à jour la valeur du champ input

                colorInput_m5.addEventListener('input', function () {
                    const selectedColor = colorInput_m5.value;
                    document.documentElement.style.setProperty('--font-color-m5', selectedColor);
                    localStorage.setItem('font_color_section_m5', selectedColor);
                });


                const colorInput2 = document.getElementById('fontColor_m53');
                const texte_color_m5 = localStorage.getItem('texte_color_m5');

                document.documentElement.style.setProperty('--text-color-m5', texte_color_m5 || '#000000');
                colorInput2.value = texte_color_m5 || '#000000'; // Mettre à jour la valeur du champ input

                colorInput2.addEventListener('input', function () {
                    const selectedColor = colorInput2.value;
                    document.documentElement.style.setProperty('--text-color-m5', selectedColor);
                    localStorage.setItem('texte_color_m5', selectedColor);
                });


                const colorInput4 = document.getElementById('fontColor_m54');
                const texte_color2_m5 = localStorage.getItem('texte_color2_m5');

                document.documentElement.style.setProperty('--text-color2-m5', texte_color2_m5 || '#0089be');
                colorInput4.value = texte_color2_m5 || '#0089be'; // Mettre à jour la valeur du champ input

                colorInput4.addEventListener('input', function () {
                    const selectedColor = colorInput4.value;
                    document.documentElement.style.setProperty('--text-color2-m5', selectedColor);
                    localStorage.setItem('texte_color2_m5', selectedColor);
                });


            </script>
        </div>

        <div class="container">
            <div class="box1">
                <div class="item1">
                    <ul>
                        <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                        <li><img src="/image/phone.png" alt=""><?= $userss['phone'] ?></li>
                        <li><img src="/image/icons8-gmail-48.png" alt=""><?= $userss['mail'] ?></li>
                    </ul>

                    <h3><?= $userss['competences'] ?></h3>
                    <h1> <?= $userss['nom'] ?></h1>
                </div>
                <div class="item2">
                    <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                </div>
            </div>

            <div class="box2">
                <div class="item1">
                    <div class="box">
                        <h2> <img src="/image/a_propos.png" alt=""> À propos</h2>
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
                                        <h3> <?= $Metiers['metier'] ?></h3>
                                        <span><?= $Metiers['moisDebut'] ?> /
                                            <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                            <?= $Metiers['anneeFin'] ?></span>
                                        <p> <?= $Metiers['description'] ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="item2">

                    <div class="exp">
                        <h2><img src="/image/etude.png" alt=""> Éducation</h2>

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
            </div>
        </div>

        <div class="model5">
            <div id="cv-content">
                <div class="box1">
                    <div class="item1">
                        <ul>
                            <li><img src="/image/address.png" alt=""> <?= $userss['ville'] ?></li>
                            <li><img src="/image/phone.png" alt=""><?= $userss['phone'] ?></li>
                            <li><img src="/image/icons8-gmail-48.png" alt=""><?= $userss['mail'] ?></li>
                        </ul>

                        <h3><?= $userss['competences'] ?></h3>
                        <h1> <?= $userss['nom'] ?></h1>
                    </div>
                    <div class="item2">
                        <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
                    </div>
                </div>

                <div class="box2">
                    <div class="item1">
                        <div class="box">
                            <h2> <img src="/image/a_propos.png" alt=""> À propos</h2>
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
                                            <h3> <?= $Metiers['metier'] ?></h3>
                                            <span><?= $Metiers['moisDebut'] ?> /
                                                <?= $Metiers['anneeDebut'] ?> , <?= $Metiers['moisFin'] ?> /
                                                <?= $Metiers['anneeFin'] ?></span>
                                            <p> <?= $Metiers['description'] ?></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item2">

                        <div class="exp">
                            <h2><img src="/image/etude.png" alt=""> Éducation</h2>

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
                </div>
            </div>
        </div>
    </section>
</body>

</html>