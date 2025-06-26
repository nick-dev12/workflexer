"""
Fonctions utilitaires pour l'analyse de compatibilité spécifiquement
pour les offres d'emploi de la source "Senjob".
"""
import logging
import json
import os
from logging.handlers import RotatingFileHandler
from typing import Dict, Tuple, List, Optional, Set
from bs4 import BeautifulSoup

# Imports depuis les utilitaires et modèles existants
from utils import (
    nlp,
    sentence_model,
    stop_words,
    normalize_text,
    get_semantic_similarity,
    create_focused_candidate_text,
    analyze_global_compatibility,
    generate_main_resume,
    generate_section_resume,
)
from models import (
    CandidatProfile,
    MatchingResponseV2,
    PointFort,
    PointAmelioration,
    Suggestion,
    AnalyseCategorielle,
    ElementManquant,
    CorrespondanceItem,
    AnalyseDetaillee
)
# Imports des nouveaux modèles spécifiques à Senjob
from models_senjob import JobOfferSenjob
from models_dakar import CandidatProfileDakar, FormationCandidatDakar, ExperienceCandidatDakar, LangueCandidatDakar

# --- Configuration du Logging ---
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# --- Configuration du Logging Détaillé pour Senjob ---
senjob_logger = logging.getLogger('senjob_analysis')
senjob_logger.setLevel(logging.INFO)
senjob_logger.propagate = False

# Construire un chemin absolu pour le fichier de log pour plus de robustesse
log_directory = os.path.dirname(os.path.abspath(__file__))
log_file_path = os.path.join(log_directory, 'senjob_analysis.log')

handler = RotatingFileHandler(log_file_path, maxBytes=1_000_000, backupCount=3, encoding='utf-8')
formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
handler.setFormatter(formatter)

if not senjob_logger.hasHandlers():
    senjob_logger.addHandler(handler)
    # Log de confirmation dans la console
    senjob_logger.info("Logger pour 'senjob_analysis' configuré. Les logs seront écrits dans : %s", log_file_path)


def analyze_competences_senjob(candidate_competences: List[str], offer_text: str) -> Tuple[float, List[CorrespondanceItem], List[ElementManquant], List[str], List[str]]:
    """
    Analyse les compétences du candidat en les recherchant directement dans le texte de l'offre.
    """
    if not candidate_competences:
        return 0.0, [], [], [], ["Le profil du candidat ne liste aucune compétence à analyser."]

    points_forts = []
    recommandations = []
    offer_text_lower = offer_text.lower()
    
    found_competences_strip = set()
    all_competences_strip = {c.strip() for c in candidate_competences}

    for comp_strip in all_competences_strip:
        if len(comp_strip) > 2 and comp_strip.lower() in offer_text_lower:
            found_competences_strip.add(comp_strip)

    if found_competences_strip:
        for comp_found in found_competences_strip:
            points_forts.append(f"Votre compétence '{comp_found}' est mentionnée dans l'offre.")
    else:
        recommandations.append("Aucune de vos compétences n'a été explicitement retrouvée dans le texte de cette offre.")

    manquants = []
    score = len(found_competences_strip) / len(all_competences_strip) if all_competences_strip else 0.0
    
    return score, [], manquants, points_forts, recommandations


def find_keyword_matches(items: List[str], offer_text: str, category: str) -> List[str]:
    """
    Recherche des correspondances de mots-clés entre une liste d'items et le texte de l'offre.
    """
    points_forts = []
    soup = BeautifulSoup(offer_text, 'html.parser')
    offer_text_cleaned = soup.get_text().lower()

    for item in items:
        item_strip = item.strip()
        if len(item_strip) > 3 and item_strip.lower() in offer_text_cleaned:
            points_forts.append(f"Votre {category} '{item_strip}' est en lien avec l'offre.")
    return points_forts


def analyze_description_senjob(description: Optional[str], offer_text: str) -> Tuple[float, List[str]]:
    """Analyse la description du candidat par rapport à l'offre."""
    if not description:
        return 0.0, []
    
    score = get_semantic_similarity(description, offer_text)
    points_forts = []
    if score > 0.6:
        points_forts.append("Votre description personnelle présente une bonne adéquation sémantique avec l'offre.")
    return score, points_forts
    

