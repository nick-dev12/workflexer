-- Script pour ajouter la colonne remember_token_expires à la table users
-- Ce script vérifie d'abord si la colonne existe avant de l'ajouter

-- Vérifier et ajouter la colonne remember_token_expires si elle n'existe pas
SET @sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
         WHERE TABLE_SCHEMA = DATABASE() 
         AND TABLE_NAME = 'users' 
         AND COLUMN_NAME = 'remember_token_expires') = 0,
        'ALTER TABLE users ADD COLUMN remember_token_expires DATETIME NULL AFTER remember_token;',
        'SELECT "La colonne remember_token_expires existe déjà" AS message;'
    )
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Optionnel : Ajouter un index sur la colonne remember_token pour améliorer les performances
SET @sql_index = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS 
         WHERE TABLE_SCHEMA = DATABASE() 
         AND TABLE_NAME = 'users' 
         AND INDEX_NAME = 'idx_remember_token') = 0,
        'CREATE INDEX idx_remember_token ON users(remember_token);',
        'SELECT "L\"index idx_remember_token existe déjà" AS message;'
    )
);

PREPARE stmt_index FROM @sql_index;
EXECUTE stmt_index;
DEALLOCATE PREPARE stmt_index; 