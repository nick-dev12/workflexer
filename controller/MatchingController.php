<?php
require_once(__DIR__ . '/../model/CandidatProfile.php');
require_once(__DIR__ . '/../model/OffreEmploi.php');

class MatchingController
{
    private $db;
    private $api_url = "http://localhost:8000/analyze/hybrid-v2";
    private $debug = true;

    // Dictionnaires de normalisation avancés
    private $skill_normalization = [
        'js' => 'javascript',
        'py' => 'python',
        'css3' => 'css',
        'html5' => 'html',
        'nodejs' => 'node.js',
        'reactjs' => 'react',
        'vuejs' => 'vue.js',
        'angularjs' => 'angular',
        'mysql' => 'mysql',
        'postgresql' => 'postgresql',
        'dotnet' => '.net',
        'csharp' => 'c#',
        'cplusplus' => 'c++',
        'photoshop' => 'adobe photoshop',
        'illustrator' => 'adobe illustrator',
    ];

    private $technology_clusters = [
        'frontend' => ['html', 'css', 'javascript', 'react', 'vue.js', 'angular', 'typescript', 'sass', 'bootstrap'],
        'backend' => ['php', 'python', 'java', 'node.js', 'ruby', 'go', 'c#', '.net', 'spring', 'django', 'laravel', 'symfony'],
        'database' => ['mysql', 'postgresql', 'mongodb', 'redis', 'elasticsearch', 'oracle', 'sql server'],
        'mobile' => ['android', 'ios', 'react native', 'flutter', 'ionic', 'swift', 'kotlin'],
        'devops' => ['docker', 'kubernetes', 'jenkins', 'git', 'aws', 'azure', 'google cloud', 'terraform'],
        'design' => ['photoshop', 'illustrator', 'figma', 'sketch', 'adobe xd', 'indesign'],
        'cms' => ['wordpress', 'drupal', 'joomla', 'shopify', 'magento']
    ];

    public function __construct($db)
    {
        $this->db = $db;
        $this->log("MatchingController hybride avancé initialisé");
    }

    private function log($message, $data = null)
    {
        if ($this->debug) {
            $log = date('Y-m-d H:i:s') . " - " . $message;
            if ($data !== null) {
                $log .= "\nData: " . print_r($data, true);
            }
            error_log($log . "\n", 3, __DIR__ . '/../logs/matching_debug.log');
        }
    }

    /**
     * Normalise le nom d'une compétence en utilisant les dictionnaires de correspondance
     */
    private function normalizeSkillName($skill)
    {
        $skill_lower = strtolower(trim($skill));
        return $this->skill_normalization[$skill_lower] ?? $skill_lower;
    }

    /**
     * Extraction avancée des entités nommées avec patterns regex sophistiqués
     */
    private function extractEntitiesAdvanced($text)
    {
        if (empty($text)) {
            return [];
        }

        $entities = [];
        $text_lower = strtolower($text);

        // Patterns pour les compétences techniques
        $tech_patterns = [
            // Langages de programmation
            '/\b(?:HTML5?|CSS3?|JavaScript|TypeScript|React|Vue\.?js|Angular|Node\.?js)\b/i',
            '/\b(?:Python|Java|PHP|Ruby|Go|Rust|Swift|Kotlin|C\+\+|C#|\.NET)\b/i',
            // Base de données
            '/\b(?:MySQL|PostgreSQL|MongoDB|Redis|Oracle|SQL Server|SQLite)\b/i',
            // DevOps et Cloud
            '/\b(?:Docker|Kubernetes|Jenkins|Git|AWS|Azure|Google Cloud)\b/i',
            // Design
            '/\b(?:Photoshop|Illustrator|Figma|Sketch|Adobe XD|InDesign)\b/i',
            // CMS
            '/\b(?:WordPress|Drupal|Shopify|Magento|PrestaShop)\b/i',
        ];

        foreach ($tech_patterns as $pattern) {
            preg_match_all($pattern, $text, $matches);
            foreach ($matches[0] as $match) {
                $entities[] = [
                    'text' => $match,
                    'label' => 'TECH_SKILL',
                    'confidence' => 0.9,
                    'normalized' => $this->normalizeSkillName($match)
                ];
            }
        }

        // Extraction des entités d'entreprise
        $company_pattern = '/\b(?:chez|pour|dans l\'entreprise|société)\s+([A-Z][a-zA-Z\s&]{2,30})\b/i';
        preg_match_all($company_pattern, $text, $matches);
        foreach ($matches[1] as $match) {
            $entities[] = [
                'text' => trim($match),
                'label' => 'ORG',
                'confidence' => 0.8
            ];
        }

        // Extraction des certifications
        $cert_pattern = '/\b(?:certification|certifié|diplôme|master|licence)\s+([A-Za-z0-9\s\+]{3,30})\b/i';
        preg_match_all($cert_pattern, $text, $matches);
        foreach ($matches[1] as $match) {
            $entities[] = [
                'text' => trim($match),
                'label' => 'CERTIFICATION',
                'confidence' => 0.7
            ];
        }

        return $entities;
    }

