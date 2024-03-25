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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Nunito", sans-serif;
  width: 793px;
  height: 1122px;
  border: 1.5px solid #a3a3a3;
  margin: 0 auto;
  position: relative;
  margin-bottom: 40px;
  background-color: #ffffff;
}

.section2 .box3 table .tr4 {
  background-color: #636262;
}
.section2 .box3 table .tr4 td a {
  color: #ffffff;
}

header {
  background-color: #d7d7d7;
  padding: 40px;
  text-align: center;
}
header h1 {
  width: 70%;
  margin-left: 200px;
  font-size: 25px;
  padding: 0 20px;
}
header h2 {
  width: 70%;
  margin-left: 200px;
  font-size: 20px;
  color: #346dc8;
}



.section3 .button12 {
  padding: 10px;
  background-color: #346dc8;
  color: #ffffff;
  font-size: 15px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: all 0.4s;
}
.section3 button:hover {
  background-color: #303030;
}

#container .img {
  position: absolute;
  width: 170px;
  height: 150px;
  object-fit: cover;
  top: 40px;
  object-fit: cover;
  left: 40px;
  border: 1.5px solid #ddd;
  border-radius: 7px;
  padding: 0%;
}

#container .container-box {
  display: flex;
}

#container .box1 {
  width: 270px;
  height: 880px;
  position: relative;
  border-right: 3px solid #000000;
  margin-top: 20px;
  padding-top: 40px;
}
#container .box1 h1 {
  width: 80%;
  text-align: center;
  padding: 3px 20px;
  background-color: #000000;
  color: #ddd;
  margin: 10px auto;
  font-size: 12px;
  display: flex;
  align-items: center;
  border-radius: 4px;
  text-transform: uppercase;
}
#container .box1 h1 img {
  height: 20px;
  width: 20px;
  margin-right: 15px;
}
#container .box1 .bb {
  display: flex;
  align-items: center;
  width: 80%;
  margin: 15px auto;
}
#container .box1 .bb img {
  height: 25px;
  width: 25px;
  margin-right: 20px;
  object-fit: cover;
}
#container .box1 .bb p {
  display: flex;
  flex-direction: column;
  font-size: 12px;
  position: relative;
  width: 100%;
  align-items: start;
}

#container .box1 ul {
  width: 80%;
  margin: 0 auto;
}
#container .box1 ul li {
  font-size: 12px;
  list-style-type: square;
  width: 100%;
  margin: 2px auto;
  margin-left: 10px;
}
#container .box1 .reseaux {
  display: flex;
  align-items: center;
  width: 80%;
  justify-content: space-around;
  margin: 5px auto;
}
#container .box1 .resaux img {
  height: 30px;
  width: 30px;
}

#container .box2 {
  width: 600px;
  height: 950px;
  position: relative;
  padding-top: 10px;
  padding-bottom: 10px;
}

#container .box2 h1 {
  font-size: 14px;
  width: 80%;
  margin: 7px auto;
  background-color: #000000;
  color: #ddd;
  padding: 4px 20px;
  border-radius: 4px;
  text-transform: uppercase;
}
#container .box2 p {
  font-size: 13px;
  width: 85%;
  margin: 10px auto;
}

#container .box2 .experiences .div {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  margin: 5px auto;
  flex-direction: column;
}
#container .box2 .experiences .div1 {
  display: flex;
  align-items: center;
  margin: 3px;
  width: 80%;
}
#container .box2 .div .info {
  display: flex;
  align-items: start;
  flex-direction: column;
  width: 100%;
}
#container .box2 .div h4 {
  width: 100%;
  font-size: 13px;
  margin-top: 2px;
}
#container .box2 .div p {
  font-size: 12px;
  width: 100%;
  margin: 0;
}
#container .box2 .div span {
  font-size: 10px;
  color: #346dc8;
}
#container .box2 .div .strong {
  padding: 5px;
  background-color: #303030;
  border-radius: 50%;
  margin-right: 20px;
}

#container .box2 .experiences .outils {
  width: 80%;
  display: flex;
  align-items: center;
  margin: 0 auto;
  flex-wrap: wrap;
  justify-content: flex-start;
  margin-top: -3px;
}
#container .box2 .outils p {
  display: flex;
  align-items: center;
  width: auto;
  font-size: 15px;
  font-weight: 600;
  margin-top: 2px;
}
#container .box2 .outils span {
  padding: 3px;
  background-color: #000000;
  margin-right: 10px;
}
#container .box2 .div-comp {
  width: 80%;
  display: flex;
  align-items: center;
  margin: 0 auto;
  position: relative;
  flex-wrap: wrap;
}
#container .box2 .comp {
  padding: 3px 10px;
  font-size: 13px;
  border-radius: 5px;
  background-color: #e2e2e2;
  margin: 5px 10px;
}
    </style>
