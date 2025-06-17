# Instructions pour l'API de matching WorkFlexer

## Structure du projet

```
api_matching/
├── requirements.txt     # Dépendances Python
├── setup.bat           # Script d'installation
├── start_api.bat       # Script de démarrage de l'API
├── main.py             # Point d'entrée de l'API
├── config.py           # Configuration de l'API
├── exemple_appel_php.php # Exemple d'appel à l'API depuis PHP
└── INSTRUCTIONS.md     # Ce fichier
```

## Installation

1. Assurez-vous que Python 3.8+ est installé sur votre système.
2. Exécutez le script `setup.bat` pour installer les dépendances.

## Démarrage de l'API

1. Exécutez le script `start_api.bat` pour démarrer l'API.
2. L'API sera accessible à l'adresse : http://localhost:8000
3. La documentation interactive de l'API est disponible à : http://localhost:8000/docs

## Utilisation depuis PHP

Pour utiliser l'API depuis votre code PHP, vous pouvez vous inspirer du fichier `exemple_appel_php.php`.

Voici les étapes principales :

1. Récupérer les données du profil candidat et de l'offre d'emploi.
2. Formater ces données selon le format attendu par l'API.
3. Envoyer une requête HTTP POST à l'API.
4. Récupérer et traiter la réponse.

## Format des données

### Entrée

L'API attend deux objets JSON :

1. **profil** : Les informations du candidat
   - `competences` : Liste des compétences
   - `formation` : Niveau d'études
   - `experience` : Années d'expérience

2. **offre** : Les informations de l'offre d'emploi
   - `competences_requises` : Liste des compétences requises
   - `formation_requise` : Niveau d'études requis
   - `experience_requise` : Années d'expérience requises

### Sortie

L'API renvoie un objet JSON avec :

- `pourcentage` : Score global de correspondance (0-100%)
- `points_forts` : Liste des points forts du candidat
- `points_a_ameliorer` : Liste des points à améliorer

## Intégration dans WorkFlexer

Pour intégrer l'API dans le site WorkFlexer, vous pouvez :

1. Créer une fonction d'appel à l'API dans un fichier utilitaire.
2. Appeler cette fonction lorsqu'un utilisateur consulte une offre d'emploi.
3. Afficher le résultat dans une section dédiée de la page.

Exemple :

```php
// Dans le contrôleur qui gère l'affichage des offres
if (isset($_GET['id_offre'])) {
    $id_offre = $_GET['id_offre'];
    $offre = getOffreDetails($db, $id_offre);
    
    // Si l'utilisateur est connecté, récupérer son profil et faire l'analyse
    if (isset($_SESSION['users_id'])) {
        $profil = getUserProfile($db, $_SESSION['users_id']);
        
        // Formater les données pour l'API
        $profil_data = formatUserProfileForAPI($profil);
        $offre_data = formatOffreForAPI($offre);
        
        // Appeler l'API
        $matching_result = analyserCorrespondance($profil_data, $offre_data);
        
        // Passer le résultat à la vue
        $_SESSION['matching_result'] = $matching_result;
    }
}
```

## Personnalisation

Pour personnaliser l'algorithme de matching, modifiez le fichier `config.py` :

- Ajustez les poids des différents critères
- Modifiez les seuils de correspondance
- Ajoutez de nouveaux critères d'analyse 