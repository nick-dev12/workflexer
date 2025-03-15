/**
 * Script d'exportation directe pour les statistiques
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('Initialisation du script d\'exportation directe');

    // Référence aux boutons d'exportation
    const pdfExportBtn = document.getElementById('export-pdf');
    const excelExportBtn = document.getElementById('export-excel');
    const csvExportBtn = document.getElementById('export-csv');

    // Vérifier si les boutons existent
    if (pdfExportBtn) {
        console.log('Bouton d\'exportation PDF trouvé');
        pdfExportBtn.addEventListener('click', function () {
            console.log('Clic sur Exporter en PDF');
            exportToPDF();
        });
    } else {
        console.error('Bouton d\'exportation PDF non trouvé');
    }

    if (excelExportBtn) {
        console.log('Bouton d\'exportation Excel trouvé');
        excelExportBtn.addEventListener('click', function () {
            console.log('Clic sur Exporter en Excel');
            exportToExcel();
        });
    } else {
        console.error('Bouton d\'exportation Excel non trouvé');
    }

    if (csvExportBtn) {
        console.log('Bouton d\'exportation CSV trouvé');
        csvExportBtn.addEventListener('click', function () {
            console.log('Clic sur Exporter en CSV');
            exportToCSV();
        });
    } else {
        console.error('Bouton d\'exportation CSV non trouvé');
    }
});

/**
 * Capture un graphique sous forme d'image
 * @param {string} chartId ID du canvas du graphique
 * @returns {Promise<string>} Promise qui résout avec l'URL de l'image en base64
 */
function captureChart(chartId) {
    return new Promise((resolve, reject) => {
        try {
            const canvas = document.getElementById(chartId);
            if (!canvas) {
                console.error(`Canvas avec ID ${chartId} non trouvé`);
                reject(new Error(`Canvas avec ID ${chartId} non trouvé`));
                return;
            }

            // Convertir le canvas en image base64
            const imageData = canvas.toDataURL('image/png');
            resolve(imageData);
        } catch (error) {
            console.error(`Erreur lors de la capture du graphique ${chartId}:`, error);
            reject(error);
        }
    });
}

/**
 * Exporte les statistiques au format PDF avec graphiques
 */
