/**
 * Gestion de l'exportation des statistiques en différents formats
 */

document.addEventListener('DOMContentLoaded', function () {
    // Référence au bouton d'exportation
    const exportBtn = document.getElementById('stats-export-btn');
    const exportMenu = document.getElementById('stats-export-menu');

    // Afficher/masquer le menu d'exportation
    if (exportBtn && exportMenu) {
        exportBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Ajouter la classe visible pour afficher le menu
            exportMenu.classList.toggle('visible');

            // Fermer le menu si on clique ailleurs
            function closeMenu(e) {
                if (!exportMenu.contains(e.target) && e.target !== exportBtn) {
                    exportMenu.classList.remove('visible');
                    document.removeEventListener('click', closeMenu);
                }
            }

            // Ajouter l'écouteur d'événements pour fermer le menu
            document.addEventListener('click', closeMenu);
        });
    } else {
        console.error("Bouton d'exportation ou menu non trouvé");
    }

    // Gestionnaires pour les différents formats d'exportation
    setupExportHandlers();
});

/**
 * Configure les gestionnaires d'événements pour les différents formats d'exportation
 */
function setupExportHandlers() {
    // Exportation PDF
    const pdfExportBtn = document.getElementById('export-pdf');
    if (pdfExportBtn) {
        pdfExportBtn.addEventListener('click', function () {
            exportToPDF();
        });
    }

    // Exportation CSV
    const csvExportBtn = document.getElementById('export-csv');
    if (csvExportBtn) {
        csvExportBtn.addEventListener('click', function () {
            exportToCSV();
        });
    }

    // Exportation Excel
    const excelExportBtn = document.getElementById('export-excel');
    if (excelExportBtn) {
        excelExportBtn.addEventListener('click', function () {
            exportToExcel();
        });
    }
}

/**
 * Exporte les statistiques au format PDF
 */
function exportToPDF() {
    // Afficher l'indicateur de chargement
    showLoading();

    try {
        // Récupérer les données de statistiques
        const statsData = getStatisticsData();
        const entrepriseNom = getEntrepriseName();
        const dateGeneration = new Date().toLocaleDateString();

        // Vérifier si jsPDF est disponible
        if (typeof window.jspdf === 'undefined' && typeof jspdf === 'undefined') {
            console.error("La bibliothèque jsPDF n'est pas correctement chargée");
            showNotification("Erreur lors de l'exportation en PDF. La bibliothèque jsPDF n'est pas chargée.", 'error');
            hideLoading();
            return;
        }

        // Créer un nouvel objet jsPDF
        let doc;

        // Essayer différentes façons d'initialiser jsPDF selon la version disponible
        if (typeof jspdf !== 'undefined' && typeof jspdf.jsPDF === 'function') {
            // Version UMD moderne
            doc = new jspdf.jsPDF();
        } else if (typeof window.jspdf !== 'undefined' && typeof window.jspdf.jsPDF === 'function') {
            // Version UMD moderne (window)
            doc = new window.jspdf.jsPDF();
        } else if (typeof jsPDF === 'function') {
            // Version ancienne
            doc = new jsPDF();
        } else {
            console.error("Impossible d'initialiser jsPDF");
            showNotification("Erreur lors de l'exportation en PDF. Impossible d'initialiser jsPDF.", 'error');
            hideLoading();
            return;
        }

        // Ajouter le titre
        doc.setFontSize(18);
        doc.text(`Statistiques - ${entrepriseNom}`, 14, 20);

        // Ajouter la date de génération
        doc.setFontSize(10);
        doc.text(`Généré le: ${dateGeneration}`, 14, 30);

        // Ajouter les statistiques principales
        doc.setFontSize(14);
        doc.text('Statistiques générales', 14, 40);

        let yPos = 50;
        doc.setFontSize(10);

        // Ajouter les statistiques principales
        doc.text(`Offres publiées: ${statsData.offres_publiees}`, 20, yPos);
        yPos += 8;
        doc.text(`Candidatures reçues: ${statsData.candidatures_total}`, 20, yPos);
        yPos += 8;
        doc.text(`Offres expirées: ${statsData.offres_expirees}`, 20, yPos);
        yPos += 8;
        doc.text(`Offres supprimées: ${statsData.offres_supprimees}`, 20, yPos);
        yPos += 8;
        doc.text(`Candidats acceptés: ${statsData.candidats_acceptes}`, 20, yPos);
        yPos += 8;
        doc.text(`Candidats refusés: ${statsData.candidats_refuses}`, 20, yPos);
        yPos += 8;
        doc.text(`Candidats en attente: ${statsData.candidats_en_attente}`, 20, yPos);
        yPos += 8;
        doc.text(`Vues totales: ${statsData.vues_total}`, 20, yPos);

        // Ajouter les candidatures par catégorie
        yPos += 15;
        doc.setFontSize(14);
        doc.text('Candidatures par catégorie', 14, yPos);

        yPos += 10;
        doc.setFontSize(10);

        if (statsData.candidatures_par_categorie && statsData.candidatures_par_categorie.length > 0) {
            statsData.candidatures_par_categorie.forEach(item => {
                doc.text(`${item.categorie}: ${item.nombre}`, 20, yPos);
                yPos += 8;

                // Ajouter une nouvelle page si nécessaire
                if (yPos > 270) {
                    doc.addPage();
                    yPos = 20;
                }
            });
        } else {
            doc.text('Aucune donnée disponible', 20, yPos);
            yPos += 8;
        }

        // Ajouter les vues par offre
        yPos += 7;
        doc.setFontSize(14);
        doc.text('Top 5 des offres les plus vues', 14, yPos);

        yPos += 10;
        doc.setFontSize(10);

        if (statsData.vues_par_offre && statsData.vues_par_offre.length > 0) {
            statsData.vues_par_offre.forEach(item => {
                doc.text(`${item.poste}: ${item.nombre} vues`, 20, yPos);
                yPos += 8;
            });
        } else {
            doc.text('Aucune donnée disponible', 20, yPos);
        }

        // Sauvegarder le PDF
        doc.save(`statistiques_${entrepriseNom.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.pdf`);

        // Masquer l'indicateur de chargement et afficher une notification
        hideLoading();
        showNotification('Exportation en PDF réussie', 'success');
    } catch (error) {
        console.error("Erreur lors de l'exportation en PDF:", error);
        hideLoading();
        showNotification("Erreur lors de l'exportation en PDF: " + error.message, 'error');
    }
}

