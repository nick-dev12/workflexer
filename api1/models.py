"""
Modèles de données pour l'API de matching
"""
from typing import List, Optional, Dict, Union
from pydantic import BaseModel, Field, validator
from datetime import datetime


class Formation(BaseModel):
    niveau: str
    domaine: str
    etablissement: Optional[str] = None
    annee_obtention: Optional[int] = None
    description: Optional[str] = None
    date_debut: Optional[str] = None
    date_fin: Optional[str] = None
    en_cours: bool = False
    type_formation: Optional[str] = None
    mentions: List[str] = Field(default_factory=list)
    
    @validator('annee_obtention')
    def validate_annee(cls, v):
        if v and v > datetime.now().year:
            raise ValueError("L'année d'obtention ne peut pas être dans le futur")
        return v


class Experience(BaseModel):
    titre_poste: str
    entreprise: Optional[str] = None
    duree_mois: int = 0
    description: str = ""
    competences: List[str] = Field(default_factory=list)
    secteur: Optional[str] = None
    date_debut: Optional[str] = None
    date_fin: Optional[str] = None
    en_cours: bool = False
    type_contrat: Optional[str] = None
    realisations: List[str] = Field(default_factory=list)
    technologies: List[str] = Field(default_factory=list)
    responsabilites: List[str] = Field(default_factory=list)
    
    @validator('duree_mois')
    def validate_duree(cls, v):
        if v < 0:
            raise ValueError("La durée ne peut pas être négative")
        return v


class Competence(BaseModel):
    nom: str
    niveau: int = Field(ge=1, le=5, default=1)
    annees_experience: float = 0.0
    certifications: List[str] = Field(default_factory=list)
    derniere_utilisation: Optional[str] = None
    contexte_utilisation: List[str] = Field(default_factory=list)
    type_competence: str = "Technique"
    projets_associes: List[str] = Field(default_factory=list)
    
    @validator('niveau')
    def validate_niveau(cls, v):
        if not 1 <= v <= 5:
            raise ValueError("Le niveau doit être entre 1 et 5")
        return v


class Langue(BaseModel):
    nom: str
    niveau: str = "A1"
    certifications: List[str] = Field(default_factory=list)
    date_certification: Optional[str] = None
    contexte_utilisation: List[str] = Field(default_factory=list)
    sejours_linguistiques: List[Dict[str, str]] = Field(default_factory=list)
    
    @validator('niveau')
    def validate_niveau(cls, v):
        niveaux_valides = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2']
        if v not in niveaux_valides:
            raise ValueError(f"Le niveau doit être l'un des suivants : {', '.join(niveaux_valides)}")
        return v


class ProjetPersonnel(BaseModel):
    titre: str
    description: str = ""
    technologies: List[str] = Field(default_factory=list)
    date_debut: Optional[str] = None
    date_fin: Optional[str] = None
    en_cours: bool = False
    url: Optional[str] = None
    images: List[str] = Field(default_factory=list)
    competences_developpees: List[str] = Field(default_factory=list)


class CandidatProfile(BaseModel):
    id: int
    formations: List[Formation] = Field(default_factory=list)
    experiences: List[Experience] = Field(default_factory=list)
    competences: List[Competence] = Field(default_factory=list)
    langues: List[Langue] = Field(default_factory=list)
    centres_interet: List[str] = Field(default_factory=list)
    projets: List[ProjetPersonnel] = Field(default_factory=list)
    disponibilite: Optional[str] = None
    mobilite: Dict[str, Union[bool, List[str]]] = Field(default_factory=dict)
    preferences_travail: Dict[str, Union[bool, str, List[str]]] = Field(default_factory=dict)
    portfolio: Dict[str, str] = Field(default_factory=dict)
    certifications: List[Dict[str, str]] = Field(default_factory=list)
    profil_linkedin: Optional[str] = None
    github_username: Optional[str] = None
    niveau_etude: Optional[str] = None
    niveau_experience: Optional[str] = None


