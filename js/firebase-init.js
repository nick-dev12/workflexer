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
if (typeof firebase !== 'undefined') {
    try {
        firebase.initializeApp(firebaseConfig);
        console.log('Firebase initialized successfully');

        const messaging = firebase.messaging();
        console.log('Firebase Messaging initialized');

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
                    // Get FCM token and save it
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

            if (!entrepriseId) {
                console.error('No enterprise ID found in data-entreprise-id attribute');
                alert('Erreur: ID de l\'entreprise non trouvé. Veuillez contacter l\'administrateur.');
                return;
            }

            console.log('Enterprise ID:', entrepriseId);
            console.log('Token to save:', token.substring(0, 10) + '...');

            // Determine the correct path for the AJAX endpoint
            // Try to detect if we're in a subdirectory
            const currentPath = window.location.pathname;
            const isInSubdir = currentPath.includes('/entreprise/');

            // Adjust the path based on the current location
            let ajaxUrl = isInSubdir ? '../ajax/save_fcm_token.php' : '/ajax/save_fcm_token.php';

            console.log('Current path:', currentPath);
            console.log('Is in subdirectory:', isInSubdir);
            console.log('Sending request to:', ajaxUrl);

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
                    console.log('Raw response:', response);
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

                    // Try the alternative path if the first one fails
                    const alternativePath = isInSubdir ? '/ajax/save_fcm_token.php' : '../ajax/save_fcm_token.php';
                    console.log('Trying alternative path:', alternativePath);

                    fetch(alternativePath, {
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
                            console.log('Alternative response:', response);
                            if (!response.ok) {
                                throw new Error('Alternative path also failed: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Alternative token save response:', data);
                            if (data.success) {
                                console.log('Token saved successfully via alternative path');
                                alert('Notifications activées avec succès!');
                            } else {
                                console.error('Alternative server error:', data.message);
                            }
                        })
                        .catch(altError => {
                            console.error('Alternative path also failed:', altError);
                        });
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
                    break;
                case 'denied':
                case 'error':
                    notificationButton.innerHTML = '<i class="fas fa-bell-slash"></i> Activer les notifications';
                    notificationButton.classList.add('notifications-disabled');
                    notificationButton.classList.remove('notifications-enabled');
                    break;
                default:
                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
                    notificationButton.classList.remove('notifications-enabled');
                    notificationButton.classList.remove('notifications-disabled');
            }
        }

        // Listen for token refresh
        messaging.onTokenRefresh(() => {
            const vapidKey = "BJu_UkRPp4Wfx1KYK7ZDCn-1Q5A5_MjlrM0BhFx5EY-zrpeVYQGiLV_9H0BwBZLudfSiJ5NQJ-LynHm94e5GLHE";
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
        console.error('Firebase initialization error:', error);
    }
} 