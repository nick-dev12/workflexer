# Changelog Version 3.0 - Recherche Candidat dans Offre

## 🎯 Résumé des changements

**Nouvelle approche** : Au lieu d'analyser les correspondances traditionnelles, la V3 recherche les données du candidat directement dans le texte de l'offre consultée.

## 📁 Fichiers créés/modifiés

### Nouveaux fichiers Python
- `api1/utils.py` - Fonction `analyze_candidate_in_offer_v3()`
- `api1/app_v3.py` - Serveur Flask V3
- `api1/start_v3.py` - Script de démarrage
- `api1/test_v3.py` - Tests automatisés
- `api1/README_V3.md` - Documentation

### Fichiers PHP modifiés
- `controller/MatchingController.php` - Nouvelles méthodes V3

## 🎯 Priorités des données (Nouveau système)

| Données | Poids | Source principale |
|---------|-------|-------------------|
| **Compétences** | 40% | `competence_users` |
| **Description profil** | 25% | `description_users` |
| **Projets** | 20% | `projet_users` |
| Formation | 5% | Tables existantes |
| Expérience | 5% | Tables existantes |
| Langues | 5% | Tables existantes |

## 🔍 Fonctionnement

1. **Collecte** des données prioritaires (compétences, description, projets)
2. **Recherche** de ces données dans le texte de l'offre
3. **Calcul** du score basé sur les correspondances trouvées
4. **Génération** d'un rapport encourageant centré sur les points forts

## ✅ Avantages

- **Centré candidat** : Met en valeur ce qu'il possède
- **Encourageant** : Focus sur les points forts
- **Performance** : Priorise les données importantes
- **Simple** : Rapport clair et actionnable

## 🚀 Utilisation

```bash
# Démarrage
python api1/app_v3.py

# Tests
python api1/test_v3.py
```

**Endpoint** : `POST /analyze_candidate_in_offer_v3`

---
**Version** : 3.0.0 - Prêt pour déploiement 