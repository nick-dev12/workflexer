<?php
/**
 * Exemple d'appel à l'API de matching WorkFlexer V2
 * 
 * Ce script montre comment:
 * 1. Récupérer les données complètes d'un profil candidat depuis la base de données
 * 2. Appeler l'API pour analyser la compatibilité avec une offre d'emploi
 * 3. Traiter et afficher les résultats de l'analyse avec le nouveau format de réponse
 */

// Inclure les fichiers nécessaires
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/CandidatProfile.php');
require_once(__DIR__ . '/../model/appelle_offre.php');

/**
 * Fonction principale pour effectuer une analyse de compatibilité
 * @param int $candidat_id ID du candidat
 * @param int $offre_id ID de l'offre d'emploi
 * @return array Résultats de l'analyse
 */
function analyserCompatibilite($candidat_id, $offre_id) {
    global $db;
    
    // 1. Récupérer les données du candidat et de l'offre
    $candidatProfile = new CandidatProfile($db, $candidat_id);
    $candidatData = $candidatProfile->formatForMatching();
    
    // 2. Récupérer les projets du candidat (nouvelle donnée)
    $projets = getProjetsCandidats($db, $candidat_id);
    if ($projets) {
        $candidatData['projets'] = $projets;
    }
    
    // 3. Récupérer l'offre d'emploi
    $offreData = getOffreById($db, $offre_id);
    if (!$offreData) {
        return ['error' => 'Offre introuvable'];
    }
    
    // 4. Formater les données pour l'API
    $offreFormatted = formatOffreForApi($db, $offreData);
    
    // 5. Appeler l'API V2
    $result = callMatchingApi($candidatData, $offreFormatted);
    
    return $result;
}

/**
 * Récupère les projets du candidat depuis la BDD
 * @param PDO $db Connection à la base de données
 * @param int $users_id ID de l'utilisateur
 * @return array Liste des projets
 */
function getProjetsCandidats($db, $users_id) {
    $sql = "SELECT id, users_id, titre, liens, projetdescription as description, images, date 
            FROM projet_users 
            WHERE users_id = :users_id";
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':users_id', $users_id);
    $stmt->execute();
    
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!$projets) {
        return [];
    }
    
    // Formater les projets pour l'API
    return array_map(function($projet) {
        return [
            'id' => $projet['id'],
            'users_id' => $projet['users_id'],
            'titre' => $projet['titre'],
            'liens' => $projet['liens'],
            'description' => $projet['description'],
            'images' => $projet['images'],
            'date' => $projet['date'],
            'technologies' => [], // À remplir si disponible
            'competences_developpees' => []  // À remplir si disponible
        ];
    }, $projets);
}

/**
 * Récupère une offre d'emploi par son ID
 * @param PDO $db Connection à la base de données
 * @param int $id ID de l'offre
 * @return array|false Données de l'offre ou false si non trouvée
 */
