/**
 * Script pour la page du secteur Droit et Justice
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

    // Ajout d'effets visuels spécifiques au secteur juridique
    enhanceVisualElements();

    // Initialisation du convertisseur de devises FCFA/Euro
    initCurrencyConverter();
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
 * Initialisation du convertisseur de devises FCFA/Euro
 */
function initCurrencyConverter() {
    // Cette fonction pourrait être développée pour ajouter un convertisseur
    // de devises interactif sur la page

    // Exemple de données pour les taux de change
    const exchangeRates = {
        'FCFA_TO_EUR': 0.00152, // 1 FCFA = 0.00152 EUR
        'EUR_TO_FCFA': 655.957, // 1 EUR = 655.957 FCFA
        'FCFA_TO_USD': 0.00166, // 1 FCFA = 0.00166 USD
        'USD_TO_FCFA': 603.50   // 1 USD = 603.50 FCFA
    };

    // Point d'extension pour une future implémentation de convertisseur
}

/**
 * Calculateur de conversion de devises (FCFA vers Euro ou vice-versa)
 * @param {number} amount - Montant à convertir
 * @param {string} fromCurrency - Devise source ('FCFA', 'EUR' ou 'USD')
 * @param {string} toCurrency - Devise cible ('FCFA', 'EUR' ou 'USD')
 * @return {number} - Montant converti
 */
function convertCurrency(amount, fromCurrency, toCurrency = 'FCFA') {
    // Taux de change approximatifs
    const exchangeRates = {
        'FCFA_TO_EUR': 0.00152,
        'EUR_TO_FCFA': 655.957,
        'FCFA_TO_USD': 0.00166,
        'USD_TO_FCFA': 603.50,
        'EUR_TO_USD': 1.09,
        'USD_TO_EUR': 0.92
    };

    const rateKey = `${fromCurrency.toUpperCase()}_TO_${toCurrency.toUpperCase()}`;

    if (exchangeRates[rateKey]) {
        return amount * exchangeRates[rateKey];
    } else {
        console.error('Conversion non supportée');
        return null;
    }
}

/**
 * Ajoute des éléments visuels spécifiques au contexte juridique africain
 */
function addAfricanLawElements() {
    // Cette fonction pourrait être utilisée pour ajouter dynamiquement
    // des éléments spécifiques au contexte africain

    // Par exemple, ajouter des badges pour les formations en droit coutumier
    const lawItems = document.querySelectorAll('.education-path li');
    lawItems.forEach(item => {
        if (item.textContent.includes('coutumier') || item.textContent.includes('OHADA')) {
            const badge = document.createElement('span');
            badge.className = 'african-law-tag';
            badge.textContent = 'Droit Africain';
            item.appendChild(badge);
        }
    });
}

/**
 * Affiche un message de bienvenue dans la console pour les développeurs
 */
console.log('%cBienvenue sur la page Droit et Justice - Secteur Afrique', 'font-size: 14px; color: #8e44ad; font-weight: bold');
console.log('%cDécouvrez les opportunités juridiques en Afrique francophone', 'font-style: italic; color: #333'); 