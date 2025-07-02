"""
API FastAPI pour l'analyse de compatibilité entre profils et offres
"""

from fastapi import FastAPI, HTTPException, Request, status
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from fastapi.exceptions import RequestValidationError
import logging
from datetime import datetime
import time
import os
from dotenv import load_dotenv
from typing import Dict, Optional

from models import (
    MatchingRequest, 
    MatchingResponse, 
    MatchingResponseV2, 
    MatchingRequestV2,
    ContexteAnalyse,
    CandidatProfile
)
from utils import analyze_compatibility, normalize_text, analyze_compatibility_hybrid
import config

# Imports pour la nouvelle route Dakar
from models_dakar import JobOfferDakar, CandidatProfileDakar
from utils_dakar import analyze_compatibility_dakar

# Imports pour la nouvelle route Senjob
from models_senjob import JobOfferSenjob
from utils_senjob import analyze_compatibility_senjob
from pydantic import BaseModel

# --- Modèle de requête pour la route Dakar ---
class DakarMatchingRequest(BaseModel):
    candidate_data: CandidatProfileDakar
    job_offer_data: JobOfferDakar

# --- Modèle de requête pour la route Senjob ---
class SenjobMatchingRequest(BaseModel):
    candidate_data: CandidatProfileDakar
    job_offer_data: JobOfferSenjob


# Chargement des variables d'environnement
load_dotenv()

# Configuration du logging
logging.basicConfig(
    level=getattr(logging, config.LOG_CONFIG["level"]),
    format=config.LOG_CONFIG["format"],
    handlers=[
        logging.FileHandler(config.LOG_CONFIG["filename"]),
        logging.StreamHandler(),
    ],
)

# Réduire la verbosité du modèle sémantique
logging.getLogger("sentence_transformers").setLevel(logging.WARNING)

logger = logging.getLogger("api_matching")

# Configuration de l'API
app = FastAPI(
    title=config.API_CONFIG["title"],
    description=config.API_CONFIG["description"],
    version=config.API_CONFIG["version"],
    docs_url=config.API_CONFIG["docs_url"],
    redoc_url=config.API_CONFIG["redoc_url"],
)

# Configuration CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=config.CORS_CONFIG["allow_origins"],
    allow_credentials=config.CORS_CONFIG["allow_credentials"],
    allow_methods=config.CORS_CONFIG["allow_methods"],
    allow_headers=config.CORS_CONFIG["allow_headers"],
)

# Ajout du logging dans un fichier
log_directory = os.path.dirname(__file__)
log_file_path = os.path.join(log_directory, 'api_matching.log')

# S'assurer que le handler n'est pas ajouté plusieurs fois si le module est rechargé
api_logger = logging.getLogger('api_matching')
if not api_logger.handlers:
    handler = logging.FileHandler(log_file_path)
    formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
    handler.setFormatter(formatter)
    api_logger.addHandler(handler)
    api_logger.setLevel(logging.INFO)

# Gestionnaires d'erreurs personnalisés
@app.exception_handler(RequestValidationError)
async def validation_exception_handler(request: Request, exc: RequestValidationError):
    """Gestionnaire d'exceptions pour les erreurs de validation"""
    logger.error(f"Erreur de validation: {exc}")
    return JSONResponse(
        status_code=status.HTTP_422_UNPROCESSABLE_ENTITY,
        content={"detail": exc.errors(), "message": "Erreur de validation des données"},
    )


@app.exception_handler(Exception)
async def general_exception_handler(request: Request, exc: Exception):
    """Gestionnaire pour les exceptions générales"""
    logger.error(f"Exception non gérée: {str(exc)}", exc_info=True)
    return JSONResponse(
        status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
        content={"detail": str(exc), "message": "Erreur interne du serveur"},
    )


@app.get("/", tags=["Général"])
async def root():
    """Point d'entrée de l'API"""
    return {
        "message": f"WorkFlexer Matching API {config.API_CONFIG['version']}",
        "status": "active",
        "timestamp": datetime.now().isoformat(),
    }


