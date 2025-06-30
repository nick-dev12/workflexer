<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Avancé de Génération PDF - Capacités wkhtmltopdf</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap');
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            z-index: -1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            margin-top: 2rem;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7);
            border-radius: 22px;
            z-index: -1;
            animation: borderGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes borderGlow {
            0% { opacity: 0.5; transform: scale(1); }
            100% { opacity: 0.8; transform: scale(1.02); }
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            border-radius: 2px;
        }
        
        .subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 3rem;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .text-section {
            padding: 2rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.4) 100%);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }
        
        .text-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .text-section h2::before {
            content: '';
            position: absolute;
            left: -15px;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 30px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 3px;
        }
        
        p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #34495e;
            margin-bottom: 1.5rem;
            text-align: justify;
            font-weight: 400;
        }
        
        .highlight-text {
            background: linear-gradient(120deg, rgba(255, 107, 107, 0.2) 0%, rgba(78, 205, 196, 0.2) 100%);
            padding: 0.2rem 0.5rem;
            border-radius: 5px;
            font-weight: 500;
        }
        
        .logo-container {
            text-align: center;
            margin: 3rem 0;
            position: relative;
        }
        
        .logo-container img {
            max-width: 200px;
            height: auto;
            border-radius: 15px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
        }
        
        .logo-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
        }
        
        .features-list {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.6) 100%);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .features-list h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        ul {
            list-style: none;
            padding: 0;
        }
        
        li {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            padding-left: 3rem;
            font-size: 1.1rem;
            color: #34495e;
            transition: all 0.3s ease;
        }
        
        li:last-child {
            border-bottom: none;
        }
        
        li::before {
            content: '✦';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .cta-section {
            text-align: center;
            margin-top: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 15px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        
        .cta-button {
            display: inline-block;
            padding: 1rem 3rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            box-shadow: 
                0 15px 35px rgba(102, 126, 234, 0.4),
                0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .stat-card {
            text-align: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.4) 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #7f8c8d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .footer-note {
            margin-top: 3rem;
            padding: 1.5rem;
            background: rgba(52, 73, 94, 0.05);
            border-radius: 10px;
            border-left: 5px solid #3498db;
            font-style: italic;
            color: #7f8c8d;
        }
        
        @media print {
            body {
                background: white !important;
            }
            
            .container::before {
                display: none;
            }
            
            .container {
                box-shadow: none;
                background: white;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Avancé de Génération PDF</h1>
        <p class="subtitle">Évaluation complète des capacités de wkhtmltopdf avec des styles CSS complexes</p>
        
        <div class="content-grid">
            <div class="text-section">
                <h2>Objectifs du Test</h2>
                <p>Ce document a été conçu pour <span class="highlight-text">tester les capacités avancées</span> de wkhtmltopdf en utilisant des propriétés CSS modernes et complexes.</p>
                <p>Nous évaluons la prise en charge des dégradés, des ombres, des transformations, et des effets de transparence dans la génération de PDF.</p>
            </div>
            
            <div class="features-list">
                <h3>Fonctionnalités Testées</h3>
                <ul>
                    <li>Dégradés linéaires et radiaux</li>
                    <li>Ombres portées et effets de flou</li>
                    <li>Transparences et backdrop-filter</li>
                    <li>Animations CSS et transformations</li>
                    <li>Typographies personnalisées</li>
                    <li>Grilles CSS et flexbox</li>
                </ul>
            </div>
        </div>
        
        <div class="logo-container">
            <img src="image/logo 2.png" alt="Logo de test - Évaluation des capacités graphiques">
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">95%</div>
                <div class="stat-label">Compatibilité</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24</div>
                <div class="stat-label">Propriétés CSS</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Qualité</div>
            </div>
        </div>
        
        <div class="cta-section">
            <h3>Résultats du Test</h3>
            <p>Ce document démontre la capacité de wkhtmltopdf à gérer des styles CSS avancés tout en maintenant une qualité de rendu élevée.</p>
            <a href="https://www.google.com" class="cta-button">Voir Plus de Détails</a>
        </div>
        
        <div class="footer-note">
            <strong>Note technique :</strong> Ce test inclut des propriétés CSS3 avancées telles que les dégradés, les ombres multiples, les transformations, et les effets de transparence pour évaluer la fidélité de rendu de wkhtmltopdf.
        </div>
    </div>
</body>
</html>
