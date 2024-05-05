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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/model1.css">
</head>

<body>

    <?php include('../navbare.php') ?>

    <?php include('../include/header_users.php') ?>




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
        const element = document.querySelector(".cv2");

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

<div class="personnalisation">
  <div class="box">
    <p>Couleur de fond des titres principaux </p>
     <input type="color" name="" id="fontColor">
  </div>
  <div class="box">
    <p>Couleur de de fond (section informations)</p>
     <input type="color" name="" id="fontColor2">
  </div>

  <div class="box">
    <p>Couleur du texte (section informations)</p>
     <input type="color" name="" id="fontColor3">
  </div>
 
  <script>
    const colorInput = document.getElementById('fontColor');
    // Récupérer la valeur sauvegardée dans le stockage local (si elle existe)
const savedColor = localStorage.getItem('fontColor');

// Appliquer la couleur sauvegardée ou une valeur par défaut si aucune couleur n'a été sauvegardée
document.documentElement.style.setProperty('--font-color', savedColor || 'black');
colorInput.value = savedColor || '#000000'; // Mettre à jour la valeur du champ input

// Écouter les changements sur le champ input
colorInput.addEventListener('input', function() {
  // Mettre à jour la valeur de la variable CSS en fonction de la couleur choisie par l'utilisateur
  const selectedColor = colorInput.value;
  document.documentElement.style.setProperty('--font-color', selectedColor);

  // Sauvegarder la couleur sélectionnée dans le stockage local
  localStorage.setItem('fontColor', selectedColor);
});


const colorInput1 = document.getElementById('fontColor2');
const saveColor2 = localStorage.getItem('fontColor2');

document.documentElement.style.setProperty('--font-color2', saveColor2 || '#e6e6e6');
colorInput1.value = saveColor2 || '#e6e6e6'; // Mettre à jour la valeur du champ input

colorInput1.addEventListener('input', function() {
const selectedColor = colorInput1.value;
document.documentElement.style.setProperty('--font-color2', selectedColor);
localStorage.setItem('fontColor2', selectedColor);
});

const colorInput2 = document.getElementById('fontColor3');
const saveColor3 = localStorage.getItem('fontColor3');

document.documentElement.style.setProperty('--text-color', saveColor3 || '#000000');
colorInput2.value = saveColor3 || '#000000'; // Mettre à jour la valeur du champ input

colorInput2.addEventListener('input', function() {
const selectedColor = colorInput2.value;
document.documentElement.style.setProperty('--text-color', selectedColor);
localStorage.setItem('fontColor3', selectedColor);
});
  </script>
</div>

        <div id="box">
        <div id="container" class="container">
                <div class="haut"></div>
      
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
                              <h1 class="text"><img src="../image/diplome.png" alt=""> Diplômes</h1>
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
                              <h1 class="text"><img src="../image/diplome.png" alt=""> Certificates</h1>
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
                              <h1 class="text"><img src="../image/loisir.png" alt=""> Loisir</h1>
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
                              <h1 class="text"><img src="../image/social.png" alt=""> Reseaux </h1>
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
                              <h1 class="text">A PROPOS</h1>
                              <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouver</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                          </div>
      
                          <div class="experiences">
                              <h1 class="text">EXPÉRIENCES PROFESSIONNELLES</h1>
      
                              <div class="div">
                              <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php 
                                shuffle($afficheMetier);
                                $nombre_metier = 2
                                ?>
                                <?php foreach ($afficheMetier as $key  => $Metiers ): ?>
                                    <?php if($key < $nombre_metier): ?>
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
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
      
                                          
                              </div>
      
                          </div>
      
      
                          <div class="experiences">
                              <h1 class="text">FORMATIONS</h1>
      
                              <div class="div formation">
                                          
      
                              <?php if (empty($formationUsers)): ?>
                                <strong></strong>
                                <h4>Aucune donnée trouver</h4>
                            <?php else: ?>
                                <?php 
                                shuffle($formationUsers);
                                $nombre_formation = 3;
                                ?>
                                <?php foreach ($formationUsers as $key => $formations): ?>
                                    <?php if($key < $nombre_formation): ?>
                                    <div class="div1 div2">
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
                                            <p> 
                                                    <?= $formations['Filiere'] ?> , <strong> <?= $formations['niveau'] ?></strong>
                                                 </p>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                                         
                              </div>
      
                          </div>
      
                          <div class="experiences">
                              <h1 class="text">Competences</h1>
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
                              <h1 class="text">outils informatique</h1>
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
      
                  <div class="bas"></div>
              </div>
        </div>

        <div id="box1">
            <div id="container" class="container cv2">
                <div class="haut"></div>
      
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
                              <h1 class="text"><img src="../image/diplome.png" alt=""> Diplômes</h1>
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
                              <h1 class="text"><img src="../image/diplome.png" alt=""> Certificates</h1>
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
                              <h1 class="text"><img src="../image/loisir.png" alt=""> Loisir</h1>
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
                              <h1 class="text"><img src="../image/social.png" alt=""> Reseaux </h1>
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
                              <h1 class="text">A PROPOS</h1>
                              <?php if (empty($descriptions)): ?>
                            <p>Aucune donnée trouver</p>
                        <?php else: ?>
                            <p class="p">
                                <?= $descriptions['description'] ?>
                            </p>
                        <?php endif; ?>
                          </div>
      
                          <div class="experiences">
                              <h1 class="text">EXPÉRIENCES PROFESSIONNELLES</h1>
      
                              <div class="div">
                              <?php if (empty($afficheMetier)): ?>
                                <h4>Aucune donnée trouvée</h4>
                            <?php else: ?>
                                <?php 
                                shuffle($afficheMetier);
                                $nombre_metier = 2
                                ?>
                                <?php foreach ($afficheMetier as $key  => $Metiers ): ?>
                                    <?php if($key < $nombre_metier): ?>
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
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
      
                                          
                              </div>
      
                          </div>
      
      
                          <div class="experiences">
                              <h1 class="text">FORMATIONS</h1>
      
                              <div class="div formation">
                                          
      
                              <?php if (empty($formationUsers)): ?>
                                <strong></strong>
                                <h4>Aucune donnée trouver</h4>
                            <?php else: ?>
                                <?php 
                                shuffle($formationUsers);
                                $nombre_formation = 3;
                                ?>
                                <?php foreach ($formationUsers as $key => $formations): ?>
                                    <?php if($key < $nombre_formation): ?>
                                    <div class="div1 div2">
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
                                            <p> 
                                                    <?= $formations['Filiere'] ?> , <strong> <?= $formations['niveau'] ?></strong>
                                                 </p>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                                         
                              </div>
      
                          </div>
      
                          <div class="experiences">
                              <h1 class="text">Competences</h1>
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
                              <h1 class="text">outils informatique</h1>
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
      
                  <div class="bas"></div>
              </div>
        </div>

    </section>
    

</body>

</html>