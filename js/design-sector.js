/**
 * Script pour la page du secteur Design et Création
 * Adapté au contexte africain
 */

// Initialisation des animations AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', function () {
    // Configuration des animations
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Fonctionnalité des onglets
    initTabSystem();

    // Ajout d'effets visuels spécifiques au design
    enhanceVisualElements();

    // Initialisation du système de filtrage des formations
    initFormationFilter();
});

/**
 * Gestion du système d'onglets pour les parcours professionnels
 */
function initTabSystem() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Retire la classe active de tous les boutons et panneaux
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            // Ajoute la classe active au bouton cliqué
            this.classList.add('active');

            // Affiche le contenu correspondant
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');

            // Animation subtile lors du changement d'onglet
            const activePane = document.getElementById(tabId);
            activePane.style.opacity = '0';
            setTimeout(() => {
                activePane.style.opacity = '1';
            }, 50);
        });
    });
}

/**
 * Amélioration visuelle des éléments de la page
 */
function enhanceVisualElements() {
    // Effet de survol sur les cartes de carrière
    const careerCards = document.querySelectorAll('.career-card');
    careerCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.1)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
        });
    });

    // Animation des icônes de statistiques
    const statIcons = document.querySelectorAll('.stat-box i');
    statIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function () {
            this.style.transform = 'scale(1.2) rotate(5deg)';
        });

        icon.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1) rotate(0)';
        });
    });

    // Effet de parallaxe subtil sur l'image d'en-tête
    window.addEventListener('scroll', function () {
        const heroSection = document.querySelector('.hero-section');
        const scrollPosition = window.scrollY;

        if (scrollPosition < 600) {
            heroSection.style.backgroundPositionY = `${scrollPosition * 0.5}px`;
        }
    });
}

/**
 * Système de filtrage des formations
 */
function initFormationFilter() {
    // Cette fonction serait implémentée si un système de filtrage des formations
    // était nécessaire sur la page (par localisation, type de formation, etc.)

    // Pour l'instant, elle est laissée comme point d'extension future
}

/**
 * Calcul de conversion de devises (FCFA vers Euro ou vice-versa)
 * Utile pour comparer les salaires internationaux
 * @param {number} amount - Montant à convertir
 * @param {string} fromCurrency - Devise source ('FCFA' ou 'EUR')
 * @return {number} - Montant converti
 */
function convertCurrency(amount, fromCurrency) {
    // Taux de change approximatif: 1 EUR = 655.957 FCFA
    const exchangeRate = 655.957;

    if (fromCurrency.toUpperCase() === 'FCFA') {
        return amount / exchangeRate;
    } else if (fromCurrency.toUpperCase() === 'EUR') {
        return amount * exchangeRate;
    } else {
        console.error('Devise non reconnue');
        return null;
    }
}

/**
 * Affiche un message de bienvenue dans la console pour les développeurs
 */
console.log('%cBienvenue sur la page Design et Création - Secteur Afrique', 'font-size: 14px; color: #9b59b6; font-weight: bold');
console.log('%cDécouvrez les opportunités créatives en Afrique francophone', 'font-style: italic; color: #333');
