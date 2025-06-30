<?php

/**
 * Classe pour générer des PDF de haute qualité avec wkhtmltopdf
 * Optimisée pour les modèles de CV WorkFlexer
 * 
 * @author WorkFlexer Team
 * @version 1.0
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Knp\Snappy\Pdf;

class WkhtmltopdfGenerator
{
    private $snappy;
    private $options;
    private $wkhtmltopdfPath;
    
    public function __construct()
    {
        // Chemin vers l'exécutable wkhtmltopdf (à ajuster selon votre installation)
        $this->wkhtmltopdfPath = $this->detectWkhtmltopdfPath();
        
        if (!$this->wkhtmltopdfPath) {
            throw new Exception("wkhtmltopdf n'est pas installé ou introuvable. Veuillez l'installer d'abord.");
        }
        
        // Initialiser Snappy avec le chemin vers wkhtmltopdf
        $this->snappy = new Pdf($this->wkhtmltopdfPath);
        
        // Configuration par défaut optimisée pour les CV
        $this->options = [
            'page-size' => 'A4',
            'orientation' => 'Portrait',
            'margin-top' => '0mm',
            'margin-right' => '0mm',
            'margin-bottom' => '0mm',
            'margin-left' => '0mm',
            'encoding' => 'UTF-8',
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'javascript-delay' => 2000,
            'no-stop-slow-scripts' => true,
            'debug-javascript' => false,
            'load-error-handling' => 'ignore',
            'load-media-error-handling' => 'ignore',
            'disable-smart-shrinking' => true,
            'print-media-type' => true,
            'dpi' => 300,
            'image-quality' => 100,
            'image-dpi' => 300,
            'lowquality' => false,
            'minimum-font-size' => 8,
            'zoom' => 1.0,
            'viewport-size' => '1024x768',
            'cookie-jar' => sys_get_temp_dir() . '/wkhtmltopdf_cookies.txt'
        ];
        
        $this->snappy->setOptions($this->options);
    }
    
    /**
     * Détecte automatiquement le chemin vers wkhtmltopdf
     */
    private function detectWkhtmltopdfPath()
    {
        $possiblePaths = [
            'C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
            'C:\\Program Files (x86)\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
            'C:\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
            'wkhtmltopdf' // Si dans le PATH
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path) || $this->commandExists($path)) {
                return $path;
            }
        }
        
        return null;
    }
    
    /**
     * Vérifie si une commande existe dans le système
     */
    private function commandExists($command)
    {
        $return = shell_exec(sprintf("where %s 2>NUL", escapeshellarg($command)));
        return !empty($return);
    }
    
    /**
     * Génère un PDF à partir d'un modèle de CV
     * 
     * @param string $modelNumber Numéro du modèle (1, 2, 3, etc.)
     * @param array $userData Données de l'utilisateur
     * @param array $customOptions Options personnalisées
     * @return string Chemin vers le fichier PDF généré
     */
    public function generateCvPdf($modelNumber, $userData, $customOptions = [])
    {
        try {
            // Fusionner les options personnalisées
            $options = array_merge($this->options, $customOptions);
            $this->snappy->setOptions($options);
            
            // Générer l'HTML du CV
            $htmlContent = $this->generateHtmlForModel($modelNumber, $userData);
            
            // Nom du fichier PDF de sortie
            $outputPath = $this->generateOutputPath($modelNumber, $userData);
            
            // Générer le PDF
            $this->snappy->generateFromHtml($htmlContent, $outputPath);
            
            return $outputPath;
            
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la génération du PDF : " . $e->getMessage());
        }
    }
    
    /**
     * Génère un PDF à partir d'une URL
     * 
     * @param string $url URL du modèle de CV
     * @param string $outputPath Chemin de sortie du PDF
     * @param array $customOptions Options personnalisées
     * @return string Chemin vers le fichier PDF généré
     */
    public function generateFromUrl($url, $outputPath = null, $customOptions = [])
    {
        try {
            // Fusionner les options personnalisées
            $options = array_merge($this->options, $customOptions);
            $this->snappy->setOptions($options);
            
            if (!$outputPath) {
                $outputPath = $this->generateTempOutputPath();
            }
            
            // Générer le PDF depuis l'URL
            $this->snappy->generate($url, $outputPath);
            
            return $outputPath;
            
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la génération du PDF depuis l'URL : " . $e->getMessage());
        }
    }
    
    /**
     * Génère le contenu HTML pour un modèle spécifique
     */
    private function generateHtmlForModel($modelNumber, $userData)
    {
        $modelPath = __DIR__ . "/model{$modelNumber}.php";
        
        if (!file_exists($modelPath)) {
            throw new Exception("Le modèle {$modelNumber} n'existe pas.");
        }
        
        // Démarrer la capture de sortie
        ob_start();
        
        // Inclure le modèle avec les données utilisateur
        extract($userData);
        include $modelPath;
        
        // Récupérer le contenu HTML
        $htmlContent = ob_get_clean();
        
        // Optimiser le HTML pour wkhtmltopdf
        $htmlContent = $this->optimizeHtmlForPdf($htmlContent);
        
        return $htmlContent;
    }
    
    /**
     * Optimise le HTML pour une meilleure génération PDF
     */
    private function optimizeHtmlForPdf($html)
    {
        // Ajouter les métadonnées nécessaires
        $htmlOptimized = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        /* Optimisations PDF */
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        img {
            max-width: 100%;
            height: auto;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        
        /* Masquer les éléments de personnalisation */
        .personnalisation,
        .customizer-panel,
        .bottom-edit-toolbar,
        .floating-preview-controls,
        #toggle-customization-btn,
        .close-panel-btn {
            display: none !important;
        }
        
        /* Assurer la visibilité des contenus principaux */
        .container,
        .cv-container,
        .cv10,
        .cv11,
        .cv12,
        .cv13,
        .cv15 {
            position: relative !important;
            left: auto !important;
            top: auto !important;
            transform: none !important;
            margin: 0 auto !important;
        }
    </style>
</head>
<body>';
        
        // Extraire le contenu du body si présent
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
            $htmlOptimized .= $matches[1];
        } else {
            $htmlOptimized .= $html;
        }
        
        $htmlOptimized .= '</body></html>';
        
        return $htmlOptimized;
    }
    
    /**
     * Génère le chemin de sortie pour le PDF
     */
    private function generateOutputPath($modelNumber, $userData)
    {
        $outputDir = __DIR__ . '/../generated_pdf/';
        
        // Créer le dossier s'il n'existe pas
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }
        
        $fileName = 'cv_model' . $modelNumber . '_' . 
                   ($userData['nom'] ?? 'utilisateur') . '_' . 
                   date('Y-m-d_H-i-s') . '.pdf';
        
        // Nettoyer le nom de fichier
        $fileName = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $fileName);
        
        return $outputDir . $fileName;
    }
    
    /**
     * Génère un chemin temporaire pour le PDF
     */
    private function generateTempOutputPath()
    {
        return sys_get_temp_dir() . '/cv_' . uniqid() . '.pdf';
    }
    
    /**
     * Configure les options spécifiques à un modèle
     */
    public function setModelSpecificOptions($modelNumber)
    {
        $modelOptions = [];
        
        switch ($modelNumber) {
            case '1':
                $modelOptions = [
                    'page-width' => '210mm',
                    'page-height' => '297mm',
                    'zoom' => 1.0
                ];
                break;
                
            case '10':
            case '11':
            case '12':
            case '13':
            case '15':
                $modelOptions = [
                    'javascript-delay' => 3000,
                    'zoom' => 0.95
                ];
                break;
                
            default:
                $modelOptions = [
                    'zoom' => 1.0
                ];
        }
        
        $this->snappy->setOptions(array_merge($this->options, $modelOptions));
    }
    
    /**
     * Retourne le PDF en tant que chaîne binaire
     */
    public function generateCvPdfString($modelNumber, $userData, $customOptions = [])
    {
        try {
            $options = array_merge($this->options, $customOptions);
            $this->snappy->setOptions($options);
            
            $htmlContent = $this->generateHtmlForModel($modelNumber, $userData);
            
            return $this->snappy->getOutputFromHtml($htmlContent);
            
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la génération du PDF : " . $e->getMessage());
        }
    }
    
    /**
     * Télécharge directement le PDF vers le navigateur
     */
    public function downloadCvPdf($modelNumber, $userData, $filename = null, $customOptions = [])
    {
        try {
            $pdfContent = $this->generateCvPdfString($modelNumber, $userData, $customOptions);
            
            if (!$filename) {
                $filename = 'cv_model' . $modelNumber . '_' . 
                           ($userData['nom'] ?? 'utilisateur') . '.pdf';
            }
            
            // Nettoyer le nom de fichier
            $filename = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $filename);
            
            // Headers pour le téléchargement
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . strlen($pdfContent));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            echo $pdfContent;
            exit;
            
        } catch (Exception $e) {
            throw new Exception("Erreur lors du téléchargement du PDF : " . $e->getMessage());
        }
    }
    
    /**
     * Vérifie si wkhtmltopdf est correctement installé
     */
    public function checkInstallation()
    {
        try {
            $version = $this->snappy->getVersion();
            return [
                'installed' => true,
                'version' => $version,
                'path' => $this->wkhtmltopdfPath
            ];
        } catch (Exception $e) {
            return [
                'installed' => false,
                'error' => $e->getMessage(),
                'path' => $this->wkhtmltopdfPath
            ];
        }
    }
    
    /**
     * Configure les en-têtes et pieds de page
     */
    public function setHeaderFooter($headerHtml = null, $footerHtml = null)
    {
        $options = [];
        
        if ($headerHtml) {
            $options['header-html'] = $headerHtml;
            $options['header-spacing'] = 5;
        }
        
        if ($footerHtml) {
            $options['footer-html'] = $footerHtml;
            $options['footer-spacing'] = 5;
        }
        
        $this->snappy->setOptions(array_merge($this->options, $options));
    }
    
    /**
     * Active le mode debug pour diagnostiquer les problèmes
     */
    public function enableDebug($enable = true)
    {
        $debugOptions = [
            'debug-javascript' => $enable,
            'load-error-handling' => $enable ? 'abort' : 'ignore'
        ];
        
        $this->snappy->setOptions(array_merge($this->options, $debugOptions));
    }
} 