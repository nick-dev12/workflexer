# API de matching pour WorkFlexer
from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from typing import List, Dict, Optional
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import numpy as np
import re
import json
import os
from datetime import datetime

# Assurez-vous que les ressources NLTK sont téléchargées
try:
    nltk.data.find('tokenizers/punkt')
    nltk.data.find('corpora/stopwords')
except LookupError:
    nltk.download('punkt')
    nltk.download('stopwords')

app = FastAPI(
    title="WorkFlexer Matching API",
    description="API d'analyse de correspondance entre profils et offres d'emploi",
    version="1.0.0"
)

# Configuration CORS pour permettre les requêtes depuis le frontend PHP
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # En production, remplacer par l'URL du site
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Modèle de données simplifié pour le test
class Competence(BaseModel):
    nom: str
    niveau: Optional[str] = None

class Formation(BaseModel):
    filiere: str
    niveau: str
    etablissement: str
    annee_debut: str
    annee_fin: Optional[str] = None
    en_cours: bool = False

class Experience(BaseModel):
    poste: str
    entreprise: str
    description: str
    annee_debut: str
    annee_fin: Optional[str] = None
    en_cours: bool = False

class Langue(BaseModel):
    nom: str
    niveau: str

class ProfilCandidat(BaseModel):
    competences: List[Competence]
    formations: List[Formation]
    experiences: List[Experience]
    langues: List[Langue] = []

class OffreEmploi(BaseModel):
    titre: str
    description: str
    competences_requises: List[str]
    niveau_etude_requis: Optional[str] = None
    experience_requise: Optional[int] = None
    langues_requises: List[Dict[str, str]] = []

class ResultatMatching(BaseModel):
    pourcentage_global: float
    points_forts: List[str]
    points_a_ameliorer: List[str]
    details: Dict[str, Dict]

# Fonctions d'analyse
def analyser_competences(competences_candidat, competences_requises):
    """Analyse la correspondance entre les compétences du candidat et celles requises."""
    # Convertir les compétences du candidat en liste de noms
    competences_candidat_noms = [comp.nom.lower() for comp in competences_candidat]
    
    # Convertir les compétences requises en minuscules
    competences_requises_lower = [comp.lower() for comp in competences_requises]
    
    # Calcul du score par correspondance exacte
    score = 0
    total = len(competences_requises_lower)
    points_forts = []
    points_a_ameliorer = []
    
    # Vérifier les correspondances exactes
    for comp_req in competences_requises_lower:
        if comp_req in competences_candidat_noms:
            score += 1
            points_forts.append(f"Compétence maîtrisée : {comp_req.capitalize()}")
        else:
            # Vérifier les correspondances partielles (si un mot-clé est contenu dans une compétence)
            match_partiel = False
            for comp_candidat in competences_candidat_noms:
                if comp_req in comp_candidat or comp_candidat in comp_req:
                    score += 0.5
                    points_forts.append(f"Compétence partiellement maîtrisée : {comp_req.capitalize()}")
                    match_partiel = True
                    break
            
            if not match_partiel:
                points_a_ameliorer.append(f"Compétence à acquérir : {comp_req.capitalize()}")
    
    # Normaliser le score
    score_normalise = min(1.0, score / total) if total > 0 else 1.0
    
    return score_normalise, {
        "score": score_normalise,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer
    }

def analyser_formation(formations, niveau_requis):
    """Analyse si la formation du candidat correspond au niveau requis."""
    if not niveau_requis:
        return 1.0, {
            "score": 1.0,
            "points_forts": ["Aucun niveau d'études spécifique requis"],
            "points_a_ameliorer": []
        }
    
    # Mapping des niveaux d'études
    niveaux = {
        "bac": 1,
        "bac+2": 2,
        "dut": 2,
        "bts": 2,
        "licence": 3,
        "bachelor": 3,
        "bac+3": 3,
        "master": 5,
        "bac+5": 5,
        "ingénieur": 5,
        "doctorat": 8,
        "phd": 8,
        "bac+8": 8
    }
    
    # Trouver le niveau le plus élevé du candidat
    niveau_max_candidat = 0
    formation_max = None
    
    for formation in formations:
        for niveau_str, valeur in niveaux.items():
            if niveau_str in formation.niveau.lower() or niveau_str in formation.filiere.lower():
                if valeur > niveau_max_candidat:
                    niveau_max_candidat = valeur
                    formation_max = formation
    
    # Trouver le niveau requis
    niveau_requis_valeur = 0
    for niveau_str, valeur in niveaux.items():
        if niveau_str in niveau_requis.lower():
            niveau_requis_valeur = valeur
            break
    
    # Calculer le score
    if niveau_max_candidat >= niveau_requis_valeur:
        score = 1.0
        points_forts = [f"Niveau d'études suffisant : {formation_max.niveau if formation_max else 'Non spécifié'}"]
        points_a_ameliorer = []
    else:
        # Score proportionnel au niveau atteint
        score = niveau_max_candidat / niveau_requis_valeur if niveau_requis_valeur > 0 else 0
        points_forts = []
        points_a_ameliorer = [f"Niveau d'études requis : {niveau_requis} (vous avez {formation_max.niveau if formation_max else 'Non spécifié'})"]
    
    return score, {
        "score": score,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer
    }

