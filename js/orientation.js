/**
 * Script pour la page d'Orientation Professionnelle
 * Adapté au contexte africain - Version modernisée
 * Work-Flexer
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialisation des animations AOS avec des paramètres optimisés
    AOS.init({
        duration: 600,
        once: true,
        offset: 80,
        easing: 'ease-out-cubic'
    });

    // Gestion du filtrage des secteurs
    initSectorFiltering();

    // Gestion du slider de témoignages
    initTestimonialsSlider();

    // Animation des statistiques (compteur)
    initStatsCounter();

    // Gestion du défilement fluide
    initSmoothScrolling();

    // Effets visuels et interactions
    enhanceVisualElements();

    // Animation des cartes au survol
    initCardHoverEffects();
});

/**
 * Initialise le système de filtrage des secteurs d'activité
 */
function initSectorFiltering() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const sectorCards = document.querySelectorAll('.sector-card');

    // Animation initiale des cartes avec effet cascade
    sectorCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 70)); // Effet cascade plus prononcé
    });

    // Mettre en évidence les catégories au survol des cartes
    sectorCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            const categories = this.getAttribute('data-category').split(' ');

            // Mettre en évidence la catégorie correspondante dans la légende
            if (categories.includes('emerging')) {
                document.querySelector('.category-dot.emerging').style.transform = 'scale(1.5)';
                document.querySelector('.category-dot.emerging').style.borderColor = '#ffffff';
            }
            if (categories.includes('digital')) {
                document.querySelector('.category-dot.digital').style.transform = 'scale(1.5)';
                document.querySelector('.category-dot.digital').style.borderColor = '#ffffff';
            }
            if (categories.includes('traditional')) {
                document.querySelector('.category-dot.traditional').style.transform = 'scale(1.5)';
                document.querySelector('.category-dot.traditional').style.borderColor = '#ffffff';
            }
        });

        card.addEventListener('mouseleave', function () {
            // Réinitialiser les styles des points de catégorie
            document.querySelectorAll('.category-dot').forEach(dot => {
                dot.style.transform = 'scale(1)';
                if (dot.classList.contains('emerging')) {
                    dot.style.borderColor = '#27ae60';
                } else if (dot.classList.contains('digital')) {
                    dot.style.borderColor = '#3498db';
                } else if (dot.classList.contains('traditional')) {
                    dot.style.borderColor = '#f39c12';
                }
            });
        });
    });

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Retirer la classe active de tous les boutons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');
            let visibleCount = 0;

            // Filtrer les cartes de secteur avec animation
            sectorCards.forEach(card => {
                if (filterValue === 'all') {
                    card.style.display = 'flex';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50 * visibleCount);
                    visibleCount++;
                } else {
                    const categories = card.getAttribute('data-category').split(' ');
                    if (categories.includes(filterValue)) {
                        card.style.display = 'flex';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50 * visibleCount);
                        visibleCount++;
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(15px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                }
            });

            // Animation du titre de la section pour indiquer le changement
            const sectionTitle = document.querySelector('.sector-navigation .section-title');
            sectionTitle.style.transform = 'translateY(-5px)';
            setTimeout(() => {
                sectionTitle.style.transform = 'translateY(0)';
            }, 300);
        });
    });

    // Animation au survol des boutons de filtre
    filterBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function () {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(-3px)';
            }
        });

        btn.addEventListener('mouseleave', function () {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(0)';
            }
        });
    });

    // Interaction avec la légende des catégories
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            const categoryDot = this.querySelector('.category-dot');
            let filterValue = 'all';

            if (categoryDot.classList.contains('emerging')) filterValue = 'emerging';
            if (categoryDot.classList.contains('digital')) filterValue = 'digital';
            if (categoryDot.classList.contains('traditional')) filterValue = 'traditional';

            // Trouver et cliquer sur le bouton de filtre correspondant
            const correspondingBtn = document.querySelector(`.filter-btn[data-filter="${filterValue}"]`);
            if (correspondingBtn) {
                correspondingBtn.click();
            }
        });

        // Effet de survol pour les éléments de légende
        item.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-2px)';
            const dot = this.querySelector('.category-dot');
            dot.style.transform = 'scale(1.3)';

            // Changer la couleur de la bordure selon la catégorie
            if (dot.classList.contains('emerging')) {
                dot.style.borderColor = '#2ecc71';
            } else if (dot.classList.contains('digital')) {
                dot.style.borderColor = '#3498db';
            } else if (dot.classList.contains('traditional')) {
                dot.style.borderColor = '#f39c12';
            }
        });

        item.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
            const dot = this.querySelector('.category-dot');
            dot.style.transform = 'scale(1)';

            // Réinitialiser la couleur de la bordure
            if (dot.classList.contains('emerging')) {
                dot.style.borderColor = '#27ae60';
            } else if (dot.classList.contains('digital')) {
                dot.style.borderColor = '#3498db';
            } else if (dot.classList.contains('traditional')) {
                dot.style.borderColor = '#f39c12';
            }
        });
    });
}

