"""
Utilitaires pour l'API de matching WorkFlexer
"""

import re
import logging
from datetime import datetime
import os
import json
from typing import List, Dict, Tuple, Any, Union

# Import des configurations
from config import NIVEAUX_ETUDES, NIVEAUX_LANGUE, MAX_POINTS, RESULTATS_DIR

logger = logging.getLogger("api_matching")

def analyser_competences(competences_candidat: List[Dict[str, str]], 
                        competences_requises: List[str]) -> Tuple[float, Dict[str, Any]]:
    """Analyse la correspondance entre les compétences du candidat et celles requises."""
    # Version simple pour commencer
    score = 0
    total = len(competences_requises)
    points_forts = []
    points_a_ameliorer = []
    
    # Convertir les compétences du candidat en liste de noms pour faciliter la comparaison
    competences_candidat_noms = [comp["nom"].lower() for comp in competences_candidat]
    
    # Vérifier chaque compétence requise
    for comp_requise in competences_requises:
        comp_requise_lower = comp_requise.lower()
        if comp_requise_lower in competences_candidat_noms:
            score += 1
            points_forts.append(f"Compétence maîtrisée : {comp_requise}")
        else:
            points_a_ameliorer.append(f"Compétence à acquérir : {comp_requise}")
    
    # Calculer le score normalisé
    score_normalise = score / total if total > 0 else 0
    
    return score_normalise, {
        "score": score_normalise,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer,
        "competences_manquantes": [comp for comp in competences_requises if comp.lower() not in competences_candidat_noms]
    }

def analyser_formation(formations: List[Dict[str, Any]], 
                      niveau_requis: str) -> Tuple[float, Dict[str, Any]]:
    """Analyse si la formation du candidat correspond au niveau requis."""
    if not niveau_requis:
        return 1.0, {"score": 1.0, "points_forts": ["Aucun niveau d'études spécifique requis"], "points_a_ameliorer": []}
    
    # Trouver le niveau le plus élevé du candidat
    niveau_max_candidat = 0
    formation_max = None
    
    for formation in formations:
        for niveau_str, valeur in NIVEAUX_ETUDES.items():
            if niveau_str in formation["niveau"].lower() or niveau_str in formation["filiere"].lower():
                if valeur > niveau_max_candidat:
                    niveau_max_candidat = valeur
                    formation_max = formation
    
    # Trouver le niveau requis
    niveau_requis_valeur = 0
    for niveau_str, valeur in NIVEAUX_ETUDES.items():
        if niveau_str in niveau_requis.lower():
            niveau_requis_valeur = valeur
            break
    
    # Calculer le score
    if niveau_max_candidat >= niveau_requis_valeur:
        score = 1.0
        points_forts = [f"Niveau d'études suffisant : {formation_max['niveau'] if formation_max else 'Non spécifié'}"]
        points_a_ameliorer = []
    else:
        # Score proportionnel au niveau atteint
        score = niveau_max_candidat / niveau_requis_valeur if niveau_requis_valeur > 0 else 0
        points_forts = []
        points_a_ameliorer = [f"Niveau d'études requis : {niveau_requis} (vous avez {formation_max['niveau'] if formation_max else 'Non spécifié'})"]
    
    return score, {
        "score": score,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer
    }

def analyser_experience(experiences: List[Dict[str, Any]], 
                       annees_requises: int) -> Tuple[float, Dict[str, Any]]:
    """Analyse si l'expérience du candidat correspond aux années requises."""
    if not annees_requises:
        return 1.0, {"score": 1.0, "points_forts": ["Aucune expérience spécifique requise"], "points_a_ameliorer": []}
    
    # Calculer le nombre total d'années d'expérience
    total_annees = 0
    for exp in experiences:
        debut = int(exp["annee_debut"])
        
        if exp["en_cours"]:
            fin = datetime.now().year
        else:
            fin = int(exp["annee_fin"]) if exp["annee_fin"] else debut
        
        # Ajout des mois pour plus de précision
        mois_debut = int(exp["mois_debut"]) if exp["mois_debut"].isdigit() else 1
        mois_fin = int(exp["mois_fin"]) if exp["mois_fin"] and exp["mois_fin"].isdigit() else 12 if exp["en_cours"] else 1
        
        duree_annees = (fin - debut) + (mois_fin - mois_debut) / 12
        total_annees += duree_annees
    
    # Calculer le score
    if total_annees >= annees_requises:
        score = 1.0
        points_forts = [f"Expérience suffisante : {round(total_annees, 1)} ans (requis : {annees_requises} ans)"]
        points_a_ameliorer = []
    else:
        # Score proportionnel à l'expérience acquise
        score = total_annees / annees_requises if annees_requises > 0 else 0
        points_forts = []
        points_a_ameliorer = [f"Expérience requise : {annees_requises} ans (vous avez {round(total_annees, 1)} ans)"]
    
    return score, {
        "score": score,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer,
        "annees_experience": round(total_annees, 1)
    }

