<?php

require 'vendor/autoload.php';

use \NlpTools\Similarity\CosineSimilarity;
use \NlpTools\Tokenizers\WhitespaceTokenizer;

// Initialiser un tokenizer
$tokenizer = new WhitespaceTokenizer();
$cosineSimilarity = new CosineSimilarity();


$competences_candidat = array(
    "Développement web",
    "Conception de base de données",
    "Analyse de données",
    "Résolution de problèmes",
    "Communication interpersonnelle",
    "Gestion de projet",
    "Langages de programmation : PHP, JavaScript, Python",
    "Framework : Laravel, React, Django",
    "Base de données : MySQL, PostgreSQL, MongoDB",
    "Analyse statistique",
    "Machine Learning",
    "Développement mobile",
    "Conception UX/UI",
    "Cloud computing",
    "Systèmes embarqués"
);

$chaine_de_competences = implode("", $competences_candidat);

$chaine_de_competences_token = $tokenizer->tokenize($chaine_de_competences);

$teste = 'projet de computing et Développement Analyse je ne  PostgreSQL il nous faut de la communication';
$teste_token = $tokenizer->tokenize($teste);

$comparation = $cosineSimilarity->similarity($teste_token, $chaine_de_competences_token);
echo $comparation;


// Prétraitement des textes en les divisant en tokens
$texte1 = $tokenizer->tokenize("Ceci est un exemple de texte.");
$texte2 = $tokenizer->tokenize("Ceci est un autre exemple de texte.");

// Calcul de la similarité cosinus entre les textes
$similarity = $cosineSimilarity->similarity($texte1, $texte2);

// Affichage du résultat
echo "Similarité cosinus entre les textes : " . $similarity;

?>
