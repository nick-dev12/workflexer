<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/model8.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="cv_customizer.js"></script>
    <script src="image_customizer.js" defer></script>
</head>

<body>
    <div class="personnalisation" style="padding: 20px; margin-bottom: 20px;">
        <button class="button12" onclick="generatePDF()"
            style="padding: 10px 20px; background-color: #0089be; color: white; border: none; border-radius: 5px; cursor: pointer; margin-bottom: 15px;">Télécharger
            mon CV</button>

        <script>
            // Fonction pour générer un PDF
            function generatePDF() {
                const element = document.querySelector(".cv-container");
                const mergedOptions = {
                    filename: 'cv.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                };
                html2pdf().set(mergedOptions).from(element).save("cv.pdf");
            }
        </script>

        <div class="theme-selector">
            <h3>Thèmes de couleurs</h3>
            <div class="themes-section">
                <h4>Classiques</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="classic">
                        <div class="theme-preview">
                            <div style="background-color: #4A4A4A; height: 20px;"></div>
                            <div style="background-color: #7A7A7A; height: 20px;"></div>
                            <div style="background-color: #F5F5F5; height: 20px;"></div>
                        </div>
                        <span>Classique</span>
                    </div>
                    <div class="theme-card" data-theme="professional">
                        <div class="theme-preview">
                            <div style="background-color: #1D3557; height: 20px;"></div>
                            <div style="background-color: #457B9D; height: 20px;"></div>
                            <div style="background-color: #F1FAEE; height: 20px;"></div>
                        </div>
                        <span>Marine</span>
                    </div>
                    <div class="theme-card" data-theme="corporate">
                        <div class="theme-preview">
                            <div style="background-color: #1A237E; height: 20px;"></div>
                            <div style="background-color: #5C6BC0; height: 20px;"></div>
                            <div style="background-color: #FFFFFF; height: 20px;"></div>
                        </div>
                        <span>Corporate</span>
                    </div>
                    <div class="theme-card" data-theme="slate">
                        <div class="theme-preview">
                            <div style="background-color: #2F4F4F; height: 20px;"></div>
                            <div style="background-color: #708090; height: 20px;"></div>
                            <div style="background-color: #E8ECEE; height: 20px;"></div>
                        </div>
                        <span>Ardoise</span>
                    </div>
                </div>

                <h4>Couleurs vives</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="elegant">
                        <div class="theme-preview">
                            <div style="background-color: #0E3B43; height: 20px;"></div>
                            <div style="background-color: #328590; height: 20px;"></div>
                            <div style="background-color: #F0F0F0; height: 20px;"></div>
                        </div>
                        <span>Émeraude</span>
                    </div>
                    <div class="theme-card" data-theme="creative">
                        <div class="theme-preview">
                            <div style="background-color: #845EC2; height: 20px;"></div>
                            <div style="background-color: #B39CD0; height: 20px;"></div>
                            <div style="background-color: #FBEAFF; height: 20px;"></div>
                        </div>
                        <span>Violet</span>
                    </div>
                    <div class="theme-card" data-theme="modern">
                        <div class="theme-preview">
                            <div style="background-color: #3D5A80; height: 20px;"></div>
                            <div style="background-color: #98C1D9; height: 20px;"></div>
                            <div style="background-color: #E0FBFC; height: 20px;"></div>
                        </div>
                        <span>Océan</span>
                    </div>
                    <div class="theme-card" data-theme="mint">
                        <div class="theme-preview">
                            <div style="background-color: #21897E; height: 20px;"></div>
                            <div style="background-color: #69B7A8; height: 20px;"></div>
                            <div style="background-color: #F4FFF8; height: 20px;"></div>
                        </div>
                        <span>Menthe</span>
                    </div>
                </div>

                <h4>Tons chauds</h4>
                <div class="themes-container">
                    <div class="theme-card" data-theme="earthy">
                        <div class="theme-preview">
                            <div style="background-color: #5F4B32; height: 20px;"></div>
                            <div style="background-color: #A1887F; height: 20px;"></div>
                            <div style="background-color: #F0EAE2; height: 20px;"></div>
                        </div>
                        <span>Terracotta</span>
                    </div>
                    <div class="theme-card" data-theme="burgundy">
                        <div class="theme-preview">
                            <div style="background-color: #800020; height: 20px;"></div>
                            <div style="background-color: #AD8A8E; height: 20px;"></div>
                            <div style="background-color: #F2F2F2; height: 20px;"></div>
                        </div>
                        <span>Bordeaux</span>
                    </div>
                    <div class="theme-card" data-theme="amber">
                        <div class="theme-preview">
                            <div style="background-color: #B86E00; height: 20px;"></div>
                            <div style="background-color: #F0A858; height: 20px;"></div>
                            <div style="background-color: #FFFBF0; height: 20px;"></div>
                        </div>
                        <span>Ambre</span>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .theme-selector {
                margin-top: 20px;
                padding: 15px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .theme-selector h3 {
                text-align: center;
                margin-bottom: 15px;
                color: #333;
                font-size: 18px;
            }

            .theme-selector h4 {
                border-bottom: 1px solid #e0e0e0;
                padding-bottom: 8px;
                margin: 15px 0 10px;
                color: #555;
                font-size: 16px;
            }

            .themes-section {
                max-height: 400px;
                overflow-y: auto;
                padding-right: 5px;
            }

            .themes-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
                gap: 12px;
                margin-bottom: 15px;
            }

            .theme-card {
                width: calc(25% - 12px);
                min-width: 85px;
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .theme-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .theme-card.active {
                border: 2px solid #0089be;
                transform: translateY(-2px);
            }

            .theme-preview {
                width: 100%;
            }

            .theme-card span {
                display: block;
                text-align: center;
                padding: 6px 0;
                font-size: 12px;
                background-color: white;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Styles pour tablette */
            @media (max-width: 768px) {
                .theme-card {
                    width: calc(33.33% - 12px);
                }

                .themes-section {
                    max-height: 350px;
                }
            }

            /* Styles pour mobile */
            @media (max-width: 480px) {
                .theme-card {
                    width: calc(50% - 8px);
                    min-width: 60px;
                }

                .themes-container {
                    gap: 8px;
                }

                .theme-selector {
                    padding: 10px;
                }

                .theme-selector h3 {
                    font-size: 16px;
                }

                .theme-selector h4 {
                    font-size: 14px;
                }

                .theme-card span {
                    font-size: 11px;
                    padding: 4px 0;
                }

                .themes-section {
                    max-height: 250px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Définition des thèmes
                const themes = {
                    elegant: {
                        leftBg: '#0E3B43',
                        leftColor: '#ffffff',
                        rightBg: '#F0F0F0',
                        rightColor: '#333333'
                    },
                    professional: {
                        leftBg: '#1D3557',
                        leftColor: '#F1FAEE',
                        rightBg: '#F1FAEE',
                        rightColor: '#1D3557'
                    },
                    creative: {
                        leftBg: '#845EC2',
                        leftColor: '#FBEAFF',
                        rightBg: '#FBEAFF',
                        rightColor: '#845EC2'
                    },
                    classic: {
                        leftBg: '#4A4A4A',
                        leftColor: '#FFFFFF',
                        rightBg: '#F5F5F5',
                        rightColor: '#333333'
                    },
                    modern: {
                        leftBg: '#3D5A80',
                        leftColor: '#E0FBFC',
                        rightBg: '#E0FBFC',
                        rightColor: '#3D5A80'
                    },
                    earthy: {
                        leftBg: '#5F4B32',
                        leftColor: '#F0EAE2',
                        rightBg: '#F0EAE2',
                        rightColor: '#5F4B32'
                    },
                    // Nouveaux thèmes
                    corporate: {
                        leftBg: '#1A237E',
                        leftColor: '#FFFFFF',
                        rightBg: '#FFFFFF',
                        rightColor: '#1A237E'
                    },
                    burgundy: {
                        leftBg: '#800020',
                        leftColor: '#F2F2F2',
                        rightBg: '#F2F2F2',
                        rightColor: '#800020'
                    },
                    mint: {
                        leftBg: '#21897E',
                        leftColor: '#F4FFF8',
                        rightBg: '#F4FFF8',
                        rightColor: '#21897E'
                    },
                    slate: {
                        leftBg: '#2F4F4F',
                        leftColor: '#E8ECEE',
                        rightBg: '#E8ECEE',
                        rightColor: '#2F4F4F'
                    },
                    amber: {
                        leftBg: '#B86E00',
                        leftColor: '#FFFBF0',
                        rightBg: '#FFFBF0',
                        rightColor: '#B86E00'
                    }
                };

                // Récupérer le numéro du modèle à partir de l'URL
                const modelNumber = window.location.pathname.match(/model(\d+)\.php/i)?.[1] || '8';
                const storagePrefix = `model${modelNumber}-`;

                // Ajouter les écouteurs d'événements aux cartes de thème
                const themeCards = document.querySelectorAll('.theme-card');
                themeCards.forEach(card => {
                    card.addEventListener('click', function () {
                        // Retirer la classe active de toutes les cartes
                        themeCards.forEach(c => c.classList.remove('active'));

                        // Ajouter la classe active à la carte cliquée
                        this.classList.add('active');

                        // Appliquer le thème
                        const themeName = this.getAttribute('data-theme');
                        applyTheme(themes[themeName]);
                    });
                });

                // Fonction pour appliquer un thème
                function applyTheme(theme) {
                    // Appliquer les couleurs CSS pour ce modèle
                    document.querySelector('.left-column').style.backgroundColor = theme.leftBg;
                    document.querySelector('.left-column').style.color = theme.leftColor;
                    document.querySelector('.right-column').style.backgroundColor = theme.rightBg;
                    document.querySelector('.right-column').style.color = theme.rightColor;

                    // Mise à jour des titres dans la colonne de droite pour contraste
                    document.querySelectorAll('.right-column h3, .right-column h4').forEach(el => {
                        el.style.color = theme.rightColor;
                    });

                    // Sauvegarder dans localStorage avec préfixe spécifique au modèle
                    localStorage.setItem(`${storagePrefix}leftBg`, theme.leftBg);
                    localStorage.setItem(`${storagePrefix}leftColor`, theme.leftColor);
                    localStorage.setItem(`${storagePrefix}rightBg`, theme.rightBg);
                    localStorage.setItem(`${storagePrefix}rightColor`, theme.rightColor);
                }

                // Vérifier s'il y a un thème sauvegardé et l'appliquer
                const savedTheme = {
                    leftBg: localStorage.getItem(`${storagePrefix}leftBg`),
                    leftColor: localStorage.getItem(`${storagePrefix}leftColor`),
                    rightBg: localStorage.getItem(`${storagePrefix}rightBg`),
                    rightColor: localStorage.getItem(`${storagePrefix}rightColor`)
                };

                if (savedTheme.leftBg) {
                    // Appliquer le thème sauvegardé
                    document.querySelector('.left-column').style.backgroundColor = savedTheme.leftBg;
                    document.querySelector('.left-column').style.color = savedTheme.leftColor;
                    document.querySelector('.right-column').style.backgroundColor = savedTheme.rightBg;
                    document.querySelector('.right-column').style.color = savedTheme.rightColor;

                    // Mise à jour des titres dans la colonne de droite pour contraste
                    document.querySelectorAll('.right-column h3, .right-column h4').forEach(el => {
                        el.style.color = savedTheme.rightColor;
                    });

                    // Retrouver quel thème correspond aux couleurs sauvegardées
                    for (const [themeName, theme] of Object.entries(themes)) {
                        if (theme.leftBg === savedTheme.leftBg &&
                            theme.leftColor === savedTheme.leftColor) {
                            // Marquer le thème comme actif
                            const themeCard = document.querySelector(`.theme-card[data-theme="${themeName}"]`);
                            if (themeCard) themeCard.classList.add('active');
                            break;
                        }
                    }
                }
            });
        </script>
    </div>

    <div class="cv-container">
        <div class="left-column">
            <div class="profile">
                <img src="profile.jpg" alt="Photo de profil">
                <h1>Babacar Ndiaye</h1>
                <h2>Responsable Logistique</h2>
            </div>
            <div class="contact">
                <h3>Me Contacter</h3>
                <p>Rue Kaolack, Point E<br>Dakar, Sénégal<br>+ 150 20 30 00<br>babacar@mbpdakar.com</p>
            </div>
            <div class="section">
                <h3>Formation</h3>
                <p>Master Gestion Production Logistique Achats<br>2013 – Polytechnique Lille, France</p>
                <p>Licence Logistique et Pilotage de Flux<br>2011 – Polytechnique Lille, France</p>
            </div>
            <div class="section">
                <h3>Compétences</h3>
                <ul>
                    <li>Logistique, gestion de la chaîne d'approvisionnement</li>
                    <li>Gestion des stocks, planification des approvisionnements</li>
                    <li>Gestion des relations avec les fournisseurs</li>
                    <li>Analyse des données et des indicateurs de performance (KPI)</li>
                    <li>Utilisation des logiciels WMS, ERP et autres outils de gestion logistique</li>
                </ul>
            </div>
            <div class="section">
                <h3>Langues</h3>
                <p>Français : Courant<br>Anglais : Courant<br>Allemand : Intermédiaire</p>
            </div>
        </div>
        <div class="right-column">
            <div class="about">
                <h3>À propos de moi</h3>
                <p>Professionnel de la logistique chevronné, polyvalent et orienté résultats, avec une vaste expérience
                    dans toutes les facettes de la gestion de la chaîne d'approvisionnement et de la logistique,
                    englobant la manutention et le stockage des matériaux, la réduction des coûts, les opérations de
                    transport, le contrôle des stocks et la régulation. Expert dans la gestion des relations et
                    l'établissement de relations à long terme avec les fournisseurs, les clients et partenaires clés
                    pour identifier les opportunités et conduire un processus continu.</p>
            </div>
            <div class="experience">
                <h3>Expérience Professionnelle</h3>
                <h4>Responsable Logistique | Amazon France – Paris</h4>
                <p>2018 – Actuel</p>
                <ul>
                    <li>Supervision de 360 activités quotidiennes des personnels en encadrant, en déléguant, en
                        surveillant les projets et en fournissant une direction et un soutien technique.</li>
                    <li>Gestion de l'inventaire et de la distribution des stocks en magasin, en supervisant et en
                        organisant le dépôt et la distribution de toutes les cargaisons.</li>
                    <li>Coordination des opérations logistiques, y compris la supervision et l'ordonnancement du
                        personnel, la réception, la manipulation, le stockage, l'expédition ou la circulation des
                        produits.</li>
                    <li>Analyse des indicateurs de performance (KPI) pour identifier les tendances et les opportunités
                        d'amélioration.</li>
                    <li>Formation du personnel sur les procédures d'inspection et d'obtention des résultats.</li>
                </ul>
                <h4>Assistant Logistique | Deloitte Afrique Francophone – Dakar</h4>
                <p>2014 – 2018</p>
                <ul>
                    <li>Participation à la mise en place et à la politique de gestion des flux logistiques.</li>
                    <li>Gestion des stocks et des flux de marchandises de l'entrepôt, le stockage, les livraisons et les
                        expéditions.</li>
                    <li>Supervision de l'équipe en charge de la gestion des expéditions, du suivi des livraisons et des
                        retours.</li>
                    <li>Développement des budgets d'inventaire et d'exploitation pour les opérations logistiques.</li>
                    <li>Analyse des indicateurs de performance (KPI) pour identifier les tendances et les opportunités
                        d'amélioration.</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>