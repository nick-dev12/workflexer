<?php

require_once(__DIR__ . '/../../../conn/conn.php');
/**
 * Fonctions pour gérer la file d'attente des emails
 */

/**
 * Ajoute un email à la file d'attente
 * 
 * @param PDO $db Connexion à la base de données
 * @param string $destinataire Adresse email du destinataire
 * @param string $nom_destinataire Nom du destinataire
 * @param string $sujet Sujet de l'email
 * @param string $message Corps de l'email (HTML)
 * @return bool True si l'ajout a réussi, False sinon
 */
function ajouterEmailQueue($db, $destinataire, $nom_destinataire, $sujet, $message)
{
    try {
        $sql = "INSERT INTO email_queue (destinataire, nom_destinataire, sujet, message) 
                VALUES (:destinataire, :nom_destinataire, :sujet, :message)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':destinataire', $destinataire, PDO::PARAM_STR);
        $stmt->bindParam(':nom_destinataire', $nom_destinataire, PDO::PARAM_STR);
        $stmt->bindParam(':sujet', $sujet, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log('Erreur lors de l\'ajout d\'un email à la file d\'attente: ' . $e->getMessage());
        return false;
    }
}

/**
 * Récupère les emails en attente d'envoi
 * 
 * @param PDO $db Connexion à la base de données
 * @param int $limit Nombre maximum d'emails à récupérer
 * @return array Liste des emails en attente
 */
function getEmailsEnAttente($db, $limit = 10)
{
    try {
        $sql = "SELECT * FROM email_queue 
                WHERE statut = 'pending' 
                AND tentatives < 3
                ORDER BY date_creation ASC
                LIMIT :limit";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des emails en attente: ' . $e->getMessage());
        return [];
    }
}

/**
 * Met à jour le statut d'un email
 * 
 * @param PDO $db Connexion à la base de données
 * @param int $id ID de l'email
 * @param string $statut Nouveau statut ('sent' ou 'failed')
 * @param string $erreur Message d'erreur (optionnel)
 * @return bool True si la mise à jour a réussi, False sinon
 */
function updateEmailStatus($db, $id, $statut, $erreur = null)
{
    try {
        // Version corrigée de la requête SQL
        if ($statut == 'sent') {
            $sql = "UPDATE email_queue 
                    SET statut = :statut, 
                        tentatives = tentatives + 1,
                        date_envoi = NOW(),
                        erreur = :erreur
                    WHERE id = :id";
        } else {
            $sql = "UPDATE email_queue 
                    SET statut = :statut, 
                        tentatives = tentatives + 1,
                        erreur = :erreur
                    WHERE id = :id";
        }

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->bindParam(':erreur', $erreur, PDO::PARAM_STR);

        $result = $stmt->execute();

        // Vérifier si la mise à jour a réussi
        if (!$result) {
            error_log('Erreur lors de la mise à jour du statut de l\'email ID ' . $id . ': ' . print_r($stmt->errorInfo(), true));
        }

        return $result;
    } catch (PDOException $e) {
        error_log('Exception lors de la mise à jour du statut de l\'email ID ' . $id . ': ' . $e->getMessage());
        return false;
    }
}

/**
 * Nettoie les emails anciens qui ont été envoyés ou qui ont échoué définitivement
 * 
 * @param PDO $db Connexion à la base de données
 * @param int $jours Nombre de jours à conserver
 * @return bool True si le nettoyage a réussi, False sinon
 */
function nettoyerEmailsAnciens($db, $jours = 30)
{
    try {
        $sql = "DELETE FROM email_queue 
                WHERE (statut = 'sent' OR (statut = 'failed' AND tentatives >= 3))
                AND date_creation < DATE_SUB(NOW(), INTERVAL :jours DAY)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':jours', $jours, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log('Erreur lors du nettoyage des emails anciens: ' . $e->getMessage());
        return false;
    }
}