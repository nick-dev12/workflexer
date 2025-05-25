/**
 * Script pour la page du secteur Technologie et Informatique
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

    // Ajout d'effets visuels spécifiques au secteur technologique
    enhanceVisualElements();

    // Initialisation du convertisseur de devises FCFA/Euro
    initCurrencyConverter();

    // Initialisation des statistiques du marché tech africain
    initAfricanTechStats();
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

    // Taux de change actualisés pour 2023-2024
    const exchangeRates = {
        'FCFA_TO_EUR': 0.00152, // 1 FCFA = 0.00152 EUR
        'EUR_TO_FCFA': 655.957, // 1 EUR = 655.957 FCFA
        'FCFA_TO_USD': 0.00166, // 1 FCFA = 0.00166 USD
        'USD_TO_FCFA': 603.50   // 1 USD = 603.50 FCFA
    };

    // Point d'extension pour une future implémentation de convertisseur
}

/**
 * Initialisation des statistiques du marché tech africain
 * Basé sur les données de recherche 2023-2024
 */
function initAfricanTechStats() {
    // Création d'un élément pour afficher les statistiques du marché
    const statsContainer = document.createElement('div');
    statsContainer.className = 'african-tech-stats';
    statsContainer.innerHTML = `
        <div class="stats-header">
            <h3>Statistiques du secteur tech en Afrique francophone</h3>
            <p>Données actualisées 2023-2024</p>
        </div>
        <div class="stats-content">
            <div class="stats-item">
                <span class="stats-number">+22%</span>
                <span class="stats-label">Croissance annuelle du secteur tech</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">47%</span>
                <span class="stats-label">Part des solutions mobiles dans les innovations tech</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">+310</span>
                <span class="stats-label">Hubs technologiques actifs en Afrique</span>
            </div>
        </div>
    `;

    // Ajout des statistiques à la page si l'élément cible existe
    const targetSection = document.querySelector('.trends-section .container');
    if (targetSection) {
        targetSection.appendChild(statsContainer);
    }
}

/**
 * Calculateur de conversion de devises (FCFA vers Euro ou vice-versa)
 * @param {number} amount - Montant à convertir
 * @param {string} fromCurrency - Devise source ('FCFA', 'EUR' ou 'USD')
 * @param {string} toCurrency - Devise cible ('FCFA', 'EUR' ou 'USD')
 * @return {number} - Montant converti
 */
function convertCurrency(amount, fromCurrency, toCurrency = 'FCFA') {
    // Taux de change actualisés 2023-2024
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
 * Ajoute des éléments visuels spécifiques au contexte tech africain
 */
function addAfricanTechElements() {
    // Cette fonction pourrait être utilisée pour ajouter dynamiquement
    // des éléments spécifiques au contexte africain

    // Par exemple, ajouter des badges pour les formations en tech mobile
    const techItems = document.querySelectorAll('.education-path li');
    techItems.forEach(item => {
        if (item.textContent.includes('mobile') || item.textContent.includes('digital')) {
            const badge = document.createElement('span');
            badge.className = 'african-tech-tag';
            badge.textContent = 'Tendance Afrique';
            item.appendChild(badge);
        }
    });
}

/**
 * Détecte la connexion internet et adapte le contenu si nécessaire
 * (Fonctionnalité pertinente pour le contexte africain où la connexion peut être limitée)
 */
function adaptToConnectionSpeed() {
    // Vérifie si l'API Navigator.connection est disponible
    if ('connection' in navigator) {
        const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        // Adapte le contenu en fonction de la vitesse de connexion
        if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
            // Charge des images plus légères
            const images = document.querySelectorAll('img[data-low-res]');
            images.forEach(img => {
                img.src = img.getAttribute('data-low-res');
            });

            // Désactive certaines animations
            document.body.classList.add('low-bandwidth');
        }
    }
}

/**
 * Statistiques tech pour l'Afrique francophone
 * Basées sur les données 2023-2024
 */
const africanTechStats = {
    // Croissance des startups tech en Afrique (2017-2025)
    startupGrowth: {
        2017: 442,  // nombre de startups tech financées
        2021: 564,
        2023: 633,
        2025: 780   // prévision
    },

    // Répartition des hubs tech par région (2023)
    techHubs: {
        'Afrique de l\'Ouest francophone': 87,
        'Afrique Centrale': 42,
        'Afrique du Nord francophone': 65,
        'Océan Indien': 12
    },

    // Tendances tech en Afrique francophone (2023-2024)
    trends: [
        'Solutions Mobile-First',
        'Fintech & Mobile Money',
        'Tech Durable & Hors-ligne',
        'IA & Données Locales'
    ]
};

/**
 * Affiche un message de bienvenue dans la console pour les développeurs
 */
console.log('%cBienvenue sur la page Technologie et Informatique - Secteur Afrique', 'font-size: 14px; color: #3498db; font-weight: bold');
console.log('%cDécouvrez les opportunités tech en Afrique francophone', 'font-style: italic; color: #333'); 