/**
 * Script simplifié pour la fonctionnalité de mise en avant des expériences professionnelles
 * Version avec bouton uniquement (sans maintien appuyé)
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
    let selectedExperiences = new Set();

    // Initialisation
    function init() {
        if (!experiencesList || !highlightToggleBtn) return;

        // Récupérer toutes les cartes d'expérience
        experienceCards = document.querySelectorAll('.experience-card');

        // Initialiser l'état de chaque carte
        experienceCards.forEach(card => {
            const isHighlighted = card.classList.contains('highlighted');
            const experienceId = card.dataset.id;
            originalHighlightState[experienceId] = isHighlighted;

            // Ajouter seulement les événements de clic
            card.addEventListener('click', handleClick);
        });

        // Ajouter les écouteurs d'événements aux boutons
        highlightToggleBtn.addEventListener('click', toggleSelectionMode);
        if (saveBtn) saveBtn.addEventListener('click', saveHighlightedExperiences);
        if (cancelBtn) cancelBtn.addEventListener('click', cancelHighlighting);
    }

    // Gestionnaire de clic simplifié
    function handleClick(e) {
        if (!selectionMode) return;

        // Ne pas réagir si on clique sur un bouton ou un lien
        if (e.target.closest('a') || e.target.closest('button') || e.target.closest('img.img2-btn')) {
            return;
        }

        toggleCardSelection.call(this, e);
    }

    // Activer/désactiver le mode sélection
    function toggleSelectionMode() {
        selectionMode = !selectionMode;

        if (selectionMode) {
            experiencesList.classList.add('selection-mode');
            highlightInstructions.classList.add('active');
            highlightToggleBtn.innerHTML = '<i class="fas fa-times"></i> Annuler la sélection';
            highlightToggleBtn.classList.add('active');

            // Masquer tous les boutons d'action pendant la sélection
            experienceCards.forEach(card => {
                // Masquer les boutons de modification et suppression
                const actionButtons = card.querySelectorAll('.img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .experience-actions');
                actionButtons.forEach(btn => {
                    btn.style.display = 'none';
                });
            });

            // Initialiser les sélections avec les expériences déjà mises en avant
            selectedExperiences.clear();
            experienceCards.forEach(card => {
                if (card.classList.contains('highlighted')) {
                    selectedExperiences.add(card.dataset.id);
                    card.classList.add('selected');
                }
            });
        } else {
            experiencesList.classList.remove('selection-mode');
            highlightInstructions.classList.remove('active');
            highlightToggleBtn.innerHTML = '<i class="fas fa-star"></i> Mettre en avant';
            highlightToggleBtn.classList.remove('active');

            // Réafficher tous les boutons d'action
            experienceCards.forEach(card => {
                const actionButtons = card.querySelectorAll('.img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .experience-actions');
                actionButtons.forEach(btn => {
                    btn.style.display = '';
                });
            });

            // Supprimer les classes de sélection
            experienceCards.forEach(card => {
                card.classList.remove('selected');
            });

            selectedExperiences.clear();
        }
    }

    // Sélectionner/désélectionner une carte
    function toggleCardSelection(e) {
        const card = this;
        const experienceId = card.dataset.id;

        if (selectedExperiences.has(experienceId)) {
            // Désélectionner
            selectedExperiences.delete(experienceId);
            card.classList.remove('selected');
        } else {
            // Sélectionner
            selectedExperiences.add(experienceId);
            card.classList.add('selected');
        }

        // Effet de vibration sur mobile (si supporté)
        if ('vibrate' in navigator) {
            navigator.vibrate(50);
        }

        // Effet sonore léger (optionnel)
        playSelectSound();
    }

    // Jouer un son de sélection léger (optionnel)
    function playSelectSound() {
        // Créer un son synthétique très court et discret
        if ('AudioContext' in window || 'webkitAudioContext' in window) {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.1);
            } catch (e) {
                // Ignorer les erreurs audio
            }
        }
    }

    // Enregistrer les expériences mises en avant
    function saveHighlightedExperiences() {
        const updates = [];

        // Collecter toutes les mises à jour
        experienceCards.forEach(card => {
            const experienceId = card.dataset.id;
            const isSelected = selectedExperiences.has(experienceId);

            // Mettre à jour l'état visuel
            updateCardHighlight(card, isSelected);

            // Ajouter à la liste des mises à jour
            updates.push({
                id: experienceId,
                highlighted: isSelected
            });
        });

        // Envoyer les mises à jour au serveur
        Promise.all(updates.map(update => {
            const formData = new FormData();
            formData.append('update_mis_en_avant', '1');
            formData.append('experience_id', update.id);
            formData.append('mis_en_avant', update.highlighted ? 1 : 0);

            return fetch('user_profil.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'état original
                    originalHighlightState[update.id] = update.highlighted;
                }
                return data;
            });
        }))
        .then(() => {
            // Désactiver le mode sélection
            toggleSelectionMode();

            // Afficher le message de confirmation
            showConfirmation();
        })
        .catch(error => {
            console.error('Erreur lors de la sauvegarde:', error);
            // Afficher un message d'erreur à l'utilisateur
            showError('Une erreur est survenue lors de la sauvegarde. Veuillez réessayer.');
        });
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

    // Annuler les modifications et restaurer l'état original
    function cancelHighlighting() {
        // Restaurer l'état original de toutes les cartes
        experienceCards.forEach(card => {
            const experienceId = card.dataset.id;
            const originalState = originalHighlightState[experienceId];
            
            updateCardHighlight(card, originalState);
            
            // Restaurer l'état de sélection visuel
            if (originalState) {
                card.classList.add('selected');
                selectedExperiences.add(experienceId);
            } else {
                card.classList.remove('selected');
                selectedExperiences.delete(experienceId);
            }
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

    // Afficher un message d'erreur
    function showError(message) {
        // Créer un élément de message d'erreur temporaire
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
        errorDiv.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        `;

        document.body.appendChild(errorDiv);

        // Supprimer le message après 5 secondes
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }

    // Initialiser le script
    init();
}); 