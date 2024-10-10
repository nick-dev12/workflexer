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

<s>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV1</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Climate+Crisis&family=Nunito&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Fascinate+Inline&family=Nunito&display=swap");

    /*--------------------------------------------------------------
  Variables
--------------------------------------------------------------*/
    :root {
      --texte-color_titre: #ededed;
      --font-color_titre: #5b4f4f;
      --font-color_section: #e6e6e6;
      --texte-color_section: #000000;
    }

    /*--------------------------------------------------------------
  Styles globaux
--------------------------------------------------------------*/
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }


    body {
      font-family: "Nunito", sans-serif;
      background-color: #e1e2e275;
    }

    #container {
      width: 793px;
      height: 1122px;
      border: 1.5px solid #a3a3a3;
      margin: 0 auto;
      position: relative;
      margin-bottom: 40px;
      background-color: #ffffff;
    }

    #container .box1 p {
      color: var(--texte-color_section);
    }

    #container .box1 p span {
      color: var(--texte-color_section);
    }

    #container .box1 ul li {
      color: var(--texte-color_section);
    }

    #container .box1 h2 {
      color: var(--texte-color_section);
      font-size: 18px;
    }

    #container .haut {
      background-color: var(--font-color_section);
      height: 30px;
      width: 100%;
      position: absolute;
      top: 0%;
      z-index: 5;
    }

    #container .bas {
      background-color: var(--font-color_section);
      height: 30px;
      width: 100%;
      position: absolute;
      bottom: 0%;
    }

    #container .img {
      width: 170px;
      height: 150px;
      object-fit: cover;
      border: 1.5px solid #ddd;
      border-radius: 7px;
    }

    #container .box1 .profil {
      width: 100%;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      margin-top: 20px;
    }

    #container .container-box {
      display: flex;
    }

    #container .box1 {
      width: 290px;
      height: 1120px;
      position: relative;
      border-right: 3px solid #000000;
      padding-top: 20px;
      background-color: var(--font-color_section);
    }

    #container .box1 h1 {
      width: 80%;
      text-align: center;
      padding: 5px 20px;
      background-color: var(--font-color_titre);
      color: var(--texte-color_titre);
      margin: 10px auto;
      font-size: 12px;
      display: flex;
      align-items: center;
      border-radius: 4px;
      text-transform: uppercase;
    }

    #container .box1 .profil .nom {
      background-color: #ffffff;
      font-size: 15px;
      color: #000000;
      width: 100%;
      padding: 5px 10px;
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

    #container .box1 .bb p span {
      overflow: hidden;
      width: 140px;
    }

    #container .box1 ul {
      width: 80%;
      margin: 0 auto;
    }

    #container .box1 ul li {
      font-size: 13px;
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
      height: 1100px;
      position: relative;
      padding-top: 10px;
      padding-bottom: 10px;
    }

    #container .box2 .info_users {
      margin-top: 30px;
    }

    #container .box2 h1 {
      font-size: 14px;
      width: 80%;
      margin: 7px auto;
      background-color: var(--font-color_titre);
      color: var(--texte-color_titre);
      padding: 4px 10px;
      border-radius: 4px;
      text-transform: uppercase;
      display: flex;
      align-items: center;
    }

    #container .box2 h1 img {
      height: 25px;
      width: 25px;
      margin-right: 15px;

    }

    #container .box2 .info_users p {
      font-size: 12px;
      width: 85%;
      margin: 15px auto;
      text-align: justify;
    }

    #container .box2 p {
      font-size: 12px;
      width: 85%;
      margin: 15px auto;
    }

    #container .box2 .experiences .div {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      margin: 10px auto;
      flex-wrap: wrap;
    }

    #container .box2 .experiences .div1 {
      display: flex;
      align-items: center;
      margin: 10px;
      width: 80%;
      position: relative;
    }

    #container .box2 .experiences .div2 {
      display: flex;
      align-items: center;
      margin: 7px 10px;
      width: 80%;
    }

    #container .box2 .div .info {
      display: flex;
      align-items: start;
      flex-direction: column;
      width: 100%;
    }

    #container .box2 .div h4 {
      width: 80%;
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

    #container .box2 .div .div1 #strong {
      height: 50px;
      display: block;
      padding: 2px;
      background-color: var(--font-color_section);
      margin-right: 15px;
    }

    #container .box2 .div .div2 #strong {
      height: 50px;
      display: block;
      padding: 2px;
      background-color: var(--font-color_section);
      margin-right: 15px;
    }


    #container .box2 .experiences .outils {
      width: 90%;
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
      margin-right: 20px;
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
</s>

