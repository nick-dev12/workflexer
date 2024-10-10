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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>model4</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/model4.css">
</head>

<body>


    <?php include('../navbare.php') ?>




    <div class="section3">


        <div class="personnalisation">
            <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>
            <script>
                // Importez la bibliothèque jsPDF
                function generatePDF() {
                    const element = document.querySelector("#containe");

                    // Hypothétiquement, si resolution et imageMode étaient des options valides
                    // vous pourriez les fusionner avec les options existantes de cette manière :
                    const mergedOptions = {
                        filename: 'cv.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        }, // Qualité JPEG de l'image
                        html2canvas: {
                            scale: 2
                        }, // Échelle de rendu HTML2Canvas
                    };

                    // Utiliser les options fusionnées pour la conversion HTML vers PDF
                    html2pdf().set(mergedOptions).from(element).save("cv.pdf");
                }
            </script>


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
                const font_color_section4 = localStorage.getItem('font_color_section4');

                document.documentElement.style.setProperty('--font-color_section', font_color_section4 || '#e6e6e6');
                colorInput1.value = font_color_section4 || '#e6e6e6'; // Mettre à jour la valeur du champ input

                colorInput1.addEventListener('input', function () {
                    const selectedColor = colorInput1.value;
                    document.documentElement.style.setProperty('--font-color_section', selectedColor);
                    localStorage.setItem('font_color_section4', selectedColor);
                });


                const colorInput2 = document.getElementById('fontColor3');
                const texte_color_section4 = localStorage.getItem('texte_color_section4');

                document.documentElement.style.setProperty('--texte-color_section', texte_color_section4 || '#000000');
                colorInput2.value = texte_color_section4 || '#000000'; // Mettre à jour la valeur du champ input

                colorInput2.addEventListener('input', function () {
                    const selectedColor = colorInput2.value;
                    document.documentElement.style.setProperty('--texte-color_section', selectedColor);
                    localStorage.setItem('texte_color_section4', selectedColor);
                });
            </script>
        </div>


        <div class="containers">
            <div class="decor"></div>

            <div class="box1">
                <div class="item1">
                    <img src="../upload/<?= $userss['images'] ?>" alt="">
                    <div>
                        <h1> <?= $userss['nom'] ?></h1>
                        <h2> <?= $userss['competences'] ?></h2>
                    </div>
                </div>

                <div class="item2">
                    <?php if (empty($descriptions)): ?>
                        <p class="a_propos">Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p class="a_propos">
                            <?= $descriptions['description'] ?>
                        </p>
                    <?php endif; ?>

                    <div>
                        <h2>Contacts</h2>
                        <p> <img src="/image/address.png" alt=""> <?= $userss['ville'] ?></p>
                        <p><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></p>
                        <p><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></p>
                    </div>
                </div>


                <div class="div item3">
                    <div>
                        <h2>Langues</h2>
                        <?php if (empty($afficheLangue)): ?>
                            <ul>
                                <li>Aucune donnée trouvée</li>
                            </ul>
                        <?php else: ?>

                            <ul>
                                <?php foreach ($afficheLangue as $langues): ?>
                                    <li>
                                        <?php echo $langues['langue']; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        <?php endif; ?>
                    </div>

                    <div>
                        <h2>Centres d'intérêts</h2>
                        <?php if (empty($afficheCentreInteret)): ?>
                            <ul>
                                <li>Aucune donnée trouvée</li>
                            </ul>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($afficheCentreInteret as $interet): ?>
                                    <li>
                                        <?= $interet['interet'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        <?php endif; ?>
                    </div>

                </div>
            </div>



            <div class="box2">
                <div class="item1">

                    <div class="exp">
                        <h2>Expériences Professionnelles <img src="/image/experience.png" alt=""></h2>

                        <?php if (empty($afficheMetier)): ?>
                            <h3>Aucune donnée trouvée</h3>
                        <?php else: ?>
                            <?php
                            shuffle($afficheMetier);
                            $nombre_metier = 2
                                ?>
                            <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                <?php if ($key < $nombre_metier): ?>
                                    <div class="box">

                                        <div>
                                            <span> <?= $Metiers['moisDebut'] ?> /<?= $Metiers['anneeDebut'] ?> au
                                                <?= $Metiers['moisFin'] ?> /<?= $Metiers['anneeFin'] ?> </span>
                                            <h3> <?= $Metiers['metier'] ?></h3>
                                        </div>
                                        <p class="desc">
                                            <?= $Metiers['description'] ?>
                                        </p>


                                    </div>

                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>


                    <div class="educ">
                        <h2>Éducation <img src="/image/etude.png" alt=""></h2>
                        <div class="box">
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
                                            <span> <?= $formations['moisDebut'] ?> /<?= $formations['anneeDebut'] ?> au
                                                <?= $formations['moisFin'] ?> /<?= $formations['anneeFin'] ?> </span>
                                            <h3> <?= $formations['etablissement'] ?></h3>
                                            <p> <?= $formations['Filiere'] ?> , <strong> <?= $formations['niveau'] ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>


                        </div>
                    </div>

                    <!-- <div class="logiciel">
                   <div>
                    <h2>Outils</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                   <div id="compe">
                    <h2>Compétences</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                </div> -->

                </div>

                <div class="item2">
                    <div class="logiciel">
                        <div>
                            <h2>Outils <img src="/image/outil.png" alt=""></h2>
                            <ul>
                                <?php if ($afficheOutil): ?>
                                    <?php foreach ($afficheOutil as $outils): ?>
                                        <li> <?= $outils['outil'] ?></li>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </ul>
                        </div>
                        <div id="compe">
                            <h2>Compétences <img src="/image/compétences.png" alt=""></h2>
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
                </div>
            </div>
        </div>

        <div class="cv">
            <div class="containers" id="containe">
                <div class="decor"></div>

                <div class="box1">
                    <div class="item1">
                        <img src="../upload/<?= $userss['images'] ?>" alt="">
                        <div>
                            <h1> <?= $userss['nom'] ?></h1>
                            <h2> <?= $userss['competences'] ?></h2>
                        </div>
                    </div>

                    <div class="item2">
                        <?php if (empty($descriptions)): ?>
                            <p class="a_propos">Aucune donnée trouvée</p>
                        <?php else: ?>
                            <p class="a_propos">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>

                        <div>
                            <h2>Contacts</h2>
                            <p> <img src="/image/address.png" alt=""> <?= $userss['ville'] ?></p>
                            <p><img src="/image/phone.png" alt=""> <?= $userss['phone'] ?></p>
                            <p><img src="/image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></p>
                        </div>
                    </div>


                    <div class="div item3">
                        <div>
                            <h2>Langues</h2>
                            <?php if (empty($afficheLangue)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>

                                <ul>
                                    <?php foreach ($afficheLangue as $langues): ?>
                                        <li>
                                            <?php echo $langues['langue']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            <?php endif; ?>
                        </div>

                        <div>
                            <h2>Centres d'intérêts</h2>
                            <?php if (empty($afficheCentreInteret)): ?>
                                <ul>
                                    <li>Aucune donnée trouvée</li>
                                </ul>
                            <?php else: ?>
                                <ul>
                                    <?php foreach ($afficheCentreInteret as $interet): ?>
                                        <li>
                                            <?= $interet['interet'] ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            <?php endif; ?>
                        </div>

                    </div>
                </div>



                <div class="box2">
                    <div class="item1">

                        <div class="exp">
                            <h2>Expériences Professionnelles <img src="/image/experience.png" alt=""></h2>

                            <?php if (empty($afficheMetier)): ?>
                                <h3>Aucune donnée trouvée</h3>
                            <?php else: ?>
                                <?php
                                shuffle($afficheMetier);
                                $nombre_metier = 2
                                    ?>
                                <?php foreach ($afficheMetier as $key => $Metiers): ?>
                                    <?php if ($key < $nombre_metier): ?>
                                        <div class="box">

                                            <div>
                                                <span> <?= $Metiers['moisDebut'] ?> /<?= $Metiers['anneeDebut'] ?> au
                                                    <?= $Metiers['moisFin'] ?> /<?= $Metiers['anneeFin'] ?> </span>
                                                <h3> <?= $Metiers['metier'] ?></h3>
                                            </div>
                                            <p class="desc">
                                                <?= $Metiers['description'] ?>
                                            </p>


                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>


                        <div class="educ">
                            <h2>Éducation <img src="/image/etude.png" alt=""></h2>
                            <div class="box">
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
                                                <span> <?= $formations['moisDebut'] ?> /<?= $formations['anneeDebut'] ?> au
                                                    <?= $formations['moisFin'] ?> /<?= $formations['anneeFin'] ?> </span>
                                                <h3> <?= $formations['etablissement'] ?></h3>
                                                <p> <?= $formations['Filiere'] ?> , <strong> <?= $formations['niveau'] ?></strong>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>


                            </div>
                        </div>

                        <!-- <div class="logiciel">
                   <div>
                    <h2>Outils</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                   <div id="compe">
                    <h2>Compétences</h2>
                    <ul>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                        <li>je savais ce que je voulais</li>
                    </ul>
                   </div>
                </div> -->

                    </div>

                    <div class="item2">
                        <div class="logiciel">
                            <div>
                                <h2>Outils <img src="/image/outil.png" alt=""></h2>
                                <ul>
                                    <?php if ($afficheOutil): ?>
                                        <?php foreach ($afficheOutil as $outils): ?>
                                            <li> <?= $outils['outil'] ?></li>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <div id="compe">
                                <h2>Compétences <img src="/image/compétences.png" alt=""></h2>
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
                    </div>
                </div>
            </div>


            <script>
                // scripts.js
                const colorPickers = document.querySelectorAll('.color-picker input');

                colorPickers.forEach(picker => {
                    picker.addEventListener('input', (e) => {
                        const propertyName = `--${e.target.id}`;
                        document.documentElement.style.setProperty(propertyName, e.target.value);
                    });
                });
            </script>
</body>

</html>