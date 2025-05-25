// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
    authDomain: "send-notification-257c0.firebaseapp.com",
    projectId: "send-notification-257c0",
    storageBucket: "send-notification-257c0.firebasestorage.app",
    messagingSenderId: "276851238884",
    appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
    measurementId: "G-N4TGHGX008"
};

// Initialize Firebase
if (typeof firebase !== 'undefined' && !firebase.apps.length) { // S'assurer qu'on initialise qu'une fois
    try {
        firebase.initializeApp(firebaseConfig);
        console.log('Firebase initialized successfully by firebase-init.js');
    } catch (error) {
        console.error('Firebase initialization error in firebase-init.js:', error);
    }
} else if (typeof firebase !== 'undefined' && firebase.apps.length) {
    console.log('Firebase already initialized (firebase-init.js check).');
}

// TOUTE LA LOGIQUE CI-DESSOUS A ÉTÉ SUPPRIMÉE OU DÉPLACÉE VERS
// js/notifications-user.js et js/notifications-entreprise.js
// pour éviter les conflits et centraliser la gestion par page.

/*
        // Initialize UI elements once DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            const notificationButton = document.getElementById('enable-notifications');
            if (notificationButton) {
                // Update button state based on notification permission
                updateNotificationButtonState();

                // Add click event listener
                notificationButton.addEventListener('click', requestNotificationPermission);
            }
        });

        // Function to request notification permission
        function requestNotificationPermission() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');
                    // Update button state immediately
                    updateNotificationButtonState('granted');
                    // Only get FCM token if we don't already have one
                    getAndSaveFCMToken();
                } else {
                    console.log('Unable to get permission to notify.');
                    updateNotificationButtonState('denied');
                }
            });
        }

        // Get FCM token and save it to the server
        function getAndSaveFCMToken() {
            // Le Web Push certificat généré dans la console Firebase
            const vapidKey = "BDY6Hkwwi0tSnzzww0WJrnJqdeS1d-r2AWJ4Wr9eWQk4dWNmSRjpyvmCqDc99JCW_NRlY8N0PPxUQbrPuxXbrgI";

            console.log('Getting FCM token with vapidKey:', vapidKey.substring(0, 10) + '...');

            messaging.getToken({ vapidKey: vapidKey })
                .then((currentToken) => {
                    if (currentToken) {
                        console.log('FCM Token obtained:', currentToken.substring(0, 10) + '...');
                        // Save token to server
                        saveTokenToServer(currentToken);
                        // Update button state
                        updateNotificationButtonState('granted');
                    } else {
                        console.log('No registration token available. Request permission to generate one.');
                        updateNotificationButtonState('denied');
                    }
                }).catch((err) => {
                    console.error('An error occurred while retrieving token:', err);
                    console.log('Error details:', err.message, err.code, err.details);
                    updateNotificationButtonState('error');
                });
        }

        // Save token to server
        function saveTokenToServer(token) {
            console.log('Attempting to save token to server...');
            const notificationButton = document.getElementById('enable-notifications');
            const entrepriseId = notificationButton?.dataset?.entrepriseId;
            const isUserProfile = window.location.pathname.includes('/page/user_profil.php');

            // Determine the correct endpoint based on the page
            let ajaxUrl = isUserProfile ? '/ajax/save_fcm_token_user.php' : '/ajax/save_fcm_token.php';
            let postData = isUserProfile ? { token } : { token, entreprise_id: entrepriseId };

            if (!isUserProfile && !entrepriseId) {
                console.error('No enterprise ID found in data-entreprise-id attribute');
                alert('Erreur: ID de l\'entreprise non trouvé. Veuillez contacter l\'administrateur.');
                return;
            }

            console.log('Sending request to:', ajaxUrl);
            console.log('Post data:', postData);

            fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(postData),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Token save response:', data);
                    if (data.success) {
                        console.log('Token saved successfully');
                        alert('Notifications activées avec succès!');
                    } else {
                        console.error('Server error:', data.message);
                        alert('Erreur serveur: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error saving token:', error);
                    alert('Erreur de communication avec le serveur: ' + error.message);
                });
        }

        // Update notification button state
        function updateNotificationButtonState(state) {
            const notificationButton = document.getElementById('enable-notifications');
            if (!notificationButton) return;

            // If no state is provided, check the current permission
            if (!state) {
                state = Notification.permission;
            }

            // Update button based on state
            switch (state) {
                case 'granted':
                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Notifications activées';
                    notificationButton.classList.add('notifications-enabled');
                    notificationButton.classList.remove('notifications-disabled');
                    notificationButton.style.backgroundColor = '#4CAF50';
                    notificationButton.style.color = 'white';
                    break;
                case 'denied':
                case 'error':
                    notificationButton.innerHTML = '<i class="fas fa-bell-slash"></i> Activer les notifications';
                    notificationButton.classList.add('notifications-disabled');
                    notificationButton.classList.remove('notifications-enabled');
                    notificationButton.style.backgroundColor = '#f44336';
                    notificationButton.style.color = 'white';
                    break;
                default:
                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
                    notificationButton.classList.remove('notifications-enabled');
                    notificationButton.classList.remove('notifications-disabled');
                    notificationButton.style.backgroundColor = '#2196F3';
                    notificationButton.style.color = 'white';
            }

            // Make button more visible
            notificationButton.style.padding = '10px 20px';
            notificationButton.style.borderRadius = '5px';
            notificationButton.style.cursor = 'pointer';
            notificationButton.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
            notificationButton.style.transition = 'all 0.3s ease';
        }

        // Listen for token refresh
        messaging.onTokenRefresh(() => {
            const vapidKey = "BDY6Hkwwi0tSnzzww0WJrnJqdeS1d-r2AWJ4Wr9eWQk4dWNmSRjpyvmCqDc99JCW_NRlY8N0PPxUQbrPuxXbrgI";
            messaging.getToken({ vapidKey: vapidKey })
                .then((refreshedToken) => {
                    console.log('Token refreshed.');
                    saveTokenToServer(refreshedToken);
                }).catch((err) => {
                    console.log('Unable to retrieve refreshed token ', err);
                });
        });

        // Handle received messages when app is in foreground
        messaging.onMessage((payload) => {
            console.log('Message received: ', payload);

            // Create and show notification manually
            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body,
                icon: '/image/logo.png',
                data: payload.data
            };

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.ready.then(registration => {
                    registration.showNotification(notificationTitle, notificationOptions);
                });
            } else {
                // Fallback for browsers without service worker support
                new Notification(notificationTitle, notificationOptions);
            }
        });
    } catch (error) {
        console.error('Firebase initialization error in firebase-init.js (outer try-catch):', error);
    }
} else {
    console.warn('Firebase object not found, cannot initialize (firebase-init.js).');
}
*/ 