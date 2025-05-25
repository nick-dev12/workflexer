document.addEventListener('DOMContentLoaded', async function () {
    // Firebase configuration (copiée depuis firebase-init.js)
    const firebaseConfig = {
        apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
        authDomain: "send-notification-257c0.firebaseapp.com",
        projectId: "send-notification-257c0",
        storageBucket: "send-notification-257c0.firebasestorage.app",
        messagingSenderId: "276851238884",
        appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
        measurementId: "G-N4TGHGX008"
    };

    // Initialize Firebase if not already initialized
    if (typeof firebase !== 'undefined' && !firebase.apps.length) {
        try {
            firebase.initializeApp(firebaseConfig);
            console.log('Firebase initialized by notifications-entreprise.js');
        } catch (error) {
            console.error('Firebase initialization error in notifications-entreprise.js:', error);
            // Gérer l'erreur d'initialisation de Firebase si nécessaire (par exemple, désactiver le bouton)
            const nfButton = document.getElementById('enable-notifications');
            if (nfButton) {
                nfButton.disabled = true;
                nfButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Err Firebase';
            }
            return; // Arrêter si Firebase ne peut pas être initialisé
        }
    } else if (typeof firebase === 'undefined') {
        console.error("Firebase SDK not loaded before notifications-entreprise.js");
        return;
    }

    const notificationButton = document.getElementById('enable-notifications'); // ID du bouton entreprise
    const notificationStatusContainer = document.getElementById('notification-status-entreprise'); // ID du conteneur de statut entreprise

    if (!notificationButton) { // Pas besoin de notificationStatusContainer pour le fonctionnement de base du bouton
        console.warn("Bouton de notification 'enable-notifications' non trouvé.");
        return;
    }

    if (!('Notification' in window) || !('serviceWorker' in navigator)) {
        console.warn('Notifications ou Service Worker non supportés par ce navigateur.');
        notificationButton.disabled = true;
        notificationButton.innerHTML = '<i class="fas fa-bell-slash"></i> Non supporté';
        if (notificationStatusContainer) showUserMessage('Les notifications ne sont pas supportées par ce navigateur.', 'warning', notificationStatusContainer);
        return;
    }

    // La configuration Firebase est généralement la même, chargée via firebase-init.js ou directement
    // Assurez-vous que firebase.apps.length est vérifié avant initializeApp si vous le faites ici
    // Pour cet exemple, on suppose que Firebase est déjà initialisé (par exemple via ../js/firebase-init.js)
    if (!firebase || !firebase.apps.length) {
        console.error("Firebase SDK non initialisé. Assurez-vous que firebase-init.js est chargé avant ce script ou initialisez Firebase ici.");
        notificationButton.disabled = true;
        notificationButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Erreur Firebase';
        if (notificationStatusContainer) showUserMessage('Erreur init. Firebase.', 'error', notificationStatusContainer);
        return;
    }
    const messaging = firebase.messaging();

    function showUserMessage(message, type = 'info', container, duration = 3000) {
        if (!container) return;
        const messageBadge = document.createElement('div');
        // Appliquer un style minimal si pas de CSS dédié
        messageBadge.style.padding = '5px';
        messageBadge.style.marginTop = '5px';
        messageBadge.style.borderRadius = '3px';
        messageBadge.style.color = 'white';
        type === 'success' ? messageBadge.style.backgroundColor = 'green' :
            type === 'warning' ? messageBadge.style.backgroundColor = 'orange' :
                type === 'error' ? messageBadge.style.backgroundColor = 'red' :
                    messageBadge.style.backgroundColor = 'gray';

        messageBadge.textContent = message;
        container.innerHTML = '';
        container.appendChild(messageBadge);

        setTimeout(() => {
            messageBadge.style.opacity = '0';
            setTimeout(() => {
                if (messageBadge.parentNode) {
                    messageBadge.parentNode.removeChild(messageBadge);
                }
            }, 600); // Durée de transition pour la disparition
        }, duration);
    }

    try {
        console.log('Enregistrement du Service Worker pour entreprise...');
        const swRegistration = await navigator.serviceWorker.register('/firebase-messaging-sw.js', { scope: '/' });
        console.log('Service Worker (entreprise) enregistré:', swRegistration);
        await navigator.serviceWorker.ready;
        console.log('Service Worker (entreprise) est prêt et actif.');
    } catch (error) {
        console.error('Erreur critique Service Worker (entreprise):', error);
        if (notificationStatusContainer) showUserMessage('Erreur init. notifications. Rechargez.', 'error', notificationStatusContainer, 5000);
        notificationButton.disabled = true;
        notificationButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Erreur Init';
        return;
    }

    async function getTokenAndSaveEnterprise() {
        try {
            notificationButton.classList.add('loading'); // Peut nécessiter une classe CSS 'loading'
            notificationButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
            notificationButton.disabled = true;

            console.log('Tentative d\'obtention du token FCM (entreprise)...');
            // REMPLACEZ PAR VOTRE CLE VAPID REELLE
            const token = await messaging.getToken({ vapidKey: "BDY6Hkwwi0tSnzzww0WJrnJqdeS1d-r2AWJ4Wr9eWQk4dWNmSRjpyvmCqDc99JCW_NRlY8N0PPxUQbrPuxXbrgI" });

            if (token) {
                console.log('Token FCM (entreprise) obtenu:', token);
                const response = await fetch('../ajax/save_fcm_token.php', { // URL pour les entreprises
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token: token, device_info: navigator.userAgent }),
                });
                const data = await response.json();

                if (data.success) {
                    console.log('Token (entreprise) enregistré/mis à jour.');
                    notificationButton.classList.remove('loading');
                    notificationButton.classList.add('notifications-enabled'); // Classe de succès
                    notificationButton.innerHTML = '<i class="fas fa-check-circle"></i> Notifications activées';
                    notificationButton.disabled = true;
                    if (notificationStatusContainer) showUserMessage('Notifications activées!', 'success', notificationStatusContainer);
                } else {
                    throw new Error(data.message || 'Erreur serveur (entreprise).');
                }
            } else {
                throw new Error('Impossible d\'obtenir le token FCM (entreprise).');
            }
        } catch (error) {
            console.error('Erreur dans getTokenAndSaveEnterprise:', error);
            notificationButton.classList.remove('loading');
            notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
            notificationButton.disabled = false;
            let errorMessage = 'Erreur: ';
            if (error.message && error.message.includes("no active Service Worker")) {
                errorMessage += "Aucun Service Worker actif.";
            } else if (error.message && error.message.includes("permission-blocked")) {
                errorMessage += "Permission bloquee.";
            } else if (error.message && error.message.includes("applicationServerKey is not valid")) {
                errorMessage += "Clé VAPID invalide.";
            } else {
                errorMessage += error.message || "Erreur inconnue token (entreprise).";
            }
            if (notificationStatusContainer) showUserMessage(errorMessage, 'error', notificationStatusContainer, 5000);
        }
    }

    async function initializeNotificationStateEnterprise() {
        const currentPermission = Notification.permission;
        console.log('Permission actuelle (entreprise):', currentPermission);

        if (currentPermission === 'granted') {
            console.log('Notifications déjà accordées (entreprise).');
            await getTokenAndSaveEnterprise();
        } else if (currentPermission === 'denied') {
            console.warn('Notifications bloquées (entreprise).');
            notificationButton.disabled = true;
            notificationButton.innerHTML = '<i class="fas fa-bell-slash"></i> Notifications bloquées';
            notificationButton.classList.add('notifications-disabled');
            if (notificationStatusContainer) showUserMessage('Notifications bloquees.', 'error', notificationStatusContainer);
        } else { // default
            console.log('Permissions en attente (entreprise).');
            notificationButton.disabled = false;
            notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
        }
    }

    notificationButton.addEventListener('click', async function () {
        console.log('Clic sur bouton notification (entreprise).');
        const currentPermissionOnClick = Notification.permission;

        if (currentPermissionOnClick === 'granted') {
            await getTokenAndSaveEnterprise();
        } else if (currentPermissionOnClick === 'denied') {
            if (notificationStatusContainer) showUserMessage('Notifications bloquees.', 'error', notificationStatusContainer);
        } else { // default
            try {
                notificationButton.classList.add('loading');
                notificationButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Demande...';
                notificationButton.disabled = true;
                const permissionResult = await Notification.requestPermission();

                if (permissionResult === 'granted') {
                    await getTokenAndSaveEnterprise();
                } else {
                    notificationButton.classList.remove('loading');
                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
                    notificationButton.disabled = false;
                    if (notificationStatusContainer) showUserMessage('Activation refusee.', 'warning', notificationStatusContainer);
                }
            } catch (error) {
                console.error('Erreur demande permission (entreprise):', error);
                notificationButton.classList.remove('loading');
                notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
                notificationButton.disabled = false;
                if (notificationStatusContainer) showUserMessage('Erreur demande permission.', 'error', notificationStatusContainer);
            }
        }
    });

    // Pas besoin de messaging.onMessage ici sauf si vous voulez gérer les notifications 
    // reçues pendant que l'entreprise est activement sur cette page.
    // Si c'est le cas, copiez la logique de onMessage de notifications-user.js en l'adaptant.

    await initializeNotificationStateEnterprise();
}); 