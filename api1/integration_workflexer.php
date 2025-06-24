<?php
/**
 * Intégration de l'API de matching dans le système WorkFlexer
 * 
 * Ce fichier montre comment intégrer l'API de matching dans le système WorkFlexer
 * pour afficher les résultats d'analyse de compatibilité entre un candidat et une offre.
 */

// Inclusion des fichiers nécessaires pour WorkFlexer
// require_once 'conn/conn.php'; // Connexion à la base de données
// require_once 'model/users.php'; // Modèle utilisateur
// require_once 'model/offre_emploi.php'; // Modèle offre d'emploi

/**
 * Classe pour l'intégration de l'API de matching
 */
class MatchingIntegration
{
    private $api_url;
    private $api_version;

    /**
     * Constructeur
     * 
     * @param string $api_url URL de l'API
     * @param string $api_version Version de l'API à utiliser (v1 ou v2)
     */
    public function __construct($api_url = 'http://localhost:8000', $api_version = 'v2')
    {
        $this->api_url = $api_url;
        $this->api_version = $api_version;
    }

    /**
     * Convertit un profil utilisateur WorkFlexer en format compatible avec l'API
     * 
     * @param array $user_data Données utilisateur de WorkFlexer
     * @return array Profil formaté pour l'API
     */
    public function convertUserProfile($user_data)
    {
        // Conversion des formations
    $formations = [];
        foreach ($user_data['formations'] as $formation) {
            $formations[] = [
                'niveau' => $formation['niveau_etude'],
                'domaine' => $formation['domaine'],
                'etablissement' => $formation['etablissement'],
                'annee_obtention' => intval($formation['annee_obtention']),
                'description' => $formation['description'],
                'date_debut' => $formation['date_debut'],
                'date_fin' => $formation['date_fin'],
                'en_cours' => ($formation['en_cours'] == 1)
            ];
        }

        // Conversion des expériences
    $experiences = [];
        foreach ($user_data['experiences'] as $experience) {
            $experiences[] = [
                'titre_poste' => $experience['titre_poste'],
                'entreprise' => $experience['entreprise'],
                'duree_mois' => $this->calculateDurationInMonths($experience['date_debut'], $experience['date_fin']),
                'description' => $experience['description'],
                'competences' => explode(',', $experience['competences']),
                'secteur' => $experience['secteur'],
                'date_debut' => $experience['date_debut'],
                'date_fin' => $experience['date_fin'],
                'en_cours' => ($experience['en_cours'] == 1)
            ];
        }

        // Conversion des compétences
        $competences = [];
        foreach ($user_data['competences'] as $competence) {
            $competences[] = [
                'nom' => $competence['nom'],
                'niveau' => intval($competence['niveau']),
                'annees_experience' => floatval($competence['annees_experience'])
            ];
        }

        // Conversion des langues
    $langues = [];
        foreach ($user_data['langues'] as $langue) {
            $langues[] = [
                'nom' => $langue['nom'],
                'niveau' => $langue['niveau']
            ];
        }

        // Construction du profil complet
        return [
            'id' => intval($user_data['id']),
            'formations' => $formations,
            'experiences' => $experiences,
            'competences' => $competences,
            'langues' => $langues,
            'niveau_etude' => $user_data['niveau_etude'],
            'niveau_experience' => $user_data['niveau_experience']
        ];
    }

