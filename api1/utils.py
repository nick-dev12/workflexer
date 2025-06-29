"""
Fonctions utilitaires pour l'analyse de compatibilité
"""

import logging
import re
from typing import Dict, List, Tuple, Set, Optional

# Nouveaux imports pour NLP avancé
import spacy
from sentence_transformers import SentenceTransformer, util
import numpy as np
from nltk.corpus import stopwords
import nltk

import config
from models import (
    CandidatProfile,
    JobOffer,
    MatchingResponse,
    MatchingResponseV2,
    Formation,
    Experience,
    Competence,
    Langue,
    ExigenceFormation,
    ExigenceExperience,
    AnalyseCategorielle,
    AnalyseDetaillee,
    PointFort,
    PointAmelioration,
    Suggestion,
    CorrespondanceItem,
    ElementManquant,
    ProjetPersonnel,
)

# --- Configuration du Logging ---
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# --- Chargement des modèles et ressources NLP (une seule fois) ---
try:
    logger.info("Loading NLP models as requested...")
    # Chargement du modèle spaCy pour le français
    nlp = spacy.load("fr_core_news_sm")
    logger.info("spaCy model 'fr_core_news_sm' loaded successfully.")
    
    # Chargement du modèle SentenceTransformer pour les embeddings sémantiques
    sentence_model = SentenceTransformer('distiluse-base-multilingual-cased-v1')
    logger.info("SentenceTransformer model 'distiluse-base-multilingual-cased-v1' loaded successfully.")

    # Assurer que les données NLTK nécessaires sont téléchargées
    try:
        nltk.data.find('corpora/stopwords')
        nltk.data.find('tokenizers/punkt')
    except LookupError:
        logger.info("NLTK data not found. Downloading 'stopwords' and 'punkt'...")
        nltk.download('stopwords')
        nltk.download('punkt')
        
    stop_words = set(stopwords.words('french'))
    logger.info("NLTK French stopwords loaded.")

except Exception as e:
    logger.error(f"Critical error loading NLP models: {e}", exc_info=True)
    nlp = None
    sentence_model = None
    stop_words = set()


# Constantes pour l'analyse
COMPLETION_THRESHOLD = config.WEIGHTS.get("completion_threshold", 0.7)
EXPERIENCE_WEIGHT = config.WEIGHTS.get("experience", 0.35)
FORMATION_WEIGHT = config.WEIGHTS.get("formation", 0.25)
COMPETENCES_WEIGHT = config.WEIGHTS.get("competences", 0.25)
LANGUES_WEIGHT = config.WEIGHTS.get("langues", 0.15)
OUTILS_WEIGHT = config.WEIGHTS.get("outils", 0.10)


def normalize_text(text: str) -> List[str]:
    """
    Nettoie, tokenise, lemmatise le texte et supprime les mots vides en utilisant spaCy.
    Retourne une liste de lemmes normalisés pour une comparaison sémantique efficace.
    """
    if not nlp or not text or not isinstance(text, str):
        return []
    # 1. Mise en minuscules et suppression de la ponctuation non pertinente
    text = text.lower()
    text = re.sub(r'[^\w\s]', ' ', text)
    
    # 2. Traitement avec spaCy pour la lemmatisation et le filtrage
    doc = nlp(text)
    lemmas = [
        token.lemma_ 
        for token in doc 
        if token.is_alpha and token.lemma_ not in stop_words
    ]
    
    return lemmas

def get_semantic_similarity(text1: str, text2: str) -> float:
    """
    Calcule la similarité sémantique entre deux textes en utilisant le SentenceTransformer chargé.
    """
    if not sentence_model or not text1 or not text2:
        return 0.0
    
    try:
        # L'encodage et la comparaison sont plus efficaces ainsi
        embeddings = sentence_model.encode([text1, text2], convert_to_tensor=True, show_progress_bar=False)
        cosine_score = util.pytorch_cos_sim(embeddings[0], embeddings[1])
        return cosine_score.item()
    except Exception as e:
        logger.error(f"Error calculating semantic similarity for texts ('{text1[:30]}...', '{text2[:30]}...'): {e}", exc_info=False)
        return 0.0


# Mapping des niveaux d'études standardisés
NIVEAU_ETUDES_MAP = {
    "Bac": {"niveau": 1, "equivalents": ["Baccalauréat", "High School"]},
    "Bac+2": {"niveau": 2, "equivalents": ["DUT", "BTS", "DEUG"]},
    "Bac+3": {"niveau": 3, "equivalents": ["Licence", "Bachelor"]},
    "Bac+4": {"niveau": 4, "equivalents": ["Maîtrise", "Master 1"]},
    "Bac+5": {"niveau": 5, "equivalents": ["Master", "Ingénieur", "MBA"]},
    "Doctorat": {"niveau": 8, "equivalents": ["PhD", "Doctorate"]},
}


def get_niveau_etudes_value(niveau: str) -> int:
    """Convertit un niveau d'études en valeur numérique standardisée."""
    niveau = niveau.strip()
    for key, data in NIVEAU_ETUDES_MAP.items():
        if niveau == key or niveau in data["equivalents"]:
            return data["niveau"]
    return 0