/**
 * Exporte les statistiques au format CSV
 */
function exportToCSV() {
    // Afficher l'indicateur de chargement
    showLoading();

    try {
        // Récupérer les données de statistiques
        const statsData = getStatisticsData();
        const entrepriseNom = getEntrepriseName();

        // Créer les lignes CSV
        let csvContent = 'data:text/csv;charset=utf-8,';

        // Ajouter l'en-tête
        csvContent += 'Catégorie,Valeur\r\n';

        // Ajouter les statistiques principales
        csvContent += `Offres publiées,${statsData.offres_publiees}\r\n`;
        csvContent += `Candidatures reçues,${statsData.candidatures_total}\r\n`;
        csvContent += `Offres expirées,${statsData.offres_expirees}\r\n`;
        csvContent += `Offres supprimées,${statsData.offres_supprimees}\r\n`;
        csvContent += `Candidats acceptés,${statsData.candidats_acceptes}\r\n`;
        csvContent += `Candidats refusés,${statsData.candidats_refuses}\r\n`;
        csvContent += `Candidats en attente,${statsData.candidats_en_attente}\r\n`;
        csvContent += `Vues totales,${statsData.vues_total}\r\n`;

        // Ajouter une ligne vide
        csvContent += '\r\n';

        // Ajouter les candidatures par catégorie
        csvContent += 'Candidatures par catégorie\r\n';
        csvContent += 'Catégorie,Nombre\r\n';

        if (statsData.candidatures_par_categorie && statsData.candidatures_par_categorie.length > 0) {
            statsData.candidatures_par_categorie.forEach(item => {
                csvContent += `${item.categorie},${item.nombre}\r\n`;
            });
        } else {
            csvContent += 'Aucune donnée disponible,0\r\n';
        }

        // Ajouter une ligne vide
        csvContent += '\r\n';

        // Ajouter les vues par offre
        csvContent += 'Top 5 des offres les plus vues\r\n';
        csvContent += 'Poste,Nombre de vues\r\n';

        if (statsData.vues_par_offre && statsData.vues_par_offre.length > 0) {
            statsData.vues_par_offre.forEach(item => {
                csvContent += `${item.poste},${item.nombre}\r\n`;
            });
        } else {
            csvContent += 'Aucune donnée disponible,0\r\n';
        }

        // Créer un lien pour télécharger le fichier CSV
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `statistiques_${entrepriseNom.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.csv`);
        document.body.appendChild(link);

        // Cliquer sur le lien pour télécharger le fichier
        link.click();

        // Supprimer le lien
        document.body.removeChild(link);

        // Masquer l'indicateur de chargement et afficher une notification
        hideLoading();
        showNotification('Exportation en CSV réussie', 'success');
    } catch (error) {
        console.error("Erreur lors de l'exportation en CSV:", error);
        hideLoading();
        showNotification("Erreur lors de l'exportation en CSV: " + error.message, 'error');
    }
}

