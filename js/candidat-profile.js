document.addEventListener('DOMContentLoaded', function () {
    // Animation d'entrée pour la carte de profil
    const profileHeader = document.querySelector('.profile-header');
    if (profileHeader) {
        setTimeout(() => {
            profileHeader.classList.add('visible');
        }, 100);
    }

    // Animation pour les boutons d'action
    const actionButtons = document.querySelectorAll('.action-button');
    actionButtons.forEach((button, index) => {
        setTimeout(() => {
            button.classList.add('animated');
        }, 500 + (index * 100));
    });

    // Gestion du bouton de sauvegarde (favoris)
    const saveButton = document.querySelector('.save-btn');
    if (saveButton) {
        saveButton.addEventListener('click', function () {
            const icon = this.querySelector('i');

            if (icon.classList.contains('fas')) {
                // Retirer des favoris
                icon.classList.remove('fas');
                icon.classList.add('far');

                // Animation de retrait
                this.classList.add('unsaved');
                setTimeout(() => {
                    this.classList.remove('unsaved');
                }, 300);

                // Notification
                showNotification('Profil retiré des favoris', 'info');

            } else {
                // Ajouter aux favoris
                icon.classList.remove('far');
                icon.classList.add('fas');

                // Animation d'ajout
                this.classList.add('saved');
                setTimeout(() => {
                    this.classList.remove('saved');
                }, 300);

                // Notification
                showNotification('Profil ajouté aux favoris', 'success');
            }
        });
    }

    // Animation au survol de l'image de profil
    const profileImage = document.querySelector('.profile-image-wrapper');
    if (profileImage) {
        profileImage.addEventListener('mouseover', function () {
            this.classList.add('hovered');
        });

        profileImage.addEventListener('mouseout', function () {
            this.classList.remove('hovered');
        });
    }

    // Animation pour les métriques (compteurs)
    animateCounters();
});

// Fonction pour animer les compteurs numériques
function animateCounters() {
    const counters = document.querySelectorAll('.metric-value');

    counters.forEach(counter => {
        const target = parseInt(counter.innerText);
        const count = 0;
        const speed = 200; // Vitesse d'animation (ms)

        if (target > 0) {
            const inc = Math.ceil(target / speed);

            const updateCount = () => {
                const value = parseInt(counter.innerText);
                if (value < target) {
                    counter.innerText = Math.min(value + inc, target);
                    setTimeout(updateCount, 1);
                }
            };

            counter.innerText = '0';
            setTimeout(updateCount, 800); // Délai avant de démarrer l'animation
        }
    });
}

// Fonction pour afficher des notifications
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `profile-notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
        </div>
    `;

    // Ajouter à la page
    document.body.appendChild(notification);

    // Animation d'entrée
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Animation de sortie et suppression
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
} 