def analyze_profile_completion(profile: CandidatProfile) -> Dict:
    """Analyse le niveau de complétion du profil."""
    scores = {}
    
    # Vérification des formations
    if profile.formations:
        formations_score = sum(
            1 for f in profile.formations if f.niveau and f.domaine and f.etablissement
        ) / len(profile.formations)
        scores["formations"] = formations_score
    else:
        scores["formations"] = 0.0
    
    # Vérification des expériences
    if profile.experiences:
        experiences_score = sum(
            1
            for e in profile.experiences
            if e.titre_poste and e.description and e.competences
        ) / len(profile.experiences)
        scores["experiences"] = experiences_score
    else:
        scores["experiences"] = 0.0
    
    # Vérification des compétences
    if profile.competences:
        competences_score = sum(
            1 for c in profile.competences if c.nom and c.niveau
        ) / len(profile.competences)
        scores["competences"] = competences_score
    else:
        scores["competences"] = 0.0
    
    # Vérification des langues
    if profile.langues:
        langues_score = sum(1 for l in profile.langues if l.nom and l.niveau) / len(
            profile.langues
        )
        scores["langues"] = langues_score
    else:
        scores["langues"] = 0.0
    
    # Score global pondéré
    global_score = (
        scores["formations"] * FORMATION_WEIGHT
        + scores["experiences"] * EXPERIENCE_WEIGHT
        + scores["competences"] * COMPETENCES_WEIGHT
        + scores["langues"] * LANGUES_WEIGHT
    )
    
    return {
        "score": global_score,
        "details": {
            "formations": scores["formations"],
            "experiences": scores["experiences"],
            "competences": scores["competences"],
            "langues": scores["langues"],
        },
    }


def analyze_formation_compatibility(
    formations: List[Formation],
    exigence: ExigenceFormation,
    niveau_etude_profil: Optional[str],
    niveau_etude_valeur: Optional[int] = None
) -> Tuple[float, List[str], List[str]]:
    """Analyse de la compatibilité des formations, incluant le niveau d'étude global."""
    points_forts = []
    recommendations = []
    score_total = 0.0
    
    if not exigence.domaines_acceptes and exigence.niveau_minimum == "Non spécifié":
        return 1.0, ["Aucune exigence de formation spécifique."], []

    # Analyse du niveau d'études - Données maintenant normalisées et fiables
    niveau_requis_val = exigence.niveau_valeur
    niveau_candidat_val = niveau_etude_valeur if niveau_etude_valeur is not None else 0

    # Comparaison stricte des niveaux
    if niveau_candidat_val >= niveau_requis_val:
        score_niveau = 1.0
        if niveau_etude_profil and niveau_requis_val > 0:
            points_forts.append(f"Niveau d'études ({niveau_etude_profil}) adéquat pour le niveau requis ({exigence.niveau_minimum}).")
    else:
        score_niveau = (niveau_candidat_val / niveau_requis_val) if niveau_requis_val > 0 else 0
        if niveau_requis_val > 0:
            recommendations.append(
                f"Le niveau d'études requis ({exigence.niveau_minimum}) est supérieur à votre niveau actuel ({niveau_etude_profil or 'Non spécifié'})."
            )

    score_total = score_niveau

    return score_total, points_forts, recommendations


def calculate_domain_similarity(domain1: str, domain2: str) -> float:
    """
    Calcule la similarité sémantique entre deux domaines de formation
    en utilisant une approche plus stricte et rigoureuse.
    
    Args:
        domain1: Premier domaine
        domain2: Deuxième domaine
        
    Returns:
        Score de similarité entre 0 et 1
    """
    # Normalisation des domaines
    domain1 = domain1.lower().strip()
    domain2 = domain2.lower().strip()
    
    # Vérification des correspondances exactes
    if domain1 == domain2:
        return 1.0
    
    # Vérification des sous-chaînes
    if domain1 in domain2 or domain2 in domain1:
        # Calculer le ratio de longueur pour une évaluation plus stricte
        len_ratio = min(len(domain1), len(domain2)) / max(len(domain1), len(domain2))
        # Ajuster le score en fonction du ratio de longueur
        return 0.8 * len_ratio
    
    # Utiliser le modèle sémantique pour les cas plus complexes
    try:
        embeddings1 = sentence_model.encode([domain1], convert_to_tensor=True, show_progress_bar=False)
        embeddings2 = sentence_model.encode([domain2], convert_to_tensor=True, show_progress_bar=False)
        
        # Calculer la similarité cosinus
        cosine_similarity = util.pytorch_cos_sim(embeddings1, embeddings2).item()
        
        # Appliquer un facteur de correction pour une évaluation plus stricte
        # Les scores entre 0.7 et 0.85 sont réduits pour éviter les faux positifs
        if 0.7 <= cosine_similarity <= 0.85:
            cosine_similarity = cosine_similarity * 0.9
        
        return cosine_similarity
    except Exception as e:
        logger.error(f"Erreur lors du calcul de similarité sémantique: {str(e)}")
        # En cas d'erreur, retourner une valeur conservative
        return 0.0


