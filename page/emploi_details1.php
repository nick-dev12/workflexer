<?php
session_start();
require_once '../conn/conn.php';
require_once '../entreprise/app/model/offre_emploi.php';
require_once '../controller/MatchingController.php';
require_once '../model/CandidatProfile.php';

// Inclure le contrôleur des utilisateurs AVANT tout output HTML
if (!function_exists('getTotalUsers')) {
    require_once '../controller/controller_users.php';
}

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
            background-color: #f0f8ff;
            border-left: 5px solid #0a74da;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 5px;
            font-size: 1.1em;
            line-height: 1.6;
            color: #333;
        }
        .intro-sentence p {
            margin: 0;
        }
        .intro-sentence strong {
            color: #0056b3;
            font-weight: 600;
        }
        .insufficient-data-message {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px 20px;
            border-radius: 8px;
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
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            border: 1px dashed #e0e0e0;
        }
        .loader {
            border: 6px solid #e0e0e0;
            border-radius: 50%;
            border-top: 6px solid #0a74da;
            width: 50px;
            height: 50px;
            animation: spin 1.5s linear infinite;
        }
        #analysis-placeholder p {
            margin-top: 20px;
            font-size: 1.1em;
            color: #555;
            font-weight: 500;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* === NOUVEAU DESIGN DU RAPPORT v3 === */
        .compatibility-report-v3 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-top: 20px;
        }

        .report-header-v3 {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
            color: #fff;
            gap: 15px;
        }
        .report-header-v3.excellent { background: linear-gradient(135deg, #28a745, #218838); }
        .report-header-v3.good { background: linear-gradient(135deg, #0a74da, #0056b3); }
        .report-header-v3.moderate { background: linear-gradient(135deg, #ffc107, #e0a800); color: #333; }
        .report-header-v3.low { background: linear-gradient(135deg, #dc3545, #c82333); }
        
        .report-header-v3.moderate .header-summary-v3 p,
        .report-header-v3.moderate .score-circle-v3 span {
            color: #555;
        }


        .score-circle-v3 {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 4px solid #fff;
            flex-shrink: 0;
        }
        .score-circle-v3 span {
            font-size: 0.9em;
            font-weight: 500;
            opacity: 0.8;
        }
        .score-circle-v3 .score-value-v3 {
            font-size: 2.2em;
            font-weight: 700;
            line-height: 1;
        }
        .score-circle-v3 .score-value-v3 span {
            font-size: 0.5em;
            opacity: 1;
            font-weight: 700;
        }

        .header-summary-v3 h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 700;
        }
        .header-summary-v3 p {
            margin: 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .report-body-v3 {
            padding: 20px 15px;
        }

        .report-section-v3 {
            margin-top: 25px;
        }
        .report-section-v3 h2 {
            font-size: 16px;
            color: #333;
            margin-bottom: 12px;
            padding-bottom: 8px;
        }
        .report-section-v3 h2 i {
            margin-right: 12px;
            color: #0a74da;
        }
        .report-section-v3 .section-description-v3 {
            font-size: 12px;
            margin-bottom: 15px;
        }

        .card-grid-v3 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .custom-card-v3 {
            padding: 15px;
            gap: 15px;
        }
        .card-icon-v3 {
            font-size: 1.8em;
            color: #0a74da;
        }
        .card-content-v3 h4 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 14px;
        }
        .card-content-v3 p {
            margin: 0;
            color: #555;
            font-size: 12px;
        }

        .skills-list-v3 {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .skills-list-v3 span {
            padding: 6px 12px;
            font-size: 12px;
        }

        .improvements-list-v3 {
            gap: 12px;
        }
        .improvement-item-v3 {
            padding: 15px;
        }
        .improvement-header-v3 {
            font-size: 14px;
        }
        .improvement-header-v3 i {
            color: #28a745;
        }
        .improvement-item-v3 .suggestion-v3 {
            margin: 10px 0 15px 28px;
            color: #555;
            font-style: italic;
            font-size: 12px;
        }
        .resources-v3 {
            margin-left: 28px;
            margin-top: 15px;
        }
        .resources-v3 h5 {
            margin: 0 0 10px 0;
            font-size: 13px;
            color: #444;
        }
        .resources-v3 ul {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }
        .resources-v3 li a {
            color: #0056b3;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 12px;
        }
        .resources-v3 li a:hover {
            color: #0a74da;
            text-decoration: underline;
        }

        /* === RESPONSIVE DESIGN === */
        @media (min-width: 500px) {
            .report-header-v3 {
                flex-direction: row;
                text-align: left;
                padding: 20px 25px;
            }
            .card-grid-v3 {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 15px;
            }
             .report-body-v3 {
                padding: 25px;
            }
        }

        @media (min-width: 768px) {
            .score-circle-v3 {
                width: 100px;
                height: 100px;
            }
            .score-circle-v3 .score-value-v3 {
                font-size: 2.4em;
            }
            .header-summary-v3 h2 {
                font-size: 22px;
            }
            .header-summary-v3 p,
            .report-section-v3 .section-description-v3,
            .card-content-v3 p,
            .improvement-item-v3 .suggestion-v3,
            .resources-v3 li a,
            .skills-list-v3 span {
                font-size: 14px;
            }
            .report-section-v3 h2 {
                font-size: 18px;
            }
             .card-content-v3 h4,
             .improvement-header-v3 {
                font-size: 15px;
            }
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
        const score_class = score >= 75 ? 'excellent' : (score >= 60 ? 'good' : (score >= 40 ? 'moderate' : 'low'));
        
        let score_text;
        if (score >= 75) {
            score_text = "Excellent profil !";
        } else if (score >= 60) {
            score_text = "Ça matche plutôt bien !";
        } else if (score >= 40) {
            score_text = "Il y a du potentiel !";
        } else {
            score_text = "Pour l'instant, c'est un peu juste...";
        }

        // 1. Points forts
        const pointsFortsHtml = data.points_forts && data.points_forts.length > 0 ? `
            <section class="report-section-v3 strengths">
                <h2><i class="fas fa-thumbs-up"></i> Tes points forts pour ce poste</h2>
                <div class="card-grid-v3">
                    ${data.points_forts.slice(0, 6).map(p => `
                        <div class="custom-card-v3">
                            <div class="card-icon-v3"><i class="fas ${getIconForCategory(p.categorie || 'general')}"></i></div>
                            <div class="card-content-v3">
                                <h4>${getCategoryLabel(p.categorie || 'general')}</h4>
                                <p>${escapeHtml(p.description)}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </section>` : '';

        // 2. Compétences recherchées
        const competencesManquantesHtml = data.competences_manquantes && data.competences_manquantes.length > 0 ? `
            <section class="report-section-v3 missing-skills">
                <h2><i class="fas fa-puzzle-piece"></i> Les compétences de l'offre</h2>
                <p class="section-description-v3">Voici les compétences clés pour ce job. Si tu les as, n'oublie pas de les ajouter à ton profil Work-Flexer pour booster ton score !</p>
                <div class="skills-list-v3">
                    ${data.competences_manquantes.map(skill => `<span>${escapeHtml(skill)}</span>`).join('')}
                </div>
            </section>` : '';

        // 3. Plan d'amélioration
        const pointsAmeliorationHtml = data.points_amelioration && data.points_amelioration.length > 0 ? `
            <section class="report-section-v3 improvements">
                <h2><i class="fas fa-rocket"></i> Ton plan pour devenir le candidat idéal</h2>
                <div class="improvements-list-v3">
                    ${data.points_amelioration.map(p => `
                        <div class="improvement-item-v3">
                            <div class="improvement-header-v3">
                                <i class="fas ${getIconForCategory(p.categorie || 'general')}"></i>
                                <p>${escapeHtml(p.description)}</p>
                            </div>
                            ${p.suggestion ? `<p class="suggestion-v3"><strong>Notre conseil :</strong> ${escapeHtml(p.suggestion)}</p>` : ''}
                            ${p.ressources && p.ressources.length > 0 ? `
                                <div class="resources-v3">
                                    <h5><i class="fas fa-book-open"></i> Quelques ressources pour t'aider :</h5>
                                    <ul>
                                        ${p.ressources.map(r => `<li><a href="${escapeHtml(r.url)}" target="_blank" rel="noopener">${escapeHtml(r.name)}</a></li>`).join('')}
                                    </ul>
                                </div>
                            ` : ''}
                        </div>
                    `).join('')}
                </div>
            </section>` : '';
        
        return `
            <div class="compatibility-report-v3">
                <div class="report-header-v3 ${score_class}">
                    <div class="score-circle-v3">
                        <span>Score</span>
                        <div class="score-value-v3">${score}<span>%</span></div>
                    </div>
                    <div class="header-summary-v3">
                        <h2>${score_text}</h2>
                        <p>${escapeHtml(data.resume)}</p>
                    </div>
                </div>
                <div class="report-body-v3">
                    ${pointsFortsHtml}
                    ${competencesManquantesHtml}
                    ${pointsAmeliorationHtml}
                </div>
            </div>
        `;
    }

    function getIconForCategory(category) {
        const icons = {
            'competence': 'fa-cogs',
            'formation': 'fa-graduation-cap',
            'experience': 'fa-briefcase',
            'langue': 'fa-language',
            'general': 'fa-star',
            'outils': 'fa-tools',
            'analyse_ia': 'fa-brain',
            'expertise_technique': 'fa-code-branch',
            'projets': 'fa-project-diagram'
        };
        return icons[category.toLowerCase()] || 'fa-star';
    }

    function getCategoryLabel(category) {
        const labels = {
            'competence': 'Compétences Techniques',
            'formation': 'Parcours Académique',
            'experience': 'Expérience Pro',
            'langue': 'Langues',
            'general': 'Atout Général',
            'outils': 'Outils Maîtrisés',
            'analyse_ia': 'Analyse IA',
            'expertise_technique': 'Expertise Technique',
            'projets': 'Projets Pertinents'
        };
        return labels[category.toLowerCase()] || 'Atout Général';
    }
    </script>
    <?php endif; ?>
</body>

</html>