def analyze_langues_senjob(langues: List[LangueCandidatDakar], offer_text: str) -> List[str]:
    """Recherche les langues du candidat dans le texte de l'offre."""
    langue_items = [langue.nom for langue in langues]
    return find_keyword_matches(langue_items, offer_text, "langue")


def analyze_formation_senjob(formations: List[FormationCandidatDakar], offre_texte: str) -> Tuple[float, List[str], List[str]]:
    """Analyse de la formation en cherchant des correspondances de mots-clés."""
    points_forts = []
    recommandations = []

    diplomes = [f.diplome for f in formations if f.diplome]
    etablissements = [f.etablissement for f in formations if f.etablissement]

    points_forts.extend(find_keyword_matches(diplomes, offre_texte, "diplôme"))
    points_forts.extend(find_keyword_matches(etablissements, offre_texte, "établissement"))

    score = 0.75 if points_forts else 0.5
    if not points_forts:
        recommandations.append("Aucun de vos diplômes ou établissements ne semble mentionné directement dans l'offre.")
            
    return score, points_forts, recommandations


def analyze_experience_senjob(experiences: List[ExperienceCandidatDakar], offre_texte: str) -> Tuple[float, List[str], List[str]]:
    """Analyse de l'expérience en combinant sémantique et mots-clés."""
    points_forts = []
    recommandations = []

    if not experiences:
        return 0.0, [], ["Le profil ne contient aucune expérience professionnelle à analyser."]

    postes = [exp.poste for exp in experiences if exp.poste]
    points_forts.extend(find_keyword_matches(postes, offre_texte, "poste"))

    candidate_experience_text = " ".join([exp.description for exp in experiences if exp.description])
    score_semantique = 0.0
    if candidate_experience_text.strip():
        score_semantique = get_semantic_similarity(candidate_experience_text, offre_texte)
        if score_semantique > 0.65:
            points_forts.append(f"La description de vos expériences est sémantiquement très pertinente (similarité de {score_semantique:.2f}).")
        elif not points_forts:
            recommandations.append("Le contenu de vos expériences pourrait être plus aligné avec la description de l'offre.")
            
    score = 0.8 if points_forts else score_semantique
    
    return score, points_forts, recommandations


