<?php
session_start(); // Session start doit être au début
include __DIR__ . '/../entreprise/app/model/offre_emploi.php';
include __DIR__ . '/../conn/conn.php';
require_once __DIR__ . '/../model/CandidatProfile.php';

if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
    // On récupère les détails de l'offre pour l'affichage de base
    $details_offre2 = getDetails_emploi2($db, $offre_id);
    
    // On pré-charge le titre du candidat si connecté, pour la phrase d'intro
    $candidat_titre = null;
    if (isset($_SESSION['users_id'])) {
        $candidatProfile = new CandidatProfile($db, $_SESSION['users_id']);
        $candidat_titre = $candidatProfile->getTitre();
    }
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
    <link rel="stylesheet" href="../api1/css/compatibility.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Détails de l'offre d'emploi</title>
    <style>
        /* Styles repris de emploi_details1.php pour la cohérence */
        .intro-sentence{background-color:#eaf3ff;border-left:5px solid #0056b3;padding:15px 20px;margin-bottom:25px;border-radius:5px;font-size:1.1em;line-height:1.6}.intro-sentence p{margin:0}.intro-sentence strong{color:#004085}.insufficient-data-message{background-color:#fff3cd;color:#856404;padding:15px 20px;border-radius:5px;border:1px solid #ffeeba;margin:20px 0;text-align:center}.insufficient-data-message i{margin-right:10px}#analysis-placeholder{display:flex;flex-direction:column;justify-content:center;align-items:center;min-height:300px;background-color:#f9f9f9;border-radius:8px;padding:20px;text-align:center}.loader{border:8px solid #f3f3f3;border-radius:50%;border-top:8px solid #3498db;width:60px;height:60px;animation:spin 1.5s linear infinite}#analysis-placeholder p{margin-top:20px;font-size:1.1em;color:#555}@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
    </style>
</head>

<body>
    <?php include '../navbare.php'; ?>

    <?php if (isset($details_offre2)): ?>
        <div class="containerBox">
            <!-- Section de compatibilité asynchrone -->
            <?php if (isset($_SESSION['users_id'])): ?>
                <div id="analysis-placeholder">
                    <div class="loader"></div>
                    <p>Analyse de votre profil en cours...</p>
                </div>
                <div id="analysis-results" style="display:none;"></div>
            <?php else: ?>
                <div class="compatibility-section">
                    <h2><i class="fas fa-chart-bar"></i> Analyse de compatibilité</h2>
                    <p class="login-message"><i class="fas fa-user"></i> <a href="/connexion.php">Connectez-vous</a> pour voir votre compatibilité.</p>
                </div>
            <?php endif; ?>

            <!-- Détails de l'offre (structure améliorée) -->
            <div class="job-details">
                 <div class="job-header">
                    <h1><?= htmlspecialchars($details_offre2['titre'] ?? 'Titre non disponible') ?></h1>
                    <div class="company-info">
                        <span><i class="fas fa-building"></i> <?= htmlspecialchars($details_offre2['entreprise'] ?? 'Non spécifiée') ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($details_offre2['localisation'] ?? 'Non spécifiée') ?></span>
                    </div>
                </div>
                <div class="job-content">
                    <div class="job-section">
                        <h3><i class="fas fa-tasks"></i> Description du poste</h3>
                        <div class="job-description"><?= $details_offre2['description_poste'] ?? 'Non fournie' ?></div>
                    </div>
                    <div class="job-section">
                        <h3><i class="fas fa-user-tie"></i> Profil recherché</h3>
                        <div class="job-profile"><?= $details_offre2['profil_recherche'] ?? 'Non fourni' ?></div>
                    </div>
                     <?php if (isset($_SESSION['users_id'])): ?>
                        <div class="apply-section">
                            <a class="apply-button" href="<?= $details_offre2['lien_offre'] ?>">
                                <i class="fas fa-paper-plane"></i> Postuler maintenant
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>Aucune offre trouvée.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['users_id']) && isset($offre_id)): ?>
    <script>
        // Le script est presque identique à celui de emploi_details1.php, 
        // il pointe juste vers le nouvel endpoint AJAX.
        document.addEventListener('DOMContentLoaded', function() {
            const placeholder = document.getElementById('analysis-placeholder');
            const resultsContainer = document.getElementById('analysis-results');
            const offreId = <?= json_encode($offre_id) ?>;
            const candidatTitre = <?= json_encode($candidat_titre) ?>;
            const offreTitre = <?= json_encode($details_offre2['titre'] ?? '') ?>;

            fetch(`/ajax/get_compatibility_analysis_dakar.php?offre_id=${offreId}`)
                .then(response => response.ok ? response.json() : Promise.reject('Server error'))
                .then(data => {
                    placeholder.style.display = 'none';
                    resultsContainer.style.display = 'block';
                    let reportHtml = '';

                    if (data.error && data.error === 'insufficient_data') {
                        reportHtml = `<div class="insufficient-data-message"><i class="fas fa-info-circle"></i> ${escapeHtml(data.message)}</div>`;
                    } else if (data.score_global !== undefined) {
                        if (candidatTitre && offreTitre) {
                            reportHtml += `<div class="intro-sentence"><p>En tant que <strong>${escapeHtml(candidatTitre)}</strong>, vous postulez pour le poste de <strong>${escapeHtml(offreTitre)}</strong>. Voici une analyse de votre profil.</p></div>`;
                        }
                        reportHtml += buildCompatibilityReport(data);
                    } else {
                        reportHtml = `<div class="insufficient-data-message"><i class="fas fa-exclamation-triangle"></i> Une erreur est survenue lors de la génération de l'analyse.</div>`;
                    }
                    resultsContainer.innerHTML = reportHtml;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    placeholder.style.display = 'none';
                    resultsContainer.style.display = 'block';
                    resultsContainer.innerHTML = `<div class="insufficient-data-message"><i class="fas fa-exclamation-triangle"></i> Impossible de charger l'analyse.</div>`;
                });
        });

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return text.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'})[m]);
        }
        
        function buildCompatibilityReport(data) {
            // Cette fonction est une copie de celle dans emploi_details1.php
            // Elle construit le HTML du rapport d'analyse à partir des données JSON.
            const score = Math.round(data.score_global);
            const score_class = score >= 70 ? 'excellent' : (score >= 50 ? 'good' : (score >= 30 ? 'moderate' : 'low'));
            const score_text = score >= 70 ? 'Excellente' : (score >= 50 ? 'Bonne' : (score >= 30 ? 'Moyenne' : 'Insuffisante'));
            
            const pointsFortsHtml = data.points_forts && data.points_forts.length > 0 ? `
                <section class="compatibility-strengths">
                    <h3><i class="fas fa-star"></i> Vos Points Forts</h3>
                    <ul>${data.points_forts.map(p => `<li><i class="fas fa-check-circle"></i> ${escapeHtml(p.description)}</li>`).join('')}</ul>
                </section>` : '';

            const competencesManquantesHtml = data.competences_manquantes && data.competences_manquantes.length > 0 ? `
                <section class="compatibility-missing-skills">
                    <h3><i class="fas fa-puzzle-piece"></i> Compétences Clés Recherchées</h3>
                    <ul>${data.competences_manquantes.map(s => `<li><i class="fas fa-exclamation-triangle"></i> ${escapeHtml(s)}</li>`).join('')}</ul>
                </section>` : '';

            const pointsAmeliorationHtml = data.points_amelioration && data.points_amelioration.length > 0 ? `
                <section class="compatibility-gaps">
                    <h3><i class="fas fa-exclamation-circle"></i> Axes d'Amélioration</h3>
                    <ul>${data.points_amelioration.map(p => `<li><i class="fas fa-wrench"></i> ${escapeHtml(p.description)}</li>`).join('')}</ul>
                </section>` : '';

            return `
                <div class="compatibility-analysis">
                    <div class="compatibility-header ${score_class}">
                        <h2>Analyse de compatibilité</h2>
                        <div class="score">${score}%</div>
                        <div class="niveau">${score_text} adéquation</div>
                        <p class="resume">${escapeHtml(data.resume)}</p>
                    </div>
                    <div class="compatibility-content">
                        ${competencesManquantesHtml}
                        ${pointsFortsHtml}
                        ${pointsAmeliorationHtml}
                    </div>
                </div>`;
        }
    </script>
    <?php endif; ?>
</body>
</html>