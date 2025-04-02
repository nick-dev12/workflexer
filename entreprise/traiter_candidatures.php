<?php
session_start();

if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: ../index.php');
    exit;
}

include_once('../controller/controller_accepte_candidats.php');
include_once('../entreprise/app/model/email_queue.php');
include_once('../entreprise/app/model/email_templates.php');
include_once('../model/postulation.php');
require_once('../model/accepte_candidats.php');
include_once('../conn/conn.php');
require_once('../model/fcm_notification.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['selected_candidates'])) {
    $action = $_POST['action'];
    $poste = $_POST['poste'];
    $poste_id = $_POST['poste_id'];

    // Décoder les données des candidats sélectionnés
    $selectedCandidates = json_decode($_POST['selected_candidates'], true);

    if (empty($selectedCandidates)) {
        $_SESSION['error_message'] = "Aucun candidat sélectionné.";
        header("Location: candidatures_poste.php?poste=" . urlencode($poste) . "&poste_id=" . urlencode($poste_id));
        exit;
    }

    $successCount = 0;
    $errorCount = 0;
    $fcmSuccessCount = 0;

    // Récupérer le nom de l'entreprise
    $entrepriseQuery = "SELECT entreprise FROM compte_entreprise WHERE id = :entreprise_id";
    $stmtEntreprise = $db->prepare($entrepriseQuery);
    $stmtEntreprise->bindValue(':entreprise_id', $_SESSION['compte_entreprise'], PDO::PARAM_STR);
    $stmtEntreprise->execute();
    $entrepriseInfo = $stmtEntreprise->fetch(PDO::FETCH_ASSOC);
    $nomEntreprise = $entrepriseInfo ? $entrepriseInfo['entreprise'] : 'Entreprise';

    // Traiter chaque candidat
    foreach ($selectedCandidates as $candidate) {
        $poste_id_candidat = $candidate['poste_id'];
        $offre_id = $candidate['offre_id'];
        $nom_candidat = $candidate['nom'];
        $email_candidat = $candidate['email'];

        // Récupérer les informations du postulant pour l'email
        $postulation = affichePostulant($db, $poste_id_candidat);

        // S'assurer que nous avons les données de l'utilisateur
        if (!$postulation) {
            $errorCount++;
            continue;
        }

        if ($action === 'accepter') {
            // Définir le statut pour l'acceptation
            $statut = 'accepter';

            // Accepter le candidat
            $success = AccepteCandidats($db, $statut, $poste_id_candidat);

            if ($success) {
                // Ajouter une notification de suivi si l'utilisateur et l'entreprise sont définis
                if (isset($postulation['entreprise_id']) && isset($postulation['users_id'])) {
                    notification_suivi($db, $postulation['entreprise_id'], $postulation['users_id'], $statut);

                    // Envoyer notification FCM au candidat accepté
                    $fcmResult = sendApplicationStatusNotification(
                        $db,
                        $postulation['users_id'],
                        'accepter',
                        $poste,
                        $nomEntreprise
                    );

                    if ($fcmResult) {
                        $fcmSuccessCount++;
                        error_log("Notification FCM envoyée avec succès pour l'utilisateur " . $postulation['users_id'] . " (Candidature acceptée)");
                    } else {
                        error_log("Échec de l'envoi de notification FCM pour l'utilisateur " . $postulation['users_id'] . " (Candidature acceptée)");
                    }
                }

                // Ajouter l'email à la file d'attente
                $sujet = "Candidature acceptée pour le poste de " . $poste;
                $message = generateAcceptEmail($nom_candidat, $poste);

                if (ajouterEmailQueue($db, $email_candidat, $nom_candidat, $sujet, $message)) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            } else {
                $errorCount++;
            }
        } elseif ($action === 'recaler') {
            // Définir le statut pour le refus
            $statut = 'recaler';

            // Refuser le candidat
            $success = recalerCandidats($db, $statut, $poste_id_candidat);

            if ($success) {
                // Ajouter une notification de suivi si l'utilisateur et l'entreprise sont définis
                if (isset($postulation['entreprise_id']) && isset($postulation['users_id'])) {
                    notification_suivi($db, $postulation['entreprise_id'], $postulation['users_id'], $statut);

                    // Envoyer notification FCM au candidat refusé
                    $fcmResult = sendApplicationStatusNotification(
                        $db,
                        $postulation['users_id'],
                        'recaler',
                        $poste,
                        $nomEntreprise
                    );

                    if ($fcmResult) {
                        $fcmSuccessCount++;
                        error_log("Notification FCM envoyée avec succès pour l'utilisateur " . $postulation['users_id'] . " (Candidature refusée)");
                    } else {
                        error_log("Échec de l'envoi de notification FCM pour l'utilisateur " . $postulation['users_id'] . " (Candidature refusée)");
                    }
                }

                // Ajouter l'email à la file d'attente
                $sujet = "Concernant votre candidature pour le poste de " . $poste;
                $message = generateRejectEmail($nom_candidat, $poste);

                if (ajouterEmailQueue($db, $email_candidat, $nom_candidat, $sujet, $message)) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            } else {
                $errorCount++;
            }
        }
    }

    // Définir le message de succès ou d'erreur
    if ($successCount > 0) {
        $actionText = ($action === 'accepter') ? 'accepté' : 'refusé';
        $_SESSION['success_message'] = "$successCount candidat(s) $actionText(s) avec succès. ";

        if ($fcmSuccessCount > 0) {
            $_SESSION['success_message'] .= "$fcmSuccessCount notification(s) push envoyée(s). ";
        }

        $_SESSION['success_message'] .= "Les emails seront envoyés en arrière-plan.";
    }

    if ($errorCount > 0) {
        $_SESSION['error_message'] = "$errorCount candidat(s) n'ont pas pu être traités correctement.";
    }

    // Rediriger vers la page des candidatures
    header("Location: candidatures_poste.php?poste=" . urlencode($poste) . "&poste_id=" . urlencode($poste_id));
    exit;
} else {
    // Redirection si accès direct au script
    header('Location: postulation.php?categorie=all');
    exit;
}