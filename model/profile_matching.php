<?php

require_once(__DIR__ . '/../conn/conn.php');

/**
 * Récupère les informations complètes du profil d'un candidat
 * 
 * @param mixed $db La connexion à la base de données
 * @param int $users_id L'identifiant de l'utilisateur
 * @return array Tableau contenant les informations du profil
 */
function getCandidateCompleteProfile($db, $users_id)
{
    // Information utilisateur
    $sql = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Formation
    $sql = "SELECT * FROM formation_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Expérience professionnelle
    $sql = "SELECT * FROM metier_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compétences
    $sql = "SELECT * FROM competence_users WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Niveau d'étude et d'expérience
    $sql = "SELECT * FROM niveau_etude WHERE users_id = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $niveaux = $stmt->fetch(PDO::FETCH_ASSOC);

    return [
        'userData' => $userData,
        'formations' => $formations,
        'experiences' => $experiences,
        'competences' => $competences,
        'niveaux' => $niveaux
    ];
}

/**
 * Convertit le profil du candidat en chaîne de caractères formatée
 * 
 * @param array $profile Tableau contenant les informations du profil
 * @return string Chaîne de caractères représentant le profil
 */
function convertProfileToString($profile)
{
    $result = "";

    // Ajouter les informations de l'utilisateur
    if (isset($profile['userData'])) {
        $result .= "Profil: " . (isset($profile['userData']['nom']) ? $profile['userData']['nom'] : "") . " ";
        $result .= (isset($profile['userData']['prenom']) ? $profile['userData']['prenom'] : "") . " ";
        $result .= (isset($profile['userData']['profession']) ? $profile['userData']['profession'] : "") . " ";
        $result .= (isset($profile['userData']['categorie']) ? $profile['userData']['categorie'] : "") . "\n";
    }

    // Ajouter les compétences
    if (isset($profile['competences']) && is_array($profile['competences'])) {
        $result .= "Compétences: ";
        foreach ($profile['competences'] as $competence) {
            $result .= $competence['competence'] . ", ";
        }
        $result .= "\n";
    }

    // Ajouter les formations
    if (isset($profile['formations']) && is_array($profile['formations'])) {
        $result .= "Formations: \n";
        foreach ($profile['formations'] as $formation) {
            $result .= "- " . $formation['niveau'] . " en " . $formation['Filiere'] . " à " . $formation['etablissement'];
            $result .= " de " . $formation['moisDebut'] . "/" . $formation['anneeDebut'];
            if (!empty($formation['moisFin']) && !empty($formation['anneeFin'])) {
                $result .= " à " . $formation['moisFin'] . "/" . $formation['anneeFin'];
            } elseif (!empty($formation['en_cours'])) {
                $result .= " (en cours)";
            }
            $result .= "\n";
        }
    }

    // Ajouter les expériences professionnelles
    if (isset($profile['experiences']) && is_array($profile['experiences'])) {
        $result .= "Expériences professionnelles: \n";
        foreach ($profile['experiences'] as $experience) {
            $result .= "- " . $experience['metier'];
            $result .= " de " . $experience['moisDebut'] . "/" . $experience['anneeDebut'];
            if (!empty($experience['moisFin']) && !empty($experience['anneeFin'])) {
                $result .= " à " . $experience['moisFin'] . "/" . $experience['anneeFin'];
            } elseif (!empty($experience['en_cours'])) {
                $result .= " (en cours)";
            }
            $result .= "\n";
            if (!empty($experience['description'])) {
                $result .= "  Description: " . $experience['description'] . "\n";
            }
        }
    }

    // Ajouter les niveaux d'étude et d'expérience
    if (isset($profile['niveaux'])) {
        $result .= "Niveau d'étude: " . (isset($profile['niveaux']['n_etude']) ? $profile['niveaux']['n_etude'] : "Non spécifié") . " ans\n";
        $result .= "Niveau d'expérience: " . (isset($profile['niveaux']['n_experience']) ? $profile['niveaux']['n_experience'] : "Non spécifié") . " ans\n";
    }

    return $result;
}