def analyze_experience_compatibility(
    experiences: List[Experience],
    exigence: ExigenceExperience,
    job_description: str,
    niveau_experience_valeur: Optional[int] = None
) -> Tuple[float, List[str], List[str]]:
    """
    Analyse la compatibilité de l'expérience, en combinant la durée et la pertinence sémantique.
    """
    points_forts = []
    recommendations = []
    
    # 1. Analyse de la durée de l'expérience - Données maintenant normalisées et fiables
    total_experience_months = sum(e.duree_mois for e in experiences if e.duree_mois)
    required_experience_months = exigence.duree_minimum_mois

    if required_experience_months == 0:
        score_duree = 1.0 # Pas d'exigence de durée, le candidat est compatible sur ce point
        points_forts.append("La durée d'expérience n'est pas un critère principal pour cette offre.")
    elif total_experience_months >= required_experience_months:
        score_duree = 1.0
        points_forts.append(f"Vous avez {total_experience_months / 12:.1f} ans d'expérience, ce qui correspond ou dépasse les {required_experience_months / 12:.1f} ans requis.")
    else:
        score_duree = total_experience_months / required_experience_months if required_experience_months > 0 else 0
        recommendations.append(f"L'offre requiert {required_experience_months / 12:.1f} ans d'expérience, mais votre profil en indique {total_experience_months / 12:.1f}.")

    # 2. Analyse de la pertinence sémantique
    all_lemmas = [
        lemma
        for e in experiences if e.description
        for lemma in normalize_text(e.description)
    ]
    candidate_experience_text = " ".join(all_lemmas)
    offer_description_normalized = " ".join(normalize_text(job_description))

    score_semantique = 0.0
    if candidate_experience_text and offer_description_normalized:
        score_semantique = get_semantic_similarity(candidate_experience_text, offer_description_normalized)
        if score_semantique > 0.6:
            points_forts.append(f"La description de vos expériences est sémantiquement proche de l'offre (similarité de {score_semantique:.2f}).")
        else:
            recommendations.append("Le contenu de vos expériences pourrait être plus aligné avec la description du poste. Pensez à mettre en avant les tâches et projets pertinents.")
            
    # 3. Calcul du score final pondéré
    # Pondération : 40% durée, 60% sémantique
    WEIGHT_DUREE = 0.4
    WEIGHT_SEMANTIQUE = 0.6
    
    final_score = (score_duree * WEIGHT_DUREE) + (score_semantique * WEIGHT_SEMANTIQUE)
    
    return final_score, points_forts, recommendations


def analyze_competences_compatibility(
    candidate_competences: List[Competence], required_competences: List[Competence]
) -> Tuple[float, List[CorrespondanceItem], List[ElementManquant], List[str], List[str]]:
    """
    Analyse sémantique de la compatibilité des compétences.
    Retourne: score, correspondances, manquants, points forts (strings), recommandations (strings)
    """
    if not required_competences:
        return 1.0, [], [], ["Aucune compétence spécifique n'est requise."], []

    if not candidate_competences:
        manquants = [ElementManquant(description=c.nom, categorie='competence', importance='importante') for c in required_competences]
        reco_text = (
            f"Le profil ne liste aucune compétence. Compétences à ajouter : "
            f"{', '.join([c.nom for c in required_competences])}"
        )
        return 0.0, [], manquants, [], [reco_text]

    # OPTIMISATION : Encodage par lots
    # 1. Préparer les listes de compétences à encoder
    req_skill_names = [s.nom for s in required_competences if s.nom]
    cand_skill_names = [s.nom for s in candidate_competences if s.nom]

    if not req_skill_names or not cand_skill_names:
        return 0.0, [], [ElementManquant(description=c.nom, categorie='competence', importance='importante') for c in required_competences], [], ["Le profil ou l'offre ne contient aucune compétence valide à comparer."]

    # 2. Encoder toutes les compétences en une seule fois
    try:
        req_embeddings = sentence_model.encode(req_skill_names, convert_to_tensor=True, show_progress_bar=False)
        cand_embeddings = sentence_model.encode(cand_skill_names, convert_to_tensor=True, show_progress_bar=False)
        
        # 3. Calculer la matrice de similarité cosinus
        cosine_scores = util.pytorch_cos_sim(req_embeddings, cand_embeddings)
    except Exception as e:
        logger.error(f"Erreur lors de l'encodage par lot des compétences : {e}")
        return 0.0, [], [], [], ["Erreur lors de l'analyse sémantique des compétences."]

    correspondances = []
    manquants = []
    points_forts = []
    matched_req_indices = set()
    
    SIMILARITY_THRESHOLD = 0.80

    # 4. Traiter la matrice de similarité
    for i, req_skill in enumerate(required_competences):
        # Trouver le meilleur score de similarité pour la compétence requise i
        if i < len(cosine_scores):
            best_match_score, best_cand_index = cosine_scores[i].max(), cosine_scores[i].argmax()
            
            if best_match_score > SIMILARITY_THRESHOLD:
                best_cand_obj = candidate_competences[best_cand_index]
                matched_req_indices.add(i)

                item = CorrespondanceItem(
                    element_profil=best_cand_obj.nom,
                    element_offre=req_skill.nom,
                    niveau_correspondance=best_match_score.item(),
                    categorie='competence',
                    similarite_semantique=best_match_score.item()
                )
                correspondances.append(item)

                if best_match_score < 0.98:
                    points_forts.append(f"{req_skill.nom} (similaire à votre compétence '{best_cand_obj.nom}')")
                else:
                    points_forts.append(req_skill.nom)
            else:
                manquants.append(ElementManquant(description=req_skill.nom, categorie='competence', importance='importante'))
        else:
             manquants.append(ElementManquant(description=req_skill.nom, categorie='competence', importance='importante'))


    # Nouveau calcul du score : un ratio strict de couverture des compétences requises
    score = len(matched_req_indices) / len(required_competences) if required_competences else 1.0
    
    recommendations = []
    if manquants:
        missing_list = [m.description for m in manquants]
        recommendations.append(f"Compétences manquantes ou non identifiées : {', '.join(missing_list)}. Pensez à les ajouter ou à reformuler vos compétences actuelles.")

    return score, correspondances, manquants, points_forts, recommendations


