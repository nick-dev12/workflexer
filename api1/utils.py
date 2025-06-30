"""
Fonctions utilitaires avancées pour l'analyse de compatibilité hybride
Utilise SpaCy pour l'extraction d'entités et SentenceTransformers pour l'analyse sémantique
"""

import logging
import re
import time
from typing import Dict, List, Tuple, Set, Optional, Union
from collections import defaultdict, Counter
import pickle
import os
import hashlib
import torch

# Imports pour NLP avancé
import spacy
from sentence_transformers import SentenceTransformer, util
import numpy as np
from nltk.corpus import stopwords
import nltk
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.cluster import KMeans

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
    ExtractedEntity,
    SectionEmbedding,
    SemanticSimilarity,
    AdvancedCompetenceAnalysis,
    HybridAnalysisResult,
    EntityMatchResult,
    SkillGapAnalysis,
    CareerProgressionAnalysis,
    IndustryRelevanceAnalysis,
    ContexteAnalyse,
)

# --- Configuration du Logging ---
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# --- Configuration du Caching ---
CACHE_DIR = os.path.join(os.path.dirname(__file__), 'cache')
os.makedirs(CACHE_DIR, exist_ok=True)
logger.info(f"Le cache des embeddings est stocké dans: {CACHE_DIR}")

def get_from_cache(key: str):
    """Récupère un élément du cache basé sur les fichiers."""
    cache_file = os.path.join(CACHE_DIR, key)
    if os.path.exists(cache_file):
        try:
            with open(cache_file, 'rb') as f:
                return pickle.load(f)
        except (pickle.UnpicklingError, EOFError):
            logger.warning(f"Fichier de cache corrompu: {cache_file}")
            return None
    return None

def set_in_cache(key: str, value: any):
    """Sauvegarde un élément dans le cache."""
    cache_file = os.path.join(CACHE_DIR, key)
    try:
        with open(cache_file, 'wb') as f:
            pickle.dump(value, f)
    except Exception as e:
        logger.error(f"Erreur lors de la sauvegarde dans le cache pour la clé {key}: {e}")

def get_embedding_with_cache(text: str) -> List[float]:
    """Génère ou récupère depuis le cache l'embedding pour un texte donné."""
    if not sentence_model or not text:
        return []

    cache_key = hashlib.md5(text.encode()).hexdigest()
    cached_embedding = get_from_cache(cache_key)
    if cached_embedding is not None:
        return cached_embedding

    try:
        embedding = sentence_model.encode(text, convert_to_tensor=False, show_progress_bar=False).tolist()
        set_in_cache(cache_key, embedding)
        return embedding
    except Exception as e:
        logger.error(f"Erreur de génération d'embedding pour le texte: '{text[:50]}...': {e}")
        return []

def get_embeddings_with_cache_batch(texts: List[str]) -> List[List[float]]:
    """Génère ou récupère depuis le cache les embeddings pour un lot de textes."""
    if not sentence_model or not texts:
        return [[] for _ in texts]

    results = [None] * len(texts)
    texts_to_encode = []
    indices_to_encode = []

    for i, text in enumerate(texts):
        if not text:
            results[i] = []
            continue
            
        cache_key = hashlib.md5(text.encode()).hexdigest()
        cached_embedding = get_from_cache(cache_key)
        if cached_embedding is not None:
            results[i] = cached_embedding
        else:
            texts_to_encode.append(text)
            indices_to_encode.append(i)

    if texts_to_encode:
        logger.info(f"Cache miss pour {len(texts_to_encode)} embeddings. Génération...")
        try:
            new_embeddings = sentence_model.encode(texts_to_encode, convert_to_tensor=False, show_progress_bar=False)
            
            for i, embedding in enumerate(new_embeddings):
                original_index = indices_to_encode[i]
                list_embedding = embedding.tolist()
                results[original_index] = list_embedding
                set_in_cache(hashlib.md5(texts[original_index].encode()).hexdigest(), list_embedding)
        except Exception as e:
            logger.error(f"Erreur lors de la génération d'embeddings par lot: {e}")
            for i in indices_to_encode:
                results[i] = []

    return results

# --- Chargement des modèles et ressources NLP (une seule fois) ---
try:
    logger.info("Loading advanced NLP models for hybrid analysis...")
    
    # Chargement du modèle spaCy pour le français avec pipeline complet
    nlp = spacy.load("fr_core_news_sm")
    logger.info("spaCy model 'fr_core_news_sm' loaded successfully.")
    
    # Chargement du modèle SentenceTransformer optimisé pour le français
    sentence_model = SentenceTransformer('distiluse-base-multilingual-cased-v1')
    logger.info("SentenceTransformer model loaded successfully.")

    # Assurer que les données NLTK nécessaires sont téléchargées
    try:
        nltk.data.find('corpora/stopwords')
        nltk.data.find('tokenizers/punkt')
    except LookupError:
        logger.info("NLTK data not found. Downloading required packages...")
        nltk.download('stopwords')
        nltk.download('punkt')
        
    stop_words = set(stopwords.words('french'))
    logger.info("NLTK French stopwords loaded.")
    
    # Modèle TF-IDF pour l'analyse de mots-clés
    tfidf_vectorizer = TfidfVectorizer(
        stop_words=list(stop_words),
        max_features=5000,
        ngram_range=(1, 3)
    )
    logger.info("TF-IDF vectorizer initialized.")

except Exception as e:
    logger.error(f"Critical error loading NLP models: {e}", exc_info=True)
    nlp = None
    sentence_model = None
    stop_words = set()
    tfidf_vectorizer = None

# --- Dictionnaires de normalisation et synonymes ---
SKILL_NORMALIZATION = {
    'js': 'javascript',
    'py': 'python',
    'css3': 'css',
    'html5': 'html',
    'nodejs': 'node.js',
    'reactjs': 'react',
    'vuejs': 'vue.js',
    'angularjs': 'angular',
    'mysql': 'mysql',
    'postgresql': 'postgresql',
    'nosql': 'nosql',
    'sql server': 'sql server',
    'dotnet': '.net',
    'csharp': 'c#',
    'cplusplus': 'c++',
    'photoshop': 'adobe photoshop',
    'illustrator': 'adobe illustrator',
    'indesign': 'adobe indesign',
    'wordpress': 'wordpress',
    'drupal': 'drupal',
    'shopify': 'shopify',
    'magento': 'magento',
}

TECHNOLOGY_CLUSTERS = {
    'frontend': ['html', 'css', 'javascript', 'react', 'vue.js', 'angular', 'typescript', 'sass', 'less', 'webpack', 'bootstrap', 'tailwind'],
    'backend': ['php', 'python', 'java', 'node.js', 'ruby', 'go', 'c#', '.net', 'spring', 'django', 'flask', 'laravel', 'symfony'],
    'database': ['mysql', 'postgresql', 'mongodb', 'redis', 'elasticsearch', 'oracle', 'sql server', 'sqlite'],
    'mobile': ['android', 'ios', 'react native', 'flutter', 'ionic', 'cordova', 'swift', 'kotlin', 'xamarin'],
    'devops': ['docker', 'kubernetes', 'jenkins', 'git', 'aws', 'azure', 'google cloud', 'terraform', 'ansible'],
    'design': ['photoshop', 'illustrator', 'figma', 'sketch', 'adobe xd', 'indesign', 'after effects'],
    'cms': ['wordpress', 'drupal', 'joomla', 'shopify', 'magento', 'prestashop'],
    'analytics': ['google analytics', 'google tag manager', 'mixpanel', 'amplitude', 'tableau', 'power bi']
}

SECTOR_KEYWORDS = {
    'informatique': ['développement', 'programmation', 'logiciel', 'application', 'système', 'réseau', 'sécurité', 'data', 'ia', 'machine learning'],
    'marketing': ['marketing', 'communication', 'publicité', 'seo', 'sem', 'réseaux sociaux', 'contenu', 'campagne', 'brand'],
    'finance': ['finance', 'comptabilité', 'audit', 'contrôle de gestion', 'fiscalité', 'budget', 'investissement', 'banque'],
    'rh': ['ressources humaines', 'recrutement', 'formation', 'paie', 'gestion du personnel', 'talent management'],
    'vente': ['vente', 'commercial', 'négociation', 'client', 'prospection', 'relation client', 'business development'],
    'design': ['design', 'graphique', 'ui', 'ux', 'interface', 'ergonomie', 'expérience utilisateur', 'créatif']
}


