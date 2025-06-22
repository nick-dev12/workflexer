<?php
/**
 * Intégration de l'API de matching dans WorkFlexer
 * 
 * Ce fichier contient les fonctions nécessaires pour intégrer l'API de matching
 * dans les pages de détail des offres d'emploi de WorkFlexer.
 */

/**
 * Appelle l'API de matching pour analyser la compatibilité entre un candidat et une offre
 * 
 * @param array $candidateData Données du profil du candidat
 * @param array $jobOfferData Données de l'offre d'emploi
 * @return array|false Résultats de l'analyse ou false en cas d'erreur
 */
function analyserCompatibilite($candidateData, $jobOfferData) {
    // URL de l'API (à adapter selon votre configuration)
    $apiUrl = 'http://localhost:8000/analyser';
    
    // Préparation des données
    $postData = json_encode([
        'candidate' => $candidateData,
        'job_offer' => $jobOfferData
    ]);
    
    // Configuration de la requête cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ]);
    
    // Exécution de la requête
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Vérification de la réponse
    if ($httpCode == 200) {
        return json_decode($response, true);
    } else {
        error_log("Erreur API de matching: $httpCode - $response");
        return false;
    }
}

/**
 * Récupère les données du profil d'un candidat depuis la base de données
 * 
 * @param int $candidat_id ID du candidat
 * @param mysqli $conn Connexion à la base de données
 * @return array Données du profil du candidat
 */
function getProfilCandidat($candidat_id, $conn) {
    $candidateData = [];
    
    // Informations de base
    $query = "SELECT id, nom, prenom, email, telephone, titre FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $candidateData = $row;
    }
    
    // Compétences
    $query = "SELECT competence FROM competences_users WHERE id_users = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $competences = [];
    while ($row = $result->fetch_assoc()) {
        $competences[] = $row['competence'];
    }
    $candidateData['competences'] = $competences;
    
    // Formations
    $query = "SELECT diplome, etablissement, niveau, annee_debut, annee_fin, description 
              FROM formation_users WHERE id_users = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $formations = [];
    while ($row = $result->fetch_assoc()) {
        $formations[] = $row;
    }
    $candidateData['formations'] = $formations;
    
    // Expériences
    $query = "SELECT poste, entreprise, date_debut, date_fin, 
              TIMESTAMPDIFF(MONTH, date_debut, IFNULL(date_fin, CURRENT_DATE())) / 12 as duree,
              description 
              FROM experience_users WHERE id_users = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $experiences = [];
    while ($row = $result->fetch_assoc()) {
        $experiences[] = $row;
    }
    $candidateData['experiences'] = $experiences;
    
    // Langues
    $query = "SELECT langue as nom, niveau FROM langue_users WHERE id_users = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $langues = [];
    while ($row = $result->fetch_assoc()) {
        $langues[] = $row;
    }
    $candidateData['langues'] = $langues;
    
    // Outils
    $query = "SELECT outil FROM outil_users WHERE id_users = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $outils = [];
    while ($row = $result->fetch_assoc()) {
        $outils[] = $row['outil'];
    }
    $candidateData['outils'] = $outils;
    
    return $candidateData;
}

/**
 * Récupère les données d'une offre d'emploi depuis la base de données
 * 
 * @param int $offre_id ID de l'offre d'emploi
 * @param mysqli $conn Connexion à la base de données
 * @return array Données de l'offre d'emploi
 */
function getOffreEmploi($offre_id, $conn) {
    $jobOfferData = [];
    
    // Informations de base
    $query = "SELECT o.id, o.titre, e.nom_entreprise as entreprise, o.description 
              FROM offre_emploi o
              JOIN entreprise e ON o.id_entreprise = e.id_entreprise
              WHERE o.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offre_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $jobOfferData = $row;
    }
    
    // Compétences requises
    $query = "SELECT competence FROM competences_offre WHERE id_offre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offre_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $competences_requises = [];
    while ($row = $result->fetch_assoc()) {
        $competences_requises[] = $row['competence'];
    }
    $jobOfferData['competences_requises'] = $competences_requises;
    
    // Niveau d'études
    $query = "SELECT niveau_etudes FROM offre_emploi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offre_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $jobOfferData['niveau_etudes'] = $row['niveau_etudes'];
    }
    
    // Années d'expérience
    $query = "SELECT annees_experience FROM offre_emploi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offre_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $jobOfferData['annees_experience'] = floatval($row['annees_experience']);
    }
    
    // Langues requises
    $query = "SELECT langue FROM langues_offre WHERE id_offre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offre_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $langues_requises = [];
    while ($row = $result->fetch_assoc()) {
        $langues_requises[] = $row['langue'];
    }
    $jobOfferData['langues_requises'] = $langues_requises;
    
    // Outils requis
    $query = "SELECT outil FROM outils_offre WHERE id_offre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offre_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $outils_requis = [];
    while ($row = $result->fetch_assoc()) {
        $outils_requis[] = $row['outil'];
    }
    $jobOfferData['outils_requis'] = $outils_requis;
    
    return $jobOfferData;
}