/**
 * Convertit une offre d'emploi en chaîne de caractères formatée
 * 
 * @param array $offre Tableau contenant les informations de l'offre
 * @return string Chaîne de caractères représentant l'offre
 */
function convertJobOfferToString($offre)
{
    $result = "";

    $result .= "Poste: " . (isset($offre['poste']) ? $offre['poste'] : "") . "\n";
    $result .= "Catégorie: " . (isset($offre['categorie']) ? $offre['categorie'] : "") . "\n";
    $result .= "Mission: " . (isset($offre['mission']) ? $offre['mission'] : "") . "\n";
    $result .= "Profil: " . (isset($offre['profil']) ? $offre['profil'] : "") . "\n";
    $result .= "Contrat: " . (isset($offre['contrat']) ? $offre['contrat'] : "") . "\n";
    $result .= "Études: " . (isset($offre['etudes']) ? $offre['etudes'] : "") . "\n";
    $result .= "Expérience: " . (isset($offre['experience']) ? $offre['experience'] : "") . "\n";
    $result .= "Localité: " . (isset($offre['localite']) ? $offre['localite'] : "") . "\n";
    $result .= "Langues: " . (isset($offre['langues']) ? $offre['langues'] : "") . "\n";
    $result .= "Niveau d'études requis: " . (isset($offre['n_etudes']) ? $offre['n_etudes'] : "0") . " ans\n";
    $result .= "Niveau d'expérience requis: " . (isset($offre['n_experience']) ? $offre['n_experience'] : "0") . " ans\n";

    return $result;
}

/**
 * Prétraite une chaîne de caractères pour la comparaison en supprimant certains caractères
 * et en normalisant le texte
 * 
 * @param string $text La chaîne à prétraiter
 * @return string La chaîne prétraitée
 */
function preprocessTextForComparison($text)
{
    // Conversion en minuscules
    $text = mb_strtolower($text, 'UTF-8');

    // Caractères à ignorer
    $ignore_chars = [
        ',',
        '.',
        '!',
        '?',
        ':',
        ';',
        '(',
        ')',
        '[',
        ']',
        '{',
        '}',
        '"',
        "'",
        '/',
        '\\',
        '|',
        '-',
        '_',
        '+',
        '=',
        '*',
        '&',
        '%',
        '$',
        '#',
        '@',
        '^',
        '~',
        '`',
        '<',
        '>',
        '\n',
        '\r',
        '\t'
    ];

    // Suppression des caractères à ignorer
    $text = str_replace($ignore_chars, ' ', $text);

    // Suppression des espaces multiples
    $text = preg_replace('/\s+/', ' ', $text);

    // Suppression des espaces en début et fin de chaîne
    $text = trim($text);

    return $text;
}

/**
 * Renforce les mots clés importants dans la chaîne pour améliorer la comparaison
 * 
 * @param string $text La chaîne à traiter
 * @return string La chaîne avec les mots clés renforcés
 */
