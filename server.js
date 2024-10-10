const express = require('express');
const puppeteer = require('puppeteer');
const { exec } = require('child_process');
const app = express();

(async () => {
    // Lancer le navigateur et ouvrir une nouvelle page vide
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    // Naviguer vers une URL
    await page.goto('http://localhost:3000/model_cv/model1.php', { waitUntil: 'networkidle0' });


    // await page.waitForSelector("sidebar-component");
    await page.pdf({ path: 'output.pdf', printBackground: true });
    // Imprimer le titre complet

    await browser.close();
})();

app.get('/generate-pdf', (req, res) => {
    exec('node generatePdf.js', (error, stdout, stderr) => {
        if (error) {
            console.error(`Erreur d'exécution : ${error}`);
            return res.status(500).send('Erreur lors de la génération du PDF');
        }
        res.download('cv.pdf', 'cv.pdf', (err) => {
            if (err) {
                console.error('Erreur lors du téléchargement du fichier:', err);
                res.status(500).send('Erreur lors du téléchargement du PDF');
            }
        });
    });
});