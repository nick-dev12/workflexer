"""
Configuration pour l'API de matching
"""

import os
from dotenv import load_dotenv

# Chargement des variables d'environnement
load_dotenv()

# Poids des différents critères dans le calcul d
# e compatibilité
WEIGHTS = {
    "competences": float(
        os.getenv("COMPETENCES_WEIGHT", 0.40)
    ),  # 40% pour les compétences
    "formation": float(
        os.getenv("FORMATION_WEIGHT", 0.20)
    ),  # 20% pour la formation/diplômes
    "experience": float(
        os.getenv("EXPERIENCE_WEIGHT", 0.20)
    ),  # 20% pour l'expérience professionnelle
    "langues": float(os.getenv("LANGUES_WEIGHT", 0.10)),  # 10% pour les langues
    "outils": float(os.getenv("OUTILS_WEIGHT", 0.10)),  # 10% pour les outils maîtrisés
}

# Seuils de compatibilité
COMPATIBILITY_THRESHOLDS = {
    "excellent": float(
        os.getenv("THRESHOLD_EXCELLENT", 0.85)
    ),  # Au-dessus de 85% = excellente compatibilité
    "good": float(
        os.getenv("THRESHOLD_GOOD", 0.70)
    ),  # Entre 70% et 85% = bonne compatibilité
    "moderate": float(
        os.getenv("THRESHOLD_MODERATE", 0.50)
    ),  # Entre 50% et 70% = compatibilité moyenne
    "low": float(
        os.getenv("THRESHOLD_LOW", 0.30)
    ),  # Entre 30% et 50% = faible compatibilité
    "poor": float(
        os.getenv("THRESHOLD_POOR", 0.0)
    ),  # En dessous de 30% = très faible compatibilité
}

# Configuration des messages selon le niveau de compatibilité
COMPATIBILITY_MESSAGES = {
    "excellent": "Votre profil correspond parfaitement à cette offre!",
    "good": "Votre profil correspond bien à cette offre.",
    "moderate": "Votre profil correspond partiellement à cette offre.",
    "low": "Votre profil correspond peu à cette offre.",
    "poor": "Votre profil ne correspond pas à cette offre.",
}

# Nombre maximum de points forts et points à améliorer à retourner
MAX_STRENGTHS = int(os.getenv("MAX_STRENGTHS", 5))
MAX_IMPROVEMENTS = int(os.getenv("MAX_IMPROVEMENTS", 5))

# Configuration de l'API
API_CONFIG = {
    "title": "API de Matching WorkFlexer",
    "description": "API pour analyser la compatibilité entre un profil candidat et une offre d'emploi",
    "version": os.getenv("API_VERSION", "2.0.0"),
    "docs_url": "/docs",
    "redoc_url": "/redoc",
}

# Seuil de similarité pour considérer deux compétences comme équivalentes
SIMILARITY_THRESHOLD = float(os.getenv("MODEL_SIMILARITY_THRESHOLD", 0.75))

# Configuration du logging
LOG_CONFIG = {
    "level": os.getenv("LOG_LEVEL", "INFO"),
    "format": "%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    "filename": os.getenv("LOG_FILE", "api_matching.log"),
}

# Configuration CORS
CORS_CONFIG = {
    "allow_origins": os.getenv("CORS_ALLOWED_ORIGINS", "*").split(","),
    "allow_credentials": True,
    "allow_methods": ["*"],
    "allow_headers": ["*"],
}

# Nouvelles configurations pour l'analyse avancée
ADVANCED_CONFIG = {
    # Seuils pour les niveaux d'adéquation
    "adequation_thresholds": {
        "excellent": float(os.getenv("ADEQUATION_EXCELLENT", 0.75)),
        "bon": float(os.getenv("ADEQUATION_BON", 0.50)),
        "moyen": float(os.getenv("ADEQUATION_MOYEN", 0.30)),
        "faible": float(os.getenv("ADEQUATION_FAIBLE", 0.0)),
    },
    
    # Poids par défaut pour l'analyse avancée
    "default_weights": {
        "formation": float(os.getenv("DEFAULT_FORMATION_WEIGHT", 0.25)),
        "experience": float(os.getenv("DEFAULT_EXPERIENCE_WEIGHT", 0.30)),
        "competences": float(os.getenv("DEFAULT_COMPETENCES_WEIGHT", 0.35)),
        "langues": float(os.getenv("DEFAULT_LANGUES_WEIGHT", 0.10)),
    },
    
    # Configuration des modèles NLP
    "nlp_models": {
        "embeddings": os.getenv("EMBEDDINGS_MODEL", "paraphrase-multilingual-MiniLM-L12-v2"),
        "spacy_model": os.getenv("SPACY_MODEL", "fr_core_news_md"),
    },
    
    # Limites pour les résultats
    "limits": {
        "max_strengths": int(os.getenv("MAX_STRENGTHS", 5)),
        "max_improvements": int(os.getenv("MAX_IMPROVEMENTS", 5)),
        "max_suggestions": int(os.getenv("MAX_SUGGESTIONS", 5)),
    },
    
    # Options d'analyse
    "options": {
        "semantic_analysis": os.getenv("ENABLE_SEMANTIC_ANALYSIS", "true").lower() == "true",
        "detailed_analysis": os.getenv("ENABLE_DETAILED_ANALYSIS", "true").lower() == "true",
        "learning_resources": os.getenv("INCLUDE_LEARNING_RESOURCES", "false").lower() == "true",
    },
}

# Configuration des ressources d'apprentissage
LEARNING_RESOURCES = {
    "competences": {
        "droit des contrats": [
            {
                "titre": "Formation en droit des contrats",
                "type": "cours",
                "url": "https://www.coursera.org/learn/contrats",
                "duree": "4 semaines",
                "niveau": "débutant",
            },
            {
                "titre": "Certification en droit des affaires",
                "type": "certification",
                "url": "https://www.example.com/certification-droit",
                "duree": "3 mois",
                "niveau": "intermédiaire",
            },
        ],
        "gestion des contrats": [
            {
                "titre": "Gestion de contrats commerciaux",
                "type": "cours",
                "url": "https://www.udemy.com/course/gestion-contrats",
                "duree": "6 heures",
                "niveau": "débutant",
            },
        ],
        "rest": [
            {
                "titre": "API REST Masterclass",
                "type": "cours",
                "url": "https://www.udemy.com/course/api-rest",
                "duree": "8 heures",
                "niveau": "intermédiaire",
            },
        ],
    },
    "secteurs": {
        "recrutement": [
            {
                "titre": "Techniques de recrutement modernes",
                "type": "cours",
                "url": "https://www.coursera.org/learn/recrutement",
                "duree": "3 semaines",
                "niveau": "débutant",
            },
        ],
        "intérim": [
            {
                "titre": "Gestion des missions d'intérim",
                "type": "cours",
                "url": "https://www.example.com/interim-management",
                "duree": "4 heures",
                "niveau": "débutant",
            },
        ],
    },
}