function enhanceKeywords($text)
{
    // Liste des mots clés importants dans le domaine de l'emploi
    $keywordsImportance = [
        // Compétences techniques communes
        'développeur' => 3,
        'programmeur' => 3,
        'analyste' => 2,
        'ingénieur' => 2,
        'technicien' => 2,
        'administrateur' => 2,
        'architecte' => 3,
        'consultant' => 2,
        'gestionnaire' => 2,
        'chef de projet' => 3,
        'directeur' => 3,
        'manager' => 3,
        'responsable' => 2,
        'coordinateur' => 2,
        'superviseur' => 2,
        'expert' => 3,
        'spécialiste' => 2,

        // Langages de programmation
        'php' => 3,
        'javascript' => 3,
        'java' => 3,
        'python' => 3,
        'c++' => 3,
        'c#' => 3,
        'ruby' => 3,
        'html' => 2,
        'css' => 2,
        'sql' => 2,
        'typescript' => 3,
        'kotlin' => 3,
        'swift' => 3,
        'scala' => 3,
        'go' => 3,
        'rust' => 3,
        'perl' => 2,
        'r' => 2,
        'matlab' => 2,

        // Frameworks et technologies
        'laravel' => 3,
        'symfony' => 3,
        'react' => 3,
        'angular' => 3,
        'vue' => 3,
        'node' => 3,
        'express' => 3,
        'django' => 3,
        'flask' => 3,
        'spring' => 3,
        'asp.net' => 3,
        'jquery' => 2,
        'bootstrap' => 2,
        'tailwind' => 2,
        'wordpress' => 2,
        'drupal' => 2,
        'magento' => 2,
        'shopify' => 2,
        'flutter' => 3,
        'react native' => 3,

        // Bases de données
        'mysql' => 2,
        'postgresql' => 2,
        'mongodb' => 2,
        'oracle' => 2,
        'sql server' => 2,
        'sqlite' => 2,
        'redis' => 2,
        'cassandra' => 2,
        'dynamodb' => 2,
        'neo4j' => 2,
        'elasticsearch' => 2,

        // Outils et méthodologies
        'git' => 2,
        'docker' => 2,
        'kubernetes' => 2,
        'aws' => 2,
        'azure' => 2,
        'devops' => 3,
        'agile' => 2,
        'scrum' => 2,
        'kanban' => 2,
        'ci/cd' => 2,
        'terraform' => 2,
        'jenkins' => 2,
        'jira' => 2,
        'confluence' => 2,
        'trello' => 2,
        'github' => 2,
        'gitlab' => 2,
        'bitbucket' => 2,

        // Finance et comptabilité
        'finance' => 2,
        'comptabilité' => 2,
        'audit' => 2,
        'contrôle de gestion' => 2,
        'fiscalité' => 2,
        'trésorerie' => 2,
        'banque' => 2,
        'assurance' => 2,
        'investissement' => 2,
        'analyste financier' => 3,
        'expert comptable' => 3,
        'commissaire aux comptes' => 3,
        'actuaire' => 3,
        'courtier' => 2,
        'trader' => 2,
        'gestionnaire de patrimoine' => 3,

        // Marketing et communication
        'marketing' => 2,
        'communication' => 2,
        'publicité' => 2,
        'relations publiques' => 2,
        'digital' => 2,
        'seo' => 3,
        'sem' => 3,
        'réseaux sociaux' => 2,
        'community manager' => 3,
        'content manager' => 3,
        'brand manager' => 3,
        'chef de produit' => 3,
        'chef de marque' => 3,
        'acquisition' => 2,
        'crm' => 2,
        'e-commerce' => 2,
        'inbound marketing' => 2,
        'growth hacking' => 3,
        'copywriter' => 2,
        'rédacteur web' => 2,

        // Vente et commerce
        'vente' => 2,
        'commercial' => 2,
        'business development' => 3,
        'key account manager' => 3,
        'retail' => 2,
        'merchandising' => 2,
        'export' => 2,
        'import' => 2,
        'category manager' => 3,
        'directeur commercial' => 3,
        'négociateur' => 2,
        'acheteur' => 2,
        'approvisionnement' => 2,
        'supply chain' => 2,
        'logistique' => 2,
        'distribution' => 2,
        'commerce international' => 2,

        // Ressources humaines
        'ressources humaines' => 2,
        'recrutement' => 2,
        'formation' => 2,
        'développement des compétences' => 2,
        'talent acquisition' => 3,
        'rémunération' => 2,
        'avantages sociaux' => 2,
        'paie' => 2,
        'gpec' => 2,
        'relations sociales' => 2,
        'sirh' => 2,
        'chargé de recrutement' => 3,
        'responsable formation' => 3,
        'drh' => 3,
        'hrm' => 2,

        // Santé
        'santé' => 2,
        'médecin' => 3,
        'infirmier' => 3,
        'infirmière' => 3,
        'pharmacien' => 3,
        'dentiste' => 3,
        'kinésithérapeute' => 3,
        'psychologue' => 3,
        'aide-soignant' => 2,
        'technicien de laboratoire' => 3,
        'radiologue' => 3,
        'chirurgien' => 3,
        'vétérinaire' => 3,
        'sage-femme' => 3,
        'opticien' => 2,
        'orthophoniste' => 3,
        'ostéopathe' => 3,
        'ergothérapeute' => 3,
        'médecine' => 2,
        'hospitalier' => 2,

        // Ingénierie et industrie
        'ingénieur production' => 3,
        'ingénieur qualité' => 3,
        'ingénieur méthodes' => 3,
        'ingénieur maintenance' => 3,
        'ingénieur r&d' => 3,
        'électronique' => 2,
        'mécanique' => 2,
        'automatisme' => 2,
        'robotique' => 2,
        'électrotechnique' => 2,
        'qualité' => 2,
        'lean manufacturing' => 2,
        'aéronautique' => 2,
        'automobile' => 2,
        'naval' => 2,
        'ferroviaire' => 2,
        'agroalimentaire' => 2,
        'pharmaceutique' => 2,
        'chimie' => 2,
        'plasturgie' => 2,
        'métallurgie' => 2,

        // Construction et immobilier
        'btp' => 2,
        'construction' => 2,
        'architecture' => 3,
        'génie civil' => 3,
        'urbanisme' => 2,
        'immobilier' => 2,
        'promoteur' => 2,
        'agent immobilier' => 2,
        'gestionnaire de copropriété' => 3,
        'facility management' => 3,
        'conducteur de travaux' => 3,
        'chef de chantier' => 3,
        'électricien' => 2,
        'plombier' => 2,
        'chauffagiste' => 2,
        'menuisier' => 2,
        'charpentier' => 2,
        'maçon' => 2,
        'peintre' => 2,
        'couvreur' => 2,

        // Energie et environnement
        'énergie' => 2,
        'environnement' => 2,
        'développement durable' => 2,
        'énergies renouvelables' => 3,
        'éolien' => 2,
        'solaire' => 2,
        'hydraulique' => 2,
        'nucléaire' => 2,
        'hydrogène' => 2,
        'pétrole' => 2,
        'gaz' => 2,
        'recyclage' => 2,
        'traitement des déchets' => 2,
        'traitement de l\'eau' => 2,
        'biodiversité' => 2,
        'écologie' => 2,
        'hse' => 2,

        // Transport et logistique
        'transport' => 2,
        'chauffeur' => 2,
        'livreur' => 2,
        'conducteur' => 2,
        'pilote' => 3,
        'hôtesse de l\'air' => 2,
        'steward' => 2,
        'transitaire' => 2,
        'affréteur' => 2,
        'responsable entrepôt' => 3,
        'gestionnaire de stocks' => 2,
        'magasinier' => 2,
        'cariste' => 2,
        'manutentionnaire' => 2,
        'planificateur' => 2,
        'dispatching' => 2,
        'entreposage' => 2,

        // Education et formation
        'éducation' => 2,
        'enseignement' => 2,
        'professeur' => 3,
        'enseignant' => 3,
        'formateur' => 2,
        'coach' => 2,
        'tuteur' => 2,
        'éducateur' => 2,
        'directeur d\'école' => 3,
        'principal' => 3,
        'proviseur' => 3,
        'universitaire' => 2,
        'chercheur' => 3,
        'doctorant' => 2,
        'instituteur' => 3,
        'cpge' => 2,
        'agrégé' => 3,
        'pédagogie' => 2,

        // Média, art et culture
        'média' => 2,
        'journaliste' => 3,
        'reporter' => 3,
        'rédacteur en chef' => 3,
        'présentateur' => 2,
        'animateur' => 2,
        'réalisateur' => 3,
        'producteur' => 3,
        'photographe' => 3,
        'graphiste' => 3,
        'designer' => 3,
        'artiste' => 2,
        'musicien' => 2,
        'acteur' => 2,
        'auteur' => 2,
        'écrivain' => 2,
        'éditeur' => 2,
        'bibliothécaire' => 2,
        'documentaliste' => 2,
        'archiviste' => 2,

        // Tourisme, hôtellerie et restauration
        'tourisme' => 2,
        'hôtellerie' => 2,
        'restauration' => 2,
        'réceptionniste' => 2,
        'concierge' => 2,
        'chef cuisinier' => 3,
        'cuisinier' => 2,
        'pâtissier' => 2,
        'boulanger' => 2,
        'sommelier' => 2,
        'barman' => 2,
        'serveur' => 2,
        'guide touristique' => 2,
        'voyagiste' => 2,
        'agent de voyage' => 2,
        'revenue manager' => 3,
        'gouvernante' => 2,
        'directeur d\'hôtel' => 3,

        // Juridique et droit
        'juridique' => 2,
        'droit' => 2,
        'avocat' => 3,
        'juriste' => 3,
        'notaire' => 3,
        'huissier' => 3,
        'magistrat' => 3,
        'juge' => 3,
        'procureur' => 3,
        'greffier' => 2,
        'clerc' => 2,
        'compliance' => 2,
        'contentieux' => 2,
        'propriété intellectuelle' => 2,
        'droit des affaires' => 2,
        'droit social' => 2,
        'droit fiscal' => 2,
        'droit immobilier' => 2,

        // Sécurité et défense
        'sécurité' => 2,
        'défense' => 2,
        'militaire' => 2,
        'police' => 2,
        'gendarmerie' => 2,
        'pompier' => 2,
        'agent de sécurité' => 2,
        'garde du corps' => 2,
        'officier' => 3,
        'sous-officier' => 2,
        'soldat' => 2,
        'surveillance' => 2,
        'gardiennage' => 2,
        'cybersécurité' => 3,
        'renseignement' => 2,
        'sécurité civile' => 2,

        // Télécommunications
        'télécommunications' => 2,
        'télécom' => 2,
        'réseaux' => 2,
        'fibre optique' => 2,
        'antennes' => 2,
        'opérateurs' => 2,
        'satellite' => 2,
        'voip' => 2,
        'ingénieur télécom' => 3,
        'technicien réseau' => 2,

        // Soft skills généraux
        'leadership' => 2,
        'collaboration' => 2,
        'autonomie' => 2,
        'résolution de problèmes' => 2,
        'créativité' => 2,
        'adaptabilité' => 2,
        'négociation' => 2,
        'gestion du temps' => 2,
        'organisation' => 2,
        'prise de décision' => 2,
        'esprit critique' => 2,
        'travail d\'équipe' => 2,
        'polyvalence' => 2,
        'rigueur' => 2,
        'analyse' => 2,
        'synthèse' => 2,
        'innovation' => 2
    ];

    // Renforcer les mots clés en les répétant selon leur importance
    foreach ($keywordsImportance as $keyword => $importance) {
        $pattern = '/\b' . preg_quote($keyword, '/') . '\b/i';
        $replacement = str_repeat(" $keyword", $importance);
        $text = preg_replace($pattern, $replacement, $text);
    }

    return $text;
}

