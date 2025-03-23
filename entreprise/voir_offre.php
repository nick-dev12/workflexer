<?php
session_start();

include_once('../conn/conn.php');


if (isset($_GET['offres_id']) or isset($_GET['entreprise_id'])) {
    $offre_id = $_GET['offres_id'];
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


if (isset($_SESSION['users_id'])) {
    $get_vue_offre = get_vue_offre_users($db, $_SESSION['users_id'], $offre_id);
    if (empty($get_vue_offre)) {
        post_vue_offre($db, $_SESSION['users_id'], $offre_id, $entreprise_id);
    }
}

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
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
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

    <?php include('../include/notifications.php'); ?>

    <section class="section3">


        <div class="job-offer">

            <div class="box11">
                <img src="../upload/<?= $getEntreprise['images'] ?>" alt="Logo <?= $getEntreprise['entreprise'] ?>">
                <h2>Offre d'emploi</h2>
                <p class="company">
                    <?= $getEntreprise['entreprise'] ?>
                </p>

                <button class="toggle-company-info">
                    <i class="fas fa-chevron-down"></i> Afficher les informations de l'entreprise
                </button>

                <div class="company-info-container">
                    <?php if ($afficheDescriptionentreprise): ?>
                        <p class="lien"><a href="<?= $afficheDescriptionentreprise['liens'] ?>" target="_blank">
                                <i class="fas fa-globe"></i> <?= $afficheDescriptionentreprise['liens'] ?>
                            </a></p>
                    <?php else: ?>
                        <p class="lien"><i class="fas fa-info-circle"></i> Aucun lien pour cette entreprise</p>
                    <?php endif; ?>

                    <h4><i class="fas fa-building"></i> Type d'entreprise</h4>
                    <p>
                        <?= $getEntreprise['types'] ?>
                    </p>

                    <h4><i class="fas fa-align-left"></i> Description de l'Entreprise</h4>
                    <?php if ($afficheDescriptionentreprise): ?>
                        <p class="description">
                            <?= $afficheDescriptionentreprise['descriptions'] ?>
                        </p>
                    <?php else: ?>
                        <p class="description">
                            <i class="fas fa-exclamation-circle"></i> Description indisponible
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($Offres): ?>
                <div class="box3">
                    <h1>Détails de l'offre</h1>
                    <div class="poste-container">
                        <h2><i class="fas fa-briefcase"></i> Poste disponible : <span>
                                <?= $Offres['poste'] ?>
                            </span></h2>
                        <div class="nombre-poste-disponible">
                            <i class="fas fa-users"></i>
                            <span class="nombre"><?= isset($Offres['place']) ? $Offres['place'] : '1' ?></span>
                            <span class="texte">poste(s) à pourvoir</span>
                        </div>
                    </div>
                </div>


                <div class="box2">
                    <h3><i class="fas fa-tasks"></i> Missions et responsabilités</h3>
                    <p><?= $Offres['mission'] ?></p>
                </div>

                <div class="box2">
                    <h3><i class="fas fa-user-graduate"></i> Profil recherché</h3>
                    <p>Qualités et compétences requises:</p>
                    <p><?= $Offres['profil'] ?></p>
                </div>

                <div class="box2">
                    <h3><i class="fas fa-info-circle"></i> Informations supplémentaires</h3>
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

                        <p class="info"> <strong>Niveau d'expérience minimum : </strong>
                            <?= $Offres['experience'] ?>
                        </p>

                        <p class="info"> <strong>Niveau d'étude minimum: </strong>
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
                    <?php if (isset($_SESSION['match_result'])): ?>
                        <div class="match-result">
                            <h3><i class="fas fa-chart-bar"></i> Compatibilité de votre profil</h3>

                            <div class="compatibility-details">
                                <?php if ($_SESSION['match_result']['niveauEtudeMatch']): ?>
                                    <p class="match-item success"><i class="fas fa-check-circle"></i> Votre niveau d'études correspond
                                        aux exigences</p>
                                <?php else: ?>
                                    <p class="match-item error"><i class="fas fa-times-circle"></i> Votre niveau d'études ne correspond
                                        pas aux exigences</p>
                                <?php endif; ?>

                                <?php if ($_SESSION['match_result']['niveauExperienceMatch']): ?>
                                    <p class="match-item success"><i class="fas fa-check-circle"></i> Votre expérience correspond aux
                                        exigences</p>
                                <?php else: ?>
                                    <p class="match-item error"><i class="fas fa-times-circle"></i> Votre expérience ne correspond pas
                                        aux exigences</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <input type="hidden" name="id_users" id="" value="<?= $getInfo['id'] ?>">
                        <input type="hidden" name="nom_users" id="" value="<?= $getInfo['nom'] ?>">
                        <input type="hidden" name="mail_users" id="" value="<?= $getInfo['mail'] ?>">
                        <input type="hidden" name="phone_users" id="" value="<?= $getInfo['phone'] ?>">
                        <input type="hidden" name="competence_users" id="" value="<?= $getInfo['competences'] ?>">
                        <input type="hidden" name="profession_users" id="" value="<?= $getInfo['profession'] ?>">
                        <input type="hidden" name="images_users" id="" value="<?= $getInfo['images'] ?>">

                        <?php if (isset($getPostulation['offre_id'])): ?>
                            <p class="msg001"><i class="fas fa-info-circle"></i> Vous avez déjà envoyé votre candidature. Merci de
                                patienter pour une réponse favorable.</p>
                        <?php else: ?>
                            <?php if (isset($_SESSION['match_result']) && $_SESSION['match_result']['niveauEtudeMatch'] && $_SESSION['match_result']['niveauExperienceMatch']): ?>
                                <button class="btn001" type="submit" name="postuler"><i class="fas fa-paper-plane"></i> Postuler
                                    maintenant</button>
                            <?php else: ?>
                                <p class="msg001"><i class="fas fa-exclamation-triangle"></i> Votre niveau d'études ou d'expérience ne
                                    correspond pas
                                    aux exigences de cette offre</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </form>
                <?php else: ?>
                    <form action="">
                        <p class="msg001"><i class="fas fa-exclamation-triangle"></i> Vous devez avoir un compte professionnel
                            pour pouvoir postuler</p>
                    </form>
                <?php endif; ?>




            <?php endif; ?>

        </div>

    </section>

    <div class="container_box10">
        <h2>Offres Similaires</h2>

        <div class="slider owl-carousel carousel3">
            <?php if (isset($afficheAllOffre)): ?>
                <?php foreach ($afficheAllOffre as $affiches): ?>
                    <?php if ($affiches['statut'] === 'publiee' or $affiches['statut'] === ''): ?>
                        <?php $infoEntreprise = getEntreprise($db, $affiches['entreprise_id']) ?>

                        <?php if ($affiches['categorie'] === $Offres['categorie']): ?>

                            <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                                data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                                <img src="../upload/<?php echo $infoEntreprise['images'] ?>"
                                    alt="Logo <?php echo $infoEntreprise['entreprise']; ?>">
                                <div class="info-box">
                                    <p class="p">
                                        <strong>
                                            <?php echo $infoEntreprise['entreprise']; ?>
                                        </strong>
                                    </p>
                                    <p class="poste">
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
            <?php endif; ?>
        </div>
    </div>


    <?php include('../footer.php') ?>


    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>

    <script>
        // Script pour afficher/masquer les informations de l'entreprise
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.querySelector('.toggle-company-info');
            const companyInfo = document.querySelector('.company-info-container');

            if (toggleBtn && companyInfo) {
                toggleBtn.addEventListener('click', function () {
                    companyInfo.classList.toggle('active');
                    toggleBtn.classList.toggle('active');

                    if (companyInfo.classList.contains('active')) {
                        toggleBtn.innerHTML = '<i class="fas fa-chevron-up"></i> Masquer les informations de l\'entreprise';
                    } else {
                        toggleBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Afficher les informations de l\'entreprise';
                    }
                });
            }
        });
    </script>
</body>

</html>