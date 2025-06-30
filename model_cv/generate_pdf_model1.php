<?php
/**
 * Générateur PDF pour le modèle 1 avec mikehaertl/phpwkhtmltopdf
 * WorkFlexer - Système de CV personnalisables
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 120);

// Inclure l'autoloader de Composer et la configuration
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/WkhtmltopdfConfig.php';

use mikehaertl\wkhtmltopdf\Pdf;

// Inclure les contrôleurs nécessaires
if (isset($_SESSION['users'])) {
    $user_id = $_SESSION['users'];
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_centre_interet.php');
} else {
    die(json_encode(['error' => 'Session utilisateur non trouvée']));
}

try {
    // --- Détection du chemin de wkhtmltopdf ---
    $wkhtmltopdfPath = null;
    foreach (WkhtmltopdfConfig::detectWkhtmltopdfPaths() as $path) {
        if (file_exists($path)) {
            $wkhtmltopdfPath = $path;
            break;
        }
    }
    if (!$wkhtmltopdfPath) {
        // Tenter de trouver via la commande 'where' sur Windows
        $whereOutput = shell_exec('where wkhtmltopdf.exe');
        if (!empty($whereOutput)) {
            $wkhtmltopdfPath = trim(explode("\n", $whereOutput)[0]);
        }
    }

    if (!$wkhtmltopdfPath) {
        throw new Exception("Exécutable wkhtmltopdf introuvable. Veuillez vérifier l'installation et le PATH.");
    }

    // --- Préparation des données et du contenu HTML ---
    ob_start();
    include 'model1.php'; // Inclure directement le template du modèle 1
    $htmlContent = ob_get_clean();

    // --- Configuration des options PDF ---
    $defaultOptions = WkhtmltopdfConfig::getDefaultConfig();
    $modelOptions = WkhtmltopdfConfig::getModelConfig('1');
    $finalOptions = array_merge($defaultOptions, $modelOptions);
    
    // mikehaertl/phpwkhtmltopdf utilise un format légèrement différent pour certaines options
    $pdf = new Pdf([
        'binary' => $wkhtmltopdfPath,
        'commandOptions' => $finalOptions,
    ]);

    // --- Génération et envoi du PDF ---
    $pdf->addPage($htmlContent);

    // Générer le nom de fichier
    $filename = 'CV_Model1_' .
                (isset($userss['nom']) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $userss['nom']) : 'Utilisateur') . '_' .
                date('Y-m-d') . '.pdf';

    if (!$pdf->send($filename)) {
        throw new Exception('Erreur lors de la génération du PDF : ' . $pdf->getError());
    }

} catch (Exception $e) {
    // Log l'erreur
    error_log("Erreur génération PDF Model 1: " . $e->getMessage());

    // Retourner une erreur JSON
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'message' => 'Erreur lors de la génération du PDF : ' . $e->getMessage()
    ]);
    exit;
}
?> 