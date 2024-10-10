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
    <title>model3</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/model3.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>


    <?php include('../navbare.php') ?>


    <section class="section3">


        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>


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
                const font_color_section2 = localStorage.getItem('font_color_section2');

                document.documentElement.style.setProperty('--font-color_section', font_color_section2 || '#e6e6e6');
                colorInput1.value = font_color_section2 || '#e6e6e6'; // Mettre à jour la valeur du champ input

                colorInput1.addEventListener('input', function () {
                    const selectedColor = colorInput1.value;
                    document.documentElement.style.setProperty('--font-color_section', selectedColor);
                    localStorage.setItem('font_color_section2', selectedColor);
                });



                const colorInput2 = document.getElementById('fontColor3');
                const texte_color_section2 = localStorage.getItem('texte_color_section2');

                document.documentElement.style.setProperty('--texte-color_section', texte_color_section2 || '#000000');
                colorInput2.value = texte_color_section2 || '#000000'; // Mettre à jour la valeur du champ input

                colorInput2.addEventListener('input', function () {
                    const selectedColor = colorInput2.value;
                    document.documentElement.style.setProperty('--texte-color_section', selectedColor);
                    localStorage.setItem('texte_color_section2', selectedColor);
                });


            </script>
        </div>


        <script>
            // Importez la bibliothèque jsPDF
            function generatePDF() {
                const element = document.getElementById("CV");

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

        <div id="containe1">
            <div class="containers">
                <div class="box1">
                    <div class="item">
                        <h1>
                            <?= $userss['nom'] ?>
                        </h1>
                        <img src="../upload/<?= $userss['images'] ?>" alt="">
                        <h2> <?= $userss['competences'] ?></h2>
                        <span>******</span>

                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="items">
                        <h1>Contact</h1>
                        <div>
                            <img src="/image/address.png" alt="">
                            <span>Adresse</span>
                            <p> <?= $userss['ville'] ?></p>
                        </div>

                        <div>
                            <img src="/image/phone.png" alt="">
                            <span>Téléphone</span>
                            <p><?= $userss['phone'] ?></p>
                        </div>

                        <div>
                            <img src="/image/icons8-gmail-48.png" alt="">
                            <span>E-mail</span>
                            <p><?= $userss['mail'] ?></p>
                        </div>
                    </div>

                    <div class="itemss">

                        <h1>Langues</h1>
                        <div>
                            <?php if ($afficheLangue): ?>
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <p> <?= $langues['langue'] ?> <span> (<?= $langues['niveau'] ?>)</span></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune donnée trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="box2">
                    <div class="decor1"></div>
                    <div class="decor2"></div>

                    <div class="item">
                        <h1><strong><img src="/image/experience.png" alt=""></strong>Expériences</h1>
                        <?php if (empty($afficheMetier)): ?>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            shuffle($afficheMetier);
                            $nombre_metier = 2
                                ?>
                            <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                <?php if ($key < $nombre_metier): ?>
                                    <div class="exp">
                                        <span class="part"></span>
                                        <div class="exper">
                                            <h3><?= $Metiers['metier'] ?> <em> <?= $Metiers['moisDebut'] ?> /
                                                    <?= $Metiers['anneeDebut'] ?> // <?= $Metiers['moisFin'] ?> /
                                                    <?= $Metiers['anneeFin'] ?></em> </h3>
                                            <span class="titre">Advantetch Group</span>
                                            <p> <?= $Metiers['description'] ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>


                    <div class="items">
                        <h1><strong><img src="/image/etude.png" alt=""></strong>Éducation</h1>

                        <div class="containe-exp">
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
                                        <div class="exp">
                                            <span class="part"></span>
                                            <div class="exper">
                                                <h3><?= $formations['etablissement'] ?> <em><?= $formations['moisDebut'] ?> /
                                                        <?= $formations['anneeDebut'] ?> // <?= $formations['moisFin'] ?> /
                                                        <?= $formations['anneeFin'] ?></em> </h3>
                                                <p><?= $formations['Filiere'] ?> <span class="titre"> <strong>
                                                            <?= $formations['niveau'] ?></strong></span> </p>

                                            </div>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="itemss">
                        <h1><strong><img src="/image/compétences.png" alt=""></strong>Compétences</h1>


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


                    <div class="itemsss">
                        <h1><strong><img src="/image/outil.png" alt=""></strong>Outils informatiques</h1>

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

        <div id="containe">
            <div class="containers " id="CV">
                <div class="box1">
                    <div class="item">
                        <h1>
                            <?= $userss['nom'] ?>
                        </h1>
                        <img src="../upload/<?= $userss['images'] ?>" alt="">
                        <h2> <?= $userss['competences'] ?></h2>
                        <span>******</span>

                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="items">
                        <h1>Contact</h1>
                        <div>
                            <img src="/image/address.png" alt="">
                            <span>Adresse</span>
                            <p> <?= $userss['ville'] ?></p>
                        </div>

                        <div>
                            <img src="/image/phone.png" alt="">
                            <span>Téléphone</span>
                            <p><?= $userss['phone'] ?></p>
                        </div>

                        <div>
                            <img src="/image/icons8-gmail-48.png" alt="">
                            <span>E-mail</span>
                            <?= $userss['mail'] ?>
                        </div>
                    </div>

                    <div class="itemss">

                        <h1>Langues</h1>
                        <div>
                            <?php if ($afficheLangue): ?>
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <p> <?= $langues['langue'] ?> <span> (<?= $langues['niveau'] ?>)</span></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucune donnée trouvée</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="box2">
                    <div class="decor1"></div>
                    <div class="decor2"></div>

                    <div class="item">
                        <h1><strong><img src="/image/experience.png" alt=""></strong>Expériences</h1>
                        <?php if (empty($afficheMetier)): ?>
                            <h4>Aucune donnée trouvée</h4>
                        <?php else: ?>
                            <?php
                            shuffle($afficheMetier);
                            $nombre_metier = 2
                                ?>
                            <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                <?php if ($key < $nombre_metier): ?>
                                    <div class="exp">
                                        <span class="part"></span>
                                        <div class="exper">
                                            <h3><?= $Metiers['metier'] ?> <em> <?= $Metiers['moisDebut'] ?> /
                                                    <?= $Metiers['anneeDebut'] ?> // <?= $Metiers['moisFin'] ?> /
                                                    <?= $Metiers['anneeFin'] ?></em> </h3>
                                            <span class="titre">Advantetch Group</span>
                                            <p> <?= $Metiers['description'] ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>


                    <div class="items">
                        <h1><strong><img src="/image/etude.png" alt=""></strong>Éducation</h1>

                        <div class="containe-exp">
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
                                        <div class="exp">
                                            <span class="part"></span>
                                            <div class="exper">
                                                <h3><?= $formations['etablissement'] ?> <em><?= $formations['moisDebut'] ?> /
                                                        <?= $formations['anneeDebut'] ?> // <?= $formations['moisFin'] ?> /
                                                        <?= $formations['anneeFin'] ?></em> </h3>
                                                <span class="titre"> <?= $formations['Filiere'] ?> <strong>
                                                        <?= $formations['niveau'] ?></strong></span>

                                            </div>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="itemss">
                        <h1><strong><img src="/image/compétences.png" alt=""></strong>Compétences</h1>


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


                    <div class="itemsss">
                        <h1><strong><img src="/image/outil.png" alt=""></strong>Outils informatiques</h1>

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
    </section>
</body>

</html>