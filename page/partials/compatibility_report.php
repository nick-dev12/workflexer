<?php
/**
 * Partial view for displaying the compatibility analysis report.
 * Expects the following variables to be set:
 * - $compatibilite: The analysis result from the API.
 * - $details_offre: The job offer details.
 * - $candidat_titre: The candidate's professional title.
 */

if (isset($compatibilite['error']) && $compatibilite['error'] === 'insufficient_data'): ?>
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

        <?php if (!empty($compatibilite['competences_manquantes'])): ?>
        <section class="compatibility-missing-skills">
            <h3><i class="fas fa-puzzle-piece"></i> Compétences Clés Recherchées</h3>
            <p>Voici les compétences mentionnées dans l'offre que nous n'avons pas détectées dans votre profil. Pensez à les ajouter si vous les possédez.</p>
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