<body>


  <section class="section3">

    <div id="box1">
      <div id="container" class="container cv2">
        <!-- <div class="haut"></div> -->

        <div class="container-box">

          <div class="box1">
            <div class="profil">
              <img class="img" src="../upload/<?= $userss['images'] ?>" alt="">
              <h1 class="nom">
                <?= $userss['nom'] ?>
              </h1>
              <h2 class="profession">
                <?= $userss['competences'] ?>
              </h2>
            </div>

            <div>
              <h1 class="text">Profil</h1>
              <div class="bb">
                <img src="/image/address.png" alt="">
                <p>
                  <strong>
                    ADRESSE
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
                    TÉLÉPHONE
                  </strong>
                  <span>
                    <?= $userss['phone'] ?>
                  </span>
                </p>
              </div>

              <div class="bb">
                <img src="/image/nationalite.png" alt="">
                <p>
                  <strong>
                    NATIONALITÉ
                  </strong>
                  <span>*********</span>
                </p>
              </div>
            </div>


            <div>
              <h1 class="text"><img src="../image/diplome.png" alt=""> Diplômes</h1>
              <?php if (empty($afficheDiplome)): ?>
                <ul>
                  <li>
                    Non renseigné
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
              <h1 class="text"><img src="../image/diplome.png" alt=""> Certificats</h1>
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
              <h1 class="text"><img src="../image/langue.png" alt=""> Langues</h1>
              <?php if (empty($afficheLangue)): ?>
                <ul>
                  <li>Aucune donnée trouvée</li>
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
              <h1 class="text"><img src="../image/loisir.png" alt=""> Loisirs</h1>
              <?php if (empty($afficheCentreInteret)): ?>
                <ul>
                  <li>Aucune donnée trouvée</li>
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
              <h1 class="text"><img src="../image/social.png" alt=""> Réseaux</h1>
              <div class="reseaux">
                <img src="../image/facebook.png" alt="">
                <img src="../image/linkedin.png" alt="">
                <img src="../image/tweeter.png" alt="">
                <img src="../image/whatsapp.png" alt="">
              </div>
            </div>
          </div>

          <div class="box2">

            <div class="info_users">
              <h1 class="text"> <img src="/image/a_propos.png" alt=""> À PROPOS </h1>
              <?php if (empty($descriptions)): ?>
                <p>Aucune donnée trouvée</p>
              <?php else: ?>
                <p class="p">
                  <?= $descriptions['description'] ?>
                </p>
              <?php endif; ?>
            </div>

            <div class="experiences">
              <h1 class="text"> <img src="/image/experience.png" alt=""> EXPÉRIENCES PROFESSIONNELLES
              </h1>

              <div class="div">
                <?php if (empty($afficheMetier)): ?>
                  <h4>Aucune donnée trouvée</h4>
                <?php else: ?>
                  <?php
                  shuffle($afficheMetier);
                  $nombre_metier = 2
                    ?>
                  <?php foreach ($afficheMetier as $key => $Metiers): ?>
                    <?php if ($key < $nombre_metier): ?>
                      <div class="div1">
                        <strong id="strong"></strong>
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
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>


              </div>

            </div>


            <div class="experiences">
              <h1 class="text"> <img src="/image/etude.png" alt=""> FORMATIONS </h1>

              <div class="div formation">


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
                      <div class="div1 div2">
                        <strong id="strong"></strong>

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
                          <p>
                            <?= $formations['Filiere'] ?> , <strong>
                              <?= $formations['niveau'] ?></strong>
                          </p>

                        </div>
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>

              </div>

            </div>

            <div class="experiences">
              <h1 class="text"> <img src="/image/compétences.png" alt=""> Compétences </h1>
              <div class="div-comp">
                <?php if ($competencesUtilisateur): ?>
                  <?php foreach ($competencesUtilisateur as $competence): ?>
                    <span class="comp">
                      <?php echo $competence['competence']; ?>
                    </span>
                  <?php endforeach; ?>
                <?php else: ?>

                  <h4>Aucune donnée trouvée</h4>
                <?php endif ?>

              </div>

            </div>

            <div class="experiences">
              <h1 class="text"> <img src="/image/outil.png" alt=""> Outils informatiques </h1>
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

        <!-- <div class="bas"></div> -->
      </div>
    </div>

  </section>

</body>

</html>