    /**
     * Convertit une offre d'emploi WorkFlexer en format compatible avec l'API
     * 
     * @param array $offre_data Données de l'offre d'emploi de WorkFlexer
     * @return array Offre formatée pour l'API
     */
    public function convertJobOffer($offre_data)
    {
        // Construction de l'exigence de formation
        $formation_requise = [
            'niveau_minimum' => $offre_data['niveau_etude_requis'],
            'domaines_acceptes' => explode(',', $offre_data['domaines_formation']),
            'formation_obligatoire' => ($offre_data['formation_obligatoire'] == 1)
        ];

        // Construction de l'exigence d'expérience
        $experience_requise = [
            'duree_minimum_mois' => intval($offre_data['experience_requise_mois']),
            'secteurs_acceptes' => explode(',', $offre_data['secteurs_acceptes']),
            'competences_requises' => explode(',', $offre_data['competences_requises']),
            'mots_cles_poste' => explode(',', $offre_data['mots_cles'])
        ];

        // Construction des compétences requises
        $competences_requises = [];
        foreach (explode(',', $offre_data['competences_detaillees']) as $comp) {
            $parts = explode(':', $comp);
            if (count($parts) == 2) {
                $competences_requises[] = [
                    'nom' => trim($parts[0]),
                    'niveau' => intval(trim($parts[1]))
                ];
            }
        }

        // Construction des langues requises
        $langues_requises = [];
        foreach (explode(',', $offre_data['langues_requises']) as $lang) {
            $parts = explode(':', $lang);
            if (count($parts) == 2) {
                $langues_requises[] = [
                    'nom' => trim($parts[0]),
                    'niveau' => trim($parts[1])
                ];
            }
        }

        // Construction de l'offre complète
        return [
            'id' => intval($offre_data['id']),
            'titre' => $offre_data['titre'],
            'description' => $offre_data['description'],
            'formation_requise' => $formation_requise,
            'experience_requise' => $experience_requise,
            'competences_requises' => $competences_requises,
            'langues_requises' => $langues_requises,
            'secteur' => $offre_data['secteur'],
            'type_contrat' => $offre_data['type_contrat'],
            'localisation' => $offre_data['localisation'],
            'salaire_min' => floatval($offre_data['salaire_min']),
            'salaire_max' => floatval($offre_data['salaire_max']),
            'teletravail' => ($offre_data['teletravail'] == 1),
            'horaires_flexibles' => ($offre_data['horaires_flexibles'] == 1)
        ];
    }

    /**
     * Calcule la durée en mois entre deux dates
     * 
     * @param string $date_debut Date de début (format YYYY-MM-DD)
     * @param string $date_fin Date de fin (format YYYY-MM-DD)
     * @return int Durée en mois
     */
    private function calculateDurationInMonths($date_debut, $date_fin)
    {
        if (empty($date_fin)) {
            $date_fin = date('Y-m-d'); // Date actuelle si en cours
        }

        $debut = new DateTime($date_debut);
        $fin = new DateTime($date_fin);
        $interval = $debut->diff($fin);

        return ($interval->y * 12) + $interval->m;
    }

    /**
     * Appelle l'API de matching pour analyser la compatibilité
     * 
     * @param array $user_profile Profil utilisateur formaté
     * @param array $job_offer Offre d'emploi formatée
     * @return array|false Résultat de l'analyse ou false en cas d'erreur
     */
    public function analyzeCompatibility($user_profile, $job_offer)
    {
        $endpoint = ($this->api_version == 'v2') ? '/analyze/v2' : '/analyze';
        $url = $this->api_url . $endpoint;

        $data = [
            'candidate' => $user_profile,
            'job_offer' => $job_offer,
            'options' => [
                'include_details' => true
            ]
        ];

        $result = $this->callAPI($url, $data);

        if ($result['success']) {
            return $result['response'];
    } else {
            error_log("Erreur lors de l'appel à l'API de matching: " . $result['error']);
            return false;
    }
}

/**
     * Appelle l'API via une requête HTTP POST
     * 
     * @param string $url URL de l'API
     * @param array $data Données à envoyer
     * @return array Résultat de l'appel
     */
    private function callAPI($url, $data)
    {
        $ch = curl_init($url);

        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
        if ($httpcode != 200) {
            return [
                'success' => false,
                'error' => "Erreur HTTP $httpcode",
                'response' => $result
            ];
        }

        return [
            'success' => true,
            'response' => json_decode($result, true)
        ];
    }

