<?php
require_once(__DIR__ . '/../conn/conn.php');

class OffreEmploiDakar
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupère les détails d'une offre d'emploi depuis la table emploidakar
     * @param int $offre_id
     * @return array|null
     */
    public function getOffreDetails($offre_id)
    {
        try {
            $sql = "SELECT offre_id, titre, description_poste, profil_recherche, 
                           entreprise, localisation, type_contrat, 
                           date_publication, lien_offre, reference 
                    FROM scrap_emploi_emploidakar 
                    WHERE offre_id = :offre_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':offre_id', $offre_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de l'offre Dakar : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Formate les données de l'offre pour l'API de matching.
     * C'est ici que nous standardisons les données pour qu'elles correspondent au modèle attendu par l'API.
     * @param array $offre
     * @return array
     */
    public function formatForMatching($offre)
    {
        $texte_integral = ($offre['description_poste'] ?? '') . "\n\n" . ($offre['profil_recherche'] ?? '');

        // Extraction simple (peut être améliorée avec les fonctions de OffreEmploi.php si nécessaire)
        $competences_requises = $this->extractSkillsFromText($texte_integral);

        return [
            'id' => $offre['offre_id'],
            'titre' => $offre['titre'],
            'description' => $offre['description_poste'] ?? '',
            'secteur' => 'Non spécifié', 
            'type_contrat' => $offre['type_contrat'] ?? 'Non spécifié',
            'localisation' => $offre['localisation'] ?? 'Non spécifiée',
            'texte_integral' => $texte_integral,
            
            // On standardise les exigences en se basant sur le texte
            'formation_requise' => [
                'niveau_minimum' => $this->normalizeEducationLevel($texte_integral),
            ],
            'experience_requise' => [
                'duree_minimum_mois' => $this->extractExperienceYears($texte_integral) * 12,
            ],
            'competences_requises' => array_map(function($comp) {
                return ['nom' => $comp, 'niveau' => 3]; // Niveau par défaut
            }, $competences_requises),
            'langues_requises' => array_map(function($lang) {
                return ['nom' => $lang, 'niveau' => 'B2']; // Niveau par défaut
            }, $this->extractLanguages($texte_integral))
        ];
    }

    // Les fonctions d'extraction suivantes sont des versions simplifiées.
    // Pour une meilleure précision, on pourrait les partager via un Trait ou une classe utilitaire.
    private function extractSkillsFromText($text) {
        $competences = [];
        // Simplifié : on cherche des mots après des indicateurs
        if (preg_match('/compétences\s*:\s*(.*)/i', $text, $matches)) {
            $competences = array_map('trim', explode(',', $matches[1]));
        }
        return array_unique($competences);
    }

    private function extractExperienceYears($text) {
        if (preg_match('/(\d+)\s*an/i', $text, $matches)) {
            return (int)$matches[1];
        }
        return 0; // Par défaut
    }

    private function extractLanguages($text) {
        $langues = [];
        if (stripos($text, 'anglais') !== false) $langues[] = 'Anglais';
        if (stripos($text, 'français') !== false) $langues[] = 'Français';
        return array_unique($langues);
    }
    
    private function normalizeEducationLevel($text) {
        if (preg_match('/(bac\s*\+\s*\d+)/i', $text, $matches)) {
            return strtoupper(str_replace(' ', '', $matches[1]));
        }
        if (stripos($text, 'master') !== false) return 'Bac+5';
        if (stripos($text, 'licence') !== false) return 'Bac+3';
        return 'Non spécifié';
    }
} 