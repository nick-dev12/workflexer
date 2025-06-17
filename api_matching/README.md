# API de Matching WorkFlexer

Cette API Python analyse la correspondance entre un profil de candidat et une offre d'emploi, et renvoie un score de matching avec des recommandations personnalisées.

## Installation

### Prérequis

- Python 3.8 ou supérieur
- Windows (compatible avec d'autres OS avec adaptations)

### Étapes d'installation

1. Clonez ce dépôt ou téléchargez les fichiers dans votre projet
2. Exécutez le script d'installation :
   ```
   setup.bat
   ```
   Ce script va :
   - Créer un environnement virtuel Python
   - Installer les dépendances nécessaires
   - Télécharger les ressources NLTK pour l'analyse de texte

## Démarrage de l'API

Pour démarrer l'API, exécutez :
```
start_api.bat
```

L'API sera accessible à l'adresse : http://localhost:8000

La documentation interactive de l'API est disponible à : http://localhost:8000/docs

## Utilisation depuis PHP

### Exemple simple

```php
<?php
// Fonction pour appeler l'API
function analyserCorrespondance($profil, $offre) {
    $url = "http://localhost:8000/analyser";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "profil" => $profil,
        "offre" => $offre
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($status == 200) {
        return json_decode($response, true);
    } else {
        return false;
    }
}

// Exemple d'utilisation
$profil = [
    "competences" => [
        ["nom" => "PHP", "niveau" => "avancé"],
        ["nom" => "JavaScript", "niveau" => "intermédiaire"]
    ],
    "formations" => [
        [
            "filiere" => "Développement Web",
            "niveau" => "Bac+3",
            "etablissement" => "École du Web",
            "annee_debut" => "2018",
            "annee_fin" => "2021",
            "en_cours" => false
        ]
    ],
    "experiences" => [
        [
            "poste" => "Développeur Web",
            "entreprise" => "WebAgency",
            "description" => "Développement de sites web",
            "annee_debut" => "2021",
            "annee_fin" => null,
            "en_cours" => true
        ]
    ],
    "langues" => [
        ["nom" => "Français", "niveau" => "C2"],
        ["nom" => "Anglais", "niveau" => "B2"]
    ]
];

$offre = [
    "titre" => "Développeur PHP",
    "description" => "Nous recherchons un développeur PHP...",
    "competences_requises" => ["PHP", "JavaScript", "MySQL"],
    "niveau_etude_requis" => "Bac+3",
    "experience_requise" => 2,
    "langues_requises" => [
        ["nom" => "Français", "niveau" => "C1"],
        ["nom" => "Anglais", "niveau" => "B1"]
    ]
];

$resultat = analyserCorrespondance($profil, $offre);
?>
```

## Structure des données

### Format d'entrée

L'API attend deux objets JSON :

1. **profil** : Les informations du candidat
   - `competences` : Liste des compétences (objets avec nom et niveau)
   - `formations` : Liste des formations (filière, niveau, établissement, dates)
   - `experiences` : Liste des expériences professionnelles
   - `langues` : Liste des langues maîtrisées

2. **offre** : Les informations de l'offre d'emploi
   - `titre` : Titre de l'offre
   - `description` : Description complète de l'offre
   - `competences_requises` : Liste des compétences requises
   - `niveau_etude_requis` : Niveau d'études requis
   - `experience_requise` : Années d'expérience requises
   - `langues_requises` : Liste des langues requises

### Format de sortie

L'API renvoie un objet JSON avec :

- `pourcentage_global` : Score global de correspondance (0-100%)
- `points_forts` : Liste des points forts du candidat
- `points_a_ameliorer` : Liste des points à améliorer
- `details` : Détails de l'analyse par catégorie

## Fonctionnalités

- Analyse des compétences avec correspondance exacte et partielle
- Analyse du niveau de formation
- Analyse des années d'expérience
- Analyse des langues et niveaux requis
- Analyse sémantique de la description de l'offre
- Calcul d'un score global pondéré
- Recommandations personnalisées

## Dépannage

Si vous rencontrez des problèmes lors de l'installation :

1. Assurez-vous que Python 3.8+ est correctement installé
2. Vérifiez que pip est à jour
3. Si des erreurs de compilation apparaissent, utilisez les versions précompilées des bibliothèques

## Support

Pour toute question ou assistance, contactez l'équipe de développement de WorkFlexer. 