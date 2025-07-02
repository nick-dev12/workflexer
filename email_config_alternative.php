<?php
/**
 * Configurations alternatives pour l'envoi d'emails
 * À utiliser en cas de problème avec le serveur SMTP principal
 */

// Configuration 1: Gmail SMTP (recommandé comme backup)
function getGmailConfig() {
    return [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'secure' => PHPMailer::ENCRYPTION_STARTTLS,
        'username' => 'votre-email@gmail.com', // À remplacer
        'password' => 'votre-mot-de-passe-app', // Utiliser un mot de passe d'application
        'from_email' => 'votre-email@gmail.com',
        'from_name' => 'Work-Flexer'
    ];
}

// Configuration 2: Serveur SMTP Work-Flexer optimisé
function getWorkFlexerConfig() {
    return [
        'host' => 'mail.work-flexer.com',
        'port' => 587,
        'secure' => PHPMailer::ENCRYPTION_STARTTLS,
        'username' => 'service@work-flexer.com',
        'password' => 'Ludvanne12@gmail.com',
        'from_email' => 'service@work-flexer.com',
        'from_name' => 'Work-Flexer'
    ];
}

// Configuration 3: Alternative avec port 465 (SSL)
function getWorkFlexerSSLConfig() {
    return [
        'host' => 'mail.work-flexer.com',
        'port' => 465,
        'secure' => PHPMailer::ENCRYPTION_SMTPS,
        'username' => 'service@work-flexer.com',
        'password' => 'Ludvanne12@gmail.com',
        'from_email' => 'service@work-flexer.com',
        'from_name' => 'Work-Flexer'
    ];
}

// Configuration 4: Sans SSL (pour tests uniquement)
function getWorkFlexerNoSSLConfig() {
    return [
        'host' => 'mail.work-flexer.com',
        'port' => 25,
        'secure' => false,
        'username' => 'service@work-flexer.com',
        'password' => 'Ludvanne12@gmail.com',
        'from_email' => 'service@work-flexer.com',
        'from_name' => 'Work-Flexer'
    ];
}

/**
 * Fonction robuste pour envoyer un email avec fallback
 */
function sendEmailWithFallback($to, $subject, $body, $toName = '') {
    $configurations = [
        getWorkFlexerConfig(),
        getWorkFlexerSSLConfig(),
        getWorkFlexerNoSSLConfig()
        // Ajouter getGmailConfig() si configuré
    ];
    
    foreach ($configurations as $index => $config) {
        try {
            $mail = new PHPMailer(true);
            
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->Port = $config['port'];
            
            if ($config['secure']) {
                $mail->SMTPSecure = $config['secure'];
            }
            
            // Options SSL robustes
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                    'cafile' => false,
                    'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT,
                    'ciphers' => 'HIGH:!SSLv2:!SSLv3'
                ),
                'tls' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                    'cafile' => false,
                    'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT
                )
            );
            
            // Configuration de base
            $mail->Timeout = 30;
            $mail->SMTPDebug = 0;
            $mail->SMTPAutoTLS = false;
            
            // Configuration de l'email
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($to, $toName);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';
            
            // Tentative d'envoi
            $mail->send();
            
            // Si nous arrivons ici, l'envoi a réussi
            return [
                'success' => true,
                'message' => 'Email envoyé avec succès',
                'config_used' => $index + 1
            ];
            
        } catch (Exception $e) {
            // Log de l'erreur pour cette configuration
            error_log("Configuration " . ($index + 1) . " échouée: " . $e->getMessage());
            
            // Si c'est la dernière configuration, retourner l'erreur
            if ($index === count($configurations) - 1) {
                return [
                    'success' => false,
                    'message' => 'Toutes les configurations ont échoué. Dernière erreur: ' . $e->getMessage(),
                    'config_used' => null
                ];
            }
        }
    }
}

/**
 * Fonction simplifiée pour tester la connectivité SMTP
 */
function testSMTPConnectivity($host, $port) {
    $connection = @fsockopen($host, $port, $errno, $errstr, 10);
    if ($connection) {
        fclose($connection);
        return true;
    }
    return false;
}

/**
 * Vérifications préliminaires avant envoi d'email
 */
function performEmailChecks() {
    $checks = [];
    
    // Test de résolution DNS
    $host = 'mail.work-flexer.com';
    $ip = gethostbyname($host);
    $checks['dns'] = $ip !== $host;
    
    // Test de connectivité sur différents ports
    $ports = [25, 587, 465];
    foreach ($ports as $port) {
        $checks["port_$port"] = testSMTPConnectivity($host, $port);
    }
    
    // Vérification des extensions PHP
    $checks['openssl'] = extension_loaded('openssl');
    $checks['sockets'] = extension_loaded('sockets');
    
    return $checks;
}
?> 