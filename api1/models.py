"""
Modèles de données pour l'API de matching avancée avec approche hybride
"""
from typing import List, Optional, Dict, Union, Any, Set
from pydantic import BaseModel, Field, validator
from datetime import datetime
import numpy as np


# === NOUVEAUX MODÈLES POUR L'APPROCHE HYBRIDE ===

class ExtractedEntity(BaseModel):
    """Entité extraite par SpaCy"""
    text: str
    label: str  # PERSON, ORG, TECH, SKILL, etc.
    start: int
    end: int
    confidence: float = 1.0


class SectionEmbedding(BaseModel):
    """Embedding d'une section spécifique"""
    section_name: str  # "competences", "experience", "formation", etc.
    text: str
    embedding: List[float] = Field(default_factory=list)
    entities: List[ExtractedEntity] = Field(default_factory=list)
    keywords: List[str] = Field(default_factory=list)
    normalized_terms: Dict[str, str] = Field(default_factory=dict)  # "JS" -> "JavaScript"


class SemanticSimilarity(BaseModel):
    """Résultat de comparaison sémantique"""
    score: float = Field(ge=0.0, le=1.0)
    matched_terms: List[Dict[str, str]] = Field(default_factory=list)  # [{"candidate": "Python", "offer": "Python"}]
    missing_terms: List[str] = Field(default_factory=list)
    extra_terms: List[str] = Field(default_factory=list)
    semantic_matches: List[Dict[str, Union[str, float]]] = Field(default_factory=list)  # Matches sémantiques avec scores


class AdvancedCompetenceAnalysis(BaseModel):
    """Analyse avancée des compétences avec recherche sémantique"""
    exact_matches: List[str] = Field(default_factory=list)
    semantic_matches: List[Dict[str, Any]] = Field(default_factory=list)
    missing_critical: List[str] = Field(default_factory=list)
    missing_optional: List[str] = Field(default_factory=list)
    technology_clusters: Dict[str, List[str]] = Field(default_factory=dict)  # "Frontend": ["React", "Vue"], etc.
    skill_levels: Dict[str, Dict[str, Union[int, str]]] = Field(default_factory=dict)
    similarity_matrix: Dict[str, Dict[str, float]] = Field(default_factory=dict)


class HybridAnalysisResult(BaseModel):
    """Résultat de l'analyse hybride niveau 1 (global) + niveau 2 (granulaire)"""
    global_similarity: float
    global_embedding_score: float
    section_similarities: Dict[str, SemanticSimilarity] = Field(default_factory=dict)
    competence_analysis: AdvancedCompetenceAnalysis = Field(default_factory=AdvancedCompetenceAnalysis)
    entity_matches: Dict[str, List[ExtractedEntity]] = Field(default_factory=dict)
    keyword_density: Dict[str, float] = Field(default_factory=dict)
    contextual_relevance: float = 0.0


# === MODÈLES ENRICHIS EXISTANTS ===

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
    
    # Nouveaux champs pour l'approche hybride
    extracted_entities: List[ExtractedEntity] = Field(default_factory=list)
    embedding: List[float] = Field(default_factory=list)
    normalized_domain: Optional[str] = None
    relevance_keywords: List[str] = Field(default_factory=list)
    
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
    
    # Nouveaux champs pour l'approche hybride
    extracted_entities: List[ExtractedEntity] = Field(default_factory=list)
    embedding: List[float] = Field(default_factory=list)
    normalized_title: Optional[str] = None
    technical_keywords: List[str] = Field(default_factory=list)
    soft_skills: List[str] = Field(default_factory=list)
    industry_relevance: float = 0.0
    
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
    
    # Nouveaux champs pour l'approche hybride
    normalized_name: Optional[str] = None
    synonyms: List[str] = Field(default_factory=list)
    category: Optional[str] = None  # "Programming", "Framework", "Database", etc.
    embedding: List[float] = Field(default_factory=list)
    market_demand: float = 0.0  # Score de demande sur le marché
    learning_resources: List[Dict[str, str]] = Field(default_factory=list)
    
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
    
    # Nouveaux champs pour l'approche hybride
    normalized_name: Optional[str] = None
    native_level: bool = False
    professional_context: bool = False
    
    @validator('niveau')
    def validate_niveau(cls, v):
        niveaux_valides = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2']
        if v not in niveaux_valides:
            raise ValueError(f"Le niveau doit être l'un des suivants : {', '.join(niveaux_valides)}")
        return v


