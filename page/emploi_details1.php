<?php
session_start();
require_once '../conn/conn.php';
require_once '../entreprise/app/model/offre_emploi.php';
require_once '../controller/MatchingController.php';
require_once '../model/CandidatProfile.php';

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

        // Si l'utilisateur est connecté, on prépare les titres
        $candidat_titre = null;
        if (isset($_SESSION['users_id'])) {
             $candidatProfile = new CandidatProfile($db, $_SESSION['users_id']);
             $candidat_titre = $candidatProfile->getTitre();
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
    <style>
        .intro-sentence {
            background-color: #eaf3ff;
            border-left: 5px solid #0056b3;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 5px;
            font-size: 1.1em;
            line-height: 1.6;
        }
        .intro-sentence p {
            margin: 0;
        }
        .intro-sentence strong {
            color: #004085;
        }
        .insufficient-data-message {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px 20px;
            border-radius: 5px;
            border: 1px solid #ffeeba;
            margin: 20px 0;
            text-align: center;
        }
        .insufficient-data-message i {
            margin-right: 10px;
        }

        /* --- Animation de chargement --- */
        #analysis-placeholder {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 300px;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 60px;
            height: 60px;
            animation: spin 1.5s linear infinite;
        }
        #analysis-placeholder p {
            margin-top: 20px;
            font-size: 1.1em;
            color: #555;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <?php include '../navbare.php'; ?>

    <?php if (isset($details_offre)): ?>
    <div class="containerBox">
        <!-- Section de compatibilité -->
        <?php if (isset($_SESSION['users_id'])): ?>
            <div id="analysis-placeholder">
                <div class="loader"></div>
                <p>Analyse de votre profil en cours...</p>
            </div>
            <div id="analysis-results" style="display:none;"></div>
        <?php else: ?>
            <div class="compatibility-section">
                <h2><i class="fas fa-chart-bar"></i> Analyse de compatibilité</h2>
                <p class="login-message"><i class="fas fa-user"></i> <a href="/connexion.php">Connectez-vous</a> pour voir
                    votre compatibilité.</p>
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

    <?php if (isset($_SESSION['users_id'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const placeholder = document.getElementById('analysis-placeholder');
        const resultsContainer = document.getElementById('analysis-results');
        const offreId = <?= json_encode($offre_id ?? null) ?>;
        const candidatTitre = <?= json_encode($candidat_titre ?? null) ?>;
        const offreTitre = <?= json_encode($details_offre['titre'] ?? null) ?>;

        if (!offreId) return;

        fetch(`/ajax/get_compatibility_analysis.php?offre_id=${offreId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('La réponse du serveur n\'est pas OK');
                }
                return response.json();
            })
            .then(data => {
                placeholder.style.display = 'none';
                resultsContainer.style.display = 'block';
                
                let reportHtml = '';

                // Gérer le cas où l'offre est trop courte
                if (data.error && data.error === 'insufficient_data') {
                    reportHtml = `
                        <div class="insufficient-data-message">
                            <i class="fas fa-info-circle"></i> ${escapeHtml(data.message)}
                        </div>`;
                } else if (data.score_global !== undefined) {
                    // Phrase d'intro
                    if (candidatTitre && offreTitre) {
                        reportHtml += `
                        <div class="intro-sentence">
                            <p>En tant que <strong>${escapeHtml(candidatTitre)}</strong>, vous postulez pour le poste de <strong>${escapeHtml(offreTitre)}</strong>. Voici une analyse de l'adéquation de votre profil pour ce poste.</p>
                        </div>`;
                    }
                    
                    reportHtml += buildCompatibilityReport(data);
                } else {
                     reportHtml = `<div class="insufficient-data-message"><i class="fas fa-exclamation-triangle"></i> Une erreur est survenue lors de la génération de l'analyse.</div>`;
                }
                
                resultsContainer.innerHTML = reportHtml;
            })
            .catch(error => {
                console.error('Erreur lors de la récupération de l\'analyse:', error);
                placeholder.style.display = 'none';
                resultsContainer.style.display = 'block';
                resultsContainer.innerHTML = `<div class="insufficient-data-message"><i class="fas fa-exclamation-triangle"></i> Impossible de charger l'analyse de compatibilité pour le moment.</div>`;
            });
    });

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    function buildCompatibilityReport(data) {
        const score = Math.round(data.score_global);
        const score_class = score >= 70 ? 'excellent' : (score >= 50 ? 'good' : (score >= 30 ? 'moderate' : 'low'));
        const score_text = score >= 70 ? 'Excellente adéquation' : (score >= 50 ? 'Bonne adéquation' : (score >= 30 ? 'Adéquation moyenne' : 'Adéquation insuffisante'));
        const etude_match = (data.analyse_detaillee.formation.score ?? 0) > 50;
        const experience_match = (data.analyse_detaillee.experience.score ?? 0) > 50;
        
        // Points forts
        const pointsFortsHtml = data.points_forts && data.points_forts.length > 0 ? `
            <section class="compatibility-strengths">
                <h3><i class="fas fa-star"></i> Vos Points Forts</h3>
                <ul>
                    ${data.points_forts.map(p => `<li><i class="fas fa-check-circle"></i> ${escapeHtml(p.description)}</li>`).join('')}
                </ul>
            </section>` : '';

        // Compétences manquantes
        const competencesManquantesHtml = data.competences_manquantes && data.competences_manquantes.length > 0 ? `
            <section class="compatibility-missing-skills">
                <h3><i class="fas fa-puzzle-piece"></i> Compétences Clés Recherchées</h3>
                <p>Voici les compétences mentionnées dans l'offre que nous n'avons pas détectées dans votre profil. Pensez à les ajouter si vous les possédez.</p>
                <ul>
                    ${data.competences_manquantes.map(s => `<li><i class="fas fa-exclamation-triangle"></i> ${escapeHtml(s)}</li>`).join('')}
                </ul>
            </section>` : '';

        // Axes d'amélioration
        const pointsAmeliorationHtml = data.points_amelioration && data.points_amelioration.length > 0 ? `
            <section class="compatibility-gaps">
                <h3><i class="fas fa-exclamation-circle"></i> Axes d'Amélioration</h3>
                <ul>
                    ${data.points_amelioration.map(p => `<li><i class="fas fa-wrench"></i> ${escapeHtml(p.description)}</li>`).join('')}
                </ul>
            </section>` : '';
        
        return `
            <div class="compatibility-analysis">
                <div class="compatibility-header ${score_class}">
                    <h2>Analyse de compatibilité</h2>
                    <div class="score">${score}%</div>
                    <div class="niveau">${score_text}</div>
                    <p class="resume">${escapeHtml(data.resume)}</p>
                </div>
                <div class="compatibility-content">
                    <section class="compatibility-summary">
                        <h3>Synthèse de l'analyse</h3>
                        <div class="criteria-overview">
                             <div class="criteria-item ${etude_match ? 'criteria-match' : 'criteria-mismatch'}">
                                <h4><i class="fas fa-graduation-cap"></i> Formation</h4>
                                <p class="score-details">Score: ${data.analyse_detaillee.formation.score ?? 'N/A'}%</p>
                                <p class="criteria-status ${etude_match ? 'success' : 'warning'}"><i class="fas ${etude_match ? 'fa-check-circle' : 'fa-exclamation-triangle'}"></i> Niveau d'études ${etude_match ? 'adéquat' : 'à améliorer'}</p>
                            </div>
                            <div class="criteria-item ${experience_match ? 'criteria-match' : 'criteria-mismatch'}">
                                <h4><i class="fas fa-briefcase"></i> Expérience</h4>
                                <p class="score-details">Score: ${data.analyse_detaillee.experience.score ?? 'N/A'}%</p>
                                <p class="criteria-status ${experience_match ? 'success' : 'warning'}"><i class="fas ${experience_match ? 'fa-check-circle' : 'fa-exclamation-triangle'}"></i> Expérience ${experience_match ? 'suffisante' : 'à développer'}</p>
                            </div>
                        </div>
                    </section>
                    ${competencesManquantesHtml}
                    ${pointsFortsHtml}
                    ${pointsAmeliorationHtml}
                </div>
            </div>
        `;
    }
    </script>
    <?php endif; ?>
</body>

</html>