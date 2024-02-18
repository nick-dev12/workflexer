<?php
session_start();
if (isset($_GET['id'])) {
  $offre_id = $_GET['id'];
} else {
  header('Location: ../page/Offres_d\'emploi.php');
}

include_once('entreprise/app/controller/controllerEntreprise.php');
include_once('entreprise/app/controller/controllerDescription.php');
include_once('controller/controller_users.php');
include_once('controller/controller_postulation.php');

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

  <title>Profil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- <link rel="stylesheet" href="../css/owl.carousel.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/voir_offre.css"> -->
  <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <?php include('navbare.php') ?>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
    }

    .job-offer {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 30px 20px;
      width: 90%;
      max-width: 700px;
      text-align: center;
    }

    .job-offer .box1 {
      width: 90%;
      margin: 0 auto;
    }

    .job-offer .box1 p {
      font-size: 15px;
      margin-top: -10px;
    }

    .job-offer .box2 {
      margin-top: 30px;
      padding: 0 20px;
    }

    .job-offer h2 {
      color: #272727;
      font-size: 24px;
      margin-bottom: 20px;
      text-transform: capitalize;
      letter-spacing: 1px;
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
    }

    .company {
      font-weight: bold;
    }

    .location {
      color: #272727;
    }

    .description,
    .requirements,
    .salary {
      color: #272727;
      text-align: left;
    }

    .apply-button {
      display: inline-block;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 5px;
      margin-top: 20px;
    }

    .apply-button:hover {
      background-color: #0056b3;
    }

    .job-offer h3 {
      color: #007bff;
      font-size: 16px;
      margin-top: 20px;
      text-transform: uppercase;
    }

    .job-offer ul {
      margin-top: 10px;
      margin-left: 20px;
      text-align: left;
    }

    .job-offer ul li {
      color: #272727;
    }

    .job-offer h3+p {
      color: #272727;
      text-align: left;
    }

    .job-offer img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 50%;
    }

    .job-offer .box2 .info {
      width: 90%;
      padding-left: 40px;
      margin-top: 10px;
      color: #272727;
      text-align: left;
    }

    /* Responsive Design */

    @media only screen and (max-width: 600px) {
      .job-offer {
        width: 90%;
        max-width: 90%;
      }
    }
  </style>
  <div class="job-offer">
    <div class="box1">
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
      <p class="description">
        <?= $afficheDescriptionentreprise['descriptions'] ?>
      </p>
    </div>

    <h1>Detaille de l'offre</h1>
    <h2>Poste disponible : <span>
        <?= $Offres['poste'] ?>
      </span></h2>

    <div class="box2">
      <h3>Missions et responsabilités</h3>
      <?= $Offres['mission'] ?>
    </div>

    <div class="box2">
      <h3>Profil recherché</h3>
      <p>Qualités et compétences requises:</p>
      <?= $Offres['profil'] ?>
    </div>

    <div class="box2">
      <h3>Informations supplémentaires</h3>
      <p class="info"> <strong>Métier : </strong><?= $Offres['metier'] ?></p>
      <p class="info"> <strong> Type de contrat :</strong> <?= $Offres['contrat'] ?></p>
      <p class="info"> <strong>Région : </strong> <?= $Offres['localite'] ?></p>
      <p class="info"> <strong>Ville : </strong> <?= $getEntreprise['ville'] ?></p>
      <p class="info"> <strong>Niveau d'expérience : </strong> <?= $Offres['etudes'] ?></p>
      <p class="info"> <strong>Langues exigées : </strong> <?= $Offres['langues'] ?></p>


      <a href="#" class="apply-button">Postuler maintenant</a>
    </div>

  </div>
</body>

</html>