/**
 * Exporte les statistiques au format Excel (XLSX)
 */
function exportToExcel() {
    // Afficher l'indicateur de chargement
    showLoading();

    try {
        // Récupérer les données de statistiques
        const statsData = getStatisticsData();
        const entrepriseNom = getEntrepriseName();

        // Vérifier si la bibliothèque XLSX est chargée
        if (typeof XLSX === 'undefined') {
            console.error("La bibliothèque SheetJS (XLSX) n'est pas correctement chargée");
            showNotification("Erreur lors de l'exportation en Excel. La bibliothèque SheetJS n'est pas chargée.", 'error');
            hideLoading();
            return;
        }

        // Créer un nouveau classeur
        const wb = XLSX.utils.book_new();

        // Créer la feuille des statistiques générales
        const wsGeneral = XLSX.utils.aoa_to_sheet([
            ['Statistiques générales'],
            ['Catégorie', 'Valeur'],
            ['Offres publiées', statsData.offres_publiees],
            ['Candidatures reçues', statsData.candidatures_total],
            ['Offres expirées', statsData.offres_expirees],
            ['Offres supprimées', statsData.offres_supprimees],
            ['Candidats acceptés', statsData.candidats_acceptes],
            ['Candidats refusés', statsData.candidats_refuses],
            ['Candidats en attente', statsData.candidats_en_attente],
            ['Vues totales', statsData.vues_total]
        ]);

        // Ajouter la feuille au classeur
        XLSX.utils.book_append_sheet(wb, wsGeneral, 'Statistiques générales');

        // Créer la feuille des candidatures par catégorie
        const categoriesData = [['Catégorie', 'Nombre']];

        if (statsData.candidatures_par_categorie && statsData.candidatures_par_categorie.length > 0) {
            statsData.candidatures_par_categorie.forEach(item => {
                categoriesData.push([item.categorie, item.nombre]);
            });
        } else {
            categoriesData.push(['Aucune donnée disponible', 0]);
        }

        const wsCategories = XLSX.utils.aoa_to_sheet(categoriesData);
        XLSX.utils.book_append_sheet(wb, wsCategories, 'Candidatures par catégorie');

        // Créer la feuille des vues par offre
        const vuesData = [['Poste', 'Nombre de vues']];

        if (statsData.vues_par_offre && statsData.vues_par_offre.length > 0) {
            statsData.vues_par_offre.forEach(item => {
                vuesData.push([item.poste, item.nombre]);
            });
        } else {
            vuesData.push(['Aucune donnée disponible', 0]);
        }

        const wsVues = XLSX.utils.aoa_to_sheet(vuesData);
        XLSX.utils.book_append_sheet(wb, wsVues, 'Top 5 des offres');

        // Créer la feuille des candidatures par mois
        const moisData = [['Mois', 'Nombre de candidatures']];
        const moisNoms = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        if (statsData.candidatures_par_mois && statsData.candidatures_par_mois.length > 0) {
            statsData.candidatures_par_mois.forEach(item => {
                moisData.push([moisNoms[item.mois - 1], item.nombre]);
            });
        } else {
            moisData.push(['Aucune donnée disponible', 0]);
        }

        const wsMois = XLSX.utils.aoa_to_sheet(moisData);
        XLSX.utils.book_append_sheet(wb, wsMois, 'Candidatures par mois');

        // Générer le fichier Excel
        XLSX.writeFile(wb, `statistiques_${entrepriseNom.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.xlsx`);

        // Masquer l'indicateur de chargement et afficher une notification
        hideLoading();
        showNotification('Exportation en Excel réussie', 'success');
    } catch (error) {
        console.error("Erreur lors de l'exportation en Excel:", error);
        hideLoading();
        showNotification("Erreur lors de l'exportation en Excel: " + error.message, 'error');
    }
}

/**
 * Récupère le nom de l'entreprise depuis la page
 * @returns {string} Nom de l'entreprise ou "Entreprise" par défaut
 */
