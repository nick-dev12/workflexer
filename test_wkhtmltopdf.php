<?php
/**
 * Script de test pour wkhtmltopdf
 * WorkFlexer - Système de CV personnalisables
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'model_cv/WkhtmltopdfGenerator.php';
require_once 'model_cv/WkhtmltopdfConfig.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test wkhtmltopdf - WorkFlexer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .status {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .button {
            background-color: #007cba;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover {
            background-color: #005a87;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test de wkhtmltopdf pour WorkFlexer</h1>
        <p>Ce script vérifie que wkhtmltopdf est correctement installé et configuré.</p>
    </div>

    <?php
    // Test 1 : Vérification de l'installation
    echo '<div class="container">';
    echo '<h2>📋 Test 1 : Vérification de l\'installation</h2>';
    
    try {
        $generator = new WkhtmltopdfGenerator();
        $installCheck = $generator->checkInstallation();
        
        if ($installCheck['installed']) {
            echo '<div class="status success">';
            echo '<h3>✅ wkhtmltopdf est installé</h3>';
            echo '<p><strong>Version :</strong> ' . htmlspecialchars($installCheck['version'] ?? 'Inconnue') . '</p>';
            echo '<p><strong>Chemin :</strong> ' . htmlspecialchars($installCheck['path']) . '</p>';
            echo '</div>';
        } else {
            echo '<div class="status error">';
            echo '<h3>❌ wkhtmltopdf n\'est pas installé</h3>';
            echo '<p><strong>Erreur :</strong> ' . htmlspecialchars($installCheck['error']) . '</p>';
            echo '<p><a href="install_wkhtmltopdf.php" class="button">🔧 Installer wkhtmltopdf</a></p>';
            echo '</div>';
        }
    } catch (Exception $e) {
        echo '<div class="status error">';
        echo '<h3>❌ Erreur lors de la vérification</h3>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '</div>';
    }
    echo '</div>';

    // Test 2 : Configuration PHP
    echo '<div class="container">';
    echo '<h2>⚙️ Test 2 : Configuration PHP</h2>';
    
    $phpTests = [
        'Version PHP' => [
            'test' => version_compare(PHP_VERSION, '8.0.0', '>='),
            'value' => PHP_VERSION,
            'expected' => '8.0.0+'
        ],
        'Extension exec' => [
            'test' => function_exists('exec'),
            'value' => function_exists('exec') ? 'Disponible' : 'Non disponible',
            'expected' => 'Disponible'
        ],
        'Extension shell_exec' => [
            'test' => function_exists('shell_exec'),
            'value' => function_exists('shell_exec') ? 'Disponible' : 'Non disponible',
            'expected' => 'Disponible'
        ]
    ];
    
    echo '<table>';
    echo '<tr><th>Test</th><th>Résultat</th><th>Attendu</th><th>Statut</th></tr>';
    
    foreach ($phpTests as $testName => $test) {
        $status = $test['test'] ? '✅' : '❌';
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($testName) . '</td>';
        echo '<td>' . htmlspecialchars($test['value']) . '</td>';
        echo '<td>' . htmlspecialchars($test['expected']) . '</td>';
        echo '<td style="color: ' . ($test['test'] ? 'green' : 'red') . '">' . $status . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo '</div>';

    // Test 3 : Test de génération PDF simple
    echo '<div class="container">';
    echo '<h2>📄 Test 3 : Génération PDF simple</h2>';
    
    if (isset($_POST['test_simple_pdf'])) {
        try {
            // Créer un fichier HTML temporaire pour le test
            $testHtml = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test PDF WorkFlexer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { background-color: #007cba; color: white; padding: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 Test PDF WorkFlexer</h1>
        <p>Génération réussie avec wkhtmltopdf</p>
    </div>
    <p><strong>Date :</strong> ' . date('d/m/Y H:i:s') . '</p>
    <p><strong>Version PHP :</strong> ' . PHP_VERSION . '</p>
</body>
</html>';
            
            $tempHtmlFile = sys_get_temp_dir() . '/test_workflexer_' . uniqid() . '.html';
            file_put_contents($tempHtmlFile, $testHtml);
            
            $generator = new WkhtmltopdfGenerator();
            $pdfPath = $generator->generateFromUrl($tempHtmlFile);
            
            // Lire le contenu du PDF
            $pdfContent = file_get_contents($pdfPath);
            
            // Nettoyer les fichiers temporaires
            unlink($tempHtmlFile);
            unlink($pdfPath);
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="test_workflexer_' . date('Y-m-d_H-i-s') . '.pdf"');
            header('Content-Length: ' . strlen($pdfContent));
            echo $pdfContent;
            exit;
            
        } catch (Exception $e) {
            echo '<div class="status error">';
            echo '<h3>❌ Erreur lors du test</h3>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>Cliquez sur le bouton pour générer un PDF de test :</p>';
        echo '<form method="post">';
        echo '<button type="submit" name="test_simple_pdf" class="button">📄 Générer PDF de test</button>';
        echo '</form>';
    }
    echo '</div>';

    // Test 4 : Configuration des modèles
    echo '<div class="container">';
    echo '<h2>🎨 Test 4 : Configuration des modèles</h2>';
    
    $models = ['1', '10', '11', '15'];
    
    echo '<table>';
    echo '<tr><th>Modèle</th><th>Fichier</th><th>Statut</th></tr>';
    
    foreach ($models as $model) {
        $modelFile = "model_cv/model{$model}.php";
        $fileExists = file_exists($modelFile);
        
        echo '<tr>';
        echo '<td>Modèle ' . htmlspecialchars($model) . '</td>';
        echo '<td>' . ($fileExists ? '✅ Existe' : '❌ Manquant') . '</td>';
        echo '<td>' . ($fileExists ? '✅ Prêt' : '❌ Non disponible') . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo '</div>';
    ?>

    <div class="container">
        <h2>📚 Ressources utiles</h2>
        <ul>
            <li><a href="GUIDE_WKHTMLTOPDF.md">📖 Guide d'implémentation complet</a></li>
            <li><a href="install_wkhtmltopdf.php">🔧 Installation de wkhtmltopdf</a></li>
            <li><a href="model_cv/">📁 Dossier des modèles de CV</a></li>
        </ul>
    </div>
</body>
</html> 