def analyze_compatibility_senjob(candidate_data: Dict, job_offer_data: Dict) -> Dict:
    """
    Analyse de compatibilité complète utilisant une approche HYBRIDE pour Senjob.
    """
    try:
        senjob_logger.info("="*50)
        senjob_logger.info(f"Début de l'analyse pour l'offre ID: {job_offer_data.get('id')} et candidat ID: {candidate_data.get('id')}")
        senjob_logger.info("Données du candidat reçues (brutes):\n%s", json.dumps(candidate_data, indent=2, ensure_ascii=False))
        senjob_logger.info("Données de l'offre reçues (brutes):\n%s", json.dumps(job_offer_data, indent=2, ensure_ascii=False))

        profile = CandidatProfileDakar(**candidate_data)
        offer = JobOfferSenjob(**job_offer_data)
        
        senjob_logger.info("Données du candidat après validation Pydantic:\n%s", profile.model_dump_json(indent=2))
        senjob_logger.info("Données de l'offre après validation Pydantic:\n%s", offer.model_dump_json(indent=2))

        if not getattr(profile, 'texte_integral', None):
            texts = [profile.description or ""]
            texts.extend(profile.competences)
            texts.extend(profile.outils)
            for exp in profile.experiences:
                texts.append(exp.poste or "")
                texts.append(exp.description or "")
            profile.texte_integral = " ".join(filter(None, texts))

        if not offer.texte_integral or len(offer.texte_integral) < 50:
            return {"error": "insufficient_data", "message": "La description de l'offre est trop courte."}

        global_semantic_score = analyze_global_compatibility(profile.texte_integral, offer.texte_integral)
        
        # Analyse Granulaire
        competences_score, _, c_manquants, c_details, c_reco = analyze_competences_senjob(profile.competences, offer.texte_integral)
        experience_score, e_details, e_reco = analyze_experience_senjob(profile.experiences, offer.texte_integral)
        formation_score, f_details, f_reco = analyze_formation_senjob(profile.formations, offer.texte_integral)
        description_score, d_details = analyze_description_senjob(profile.description, offer.texte_integral)
        l_details = analyze_langues_senjob(profile.langues, offer.texte_integral)
        o_details = find_keyword_matches(profile.outils, offer.texte_integral, "outil")
        
        # Calcul du Score Hybride Pondéré
        DESCRIPTION_WEIGHT = 0.15
        FORMATION_WEIGHT = 0.15
        EXPERIENCE_WEIGHT = 0.40
        COMPETENCES_WEIGHT = 0.30
        
        granular_composite_score = (
            description_score * DESCRIPTION_WEIGHT +
            formation_score * FORMATION_WEIGHT +
            experience_score * EXPERIENCE_WEIGHT +
            competences_score * COMPETENCES_WEIGHT
        )
        
        WEIGHT_GLOBAL = 0.60
        WEIGHT_GRANULAR = 0.40

        final_hybrid_score = (global_semantic_score * WEIGHT_GLOBAL) + (granular_composite_score * WEIGHT_GRANULAR)
        final_global_score = max(0, min(1, final_hybrid_score)) * 100
        
        logger.info(f"Score final Hybride (Senjob) calculé : {final_global_score:.0f}")

        # Construction de la Réponse
        points_forts = [PointFort(description=d, categorie=c) for c, details in [
            ("description", d_details),
            ("formation", f_details), 
            ("experience", e_details), 
            ("competences", c_details),
            ("langues", l_details),
            ("outils", o_details)
        ] for d in details]
        
        points_amelioration = [PointAmelioration(description=r, categorie=c) for c, recos in [
            ("formation", f_reco), 
            ("experience", e_reco), 
            ("competences", c_reco)
        ] for r in recos]
        
        suggestions = []
        for pa in points_amelioration:
            suggestions.append(Suggestion(
                categorie=pa.categorie,
                description=f"Pour renforcer votre profil, considérez : {pa.description}",
                priorite="moyenne"
            ))
        if c_manquants:
             suggestions.append(Suggestion(
                categorie="Compétences",
                description=f"Focus sur l'acquisition ou la mise en avant des compétences suivantes : {', '.join([m.description for m in c_manquants])}.",
                priorite="haute"
            ))

        def get_adequation_level(score):
            if score > 85: return "Excellent"
            if score > 70: return "Très bon"
            if score > 50: return "Bon"
            if score > 30: return "Passable"
            return "Faible"
            
        niveau_adequation = get_adequation_level(final_global_score)
        resume = generate_main_resume(final_global_score, niveau_adequation, "compétences", points_amelioration)

        analyse_detaillee_obj = {
            "formation": AnalyseCategorielle(categorie="Formation", score=round(formation_score * 100), points_forts=f_details, points_amelioration=f_reco, resume=generate_section_resume("formation", formation_score)),
            "experience": AnalyseCategorielle(categorie="Expérience", score=round(experience_score * 100), points_forts=e_details, points_amelioration=e_reco, resume=generate_section_resume("experience", experience_score)),
            "competences": AnalyseCategorielle(
                categorie="Compétences", 
                score=round(competences_score * 100),
                elements_correspondants=[],
                elements_manquants=c_manquants,
                points_forts=c_details, 
                points_amelioration=c_reco,
                resume=generate_section_resume("competences", competences_score)
            ),
            "langues": AnalyseCategorielle(categorie="Langues", score=50, resume="Le niveau de langue doit être vérifié manuellement."),
        }

        response_data = MatchingResponseV2(
            score_global=round(final_global_score),
            score_global_semantique=round(global_semantic_score * 100),
            niveau_adequation=niveau_adequation,
            resume=resume,
            points_forts=points_forts,
            points_amelioration=points_amelioration,
            suggestions=suggestions,
            analyse_detaillee=analyse_detaillee_obj,
            competences_manquantes=[m.description for m in c_manquants]
        )
        
        final_response = response_data.model_dump(exclude_none=True)

        senjob_logger.info("Rapport d'analyse final généré:\n%s", json.dumps(final_response, indent=2, ensure_ascii=False))
        senjob_logger.info("Fin de l'analyse.")
        senjob_logger.info("="*50 + "\n")

        return final_response

    except Exception as e:
        senjob_logger.error(f"Erreur majeure dans analyze_compatibility_senjob: {e}", exc_info=True)
        return {
            "score_global": 0,
            "niveau_adequation": "Erreur",
            "resume": f"Une erreur critique est survenue lors de l'analyse : {e}",
        } 