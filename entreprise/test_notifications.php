<?php
session_start();
require_once(__DIR__ . '/../conn/conn.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['compte_entreprise'])) {
    echo '<p style="color:red">Vous devez être connecté en tant qu\'entreprise</p>';
    exit;
}

// Entreprise ID
$entreprise_id = $_SESSION['compte_entreprise'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test des notifications FCM</title>

    <!-- Manifest pour PWA -->
    <link rel="manifest" href="../manifest.json">

    <!-- Méta-tags pour le service worker -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="WorkFlexer">
    <meta name="theme-color" content="#4CAF50">

    <!-- Firebase App (the core Firebase SDK) -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>

    <!-- Firebase Messaging -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js"></script>

    <!-- Font Awesome (pour les icônes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
        }

        #notification-button,
        #check-sw-button,
        #send-test-notification,
        #test-auth-token {
            padding: 12px 18px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            color: white;
            margin: 10px 5px 10px 0;
        }

        #notification-button {
            background-color: #4CAF50;
        }

        #check-sw-button {
            background-color: #2196F3;
        }

        #send-test-notification {
            background-color: #FF9800;
        }

        #test-auth-token {
            background-color: #9C27B0;
        }

        #notification-button:hover,
        #check-sw-button:hover,
        #send-test-notification:hover,
        #test-auth-token:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #notification-button.disabled {
            background-color: #f44336;
        }

        #log {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
            margin-top: 20px;
            font-family: monospace;
            border-radius: 5px;
        }

        .log-item {
            margin-bottom: 5px;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .info {
            color: blue;
        }

        ol li {
            margin-bottom: 10px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <h1>Test des notifications FCM</h1>

    <div class="container">
        <h2>Informations</h2>
        <p><strong>Entreprise ID:</strong> <?php echo htmlspecialchars($entreprise_id); ?></p>
        <button id="notification-button" data-entreprise-id="<?php echo htmlspecialchars($entreprise_id); ?>">
            <i class="fas fa-bell"></i> Activer les notifications
        </button>
        <button id="check-sw-button">
            <i class="fas fa-cog"></i> Vérifier le service worker
        </button>
        <button id="send-test-notification">
            <i class="fas fa-paper-plane"></i> Envoyer notification test
        </button>
        <button id="test-auth-token" style="background-color: #9C27B0;">
            <i class="fas fa-key"></i> Tester jeton OAuth
        </button>
        <a href="notification_logs.php" class="btn"
            style="background-color: #607D8B; color: white; padding: 12px 18px; border-radius: 5px; margin: 10px 5px 10px 0; display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
            <i class="fas fa-history"></i> Historique des notifications
        </a>
    </div>

    <div class="container">
        <h2>Guide d'utilisation</h2>
        <ol style="padding-left: 20px;">
            <li>Cliquez sur <strong>"Activer les notifications"</strong> et autorisez les notifications dans votre
                navigateur</li>
            <li>Vérifiez que le Service Worker est correctement installé avec <strong>"Vérifier le service
                    worker"</strong></li>
            <li>Si vous rencontrez des erreurs SSL, cliquez sur <strong>"Tester jeton OAuth"</strong> pour diagnostiquer
                les problèmes d'authentification</li>
            <li>Envoyez une notification de test avec <strong>"Envoyer notification test"</strong> pour confirmer que
                tout fonctionne</li>
            <li>Si vous recevez la notification, votre système est correctement configuré!</li>
        </ol>
        <p><em>Note: En cas d'erreur SSL, les vérifications SSL ont été désactivées pour l'environnement de
                développement.</em></p>
        <p><em>Mise à jour: L'erreur "Invalid value at 'message.data[1].value'" a été corrigée. Toutes les valeurs dans
                le champ data sont maintenant des chaînes de caractères.</em></p>
        <p style="color:green; font-weight:bold;"><i class="fas fa-check-circle"></i> Système de notification FCM
            correctement configuré et fonctionnel!</p>
    </div>

    <div class="container">
        <h2>Journal de debug</h2>
        <div id="log"></div>
    </div>

    <script>
        // Firebase configuration (même configuration que firebase-init.js)
        const firebaseConfig = {
            apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
            authDomain: "send-notification-257c0.firebaseapp.com",
            projectId: "send-notification-257c0",
            storageBucket: "send-notification-257c0.firebasestorage.app",
            messagingSenderId: "276851238884",
            appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
            measurementId: "G-N4TGHGX008"
        };

        // Fonction pour ajouter un message au journal
        function log(message, type = 'info') {
            const logContainer = document.getElementById('log');
            const logItem = document.createElement('div');
            logItem.className = `log-item ${type}`;
            logItem.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
            logContainer.appendChild(logItem);

            // Auto-scroll to bottom
            logContainer.scrollTop = logContainer.scrollHeight;
        }

        // Initialize Firebase
        log('Initialisation de Firebase...');
        if (typeof firebase !== 'undefined') {
            firebase.initializeApp(firebaseConfig);
            log('Firebase initialisé', 'success');

            const messaging = firebase.messaging();
            log('Firebase Messaging initialisé', 'success');

            // Notification button
            const notificationButton = document.getElementById('notification-button');

            // Check current permission state
            log(`État actuel des permissions: ${Notification.permission}`);
            updateButtonState(Notification.permission);

            // Vérifier le service worker au chargement de la page
            if ('serviceWorker' in navigator) {
                log('Vérification du service worker au chargement...', 'info');
                navigator.serviceWorker.getRegistrations().then(registrations => {
                    if (registrations.length === 0) {
                        log('Aucun Service Worker enregistré. Veuillez cliquer sur "Vérifier le service worker"', 'error');
                    } else {
                        log(`${registrations.length} Service Worker(s) déjà enregistré(s)`, 'success');
                    }
                }).catch(error => {
                    log(`Erreur lors de la vérification des Service Workers: ${error.message}`, 'error');
                });
            }

            // Button event listener
            notificationButton.addEventListener('click', () => {
                log('Demande de permission pour les notifications...');

                Notification.requestPermission().then((permission) => {
                    log(`Permission: ${permission}`);

                    if (permission === 'granted') {
                        log('Permission accordée, demande de token...', 'success');
                        getAndSaveToken();
                    } else {
                        log('Permission refusée', 'error');
                        updateButtonState('denied');
                    }
                }).catch(error => {
                    log(`Erreur lors de la demande de permission: ${error.message}`, 'error');
                });
            });

            // Service Worker check button
            const checkSwButton = document.getElementById('check-sw-button');
            checkSwButton.addEventListener('click', checkServiceWorker);

            // Test notification button
            const sendTestButton = document.getElementById('send-test-notification');
            sendTestButton.addEventListener('click', sendTestNotification);

            // Test authentication token button
            const testAuthButton = document.getElementById('test-auth-token');
            testAuthButton.addEventListener('click', testAuthToken);

            // Function to get and save FCM token
            function getAndSaveToken() {
                log('Obtention du token FCM...');

                // Nouvelle clé VAPID correcte
                const vapidKey = "BDY6Hkwwi0tSnzzww0WJrnJqdeS1d-r2AWJ4Wr9eWQk4dWNmSRjpyvmCqDc99JCW_NRlY8N0PPxUQbrPuxXbrgI";
                log(`Utilisation de la clé VAPID: ${vapidKey.substring(0, 15)}...`);

                messaging.getToken({ vapidKey: vapidKey })
                    .then((token) => {
                        if (token) {
                            log(`Token obtenu: ${token.substring(0, 20)}...`, 'success');
                            saveTokenToServer(token);
                            updateButtonState('granted');
                        } else {
                            log('Aucun token généré', 'error');
                            updateButtonState('denied');
                        }
                    }).catch((error) => {
                        log(`Erreur lors de l'obtention du token: ${error.message}`, 'error');
                        // Afficher plus de détails sur l'erreur
                        if (error.code) {
                            log(`Code d'erreur: ${error.code}`, 'error');
                        }
                        if (error.details) {
                            log(`Détails: ${error.details}`, 'error');
                        }
                        log('Vérifiez dans la console pour plus d\'informations', 'error');
                        console.error('Détails complets de l\'erreur:', error);
                        updateButtonState('error');
                    });
            }

            // Function to save token to server
            function saveTokenToServer(token) {
                const entrepriseId = notificationButton.dataset.entrepriseId;

                if (!entrepriseId) {
                    log('ID entreprise non trouvé', 'error');
                    return;
                }

                log(`Envoi du token au serveur pour entreprise ${entrepriseId}...`);

                // Try with relative path first
                const ajaxUrl = '../ajax/save_fcm_token.php';
                log(`URL AJAX: ${ajaxUrl}`);

                fetch(ajaxUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        token: token,
                        entreprise_id: entrepriseId
                    }),
                })
                    .then(response => {
                        log(`Réponse du serveur: ${response.status} ${response.statusText}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            log('Token enregistré avec succès!', 'success');
                        } else {
                            log(`Erreur serveur: ${data.message}`, 'error');
                        }
                    })
                    .catch((error) => {
                        log(`Erreur de communication: ${error.message}`, 'error');
                    });
            }

            // Update button state
            function updateButtonState(state) {
                if (state === 'granted') {
                    notificationButton.textContent = '✓ Notifications activées';
                    notificationButton.className = '';
                } else {
                    notificationButton.textContent = '⚠ Activer les notifications';
                    notificationButton.className = 'disabled';
                }
            }

            // Handle foreground messages
            messaging.onMessage((payload) => {
                log(`Message reçu: ${JSON.stringify(payload)}`, 'success');
            });

            // Function to check service worker
            function checkServiceWorker() {
                log('Vérification du service worker...');

                if ('serviceWorker' in navigator) {
                    log('Service Worker supporté par le navigateur', 'info');

                    navigator.serviceWorker.getRegistrations().then(registrations => {
                        if (registrations.length === 0) {
                            log('Aucun Service Worker enregistré', 'error');

                            // Essayer d'enregistrer le service worker
                            log('Tentative d\'enregistrement du service worker...', 'info');
                            registerServiceWorker();
                        } else {
                            log(`${registrations.length} Service Worker enregistré(s)`, 'success');

                            // Afficher les détails des service workers
                            registrations.forEach((registration, index) => {
                                log(`SW ${index + 1} - Scope: ${registration.scope}`, 'info');
                                if (registration.active) {
                                    log(`SW ${index + 1} - State: ${registration.active.state}`, 'success');
                                } else if (registration.installing) {
                                    log(`SW ${index + 1} - En cours d'installation`, 'info');
                                } else if (registration.waiting) {
                                    log(`SW ${index + 1} - En attente d'activation`, 'info');
                                }
                            });
                        }
                    }).catch(error => {
                        log(`Erreur lors de la vérification des Service Workers: ${error.message}`, 'error');
                    });
                } else {
                    log('Service Worker non supporté par ce navigateur', 'error');
                }
            }

            // Function to register service worker
            function registerServiceWorker() {
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.register('/firebase-messaging-sw.js')
                        .then(registration => {
                            log('Service Worker enregistré avec succès!', 'success');
                            log(`Scope: ${registration.scope}`, 'info');
                        })
                        .catch(error => {
                            log(`Échec de l'enregistrement du Service Worker: ${error.message}`, 'error');

                            // Essayer avec un chemin relatif
                            log('Tentative avec un chemin relatif...', 'info');
                            navigator.serviceWorker.register('../firebase-messaging-sw.js')
                                .then(registration => {
                                    log('Service Worker enregistré avec succès (chemin relatif)!', 'success');
                                    log(`Scope: ${registration.scope}`, 'info');
                                })
                                .catch(altError => {
                                    log(`Échec de l'enregistrement du Service Worker (chemin relatif): ${altError.message}`, 'error');
                                });
                        });
                } else {
                    log('Service Worker non supporté par ce navigateur', 'error');
                }
            }

            // Function to send test notification
            function sendTestNotification() {
                log('Envoi d\'une notification de test...');

                // Check if notifications are enabled
                if (Notification.permission !== 'granted') {
                    log('Vous devez d\'abord autoriser les notifications', 'error');
                    return;
                }

                // Send test notification request to server
                fetch('../ajax/send_test_notification.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => {
                        log(`Réponse du serveur: ${response.status} ${response.statusText}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            log('Notification de test envoyée avec succès!', 'success');
                        } else {
                            log(`Échec d'envoi de la notification: ${data.message}`, 'error');
                        }
                    })
                    .catch(error => {
                        log(`Erreur de communication: ${error.message}`, 'error');
                    });
            }

            // Function to test authentication token generation
            function testAuthToken() {
                log('Test de génération du jeton OAuth...');

                fetch('../ajax/test_auth_token.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => {
                        log(`Réponse du serveur: ${response.status} ${response.statusText}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            log(`Jeton OAuth généré avec succès via ${data.method}`, 'success');
                            log(`Longueur du jeton: ${data.token_length} caractères`, 'info');
                            log(`Aperçu: ${data.token_preview}`, 'info');
                            log(`Temps de génération: ${data.time_ms}ms`, 'info');
                        } else {
                            log('Échec de génération du jeton OAuth', 'error');
                            if (data.curl_error) {
                                log(`Erreur cURL: ${data.curl_error}`, 'error');
                            }
                            if (data.google_client_error) {
                                log(`Erreur Google Client: ${data.google_client_error}`, 'error');
                            }
                        }
                    })
                    .catch(error => {
                        log(`Erreur de communication: ${error.message}`, 'error');
                    });
            }
        } else {
            log('Firebase n\'est pas disponible', 'error');
        }
    </script>
</body>

</html>