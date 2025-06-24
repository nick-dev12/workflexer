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

/**
 * Scripts pour l'affichage interactif des résultats d'analyse de compatibilité
 * WorkFlexer - API de matching
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialisation
    initCompatibilityAnalysis();
});

/**
 * Initialise les fonctionnalités interactives de l'analyse de compatibilité
 */
function initCompatibilityAnalysis() {
    // Ajouter des animations d'apparition
    animateSections();

    // Initialiser les graphiques
    initCharts();

    // Ajouter les événements pour les sections dépliables
    initCollapsibleSections();

    // Ajouter la fonctionnalité de filtrage
    initFilters();
}

/**
 * Ajoute des animations d'apparition aux sections
 */
function animateSections() {
    const sections = document.querySelectorAll('.compatibility-strengths, .compatibility-improvements, .compatibility-details, .compatibility-suggestions');

    // Si l'API IntersectionObserver est disponible
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated', 'fadeIn');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        sections.forEach(section => {
            observer.observe(section);
        });
    } else {
        // Fallback pour les navigateurs qui ne supportent pas IntersectionObserver
        sections.forEach(section => {
            section.classList.add('animated', 'fadeIn');
        });
    }
}

/**
 * Initialise les graphiques pour visualiser les scores
 */
function initCharts() {
    // Vérifier si Chart.js est disponible
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js n\'est pas disponible. Les graphiques ne seront pas affichés.');
        return;
    }

    // Graphique radar pour les scores par catégorie
    const radarCanvas = document.getElementById('compatibility-radar');
    if (radarCanvas) {
        const categories = [];
        const scores = [];

        document.querySelectorAll('.category-analysis').forEach(category => {
            const title = category.querySelector('h4').textContent.split(' ')[0];
            const score = parseInt(category.querySelector('.score').textContent);

            categories.push(title);
            scores.push(score);
        });

        new Chart(radarCanvas, {
            type: 'radar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Score de compatibilité',
                    data: scores,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                scale: {
                    ticks: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    }

    // Graphique en jauge pour le score global
    const gaugeCanvas = document.getElementById('compatibility-gauge');
    if (gaugeCanvas) {
        const score = parseInt(document.querySelector('.compatibility-header .score').textContent);

        new Chart(gaugeCanvas, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [score, 100 - score],
                    backgroundColor: [
                        score >= 75 ? '#28a745' :
                            score >= 50 ? '#17a2b8' :
                                score >= 30 ? '#ffc107' :
                                    '#dc3545',
                        '#f5f5f5'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutoutPercentage: 70,
                rotation: Math.PI,
                circumference: Math.PI,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                }
            }
        });

        // Ajouter le texte au centre de la jauge
        const ctx = gaugeCanvas.getContext('2d');
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.font = 'bold 24px Arial';
        ctx.fillStyle = '#333';
        ctx.fillText(`${score}%`, gaugeCanvas.width / 2, gaugeCanvas.height / 2 + 10);
    }
}

/**
 * Initialise les sections dépliables pour une meilleure lisibilité
 */
function initCollapsibleSections() {
    const sections = document.querySelectorAll('.compatibility-details h3, .compatibility-suggestions h3');

    sections.forEach(section => {
        section.classList.add('collapsible');
        section.innerHTML += '<span class="toggle-icon">+</span>';

        const content = section.nextElementSibling;
        content.style.display = 'none';

        section.addEventListener('click', function () {
            this.classList.toggle('active');

            if (content.style.display === 'none') {
                content.style.display = 'block';
                this.querySelector('.toggle-icon').textContent = '-';
            } else {
                content.style.display = 'none';
                this.querySelector('.toggle-icon').textContent = '+';
            }
        });
    });
}

/**
 * Initialise les filtres pour les points forts et points à améliorer
 */
function initFilters() {
    const filterContainer = document.createElement('div');
    filterContainer.className = 'compatibility-filters';
    filterContainer.innerHTML = `
        <div class="filter-title">Filtrer par catégorie:</div>
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">Tout</button>
            <button class="filter-btn" data-filter="formation">Formation</button>
            <button class="filter-btn" data-filter="experience">Expérience</button>
            <button class="filter-btn" data-filter="competence">Compétences</button>
            <button class="filter-btn" data-filter="langue">Langues</button>
        </div>
    `;

    // Insérer les filtres avant les listes de points forts et points à améliorer
    const strengthsSection = document.querySelector('.compatibility-strengths');
    const improvementsSection = document.querySelector('.compatibility-improvements');

    if (strengthsSection) {
        const filterClone = filterContainer.cloneNode(true);
        strengthsSection.insertBefore(filterClone, strengthsSection.querySelector('ul'));

        // Ajouter les événements aux boutons de filtre
        addFilterEvents(filterClone, strengthsSection.querySelectorAll('li'));
    }

    if (improvementsSection) {
        const filterClone = filterContainer.cloneNode(true);
        improvementsSection.insertBefore(filterClone, improvementsSection.querySelector('ul'));

        // Ajouter les événements aux boutons de filtre
        addFilterEvents(filterClone, improvementsSection.querySelectorAll('li'));
    }
}

/**
 * Ajoute les événements aux boutons de filtre
 * 
 * @param {HTMLElement} filterContainer Conteneur des boutons de filtre
 * @param {NodeList} items Éléments à filtrer
 */
function addFilterEvents(filterContainer, items) {
    const buttons = filterContainer.querySelectorAll('.filter-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            // Mettre à jour l'état actif des boutons
            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            // Filtrer les éléments
            items.forEach(item => {
                if (filter === 'all') {
                    item.style.display = '';
                } else {
                    const categorySpan = item.querySelector(`[class*="category-${filter}"]`);
                    item.style.display = categorySpan ? '' : 'none';
                }
            });
        });
    });
}

/**
 * Exporte les résultats d'analyse au format PDF
 */
function exportToPDF() {
    // Vérifier si jsPDF est disponible
    if (typeof jsPDF === 'undefined') {
        console.warn('jsPDF n\'est pas disponible. L\'export PDF ne sera pas possible.');
        return;
    }

    const element = document.querySelector('.compatibility-analysis');
    const pdf = new jsPDF('p', 'mm', 'a4');

    html2canvas(element).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 210; // A4 width in mm
        const pageHeight = 295; // A4 height in mm
        const imgHeight = canvas.height * imgWidth / canvas.width;
        let heightLeft = imgHeight;
        let position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        pdf.save('analyse-compatibilite.pdf');
    });
}