@app.post("/analyze", response_model=Dict, tags=["Analyse"])
async def analyze(request: MatchingRequest):
    """
    Analyse la compatibilité entre un profil candidat et une offre d'emploi.
    
    Args:
        request: Les données du candidat et de l'offre d'emploi
        
    Returns:
        Un rapport d'analyse détaillé
    """
    try:
        logger.info(f"Analyse demandée pour le candidat {request.candidate.id} et l'offre {request.job_offer.id}")
        
        # Analyse de compatibilité
        result = analyze_compatibility(
            request.candidate.dict(exclude_none=True),
            request.job_offer.dict(exclude_none=True),
        )
        
        logger.info(f"Analyse terminée avec un score global de {result.get('global_score', 0)}")
        return result
        
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'analyse: {str(e)}",
        )


@app.post("/analyze/v2", response_model=MatchingResponseV2, tags=["Analyse"])
async def analyze_v2(request: MatchingRequest):
    """
    Analyse la compatibilité entre un profil candidat et une offre d'emploi (version 2).
    Cette version retourne une structure de réponse améliorée avec une meilleure organisation
    des points forts, points d'amélioration et suggestions.
    
    Args:
        request: Les données du candidat et de l'offre d'emploi
        
    Returns:
        Un rapport d'analyse détaillé avec une structure améliorée
    """
    try:
        logger.info(f"Analyse V2 demandée pour le candidat {request.candidate.id} et l'offre {request.job_offer.id}")
        
        # Analyse de compatibilité
        result = analyze_compatibility(
            request.candidate.dict(exclude_none=True),
            request.job_offer.dict(exclude_none=True),
        )
        
        logger.info(f"Analyse V2 terminée avec un score global de {result.get('score_global', 0)}")
        return result
    
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse V2: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'analyse: {str(e)}",
        )


@app.post("/analyze/v3", response_model=MatchingResponseV2, tags=["Analyse Avancée"])
async def analyze_v3(request: MatchingRequestV2):
    """
    Analyse avancée de compatibilité avec options personnalisables.
    Cette version permet de configurer les poids des différents critères et d'activer
    des fonctionnalités avancées d'analyse.
    
    Args:
        request: Les données du candidat, de l'offre d'emploi et les options d'analyse
        
    Returns:
        Un rapport d'analyse détaillé avec une structure améliorée et des informations supplémentaires
    """
    try:
        start_time = time.time()
        logger.info(f"Analyse V3 demandée pour le candidat {request.candidate.id} et l'offre {request.job_offer.id}")
        logger.info(f"Options d'analyse: {request.options.dict() if request.options else 'options par défaut'}")
        
        # Préparation des options d'analyse
        options = request.options.dict() if request.options else {}
        
        # Analyse de compatibilité avec options avancées
        result = analyze_compatibility(
            request.candidate.dict(exclude_none=True),
            request.job_offer.dict(exclude_none=True),
            options=options
        )
        
        # Ajout du temps d'analyse
        end_time = time.time()
        analysis_time_ms = int((end_time - start_time) * 1000)
        
        if isinstance(result.get("contexte_analyse"), dict):
            result["contexte_analyse"]["temps_analyse_ms"] = analysis_time_ms
        else:
            # Si contexte_analyse est un objet ContexteAnalyse
            if "contexte_analyse" in result:
                result["contexte_analyse"].temps_analyse_ms = analysis_time_ms
        
        logger.info(f"Analyse V3 terminée avec un score global de {result.get('score_global', 0)} en {analysis_time_ms}ms")
        return result
    
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse V3: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'analyse avancée: {str(e)}",
        )


@app.post("/analyze/hybrid-v2", response_model=Dict, tags=["Analyse Hybride"])
async def analyze_hybrid_v2(request: MatchingRequest):
    """
    Endpoint pour l'analyse de compatibilité V2 avec une approche hybride avancée.
    Retourne un dictionnaire JSON avec les résultats détaillés.
    """
    try:
        candidate_data = request.candidate.dict(exclude_none=True)
        job_offer_data = request.job_offer.dict(exclude_none=True)

        # Logging de la requête
        api_logger.info(f"Analyse Hybride V2 demandée pour le candidat {candidate_data.get('id')} et l'offre {job_offer_data.get('id')}")
        api_logger.debug(f"Données candidat reçues: {candidate_data}")
        api_logger.debug(f"Données offre reçues: {job_offer_data}")

        # Appel à la fonction d'analyse hybride
        result = analyze_compatibility_hybrid(candidate_data, job_offer_data)
        
        return result

    except Exception as e:
        api_logger.error(f"Erreur lors de l'analyse hybride V2: {str(e)}", exc_info=True)
        raise HTTPException(status_code=500, detail=str(e))


