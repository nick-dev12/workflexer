<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Simuler une session si nécessaire
if (!isset($_SESSION['compte_entreprise'])) {
    $_SESSION['compte_entreprise'] = 'test_entreprise_id';
    echo "<p>Session simulée avec entreprise_id: test_entreprise_id</p>";
} else {
    echo "<p>Session existante avec entreprise_id: {$_SESSION['compte_entreprise']}</p>";
}

// Inclure les fichiers nécessaires
require_once(__DIR__ . '/conn/conn.php');
require_once(__DIR__ . '/model/fcm_tokens.php');

echo "<h1>Test de sauvegarde d'un token FCM</h1>";

// Test de connexion à la base de données
if (!isset($db) || !($db instanceof PDO)) {
    echo "<p style='color:red'>Erreur: Connexion à la base de données échouée</p>";
    exit;
}

echo "<p style='color:green'>Connexion à la base de données réussie</p>";

// Vérifier l'existence de la table
try {
    $stmt = $db->query("SHOW TABLES LIKE 'fcm_tokens'");
    $tableExists = $stmt->rowCount() > 0;

    if ($tableExists) {
        echo "<p style='color:green'>Table fcm_tokens existe</p>";

        // Afficher la structure de la table
        $columns = $db->query("DESCRIBE fcm_tokens")->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Colonnes de la table: " . implode(', ', $columns) . "</p>";

        // Compter les entrées existantes
        $count = $db->query("SELECT COUNT(*) FROM fcm_tokens")->fetchColumn();
        echo "<p>Nombre d'entrées existantes: $count</p>";

        // Afficher les entrées existantes
        $tokens = $db->query("SELECT * FROM fcm_tokens")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($tokens)) {
            echo "<h2>Tokens existants:</h2>";
            echo "<ul>";
            foreach ($tokens as $token) {
                echo "<li>ID: {$token['id']} - Entreprise: {$token['entreprise_id']} - Token: " . substr($token['token'], 0, 20) . "...</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p style='color:red'>Table fcm_tokens n'existe pas</p>";

        // Créer la table
        echo "<p>Tentative de création de la table...</p>";
        require_once(__DIR__ . '/migrations/create_fcm_tokens_table.php');
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Erreur lors de la vérification de la table: " . $e->getMessage() . "</p>";
}

// Fonction pour tester la sauvegarde d'un token
function testSaveToken($db, $entreprise_id, $token)
{
    echo "<h2>Test de sauvegarde d'un token</h2>";
    echo "<p>Entreprise ID: $entreprise_id</p>";
    echo "<p>Token (début): " . substr($token, 0, 20) . "...</p>";

    try {
        $result = saveEnterpriseToken($db, $entreprise_id, $token);

        if ($result) {
            echo "<p style='color:green'>Token sauvegardé avec succès!</p>";
        } else {
            echo "<p style='color:red'>Échec de la sauvegarde du token</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Exception lors de la sauvegarde: " . $e->getMessage() . "</p>";
    }

    // Vérifier si le token a bien été sauvegardé
    try {
        $stmt = $db->prepare("SELECT * FROM fcm_tokens WHERE entreprise_id = :entreprise_id");
        $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_STR);
        $stmt->execute();
        $savedToken = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($savedToken) {
            echo "<p style='color:green'>Token trouvé dans la base de données:</p>";
            echo "<ul>";
            echo "<li>ID: {$savedToken['id']}</li>";
            echo "<li>Entreprise: {$savedToken['entreprise_id']}</li>";
            echo "<li>Token (début): " . substr($savedToken['token'], 0, 20) . "...</li>";
            echo "<li>Créé le: {$savedToken['created_at']}</li>";
            echo "<li>Mis à jour le: {$savedToken['updated_at']}</li>";
            echo "</ul>";
        } else {
            echo "<p style='color:red'>Token non trouvé dans la base de données après la sauvegarde!</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Exception lors de la vérification: " . $e->getMessage() . "</p>";
    }
}

// Tester la sauvegarde d'un token de test
$testToken = "test_fcm_token_" . time() . "_" . bin2hex(random_bytes(16));
testSaveToken($db, $_SESSION['compte_entreprise'], $testToken);

echo "<h2>Actions</h2>";
echo "<ul>";
echo "<li><a href='setup_fcm.php'>Exécuter le script de configuration FCM</a></li>";
echo "<li><a href='test_fcm_token.php?reset=1'>Réinitialiser les tokens FCM</a></li>";
echo "</ul>";

// Option pour réinitialiser les tokens
if (isset($_GET['reset'])) {
    try {
        $db->exec("TRUNCATE TABLE fcm_tokens");
        echo "<p style='color:green'>Table fcm_tokens vidée avec succès</p>";
    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur lors de la réinitialisation: " . $e->getMessage() . "</p>";
    }
}