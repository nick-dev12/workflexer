<?php

// Test simple de l'API hybrid-v2
$url = "http://localhost:8000/analyze/hybrid-v2";

$data = [
    "candidate" => [
        "id" => 5,
        "nom" => "Test User",
        "email" => "test@example.com",
        "competences" => [
            [
                "nom" => "PHP",
                "niveau" => 3,
                "annees_experience" => 2.0
            ]
        ],
        "formations" => [],
        "experiences" => [],
        "langues" => [],
        "projets" => []
    ],
    "job_offer" => [
        "id" => 3,
        "titre" => "Développeur PHP",
        "description" => "Poste de développeur PHP avec MySQL",
        "competences_requises" => [
            [
                "nom" => "PHP",
                "niveau" => 4,
                "annees_experience" => 3.0
            ],
            [
                "nom" => "MySQL",
                "niveau" => 3,
                "annees_experience" => 2.0
            ]
        ],
        "secteur" => "Informatique",
        "type_contrat" => "CDI",
        "localisation" => "Paris"
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

echo "=== TEST API HYBRID-V2 ===\n";
echo "HTTP Code: " . $httpCode . "\n";
echo "Error: " . ($error ?: 'Aucune') . "\n";
echo "Response: " . ($response ?: 'Vide') . "\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if ($result) {
        echo "\n=== RÉSULTAT DÉCODÉ ===\n";
        echo "Score global: " . ($result['score_global'] ?? 'N/A') . "\n";
        echo "Score sémantique: " . ($result['score_semantique'] ?? 'N/A') . "\n";
        echo "Niveau adéquation: " . ($result['niveau_adequation'] ?? 'N/A') . "\n";
        echo "Points forts: " . count($result['points_forts'] ?? []) . "\n";
        echo "Suggestions: " . count($result['suggestions'] ?? []) . "\n";
    } else {
        echo "Erreur de décodage JSON\n";
    }
} else {
    echo "Erreur HTTP: " . $httpCode . "\n";
}

?> 