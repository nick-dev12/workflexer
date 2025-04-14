<?php
// Start session
session_start();

// Include device detection functionality
include_once('check_device.php');

// Check the device type
$isDesktop = isDesktop();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de détection d'appareil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            background-color: #f5f5f5;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .result {
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .desktop {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .mobile {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .user-agent {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
            padding: 10px;
            margin-top: 20px;
            overflow-wrap: break-word;
            font-family: monospace;
            font-size: 0.9rem;
        }

        h1 {
            color: #333;
        }

        .icon {
            font-size: 2rem;
            margin-right: 10px;
            vertical-align: middle;
        }

        .next-steps {
            margin-top: 30px;
            background-color: #cce5ff;
            border: 1px solid #b8daff;
            color: #004085;
            padding: 15px;
            border-radius: 5px;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #0069d9;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <h1>Test de détection d'appareil</h1>

    <div class="container">
        <div class="result <?php echo $isDesktop ? 'desktop' : 'mobile'; ?>">
            <?php if ($isDesktop): ?>
                <i class="fas fa-desktop icon"></i> Appareil détecté : <strong>Ordinateur</strong>
                <p>Vous pouvez accéder aux modèles de CV et à toutes les fonctionnalités de personnalisation.</p>
            <?php else: ?>
                <i class="fas fa-mobile-alt icon"></i> Appareil détecté : <strong>Mobile</strong>
                <p>Les fonctionnalités de personnalisation de CV nécessitent un ordinateur.</p>
            <?php endif; ?>
        </div>

        <div class="user-agent">
            <strong>User-Agent :</strong> <?php echo $_SERVER['HTTP_USER_AGENT']; ?>
        </div>

        <div class="next-steps">
            <h3>Informations :</h3>
            <p>
                <?php if ($isDesktop): ?>
                    Votre appareil est reconnu comme un ordinateur. Vous pouvez accéder aux modèles de CV et à toutes les
                    fonctionnalités de personnalisation.
                <?php else: ?>
                    Votre appareil est reconnu comme un appareil mobile. Pour accéder aux modèles de CV et utiliser toutes
                    les fonctionnalités de personnalisation, veuillez vous connecter depuis un ordinateur.
                <?php endif; ?>
            </p>
        </div>

        <div class="buttons">
            <a href="../" class="btn">Retour à l'accueil</a>
            <a href="mobile_message.php" class="btn btn-secondary">Voir la page mobile</a>
        </div>
    </div>
</body>

</html>