class ProjetPersonnel(BaseModel):
    id: Optional[int] = None
    users_id: Optional[int] = None
    titre: str
    liens: Optional[str] = None
    description: str = ""
    images: Optional[str] = None
    date: Optional[str] = None
    technologies: List[str] = Field(default_factory=list)
    date_debut: Optional[str] = None
    date_fin: Optional[str] = None
    en_cours: bool = False
    url: Optional[str] = None
    competences_developpees: List[str] = Field(default_factory=list)
    
    # Nouveaux champs pour l'approche hybride
    extracted_entities: List[ExtractedEntity] = Field(default_factory=list)
    embedding: List[float] = Field(default_factory=list)
    normalized_technologies: List[str] = Field(default_factory=list)
    complexity_score: float = 0.0
    relevance_to_offer: float = 0.0


class CandidatProfile(BaseModel):
    id: int
    # Informations de base de l'utilisateur (table users)
    nom: str
    email: str = ""
    telephone: str = ""
    ville: Optional[str] = None
    domaine_competence: Optional[str] = None  # Correspond à 'competences' dans la table users
    profession: Optional[str] = None
    categorie: Optional[str] = None
    images: Optional[str] = None
    statut: Optional[str] = None
    verification: Optional[str] = None
    verification_statut: Optional[str] = None
    date_inscription: Optional[str] = None
    
    # Description du profil (table description_users)
    description: Optional[str] = None  # Description "à propos de moi" du CV
    
    # Données de formation et expérience
    formations: List[Formation] = Field(default_factory=list)
    experiences: List[Experience] = Field(default_factory=list)
    competences: List[Competence] = Field(default_factory=list)
    langues: List[Langue] = Field(default_factory=list)
    centres_interet: List[str] = Field(default_factory=list)
    
    # Projets personnels (table projet_users)
    projets: List[ProjetPersonnel] = Field(default_factory=list)
    
    # Autres informations
    disponibilite: Optional[str] = None
    mobilite: Dict[str, Union[bool, List[str]]] = Field(default_factory=dict)
    preferences_travail: Dict[str, Union[bool, str, List[str]]] = Field(default_factory=dict)
    portfolio: Dict[str, str] = Field(default_factory=dict)
    certifications: List[Dict[str, str]] = Field(default_factory=list)
    profil_linkedin: Optional[str] = None
    github_username: Optional[str] = None
    niveau_etude: Optional[str] = None
    niveau_experience: Optional[str] = None
    niveau_etude_valeur: Optional[int] = None
    niveau_experience_valeur: Optional[int]= None
    texte_integral: Optional[str] = None
    outils: List[str] = []
    
    # === NOUVEAUX CHAMPS POUR L'APPROCHE HYBRIDE ===
    section_embeddings: Dict[str, SectionEmbedding] = Field(default_factory=dict)
    global_embedding: List[float] = Field(default_factory=list)
    extracted_entities: List[ExtractedEntity] = Field(default_factory=list)
    skill_clusters: Dict[str, List[str]] = Field(default_factory=dict)
    career_progression: List[Dict[str, Any]] = Field(default_factory=list)
    profile_completeness: Dict[str, float] = Field(default_factory=dict)


class ExigenceFormation(BaseModel):
    niveau_minimum: str = "Non spécifié"
    niveau_valeur: int = 0
    domaines_acceptes: List[str] = Field(default_factory=list)
    formation_obligatoire: bool = False
    formations_alternatives: List[str] = Field(default_factory=list)
    equivalences_acceptees: List[str] = Field(default_factory=list)
    specialisations_preferees: List[str] = Field(default_factory=list)
    
    # Nouveaux champs pour l'approche hybride
    embedding: List[float] = Field(default_factory=list)
    normalized_domains: List[str] = Field(default_factory=list)
    flexibility_score: float = 0.0


