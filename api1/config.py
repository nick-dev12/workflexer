"""
Configuration pour l'API de matching
"""

# Poids des différents critères dans le calcul de compatibilité
WEIGHTS = {
    "competences": 0.40,       # 40% pour les compétences
    "formation": 0.20,         # 20% pour la formation/diplômes
    "experience": 0.20,        # 20% pour l'expérience professionnelle
    "langues": 0.10,           # 10% pour les langues
    "outils": 0.10,            # 10% pour les outils maîtrisés
}

# Seuils de compatibilité
COMPATIBILITY_THRESHOLDS = {
    "excellent": 0.85,         # Au-dessus de 85% = excellente compatibilité
    "good": 0.70,              # Entre 70% et 85% = bonne compatibilité
    "moderate": 0.50,          # Entre 50% et 70% = compatibilité moyenne
    "low": 0.30,               # Entre 30% et 50% = faible compatibilité
    "poor": 0.0                # En dessous de 30% = très faible compatibilité
}

# Configuration des messages selon le niveau de compatibilité
COMPATIBILITY_MESSAGES = {
    "excellent": "Votre profil correspond parfaitement à cette offre!",
    "good": "Votre profil correspond bien à cette offre.",
    "moderate": "Votre profil correspond partiellement à cette offre.",
    "low": "Votre profil correspond peu à cette offre.",
    "poor": "Votre profil ne correspond pas à cette offre."
}

# Nombre maximum de points forts et points à améliorer à retourner
MAX_STRENGTHS = 5
MAX_IMPROVEMENTS = 5

# Configuration de l'API
API_CONFIG = {
    "title": "API de Matching WorkFlexer",
    "description": "API pour analyser la compatibilité entre un profil candidat et une offre d'emploi",
    "version": "1.0.0",
    "docs_url": "/docs",
    "redoc_url": "/redoc",
}

# Seuil de similarité pour considérer deux compétences comme équivalentes
SIMILARITY_THRESHOLD = 0.75 