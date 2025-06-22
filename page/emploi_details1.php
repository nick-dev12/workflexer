<?php
session_start();
require_once '../conn/conn.php';
require_once '../entreprise/app/model/offre_emploi.php';
require_once '../controller/MatchingController.php';

// Activation des logs d'erreur PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fonction de log personnalisée
function debug_log($message, $data = null) {
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
    <link rel="stylesheet" href="../css/compatibility_section.css">
    <title>Détails de l'offre d'emploi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/compatibility_section.js" defer></script>
</head>

<body>
<?php include '../navbare.php'; ?>

    <?php if (isset($details_offre)): ?>
        <div class="containerBox">
            <!-- Section de compatibilité -->
            <?php if (isset($_SESSION['users_id']) && $compatibilite && isset($compatibilite['global_score'])): ?>
                <?php
                    // Logique pour les couleurs et textes dynamiques
                    $score = round($compatibilite['global_score']);
                    $score_color_class = 'score-red';
                    if ($score >= 70) { $score_color_class = 'score-green'; } 
                    elseif ($score >= 50) { $score_color_class = 'score-orange'; }
                ?>
                <div class="compatibility-section new-design">
                    <!-- Section Synthèse -->
                    <div class="synthesis-section">
                        <div class="score-display <?= $score_color_class ?>"><?= $score ?>%</div>
                        <p class="synthesis-text"><?= htmlspecialchars($compatibilite['synthesis']) ?></p>
                    </div>

                    <!-- Grille des Cartes d'Analyse -->
                    <div class="analysis-grid">
                        <?php foreach ($compatibilite['analyses'] as $analysis): ?>
                            <div class="analysis-card">
                                <div class="card-header">
                                    <h3><?= htmlspecialchars($analysis['titre']) ?></h3>
                                    <span class="score"><?= htmlspecialchars($analysis['score']) ?>%</span>
                                </div>
                                <div class="card-body">
                                    <h4><span class="icon icon-plus">&#10004;</span>Points Forts</h4>
                                    <ul>
                                        <?php if (!empty($analysis['points_forts'])): ?>
                                            <?php foreach ($analysis['points_forts'] as $point): ?>
                                                <li><?= htmlspecialchars($point) ?></li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="no-items">Aucun point fort spécifique détecté.</li>
                                        <?php endif; ?>
                                    </ul>

                                    <h4 style="margin-top: 1.5rem;"><span class="icon icon-minus">&#9888;</span>Axes d'Amélioration</h4>
                                    <ul>
                                        <?php if (!empty($analysis['points_faibles'])): ?>
                                            <?php foreach ($analysis['points_faibles'] as $point): ?>
                                                <li><?= htmlspecialchars($point) ?></li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                             <li class="no-items">Aucun axe d'amélioration direct.</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                 <div class="compatibility-section">
                    <h2>Analyse de compatibilité</h2>
                     <?php if(isset($_SESSION['users_id'])): ?>
                        <p class="error-message">L'analyse de compatibilité n'a pas pu être effectuée. Veuillez compléter votre profil ou réessayer plus tard.</p>
                     <?php else: ?>
                        <p class="login-message"><a href="/connexion.php">Connectez-vous</a> pour voir votre compatibilité avec cette offre.</p>
                     <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Détails de l'offre existants -->
        <div class="box1">
            <h1><?= htmlspecialchars($details_offre['titre'] ?? 'Titre non disponible') ?></h1>
            <div><strong>Entreprise :</strong> <?= htmlspecialchars($details_offre['entreprise'] ?? 'Non spécifiée') ?></div>
            <p><strong>Localisation :</strong> <?= htmlspecialchars($details_offre['localisation'] ?? 'Non spécifiée') ?></p>
            <p><strong>Description de l'entreprise :</strong> <?= htmlspecialchars($details_offre['description_entreprise'] ?? 'Non fournie') ?></p>
            <p><strong>Site internet :</strong> <a href="<?= htmlspecialchars($details_offre['site_internet'] ?? '#') ?>" target="_blank"><?= htmlspecialchars($details_offre['site_internet'] ?? 'Non fourni') ?></a></p>
            <p><strong>Source :</strong> <?= htmlspecialchars($details_offre['source'] ?? 'Non spécifiée') ?></p>
            <p><strong>Date de publication :</strong> <?= htmlspecialchars($details_offre['date_publication'] ?? 'Non spécifiée') ?></p>
        </div>

        <div>
            <strong>Description du poste :</strong> <?= $details_offre['description_poste'] ?? 'Non fournie' ?>
        </div>
        <div>
            <strong>Profil recherché :</strong> <?= $details_offre['profil_recherche'] ?? 'Non fourni' ?>
        </div>

        <div class="box2">
            <p><strong>Date de création :</strong> <?= htmlspecialchars($details_offre['date_creation'] ?? 'Non spécifiée') ?></p>
            <p><strong>Niveau d'étude :</strong> <?= htmlspecialchars($details_offre['niveau_etude'] ?? 'Non spécifié') ?></p>
            <p><strong>Niveau d'expérience :</strong> <?= htmlspecialchars($details_offre['niveau_experience'] ?? 'Non spécifié') ?></p>
            <p><strong>Type de contrat :</strong> <?= htmlspecialchars($details_offre['type_contrat'] ?? 'Non spécifié') ?></p>
            <p><strong>Compétences :</strong> <?= htmlspecialchars($details_offre['competences'] ?? 'Non spécifiées') ?></p>
            <p><strong>Secteur d'activité :</strong> <?= htmlspecialchars($details_offre['secteur_activite'] ?? 'Non spécifié') ?></p>
        </div>

        <?php if (isset($_SESSION['users_id'])): ?>
                <p><a class="liens" href="<?= $details_offre['lien_offre'] ?>">Postuler</a></p>
        <?php else: ?>
            <p id="message">Vous devez vous connecter à un compte professionnel pour postuler à cette offre d'emploi.</p>
        <?php endif; ?>
        </div>
    <?php else: ?>
        <?php debug_log("Aucun détail d'offre trouvé"); ?>
        <p>Aucune offre trouvée.</p>
<?php endif; ?>

    <!-- Script de débogage -->
    <script>
    console.log('Chargement de la page de détails de l\'offre');
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM chargé');
        const scoreCircle = document.querySelector('.score-circle');
        if (scoreCircle) {
            console.log('Score circle trouvé avec data-score:', scoreCircle.dataset.score);
        } else {
            console.log('Score circle non trouvé');
        }
    });
    </script>
</body>

</html>