class ExigenceExperience(BaseModel):
    niveau: str = "Non spécifié"
    duree_minimum_mois: int = 0
    secteurs_acceptes: List[str] = Field(default_factory=list)
    competences_requises: List[str] = Field(default_factory=list)
    mots_cles_poste: List[str] = Field(default_factory=list)
    niveaux_responsabilite: List[str] = Field(default_factory=list)
    contextes_valorises: List[str] = Field(default_factory=list)
    type_experience: List[str] = Field(default_factory=list)
    
    # Nouveaux champs pour l'approche hybride
    embedding: List[float] = Field(default_factory=list)
    extracted_entities: List[ExtractedEntity] = Field(default_factory=list)
    seniority_indicators: List[str] = Field(default_factory=list)
    flexibility_score: float = 0.0


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
    texte_integral: Optional[str] = None
    
    # === NOUVEAUX CHAMPS POUR L'APPROCHE HYBRIDE ===
    section_embeddings: Dict[str, SectionEmbedding] = Field(default_factory=dict)
    global_embedding: List[float] = Field(default_factory=list)
    extracted_entities: List[ExtractedEntity] = Field(default_factory=list)
    critical_skills: List[str] = Field(default_factory=list)  # Compétences critiques identifiées automatiquement
    nice_to_have_skills: List[str] = Field(default_factory=list)  # Compétences bonus
    company_culture_keywords: List[str] = Field(default_factory=list)
    urgency_indicators: List[str] = Field(default_factory=list)
    market_competitiveness: float = 0.0


# === MODÈLES D'ANALYSE AVANCÉE ===

class EntityMatchResult(BaseModel):
    """Résultat de correspondance d'entités entre candidat et offre"""
    entity_type: str  # SKILL, TECH, ORG, etc.
    candidate_entities: List[ExtractedEntity] = Field(default_factory=list)
    offer_entities: List[ExtractedEntity] = Field(default_factory=list)
    matches: List[Dict[str, Any]] = Field(default_factory=list)
    missing_in_candidate: List[ExtractedEntity] = Field(default_factory=list)
    similarity_scores: Dict[str, float] = Field(default_factory=dict)


class SkillGapAnalysis(BaseModel):
    """Analyse des lacunes de compétences"""
    missing_critical_skills: List[Dict[str, Any]] = Field(default_factory=list)
    missing_nice_to_have: List[Dict[str, Any]] = Field(default_factory=list)
    transferable_skills: List[Dict[str, Any]] = Field(default_factory=list)
    learning_path: List[Dict[str, Any]] = Field(default_factory=list)
    estimated_learning_time: Dict[str, str] = Field(default_factory=dict)
    market_resources: List[Dict[str, str]] = Field(default_factory=list)


class CareerProgressionAnalysis(BaseModel):
    """Analyse de progression de carrière"""
    current_level: str
    target_level: str
    progression_feasibility: float
    required_experience_gap: int  # en mois
    skill_progression_needed: List[Dict[str, Any]] = Field(default_factory=list)
    typical_career_path: List[str] = Field(default_factory=list)


class IndustryRelevanceAnalysis(BaseModel):
    """Analyse de pertinence sectorielle"""
    sector_match_score: float
    industry_keywords_match: Dict[str, float] = Field(default_factory=dict)
    cross_industry_transferability: float
    sector_specific_gaps: List[str] = Field(default_factory=list)
    emerging_trends_alignment: float


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


# Nouveaux modèles pour une meilleure structuration des résultats

class PointFort(BaseModel):
    """Représente un point fort du candidat par rapport à l'offre"""
    description: str
    categorie: str  # formation, experience, competence, langue
    importance: str = "normal"  # critique, important, normal
    details: Optional[str] = None
    impact_score: Optional[float] = None  # Impact sur le score global (0-1)