def analyze_langues_compatibility(
    langues: List[Langue], requises: List[Langue]
) -> Tuple[float, List[str], List[str]]:
    """Analyse approfondie de la compatibilité des langues."""
    if not requises:
        return 1.0, ["Aucune exigence linguistique spécifique"], []
    
    score = 0
    details = []
    recommendations = []
    points_forts = []
    
    niveaux_echelle = {"A1": 1, "A2": 2, "B1": 3, "B2": 4, "C1": 5, "C2": 6}
    
    langues_dict = {l.nom.lower(): l for l in langues}
    
    # Analyse détaillée par langue
    for langue_requise in requises:
        nom_langue = langue_requise.nom.lower()
        if nom_langue in langues_dict:
            langue_candidate = langues_dict[nom_langue]
            niveau_requis = niveaux_echelle[langue_requise.niveau]
            niveau_candidat = niveaux_echelle[langue_candidate.niveau]
            
            if niveau_candidat >= niveau_requis:
                score += 1
                if niveau_candidat > niveau_requis:
                    points_forts.append(
                        f"Niveau {langue_candidate.niveau} en {langue_requise.nom} (requis: {langue_requise.niveau})"
                    )
                else:
                    details.append(f"Niveau requis atteint en {langue_requise.nom}")
                
                if langue_candidate.certifications:
                    points_forts.append(
                        f"Certifications en {langue_requise.nom}: {', '.join(langue_candidate.certifications)}"
                    )
            else:
                score += max(0, (niveau_candidat / niveau_requis) - 0.2)
                recommendations.append(
                    f"Améliorer le niveau en {langue_requise.nom} "
                    f"(actuel: {langue_candidate.niveau}, requis: {langue_requise.niveau})"
                )
        else:
            recommendations.append(
                f"Apprentissage recommandé : {langue_requise.nom} (niveau {langue_requise.niveau})"
            )
    
    # Langues supplémentaires
    langues_supp = set(langues_dict.keys()) - {l.nom.lower() for l in requises}
    if langues_supp:
        points_forts.append(
            f"Langues supplémentaires maîtrisées : {', '.join(langues_supp)}"
        )
    
    score_final = score / len(requises)
    return score_final, details + points_forts, recommendations


def analyze_outils_compatibility(outils: List[str], offer_text: str) -> Tuple[float, List[str], List[str]]:
    """Analyse la compatibilité des outils en recherchant des correspondances de mots-clés."""
    if not outils:
        return 1.0, [], []

    points_forts = []
    offer_text_lower = offer_text.lower()
    
    found_outils = {outil.strip() for outil in outils if len(outil.strip()) > 2 and outil.strip().lower() in offer_text_lower}

    if found_outils:
        for outil in found_outils:
            points_forts.append(f"Votre maîtrise de l'outil '{outil}' est un atout pour cette offre.")
            
    score = len(found_outils) / len(outils) if outils else 0.0
    
    return score, points_forts, []


def identify_critical_gaps(
    profile: CandidatProfile, offer: JobOffer
) -> List[Dict[str, str]]:
    """Identifie les lacunes critiques du profil de manière détaillée."""
    gaps = []
    
    # Analyse formation
    if offer.formation_requise.formation_obligatoire:
        niveau_requis = get_niveau_etudes_value(offer.formation_requise.niveau_minimum)
        formations_suffisantes = [
            f
            for f in profile.formations
            if get_niveau_etudes_value(f.niveau) >= niveau_requis
        ]
        if not formations_suffisantes:
            gaps.append(
                {
                "categorie": "Formation",
                "description": f"Formation de niveau {offer.formation_requise.niveau_minimum} requise",
                "impact": "Critique",
                    "suggestion": "Envisager une formation complémentaire ou validation des acquis",
                }
            )
    
    # Analyse expérience
    experience_totale = sum(exp.duree_mois for exp in profile.experiences)
    if experience_totale < offer.experience_requise.duree_minimum_mois:
        manque = offer.experience_requise.duree_minimum_mois - experience_totale
        gaps.append(
            {
            "categorie": "Expérience",
            "description": f"Il manque {manque/12:.1f} ans d'expérience",
            "impact": "Important",
                "suggestion": "Valoriser les stages et projets personnels en attendant",
            }
        )
    
    # Analyse compétences essentielles
    competences_candidates = {c.nom.lower(): c for c in profile.competences}
    for comp_requise in offer.competences_requises:
        if comp_requise.niveau >= 4:  # Compétences critiques
            if comp_requise.nom.lower() not in competences_candidates:
                gaps.append(
                    {
                    "categorie": "Compétence",
                    "description": f"Compétence essentielle manquante : {comp_requise.nom}",
                    "impact": "Critique",
                        "suggestion": f"Formation recommandée en {comp_requise.nom}",
                    }
                )
            elif (
                competences_candidates[comp_requise.nom.lower()].niveau
                < comp_requise.niveau - 1
            ):
                gaps.append(
                    {
                    "categorie": "Compétence",
                    "description": f"Niveau insuffisant en {comp_requise.nom}",
                    "impact": "Important",
                        "suggestion": "Approfondir via des projets personnels ou formations",
                    }
                )
    
    return gaps


