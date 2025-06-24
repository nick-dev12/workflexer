#!/usr/bin/env python
"""
Script de démarrage de l'API de matching WorkFlexer
"""

import os
import sys
import uvicorn
from dotenv import load_dotenv

# Chargement des variables d'environnement
load_dotenv()

def start_api():
    """Démarre l'API avec les paramètres configurés"""
    try:
        # Récupération du port depuis les variables d'environnement ou utilisation de la valeur par défaut
        port = int(os.getenv("API_PORT", 8000))
        
        # Récupération du niveau de log
        log_level = os.getenv("LOG_LEVEL", "info").lower()
        
        print(f"Démarrage de l'API WorkFlexer sur le port {port}...")
        print(f"Documentation interactive disponible à l'adresse: http://localhost:{port}/docs")
        print(f"Documentation ReDoc disponible à l'adresse: http://localhost:{port}/redoc")
        print(f"Pour arrêter l'API, appuyez sur CTRL+C")
        
        # Démarrage de l'API
        uvicorn.run(
            "main:app", 
            host="0.0.0.0", 
            port=port, 
            reload=True,
            log_level=log_level
        )
        
    except Exception as e:
        print(f"Erreur lors du démarrage de l'API: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    start_api() 