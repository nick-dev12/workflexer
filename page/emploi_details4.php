<?php
session_start();
require_once '../conn/conn.php';
require_once '../entreprise/app/model/offre_emploi.php';

// Vérification de l'ID de l'offre
if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
    $details_offre = getDetails_emploi_offreemploisn($db, $offre_id);
} else {
    header('Location: /page/offres_emploi_unifiees.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Détails de l'offre d'emploi</title>
</head>

<body>
    <?php include '../navbare.php'; ?>

    <?php if ($details_offre): ?>
    <div class="containerBox">
        <div class="job-details">
            <div class="job-header">
                <h1><?= htmlspecialchars($details_offre['titre'] ?? 'Titre non disponible') ?></h1>
                <div class="company-info">
                    <span><i class="fas fa-building"></i>
                        <?= htmlspecialchars($details_offre['entreprise'] ?? 'Non spécifiée') ?></span>
                    <span><i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($details_offre['lieu'] ?? 'Non spécifiée') ?></span>
                </div>
            </div>

            <div class="job-content">
                <?php if (!empty($details_offre['description_courte'])): ?>
                <div class="job-section">
                    <h3><i class="fas fa-info-circle"></i> Description courte</h3>
                    <p><?= nl2br(htmlspecialchars($details_offre['description_courte'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($details_offre['description_complete'])): ?>
                <div class="job-section">
                    <h3><i class="fas fa-tasks"></i> Description complète</h3>
                    <div class="job-description"><?= $details_offre['description_complete'] ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="job-details-grid">
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <span>Date de publication :</span>
                        <strong><?= htmlspecialchars(date('d/m/Y', strtotime($details_offre['date_publication'] ?? ''))) ?></strong>
                    </div>
                    <?php if (!empty($details_offre['date_cloture'])): ?>
                    <div class="detail-item">
                        <i class="fas fa-calendar-times"></i>
                        <span>Date de clôture :</span>
                        <strong><?= htmlspecialchars(date('d/m/Y', strtotime($details_offre['date_cloture']))) ?></strong>
                    </div>
                    <?php endif; ?>
                    <div class="detail-item">
                        <i class="fas fa-file-contract"></i>
                        <span>Type de contrat :</span>
                        <strong><?= htmlspecialchars($details_offre['type_contrat'] ?? 'Non spécifié') ?></strong>
                    </div>
                    <?php if (!empty($details_offre['reference'])): ?>
                    <div class="detail-item">
                        <i class="fas fa-hashtag"></i>
                        <span>Référence :</span>
                        <strong><?= htmlspecialchars($details_offre['reference']) ?></strong>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="apply-section">
                    <a class="apply-button" href="<?= htmlspecialchars($details_offre['lien_offre']) ?>" target="_blank"
                        rel="noopener noreferrer">
                        <i class="fas fa-paper-plane"></i> Postuler maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="containerBox">
        <p>Cette offre d'emploi n'est plus disponible ou n'a pas été trouvée.</p>
    </div>
    <?php endif; ?>
</body>

</html>