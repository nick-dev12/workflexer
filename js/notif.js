if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
        registration.pushManager.getSubscription().then(function(subscription) {
            if (subscription === null) {
                // Demande la permission pour les notifications push
                registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array('<Your Public VAPID Key>')
                }).then(function(subscription) {
                    // Envoyer l'abonnement au serveur pour le stocker
                    fetch('/save-subscription.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(subscription)
                    });
                }).catch(function(err) {
                    console.error('Failed to subscribe user: ', err);
                });
            }
        });
    });
}