</head>
<body>

    <section class="section3">

        <img src="../image/fleche.png" alt="" class="img222">
        <script>
            let img222 = document.querySelector('.img222');
            let section2 = document.querySelector('.section2');
            let img111 = document.querySelector('.img111')
            img222.addEventListener('click', () => {
                section2.style.marginLeft = '0px';
                img222.style.display = 'none';
            });

            img111.addEventListener('click', () => {
                section2.style.marginLeft = '-150%';
                img222.style.display = 'block';
            });
        </script>

        <button class="button12" onclick="generatePDF()">Télécharger mon CV</button>



        <script>
            // Importez la bibliothèque jsPDF
            function generatePDF() {
                const element = document.getElementById("container");
                html2pdf().from(element).save("cv.pdf");
            }
        </script>


        <div id="container" class="container">
            <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
            <header>
                <h1>
                    <?= $userss['nom'] ?>
                </h1>
                <h2>
                    <?= $userss['competences'] ?>
                </h2>
            </header>

            <div class="container-box">

                <div class="box1">
                    <div>
                        <h1>Profil</h1>
                        <div class="bb">
                            <img src="/image/address.png" alt="">
                            <p>
                                <strong>
                                    ADDRESSE
                                </strong>
                                <span>
                                    <?= $userss['ville'] ?>
                                </span>
                            </p>
                        </div>

                        <div class="bb">
                            <img src="/image/icons8-gmail-48.png" alt="">
                            <p>
                                <strong>
                                    E-mail
                                </strong>
                                <span>
                                    <?= $userss['mail'] ?>
                                </span>
                            </p>
                        </div>

                        <div class="bb">
                            <img src="/image/phone.png" alt="">
                            <p>
                                <strong>
                                    TELEPHONE
                                </strong>
                                <span>
                                    <?= $userss['phone'] ?>
                                </span>
                            </p>
                        </div>

                        <div class="bb">
                            <img src="/image/nationaliet.png" alt="">
                            <p>
                                <strong>
                                    NATIONALITE
                                </strong>
                                <span>*********</span>
                            </p>
                        </div>
                    </div>


                    <div>
                        <h1><img src="../image/diplome.png" alt=""> Diplômes</h1>
                        <?php if (empty($afficheDiplome)): ?>
                            <ul>
                                <li>
                                    Non renseigner
                                </li>
                            </ul>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($afficheDiplome as $diplomes): ?>
                                    <li>
                                        <?= $diplomes['diplome'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div>
                        <h1><img src="../image/diplome.png" alt=""> Certificates</h1>
                        <?php if (empty($afficheCertificat)): ?>
                            <ul>
                                <li>Aucune donnée trouvée!</li>
                            </ul>

                        <?php else: ?>
                            <ul>
                                <?php foreach ($afficheCertificat as $certificat): ?>
                                    <li>
                                        <?= $certificat['certificat'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                    <div>
                        <h1><img src="../image/langue.png" alt=""> Langues</h1>
                        <?php if (empty($afficheLangue)): ?>
                            <ul>
                                <li>Aucune donnée trouver</li>
                            </ul>
                        <?php else: ?>
                            <?php foreach ($afficheLangue as $langues): ?>
                                <ul>
                                    <li>
                                        <?php echo $langues['langue']; ?>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>

                    <div>
                        <h1><img src="../image/loisir.png" alt=""> Loisir</h1>
                        <?php if (empty($afficheCentreInteret)): ?>
                            <ul>
                                <li>Aucune donnée trouver</li>
                            </ul>
                        <?php else: ?>
                            <?php foreach ($afficheCentreInteret as $interet): ?>
                                <ul>
                                    <li>
                                        <?= $interet['interet'] ?>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div>
                        <h1><img src="../image/social.png" alt=""> Reseaux </h1>
                        <div class="reseaux">
                            <img src="../image/facebook.png" alt="">
                            <img src="../image/linkedin.png" alt="">
                            <img src="../image/tweeter.png" alt="">
                            <img src="../image/whatsapp.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="box2">

                    <div>
                        <h1>A PROPOS</h1>
                        <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouver</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="experiences">
                        <h1>EXPÉRIENCES PROFESSIONNELLES</h1>

                        <div class="div">
                            <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php foreach ($afficheMetier as $Metiers): ?>
                                    <div class="div1">
                                        <strong class="strong"></strong>
                                        <div class="info">
                                            <h4>
                                                <?= $Metiers['metier'] ?>
                                            </h4>
                                            <span><em>
                                                    <?= $Metiers['moisDebut'] ?> /
                                                    <?= $Metiers['anneeDebut'] ?>
                                                </em> à <em>
                                                    <?= $Metiers['moisFin'] ?> /
                                                    <?= $Metiers['anneeFin'] ?>
                                                </em></span>
                                            <p>
                                                <?= $Metiers['description'] ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>


                    <div class="experiences">
                        <h1>FORMATIONS</h1>

                        <div class="div">
                            <?php if (empty($formationUsers)): ?>
                                <strong></strong>
                                <h4>Aucune donnée trouver</h4>
                            <?php else: ?>
                                <?php foreach ($formationUsers as $formations): ?>
                                    <div class="div1">
                                        <strong class="strong"></strong>

                                        <div class="info">
                                            <h4>
                                                <?= $formations['etablissement'] ?>
                                            </h4>
                                            <span><em>
                                                    <?= $formations['moisDebut'] ?> /
                                                    <?= $formations['anneeDebut'] ?>
                                                </em> à <em>
                                                    <?= $formations['moisFin'] ?> /
                                                    <?= $formations['anneeFin'] ?>
                                                </em>
                                            </span>
                                            <p> <strong>
                                                    <?= $formations['Filiere'] ?>
                                                </strong> </p>
                                            <p>
                                                <?= $formations['niveau'] ?>
                                            </p>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="experiences">
                        <h1>Competences</h1>
                        <div class="div-comp">
                            <?php if ($competencesUtilisateur): ?>
                                <?php foreach ($competencesUtilisateur as $competence): ?>
                                    <span class="comp">
                                        <?php echo $competence['competence']; ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>

                                <h4>Aucune donnée trouver</h4>
                            <?php endif ?>
                        </div>

                    </div>

                    <div class="experiences">
                        <h1>outils informatique</h1>
                        <?php if ($afficheOutil): ?>
                            <div class="outils">
                                <?php foreach ($afficheOutil as $outils): ?>
                                    <p><span></span>
                                        <?= $outils['outil'] ?>
                                    </p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif ?>

                    </div>
                </div>
            </div>
        </div>




    </section>


</body>

</html>