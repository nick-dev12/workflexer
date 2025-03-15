<?php
session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('app/controller/controllerOffre_emploi.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: ../connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->

    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>Statistiques détaillées - <?= $getEntreprise['entreprise']; ?></title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script defer src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/entreprise_profil.css">
    <link rel="stylesheet" href="/css/statistiques.css">
    <link rel="stylesheet" href="/css/donnee_statistique.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/notifications.css">
    <!-- Chart.js pour les graphiques -->
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Script pour les fonctionnalités avancées des statistiques -->
    <script defer src="/js/statistiques.js"></script>
    <!-- Bibliothèques pour l'exportation des données -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <div class="container">
        <div class="page-header">
            <div class="page-title">
                <h1><i class="fas fa-chart-line"></i> Statistiques détaillées</h1>
                <p>Analyse complète des performances de vos offres d'emploi et candidatures</p>
            </div>
            <div class="page-actions">
                <a href="entreprise_profil.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Retour au profil
                </a>
            </div>
        </div>





        <!-- Section des statistiques -->
        <?php
        // Inclure le fichier des fonctions de statistiques
        include_once('app/model/statistiques.php');
        include_once('../include/notifications.php');

        // Récupérer toutes les statistiques
        $stats = getAllStatistiques($db, $_SESSION['compte_entreprise']);

        // Formater les données pour les graphiques
        $candidaturesParCategorie = [];
        $candidaturesParCategorieLabels = [];
        $candidaturesParCategorieData = [];

        foreach ($stats['candidatures_par_categorie'] as $categorie) {
            $candidaturesParCategorieLabels[] = $categorie['categorie'];
            $candidaturesParCategorieData[] = $categorie['nombre'];
        }

        $vuesParOffre = [];
        $vuesParOffreLabels = [];
        $vuesParOffreData = [];

        foreach ($stats['vues_par_offre'] as $offre) {
            $vuesParOffreLabels[] = $offre['poste'];
            $vuesParOffreData[] = $offre['nombre'];
        }

        $candidaturesParMois = [];
        $candidaturesParMoisLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $candidaturesParMoisData = array_fill(0, 12, 0);

        foreach ($stats['candidatures_par_mois'] as $mois) {
            $candidaturesParMoisData[$mois['mois'] - 1] = $mois['nombre'];
        }

        // Calculer le taux d'acceptation
        $tauxAcceptation = 0;
        if ($stats['candidatures_total'] > 0) {
            $tauxAcceptation = round(($stats['candidats_acceptes'] / $stats['candidatures_total']) * 100);
        }

        // Calculer le taux de refus
        $tauxRefus = 0;
        if ($stats['candidatures_total'] > 0) {
            $tauxRefus = round(($stats['candidats_refuses'] / $stats['candidatures_total']) * 100);
        }
        ?>

        <div class="stats-section">
            <div class="stats-section-header">
                <h2>Tableau de bord des statistiques</h2>
                <div class="stats-actions">
                    <div class="export-buttons">
                        <button id="export-pdf" class="export-btn">
                            <i class="far fa-file-pdf"></i>
                            <span>PDF</span>
                        </button>
                        <button id="export-excel" class="export-btn">
                            <i class="far fa-file-excel"></i>
                            <span>Excel</span>
                        </button>
                        <button id="export-csv" class="export-btn">
                            <i class="far fa-file-csv"></i>
                            <span>CSV</span>
                        </button>
                    </div>
                    <button id="refreshStats">
                        <i class="fas fa-sync-alt"></i>
                        <span>Actualiser</span>
                    </button>
                </div>
            </div>

            <!-- Section des filtres de date -->
            <div class="stats-filters">
                <h3>Filtrer par période</h3>
                <div class="stats-date-filter">
                    <select id="date-filter">
                        <option value="all">Toutes les périodes</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois-ci</option>
                        <option value="quarter">Ce trimestre</option>
                        <option value="year">Cette année</option>
                        <option value="custom">Période personnalisée</option>
                    </select>

                    <div class="stats-custom-date" style="display: none;">
                        <input type="date" id="start-date">
                        <input type="date" id="end-date">
                        <button id="apply-filter">Appliquer</button>
                    </div>
                </div>
            </div>

            <div class="stats-cards">
                <div class="stats-card" data-type="offres_publiees" data-value="<?= $stats['offres_publiees'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stats-card-title">Offres publiées</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['offres_publiees'] ?></div>
                </div>

                <div class="stats-card success" data-type="candidatures_total"
                    data-value="<?= $stats['candidatures_total'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-card-title">Candidatures reçues</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['candidatures_total'] ?></div>
                </div>

                <div class="stats-card info" data-type="vues_total" data-value="<?= $stats['vues_total'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stats-card-title">Vues des offres</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['vues_total'] ?></div>
                </div>

                <div class="stats-card warning" data-type="offres_expirees"
                    data-value="<?= $stats['offres_expirees'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-card-title">Offres expirées</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['offres_expirees'] ?></div>
                </div>

                <div class="stats-card danger" data-type="offres_supprimees"
                    data-value="<?= $stats['offres_supprimees'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <div class="stats-card-title">Offres supprimées</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['offres_supprimees'] ?></div>
                </div>

                <div class="stats-card success" data-type="candidats_acceptes"
                    data-value="<?= $stats['candidats_acceptes'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-card-title">Candidats acceptés</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['candidats_acceptes'] ?></div>
                    <div class="stats-card-trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span><?= $tauxAcceptation ?>% de taux d'acceptation</span>
                    </div>
                </div>

                <div class="stats-card danger" data-type="candidats_refuses"
                    data-value="<?= $stats['candidats_refuses'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stats-card-title">Candidats refusés</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['candidats_refuses'] ?></div>
                    <div class="stats-card-trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span><?= $tauxRefus ?>% de taux de refus</span>
                    </div>
                </div>

                <div class="stats-card purple" data-type="candidats_en_attente"
                    data-value="<?= $stats['candidats_en_attente'] ?>">
                    <div class="box-card">
                        <div class="stats-card-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stats-card-title">Candidats en attente</div>
                    </div>
                    <div class="stats-card-value"><?= $stats['candidats_en_attente'] ?></div>
                </div>
            </div>

            <div class="stats-charts">
                <div class="stats-chart-container">
                    <div class="stats-chart-header">
                        <h3 class="stats-chart-title">Candidatures par catégorie</h3>
                        <div class="stats-chart-actions">
                            <button class="chart-fullscreen" data-chart="categoriesChart">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="stats-chart">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>

                <div class="stats-chart-container">
                    <div class="stats-chart-header">
                        <h3 class="stats-chart-title">Top 5 des offres les plus vues</h3>
                        <div class="stats-chart-actions">
                            <button class="chart-fullscreen" data-chart="vuesChart">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="stats-chart">
                        <canvas id="vuesChart"></canvas>
                    </div>
                </div>

                <div class="stats-chart-container">
                    <div class="stats-chart-header">
                        <h3 class="stats-chart-title">Candidatures par mois</h3>
                        <div class="stats-chart-actions">
                            <button class="chart-fullscreen" data-chart="moisChart">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="stats-chart">
                        <canvas id="moisChart"></canvas>
                    </div>
                </div>

                <div class="stats-chart-container">
                    <div class="stats-chart-header">
                        <h3 class="stats-chart-title">Répartition des candidatures</h3>
                        <div class="stats-chart-actions">
                            <button class="chart-fullscreen" data-chart="statusChart">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="stats-chart">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tableau détaillé des statistiques -->
            <div class="stats-table-container">
                <h3>Détails des candidatures par offre</h3>
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Poste</th>
                            <th>Catégorie</th>
                            <th>Candidatures</th>
                            <th>Acceptés</th>
                            <th>Refusés</th>
                            <th>En attente</th>
                            <th>Vues</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody id="stats-table-body">
                        <!-- Les données seront chargées dynamiquement via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Configuration des graphiques avec Chart.js
        document.addEventListener('DOMContentLoaded', function () {
            // Graphique des candidatures par catégorie
            const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
            window.categoriesChart = new Chart(categoriesCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($candidaturesParCategorieLabels) ?>,
                    datasets: [{
                        label: 'Nombre de candidatures',
                        data: <?= json_encode($candidaturesParCategorieData) ?>,
                        backgroundColor: [
                            '#4361ee', '#4895ef', '#4cc9f0', '#3a0ca3', '#7209b7',
                            '#f72585', '#b5179e', '#560bad', '#480ca8', '#3a0ca3'
                        ],
                        borderWidth: 0,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#2b2d42',
                            titleFont: {
                                family: "'Nunito', sans-serif",
                                size: 14
                            },
                            bodyFont: {
                                family: "'Nunito', sans-serif",
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });

            // Graphique des vues par offre
            const vuesCtx = document.getElementById('vuesChart').getContext('2d');
            window.vuesChart = new Chart(vuesCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($vuesParOffreLabels) ?>,
                    datasets: [{
                        label: 'Nombre de vues',
                        data: <?= json_encode($vuesParOffreData) ?>,
                        backgroundColor: '#4cc9f0',
                        borderWidth: 0,
                        borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#2b2d42',
                            titleFont: {
                                family: "'Nunito', sans-serif",
                                size: 14
                            },
                            bodyFont: {
                                family: "'Nunito', sans-serif",
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

            // Graphique des candidatures par mois
            const moisCtx = document.getElementById('moisChart').getContext('2d');
            window.moisChart = new Chart(moisCtx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($candidaturesParMoisLabels) ?>,
                    datasets: [{
                        label: 'Nombre de candidatures',
                        data: <?= json_encode($candidaturesParMoisData) ?>,
                        backgroundColor: 'rgba(67, 97, 238, 0.2)',
                        borderColor: '#4361ee',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#4361ee',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#2b2d42',
                            titleFont: {
                                family: "'Nunito', sans-serif",
                                size: 14
                            },
                            bodyFont: {
                                family: "'Nunito', sans-serif",
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

            // Graphique de répartition des candidatures par statut
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            window.statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Acceptés', 'Refusés', 'En attente'],
                    datasets: [{
                        data: [
                            <?= $stats['candidats_acceptes'] ?>,
                            <?= $stats['candidats_refuses'] ?>,
                            <?= $stats['candidats_en_attente'] ?>
                        ],
                        backgroundColor: [
                            '#4ade80', // Vert pour acceptés
                            '#ef476f', // Rouge pour refusés
                            '#fb8500'  // Orange pour en attente
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: "'Nunito', sans-serif",
                                    size: 12
                                },
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#2b2d42',
                            titleFont: {
                                family: "'Nunito', sans-serif",
                                size: 14
                            },
                            bodyFont: {
                                family: "'Nunito', sans-serif",
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });

            // Gestion des boutons d'action
            document.getElementById('refreshStats').addEventListener('click', function () {
                location.reload();
            });

            // Gestion des filtres de date
            document.getElementById('date-filter').addEventListener('change', function () {
                if (this.value === 'custom') {
                    document.querySelector('.stats-custom-date').style.display = 'flex';
                } else {
                    document.querySelector('.stats-custom-date').style.display = 'none';
                    // Appliquer le filtre prédéfini
                    applyDateFilter(this.value);
                }
            });

            document.getElementById('apply-filter').addEventListener('click', function () {
                const startDate = document.getElementById('start-date').value;
                const endDate = document.getElementById('end-date').value;

                if (startDate && endDate) {
                    applyCustomDateFilter(startDate, endDate);
                } else {
                    alert('Veuillez sélectionner une date de début et de fin');
                }
            });

            // Gestion des boutons plein écran pour les graphiques
            document.querySelectorAll('.chart-fullscreen').forEach(button => {
                button.addEventListener('click', function () {
                    const chartId = this.getAttribute('data-chart');
                    const chartContainer = document.getElementById(chartId).closest('.stats-chart-container');

                    if (chartContainer.classList.contains('fullscreen')) {
                        chartContainer.classList.remove('fullscreen');
                        this.innerHTML = '<i class="fas fa-expand"></i>';
                    } else {
                        chartContainer.classList.add('fullscreen');
                        this.innerHTML = '<i class="fas fa-compress"></i>';
                    }
                });
            });

            // Fonction pour appliquer un filtre de date prédéfini
            function applyDateFilter(filterType) {
                // Implémenter la logique de filtrage selon le type
                console.log('Applying filter:', filterType);
                // Cette fonction devrait faire une requête AJAX pour obtenir les données filtrées
            }

            // Fonction pour appliquer un filtre de date personnalisé
            function applyCustomDateFilter(startDate, endDate) {
                console.log('Applying custom filter:', startDate, 'to', endDate);
                // Cette fonction devrait faire une requête AJAX pour obtenir les données filtrées
            }

            // Ajouter les attributs data aux cartes de statistiques pour l'exportation
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                const title = card.querySelector('.stats-card-title').textContent.trim().toLowerCase();
                const value = card.querySelector('.stats-card-value').textContent.trim();

                // Déterminer le type de statistique
                let type = '';
                if (title.includes('offres publiées')) {
                    type = 'offres_publiees';
                } else if (title.includes('candidatures')) {
                    type = 'candidatures_total';
                } else if (title.includes('offres expirées')) {
                    type = 'offres_expirees';
                } else if (title.includes('offres supprimées')) {
                    type = 'offres_supprimees';
                } else if (title.includes('candidats acceptés')) {
                    type = 'candidats_acceptes';
                } else if (title.includes('candidats refusés')) {
                    type = 'candidats_refuses';
                } else if (title.includes('candidats en attente')) {
                    type = 'candidats_en_attente';
                } else if (title.includes('vues')) {
                    type = 'vues_total';
                }

                // Ajouter les attributs data
                if (type) {
                    card.setAttribute('data-type', type);
                    card.setAttribute('data-value', value.replace(/\D/g, ''));
                }
            });
        });
    </script>

    <!-- Script pour l'exportation des statistiques -->
    <script>
        // S'assurer que jsPDF est correctement initialisé
        window.jspdf = window.jspdf || {};
        if (typeof window.jspdf.jsPDF === 'undefined' && typeof jspdf !== 'undefined') {
            window.jspdf = jspdf;
        }

        // Charger jsPDF si nécessaire
        if (typeof jspdf === 'undefined' && typeof window.jspdf === 'undefined' && typeof jsPDF === 'undefined') {
            console.log("Chargement d'une version alternative de jsPDF...");
            // Charger une version alternative de jsPDF
            const script = document.createElement('script');
            script.src = "https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js";
            script.onload = function () {
                console.log("Version alternative de jsPDF chargée avec succès");
                if (typeof jspdf !== 'undefined') {
                    window.jspdf = jspdf;
                }
            };
            script.onerror = function () {
                console.error("Impossible de charger la version alternative de jsPDF");
            };
            document.head.appendChild(script);
        }
    </script>
    <script src="/js/export-direct.js"></script>

    <!-- Script de débogage pour les boutons d'exportation -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Script de débogage pour les boutons d\'exportation');

            // Vérifier si les boutons existent
            const pdfExportBtn = document.getElementById('export-pdf');
            const excelExportBtn = document.getElementById('export-excel');
            const csvExportBtn = document.getElementById('export-csv');

            if (pdfExportBtn) {
                console.log('Bouton d\'exportation PDF trouvé:', pdfExportBtn);
                pdfExportBtn.addEventListener('click', function () {
                    console.log('Clic sur le bouton d\'exportation PDF (débogage)');
                });
            } else {
                console.error('Bouton d\'exportation PDF non trouvé');
            }

            if (excelExportBtn) {
                console.log('Bouton d\'exportation Excel trouvé:', excelExportBtn);
                excelExportBtn.addEventListener('click', function () {
                    console.log('Clic sur le bouton d\'exportation Excel (débogage)');
                });
            } else {
                console.error('Bouton d\'exportation Excel non trouvé');
            }

            if (csvExportBtn) {
                console.log('Bouton d\'exportation CSV trouvé:', csvExportBtn);
                csvExportBtn.addEventListener('click', function () {
                    console.log('Clic sur le bouton d\'exportation CSV (débogage)');
                });
            } else {
                console.error('Bouton d\'exportation CSV non trouvé');
            }

            // Vérifier si les bibliothèques sont chargées
            console.log('jsPDF disponible:', typeof window.jspdf !== 'undefined');
            console.log('jsPDF.jsPDF disponible:', typeof window.jspdf?.jsPDF !== 'undefined');
            console.log('SheetJS (XLSX) disponible:', typeof XLSX !== 'undefined');

            // Vérifier si les attributs data sont correctement ajoutés
            const statsCards = document.querySelectorAll('.stats-card');
            console.log('Nombre de cartes de statistiques avec attributs data:', statsCards.length);
            statsCards.forEach((card, index) => {
                console.log(`Carte ${index + 1}:`, {
                    type: card.getAttribute('data-type'),
                    value: card.getAttribute('data-value')
                });
            });
        });
    </script>
</body>

</html>