def analyser_experience(experiences, annees_requises):
    """Analyse si l'expérience du candidat correspond aux années requises."""
    if not annees_requises:
        return 1.0, {
            "score": 1.0,
            "points_forts": ["Aucune expérience spécifique requise"],
            "points_a_ameliorer": []
        }
    
    # Calculer le nombre total d'années d'expérience
    total_annees = 0
    for exp in experiences:
        debut = int(exp.annee_debut)
        
        if exp.en_cours:
            fin = datetime.now().year
        else:
            fin = int(exp.annee_fin) if exp.annee_fin else debut
        
        duree_annees = fin - debut
        total_annees += duree_annees
    
    # Calculer le score
    if total_annees >= annees_requises:
        score = 1.0
        points_forts = [f"Expérience suffisante : {total_annees} ans (requis : {annees_requises} ans)"]
        points_a_ameliorer = []
    else:
        # Score proportionnel à l'expérience acquise
        score = total_annees / annees_requises if annees_requises > 0 else 0
        points_forts = []
        points_a_ameliorer = [f"Expérience requise : {annees_requises} ans (vous avez {total_annees} ans)"]
    
    return score, {
        "score": score,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer
    }

def analyser_langues(langues_candidat, langues_requises):
    """Analyse la correspondance entre les langues du candidat et celles requises."""
    if not langues_requises:
        return 1.0, {
            "score": 1.0,
            "points_forts": ["Aucune langue spécifique requise"],
            "points_a_ameliorer": []
        }
    
    # Mapping des niveaux de langue
    niveaux_langue = {
        "a1": 1,
        "a2": 2,
        "b1": 3,
        "b2": 4,
        "c1": 5,
        "c2": 6,
        "débutant": 1,
        "intermédiaire": 3,
        "avancé": 5,
        "bilingue": 6,
        "natif": 6
    }
    
    # Convertir les langues du candidat en dictionnaire
    langues_candidat_dict = {langue.nom.lower(): langue.niveau.lower() for langue in langues_candidat}
    
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
            niveau_requis_val = niveaux_langue.get(niveau_requis, 0)
            niveau_candidat_val = niveaux_langue.get(niveau_candidat, 0)
            
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

def analyser_description_offre(profil, description_offre):
    """Analyse la correspondance entre le profil du candidat et la description de l'offre."""
    if not description_offre:
        return 1.0, {
            "score": 1.0,
            "points_forts": ["Pas de description d'offre à analyser"],
            "points_a_ameliorer": []
        }
    
    # Créer un texte représentant le profil du candidat
    profil_text = ""
    
    # Ajouter les compétences
    for comp in profil.competences:
        profil_text += f"{comp.nom} "
    
    # Ajouter les formations
    for form in profil.formations:
        profil_text += f"{form.filiere} {form.niveau} {form.etablissement} "
    
    # Ajouter les expériences
    for exp in profil.experiences:
        profil_text += f"{exp.poste} {exp.entreprise} {exp.description} "
    
    # Prétraitement des textes
    stop_words = set(stopwords.words('french'))
    
    def preprocess_text(text):
        text = text.lower()
        text = re.sub(r'[^\w\s]', '', text)
        tokens = word_tokenize(text)
        tokens = [word for word in tokens if word not in stop_words]
        return " ".join(tokens)
    
    profil_processed = preprocess_text(profil_text)
    description_processed = preprocess_text(description_offre)
    
    # Vectorisation TF-IDF
    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform([profil_processed, description_processed])
    
    # Calcul de la similarité cosinus
    cosine_sim = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]
    
    # Extraire les mots-clés importants de l'offre
    feature_names = vectorizer.get_feature_names_out()
    tfidf_sorting = np.argsort(tfidf_matrix[1].toarray()).flatten()[::-1]
    
    top_n = 5
    top_keywords = [feature_names[i] for i in tfidf_sorting[:top_n]]
    
    # Générer des points forts et à améliorer
    points_forts = []
    points_a_ameliorer = []
    
    for keyword in top_keywords:
        if keyword in profil_processed:
            points_forts.append(f"Votre profil correspond bien au mot-clé : {keyword}")
        else:
            points_a_ameliorer.append(f"Considérez ajouter des compétences liées à : {keyword}")
    
    return cosine_sim, {
        "score": cosine_sim,
        "points_forts": points_forts,
        "points_a_ameliorer": points_a_ameliorer
    }

