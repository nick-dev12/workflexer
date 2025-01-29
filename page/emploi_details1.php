<?php
include '../entreprise/app/model/offre_emploi.php';


if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
    $details_offre = getDetails_emploi($db, $offre_id);
} else {
    header('Location: /page/Offres_d\'emploi.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/emploi_details1.css">
    <title>Détails de l'offre d'emploi</title>
</head>

<body>

</body>

<?php include '../navbare.php'; ?>



<?php if (isset($details_offre)): ?>

    <div class="containerBox">
        <div class="box1">
            <h1><?= $details_offre['titre'] ?></h1>
            <div><strong>Entreprise :</strong> <?= $details_offre['entreprise'] ?></div>
            <p><strong>Localisation :</strong> <?= $details_offre['localisation'] ?></p>
            <p><strong>Description de l'entreprise :</strong> <?= $details_offre['description_entreprise'] ?></p>
            <p><strong>Site internet :</strong> <a href="<?= $details_offre['site_internet'] ?>"
                    target="_blank"><?= $details_offre['site_internet'] ?></a></p>
            <p><strong>Source :</strong> <?= $details_offre['source'] ?></p>
            <p><strong>Date de publication :</strong> <?= $details_offre['date_publication'] ?></p>
        </div>
        <div>
            <strong>Description du poste :</strong> <?= $details_offre['description_poste'] ?>
        </div>
        <div>
            <strong>Profil recherché :</strong> <?= $details_offre['profil_recherche'] ?>
        </div>

        <div class="box2">
            <p><strong>Date de création :</strong> <?= $details_offre['date_creation'] ?></p>
            <p><strong>Niveau d'étude :</strong> <?= $details_offre['niveau_etude'] ?></p>
            <p><strong>Niveau d'expérience :</strong> <?= $details_offre['niveau_experience'] ?></p>
            <p><strong>Type de contrat :</strong> <?= $details_offre['type_contrat'] ?></p>
            <p><strong>Compétences :</strong> <?= $details_offre['competences'] ?></p>
            <p><strong>Secteur d'activité :</strong> <?= $details_offre['secteur_activite'] ?></p>
        </div>

        <?php if (isset($_SESSION['users_id'])): ?>

            <p><a class="liens" href="<?= $details_offre['lien_offre'] ?>">
                    Postuler
                </a>
            </p>
        <?php else: ?>
            <p id="message">Vous devez vous connecter à un compte professionnel pour postuler à cette offre d'emploi.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Aucune offre trouvée.</p>
    </div>
<?php endif; ?>
</body>

</html>