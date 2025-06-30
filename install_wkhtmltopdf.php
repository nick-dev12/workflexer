<?php
/**
 * Script d'installation automatique de wkhtmltopdf
 * WorkFlexer - Système de CV personnalisables
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 300); // 5 minutes

class WkhtmltopdfInstaller
{
    private $downloadUrl = 'https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox-0.12.6-1.msvc2015-win64.exe';
    private $installerPath;
    private $installPath = 'C:\\Program Files\\wkhtmltopdf';
    
    public function __construct()
    {
        $this->installerPath = __DIR__ . '/wkhtmltopdf-installer.exe';
    }
    
    /**
     * Lance l'installation complète
     */
    public function install()
    {
        try {
            echo "<h2>🚀 Installation de wkhtmltopdf pour WorkFlexer</h2>";
            
            // Vérifier si déjà installé
            if ($this->isInstalled()) {
                echo "<p style='color: green;'>✅ wkhtmltopdf est déjà installé !</p>";
                $this->showInstallationInfo();
                return true;
            }
            
            // Télécharger l'installateur
            echo "<p>📥 Téléchargement de l'installateur...</p>";
            if (!$this->downloadInstaller()) {
                throw new Exception("Échec du téléchargement");
            }
            
            // Lancer l'installation
            echo "<p>🔧 Lancement de l'installation...</p>";
            $this->runInstaller();
            
            // Vérifier l'installation
            if ($this->isInstalled()) {
                echo "<p style='color: green;'>✅ Installation réussie !</p>";
                $this->showInstallationInfo();
                $this->cleanup();
                return true;
            } else {
                throw new Exception("L'installation semble avoir échoué");
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
            return false;
        }
    }
    
    /**
     * Vérifie si wkhtmltopdf est installé
     */
    private function isInstalled()
    {
        $paths = [
            'C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe',
            'C:\\Program Files (x86)\\wkhtmltopdf\\bin\\wkhtmltopdf.exe'
        ];
        
        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return false;
    }
    
    /**
     * Télécharge l'installateur
     */
    private function downloadInstaller()
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => 120,
                'user_agent' => 'WorkFlexer PDF Generator'
            ]
        ]);
        
        $data = file_get_contents($this->downloadUrl, false, $context);
        
        if ($data === false) {
            return false;
        }
        
        return file_put_contents($this->installerPath, $data) !== false;
    }
    
    /**
     * Lance l'installateur
     */
    private function runInstaller()
    {
        if (!file_exists($this->installerPath)) {
            throw new Exception("Installateur non trouvé");
        }
        
        echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>📋 Instructions d'installation :</h3>";
        echo "<ol>";
        echo "<li>L'installateur va s'ouvrir dans une nouvelle fenêtre</li>";
        echo "<li>Suivez les étapes d'installation (Next → Next → Install)</li>";
        echo "<li>Acceptez les permissions d'administrateur si demandées</li>";
        echo "<li>Une fois terminé, revenez sur cette page et actualisez</li>";
        echo "</ol>";
        echo "</div>";
        
        // Lancer l'installateur en mode silencieux si possible
        $command = '"' . $this->installerPath . '"';
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen("start /B " . $command, "r"));
        } else {
            exec($command . " > /dev/null 2>&1 &");
        }
        
        echo "<p>🔄 Installateur lancé. Veuillez suivre les instructions dans la fenêtre qui s'est ouverte.</p>";
    }
    
    /**
     * Affiche les informations d'installation
     */
    private function showInstallationInfo()
    {
        $path = $this->isInstalled();
        if ($path) {
            echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<h3>ℹ️ Informations d'installation :</h3>";
            echo "<p><strong>Chemin :</strong> " . htmlspecialchars($path) . "</p>";
            
            // Tester la version
            $version = $this->getVersion($path);
            if ($version) {
                echo "<p><strong>Version :</strong> " . htmlspecialchars($version) . "</p>";
            }
            
            echo "<p><strong>Statut :</strong> <span style='color: green;'>✅ Opérationnel</span></p>";
            echo "</div>";
        }
    }
    
    /**
     * Récupère la version de wkhtmltopdf
     */
    private function getVersion($path)
    {
        $command = '"' . $path . '" --version 2>&1';
        $output = shell_exec($command);
        
        if ($output && preg_match('/wkhtmltopdf\s+([\d\.]+)/', $output, $matches)) {
            return $matches[1];
        }
        
        return null;
    }
    
    /**
     * Nettoie les fichiers temporaires
     */
    private function cleanup()
    {
        if (file_exists($this->installerPath)) {
            unlink($this->installerPath);
        }
    }
    
    /**
     * Teste la génération d'un PDF simple
     */
    public function testPdfGeneration()
    {
        $path = $this->isInstalled();
        if (!$path) {
            return false;
        }
        
        $testHtml = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test PDF</title>
</head>
<body>
    <h1>Test de génération PDF</h1>
    <p>Si vous voyez ce texte, wkhtmltopdf fonctionne correctement !</p>
    <p>Date de test : ' . date('Y-m-d H:i:s') . '</p>
</body>
</html>';
        
        $testHtmlFile = sys_get_temp_dir() . '/test_wkhtmltopdf.html';
        $testPdfFile = sys_get_temp_dir() . '/test_wkhtmltopdf.pdf';
        
        file_put_contents($testHtmlFile, $testHtml);
        
        $command = '"' . $path . '" "' . $testHtmlFile . '" "' . $testPdfFile . '" 2>&1';
        $output = shell_exec($command);
        
        $success = file_exists($testPdfFile) && filesize($testPdfFile) > 0;
        
        // Nettoyer
        if (file_exists($testHtmlFile)) unlink($testHtmlFile);
        if (file_exists($testPdfFile)) unlink($testPdfFile);
        
        return $success;
    }
}