function getOffreById($db, $id) {
    $sql = "SELECT * FROM appel_offre WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Formate les données de l'offre pour l'API
 * @param PDO $db Connection à la base de données
 * @param array $offre Données brutes de l'offre
 * @return array Données formatées
 */
function formatOffreForApi($db, $offre) {
    // Exemple de formatage (à adapter selon votre structure)
    return [
        'id' => $offre['id'],
        'titre' => $offre['nom_offre'],
        'description' => $offre['description'],
        'secteur' => $offre['categorie'],
        'type_contrat' => $offre['type_contrat'],
        'localisation' => $offre['ville'],
        'formation_requise' => [
            'niveau_minimum' => $offre['n_etude'] ?? 'Non spécifié',
            'niveau_valeur' => intval($offre['valeur_etude'] ?? 0),
            'domaines_acceptes' => [$offre['categorie']],
            'formation_obligatoire' => ($offre['n_etude'] && $offre['n_etude'] !== 'Non spécifié')
        ],
        'experience_requise' => [
            'niveau' => $offre['n_experience'] ?? 'Non spécifié',
            'duree_minimum_mois' => intval($offre['valeur_experience'] ?? 0) * 12,
            'secteurs_acceptes' => [$offre['categorie']]
        ],
        'competences_requises' => getCompetencesRequises($db, $offre['id']),
        'langues_requises' => getLanguesRequises($db, $offre['id'])
    ];
}

/**
 * Récupère les compétences requises pour une offre
 * @param PDO $db Connection à la base de données
 * @param int $offre_id ID de l'offre
 * @return array Liste des compétences
 */
function getCompetencesRequises($db, $offre_id) {
    // À implémenter selon votre structure de base de données
    return []; // Placeholder
}

/**
 * Récupère les langues requises pour une offre
 * @param PDO $db Connection à la base de données
 * @param int $offre_id ID de l'offre
 * @return array Liste des langues
 */
function getLanguesRequises($db, $offre_id) {
    // À implémenter selon votre structure de base de données
    return []; // Placeholder
}

/**
 * Appelle l'API de matching
 * @param array $candidat Données du candidat
 * @param array $offre Données de l'offre
 * @return array Résultats de l'analyse
 */
function callMatchingApi($candidat, $offre) {
    $apiUrl = 'http://localhost:8000/analyze/v2'; // URL de l'API V2 (mise à jour du port)
    
    $data = [
        'candidate' => $candidat,
        'job_offer' => $offre
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);
    
    if ($result === FALSE) {
        return ['error' => 'Erreur lors de l\'appel à l\'API'];
    }
    
    return json_decode($result, true);
}

/**
 * Affiche les résultats d'analyse de compatibilité
 * @param array $resultat Résultats de l'analyse
 */
function afficherResultats($resultat) {
    if (isset($resultat['error'])) {
        echo "<div class='alert alert-danger'>{$resultat['error']}</div>";
        return;
    }
    
    // Afficher le score global et le résumé
    echo "<div class='compatibility-header'>";
    echo "<h2>Compatibilité: <span class='score'>{$resultat['score_global']}%</span> <span class='level'>({$resultat['niveau_adequation']})</span></h2>";
    echo "<p class='summary'>{$resultat['resume']}</p>";
    echo "</div>";
    
    // Afficher les points forts
    if (!empty($resultat['points_forts'])) {
        echo "<div class='strengths-section'>";
        echo "<h3>Points forts</h3>";
    echo "<ul>";
        foreach ($resultat['points_forts'] as $point) {
            $categorie = ucfirst($point['categorie']);
            echo "<li><span class='category {$point['categorie']}'>{$categorie}</span> {$point['description']}</li>";
    }
    echo "</ul>";
        echo "</div>";
    }
    
    // Afficher les points d'amélioration
    if (!empty($resultat['points_amelioration'])) {
        echo "<div class='improvements-section'>";
        echo "<h3>Points d'amélioration</h3>";
    echo "<ul>";
        foreach ($resultat['points_amelioration'] as $point) {
            $categorie = ucfirst($point['categorie']);
            $priorite = $point['priorite'] ?? 'normale';
            echo "<li class='priority-{$priorite}'><span class='category {$point['categorie']}'>{$categorie}</span> {$point['description']}</li>";
    }
    echo "</ul>";
        echo "</div>";
    }
    
    // Afficher l'analyse détaillée par catégorie
    if (isset($resultat['analyse_detaillee'])) {
        echo "<div class='detailed-analysis'>";
        echo "<h3>Analyse détaillée</h3>";
        
        foreach ($resultat['analyse_detaillee'] as $categorie => $analyse) {
            $nomCategorie = ucfirst($categorie);
            $scoreClass = ($analyse['score'] >= 70) ? 'high' : (($analyse['score'] >= 40) ? 'medium' : 'low');
            
            echo "<div class='category-analysis {$categorie}'>";
            echo "<h4>{$nomCategorie} <span class='score {$scoreClass}'>{$analyse['score']}%</span></h4>";
            echo "<p class='resume'>{$analyse['resume']}</p>";
            
            // Points forts de la catégorie
            if (!empty($analyse['points_forts'])) {
                echo "<div class='category-strengths'>";
                echo "<h5>Points forts</h5>";
                echo "<ul>";
                foreach ($analyse['points_forts'] as $point) {
                    echo "<li>{$point}</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            
            // Points d'amélioration de la catégorie
            if (!empty($analyse['points_amelioration'])) {
                echo "<div class='category-improvements'>";
                echo "<h5>Points d'amélioration</h5>";
                echo "<ul>";
                foreach ($analyse['points_amelioration'] as $point) {
                    echo "<li>{$point}</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            
            // Correspondances détaillées (pour les compétences)
            if (!empty($analyse['elements_correspondants'])) {
                echo "<div class='correspondances'>";
                echo "<h5>Correspondances</h5>";
                echo "<ul>";
                foreach ($analyse['elements_correspondants'] as $corresp) {
                    $score = round($corresp['niveau_correspondance'] * 100);
                    echo "<li>{$corresp['element_profil']} → {$corresp['element_offre']} <span class='match-score'>({$score}%)</span></li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            
            // Éléments manquants
            if (!empty($analyse['elements_manquants'])) {
                echo "<div class='missing-elements'>";
                echo "<h5>Éléments manquants</h5>";
    echo "<ul>";
                foreach ($analyse['elements_manquants'] as $manquant) {
                    echo "<li class='importance-{$manquant['importance']}'>{$manquant['description']}</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            
            echo "</div>"; // Fin category-analysis
        }
        
        echo "</div>"; // Fin detailed-analysis
    }
    
    // Afficher les suggestions
    if (!empty($resultat['suggestions'])) {
        echo "<div class='suggestions-section'>";
        echo "<h3>Suggestions d'amélioration</h3>";
        echo "<ul>";
        foreach ($resultat['suggestions'] as $suggestion) {
            $categorie = ucfirst($suggestion['categorie']);
            $priorite = $suggestion['priorite'] ?? 'normale';
            echo "<li class='priority-{$priorite}'><span class='category'>{$categorie}</span> {$suggestion['description']}</li>";
    }
    echo "</ul>";
        echo "</div>";
    }
}

// Exemple d'utilisation
$candidat_id = 10; // ID du candidat à analyser
$offre_id = 5;    // ID de l'offre à comparer

// Si appel depuis un formulaire
if (isset($_POST['analyze'])) {
    $candidat_id = intval($_POST['candidat_id']);
    $offre_id = intval($_POST['offre_id']);
}

// CSS pour l'affichage des résultats
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse de compatibilité - WorkFlexer</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 1200px; margin: 0 auto; padding: 20px; }
        h2 { color: #2c3e50; margin-bottom: 20px; }
        h3 { color: #3498db; margin-top: 30px; }
        h4 { color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .score { font-weight: bold; }
        .level { font-style: italic; color: #7f8c8d; }
        .high { color: #27ae60; }
        .medium { color: #f39c12; }
        .low { color: #e74c3c; }
        .category { font-weight: bold; margin-right: 5px; padding: 2px 6px; border-radius: 3px; font-size: 0.9em; }
        .formation { background-color: #3498db; color: white; }
        .experience { background-color: #2ecc71; color: white; }
        .competences, .competence { background-color: #e74c3c; color: white; }
        .langues, .langue { background-color: #f39c12; color: white; }
        .projets { background-color: #9b59b6; color: white; }
        ul { padding-left: 20px; }
        li { margin-bottom: 8px; }
        .priority-haute { font-weight: bold; color: #e74c3c; }
        .importance-critique { font-weight: bold; color: #e74c3c; }
        .match-score { color: #7f8c8d; font-size: 0.9em; }
        .category-analysis { background-color: #f9f9f9; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .compatibility-header { background-color: #ecf0f1; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .summary { font-size: 1.1em; line-height: 1.6; }
        .resume { font-style: italic; color: #7f8c8d; }
        form { margin-bottom: 30px; background-color: #f5f5f5; padding: 20px; border-radius: 5px; }
        input, select, button { padding: 8px 12px; margin-right: 10px; }
        button { background-color: #3498db; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #2980b9; }
    </style>
</head>
<body>
    <h1>Analyse de compatibilité - WorkFlexer</h1>
    
    <form method="post" action="">
        <h3>Sélectionner un candidat et une offre</h3>
        <div>
            <label for="candidat_id">Candidat:</label>
            <select name="candidat_id" id="candidat_id" required>
                <?php
                // À compléter avec la liste des candidats depuis la BDD
                echo "<option value='{$candidat_id}'>Candidat #{$candidat_id}</option>";
                ?>
            </select>
            
            <label for="offre_id">Offre d'emploi:</label>
            <select name="offre_id" id="offre_id" required>
                <?php
                // À compléter avec la liste des offres depuis la BDD
                echo "<option value='{$offre_id}'>Offre #{$offre_id}</option>";
                ?>
            </select>
            
            <button type="submit" name="analyze">Analyser la compatibilité</button>
        </div>
    </form>

    <div class="results">
        <?php
        if (isset($_POST['analyze']) || isset($candidat_id)) {
            $resultats = analyserCompatibilite($candidat_id, $offre_id);
            afficherResultats($resultats);
        }
        ?>
    </div>
</body>
</html>
