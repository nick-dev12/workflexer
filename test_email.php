<?php
// Script de test pour diagnostiquer les problèmes d'email SMTP
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Test SMTP</title></head><body>";
echo "<h1>Diagnostic des problèmes SMTP Work-Flexer</h1>";

// Test de résolution DNS
echo "<h2>1. Test de résolution DNS</h2>";
$host = 'mail.work-flexer.com';
$ip = gethostbyname($host);
echo "Résolution DNS pour $host: $ip<br>";

if ($ip === $host) {
    echo "<div style='color: red;'>❌ Impossible de résoudre le nom d'hôte</div>";
} else {
    echo "<div style='color: green;'>✅ Résolution DNS réussie</div>";
}

// Test de connectivité réseau
echo "<h2>2. Test de connectivité réseau</h2>";
$ports = [25, 587, 465];

foreach ($ports as $port) {
    $connection = @fsockopen($host, $port, $errno, $errstr, 10);
    if ($connection) {
        echo "<div style='color: green;'>✅ Port $port accessible</div>";
        fclose($connection);
    } else {
        echo "<div style='color: red;'>❌ Port $port inaccessible: $errstr ($errno)</div>";
    }
}

// Configuration de test robuste
echo "<h2>3. Test de configuration SMTP</h2>";

function testSMTPConfiguration() {
    $mail = new PHPMailer(true);
    
    try {
        // Configuration SMTP robuste
        $mail->isSMTP();
        $mail->Host = 'mail.work-flexer.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'service@work-flexer.com';
        $mail->Password = 'Ludvanne12@gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Options SSL pour contourner les problèmes de certificat
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
                'cafile' => false,
                'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT
            )
        );
        
        // Configuration de débogage
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = 'html';
        
        // Timeout
        $mail->Timeout = 60;
        $mail->SMTPKeepAlive = true;
        
        // Test de connexion
        echo "<h3>Tentative de connexion SMTP...</h3>";
        if ($mail->smtpConnect()) {
            echo "<div style='color: green; font-weight: bold;'>✅ Connexion SMTP réussie!</div>";
            $mail->smtpClose();
            return true;
        } else {
            echo "<div style='color: red; font-weight: bold;'>❌ Échec de la connexion SMTP</div>";
            return false;
        }
        
    } catch (Exception $e) {
        echo "<div style='color: red; font-weight: bold;'>❌ Erreur SMTP: " . $e->getMessage() . "</div>";
        echo "<div style='color: red;'>Détails: " . $mail->ErrorInfo . "</div>";
        return false;
    }
}

testSMTPConfiguration();

echo "</body></html>";
?> 