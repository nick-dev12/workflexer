<?php
/**
 * Exemple d'utilisation de l'API de matching WorkFlexer
 * 
 * Ce script montre comment appeler l'API de matching pour analyser
 * la compatibilité entre un profil candidat et une offre d'emploi.
 */

// Configuration
$api_url = "http://localhost:8000"; // URL de l'API
$endpoint = "/analyze/v2"; // Endpoint pour la nouvelle version de l'API

/**
 * Fonction pour appeler l'API de matching
 * 
 * @param string $url URL complète de l'API
 * @param array $data Données à envoyer à l'API
 * @return array Réponse de l'API
 */
function callMatchingAPI($url, $data)
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

// Exemple de données pour un candidat
$candidat = [
    'id' => 123,
    'formations' => [
        [
            'niveau' => 'Bac+3',
            'domaine' => 'Informatique',
            'etablissement' => 'Université Paris 8',
            'annee_obtention' => 2020
        ]
    ],
    'experiences' => [
        [
            'titre_poste' => 'Développeur Web',
            'entreprise' => 'TechCorp',
            'duree_mois' => 18,
            'description' => 'Développement d\'applications web',
            'competences' => ['PHP', 'JavaScript', 'HTML', 'CSS']
        ]
    ],
    'competences' => [
        [
            'nom' => 'PHP',
            'niveau' => 4,
            'annees_experience' => 2.5
        ],
        [
            'nom' => 'JavaScript',
            'niveau' => 3,
            'annees_experience' => 2.0
        ],
        [
            'nom' => 'HTML',
            'niveau' => 4,
            'annees_experience' => 3.0
        ]
    ],
    'langues' => [
        [
            'nom' => 'Français',
            'niveau' => 'C2'
        ],
        [
            'nom' => 'Anglais',
            'niveau' => 'B2'
        ]
    ]
];

// Exemple de données pour une offre d'emploi
$offre = [
    'id' => 456,
    'titre' => 'Développeur PHP Full Stack',
    'description' => 'Nous recherchons un développeur PHP expérimenté pour rejoindre notre équipe.',
    'formation_requise' => [
        'niveau_minimum' => 'Bac+2',
        'domaines_acceptes' => ['Informatique', 'Développement Web']
    ],
    'experience_requise' => [
        'duree_minimum_mois' => 12,
        'competences_requises' => ['PHP', 'MySQL', 'JavaScript']
    ],
    'competences_requises' => [
        [
            'nom' => 'PHP',
            'niveau' => 3
        ],
        [
            'nom' => 'JavaScript',
            'niveau' => 3
        ],
        [
            'nom' => 'MySQL',
            'niveau' => 2
        ]
    ],
    'langues_requises' => [
        [
            'nom' => 'Français',
            'niveau' => 'B2'
        ],
        [
            'nom' => 'Anglais',
            'niveau' => 'B1'
        ]
    ],
    'secteur' => 'Informatique',
    'type_contrat' => 'CDI',
    'localisation' => 'Paris'
];

// Construction des données pour l'API
$data = [
    'candidate' => $candidat,
    'job_offer' => $offre,
    'options' => [
        'include_details' => true
    ]
];

// Appel à l'API
$result = callMatchingAPI($api_url . $endpoint, $data);

// Affichage des résultats
if ($result['success']) {
    $response = $result['response'];

    echo "<h1>Résultat de l'analyse de compatibilité</h1>";

    // Affichage du score global et du résumé
    echo "<h2>Score global: " . $response['score_global'] . "% - " . $response['niveau_adequation'] . "</h2>";
    echo "<p><strong>Résumé:</strong> " . $response['resume'] . "</p>";

    // Affichage des points forts
    echo "<h2>Points forts</h2>";
    echo "<ul>";
    foreach ($response['points_forts'] as $point) {
        $importance = $point['importance'] == 'important' ? ' <span style="color: green;">(Important)</span>' : '';
        echo "<li><strong>" . ucfirst($point['categorie']) . ":</strong> " . $point['description'] . $importance . "</li>";
    }
    echo "</ul>";

    // Affichage des points à améliorer
    echo "<h2>Points à améliorer</h2>";
    echo "<ul>";
    foreach ($response['points_amelioration'] as $point) {
        $priorite = $point['priorite'] == 'haute' ? ' <span style="color: red;">(Priorité haute)</span>' : '';
        echo "<li><strong>" . ucfirst($point['categorie']) . ":</strong> " . $point['description'] . $priorite;
        if (!empty($point['suggestion'])) {
            echo "<br><em>Suggestion: " . $point['suggestion'] . "</em>";
        }
        echo "</li>";
    }
    echo "</ul>";

    // Affichage des analyses détaillées
    echo "<h2>Analyse détaillée par catégorie</h2>";

    // Formation
    echo "<h3>Formation - " . $response['analyse_detaillee']['formation']['score'] . "%</h3>";
    echo "<p>" . $response['analyse_detaillee']['formation']['resume'] . "</p>";

    // Expérience
    echo "<h3>Expérience - " . $response['analyse_detaillee']['experience']['score'] . "%</h3>";
    echo "<p>" . $response['analyse_detaillee']['experience']['resume'] . "</p>";

    // Compétences
    echo "<h3>Compétences - " . $response['analyse_detaillee']['competences']['score'] . "%</h3>";
    echo "<p>" . $response['analyse_detaillee']['competences']['resume'] . "</p>";

    // Langues
    echo "<h3>Langues - " . $response['analyse_detaillee']['langues']['score'] . "%</h3>";
    echo "<p>" . $response['analyse_detaillee']['langues']['resume'] . "</p>";

    // Suggestions d'amélioration
    if (!empty($response['suggestions'])) {
        echo "<h2>Suggestions d'amélioration</h2>";
        echo "<ul>";
        foreach ($response['suggestions'] as $suggestion) {
            $impact = $suggestion['impact_estime'] == 'fort' ? ' <span style="color: green;">(Impact fort)</span>' : '';
            echo "<li><strong>" . ucfirst($suggestion['categorie']) . ":</strong> " . $suggestion['description'] . $impact . "</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<h1>Erreur lors de l'appel à l'API</h1>";
    echo "<p>" . $result['error'] . "</p>";
    echo "<pre>" . print_r($result['response'], true) . "</pre>";
}
?>