@app.post("/extract-keywords", tags=["Utilitaires"])
async def extract_keywords(data: Dict[str, str]):
    """
    Normalise et extrait les lemmes pertinents d'une description de poste.
    
    Args:
        data: Dictionnaire contenant la description du poste
        
    Returns:
        Liste des lemmes normalisés
    """
    try:
        if "description" not in data:
            raise HTTPException(
                status_code=400,
                detail="La description est requise",
            )
        
        keywords = normalize_text(data["description"])
        return {"keywords": keywords}
    
    except Exception as e:
        logger.error(f"Erreur lors de l'extraction des mots-clés: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'extraction des mots-clés: {str(e)}",
        )


@app.get("/health", tags=["Monitoring"])
async def health_check():
    """Vérifie l'état de santé de l'API"""
    return {
        "status": "healthy",
        "timestamp": datetime.now().isoformat(),
        "version": config.API_CONFIG["version"],
    }


@app.get("/config", tags=["Configuration"])
async def get_config():
    """Retourne la configuration actuelle de l'API"""
    return {
        "weights": config.WEIGHTS,
        "thresholds": config.COMPATIBILITY_THRESHOLDS,
        "similarity_thresholds": config.SIMILARITY_THRESHOLDS,
        "version": config.API_CONFIG["version"],
        "database": {
            "host": os.getenv("DB_HOST"),
            "port": os.getenv("DB_PORT"),
            "user": os.getenv("DB_USER"),
            "name": os.getenv("DB_NAME"),
        }
    }


# --- Nouvelle route pour les offres Dakar ---
@app.post("/analyze_dakar", response_model=Dict, tags=["Analyse Dakar"])
async def analyze_dakar(request: DakarMatchingRequest):
    """
    Analyse la compatibilité entre un profil candidat et une offre d'emploi Dakar.
    """
    try:
        logger.info(f"Analyse Dakar demandée pour le candidat {request.candidate_data.id} et l'offre {request.job_offer_data.id}")
        
        # Appel de la fonction d'analyse spécifique à Dakar
        result = analyze_compatibility_dakar(
            request.candidate_data.model_dump(exclude_none=True), # Utiliser model_dump() pour pydantic v2
            request.job_offer_data.model_dump(exclude_none=True),
        )
        
        logger.info(f"Analyse Dakar terminée avec un score global de {result.get('score_global', 0)}")
        return result
        
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse Dakar: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'analyse Dakar: {str(e)}",
        )


@app.post("/analyze_senjob", response_model=Dict, tags=["Analyse Senjob"])
async def analyze_senjob(request: SenjobMatchingRequest):
    """
    Analyse la compatibilité entre un profil candidat et une offre d'emploi Senjob.
    """
    try:
        logger.info(f"Analyse Senjob demandée pour le candidat {request.candidate_data.id} et l'offre {request.job_offer_data.id}")
        
        # Appel de la fonction d'analyse spécifique à Senjob
        result = analyze_compatibility_senjob(
            request.candidate_data.model_dump(exclude_none=True),
            request.job_offer_data.model_dump(exclude_none=True),
        )
        
        logger.info(f"Analyse Senjob terminée avec un score global de {result.get('score_global', 0)}")
        return result
        
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse Senjob: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'analyse Senjob: {str(e)}",
        )


if __name__ == "__main__":
    import uvicorn

    # Récupération du port depuis les variables d'environnement ou utilisation de la valeur par défaut
    port = int(os.getenv("API_PORT", 8000))

    uvicorn.run(app, host="0.0.0.0", port=port)
