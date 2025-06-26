<?php
class OffreEmploiSenjob
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOffreDetails($offre_id)
    {
        $sql = "SELECT * FROM senjob WHERE offre_id = :offre_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function formatForMatching($offre_details)
    {
        if (!$offre_details) {
            return null;
        }

        // Concaténer les champs pertinents pour créer un texte intégral
        $texte_integral = implode(" ", [
            $offre_details['titre'] ?? '',
            $offre_details['description_poste'] ?? '',
            $offre_details['entreprise'] ?? '',
            $offre_details['localisation'] ?? '',
            $offre_details['type_contrat'] ?? ''
        ]);

        return [
            'id' => (int) $offre_details['offre_id'],
            'titre' => $offre_details['titre'],
            'description' => $offre_details['description_poste'],
            'entreprise' => $offre_details['entreprise'],
            'localisation' => $offre_details['localisation'],
            'type_contrat' => $offre_details['type_contrat'],
            'texte_integral' => strip_tags($texte_integral) // Nettoyage basique
        ];
    }
} 