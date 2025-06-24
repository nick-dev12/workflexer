"""
Fonctions utilitaires pour l'analyse de compatibilité
"""

import logging
import re
from typing import Dict, List, Tuple, Set, Optional
from sentence_transformers import SentenceTransformer, util
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
)

# Charger le modèle pour l'analyse sémantique (multilingue)
semantic_model = SentenceTransformer("paraphrase-multilingual-MiniLM-L12-v2")
logger = logging.getLogger(__name__)

# Constantes pour l'analyse
COMPLETION_THRESHOLD = config.WEIGHTS.get("completion_threshold", 0.7)
EXPERIENCE_WEIGHT = config.WEIGHTS.get("experience", 0.35)
FORMATION_WEIGHT = config.WEIGHTS.get("formation", 0.25)
COMPETENCES_WEIGHT = config.WEIGHTS.get("competences", 0.25)
LANGUES_WEIGHT = config.WEIGHTS.get("langues", 0.15)


def extract_keywords_from_description(description: str) -> List[str]:
    """
    Extrait les mots-clés pertinents d'une description de poste.
    
    Args:
        description (str): Description du poste
        
    Returns:
        List[str]: Liste des mots-clés extraits
    """
    # Liste de mots à ignorer
    stop_words = {
        "le",
        "la",
        "les",
        "un",
        "une",
        "des",
        "ce",
        "ces",
        "son",
        "sa",
        "ses",
        "et",
        "ou",
        "mais",
        "donc",
        "car",
        "ni",
        "que",
        "qui",
        "quoi",
        "dont",
        "où",
        "pour",
        "dans",
        "sur",
        "avec",
        "sans",
        "par",
        "de",
        "à",
        "au",
        "aux",
        "en",
        "nous",
        "vous",
        "ils",
        "elles",
        "notre",
        "votre",
        "leur",
        "être",
        "avoir",
        "faire",
        "pouvoir",
        "devoir",
        "aller",
        "venir",
        "plus",
        "moins",
        "très",
        "peu",
        "beaucoup",
        "trop",
        "assez",
    }
    
    # Patterns pour extraire les compétences et technologies
    tech_patterns = [
        r"\b[A-Za-z]+[\+\#]?(?:\.[A-Za-z]+)*\b",  # Langages de programmation et technologies
        r"\b[A-Z][A-Za-z]*(?:\s*[A-Z][A-Za-z]*)*\b",  # Frameworks et outils
        r"[A-Za-z]+\s*(?:\d+(?:\.\d+)*)",  # Versions de technologies
    ]
    
    # Extraction des sections importantes
    sections = {
        "missions": r"(?:Missions|Responsabilités|Tâches)\s*:?\s*(.*?)(?:\n\n|\Z)",
        "profil": r"(?:Profil|Compétences|Prérequis)\s*:?\s*(.*?)(?:\n\n|\Z)",
        "technologies": r"(?:Technologies|Stack|Environnement technique)\s*:?\s*(.*?)(?:\n\n|\Z)",
    }
    
    keywords = set()
    
    # Nettoyage du texte
    text = description.lower()
    text = re.sub(r"[^\w\s\-\.]", " ", text)
    
    # Extraction des mots-clés par section
    for section_name, pattern in sections.items():
        matches = re.findall(pattern, description, re.IGNORECASE | re.DOTALL)
        for match in matches:
            # Extraction des technologies
            for tech_pattern in tech_patterns:
                techs = re.findall(tech_pattern, match)
                keywords.update(tech.strip() for tech in techs if len(tech.strip()) > 2)
            
            # Extraction des autres mots-clés
            words = match.lower().split()
            keywords.update(
                word for word in words if word not in stop_words and len(word) > 2
            )
    
    # Extraction des compétences spécifiques
    competences_patterns = [
        r"(?:maîtrise|connaissance|expertise)\s+(?:de|en|du|des)?\s+([^,\.;]+)",
        r"(?:expérience\s+(?:en|avec|sur))\s+([^,\.;]+)",
        r"(?:compétences?\s+(?:en|sur|avec))\s+([^,\.;]+)",
    ]
    
    for pattern in competences_patterns:
        matches = re.findall(pattern, description, re.IGNORECASE)
        for match in matches:
            words = match.lower().split()
            keywords.update(
                word for word in words if word not in stop_words and len(word) > 2
            )
    
    # Filtrage et nettoyage final
    cleaned_keywords = {
        keyword.strip()
        for keyword in keywords
        if len(keyword.strip()) > 2 and not keyword.strip().isdigit()
    }
    
    return list(cleaned_keywords)


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

    # Analyse du niveau d'études
    niveau_requis = exigence.niveau_valeur if hasattr(exigence, 'niveau_valeur') else get_niveau_etudes_value(exigence.niveau_minimum)
    
    # Utiliser directement la valeur numérique du niveau d'étude si disponible
    if niveau_etude_valeur is not None:
        niveau_max_candidat = niveau_etude_valeur
    else:
        # Extraire le niveau d'études du texte
        niveau_max_candidat = get_niveau_etudes_value(niveau_etude_profil) if niveau_etude_profil else 0

    # Comparaison des niveaux
    if niveau_max_candidat >= niveau_requis:
        score_niveau = 1.0
        if niveau_etude_profil:
            points_forts.append(f"Niveau d'études ({niveau_etude_profil}) supérieur ou égal au niveau requis ({exigence.niveau_minimum})")
    else:
        score_niveau = max(0, 0.5 * (niveau_max_candidat / niveau_requis if niveau_requis > 0 else 1))
        if niveau_requis > 0:
            recommendations.append(
                f"Le niveau d'études requis est {exigence.niveau_minimum}, "
                f"alors que votre niveau actuel est {niveau_etude_profil or 'Non spécifié'}"
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
        embeddings1 = semantic_model.encode([domain1], convert_to_tensor=True, show_progress_bar=False)
        embeddings2 = semantic_model.encode([domain2], convert_to_tensor=True, show_progress_bar=False)
        
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
    niveau_experience_valeur: Optional[int] = None
) -> Tuple[float, List[str], List[str]]:
    """Analyse approfondie de la compatibilité des expériences professionnelles."""
    points_forts = []
    recommendations = []
    
    # Analyse de la durée d'expérience
    if niveau_experience_valeur is not None:
        duree_totale_annees = niveau_experience_valeur
        duree_totale = duree_totale_annees * 12
    else:
        duree_totale = sum(exp.duree_mois for exp in experiences)
        duree_totale_annees = duree_totale / 12
    
    # Analyse des exigences d'expérience
    if exigence.niveau == "Non spécifié":
        return 1.0, ["Aucune expérience spécifique requise."], []
    elif exigence.niveau == "Etudiant, jeune diplômé":
        # Pas d'expérience minimale requise
        if duree_totale > 0:
            msg = f"Vous avez {duree_totale_annees:.1f} ans d'expérience, ce qui est un plus."
            points_forts.append(msg)
            return 1.0, points_forts, []
        else:
            return 0.8, [], ["Une première expérience serait un plus."]
    else:
        # Convertir l'exigence en mois
        duree_requise = exigence.duree_minimum_mois
        
        if duree_totale >= duree_requise:
            msg = f"Vous avez {duree_totale_annees:.1f} ans d'expérience, ce qui répond aux exigences."
            points_forts.append(msg)
            score = 1.0
        else:
            manque_mois = duree_requise - duree_totale
            manque_annees = manque_mois / 12
            recommendations.append(
                f"Il vous manque {manque_annees:.1f} ans d'expérience par rapport au minimum requis."
            )
            score = min(0.8, duree_totale / duree_requise)
    
    return score, points_forts, recommendations