/**
 * Calcule le pourcentage de correspondance basé sur les mots communs
 * indépendamment de leur ordre
 * 
 * @param string $str1 Première chaîne
 * @param string $str2 Deuxième chaîne
 * @return float Pourcentage de correspondance (0-100)
 */
function calculateKeywordMatchPercentage($str1, $str2)
{
    // Prétraitement des chaînes
    $processedStr1 = preprocessTextForComparison($str1);
    $processedStr2 = preprocessTextForComparison($str2);

    // Diviser les chaînes en mots
    $words1 = explode(' ', $processedStr1);
    $words2 = explode(' ', $processedStr2);

    // Filtrer les mots vides
    $words1 = array_filter($words1, function ($word) {
        return strlen($word) > 2; // Ignorer les mots trop courts
    });

    $words2 = array_filter($words2, function ($word) {
        return strlen($word) > 2; // Ignorer les mots trop courts
    });

    // Compter la fréquence des mots
    $wordFreq1 = array_count_values($words1);
    $wordFreq2 = array_count_values($words2);

    // Calculer le nombre de mots communs
    $commonWords = 0;
    foreach ($wordFreq1 as $word => $freq1) {
        if (isset($wordFreq2[$word])) {
            $commonWords += min($freq1, $wordFreq2[$word]);
        }
    }

    // Calculer le pourcentage
    $totalWords = count($words1) + count($words2);
    if ($totalWords > 0) {
        return (2 * $commonWords / $totalWords) * 100;
    }

    return 0;
}