class PointAmelioration(BaseModel):
    """Représente un point à améliorer pour le candidat"""
    description: str
    categorie: str  # formation, experience, competence, langue
    priorite: str = "normale"  # haute, moyenne, normale
    suggestion: Optional[str] = None
    impact_potentiel: Optional[float] = None  # Impact potentiel sur le score (0-1)
    ressources: Optional[List[Dict[str, str]]] = None  # Ressources pour s'améliorer


class CorrespondanceItem(BaseModel):
    """Élément de correspondance entre le profil et l'offre"""
    element_profil: str
    element_offre: str
    niveau_correspondance: float  # 0 à 1
    categorie: str  # formation, experience, competence, langue
    details_correspondance: Optional[str] = None
    similarite_semantique: Optional[float] = None  # Pour les correspondances sémantiques


class ElementManquant(BaseModel):
    """Élément requis par l'offre mais absent du profil"""
    description: str
    categorie: str
    importance: str = "normale"  # critique, importante, normale
    suggestion_acquisition: Optional[str] = None
    impact_sur_score: Optional[float] = None  # Impact sur le score global (0-1)
    difficulte_acquisition: Optional[str] = None  # facile, modérée, difficile


class AnalyseCategorielle(BaseModel):
    """Analyse détaillée d'une catégorie (formation, expérience, etc.)"""
    categorie: str
    score: float
    elements_correspondants: List[CorrespondanceItem] = Field(default_factory=list)
    elements_manquants: List[ElementManquant] = Field(default_factory=list)
    points_forts: List[str] = Field(default_factory=list)
    points_amelioration: List[str] = Field(default_factory=list)
    resume: str = ""
    poids_dans_score_global: Optional[float] = None  # Poids de cette catégorie (0-1)
    details_techniques: Optional[Dict[str, Any]] = None  # Détails techniques supplémentaires


class AnalyseDetaillee(BaseModel):
    """Analyse détaillée de la compatibilité"""
    formation: AnalyseCategorielle
    experience: AnalyseCategorielle
    competences: AnalyseCategorielle
    langues: AnalyseCategorielle
    facteurs_bonus: Optional[Dict[str, float]] = None  # Facteurs bonus (ex: mobilité)
    facteurs_malus: Optional[Dict[str, float]] = None  # Facteurs malus (ex: disponibilité)


class Suggestion(BaseModel):
    """Suggestion d'amélioration pour le candidat"""
    categorie: str
    description: str
    priorite: str = "normale"  # haute, moyenne, normale
    impact_estime: str = "moyen"  # fort, moyen, faible
    ressources_recommandees: Optional[List[Dict[str, str]]] = None
    temps_acquisition_estime: Optional[str] = None  # court, moyen, long terme
    cout_acquisition_estime: Optional[str] = None  # faible, modéré, élevé


class ContexteAnalyse(BaseModel):
    """Contexte de l'analyse effectuée"""
    timestamp: str = Field(default_factory=lambda: datetime.now().isoformat())
    version_api: str = "2.0.0"
    niveau_confiance: str = "haute"
    modeles_utilises: Optional[Dict[str, str]] = None  # Modèles NLP utilisés
    parametres_analyse: Optional[Dict[str, Any]] = None  # Paramètres utilisés
    temps_analyse_ms: Optional[int] = None  # Temps d'analyse en millisecondes
    source_donnees: Optional[str] = None  # Source des données analysées


class CompetenceTrouvee(BaseModel):
    """Compétence du candidat trouvée dans l'offre"""
    competence: str
    type_correspondance: str  # exact, normalized, semantic
    confiance: int  # Pourcentage de confiance (0-100)