def analyze_competences_compatibility(
    candidate_competences: List[Competence], required_competences: List[Competence]
) -> Tuple[float, List[str], List[str]]:
    """Analyse sémantique de la compatibilité des compétences en utilisant le traitement par lots."""
    details, recommendations, points_forts = [], [], []

    if not required_competences:
        return 1.0, ["Aucune compétence spécifique n'est requise."], []

    if not candidate_competences:
        reco_text = (
            f"Le profil ne liste aucune compétence. Compétences à ajouter : "
            f"{', '.join([c.nom for c in required_competences])}"
        )
        recommendations.append(reco_text)
        return 0.0, [], recommendations

    # Extraire les noms des compétences
    req_comp_names = [c.nom for c in required_competences]
    cand_comp_names = [c.nom for c in candidate_competences]

    # Créer des groupes de compétences similaires
    competences_groupes = {
        "developpement": [
            "git",
            "python",
            "java",
            "javascript",
            "php",
            "c++",
            "ruby",
            "swift",
        ],
        "vente": ["vente", "négociation", "commercial", "prospection", "crm"],
        "marketing": [
            "marketing",
            "communication",
            "publicité",
            "réseaux sociaux",
            "seo",
        ],
        "gestion": ["gestion de projet", "management", "planification", "organisation"],
        "design": ["design", "ui", "ux", "photoshop", "illustrator", "figma"],
    }

    # Vérifier d'abord les correspondances exactes
    competences_correspondantes = set()
    competences_manquantes = set(r.lower() for r in req_comp_names)
    
    # 1. Correspondance exacte
    for req_comp in req_comp_names:
        req_comp_lower = req_comp.lower()
        for cand_comp in cand_comp_names:
            if cand_comp.lower() == req_comp_lower:
                competences_correspondantes.add(req_comp)
                if req_comp_lower in competences_manquantes:
                    competences_manquantes.remove(req_comp_lower)
                points_forts.append(f"Compétence requise '{req_comp}' maîtrisée.")

    # 2. Correspondance par groupe
    for req_comp in req_comp_names:
        if req_comp.lower() not in competences_correspondantes:
            req_groupe = None
            for groupe, comps in competences_groupes.items():
                if req_comp.lower() in [c.lower() for c in comps]:
                    req_groupe = groupe
                    break
            
            if req_groupe:
                for cand_comp in cand_comp_names:
                    if cand_comp.lower() in [
                        c.lower() for c in competences_groupes[req_groupe]
                    ]:
                        competences_correspondantes.add(req_comp)
                        if req_comp.lower() in competences_manquantes:
                            competences_manquantes.remove(req_comp.lower())
                        points_forts.append(
                            f"Compétence requise '{req_comp}' couverte par votre compétence "
                            f"'{cand_comp}' (même domaine)."
                        )
                        break

    # 3. Correspondance sémantique uniquement pour les compétences restantes
    if competences_manquantes:
        # Encoder les compétences restantes
        remaining_req = [
            c for c in req_comp_names if c.lower() in competences_manquantes
        ]
        if remaining_req:
            req_embeddings = semantic_model.encode(
                remaining_req, convert_to_tensor=True, show_progress_bar=False
            )
            cand_embeddings = semantic_model.encode(
                cand_comp_names, convert_to_tensor=True, show_progress_bar=False
            )
            
            # Augmenter le seuil de similarité
            cosine_scores = util.pytorch_cos_sim(req_embeddings, cand_embeddings)
            for i, req_comp in enumerate(remaining_req):
                best_match_score = cosine_scores[i].max().item()
                
                # Utiliser le seuil de similarité configuré
                if best_match_score > config.SIMILARITY_THRESHOLD:
                    matched_cand_index = cosine_scores[i].argmax().item()
                    matched_cand_name = cand_comp_names[matched_cand_index]
                    
                    competences_correspondantes.add(req_comp)
                    if req_comp.lower() in competences_manquantes:
                        competences_manquantes.remove(req_comp.lower())
                    points_forts.append(
                        f"Compétence requise '{req_comp}' similaire à votre compétence "
                        f"'{matched_cand_name}'."
                    )

    # Générer les détails et recommandations
    if competences_correspondantes:
        details.append(
            f"Compétences maîtrisées : {', '.join(competences_correspondantes)}."
        )

    if competences_manquantes:
        recommendations.append(
            f"Compétences à développer ou à mieux décrire : "
            f"{', '.join(c.capitalize() for c in competences_manquantes)}."
        )

    score = (
        len(competences_correspondantes) / len(required_competences)
        if required_competences
        else 1.0
    )

    # Ne retourner les points forts que si le score est suffisant
    if score < 0.3:  # Moins de 30% de correspondance
        points_forts = []  # Réinitialiser les points forts si le score est trop faible
        
    return score, details + points_forts, recommendations


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
    """Génère une synthèse textuelle à partir des résultats de l'analyse."""
    score = round(global_score)
    
    if score >= 75:
        intro = f"Avec un score de {score}%, votre profil est en excellente adéquation avec cette offre. "
        conclusion = "Vous êtes un candidat très prometteur pour ce poste."
    elif score >= 50:
        intro = (
            f"Votre profil correspond à {score}%, ce qui représente une bonne base. "
        )
        conclusion = "Avec quelques ajustements, votre candidature pourrait être encore plus forte."
    else:
        intro = f"Votre profil correspond à {score}%. Il existe des écarts notables avec les exigences du poste. "
        conclusion = "Considérez les pistes d'amélioration pour renforcer votre profil pour ce type de rôle."

    points_forts = []
    for section in analyses.values():
        if section.get("points_forts"):
            points_forts.extend(
                section["points_forts"][:1]
            )  # On prend le 1er point fort de chaque section

    if points_forts:
        intro += f"Vos principaux atouts sont {', '.join(points_forts).lower()}. "
    
    return intro + conclusion