function getEntrepriseName() {
    // Essayer de récupérer le nom de l'entreprise depuis différents éléments
    try {
        // Essayer d'abord depuis le titre de la page
        const pageTitle = document.title;
        if (pageTitle) {
            const titleParts = pageTitle.split('-');
            if (titleParts.length > 1) {
                return titleParts[1].trim();
            }
        }

        // Essayer ensuite depuis d'autres éléments potentiels
        const profileInfo = document.querySelector('.profile-info h2');
        if (profileInfo) {
            return profileInfo.textContent.trim();
        }

        // Si aucun élément n'est trouvé, retourner une valeur par défaut
        return "Entreprise";
    } catch (error) {
        console.error("Erreur lors de la récupération du nom de l'entreprise:", error);
        return "Entreprise";
    }
}

/**
 * Récupère les données de statistiques depuis les éléments HTML
 * @returns {Object} Données de statistiques
 */
function getStatisticsData() {
    // Récupérer les données depuis les attributs data des cartes de statistiques
    const statsCards = document.querySelectorAll('.stats-card');
    const statsData = {
        offres_publiees: 0,
        candidatures_total: 0,
        offres_expirees: 0,
        offres_supprimees: 0,
        candidats_acceptes: 0,
        candidats_refuses: 0,
        candidats_en_attente: 0,
        vues_total: 0,
        candidatures_par_categorie: [],
        vues_par_offre: [],
        candidatures_par_mois: []
    };

    // Récupérer les données des cartes de statistiques
    statsCards.forEach(card => {
        const type = card.getAttribute('data-type');
        const value = parseInt(card.getAttribute('data-value'), 10);

        if (type && !isNaN(value)) {
            statsData[type] = value;
        }
    });

    // Récupérer les données des graphiques
    try {
        // Candidatures par catégorie
        if (window.categoriesChart) {
            const categoriesData = window.categoriesChart.data;
            statsData.candidatures_par_categorie = categoriesData.labels.map((label, index) => {
                return {
                    categorie: label,
                    nombre: categoriesData.datasets[0].data[index]
                };
            });
        }

        // Vues par offre
        if (window.vuesChart) {
            const vuesData = window.vuesChart.data;
            statsData.vues_par_offre = vuesData.labels.map((label, index) => {
                return {
                    poste: label,
                    nombre: vuesData.datasets[0].data[index]
                };
            });
        }

        // Candidatures par mois
        if (window.moisChart) {
            const moisData = window.moisChart.data;
            const moisLabels = moisData.labels;

            statsData.candidatures_par_mois = moisLabels.map((label, index) => {
                // Convertir l'abréviation du mois en numéro de mois
                const moisMap = {
                    'Jan': 1, 'Fév': 2, 'Mar': 3, 'Avr': 4, 'Mai': 5, 'Juin': 6,
                    'Juil': 7, 'Août': 8, 'Sep': 9, 'Oct': 10, 'Nov': 11, 'Déc': 12
                };

                const mois = moisMap[label] || (index + 1);

                return {
                    mois: mois,
                    nombre: moisData.datasets[0].data[index]
                };
            });
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des données des graphiques:', error);
    }

    return statsData;
}

/**
 * Affiche une notification
 * @param {string} message Message à afficher
 * @param {string} type Type de notification (success, error, info)
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `stats-notification ${type}`;

    const content = document.createElement('div');
    content.className = 'stats-notification-content';

    const icon = document.createElement('i');
    icon.className = type === 'success' ? 'fas fa-check-circle' :
        type === 'error' ? 'fas fa-exclamation-circle' :
            'fas fa-info-circle';

    const span = document.createElement('span');
    span.textContent = message;

    content.appendChild(icon);
    content.appendChild(span);
    notification.appendChild(content);

    document.body.appendChild(notification);

    // Afficher la notification avec une animation
    setTimeout(() => {
        notification.classList.add('visible');
    }, 10);

    // Masquer la notification après 3 secondes
    setTimeout(() => {
        notification.classList.remove('visible');

        // Supprimer la notification après l'animation
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

/**
 * Affiche l'indicateur de chargement
 */
function showLoading() {
    const loading = document.createElement('div');
    loading.className = 'stats-loading';
    loading.id = 'stats-loading';

    const spinner = document.createElement('div');
    spinner.className = 'stats-loading-spinner';

    const span = document.createElement('span');
    span.textContent = 'Exportation en cours...';

    loading.appendChild(spinner);
    loading.appendChild(span);

    document.querySelector('.stats-section').appendChild(loading);
}

/**
 * Masque l'indicateur de chargement
 */
function hideLoading() {
    const loading = document.getElementById('stats-loading');
    if (loading) {
        loading.parentNode.removeChild(loading);
    }
} 