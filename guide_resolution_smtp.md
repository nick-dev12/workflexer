# Guide de Résolution des Problèmes SMTP Work-Flexer

## Problèmes Identifiés

### 1. Erreur SSL Certificate Verification Failed
**Erreur:** `SSL operation failed with code 1. OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed`

**Causes possibles:**
- Certificat SSL du serveur SMTP invalide ou expiré
- Configuration SSL/TLS incorrecte
- Problème de validation de certificat

### 2. Problèmes de Configuration DNS/DMARC
D'après MxRecord, votre domaine a plusieurs problèmes :
- DMARC Quarantine/Reject policy not enabled
- SOA Serial Number Format is Invalid
- SOA Expire Value out of recommended range
- Reverse DNS does not match SMTP Banner

## Solutions Implémentées

### 1. Configuration SMTP Robuste
```php
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
```

### 2. Configuration Alternative avec Fallback
Le fichier `email_config_alternative.php` contient plusieurs configurations de secours.

## Étapes de Diagnostic

### 1. Exécuter le Test de Diagnostic
```bash
php test_email.php
```

### 2. Vérifier la Connectivité Réseau
```bash
telnet mail.work-flexer.com 587
telnet mail.work-flexer.com 465
telnet mail.work-flexer.com 25
```

### 3. Tester la Résolution DNS
```bash
nslookup mail.work-flexer.com
dig mail.work-flexer.com MX
```

## Actions Recommandées

### 1. Configuration Serveur (À faire côté hébergeur)
- **Corriger le certificat SSL** du serveur mail.work-flexer.com
- **Configurer DMARC** : Ajouter un enregistrement TXT DMARC
- **Corriger le SOA** : Mettre à jour les enregistrements DNS
- **Configurer le Reverse DNS** : Assurer la correspondance avec le banner SMTP

### 2. Enregistrements DNS à Ajouter
```
# DMARC Record
_dmarc.work-flexer.com. TXT "v=DMARC1; p=quarantine; rua=mailto:dmarc@work-flexer.com"

# SPF Record (si pas déjà présent)
work-flexer.com. TXT "v=spf1 include:mail.work-flexer.com ~all"

# DKIM Record (à générer par le serveur mail)
default._domainkey.work-flexer.com. TXT "v=DKIM1; k=rsa; p=[clé publique]"
```

### 3. Solutions Temporaires

#### Option 1: Utiliser Gmail SMTP (Recommandé)
```php
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Username = 'votre-email@gmail.com';
$mail->Password = 'mot-de-passe-application'; // Pas le mot de passe normal
```

#### Option 2: Désactiver Temporairement SSL
```php
$mail->SMTPAutoTLS = false;
$mail->SMTPSecure = false;
$mail->Port = 25;
```

## Vérifications à Effectuer

### 1. Extensions PHP Requises
- OpenSSL: `extension_loaded('openssl')`
- Sockets: `extension_loaded('sockets')`

### 2. Logs à Consulter
- Logs PHP: `/var/log/php/error.log`
- Logs Mail: `/var/log/mail.log`
- Logs Apache/Nginx

### 3. Tests de Connectivité
```php
// Test de port
$connection = fsockopen('mail.work-flexer.com', 587, $errno, $errstr, 10);

// Test de résolution DNS
$ip = gethostbyname('mail.work-flexer.com');
```

## Commandes de Débogage Utiles

### 1. Test SMTP Manuel
```bash
openssl s_client -connect mail.work-flexer.com:587 -starttls smtp
```

### 2. Vérification Certificat SSL
```bash
openssl s_client -connect mail.work-flexer.com:587 -showcerts
```

### 3. Test de Port
```bash
nc -zv mail.work-flexer.com 587
nc -zv mail.work-flexer.com 465
nc -zv mail.work-flexer.com 25
```

## Prochaines Étapes

1. **Exécuter `test_email.php`** pour identifier la configuration qui fonctionne
2. **Contacter l'hébergeur** pour corriger les problèmes de certificat SSL
3. **Configurer les enregistrements DNS** DMARC, SPF, DKIM
4. **Implémenter le système de fallback** avec `email_config_alternative.php`
5. **Surveiller les logs** pour identifier d'autres problèmes potentiels

## Configuration de Production Recommandée

```php
// Utiliser la fonction de fallback
include 'email_config_alternative.php';

$result = sendEmailWithFallback(
    $destinataire,
    $sujet,
    $message,
    $nom
);

if ($result['success']) {
    // Succès
    echo "Email envoyé avec la configuration " . $result['config_used'];
} else {
    // Échec
    echo "Erreur: " . $result['message'];
}
``` 