# Constantes pour l'analyse
COMPLETION_THRESHOLD = config.WEIGHTS.get("completion_threshold", 0.7)
EXPERIENCE_WEIGHT = config.WEIGHTS.get("experience", 0.35)
FORMATION_WEIGHT = config.WEIGHTS.get("formation", 0.25)
COMPETENCES_WEIGHT = config.WEIGHTS.get("competences", 0.25)
LANGUES_WEIGHT = config.WEIGHTS.get("langues", 0.15)
OUTILS_WEIGHT = config.WEIGHTS.get("outils", 0.10)

# Seuils pour l'analyse avancée
SEMANTIC_SIMILARITY_THRESHOLD = 0.75
ENTITY_CONFIDENCE_THRESHOLD = 0.6
SKILL_MATCH_THRESHOLD = 0.8


# === NOUVELLES FONCTIONS D'EXTRACTION ET D'ANALYSE AVANCÉE ===

def normalize_skill_name(skill: str) -> str:
    """
    Normalise le nom d'une compétence en utilisant les dictionnaires de correspondance.
    """
    skill_lower = skill.lower().strip()
    return SKILL_NORMALIZATION.get(skill_lower, skill_lower)


def _convert_to_text(data) -> str:
    """
    Convertit différents types de données en texte pour l'analyse SpaCy.
    """
    if isinstance(data, str):
        return data
    elif isinstance(data, list):
        # Si c'est une liste de dictionnaires avec 'nom'
        if data and isinstance(data[0], dict) and 'nom' in data[0]:
            return ', '.join([item.get('nom', '') for item in data if item.get('nom')])
        # Si c'est une liste de chaînes
        elif data and isinstance(data[0], str):
            return ', '.join(data)
        else:
            return str(data) if data else ''
    elif isinstance(data, dict):
        # Si c'est un dictionnaire, extraire les valeurs textuelles principales
        text_parts = []
        for key, value in data.items():
            if isinstance(value, str) and value.strip():
                text_parts.append(f"{key}: {value}")
        return ' '.join(text_parts)
    else:
        return str(data) if data else ''


def extract_entities_with_spacy(text: str) -> List[ExtractedEntity]:
    """
    Extrait les entités nommées d'un texte en utilisant SpaCy avec des règles personnalisées.
    """
    if not nlp or not text:
        return []
    
    entities = []
    doc = nlp(text)
    
    # Entités standard de SpaCy
    for ent in doc.ents:
        entities.append(ExtractedEntity(
            text=ent.text,
            label=ent.label_,
            start=ent.start,
            end=ent.end,
            confidence=0.8  # SpaCy confidence par défaut
        ))
    
    # Extraction personnalisée de compétences techniques
    tech_patterns = [
        r'\b(?:HTML5?|CSS3?|JavaScript|TypeScript|React|Vue\.?js|Angular|Node\.?js)\b',
        r'\b(?:Python|Java|PHP|Ruby|Go|Rust|Swift|Kotlin|C\+\+|C#|\.NET)\b',
        r'\b(?:MySQL|PostgreSQL|MongoDB|Redis|Oracle|SQL Server|SQLite)\b',
        r'\b(?:Docker|Kubernetes|Jenkins|Git|AWS|Azure|Google Cloud)\b',
        r'\b(?:Photoshop|Illustrator|Figma|Sketch|Adobe XD|InDesign)\b',
        r'\b(?:WordPress|Drupal|Shopify|Magento|PrestaShop)\b',
    ]
    
    text_lower = text.lower()
    for pattern in tech_patterns:
        matches = re.finditer(pattern, text, re.IGNORECASE)
        for match in matches:
            skill_text = match.group()
            entities.append(ExtractedEntity(
                text=skill_text,
                label="TECH_SKILL",
                start=match.start(),
                end=match.end(),
                confidence=0.9
            ))
    
    return entities


def create_section_embedding(section_name: str, text) -> SectionEmbedding:
    """
    Crée un embedding pour une section spécifique du profil ou de l'offre.
    """
    text_str = _convert_to_text(text)
    
    if not text_str:
        return SectionEmbedding(section_name=section_name, text=text_str)
    
    # Génération de l'embedding avec cache
    embedding = get_embedding_with_cache(text_str)
    
    entities = extract_entities_with_spacy(text_str)
    keywords = extract_keywords_tfidf(text_str)
    
    normalized_terms = {}
    for entity in entities:
        if entity.label == "TECH_SKILL":
            normalized = normalize_skill_name(entity.text)
            if normalized != entity.text.lower():
                normalized_terms[entity.text.lower()] = normalized
    
    return SectionEmbedding(
        section_name=section_name,
        text=text_str,
        embedding=embedding,
        entities=entities,
        keywords=keywords,
        normalized_terms=normalized_terms
    )


def extract_keywords_tfidf(text: str, max_keywords: int = 10) -> List[str]:
    """
    Extrait les mots-clés les plus importants d'un texte en utilisant TF-IDF.
    """
    if not tfidf_vectorizer or not text or len(text.strip()) < 10:
        return []
    
    try:
        # Créer un corpus temporaire pour l'analyse TF-IDF
        corpus = [text]
        tfidf_matrix = tfidf_vectorizer.fit_transform(corpus)
        feature_names = tfidf_vectorizer.get_feature_names_out()
        tfidf_scores = tfidf_matrix.toarray()[0]
        
        # Obtenir les indices des scores les plus élevés
        top_indices = tfidf_scores.argsort()[-max_keywords:][::-1]
        keywords = [feature_names[i] for i in top_indices if tfidf_scores[i] > 0.1]
        
        return keywords[:max_keywords]
    except Exception as e:
        logger.error(f"Erreur lors de l'extraction des mots-clés TF-IDF: {e}")
        return []


def calculate_semantic_similarity_advanced(
    text1: str, 
    text2: str,
    section_embeddings1: Dict[str, SectionEmbedding] = None,
    section_embeddings2: Dict[str, SectionEmbedding] = None
) -> SemanticSimilarity:
    """
    Calcule une similarité sémantique avancée entre deux textes avec analyse détaillée.
    """
    if not sentence_model or not text1 or not text2:
        return SemanticSimilarity(score=0.0)
    
    try:
        # Calcul de la similarité globale
        embeddings = sentence_model.encode([text1, text2], convert_to_tensor=True, show_progress_bar=False)
        cosine_score = util.pytorch_cos_sim(embeddings[0], embeddings[1]).item()
        
        # Analyse des termes correspondants
        tokens1 = set(normalize_text(text1))
        tokens2 = set(normalize_text(text2))
        
        matched_terms = []
        for token in tokens1.intersection(tokens2):
            matched_terms.append({"candidate": token, "offer": token})
        
        missing_terms = list(tokens2 - tokens1)
        extra_terms = list(tokens1 - tokens2)
        
        # Analyse sémantique des termes non correspondants
        semantic_matches = []
        if section_embeddings1 and section_embeddings2:
            semantic_matches = find_semantic_matches(
                section_embeddings1, section_embeddings2, threshold=SEMANTIC_SIMILARITY_THRESHOLD
            )
        
        return SemanticSimilarity(
            score=cosine_score,
            matched_terms=matched_terms,
            missing_terms=missing_terms,
            extra_terms=extra_terms,
            semantic_matches=semantic_matches
        )
        
    except Exception as e:
        logger.error(f"Erreur lors du calcul de similarité avancée: {e}")
        return SemanticSimilarity(score=0.0)


