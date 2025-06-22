<?php
/**
 * Exemple d'intégration de l'API de matching dans WorkFlexer
 * Ce fichier montre comment appeler l'API Python depuis PHP
 */

/**
 * Fonction pour appeler l'API de matching
 * 
 * @param array $candidateData Données du profil du candidat
 * @param array $jobOfferData Données de l'offre d'emploi
 * @return array|false Résultats de l'analyse ou false en cas d'erreur
 */
function analyserCompatibilite($candidateData, $jobOfferData) {
    // URL de l'API (à adapter selon votre configuration)
    $apiUrl = 'http://localhost:8000/analyser';
    
    // Préparation des données
    $postData = json_encode([
        'candidate' => $candidateData,
        'job_offer' => $jobOfferData
    ]);
    
    // Configuration de la requête cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ]);
    
    // Exécution de la requête
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Vérification de la réponse
    if ($httpCode == 200) {
        return json_decode($response, true);
    } else {
        error_log("Erreur API de matching: $httpCode - $response");
        return false;
    }
}

// Exemple d'utilisation
// --------------------------------------------------

// Exemple de données de profil candidat
$candidateData = [
    'id' => 1,
    'nom' => 'Dupont',
    'prenom' => 'Jean',
    'email' => 'jean.dupont@example.com',
    'competences' => [
        'PHP', 'JavaScript', 'HTML', 'CSS', 'MySQL'
    ],
    'formations' => [
        [
            'diplome' => 'Master en Informatique',
            'etablissement' => 'Université de Paris',
            'niveau' => 'Bac+5',
            'annee_debut' => '2018',
            'annee_fin' => '2020'
        ],
        [
            'diplome' => 'Licence en Informatique',
            'etablissement' => 'Université de Lyon',
            'niveau' => 'Bac+3',
            'annee_debut' => '2015',
            'annee_fin' => '2018'
        ]
    ],
    'experiences' => [
        [
            'poste' => 'Développeur Web',
            'entreprise' => 'TechCorp',
            'date_debut' => '2020-09-01',
            'date_fin' => '2023-08-31',
            'duree' => 3.0,
            'description' => 'Développement d\'applications web avec PHP et JavaScript'
        ]
    ],
    'langues' => [
        [
            'nom' => 'Français',
            'niveau' => 'Natif'
        ],
        [
            'nom' => 'Anglais',
            'niveau' => 'Courant'
        ]
    ],
    'outils' => [
        'Visual Studio Code', 'Git', 'Docker', 'Jira'
    ]
];

// Exemple de données d'offre d'emploi
$jobOfferData = [
    'id' => 42,
    'titre' => 'Développeur Full Stack',
    'entreprise' => 'Innovatech',
    'description' => 'Nous recherchons un développeur full stack expérimenté pour rejoindre notre équipe.',
    'competences_requises' => [
        'PHP', 'JavaScript', 'React', 'Node.js', 'SQL'
    ],
    'niveau_etudes' => 'Bac+5',
    'annees_experience' => 2.0,
    'langues_requises' => [
        'Français', 'Anglais'
    ],
    'outils_requis' => [
        'Git', 'Docker', 'Jenkins'
    ]
];

// Appel à l'API de matching
$resultats = analyserCompatibilite($candidateData, $jobOfferData);

// Affichage des résultats
if ($resultats !== false) {
    echo "<h2>Résultats de l'analyse de compatibilité</h2>";
    
    echo "<h3>Score global: " . $resultats['global_score'] . "%</h3>";
    echo "<p><strong>Niveau de compatibilité:</strong> " . $resultats['compatibility_message'] . "</p>";
    
    echo "<h3>Scores par catégorie:</h3>";
    echo "<ul>";
    foreach ($resultats['scores_by_category'] as $category => $score) {
        echo "<li>$category: $score%</li>";
    }
    echo "</ul>";
    
    echo "<h3>Points forts:</h3>";
    echo "<ul>";
    foreach ($resultats['strengths'] as $strength) {
        echo "<li>$strength</li>";
    }
    echo "</ul>";
    
    echo "<h3>Points à améliorer:</h3>";
    echo "<ul>";
    foreach ($resultats['improvements'] as $improvement) {
        echo "<li>$improvement</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Erreur lors de l'analyse de compatibilité.</p>";
}
?>