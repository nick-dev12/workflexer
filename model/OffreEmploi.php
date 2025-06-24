<?php
require_once(__DIR__ . '/../conn/conn.php');

class OffreEmploi
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupère les détails d'une offre d'emploi
     * @param int $offre_id
     * @return array|null
     */
    public function getOffreDetails($offre_id)
    {
        try {
            $sql = "SELECT offre_id, titre, description_poste, profil_recherche, 
                           entreprise, localisation, lien_offre, source, 
                           date_publication, date_creation, niveau_etude, 
                           niveau_experience, type_contrat, competences, 
                           secteur_activite, site_internet, description_entreprise 
                    FROM scrap_emploi_emploisenegal 
                    WHERE offre_id = :offre_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':offre_id', $offre_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de l'offre : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Formate les données de l'offre pour l'API de matching
     * @param array $offre
     * @return array
     */
    public function formatForMatching($offre)
    {
        // Extraction des compétences
        $competences = array_map('trim', explode(',', $offre['competences']));

        // Extraction des compétences supplémentaires du profil recherché
        $competences_supplementaires = $this->extractSkillsFromText($offre['profil_recherche']);
        $competences = array_unique(array_merge($competences, $competences_supplementaires));

        // Extraction du nombre d'années d'expérience requis
        $annees_experience = $this->extractExperienceYears($offre['niveau_experience']);

        // Extraction des langues requises
        $langues_requises = $this->extractLanguages($offre['profil_recherche']);

        // Extraction des outils requis
        $outils_requis = $this->extractTools($offre['profil_recherche']);

        // Nettoyage du niveau d'études
        $niveau_etudes = $this->normalizeEducationLevel($offre['niveau_etude']);

        return [
            'id' => $offre['offre_id'],
            'titre' => $offre['titre'],
            'entreprise' => $offre['entreprise'],
            'description' => strip_tags($offre['description_poste']),
            'competences_requises' => $competences,
            'niveau_etudes' => $niveau_etudes,
            'annees_experience' => $annees_experience,
            'langues_requises' => $langues_requises,
            'outils_requis' => $outils_requis
        ];
    }

    /**
     * Extrait le nombre d'années d'expérience à partir du texte
     */
    private function extractExperienceYears($experience_text)
    {
        if (preg_match('/(\d+)/', $experience_text, $matches)) {
            return floatval($matches[1]);
        }
        return null;
    }

    /**
     * Extrait les langues requises du profil recherché
     */
    private function extractLanguages($profil_text)
    {
        $langues = [];
        $langues_possibles = [
            'français' => ['français', 'french', 'francais'],
            'anglais' => ['anglais', 'english'],
            'espagnol' => ['espagnol', 'spanish'],
            'arabe' => ['arabe', 'arabic'],
            'wolof' => ['wolof']
        ];

        foreach ($langues_possibles as $langue => $variations) {
            foreach ($variations as $variation) {
                if (stripos($profil_text, $variation) !== false) {
                    $langues[] = $langue;
                    break;
                }
            }
        }

        return array_unique($langues);
    }

    /**
     * Extrait les outils requis du profil recherché
     */
    private function extractTools($profil_text)
    {
        $outils = [];
        $outils_possibles = [
            // Bureautique
            'word',
            'excel',
            'powerpoint',
            'office',
            'outlook',
            // Design
            'photoshop',
            'illustrator',
            'indesign',
            'figma',
            'sketch',
            // CAO/DAO
            'autocad',
            'solidworks',
            'sketchup',
            'revit',
            'catia',
            // Développement
            'java',
            'python',
            'javascript',
            'php',
            'html',
            'css',
            // Base de données
            'sql',
            'mysql',
            'postgresql',
            'oracle',
            'mongodb',
            // Gestion de projet
            'git',
            'github',
            'gitlab',
            'bitbucket',
            'jira',
            'trello',
            'asana',
            'slack',
            // ERP/CRM
            'sap',
            'salesforce',
            'sage',
            'oracle'
        ];

        foreach ($outils_possibles as $outil) {
            if (stripos($profil_text, $outil) !== false) {
                $outils[] = $outil;
            }
        }

        return array_unique($outils);
    }

    /**
     * Extrait les compétences supplémentaires du texte du profil
     */
    private function extractSkillsFromText($text)
    {
        $competences = [];

        // Liste de mots-clés indiquant des compétences
        $indicateurs = [
            'compétences',
            'maîtrise',
            'connaissance',
            'expertise',
            'savoir-faire',
            'capacité',
            'expérience en'
        ];

        // Découpage du texte en phrases
        $phrases = preg_split('/[.!?]+/', $text);

        foreach ($phrases as $phrase) {
            foreach ($indicateurs as $indicateur) {
                if (stripos($phrase, $indicateur) !== false) {
                    // Extraction des mots/expressions après l'indicateur
                    $competences_trouvees = $this->extractKeyPhrases($phrase);
                    $competences = array_merge($competences, $competences_trouvees);
                }
            }
        }

        return array_unique($competences);
    }

    /**
     * Extrait les expressions clés d'une phrase
     */
    private function extractKeyPhrases($phrase)
    {
        $expressions = [];

        // Suppression des balises HTML
        $phrase = strip_tags($phrase);

        // Découpage sur les virgules et les points-virgules
        $parties = preg_split('/[,;]/', $phrase);

        foreach ($parties as $partie) {
            $partie = trim($partie);
            if (strlen($partie) > 3 && !preg_match('/^(de|du|des|le|la|les|un|une|et|ou)$/i', $partie)) {
                $expressions[] = $partie;
            }
        }

        return $expressions;
    }

    /**
     * Normalise le niveau d'études
     */
    private function normalizeEducationLevel($niveau)
    {
        $niveau = strtolower(trim($niveau));

        $equivalences = [
            'bac' => 'Bac',
            'bac+2' => 'Bac+2',
            'bac+3' => 'Bac+3',
            'licence' => 'Bac+3',
            'bac+4' => 'Bac+4',
            'bac+5' => 'Bac+5',
            'master' => 'Bac+5',
            'ingénieur' => 'Bac+5',
            'doctorat' => 'Bac+8',
            'phd' => 'Bac+8'
        ];

        foreach ($equivalences as $pattern => $normalized) {
            if (stripos($niveau, $pattern) !== false) {
                return $normalized;
            }
        }

        return $niveau;
    }
}