    /**
     * Génère une représentation HTML des résultats d'analyse
     * 
     * @param array $analysis_results Résultats de l'analyse
     * @return string HTML formaté
     */
    public function generateAnalysisHTML($analysis_results)
    {
        $html = '<div class="compatibility-analysis">';

        // Score global et résumé
        $score = $analysis_results['score_global'];
        $niveau = $analysis_results['niveau_adequation'];

        $score_class = '';
        if ($score >= 75)
            $score_class = 'excellent';
        elseif ($score >= 50)
            $score_class = 'good';
        elseif ($score >= 30)
            $score_class = 'moderate';
        else
            $score_class = 'low';

        $html .= '<div class="compatibility-header ' . $score_class . '">';
        $html .= '<h2>Compatibilité : <span class="score">' . $score . '%</span> <span class="niveau">(' . $niveau . ')</span></h2>';
        $html .= '<p class="resume">' . $analysis_results['resume'] . '</p>';
        $html .= '</div>';

        // Points forts
        if (!empty($analysis_results['points_forts'])) {
            $html .= '<div class="compatibility-strengths">';
            $html .= '<h3>Vos atouts pour ce poste</h3>';
            $html .= '<ul>';
            foreach ($analysis_results['points_forts'] as $point) {
                $importance = ($point['importance'] == 'important') ? ' <span class="important-tag">Important</span>' : '';
                $html .= '<li><span class="category-' . $point['categorie'] . '">' . ucfirst($point['categorie']) . '</span>: ' .
                    $point['description'] . $importance . '</li>';
            }
            $html .= '</ul>';
            $html .= '</div>';
        }

        // Points à améliorer
        if (!empty($analysis_results['points_amelioration'])) {
            $html .= '<div class="compatibility-improvements">';
            $html .= '<h3>Points à améliorer</h3>';
            $html .= '<ul>';
            foreach ($analysis_results['points_amelioration'] as $point) {
                $priorite = ($point['priorite'] == 'haute') ? ' <span class="high-priority-tag">Priorité haute</span>' : '';
                $html .= '<li><span class="category-' . $point['categorie'] . '">' . ucfirst($point['categorie']) . '</span>: ' .
                    $point['description'] . $priorite;

                if (!empty($point['suggestion'])) {
                    $html .= '<div class="suggestion">' . $point['suggestion'] . '</div>';
                }

                $html .= '</li>';
            }
            $html .= '</ul>';
            $html .= '</div>';
        }

        // Analyse détaillée par catégorie
        $html .= '<div class="compatibility-details">';
        $html .= '<h3>Analyse détaillée</h3>';

        $categories = [
            'formation' => 'Formation',
            'experience' => 'Expérience professionnelle',
            'competences' => 'Compétences techniques',
            'langues' => 'Langues'
        ];

        foreach ($categories as $key => $title) {
            $cat_data = $analysis_results['analyse_detaillee'][$key];
            $cat_score = $cat_data['score'];

            $cat_class = '';
            if ($cat_score >= 75)
                $cat_class = 'excellent';
            elseif ($cat_score >= 50)
                $cat_class = 'good';
            elseif ($cat_score >= 30)
                $cat_class = 'moderate';
            else
                $cat_class = 'low';

            $html .= '<div class="category-analysis ' . $cat_class . '">';
            $html .= '<h4>' . $title . ' <span class="score">' . $cat_score . '%</span></h4>';
            $html .= '<p class="resume">' . $cat_data['resume'] . '</p>';
            $html .= '</div>';
        }

        $html .= '</div>';

        // Suggestions d'amélioration
        if (!empty($analysis_results['suggestions'])) {
            $html .= '<div class="compatibility-suggestions">';
            $html .= '<h3>Suggestions pour améliorer votre profil</h3>';
            $html .= '<ul>';
            foreach ($analysis_results['suggestions'] as $suggestion) {
                $impact = ($suggestion['impact_estime'] == 'fort') ? ' <span class="high-impact-tag">Impact fort</span>' : '';
                $html .= '<li><span class="category-' . $suggestion['categorie'] . '">' . ucfirst($suggestion['categorie']) . '</span>: ' .
                    $suggestion['description'] . $impact . '</li>';
            }
            $html .= '</ul>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}

// Exemple d'utilisation
/*
// Récupération des données utilisateur et offre depuis la base de données
$user_id = $_GET['user_id'];
$offre_id = $_GET['offre_id'];

$user_data = getUserData($user_id);
$offre_data = getOffreData($offre_id);

// Instanciation de l'intégration
$matching = new MatchingIntegration();

// Conversion des données
$user_profile = $matching->convertUserProfile($user_data);
$job_offer = $matching->convertJobOffer($offre_data);

// Analyse de compatibilité
$results = $matching->analyzeCompatibility($user_profile, $job_offer);

if ($results) {
    // Affichage des résultats
    echo $matching->generateAnalysisHTML($results);
} else {
    echo '<div class="error">Impossible d\'analyser la compatibilité pour le moment.</div>';
}
*/
?> 