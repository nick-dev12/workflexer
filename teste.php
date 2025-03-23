<?php
// Chaînes à comparer
$string1 = "Le développement technologique est essentiel.";
$string2 = "Développement technologique est essentiel";

// Liste des articles et déterminants à ignorer
$ignore_words = ['le', 'la', 'les', 'un', 'une', 'des', 'du', 'de', 'd\'', 'au', 'aux'];

// Fonction pour nettoyer la chaîne
function clean_string($string, $ignore_words)
{
    // Conversion en minuscules
    $string = strtolower($string);
    // Suppression des accents
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    // Suppression des articles et déterminants
    foreach ($ignore_words as $word) {
        $string = preg_replace('/\b' . preg_quote($word, '/') . '\b/', '', $string);
    }
    // Suppression des espaces supplémentaires
    $string = preg_replace('/\s+/', ' ', $string);
    return trim($string);
}

// Nettoyage des chaînes
$clean_string1 = clean_string($string1, $ignore_words);
$clean_string2 = clean_string($string2, $ignore_words);

// Calcul de la similarité
similar_text($clean_string1, $clean_string2, $percent);

// Affichage du résultat
echo "Pourcentage de similarité : $percent%";
?>