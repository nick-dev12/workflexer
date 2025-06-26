"""
Modèles de données Pydantic spécifiquement adaptés 
pour les offres d'emploi provenant de la source "Dakar".
Ces modèles sont plus souples que les modèles principaux,
car les données sources sont moins structurées.
"""
from typing import List, Optional, Union
from pydantic import BaseModel, Field, validator

# Utilisation des modèles existants pour le profil candidat, qui reste inchangé
from models import CandidatProfile, MatchingResponseV2

# --- Modèles pour le PROFIL CANDIDAT (adaptés à la source de données PHP) ---

class FormationCandidatDakar(BaseModel):
    """Modèle flexible pour la formation du candidat."""
    diplome: Optional[str] = None
    etablissement: Optional[str] = None
    niveau: Optional[str] = None
    
    class Config:
        extra = "ignore"

class ExperienceCandidatDakar(BaseModel):
    """Modèle flexible pour l'expérience du candidat."""
    poste: Optional[str] = None
    description: Optional[str] = None
    duree: Optional[float] = None
    
    class Config:
        extra = "ignore"

class LangueCandidatDakar(BaseModel):
    """Modèle flexible pour la langue du candidat."""
    nom: str
    niveau: str # Accepte "Intermédiaire", "Débutant", etc.

class CandidatProfileDakar(BaseModel):
    """
    Modèle de données pour un profil candidat adapté à la structure
    envoyée par le script `CandidatProfile.php`.
    """
    id: int
    nom: Optional[str] = None
    email: Optional[str] = None
    telephone: Optional[str] = None
    titre: Optional[str] = None
    description: Optional[str] = None
    
    # Les compétences sont une simple liste de chaînes
    competences: List[str] = Field(default_factory=list)
    
    formations: List[FormationCandidatDakar] = Field(default_factory=list)
    experiences: List[ExperienceCandidatDakar] = Field(default_factory=list)
    langues: List[LangueCandidatDakar] = Field(default_factory=list)
    outils: List[str] = Field(default_factory=list)
    
    # Ce champ est construit en PHP et est crucial pour l'analyse
    texte_integral: Optional[str] = None
    
    class Config:
        extra = "ignore"


# --- Modèles pour l'OFFRE D'EMPLOI (source Dakar) ---

class ExigenceFormationDakar(BaseModel):
    """Exigence de formation simplifiée."""
    niveau_minimum: Optional[str] = "Non spécifié"

class ExigenceExperienceDakar(BaseModel):
    """Exigence d'expérience simplifiée."""
    duree_minimum_mois: Optional[int] = 0

class CompetenceDakar(BaseModel):
    """Compétence requise simplifiée."""
    nom: str
    niveau: Optional[int] = 3

class LangueDakar(BaseModel):
    """Langue requise simplifiée."""
    nom: str
    niveau: Optional[str] = "B2"

class JobOfferDakar(BaseModel):
    """
    Modèle de données pour une offre d'emploi de la source "Dakar".
    """
    id: int
    titre: str
    description: Optional[str] = ""
    secteur: Optional[str] = "Non spécifié"
    type_contrat: Optional[str] = "Non spécifié"
    localisation: Optional[str] = "Non spécifiée"
    texte_integral: str

    formation_requise: Optional[ExigenceFormationDakar] = Field(default_factory=ExigenceFormationDakar)
    experience_requise: Optional[ExigenceExperienceDakar] = Field(default_factory=ExigenceExperienceDakar)
    competences_requises: List[CompetenceDakar] = Field(default_factory=list)
    langues_requises: List[LangueDakar] = Field(default_factory=list)

    class Config:
        extra = "ignore" 