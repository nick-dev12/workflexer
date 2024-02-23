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
    <title>Document</title>
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">

    <script src="../script/jquery-3.6.0.min.js"></script>

    <script src="../script/summernote@0.8.18.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">

    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/model1.css">
</head>

<body>

    <?php include('../navbare.php') ?>

    <?php include('../include/header_users.php') ?>






    <section class="section3">
        <div class="container_box2">
            <div class="box1">
                <h1>Mon Cv</h1>
            </div>
            <div class="box2">

                <div class="parte1">
                    <div class="pte1">
                        <img class="affiche" src="../upload/<?= $userss['images'] ?>" alt="">
                    </div>
                    <div class="pte2">
                        <h2>
                            <?= $userss['nom'] ?>
                        </h2>
                        <h4>
                            <?= $userss['competences'] ?>
                        </h4>
                        <div>
                            <table>
                                <tr>
                                    <td class="inc"><img src="../image/icons8-gmail-48.png" alt=""></td>
                                    <td>
                                        <?= $userss['mail'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="inc"><img src="../image/phone.png" alt=""></td>
                                    <td>
                                        <?= $userss['phone'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="inc"><img src="../image/villeic.png" alt=""></td>
                                    <td>
                                        <?= $userss['ville'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="inc"><img src="../image/nationaliet.png" alt=""></td>
                                    <td>Gabonnais</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="pte3">
                        <h2><img src="../image/langue.png" alt=""> Langues </h2>
                        <div>
                            <table>
                                <?php if (empty($afficheLangue)): ?>
                                    <p>Aucune donnée trouver</p>
                                <?php else: ?>
                                    <?php foreach ($afficheLangue as $langues): ?>
                                        <tr>
                                            <td class="lan">
                                                <?php echo $langues['langue']; ?>
                                            </td>
                                            <td class="niv">
                                                <?php echo $langues['niveau']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>


                    <div class="pte3">
                        <h2><img src="../image/diplome.png" alt=""> Diplômes </h2>
                        <div>
                            <?php if (empty($afficheDiplome)): ?>
                                <p>Aucune donnée trouvée!</p>
                            <?php else: ?>
                                <?php foreach ($afficheDiplome as $diplomes): ?>
                                    <p>
                                        <?= $diplomes['diplome'] ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="pte3">
                        <h2><img src="../image/diplome.png" alt=""> Certificates </h2>
                        <div>
                            <?php if (empty($afficheCertificat)): ?>
                                <p>Aucune donnée trouvée!</p>
                            <?php else: ?>
                                <?php foreach ($afficheCertificat as $certificat): ?>
                                    <p>
                                        <?= $certificat['certificat'] ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pte3">
                        <h2><img src="../image/loisir.png" alt=""> Centre d'interet </h2>
                        <div>
                            <?php if (empty($afficheCentreInteret)): ?>
                                <p>Aucune donnée trouver</p>
                            <?php else: ?>
                                <?php foreach ($afficheCentreInteret as $interet): ?>
                                    <p>
                                        <?= $interet['interet'] ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pte3">
                        <h2><img src="../image/social.png" alt=""> Reseaux social </h2>
                        <div class="reseaux">
                            <img src="../image/facebook.png" alt="">
                            <img src="../image/linkedin.png" alt="">
                            <img src="../image/tweeter.png" alt="">
                            <img src="../image/whatsapp.png" alt="">
                        </div>
                    </div>
                </div>




                <div class="parte2">
                    <div class="pat1">
                        <h1>A propos de moi !</h1>
                    </div>

                    <div class="pat2">
                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouver</p>
                        <?php else: ?>
                            <p>
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                    </div>


                    <div class="exp">
                        <div class="til1">
                            <h1>Expérience professionnelle</h1>
                        </div>
                        <div class="mes_exp">
                            <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php foreach ($afficheMetier as $Metiers): ?>
                                    <div class="exp1"></div>
                                    <div class="exp2">
                                        <em>
                                            <?= $Metiers['moisDebut'] ?> /
                                            <?= $Metiers['anneeDebut'] ?>
                                        </em>
                                        <em>
                                            <?= $Metiers['moisFin'] ?> /
                                            <?= $Metiers['anneeFin'] ?>
                                        </em>
                                    </div>
                                    <div class="exp3">
                                        <h2>
                                            <?= $Metiers['metier'] ?>
                                        </h2>
                                        <p>
                                            <?= $Metiers['description'] ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>




                    <div class="exp">
                        <div class="til1">
                            <h1>Formation et parcour</h1>
                        </div>
                        <div class="mes_exp">
                            <?php if (empty($formationUsers)): ?>
                                <h4>Aucune donnée trouver</h4>
                            <?php else: ?>
                                <?php foreach ($formationUsers as $formations): ?>
                                    <div class="exp1"></div>
                                    <div class="exp2">
                                        <em>
                                            <?= $formations['moisDebut'] ?> /
                                            <?= $formations['anneeDebut'] ?>
                                        </em>
                                        <em>
                                            <?= $formations['moisFin'] ?> /
                                            <?= $formations['anneeFin'] ?>
                                        </em>
                                    </div>
                                    <div class="exp3">
                                        <h2>
                                            <?= $formations['etablissement'] ?>
                                        </h2>
                                        <h4>
                                            <?= $formations['niveau'] ?>
                                        </h4>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="outils">
                        <div class="out1">
                            <h1>Maîtrise des outils informatique</h1>
                        </div>
                        <div class="out2">
                            <?php if (empty($afficheOutil)): ?>
                                <p>Aucune donnee trouver</p>
                            <?php else: ?>

                                <table>
                                    <?php foreach ($afficheOutil as $outils): ?>
                                        <tr>
                                            <td>
                                                <?= $outils['outil'] ?>
                                            </td>
                                            <td><em>
                                                    <?= $outils['niveau'] ?>
                                                </em></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </table>
                            <?php endif; ?>
                        </div>
                    </div>



                    <div class="outils">
                        <div class="out1">
                            <h1>Competences</h1>
                        </div>
                        <div class="out22">
                        <?php foreach ($competencesUtilisateur as $competence): ?>
                            <p class="comp">
                                <?php echo $competence['competence']; ?>
                            </p>
                           
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        </div>

    </section>

</body>

</html>