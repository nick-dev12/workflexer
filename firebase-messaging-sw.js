// Version définie pour forcer la mise à jour du service worker
const VERSION = '1.1.0';
console.log(`Firebase Messaging Service Worker Version ${VERSION}`);

// Importer les scripts Firebase nécessaires
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js');

// Configuration Firebase
const firebaseConfig = {
    apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
    authDomain: "send-notification-257c0.firebaseapp.com",
    projectId: "send-notification-257c0",
    storageBucket: "send-notification-257c0.firebasestorage.app",
    messagingSenderId: "276851238884",
    appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
    measurementId: "G-N4TGHGX008"
};

// Initialiser Firebase
if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
}

// Récupérer l'instance de Firebase Messaging
const messaging = firebase.messaging();

// Log d'initialisation
console.log('[Firebase SW] Service Worker initialisé avec succès');

// Gérer les messages en arrière-plan
messaging.onBackgroundMessage((payload) => {
    console.log('[Firebase SW] Message reçu en arrière-plan:', payload);

    // Vérifier les données de la notification
    if (!payload.notification && !payload.data) {
        console.warn('[Firebase SW] Notification sans contenu reçue');
        return;
    }

    // Préparer les options de la notification
    const notificationTitle = payload.notification?.title || 'Nouvelle notification';
    const notificationOptions = {
        body: payload.notification?.body || '',
        icon: '/image/logo.png',
        badge: '/image/logo.png',
        tag: payload.data?.notification_id || 'default', // Évite les notifications en double
        data: payload.data || {},
        requireInteraction: true,
        silent: false, // Permet le son de notification
        timestamp: Date.now(), // Ajoute un timestamp
        vibrate: [200, 100, 200], // Pattern de vibration
        actions: [
            {
                action: 'view',
                title: 'Voir détails',
                icon: '/image/view-icon.png'
            }
        ]
    };

    // Afficher la notification
    self.registration.showNotification(notificationTitle, notificationOptions)
        .catch(error => console.error('[Firebase SW] Erreur d\'affichage de la notification:', error));
});

// Gérer le clic sur la notification
self.addEventListener('notificationclick', (event) => {
    console.log('[Firebase SW] Clic sur la notification détecté');

    // Fermer la notification
    event.notification.close();

    // Récupérer les données de la notification
    const data = event.notification.data || {};
    let pageUrl = '/';

    // Déterminer l'URL en fonction du type de notification
    switch (data.notification_type) {
        case 'candidat':
            pageUrl = '/page/user_profil.php';
            break;
        case 'offre':
            pageUrl = data.offre_id ? `/entreprise/offre.php?offre_id=${data.offre_id}` : pageUrl;
            break;
        case 'candidature':
            pageUrl = data.candidat_id ? `/entreprise/candidature.php?id=${data.candidat_id}` : pageUrl;
            break;
    }

    // Gérer la navigation
    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        })
            .then((clientList) => {
                // Vérifier si une fenêtre existe déjà
                for (const client of clientList) {
                    if (client.url === pageUrl && 'focus' in client) {
                        return client.focus();
                    }
                }
                // Si aucune fenêtre n'existe, en ouvrir une nouvelle
                return clients.openWindow(pageUrl);
            })
            .catch(error => console.error('[Firebase SW] Erreur de navigation:', error))
    );
});

// Gérer l'installation du service worker
self.addEventListener('install', (event) => {
    console.log('[Firebase SW] Installation du Service Worker');
    self.skipWaiting(); // Forcer l'activation immédiate
});

// Gérer l'activation du service worker
self.addEventListener('activate', (event) => {
    console.log('[Firebase SW] Service Worker activé');
    event.waitUntil(clients.claim()); // Prendre le contrôle immédiatement
}); 