function exportToPDF() {
    console.log('Début de l\'exportation en PDF');
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

        // Capturer les graphiques
        Promise.all([
            captureChart('categoriesChart'),
            captureChart('vuesChart'),
            captureChart('moisChart'),
            captureChart('statusChart')
        ]).then(([categoriesChartImg, vuesChartImg, moisChartImg, statusChartImg]) => {
            // Créer un nouvel objet jsPDF
            let doc;

            // Essayer différentes façons d'initialiser jsPDF selon la version disponible
            if (typeof jspdf !== 'undefined' && typeof jspdf.jsPDF === 'function') {
                // Version UMD moderne
                doc = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
            } else if (typeof window.jspdf !== 'undefined' && typeof window.jspdf.jsPDF === 'function') {
                // Version UMD moderne (window)
                doc = new window.jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
            } else if (typeof jsPDF === 'function') {
                // Version ancienne
                doc = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
            } else {
                console.error("Impossible d'initialiser jsPDF");
                showNotification("Erreur lors de l'exportation en PDF. Impossible d'initialiser jsPDF.", 'error');
                hideLoading();
                return;
            }

            // Définir les couleurs
            const primaryColor = '#4361ee';
            const secondaryColor = '#3f37c9';
            const successColor = '#4ade80';
            const warningColor = '#fb8500';
            const dangerColor = '#ef476f';
            const grayColor = '#6b7280';
            const darkColor = '#1f2937';

            // Ajouter un en-tête avec logo (si disponible)
            try {
                const logo = document.querySelector('link[rel="icon"]');
                if (logo && logo.href) {
                    // Ajouter le logo si disponible
                    doc.addImage(logo.href, 'PNG', 14, 10, 20, 20);
                }
            } catch (e) {
                console.log('Pas de logo disponible pour le PDF');
            }

            // Ajouter un rectangle de couleur en haut
            doc.setFillColor(primaryColor);
            doc.rect(0, 0, 210, 15, 'F');

            // Ajouter le titre
            doc.setFontSize(22);
            doc.setTextColor(darkColor);
            doc.setFont('helvetica', 'bold');
            doc.text(`Statistiques - ${entrepriseNom}`, 14, 30);

            // Ajouter la date de génération
            doc.setFontSize(10);
            doc.setTextColor(grayColor);
            doc.setFont('helvetica', 'normal');
            doc.text(`Généré le: ${dateGeneration}`, 14, 38);

            // Ajouter une ligne de séparation
            doc.setDrawColor(primaryColor);
            doc.setLineWidth(0.5);
            doc.line(14, 42, 196, 42);

            // Ajouter les statistiques principales
            doc.setFontSize(16);
            doc.setTextColor(primaryColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Statistiques générales', 14, 50);

            // Créer un tableau pour les statistiques principales
            const tableData = [
                ['Offres publiées', statsData.offres_publiees.toString()],
                ['Candidatures reçues', statsData.candidatures_total.toString()],
                ['Offres expirées', statsData.offres_expirees.toString()],
                ['Offres supprimées', statsData.offres_supprimees.toString()],
                ['Candidats acceptés', statsData.candidats_acceptes.toString()],
                ['Candidats refusés', statsData.candidats_refuses.toString()],
                ['Candidats en attente', statsData.candidats_en_attente.toString()],
                ['Vues totales', statsData.vues_total.toString()]
            ];

            // Dessiner le tableau
            doc.setFontSize(10);
            doc.setTextColor(darkColor);
            doc.setFont('helvetica', 'normal');

            let startY = 55;
            const cellPadding = 5;
            const colWidth = [40, 20];
            const rowHeight = 8;

            // En-tête du tableau
            doc.setFillColor(primaryColor);
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.rect(14, startY, colWidth[0] + colWidth[1], rowHeight, 'F');
            doc.text('Catégorie', 14 + cellPadding, startY + rowHeight - cellPadding / 2);
            doc.text('Valeur', 14 + colWidth[0] + cellPadding, startY + rowHeight - cellPadding / 2);
            startY += rowHeight;

            // Corps du tableau
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(darkColor);

            for (let i = 0; i < tableData.length; i++) {
                // Alterner les couleurs de fond
                if (i % 2 === 0) {
                    doc.setFillColor(245, 247, 250);
                } else {
                    doc.setFillColor(255, 255, 255);
                }

                doc.rect(14, startY, colWidth[0] + colWidth[1], rowHeight, 'F');

                // Dessiner les bordures
                doc.setDrawColor(200, 200, 200);
                doc.rect(14, startY, colWidth[0] + colWidth[1], rowHeight, 'S');
                doc.line(14 + colWidth[0], startY, 14 + colWidth[0], startY + rowHeight);

                // Ajouter le texte
                doc.text(tableData[i][0], 14 + cellPadding, startY + rowHeight - cellPadding / 2);
                doc.text(tableData[i][1], 14 + colWidth[0] + cellPadding, startY + rowHeight - cellPadding / 2);

                startY += rowHeight;
            }

            // Ajouter le graphique de répartition des candidatures
            startY += 10;
            doc.setFontSize(16);
            doc.setTextColor(primaryColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Répartition des candidatures', 14, startY);
            startY += 8;

            // Ajouter l'image du graphique
            try {
                doc.addImage(statusChartImg, 'PNG', 14, startY, 80, 60);
                startY += 65;
            } catch (e) {
                console.error('Erreur lors de l\'ajout du graphique de répartition:', e);
                startY += 5;
                doc.setFontSize(10);
                doc.setTextColor(grayColor);
                doc.text('Graphique non disponible', 14, startY);
                startY += 10;
            }

            // Ajouter une nouvelle page pour les autres graphiques
            doc.addPage();

            // Ajouter un en-tête à la nouvelle page
            doc.setFillColor(primaryColor);
            doc.rect(0, 0, 210, 15, 'F');

            // Ajouter un titre à la nouvelle page
            doc.setFontSize(22);
            doc.setTextColor(darkColor);
            doc.setFont('helvetica', 'bold');
            doc.text(`Statistiques - ${entrepriseNom}`, 14, 30);

            // Ajouter la date de génération
            doc.setFontSize(10);
            doc.setTextColor(grayColor);
            doc.setFont('helvetica', 'normal');
            doc.text(`Généré le: ${dateGeneration}`, 14, 38);

            // Ajouter une ligne de séparation
            doc.setDrawColor(primaryColor);
            doc.setLineWidth(0.5);
            doc.line(14, 42, 196, 42);

            // Réinitialiser la position Y
            startY = 50;

            // Ajouter le graphique des candidatures par catégorie
            doc.setFontSize(16);
            doc.setTextColor(primaryColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Candidatures par catégorie', 14, startY);
            startY += 8;

            // Ajouter l'image du graphique
            try {
                doc.addImage(categoriesChartImg, 'PNG', 14, startY, 180, 60);
                startY += 65;
            } catch (e) {
                console.error('Erreur lors de l\'ajout du graphique des catégories:', e);
                startY += 5;
                doc.setFontSize(10);
                doc.setTextColor(grayColor);
                doc.text('Graphique non disponible', 14, startY);
                startY += 10;
            }

            // Ajouter le graphique des vues par offre
            doc.setFontSize(16);
            doc.setTextColor(primaryColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Top 5 des offres les plus vues', 14, startY);
            startY += 8;

            // Ajouter l'image du graphique
            try {
                doc.addImage(vuesChartImg, 'PNG', 14, startY, 180, 60);
                startY += 65;
            } catch (e) {
                console.error('Erreur lors de l\'ajout du graphique des vues:', e);
                startY += 5;
                doc.setFontSize(10);
                doc.setTextColor(grayColor);
                doc.text('Graphique non disponible', 14, startY);
                startY += 10;
            }

            // Ajouter le graphique des candidatures par mois
            doc.setFontSize(16);
            doc.setTextColor(primaryColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Candidatures par mois', 14, startY);
            startY += 8;

            // Ajouter l'image du graphique
            try {
                doc.addImage(moisChartImg, 'PNG', 14, startY, 180, 60);
            } catch (e) {
                console.error('Erreur lors de l\'ajout du graphique des mois:', e);
                startY += 5;
                doc.setFontSize(10);
                doc.setTextColor(grayColor);
                doc.text('Graphique non disponible', 14, startY);
            }

            // Ajouter un pied de page
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);

                // Ajouter un rectangle de couleur en bas
                doc.setFillColor(primaryColor);
                doc.rect(0, 282, 210, 15, 'F');

                // Ajouter le numéro de page
                doc.setFontSize(10);
                doc.setTextColor(255, 255, 255);
                doc.text(`Page ${i} sur ${pageCount}`, 105, 290, { align: 'center' });

                // Ajouter le nom de l'entreprise
                doc.text(entrepriseNom, 14, 290);

                // Ajouter la date
                doc.text(dateGeneration, 196, 290, { align: 'right' });
            }

            // Sauvegarder le PDF
            doc.save(`statistiques_${entrepriseNom.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.pdf`);

            // Masquer l'indicateur de chargement et afficher une notification
            hideLoading();
            showNotification('Exportation en PDF réussie', 'success');
        }).catch(error => {
            console.error("Erreur lors de la capture des graphiques:", error);
            hideLoading();
            showNotification("Erreur lors de l'exportation en PDF: " + error.message, 'error');
        });
    } catch (error) {
        console.error("Erreur lors de l'exportation en PDF:", error);
        hideLoading();
        showNotification("Erreur lors de l'exportation en PDF: " + error.message, 'error');
    }
}

/**
 * Exporte les statistiques au format CSV avec un formatage amélioré
 */
function exportToCSV() {
    console.log('Début de l\'exportation en CSV');
    // Afficher l'indicateur de chargement
    showLoading();

    try {
        // Récupérer les données de statistiques
        const statsData = getStatisticsData();
        const entrepriseNom = getEntrepriseName();
        const dateGeneration = new Date().toLocaleDateString();
        const annee = new Date().getFullYear();

        // Créer les lignes CSV avec un meilleur formatage
        let csvContent = 'data:text/csv;charset=utf-8,';

        // Ajouter un en-tête avec le nom de l'entreprise et la date
        csvContent += `"STATISTIQUES - ${entrepriseNom.toUpperCase()}"\r\n`;
        csvContent += `"Généré le: ${dateGeneration}"\r\n\r\n`;

        // Ajouter une ligne de séparation
        csvContent += '"=========================================================="\r\n\r\n';

        // Ajouter les statistiques principales avec une section
        csvContent += '"STATISTIQUES GÉNÉRALES"\r\n';
        csvContent += '"=========================================================="\r\n';
        csvContent += '"Catégorie","Valeur"\r\n';
        csvContent += `"Offres publiées","${statsData.offres_publiees}"\r\n`;
        csvContent += `"Candidatures reçues","${statsData.candidatures_total}"\r\n`;
        csvContent += `"Offres expirées","${statsData.offres_expirees}"\r\n`;
        csvContent += `"Offres supprimées","${statsData.offres_supprimees}"\r\n`;
        csvContent += `"Candidats acceptés","${statsData.candidats_acceptes}"\r\n`;
        csvContent += `"Candidats refusés","${statsData.candidats_refuses}"\r\n`;
        csvContent += `"Candidats en attente","${statsData.candidats_en_attente}"\r\n`;
        csvContent += `"Vues totales","${statsData.vues_total}"\r\n\r\n`;

        // Ajouter une ligne de séparation
        csvContent += '"=========================================================="\r\n\r\n';

        // Ajouter les candidatures par catégorie
        csvContent += '"CANDIDATURES PAR CATÉGORIE"\r\n';
        csvContent += '"=========================================================="\r\n';
        csvContent += '"Catégorie","Nombre"\r\n';

        if (statsData.candidatures_par_categorie && statsData.candidatures_par_categorie.length > 0) {
            statsData.candidatures_par_categorie.forEach(item => {
                csvContent += `"${item.categorie}","${item.nombre}"\r\n`;
            });
        } else {
            csvContent += '"Aucune donnée disponible","0"\r\n';
        }

        // Ajouter une ligne de séparation
        csvContent += '\r\n"=========================================================="\r\n\r\n';

        // Ajouter les vues par offre
        csvContent += '"TOP DES OFFRES LES PLUS VUES"\r\n';
        csvContent += '"=========================================================="\r\n';
        csvContent += '"Poste","Nombre de vues"\r\n';

        if (statsData.vues_par_offre && statsData.vues_par_offre.length > 0) {
            statsData.vues_par_offre.forEach(item => {
                csvContent += `"${item.poste}","${item.nombre}"\r\n`;
            });
        } else {
            csvContent += '"Aucune donnée disponible","0"\r\n';
        }

        // Ajouter une ligne de séparation
        csvContent += '\r\n"=========================================================="\r\n\r\n';

        // Ajouter les candidatures par mois
        csvContent += '"CANDIDATURES PAR MOIS"\r\n';
        csvContent += '"=========================================================="\r\n';
        csvContent += '"Mois","Nombre de candidatures"\r\n';

        const moisNoms = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        if (statsData.candidatures_par_mois && statsData.candidatures_par_mois.length > 0) {
            // Créer un tableau pour tous les mois
            const candidaturesParMois = Array(12).fill(0);

            // Convertir l'abréviation du mois en numéro de mois
            const moisMap = {
                'Jan': 1, 'Fév': 2, 'Mar': 3, 'Avr': 4, 'Mai': 5, 'Juin': 6,
                'Juil': 7, 'Août': 8, 'Sep': 9, 'Oct': 10, 'Nov': 11, 'Déc': 12
            };

            // Remplir avec les données disponibles
            statsData.candidatures_par_mois.forEach(item => {
                const moisIndex = typeof item.mois === 'string' ?
                    moisMap[item.mois] - 1 :
                    (typeof item.mois === 'number' ? item.mois - 1 : 0);

                if (moisIndex >= 0 && moisIndex < 12) {
                    candidaturesParMois[moisIndex] = item.nombre;
                }
            });

            // Ajouter tous les mois
            moisNoms.forEach((mois, index) => {
                csvContent += `"${mois}","${candidaturesParMois[index]}"\r\n`;
            });
        } else {
            csvContent += '"Aucune donnée disponible","0"\r\n';
        }

        // Ajouter une ligne de séparation
        csvContent += '\r\n"=========================================================="\r\n\r\n';

        // Ajouter une note sur les graphiques
        csvContent += '"NOTE"\r\n';
        csvContent += '"Pour visualiser les graphiques correspondant à ces données, veuillez exporter au format PDF."\r\n\r\n';

        // Ajouter une ligne vide et un pied de page
        csvContent += '\r\n';
        csvContent += `"© ${annee} ${entrepriseNom} - Tous droits réservés"\r\n`;

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
 * Exporte les statistiques au format Excel avec graphiques
 */
function exportToExcel() {
    console.log('Début de l\'exportation en Excel');
    // Afficher l'indicateur de chargement
    showLoading();

    try {
        // Récupérer les données de statistiques
        const statsData = getStatisticsData();
        const entrepriseNom = getEntrepriseName();
        const dateGeneration = new Date().toLocaleDateString();

        // Vérifier si SheetJS est disponible
        if (typeof XLSX === 'undefined') {
            console.error("La bibliothèque SheetJS n'est pas correctement chargée");
            showNotification("Erreur lors de l'exportation en Excel. La bibliothèque SheetJS n'est pas chargée.", 'error');
            hideLoading();
            return;
        }

        // Capturer les graphiques
        Promise.all([
            captureChart('categoriesChart'),
            captureChart('vuesChart'),
            captureChart('moisChart'),
            captureChart('statusChart')
        ]).then(([categoriesChartImg, vuesChartImg, moisChartImg, statusChartImg]) => {
            // Définir les styles
            const styles = {
                header: { font: { bold: true, color: { rgb: "FFFFFF" } }, fill: { fgColor: { rgb: "4361EE" } }, alignment: { horizontal: "center" } },
                subheader: { font: { bold: true, color: { rgb: "4361EE" } }, fill: { fgColor: { rgb: "F5F7FA" } } },
                normal: { font: { color: { rgb: "1F2937" } } },
                number: { font: { color: { rgb: "1F2937" } }, numFmt: "0" },
                date: { font: { color: { rgb: "6B7280" } }, numFmt: "dd/mm/yyyy" },
                title: { font: { bold: true, sz: 16, color: { rgb: "4361EE" } } },
                footer: { font: { color: { rgb: "6B7280" } }, fill: { fgColor: { rgb: "F5F7FA" } } }
            };

            // Créer un nouveau classeur
            const wb = XLSX.utils.book_new();
            wb.Props = {
                Title: `Statistiques - ${entrepriseNom}`,
                Subject: "Statistiques de recrutement",
                Author: entrepriseNom,
                CreatedDate: new Date()
            };

            // Données pour la feuille des statistiques générales
            const generalData = [
                [{ v: `Statistiques - ${entrepriseNom}`, t: 's', s: styles.title }],
                [{ v: `Généré le: ${dateGeneration}`, t: 's', s: styles.date }],
                [],
                [{ v: "Statistiques générales", t: 's', s: styles.subheader }],
                [
                    { v: "Catégorie", t: 's', s: styles.header },
                    { v: "Valeur", t: 's', s: styles.header }
                ],
                [
                    { v: "Offres publiées", t: 's', s: styles.normal },
                    { v: statsData.offres_publiees, t: 'n', s: styles.number }
                ],
                [
                    { v: "Candidatures reçues", t: 's', s: styles.normal },
                    { v: statsData.candidatures_total, t: 'n', s: styles.number }
                ],
                [
                    { v: "Offres expirées", t: 's', s: styles.normal },
                    { v: statsData.offres_expirees, t: 'n', s: styles.number }
                ],
                [
                    { v: "Offres supprimées", t: 's', s: styles.normal },
                    { v: statsData.offres_supprimees, t: 'n', s: styles.number }
                ],
                [
                    { v: "Candidats acceptés", t: 's', s: styles.normal },
                    { v: statsData.candidats_acceptes, t: 'n', s: styles.number }
                ],
                [
                    { v: "Candidats refusés", t: 's', s: styles.normal },
                    { v: statsData.candidats_refuses, t: 'n', s: styles.number }
                ],
                [
                    { v: "Candidats en attente", t: 's', s: styles.normal },
                    { v: statsData.candidats_en_attente, t: 'n', s: styles.number }
                ],
                [
                    { v: "Vues totales", t: 's', s: styles.normal },
                    { v: statsData.vues_total, t: 'n', s: styles.number }
                ],
                [],
                [{ v: "Répartition des candidatures", t: 's', s: styles.subheader }],
                [
                    { v: "Statut", t: 's', s: styles.header },
                    { v: "Nombre", t: 's', s: styles.header }
                ],
                [
                    { v: "Acceptés", t: 's', s: styles.normal },
                    { v: statsData.candidats_acceptes, t: 'n', s: styles.number }
                ],
                [
                    { v: "Refusés", t: 's', s: styles.normal },
                    { v: statsData.candidats_refuses, t: 'n', s: styles.number }
                ],
                [
                    { v: "En attente", t: 's', s: styles.normal },
                    { v: statsData.candidats_en_attente, t: 'n', s: styles.number }
                ],
                [],
                [{ v: `© ${new Date().getFullYear()} ${entrepriseNom}`, t: 's', s: styles.footer }]
            ];

            // Créer la feuille des statistiques générales
            const wsGeneral = XLSX.utils.aoa_to_sheet(generalData);

            // Définir les largeurs de colonnes
            wsGeneral['!cols'] = [{ wch: 30 }, { wch: 15 }];

            // Ajouter la feuille au classeur
            XLSX.utils.book_append_sheet(wb, wsGeneral, "Statistiques générales");

            // Créer la feuille pour les candidatures par catégorie
            if (statsData.candidatures_par_categorie && statsData.candidatures_par_categorie.length > 0) {
                const categoriesData = [
                    [{ v: "Candidatures par catégorie", t: 's', s: styles.title }],
                    [{ v: `Généré le: ${dateGeneration}`, t: 's', s: styles.date }],
                    [],
                    [
                        { v: "Catégorie", t: 's', s: styles.header },
                        { v: "Nombre", t: 's', s: styles.header }
                    ]
                ];

                // Ajouter les données des catégories
                statsData.candidatures_par_categorie.forEach(item => {
                    categoriesData.push([
                        { v: item.categorie, t: 's', s: styles.normal },
                        { v: item.nombre, t: 'n', s: styles.number }
                    ]);
                });

                // Ajouter le pied de page
                categoriesData.push([]);
                categoriesData.push([{ v: `© ${new Date().getFullYear()} ${entrepriseNom}`, t: 's', s: styles.footer }]);

                // Créer la feuille
                const wsCategories = XLSX.utils.aoa_to_sheet(categoriesData);

                // Définir les largeurs de colonnes
                wsCategories['!cols'] = [{ wch: 30 }, { wch: 15 }];

                // Ajouter la feuille au classeur
                XLSX.utils.book_append_sheet(wb, wsCategories, "Candidatures par catégorie");
            }

            // Créer la feuille pour les vues par offre
            if (statsData.vues_par_offre && statsData.vues_par_offre.length > 0) {
                const vuesData = [
                    [{ v: "Top des offres les plus vues", t: 's', s: styles.title }],
                    [{ v: `Généré le: ${dateGeneration}`, t: 's', s: styles.date }],
                    [],
                    [
                        { v: "Poste", t: 's', s: styles.header },
                        { v: "Nombre de vues", t: 's', s: styles.header }
                    ]
                ];

                // Ajouter les données des vues
                statsData.vues_par_offre.forEach(item => {
                    vuesData.push([
                        { v: item.poste, t: 's', s: styles.normal },
                        { v: item.nombre, t: 'n', s: styles.number }
                    ]);
                });

                // Ajouter le pied de page
                vuesData.push([]);
                vuesData.push([{ v: `© ${new Date().getFullYear()} ${entrepriseNom}`, t: 's', s: styles.footer }]);

                // Créer la feuille
                const wsVues = XLSX.utils.aoa_to_sheet(vuesData);

                // Définir les largeurs de colonnes
                wsVues['!cols'] = [{ wch: 40 }, { wch: 15 }];

                // Ajouter la feuille au classeur
                XLSX.utils.book_append_sheet(wb, wsVues, "Vues par offre");
            }

            // Créer la feuille pour les candidatures par mois
            if (statsData.candidatures_par_mois && statsData.candidatures_par_mois.length > 0) {
                const moisData = [
                    [{ v: "Candidatures par mois", t: 's', s: styles.title }],
                    [{ v: `Généré le: ${dateGeneration}`, t: 's', s: styles.date }],
                    [],
                    [
                        { v: "Mois", t: 's', s: styles.header },
                        { v: "Nombre", t: 's', s: styles.header }
                    ]
                ];

                // Convertir l'abréviation du mois en numéro de mois
                const moisMap = {
                    'Jan': 1, 'Fév': 2, 'Mar': 3, 'Avr': 4, 'Mai': 5, 'Juin': 6,
                    'Juil': 7, 'Août': 8, 'Sep': 9, 'Oct': 10, 'Nov': 11, 'Déc': 12
                };

                // Ajouter les données des mois
                statsData.candidatures_par_mois.forEach(item => {
                    const moisNum = moisMap[item.mois] || 0;
                    moisData.push([
                        { v: item.mois, t: 's', s: styles.normal },
                        { v: item.nombre, t: 'n', s: styles.number }
                    ]);
                });

                // Ajouter le pied de page
                moisData.push([]);
                moisData.push([{ v: `© ${new Date().getFullYear()} ${entrepriseNom}`, t: 's', s: styles.footer }]);

                // Créer la feuille
                const wsMois = XLSX.utils.aoa_to_sheet(moisData);

                // Définir les largeurs de colonnes
                wsMois['!cols'] = [{ wch: 20 }, { wch: 15 }];

                // Ajouter la feuille au classeur
                XLSX.utils.book_append_sheet(wb, wsMois, "Candidatures par mois");
            }

            // Créer une feuille pour les graphiques
            const graphiquesData = [
                [{ v: "Graphiques statistiques", t: 's', s: styles.title }],
                [{ v: `Généré le: ${dateGeneration}`, t: 's', s: styles.date }],
                [],
                [{ v: "Instructions pour créer des graphiques", t: 's', s: styles.subheader }],
                [{ v: "1. Sélectionnez les données dans les feuilles correspondantes", t: 's', s: styles.normal }],
                [{ v: "2. Insérez un graphique via l'onglet 'Insertion' > 'Graphiques'", t: 's', s: styles.normal }],
                [{ v: "3. Choisissez le type de graphique approprié (camembert, histogramme, etc.)", t: 's', s: styles.normal }],
                [],
                [{ v: "Données pour graphique de répartition des candidatures", t: 's', s: styles.subheader }],
                [
                    { v: "Statut", t: 's', s: styles.header },
                    { v: "Nombre", t: 's', s: styles.header }
                ],
                [
                    { v: "Acceptés", t: 's', s: styles.normal },
                    { v: statsData.candidats_acceptes, t: 'n', s: styles.number }
                ],
                [
                    { v: "Refusés", t: 's', s: styles.normal },
                    { v: statsData.candidats_refuses, t: 'n', s: styles.number }
                ],
                [
                    { v: "En attente", t: 's', s: styles.normal },
                    { v: statsData.candidats_en_attente, t: 'n', s: styles.number }
                ],
                [],
                [{ v: "Note: Pour visualiser les graphiques, veuillez consulter le PDF exporté qui contient les graphiques complets.", t: 's', s: styles.normal }],
                [{ v: "Les données ci-dessus peuvent être utilisées pour créer vos propres graphiques dans Excel.", t: 's', s: styles.normal }],
                []
            ];

            // Ajouter des données pour les autres graphiques
            if (statsData.candidatures_par_categorie && statsData.candidatures_par_categorie.length > 0) {
                graphiquesData.push([{ v: "Données pour graphique des candidatures par catégorie", t: 's', s: styles.subheader }]);
                graphiquesData.push([
                    { v: "Catégorie", t: 's', s: styles.header },
                    { v: "Nombre", t: 's', s: styles.header }
                ]);

                statsData.candidatures_par_categorie.forEach(item => {
                    graphiquesData.push([
                        { v: item.categorie, t: 's', s: styles.normal },
                        { v: item.nombre, t: 'n', s: styles.number }
                    ]);
                });

                graphiquesData.push([]);
            }

            if (statsData.vues_par_offre && statsData.vues_par_offre.length > 0) {
                graphiquesData.push([{ v: "Données pour graphique des offres les plus vues", t: 's', s: styles.subheader }]);
                graphiquesData.push([
                    { v: "Poste", t: 's', s: styles.header },
                    { v: "Nombre de vues", t: 's', s: styles.header }
                ]);

                statsData.vues_par_offre.forEach(item => {
                    graphiquesData.push([
                        { v: item.poste, t: 's', s: styles.normal },
                        { v: item.nombre, t: 'n', s: styles.number }
                    ]);
                });

                graphiquesData.push([]);
            }

            if (statsData.candidatures_par_mois && statsData.candidatures_par_mois.length > 0) {
                graphiquesData.push([{ v: "Données pour graphique des candidatures par mois", t: 's', s: styles.subheader }]);
                graphiquesData.push([
                    { v: "Mois", t: 's', s: styles.header },
                    { v: "Nombre", t: 's', s: styles.header }
                ]);

                // Trier les mois par ordre chronologique
                const moisMap = {
                    'Jan': 1, 'Fév': 2, 'Mar': 3, 'Avr': 4, 'Mai': 5, 'Juin': 6,
                    'Juil': 7, 'Août': 8, 'Sep': 9, 'Oct': 10, 'Nov': 11, 'Déc': 12
                };

                const moisNoms = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

                // Créer un tableau pour tous les mois
                const candidaturesParMois = Array(12).fill(0);

                // Remplir avec les données disponibles
                statsData.candidatures_par_mois.forEach(item => {
                    const moisIndex = typeof item.mois === 'string' ?
                        moisMap[item.mois] - 1 :
                        (typeof item.mois === 'number' ? item.mois - 1 : 0);

                    if (moisIndex >= 0 && moisIndex < 12) {
                        candidaturesParMois[moisIndex] = item.nombre;
                    }
                });

                // Ajouter tous les mois
                moisNoms.forEach((mois, index) => {
                    graphiquesData.push([
                        { v: mois, t: 's', s: styles.normal },
                        { v: candidaturesParMois[index], t: 'n', s: styles.number }
                    ]);
                });

                graphiquesData.push([]);
            }

            // Ajouter le pied de page
            graphiquesData.push([{ v: `© ${new Date().getFullYear()} ${entrepriseNom}`, t: 's', s: styles.footer }]);

            // Créer la feuille des graphiques
            const wsGraphiques = XLSX.utils.aoa_to_sheet(graphiquesData);

            // Définir les largeurs de colonnes
            wsGraphiques['!cols'] = [{ wch: 50 }, { wch: 15 }];

            // Ajouter la feuille au classeur
            XLSX.utils.book_append_sheet(wb, wsGraphiques, "Graphiques");

            // Créer une feuille pour les instructions
            const instructionsData = [
                [{ v: "Instructions pour l'utilisation des données", t: 's', s: styles.title }],
                [{ v: `Généré le: ${dateGeneration}`, t: 's', s: styles.date }],
                [],
                [{ v: "Comment créer des graphiques dans Excel", t: 's', s: styles.subheader }],
                [{ v: "1. Sélectionnez les données que vous souhaitez représenter (par exemple, les données de répartition des candidatures)", t: 's', s: styles.normal }],
                [{ v: "2. Cliquez sur l'onglet 'Insertion' dans le ruban Excel", t: 's', s: styles.normal }],
                [{ v: "3. Dans la section 'Graphiques', choisissez le type de graphique approprié:", t: 's', s: styles.normal }],
                [{ v: "   - Pour la répartition des candidatures: graphique en secteurs (camembert)", t: 's', s: styles.normal }],
                [{ v: "   - Pour les candidatures par catégorie: graphique en colonnes ou en barres", t: 's', s: styles.normal }],
                [{ v: "   - Pour les vues par offre: graphique en colonnes", t: 's', s: styles.normal }],
                [{ v: "   - Pour les candidatures par mois: graphique en courbes ou en colonnes", t: 's', s: styles.normal }],
                [{ v: "4. Personnalisez votre graphique en utilisant les options de mise en forme d'Excel", t: 's', s: styles.normal }],
                [],
                [{ v: "Conseils pour des graphiques efficaces", t: 's', s: styles.subheader }],
                [{ v: "- Utilisez des couleurs contrastées pour distinguer facilement les différentes catégories", t: 's', s: styles.normal }],
                [{ v: "- Ajoutez des titres clairs à vos graphiques", t: 's', s: styles.normal }],
                [{ v: "- Incluez des étiquettes de données pour montrer les valeurs exactes", t: 's', s: styles.normal }],
                [{ v: "- Pour les graphiques en camembert, limitez-vous à 5-7 catégories maximum pour une meilleure lisibilité", t: 's', s: styles.normal }],
                [],
                [{ v: "Note: Pour une visualisation immédiate des graphiques, consultez le fichier PDF exporté qui contient déjà tous les graphiques générés automatiquement.", t: 's', s: styles.normal }],
                [],
                [{ v: `© ${new Date().getFullYear()} ${entrepriseNom}`, t: 's', s: styles.footer }]
            ];

            // Créer la feuille des instructions
            const wsInstructions = XLSX.utils.aoa_to_sheet(instructionsData);

            // Définir les largeurs de colonnes
            wsInstructions['!cols'] = [{ wch: 100 }];

            // Ajouter la feuille au classeur
            XLSX.utils.book_append_sheet(wb, wsInstructions, "Instructions");

            // Convertir le classeur en binaire
            const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

            // Fonction pour convertir une chaîne en ArrayBuffer
            function s2ab(s) {
                const buf = new ArrayBuffer(s.length);
                const view = new Uint8Array(buf);
                for (let i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
            }

            // Créer un Blob et télécharger le fichier
            const blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `statistiques_${entrepriseNom.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.xlsx`;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 0);

            // Masquer l'indicateur de chargement et afficher une notification
            hideLoading();
            showNotification('Exportation en Excel réussie', 'success');
        }).catch(error => {
            console.error("Erreur lors de la capture des graphiques:", error);
            hideLoading();
            showNotification("Erreur lors de l'exportation en Excel: " + error.message, 'error');
        });
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