<?php
session_start();
if (isset($_GET['offres_id']) || isset($_GET['entreprise_id'])) {
    $offre_id = $_GET['offres_id'];
} else {
    header('Location: ../page/Offres_d\'emploi.php');
}

include_once('app/controller/controllerOffre_emploi.php');
include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('../controller/controller_users.php');
include_once('../controller/controller_postulation.php');

$Offres = getOffres($db, $offre_id);
$entreprise_id = $Offres['entreprise_id'];
$getEntreprise = getEntreprise($db, $entreprise_id);
$afficheDescriptionentreprise = getDescriptionEntreprise($db, $entreprise_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <title>Offre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../css/owl.carousel.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/voir_offre.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    
    <section class="section3">


    <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message">
                <p>
                    <span></span>
                    <?php echo $_SESSION['success_message']; ?>
                    <?php unset($_SESSION['success_message']); ?>
                </p>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="erreurs" id="messageErreur">
                    <span></span>
                    <?php echo $_SESSION['error_message']; ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <script>
            let success = document.querySelector('.message')
            setTimeout(() => {
                success.classList.add('visible');
            }, 200);
            setTimeout(() => {
                success.classList.remove('visible');
            }, 6000);

            // Sélectionnez l'élément contenant le message d'erreur
            var messageErreur = document.getElementById('messageErreur');

            // Fonction pour afficher le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.add('visible');
            }, 200); // 1000 millisecondes équivalent à 1 seconde

            // Fonction pour masquer le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.remove('visible');
            }, 6000); // 6000 millisecondes équivalent à 6 secondes
        </script>


        <div class="job-offer">

            <div class="box11">
                <img src="../upload/<?= $getEntreprise['images'] ?>" alt="">
                <h2>Offre d'emploi</h2>
                <p class="company">
                    <?= $getEntreprise['entreprise'] ?>
                </p>

                <?php if ($afficheDescriptionentreprise): ?>
                    <p class="lien"><a href="<?= $afficheDescriptionentreprise['liens'] ?>">
                            <?= $afficheDescriptionentreprise['liens'] ?>
                        </a></p>
                <?php else: ?>
                    <p class="lien">Aucun lien pour cette entreprise</p>
                <?php endif; ?>

                <h4>Type d'entreprise</h4>
                <p>
                    <?= $getEntreprise['types'] ?>
                </p>

                <h4>Description de l'Entreprise</h4>
                <?php if ($afficheDescriptionentreprise): ?>
                    <p class="description">
                        <?= $afficheDescriptionentreprise['descriptions'] ?>
                    </p>
                <?php else: ?>
                    <p class="description">
                        Description indisponible
                    </p>
                <?php endif; ?>
            </div>

            <?php if ($Offres): ?>
                <div class="box3">
                    <h1>Detaille de l'offre</h1>
                    <h2>Poste disponible : <span>
                            <?= $Offres['poste'] ?>
                        </span></h2>
                </div>


                <div class="box2">
                    <h3>Missions et responsabilités</h3>
                    <p><?= $Offres['mission'] ?></p>
                </div>

                <div class="box2">
                    <h3>Profil recherché</h3>
                    <p>Qualités et compétences requises:</p>
                   <p> <?= $Offres['profil'] ?></p>
                </div>

                <div class="box2">
                    <h3>Informations supplémentaires</h3>
                  <div class="box_info">
                    <p class="info"> <strong> Type de contrat :</strong>
                        <?= $Offres['contrat'] ?>
                    </p>
                    <p class="info"> <strong>Région : </strong>
                        <?= $Offres['localite'] ?>
                    </p>
                    <p class="info"> <strong>Ville : </strong>
                        <?= $getEntreprise['ville'] ?>
                    </p>
                    <p class="info"> <strong>Niveau d'expérience : </strong>
                        <?= $Offres['etudes'] ?>
                    </p>
                    <p class="info"> <strong>Langues exigées : </strong>
                        <?= $Offres['langues'] ?>
                    </p>
                  </div>

                </div>


                <?php
                if (isset($_SESSION['users_id'])) {
                    $getInfo = getInfoUsers($db, $_SESSION['users_id']);
                }

                ?>

                <?php if (isset($_SESSION['users_id'])): ?>
                    <form action="" method="post">
                        <input type="hidden" name="id_users" id="" value="<?= $getInfo['id'] ?>">
                        <input type="hidden" name="nom_users" id="" value="<?= $getInfo['nom'] ?>">
                        <input type="hidden" name="mail_users" id="" value="<?= $getInfo['mail'] ?>">
                        <input type="hidden" name="phone_users" id="" value="<?= $getInfo['phone'] ?>">
                        <input type="hidden" name="competence_users" id="" value="<?= $getInfo['competences'] ?>">
                        <input type="hidden" name="profession_users" id="" value="<?= $getInfo['profession'] ?>">
                        <input type="hidden" name="images_users" id="" value="<?= $getInfo['images'] ?>">

                        <?php if (isset($getPostulation['offre_id'])): ?>
                            <p class="msg001">Vous avez déjà envoyer votre candidature merci de patienter une réponse favorable.</p>
                        <?php else: ?>
                            <button class="btn001" type="submit" name="postuler">Postuler maintenant</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>




            <?php endif; ?>

        </div>

    </section>

    <div class="container_box10">
        <h2>Offres Simillaires </h2>
     
        <div class="slider owl-carousel carousel3">
            <?php foreach ($afficheAllOffre as $affiches): ?>
            <?php if($affiches['statut'] === 'publiee' or $affiches['statut'] === ''): ?>
                <?php $infoEntreprise = getEntreprise($db, $affiches['entreprise_id']) ?>

                <?php if ($affiches['categorie'] === $Offres['categorie']): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>
                            </p>
                            <p class="poste" >
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($affiches['poste']); ?>
                                    </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($affiches['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($affiches['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($affiches['experience']); ?>
                                    </p>
                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($affiches['localite']); ?>
                                    </p>
                                </div>

                            </div>
                           

                            <p id="nom">
                                <?php echo $affiches['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $affiches['offre_id']; ?>&entreprise_id=<?= $affiches['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>

                    </div>

                <?php endif; ?>
                <?php endif; ?>
            <?php endforeach ?>
        </div>
    </div>


    <?php include('../footer.php') ?>


    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
  
</body>

</html>