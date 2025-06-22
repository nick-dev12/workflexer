/**
 * Script pour animer les résultats de compatibilité
 * API de matching WorkFlexer
 */

document.addEventListener('DOMContentLoaded', function () {
    // Animation du cercle de score
    const scoreCircle = document.querySelector('.score-circle');
    if (scoreCircle) {
        const score = parseInt(scoreCircle.dataset.score);
        const degrees = (score / 100) * 360;

        scoreCircle.style.setProperty('--rotation', `-${degrees}deg`);
        scoreCircle.querySelector('.score-value').textContent = `${score}%`;

        // Animation du cercle
        setTimeout(() => {
            scoreCircle.style.borderTopColor = '#4CAF50';
            scoreCircle.style.transform = `rotate(${degrees}deg)`;
        }, 100);
    }

    // Animation des barres de progression
    const progressBars = document.querySelectorAll('.progress');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });

    // Animation des listes de points forts et à améliorer
    const listItems = document.querySelectorAll('.strengths li, .improvements li');
    listItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            item.style.transition = 'all 0.3s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 500 + (index * 100));
    });
});

/**
 * Initialise les cercles de score avec leur valeur
 */
function initScoreCircles() {
    const scoreCircles = document.querySelectorAll('.score-circle');

    scoreCircles.forEach(circle => {
        const score = circle.getAttribute('data-score');

        // Définir la variable CSS pour l'animation du cercle
        circle.style.setProperty('--score', score);

        // Ajouter une classe pour déclencher l'animation
        setTimeout(() => {
            circle.classList.add('animated');
        }, 300);

        // Définir la couleur en fonction du score
        setScoreColor(circle, score);
    });
}

/**
 * Définit la couleur du cercle en fonction du score
 * 
 * @param {HTMLElement} circle - Élément du cercle de score
 * @param {number} score - Score de compatibilité (0-100)
 */
function setScoreColor(circle, score) {
    let color;

    if (score >= 85) {
        color = '#4CAF50'; // Vert - Excellent
    } else if (score >= 70) {
        color = '#8BC34A'; // Vert clair - Bon
    } else if (score >= 50) {
        color = '#FFC107'; // Jaune - Moyen
    } else if (score >= 30) {
        color = '#FF9800'; // Orange - Faible
    } else {
        color = '#F44336'; // Rouge - Très faible
    }

    // Appliquer la couleur au gradient
    circle.style.background = `conic-gradient(
        ${color} calc(var(--score) * 1%),
        #f3f3f3 0
    )`;
}

/**
 * Anime les barres de progression des catégories
 */
function animateProgressBars() {
    const progressBars = document.querySelectorAll('.progress');

    progressBars.forEach(bar => {
        // Récupérer la valeur de score depuis le parent
        const scoreElement = bar.closest('li').querySelector('.category-score');
        const score = parseInt(scoreElement.textContent);

        // Initialiser à 0 puis animer jusqu'à la valeur finale
        bar.style.width = '0%';

        setTimeout(() => {
            bar.style.width = score + '%';

            // Définir la couleur en fonction du score
            if (score >= 85) {
                bar.style.backgroundColor = '#4CAF50'; // Vert - Excellent
            } else if (score >= 70) {
                bar.style.backgroundColor = '#8BC34A'; // Vert clair - Bon
            } else if (score >= 50) {
                bar.style.backgroundColor = '#FFC107'; // Jaune - Moyen
            } else if (score >= 30) {
                bar.style.backgroundColor = '#FF9800'; // Orange - Faible
            } else {
                bar.style.backgroundColor = '#F44336'; // Rouge - Très faible
            }
        }, 500);
    });
}

/**
 * Fonction pour rafraîchir l'analyse de compatibilité via AJAX
 * 
 * @param {number} offre_id - ID de l'offre d'emploi
 * @param {number} candidat_id - ID du candidat
 * @param {string} container_id - ID du conteneur HTML pour les résultats
 */
function refreshCompatibilityAnalysis(offre_id, candidat_id, container_id) {
    const container = document.getElementById(container_id);

    if (!container) {
        console.error('Conteneur non trouvé:', container_id);
        return;
    }

    // Afficher un indicateur de chargement
    container.innerHTML = '<div class="loading">Analyse en cours...</div>';

    // Effectuer la requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'analyser_compatibilite.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status === 200) {
            // Mettre à jour le conteneur avec les résultats
            container.innerHTML = this.responseText;

            // Réinitialiser les animations
            initScoreCircles();
            animateProgressBars();
        } else {
            container.innerHTML = '<div class="error-message">Erreur lors de l\'analyse de compatibilité.</div>';
        }
    };

    xhr.onerror = function () {
        container.innerHTML = '<div class="error-message">Erreur de connexion au serveur.</div>';
    };

    // Envoyer la requête
    xhr.send('offre_id=' + offre_id + '&candidat_id=' + candidat_id);
}

/**
 * Affiche un tooltip avec des détails sur une catégorie
 * 
 * @param {HTMLElement} element - Élément déclencheur
 * @param {string} message - Message à afficher dans le tooltip
 */
function showCategoryTooltip(element, message) {
    // Créer le tooltip s'il n'existe pas déjà
    let tooltip = document.getElementById('category-tooltip');

    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.id = 'category-tooltip';
        tooltip.className = 'category-tooltip';
        document.body.appendChild(tooltip);
    }

    // Définir le contenu du tooltip
    tooltip.textContent = message;

    // Positionner le tooltip
    const rect = element.getBoundingClientRect();
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';

    // Afficher le tooltip
    tooltip.classList.add('visible');

    // Cacher le tooltip après un délai
    setTimeout(() => {
        tooltip.classList.remove('visible');
    }, 3000);
}

/**
 * Exporte les résultats de compatibilité au format PDF
 * 
 * @param {string} container_id - ID du conteneur HTML contenant les résultats
 */
function exportCompatibilityResults(container_id) {
    // Cette fonction nécessite une bibliothèque comme jsPDF ou html2pdf
    // Exemple d'implémentation à adapter selon vos besoins

    alert('Fonctionnalité d\'export PDF à implémenter avec une bibliothèque comme jsPDF ou html2pdf.');
}