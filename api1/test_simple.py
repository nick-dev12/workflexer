#!/usr/bin/env python3
"""
Script de test pour l'analyse de compatibilité simplifiée
"""

import json
from utils import analyze_compatibility

def test_simple_analysis():
    """Test de l'analyse simplifiée"""
    
    # Données de test d'un candidat
    candidate_data = {
        "id": 1,
        "nom": "Jean Dupont",
        "email": "jean@example.com",
        "competences": [
            {"nom": "Communication", "niveau": 4},
            {"nom": "Gestion", "niveau": 3},
            {"nom": "Vente", "niveau": 4},
            {"nom": "Marketing", "niveau": 3},
            {"nom": "Négociation", "niveau": 4}
        ],
        "experiences": [
            {
                "titre_poste": "Responsable Commercial",
                "description": "Gestion d'une équipe de vente, négociation avec les clients",
                "competences": ["Vente", "Management"]
            }
        ],
        "projets": [],
        "formations": [],
        "langues": [],
        "outils": [],
        "texte_integral": "Responsable commercial expérimenté avec de solides compétences en vente, communication et gestion d'équipe. Expert en négociation et développement commercial."
    }
    
    # Données de test d'une offre d'emploi
    job_offer_data = {
        "id": 1,
        "titre": "Commercial B2B",
        "description": "Nous recherchons un commercial expérimenté pour développer notre portefeuille client B2B. Compétences requises : vente, négociation, communication, prospection commerciale.",
        "competences_requises": [
            {"nom": "Vente", "niveau": 4},
            {"nom": "Négociation", "niveau": 4},
            {"nom": "Communication", "niveau": 3},
            {"nom": "Prospection", "niveau": 3}
        ],
        "formation_requise": {
            "niveau_minimum": "Bac+2",
            "niveau_valeur": 2,
            "domaines_acceptes": ["Commerce", "Marketing"],
            "formation_obligatoire": False
        },
        "experience_requise": {
            "niveau": "Confirmé",
            "duree_minimum_mois": 24,
            "secteurs_acceptes": ["Commerce"],
            "competences_requises": ["Vente", "Négociation"]
        },
        "langues_requises": [],
        "secteur": "Commerce",
        "type_contrat": "CDI",
        "localisation": "Paris",
        "texte_integral": "Commercial B2B - Nous recherchons un commercial expérimenté pour développer notre portefeuille client B2B. Vous serez en charge de la prospection, de la négociation et du suivi client. Compétences requises : vente, négociation, communication, prospection commerciale. Expérience minimum 2 ans en vente B2B."
    }
    
    print("=== Test de l'analyse de compatibilité simplifiée ===")
    print(f"Candidat: {candidate_data['nom']}")
    print(f"Offre: {job_offer_data['titre']}")
    print()
    
    try:
        # Lancement de l'analyse
        result = analyze_compatibility(candidate_data, job_offer_data)
        
        # Affichage des résultats
        print("=== RÉSULTATS ===")
        print(f"Score global: {result.get('score_global', 0)}%")
        print(f"Résumé: {result.get('resume', 'N/A')}")
        print(f"Message compétences: {result.get('competences_message', 'N/A')}")
        print(f"Nombre de compétences trouvées: {result.get('nombre_competences_trouvees', 0)}")
        
        if result.get('competences_trouvees'):
            print("\n=== COMPÉTENCES TROUVÉES ===")
            for comp in result['competences_trouvees']:
                print(f"- {comp['competence']} ({comp['type_correspondance']}, {comp['confiance']}%)")
        
        print(f"\n=== CONTEXTE ===")
        contexte = result.get('contexte_analyse', {})
        print(f"Version API: {contexte.get('version_api', 'N/A')}")
        print(f"Temps d'analyse: {contexte.get('temps_analyse_ms', 0)}ms")
        print(f"Compétences analysées: {contexte.get('nombre_competences_analysees', 0)}")
        
        return True
        
    except Exception as e:
        print(f"ERREUR: {e}")
        import traceback
        traceback.print_exc()
        return False

if __name__ == "__main__":
    success = test_simple_analysis()
    if success:
        print("\n✅ Test réussi !")
    else:
        print("\n❌ Test échoué !") 