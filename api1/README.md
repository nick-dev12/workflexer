# API de Matching WorkFlexer

Cette API analyse la compatibilité entre un profil de candidat et une offre d'emploi. Elle permet d'obtenir un score de compatibilité global, des scores par catégorie, ainsi que les points forts et les points à améliorer pour mieux correspondre à l'offre.

## Installation

### Prérequis

- Python 3.8 ou supérieur
- pip (gestionnaire de paquets Python)
- Windows, Linux ou macOS

### Installation sur Windows

1. Clonez ce dépôt ou téléchargez les fichiers
2. Ouvrez une invite de commande dans le dossier de l'API
3. Exécutez le script d'installation :

```
setup.bat
```

Ce script va :
- Créer un environnement virtuel Python
- Installer toutes les dépendances nécessaires
- Télécharger les ressources NLTK requises

### Installation manuelle (toutes plateformes)

Si vous préférez installer manuellement ou si vous n'utilisez pas Windows :

```bash
# Créer un environnement virtuel
python -m venv venv

# Activer l'environnement virtuel
# Sur Windows :
venv\Scripts\activate
# Sur Linux/macOS :
source venv/bin/activate

# Installer les dépendances
pip install -r requirements.txt

# Télécharger les ressources NLTK
python -c "import nltk; nltk.download('punkt'); nltk.download('stopwords'); nltk.download('wordnet')"
```

## Démarrage de l'API

### Sur Windows

Exécutez le script de démarrage :

```
start_api.bat
```

### Manuellement (toutes plateformes)

```bash
# Activer l'environnement virtuel si ce n'est pas déjà fait
# Sur Windows :
venv\Scripts\activate
# Sur Linux/macOS :
source venv/bin/activate

# Démarrer l'API
uvicorn main:app --reload --host 0.0.0.0 --port 8000
```

L'API sera accessible à l'adresse : http://localhost:8000

## Documentation de l'API

Une fois l'API démarrée, vous pouvez accéder à la documentation interactive :

- Documentation Swagger UI : http://localhost:8000/docs
- Documentation ReDoc : http://localhost:8000/redoc

## Utilisation depuis PHP

Un exemple d'intégration avec PHP est disponible dans le fichier `exemple_appel_php.php`. Pour une intégration plus complète avec WorkFlexer, consultez le fichier `integration_workflexer.php`.

### Exemple d'appel à l'API

```php
<?php
// Initialisation de la requête cURL
$ch = curl_init('http://localhost:8000/analyser');

// Préparation des données
$data = [
    'candidate' => [
        'id' => 1,
        'competences' => ['PHP', 'JavaScript', 'HTML', 'CSS'],
        'formations' => [
            [
                'diplome' => 'Master en Informatique',
                'niveau' => 'Bac+5'
            ]
        ],
        // ... autres données du candidat
    ],
    'job_offer' => [
        'id' => 42,
        'competences_requises' => ['PHP', 'JavaScript', 'React'],
        'niveau_etudes' => 'Bac+5',
        // ... autres données de l'offre
    ]
];

// Configuration de la requête
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

// Exécution de la requête
$response = curl_exec($ch);
$results = json_decode($response, true);

// Utilisation des résultats
echo "Score de compatibilité : " . $results['global_score'] . "%";
?>
```

## Structure du projet

- `main.py` : Point d'entrée de l'API FastAPI
- `models.py` : Modèles de données pour l'API
- `utils.py` : Fonctions d'analyse et de traitement
- `config.py` : Configuration et paramètres
- `requirements.txt` : Liste des dépendances
- `setup.bat` : Script d'installation pour Windows
- `start_api.bat` : Script de démarrage pour Windows
- `exemple_appel_php.php` : Exemple d'utilisation depuis PHP
- `integration_workflexer.php` : Intégration avec WorkFlexer

## Personnalisation

Vous pouvez personnaliser les paramètres de l'API en modifiant le fichier `config.py` :

- Poids des différents critères dans le calcul de compatibilité
- Seuils de compatibilité
- Messages selon le niveau de compatibilité
- Nombre maximum de points forts et points à améliorer à retourner

## Dépannage

### L'API ne démarre pas

- Vérifiez que Python est correctement installé et accessible dans le PATH
- Vérifiez que toutes les dépendances sont installées : `pip list`
- Vérifiez qu'aucun autre service n'utilise déjà le port 8000

### Erreurs lors de l'appel à l'API depuis PHP

- Vérifiez que l'API est bien en cours d'exécution
- Vérifiez que l'URL de l'API est correcte
- Activez les logs d'erreur PHP pour plus de détails

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.