/**
 * Script pour la fonctionnalité de mise en avant des outils informatiques
 */
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const highlightToggleBtn = document.querySelector('.outil-highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.outil-highlight-instructions');
    const saveBtn = document.querySelector('.outil-save-btn');
    const cancelBtn = document.querySelector('.outil-cancel-btn');
    const confirmationMessage = document.querySelector('.outil-highlight-confirmation');
    const toolItems = document.querySelectorAll('.tool-item');

    // Variables d'état
    let selectionMode = false;
    let selectedOutils = new Set();

    // Vérifier que les éléments existent
    if (!highlightToggleBtn || !highlightInstructions || toolItems.length === 0) {
        return;
    }

    // Initialiser les outils déjà mis en avant
    toolItems.forEach(item => {
        if (item.classList.contains('highlighted')) {
            selectedOutils.add(item.dataset.id);
        }
    });

    // Gestionnaire pour le bouton "Mettre en avant"
    highlightToggleBtn.addEventListener('click', function() {
        selectionMode = true;
        highlightInstructions.style.display = 'block';
        highlightToggleBtn.style.display = 'none';
        
        // Activer le mode sélection sur tous les outils
        toolItems.forEach(item => {
            item.classList.add('selectable');
            
            // Masquer tous les boutons d'action pendant la sélection
            const actionButtons = item.querySelectorAll('a, .img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .tool-actions, .delete-tool');
            actionButtons.forEach(btn => {
                btn.style.display = 'none';
            });
        });
    });

    // Gestionnaire pour le bouton "Annuler"
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            exitSelectionMode();
            
            // Restaurer l'état précédent
            toolItems.forEach(item => {
                const wasHighlighted = selectedOutils.has(item.dataset.id);
                item.classList.toggle('highlighted', wasHighlighted);
            });
        });
    }

    // Gestionnaire pour le bouton "Enregistrer"
    if (saveBtn) {
        saveBtn.addEventListener('click', async function() {
            const formData = new FormData();
            formData.append('action', 'updateOutilHighlights');
            formData.append('highlighted_outils', JSON.stringify(Array.from(selectedOutils)));

            try {
                const response = await fetch('../controller/controller_outil_users.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        showConfirmation();
                        exitSelectionMode();
                        
                        // Mettre à jour selectedOutils avec le nouvel état
                        selectedOutils.clear();
                        toolItems.forEach(item => {
                            if (item.classList.contains('highlighted')) {
                                selectedOutils.add(item.dataset.id);
                            }
                        });
                    } else {
                        alert('Erreur: ' + (data.message || 'Erreur inconnue'));
                    }
                } else {
                    if (response.status === 401) {
                        alert('Votre session a expiré. Veuillez vous reconnecter.');
                    } else {
                        alert(`Erreur ${response.status}: ${response.statusText}`);
                    }
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur de connexion au serveur.');
            }
        });
    }

    // Gestionnaire de clic sur les outils
    toolItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Ne pas réagir si on clique sur un lien ou si on n'est pas en mode sélection
            if (e.target.closest('a') || e.target.closest('.tool-actions') || !selectionMode) {
                return;
            }

            // Empêcher la propagation
            e.preventDefault();
            e.stopPropagation();

            const outilId = item.dataset.id;
            
            // Basculer la sélection
            if (selectedOutils.has(outilId)) {
                selectedOutils.delete(outilId);
                item.classList.remove('highlighted');
            } else {
                selectedOutils.add(outilId);
                item.classList.add('highlighted');
            }
        });
    });

    // Fonction pour quitter le mode sélection
    function exitSelectionMode() {
        selectionMode = false;
        highlightInstructions.style.display = 'none';
        highlightToggleBtn.style.display = 'inline-flex';
        
        toolItems.forEach(item => {
            item.classList.remove('selectable');
            
            // Réafficher tous les boutons d'action
            const actionButtons = item.querySelectorAll('a, .img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .tool-actions, .delete-tool');
            actionButtons.forEach(btn => {
                btn.style.display = '';
            });
        });
    }

    // Fonction pour afficher le message de confirmation
    function showConfirmation() {
        if (confirmationMessage) {
            confirmationMessage.style.display = 'block';
            setTimeout(() => {
                confirmationMessage.style.display = 'none';
            }, 3000);
        }
    }
}); 