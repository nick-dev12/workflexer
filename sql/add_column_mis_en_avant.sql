-- Vérifier si la colonne mis_en_avant existe déjà dans la table metier_users
-- Si elle n'existe pas, l'ajouter

-- Pour MySQL
ALTER TABLE metier_users ADD COLUMN IF NOT EXISTS mis_en_avant TINYINT(1) DEFAULT 0;

-- Si votre serveur MySQL ne supporte pas la syntaxe IF NOT EXISTS, utilisez cette méthode alternative :
-- Décommentez le code ci-dessous et commentez la ligne précédente

/*
SET @exists = 0;
SELECT 1 INTO @exists FROM information_schema.columns 
WHERE table_schema = DATABASE() 
AND table_name = 'metier_users' 
AND column_name = 'mis_en_avant';

SET @query = IF(@exists = 0, 
    'ALTER TABLE metier_users ADD COLUMN mis_en_avant TINYINT(1) DEFAULT 0',
    'SELECT "La colonne mis_en_avant existe déjà dans la table metier_users"');

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
*/ 