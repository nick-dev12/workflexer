<?php
require_once(__DIR__ . '/../conn/conn.php');
require_once(__DIR__ . '/../model/CandidatProfile.php');
require_once(__DIR__ . '/../model/OffreEmploi.php');
require_once(__DIR__ . '/../controller/MatchingController.php');

// Configuration du mode test
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fonction pour afficher un message stylisé
function printMessage($message, $type = 'info') {
    $colors = [
        'info' => "\033[0;34m",    // Bleu
        'success' => "\033[0;32m",  // Vert
        'error' => "\033[0;31m",    // Rouge
        'warning' => "\033[0;33m",  // Jaune
        'reset' => "\033[0m"        // Reset
    ];
    
    echo $colors[$type] . $message . $colors['reset'] . "\n";
}

// Fonction pour lister les candidats disponibles
function listCandidats($db) {
    $sql = "SELECT u.id, u.nom, u.profession, u.categorie 
            FROM users u 
            ORDER BY u.id ASC 
            LIMIT 20";
    $stmt = $db->query($sql);
    $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    printMessage("\nCandidats disponibles:", 'info');
    foreach ($candidats as $candidat) {
        echo sprintf("ID: %d - %s (%s - %s)\n", 
            $candidat['id'], 
            $candidat['nom'], 
            $candidat['profession'],
            $candidat['categorie']
        );
    }
}

// Fonction pour lister les offres disponibles
function listOffres($db) {
    $sql = "SELECT offre_id, titre, entreprise, type_contrat, competences 
            FROM scrap_emploi_emploisenegal 
            ORDER BY offre_id ASC 
            LIMIT 20";
    $stmt = $db->query($sql);
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    printMessage("\nOffres disponibles:", 'info');
    foreach ($offres as $offre) {
        echo sprintf("ID: %d - %s\nEntreprise: %s | Type: %s\nCompétences: %s\n\n", 
            $offre['offre_id'], 
            $offre['titre'], 
            $offre['entreprise'],
            $offre['type_contrat'],
            $offre['competences']
        );
    }
}

// Fonction pour afficher les résultats de l'analyse
function displayResults($resultat) {
    if (!$resultat) {
        printMessage("Aucun résultat d'analyse disponible.", 'error');
        return;
    }

    // Score global
    printMessage("\n=== Résultats de l'analyse ===", 'info');
    printMessage(sprintf("Score global: %d%%", $resultat['global_score']), 'success');

    // Points forts
    if (!empty($resultat['strengths'])) {
        printMessage("\nPoints forts:", 'success');
        foreach ($resultat['strengths'] as $strength) {
            echo "✓ " . $strength . "\n";
        }
    }

    // Points à améliorer
    if (!empty($resultat['improvements'])) {
        printMessage("\nPoints à améliorer:", 'warning');
        foreach ($resultat['improvements'] as $improvement) {
            echo "! " . $improvement . "\n";
        }
    }

    // Scores détaillés
    if (isset($resultat['detailed_scores']) && !empty($resultat['detailed_scores'])) {
        printMessage("\nScores détaillés:", 'info');
        foreach ($resultat['detailed_scores'] as $category => $score) {
            echo sprintf("%s: %d%%\n", $category, $score);
        }
    }
}

// Menu principal
while (true) {
    echo "\n=== Test de compatibilité WorkFlexer ===\n";
    echo "1. Lister les candidats disponibles\n";
    echo "2. Lister les offres disponibles\n";
    echo "3. Analyser la compatibilité\n";
    echo "4. Quitter\n";
    
    $choix = readline("Votre choix (1-4): ");
    
    switch ($choix) {
        case '1':
            listCandidats($db);
            break;
            
        case '2':
            listOffres($db);
            break;
            
        case '3':
            $candidat_id = readline("ID du candidat: ");
            $offre_id = readline("ID de l'offre: ");
            
            try {
                $matchingController = new MatchingController($db);
                $resultat = $matchingController->analyserCompatibilite($candidat_id, $offre_id);
                displayResults($resultat);
            } catch (Exception $e) {
                printMessage("Erreur: " . $e->getMessage(), 'error');
            }
            break;
            
        case '4':
            printMessage("Au revoir!", 'success');
            exit(0);
            
        default:
            printMessage("Choix invalide. Veuillez réessayer.", 'error');
    }
    
    echo "\nAppuyez sur Entrée pour continuer...";
    readline();
} 