def find_semantic_matches(
    embeddings1: Dict[str, SectionEmbedding],
    embeddings2: Dict[str, SectionEmbedding],
    threshold: float = 0.75
) -> List[Dict[str, Union[str, float]]]:
    """
    Trouve les correspondances sémantiques entre les embeddings de deux ensembles de sections.
    """
    matches = []
    
    for section1_name, embedding1 in embeddings1.items():
        for section2_name, embedding2 in embeddings2.items():
            if not embedding1.embedding or not embedding2.embedding:
                continue
                
            try:
                similarity = cosine_similarity(
                    [embedding1.embedding], [embedding2.embedding]
                )[0][0]
                
                if similarity > threshold:
                    matches.append({
                        "section1": section1_name,
                        "section2": section2_name,
                        "similarity": float(similarity),
                        "terms1": embedding1.keywords[:5],
                        "terms2": embedding2.keywords[:5]
                    })
            except Exception as e:
                logger.error(f"Erreur lors de la comparaison d'embeddings: {e}")
                continue
    
    return sorted(matches, key=lambda x: x["similarity"], reverse=True)


def cluster_skills_by_technology(skills: List[str]) -> Dict[str, List[str]]:
    """
    Groupe les compétences par clusters technologiques.
    """
    clustered_skills = defaultdict(list)
    uncategorized = []
    
    # Normaliser les compétences
    normalized_skills = [normalize_skill_name(skill) for skill in skills]
    
    # Classer les compétences dans les clusters
    for skill in normalized_skills:
        categorized = False
        for cluster_name, cluster_skills in TECHNOLOGY_CLUSTERS.items():
            if skill.lower() in [cs.lower() for cs in cluster_skills]:
                clustered_skills[cluster_name].append(skill)
                categorized = True
                break
        
        if not categorized:
            uncategorized.append(skill)
    
    # Ajouter les compétences non catégorisées
    if uncategorized:
        clustered_skills['autres'] = uncategorized
    
    return dict(clustered_skills)


def analyze_skill_market_demand(skill: str) -> float:
    """
    Analyse la demande du marché pour une compétence donnée.
    Retourne un score entre 0 et 1.
    """
    skill_lower = normalize_skill_name(skill)
    
    # Base de données simplifiée de la demande du marché
    high_demand_skills = [
        'python', 'javascript', 'react', 'node.js', 'aws', 'docker', 
        'kubernetes', 'machine learning', 'data science', 'devops',
        'typescript', 'vue.js', 'angular', 'spring boot', 'microservices'
    ]
    
    medium_demand_skills = [
        'php', 'java', 'mysql', 'postgresql', 'html', 'css', 'git',
        'linux', 'jenkins', 'redis', 'mongodb', 'laravel', 'symfony'
    ]
    
    if skill_lower in high_demand_skills:
        return 0.9
    elif skill_lower in medium_demand_skills:
        return 0.6
    else:
        return 0.3