/**
 * Calcule le pourcentage de similarité entre deux chaînes en combinant
 * plusieurs méthodes pour obtenir un résultat plus précis
 * 
 * @param string $str1 Première chaîne
 * @param string $str2 Deuxième chaîne
 * @return float Pourcentage de similarité combiné (0-100)
 */
function calculateSimilarityPercentage($str1, $str2)
{
    // Prétraitement des chaînes
    $processedStr1 = preprocessTextForComparison($str1);
    $processedStr2 = preprocessTextForComparison($str2);

    // Renforcement des mots clés importants
    $enhancedStr1 = enhanceKeywords($processedStr1);
    $enhancedStr2 = enhanceKeywords($processedStr2);

    // Calcul de la similarité avec similar_text (sensible à l'ordre)
    $similarTextPercentage = 0;
    similar_text($enhancedStr1, $enhancedStr2, $similarTextPercentage);

    // Calcul de la correspondance par mots-clés (insensible à l'ordre)
    $keywordMatchPercentage = calculateKeywordMatchPercentage($processedStr1, $processedStr2);

    // Combiner les deux méthodes (60% pour similar_text, 40% pour la correspondance par mots-clés)
    $combinedPercentage = ($similarTextPercentage * 0.6) + ($keywordMatchPercentage * 0.4);

    return $combinedPercentage;
}

