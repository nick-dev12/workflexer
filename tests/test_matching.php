<?php
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/CandidatProfile.php');
require_once(__DIR__ . '/../model/OffreEmploi.php');
require_once(__DIR__ . '/../controller/MatchingController.php');

// Configuration du mode test
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Début des tests de l'intégration du matching ===\n\n";

// Fonction utilitaire pour les tests
function testResult($test_name, $condition, $details = '') {
    echo $test_name . ": " . ($condition ? "✅ OK" : "❌ ÉCHEC");
    if ($details) {
        echo " ($details)";
    }
    echo "\n";
}

try {
    // Test 1: Connexion à la base de données
    testResult("Connexion à la base de données", $db instanceof PDO);

    // Vérification de la présence d'utilisateurs dans la base
    $stmt = $db->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        throw new Exception("Aucun utilisateur trouvé dans la base de données");
    }
    $users_id = $user['id'];
    testResult("Récupération d'un ID utilisateur valide", true, "ID: " . $users_id);

    // Vérification de la présence d'offres dans la base
    $stmt = $db->query("SELECT offre_id FROM scrap_emploi_emploisenegal LIMIT 1");
    $offre = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$offre) {
        throw new Exception("Aucune offre trouvée dans la base de données");
    }
    $offre_id = $offre['offre_id'];
    testResult("Récupération d'un ID offre valide", true, "ID: " . $offre_id);

    // Test 2: Récupération du profil candidat
    $candidatProfile = new CandidatProfile($db, $users_id);
    $profile = $candidatProfile->getFullProfile();
    
    if ($profile === null) {
        throw new Exception("Impossible de récupérer le profil du candidat");
    }
    
    testResult(
        "Récupération du profil candidat",
        $profile !== null && isset($profile['basic_info']),
        "ID utilisateur: " . $users_id
    );

    if ($profile) {
        echo "\nDonnées du profil récupérées:\n";
        foreach ($profile as $key => $value) {
            if (is_array($value)) {
                echo "  - $key: " . count($value) . " éléments\n";
            } else {
                echo "  - $key: présent\n";
            }
        }
    }

    // Test 3: Formatage des données du candidat pour l'API
    $formattedProfile = $candidatProfile->formatForMatching();
    testResult(
        "Formatage des données du candidat",
        $formattedProfile !== null && 
        isset($formattedProfile['competences']) && 
        isset($formattedProfile['formations'])
    );

    if ($formattedProfile) {
        echo "\nDonnées formatées du candidat:\n";
        foreach ($formattedProfile as $key => $value) {
            if (is_array($value)) {
                echo "  - $key: " . count($value) . " éléments\n";
            } else {
                echo "  - $key: " . (is_string($value) ? $value : 'présent') . "\n";
            }
        }
    }

    // Test 4: Récupération des détails d'une offre
    $offreEmploi = new OffreEmploi($db);
    $offre = $offreEmploi->getOffreDetails($offre_id);
    testResult(
        "Récupération des détails de l'offre",
        $offre !== null && isset($offre['titre']),
        "ID offre: " . $offre_id
    );

    if ($offre) {
        echo "\nDétails de l'offre:\n";
        echo "  - Titre: " . $offre['titre'] . "\n";
        echo "  - Entreprise: " . $offre['entreprise'] . "\n";
        echo "  - Type de contrat: " . $offre['type_contrat'] . "\n";
        echo "  - Compétences requises: " . $offre['competences'] . "\n";
    }

    // Test 5: Formatage des données de l'offre pour l'API
    $formattedOffre = $offreEmploi->formatForMatching($offre);
    testResult(
        "Formatage des données de l'offre",
        $formattedOffre !== null && 
        isset($formattedOffre['competences_requises'])
    );

    if ($formattedOffre) {
        echo "\nDonnées formatées de l'offre:\n";
        foreach ($formattedOffre as $key => $value) {
            if (is_array($value)) {
                if ($key === 'entreprise') {
                    echo "  - $key:\n";
                    foreach ($value as $k => $v) {
                        echo "    - $k: " . $v . "\n";
                    }
                } else {
                    echo "  - $key: " . count($value) . " éléments\n";
                }
            } else {
                echo "  - $key: " . (is_string($value) ? $value : 'présent') . "\n";
            }
        }
    }

    // Test 6: Test de l'appel à l'API via le contrôleur
    echo "\nTest de l'appel à l'API...\n";
    try {
        $matchingController = new MatchingController($db);
        $resultat = $matchingController->analyserCompatibilite($users_id, $offre_id);
        
        testResult(
            "Appel à l'API de matching",
            $resultat !== null && isset($resultat['global_score'])
        );

        if ($resultat) {
            echo "\nRésultats de l'analyse:\n";
            echo "================================\n";
            echo "Score global: " . $resultat['global_score'] . "%\n\n";
            
            echo "Scores détaillés:\n";
            foreach ($resultat['detailed_scores'] as $category => $score) {
                echo "- $category: $score%\n";
            }
            
            echo "\nPoints forts (" . count($resultat['strengths']) . "):\n";
            foreach ($resultat['strengths'] as $strength) {
                echo "✓ $strength\n";
            }
            
            echo "\nPoints à améliorer (" . count($resultat['improvements']) . "):\n";
            foreach ($resultat['improvements'] as $improvement) {
                echo "! $improvement\n";
            }
        }
    } catch (Exception $e) {
        echo "\n❌ Erreur lors de l'appel à l'API: " . $e->getMessage() . "\n";
        echo "Vérifiez que l'API est bien démarrée sur http://localhost:8000\n";
    }

    echo "\n=== Tests terminés ===\n";

} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
} 