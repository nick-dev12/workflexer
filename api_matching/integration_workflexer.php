<?php
/**
 * Intégration de l'API de matching dans WorkFlexer
 * 
 * Ce fichier montre comment intégrer l'API de matching dans le site WorkFlexer
 * pour analyser la correspondance entre un profil candidat et une offre d'emploi.
 */

// Inclure ce fichier dans les pages où vous souhaitez utiliser l'API de matching
// Par exemple, dans la page de détail d'une offre d'emploi

/**
 * Fonction qui analyse la correspondance entre un profil et une offre
 * 
 * @param int $profil_id ID du profil utilisateur
 * @param int $offre_id ID de l'offre d'emploi
 * @return array|false Résultat de l'analyse ou false en cas d'erreur
 */
function analyserMatchingProfilOffre($db, $profil_id, $offre_id) {
    // 1. Récupérer les données du profil
    $profil_data = preparerDonneesProfil($db, $profil_id);
    
    // 2. Récupérer les données de l'offre
    $offre_data = preparerDonneesOffre($db, $offre_id);
    
    // 3. Appeler l'API de matching
    return appelerAPIMatching($profil_data, $offre_data);
}

/**
 * Prépare les données du profil pour l'API
 * 
 * @param PDO $db Connexion à la base de données
 * @param int $profil_id ID du profil utilisateur
 * @return array Données formatées pour l'API
 */
function preparerDonneesProfil($db, $profil_id) {
    // Récupérer les formations
    $formations = getFormation($db, $profil_id);
    
    // Récupérer les expériences (à implémenter selon votre modèle de données)
    $experiences = getExperiences($db, $profil_id);
    
    // Récupérer les compétences (à implémenter selon votre modèle de données)
    $competences = getCompetences($db, $profil_id);
    
    // Récupérer les langues (à implémenter selon votre modèle de données)
    $langues = getLangues($db, $profil_id);
    
    // Formater les données pour l'API
    $formations_api = [];
    foreach ($formations as $formation) {
        $formations_api[] = [
            'filiere' => $formation['Filiere'],
            'niveau' => $formation['niveau'],
            'etablissement' => $formation['etablissement'],
            'mois_debut' => $formation['moisDebut'],
            'annee_debut' => $formation['anneeDebut'],
            'mois_fin' => $formation['moisFin'] ?? null,
            'annee_fin' => $formation['anneeFin'] ?? null,
            'en_cours' => ($formation['encours'] === 'En cours')
        ];
    }
    
    // Formater les expériences (à adapter selon votre structure)
    $experiences_api = [];
    foreach ($experiences as $experience) {
        $experiences_api[] = [
            'poste' => $experience['poste'],
            'entreprise' => $experience['entreprise'],
            'description' => $experience['description'],
            'mois_debut' => $experience['mois_debut'],
            'annee_debut' => $experience['annee_debut'],
            'mois_fin' => $experience['mois_fin'] ?? null,
            'annee_fin' => $experience['annee_fin'] ?? null,
            'en_cours' => ($experience['en_cours'] === 'En cours')
        ];
    }
    
    // Formater les compétences
    $competences_api = [];
    foreach ($competences as $competence) {
        $competences_api[] = [
            'nom' => $competence['nom'],
            'niveau' => $competence['niveau'] ?? null
        ];
    }
    
    // Formater les langues
    $langues_api = [];
    foreach ($langues as $langue) {
        $langues_api[] = [
            'nom' => $langue['nom'],
            'niveau' => $langue['niveau']
        ];
    }
    
    // Retourner les données formatées
    return [
        'id' => $profil_id,
        'formations' => $formations_api,
        'experiences' => $experiences_api,
        'competences' => $competences_api,
        'langues' => $langues_api
    ];
}

/**
 * Prépare les données de l'offre pour l'API
 * 
 * @param PDO $db Connexion à la base de données
 * @param int $offre_id ID de l'offre d'emploi
 * @return array Données formatées pour l'API
 */
