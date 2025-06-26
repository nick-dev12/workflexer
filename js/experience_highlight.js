/**
 * Script pour la fonctionnalité de mise en avant des expériences professionnelles
 */
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const experiencesList = document.querySelector('.experiences-list');
    const highlightToggleBtn = document.querySelector('.highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.highlight-instructions');
    const saveBtn = document.querySelector('.save-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const confirmationMessage = document.querySelector('.highlight-confirmation');

    // Variables d'état
    let selectionMode = false;
    let experienceCards = [];
    let originalHighlightState = {};

    // Variables pour la gestion du "long press"
    let pressTimer = null;
    let touchStartX = 0;
    let touchStartY = 0;
    const longPressDuration = 500; // 500ms
    const moveThreshold = 10; // Seuil de mouvement en pixels pour considérer comme un scroll

    // Initialisation
    function init() {
        if (!experiencesList || !highlightToggleBtn) return;

        // Récupérer toutes les cartes d'expérience
        experienceCards = document.querySelectorAll('.experience-card');

        // Ajouter les checkboxes à chaque carte
        experienceCards.forEach(card => {
            // Sauvegarder l'état initial (mis en avant ou non)
            const isHighlighted = card.classList.contains('highlighted');
            const experienceId = card.dataset.id;
            originalHighlightState[experienceId] = isHighlighted;

            // Créer le conteneur de checkbox
            const checkboxContainer = document.createElement('div');
            checkboxContainer.className = 'highlight-checkbox-container';

            // Créer la checkbox
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'highlight-checkbox';
            checkbox.checked = isHighlighted;
            checkbox.dataset.id = experienceId;

            // Ajouter la checkbox au conteneur
            checkboxContainer.appendChild(checkbox);

            // Ajouter le conteneur à la carte
            card.appendChild(checkboxContainer);

            // Ajouter les écouteurs d'événements pour le maintien long
            card.addEventListener('mousedown', handleLongPress);
            card.addEventListener('touchstart', handleLongPress);
            card.addEventListener('mouseup', cancelLongPress);
            card.addEventListener('mouseleave', cancelLongPress);
            card.addEventListener('touchend', cancelLongPress);
            card.addEventListener('touchcancel', cancelLongPress);
            card.addEventListener('touchmove', handleTouchMove); // Gérer le scroll
        });

        // Ajouter les écouteurs d'événements aux boutons
        highlightToggleBtn.addEventListener('click', toggleSelectionMode);
        if (saveBtn) saveBtn.addEventListener('click', saveHighlightedExperiences);
        if (cancelBtn) cancelBtn.addEventListener('click', cancelHighlighting);
    }

    // Gestionnaire pour le maintien long
    function handleLongPress(e) {
        if (e.type === 'touchstart') {
            // Enregistrer les coordonnées de départ pour différencier clic et scroll
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }
        
        // Démarrer un minuteur
        pressTimer = window.setTimeout(() => {
            // Activer le mode sélection si pas déjà actif
            if (!selectionMode) {
                toggleSelectionMode();
            }
        }, longPressDuration);
    }

    // Gestionnaire de mouvement pour annuler le "long press" en cas de scroll
    function handleTouchMove(e) {
        if (!pressTimer) {
            return;
        }

        const touchX = e.touches[0].clientX;
        const touchY = e.touches[0].clientY;

        // Si le doigt a bougé au-delà du seuil, c'est un scroll, pas un "long press"
        if (Math.abs(touchX - touchStartX) > moveThreshold || Math.abs(touchY - touchStartY) > moveThreshold) {
            cancelLongPress();
        }
    }

    // Annuler le minuteur si l'utilisateur relâche avant la fin
    function cancelLongPress() {
        if (pressTimer) {
            window.clearTimeout(pressTimer);
            pressTimer = null;
        }
    }

    // Activer/désactiver le mode sélection
    function toggleSelectionMode() {
        selectionMode = !selectionMode;

        if (selectionMode) {
            experiencesList.classList.add('selection-mode');
            highlightInstructions.classList.add('active');
            highlightToggleBtn.innerHTML = '<i class="fas fa-times"></i> Annuler la sélection';

            // Ajouter des écouteurs d'événements aux cartes pour la sélection
            experienceCards.forEach(card => {
                card.addEventListener('click', toggleCardSelection);
            });
        } else {
            experiencesList.classList.remove('selection-mode');
            highlightInstructions.classList.remove('active');
            highlightToggleBtn.innerHTML = '<i class="fas fa-star"></i> Mettre en avant';

            // Supprimer les écouteurs d'événements des cartes
            experienceCards.forEach(card => {
                card.removeEventListener('click', toggleCardSelection);
            });
        }
    }

    // Sélectionner/désélectionner une carte
    function toggleCardSelection(e) {
        // Ne pas réagir si on clique sur un bouton ou un lien
        if (e.target.closest('a') || e.target.closest('button') || e.target.closest('img.img2-btn')) {
            return;
        }

        const card = this;
        const checkbox = card.querySelector('.highlight-checkbox');

        // Inverser l'état de la checkbox
        checkbox.checked = !checkbox.checked;

        // Mettre à jour visuellement la carte
        updateCardHighlight(card, checkbox.checked);
    }

    // Mettre à jour l'apparence d'une carte selon son état de sélection
    function updateCardHighlight(card, isHighlighted) {
        if (isHighlighted) {
            card.classList.add('highlighted');

            // Vérifier si le badge existe déjà
            if (!card.querySelector('.highlighted-badge')) {
                const badge = document.createElement('div');
                badge.className = 'highlighted-badge';
                badge.innerHTML = '<i class="fas fa-star"></i> Mis en avant';
                card.appendChild(badge);
            }
        } else {
            card.classList.remove('highlighted');

            // Supprimer le badge s'il existe
            const badge = card.querySelector('.highlighted-badge');
            if (badge) {
                badge.remove();
            }
        }
    }

    // Enregistrer les expériences mises en avant
    function saveHighlightedExperiences() {
        const updates = [];

        // Collecter toutes les mises à jour
        experienceCards.forEach(card => {
            const checkbox = card.querySelector('.highlight-checkbox');
            const experienceId = checkbox.dataset.id;
            const isHighlighted = checkbox.checked;

            // Mettre à jour l'état visuel
            updateCardHighlight(card, isHighlighted);

            // Ajouter à la liste des mises à jour
            updates.push({
                id: experienceId,
                highlighted: isHighlighted
            });
        });

        // Envoyer les mises à jour au serveur
        updates.forEach(update => {
            const formData = new FormData();
            formData.append('update_mis_en_avant', '1');
            formData.append('experience_id', update.id);
            formData.append('mis_en_avant', update.highlighted ? 1 : 0);

            fetch('user_profil.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour l'état original
                        originalHighlightState[update.id] = update.highlighted;
                    }
                })
                .catch(error => console.error('Erreur:', error));
        });

        // Désactiver le mode sélection
        toggleSelectionMode();

        // Afficher le message de confirmation
        showConfirmation();
    }

    // Annuler les modifications et restaurer l'état original
    function cancelHighlighting() {
        experienceCards.forEach(card => {
            const checkbox = card.querySelector('.highlight-checkbox');
            const experienceId = checkbox.dataset.id;

            // Restaurer l'état original
            checkbox.checked = originalHighlightState[experienceId];
            updateCardHighlight(card, originalHighlightState[experienceId]);
        });

        // Désactiver le mode sélection
        toggleSelectionMode();
    }

    // Afficher le message de confirmation
    function showConfirmation() {
        confirmationMessage.classList.add('show');

        // Masquer le message après 3 secondes
        setTimeout(() => {
            confirmationMessage.classList.remove('show');
        }, 3000);
    }

    // Initialiser le script
    init();
}); 