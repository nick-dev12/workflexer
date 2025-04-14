// Version définie pour forcer la mise à jour du service worker
const VERSION = '1.0.3';
console.log(`Firebase Messaging Service Worker Version ${VERSION}`);

// Firebase app config from the FCM console
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js');

// Initialize Firebase
firebase.initializeApp({
    apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
    authDomain: "send-notification-257c0.firebaseapp.com",
    projectId: "send-notification-257c0",
    storageBucket: "send-notification-257c0.firebasestorage.app",
    messagingSenderId: "276851238884",
    appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
    measurementId: "G-N4TGHGX008"
});

// Retrieve Firebase Messaging instance
const messaging = firebase.messaging();

// Log initialization
console.log('Firebase Messaging SW initialized!');

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    // Ensure notification data exists
    if (!payload.notification) {
        console.log('No notification in payload');
        return;
    }

    // Create notification options
    const notificationOptions = {
        body: payload.notification.body || '',
        icon: '/image/logo.png',
        badge: '/image/logo.png',
        data: payload.data || {},
        requireInteraction: true,
        actions: [
            {
                action: 'view',
                title: 'Voir détails'
            }
        ]
    };

    // Show notification
    self.registration.showNotification(
        payload.notification.title || 'Nouvelle notification',
        notificationOptions
    );
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    console.log('[Service Worker] Notification click received.');

    // Close the notification
    event.notification.close();

    // Get notification data
    const data = event.notification.data || {};

    // Define default page URL
    let pageUrl = '/';

    // Determine the correct URL based on notification type
    if (data.notification_type === 'candidat') {
        pageUrl = '/page/user_profil.php';
    } else if (data.candidat_id) {
        pageUrl = '/entreprise/candidature.php?id=' + data.candidat_id;
    } else if (data.offre_id) {
        pageUrl = '/entreprise/offre.php?offre_id=' + data.offre_id;
    }

    // Open the page
    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        })
            .then((clientList) => {
                // Check if there's already a window/tab open with the target URL
                for (const client of clientList) {
                    if (client.url === pageUrl && 'focus' in client) {
                        return client.focus();
                    }
                }
                // If no existing window found, open a new one
                return clients.openWindow(pageUrl);
            })
    );
}); 