function preparerDonneesOffre($db, $offre_id) {
    // Récupérer les détails de l'offre (à implémenter selon votre modèle de données)
    $offre = getOffreDetails($db, $offre_id);
    
    // Extraire les compétences requises (à adapter selon votre structure)
    $competences_requises = explode(',', $offre['competences_requises']);
    $competences_requises = array_map('trim', $competences_requises);
    
    // Extraire les langues requises (à adapter selon votre structure)
    $langues_requises = [];
    if (!empty($offre['langues_requises'])) {
        $langues = explode(',', $offre['langues_requises']);
        foreach ($langues as $langue) {
            // Format supposé: "Français (B2)"
            if (preg_match('/(.+)\s*\((.+)\)/', $langue, $matches)) {
                $langues_requises[] = [
                    'nom' => trim($matches[1]),
                    'niveau' => trim($matches[2])
                ];
            }
        }
    }
    
    // Retourner les données formatées
    return [
        'id' => $offre_id,
        'titre' => $offre['titre'],
        'description' => $offre['description'],
        'competences_requises' => $competences_requises,
        'niveau_etude_requis' => $offre['niveau_etude'] ?? null,
        'experience_requise' => intval($offre['experience_requise'] ?? 0),
        'langues_requises' => $langues_requises
    ];
}

/**
 * Appelle l'API de matching avec les données formatées
 * 
 * @param array $profil_data Données du profil
 * @param array $offre_data Données de l'offre
 * @return array|false Résultat de l'analyse ou false en cas d'erreur
 */
function appelerAPIMatching($profil_data, $offre_data) {
    // URL de l'API (à adapter selon votre configuration)
    $url = "http://localhost:8000/analyser";
    
    // Configuration de la requête cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'profil' => $profil_data,
        'offre' => $offre_data
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    
    // Exécution de la requête
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Vérification de la réponse
    if ($status == 200) {
        return json_decode($response, true);
    } else {
        error_log("Erreur lors de l'appel à l'API de matching: $status - $response");
        return false;
    }
}

/**
 * Affiche le résultat de l'analyse de matching
 * 
 * @param array $resultat Résultat de l'analyse
 * @return string HTML à afficher
 */
function afficherResultatMatching($resultat) {
    $html = '<div class="matching-result">';
    
    // Score global
    $html .= '<div class="matching-score">';
    $html .= '<h3>Score de correspondance</h3>';
    $html .= '<div class="score-circle" style="--score: ' . $resultat['pourcentage_global'] . '%;">';
    $html .= '<span>' . round($resultat['pourcentage_global']) . '%</span>';
    $html .= '</div>';
    $html .= '</div>';
    
    // Points forts
    $html .= '<div class="matching-strengths">';
    $html .= '<h3>Vos points forts</h3>';
    $html .= '<ul>';
    foreach ($resultat['points_forts'] as $point) {
        $html .= '<li>' . htmlspecialchars($point) . '</li>';
    }
    $html .= '</ul>';
    $html .= '</div>';
    
    // Points à améliorer
    $html .= '<div class="matching-improvements">';
    $html .= '<h3>Points à améliorer</h3>';
    $html .= '<ul>';
    foreach ($resultat['points_a_ameliorer'] as $point) {
        $html .= '<li>' . htmlspecialchars($point) . '</li>';
    }
    $html .= '</ul>';
    $html .= '</div>';
    
    $html .= '</div>';
    
    return $html;
}

// Exemple d'utilisation dans une page de détail d'offre
if (isset($_GET['id_offre']) && isset($_SESSION['users_id'])) {
    $offre_id = $_GET['id_offre'];
    $profil_id = $_SESSION['users_id'];
    
    // Analyser la correspondance
    $resultat_matching = analyserMatchingProfilOffre($db, $profil_id, $offre_id);
    
    // Si l'analyse a réussi, afficher le résultat
    if ($resultat_matching) {
        $html_resultat = afficherResultatMatching($resultat_matching);
        // Vous pouvez stocker ce HTML dans une variable pour l'afficher plus tard dans la page
    }
}
?>