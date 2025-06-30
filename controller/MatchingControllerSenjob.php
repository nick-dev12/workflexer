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
        $client = new Client([
            'timeout' => 180, // Augmentation du timeout à 3 minutes
            'connect_timeout' => 30
        ]);
        $endpoint = '/analyze_senjob/';

        try {
            $response = $client->post($this->api_base_url . $endpoint, [
                'json' => [
                    'candidate_data' => $candidat_data,
                    'job_offer_data' => $offre_data
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            // Log du succès
            error_log("API Senjob - Analyse réussie pour candidat {$candidat_data['id']} et offre {$offre_data['id']}");
            
            return $result;
        } catch (RequestException $e) {
            error_log("Erreur API Matching (Senjob): " . $e->getMessage());
            return ['error' => 'api_error', 'message' => 'Erreur de communication avec le service d\'analyse. Veuillez réessayer.'];
        } catch (Exception $e) {
            error_log("Erreur générale Matching (Senjob): " . $e->getMessage());
            return ['error' => 'general_error', 'message' => 'Une erreur inattendue s\'est produite.'];
        }
    }
} 