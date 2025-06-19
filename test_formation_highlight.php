<?php
// Démarrer la session
session_start();

// Simuler une session utilisateur
$_SESSION['users_id'] = 1; // Remplacez par un ID utilisateur valide

// Inclure la connexion à la base de données
include(__DIR__ . '/conn/conn.php');

// Inclure le modèle
require_once(__DIR__ . '/model/formation_users.php');

// Vérifier si la table a la colonne mis_en_avant
try {
    $stmt = $db->prepare("SHOW COLUMNS FROM formation_users LIKE 'mis_en_avant'");
    $stmt->execute();
    $column_exists = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$column_exists) {
        echo "La colonne 'mis_en_avant' n'existe pas dans la table formation_users. Création de la colonne...<br>";
        $db->exec("ALTER TABLE formation_users ADD COLUMN mis_en_avant TINYINT(1) NOT NULL DEFAULT 0");
        echo "Colonne 'mis_en_avant' créée avec succès.<br>";
    } else {
        echo "La colonne 'mis_en_avant' existe déjà dans la table formation_users.<br>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la vérification de la colonne : " . $e->getMessage() . "<br>";
}

// Test de la fonction updateFormationHighlights
echo "<h2>Test de la fonction updateFormationHighlights</h2>";

// Récupérer les formations de l'utilisateur
$formations = getFormation($db, $_SESSION['users_id']);

if (empty($formations)) {
    echo "Aucune formation trouvée pour l'utilisateur.<br>";
} else {
    echo "Formations trouvées : " . count($formations) . "<br>";
    
    // Afficher les formations actuelles
    echo "<h3>Formations actuelles</h3>";
    echo "<ul>";
    foreach ($formations as $formation) {
        $highlighted = $formation['mis_en_avant'] == 1 ? "Mise en avant" : "Non mise en avant";
        echo "<li>ID: " . $formation['id'] . " - " . $formation['Filiere'] . " (" . $highlighted . ")</li>";
    }
    echo "</ul>";
    
    // Sélectionner quelques formations pour les mettre en avant
    $formationIds = [];
    foreach ($formations as $index => $formation) {
        if ($index % 2 == 0) { // Sélectionner une formation sur deux
            $formationIds[] = $formation['id'];
        }
    }
    
    echo "<h3>Formations à mettre en avant</h3>";
    echo "<ul>";
    foreach ($formationIds as $id) {
        echo "<li>ID: " . $id . "</li>";
    }
    echo "</ul>";
    
    // Mettre à jour les formations mises en avant
    $result = updateFormationHighlights($db, $formationIds, $_SESSION['users_id']);
    echo "Résultat de la mise à jour : " . ($result ? "Succès" : "Échec") . "<br>";
    
    // Récupérer les formations mises à jour
    $updatedFormations = getFormation($db, $_SESSION['users_id']);
    
    // Afficher les formations mises à jour
    echo "<h3>Formations après mise à jour</h3>";
    echo "<ul>";
    foreach ($updatedFormations as $formation) {
        $highlighted = $formation['mis_en_avant'] == 1 ? "Mise en avant" : "Non mise en avant";
        echo "<li>ID: " . $formation['id'] . " - " . $formation['Filiere'] . " (" . $highlighted . ")</li>";
    }
    echo "</ul>";
}

echo "<p>Test terminé.</p>";
?> 