    /**
     * Classification automatique des compétences par cluster technologique
     */
    private function classifySkillsByCluster($skills)
    {
        $clustered_skills = [];
        $uncategorized = [];

        foreach ($skills as $skill) {
            $normalized = $this->normalizeSkillName($skill);
            $categorized = false;

            foreach ($this->technology_clusters as $cluster_name => $cluster_skills) {
                if (in_array($normalized, array_map('strtolower', $cluster_skills))) {
                    if (!isset($clustered_skills[$cluster_name])) {
                        $clustered_skills[$cluster_name] = [];
                    }
                    $clustered_skills[$cluster_name][] = $skill;
                    $categorized = true;
                    break;
                }
            }

            if (!$categorized) {
                $uncategorized[] = $skill;
            }
        }

        if (!empty($uncategorized)) {
            $clustered_skills['autres'] = $uncategorized;
        }

        return $clustered_skills;
    }

    /**
     * Extraction de mots-clés contextuels avancée
     */
    private function extractContextualKeywords($text, $max_keywords = 15)
    {
        if (empty($text)) {
            return [];
        }

        // Mots vides français
        $stopwords = [
            'le', 'de', 'et', 'à', 'un', 'il', 'être', 'et', 'en', 'avoir', 'que', 'pour',
            'dans', 'ce', 'son', 'une', 'sur', 'avec', 'ne', 'se', 'pas', 'tout', 'plus',
            'par', 'grand', 'en', 'une', 'être', 'et', 'à', 'il', 'avoir', 'ne', 'je'
        ];

        // Nettoyage du texte
        $text = strtolower($text);
        $text = preg_replace('/[^\w\s]/u', ' ', $text);
        $words = array_filter(explode(' ', $text));

        // Filtrage des mots vides et calcul de fréquence
        $word_freq = [];
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) > 2 && !in_array($word, $stopwords)) {
                $word_freq[$word] = ($word_freq[$word] ?? 0) + 1;
            }
        }

        // Tri par fréquence et limitation
        arsort($word_freq);
        return array_keys(array_slice($word_freq, 0, $max_keywords));
    }

    /**
     * Version améliorée de formatCompetence avec normalisation
     */
    private function formatCompetence($competence)
    {
        if (is_string($competence)) {
            $competence = ['competence' => $competence, 'mis_en_avant' => 0];
        }
        
        $nom = trim($competence['competence']);
        $normalized = $this->normalizeSkillName($nom);
        $niveau = isset($competence['mis_en_avant']) && $competence['mis_en_avant'] ? 4 : 3;
        
        return [
            'nom' => $nom,
            'niveau' => $niveau,
            'annees_experience' => $competence['annees_experience'] ?? 1,
            'normalized_name' => $normalized,
            'category' => $this->getSkillCategory($normalized),
            'market_demand' => $this->estimateMarketDemand($normalized)
        ];
    }

    /**
     * Estime la demande du marché pour une compétence
     */
    private function estimateMarketDemand($skill)
    {
        $high_demand = ['python', 'javascript', 'react', 'node.js', 'aws', 'docker', 'kubernetes'];
        $medium_demand = ['php', 'java', 'mysql', 'html', 'css', 'git'];

        $skill_lower = strtolower($skill);
        if (in_array($skill_lower, $high_demand)) {
            return 0.9;
        } elseif (in_array($skill_lower, $medium_demand)) {
            return 0.6;
        }
        return 0.3;
    }

    /**
     * Détermine la catégorie d'une compétence
     */
    private function getSkillCategory($skill)
    {
        foreach ($this->technology_clusters as $category => $skills) {
            if (in_array(strtolower($skill), array_map('strtolower', $skills))) {
                return $category;
            }
        }
        return 'general';
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

    private function extractEducationLevelValue(string $text): int
    {
        // Recherche de "bac+\d" ou "master", "licence", etc.
        if (preg_match('/(?:bac\s*\+\s*|master\s*pro\s*)(\d+)/i', $text, $matches)) {
            return intval($matches[1]);
        }
        $lowerText = strtolower($text);
        if (strpos($lowerText, 'doctorat') !== false) return 8;
        if (strpos($lowerText, 'master') !== false) return 5;
        if (strpos($lowerText, 'licence') !== false) return 3;
        if (strpos($lowerText, 'bac') !== false) return 0;
        return 0;
    }

    private function extractExperienceYearsFromText(string $text): int
    {
        // Recherche de "X ans", "entre X et Y ans"
        if (preg_match('/(?:entre\s*)?(\d+)\s*(?:à|et|-)?\s*(?:\d+\s*)?an/i', $text, $matches)) {
            return intval($matches[1]); // On prend le minimum requis
        }
        return 0;
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

        // Extraction du niveau d'étude requis et sa valeur numérique
        $niveau_etude = $offre['niveau_etude'] ?? "Non spécifié";
        $niveau_etude_valeur = $this->extractEducationLevelValue($offre['profil_recherche'] ?? '');
        if ($niveau_etude_valeur === 0) {
            $niveau_etude_valeur = $this->extractEducationLevelValue($niveau_etude);
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
        $duree_minimum_mois = $this->extractExperienceYearsFromText($niveau_experience) * 12;
        if ($duree_minimum_mois === 0) {
             $duree_minimum_mois = $this->extractExperienceYearsFromText($offre['profil_recherche'] ?? '') * 12;
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

    private function concatenateCandidateData(array $candidatData): string
    {
        $text = [];
        $text[] = "Profil du candidat : " . ($candidatData['nom'] ?? '');
        $text[] = "Profession : " . ($candidatData['profession'] ?? '');
        if (!empty($candidatData['description'])) {
            $text[] = "Description : " . strip_tags($candidatData['description']);
        }

        if (!empty($candidatData['formations'])) {
            $formations_text = "Formations: ";
            foreach ($candidatData['formations'] as $f) {
                $formations_text .= "{$f['niveau']} en {$f['domaine']} à {$f['etablissement']}; ";
            }
            $text[] = $formations_text;
        }

        if (!empty($candidatData['experiences'])) {
            $experiences_text = "Expériences: ";
            foreach ($candidatData['experiences'] as $e) {
                $experiences_text .= "{$e['titre_poste']} - " . strip_tags($e['description']) . "; ";
            }
            $text[] = $experiences_text;
        }

        if (!empty($candidatData['competences'])) {
            $competences_text = "Compétences: ";
            foreach ($candidatData['competences'] as $c) {
                $competences_text .= "{$c['nom']}, ";
            }
            $text[] = rtrim($competences_text, ', ');
        }
        
        if (!empty($candidatData['outils'])) {
            $outils_text = "Outils: " . implode(', ', $candidatData['outils']);
            $text[] = $outils_text;
        }
        
        if (!empty($candidatData['projets'])) {
            $projets_text = "Projets: ";
            foreach ($candidatData['projets'] as $p) {
                $projets_text .= "{$p['titre']} - " . strip_tags($p['description']) . "; ";
            }
            $text[] = $projets_text;
        }

        return implode("\n", $text);
    }

    private function concatenateOfferData(array $offreData): string
    {
        $text = [];
        $text[] = "Offre d'emploi : " . ($offreData['titre'] ?? '');
        $text[] = "Secteur : " . ($offreData['secteur'] ?? '');
        if (!empty($offreData['description'])) {
            $text[] = "Description du poste : " . strip_tags($offreData['description']);
        }

        if (!empty($offreData['competences_requises'])) {
            $text[] = "Compétences requises: " . implode(', ', array_column($offreData['competences_requises'], 'nom'));
        }
        
        if (isset($offreData['formation_requise']) && !empty($offreData['formation_requise']['niveau_minimum'])) {
            $text[] = "Niveau d'étude requis: " . $offreData['formation_requise']['niveau_minimum'];
        }
        
        if (isset($offreData['experience_requise']) && !empty($offreData['experience_requise']['niveau'])) {
            $text[] = "Niveau d'expérience requis: " . $offreData['experience_requise']['niveau'];
        }

        return implode("\n", $text);
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
            $candidatData['niveau_etude_valeur'] = $niveaux['niveau_etude_valeur'];
            $candidatData['niveau_experience_valeur'] = $niveaux['niveau_experience_valeur'];

            // Récupération de la description du candidat si non présente
            if (empty($candidatData['description'])) {
                $candidatData['description'] = $this->getDescriptionCandidat($users_id);
            }

            // Récupération des projets du candidat
            $projets = $this->getProjetsCandidat($users_id);
            $formatted_projets = array_map([$this, 'formatProjet'], $projets);

            // Enrichir les compétences avec l'extraction depuis les descriptions
            $candidatData['competences'] = $this->getAllCompetences($candidatData);

            // Formatage des données du candidat
            $formatted_candidat = [
                "id" => intval($candidatData['id']),
                "nom" => $candidatData['nom'] ?? '',
                "email" => $candidatData['email'] ?? '',
                "telephone" => $candidatData['telephone'] ?? '',
                "ville" => $candidatData['ville'] ?? '',
                "domaine_competence" => $candidatData['titre'] ?? '',  // Le titre professionnel représente le domaine de compétence
                "profession" => $candidatData['titre'] ?? '',
                "categorie" => $candidatData['categorie'] ?? '',
                "description" => $candidatData['description'] ?? '',
                "formations" => array_map([$this, 'formatFormation'], $candidatData['formations']),
                "experiences" => array_map([$this, 'formatExperience'], $candidatData['experiences']),
                "competences" => $candidatData['competences'],
                "langues" => array_map([$this, 'formatLangue'], $candidatData['langues']),
                "outils" => $candidatData['outils'] ?? [],
                "centres_interet" => [],
                "projets" => $formatted_projets,
                "disponibilite" => "Immédiate",
                "niveau_etude" => $candidatData['niveau_etude'],
                "niveau_experience" => $candidatData['niveau_experience'],
                "niveau_etude_valeur" => $candidatData['niveau_etude_valeur'],
                "niveau_experience_valeur" => $candidatData['niveau_experience_valeur']
            ];

            // Récupération des données de l'offre
            $offreEmploi = new OffreEmploi($this->db);
            $offreData = $offreEmploi->getOffreDetails($offre_id);
            if (!$offreData) {
                $this->log("Erreur: Données de l'offre non disponibles");
                throw new Exception("Impossible de récupérer les données de l'offre");
            }

            // Enrichir les compétences requises avec l'extraction depuis la description et le profil recherché
            $texte_offre_pour_extraction = ($offreData['description_poste'] ?? '') . ' ' . ($offreData['profil_recherche'] ?? '');
            $competences_from_text = $this->extractCompetencesFromText($texte_offre_pour_extraction);
            
            if (!isset($offreData['competences_requises'])) {
                $offreData['competences_requises'] = [];
            }
            $offreData['competences_requises'] = array_merge(
                $offreData['competences_requises'],
                $competences_from_text
            );

            // Formatage des données de l'offre
            $formatted_offre = $this->formatOffreEmploi($offreData);

            // Concaténation des données pour l'analyse globale (hybride)
            $formatted_candidat['texte_integral'] = $this->concatenateCandidateData($formatted_candidat);
            $formatted_offre['texte_integral'] = $this->concatenateOfferData($formatted_offre);

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
            CURLOPT_TIMEOUT => 180
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

        // Retourner directement la réponse décodée
        return $decoded;
    }

    private function formatProjet($projet)
    {
        return [
            "id" => intval($projet['id']),
            "users_id" => intval($projet['users_id']),
            "titre" => $projet['titre'],
            "liens" => $projet['liens'] ?? null,
            "description" => !empty($projet['projetdescription']) ? strip_tags($projet['projetdescription']) : "",
            "images" => $projet['images'] ?? null,
            "date" => $projet['date'] ?? null,
            "technologies" => $this->extractTechnologiesFromText($projet['projetdescription'] ?? ""),
            "competences_developpees" => $this->extractCompetencesFromText($projet['projetdescription'] ?? "")
        ];
    }

    private function getProjetsCandidat($users_id)
    {
        try {
            $sql = "SELECT id, users_id, titre, liens, projetdescription, images, date 
                    FROM projet_users 
                    WHERE users_id = :users_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':users_id', $users_id);
            $stmt->execute();
            
            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $projets ? $projets : [];
        } catch (Exception $e) {
            $this->log("Erreur lors de la récupération des projets", [
                'users_id' => $users_id,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    private function getDescriptionCandidat($users_id)
    {
        try {
            $sql = "SELECT description 
                    FROM description_users 
                    WHERE users_id = :users_id 
                    ORDER BY date DESC LIMIT 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':users_id', $users_id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['description'] : '';
        } catch (Exception $e) {
            $this->log("Erreur lors de la récupération de la description", [
                'users_id' => $users_id,
                'error' => $e->getMessage()
            ]);
            return '';
        }
    }

    private function extractTechnologiesFromText($text)
    {
        if (empty($text)) {
            return [];
        }
        
        $technologies = [];
        
        // Recherche des technologies mentionnées
        if (preg_match('/Technologies?(?:\s+utilisées)?(?:\s*:|\s*utilisées\s*:)([^<\n\.]+)/i', $text, $matches)) {
            $techs = explode(',', $matches[1]);
            $technologies = array_map('trim', $techs);
        }
        
        // Si aucune technologie n'a été trouvée avec le pattern précédent, utiliser extractCompetencesFromText
        if (empty($technologies)) {
            $competences = $this->extractCompetencesFromText($text);
            $technologies = array_column($competences, 'nom');
        }
        
        return array_filter($technologies);
    }
} 