/**
 * Identifie les termes qui contribuent le plus à la correspondance entre deux chaînes
 * 
 * @param string $str1 Première chaîne
 * @param string $str2 Deuxième chaîne
 * @param int $limit Nombre maximum de termes à retourner
 * @return array Liste des termes contributeurs avec leur poids
 */
function identifyMatchingTerms($str1, $str2, $limit = 10)
{
    // Prétraitement des chaînes
    $processedStr1 = preprocessTextForComparison($str1);
    $processedStr2 = preprocessTextForComparison($str2);

    // Diviser les chaînes en mots
    $words1 = explode(' ', $processedStr1);
    $words2 = explode(' ', $processedStr2);

    // Filtrer les mots vides
    $words1 = array_filter($words1, function ($word) {
        return strlen($word) > 2; // Ignorer les mots trop courts
    });

    $words2 = array_filter($words2, function ($word) {
        return strlen($word) > 2; // Ignorer les mots trop courts
    });

    // Compter la fréquence des mots
    $wordFreq1 = array_count_values($words1);
    $wordFreq2 = array_count_values($words2);

    // Calculer les scores des termes communs
    $termScores = [];
    foreach ($wordFreq1 as $word => $freq1) {
        if (isset($wordFreq2[$word])) {
            // Score basé sur la fréquence et l'importance du mot
            $frequency = min($freq1, $wordFreq2[$word]);

            // Vérifier si c'est un mot-clé important
            $keywordsImportance = [
                // Liste simplifiée pour l'exemple, utiliser la même liste que dans enhanceKeywords
                'développeur' => 3,
                'programmeur' => 3,
                'analyste' => 2,
                'ingénieur' => 2,
                'php' => 3,
                'javascript' => 3,
                'java' => 3,
                'python' => 3,
                'directeur' => 3,
                'manager' => 3,
                'marketing' => 2,
                'finance' => 2,
                'comptabilité' => 2,
                'banque' => 2,
                'assurance' => 2,
                'médecin' => 3,
                'infirmier' => 3,
                'avocat' => 3,
                'juriste' => 3,
                'enseignant' => 3,
                'professeur' => 3,
                'vente' => 2,
                'commercial' => 2,
                'btp' => 2,
                'construction' => 2,
                'industrie' => 2,
                'santé' => 2,
                'tourisme' => 2,
                'hôtellerie' => 2,
                'restauration' => 2,
                'transport' => 2,
                'logistique' => 2,
                'cybersécurité' => 3,
                'énergie' => 2,
                'environnement' => 2
            ];

            $importance = isset($keywordsImportance[$word]) ? $keywordsImportance[$word] : 1;

            $termScores[$word] = $frequency * $importance;
        }
    }

    // Trier par score décroissant
    arsort($termScores);

    // Limiter le nombre de termes retournés
    return array_slice($termScores, 0, $limit, true);
}

