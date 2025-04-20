<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Limité - Work-Flexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <style>
        :root {
            --primary-color: #328590;
            --secondary-color: #0E3B43;
            --light-color: #F0F0F0;
            --dark-color: #333;
            --accent-color: #FF6B6B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-color);
            color: var(--dark-color);
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 90%;
            max-width: 600px;
            padding: 2rem;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            z-index: 2;
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }

        .message-icon {
            font-size: 5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        .floating-devices {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .floating-device {
            position: absolute;
            font-size: 1.5rem;
            color: rgba(14, 59, 67, 0.1);
            animation: float 10s infinite linear;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-size: 2rem;
            animation: slideIn 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
            animation-delay: 0.3s;
        }

        p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: slideIn 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
            animation-delay: 0.6s;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(50, 133, 144, 0.3);
            position: relative;
            overflow: hidden;
            animation: slideIn 0.8s ease-out forwards, pulse-light 2s infinite;
            opacity: 0;
            transform: translateY(20px);
            animation-delay: 0.9s;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(14, 59, 67, 0.4);
        }

        .btn:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .btn:focus:after {
            animation: ripple 1s ease-out;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-light {
            0% {
                box-shadow: 0 0 0 0 rgba(50, 133, 144, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(50, 133, 144, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(50, 133, 144, 0);
            }
        }

        .highlight {
            color: var(--accent-color);
            font-weight: 600;
        }

        .device-illustration {
            margin: 2rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            animation: slideIn 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
            animation-delay: 0.6s;
        }

        .mobile-device {
            width: 50px;
            height: 90px;
            background-color: #ddd;
            border-radius: 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 2px solid #bbb;
        }

        .mobile-device:before {
            content: "";
            width: 20px;
            height: 2px;
            background-color: #999;
            position: absolute;
            top: 10px;
            border-radius: 2px;
        }

        .mobile-device:after {
            content: "";
            width: 25px;
            height: 25px;
            border: 2px solid #999;
            border-radius: 50%;
            position: absolute;
            bottom: 10px;
        }

        .arrow {
            font-size: 2rem;
            color: var(--accent-color);
            animation: arrowMove 1.5s infinite;
        }

        .desktop-device {
            width: 150px;
            height: 100px;
            background-color: #f8f8f8;
            border-radius: 5px 5px 0 0;
            position: relative;
            border: 2px solid #bbb;
            border-bottom: none;
        }

        .desktop-device:after {
            content: "";
            width: 40px;
            height: 15px;
            background-color: #ddd;
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border: 2px solid #bbb;
            border-top: none;
            box-sizing: content-box;
        }

        .desktop-device:before {
            content: "";
            width: 100px;
            height: 5px;
            background-color: #ddd;
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .check-icon {
            color: #4CAF50;
            font-size: 1.5rem;
            animation: fadeInDelay 1s forwards;
            opacity: 0;
            animation-delay: 1.2s;
        }

        .cross-icon {
            color: var(--accent-color);
            font-size: 1.5rem;
            animation: fadeInDelay 1s forwards;
            opacity: 0;
            animation-delay: 1.2s;
        }

        @keyframes fadeInDelay {
            to {
                opacity: 1;
            }
        }

        @keyframes arrowMove {
            0% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(10px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .footer-text {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #888;
            animation: fadeIn 1s ease-out forwards;
            animation-delay: 1.5s;
            opacity: 0;
        }

        /* Generate floating device icons */
        .generate-icons {
            display: none;
        }
    </style>
</head>

<body>
    <div class="floating-devices" id="floatingDevices"></div>

    <div class="container">
        <div class="message-icon">
            <i class="fas fa-laptop-code"></i>
        </div>

        <h1>Accès depuis un ordinateur requis</h1>

        <p>Pour profiter pleinement des <span class="highlight">modèles de CV</span> et de toutes les options de
            personnalisation, veuillez vous connecter depuis un <span class="highlight">ordinateur</span>.</p>

        <div class="device-illustration">
            <div class="mobile-device"></div>
            <div class="cross-icon"><i class="fas fa-times-circle"></i></div>
            <div class="arrow"><i class="fas fa-arrow-right"></i></div>
            <div class="desktop-device"></div>
            <div class="check-icon"><i class="fas fa-check-circle"></i></div>
        </div>

        <p>Les fonctionnalités de personnalisation avancées sont optimisées pour les grands écrans et ne sont pas
            disponibles sur les appareils mobiles.</p>

        <a href="/model_cv/cv_users.php" class="btn">Retourner à l'accueil</a>

        <p class="footer-text">Vous pourrez accéder à tous les modèles de CV et à leurs options de personnalisation une
            fois connecté depuis un ordinateur.</p>
    </div>

    <button class="generate-icons" id="generateIcons">Générer des icônes</button>

    <script>
        // Generate floating device icons in the background
        document.addEventListener('DOMContentLoaded', function () {
            const floatingDevices = document.getElementById('floatingDevices');
            const deviceIcons = [
                'fa-laptop', 'fa-desktop', 'fa-mobile-alt', 'fa-tablet-alt',
                'fa-keyboard', 'fa-mouse', 'fa-print', 'fa-file-pdf'
            ];

            // Create 20 random floating device icons
            for (let i = 0; i < 20; i++) {
                const icon = document.createElement('div');
                icon.className = 'floating-device';
                const randomIcon = deviceIcons[Math.floor(Math.random() * deviceIcons.length)];
                icon.innerHTML = `<i class="fas ${randomIcon}"></i>`;

                // Random position, scale, and timing
                const size = Math.random() * 1 + 0.5; // Random size between 0.5 and 1.5
                const left = Math.random() * 100; // Random horizontal position
                const animDuration = Math.random() * 15 + 10; // Random animation duration 10-25s
                const animDelay = Math.random() * 10; // Random start delay 0-10s

                icon.style.left = `${left}%`;
                icon.style.bottom = '-20px';
                icon.style.transform = `scale(${size})`;
                icon.style.animation = `float ${animDuration}s ${animDelay}s infinite linear`;

                floatingDevices.appendChild(icon);
            }
        });
    </script>
</body>

</html>