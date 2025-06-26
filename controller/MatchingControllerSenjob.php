<?php
require_once __DIR__ . '/../model/CandidatProfile.php';
require_once __DIR__ . '/../model/OffreEmploiSenjob.php';
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MatchingControllerSenjob
{
    private $db;
    private $api_base_url;

    public function __construct($db)
    {
        $this->db = $db;
        $this->api_base_url = 'http://127.0.0.1:8000';
    }

    public function analyserCompatibilite($users_id, $offre_id)
    {
        // 1. Récupérer le profil du candidat
        $candidatProfile = new CandidatProfile($this->db, $users_id);
        $candidat_data = $candidatProfile->formatForMatching();

        // 2. Récupérer les détails de l'offre
        $offreEmploi = new OffreEmploiSenjob($this->db);
        $offre_details = $offreEmploi->getOffreDetails($offre_id);
        if (!$offre_details) {
            throw new Exception("Offre d'emploi Senjob non trouvée.");
        }
        $offre_data = $offreEmploi->formatForMatching($offre_details);

        // 3. Appeler l'API de matching Python
        return $this->callMatchingAPI($candidat_data, $offre_data);
    }

    private function callMatchingAPI($candidat_data, $offre_data)
    {
        $client = new Client();
        $endpoint = '/analyze_senjob/';

        try {
            $response = $client->post($this->api_base_url . $endpoint, [
                'json' => [
                    'candidate_data' => $candidat_data,
                    'job_offer_data' => $offre_data
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            error_log("Erreur API Matching (Senjob): " . $e->getMessage());
            return ['error' => 'api_error', 'message' => $e->getMessage()];
        }
    }
} 