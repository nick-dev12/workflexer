document.addEventListener('DOMContentLoaded', function () {
    const formationCards = document.querySelectorAll('.formation-card');
    const highlightToggleBtn = document.querySelector('.formation-highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.formation-highlight-instructions');
    const cancelBtn = document.querySelector('.formation-cancel-btn');
    const saveBtn = document.querySelector('.formation-save-btn');
    const confirmationMessage = document.querySelector('.formation-highlight-confirmation');

    let isSelectingMode = false;
    let selectedFormations = new Set();

    // Initialiser les formations déjà mises en avant
    formationCards.forEach(card => {
        if (card.classList.contains('highlighted')) {
            selectedFormations.add(card.dataset.id);
        }
    });

    if (highlightToggleBtn) {
        highlightToggleBtn.addEventListener('click', function () {
            isSelectingMode = true;
            highlightInstructions.style.display = 'block';
            highlightToggleBtn.style.display = 'none';
            formationCards.forEach(card => {
                card.classList.add('selectable');
            });
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            exitSelectionMode();
            // Restaurer l'état précédent
            formationCards.forEach(card => {
                const wasHighlighted = selectedFormations.has(card.dataset.id);
                card.classList.toggle('highlighted', wasHighlighted);
            });
        });
    }

    if (saveBtn) {
        saveBtn.addEventListener('click', async function () {
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

    formationCards.forEach(card => {
        let longPressTimer;
        let isLongPress = false;

        card.addEventListener('mousedown', function () {
            if (!isSelectingMode) {
                longPressTimer = setTimeout(() => {
                    isLongPress = true;
                    isSelectingMode = true;
                    highlightInstructions.style.display = 'block';
                    highlightToggleBtn.style.display = 'none';
                    formationCards.forEach(c => c.classList.add('selectable'));
                    toggleFormationSelection(card);
                }, 500);
            }
        });

        card.addEventListener('mouseup', function () {
            clearTimeout(longPressTimer);
            if (isSelectingMode && !isLongPress) {
                toggleFormationSelection(card);
            }
            isLongPress = false;
        });

        card.addEventListener('mouseleave', function () {
            clearTimeout(longPressTimer);
        });

        // Empêcher la sélection de texte pendant le long press
        card.addEventListener('selectstart', function (e) {
            if (isSelectingMode) {
                e.preventDefault();
            }
        });
    });

    function toggleFormationSelection(card) {
        if (!isSelectingMode) return;

        const formationId = card.dataset.id;
        card.classList.toggle('highlighted');

        if (card.classList.contains('highlighted')) {
            selectedFormations.add(formationId);
        } else {
            selectedFormations.delete(formationId);
        }
    }

    function exitSelectionMode() {
        isSelectingMode = false;
        highlightInstructions.style.display = 'none';
        highlightToggleBtn.style.display = 'inline-flex';
        formationCards.forEach(card => {
            card.classList.remove('selectable');
        });
    }

    function showConfirmation() {
        confirmationMessage.style.display = 'block';
        setTimeout(() => {
            confirmationMessage.style.display = 'none';
        }, 3000);
    }
}); 