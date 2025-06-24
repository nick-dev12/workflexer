<?php
session_start();
require_once '../conn/conn.php';
require_once '../entreprise/app/model/offre_emploi.php';
require_once '../controller/MatchingController.php';

// Activation des logs d'erreur PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Fonction de log personnalisée
function debug_log($message, $data = null)
{
    $log = date('Y-m-d H:i:s') . " - " . $message;
    if ($data !== null) {
        $log .= "\nData: " . print_r($data, true);
    }
    error_log($log . "\n", 3, __DIR__ . '/../logs/emploi_details.log');
}

// Vérification de l'état de la session
debug_log("État de la session", [
    'session_id' => session_id(),
    'users_id' => $_SESSION['users_id'] ?? 'non défini',
    'is_connected' => isset($_SESSION['users_id']) ? 'oui' : 'non'
]);

// Vérification de l'ID de l'offre
if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
    debug_log("ID de l'offre reçu", $offre_id);

    try {
        $details_offre = getDetails_emploi($db, $offre_id);
        debug_log("Détails de l'offre récupérés", $details_offre);

        // Si l'utilisateur est connecté, on analyse la compatibilité
        $compatibilite = null;
        if (isset($_SESSION['users_id'])) {
            debug_log("Tentative d'analyse de compatibilité pour l'utilisateur", $_SESSION['users_id']);

            try {
                $matchingController = new MatchingController($db);
                debug_log("MatchingController initialisé");

                $compatibilite = $matchingController->analyserCompatibilite($_SESSION['users_id'], $offre_id);
                debug_log("Résultat de l'analyse de compatibilité", $compatibilite);

            } catch (Exception $e) {
                debug_log("ERREUR lors de l'analyse de compatibilité", [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            debug_log("Utilisateur non connecté - Pas d'analyse de compatibilité");
        }
    } catch (Exception $e) {
        debug_log("ERREUR lors de la récupération des détails de l'offre", [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
} else {
    debug_log("Aucun ID d'offre fourni - Redirection");
    header('Location: /page/Offres_d\'emploi.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-T">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/emploi_details1.css">
    <link rel="stylesheet" href="../api1/css/compatibility.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Détails de l'offre d'emploi</title>
</head>

<body>
    <?php include '../navbare.php'; ?>

    <?php if (isset($details_offre)): ?>
    <div class="containerBox">
        <!-- Section de compatibilité -->
        <?php if (isset($_SESSION['users_id']) && $compatibilite && isset($compatibilite['score_global'])): ?>
        <?php
                // Logique pour les couleurs et textes dynamiques
                $score = round($compatibilite['score_global']);
                $score_class = $score >= 70 ? 'excellent' : ($score >= 50 ? 'good' : ($score >= 30 ? 'moderate' : 'low'));

                // Extraction des points forts (toutes catégories confondues)
                $points_forts = [];
                if (isset($compatibilite['points_forts'])) {
                    foreach ($compatibilite['points_forts'] as $point) {
                        $points_forts[] = $point['description'];
                    }
                }

                // Extraction des points à améliorer (toutes catégories confondues)
                $points_amelioration = [];
                if (isset($compatibilite['points_amelioration'])) {
                    foreach ($compatibilite['points_amelioration'] as $point) {
                        $points_amelioration[] = $point['description'];
                    }
                }

                // Suggestions
                $suggestions = [];
                if (isset($compatibilite['suggestions'])) {
                    foreach ($compatibilite['suggestions'] as $suggestion) {
                        $suggestions[] = $suggestion['description'];
                    }
                }
                
                // Niveau d'étude et expérience (pour la section résumé)
                $niveau_etude = $compatibilite['analyse_detaillee']['formation']['resume'] ?? 'Analyse non disponible';
                $experience = $compatibilite['analyse_detaillee']['experience']['resume'] ?? 'Analyse non disponible';
                
                // Exigences de l'offre
                $niveau_etude_requis = isset($details_offre['niveau_etude']) ? $details_offre['niveau_etude'] : 'Non spécifié';
                $niveau_experience_requis = isset($details_offre['niveau_experience']) ? $details_offre['niveau_experience'] : 'Non spécifié';

                $etude_match = ($compatibilite['analyse_detaillee']['formation']['score'] ?? 0) > 50;
                $experience_match = ($compatibilite['analyse_detaillee']['experience']['score'] ?? 0) > 50;
                
                // Déterminer le message principal en fonction du score
                if ($score >= 70) {
                    $message_principal = "Votre profil est en excellente adéquation avec cette offre.";
                } elseif ($score >= 50) {
                    $message_principal = "Votre profil correspond globalement à cette offre, avec quelques points à améliorer.";
                } elseif ($score >= 30) {
                    $message_principal = "Votre profil présente une adéquation moyenne avec cette offre. Des améliorations significatives sont recommandées.";
                } else {
                    $message_principal = "Votre profil ne correspond pas suffisamment aux exigences de cette offre.";
                }
                ?>

        <div class="compatibility-analysis">
            <div class="compatibility-header <?= $score_class ?>">
                <h2>Analyse de compatibilité</h2>
                <div class="score"><?= $score ?>%</div>
                <div class="niveau">
                    <?= $score >= 70 ? 'Excellente adéquation' : ($score >= 50 ? 'Bonne adéquation' : ($score >= 30 ? 'Adéquation moyenne' : 'Adéquation insuffisante')) ?>
                </div>
                <p class="resume"><?= htmlspecialchars($compatibilite['resume']) ?></p>
            </div>

            <div class="compatibility-content">
                <section class="compatibility-summary">
                    <h3>Synthèse de l'analyse</h3>
                    <p class="main-message"><?= $message_principal ?></p>

                    <div class="criteria-overview">
                        <div class="criteria-item <?= $etude_match ? 'criteria-match' : 'criteria-mismatch' ?>">
                            <h4><i class="fas fa-graduation-cap"></i> Formation</h4>
                             <p class="score-details">Score: <?= $compatibilite['analyse_detaillee']['formation']['score'] ?? 'N/A' ?>%</p>
                            <?php if ($etude_match): ?>
                            <p class="criteria-status success"><i class="fas fa-check-circle"></i> Niveau d'études
                                adéquat</p>
                            <?php else: ?>
                            <p class="criteria-status warning"><i class="fas fa-exclamation-triangle"></i> Niveau
                                d'études à améliorer</p>
                            <?php endif; ?>
                        </div>

                        <div class="criteria-item <?= $experience_match ? 'criteria-match' : 'criteria-mismatch' ?>">
                            <h4><i class="fas fa-briefcase"></i> Expérience</h4>
                             <p class="score-details">Score: <?= $compatibilite['analyse_detaillee']['experience']['score'] ?? 'N/A' ?>%</p>
                            <?php if ($experience_match): ?>
                            <p class="criteria-status success"><i class="fas fa-check-circle"></i> Expérience suffisante
                            </p>
                            <?php else: ?>
                            <p class="criteria-status warning"><i class="fas fa-exclamation-triangle"></i> Expérience à
                                développer</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <?php if (!empty($points_forts)): ?>
                <section class="compatibility-strengths">
                    <h3><i class="fas fa-star"></i> Vos Points Forts</h3>
                    <ul>
                        <?php foreach ($points_forts as $point_fort): ?>
                        <li><i class="fas fa-check-circle"></i> <?= htmlspecialchars($point_fort) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
                <?php endif; ?>

                <?php if (!empty($points_amelioration)): ?>
                <section class="compatibility-gaps">
                    <h3><i class="fas fa-exclamation-circle"></i> Axes d'Amélioration</h3>
                    <ul>
                        <?php foreach ($points_amelioration as $point_amelioration): ?>
                        <li><i class="fas fa-times-circle"></i> <?= htmlspecialchars($point_amelioration) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
                <?php endif; ?>

                <?php if (!empty($suggestions)): ?>
                <section class="compatibility-suggestions">
                    <h3><i class="fas fa-lightbulb"></i> Recommandations Personnalisées</h3>
                    <ul>
                        <?php foreach ($suggestions as $suggestion): ?>
                        <li><i class="fas fa-arrow-right"></i> <?= htmlspecialchars($suggestion) ?></li>
                <?php endforeach; ?>
                    </ul>
                </section>
                <?php endif; ?>

                <section class="compatibility-conclusion">
                    <h3><i class="fas fa-flag-checkered"></i> Conclusion</h3>
                    <p>
                        <?php if ($score >= 70): ?>
                        <i class="fas fa-thumbs-up"></i> Votre profil correspond parfaitement à cette offre. N'hésitez
                        pas à postuler !
                        <?php elseif ($score >= 50): ?>
                        <i class="fas fa-thumbs-up"></i> Votre profil est globalement adapté. Mettez en avant vos points
                        forts !
                        <?php elseif ($score >= 30): ?>
                        <i class="fas fa-info-circle"></i> Quelques points à améliorer avant de postuler.
                        <?php else: ?>
                        <i class="fas fa-info-circle"></i> Cette offre ne correspond pas à votre profil actuel.
                        <?php endif; ?>
                    </p>
                </section>
            </div>
        </div>
        <?php else: ?>
        <div class="compatibility-section">
            <h2><i class="fas fa-chart-bar"></i> Analyse de compatibilité</h2>
            <?php if (isset($_SESSION['users_id'])): ?>
            <p class="error-message"><i class="fas fa-exclamation-triangle"></i> Veuillez compléter votre profil pour
                voir l'analyse.</p>
            <?php else: ?>
            <p class="login-message"><i class="fas fa-user"></i> <a href="/connexion.php">Connectez-vous</a> pour voir
                votre compatibilité.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Détails de l'offre avec design amélioré -->
        <div class="job-details">
            <div class="job-header">
            <h1><?= htmlspecialchars($details_offre['titre'] ?? 'Titre non disponible') ?></h1>
                <div class="company-info">
                    <span><i class="fas fa-building"></i>
                        <?= htmlspecialchars($details_offre['entreprise'] ?? 'Non spécifiée') ?></span>
                    <span><i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($details_offre['localisation'] ?? 'Non spécifiée') ?></span>
                </div>
            </div>

            <div class="job-content">
                <div class="job-section">
                    <h3><i class="fas fa-info-circle"></i> À propos de l'entreprise</h3>
                    <p><?= htmlspecialchars($details_offre['description_entreprise'] ?? 'Non fournie') ?></p>
                    <p><i class="fas fa-globe"></i> <a
                    href="<?= htmlspecialchars($details_offre['site_internet'] ?? '#') ?>"
                            target="_blank"><?= htmlspecialchars($details_offre['site_internet'] ?? 'Non fourni') ?></a>
                    </p>
        </div>

                <div class="job-section">
                    <h3><i class="fas fa-tasks"></i> Description du poste</h3>
                    <div class="job-description"><?= $details_offre['description_poste'] ?? 'Non fournie' ?></div>
        </div>

                <div class="job-section">
                    <h3><i class="fas fa-user-tie"></i> Profil recherché</h3>
                    <div class="job-profile"><?= $details_offre['profil_recherche'] ?? 'Non fourni' ?></div>
        </div>

                <div class="job-details-grid">
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <span>Date de création :</span>
                        <strong><?= htmlspecialchars($details_offre['date_creation'] ?? 'Non spécifiée') ?></strong>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Niveau d'étude :</span>
                        <strong><?= htmlspecialchars($details_offre['niveau_etude'] ?? 'Non spécifié') ?></strong>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-briefcase"></i>
                        <span>Expérience :</span>
                        <strong><?= htmlspecialchars($details_offre['niveau_experience'] ?? 'Non spécifié') ?></strong>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-file-contract"></i>
                        <span>Type de contrat :</span>
                        <strong><?= htmlspecialchars($details_offre['type_contrat'] ?? 'Non spécifié') ?></strong>
                    </div>
        </div>

        <?php if (isset($_SESSION['users_id'])): ?>
                <div class="apply-section">
                    <a class="apply-button" href="<?= $details_offre['lien_offre'] ?>">
                        <i class="fas fa-paper-plane"></i> Postuler maintenant
                    </a>
                </div>
        <?php else: ?>
                <p class="login-required">
                    <i class="fas fa-lock"></i> Connectez-vous pour postuler à cette offre d'emploi
                </p>
        <?php endif; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <?php debug_log("Aucun détail d'offre trouvé"); ?>
    <p>Aucune offre trouvée.</p>
    <?php endif; ?>
</body>

</html>