/**
 * Script pour la fonctionnalité de mise en avant des compétences
 */
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const competenceContainer = document.querySelector('.container_comp');
    const highlightToggleBtn = document.querySelector('.competence-highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.competence-highlight-instructions');
    const saveBtn = document.querySelector('.competence-save-btn');
    const cancelBtn = document.querySelector('.competence-cancel-btn');
    const confirmationMessage = document.querySelector('.competence-highlight-confirmation');

    // Variables d'état
    let selectionMode = false;
    let competenceItems = [];
    let originalHighlightState = {};

    // Initialisation
    function init() {
        if (!competenceContainer || !highlightToggleBtn) return;

        // Récupérer toutes les compétences
        competenceItems = document.querySelectorAll('.comp');

        // Ajouter les checkboxes et icônes à chaque compétence
        competenceItems.forEach(item => {
            // Sauvegarder l'état initial (mis en avant ou non)
            const isHighlighted = item.classList.contains('highlighted');
            const competenceId = item.dataset.id;
            originalHighlightState[competenceId] = isHighlighted;

            // Ajouter l'icône d'étoile si elle n'existe pas déjà
            if (!item.querySelector('.competence-star-icon')) {
                const starIcon = document.createElement('i');
                starIcon.className = 'fas fa-star competence-star-icon';
                item.insertBefore(starIcon, item.firstChild);
            }

            // Créer le conteneur de checkbox
            const checkboxContainer = document.createElement('div');
            checkboxContainer.className = 'competence-checkbox-container';

            // Créer la checkbox
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'competence-checkbox';
            checkbox.checked = isHighlighted;
            checkbox.dataset.id = competenceId;

            // Ajouter un gestionnaire d'événements spécifique à la checkbox
            checkbox.addEventListener('click', function (e) {
                e.stopPropagation(); // Empêcher la propagation du clic
                const isChecked = this.checked;
                updateItemHighlight(item, isChecked);
            });

            // Ajouter la checkbox au conteneur
            checkboxContainer.appendChild(checkbox);

            // Ajouter le conteneur à l'élément de compétence
            item.appendChild(checkboxContainer);

            // Ajouter l'écouteur d'événements pour le maintien long
            item.addEventListener('mousedown', handleLongPress);
            item.addEventListener('touchstart', handleLongPress);
            item.addEventListener('mouseup', cancelLongPress);
            item.addEventListener('mouseleave', cancelLongPress);
            item.addEventListener('touchend', cancelLongPress);
            item.addEventListener('touchcancel', cancelLongPress);
        });

        // Ajouter les écouteurs d'événements aux boutons
        highlightToggleBtn.addEventListener('click', toggleSelectionMode);
        if (saveBtn) saveBtn.addEventListener('click', saveHighlightedCompetences);
        if (cancelBtn) cancelBtn.addEventListener('click', cancelHighlighting);
    }

    // Variable pour suivre le temps de pression
    let pressTimer;

    // Gestionnaire pour le maintien long
    function handleLongPress(e) {
        // Empêcher le comportement par défaut pour les événements tactiles
        if (e.type === 'touchstart') {
            e.preventDefault();
        }

        // Démarrer un minuteur
        pressTimer = window.setTimeout(() => {
            // Activer le mode sélection si pas déjà actif
            if (!selectionMode) {
                toggleSelectionMode();
            }
        }, 500); // 500ms pour un maintien long
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
            competenceContainer.classList.add('selection-mode');
            highlightInstructions.classList.add('active');
            highlightToggleBtn.innerHTML = '<i class="fas fa-times"></i> Annuler la sélection';

            // Ajouter des écouteurs d'événements aux compétences pour la sélection
            competenceItems.forEach(item => {
                // Désactiver temporairement les liens de suppression
                const deleteLink = item.querySelector('a');
                if (deleteLink) {
                    deleteLink.style.pointerEvents = 'none';
                }

                item.addEventListener('click', toggleItemSelection);
            });
        } else {
            competenceContainer.classList.remove('selection-mode');
            highlightInstructions.classList.remove('active');
            highlightToggleBtn.innerHTML = '<i class="fas fa-star"></i> Mettre en avant';

            // Supprimer les écouteurs d'événements des compétences et réactiver les liens
            competenceItems.forEach(item => {
                // Réactiver les liens de suppression
                const deleteLink = item.querySelector('a');
                if (deleteLink) {
                    deleteLink.style.pointerEvents = 'auto';
                }

                item.removeEventListener('click', toggleItemSelection);
            });
        }
    }

    // Sélectionner/désélectionner une compétence
    function toggleItemSelection(e) {
        // Ne pas réagir si on clique sur un bouton ou un lien ou sur la checkbox elle-même
        if (e.target.closest('a') || e.target.closest('button') || e.target.classList.contains('competence-checkbox')) {
            return;
        }

        const item = this;
        const checkbox = item.querySelector('.competence-checkbox');

        // Inverser l'état de la checkbox
        checkbox.checked = !checkbox.checked;

        // Mettre à jour visuellement la compétence
        updateItemHighlight(item, checkbox.checked);
    }

    // Mettre à jour l'apparence d'une compétence selon son état de sélection
    function updateItemHighlight(item, isHighlighted) {
        if (isHighlighted) {
            item.classList.add('highlighted');
        } else {
            item.classList.remove('highlighted');
        }
    }

    // Enregistrer les compétences mises en avant
    function saveHighlightedCompetences() {
        const updates = [];

        // Collecter toutes les mises à jour
        competenceItems.forEach(item => {
            const checkbox = item.querySelector('.competence-checkbox');
            const competenceId = checkbox.dataset.id;
            const isHighlighted = checkbox.checked;

            // Mettre à jour l'état visuel
            updateItemHighlight(item, isHighlighted);

            // Ajouter à la liste des mises à jour
            updates.push({
                id: competenceId,
                highlighted: isHighlighted
            });
        });

        // Envoyer les mises à jour au serveur
        updates.forEach(update => {
            const formData = new FormData();
            formData.append('update_competence_mis_en_avant', '1');
            formData.append('competence_id', update.id);
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
        competenceItems.forEach(item => {
            const checkbox = item.querySelector('.competence-checkbox');
            const competenceId = checkbox.dataset.id;

            // Restaurer l'état original
            checkbox.checked = originalHighlightState[competenceId];
            updateItemHighlight(item, originalHighlightState[competenceId]);
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