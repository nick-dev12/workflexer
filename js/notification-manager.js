import firebaseConfig from './firebase-config.js';

class NotificationManager {
    constructor() {
        this.messaging = null;
        this.isSupported = false;
        this.initialize();
    }

    async initialize() {
        try {
            // Vérifier si le navigateur supporte les notifications
            if (!('Notification' in window)) {
                console.warn('Ce navigateur ne supporte pas les notifications.');
                return;
            }

            // Vérifier si Firebase est disponible
            if (typeof firebase === 'undefined') {
                await this.loadFirebaseScripts();
            }

            // Initialiser Firebase
            if (!firebase.apps.length) {
                firebase.initializeApp(firebaseConfig);
            }

            this.messaging = firebase.messaging();
            this.isSupported = true;

            // Configurer le service worker
            if ('serviceWorker' in navigator) {
                const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js', {
                    scope: '/',
                    updateViaCache: 'none'
                });

                this.messaging.useServiceWorker(registration);
            }
        } catch (error) {
            console.error('Erreur lors de l\'initialisation des notifications:', error);
        }
    }

    async loadFirebaseScripts() {
        const scripts = [
            'https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js',
            'https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js'
        ];

        for (const src of scripts) {
            await new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = src;
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }
    }

    async requestPermission() {
        try {
            if (!this.isSupported) {
                throw new Error('Les notifications ne sont pas supportées sur ce navigateur.');
            }

            // Demander la permission avec une explication
            const permission = await Notification.requestPermission();

            if (permission === 'granted') {
                const token = await this.messaging.getToken({
                    vapidKey: firebaseConfig.vapidKey
                });

                // Sauvegarder le token selon le type d'utilisateur
                if (this.isEnterprise()) {
                    await this.saveEnterpriseToken(token);
                } else {
                    await this.saveUserToken(token);
                }

                return true;
            } else {
                throw new Error('Permission refusée pour les notifications.');
            }
        } catch (error) {
            console.error('Erreur lors de la demande de permission:', error);
            throw error;
        }
    }

    isEnterprise() {
        // Vérifier si l'utilisateur est une entreprise (à adapter selon votre logique)
        return document.body.classList.contains('enterprise-user');
    }

    async saveEnterpriseToken(token) {
        const response = await fetch('/ajax/save_fcm_token.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ token })
        });

        if (!response.ok) {
            throw new Error('Erreur lors de la sauvegarde du token entreprise');
        }

        return await response.json();
    }

    async saveUserToken(token) {
        const response = await fetch('/ajax/save_fcm_token_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ token })
        });

        if (!response.ok) {
            throw new Error('Erreur lors de la sauvegarde du token utilisateur');
        }

        return await response.json();
    }
}

// Exporter l'instance
export const notificationManager = new NotificationManager(); 