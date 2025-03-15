<?php
/**
 * Contrôleur pour la gestion des statistiques
 * 
 * Ce fichier gère les requêtes AJAX pour le filtrage des statistiques
 * et la récupération des données pour les graphiques
 */

// Inclusion des fichiers nécessaires
require_once '../model/statistiques.php';
require_once '../../conn/conn.php'; // Inclusion du fichier de connexion à la base de données

// Vérification de la session
session_start();
if (!isset($_SESSION['compte_entreprise'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Vous devez être connecté pour accéder à ces données'
    ]);
    exit;
}

// Récupération des données POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérification des données reçues
if (!isset($data['action'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Action non spécifiée'
    ]);
    exit;
}

// La connexion à la base de données est déjà établie dans le fichier conn.php
// et la variable $db est disponible

// Traitement des différentes actions
switch ($data['action']) {
    case 'get_filtered_stats':
        // Vérification des paramètres
        if (!isset($data['period'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Période non spécifiée'
            ]);
            exit;
        }

        $entreprise_id = $_SESSION['compte_entreprise'];
        $period = $data['period'];
        $customDates = isset($data['customDates']) ? $data['customDates'] : null;

        // Définition des dates de début et de fin en fonction de la période
        $startDate = null;
        $endDate = date('Y-m-d'); // Date actuelle par défaut pour la fin

        switch ($period) {
            case 'today':
                $startDate = date('Y-m-d');
                break;
            case 'week':
                $startDate = date('Y-m-d', strtotime('-7 days'));
                break;
            case 'month':
                $startDate = date('Y-m-d', strtotime('-30 days'));
                break;
            case 'quarter':
                $startDate = date('Y-m-d', strtotime('-90 days'));
                break;
            case 'year':
                $startDate = date('Y-m-d', strtotime('-365 days'));
                break;
            case 'custom':
                if ($customDates && isset($customDates['start']) && isset($customDates['end'])) {
                    $startDate = $customDates['start'];
                    $endDate = $customDates['end'];
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Dates personnalisées non spécifiées'
                    ]);
                    exit;
                }
                break;
            case 'all':
            default:
                // Aucune restriction de date
                $startDate = null;
                break;
        }

        // Récupération des statistiques filtrées
        try {
            $stats = getFilteredStatistiques($db, $entreprise_id, $startDate, $endDate);

            // Formatage des données pour les graphiques
            $candidaturesParCategorie = [];
            $candidaturesParCategorieLabels = [];
            $candidaturesParCategorieData = [];

            foreach ($stats['candidatures_par_categorie'] as $categorie) {
                $candidaturesParCategorieLabels[] = $categorie['categorie'];
                $candidaturesParCategorieData[] = $categorie['nombre'];
            }

            $vuesParOffre = [];
            $vuesParOffreLabels = [];
            $vuesParOffreData = [];

            foreach ($stats['vues_par_offre'] as $offre) {
                $vuesParOffreLabels[] = $offre['poste'];
                $vuesParOffreData[] = $offre['nombre'];
            }

            $candidaturesParMois = [];
            $candidaturesParMoisLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            $candidaturesParMoisData = array_fill(0, 12, 0);

            foreach ($stats['candidatures_par_mois'] as $mois) {
                $candidaturesParMoisData[$mois['mois'] - 1] = $mois['nombre'];
            }

            // Calcul des taux
            $tauxAcceptation = 0;
            if ($stats['candidatures_total'] > 0) {
                $tauxAcceptation = round(($stats['candidats_acceptes'] / $stats['candidatures_total']) * 100);
            }

            $tauxRefus = 0;
            if ($stats['candidatures_total'] > 0) {
                $tauxRefus = round(($stats['candidats_refuses'] / $stats['candidatures_total']) * 100);
            }

            // Préparation de la réponse
            $response = [
                'success' => true,
                'stats' => $stats,
                'charts' => [
                    'candidatures_par_categorie' => [
                        'labels' => $candidaturesParCategorieLabels,
                        'data' => $candidaturesParCategorieData
                    ],
                    'vues_par_offre' => [
                        'labels' => $vuesParOffreLabels,
                        'data' => $vuesParOffreData
                    ],
                    'candidatures_par_mois' => [
                        'labels' => $candidaturesParMoisLabels,
                        'data' => $candidaturesParMoisData
                    ],
                    'repartition_candidatures' => [
                        'labels' => ['Acceptés', 'Refusés', 'En attente'],
                        'data' => [
                            $stats['candidats_acceptes'],
                            $stats['candidats_refuses'],
                            $stats['candidats_en_attente']
                        ]
                    ]
                ],
                'taux' => [
                    'acceptation' => $tauxAcceptation,
                    'refus' => $tauxRefus
                ],
                'period' => [
                    'type' => $period,
                    'start' => $startDate,
                    'end' => $endDate
                ]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques: ' . $e->getMessage()
            ]);
        }
        break;

    case 'export_stats':
        // Récupération des statistiques complètes pour l'export
        try {
            $stats = getAllStatistiques($db, $_SESSION['compte_entreprise']);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de l\'export des statistiques: ' . $e->getMessage()
            ]);
        }
        break;

    default:
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Action non reconnue'
        ]);
        break;
}