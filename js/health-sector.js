/**
 * Script pour la page du secteur Santé
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

    // Ajout d'effets visuels spécifiques au secteur santé
    enhanceVisualElements();

    // Initialisation de la FAQ
    initFAQ();

    // Initialisation des témoignages
    initTestimonials();
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
 * Initialisation de la FAQ avec fonctionnalité d'accordéon
 */
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        question.addEventListener('click', () => {
            // Ferme tous les autres éléments
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                }
            });

            // Bascule l'état actif de l'élément cliqué
            item.classList.toggle('active');
        });
    });
}

/**
 * Initialisation du slider de témoignages
 */
function initTestimonials() {
    const testimonials = document.querySelectorAll('.testimonial');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;

    function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.style.display = i === index ? 'block' : 'none';
        });
    }

    // Affiche le premier témoignage au chargement
    showTestimonial(0);

    // Écouteurs d'événements pour la navigation
    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function () {
            currentIndex = (currentIndex === 0) ? testimonials.length - 1 : currentIndex - 1;
            showTestimonial(currentIndex);
        });

        nextBtn.addEventListener('click', function () {
            currentIndex = (currentIndex === testimonials.length - 1) ? 0 : currentIndex + 1;
            showTestimonial(currentIndex);
        });
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
 * Ajoute des éléments visuels spécifiques au contexte médical africain
 */
function addAfricanHealthElements() {
    // Cette fonction pourrait être utilisée pour ajouter dynamiquement
    // des éléments spécifiques au contexte africain

    // Par exemple, ajouter des badges pour les formations en médecine traditionnelle
    const healthItems = document.querySelectorAll('.education-path li');
    healthItems.forEach(item => {
        if (item.textContent.includes('traditionnelle') || item.textContent.includes('communautaire')) {
            const badge = document.createElement('span');
            badge.className = 'african-health-tag';
            badge.textContent = 'Médecine Traditionnelle';
            item.appendChild(badge);
        }
    });
}

/**
 * Affiche un message de bienvenue dans la console pour les développeurs
 */
console.log('%cBienvenue sur la page Santé et Médecine - Secteur Afrique', 'font-size: 14px; color: #e91e63; font-weight: bold');
console.log('%cDécouvrez les opportunités médicales en Afrique francophone', 'font-style: italic; color: #333');