@app.get("/")
async def root():
    """Page d'accueil de l'API."""
    return {
        "message": "Bienvenue sur l'API de matching WorkFlexer",
        "documentation": "/docs",
        "status": "online"
    }

@app.post("/analyser", response_model=ResultatMatching)
async def analyser_matching(profil: ProfilCandidat, offre: OffreEmploi):
    """
    Analyse la correspondance entre un profil candidat et une offre d'emploi.
    Retourne un score de matching et des recommandations.
    """
    try:
        # Analyser les compétences
        score_competences, details_competences = analyser_competences(profil.competences, offre.competences_requises)
        
        # Analyser la formation
        score_formation, details_formation = analyser_formation(profil.formations, offre.niveau_etude_requis)
        
        # Analyser l'expérience
        score_experience, details_experience = analyser_experience(profil.experiences, offre.experience_requise)
        
        # Analyser les langues
        score_langues, details_langues = analyser_langues(profil.langues, offre.langues_requises)
        
        # Analyser la description de l'offre
        score_description, details_description = analyser_description_offre(profil, offre.description)
        
        # Calculer le score global (moyenne pondérée)
        poids = {
            "competences": 0.4,
            "formation": 0.2,
            "experience": 0.3,
            "langues": 0.05,
            "description": 0.05
        }
        
        score_global = (
            score_competences * poids["competences"] +
            score_formation * poids["formation"] +
            score_experience * poids["experience"] +
            score_langues * poids["langues"] +
            score_description * poids["description"]
        ) * 100  # Convertir en pourcentage
        
        # Collecter tous les points forts et à améliorer
        points_forts = []
        points_forts.extend(details_competences["points_forts"])
        points_forts.extend(details_formation["points_forts"])
        points_forts.extend(details_experience["points_forts"])
        points_forts.extend(details_langues["points_forts"])
        points_forts.extend(details_description["points_forts"])
        
        points_a_ameliorer = []
        points_a_ameliorer.extend(details_competences["points_a_ameliorer"])
        points_a_ameliorer.extend(details_formation["points_a_ameliorer"])
        points_a_ameliorer.extend(details_experience["points_a_ameliorer"])
        points_a_ameliorer.extend(details_langues["points_a_ameliorer"])
        points_a_ameliorer.extend(details_description["points_a_ameliorer"])
        
        # Limiter le nombre de points à afficher
        points_forts = points_forts[:5]
        points_a_ameliorer = points_a_ameliorer[:5]
        
        # Préparer les détails
        details = {
            "competences": details_competences,
            "formation": details_formation,
            "experience": details_experience,
            "langues": details_langues,
            "description": details_description
        }
        
        # Créer le résultat
        resultat = ResultatMatching(
            pourcentage_global=round(score_global, 2),
            points_forts=points_forts,
            points_a_ameliorer=points_a_ameliorer,
            details=details
        )
        
        # Sauvegarder le résultat (optionnel)
        try:
            os.makedirs("resultats", exist_ok=True)
            with open(f"resultats/matching_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json", "w", encoding="utf-8") as f:
                json.dump(resultat.dict(), f, ensure_ascii=False, indent=2)
        except Exception:
            pass  # Ignorer les erreurs de sauvegarde
        
        return resultat
        
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Erreur lors de l'analyse: {str(e)}")

# Point d'entrée pour exécution directe
if __name__ == "__main__":
    import uvicorn
    uvicorn.run("main:app", host="0.0.0.0", port=8000, reload=True)
