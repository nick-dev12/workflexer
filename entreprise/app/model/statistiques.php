<?php

/**
 * Fichier contenant les fonctions pour récupérer les statistiques de l'entreprise
 */

/**
 * Compte le nombre total d'offres publiées par une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre d'offres publiées
 */
function countOffresPubliees($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM offre_emploi WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre total d'offres supprimées par une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre d'offres supprimées
 */
function countOffresSupprimees($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM offre_suprimer WHERE entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre total d'offres expirées pour une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre d'offres expirées
 */
function countOffresExpirees($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM offre_emploi WHERE entreprise_id = :entreprise_id AND statut = 'expirée'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre total de candidatures pour toutes les offres d'une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre total de candidatures
 */
function countCandidatures($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM postulation p 
            JOIN offre_emploi o ON p.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre de candidats acceptés pour toutes les offres d'une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre de candidats acceptés
 */
function countCandidatsAcceptes($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM postulation p 
            JOIN offre_emploi o ON p.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id AND p.statut = 'accepter'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre de candidats refusés pour toutes les offres d'une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre de candidats refusés
 */
function countCandidatsRefuses($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM postulation p 
            JOIN offre_emploi o ON p.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id AND p.statut = 'recaler'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre de candidats en attente pour toutes les offres d'une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre de candidats en attente
 */
function countCandidatsEnAttente($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM postulation p 
            JOIN offre_emploi o ON p.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id AND (p.statut = '' OR p.statut IS NULL)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Compte le nombre total de vues pour toutes les offres d'une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return int Nombre total de vues
 */
function countVuesOffres($db, $entreprise_id)
{
    $sql = "SELECT COUNT(*) FROM vue_des_offres WHERE id_entreprise = :entreprise_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Récupère les statistiques de candidatures par catégorie d'offre
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return array Tableau associatif avec les catégories et le nombre de candidatures
 */
function getCandidaturesParCategorie($db, $entreprise_id)
{
    $sql = "SELECT o.categorie, COUNT(p.poste_id) as nombre 
            FROM postulation p 
            JOIN offre_emploi o ON p.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id 
            GROUP BY o.categorie";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les statistiques de vues par offre (top 5)
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return array Tableau associatif avec les offres et le nombre de vues
 */
function getVuesParOffre($db, $entreprise_id)
{
    $sql = "SELECT o.poste, COUNT(v.vue_id) as nombre 
            FROM vue_offre v 
            JOIN offre_emploi o ON v.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id 
            GROUP BY o.offre_id 
            ORDER BY nombre DESC 
            LIMIT 5";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les statistiques de candidatures par mois pour l'année en cours
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return array Tableau associatif avec les mois et le nombre de candidatures
 */
function getCandidaturesParMois($db, $entreprise_id)
{
    $sql = "SELECT MONTH(p.date) as mois, COUNT(p.poste_id) as nombre 
            FROM postulation p 
            JOIN offre_emploi o ON p.offre_id = o.offre_id 
            WHERE o.entreprise_id = :entreprise_id AND YEAR(p.date) = YEAR(CURRENT_DATE) 
            GROUP BY MONTH(p.date) 
            ORDER BY mois";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les statistiques pour une entreprise
 * @param PDO $db Connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @return array Tableau associatif avec toutes les statistiques
 */
function getAllStatistiques($db, $entreprise_id)
{
    $stats = [
        'offres_publiees' => countOffresPubliees($db, $entreprise_id),
        'offres_expirees' => countOffresExpirees($db, $entreprise_id),
        'offres_supprimees' => countOffresSupprimees($db, $entreprise_id),
        'candidatures_total' => countCandidatures($db, $entreprise_id),
        'candidats_acceptes' => countCandidatsAcceptes($db, $entreprise_id),
        'candidats_refuses' => countCandidatsRefuses($db, $entreprise_id),
        'candidats_en_attente' => countCandidatsEnAttente($db, $entreprise_id),
        'vues_total' => countVuesOffres($db, $entreprise_id),
        'candidatures_par_categorie' => getCandidaturesParCategorie($db, $entreprise_id),
        'vues_par_offre' => getVuesParOffre($db, $entreprise_id),
        'candidatures_par_mois' => getCandidaturesParMois($db, $entreprise_id)
    ];

    return $stats;
}

/**
 * Récupère les statistiques filtrées par date
 * 
 * @param PDO $db Instance de connexion à la base de données
 * @param int $entreprise_id ID de l'entreprise
 * @param string|null $startDate Date de début au format Y-m-d (null pour aucune restriction)
 * @param string|null $endDate Date de fin au format Y-m-d (null pour aucune restriction)
 * @return array Tableau associatif contenant toutes les statistiques filtrées
 */
function getFilteredStatistiques($db, $entreprise_id, $startDate = null, $endDate = null)
{
    // Préparation des conditions de date pour les requêtes SQL
    $dateCondition = "";
    $dateConditionPostulation = "";

    if ($startDate && $endDate) {
        $dateCondition = " AND date BETWEEN :start_date AND :end_date";
        $dateConditionPostulation = " AND p.date BETWEEN :start_date AND :end_date";
    } elseif ($startDate) {
        $dateCondition = " AND date >= :start_date";
        $dateConditionPostulation = " AND p.date >= :start_date";
    } elseif ($endDate) {
        $dateCondition = " AND date <= :end_date";
        $dateConditionPostulation = " AND p.date <= :end_date";
    }

    // Récupération du nombre d'offres publiées
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM offre_emploi 
        WHERE entreprise_id = :entreprise_id" . $dateCondition
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $offres_publiees = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre d'offres supprimées
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM offre_suprimer 
        WHERE entreprise_id = :entreprise_id" . $dateCondition
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $offres_supprimees = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre d'offres expirées
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM offre_emploi 
        WHERE entreprise_id = :entreprise_id 
        AND statut = 'expirée'" . $dateCondition
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $offres_expirees = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre total de candidatures
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM postulation p
        JOIN offre_emploi o ON p.offre_id = o.offre_id
        WHERE o.entreprise_id = :entreprise_id" . $dateConditionPostulation
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $candidatures_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre de candidats acceptés
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM postulation p
        JOIN offre_emploi o ON p.offre_id = o.offre_id
        WHERE o.entreprise_id = :entreprise_id 
        AND p.statut = 'accepté'" . $dateConditionPostulation
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $candidats_acceptes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre de candidats refusés
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM postulation p
        JOIN offre_emploi o ON p.offre_id = o.offre_id
        WHERE o.entreprise_id = :entreprise_id 
        AND p.statut = 'refusé'" . $dateConditionPostulation
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $candidats_refuses = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre de candidats en attente
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM postulation p
        JOIN offre_emploi o ON p.offre_id = o.offre_id
        WHERE o.entreprise_id = :entreprise_id 
        AND (p.statut IS NULL OR p.statut = '')" . $dateConditionPostulation
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $candidats_en_attente = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupération du nombre total de vues
    $stmt = $db->prepare("
        SELECT SUM(vues) as total 
        FROM offre_emploi 
        WHERE entreprise_id = :entreprise_id" . $dateCondition
    );
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $vues_total = $result['total'] ? $result['total'] : 0;

    // Récupération des candidatures par catégorie
    $stmt = $db->prepare("
        SELECT o.categorie, COUNT(p.poste_id) as nombre
        FROM postulation p
        JOIN offre_emploi o ON p.offre_id = o.offre_id
        WHERE o.entreprise_id = :entreprise_id" . $dateConditionPostulation . "
        GROUP BY o.categorie
        ORDER BY nombre DESC
    ");
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $candidatures_par_categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des vues par offre (top 5)
    $stmt = $db->prepare("
        SELECT poste, vues as nombre
        FROM offre_emploi
        WHERE entreprise_id = :entreprise_id" . $dateCondition . "
        ORDER BY vues DESC
        LIMIT 5
    ");
    $stmt->bindParam(':entreprise_id', $entreprise_id);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $vues_par_offre = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des candidatures par mois pour l'année en cours
    $currentYear = date('Y');

    $stmt = $db->prepare("
        SELECT MONTH(p.date) as mois, COUNT(p.poste_id) as nombre
        FROM postulation p
        JOIN offre_emploi o ON p.offre_id = o.offre_id
        WHERE o.entreprise_id = :entreprise_id
        AND YEAR(p.date) = :current_year" .
        ($startDate || $endDate ? $dateConditionPostulation : "") . "
        GROUP BY MONTH(p.date)
        ORDER BY mois
    ");
    $stmt->bindParam(':entreprise_id', $entreprise_id);
    $stmt->bindParam(':current_year', $currentYear);

    if ($startDate) {
        $stmt->bindParam(':start_date', $startDate);
    }
    if ($endDate) {
        $stmt->bindParam(':end_date', $endDate);
    }

    $stmt->execute();
    $candidatures_par_mois = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compilation de toutes les statistiques
    return [
        'offres_publiees' => $offres_publiees,
        'offres_supprimees' => $offres_supprimees,
        'offres_expirees' => $offres_expirees,
        'candidatures_total' => $candidatures_total,
        'candidats_acceptes' => $candidats_acceptes,
        'candidats_refuses' => $candidats_refuses,
        'candidats_en_attente' => $candidats_en_attente,
        'vues_total' => $vues_total,
        'candidatures_par_categorie' => $candidatures_par_categorie,
        'vues_par_offre' => $vues_par_offre,
        'candidatures_par_mois' => $candidatures_par_mois
    ];
}