// Interface web
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation wkhtmltopdf - WorkFlexer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .button {
            background-color: #007cba;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover {
            background-color: #005a87;
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
        .warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Installation wkhtmltopdf pour WorkFlexer</h1>
        
        <?php
        if (isset($_POST['action'])) {
            $installer = new WkhtmltopdfInstaller();
            
            switch ($_POST['action']) {
                case 'install':
                    $installer->install();
                    break;
                    
                case 'test':
                    echo "<h3>🧪 Test de génération PDF</h3>";
                    if ($installer->testPdfGeneration()) {
                        echo "<div class='status success'>✅ Test réussi ! wkhtmltopdf fonctionne parfaitement.</div>";
                    } else {
                        echo "<div class='status error'>❌ Test échoué. Vérifiez l'installation.</div>";
                    }
                    break;
            }
        } else {
            $installer = new WkhtmltopdfInstaller();
            
            echo "<p>Cet outil va installer <strong>wkhtmltopdf</strong> sur votre système Windows pour permettre la génération de PDF haute qualité dans WorkFlexer.</p>";
            
            if ($installer->isInstalled()) {
                echo "<div class='status success'>✅ wkhtmltopdf est déjà installé sur votre système !</div>";
                echo "<form method='post'>";
                echo "<button type='submit' name='action' value='test' class='button'>🧪 Tester la génération PDF</button>";
                echo "</form>";
            } else {
                echo "<div class='status warning'>⚠️ wkhtmltopdf n'est pas installé sur votre système.</div>";
                echo "<form method='post'>";
                echo "<button type='submit' name='action' value='install' class='button'>🚀 Installer wkhtmltopdf</button>";
                echo "</form>";
            }
        }
        ?>
        
        <hr style="margin: 30px 0;">
        
        <h3>📚 Informations importantes :</h3>
        <ul>
            <li><strong>Système requis :</strong> Windows 7/10/11 (64-bit)</li>
            <li><strong>Permissions :</strong> Droits d'administrateur requis</li>
            <li><strong>Taille :</strong> Environ 25 MB</li>
            <li><strong>Installation :</strong> Automatique avec interface graphique</li>
        </ul>
        
        <h3>🔍 Que fait cet outil ?</h3>
        <ol>
            <li>Télécharge la dernière version stable de wkhtmltopdf</li>
            <li>Lance l'installateur Windows</li>
            <li>Configure automatiquement WorkFlexer pour utiliser wkhtmltopdf</li>
            <li>Teste la génération de PDF</li>
        </ol>
        
        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
            <h4>🆘 Besoin d'aide ?</h4>
            <p>Si vous rencontrez des problèmes :</p>
            <ul>
                <li>Assurez-vous d'avoir les droits d'administrateur</li>
                <li>Désactivez temporairement votre antivirus</li>
                <li>Vérifiez votre connexion internet</li>
                <li>Redémarrez votre serveur web après l'installation</li>
            </ul>
        </div>
    </div>
</body>
</html> 