def generate_improvement_suggestions(
    profile: CandidatProfile, offer: JobOffer, recommendations: Dict[str, List[str]]
) -> List[Dict[str, str]]:
    """
    Génère des suggestions d'amélioration personnalisées basées sur le profil et l'offre.
    """
    suggestions = []
    
    # Analyse du secteur d'activité
    secteur = offer.secteur
    if secteur:
        experiences_secteur = [
            exp
            for exp in profile.experiences
            if exp.secteur and exp.secteur.lower() == secteur.lower()
        ]
        if not experiences_secteur:
            suggestions.append(
                {
                "type": "experience",
                "suggestion": f"Acquérir de l'expérience dans le secteur {secteur}",
                    "priorite": "haute",
                }
            )
    
    # Analyse des compétences manquantes
    competences_requises = {comp.nom.lower() for comp in offer.competences_requises}
    competences_candidat = {comp.nom.lower() for comp in profile.competences}
    competences_manquantes = competences_requises - competences_candidat
    
    if competences_manquantes:
        for comp in competences_manquantes:
            suggestions.append(
                {
                "type": "competence",
                "suggestion": f"Développer la compétence : {comp}",
                    "priorite": "haute",
                }
            )
    
    # Analyse du niveau d'études
    if (
        offer.formation_requise
        and offer.formation_requise.niveau_minimum != "Non spécifié"
    ):
        niveau_requis = offer.formation_requise.niveau_minimum
        niveaux_candidat = [f.niveau for f in profile.formations]
        if not any(
            niveau_satisfait_exigence(niveau, niveau_requis)
            for niveau in niveaux_candidat
        ):
            suggestions.append(
                {
                "type": "formation",
                "suggestion": f"Atteindre le niveau d'études requis : {niveau_requis}",
                    "priorite": "haute",
                }
            )
    
    # Suggestions spécifiques au secteur
    if secteur:
        certifications_recommandees = get_certifications_recommandees(secteur)
        for cert in certifications_recommandees:
            if not any(c.get("nom") == cert for c in profile.certifications or []):
                suggestions.append(
                    {
                    "type": "certification",
                    "suggestion": f"Obtenir la certification {cert} pertinente pour le secteur",
                        "priorite": "moyenne",
                    }
                )
    
    # Suggestions basées sur les tendances du marché
    tendances = get_tendances_marche(secteur) if secteur else []
    for tendance in tendances:
        if not any(
            comp.nom.lower() == tendance.lower() for comp in profile.competences
        ):
            suggestions.append(
                {
                "type": "tendance",
                "suggestion": f"Se former à {tendance}, une compétence en demande dans le secteur",
                    "priorite": "moyenne",
                }
            )
    
    # Intégration des recommandations spécifiques
    for categorie, recos in recommendations.items():
        for reco in recos:
            suggestions.append(
                {
                "type": categorie.replace("_reco", ""),
                "suggestion": reco,
                    "priorite": "normale",
                }
            )
    
    return suggestions


def get_certifications_recommandees(secteur: str) -> List[str]:
    """Retourne les certifications recommandées pour un secteur donné."""
    certifications_par_secteur = {
        "Informatique": [
            "ITIL Foundation",
            "Certification Agile/Scrum",
            "Certifications Cloud (AWS, Azure, GCP)",
        ],
        "Marketing": [
            "Google Analytics",
            "HubSpot Marketing",
            "Certification SEO",
        ],
        "Finance": [
            "CFA",
            "Bloomberg Market Concepts",
            "Certification Risk Management",
        ],
        # Ajoutez d'autres secteurs selon les besoins
    }
    return certifications_par_secteur.get(secteur, [])


def get_tendances_marche(secteur: str) -> List[str]:
    """Retourne les tendances actuelles du marché pour un secteur donné."""
    tendances_par_secteur = {
        "Informatique": [
            "Intelligence Artificielle",
            "DevOps",
            "Cloud Computing",
            "Cybersécurité",
        ],
        "Marketing": [
            "Marketing Digital",
            "Growth Hacking",
            "Content Marketing",
            "Social Media Marketing",
        ],
        "Finance": [
            "Blockchain",
            "FinTech",
            "ESG Investing",
            "Risk Analytics",
        ],
        # Ajoutez d'autres secteurs selon les besoins
    }
    return tendances_par_secteur.get(secteur, [])


def niveau_satisfait_exigence(niveau_candidat: str, niveau_requis: str) -> bool:
    """Vérifie si le niveau d'études du candidat satisfait le niveau requis."""
    niveaux_ordre = {
        "Secondaire": 1,
        "Bac": 2,
        "Bac+1": 3,
        "Bac+2": 4,
        "Bac+3": 5,
        "Licence": 5,
        "Bac+4": 6,
        "Bac+5": 7,
        "Master": 7,
        "Doctorat": 8,
    }
    niveau_candidat_val = niveaux_ordre.get(niveau_candidat, 0)
    niveau_requis_val = niveaux_ordre.get(niveau_requis, 0)
    return niveau_candidat_val >= niveau_requis_val


def generate_synthesis(global_score: float, analyses: Dict) -> str:
    """Génère une synthèse textuelle basée sur le score global et les analyses."""
    if global_score > 0.8:
        level = "Excellente"
    elif global_score > 0.6:
        level = "Bonne"
    elif global_score > 0.4:
        level = "Moyenne"
    else:
        level = "Faible"

    # Trouver les points forts et faibles
    points_forts = [
        analyses[cat]["titre"]
        for cat, data in analyses.items()
        if data["score"] > 70
    ]
    points_faibles = [
        analyses[cat]["titre"]
        for cat, data in analyses.items()
        if data["score"] < 50
    ]

    synthesis = f"Adéquation globale : {level} ({global_score * 100:.0f}%). "
    if points_forts:
        synthesis += f"Points forts détectés en {', '.join(points_forts)}. "
    if points_faibles:
        synthesis += (
            f"Des améliorations sont possibles en {', '.join(points_faibles)}."
        )

    return synthesis


def create_focused_candidate_text(candidate_text: str, offer_keywords: Set[str]) -> str:
    """
    Crée une version focalisée du texte du candidat, ne gardant que les phrases
    contenant des mots-clés de l'offre pour une comparaison plus pertinente.
    """
    if not offer_keywords:
        return candidate_text # Retourne le texte complet si pas de mots-clés

    focused_sentences = []
    # Utilise NLTK pour segmenter le texte en phrases
    sentences = nltk.sent_tokenize(candidate_text, language='french')
    
    for sentence in sentences:
        # Normalise la phrase pour la recherche
        normalized_sentence_words = set(normalize_text(sentence))
        # Si une phrase contient au moins un mot-clé de l'offre, on la garde
        if not normalized_sentence_words.isdisjoint(offer_keywords):
            focused_sentences.append(sentence)
            
    if not focused_sentences:
        return candidate_text # Fallback au texte complet si aucune phrase ne correspond

    return " ".join(focused_sentences)