def generate_learning_resources(skill: str) -> List[Dict[str, str]]:
    """
    Génère des ressources d'apprentissage pour une compétence donnée.
    """
    skill_lower = normalize_skill_name(skill)
    
    # Base de ressources génériques
    resources = [
        {
            "type": "documentation",
            "name": f"Documentation officielle {skill}",
            "url": f"https://www.google.com/search?q={skill}+documentation+officielle",
            "difficulty": "intermediate"
        },
        {
            "type": "tutorial",
            "name": f"Tutoriels {skill} sur YouTube",
            "url": f"https://www.youtube.com/results?search_query={skill}+tutorial",
            "difficulty": "beginner"
        },
        {
            "type": "course",
            "name": f"Cours {skill} sur Coursera",
            "url": f"https://www.coursera.org/search?query={skill}",
            "difficulty": "intermediate"
        }
    ]
    
    # Ressources spécifiques pour certaines compétences
    specific_resources = {
        'python': [
            {"type": "interactive", "name": "Python.org Beginner's Guide", "url": "https://docs.python.org/3/tutorial/", "difficulty": "beginner"},
            {"type": "practice", "name": "LeetCode Python", "url": "https://leetcode.com/", "difficulty": "advanced"}
        ],
        'javascript': [
            {"type": "interactive", "name": "MDN JavaScript Guide", "url": "https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide", "difficulty": "beginner"},
            {"type": "practice", "name": "freeCodeCamp", "url": "https://www.freecodecamp.org/", "difficulty": "beginner"}
        ],
        'react': [
            {"type": "interactive", "name": "React Official Tutorial", "url": "https://reactjs.org/tutorial/tutorial.html", "difficulty": "intermediate"},
            {"type": "course", "name": "React sur Udemy", "url": "https://www.udemy.com/topic/react/", "difficulty": "intermediate"}
        ]
    }
    
    if skill_lower in specific_resources:
        resources.extend(specific_resources[skill_lower])
    
    return resources[:5]  # Limiter à 5 ressources


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
    Calcule la similarité sémantique entre deux textes en utilisant le SentenceTransformer et le cache.
    """
    if not sentence_model or not text1 or not text2:
        return 0.0
    
    try:
        embedding1 = get_embedding_with_cache(text1)
        embedding2 = get_embedding_with_cache(text2)

        if not embedding1 or not embedding2:
            return 0.0
            
        cosine_score = util.pytorch_cos_sim(embedding1, embedding2)
        return cosine_score.item()
    except Exception as e:
        logger.error(f"Erreur de calcul de similarité pour les textes ('{text1[:30]}...', '{text2[:30]}...'): {e}", exc_info=False)
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


def analyze_competences_compatibility_advanced(
    candidate_competences: List[Competence], 
    required_competences: List[Competence],
    candidate_text: str = "",
    offer_text: str = ""
) -> AdvancedCompetenceAnalysis:
    """
    Analyse avancée de la compatibilité des compétences avec approche hybride.
    Combine l'analyse structurée et sémantique pour une évaluation plus précise.
    """
    if not required_competences:
        return AdvancedCompetenceAnalysis()

    if not candidate_competences:
        missing_critical = [comp.nom for comp in required_competences]
        return AdvancedCompetenceAnalysis(missing_critical=missing_critical)

    logger.info("Début de l'analyse avancée des compétences")
    
    # 1. Normalisation des compétences
    req_skills_normalized = []
    cand_skills_normalized = []
    
    for comp in required_competences:
        normalized = normalize_skill_name(comp.nom)
        req_skills_normalized.append({
            'original': comp.nom,
            'normalized': normalized,
            'niveau': comp.niveau,
            'category': classify_skill_category(normalized)
        })
    
    for comp in candidate_competences:
        normalized = normalize_skill_name(comp.nom)
        cand_skills_normalized.append({
            'original': comp.nom,
            'normalized': normalized,
            'niveau': comp.niveau,
            'category': classify_skill_category(normalized)
        })
    
    # 2. Correspondances exactes
    exact_matches = []
    req_normalized_names = {skill['normalized'] for skill in req_skills_normalized}
    cand_normalized_names = {skill['normalized'] for skill in cand_skills_normalized}
    
    for req_skill in req_skills_normalized:
        if req_skill['normalized'] in cand_normalized_names:
            # Trouver la compétence correspondante du candidat
            cand_skill = next(
                (cs for cs in cand_skills_normalized if cs['normalized'] == req_skill['normalized']), 
                None
            )
            if cand_skill:
                exact_matches.append(req_skill['original'])
    
    logger.info(f"Correspondances exactes trouvées : {len(exact_matches)}")
    
    # 3. Analyse sémantique pour les compétences non correspondantes
    semantic_matches = []
    missing_skills = []
    
    req_unmatched = [skill for skill in req_skills_normalized if skill['original'] not in exact_matches]
    
    if req_unmatched and sentence_model:
        try:
            # Créer les textes pour l'analyse sémantique
            req_texts = [skill['original'] for skill in req_unmatched]
            cand_texts = [skill['original'] for skill in cand_skills_normalized]
            
            if req_texts and cand_texts:
                req_embeddings = get_embeddings_with_cache_batch(req_texts)
                cand_embeddings = get_embeddings_with_cache_batch(cand_texts)
                
                req_embeddings_tensor = torch.tensor(req_embeddings, dtype=torch.float32)
                cand_embeddings_tensor = torch.tensor(cand_embeddings, dtype=torch.float32)

                if req_embeddings_tensor.shape[1] == 0 or cand_embeddings_tensor.shape[1] == 0:
                     raise ValueError("Embeddings vides détectés.")

                similarity_matrix = util.pytorch_cos_sim(req_embeddings_tensor, cand_embeddings_tensor)
                
                for i, req_skill in enumerate(req_unmatched):
                    best_match_score = similarity_matrix[i].max().item()
                    best_match_idx = similarity_matrix[i].argmax().item()
                    
                    if best_match_score > SKILL_MATCH_THRESHOLD:
                        best_match_skill = cand_skills_normalized[best_match_idx]
                        semantic_matches.append({
                            'required_skill': req_skill['original'],
                            'matched_skill': best_match_skill['original'],
                            'similarity': best_match_score,
                            'category': req_skill['category'],
                            'confidence': 'high' if best_match_score > 0.9 else 'medium'
                        })
                else:
                        # Vérifier si la compétence appartient au même cluster technologique
                        cluster_match = find_cluster_match(req_skill['normalized'], cand_skills_normalized)
                        if cluster_match:
                            semantic_matches.append({
                                'required_skill': req_skill['original'],
                                'matched_skill': cluster_match['original'],
                                'similarity': 0.75,  # Score fixe pour les correspondances de cluster
                                'category': req_skill['category'],
                                'confidence': 'medium',
                                'match_type': 'cluster'
                            })
            else:
                            missing_skills.append(req_skill['original'])
        
        except Exception as e:
            logger.error(f"Erreur lors de l'analyse sémantique des compétences: {e}")
            missing_skills = [skill['original'] for skill in req_unmatched]
    
    logger.info(f"Correspondances sémantiques trouvées : {len(semantic_matches)}")
    logger.info(f"Compétences manquantes : {len(missing_skills)}")
    
    # 4. Classification des compétences manquantes (critiques vs optionnelles)
    missing_critical = []
    missing_optional = []
    
    for skill in missing_skills:
        req_skill_info = next((rs for rs in req_skills_normalized if rs['original'] == skill), None)
        if req_skill_info and req_skill_info.get('niveau', 3) >= 4:
            missing_critical.append(skill)
        else:
            missing_optional.append(skill)
    
    # 5. Clustering technologique
    all_candidate_skills = [skill['normalized'] for skill in cand_skills_normalized]
    technology_clusters = cluster_skills_by_technology(all_candidate_skills)
    
    # 6. Analyse des niveaux de compétences
    skill_levels = {}
    for req_skill in req_skills_normalized:
        if req_skill['original'] in exact_matches:
            cand_skill = next(
                (cs for cs in cand_skills_normalized if cs['normalized'] == req_skill['normalized']), 
                None
            )
            if cand_skill:
                skill_levels[req_skill['original']] = {
                    'required_level': req_skill['niveau'],
                    'candidate_level': cand_skill['niveau'],
                    'gap': max(0, req_skill['niveau'] - cand_skill['niveau'])
                }
    
    # 7. Matrice de similarité pour toutes les compétences
    similarity_matrix_dict = {}
    if sentence_model:
        try:
            all_req_skills = [skill['original'] for skill in req_skills_normalized]
            all_cand_skills = [skill['original'] for skill in cand_skills_normalized]
            
            if all_req_skills and all_cand_skills:
                req_embeddings_list = get_embeddings_with_cache_batch(all_req_skills)
                cand_embeddings_list = get_embeddings_with_cache_batch(all_cand_skills)

                req_embeddings = np.array(req_embeddings_list)
                cand_embeddings = np.array(cand_embeddings_list)
                
                if req_embeddings.shape[1] > 0 and cand_embeddings.shape[1] > 0:
                    similarity_matrix = cosine_similarity(req_embeddings, cand_embeddings)
                    
                    for i, req_skill in enumerate(all_req_skills):
                        similarity_matrix_dict[req_skill] = {}
                        for j, cand_skill in enumerate(all_cand_skills):
                            similarity_matrix_dict[req_skill][cand_skill] = float(similarity_matrix[i][j])
        
        except Exception as e:
            logger.error(f"Erreur lors de la création de la matrice de similarité: {e}")
    
    return AdvancedCompetenceAnalysis(
        exact_matches=exact_matches,
        semantic_matches=semantic_matches,
        missing_critical=missing_critical,
        missing_optional=missing_optional,
        technology_clusters=technology_clusters,
        skill_levels=skill_levels,
        similarity_matrix=similarity_matrix_dict
    )


def analyze_competences_compatibility(
    candidate_competences: List[Competence], required_competences: List[Competence]
) -> Tuple[float, List[CorrespondanceItem], List[ElementManquant], List[str], List[str]]:
    """
    Version simplifiée pour compatibilité avec l'ancien code.
    Utilise l'analyse avancée en arrière-plan.
    """
    advanced_analysis = analyze_competences_compatibility_advanced(
        candidate_competences, required_competences
    )
    
    # Conversion des résultats vers l'ancien format
    correspondances = []
    for match in advanced_analysis.semantic_matches:
        correspondances.append(CorrespondanceItem(
            element_profil=match['matched_skill'],
            element_offre=match['required_skill'],
            niveau_correspondance=match['similarity'],
            categorie='competence',
            similarite_semantique=match['similarity']
        ))
    
    manquants = []
    all_missing = advanced_analysis.missing_critical + advanced_analysis.missing_optional
    for skill in all_missing:
        importance = 'critique' if skill in advanced_analysis.missing_critical else 'normale'
        manquants.append(ElementManquant(
            description=skill,
            categorie='competence',
            importance=importance
        ))
    
    points_forts = advanced_analysis.exact_matches.copy()
    for match in advanced_analysis.semantic_matches:
        if match['confidence'] == 'high':
            points_forts.append(f"{match['required_skill']} (similaire à {match['matched_skill']})")
    
    recommendations = []
    if advanced_analysis.missing_critical:
        recommendations.append(
            f"Compétences critiques manquantes : {', '.join(advanced_analysis.missing_critical)}"
        )
    if advanced_analysis.missing_optional:
        recommendations.append(
            f"Compétences optionnelles à acquérir : {', '.join(advanced_analysis.missing_optional[:3])}"
        )
    
    # Calcul du score
    total_required = len(required_competences)
    if total_required == 0:
        return 1.0, correspondances, manquants, points_forts, recommendations
    
    exact_score = len(advanced_analysis.exact_matches) / total_required
    semantic_score = sum(match['similarity'] for match in advanced_analysis.semantic_matches) / total_required
    final_score = exact_score + (semantic_score * 0.7)  # Les correspondances sémantiques valent moins
    
    return min(1.0, final_score), correspondances, manquants, points_forts, recommendations


def classify_skill_category(skill: str) -> str:
    """
    Classifie une compétence dans une catégorie technologique.
    """
    skill_lower = skill.lower()
    
    for category, skills_in_category in TECHNOLOGY_CLUSTERS.items():
        if skill_lower in [s.lower() for s in skills_in_category]:
            return category
    
    return 'general'


def find_cluster_match(required_skill: str, candidate_skills: List[Dict]) -> Optional[Dict]:
    """
    Trouve une correspondance dans le même cluster technologique.
    """
    required_category = classify_skill_category(required_skill)
    if required_category == 'general':
        return None
    
    for cand_skill in candidate_skills:
        if classify_skill_category(cand_skill['normalized']) == required_category:
            return cand_skill
    
    return None


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
    Analyse hybride avancée V2 utilisant SpaCy et SentenceTransformers.
    Combine l'analyse structurée (niveau 2) et l'analyse sémantique globale (niveau 1).
    """
    start_time = time.time()
    
    try:
        logger.info("Début de l'analyse hybride avancée V2")
        
        # Validation et initialisation des objets Pydantic
        profile = CandidatProfile(**candidate_data)
        offer = JobOffer(**job_offer_data)
        
        # Vérification de la qualité des données
        MIN_OFFER_LENGTH = 100
        if not offer.texte_integral or len(offer.texte_integral) < MIN_OFFER_LENGTH:
            return {
                "error": "insufficient_data",
                "message": "La description de l'offre est trop courte pour une analyse de compatibilité détaillée."
            }
        
        # === NIVEAU 1 : ANALYSE GLOBALE SÉMANTIQUE ===
        logger.info("Démarrage de l'analyse globale (Niveau 1)")
        
        # 1.1 Création des embeddings de sections pour le candidat
        candidate_sections = {}
        if profile.description:
            candidate_sections['description'] = create_section_embedding('description', profile.description)
        
        # Compétences
        competences_text = " ".join([comp.nom for comp in profile.competences])
        if competences_text.strip():
            candidate_sections['competences'] = create_section_embedding('competences', competences_text)
        
        # Expériences
        experiences_text = " ".join([
            f"{exp.titre_poste} {exp.description}" for exp in profile.experiences if exp.description
        ])
        if experiences_text.strip():
            candidate_sections['experiences'] = create_section_embedding('experiences', experiences_text)
        
        # Formations
        formations_text = " ".join([
            f"{form.niveau} {form.domaine} {form.etablissement or ''}" for form in profile.formations
        ])
        if formations_text.strip():
            candidate_sections['formations'] = create_section_embedding('formations', formations_text)
        
        # Projets
        projets_text = " ".join([
            f"{proj.titre} {proj.description}" for proj in profile.projets if proj.description
        ])
        if projets_text.strip():
            candidate_sections['projets'] = create_section_embedding('projets', projets_text)
        
        # 1.2 Création des embeddings de sections pour l'offre
        offer_sections = {}
        if offer.description:
            offer_sections['description'] = create_section_embedding('offre_description', offer.description)
        
        # Compétences requises
        competences_requises_text = " ".join([comp.nom for comp in offer.competences_requises])
        if competences_requises_text.strip():
            offer_sections['competences_requises'] = create_section_embedding('competences_requises', competences_requises_text)
        
        # Exigences de formation
        if offer.formation_requise.domaines_acceptes:
            formation_text = f"{offer.formation_requise.niveau_minimum} {' '.join(offer.formation_requise.domaines_acceptes)}"
            offer_sections['formation_requise'] = create_section_embedding('formation_requise', formation_text)
        
        # 1.3 Analyse sémantique globale
        global_semantic_analysis = calculate_semantic_similarity_advanced(
            profile.texte_integral or "",
            offer.texte_integral or "",
            candidate_sections,
            offer_sections
        )
        
        logger.info(f"Analyse sémantique globale terminée - Score: {global_semantic_analysis.score:.2f}")
        
        # === NIVEAU 2 : ANALYSE GRANULAIRE STRUCTURÉE ===
        logger.info("Démarrage de l'analyse granulaire (Niveau 2)")
        
        # 2.1 Analyse des compétences avec l'approche avancée
        advanced_competence_analysis = analyze_competences_compatibility_advanced(
            profile.competences, 
            offer.competences_requises,
            profile.texte_integral or "",
            offer.texte_integral or ""
        )
        
        # 2.2 Analyse de formation (utilise la fonction existante)
        formation_score, f_details, f_reco = analyze_formation_compatibility(
            profile.formations, 
            offer.formation_requise, 
            profile.niveau_etude, 
            profile.niveau_etude_valeur
        )
        
        # 2.3 Analyse d'expérience (utilise la fonction existante)
        experience_score, e_details, e_reco = analyze_experience_compatibility(
            profile.experiences, 
            offer.experience_requise, 
            offer.description, 
            profile.niveau_experience_valeur
        )
        
        # 2.4 Analyse des langues
        langues_score, l_details, l_reco = analyze_langues_compatibility(
            profile.langues, offer.langues_requises
        )
        
        # 2.5 Analyse des outils
        outils_score, o_details, o_reco = analyze_outils_compatibility(
            profile.outils, offer.texte_integral or ""
        )
        
        # 2.6 Analyse des projets
        p_details, p_reco = analyze_projets_candidat(profile.projets, offer)
        
        # === CALCUL DU SCORE HYBRIDE FINAL ===
        
        # Score granulaire pondéré
        granular_scores = {
            'formation': formation_score,
            'experience': experience_score,
            'competences': calculate_competence_score_from_advanced(advanced_competence_analysis, offer.competences_requises),
            'langues': langues_score,
            'outils': outils_score
        }
        
        granular_composite_score = (
            granular_scores['formation'] * FORMATION_WEIGHT +
            granular_scores['experience'] * EXPERIENCE_WEIGHT +
            granular_scores['competences'] * COMPETENCES_WEIGHT +
            granular_scores['langues'] * LANGUES_WEIGHT +
            granular_scores['outils'] * OUTILS_WEIGHT
        )
        
        # Score hybride final (60% sémantique global + 40% granulaire)
        WEIGHT_GLOBAL_SEMANTIC = 0.6
        WEIGHT_GRANULAR = 0.4
        
        final_hybrid_score = (
            (global_semantic_analysis.score * WEIGHT_GLOBAL_SEMANTIC) +
            (granular_composite_score * WEIGHT_GRANULAR)
        ) * 100
        
        logger.info(f"Score hybride final calculé : {final_hybrid_score:.0f}%")
        
        # === GÉNÉRATION DU RAPPORT AVANCÉ ===
        
        # Points forts enrichis
        points_forts = []
        
        # Compétences exactes
        for skill in advanced_competence_analysis.exact_matches:
            points_forts.append(PointFort(
                description=f"Maîtrise confirmée : {skill}",
                categorie="competence",
                importance="important"
            ))
        
        # Correspondances sémantiques fortes
        for match in advanced_competence_analysis.semantic_matches:
            if match['similarity'] > 0.9:
                points_forts.append(PointFort(
                    description=f"Compétence très proche : {match['matched_skill']} pour {match['required_skill']}",
                    categorie="competence",
                    importance="normal"
                ))
        
        # Points forts des autres sections
        for detail in f_details + e_details + l_details + o_details + p_details:
            points_forts.append(PointFort(description=detail, categorie="general"))
        
        # Points d'amélioration enrichis
        points_amelioration = []
        
        # Compétences critiques manquantes
        for skill in advanced_competence_analysis.missing_critical:
            resources = generate_learning_resources(skill)
            points_amelioration.append(PointAmelioration(
                description=f"Compétence critique manquante : {skill}",
                categorie="competence",
                priorite="haute",
                suggestion=f"Formation recommandée en {skill}",
                ressources=resources[:3]
            ))
        
        # Autres recommandations
        for reco in f_reco + e_reco + l_reco + o_reco + p_reco:
            points_amelioration.append(PointAmelioration(description=reco, categorie="general"))
        
        # Suggestions avancées
        suggestions = []
        
        # Suggestions basées sur l'analyse des compétences
        for skill in advanced_competence_analysis.missing_optional:
            market_demand = analyze_skill_market_demand(skill)
            priority = "haute" if market_demand > 0.8 else "moyenne"
            
            suggestions.append(Suggestion(
                categorie="competence",
                description=f"Développer la compétence : {skill}",
                priorite=priority,
                impact_estime="fort" if market_demand > 0.8 else "moyen"
            ))
        
        # Analyse détaillée par catégorie
        analyse_detaillee = AnalyseDetaillee(
            formation=AnalyseCategorielle(
                categorie="Formation",
                score=round(formation_score * 100),
                points_forts=f_details,
                points_amelioration=f_reco,
                resume=generate_section_resume("formation", formation_score)
            ),
            experience=AnalyseCategorielle(
                categorie="Expérience",
                score=round(experience_score * 100),
                points_forts=e_details,
                points_amelioration=e_reco,
                resume=generate_section_resume("experience", experience_score)
            ),
            competences=AnalyseCategorielle(
                categorie="Compétences", 
                score=round(granular_scores['competences'] * 100),
                points_forts=[f"Maîtrise de {skill}" for skill in advanced_competence_analysis.exact_matches],
                points_amelioration=[f"Développer : {skill}" for skill in advanced_competence_analysis.missing_critical],
                resume=generate_section_resume("competences", granular_scores['competences'])
            ),
            langues=AnalyseCategorielle(
                categorie="Langues",
                score=round(langues_score * 100),
                points_forts=l_details,
                points_amelioration=l_reco,
                resume=generate_section_resume("langues", langues_score)
            )
        )
        
        # Niveau d'adéquation
        def get_adequation_level(score):
            if score > 85: return "Excellent"
            if score > 70: return "Très bon"
            if score > 50: return "Bon"
            if score > 30: return "Passable"
            return "Faible"
            
        niveau_adequation = get_adequation_level(final_hybrid_score)
        resume = generate_main_resume(final_hybrid_score, niveau_adequation, "competences", points_amelioration)
        
        # Temps d'analyse
        analysis_time = int((time.time() - start_time) * 1000)
        
        # Construction de la réponse finale
        response = MatchingResponseV2(
            score_global=round(final_hybrid_score),
            score_global_semantique=round(global_semantic_analysis.score * 100),
            niveau_adequation=niveau_adequation,
            resume=resume,
            points_forts=points_forts[:10],  # Limiter à 10 points forts
            points_amelioration=points_amelioration[:10],  # Limiter à 10 points d'amélioration
            suggestions=suggestions[:5],  # Limiter à 5 suggestions
            analyse_detaillee=analyse_detaillee,
            competences_manquantes=advanced_competence_analysis.missing_critical + advanced_competence_analysis.missing_optional,
            contexte_analyse=ContexteAnalyse(
                niveau_confiance="haute" if global_semantic_analysis.score > 0.7 else "moyenne",
                temps_analyse_ms=analysis_time,
                modeles_utilises={
                    "spacy": "fr_core_news_sm",
                    "sentence_transformer": "distiluse-base-multilingual-cased-v1"
                }
            )
        )
        
        logger.info(f"Analyse hybride V2 terminée en {analysis_time}ms")
        return response.dict(exclude_none=True)

    except Exception as e:
        logger.error(f"Erreur majeure dans analyze_compatibility: {e}", exc_info=True)
        return {
            "score_global": 0,
            "niveau_adequation": "Erreur",
            "resume": f"Une erreur est survenue lors de l'analyse: {str(e)}",
        }


