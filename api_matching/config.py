"""
Configuration de l'API de matching WorkFlexer
"""

# Configuration de l'API
API_HOST = "0.0.0.0"  # Écoute sur toutes les interfaces
API_PORT = 8000       # Port d'écoute
DEBUG = True          # Mode debug (à désactiver en production)

# Poids des différents critères pour le calcul du score global
POIDS = {
    "competences": 0.4,    # 40% du score global
    "formation": 0.2,      # 20% du score global
    "experience": 0.3,     # 30% du score global
    "langues": 0.1         # 10% du score global
}

# Seuils de correspondance
SEUIL_EXCELLENT = 85    # Score >= 85% : Excellente correspondance
SEUIL_BON = 70          # Score >= 70% : Bonne correspondance
SEUIL_MOYEN = 50        # Score >= 50% : Correspondance moyenne
SEUIL_FAIBLE = 30       # Score >= 30% : Faible correspondance
# Score < 30% : Très faible correspondance

# Nombre maximum de points forts/à améliorer à afficher
MAX_POINTS = 5

# Configuration du logging
LOG_LEVEL = "INFO"      # Niveau de log (DEBUG, INFO, WARNING, ERROR, CRITICAL)
LOG_FILE = "api.log"    # Fichier de log

# Dossier de sauvegarde des résultats
RESULTATS_DIR = "resultats"

# Mapping des niveaux d'études
NIVEAUX_ETUDES = {
    "bac": 1,
    "bac+2": 2,
    "dut": 2,
    "bts": 2,
    "licence": 3,
    "bachelor": 3,
    "bac+3": 3,
    "master": 5,
    "bac+5": 5,
    "ingénieur": 5,
    "doctorat": 8,
    "phd": 8,
    "bac+8": 8
}

# Mapping des niveaux de langue
NIVEAUX_LANGUE = {
    "a1": 1,
    "a2": 2,
    "b1": 3,
    "b2": 4,
    "c1": 5,
    "c2": 6,
    "débutant": 1,
    "intermédiaire": 3,
    "avancé": 5,
    "bilingue": 6,
    "natif": 6
} 