class MatchingResponseSimple(BaseModel):
    """Version simplifiée du modèle de réponse pour l'API"""
    score_global: float
    resume: str
    competences_message: str
    competences_trouvees: List[CompetenceTrouvee] = Field(default_factory=list)
    nombre_competences_trouvees: int = 0
    contexte_analyse: Dict[str, Any] = Field(default_factory=dict)
    
    class Config:
        schema_extra = {
            "example": {
                "score_global": 65.0,
                "resume": "Bonne compatibilité (65%) - Votre profil présente de bons atouts pour ce poste.",
                "competences_message": "5 de vos compétences correspondent à cette offre d'emploi.",
                "competences_trouvees": [
                    {
                        "competence": "Communication",
                        "type_correspondance": "exact",
                        "confiance": 100
                    },
                    {
                        "competence": "Gestion",
                        "type_correspondance": "normalized",
                        "confiance": 90
                    }
                ],
                "nombre_competences_trouvees": 2
            }
        }


class MatchingResponseV2(BaseModel):
    """Nouvelle version du modèle de réponse pour l'API"""
    score_global: float
    score_global_semantique: Optional[float] = None
    niveau_adequation: str  # Excellent, Bon, Moyen, À améliorer
    resume: str
    points_forts: List[PointFort] = Field(default_factory=list)
    points_amelioration: List[PointAmelioration] = Field(default_factory=list)
    analyse_detaillee: AnalyseDetaillee
    suggestions: List[Suggestion] = Field(default_factory=list)
    contexte_analyse: ContexteAnalyse = Field(default_factory=ContexteAnalyse)
    competences_manquantes: Optional[List[str]] = None
    
    # Nouvelles sections pour une analyse plus détaillée
    competences_correspondantes: Optional[List[Dict[str, Any]]] = None
    niveau_etude_analyse: Optional[Dict[str, Any]] = None
    niveau_experience_analyse: Optional[Dict[str, Any]] = None
    compatibilite_sectorielle: Optional[Dict[str, Any]] = None
    compatibilite_geographique: Optional[Dict[str, Any]] = None
    
    class Config:
        schema_extra = {
            "example": {
                "score_global": 75.5,
                "niveau_adequation": "Bon",
                "resume": "Votre profil correspond à 75.5%, ce qui représente une bonne adéquation avec cette offre...",
                "points_forts": [
                    {
                        "description": "Niveau d'études supérieur au minimum requis (Bac+5 vs Bac+3)",
                        "categorie": "formation",
                        "importance": "important"
                    }
                ],
                "points_amelioration": [
                    {
                        "description": "Développer la compétence en gestion de contrats",
                        "categorie": "competence",
                        "priorite": "haute",
                        "suggestion": "Suivre une formation spécialisée en droit des contrats"
                    }
                ]
            }
        }


class MatchingResponse(BaseModel):
    """Modèle de réponse pour l'API (version actuelle)"""
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
    # Nouveaux champs pour une meilleure structuration
    resume_correspondance: Optional[str] = None
    atouts_majeurs: List[Dict[str, str]] = Field(default_factory=list)
    elements_manquants: List[Dict[str, str]] = Field(default_factory=list)
    suggestions_amelioration: List[Dict[str, str]] = Field(default_factory=list)
    correspondances_detaillees: Optional[Dict[str, List[Dict[str, Any]]]] = None


# Options avancées pour l'analyse
class AnalysisOptions(BaseModel):
    """Options avancées pour personnaliser l'analyse"""
    poids_formation: float = 0.25
    poids_experience: float = 0.30
    poids_competences: float = 0.35
    poids_langues: float = 0.10
    seuil_similarite_semantique: float = 0.75
    activer_analyse_semantique: bool = True
    activer_suggestions_personnalisees: bool = True
    niveau_detail_analyse: str = "complet"  # simple, standard, complet
    inclure_ressources_apprentissage: bool = False
    max_suggestions: int = 5
    max_points_forts: int = 5
    max_points_amelioration: int = 5
    mode_strict: bool = False  # Mode strict pour l'évaluation des critères obligatoires


# Requête avec options avancées
class MatchingRequestV2(BaseModel):
    """Requête d'analyse avec options avancées"""
    candidate: CandidatProfile
    job_offer: JobOffer
    options: Optional[AnalysisOptions] = Field(default_factory=AnalysisOptions) 