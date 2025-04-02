// Version définie pour forcer la mise à jour du service worker
const VERSION = '1.0.1';
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

// Affiche le numéro de version dans la console
console.log('Firebase Messaging SW initialized!');

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/image/logo.png',
        badge: '/image/logo.png',
        data: payload.data,
        // Add actions if needed
        actions: [
            {
                action: 'view',
                title: 'Voir candidature'
            }
        ]
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    console.log('[Service Worker] Notification click received.');

    event.notification.close();

    // Get notification data
    const data = event.notification.data;

    // Define page URL to open on notification click
    let pageUrl = '/';

    // If we have candidate data, direct to the candidate profile
    if (data && data.candidat_id) {
        pageUrl = '/entreprise/candidature.php?id=' + data.candidat_id;
    } else if (data && data.offre_id) {
        pageUrl = '/entreprise/offre.php?offre_id=' + data.offre_id;
    }

    // Open the page
    event.waitUntil(
        clients.openWindow(pageUrl)
    );
}); 