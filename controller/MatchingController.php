<?php
require_once(__DIR__ . '/../model/CandidatProfile.php');
require_once(__DIR__ . '/../model/OffreEmploi.php');

class MatchingController
{
    private $db;
    private $api_url = "http://localhost:8000/analyze/v2";
    private $debug = true;

    public function __construct($db)
    {
        $this->db = $db;
        $this->log("MatchingController initialisé");
    }

    private function log($message, $data = null)
    {
        if ($this->debug) {
            $log = date('Y-m-d H:i:s') . " - " . $message;
            if ($data !== null) {
                $log .= "\nData: " . print_r($data, true);
            }
            error_log($log . "\n", 3, __DIR__ . '/../logs/matching_controller.log');
        }
    }

    private function formatCompetence($competence)
    {
        // Si c'est une chaîne simple, la convertir en tableau associatif
        if (is_string($competence)) {
            $competence = ['competence' => $competence, 'mis_en_avant' => 0];
        }

        // Normalisation du nom de la compétence
        $nom = strtolower(trim($competence['competence']));

        // Définir un niveau par défaut basé sur mis_en_avant
        $niveau = isset($competence['mis_en_avant']) && $competence['mis_en_avant'] ? 4 : 3;

        return [
            'nom' => $nom,
            'niveau' => $niveau,
            'annees_experience' => 1 // Valeur par défaut
        ];
    }

    private function extractCompetencesFromText($text)
    {
        if (empty($text)) {
            return [];
        }

        $competences = [];

        // Liste des mots-clés techniques courants
        $keywords = [
            // Langages de programmation
            'php',
            'python',
            'javascript',
            'java',
            'c++',
            'ruby',
            'swift',
            // Frameworks
            'laravel',
            'symfony',
            'django',
            'flask',
            'react',
            'angular',
            'vue',
            // Base de données
            'mysql',
            'postgresql',
            'mongodb',
            'sql',
            'nosql',
            'oracle',
            // CMS
            'wordpress',
            'drupal',
            'joomla',
            // Outils
            'git',
            'docker',
            'kubernetes',
            'jenkins',
            'aws',
            'azure',
            // Méthodologies
            'agile',
            'scrum',
            'devops',
            // Autres compétences techniques
            'api',
            'rest',
            'soap',
            'html',
            'css',
            'sass',
            'less',
            'jquery',
            'bootstrap',
            'tailwind',
            'nodejs',
            'npm',
            'webpack'
        ];

        // Convertir le texte en minuscules pour la comparaison
        $text = strtolower($text);

        // Rechercher chaque mot-clé dans le texte
        foreach ($keywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                $competences[] = [
                    'nom' => $keyword,
                    'niveau' => 3,
                    'annees_experience' => 1
                ];
            }
        }

