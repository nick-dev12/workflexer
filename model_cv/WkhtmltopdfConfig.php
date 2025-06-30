<?php

/**
 * Configuration centralisée pour wkhtmltopdf
 * WorkFlexer - Système de CV personnalisables
 */

class WkhtmltopdfConfig
{
    /**
     * Configuration par défaut pour tous les modèles
     */
    public static function getDefaultConfig()
    {
        return [
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
            'viewport-size' => '1024x768'
        ];
    }
    
    /**
     * Configuration spécifique par modèle
     */
    public static function getModelConfig($modelNumber)
    {
        $configs = [
            '1' => [
                'page-width' => '210mm',
                'page-height' => '297mm',
                'zoom' => 1.0,
                'javascript-delay' => 2000
            ],
            '10' => [
                'zoom' => 0.95,
                'javascript-delay' => 3000,
                'enable-javascript' => true
            ],
            '11' => [
                'zoom' => 0.95,
                'javascript-delay' => 3000,
                'enable-javascript' => true
            ],
            '15' => [
                'zoom' => 0.95,
                'javascript-delay' => 3000,
                'enable-javascript' => true
            ]
        ];
        
        return $configs[$modelNumber] ?? [];
    }
    
    /**
     * Détection automatique des chemins wkhtmltopdf selon l'OS
     */
    public static function detectWkhtmltopdfPaths()
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        
        if ($isWindows) {
            return [
                'C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
                'C:\\Program Files (x86)\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
                'C:\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
                'wkhtmltopdf.exe'
            ];
        } else {
            return [
                '/usr/local/bin/wkhtmltopdf',
                '/usr/bin/wkhtmltopdf',
                'wkhtmltopdf'
            ];
        }
    }
    
    /**
     * Configuration pour la qualité d'impression
     */
    public static function getHighQualityConfig()
    {
        return [
            'dpi' => 300,
            'image-quality' => 100,
            'image-dpi' => 300,
            'lowquality' => false,
            'print-media-type' => true,
            'disable-smart-shrinking' => true
        ];
    }
    
    /**
     * Configuration pour la vitesse (qualité réduite)
     */
    public static function getFastConfig()
    {
        return [
            'dpi' => 150,
            'image-quality' => 75,
            'image-dpi' => 150,
            'lowquality' => true,
            'javascript-delay' => 1000
        ];
    }
    
    /**
     * Configuration pour le debug
     */
    public static function getDebugConfig()
    {
        return [
            'debug-javascript' => true,
            'load-error-handling' => 'abort',
            'load-media-error-handling' => 'abort'
        ];
    }
    
    /**
     * Styles CSS à injecter pour optimiser le rendu PDF
     */
    public static function getPdfOptimizationCss()
    {
        return '
        <style>
            /* Optimisations globales pour PDF */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            body {
                margin: 0 !important;
                padding: 0 !important;
                font-family: "Arial", "Helvetica", sans-serif !important;
                -webkit-font-smoothing: antialiased !important;
            }
            
            img {
                max-width: 100% !important;
                height: auto !important;
            }
            
            /* Masquer les éléments de personnalisation */
            .personnalisation,
            .customizer-panel,
            #toggle-customization-btn,
            .close-panel-btn {
                display: none !important;
            }
            
            /* Assurer la visibilité des contenus principaux */
            .container,
            .cv-container,
            #container {
                position: relative !important;
                left: auto !important;
                top: auto !important;
                transform: none !important;
                margin: 0 auto !important;
            }
        </style>';
    }
    
    /**
     * Headers HTML pour une meilleure compatibilité
     */
    public static function getHtmlHeaders()
    {
        return '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="robots" content="noindex, nofollow">
            ' . self::getPdfOptimizationCss() . '
        </head>
        <body>';
    }
    
    /**
     * Footer HTML
     */
    public static function getHtmlFooter()
    {
        return '</body></html>';
    }
    
    /**
     * Validation des options
     */
    public static function validateOptions($options)
    {
        $validOptions = [
            'page-size', 'orientation', 'margin-top', 'margin-right', 
            'margin-bottom', 'margin-left', 'encoding', 'enable-local-file-access',
            'enable-javascript', 'javascript-delay', 'no-stop-slow-scripts',
            'debug-javascript', 'load-error-handling', 'load-media-error-handling',
            'disable-smart-shrinking', 'print-media-type', 'dpi', 'image-quality',
            'image-dpi', 'lowquality', 'minimum-font-size', 'zoom', 'viewport-size'
        ];
        
        $validated = [];
        foreach ($options as $key => $value) {
            if (in_array($key, $validOptions)) {
                $validated[$key] = $value;
            }
        }
        
        return $validated;
    }
} 