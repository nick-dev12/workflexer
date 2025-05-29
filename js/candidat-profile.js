/**
 * Script pour les animations et interactions de la page de profil candidat
 */
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

    // Animation pour l'image de profil au survol
    const profileImage = document.querySelector('.profile-image-wrapper');
    if (profileImage) {
        profileImage.addEventListener('mouseover', function () {
            this.style.transform = 'scale(1.05)';
        });

        profileImage.addEventListener('mouseout', function () {
            this.style.transform = 'scale(1)';
        });
    }

    // Animation pour les métriques (compteur)
    const metricValues = document.querySelectorAll('.metric-value');
    metricValues.forEach(metric => {
        const targetValue = parseInt(metric.textContent);
        let currentValue = 0;

        // Animation du compteur uniquement si l'élément est visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Commencer l'animation
                    const duration = 1500; // ms
                    const frameRate = 30; // fps
                    const increment = Math.ceil(targetValue / (duration / 1000 * frameRate));

                    const counter = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= targetValue) {
                            metric.textContent = targetValue;
                            clearInterval(counter);
                        } else {
                            metric.textContent = currentValue;
                        }
                    }, 1000 / frameRate);

                    // Arrêter d'observer une fois l'animation démarrée
                    observer.disconnect();
                }
            });
        }, { threshold: 0.5 });

        observer.observe(metric);
    });

    // Effet parallaxe sur l'arrière-plan du profil
    const profileBackground = document.querySelector('.profile-background');
    if (profileBackground) {
        window.addEventListener('scroll', function () {
            const scrollPosition = window.scrollY;
            if (scrollPosition < 500) { // Limiter l'effet aux 500 premiers pixels de défilement
                profileBackground.style.backgroundPositionY = `${scrollPosition * 0.5}px`;
            }
        });
    }

    // Animation des compétences au défilement
    const animateOnScroll = (elements, className) => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add(className);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(el => {
            observer.observe(el);
        });
    };

    // Animer les cartes d'expérience
    animateOnScroll(document.querySelectorAll('.experience-card'), 'animate-fade-in');

    // Animer les compétences
    animateOnScroll(document.querySelectorAll('.comp'), 'animate-scale-in');

    // Animer les formations
    animateOnScroll(document.querySelectorAll('.formation-card'), 'animate-slide-in');

    // Effet de survol sur les boutons d'action
    actionButtons.forEach(button => {
        button.addEventListener('mouseover', function () {
            this.style.transform = 'translateY(-3px)';
        });

        button.addEventListener('mouseout', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // Initialiser AOS (Animate On Scroll) si présent
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
});

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