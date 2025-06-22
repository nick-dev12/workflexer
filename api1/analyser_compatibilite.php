<?php
/**
 * Point d'entrée AJAX pour l'analyse de compatibilité
 * 
 * Ce fichier traite les requêtes AJAX pour analyser la compatibilité
 * entre un candidat et une offre d'emploi.
 */

// Inclusion du fichier d'intégration
require_once 'integration_workflexer.php';

// Connexion à la base de données
require_once '../conn/conn.php';

// Vérification des paramètres
if (!isset($_POST['offre_id']) || !isset($_POST['candidat_id'])) {
    http_response_code(400);
    echo '<div class="error-message">Paramètres manquants</div>';
    exit;
}

// Récupération des paramètres
$offre_id = intval($_POST['offre_id']);
$candidat_id = intval($_POST['candidat_id']);

// Vérification de la validité des IDs
if ($offre_id <= 0 || $candidat_id <= 0) {
    http_response_code(400);
    echo '<div class="error-message">Identifiants invalides</div>';
    exit;
}

// Vérification que l'API est accessible
if (!verifierAPIMatching()) {
    http_response_code(503);
    echo '<div class="error-message">Le service d\'analyse de compatibilité n\'est pas disponible pour le moment.</div>';
    exit;
}

// Récupération des données
$candidateData = getProfilCandidat($candidat_id, $conn);
$jobOfferData = getOffreEmploi($offre_id, $conn);

// Appel à l'API de matching
$resultats = analyserCompatibilite($candidateData, $jobOfferData);

// Vérification du résultat
if ($resultats === false) {
    http_response_code(500);
    echo '<div class="error-message">Erreur lors de l\'analyse de compatibilité</div>';
    exit;
}

// Affichage des résultats
?>
<div class="compatibility-results">
    <h3>Compatibilité avec votre profil</h3>
    
    <div class="compatibility-score">
        <div class="score-circle" data-score="<?php echo $resultats['global_score']; ?>">
            <span class="score-value"><?php echo $resultats['global_score']; ?>%</span>
        </div>
        <p class="compatibility-message"><?php echo $resultats['compatibility_message']; ?></p>
    </div>
    
    <div class="compatibility-details">
        <div class="category-scores">
            <h4>Détails par catégorie</h4>
            <ul>
                <li>
                    <span class="category-name">Compétences</span>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $resultats['scores_by_category']['competences']; ?>%"></div>
                    </div>
                    <span class="category-score"><?php echo $resultats['scores_by_category']['competences']; ?>%</span>
                </li>
                <li>
                    <span class="category-name">Formation</span>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $resultats['scores_by_category']['formation']; ?>%"></div>
                    </div>
                    <span class="category-score"><?php echo $resultats['scores_by_category']['formation']; ?>%</span>
                </li>
                <li>
                    <span class="category-name">Expérience</span>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $resultats['scores_by_category']['experience']; ?>%"></div>
                    </div>
                    <span class="category-score"><?php echo $resultats['scores_by_category']['experience']; ?>%</span>
                </li>
                <li>
                    <span class="category-name">Langues</span>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $resultats['scores_by_category']['langues']; ?>%"></div>
                    </div>
                    <span class="category-score"><?php echo $resultats['scores_by_category']['langues']; ?>%</span>
                </li>
                <li>
                    <span class="category-name">Outils</span>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $resultats['scores_by_category']['outils']; ?>%"></div>
                    </div>
                    <span class="category-score"><?php echo $resultats['scores_by_category']['outils']; ?>%</span>
                </li>
            </ul>
        </div>
        
        <div class="strengths-improvements">
            <div class="strengths">
                <h4>Vos points forts</h4>
                <?php if (empty($resultats['strengths'])): ?>
                    <p>Aucun point fort identifié pour cette offre.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($resultats['strengths'] as $strength): ?>
                            <li><?php echo htmlspecialchars($strength); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <div class="improvements">
                <h4>Points à améliorer</h4>
                <?php if (empty($resultats['improvements'])): ?>
                    <p>Aucun point à améliorer identifié pour cette offre.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($resultats['improvements'] as $improvement): ?>
                            <li><?php echo htmlspecialchars($improvement); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialiser les animations
    initScoreCircles();
    animateProgressBars();
</script>