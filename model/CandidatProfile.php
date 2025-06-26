<?php
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/description_users.php');
require_once(__DIR__ . '/competence_users.php');
require_once(__DIR__ . '/formation_users.php');
require_once(__DIR__ . '/metier_users.php');
require_once(__DIR__ . '/outil_users.php');
require_once(__DIR__ . '/langue_users.php');

class CandidatProfile
{
    private $db;
    private $users_id;

    public function __construct($db, $users_id)
    {
        $this->db = $db;
        $this->users_id = $users_id;
    }

    /**
     * Récupère toutes les informations du profil candidat
     * @return array
     */
    public function getFullProfile()
    {
        try {
            // Informations de base du candidat
            $basicInfo = $this->getBasicInfo();
            if (!$basicInfo) {
                throw new Exception("Utilisateur non trouvé");
            }

            // Récupération de toutes les données du profil
            $profile = [
                'id' => $this->users_id,
                'basic_info' => $basicInfo,
                'description' => afficheDescription($this->db, $this->users_id),
                'competences' => [
                    'all' => getCompetences($this->db, $this->users_id),
                    'highlighted' => getCompetencesMisEnAvant($this->db, $this->users_id)
                ],
                'formations' => getFormation($this->db, $this->users_id),
                'experiences' => [
                    'all' => getMetier($this->db, $this->users_id),
                    'highlighted' => getMetierMisEnAvant($this->db, $this->users_id)
                ],
                'outils' => getOutil($this->db, $this->users_id),
                'langues' => getLangue($this->db, $this->users_id),
                'niveau' => $this->getNiveauEtudeExperience()
            ];

            return $profile;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération du profil : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupère les informations de base du candidat
     */
    private function getBasicInfo()
    {
        $sql = "SELECT id, nom, mail, phone, ville, profession, categorie, images, competences 
                FROM users WHERE id = :users_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':users_id', $this->users_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le niveau d'étude et d'expérience
     */
    public function getNiveauEtudeExperience(): array
    {
        $sql = "SELECT etude, experience, n_etude, n_experience FROM niveau_etude WHERE users_id = :users_id ORDER BY date DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':users_id', $this->users_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'niveau_etude' => $result['etude'] ?? 'Non spécifié',
            'niveau_experience' => $result['experience'] ?? 'Non spécifié',
            'niveau_etude_valeur' => $result['n_etude'] ?? 0,
            'niveau_experience_valeur' => $result['n_experience'] ?? 0
        ];
    }

    /**
     * Récupère le titre (domaine de compétence) du candidat
     */
    public function getTitre()
    {
        $sql = "SELECT profession, competences FROM users WHERE id = :users_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':users_id', $this->users_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['competences'] ?? $result['profession'];
        }
        return null;
    }

    /**
     * Formate les données pour l'API de matching
     */
    public function formatForMatching()
    {
        $profile = $this->getFullProfile();
        if (!$profile)
            return null;

        // Formatage des compétences
        $competences = array_map(function ($comp) {
            return $comp['competence'];
        }, $profile['competences']['all']);

        // Formatage des formations
        $formations = array_map(function ($form) {
            return [
                'diplome' => $form['Filiere'],
                'etablissement' => $form['etablissement'],
                'niveau' => $form['niveau'],
                'annee_debut' => $form['anneeDebut'],
                'annee_fin' => $form['anneeFin'],
                'description' => null
            ];
        }, $profile['formations']);

        // Formatage des expériences
        $experiences = array_map(function ($exp) {
            return [
                'poste' => $exp['metier'],
                'entreprise' => null,
                'date_debut' => $exp['anneeDebut'] . '-' . str_pad($exp['moisDebut'], 2, '0', STR_PAD_LEFT),
                'date_fin' => $exp['en_cours'] ? null : $exp['anneeFin'] . '-' . str_pad($exp['moisFin'], 2, '0', STR_PAD_LEFT),
                'duree' => $this->calculateDuration($exp['anneeDebut'], $exp['anneeFin'], $exp['en_cours']),
                'description' => $exp['description']
            ];
        }, $profile['experiences']['all']);

        // Formatage des langues
        $langues = array_map(function ($langue) {
            return [
                'nom' => $langue['langue'],
                'niveau' => $this->normalizeLanguageLevel($langue['niveau'])
            ];
        }, $profile['langues']);

        // Formatage des outils
        $outils = array_map(function ($outil) {
            return $outil['outil'];
        }, $profile['outils']);

        // Séparation du nom complet en nom et prénom
        $nomComplet = explode(' ', $profile['basic_info']['nom']);
        $prenom = array_shift($nomComplet);
        $nom = implode(' ', $nomComplet);

        // Récupérer la description
        $description = '';
        if (isset($profile['description']) && is_array($profile['description'])) {
            $description = isset($profile['description']['description']) ? $profile['description']['description'] : '';
        } elseif (isset($profile['description'])) {
            $description = $profile['description'];
        }

        // Récupérer les niveaux d'étude et d'expérience
        $niveau_etude = null;
        $niveau_etude_valeur = null;
        $niveau_experience = null;
        $niveau_experience_valeur = null;

        if (isset($profile['niveau']) && is_array($profile['niveau'])) {
            $niveau_etude = isset($profile['niveau']['etude']) ? $profile['niveau']['etude'] : null;
            $niveau_etude_valeur = isset($profile['niveau']['n_etude']) ? intval($profile['niveau']['n_etude']) : null;
            $niveau_experience = isset($profile['niveau']['experience']) ? $profile['niveau']['experience'] : null;
            $niveau_experience_valeur = isset($profile['niveau']['n_experience']) ? intval($profile['niveau']['n_experience']) : null;
        }

        return [
            'id' => $profile['id'],
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $profile['basic_info']['mail'],
            'telephone' => $profile['basic_info']['phone'],
            'titre' => $profile['basic_info']['competences'] ?? $profile['basic_info']['profession'],
            'description' => $description,
            'competences' => $competences,
            'formations' => $formations,
            'experiences' => $experiences,
            'langues' => $langues,
            'outils' => $outils,
            'certifications' => [],
            'niveau_etude' => $niveau_etude,
            'niveau_etude_valeur' => $niveau_etude_valeur,
            'niveau_experience' => $niveau_experience,
            'niveau_experience_valeur' => $niveau_experience_valeur
        ];
    }

    /**
     * Calcule la durée d'une expérience en années
     */
    private function calculateDuration($debut, $fin, $en_cours)
    {
        $fin = $en_cours ? date('Y') : $fin;
        return floatval($fin) - floatval($debut);
    }

    /**
     * Normalise le niveau de langue selon les standards
     */
    private function normalizeLanguageLevel($niveau)
    {
        $niveaux = [
            'Débutant' => 'Débutant',
            'Intermédiaire' => 'Intermédiaire',
            'Avancé' => 'Avancé',
            'Courant' => 'Courant',
            'Natif' => 'Natif'
        ];
        
        return $niveaux[$niveau] ?? 'Intermédiaire';
    }
} 