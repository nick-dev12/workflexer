/**
 * Gestion des suggestions de recherche dynamiques
 */
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const searchForm = document.getElementById('search-form');
    const searchInput = searchForm ? searchForm.querySelector('input[type="text"]') : null;
    const suggestionsContainer = document.getElementById('search-suggestions');

    // Variables pour débounce
    let typingTimer;
    const doneTypingInterval = 300; // temps d'attente après la frappe en ms

    // Si les éléments nécessaires ne sont pas trouvés, ne rien faire
    if (!searchForm || !searchInput || !suggestionsContainer) {
        console.warn('Éléments de recherche non trouvés dans la page');
        return;
    }

    // Écouteur d'événements pour l'entrée de texte
    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        // Effacer le timer existant
        clearTimeout(typingTimer);

        // Masquer les suggestions si la requête est trop courte
        if (query.length < 2) {
            suggestionsContainer.innerHTML = '';
            suggestionsContainer.classList.remove('active');
            return;
        }

        // Définir un nouveau timer pour éviter trop de requêtes
        typingTimer = setTimeout(function () {
            fetchSuggestions(query);
        }, doneTypingInterval);
    });

    // Écouteur pour masquer les suggestions lors de la perte de focus
    document.addEventListener('click', function (e) {
        if (!searchForm.contains(e.target)) {
            suggestionsContainer.classList.remove('active');
        }
    });

    // Écouteur pour le focus sur l'input - afficher les suggestions si contenu
    searchInput.addEventListener('focus', function () {
        const query = this.value.trim();
        if (query.length >= 2) {
            fetchSuggestions(query);
        }
    });

    // Écouteur pour la touche Échap pour fermer les suggestions
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            suggestionsContainer.classList.remove('active');
        }
    });

    // Fonction pour récupérer les suggestions depuis l'API
    function fetchSuggestions(query) {
        // Ajouter un indicateur de chargement
        suggestionsContainer.innerHTML = '<div class="suggestion-loading">Recherche en cours...</div>';
        suggestionsContainer.classList.add('active');

        // Appel à l'API
        fetch(`/api/search_suggestions.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Si pas de suggestions, masquer le conteneur
                if (!data.success || data.suggestions.length === 0) {
                    suggestionsContainer.innerHTML = '<div class="no-suggestions">Aucun résultat trouvé</div>';
                    return;
                }

                // Générer le HTML pour les suggestions
                renderSuggestions(data.suggestions);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des suggestions:', error);
                suggestionsContainer.innerHTML = '<div class="error-suggestion">Une erreur est survenue</div>';
            });
    }

    // Fonction pour afficher les suggestions
    function renderSuggestions(suggestions) {
        // Vider le conteneur
        suggestionsContainer.innerHTML = '';

        // Créer des éléments de suggestion
        suggestions.forEach(suggestion => {
            const item = document.createElement('a');
            item.href = suggestion.url;
            item.className = `suggestion-item ${suggestion.type}`;

            // Construire le contenu HTML de l'élément
            item.innerHTML = `
                <div class="suggestion-icon">
                    <i class="fas ${suggestion.icon}"></i>
                </div>
                <div class="suggestion-content">
                    <div class="suggestion-title">${suggestion.title}</div>
                    <div class="suggestion-subtitle">${suggestion.subtitle}</div>
                </div>
            `;

            // Ajouter l'élément au conteneur
            suggestionsContainer.appendChild(item);

            // Écouteur pour cliquer sur une suggestion
            item.addEventListener('click', function (e) {
                searchInput.value = suggestion.title; // Mettre à jour l'input avec la suggestion
                suggestionsContainer.classList.remove('active'); // Masquer les suggestions
            });
        });

        // Afficher le conteneur
        suggestionsContainer.classList.add('active');
    }

    // Gestion de la soumission du formulaire
    searchForm.addEventListener('submit', function (e) {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            e.preventDefault(); // Empêcher la soumission si requête trop courte
        }
    });
}); 