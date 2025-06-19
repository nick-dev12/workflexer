<?php
// Script pour ajouter la colonne mis_en_avant à la table competence_users

// Inclusion de la connexion à la base de données
require_once(__DIR__ . '/../conn/conn.php');

try {
    // Vérifier si la colonne existe déjà
    $checkColumn = $db->query("SHOW COLUMNS FROM competence_users LIKE 'mis_en_avant'");
    $columnExists = $checkColumn->rowCount() > 0;

    if (!$columnExists) {
        // La colonne n'existe pas, on l'ajoute
        $db->exec("ALTER TABLE competence_users ADD COLUMN mis_en_avant TINYINT(1) DEFAULT 0");
        echo "La colonne 'mis_en_avant' a été ajoutée avec succès à la table 'competence_users'.";
    } else {
        echo "La colonne 'mis_en_avant' existe déjà dans la table 'competence_users'.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout de la colonne : " . $e->getMessage();
}
?> 