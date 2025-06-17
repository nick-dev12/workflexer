import { notificationManager } from './notification-manager.js';

document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Ajouter un bouton d'activation des notifications si nécessaire
        const notificationButton = document.createElement('button');
        notificationButton.className = 'notification-button';
        notificationButton.innerHTML = `
            <i class="fas fa-bell"></i>
            <span>Activer les notifications</span>
        `;

        // Ajouter le bouton au DOM
        document.querySelector('.header-actions')?.appendChild(notificationButton);

        // Gérer le clic sur le bouton
        notificationButton.addEventListener('click', async () => {
            try {
                // Afficher un message d'information
                const infoMessage = document.createElement('div');
                infoMessage.className = 'notification-info';
                infoMessage.textContent = 'Les notifications nous permettent de vous tenir informé des nouvelles opportunités et des mises à jour importantes.';
                document.body.appendChild(infoMessage);

                // Demander la permission
                await notificationManager.requestPermission();

                // Mettre à jour l'apparence du bouton
                notificationButton.classList.add('notifications-enabled');
                notificationButton.querySelector('span').textContent = 'Notifications activées';

                // Supprimer le message d'information après 3 secondes
                setTimeout(() => {
                    infoMessage.remove();
                }, 3000);
            } catch (error) {
                console.error('Erreur lors de l\'activation des notifications:', error);

                // Afficher un message d'erreur à l'utilisateur
                const errorMessage = document.createElement('div');
                errorMessage.className = 'notification-error';
                errorMessage.textContent = 'Impossible d\'activer les notifications. Veuillez vérifier les paramètres de votre navigateur.';
                document.body.appendChild(errorMessage);

                // Supprimer le message d'erreur après 5 secondes
                setTimeout(() => {
                    errorMessage.remove();
                }, 5000);
            }
        });
    } catch (error) {
        console.error('Erreur lors de l\'initialisation des notifications:', error);
    }
}); 