def analyze_global_compatibility(candidate_text: Optional[str], offer_text: Optional[str]) -> float:
    """
    Analyse la compatibilité globale en comparant une version focalisée du profil
    avec le texte de l'offre pour donner la priorité aux exigences de l'offre.
    """
    if not candidate_text or not offer_text:
        return 0.0
    
    logger.info("Début de l'analyse sémantique globale avec focalisation.")
    
    # Extrait les mots-clés de l'offre pour guider la focalisation
    offer_keywords = set(normalize_text(offer_text))
    
    # Crée une version du texte candidat focalisée sur les mots-clés de l'offre
    focused_candidate_text = create_focused_candidate_text(candidate_text, offer_keywords)
    
    logger.info("Texte candidat focalisé créé. Lancement de la comparaison.")
    
    similarity = get_semantic_similarity(focused_candidate_text, offer_text)
    logger.info(f"Similarité sémantique globale (focalisée) calculée : {similarity:.2f}")
    return similarity


def analyze_compatibility(candidate_data: Dict, job_offer_data: Dict) -> Dict:
    """
    Analyse complète et nouvelle génération de rapport structuré V2,
    en s'appuyant sur une approche hybride (sémantique globale + analyse granulaire).
    """
    try:
        # Validation et initialisation des objets Pydantic
        profile = CandidatProfile(**candidate_data)
        offer = JobOffer(**job_offer_data)
        
        # Vérifier si l'offre a suffisamment de contenu pour une analyse pertinente
        MIN_OFFER_LENGTH = 100  # En nombre de caractères
        if not offer.texte_integral or len(offer.texte_integral) < MIN_OFFER_LENGTH:
            return {
                "error": "insufficient_data",
                "message": "La description de l'offre est trop courte pour une analyse de compatibilité détaillée. Nous vous invitons à consulter directement les détails de l'offre."
            }
        
        # --- Analyse Globale : le score principal est UNIQUEMENT basé sur cette analyse ---
        global_semantic_score = analyze_global_compatibility(profile.texte_integral, offer.texte_integral)
        
        # --- Analyses Détaillées / Granulaires : utilisées pour le contenu du rapport ---
        
        # 1. Formation
        formation_score, f_details, f_reco = analyze_formation_compatibility(
            profile.formations, offer.formation_requise, profile.niveau_etude, profile.niveau_etude_valeur
        )
        
        # 2. Expérience (avec analyse sémantique)
        experience_score, e_details, e_reco = analyze_experience_compatibility(
            profile.experiences, offer.experience_requise, offer.description, profile.niveau_experience_valeur
        )
        
        # 3. Compétences (avec analyse sémantique)
        competences_score, c_corresp, c_manquants, c_details, c_reco = analyze_competences_compatibility(
            profile.competences, offer.competences_requises
        )
        
        # 4. Langues
        langues_score, l_details, l_reco = analyze_langues_compatibility(
            profile.langues, offer.langues_requises
        )
        
        # 5. Outils (Nouveau)
        outils_score, o_details, o_reco = analyze_outils_compatibility(
            profile.outils, offer.texte_integral
        )
        
        # 5. Analyse des projets personnels (nouveau)
        p_details, p_reco = analyze_projets_candidat(profile.projets, offer)
        
        # --- Calcul du score global : Approche Hybride Pondérée ---

        # 1. Calculer le score composite de l'analyse granulaire
        granular_composite_score = (
            formation_score * FORMATION_WEIGHT +
            experience_score * EXPERIENCE_WEIGHT +
            competences_score * COMPETENCES_WEIGHT +
            langues_score * LANGUES_WEIGHT +
            outils_score * OUTILS_WEIGHT
        )
        logger.info(f"Score composite granulaire calculé : {granular_composite_score:.2f}")

        # 2. Définir les poids pour l'hybridation finale
        WEIGHT_GLOBAL_SEMANTIC = 0.6  # 60% du score vient de l'analyse globale
        WEIGHT_GRANULAR = 0.4         # 40% du score vient de l'analyse détaillée

        # 3. Calculer le score final hybride
        # Assurer que les scores sont bien entre 0 et 1 avant de les pondérer
        final_hybrid_score = (
            (global_semantic_score * WEIGHT_GLOBAL_SEMANTIC) +
            (granular_composite_score * WEIGHT_GRANULAR)
        )
        
        final_global_score = max(0, min(1, final_hybrid_score)) * 100
        logger.info(f"Score final hybride calculé : {final_global_score:.0f}")

        # --- Construction de la réponse structurée (V2) ---
        
        points_forts = [PointFort(description=d, categorie=c) for c, details in [
            ("formation", f_details), 
            ("experience", e_details), 
            ("competences", c_details), 
            ("langues", l_details),
            ("outils", o_details),
            ("projets", p_details)
        ] for d in details]
        
        points_amelioration = [PointAmelioration(description=r, categorie=c) for c, recos in [
            ("formation", f_reco), 
            ("experience", e_reco), 
            ("competences", c_reco), 
            ("langues", l_reco),
            ("outils", o_reco),
            ("projets", p_reco)
        ] for r in recos]
        
        all_recommendations = {
            "formation_reco": f_reco,
            "experience_reco": e_reco,
            "competences_reco": c_reco,
            "langues_reco": l_reco,
            "outils_reco": o_reco,
            "projets_reco": p_reco
        }
        raw_suggestions = generate_improvement_suggestions(profile, offer, all_recommendations)
        suggestions = [
            Suggestion(
                categorie=s.get("type", "générale"),
                description=s.get("suggestion", ""),
                priorite=s.get("priorite", "normale")
            ) for s in raw_suggestions
        ]
        
        projets_score = len(p_details) / max(3, len(profile.projets) if profile.projets else 1)
        projets_resume = generate_section_resume("projets", projets_score)
        
        analyse_detaillee = {
            "formation": AnalyseCategorielle(categorie="Formation", score=round(formation_score * 100), points_forts=f_details, points_amelioration=f_reco, resume=generate_section_resume("formation", formation_score)),
            "experience": AnalyseCategorielle(categorie="Expérience", score=round(experience_score * 100), points_forts=e_details, points_amelioration=e_reco, resume=generate_section_resume("experience", experience_score)),
            "competences": AnalyseCategorielle(
                categorie="Compétences", 
                score=round(competences_score * 100), 
                elements_correspondants=c_corresp,
                elements_manquants=c_manquants,
                points_forts=c_details, 
                points_amelioration=c_reco,
                resume=generate_section_resume("competences", competences_score)
            ),
            "langues": AnalyseCategorielle(categorie="Langues", score=round(langues_score * 100), points_forts=l_details, points_amelioration=l_reco, resume=generate_section_resume("langues", langues_score)),
            "outils": AnalyseCategorielle(categorie="Outils", score=round(outils_score * 100), points_forts=o_details, points_amelioration=o_reco, resume=generate_section_resume("outils", outils_score)),
            "projets": AnalyseCategorielle(categorie="Projets", score=round(projets_score * 100), points_forts=p_details, points_amelioration=p_reco, resume=projets_resume)
        }

        def get_adequation_level(score):
            if score > 85: return "Excellent"
            if score > 70: return "Très bon"
            if score > 50: return "Bon"
            if score > 30: return "Passable"
            return "Faible"
            
        niveau_adequation = get_adequation_level(final_global_score)
        
        strongest_category = max(analyse_detaillee, key=lambda k: analyse_detaillee[k].score) if analyse_detaillee else "N/A"
        resume = generate_main_resume(final_global_score, niveau_adequation, strongest_category, points_amelioration)

        response_data = MatchingResponseV2(
            score_global=round(final_global_score),
            score_global_semantique=round(global_semantic_score * 100),
            niveau_adequation=niveau_adequation,
            resume=resume,
            points_forts=points_forts,
            points_amelioration=points_amelioration,
            suggestions=suggestions,
            analyse_detaillee=analyse_detaillee,
            competences_manquantes=[m.description for m in c_manquants]
        )
        
        return response_data.dict(exclude_none=True)

    except Exception as e:
        logger.error(f"Erreur majeure dans analyze_compatibility: {e}", exc_info=True)
        return {
            "score_global": 0,
            "niveau_adequation": "Erreur",
            "resume": f"Une erreur est survenue lors de l'analyse: {e}",
        }


