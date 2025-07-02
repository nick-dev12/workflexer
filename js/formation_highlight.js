/**
 * Script pour la fonctionnalité de mise en avant des formations
 */
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const highlightToggleBtn = document.querySelector('.formation-highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.formation-highlight-instructions');
    const saveBtn = document.querySelector('.formation-save-btn');
    const cancelBtn = document.querySelector('.formation-cancel-btn');
    const confirmationMessage = document.querySelector('.formation-highlight-confirmation');
    const formationCards = document.querySelectorAll('.formation-card');

    // Variables d'état
    let selectionMode = false;
    let selectedFormations = new Set();

    // Vérifier que les éléments existent
    if (!highlightToggleBtn || !highlightInstructions || formationCards.length === 0) {
        return;
    }

    // Initialiser les formations déjà mises en avant
    formationCards.forEach(card => {
        if (card.classList.contains('highlighted')) {
            selectedFormations.add(card.dataset.id);
        }
    });

    // Gestionnaire pour le bouton "Mettre en avant"
    highlightToggleBtn.addEventListener('click', function() {
        selectionMode = true;
        highlightInstructions.style.display = 'block';
        highlightToggleBtn.style.display = 'none';
        
        // Activer le mode sélection sur toutes les formations
        formationCards.forEach(card => {
            card.classList.add('selectable');
            
            // Masquer tous les boutons d'action pendant la sélection
            const actionButtons = card.querySelectorAll('.edit-btn, .delete-btn, .img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .formation-actions, a');
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
            formationCards.forEach(card => {
                const wasHighlighted = selectedFormations.has(card.dataset.id);
                card.classList.toggle('highlighted', wasHighlighted);
            });
        });
    }

    // Gestionnaire pour le bouton "Enregistrer"
    if (saveBtn) {
        saveBtn.addEventListener('click', async function() {
            console.log("Bouton Enregistrer cliqué");
            console.log("Formations sélectionnées:", Array.from(selectedFormations));

            const formData = new FormData();
            formData.append('action', 'updateFormationHighlights');
            formData.append('highlighted_formations', JSON.stringify(Array.from(selectedFormations)));

            try {
                console.log("Envoi de la requête AJAX");
                const response = await fetch('../controller/controller_formation_users.php', {
                    method: 'POST',
                    body: formData
                });

                console.log("Réponse reçue:", response);

                if (response.ok) {
                    const data = await response.json();
                    console.log("Données reçues:", data);
                    showConfirmation();
                    exitSelectionMode();
                    
                    // Mettre à jour selectedFormations avec le nouvel état
                    selectedFormations.clear();
                    formationCards.forEach(card => {
                        if (card.classList.contains('highlighted')) {
                            selectedFormations.add(card.dataset.id);
                        }
                    });
                } else {
                    console.error('Erreur lors de la mise à jour:', response.status, response.statusText);
                    const errorText = await response.text();
                    console.error('Détails de l\'erreur:', errorText);
                }
            } catch (error) {
                console.error('Erreur:', error);
            }
        });
    }

    // Gestionnaire de clic sur les formations
    formationCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Ne pas réagir si on clique sur un bouton/lien ou si on n'est pas en mode sélection
            if (e.target.closest('.edit-btn') || e.target.closest('.delete-btn') || !selectionMode) {
                return;
            }

            // Empêcher la propagation
            e.preventDefault();
            e.stopPropagation();

            const formationId = card.dataset.id;
            
            // Basculer la sélection
            if (selectedFormations.has(formationId)) {
                selectedFormations.delete(formationId);
                card.classList.remove('highlighted');
            } else {
                selectedFormations.add(formationId);
                card.classList.add('highlighted');
            }

            console.log("Formation sélectionnée/désélectionnée:", formationId);
            console.log("État actuel des sélections:", Array.from(selectedFormations));
        });
    });

    // Fonction pour quitter le mode sélection
    function exitSelectionMode() {
        selectionMode = false;
        highlightInstructions.style.display = 'none';
        highlightToggleBtn.style.display = 'inline-flex';
        
        formationCards.forEach(card => {
            card.classList.remove('selectable');
            
            // Réafficher tous les boutons d'action
            const actionButtons = card.querySelectorAll('.edit-btn, .delete-btn, .img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .formation-actions, a');
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