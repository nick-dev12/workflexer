"""
Fonctions utilitaires pour l'analyse de compatibilité
"""
import logging
import re
from typing import Dict, List, Tuple, Set, Optional
from sentence_transformers import SentenceTransformer, util
from models import (
    CandidatProfile, JobOffer, MatchingResponse,
    Formation, Experience, Competence, Langue, ExigenceFormation, ExigenceExperience
)

# Charger le modèle pour l'analyse sémantique (multilingue)
semantic_model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')
logger = logging.getLogger(__name__)

# Constantes pour l'analyse
COMPLETION_THRESHOLD = 0.7  # Seuil minimum de complétion du profil
EXPERIENCE_WEIGHT = 0.35
FORMATION_WEIGHT = 0.25
COMPETENCES_WEIGHT = 0.25
LANGUES_WEIGHT = 0.15

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
        'le', 'la', 'les', 'un', 'une', 'des', 'ce', 'ces', 'son', 'sa', 'ses',
        'et', 'ou', 'mais', 'donc', 'car', 'ni', 'que', 'qui', 'quoi', 'dont',
        'où', 'pour', 'dans', 'sur', 'avec', 'sans', 'par', 'de', 'à', 'au',
        'aux', 'en', 'nous', 'vous', 'ils', 'elles', 'notre', 'votre', 'leur',
        'être', 'avoir', 'faire', 'pouvoir', 'devoir', 'aller', 'venir',
        'plus', 'moins', 'très', 'peu', 'beaucoup', 'trop', 'assez',
    }
    
    # Patterns pour extraire les compétences et technologies
    tech_patterns = [
        r'\b[A-Za-z]+[\+\#]?(?:\.[A-Za-z]+)*\b',  # Langages de programmation et technologies
        r'\b[A-Z][A-Za-z]*(?:\s*[A-Z][A-Za-z]*)*\b',  # Frameworks et outils
        r'[A-Za-z]+\s*(?:\d+(?:\.\d+)*)',  # Versions de technologies
    ]
    
    # Extraction des sections importantes
    sections = {
        'missions': r'(?:Missions|Responsabilités|Tâches)\s*:?\s*(.*?)(?:\n\n|\Z)',
        'profil': r'(?:Profil|Compétences|Prérequis)\s*:?\s*(.*?)(?:\n\n|\Z)',
        'technologies': r'(?:Technologies|Stack|Environnement technique)\s*:?\s*(.*?)(?:\n\n|\Z)',
    }
    
    keywords = set()
    
    # Nettoyage du texte
    text = description.lower()
    text = re.sub(r'[^\w\s\-\.]', ' ', text)
    
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
            keywords.update(word for word in words 
                          if word not in stop_words and len(word) > 2)
    
    # Extraction des compétences spécifiques
    competences_patterns = [
        r'(?:maîtrise|connaissance|expertise)\s+(?:de|en|du|des)?\s+([^,\.;]+)',
        r'(?:expérience\s+(?:en|avec|sur))\s+([^,\.;]+)',
        r'(?:compétences?\s+(?:en|sur|avec))\s+([^,\.;]+)',
    ]
    
    for pattern in competences_patterns:
        matches = re.findall(pattern, description, re.IGNORECASE)
        for match in matches:
            words = match.lower().split()
            keywords.update(word for word in words 
                          if word not in stop_words and len(word) > 2)
    
    # Filtrage et nettoyage final
    cleaned_keywords = {
        keyword.strip() for keyword in keywords
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
    "Doctorat": {"niveau": 8, "equivalents": ["PhD", "Doctorate"]}
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
        formations_score = sum(1 for f in profile.formations 
                             if f.niveau and f.domaine and f.etablissement) / len(profile.formations)
        scores["formations"] = formations_score
    else:
        scores["formations"] = 0.0
    
    # Vérification des expériences
    if profile.experiences:
        experiences_score = sum(1 for e in profile.experiences 
                              if e.titre_poste and e.description and e.competences) / len(profile.experiences)
        scores["experiences"] = experiences_score
    else:
        scores["experiences"] = 0.0
    
    # Vérification des compétences
    if profile.competences:
        competences_score = sum(1 for c in profile.competences 
                              if c.nom and c.niveau) / len(profile.competences)
        scores["competences"] = competences_score
    else:
        scores["competences"] = 0.0
    
    # Vérification des langues
    if profile.langues:
        langues_score = sum(1 for l in profile.langues 
                           if l.nom and l.niveau) / len(profile.langues)
        scores["langues"] = langues_score
    else:
        scores["langues"] = 0.0
    
    # Score global pondéré
    global_score = (
        scores["formations"] * 0.3 +
        scores["experiences"] * 0.3 +
        scores["competences"] * 0.25 +
        scores["langues"] * 0.15
    )
    
    return {
        "score": global_score,
        "details": {
            "formations": scores["formations"],
            "experiences": scores["experiences"],
            "competences": scores["competences"],
            "langues": scores["langues"]
        }
    }

def analyze_formation_compatibility(
    formations: List[Formation],
    exigence: ExigenceFormation,
    niveau_etude_profil: Optional[str]
) -> Tuple[float, List[str], List[str]]:
    """Analyse de la compatibilité des formations, incluant le niveau d'étude global."""
    details = []
    recommendations = []
    points_forts = []
    score_total = 0.0
    
    if not exigence.domaines_acceptes and exigence.niveau_minimum == "Non spécifié":
        return 1.0, ["Aucune exigence de formation spécifique."], []

    # Analyse du niveau d'études
    niveau_requis = get_niveau_etudes_value(exigence.niveau_minimum)
    formations_par_niveau = {}
    for f in formations:
        niveau = get_niveau_etudes_value(f.niveau)
        if niveau not in formations_par_niveau:
            formations_par_niveau[niveau] = []
        formations_par_niveau[niveau].append(f)

    # Score pour le niveau d'études (50% du score total)
    niveau_max_candidat = max(formations_par_niveau.keys()) if formations_par_niveau else 0
    if niveau_max_candidat >= niveau_requis:
        score_niveau = 0.5
        if niveau_max_candidat > niveau_requis:
            points_forts.append(f"Niveau d'études supérieur au minimum requis ({list(formations_par_niveau[niveau_max_candidat])[0].niveau})")
    else:
        score_niveau = max(0, 0.5 * (niveau_max_candidat / niveau_requis))
        recommendations.append(f"Le niveau d'études minimum requis est {exigence.niveau_minimum}")
    
    score_total += score_niveau

    # Analyse des domaines de formation (50% du score total)
    if exigence.domaines_acceptes:
        domaines_requis = set(d.lower() for d in exigence.domaines_acceptes)
        domaines_candidat = set(f.domaine.lower() for f in formations if f.domaine)
        
        # Vérifier les correspondances exactes
        domaines_correspondants = domaines_requis.intersection(domaines_candidat)
        
        # Vérifier les correspondances partielles
        domaines_partiels = set()
        for domaine_requis in domaines_requis - domaines_correspondants:
            for domaine_candidat in domaines_candidat:
                # Vérifier si le domaine requis est une partie du domaine du candidat
                if domaine_requis in domaine_candidat or domaine_candidat in domaine_requis:
                    domaines_partiels.add(domaine_requis)
                    break
        
        # Calculer le score des domaines
        score_domaines = 0.5 * (len(domaines_correspondants) + 0.5 * len(domaines_partiels)) / len(domaines_requis)
        score_total += score_domaines
        
        # Ajouter les points forts et recommandations pour les domaines
        if domaines_correspondants:
            points_forts.append(f"Formation(s) dans le(s) domaine(s) requis : {', '.join(domaines_correspondants)}")
        if domaines_partiels:
            points_forts.append(f"Formation(s) partiellement correspondante(s) : {', '.join(domaines_partiels)}")
        
        domaines_manquants = domaines_requis - domaines_correspondants - domaines_partiels
        if domaines_manquants:
            recommendations.append(f"Une formation dans l'un de ces domaines serait un plus : {', '.join(domaines_manquants)}")
    else:
        score_total += 0.5  # Score maximum pour les domaines si aucun domaine n'est spécifié

    # Ne garder les points forts que si le score total est suffisant
    if score_total < 0.4:  # Moins de 40% de correspondance
        points_forts = []  # Réinitialiser les points forts si le score est trop faible

    return score_total, points_forts, recommendations

def analyze_experience_compatibility(
    experiences: List[Experience],
    exigence: ExigenceExperience
) -> Tuple[float, List[str], List[str]]:
    """Analyse approfondie de la compatibilité des expériences professionnelles."""
    details = []
    recommendations = []
    points_forts = []
    
    # Analyse de la durée d'expérience
    duree_totale = sum(exp.duree_mois for exp in experiences)
    experiences_recentes = [exp for exp in experiences if exp.duree_mois >= 6]  # Expériences significatives
    
    score_duree = 1.0
    if exigence.duree_minimum_mois > 0:
        if duree_totale >= exigence.duree_minimum_mois:
            details.append(f"Expérience totale de {duree_totale / 12:.1f} ans ({exigence.duree_minimum_mois / 12:.1f} ans requis)")
            if duree_totale >= exigence.duree_minimum_mois * 1.5:
                points_forts.append("Expérience significativement supérieure au minimum requis")
            score_duree = min(2.0, duree_totale / exigence.duree_minimum_mois)
        else:
            manque = exigence.duree_minimum_mois - duree_totale
            recommendations.append(f"Il manque {manque / 12:.1f} ans d'expérience pour atteindre le minimum requis")
            score_duree = duree_totale / exigence.duree_minimum_mois if exigence.duree_minimum_mois > 0 else 1.0
    
    # Analyse des compétences acquises
    competences_par_experience = {}
    for exp in experiences:
        if exp.competences:  # Vérification si competences n'est pas None
            for comp in exp.competences:
                if comp not in competences_par_experience:
                    competences_par_experience[comp] = 0
                competences_par_experience[comp] += exp.duree_mois

    competences_requises = set(exigence.competences_requises) if exigence.competences_requises else set()
    competences_maitrisees = {comp for comp, duree in competences_par_experience.items() 
                            if duree >= 12}  # Compétences avec au moins 1 an d'expérience
    
    score_competences = 0.0
    if competences_requises:
        competences_correspondantes = competences_maitrisees.intersection(competences_requises)
        if competences_correspondantes:
            details.append(f"Maîtrise confirmée de : {', '.join(competences_correspondantes)}")
            if len(competences_correspondantes) >= len(competences_requises) * 0.8:
                points_forts.append("Excellente maîtrise des compétences techniques requises")
        
        competences_manquantes = competences_requises - competences_maitrisees
        if competences_manquantes:
            recommendations.append(f"Compétences à développer : {', '.join(competences_manquantes)}")
        
        score_competences = len(competences_correspondantes) / len(competences_requises)
    else:
        score_competences = 1.0
        if competences_maitrisees:
            details.append(f"Compétences techniques maîtrisées : {', '.join(competences_maitrisees)}")

    # Analyse des postes occupés
    if experiences_recentes and exigence.mots_cles_poste:
        postes_similaires = [exp for exp in experiences_recentes 
                           if exp.titre_poste and  # Vérification si titre_poste n'est pas None
                           any(mot.lower() in exp.titre_poste.lower() 
                               for mot in exigence.mots_cles_poste)]
        if postes_similaires:
            points_forts.append(f"A occupé des postes similaires : {', '.join(e.titre_poste for e in postes_similaires)}")
    
    # Score final pondéré
    score = (score_duree * 0.5) + (score_competences * 0.5)
    return score, details + points_forts, recommendations

def analyze_competences_compatibility(
    candidate_competences: List[Competence],
    required_competences: List[Competence]
) -> Tuple[float, List[str], List[str]]:
    """Analyse sémantique de la compatibilité des compétences en utilisant le traitement par lots."""
    details, recommendations, points_forts = [], [], []

    if not required_competences:
        return 1.0, ["Aucune compétence spécifique n'est requise."], []

    if not candidate_competences:
        reco_text = f"Le profil ne liste aucune compétence. Compétences à ajouter : {', '.join([c.nom for c in required_competences])}"
        recommendations.append(reco_text)
        return 0.0, [], recommendations

    # Extraire les noms des compétences
    req_comp_names = [c.nom for c in required_competences]
    cand_comp_names = [c.nom for c in candidate_competences]

    # Créer des groupes de compétences similaires
    competences_groupes = {
        "developpement": ["git", "python", "java", "javascript", "php", "c++", "ruby", "swift"],
        "vente": ["vente", "négociation", "commercial", "prospection", "crm"],
        "marketing": ["marketing", "communication", "publicité", "réseaux sociaux", "seo"],
        "gestion": ["gestion de projet", "management", "planification", "organisation"],
        "design": ["design", "ui", "ux", "photoshop", "illustrator", "figma"]
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
                    if cand_comp.lower() in [c.lower() for c in competences_groupes[req_groupe]]:
                        competences_correspondantes.add(req_comp)
                        if req_comp.lower() in competences_manquantes:
                            competences_manquantes.remove(req_comp.lower())
                        points_forts.append(f"Compétence requise '{req_comp}' couverte par votre compétence '{cand_comp}' (même domaine).")
                        break

    # 3. Correspondance sémantique uniquement pour les compétences restantes
    if competences_manquantes:
        # Encoder les compétences restantes
        remaining_req = [c for c in req_comp_names if c.lower() in competences_manquantes]
        if remaining_req:
            req_embeddings = semantic_model.encode(remaining_req, convert_to_tensor=True, show_progress_bar=False)
            cand_embeddings = semantic_model.encode(cand_comp_names, convert_to_tensor=True, show_progress_bar=False)
            
            # Augmenter le seuil de similarité
            cosine_scores = util.pytorch_cos_sim(req_embeddings, cand_embeddings)
            for i, req_comp in enumerate(remaining_req):
                best_match_score = cosine_scores[i].max().item()
                
                # Seuil de similarité plus strict
                if best_match_score > 0.85:  # Augmenté de 0.65 à 0.85
                    matched_cand_index = cosine_scores[i].argmax().item()
                    matched_cand_name = cand_comp_names[matched_cand_index]
                    
                    competences_correspondantes.add(req_comp)
                    if req_comp.lower() in competences_manquantes:
                        competences_manquantes.remove(req_comp.lower())
                    points_forts.append(f"Compétence requise '{req_comp}' similaire à votre compétence '{matched_cand_name}'.")

    # Générer les détails et recommandations
    if competences_correspondantes:
        details.append(f"Compétences maîtrisées : {', '.join(competences_correspondantes)}.")

    if competences_manquantes:
        recommendations.append(f"Compétences à développer ou à mieux décrire : {', '.join(c.capitalize() for c in competences_manquantes)}.")

    score = len(competences_correspondantes) / len(required_competences) if required_competences else 1.0

    # Ne retourner les points forts que si le score est suffisant
    if score < 0.3:  # Moins de 30% de correspondance
        points_forts = []  # Réinitialiser les points forts si le score est trop faible
        
    return score, details + points_forts, recommendations

def analyze_langues_compatibility(
    langues: List[Langue],
    requises: List[Langue]
) -> Tuple[float, List[str], List[str]]:
    """Analyse approfondie de la compatibilité des langues."""
    if not requises:
        return 1.0, ["Aucune exigence linguistique spécifique"], []
    
    score = 0
    details = []
    recommendations = []
    points_forts = []
    
    niveaux_echelle = {
        'A1': 1, 'A2': 2, 'B1': 3, 'B2': 4, 'C1': 5, 'C2': 6
    }
    
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
                    points_forts.append(f"Niveau {langue_candidate.niveau} en {langue_requise.nom} (requis: {langue_requise.niveau})")
                else:
                    details.append(f"Niveau requis atteint en {langue_requise.nom}")
                
                if langue_candidate.certifications:
                    points_forts.append(f"Certifications en {langue_requise.nom}: {', '.join(langue_candidate.certifications)}")
            else:
                score += max(0, (niveau_candidat / niveau_requis) - 0.2)
                recommendations.append(
                    f"Améliorer le niveau en {langue_requise.nom} "
                    f"(actuel: {langue_candidate.niveau}, requis: {langue_requise.niveau})"
                )
        else:
            recommendations.append(f"Apprentissage recommandé : {langue_requise.nom} (niveau {langue_requise.niveau})")
    
    # Langues supplémentaires
    langues_supp = set(langues_dict.keys()) - {l.nom.lower() for l in requises}
    if langues_supp:
        points_forts.append(f"Langues supplémentaires maîtrisées : {', '.join(langues_supp)}")
    
    score_final = score / len(requises)
    return score_final, details + points_forts, recommendations

def identify_critical_gaps(
    profile: CandidatProfile,
    offer: JobOffer
) -> List[Dict[str, str]]:
    """Identifie les lacunes critiques du profil de manière détaillée."""
    gaps = []
    
    # Analyse formation
    if offer.formation_requise.formation_obligatoire:
        niveau_requis = get_niveau_etudes_value(offer.formation_requise.niveau_minimum)
        formations_suffisantes = [f for f in profile.formations 
                                if get_niveau_etudes_value(f.niveau) >= niveau_requis]
        if not formations_suffisantes:
            gaps.append({
                "categorie": "Formation",
                "description": f"Formation de niveau {offer.formation_requise.niveau_minimum} requise",
                "impact": "Critique",
                "suggestion": "Envisager une formation complémentaire ou validation des acquis"
            })
    
    # Analyse expérience
    experience_totale = sum(exp.duree_mois for exp in profile.experiences)
    if experience_totale < offer.experience_requise.duree_minimum_mois:
        manque = offer.experience_requise.duree_minimum_mois - experience_totale
        gaps.append({
            "categorie": "Expérience",
            "description": f"Il manque {manque/12:.1f} ans d'expérience",
            "impact": "Important",
            "suggestion": "Valoriser les stages et projets personnels en attendant"
        })
    
    # Analyse compétences essentielles
    competences_candidates = {c.nom.lower(): c for c in profile.competences}
    for comp_requise in offer.competences_requises:
        if comp_requise.niveau >= 4:  # Compétences critiques
            if comp_requise.nom.lower() not in competences_candidates:
                gaps.append({
                    "categorie": "Compétence",
                    "description": f"Compétence essentielle manquante : {comp_requise.nom}",
                    "impact": "Critique",
                    "suggestion": f"Formation recommandée en {comp_requise.nom}"
                })
            elif competences_candidates[comp_requise.nom.lower()].niveau < comp_requise.niveau - 1:
                gaps.append({
                    "categorie": "Compétence",
                    "description": f"Niveau insuffisant en {comp_requise.nom}",
                    "impact": "Important",
                    "suggestion": "Approfondir via des projets personnels ou formations"
                })
    
    return gaps

def generate_improvement_suggestions(
    profile: CandidatProfile,
    offer: JobOffer,
    recommendations: Dict[str, List[str]]
) -> List[Dict[str, str]]:
    """
    Génère des suggestions d'amélioration personnalisées basées sur le profil et l'offre.
    """
    suggestions = []
    
    # Analyse du secteur d'activité
    secteur = offer.secteur
    if secteur:
        experiences_secteur = [exp for exp in profile.experiences 
                             if exp.secteur and exp.secteur.lower() == secteur.lower()]
        if not experiences_secteur:
            suggestions.append({
                "type": "experience",
                "suggestion": f"Acquérir de l'expérience dans le secteur {secteur}",
                "priorite": "haute"
            })
    
    # Analyse des compétences manquantes
    competences_requises = {comp.nom.lower() for comp in offer.competences_requises}
    competences_candidat = {comp.nom.lower() for comp in profile.competences}
    competences_manquantes = competences_requises - competences_candidat
    
    if competences_manquantes:
        for comp in competences_manquantes:
            suggestions.append({
                "type": "competence",
                "suggestion": f"Développer la compétence : {comp}",
                "priorite": "haute"
            })
    
    # Analyse du niveau d'études
    if offer.formation_requise and offer.formation_requise.niveau_minimum != "Non spécifié":
        niveau_requis = offer.formation_requise.niveau_minimum
        niveaux_candidat = [f.niveau for f in profile.formations]
        if not any(niveau_satisfait_exigence(niveau, niveau_requis) for niveau in niveaux_candidat):
            suggestions.append({
                "type": "formation",
                "suggestion": f"Atteindre le niveau d'études requis : {niveau_requis}",
                "priorite": "haute"
            })
    
    # Suggestions spécifiques au secteur
    if secteur:
        certifications_recommandees = get_certifications_recommandees(secteur)
        for cert in certifications_recommandees:
            if not any(c.get("nom") == cert for c in profile.certifications or []):
                suggestions.append({
                    "type": "certification",
                    "suggestion": f"Obtenir la certification {cert} pertinente pour le secteur",
                    "priorite": "moyenne"
                })
    
    # Suggestions basées sur les tendances du marché
    tendances = get_tendances_marche(secteur) if secteur else []
    for tendance in tendances:
        if not any(comp.nom.lower() == tendance.lower() for comp in profile.competences):
            suggestions.append({
                "type": "tendance",
                "suggestion": f"Se former à {tendance}, une compétence en demande dans le secteur",
                "priorite": "moyenne"
            })
    
    # Intégration des recommandations spécifiques
    for categorie, recos in recommendations.items():
        for reco in recos:
            suggestions.append({
                "type": categorie.replace("_reco", ""),
                "suggestion": reco,
                "priorite": "normale"
            })
    
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
        "Doctorat": 8
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
        intro = f"Votre profil correspond à {score}%, ce qui représente une bonne base. "
        conclusion = "Avec quelques ajustements, votre candidature pourrait être encore plus forte."
    else:
        intro = f"Votre profil correspond à {score}%. Il existe des écarts notables avec les exigences du poste. "
        conclusion = "Considérez les pistes d'amélioration pour renforcer votre profil pour ce type de rôle."

    points_forts = []
    for section in analyses.values():
        if section.get('points_forts'):
            points_forts.extend(section['points_forts'][:1]) # On prend le 1er point fort de chaque section

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
        if not hasattr(offer.formation_requise, 'domaines_acceptes'):
            offer.formation_requise.domaines_acceptes = []
        if not hasattr(offer.experience_requise, 'competences_requises'):
            offer.experience_requise.competences_requises = []
        if not hasattr(offer.experience_requise, 'mots_cles_poste'):
            offer.experience_requise.mots_cles_poste = []
        
        # Analyse de la complétion du profil
        completion = analyze_profile_completion(profile)
        
        # Analyses détaillées par catégorie
        formation_score, f_details, f_reco = analyze_formation_compatibility(
            profile.formations, offer.formation_requise, profile.niveau_etude)
        
        experience_score, e_details, e_reco = analyze_experience_compatibility(
            profile.experiences, offer.experience_requise)
        
        competences_score, c_details, c_reco = analyze_competences_compatibility(
            profile.competences, offer.competences_requises)
        
        langues_score, l_details, l_reco = analyze_langues_compatibility(
            profile.langues, offer.langues_requises or [])
        
        # Calcul du score global pondéré
        global_score = (
            formation_score * FORMATION_WEIGHT +
            experience_score * EXPERIENCE_WEIGHT +
            competences_score * COMPETENCES_WEIGHT +
            langues_score * LANGUES_WEIGHT
        ) * 100
        
        # Identification des lacunes critiques
        gaps = identify_critical_gaps(profile, offer)
        
        # Génération des suggestions d'amélioration
        suggestions = generate_improvement_suggestions(profile, offer, {
            "formation_reco": f_reco,
            "experience_reco": e_reco,
            "competences_reco": c_reco,
            "langues_reco": l_reco
        })
        
        analyses = {
            "formation": {
                "titre": "Formation", "score": round(formation_score * 100),
                "points_forts": [d for d in f_details if "supérieur" in d.lower() or "adéquation" in d.lower()],
                "points_faibles": f_reco
            },
            "experience": {
                "titre": "Expérience Professionnelle", "score": round(experience_score * 100),
                "points_forts": [d for d in e_details if "similaires" in d.lower() or "supérieure" in d.lower()],
                "points_faibles": e_reco
            },
            "competences": {
                "titre": "Compétences", "score": round(competences_score * 100),
                "points_forts": [d for d in c_details if "couverte par" in d.lower()],
                "points_faibles": c_reco
            },
            "langues": {
                "titre": "Langues", "score": round(langues_score * 100),
                "points_forts": l_details,
                "points_faibles": l_reco
            }
        }
        
        # Génération de la synthèse
        synthesis_text = generate_synthesis(global_score, analyses)

        return {
            "global_score": round(global_score, 1),
            "completion": completion,
            "analyses": analyses,
            "synthesis": synthesis_text,
            "adequation_globale": "Excellent" if global_score >= 75 else "Bon" if global_score >= 50 else "À améliorer"
        }
        
    except Exception as e:
        logger.error(f"Erreur lors de l'analyse: {str(e)}", exc_info=True)
        raise