def calculate_competence_score_from_advanced(analysis: AdvancedCompetenceAnalysis, required_competences: List[Competence]) -> float:
    """
    Calcule un score de compatibilité basé sur l'analyse avancée des compétences.
    """
    if not required_competences:
        return 1.0
    
    total_required = len(required_competences)
    exact_matches = len(analysis.exact_matches)
    semantic_matches = len([m for m in analysis.semantic_matches if m['similarity'] > 0.8])
    
    # Score basé sur les correspondances exactes et sémantiques
    exact_score = exact_matches / total_required
    semantic_score = semantic_matches / total_required * 0.8  # Les correspondances sémantiques valent 80%
    
    return min(1.0, exact_score + semantic_score)


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


def analyze_compatibility_hybrid(candidate_data: Dict, job_offer_data: Dict) -> HybridAnalysisResult:
    """
    Analyse hybride de compatibilité combinant approche sémantique et structurée.
    
    Cette fonction implémente une approche en deux niveaux :
    - Niveau 1 (60%) : Analyse sémantique globale avec IA
    - Niveau 2 (40%) : Analyse granulaire structurée traditionnelle
    
    Args:
        candidate_data: Données du candidat
        job_offer_data: Données de l'offre d'emploi
        
    Returns:
        HybridAnalysisResult: Résultats complets de l'analyse hybride
    """
    start_time = time.time()
    logger.info("Starting hybrid compatibility analysis...")
    
    try:
        # === NIVEAU 1: ANALYSE SÉMANTIQUE GLOBALE (60%) ===
        
        # Préparation des textes pour l'analyse sémantique
        candidate_text = _prepare_candidate_text_for_semantic_analysis(candidate_data)
        offer_text = _prepare_offer_text_for_semantic_analysis(job_offer_data)
        
        # Extraction d'entités avancée
        candidate_entities = extract_entities_with_spacy(candidate_text)
        offer_entities = extract_entities_with_spacy(offer_text)
        
        # Génération d'embeddings par section
        candidate_embeddings = {
            'competences': create_section_embedding('competences', _extract_competences_text(candidate_data)),
            'experience': create_section_embedding('experience', _extract_experience_text(candidate_data)),
            'formation': create_section_embedding('formation', _extract_formation_text(candidate_data)),
            'projets': create_section_embedding('projets', _extract_projets_text(candidate_data))
        }
        
        offer_embeddings = {
            'description': create_section_embedding('description', offer_text),
            'competences': create_section_embedding('competences', job_offer_data.get('competences_requises', '')),
            'experience': create_section_embedding('experience', job_offer_data.get('exigence_experience', {}).get('description', ''))
        }
        
        # Calcul de la similarité sémantique avancée
        semantic_similarity = calculate_semantic_similarity_advanced(
            candidate_text, 
            offer_text, 
            candidate_embeddings, 
            offer_embeddings
        )
        
        # Score sémantique global
        score_semantique = semantic_similarity.score * 100
        
        
        # === NIVEAU 2: ANALYSE GRANULAIRE STRUCTURÉE (40%) ===
        
        # Utilisation de l'analyse traditionnelle pour le score granulaire
        traditional_analysis = analyze_compatibility(candidate_data, job_offer_data)
        score_granulaire = traditional_analysis.get('score_global', 0)
        
        
        # === CALCUL DU SCORE HYBRIDE ===
        
        score_global = (score_semantique * 0.6) + (score_granulaire * 0.4)
        
        
        # === ANALYSE AVANCÉE DES COMPÉTENCES ===
        
        candidate_competences = _parse_competences_from_data(candidate_data)
        required_competences = _parse_competences_from_data(job_offer_data, is_offer=True)
        
        advanced_competence_analysis = analyze_competences_compatibility_advanced(
            candidate_competences,
            required_competences,
            candidate_text,
            offer_text
        )
        
        
        # === ANALYSE DES CORRESPONDANCES D'ENTITÉS ===
        
        entity_matches = _analyze_entity_matches(candidate_entities, offer_entities)
        
        
        # === CLUSTERING TECHNOLOGIQUE ===
        
        candidate_skills = [comp.nom for comp in candidate_competences] if candidate_competences else []
        skill_clusters = cluster_skills_by_technology(candidate_skills)
        
        
        # === ANALYSE DES LACUNES ET PROGRESSION ===
        
        skill_gap_analysis = _perform_skill_gap_analysis(candidate_competences, required_competences)
        career_progression = _analyze_career_progression(candidate_data, job_offer_data)
        
        
        # === GÉNÉRATION DU RÉSULTAT HYBRIDE ===
        
        # Points forts enrichis
        points_forts = _generate_enhanced_strengths(
            traditional_analysis.get('points_forts', []),
            semantic_similarity,
            advanced_competence_analysis,
            entity_matches
        )
        
        # Suggestions personnalisées
        suggestions = _generate_hybrid_suggestions(
            skill_gap_analysis,
            career_progression,
            advanced_competence_analysis
        )
        
        # Métadonnées d'analyse
        analysis_time = int((time.time() - start_time) * 1000)
        metadata = {
            'version': '2.0-hybrid',
            'modeles_ia': {
                'spacy': 'fr_core_news_sm',
                'sentence_transformer': 'distiluse-base-multilingual-cased-v1'
            },
            'approche': 'hybride_semantique_granulaire',
            'poids': {
                'semantique': 0.6,
                'granulaire': 0.4
            },
            'temps_analyse_ms': analysis_time,
            'entites_extraites': len(candidate_entities) + len(offer_entities),
            'embeddings_generes': len(candidate_embeddings) + len(offer_embeddings)
        }
        
        result = {
            "score_global": round(score_global, 2),
            "score_semantique": round(score_semantique, 2),
            "score_granulaire": round(score_granulaire, 2),
            "niveau_adequation": _get_adequation_level_hybrid(score_global),
            
            "semantic_similarity": semantic_similarity.dict() if hasattr(semantic_similarity, 'dict') else semantic_similarity,
            "advanced_competence_analysis": advanced_competence_analysis.dict() if hasattr(advanced_competence_analysis, 'dict') else advanced_competence_analysis,
            "entity_matches": [match.dict() if hasattr(match, 'dict') else match for match in entity_matches],
            "skill_clusters": skill_clusters,
            "skill_gap_analysis": skill_gap_analysis.dict() if hasattr(skill_gap_analysis, 'dict') else skill_gap_analysis,
            "career_progression": career_progression.dict() if hasattr(career_progression, 'dict') else career_progression,
            
            "points_forts": [pf.dict() if hasattr(pf, 'dict') else pf for pf in points_forts],
            "suggestions": [s.dict() if hasattr(s, 'dict') else s for s in suggestions],
            
            # Données traditionnelles enrichies
            "analyses_detaillees": traditional_analysis.get('analyses_detaillees', {}),
            "points_amelioration": traditional_analysis.get('points_amelioration', []),
            
            "metadata": metadata
        }
        
        logger.info(f"Hybrid analysis completed: Global={score_global:.2f} (Semantic={score_semantique:.2f}, Granular={score_granulaire:.2f}) in {analysis_time}ms")
        
        return result
        
    except Exception as e:
        logger.error(f"Error in hybrid compatibility analysis: {str(e)}", exc_info=True)
        raise


