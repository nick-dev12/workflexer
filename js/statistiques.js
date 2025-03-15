/**
 * statistiques.js - Gestion avancée des graphiques et statistiques
 * 
 * Ce fichier contient les fonctionnalités avancées pour les graphiques et statistiques
 * du tableau de bord de l'entreprise, incluant:
 * - Animation des graphiques
 * - Fonctionnalités d'export (PDF, CSV, etc.)
 * - Filtres de date pour les statistiques
 * - Gestion du mode plein écran
 * - Interactions avancées avec les graphiques
 */

document.addEventListener('DOMContentLoaded', function () {
    // Référence aux graphiques (définis dans entreprise_profil.php)
    let charts = {};

    // Initialisation des fonctionnalités avancées une fois les graphiques chargés
    const initAdvancedFeatures = () => {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js n\'est pas chargé');
            return;
        }

        // Ajouter des animations personnalisées aux graphiques
        enhanceChartAnimations();

        // Initialiser les filtres de date
        initDateFilters();

        // Initialiser les fonctionnalités d'export avancées
        initAdvancedExport();

        // Ajouter des interactions avancées
        addAdvancedInteractions();
    };

    /**
     * Améliore les animations des graphiques pour une meilleure expérience utilisateur
     */
    const enhanceChartAnimations = () => {
        // Animation progressive des graphiques lors du défilement
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    const chartCanvas = container.querySelector('canvas');

                    if (chartCanvas) {
                        // Ajouter une classe pour l'animation CSS
                        chartCanvas.classList.add('chart-animate');

                        // Déclencher une mise à jour du graphique pour l'animation
                        const chartInstance = Chart.getChart(chartCanvas);
                        if (chartInstance) {
                            chartInstance.update();
                        }
                    }

                    // Arrêter d'observer une fois animé
                    observer.unobserve(container);
                }
            });
        }, {
            threshold: 0.2 // Déclencher lorsque 20% du graphique est visible
        });

        // Observer tous les conteneurs de graphiques
        document.querySelectorAll('.stats-chart-container').forEach(container => {
            observer.observe(container);
        });
    };

    /**
     * Initialise les filtres de date pour filtrer les statistiques par période
     */
    const initDateFilters = () => {
        // Créer l'élément de filtre de date s'il n'existe pas déjà
        if (!document.querySelector('.stats-date-filter')) {
            const filterHTML = `
                <div class="stats-date-filter">
                    <select id="statsPeriodFilter">
                        <option value="all">Toutes les périodes</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                        <option value="quarter">Ce trimestre</option>
                        <option value="year">Cette année</option>
                        <option value="custom">Période personnalisée</option>
                    </select>
                    <div class="stats-custom-date" style="display: none;">
                        <input type="date" id="statsDateStart" placeholder="Date de début">
                        <input type="date" id="statsDateEnd" placeholder="Date de fin">
                        <button id="statsApplyDateFilter">Appliquer</button>
                    </div>
                </div>
            `;

            // Insérer le filtre dans l'en-tête de la section statistiques
            const header = document.querySelector('.stats-section-header');
            if (header) {
                header.insertAdjacentHTML('beforeend', filterHTML);

                // Gérer l'affichage du sélecteur de dates personnalisées
                const periodFilter = document.getElementById('statsPeriodFilter');
                const customDateDiv = document.querySelector('.stats-custom-date');

                if (periodFilter && customDateDiv) {
                    periodFilter.addEventListener('change', function () {
                        if (this.value === 'custom') {
                            customDateDiv.style.display = 'flex';
                        } else {
                            customDateDiv.style.display = 'none';
                            // Appliquer le filtre standard
                            applyDateFilter(this.value);
                        }
                    });

                    // Gérer le clic sur le bouton Appliquer pour les dates personnalisées
                    const applyButton = document.getElementById('statsApplyDateFilter');
                    if (applyButton) {
                        applyButton.addEventListener('click', function () {
                            const startDate = document.getElementById('statsDateStart').value;
                            const endDate = document.getElementById('statsDateEnd').value;

                            if (startDate && endDate) {
                                applyDateFilter('custom', {
                                    start: startDate,
                                    end: endDate
                                });
                            } else {
                                alert('Veuillez sélectionner une date de début et de fin');
                            }
                        });
                    }
                }
            }
        }
    };

    /**
     * Applique un filtre de date aux statistiques
     * @param {string} period - La période à filtrer (today, week, month, quarter, year, custom)
     * @param {Object} customDates - Dates personnalisées si period === 'custom'
     */
    const applyDateFilter = (period, customDates = null) => {
        // Afficher un indicateur de chargement
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'stats-loading';
        loadingIndicator.innerHTML = '<div class="stats-loading-spinner"></div><span>Chargement des données...</span>';
        document.querySelector('.stats-section').appendChild(loadingIndicator);

        // Faire une requête AJAX pour obtenir les données filtrées
        fetch('app/controller/controllerStatistiques.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'get_filtered_stats',
                period: period,
                customDates: customDates,
                entreprise_id: document.querySelector('[data-entreprise-id]')?.dataset.entrepriseId
            }),
        })
            .then(response => response.json())
            .then(data => {
                // Supprimer l'indicateur de chargement
                document.querySelector('.stats-loading').remove();

                if (data.success) {
                    // Mettre à jour les graphiques avec les nouvelles données
                    updateChartsWithFilteredData(data);

                    // Mettre à jour les cartes de statistiques
                    updateStatsCards(data.stats);

                    // Afficher une notification de succès
                    showNotification('success', `Données filtrées pour la période: ${getPeriodLabel(period, customDates)}`);
                } else {
                    // Afficher une notification d'erreur
                    showNotification('error', data.message || 'Erreur lors du filtrage des données');
                }
            })
            .catch(error => {
                // Supprimer l'indicateur de chargement
                if (document.querySelector('.stats-loading')) {
                    document.querySelector('.stats-loading').remove();
                }

                console.error('Erreur lors de la récupération des statistiques filtrées:', error);

                // Afficher une notification d'erreur
                showNotification('error', 'Erreur de connexion au serveur');

                // Pour l'instant, afficher un message indiquant que la fonctionnalité est en développement
                showNotification('info', 'Le filtrage par date sera disponible prochainement');
            });
    };

    /**
     * Obtient le libellé d'une période pour l'affichage
     * @param {string} period - La période (today, week, month, quarter, year, custom)
     * @param {Object} customDates - Dates personnalisées si period === 'custom'
     * @returns {string} Le libellé de la période
     */
    const getPeriodLabel = (period, customDates = null) => {
        switch (period) {
            case 'today':
                return 'Aujourd\'hui';
            case 'week':
                return 'Cette semaine';
            case 'month':
                return 'Ce mois';
            case 'quarter':
                return 'Ce trimestre';
            case 'year':
                return 'Cette année';
            case 'custom':
                if (customDates && customDates.start && customDates.end) {
                    const startDate = new Date(customDates.start);
                    const endDate = new Date(customDates.end);

                    const formatDate = (date) => {
                        return date.toLocaleDateString('fr-FR', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    };

                    return `Du ${formatDate(startDate)} au ${formatDate(endDate)}`;
                }
                return 'Période personnalisée';
            case 'all':
            default:
                return 'Toutes les périodes';
        }
    };

    /**
     * Met à jour les graphiques avec les données filtrées
     * @param {Object} data - Les données filtrées
     */
    const updateChartsWithFilteredData = (data) => {
        // Mettre à jour le graphique des candidatures par catégorie
        const categoriesChart = Chart.getChart('categoriesChart');
        if (categoriesChart) {
            categoriesChart.data.labels = data.charts.candidatures_par_categorie.labels;
            categoriesChart.data.datasets[0].data = data.charts.candidatures_par_categorie.data;
            categoriesChart.update();
        }

        // Mettre à jour le graphique des vues par offre
        const vuesChart = Chart.getChart('vuesChart');
        if (vuesChart) {
            vuesChart.data.labels = data.charts.vues_par_offre.labels;
            vuesChart.data.datasets[0].data = data.charts.vues_par_offre.data;
            vuesChart.update();
        }

        // Mettre à jour le graphique des candidatures par mois
        const moisChart = Chart.getChart('moisChart');
        if (moisChart) {
            moisChart.data.datasets[0].data = data.charts.candidatures_par_mois.data;
            moisChart.update();
        }

        // Mettre à jour le graphique de répartition des candidatures
        const statusChart = Chart.getChart('statusChart');
        if (statusChart) {
            statusChart.data.datasets[0].data = data.charts.repartition_candidatures.data;
            statusChart.update();
        }
    };

    /**
     * Met à jour les cartes de statistiques avec les données filtrées
     * @param {Object} stats - Les statistiques filtrées
     */
    const updateStatsCards = (stats) => {
        // Mettre à jour les valeurs des cartes de statistiques
        document.querySelector('.stats-card:nth-child(1) .stats-card-value').textContent = stats.offres_publiees;
        document.querySelector('.stats-card:nth-child(2) .stats-card-value').textContent = stats.candidatures_total;
        document.querySelector('.stats-card:nth-child(3) .stats-card-value').textContent = stats.vues_total;
        document.querySelector('.stats-card:nth-child(4) .stats-card-value').textContent = stats.offres_expirees;
        document.querySelector('.stats-card:nth-child(5) .stats-card-value').textContent = stats.offres_supprimees;
        document.querySelector('.stats-card:nth-child(6) .stats-card-value').textContent = stats.candidats_acceptes;
        document.querySelector('.stats-card:nth-child(7) .stats-card-value').textContent = stats.candidats_refuses;
        document.querySelector('.stats-card:nth-child(8) .stats-card-value').textContent = stats.candidats_en_attente;

        // Calculer les taux
        const tauxAcceptation = stats.candidatures_total > 0
            ? Math.round((stats.candidats_acceptes / stats.candidatures_total) * 100)
            : 0;

        const tauxRefus = stats.candidatures_total > 0
            ? Math.round((stats.candidats_refuses / stats.candidatures_total) * 100)
            : 0;

        // Mettre à jour les taux
        document.querySelector('.stats-card:nth-child(6) .stats-card-trend span').textContent = `${tauxAcceptation}% de taux d'acceptation`;
        document.querySelector('.stats-card:nth-child(7) .stats-card-trend span').textContent = `${tauxRefus}% de taux de refus`;

        // Ajouter une animation pour mettre en évidence les changements
        document.querySelectorAll('.stats-card').forEach(card => {
            card.classList.add('updated');
            setTimeout(() => {
                card.classList.remove('updated');
            }, 1000);
        });
    };

    /**
     * Affiche une notification
     * @param {string} type - Le type de notification (success, error, info)
     * @param {string} message - Le message à afficher
     */
    const showNotification = (type, message) => {
        // Créer la notification
        const notification = document.createElement('div');
        notification.className = `stats-notification ${type}`;

        let icon = '';
        switch (type) {
            case 'success':
                icon = '<i class="fas fa-check-circle"></i>';
                break;
            case 'error':
                icon = '<i class="fas fa-exclamation-circle"></i>';
                break;
            case 'info':
            default:
                icon = '<i class="fas fa-info-circle"></i>';
                break;
        }

        notification.innerHTML = `
            <div class="stats-notification-content">
                ${icon}
                <span>${message}</span>
                <button class="stats-notification-close"><i class="fas fa-times"></i></button>
            </div>
        `;

        document.body.appendChild(notification);

        // Afficher avec animation
        setTimeout(() => {
            notification.classList.add('visible');
        }, 100);

        // Masquer après 3 secondes
        setTimeout(() => {
            notification.classList.remove('visible');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);

        // Gérer le bouton de fermeture
        notification.querySelector('.stats-notification-close').addEventListener('click', () => {
            notification.classList.remove('visible');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
    };

    /**
     * Initialise les fonctionnalités d'export avancées (PDF, CSV, etc.)
     */
    const initAdvancedExport = () => {
        // Remplacer le bouton d'export simple par un menu déroulant
        const exportButton = document.getElementById('exportStats');

        if (exportButton) {
            // Créer le menu déroulant
            const exportMenu = document.createElement('div');
            exportMenu.className = 'stats-export-menu';
            exportMenu.innerHTML = `
                <ul>
                    <li data-format="json"><i class="fas fa-code"></i> Exporter en JSON</li>
                    <li data-format="csv"><i class="fas fa-file-csv"></i> Exporter en CSV</li>
                    <li data-format="pdf"><i class="fas fa-file-pdf"></i> Exporter en PDF</li>
                    <li data-format="image"><i class="fas fa-image"></i> Exporter en image</li>
                </ul>
            `;

            // Insérer le menu après le bouton
            exportButton.parentNode.insertBefore(exportMenu, exportButton.nextSibling);

            // Gérer l'affichage du menu
            exportButton.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                exportMenu.classList.toggle('visible');
            });

            // Gérer les clics sur les options d'export
            exportMenu.querySelectorAll('li').forEach(option => {
                option.addEventListener('click', function () {
                    const format = this.getAttribute('data-format');
                    exportStats(format);
                    exportMenu.classList.remove('visible');
                });
            });

            // Fermer le menu si on clique ailleurs
            document.addEventListener('click', function (e) {
                if (!exportMenu.contains(e.target) && e.target !== exportButton) {
                    exportMenu.classList.remove('visible');
                }
            });
        }
    };

    /**
     * Exporte les statistiques dans différents formats
     * @param {string} format - Le format d'export (json, csv, pdf, image)
     */
    const exportStats = (format) => {
        // Récupérer les données des statistiques
        const statsData = {
            offres_publiees: parseInt(document.querySelector('.stats-card:nth-child(1) .stats-card-value').textContent),
            candidatures_total: parseInt(document.querySelector('.stats-card:nth-child(2) .stats-card-value').textContent),
            vues_total: parseInt(document.querySelector('.stats-card:nth-child(3) .stats-card-value').textContent),
            offres_expirees: parseInt(document.querySelector('.stats-card:nth-child(4) .stats-card-value').textContent),
            offres_supprimees: parseInt(document.querySelector('.stats-card:nth-child(5) .stats-card-value').textContent),
            candidats_acceptes: parseInt(document.querySelector('.stats-card:nth-child(6) .stats-card-value').textContent),
            candidats_refuses: parseInt(document.querySelector('.stats-card:nth-child(7) .stats-card-value').textContent),
            candidats_en_attente: parseInt(document.querySelector('.stats-card:nth-child(8) .stats-card-value').textContent)
        };

        switch (format) {
            case 'json':
                // Export JSON (déjà implémenté dans entreprise_profil.php)
                const dataStr = JSON.stringify(statsData, null, 2);
                const downloadAnchorNode = document.createElement('a');
                downloadAnchorNode.setAttribute('href', 'data:text/json;charset=utf-8,' + encodeURIComponent(dataStr));
                downloadAnchorNode.setAttribute('download', 'statistiques_workflexer.json');
                document.body.appendChild(downloadAnchorNode);
                downloadAnchorNode.click();
                downloadAnchorNode.remove();
                break;

            case 'csv':
                // Export CSV
                let csvContent = "data:text/csv;charset=utf-8,";

                // En-têtes
                csvContent += "Métrique,Valeur\n";

                // Données
                Object.entries(statsData).forEach(([key, value]) => {
                    // Formater la clé pour l'affichage
                    const formattedKey = key
                        .replace(/_/g, ' ')
                        .replace(/\b\w/g, l => l.toUpperCase());

                    csvContent += `"${formattedKey}","${value}"\n`;
                });

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "statistiques_workflexer.csv");
                document.body.appendChild(link);
                link.click();
                link.remove();
                break;

            case 'pdf':
            case 'image':
                // Pour PDF et image, afficher un message indiquant que la fonctionnalité est en développement
                const notification = document.createElement('div');
                notification.className = 'stats-notification';
                notification.innerHTML = `
                    <div class="stats-notification-content">
                        <i class="fas fa-info-circle"></i>
                        <span>L'export en ${format.toUpperCase()} sera disponible prochainement</span>
                        <button class="stats-notification-close"><i class="fas fa-times"></i></button>
                    </div>
                `;

                document.body.appendChild(notification);

                // Afficher avec animation
                setTimeout(() => {
                    notification.classList.add('visible');
                }, 100);

                // Masquer après 3 secondes
                setTimeout(() => {
                    notification.classList.remove('visible');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);

                // Gérer le bouton de fermeture
                notification.querySelector('.stats-notification-close').addEventListener('click', () => {
                    notification.classList.remove('visible');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                });
                break;
        }
    };

    /**
     * Ajoute des interactions avancées aux graphiques
     */
    const addAdvancedInteractions = () => {
        // Ajouter des tooltips améliorés
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(43, 45, 66, 0.9)';
        Chart.defaults.plugins.tooltip.titleFont = {
            family: "'Nunito', sans-serif",
            size: 14,
            weight: 'bold'
        };
        Chart.defaults.plugins.tooltip.bodyFont = {
            family: "'Nunito', sans-serif",
            size: 13
        };
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;
        Chart.defaults.plugins.tooltip.displayColors = true;
        Chart.defaults.plugins.tooltip.boxPadding = 6;

        // Ajouter des interactions au survol des cartes de statistiques
        document.querySelectorAll('.stats-card').forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.classList.add('hovered');
            });

            card.addEventListener('mouseleave', function () {
                this.classList.remove('hovered');
            });
        });

        // Ajouter des interactions au clic sur les légendes des graphiques
        document.querySelectorAll('.stats-chart canvas').forEach(canvas => {
            const chart = Chart.getChart(canvas);

            if (chart) {
                // Stocker une référence au graphique
                charts[canvas.id] = chart;

                // Ajouter une interaction personnalisée au clic sur les éléments du graphique
                canvas.addEventListener('click', function (e) {
                    const activePoints = chart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, false);

                    if (activePoints.length > 0) {
                        const firstPoint = activePoints[0];
                        const label = chart.data.labels[firstPoint.index];
                        const value = chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];

                        // Afficher une notification avec les détails
                        showChartElementDetails(label, value, chart.config.type);
                    }
                });
            }
        });
    };

    /**
     * Affiche les détails d'un élément de graphique lors du clic
     * @param {string} label - Le libellé de l'élément
     * @param {number} value - La valeur de l'élément
     * @param {string} chartType - Le type de graphique
     */
    const showChartElementDetails = (label, value, chartType) => {
        // Créer une notification avec les détails
        const notification = document.createElement('div');
        notification.className = 'stats-notification stats-detail-notification';

        let detailsHTML = '';

        switch (chartType) {
            case 'bar':
            case 'horizontalBar':
                detailsHTML = `
                    <h4>Détails pour: ${label}</h4>
                    <p>Nombre de candidatures: <strong>${value}</strong></p>
                `;
                break;

            case 'line':
                detailsHTML = `
                    <h4>Détails pour: ${label}</h4>
                    <p>Nombre de candidatures: <strong>${value}</strong></p>
                `;
                break;

            case 'doughnut':
            case 'pie':
                detailsHTML = `
                    <h4>Détails pour: ${label}</h4>
                    <p>Nombre de candidats: <strong>${value}</strong></p>
                `;
                break;

            default:
                detailsHTML = `
                    <h4>Détails pour: ${label}</h4>
                    <p>Valeur: <strong>${value}</strong></p>
                `;
        }

        notification.innerHTML = `
            <div class="stats-notification-content stats-detail-content">
                <div class="stats-detail-header">
                    <i class="fas fa-chart-bar"></i>
                    <button class="stats-notification-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="stats-detail-body">
                    ${detailsHTML}
                </div>
            </div>
        `;

        document.body.appendChild(notification);

        // Afficher avec animation
        setTimeout(() => {
            notification.classList.add('visible');
        }, 100);

        // Gérer le bouton de fermeture
        notification.querySelector('.stats-notification-close').addEventListener('click', () => {
            notification.classList.remove('visible');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
    };

    // Initialiser les fonctionnalités avancées
    initAdvancedFeatures();
}); 