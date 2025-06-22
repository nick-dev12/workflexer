"""
API FastAPI pour l'analyse de compatibilité entre profils et offres
"""
from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
import logging
from datetime import datetime
from typing import Dict, Optional

from models import MatchingRequest, MatchingResponse
from utils import analyze_compatibility, extract_keywords_from_description

# Configuration du logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('api_matching.log'),
        logging.StreamHandler()
    ]
)

# Réduire la verbosité du modèle sémantique
logging.getLogger("sentence_transformers").setLevel(logging.WARNING)

logger = logging.getLogger('api_matching')

app = FastAPI(
    title="WorkFlexer Matching API",
    description="API d'analyse de compatibilité entre profils de candidats et offres d'emploi",
    version="2.0.0"
)

# Configuration CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
async def root():
    """Point d'entrée de l'API"""
    return {
        "message": "WorkFlexer Matching API v2.0.0",
        "status": "active",
        "timestamp": datetime.now().isoformat()
    }

@app.post("/analyser", response_model=MatchingResponse)
async def analyser_compatibilite(request: MatchingRequest):
    """
    Analyse la compatibilité entre un profil de candidat et une offre d'emploi.
    
    Args:
        request (MatchingRequest): Les données du candidat et de l'offre à analyser
        
    Returns:
        MatchingResponse: Résultat détaillé de l'analyse de compatibilité
    """
    try:
        logger.info(f"Analyse demandée pour candidat ID: {request.candidate.id} et offre ID: {request.job_offer.id}")
        
        # Enrichissement des données
        if request.job_offer.description:
            keywords = extract_keywords_from_description(request.job_offer.description)
            if not request.job_offer.experience_requise.mots_cles_poste:
                request.job_offer.experience_requise.mots_cles_poste = []
            request.job_offer.experience_requise.mots_cles_poste.extend(keywords)
        
        # Analyse de compatibilité
        results = analyze_compatibility(
            request.candidate.dict(exclude_none=True),
            request.job_offer.dict(exclude_none=True)
        )
        
        # Enrichissement des résultats avec le contexte
        completion_score = results.get("completion", {}).get("score", 0.0)
        
        results["contexte_analyse"] = {
            "timestamp": datetime.now().isoformat(),
            "version_api": "2.0.0",
            "niveau_confiance": "haute" if completion_score > 0.8 else "moyenne"
        }
        
        return MatchingResponse(**results)
        
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse: {str(e)}", exc_info=True)
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'analyse de compatibilité: {str(e)}"
        )

@app.get("/health")
async def health_check():
    """Vérifie l'état de santé de l'API"""
    return {
        "status": "healthy",
        "timestamp": datetime.now().isoformat(),
        "version": "2.0.0"
    }

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000) 