class ExigenceFormation(BaseModel):
    niveau_minimum: str = "Non spécifié"
    domaines_acceptes: List[str] = Field(default_factory=list)
    formation_obligatoire: bool = False
    formations_alternatives: List[str] = Field(default_factory=list)
    equivalences_acceptees: List[str] = Field(default_factory=list)
    specialisations_preferees: List[str] = Field(default_factory=list)


class ExigenceExperience(BaseModel):
    duree_minimum_mois: int = 0
    secteurs_acceptes: List[str] = Field(default_factory=list)
    competences_requises: List[str] = Field(default_factory=list)
    mots_cles_poste: List[str] = Field(default_factory=list)
    niveaux_responsabilite: List[str] = Field(default_factory=list)
    contextes_valorises: List[str] = Field(default_factory=list)
    type_experience: List[str] = Field(default_factory=list)


class JobOffer(BaseModel):
    id: int
    titre: str
    description: str = ""
    formation_requise: ExigenceFormation = Field(default_factory=ExigenceFormation)
    experience_requise: ExigenceExperience = Field(default_factory=ExigenceExperience)
    competences_requises: List[Competence] = Field(default_factory=list)
    langues_requises: List[Langue] = Field(default_factory=list)
    secteur: str
    type_contrat: str
    localisation: str
    salaire_min: Optional[float] = None
    salaire_max: Optional[float] = None
    avantages: List[str] = Field(default_factory=list)
    teletravail: bool = False
    horaires_flexibles: bool = False
    deplacement_requis: bool = False
    competences_bonus: List[Competence] = Field(default_factory=list)
    environnement_technique: Dict[str, List[str]] = Field(default_factory=dict)
    methodologie: List[str] = Field(default_factory=list)
    taille_equipe: Optional[int] = None


class CompetenceAnalysis(BaseModel):
    score: float
    niveau_actuel: int
    niveau_requis: int
    experience_pertinente: List[str] = Field(default_factory=list)
    projets_pertinents: List[str] = Field(default_factory=list)
    certifications_pertinentes: List[str] = Field(default_factory=list)
    suggestions_amelioration: List[str] = Field(default_factory=list)


class DetailedScore(BaseModel):
    score: float
    details: List[str] = Field(default_factory=list)
    points_forts: List[str] = Field(default_factory=list)
    points_faibles: List[str] = Field(default_factory=list)
    recommandations: List[str] = Field(default_factory=list)
    analyse_detaillee: Optional[Dict[str, Union[float, str, List[str]]]] = None


class ReportSection(BaseModel):
    titre: str
    score: float
    points_forts: List[str] = Field(default_factory=list)
    points_faibles: List[str] = Field(default_factory=list)


class MatchingScore(BaseModel):
    formation: DetailedScore
    experience: DetailedScore
    competences: DetailedScore
    langues: DetailedScore
    global_score: float
    profil_completion: Dict[str, Dict[str, Union[float, Dict[str, Union[int, float]]]]]
    lacunes_critiques: List[Dict[str, str]] = Field(default_factory=list)
    atouts_majeurs: List[Dict[str, str]] = Field(default_factory=list)
    suggestions_amelioration: List[Dict[str, str]] = Field(default_factory=list)
    analyse_competences: Dict[str, CompetenceAnalysis] = Field(default_factory=dict)
    compatibilite_culture: Optional[float] = None
    compatibilite_technique: Optional[float] = None


class MatchingRequest(BaseModel):
    candidate: CandidatProfile
    job_offer: JobOffer
    options: Dict[str, bool] = Field(default_factory=dict)


class ProfileCompletionDetails(BaseModel):
    formations: float
    experiences: float
    competences: float
    langues: float


class ProfileCompletionScore(BaseModel):
    score: float
    details: ProfileCompletionDetails


class MatchingResponse(BaseModel):
    global_score: float
    completion: ProfileCompletionScore
    analyses: Dict[str, ReportSection]
    synthesis: str
    adequation_globale: str
    contexte_analyse: Dict[str, Union[str, float, bool]] = Field(
        default_factory=lambda: {
            "timestamp": datetime.now().isoformat(),
            "version_api": "2.0.0",
            "niveau_confiance": "haute"
        }
    ) 