<?php
include __DIR__ . '/../entreprise/app/model/offre_emploi.php';
include __DIR__ . '/../conn/conn.php';

if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
    $details_offre2 = getDetails_emploi2($db, $offre_id);
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

    <?php include '../navbare.php'; ?>

    <?php if (isset($details_offre2)): ?>

        <div class="containerBox">
            <div class="box1">
                <h1><?= $details_offre2['titre'] ?></h1>
                <div><strong>Référence :</strong> <?= $details_offre2['reference'] ?></div>
                <div><strong>Entreprise :</strong> <?= $details_offre2['entreprise'] ?></div>
                <p><strong>Localisation :</strong> <?= $details_offre2['localisation'] ?></p>
                <p><strong>Type de contrat :</strong> <?= $details_offre2['type_contrat'] ?></p>
                <p><strong>Date de publication :</strong> <?= $details_offre2['date_publication'] ?></p>
            </div>

            <div>
                <strong>Description du poste :</strong>
                <p><?= $details_offre2['description_poste'] ?></p>
            </div>

            <div>
                <strong>Profil recherché :</strong>
                <p><?= $details_offre2['profil_recherche'] ?></p>
            </div>

            <?php if (isset($_SESSION['users_id'])): ?>
                <p><a class="liens" href="<?= $details_offre2['lien_offre'] ?>" target="_blank">
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