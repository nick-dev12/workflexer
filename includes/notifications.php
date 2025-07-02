<?php
// Affichage des notifications
if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
    <div class="notifications-container">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="notification success">
                <div class="notification-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="notification-content">
                    <?= $_SESSION['success_message'] ?>
                </div>
                <button class="notification-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="notification error">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="notification-content">
                    <?= $_SESSION['error_message'] ?>
                </div>
                <button class="notification-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </div>

    <script>
        // Gestion des notifications
        document.addEventListener('DOMContentLoaded', function () {
            // Fonction pour fermer une notification
            function closeNotification(notification) {
                notification.classList.add('notification-hiding');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }

            // Gestionnaire pour les boutons de fermeture
            document.querySelectorAll('.notification-close').forEach(button => {
                button.addEventListener('click', () => {
                    const notification = button.closest('.notification');
                    closeNotification(notification);
                });
            });

            // Auto-fermeture après 6 secondes
            document.querySelectorAll('.notification').forEach(notification => {
                setTimeout(() => {
                    closeNotification(notification);
                }, 6000);
            });
        });
    </script>
<?php endif; ?>