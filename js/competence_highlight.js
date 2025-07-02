/**
 * Script pour la fonctionnalité de mise en avant des compétences
 */
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const highlightToggleBtn = document.querySelector('.competence-highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.competence-highlight-instructions');
    const saveBtn = document.querySelector('.competence-save-btn');
    const cancelBtn = document.querySelector('.competence-cancel-btn');
    const confirmationMessage = document.querySelector('.competence-highlight-confirmation');
    const competenceItems = document.querySelectorAll('.comp');

    // Variables d'état
    let selectionMode = false;
    let selectedCompetences = new Set();

    // Vérifier que les éléments existent
    if (!highlightToggleBtn || !highlightInstructions || competenceItems.length === 0) {
        return;
    }

    // Initialiser les compétences déjà mises en avant
    competenceItems.forEach(item => {
        if (item.classList.contains('highlighted')) {
            selectedCompetences.add(item.dataset.id);
        }
    });

    // Gestionnaire pour le bouton "Mettre en avant"
    highlightToggleBtn.addEventListener('click', function() {
        selectionMode = true;
        highlightInstructions.style.display = 'block';
        highlightToggleBtn.style.display = 'none';
        
        // Activer le mode sélection sur toutes les compétences
        competenceItems.forEach(item => {
            item.classList.add('selectable');
            
            // Masquer tous les boutons d'action pendant la sélection
            const actionButtons = item.querySelectorAll('a, .img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .competence-actions');
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
            competenceItems.forEach(item => {
                const wasHighlighted = selectedCompetences.has(item.dataset.id);
                item.classList.toggle('highlighted', wasHighlighted);
            });
        });
    }

    // Gestionnaire pour le bouton "Enregistrer"
    if (saveBtn) {
        saveBtn.addEventListener('click', async function() {
            const formData = new FormData();
            formData.append('action', 'updateCompetenceHighlights');
            formData.append('highlighted_competences', JSON.stringify(Array.from(selectedCompetences)));

            try {
                const response = await fetch('../controller/controller_competence_users.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        showConfirmation();
                        exitSelectionMode();
                        
                        // Mettre à jour selectedCompetences avec le nouvel état
                        selectedCompetences.clear();
                        competenceItems.forEach(item => {
                            if (item.classList.contains('highlighted')) {
                                selectedCompetences.add(item.dataset.id);
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

    // Gestionnaire de clic sur les compétences
    competenceItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Ne pas réagir si on clique sur un lien ou si on n'est pas en mode sélection
            if (e.target.closest('a') || !selectionMode) {
                return;
            }

            // Empêcher la propagation
            e.preventDefault();
            e.stopPropagation();

            const competenceId = item.dataset.id;
            
            // Basculer la sélection
            if (selectedCompetences.has(competenceId)) {
                selectedCompetences.delete(competenceId);
                item.classList.remove('highlighted');
            } else {
                selectedCompetences.add(competenceId);
                item.classList.add('highlighted');
            }
        });
    });

    // Fonction pour quitter le mode sélection
    function exitSelectionMode() {
        selectionMode = false;
        highlightInstructions.style.display = 'none';
        highlightToggleBtn.style.display = 'inline-flex';
        
        competenceItems.forEach(item => {
            item.classList.remove('selectable');
            
            // Réafficher tous les boutons d'action
            const actionButtons = item.querySelectorAll('a, .img2-btn, .btn-modifier, .btn-supprimer, .btn-edit, .btn-delete, .competence-actions');
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