def _prepare_candidate_text_for_semantic_analysis(candidate_data: Dict) -> str:
    """Prépare le texte candidat pour l'analyse sémantique."""
    texts = []
    
    # Description personnelle
    if candidate_data.get('description'):
        texts.append(candidate_data['description'])
    
    # Compétences
    competences = candidate_data.get('competences', [])
    if competences:
        comp_text = ', '.join([c.get('nom', '') for c in competences if c.get('nom')])
        texts.append(f"Compétences: {comp_text}")
    
    # Expériences
    experiences = candidate_data.get('experiences', [])
    for exp in experiences:
        if exp.get('description'):
            texts.append(f"Expérience {exp.get('titre_poste', '')}: {exp.get('description', '')}")
    
    # Formations
    formations = candidate_data.get('formations', [])
    for form in formations:
        texts.append(f"Formation {form.get('niveau', '')} en {form.get('domaine', '')} à {form.get('etablissement', '')}")
    
    # Projets
    projets = candidate_data.get('projets', [])
    for proj in projets:
        if proj.get('description'):
            texts.append(f"Projet {proj.get('titre', '')}: {proj.get('description', '')}")
    
    return ' '.join(texts)


def _prepare_offer_text_for_semantic_analysis(job_offer_data: Dict) -> str:
    """Prépare le texte de l'offre pour l'analyse sémantique."""
    texts = []
    
    # Titre et description
    if job_offer_data.get('titre'):
        texts.append(job_offer_data['titre'])
    
    if job_offer_data.get('description'):
        texts.append(job_offer_data['description'])
    
    # Compétences requises
    competences = job_offer_data.get('competences_requises', [])
    if competences:
        if isinstance(competences, str):
            texts.append(f"Compétences requises: {competences}")
        elif isinstance(competences, list):
            comp_text = ', '.join([c.get('nom', '') if isinstance(c, dict) else str(c) for c in competences if c])
            if comp_text:
                texts.append(f"Compétences requises: {comp_text}")
    
    # Exigences
    exigence_exp = job_offer_data.get('exigence_experience', {})
    if exigence_exp.get('description'):
        texts.append(f"Expérience requise: {exigence_exp['description']}")
    
    exigence_form = job_offer_data.get('exigence_formation', {})
    if exigence_form.get('niveau'):
        texts.append(f"Formation requise: {exigence_form['niveau']} en {exigence_form.get('domaine', '')}")
    
    return ' '.join(texts)


