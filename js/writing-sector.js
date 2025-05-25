/**
 * Script pour la page du secteur Rédaction et Traduction
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

    // Ajout d'effets visuels spécifiques au secteur rédaction
    enhanceVisualElements();

    // Initialisation du convertisseur de devises FCFA/Euro
    initCurrencyConverter();

    // Initialisation des statistiques du marché rédaction africain
    initAfricanWritingStats();
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

    // Ajout de badges pour les formations spécifiques africaines
    const educationItems = document.querySelectorAll('.education-card li');
    educationItems.forEach(item => {
        if (item.textContent.includes('UCAD') ||
            item.textContent.includes('CESTI') ||
            item.textContent.includes('ISTC') ||
            item.textContent.includes('UGB')) {
            const badge = document.createElement('span');
            badge.className = 'african-writing-tag';
            badge.textContent = 'Institution Africaine';
            item.appendChild(badge);
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
 * Initialisation des statistiques du marché rédaction africain
 * Basé sur les données de recherche 2023-2024
 */
function initAfricanWritingStats() {
    // Création d'un élément pour afficher les statistiques du marché
    const statsContainer = document.createElement('div');
    statsContainer.className = 'african-writing-stats';
    statsContainer.innerHTML = `
        <div class="stats-header">
            <h3>Statistiques de la rédaction en Afrique</h3>
            <p>Données actualisées 2023-2024</p>
        </div>
        <div class="stats-content">
            <div class="stats-item">
                <span class="stats-number">+18%</span>
                <span class="stats-label">Croissance du contenu numérique africain</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">75%</span>
                <span class="stats-label">Métiers exercés en freelance</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">+35%</span>
                <span class="stats-label">Demande en traduction français-langues africaines</span>
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
 * Ajoute des éléments visuels spécifiques au contexte rédaction africain
 */
function addAfricanWritingElements() {
    // Cette fonction pourrait être utilisée pour ajouter dynamiquement
    // des éléments spécifiques au contexte africain

    // Par exemple, ajouter des badges pour les formations en langues africaines
    const languageItems = document.querySelectorAll('.education-path li');
    languageItems.forEach(item => {
        if (item.textContent.includes('wolof') || item.textContent.includes('bambara') ||
            item.textContent.includes('swahili') || item.textContent.includes('langues africaines')) {
            const badge = document.createElement('span');
            badge.className = 'african-writing-tag';
            badge.textContent = 'Langues Africaines';
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
 * Statistiques rédaction pour l'Afrique
 * Basées sur les données 2023-2024
 */
const africanWritingStats = {
    // Répartition des métiers de l'écrit en Afrique (2023)
    writingJobs: {
        'Rédaction web': 32.5, // en pourcentage
        'Journalisme': 24.8,
        'Traduction': 18.5,
        'Copywriting': 15.2,
        'Édition': 9.0
    },

    // Principales langues de traduction en Afrique (2023)
    topLanguages: [
        'Français',
        'Anglais',
        'Arabe',
        'Swahili',
        'Wolof',
        'Bambara',
        'Haoussa',
        'Yoruba',
        'Amharique',
        'Portugais'
    ],

    // Tendances rédaction en Afrique (2023-2024)
    trends: [
        'IA et Rédaction',
        'Contenus Multiformat',
        'Localisation Panafricaine',
        'Valorisation des Langues Africaines'
    ]
};

/**
 * Affiche un message de bienvenue dans la console pour les développeurs
 */
console.log('%cBienvenue sur la page Rédaction et Traduction - Secteur Afrique', 'font-size: 14px; color: #3498db; font-weight: bold');
console.log('%cDécouvrez les opportunités d\'écriture en Afrique francophone', 'font-style: italic; color: #333'); 