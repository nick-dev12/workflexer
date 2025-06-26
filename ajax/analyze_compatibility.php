<?php
session_start();
require_once '../conn/conn.php';
require_once '../entreprise/app/model/offre_emploi.php';
require_once '../controller/MatchingController.php';
require_once '../model/CandidatProfile.php';

// --- Validation des paramètres ---
if (!isset($_GET['offer_id']) || !isset($_SESSION['users_id'])) {
    http_response_code(400);
    echo json_encode(['html' => '<p class="error-message">Paramètres manquants pour l\'analyse.</p>']);
    exit();
}

$offre_id = $_GET['offer_id'];
$users_id = $_SESSION['users_id'];

// --- Exécution de l'analyse ---
try {
    $details_offre = getDetails_emploi($db, $offre_id);
    
    $candidatProfile = new CandidatProfile($db, $users_id);
    $candidat_titre = $candidatProfile->getTitre();

    $matchingController = new MatchingController($db);
    $compatibilite = $matchingController->analyserCompatibilite($users_id, $offre_id);
    
    // --- Nettoyage et formatage des données (comme dans l'ancienne page) ---
    if ($compatibilite) {
        if (!isset($compatibilite['score_global']) && isset($compatibilite['global_score'])) {
            $compatibilite['score_global'] = $compatibilite['global_score'];
        }
        $mappings = [
            'resume' => 'synthesis', 'points_forts' => 'atouts_majeurs',
            'points_amelioration' => 'elements_manquants', 'suggestions' => 'suggestions_amelioration',
            'analyse_detaillee' => 'analyses'
        ];
        foreach ($mappings as $target => $source) {
            if (!isset($compatibilite[$target]) && isset($compatibilite[$source])) {
                $compatibilite[$target] = $compatibilite[$source];
            }
        }
        $arrayFields = ['points_forts', 'points_amelioration', 'suggestions'];
        foreach ($arrayFields as $field) {
            if (isset($compatibilite[$field]) && is_array($compatibilite[$field])) {
                $isSimpleArray = false;
                foreach ($compatibilite[$field] as $item) {
                    if (is_string($item)) { $isSimpleArray = true; break; }
                }
                if ($isSimpleArray) {
                    $formatted = [];
                    foreach ($compatibilite[$field] as $item) {
                        if (is_string($item)) { $formatted[] = ['description' => $item]; }
                    }
                    $compatibilite[$field] = $formatted;
                }
            }
        }
    }

} catch (Exception $e) {
    http_response_code(500);
    // Log l'erreur côté serveur
    error_log("Erreur AJAX analyse: " . $e->getMessage());
    // Message pour l'utilisateur
    echo json_encode(['html' => '<p class="error-message">Une erreur est survenue lors de l\'analyse.</p>']);
    exit();
}


// --- Capture du HTML du rapport ---
ob_start();

// Le code ci-dessous est une copie de la section d'affichage de emploi_details1.php
// Il utilise les variables $compatibilite, $details_offre, $candidat_titre
?>
<?php if (isset($compatibilite['error']) && $compatibilite['error'] === 'insufficient_data'): ?>
    <div class="insufficient-data-message">
        <i class="fas fa-info-circle"></i> <?= htmlspecialchars($compatibilite['message']) ?>
    </div>
<?php elseif (isset($compatibilite) && isset($compatibilite['score_global'])): ?>
<?php
        // Logique pour les couleurs et textes dynamiques
        $score = round($compatibilite['score_global']);
        $score_class = $score >= 70 ? 'excellent' : ($score >= 50 ? 'good' : ($score >= 30 ? 'moderate' : 'low'));

        if (isset($candidat_titre) && isset($details_offre['titre'])): ?>
            <div class="intro-sentence">
                <p>En tant que <strong><?= htmlspecialchars($candidat_titre) ?></strong>, vous postulez pour le poste de <strong><?= htmlspecialchars($details_offre['titre']) ?></strong>. Voici une analyse de l'adéquation de votre profil pour ce poste.</p>
            </div>
        <?php endif;
        $points_forts = []; if (isset($compatibilite['points_forts'])) { foreach ($compatibilite['points_forts'] as $point) { $points_forts[] = $point['description']; } }
        $points_amelioration = []; if (isset($compatibilite['points_amelioration'])) { foreach ($compatibilite['points_amelioration'] as $point) { $points_amelioration[] = $point['description']; } }
        $suggestions = []; if (isset($compatibilite['suggestions'])) { foreach ($compatibilite['suggestions'] as $suggestion) { $suggestions[] = $suggestion['description']; } }
        $etude_match = ($compatibilite['analyse_detaillee']['formation']['score'] ?? 0) > 50;
        $experience_match = ($compatibilite['analyse_detaillee']['experience']['score'] ?? 0) > 50;
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
            <div class="criteria-overview">
                <div class="criteria-item <?= $etude_match ? 'criteria-match' : 'criteria-mismatch' ?>">
                    <h4><i class="fas fa-graduation-cap"></i> Formation (Score: <?= $compatibilite['analyse_detaillee']['formation']['score'] ?? 'N/A' ?>%)</h4>
                </div>
                <div class="criteria-item <?= $experience_match ? 'criteria-match' : 'criteria-mismatch' ?>">
                    <h4><i class="fas fa-briefcase"></i> Expérience (Score: <?= $compatibilite['analyse_detaillee']['experience']['score'] ?? 'N/A' ?>%)</h4>
                </div>
            </div>
        </section>

        <?php if (!empty($compatibilite['competences_manquantes'])): ?>
        <section class="compatibility-missing-skills">
            <h3><i class="fas fa-puzzle-piece"></i> Compétences Clés Recherchées</h3>
            <ul>
                <?php foreach ($compatibilite['competences_manquantes'] as $skill): ?>
                <li><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($skill) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

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
                <li><i class="fas fa-wrench"></i> <?= htmlspecialchars($point_amelioration) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
    <p class="error-message">L'analyse de compatibilité n'a pas pu être effectuée. Veuillez compléter votre profil.</p>
<?php endif; ?>
<?php
$html_output = ob_get_clean();

// --- Envoi de la réponse JSON ---
header('Content-Type: application/json');
echo json_encode(['html' => $html_output]); 