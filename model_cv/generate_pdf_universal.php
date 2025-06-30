<?php
/**
 * Générateur PDF universel pour tous les modèles de CV
 * WorkFlexer - Système de CV personnalisables
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 120);

require_once 'WkhtmltopdfGenerator.php';
require_once 'WkhtmltopdfConfig.php';

// Vérifier les paramètres
$modelNumber = $_GET['model'] ?? $_POST['model'] ?? '1';
$action = $_GET['action'] ?? $_POST['action'] ?? 'download';

// Valider le numéro de modèle
if (!preg_match('/^\d+$/', $modelNumber) || !file_exists("model{$modelNumber}.php")) {
    die(json_encode(['error' => 'Modèle de CV invalide : ' . $modelNumber]));
}

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
    // Initialiser le générateur PDF
    $pdfGenerator = new WkhtmltopdfGenerator();
    
    // Vérifier l'installation de wkhtmltopdf
    $installCheck = $pdfGenerator->checkInstallation();
    if (!$installCheck['installed']) {
        throw new Exception('wkhtmltopdf n\'est pas correctement installé : ' . $installCheck['error']);
    }
    
    // Préparer les données utilisateur pour le modèle
    $userData = [
        'userss' => $userss ?? [],
        'descriptions' => $descriptions ?? [],
        'afficheMetier' => $afficheMetier ?? [],
        'afficheCompetence' => $afficheCompetence ?? [],
        'afficheFormation' => $afficheFormation ?? [],
        'afficheDiplome' => $afficheDiplome ?? [],
        'afficheCertificat' => $afficheCertificat ?? [],
        'afficheOutil' => $afficheOutil ?? [],
        'afficheLangue' => $afficheLangue ?? [],
        'afficheProjet' => $afficheProjet ?? [],
        'afficheCentre' => $afficheCentre ?? []
    ];
    
    // Configuration par défaut
    $defaultOptions = WkhtmltopdfConfig::getDefaultConfig();
    
    // Configuration spécifique au modèle
    $modelOptions = WkhtmltopdfConfig::getModelConfig($modelNumber);
    
    // Fusionner les options
    $customOptions = array_merge($defaultOptions, $modelOptions);
    
    // Configurer les options spécifiques au modèle
    $pdfGenerator->setModelSpecificOptions($modelNumber);
    
    // Générer le nom de fichier
    $filename = 'CV_Model' . $modelNumber . '_' . 
                ($userss['nom'] ?? 'Utilisateur') . '_' . 
                date('Y-m-d') . '.pdf';
    
    // Nettoyer le nom de fichier
    $filename = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $filename);
    
    // Actions possibles
    switch ($action) {
        case 'download':
            // Téléchargement direct
            $pdfGenerator->downloadCvPdf($modelNumber, $userData, $filename, $customOptions);
            break;
            
        case 'save':
            // Sauvegarder le fichier
            $pdfPath = $pdfGenerator->generateCvPdf($modelNumber, $userData, $customOptions);
            echo json_encode([
                'success' => true,
                'message' => 'PDF généré avec succès',
                'path' => $pdfPath,
                'filename' => $filename
            ]);
            break;
            
        case 'preview':
            // Aperçu
            $pdfContent = $pdfGenerator->generateCvPdfString($modelNumber, $userData, $customOptions);
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $filename . '"');
            header('Content-Length: ' . strlen($pdfContent));
            echo $pdfContent;
            break;
            
        case 'check':
            // Vérification sans génération
            echo json_encode([
                'success' => true,
                'message' => 'Configuration valide',
                'model' => $modelNumber,
                'options' => $customOptions,
                'wkhtmltopdf' => $installCheck
            ]);
            break;
            
        default:
            throw new Exception('Action non reconnue : ' . $action);
    }
    
} catch (Exception $e) {
    // Log l'erreur
    error_log("Erreur génération PDF Model {$modelNumber}: " . $e->getMessage());
    
    // Retourner une erreur JSON
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'message' => 'Erreur lors de la génération du PDF : ' . $e->getMessage(),
        'model' => $modelNumber
    ]);
    exit;
}
?> 