def _extract_competences_text(data: Dict) -> str:
    """Extrait le texte des compétences."""
    competences = data.get('competences', [])
    if isinstance(competences, str):
        return competences
    elif isinstance(competences, list):
        if competences and isinstance(competences[0], dict):
            return ', '.join([c.get('nom', '') for c in competences if c.get('nom')])
        elif competences and isinstance(competences[0], str):
            return ', '.join(competences)
    return ''


def _extract_experience_text(data: Dict) -> str:
    """Extrait le texte des expériences."""
    experiences = data.get('experiences', [])
    texts = []
    for exp in experiences:
        texts.append(f"{exp.get('titre_poste', '')} - {exp.get('description', '')}")
    return ' '.join(texts)


def _extract_formation_text(data: Dict) -> str:
    """Extrait le texte des formations."""
    formations = data.get('formations', [])
    texts = []
    for form in formations:
        texts.append(f"{form.get('niveau', '')} en {form.get('domaine', '')}")
    return ' '.join(texts)


def _extract_projets_text(data: Dict) -> str:
    """Extrait le texte des projets."""
    projets = data.get('projets', [])
    texts = []
    for proj in projets:
        texts.append(f"{proj.get('titre', '')} - {proj.get('description', '')}")
    return ' '.join(texts)


def _parse_competences_from_data(data: Dict, is_offer: bool = False) -> List[Competence]:
    """Parse les compétences depuis les données et retourne des objets Competence."""
    if is_offer:
        competences = data.get('competences_requises', [])
    else:
        competences = data.get('competences', [])
    
    result = []
    
    if isinstance(competences, str):
        # Si c'est une chaîne, la diviser par virgules
        for comp in competences.split(','):
            result.append(Competence(
                nom=comp.strip(),
                niveau=3,  # Niveau par défaut
                annees_experience=1.0
            ))
    elif isinstance(competences, list):
        for comp in competences:
            if isinstance(comp, dict):
                result.append(Competence(
                    nom=comp.get('nom', ''),
                    niveau=comp.get('niveau', 3),
                    annees_experience=comp.get('annees_experience', 1.0),
                    certifications=comp.get('certifications', []),
                    derniere_utilisation=comp.get('derniere_utilisation'),
                    contexte_utilisation=comp.get('contexte_utilisation', []),
                    type_competence=comp.get('type_competence', 'Technique'),
                    projets_associes=comp.get('projets_associes', [])
                ))
            elif isinstance(comp, str):
                result.append(Competence(
                    nom=comp.strip(),
                    niveau=3,
                    annees_experience=1.0
                ))
    
    return result


def _analyze_entity_matches(candidate_entities: List[ExtractedEntity], offer_entities: List[ExtractedEntity]) -> List[EntityMatchResult]:
    """Analyse les correspondances entre entités extraites."""
    matches = []
    
    # Grouper les entités par type
    entity_types = set()
    for entity in candidate_entities + offer_entities:
        entity_types.add(entity.label)
    
    # Analyser les correspondances pour chaque type d'entité
    for entity_type in entity_types:
        candidate_entities_of_type = [e for e in candidate_entities if e.label == entity_type]
        offer_entities_of_type = [e for e in offer_entities if e.label == entity_type]
        
        if not candidate_entities_of_type or not offer_entities_of_type:
            # Pas de correspondance possible pour ce type
            continue
        
        # Trouver les correspondances pour ce type
        type_matches = []
        similarity_scores = {}
        
        for c_entity in candidate_entities_of_type:
            for o_entity in offer_entities_of_type:
                # Calculer la similarité entre les entités
                similarity = get_semantic_similarity(c_entity.text, o_entity.text)
                
                if similarity > ENTITY_CONFIDENCE_THRESHOLD:
                    type_matches.append({
                        'candidate_entity': c_entity,
                        'offer_entity': o_entity,
                        'similarity': similarity,
                        'match_type': 'exact' if c_entity.label == o_entity.label else 'semantic'
                    })
                    similarity_scores[f"{c_entity.text}-{o_entity.text}"] = similarity
        
        # Créer le résultat pour ce type d'entité
        if type_matches or candidate_entities_of_type or offer_entities_of_type:
            # Identifier les entités manquantes dans le candidat
            missing_in_candidate = []
            for o_entity in offer_entities_of_type:
                if not any(match['offer_entity'].text == o_entity.text for match in type_matches):
                    missing_in_candidate.append(o_entity)
            
            matches.append(EntityMatchResult(
                entity_type=entity_type,
                candidate_entities=candidate_entities_of_type,
                offer_entities=offer_entities_of_type,
                matches=type_matches,
                missing_in_candidate=missing_in_candidate,
                similarity_scores=similarity_scores
            ))
    
    return matches


