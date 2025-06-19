<?php
// Démarrer la session
session_start();

// Simuler une session utilisateur
$_SESSION['users_id'] = 1; // Remplacez par un ID utilisateur valide

// Inclure la connexion à la base de données
include(__DIR__ . '/conn/conn.php');

// Vérifier si la table a la colonne mis_en_avant
try {
    $stmt = $db->prepare("SHOW COLUMNS FROM outil_users LIKE 'mis_en_avant'");
    $stmt->execute();
    $column_exists = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$column_exists) {
        echo "La colonne 'mis_en_avant' n'existe pas dans la table outil_users. Création de la colonne...<br>";
        $db->exec("ALTER TABLE outil_users ADD COLUMN mis_en_avant TINYINT(1) NOT NULL DEFAULT 0");
        echo "Colonne 'mis_en_avant' créée avec succès.<br>";
    } else {
        echo "La colonne 'mis_en_avant' existe déjà dans la table outil_users.<br>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la vérification de la colonne : " . $e->getMessage() . "<br>";
}

// Inclure le modèle
require_once(__DIR__ . '/model/outil_users.php');

// Test de la fonction updateOutilHighlights
echo "<h2>Test de la fonction updateOutilHighlights</h2>";

// Récupérer les outils de l'utilisateur
$outils = getOutil($db, $_SESSION['users_id']);

if (empty($outils)) {
    echo "Aucun outil trouvé pour l'utilisateur.<br>";
} else {
    echo "Outils trouvés : " . count($outils) . "<br>";
    
    // Afficher les outils actuels
    echo "<h3>Outils actuels</h3>";
    echo "<ul>";
    foreach ($outils as $outil) {
        $highlighted = $outil['mis_en_avant'] == 1 ? "Mis en avant" : "Non mis en avant";
        echo "<li>ID: " . $outil['id'] . " - " . $outil['outil'] . " (" . $highlighted . ")</li>";
    }
    echo "</ul>";
    
    // Sélectionner quelques outils pour les mettre en avant
    $outilIds = [];
    foreach ($outils as $index => $outil) {
        if ($index % 2 == 0) { // Sélectionner un outil sur deux
            $outilIds[] = $outil['id'];
        }
    }
    
    echo "<h3>Outils à mettre en avant</h3>";
    echo "<ul>";
    foreach ($outilIds as $id) {
        echo "<li>ID: " . $id . "</li>";
    }
    echo "</ul>";
    
    // Mettre à jour les outils mis en avant
    $result = updateOutilHighlights($db, $outilIds, $_SESSION['users_id']);
    echo "Résultat de la mise à jour : " . ($result ? "Succès" : "Échec") . "<br>";
    
    // Récupérer les outils mis à jour
    $updatedOutils = getOutil($db, $_SESSION['users_id']);
    
    // Afficher les outils mis à jour
    echo "<h3>Outils après mise à jour</h3>";
    echo "<ul>";
    foreach ($updatedOutils as $outil) {
        $highlighted = $outil['mis_en_avant'] == 1 ? "Mis en avant" : "Non mis en avant";
        echo "<li>ID: " . $outil['id'] . " - " . $outil['outil'] . " (" . $highlighted . ")</li>";
    }
    echo "</ul>";
}

echo "<p>Test terminé.</p>";
?> 