/**
 * Vérifie si un candidat correspond à une offre d'emploi
 * 
 * @param mixed $db La connexion à la base de données
 * @param int $users_id L'identifiant de l'utilisateur
 * @param int $offre_id L'identifiant de l'offre
 * @return array Tableau contenant le résultat de la vérification
 */
function checkProfileJobMatch($db, $users_id, $offre_id)
{
    // Récupérer les informations du candidat
    $candidateProfile = getCandidateCompleteProfile($db, $users_id);

    // Récupérer les informations de l'offre
    $sql = "SELECT * FROM offre_emploi WHERE offre_id = :offre_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
    $stmt->execute();
    $jobOffer = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier les niveaux d'études et d'expérience
    $niveauEtudeMatch = false;
    $niveauExperienceMatch = false;

    if (isset($candidateProfile['niveaux']) && isset($jobOffer)) {
        $niveauEtudeCandidat = isset($candidateProfile['niveaux']['n_etude']) ? (int) $candidateProfile['niveaux']['n_etude'] : 0;
        $niveauEtudeOffre = isset($jobOffer['n_etudes']) ? (int) $jobOffer['n_etudes'] : 0;

        $niveauExperienceCandidat = isset($candidateProfile['niveaux']['n_experience']) ? (int) $candidateProfile['niveaux']['n_experience'] : 0;
        $niveauExperienceOffre = isset($jobOffer['n_experience']) ? (int) $jobOffer['n_experience'] : 0;

        $niveauEtudeMatch = $niveauEtudeCandidat >= $niveauEtudeOffre;
        $niveauExperienceMatch = $niveauExperienceCandidat >= $niveauExperienceOffre;
    }

    // Convertir le profil et l'offre en chaînes de caractères
    $profileString = convertProfileToString($candidateProfile);
    $jobOfferString = convertJobOfferToString($jobOffer);

    // Calculer le pourcentage de similarité
    $similarityPercentage = calculateSimilarityPercentage($profileString, $jobOfferString);

    // Identifier les termes qui contribuent le plus à la correspondance
    $matchingTerms = identifyMatchingTerms($profileString, $jobOfferString, 5);

    return [
        'niveauEtudeMatch' => $niveauEtudeMatch,
        'niveauExperienceMatch' => $niveauExperienceMatch,
        'similarityPercentage' => $similarityPercentage,
        'profileString' => $profileString,
        'jobOfferString' => $jobOfferString,
        'matchingTerms' => $matchingTerms,
        'isMatch' => $niveauEtudeMatch && $niveauExperienceMatch && $similarityPercentage >= 30
    ];
}
?>