        return array_unique($competences, SORT_REGULAR);
    }

    private function getAllCompetences($candidatData)
    {
        $competences = [];

        // Compétences déclarées
        if (isset($candidatData['competences']) && is_array($candidatData['competences'])) {
            foreach ($candidatData['competences'] as $comp) {
                // Si c'est déjà un tableau associatif, l'utiliser tel quel
                if (is_array($comp) && isset($comp['competence'])) {
                    $competences[] = $this->formatCompetence($comp);
                }
                // Si c'est une chaîne, la convertir
                else if (is_string($comp)) {
                    $competences[] = $this->formatCompetence($comp);
                }
            }
        }

        // Extraire les compétences de la description
        if (!empty($candidatData['description'])) {
            $description_text = is_array($candidatData['description']) ?
                ($candidatData['description']['description'] ?? '') :
                $candidatData['description'];

            if (!empty($description_text)) {
                $competences = array_merge(
                    $competences,
                    $this->extractCompetencesFromText($description_text)
                );
            }
        }

        // Extraire les compétences des expériences
        if (isset($candidatData['experiences']) && is_array($candidatData['experiences'])) {
            foreach ($candidatData['experiences'] as $exp) {
                if (!empty($exp['description'])) {
                    $competences = array_merge(
                        $competences,
                        $this->extractCompetencesFromText($exp['description'])
                    );
                }
            }
        }

        // Extraire les compétences des formations
        if (isset($candidatData['formations']) && is_array($candidatData['formations'])) {
            foreach ($candidatData['formations'] as $formation) {
                if (!empty($formation['description'])) {
                    $competences = array_merge(
                        $competences,
                        $this->extractCompetencesFromText($formation['description'])
                    );
                }
            }
        }

        // Supprimer les doublons en conservant la version avec le niveau le plus élevé
        $uniqueCompetences = [];
        foreach ($competences as $comp) {
            $nom = $comp['nom'];
            if (!isset($uniqueCompetences[$nom]) || $uniqueCompetences[$nom]['niveau'] < $comp['niveau']) {
                $uniqueCompetences[$nom] = $comp;
            }
        }

        return array_values($uniqueCompetences);
    }

    private function formatFormation($formation)
    {
        return [
            "niveau" => $formation['niveau'],
            "domaine" => $formation['diplome'] ?? "Non spécifié",
            "etablissement" => $formation['etablissement'],
            "annee_obtention" => intval($formation['annee_fin']),
            "description" => $formation['description']
        ];
    }

    private function formatExperience($experience)
    {
        // Extraire les compétences du texte de description
        $competences = [];
        if (!empty($experience['description'])) {
            // Recherche des technologies mentionnées
            if (preg_match('/Technologies?\s*:([^<\n]+)/i', $experience['description'], $matches)) {
                $techs = explode(',', $matches[1]);
                $competences = array_map('trim', $techs);
            }
        }

        // Calculer la durée en mois
        $duree_mois = 0;
        if (isset($experience['duree']) && $experience['duree'] > 0) {
            $duree_mois = intval($experience['duree'] * 12);
        }

        return [
            "titre_poste" => $experience['poste'],
            "entreprise" => $experience['entreprise'],
            "duree_mois" => $duree_mois,
            "description" => strip_tags($experience['description']),
            "competences" => $competences,
            "secteur" => "Informatique" // Valeur par défaut
        ];
    }

    private function formatLangue($langue)
    {
        $niveaux_mapping = [
            "Débutant" => "A1",
            "Intermédiaire" => "B1",
            "Avancé" => "B2",
            "Courant" => "C1",
            "Natif" => "C2"
        ];

        return [
            "nom" => trim($langue['nom']),
            "niveau" => $niveaux_mapping[$langue['niveau']] ?? "B1",
            "certifications" => []
        ];
    }

    private function formatOffreEmploi($offre)
    {
        // Formater les compétences requises
        $competences_requises = [];

        // Ajouter les compétences explicitement listées
        if (!empty($offre['competences'])) {
            $competences_listees = array_map(function ($comp) {
                return [
                    "nom" => strtolower(trim($comp)),
                    "niveau" => 3,
                    "annees_experience" => 1
                ];
            }, explode(',', $offre['competences']));
            $competences_requises = array_merge($competences_requises, $competences_listees);
        }

        // Ajouter les compétences extraites de la description
        if (!empty($offre['competences_requises'])) {
            $competences_requises = array_merge($competences_requises, $offre['competences_requises']);
        }

        // Supprimer les doublons
        $competences_uniques = [];
        foreach ($competences_requises as $comp) {
            $nom = $comp['nom'];
            if (!isset($competences_uniques[$nom])) {
                $competences_uniques[$nom] = $comp;
            }
        }
        $competences_requises = array_values($competences_uniques);

        // Extraire le niveau d'étude requis et sa valeur numérique
        $niveau_etude = $offre['niveau_etude'] ?? "Non spécifié";
        $niveau_etude_valeur = 0;

        if (preg_match('/bac\s*\+\s*(\d+)/i', $niveau_etude, $matches)) {
            $niveau_etude_valeur = intval($matches[1]);
        } elseif (stripos($niveau_etude, 'bac') !== false) {
            $niveau_etude_valeur = 0;
        } elseif (stripos($niveau_etude, 'licence') !== false) {
            $niveau_etude_valeur = 3;
        } elseif (stripos($niveau_etude, 'master') !== false) {
            $niveau_etude_valeur = 5;
        } elseif (stripos($niveau_etude, 'doctorat') !== false) {
            $niveau_etude_valeur = 8;
        }

        // Exigences de formation
        $formation_requise = [
            "niveau_minimum" => $niveau_etude,
            "niveau_valeur" => $niveau_etude_valeur,
            "domaines_acceptes" => !empty($offre['secteur_activite']) ? array_map('trim', explode(',', $offre['secteur_activite'])) : [],
            "formation_obligatoire" => strpos(strtolower($offre['profil_recherche'] ?? ''), 'obligatoire') !== false
        ];

        // Exigences d'expérience
        $niveau_experience = $offre['niveau_experience'] ?? "Non spécifié";
        $duree_minimum_mois = 0;

        if (preg_match('/(\d+)\s*an/i', $niveau_experience, $matches)) {
            $duree_minimum_mois = intval($matches[1]) * 12;
        }

        $experience_requise = [
            "niveau" => $niveau_experience,
            "duree_minimum_mois" => $duree_minimum_mois,
            "annees" => $duree_minimum_mois / 12,
            "secteurs_acceptes" => !empty($offre['secteur_activite']) ? array_map('trim', explode(',', $offre['secteur_activite'])) : [],
            "competences_requises" => array_column($competences_requises, 'nom')
        ];

        return [
            "id" => intval($offre['offre_id']),
            "titre" => $offre['titre'],
            "description" => strip_tags($offre['description_poste']),
            "formation_requise" => $formation_requise,
            "experience_requise" => $experience_requise,
            "competences_requises" => $competences_requises,
            "langues_requises" => [],
            "secteur" => $offre['secteur_activite'],
            "type_contrat" => $offre['type_contrat'],
            "localisation" => $offre['localisation']
        ];
    }

    /**
     * Analyse la compatibilité entre un candidat et une offre
     * @param int $users_id
     * @param int $offre_id
     * @return array|null
     */
    public function analyserCompatibilite($users_id, $offre_id)
    {
        try {
            $this->log("Début de l'analyse de compatibilité", [
                'users_id' => $users_id,
                'offre_id' => $offre_id
            ]);

            // Récupération des données du candidat
            $candidatProfile = new CandidatProfile($this->db, $users_id);
            $candidatData = $candidatProfile->formatForMatching();
            if (!$candidatData) {
                $this->log("Erreur: Données du candidat non disponibles");
                throw new Exception("Impossible de récupérer les données du candidat");
            }

            // Récupération des niveaux d'études et d'expérience
            $niveaux = $candidatProfile->getNiveauEtudeExperience();
            $candidatData['niveau_etude'] = $niveaux['niveau_etude'];
            $candidatData['niveau_experience'] = $niveaux['niveau_experience'];

            // Enrichir les compétences avec l'extraction depuis les descriptions
            $candidatData['competences'] = $this->getAllCompetences($candidatData);

            // Formatage des données du candidat
            $formatted_candidat = [
                "id" => intval($candidatData['id']),
                "formations" => array_map([$this, 'formatFormation'], $candidatData['formations']),
                "experiences" => array_map([$this, 'formatExperience'], $candidatData['experiences']),
                "competences" => $candidatData['competences'],
                "langues" => array_map([$this, 'formatLangue'], $candidatData['langues']),
                "centres_interet" => [],
                "projets" => [],
                "disponibilite" => "Immédiate",
                "niveau_etude" => $candidatData['niveau_etude'],
                "niveau_experience" => $candidatData['niveau_experience']
            ];

            // Récupération des données de l'offre
            $offreEmploi = new OffreEmploi($this->db);
            $offreData = $offreEmploi->getOffreDetails($offre_id);
            if (!$offreData) {
                $this->log("Erreur: Données de l'offre non disponibles");
                throw new Exception("Impossible de récupérer les données de l'offre");
            }

            // Enrichir les compétences requises avec l'extraction depuis la description
            $competences_from_description = $this->extractCompetencesFromText($offreData['description_poste']);
            if (!isset($offreData['competences_requises'])) {
                $offreData['competences_requises'] = [];
            }
            $offreData['competences_requises'] = array_merge(
                $offreData['competences_requises'],
                $competences_from_description
            );

            // Formatage des données de l'offre
            $formatted_offre = $this->formatOffreEmploi($offreData);

            // Préparation des données pour l'API
            $requestData = [
                'candidate' => $formatted_candidat,
                'job_offer' => $formatted_offre
            ];

            $this->log("Données préparées pour l'API", $requestData);

            // Appel à l'API
            $response = $this->callMatchingAPI($requestData);

            if (!$response) {
                $this->log("Erreur: Réponse API nulle");
                throw new Exception("Erreur lors de l'appel à l'API de matching");
            }

            $this->log("Réponse de l'API reçue", $response);
            return $response;

        } catch (Exception $e) {
            $this->log("Exception dans analyserCompatibilite", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    private function getOfferData(string $offre_id): array
    {
        // ... (code existant)
    }

    private function getCandidateData(string $users_id): array
    {
        $profile = new CandidatProfile($this->db);
        $data = $profile->formatForMatching($users_id);

        // Ajout du niveau d'étude et d'expérience
        try {
            $stmt = $this->db->prepare("SELECT n_etude, n_experience FROM niveau_etude WHERE users_id = :users_id ORDER BY date DESC LIMIT 1");
            $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
            $stmt->execute();
            $niveaux = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($niveaux) {
                $data['niveau_etude'] = $niveaux['n_etude'];
                $data['niveau_experience'] = $niveaux['n_experience'];
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des niveaux: " . $e->getMessage());
        }

        return $data;
    }

    /**
     * Appelle l'API de matching
     * @param array $data
     * @return array|null
     */
    private function callMatchingAPI($data)
    {
        $this->log("Début de l'appel API");

        $ch = curl_init($this->api_url);
        if (!$ch) {
            $this->log("Erreur: Impossible d'initialiser CURL");
            return null;
        }

        $jsonData = json_encode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->log("Erreur d'encodage JSON", [
                'error' => json_last_error_msg(),
                'data' => $data
            ]);
            return null;
        }

        // Configuration de CURL avec logs détaillés
        $verbose = fopen('php://temp', 'w+');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_VERBOSE => true,
            CURLOPT_STDERR => $verbose,
            CURLOPT_TIMEOUT => 30
        ]);

        $this->log("Envoi de la requête à l'API", [
            'url' => $this->api_url,
            'data' => $jsonData
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        // Récupération des logs verbeux
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        $this->log("Logs CURL détaillés", $verboseLog);

        curl_close($ch);
        fclose($verbose);

        if ($error) {
            $this->log("Erreur CURL", [
                'error' => $error,
                'httpCode' => $httpCode
            ]);
            return null;
        }

        if ($httpCode !== 200) {
            $this->log("Erreur HTTP", [
                'httpCode' => $httpCode,
                'response' => $response
            ]);
            return null;
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->log("Erreur de décodage JSON", [
                'error' => json_last_error_msg(),
                'response' => $response
            ]);
            return null;
        }

        $this->log("Réponse API décodée avec succès", $decoded);

        // Adapter le format de la réponse pour la version v2 de l'API
        if (isset($decoded['version']) && $decoded['version'] === 'v2') {
            return [
                'score_global' => $decoded['score_global'],
                'niveau_adequation' => $decoded['niveau_adequation'],
                'resume' => $decoded['resume'],
                'points_forts' => $decoded['points_forts'],
                'points_amelioration' => $decoded['points_amelioration'],
                'analyse_detaillee' => $decoded['analyse_detaillee'],
                'suggestions' => $decoded['suggestions']
            ];
        }

        // Compatibilité avec l'ancien format si nécessaire
        return $decoded;
    }
}