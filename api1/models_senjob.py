"""
Modèles de données Pydantic spécifiquement adaptés 
pour les offres d'emploi provenant de la source "Senjob".
"""
from typing import List, Optional
from pydantic import BaseModel, Field

# On réutilise le modèle de profil candidat car il est générique
# et adapté à la structure envoyée par CandidatProfile.php
from models_dakar import CandidatProfileDakar

class JobOfferSenjob(BaseModel):
    """
    Modèle de données pour une offre d'emploi de la source "Senjob".
    """
    id: int
    titre: str
    entreprise: Optional[str] = None
    localisation: Optional[str] = None
    type_contrat: Optional[str] = None
    description: Optional[str] = ""
    texte_integral: str

    class Config:
        extra = "ignore" 