def _perform_skill_gap_analysis(candidate_competences: List[Competence], required_competences: List[Competence]) -> SkillGapAnalysis:
    """Effectue une analyse des lacunes de compétences."""
    candidate_skills = set([normalize_skill_name(c.nom) for c in candidate_competences])
    required_skills = set([normalize_skill_name(c.nom) for c in required_competences])
    
    missing_skills = required_skills - candidate_skills
    
    # Calcul des priorités
    missing_critical_skills = []
    missing_nice_to_have = []
    transferable_skills = []
    
    for skill in missing_skills:
        demand = analyze_skill_market_demand(skill)
        skill_info = {
            'nom': skill,
            'demande_marche': demand,
            'ressources': generate_learning_resources(skill)[:2]
        }
        
        if demand > 0.8:
            missing_critical_skills.append(skill_info)
        else:
            missing_nice_to_have.append(skill_info)
    
    # Identifier les compétences transférables
    for candidate_skill in candidate_skills:
        if candidate_skill not in required_skills:
            # Vérifier si la compétence peut être transférée
            transferable_skills.append({
                'nom': candidate_skill,
                'transferabilite': 0.7,  # Score par défaut
                'domaines_applicables': ['général']
            })
    
    # Générer un parcours d'apprentissage
    learning_path = []
    for skill_info in missing_critical_skills[:3]:  # Top 3 critiques
        learning_path.append({
            'competence': skill_info['nom'],
            'priorite': 'haute',
            'temps_estime': '2-3 mois',
            'ressources': skill_info['ressources']
        })
    
    # Temps d'apprentissage estimé
    estimated_learning_time = {}
    for skill_info in missing_critical_skills:
        estimated_learning_time[skill_info['nom']] = '2-3 mois'
    for skill_info in missing_nice_to_have:
        estimated_learning_time[skill_info['nom']] = '1-2 mois'
    
    return SkillGapAnalysis(
        missing_critical_skills=missing_critical_skills,
        missing_nice_to_have=missing_nice_to_have,
        transferable_skills=transferable_skills,
        learning_path=learning_path,
        estimated_learning_time=estimated_learning_time,
        market_resources=[res for skill_info in missing_critical_skills for res in skill_info['ressources']]
    )


def _analyze_career_progression(candidate_data: Dict, job_offer_data: Dict) -> CareerProgressionAnalysis:
    """Analyse la progression de carrière potentielle."""
    
    # 1. Niveaux actuels et cibles
    current_level = candidate_data.get('niveau_experience', 'Non spécifié')
    target_level = job_offer_data.get('experience_requise', {}).get('niveau', 'Non spécifié')
    
    # 2. Écart d'expérience
    candidate_exp_months = candidate_data.get('niveau_experience_valeur', 0) * 12
    required_exp_months = job_offer_data.get('experience_requise', {}).get('duree_minimum_mois', 0)
    required_experience_gap = max(0, int(required_exp_months - candidate_exp_months))
    
    # 3. Faisabilité de la progression
    if required_exp_months > 0:
        progression_feasibility = 1.0 - (required_experience_gap / required_exp_months)
    else:
        progression_feasibility = 1.0
    progression_feasibility = max(0.0, progression_feasibility)

    # 4. Compétences à développer (simplifié)
    offer_title_lower = job_offer_data.get('titre', '').lower()
    skill_progression_needed = []
    if any(keyword in offer_title_lower for keyword in ['senior', 'manager', 'lead', 'chef', 'directeur']):
        skill_progression_needed.append({'competence': 'Leadership', 'niveau_actuel': 'Intermédiaire', 'niveau_requis': 'Avancé'})
        skill_progression_needed.append({'competence': 'Gestion de projet', 'niveau_actuel': 'Intermédiaire', 'niveau_requis': 'Avancé'})

    # 5. Chemin de carrière typique (simplifié)
    typical_career_path = []
    if 'junior' in str(target_level).lower():
        typical_career_path = ['Développeur Junior', 'Développeur Confirmé', 'Développeur Senior']
    elif 'senior' in str(target_level).lower() or 'confirmé' in str(target_level).lower():
        typical_career_path = ['Développeur Confirmé', 'Développeur Senior', 'Lead Développeur/Architecte']
    
    return CareerProgressionAnalysis(
        current_level=str(current_level),
        target_level=str(target_level),
        progression_feasibility=float(progression_feasibility),
        required_experience_gap=int(required_experience_gap),
        skill_progression_needed=skill_progression_needed,
        typical_career_path=typical_career_path
    )


def _generate_enhanced_strengths(traditional_points_forts: List, semantic_similarity: SemanticSimilarity, 
                               advanced_competence_analysis: AdvancedCompetenceAnalysis,
                               entity_matches: List[EntityMatchResult]) -> List[PointFort]:
    """Génère des points forts enrichis avec l'analyse hybride."""
    points_forts = []
    
    # Points forts traditionnels
    for pf in traditional_points_forts:
        if isinstance(pf, dict):
            points_forts.append(PointFort(
                description=pf.get('description', pf.get('titre', '')),
                categorie=pf.get('domaine', 'general'),
                importance=pf.get('importance', 'normal').lower(),
                details=pf.get('details'),
                impact_score=pf.get('impact_score', 0.5)
            ))
    
    # Points forts sémantiques
    if hasattr(semantic_similarity, 'score') and semantic_similarity.score > 0.8:
        points_forts.append(PointFort(
            description=f"Excellente compatibilité sémantique - Votre profil présente une compatibilité sémantique de {semantic_similarity.score*100:.1f}% avec l'offre",
            categorie="analyse_ia",
            importance="critique",
            details="Détecté par analyse sémantique avancée",
            impact_score=0.9
        ))
    
    # Points forts basés sur les entités
    if len(entity_matches) > 3:
        points_forts.append(PointFort(
            description=f"Correspondances d'expertise détectées - {len(entity_matches)} correspondances précises d'expertise ont été détectées par l'IA",
            categorie="expertise_technique",
            importance="important",
            details="Analyse par extraction d'entités nommées",
            impact_score=0.8
        ))
    
    return points_forts


def _generate_hybrid_suggestions(skill_gap_analysis: SkillGapAnalysis, career_progression: CareerProgressionAnalysis,
                               advanced_competence_analysis: AdvancedCompetenceAnalysis) -> List[Suggestion]:
    """Génère des suggestions personnalisées basées sur l'analyse hybride."""
    suggestions = []
    
    # Suggestions basées sur les lacunes critiques
    for skill_info in skill_gap_analysis.missing_critical_skills[:3]:  # Top 3 critiques
        skill_name = skill_info.get('nom', '') if isinstance(skill_info, dict) else str(skill_info)
        resources = skill_info.get('ressources', []) if isinstance(skill_info, dict) else generate_learning_resources(skill_name)
        suggestions.append(Suggestion(
            categorie="Compétence critique",
            description=f"Acquisition urgente: {skill_name} - Cette compétence est critique pour le poste et très demandée sur le marché",
            priorite="haute",
            impact_estime="fort",
            ressources_recommandees=resources[:2] if resources else [],  # Top 2 ressources
            temps_acquisition_estime="court terme"
        ))
    
    # Suggestions basées sur la progression de carrière
    if career_progression.progression_feasibility < 0.7 and career_progression.required_experience_gap > 12:
        suggestions.append(Suggestion(
            categorie="Développement professionnel",
            description=f"Le poste semble nécessiter plus d'expérience ({career_progression.required_experience_gap / 12:.1f} mois manquants). Vous pourriez envisager des postes intermédiaires pour atteindre ce niveau.",
            priorite="moyenne",
            impact_estime="moyen",
            ressources_recommandees=generate_learning_resources("gestion de carrière")[:1],
            temps_acquisition_estime="long terme"
        ))

    if career_progression.skill_progression_needed:
        for skill_needed in career_progression.skill_progression_needed:
            suggestions.append(Suggestion(
                categorie="Développement professionnel",
                description=f"Pour évoluer vers ce type de poste, le développement de la compétence '{skill_needed.get('competence')}' est recommandé.",
                priorite="moyenne",
                impact_estime="moyen",
                ressources_recommandees=generate_learning_resources(skill_needed.get('competence', ''))[:2],
                temps_acquisition_estime="moyen terme"
            ))

    # Suggestions basées sur les compétences avancées
    # (Cette section peut être ajoutée si 'advanced_competence_analysis' contient des recommandations)

    return suggestions


def _get_adequation_level_hybrid(score: float) -> str:
    """Détermine le niveau d'adéquation basé sur le score hybride."""
    if score >= 85:
        return "Excellente"
    elif score >= 70:
        return "Très bonne"
    elif score >= 55:
        return "Bonne"
    elif score >= 40:
        return "Correcte"
    else:
        return "Faible"
