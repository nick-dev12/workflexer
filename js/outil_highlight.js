document.addEventListener('DOMContentLoaded', function () {
    const toolItems = document.querySelectorAll('.tool-item');
    const highlightToggleBtn = document.querySelector('.outil-highlight-toggle-btn');
    const highlightInstructions = document.querySelector('.outil-highlight-instructions');
    const cancelBtn = document.querySelector('.outil-cancel-btn');
    const saveBtn = document.querySelector('.outil-save-btn');
    const confirmationMessage = document.querySelector('.outil-highlight-confirmation');

    let isSelectingMode = false;
    let selectedOutils = new Set();

    // Initialiser les outils déjà mis en avant
    toolItems.forEach(item => {
        if (item.classList.contains('highlighted')) {
            selectedOutils.add(item.dataset.id);
        }
    });

    if (highlightToggleBtn) {
        highlightToggleBtn.addEventListener('click', function () {
            isSelectingMode = true;
            highlightInstructions.style.display = 'block';
            highlightToggleBtn.style.display = 'none';
            toolItems.forEach(item => {
                item.classList.add('selectable');
            });
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            exitSelectionMode();
            // Restaurer l'état précédent
            toolItems.forEach(item => {
                const wasHighlighted = selectedOutils.has(item.dataset.id);
                item.classList.toggle('highlighted', wasHighlighted);
            });
        });
    }

    if (saveBtn) {
        saveBtn.addEventListener('click', async function () {
            console.log("Bouton Enregistrer cliqué");
            console.log("Outils sélectionnés:", Array.from(selectedOutils));

            const formData = new FormData();
            formData.append('action', 'updateOutilHighlights');
            formData.append('highlighted_outils', JSON.stringify(Array.from(selectedOutils)));

            try {
                console.log("Envoi de la requête AJAX");
                const response = await fetch('../controller/controller_outil_users.php', {
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

    toolItems.forEach(item => {
        let longPressTimer;
        let isLongPress = false;

        item.addEventListener('mousedown', function () {
            if (!isSelectingMode) {
                longPressTimer = setTimeout(() => {
                    isLongPress = true;
                    isSelectingMode = true;
                    highlightInstructions.style.display = 'block';
                    highlightToggleBtn.style.display = 'none';
                    toolItems.forEach(i => i.classList.add('selectable'));
                    toggleOutilSelection(item);
                }, 500);
            }
        });

        item.addEventListener('mouseup', function () {
            clearTimeout(longPressTimer);
            if (isSelectingMode && !isLongPress) {
                toggleOutilSelection(item);
            }
            isLongPress = false;
        });

        item.addEventListener('mouseleave', function () {
            clearTimeout(longPressTimer);
        });

        // Empêcher la sélection de texte pendant le long press
        item.addEventListener('selectstart', function (e) {
            if (isSelectingMode) {
                e.preventDefault();
            }
        });
    });

    function toggleOutilSelection(item) {
        if (!isSelectingMode) return;

        const outilId = item.dataset.id;
        item.classList.toggle('highlighted');

        if (item.classList.contains('highlighted')) {
            selectedOutils.add(outilId);
        } else {
            selectedOutils.delete(outilId);
        }
    }

    function exitSelectionMode() {
        isSelectingMode = false;
        highlightInstructions.style.display = 'none';
        highlightToggleBtn.style.display = 'inline-flex';
        toolItems.forEach(item => {
            item.classList.remove('selectable');
        });
    }

    function showConfirmation() {
        confirmationMessage.style.display = 'block';
        setTimeout(() => {
            confirmationMessage.style.display = 'none';
        }, 3000);
    }
}); 