def generate_main_resume(global_score: float, niveau_adequation: str, strongest_category: str, points_amelioration: List[PointAmelioration]) -> str:
    """Génère un résumé principal personnalisé et engageant."""
    score = round(global_score)

    if score > 85:
        resume = f"Excellent ! ({score}%) Votre profil matche parfaitement avec cette offre. C'est un grand oui !"
    elif score > 70:
        resume = f"Très bon profil ! ({score}%) Vous avez de solides atouts pour ce poste. Quelques petits ajustements et ce sera parfait."
    elif score > 50:
        resume = f"Pas mal du tout ! ({score}%) Votre profil a de bons atouts. Jetez un oeil aux suggestions pour faire la différence."
    elif score > 30:
        resume = f"Il y a du potentiel. ({score}%) Il y a des points qui matchent, mais aussi des écarts. Concentrez-vous sur les suggestions pour les prochaines fois."
    else:
        resume = f"Pour l'instant, ça ne matche pas trop ({score}%). Pas de panique ! Servez-vous de l'analyse pour voir sur quoi travailler."

    return resume


def generate_section_resume(categorie: str, score: float) -> str:
    """Génère un résumé engageant pour une catégorie spécifique."""
    score_pct = round(score * 100)
    
    resumes = {
            "formation": {
            "excellent": f"Votre parcours académique ({score_pct}%) est un atout majeur pour ce poste.",
            "bon": f"Votre formation ({score_pct}%) est solide et pertinente pour ce rôle.",
            "moyen": f"Votre formation ({score_pct}%) est un bon point de départ, mais pourrait être complétée pour correspondre parfaitement à l'offre.",
            "faible": f"Votre parcours de formation ({score_pct}%) semble assez éloigné des prérequis pour ce poste. Mettez en avant vos expériences concrètes.",
            },
            "experience": {
            "excellent": f"Votre expérience professionnelle ({score_pct}%) est en parfaite adéquation avec les missions proposées.",
            "bon": f"Vous avez une expérience très pertinente ({score_pct}%) pour ce poste. Pensez à bien la détailler.",
            "moyen": f"Votre expérience ({score_pct}%) est intéressante. Essayez de mettre en avant les projets les plus similaires à ceux de l'offre.",
            "faible": f"Il semble vous manquer une expérience significative ({score_pct}%) pour ce poste. Valorisez vos stages, projets personnels ou formations.",
            },
            "competences": {
            "excellent": f"Vos compétences ({score_pct}%) correspondent parfaitement aux attentes. Vous êtes prêt pour les défis techniques de ce poste.",
            "bon": f"Vous possédez un solide éventail de compétences ({score_pct}%) pour cette mission.",
            "moyen": f"Vous avez les compétences de base ({score_pct}%), mais certaines expertises demandées mériteraient d'être renforcées.",
            "faible": f"Un décalage important est noté sur les compétences clés ({score_pct}%). C'est un bon axe de progression pour votre carrière.",
            },
            "langues": {
            "excellent": f"Vos compétences linguistiques ({score_pct}%) sont un véritable plus pour cette opportunité.",
            "bon": f"Vous maîtrisez les langues requises ({score_pct}%) pour ce poste.",
            "moyen": f"Votre niveau en langues ({score_pct}%) est correct, mais une amélioration pourrait être un avantage.",
            "faible": f"Les exigences linguistiques ({score_pct}%) pour ce poste ne semblent pas être atteintes.",
        },
        "outils": {
            "excellent": f"Votre maîtrise des outils informatiques ({score_pct}%) est un avantage certain.",
            "bon": f"Les outils que vous maîtrisez ({score_pct}%) sont pertinents pour cette mission.",
            "moyen": f"Certains outils que vous mentionnez ({score_pct}%) sont utiles, mais l'offre pourrait en requérir d'autres.",
            "faible": f"Pensez à lister les outils informatiques (logiciels, langages, etc.) que vous maîtrisez pour enrichir votre profil ({score_pct}%).",
        },
        "projets": {
            "excellent": f"Vos projets personnels ({score_pct}%) illustrent parfaitement vos compétences et votre motivation pour ce type de poste.",
            "bon": f"Vos projets ({score_pct}%) sont un bon complément à votre profil et démontrent votre intérêt pour le domaine.",
            "moyen": f"Vos projets personnels ({score_pct}%) sont intéressants, mais pourraient être mieux alignés avec cette offre spécifique.",
            "faible": f"Ajouter ou mettre en avant des projets plus pertinents ({score_pct}%) renforcerait significativement votre candidature."
        }
    }

    if score_pct >= 85: level = "excellent"
    elif score_pct >= 60: level = "bon"
    elif score_pct >= 40: level = "moyen"
    else: level = "faible"

    # Fallback for unknown categories
    default_resume = {
        "excellent": f"Votre profil est excellent ({score_pct}%) sur ce point.",
        "bon": f"Votre profil est bon ({score_pct}%) sur ce point.",
        "moyen": f"Votre profil est moyen ({score_pct}%) sur ce point.",
        "faible": f"Votre profil est faible ({score_pct}%) sur ce point.",
    }
    
    return resumes.get(categorie.lower(), default_resume).get(level, "")


