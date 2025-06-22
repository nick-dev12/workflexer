document.addEventListener('DOMContentLoaded', () => {
    // Gestion des onglets
    window.openTab = function (evt, tabName) {
        let i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Animation du score circulaire
    const scoreCircle = document.querySelector('.score-circle');
    if (scoreCircle) {
        const score = scoreCircle.dataset.score;
        // Déclenche l'animation après un court délai pour être visible
        setTimeout(() => {
            scoreCircle.style.setProperty('--score-percent', score);
        }, 100);
    }

    // Initialisation du graphique Radar
    const radarCtx = document.getElementById('compatibilityRadarChart');
    if (radarCtx && typeof radarData !== 'undefined') {
        new Chart(radarCtx, {
            type: 'radar',
            data: radarData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: 100,
                        ticks: {
                            stepSize: 20,
                            backdropColor: 'transparent',
                            color: '#444'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        pointLabels: {
                            font: {
                                size: 12
                            },
                            color: '#333'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.r !== null) {
                                    label += context.parsed.r.toFixed(1) + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
}); 