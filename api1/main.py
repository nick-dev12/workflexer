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

from api1.models import (
    MatchingRequest, 
    MatchingResponse, 
    MatchingResponseV2, 
    MatchingRequestV2,
    ContexteAnalyse
)
from api1.utils import analyze_compatibility, extract_keywords_from_description
import api1.config as config

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


@app.post("/extract-keywords", tags=["Utilitaires"])
async def extract_keywords(data: Dict[str, str]):
    """
    Extrait les mots-clés pertinents d'une description de poste.
    
    Args:
        data: Dictionnaire contenant la description du poste
        
    Returns:
        Liste des mots-clés extraits
    """
    try:
        if "description" not in data:
            raise HTTPException(
                status_code=400,
                detail="La description est requise",
            )
        
        keywords = extract_keywords_from_description(data["description"])
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
        "similarity_threshold": config.SIMILARITY_THRESHOLD,
        "version": config.API_CONFIG["version"],
    }


if __name__ == "__main__":
    import uvicorn

    # Récupération du port depuis les variables d'environnement ou utilisation de la valeur par défaut
    port = int(os.getenv("API_PORT", 8000))

    uvicorn.run(app, host="0.0.0.0", port=port)