def analyser_langues(langues_candidat: List[Dict[str, str]], 
                    langues_requises: List[Dict[str, str]]) -> Tuple[float, Dict[str, Any]]:
    """Analyse la correspondance entre les langues du candidat et celles requises."""
    if not langues_requises:
        return 1.0, {"score": 1.0, "points_forts": ["Aucune langue spécifique requise"], "points_a_ameliorer": []}
    
    # Convertir les langues du candidat en dictionnaire pour faciliter la recherche
    langues_candidat_dict = {langue["nom"].lower(): langue["niveau"].lower() for langue in langues_candidat}
    
    score = 0
    total = len(langues_requises)
    points_forts = []
    points_a_ameliorer = []
    
    for langue_req in langues_requises:
        nom_langue = langue_req["nom"].lower()
        niveau_requis = langue_req["niveau"].lower()
        
        if nom_langue in langues_candidat_dict:
            niveau_candidat = langues_candidat_dict[nom_langue]
            
            # Convertir les niveaux en valeurs numériques
            niveau_requis_val = NIVEAUX_LANGUE.get(niveau_requis, 0)
            niveau_candidat_val = NIVEAUX_LANGUE.get(niveau_candidat, 0)
            
            if niveau_candidat_val >= niveau_requis_val:
                score += 1
                points_forts.append(f"Langue maîtrisée : {langue_req['nom']} (niveau {niveau_candidat.upper()})")
            else:
                # Score partiel basé sur le niveau atteint
                score_partiel = niveau_candidat_val / niveau_requis_val if niveau_requis_val > 0 else 0
                score += score_partiel
                points_a_ameliorer.append(f"Améliorer votre niveau en {langue_req['nom']} : {niveau_requis.upper()} requis (vous avez {niveau_candidat.upper()})")
        else:
            points_a_ameliorer.append(f"Langue manquante : {langue_req['nom']} (niveau {niveau_requis.upper()})")
    
    # Calculer le score normalisé
    score_normalise = score / total if total > 0 else 0
    
    return score_normalise, {
        "score": score_normalise,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer
    }

def sauvegarder_resultat(profil_id: Union[int, None], 
                        offre_id: Union[int, None], 
                        resultat: Dict[str, Any]) -> None:
    """Sauvegarde le résultat de l'analyse pour des statistiques futures."""
    try:
        # Créer le dossier de résultats s'il n'existe pas
        os.makedirs(RESULTATS_DIR, exist_ok=True)
        
        # Nom du fichier basé sur les IDs et la date
        nom_fichier = f"{RESULTATS_DIR}/matching_{profil_id}_{offre_id}_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json"
        
        # Sauvegarder au format JSON
        with open(nom_fichier, "w", encoding="utf-8") as f:
            json.dump(resultat, f, ensure_ascii=False, indent=2)
            
        logger.info(f"Résultat sauvegardé dans {nom_fichier}")
        
    except Exception as e:
        logger.error(f"Erreur lors de la sauvegarde du résultat: {str(e)}")

def limiter_points(points_forts: List[str], points_a_ameliorer: List[str]) -> Tuple[List[str], List[str]]:
    """Limite le nombre de points forts et à améliorer à afficher."""
    return points_forts[:MAX_POINTS], points_a_ameliorer[:MAX_POINTS] 