def analyze_projets_candidat(projets: List[ProjetPersonnel], offre: JobOffer) -> Tuple[List[str], List[str]]:
    """
    Analyse les projets personnels du candidat par rapport à l'offre d'emploi.
    
    Args:
        projets: Liste des projets personnels du candidat
        offre: Offre d'emploi analysée
        
    Returns:
        points_forts: Liste des points forts liés aux projets
        recommendations: Liste des recommandations d'amélioration
    """
    if not projets:
        return [], ["Ajouter des projets personnels pourrait renforcer votre candidature."]
    
    points_forts = []
    recommendations = []
    
    # Extraction des mots-clés pertinents depuis l'offre
    mots_cles_offre = set()
    if offre.description:
        mots_cles_offre.update(normalize_text(offre.description))
    
    # Ajout des compétences requises aux mots-clés
    for comp in offre.competences_requises:
        if comp.nom:
            mots_cles_offre.update(normalize_text(comp.nom))
    
    # Analyse de chaque projet
    projets_pertinents = []
    for projet in projets:
        pertinence_score = 0.0
        
        # Vérification de la description du projet
        if projet.description:
            mots_cles_projet = set(normalize_text(projet.description))
            # Calcul du nombre de mots-clés communs
            mots_communs = mots_cles_projet.intersection(mots_cles_offre)
            if mots_communs:
                pertinence_score += 0.5 * (len(mots_communs) / len(mots_cles_offre)) if mots_cles_offre else 0
        
        # Vérification des technologies utilisées
        if projet.technologies:
            for tech in projet.technologies:
                tech_normalized = normalize_text(tech)
                if any(kw in tech_normalized for kw in mots_cles_offre):
                    pertinence_score += 0.3
                    break
        
        # Vérification des compétences développées
        if projet.competences_developpees:
            for comp in projet.competences_developpees:
                comp_normalized = normalize_text(comp)
                if any(kw in comp_normalized for kw in mots_cles_offre):
                    pertinence_score += 0.3
                    break
        
        # Si le projet est pertinent, l'ajouter à la liste
        if pertinence_score > 0.4:
            projets_pertinents.append((projet, pertinence_score))
    
    # Tri des projets par pertinence
    projets_pertinents.sort(key=lambda x: x[1], reverse=True)
    
    # Génération des points forts et recommandations
    if projets_pertinents:
        # Prendre les 3 projets les plus pertinents
        for projet, score in projets_pertinents[:3]:
            points_forts.append(f"Projet '{projet.titre}' pertinent pour cette offre")
    else:
        recommendations.append("Vos projets actuels ne semblent pas directement liés à cette offre. Envisagez d'ajouter des projets plus pertinents.")
    
    # Recommandations générales si peu de projets
    if len(projets) < 3:
        recommendations.append("Enrichir votre profil avec plus de projets personnels démontrera votre motivation et vos compétences pratiques.")
    
    return points_forts, recommendations
