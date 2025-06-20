<?php
/**
 * Exemple d'appel à l'API de matching depuis PHP
 * Ce fichier montre comment envoyer les données du profil et de l'offre à l'API Python
 * et comment traiter la réponse.
 */

/**
 * Fonction qui envoie les données à l'API de matching et retourne le résultat
 * 
 * @param array $profil Les données du profil du candidat
 * @param array $offre Les données de l'offre d'emploi
 * @return array|false Le résultat de l'analyse ou false en cas d'erreur
 */
function analyserCorrespondance($profil, $offre) {
    // URL de l'API (à adapter selon votre configuration)
    $url = "http://localhost:8000/analyser";
    
    // Configuration de la requête cURL
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
    
    // Exécution de la requête
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Vérification de la réponse
    if ($status == 200) {
        return json_decode($response, true);
    } else {
        error_log("Erreur lors de l'appel à l'API de matching: $status - $response");
        return false;
    }
}

// Exemple d'utilisation
// Supposons que nous avons récupéré ces données de la base de données

// Données du profil du candidat (à adapter selon votre structure de données)
$profil = [
    "competences" => [
        ["nom" => "PHP", "niveau" => "avancé"],
        ["nom" => "JavaScript", "niveau" => "intermédiaire"],
        ["nom" => "HTML", "niveau" => "avancé"],
        ["nom" => "CSS", "niveau" => "avancé"],
        ["nom" => "MySQL", "niveau" => "intermédiaire"]
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
            "description" => "Développement de sites web et applications",
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

// Données de l'offre d'emploi (à adapter selon votre structure de données)
$offre = [
    "titre" => "Développeur PHP Full Stack",
    "description" => "Nous recherchons un développeur PHP expérimenté pour rejoindre notre équipe. Vous serez responsable du développement et de la maintenance de nos applications web. Vous devez maîtriser PHP, JavaScript, HTML/CSS et avoir une bonne connaissance des frameworks modernes.",
    "competences_requises" => ["PHP", "JavaScript", "React", "Node.js", "MySQL"],
    "niveau_etude_requis" => "Bac+3 Informatique",
    "experience_requise" => 3, // 3 ans d'expérience requis
    "langues_requises" => [
        ["nom" => "Français", "niveau" => "C1"],
        ["nom" => "Anglais", "niveau" => "B2"]
    ]
];

// Appel à l'API de matching
$resultat = analyserCorrespondance($profil, $offre);

// Affichage du résultat
if ($resultat) {
    echo "<h1>Résultat de l'analyse de correspondance</h1>";
    echo "<p>Score de correspondance: <strong>" . $resultat['pourcentage_global'] . "%</strong></p>";
    
    echo "<h2>Points forts</h2>";
    echo "<ul>";
    foreach ($resultat['points_forts'] as $point) {
        echo "<li>$point</li>";
    }
    echo "</ul>";
    
    echo "<h2>Points à améliorer</h2>";
    echo "<ul>";
    foreach ($resultat['points_a_ameliorer'] as $point) {
        echo "<li>$point</li>";
    }
    echo "</ul>";
    
    // Affichage des détails (optionnel)
    echo "<h2>Détails de l'analyse</h2>";
    echo "<h3>Compétences</h3>";
    echo "<p>Score: " . ($resultat['details']['competences']['score'] * 100) . "%</p>";
    
    echo "<h3>Formation</h3>";
    echo "<p>Score: " . ($resultat['details']['formation']['score'] * 100) . "%</p>";
    
    echo "<h3>Expérience</h3>";
    echo "<p>Score: " . ($resultat['details']['experience']['score'] * 100) . "%</p>";
} else {
    echo "<p>Erreur lors de l'analyse de correspondance.</p>";
}
?>
