# API de Matching WorkFlexer

API d'analyse de compatibilité entre profils de candidats et offres d'emploi pour la plateforme WorkFlexer.

## Fonctionnalités

- Analyse sémantique des compétences avec sentence-transformers
- Calcul de compatibilité pondéré entre profils et offres
- Suggestions personnalisées pour améliorer la compatibilité
- Analyse détaillée par catégorie (formation, expérience, compétences, langues)
- Options avancées pour personnaliser l'analyse

## Prérequis

- Python 3.7+
- FastAPI
- Uvicorn
- Sentence Transformers
- spaCy avec modèle français
- Autres dépendances listées dans `requirements.txt`

## Installation

1. Cloner le dépôt ou télécharger les fichiers

2. Installer les dépendances :
```bash
pip install -r requirements.txt
```

3. Télécharger le modèle spaCy français :
```bash
python -m spacy download fr_core_news_md
```

4. Configurer les variables d'environnement (optionnel) :
Créer un fichier `.env` à la racine du projet avec les paramètres souhaités.

## Démarrage de l'API

### Méthode simple

```bash
python start_api.py
```

### Méthode alternative

```bash
uvicorn main:app --reload --host 0.0.0.0 --port 8000
```

L'API sera accessible à l'adresse : http://localhost:8000

La documentation interactive (Swagger UI) : http://localhost:8000/docs

La documentation ReDoc : http://localhost:8000/redoc

## Endpoints principaux

### Analyse de compatibilité standard

`POST /analyze/v2`

Analyse la compatibilité entre un profil candidat et une offre d'emploi.

Exemple de requête :
```json
{
  "candidate": {
    "id": 1,
    "formations": [...],
    "experiences": [...],
    "competences": [...],
    "langues": [...],
    "niveau_etude": "Bac+5",
    "niveau_etude_valeur": 5,
    "niveau_experience": "5ans",
    "niveau_experience_valeur": 5
  },
  "job_offer": {
    "id": 1,
    "titre": "Contract Manager",
    "description": "...",
    "formation_requise": {...},
    "experience_requise": {...},
    "competences_requises": [...],
    "langues_requises": [...],
    "secteur": "Intérim, recrutement"
  }
}
```

### Analyse de compatibilité avancée

`POST /analyze/v3`

Analyse avancée avec options personnalisables.

Exemple de requête :
```json
{
  "candidate": {...},
  "job_offer": {...},
  "options": {
    "poids_formation": 0.3,
    "poids_experience": 0.3,
    "poids_competences": 0.3,
    "poids_langues": 0.1,
    "seuil_similarite_semantique": 0.8,
    "activer_analyse_semantique": true,
    "activer_suggestions_personnalisees": true,
    "niveau_detail_analyse": "complet",
    "inclure_ressources_apprentissage": true,
    "max_suggestions": 5
  }
}
```

## Structure de la réponse

La réponse de l'API contient :

- `score_global` : Score global de compatibilité (0-100)
- `niveau_adequation` : Niveau d'adéquation (Excellent, Bon, Moyen, À améliorer)
- `resume` : Résumé textuel de l'analyse
- `points_forts` : Liste des points forts du candidat
- `points_amelioration` : Liste des points à améliorer
- `analyse_detaillee` : Analyse détaillée par catégorie
- `suggestions` : Suggestions personnalisées pour améliorer la compatibilité

## Configuration

Les paramètres de l'API sont configurables via :

1. Variables d'environnement
2. Fichier `.env`
3. Options dans la requête pour `/analyze/v3`

## Licence

Ce projet est sous licence propriétaire. © WorkFlexer 2024.