/**
 * Affiche les résultats de l'analyse de compatibilité
 * 
 * @param array $resultats Résultats de l'analyse
 * @return string Code HTML pour afficher les résultats
 */
function afficherResultatsCompatibilite($resultats) {
    ob_start();
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
                    <ul>
                        <?php foreach ($resultats['strengths'] as $strength): ?>
                            <li><?php echo htmlspecialchars($strength); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="improvements">
                    <h4>Points à améliorer</h4>
                    <ul>
                        <?php foreach ($resultats['improvements'] as $improvement): ?>
                            <li><?php echo htmlspecialchars($improvement); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Fonction principale pour intégrer l'analyse de compatibilité dans une page
 * 
 * @param int $offre_id ID de l'offre d'emploi
 * @param int $candidat_id ID du candidat
 * @param mysqli $conn Connexion à la base de données
 * @return string|false Code HTML pour afficher les résultats ou false en cas d'erreur
 */
function obtenirAnalyseCompatibilite($offre_id, $candidat_id, $conn) {
    // Récupération des données
    $candidateData = getProfilCandidat($candidat_id, $conn);
    $jobOfferData = getOffreEmploi($offre_id, $conn);
    
    // Appel à l'API de matching
    $resultats = analyserCompatibilite($candidateData, $jobOfferData);
    
    // Affichage des résultats
    if ($resultats !== false) {
        return afficherResultatsCompatibilite($resultats);
    } else {
        return '<div class="error-message">Impossible d\'analyser la compatibilité avec cette offre pour le moment.</div>';
    }
}

/**
 * Vérifie si l'API de matching est accessible
 * 
 * @return bool True si l'API est accessible, false sinon
 */
function verifierAPIMatching() {
    $apiUrl = 'http://localhost:8000/health';
    
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ($httpCode == 200);
}

// Ajouter une feuille de style CSS pour les résultats de compatibilité
function ajouterStyleCompatibilite() {
    ?>
    <style>
        .compatibility-results {
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .compatibility-score {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .score-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-weight: bold;
            font-size: 24px;
            position: relative;
            background: conic-gradient(
                #4CAF50 calc(var(--score) * 1%),
                #f3f3f3 0
            );
        }
        
        .score-circle::before {
            content: '';
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
        }
        
        .score-value {
            position: relative;
            z-index: 2;
        }
        
        .compatibility-message {
            font-size: 18px;
            margin: 0;
        }
        
        .category-scores ul {
            list-style: none;
            padding: 0;
        }
        
        .category-scores li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .category-name {
            width: 100px;
            font-weight: bold;
        }
        
        .progress-bar {
            flex: 1;
            height: 10px;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin: 0 10px;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            background-color: #4CAF50;
        }
        
        .category-score {
            width: 50px;
            text-align: right;
        }
        
        .strengths-improvements {
            display: flex;
            margin-top: 20px;
        }
        
        .strengths, .improvements {
            flex: 1;
            padding: 15px;
        }
        
        .strengths {
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 8px;
            margin-right: 10px;
        }
        
        .improvements {
            background-color: rgba(255, 152, 0, 0.1);
            border-radius: 8px;
        }
        
        .error-message {
            padding: 15px;
            background-color: #ffebee;
            color: #c62828;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les cercles de score
            const scoreCircles = document.querySelectorAll('.score-circle');
            scoreCircles.forEach(circle => {
                const score = circle.getAttribute('data-score');
                circle.style.setProperty('--score', score);
            });
        });
    </script>
    <?php
}
?> 