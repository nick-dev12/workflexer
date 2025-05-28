document.addEventListener('DOMContentLoaded', async function () {
    const notificationButton = document.getElementById('notification-button-user');
    const notificationStatus = document.getElementById('notification-status');
    const fullscreenNotification = document.getElementById('fullscreen-notification');
    const closeNotificationButton = document.getElementById('close-notification');

    // Vérifier si les notifications sont déjà activées
    const notificationsEnabled = localStorage.getItem('notifications_enabled') === 'true';

    // Vérifier si la notification a été fermée récemment
    const lastDismissedTime = localStorage.getItem('notification_closed_time');
    const currentTime = new Date().getTime();
    // Définir un délai d'expiration (1 minute en millisecondes)
    const dismissExpiration = 1 * 60 * 1000;
    const notificationClosedRecently = lastDismissedTime && (currentTime - parseInt(lastDismissedTime) < dismissExpiration);

    if (!notificationButton || !notificationStatus || !fullscreenNotification) {
        console.warn("Éléments de notification non trouvés.");
        return;
    }

    // Fonctions pour gérer l'affichage de la notification en plein écran
    function showFullscreenNotification() {
        fullscreenNotification.style.display = 'flex';
        setTimeout(() => {
            fullscreenNotification.classList.add('visible');
        }, 50); // Petit délai pour permettre la transition
    }

    function hideFullscreenNotification() {
        fullscreenNotification.classList.remove('visible');
        setTimeout(() => {
            fullscreenNotification.style.display = 'none';
        }, 500); // Correspondant à la durée de transition
    }

    // Gestion du bouton de fermeture
    if (closeNotificationButton) {
        closeNotificationButton.addEventListener('click', function () {
            hideFullscreenNotification();
            // Stocker le timestamp actuel plutôt qu'un simple booléen
            localStorage.setItem('notification_closed_time', new Date().getTime().toString());
        });
    }

    // Si les notifications ne sont pas activées et la notification n'a pas été fermée récemment,
    // afficher la notification après 5 secondes
    if (!notificationsEnabled && !notificationClosedRecently) {
        setTimeout(() => {
            showFullscreenNotification();
        }, 5000);
    }

    // Vérifications initiales de support
    if (!('Notification' in window) || !('serviceWorker' in navigator)) {
        console.warn('Notifications ou Service Worker non supportés par ce navigateur.');
        notificationButton.disabled = true;
        notificationButton.innerHTML = '<i class="fas fa-bell-slash"></i> Non supporté';
        showUserMessage('Les notifications ne sont pas supportées par ce navigateur.', 'warning');
        return;
    }

    const firebaseConfig = {
        apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
        authDomain: "send-notification-257c0.firebaseapp.com",
        projectId: "send-notification-257c0",
        storageBucket: "send-notification-257c0.firebasestorage.app",
        messagingSenderId: "276851238884",
        appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
        measurementId: "G-N4TGHGX008"
    };

    if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
    }
    const messaging = firebase.messaging();

    function showUserMessage(message, type = 'info', duration = 3000) {
        if (!notificationStatus) return;
        const messageBadge = document.createElement('div');
        messageBadge.className = `notification-${type}`;
        messageBadge.innerHTML = message;
        notificationStatus.innerHTML = '';
        notificationStatus.appendChild(messageBadge);
        setTimeout(() => {
            messageBadge.style.opacity = '0';
            setTimeout(() => {
                if (messageBadge.parentNode) {
                    messageBadge.parentNode.removeChild(messageBadge);
                }
            }, 300);
        }, duration);
    }

    // --- Déplacé la logique d'enregistrement du SW et useServiceWorker ici ---
    try {
        console.log('Enregistrement du Service Worker...');
        // Enregistrer le SW
        const swRegistration = await navigator.serviceWorker.register('/firebase-messaging-sw.js', { scope: '/' });
        console.log('Service Worker enregistré avec succès:', swRegistration);

        // Attendre que le SW soit prêt et actif
        await navigator.serviceWorker.ready;
        console.log('Service Worker est prêt et actif.');

        // Suppression de l'appel à messaging.useServiceWorker qui n'existe plus dans cette version de Firebase

    } catch (error) {
        console.error('Erreur critique lors de l\'initialisation du Service Worker:', error);
        showUserMessage('Erreur initialisation notifications. Rechargez la page.', 'error', 5000);
        notificationButton.disabled = true;
        notificationButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Erreur Init';
        return; // Bloquer la suite si cette étape échoue
    }
    // --- Fin du bloc déplacé ---

    async function getTokenAndSave() {
        try {
            notificationButton.classList.add('loading');
            notificationButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
            notificationButton.disabled = true;

            console.log('Tentative d\'obtention du token FCM...');
            const token = await messaging.getToken({ vapidKey: "BDY6Hkwwi0tSnzzww0WJrnJqdeS1d-r2AWJ4Wr9eWQk4dWNmSRjpyvmCqDc99JCW_NRlY8N0PPxUQbrPuxXbrgI" });

            if (token) {
                console.log('Token FCM obtenu:', token);
                const response = await fetch('../ajax/save_fcm_token_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token: token, device_info: navigator.userAgent }),
                });
                const data = await response.json();

                if (data.success) {
                    console.log('Token enregistré/mis à jour avec succès.');
                    notificationButton.classList.remove('loading');
                    notificationButton.classList.add('enabled');
                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Notifications activées';
                    notificationButton.disabled = true;
                    showUserMessage('Notifications activées avec succès!', 'success');

                    // Marquer les notifications comme activées dans localStorage
                    localStorage.setItem('notifications_enabled', 'true');

                    // Supprimer l'horodatage de fermeture de notification lors de l'activation
                    localStorage.removeItem('notification_closed_time');

                    // Masquer la notification en plein écran si elle est visible
                    if (fullscreenNotification.classList.contains('visible')) {
                        hideFullscreenNotification();
                    }
                } else {
                    throw new Error(data.message || 'Erreur serveur lors de la sauvegarde du token.');
                }
            } else {
                throw new Error('Impossible d\'obtenir le token FCM (token vide).');
            }
        } catch (error) {
            console.error('Erreur dans getTokenAndSave:', error);
            notificationButton.classList.remove('loading');
            notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
            notificationButton.disabled = false;
            let errorMessage = 'Erreur: ';
            if (error.message && error.message.includes("no active Service Worker")) {
                errorMessage += "Aucun Service Worker actif. Rechargez ou vérifiez la console.";
            } else if (error.message && error.message.includes("permission-blocked")) {
                errorMessage += "Permission bloquee.";
            } else {
                errorMessage += error.message || "Erreur inconnue lors de l\'obtention du token.";
            }
            showUserMessage(errorMessage, 'error', 5000);
        }
    }

    async function initializeNotificationState() {
        const currentPermission = Notification.permission;
        console.log('Permission de notification actuelle (initialisation):', currentPermission);

        if (currentPermission === 'granted') {
            console.log('Notifications déjà accordées, obtention/mise à jour du token.');
            await getTokenAndSave();
        } else if (currentPermission === 'denied') {
            console.warn('Notifications bloquées par l\'utilisateur.');
            notificationButton.disabled = true;
            notificationButton.innerHTML = '<i class="fas fa-bell-slash"></i> Notifications bloquées';
            showUserMessage('Notifications bloquees. Verifiez parametres navigateur.', 'error');
        } else { // default
            console.log('Permissions de notification en attente (default).');
            notificationButton.disabled = false;
            notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
        }
    }

    notificationButton.addEventListener('click', async function () {
        console.log('Clic sur le bouton de notification.');
        const currentPermissionOnClick = Notification.permission;
        console.log('Permission au moment du clic:', currentPermissionOnClick);

        if (currentPermissionOnClick === 'granted') {
            console.log('Notifications déjà accordées (clic), tentative de rafraîchissement du token.');
            await getTokenAndSave();
        } else if (currentPermissionOnClick === 'denied') {
            showUserMessage('Les notifications sont bloquées. Modifiez les paramètres du navigateur.', 'error');
        } else { // default
            try {
                notificationButton.classList.add('loading');
                notificationButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Demande en cours...';
                notificationButton.disabled = true;

                console.log('Demande de permission de notification...');
                const permissionResult = await Notification.requestPermission();
                console.log('Résultat de la demande de permission:', permissionResult);

                if (permissionResult === 'granted') {
                    console.log('Permission accordée suite au clic.');
                    await getTokenAndSave();
                } else {
                    console.warn('Permission refusée suite au clic.');
                    notificationButton.classList.remove('loading');
                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
                    notificationButton.disabled = false;
                    showUserMessage('Activation refusee.', 'warning');
                }
            } catch (error) {
                console.error('Erreur lors de la demande de permission:', error);
                notificationButton.classList.remove('loading');
                notificationButton.innerHTML = '<i class="fas fa-bell"></i> Activer les notifications';
                notificationButton.disabled = false;
                showUserMessage('Erreur demande permission.', 'error');
            }
        }
    });

    messaging.onMessage((payload) => {
        console.log('Message reçu en premier plan:', payload);
        if (payload.notification) {
            let notificationTitle = payload.notification.title || "Nouvelle notification";
            if (notificationTitle.length > 50) {
                notificationTitle = notificationTitle.substring(0, 47) + '...';
            }
            const notificationOptions = {
                body: payload.notification.body || '',
                icon: payload.notification.icon || '/image/logo_carre.png',
                badge: '/image/logo_carre.png',
                data: payload.data || {}
            };
            const notification = new Notification(notificationTitle, notificationOptions);
            notification.onclick = function (event) {
                event.preventDefault();
                window.focus();
                if (payload.data && payload.data.url) {
                    window.location.href = payload.data.url;
                } else {
                    window.location.href = '/page/user_profil.php';
                }
                notification.close();
            };
        } else {
            console.log("Payload reçu sans champ 'notification':", payload);
        }
    });

    // Initialiser l'état des notifications après la configuration du SW
    await initializeNotificationState();
});