def analyze_compatibility(candidate_data: Dict, job_offer_data: Dict) -> Dict:
    """Analyse complète et génère un rapport structuré."""
    try:
        # Validation et nettoyage des données d'entrée
        candidate_data = {k: v for k, v in candidate_data.items() if v is not None}
        job_offer_data = {k: v for k, v in job_offer_data.items() if v is not None}
        
        # Initialisation des objets avec gestion des valeurs par défaut
        profile = CandidatProfile(**candidate_data)
        offer = JobOffer(**job_offer_data)
        
        # S'assurer que les listes ne sont pas None
        profile.formations = profile.formations or []
        profile.experiences = profile.experiences or []
        profile.competences = profile.competences or []
        profile.langues = profile.langues or []
        
        # S'assurer que les listes requises ne sont pas None dans l'offre
        if not hasattr(offer.formation_requise, "domaines_acceptes"):
            offer.formation_requise.domaines_acceptes = []
        if not hasattr(offer.experience_requise, "competences_requises"):
            offer.experience_requise.competences_requises = []
        if not hasattr(offer.experience_requise, "mots_cles_poste"):
            offer.experience_requise.mots_cles_poste = []
        
        # Analyse de la complétion du profil
        completion = analyze_profile_completion(profile)
        
        # Analyses détaillées par catégorie
        formation_score, f_details, f_reco = analyze_formation_compatibility(
            profile.formations, offer.formation_requise, profile.niveau_etude, profile.niveau_etude_valeur
        )
        
        experience_score, e_details, e_reco = analyze_experience_compatibility(
            profile.experiences, offer.experience_requise, profile.niveau_experience_valeur
        )
        
        competences_score, c_details, c_reco = analyze_competences_compatibility(
            profile.competences, offer.competences_requises
        )
        
        langues_score, l_details, l_reco = analyze_langues_compatibility(
            profile.langues, offer.langues_requises or []
        )
        
        # Calcul du score global pondéré
        global_score = (
            formation_score * FORMATION_WEIGHT
            + experience_score * EXPERIENCE_WEIGHT
            + competences_score * COMPETENCES_WEIGHT
            + langues_score * LANGUES_WEIGHT
        ) * 100
        
        # Identification des lacunes critiques
        gaps = identify_critical_gaps(profile, offer)
        
        # Génération des suggestions d'amélioration
        suggestions = generate_improvement_suggestions(
            profile,
            offer,
            {
            "formation_reco": f_reco,
            "experience_reco": e_reco,
            "competences_reco": c_reco,
                "langues_reco": l_reco,
            },
        )
        
        # Construction de la nouvelle structure de réponse
        
        # 1. Création des analyses catégorielles
        formation_analyse = AnalyseCategorielle(
            categorie="Formation",
            score=round(formation_score * 100),
            points_forts=[d for d in f_details if "supérieur" in d.lower() or "adéquation" in d.lower()],
            points_amelioration=f_reco,
            resume=generate_section_resume("formation", formation_score, f_details, f_reco)
        )
        
        experience_analyse = AnalyseCategorielle(
            categorie="Expérience Professionnelle",
            score=round(experience_score * 100),
            points_forts=[d for d in e_details if "similaires" in d.lower() or "supérieure" in d.lower()],
            points_amelioration=e_reco,
            resume=generate_section_resume("expérience", experience_score, e_details, e_reco)
        )
        
        competences_analyse = AnalyseCategorielle(
            categorie="Compétences",
            score=round(competences_score * 100),
            points_forts=[d for d in c_details if "couverte par" in d.lower() or "maîtrisée" in d.lower()],
            points_amelioration=c_reco,
            resume=generate_section_resume("compétences", competences_score, c_details, c_reco)
        )
        
        langues_analyse = AnalyseCategorielle(
            categorie="Langues",
            score=round(langues_score * 100),
            points_forts=l_details,
            points_amelioration=l_reco,
            resume=generate_section_resume("langues", langues_score, l_details, l_reco)
        )
        
        analyse_detaillee = AnalyseDetaillee(
            formation=formation_analyse,
            experience=experience_analyse,
            competences=competences_analyse,
            langues=langues_analyse
        )
        
        # 2. Extraction des points forts globaux
        points_forts = []
        
        # Points forts de formation
        for detail in f_details:
            if "supérieur" in detail.lower() or "adéquation" in detail.lower():
                points_forts.append(PointFort(
                    description=detail,
                    categorie="formation",
                    importance="important" if "supérieur" in detail.lower() else "normal"
                ))
        
        # Points forts d'expérience
        for detail in e_details:
            if "similaires" in detail.lower() or "supérieure" in detail.lower():
                points_forts.append(PointFort(
                    description=detail,
                    categorie="experience",
                    importance="important"
                ))
        
        # Points forts de compétences
        for detail in c_details:
            if "maîtrisée" in detail.lower() or "couverte par" in detail.lower():
                points_forts.append(PointFort(
                    description=detail,
                    categorie="competence",
                    importance="important" if "maîtrisée" in detail.lower() else "normal"
                ))
        
        # Points forts de langues
        for detail in l_details:
            if detail != "Aucune exigence linguistique spécifique":
                points_forts.append(PointFort(
                    description=detail,
                    categorie="langue",
                    importance="normal"
                ))
        
        # 3. Extraction des points d'amélioration
        points_amelioration = []
        
        # Améliorations de formation
        for reco in f_reco:
            points_amelioration.append(PointAmelioration(
                description=reco,
                categorie="formation",
                priorite="haute" if "requis" in reco.lower() else "normale",
                suggestion=f"Envisager une formation complémentaire dans ce domaine"
            ))
        
        # Améliorations d'expérience
        for reco in e_reco:
            priorite = "haute" if "minimum requis" in reco.lower() else "normale"
            points_amelioration.append(PointAmelioration(
                description=reco,
                categorie="experience",
                priorite=priorite,
                suggestion=f"Valoriser vos projets et stages en lien avec ces compétences"
            ))
        
        # Améliorations de compétences
        for reco in c_reco:
            points_amelioration.append(PointAmelioration(
                description=reco,
                categorie="competence",
                priorite="haute",
                suggestion=f"Suivre des formations ou réaliser des projets personnels"
            ))
        
        # Améliorations de langues
        for reco in l_reco:
            points_amelioration.append(PointAmelioration(
                description=reco,
                categorie="langue",
                priorite="moyenne",
                suggestion=f"Pratiquer régulièrement cette langue"
            ))
        
        # 4. Génération des suggestions personnalisées
        suggestions_list = []
        for sugg in suggestions:
            suggestions_list.append(Suggestion(
                categorie=sugg.get("type", "general"),
                description=sugg.get("suggestion", ""),
                priorite=sugg.get("priorite", "normale"),
                impact_estime="fort" if sugg.get("priorite") == "haute" else "moyen"
            ))
        
        # 5. Génération du résumé global
        resume = generate_synthesis(global_score, {
            "formation": {"points_forts": formation_analyse.points_forts},
            "experience": {"points_forts": experience_analyse.points_forts},
            "competences": {"points_forts": competences_analyse.points_forts},
            "langues": {"points_forts": langues_analyse.points_forts}
        })
        
        # 6. Détermination du niveau d'adéquation
        niveau_adequation = "Excellent" if global_score >= 75 else "Bon" if global_score >= 50 else "Moyen" if global_score >= 30 else "À améliorer"
        
        # Création de la réponse au nouveau format
        response_v2 = MatchingResponseV2(
            score_global=round(global_score, 1),
            niveau_adequation=niveau_adequation,
            resume=resume,
            points_forts=points_forts,
            points_amelioration=points_amelioration,
            analyse_detaillee=analyse_detaillee,
            suggestions=suggestions_list
        )
        
        # Pour la compatibilité avec l'ancien format
        analyses = {
            "formation": {
                "titre": "Formation",
                "score": round(formation_score * 100),
                "points_forts": formation_analyse.points_forts,
                "points_faibles": formation_analyse.points_amelioration,
            },
            "experience": {
                "titre": "Expérience Professionnelle",
                "score": round(experience_score * 100),
                "points_forts": experience_analyse.points_forts,
                "points_faibles": experience_analyse.points_amelioration,
            },
            "competences": {
                "titre": "Compétences",
                "score": round(competences_score * 100),
                "points_forts": competences_analyse.points_forts,
                "points_faibles": competences_analyse.points_amelioration,
            },
            "langues": {
                "titre": "Langues",
                "score": round(langues_score * 100),
                "points_forts": langues_analyse.points_forts,
                "points_faibles": langues_analyse.points_amelioration,
            },
        }
        
        # Conversion du nouveau format vers l'ancien format pour la rétrocompatibilité
        response = {
            "global_score": round(global_score, 1),
            "completion": completion,
            "analyses": analyses,
            "synthesis": resume,
            "adequation_globale": niveau_adequation,
            # Nouveaux champs pour une meilleure structuration
            "resume_correspondance": resume,
            "atouts_majeurs": [{"categorie": pf.categorie, "description": pf.description} for pf in points_forts],
            "elements_manquants": [{"categorie": pa.categorie, "description": pa.description} for pa in points_amelioration],
            "suggestions_amelioration": [{"categorie": s.categorie, "description": s.description} for s in suggestions_list],
        }
        
        # Retourner la réponse au format souhaité (nouveau format V2)
        return response_v2.dict()
        
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse: {str(e)}", exc_info=True)
        raise


def generate_section_resume(categorie: str, score: float, details: List[str], recommandations: List[str]) -> str:
    """Génère un résumé textuel pour une section d'analyse."""
    score_pct = round(score * 100)
    
    if score_pct >= 80:
        niveau = "excellente"
    elif score_pct >= 60:
        niveau = "bonne"
    elif score_pct >= 40:
        niveau = "moyenne"
    else:
        niveau = "faible"
    
    resume = f"Votre profil présente une {niveau} adéquation ({score_pct}%) en termes de {categorie}. "
    
    # Ajouter les points forts s'il y en a
    points_forts_significatifs = [d for d in details if len(d) > 5][:2]  # Limiter à 2 points forts
    if points_forts_significatifs:
        resume += f"Points forts : {' '.join(points_forts_significatifs)}. "
    
    # Ajouter les recommandations principales s'il y en a
    if recommandations and score < 0.7:  # Ne montrer les recommandations que si le score est inférieur à 70%
        recommandations_principales = recommandations[:1]  # Limiter à 1 recommandation
        resume += f"Suggestion : {' '.join(recommandations_principales)}."
    
    return resume