/**
 * Initialise le slider de témoignages avec transitions améliorées
 */
function initTestimonialsSlider() {
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;
    let autoplayInterval;
    let isTransitioning = false;

    function showTestimonial(index) {
        if (isTransitioning) return;
        isTransitioning = true;

        // Masquer le témoignage actuel
        if (testimonialCards[currentIndex]) {
            testimonialCards[currentIndex].style.opacity = '0';
            testimonialCards[currentIndex].style.transform = 'translateX(-30px)';

            setTimeout(() => {
                testimonialCards[currentIndex].style.display = 'none';

                // Afficher le nouveau témoignage
                testimonialCards[index].style.display = 'flex';
                testimonialCards[index].style.transform = 'translateX(30px)';

                setTimeout(() => {
                    testimonialCards[index].style.opacity = '1';
                    testimonialCards[index].style.transform = 'translateX(0)';
                    isTransitioning = false;
                }, 50);
            }, 300);
        } else {
            // Premier chargement
            testimonialCards[index].style.display = 'flex';
            setTimeout(() => {
                testimonialCards[index].style.opacity = '1';
                testimonialCards[index].style.transform = 'translateX(0)';
                isTransitioning = false;
            }, 50);
        }

        // Mettre à jour les indicateurs
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');

        currentIndex = index;

        // Réinitialiser l'autoplay
        clearInterval(autoplayInterval);
        startAutoplay();
    }

    // Initialisation du slider
    if (testimonialCards.length > 0) {
        showTestimonial(0);

        // Événements pour les boutons de navigation
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function () {
                if (isTransitioning) return;
                let newIndex = currentIndex - 1;
                if (newIndex < 0) newIndex = testimonialCards.length - 1;
                showTestimonial(newIndex);
            });

            nextBtn.addEventListener('click', function () {
                if (isTransitioning) return;
                let newIndex = currentIndex + 1;
                if (newIndex >= testimonialCards.length) newIndex = 0;
                showTestimonial(newIndex);
            });
        }

        // Événements pour les points de navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function () {
                if (isTransitioning || index === currentIndex) return;
                showTestimonial(index);
            });
        });

        // Fonction pour démarrer l'autoplay
        function startAutoplay() {
            autoplayInterval = setInterval(() => {
                if (!isTransitioning) {
                    let newIndex = currentIndex + 1;
                    if (newIndex >= testimonialCards.length) newIndex = 0;
                    showTestimonial(newIndex);
                }
            }, 5000); // Changer de témoignage toutes les 5 secondes
        }

        // Démarrer l'autoplay
        startAutoplay();

        // Arrêter l'autoplay au survol du slider
        const testimonialSlider = document.querySelector('.testimonials-slider');
        if (testimonialSlider) {
            testimonialSlider.addEventListener('mouseenter', () => {
                clearInterval(autoplayInterval);
            });

            testimonialSlider.addEventListener('mouseleave', () => {
                startAutoplay();
            });
        }
    }
}

/**
 * Initialise les compteurs pour les statistiques avec animation fluide
 */
function initStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number');

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.2
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const value = target.innerText;

                // Si la valeur contient un signe +, on l'extrait pour l'animation
                let finalValue = value;
                let prefix = '';
                let suffix = '';

                if (value.includes('+')) {
                    prefix = '+';
                    finalValue = value.replace('+', '');
                }

                if (value.includes('M')) {
                    suffix = 'M';
                    finalValue = value.replace('M', '');
                }

                if (value.includes('%')) {
                    suffix = '%';
                    finalValue = value.replace('%', '');
                }

                // Convertir en nombre pour l'animation
                const numValue = parseFloat(finalValue);

                // Animation du compteur avec easing
                let startValue = 0;
                const duration = 1500; // 1.5 secondes
                const startTime = performance.now();

                const updateCounter = (currentTime) => {
                    const elapsedTime = currentTime - startTime;

                    if (elapsedTime < duration) {
                        // Fonction d'easing pour une animation plus naturelle
                        const progress = 1 - Math.pow(1 - elapsedTime / duration, 3);
                        const currentValue = numValue * progress;

                        target.innerText = prefix + (suffix === '%' ? currentValue.toFixed(1) : Math.floor(currentValue)) + suffix;
                        requestAnimationFrame(updateCounter);
                    } else {
                        target.innerText = prefix + numValue + suffix;
                    }
                };

                requestAnimationFrame(updateCounter);

                // Ne déclencher l'animation qu'une seule fois
                observer.unobserve(target);
            }
        });
    }, options);

    statNumbers.forEach(number => {
        observer.observe(number);
    });
}

/**
 * Initialise le défilement fluide pour les liens d'ancrage
 */
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Calculer la position de défilement en tenant compte de la hauteur de la barre de navigation
                const navbarHeight = document.querySelector('nav') ? document.querySelector('nav').offsetHeight : 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Ajoute des effets visuels et des interactions à la page
 */
function enhanceVisualElements() {
    // Animation de l'indicateur de défilement
    const scrollIndicator = document.querySelector('.hero-scroll-indicator');
    if (scrollIndicator) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollIndicator.style.opacity = '0';
            } else {
                scrollIndicator.style.opacity = '1';
            }
        });
    }

    // Effet de parallaxe sur la section hero
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY;
            if (scrollPosition < 600) {
                const yPos = -(scrollPosition * 0.15);
                heroSection.style.backgroundPosition = `center ${yPos}px`;
            }
        });
    }
}

/**
 * Ajoute des effets de survol modernes aux cartes
 */
function initCardHoverEffects() {
    // Effet de survol 3D subtil sur les cartes
    const cards = document.querySelectorAll('.sector-card, .resource-card, .trend-card');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function (e) {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mousemove', function (e) {
            if (window.innerWidth > 768) { // Uniquement sur desktop
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left; // Position X de la souris dans la carte
                const y = e.clientY - rect.top; // Position Y de la souris dans la carte

                // Calculer les angles de rotation en fonction de la position de la souris
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 20; // Diviser pour réduire l'effet
                const rotateY = (centerX - x) / 20;

                // Appliquer la transformation
                this.style.transform = `translateY(-8px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            }
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0) rotateX(0) rotateY(0)';
        });
    });

    // Animation des icônes
    const icons = document.querySelectorAll('.sector-icon, .resource-icon, .trend-icon');
    icons.forEach(icon => {
        icon.addEventListener('mouseenter', function () {
            this.style.transform = 'scale(1.1)';
        });

        icon.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1)';
        });
    });
}

/**
 * Détecte la qualité de la connexion et adapte les ressources en conséquence
 * (Fonction utile pour le contexte africain où la connexion peut être limitée)
 */
function adaptToConnectionSpeed() {
    if ('connection' in navigator) {
        const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
            // Charger des images plus légères
            document.querySelectorAll('img[data-low-res]').forEach(img => {
                img.src = img.getAttribute('data-low-res');
            });

            // Désactiver certaines animations
            document.body.classList.add('low-bandwidth');

            // Réduire la qualité des animations
            AOS.init({
                disable: true
            });

            // Alerter l'utilisateur
            console.log('Connexion lente détectée. Mode économie de données activé.');
        }
    }
}

// Appel de la fonction d'adaptation à la connexion
adaptToConnectionSpeed(); 