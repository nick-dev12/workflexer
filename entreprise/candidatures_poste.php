<?php
session_start();

if (!isset($_GET['poste']) || empty($_GET['poste'])) {
    header('Location: ../entreprise/postulation.php?categorie=all');
    exit;
}

if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: ../index.php');
    exit;
}

include_once('../entreprise/app/controller/controllerEntreprise.php');
include_once('../entreprise/app/controller/controllerDescription.php');
include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../controller/controller_postulation.php');
include_once('../controller/controller_accepte_candidats.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');

// Récupérer les informations du poste
$poste = $_GET['poste'];
$poste_id = isset($_GET['poste_id']) ? $_GET['poste_id'] : null;

// Récupérer les candidatures non traitées
$getALLpostulation = getALLPostulation($db, $_SESSION['compte_entreprise'], $poste);

// Récupérer les candidatures acceptées et refusées
$getALLpostulationAccepter = [];
$getALLpostulationRejeter = [];

if ($poste_id) {
    $getALLpostulationAccepter = getPostulationAccepterEntreprise($db, $poste_id, $_SESSION['compte_entreprise']);
    $getALLpostulationRejeter = getPostulationRejeterEntreprise($db, $poste_id, $_SESSION['compte_entreprise']);
}

// Compter les candidats par statut
$untreatedCount = 0;
foreach ($getALLpostulation as $postulant) {
    if (empty($postulant['statut'])) {
        $untreatedCount++;
    }
}

$acceptedCount = count($getALLpostulationAccepter);
$rejectedCount = count($getALLpostulationRejeter);
$countAllposte = $untreatedCount + $acceptedCount + $rejectedCount;

// Traitement des actions (accepter/refuser)
if (isset($_GET['accepter']) && isset($_GET['offrees_id'])) {
    $accepter = $_GET['accepter'];
    $offre_id = $_GET['offrees_id'];

    $accepte = accepteCandidats($db, $accepter, $offre_id);

    if ($accepte) {
        $_SESSION['success_message'] = "Candidature acceptée avec succès";
    } else {
        $_SESSION['error_message'] = "Erreur lors de l'acceptation de la candidature";
    }

    header("Location: candidatures_poste.php?poste=" . urlencode($poste) . "&poste_id=" . urlencode($poste_id));
    exit;
}

if (isset($_GET['recaler']) && isset($_GET['offrees_id'])) {
    $recaler = $_GET['recaler'];
    $offre_id = $_GET['offrees_id'];

    $recale = recalerCandidats($db, $recaler, $offre_id);

    if ($recale) {
        $_SESSION['success_message'] = "Candidature refusée avec succès";
    } else {
        $_SESSION['error_message'] = "Erreur lors du refus de la candidature";
    }

    header("Location: candidatures_poste.php?poste=" . urlencode($poste) . "&poste_id=" . urlencode($poste_id));
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <title>Candidatures pour <?= htmlspecialchars($poste) ?> | WorkFlexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/candidatures_poste.css">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>
    <?php include('../include/header_entreprise.php') ?>

    <section class="section3">
        <!-- Notifications -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="notification success">
                <i class="fas fa-check-circle"></i>
                <span><?= $_SESSION['success_message'] ?></span>
                <button class="close-btn"><i class="fas fa-times"></i></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="notification error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= $_SESSION['error_message'] ?></span>
                <button class="close-btn"><i class="fas fa-times"></i></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- En-tête de la page -->
        <div class="page-header">
            <div class="header-content">
                <div class="back-button">
                    <a href="postulation.php?categorie=all" title="Retour à la liste des postes">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h1>Candidatures pour le poste: <span><?= htmlspecialchars($poste) ?></span></h1>
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-value"><?= $countAllposte ?></div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-item new">
                        <div class="stat-value"><?= $untreatedCount ?></div>
                        <div class="stat-label">Non traités</div>
                    </div>
                    <div class="stat-item accepted">
                        <div class="stat-value"><?= $acceptedCount ?></div>
                        <div class="stat-label">Acceptés</div>
                    </div>
                    <div class="stat-item rejected">
                        <div class="stat-value"><?= $rejectedCount ?></div>
                        <div class="stat-label">Refusés</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="filters-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Rechercher par nom ou compétences...">
            </div>
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="untreated">
                    Non traités <span class="count"><?= $untreatedCount ?></span>
                </button>
                <button class="filter-tab" data-filter="accepted">
                    Acceptés <span class="count"><?= $acceptedCount ?></span>
                </button>
                <button class="filter-tab" data-filter="rejected">
                    Refusés <span class="count"><?= $rejectedCount ?></span>
                </button>
            </div>
            <div class="view-options">
                <button class="view-option active" data-view="grid">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="view-option" data-view="list">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <!-- Boutons d'action en masse -->
        <div class="bulk-actions-container" id="bulk-actions-container" style="display: block;">
            <div class="select-actions">
                <button id="select-all-btn" class="action-btn select-btn">
                    <i class="fas fa-check-square"></i> Sélectionner tous les non traités
                </button>
                <span id="selected-count" class="selected-count">0 candidat(s) sélectionné(s)</span>
            </div>
            <div class="bulk-buttons">
                <button id="bulk-accept-btn" class="action-btn bulk-btn accept-btn" disabled>
                    <i class="fas fa-check"></i> Accepter la sélection
                </button>
                <button id="bulk-reject-btn" class="action-btn bulk-btn reject-btn" disabled>
                    <i class="fas fa-times"></i> Refuser la sélection
                </button>
            </div>
        </div>

        <!-- Formulaire pour les actions en masse -->
        <form id="bulk-action-form" method="post" action="traiter_candidatures.php">
            <input type="hidden" name="poste" value="<?= htmlspecialchars($poste) ?>">
            <input type="hidden" name="poste_id" value="<?= htmlspecialchars($poste_id) ?>">
            <input type="hidden" name="action" id="bulk-action-type" value="">
            <input type="hidden" name="selected_candidates" id="selected-candidates-input" value="">
        </form>

        <!-- Liste des candidats -->
        <div class="candidates-container grid-view">
            <?php if ($countAllposte == 0): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h3>Aucune candidature</h3>
                    <p>Il n'y a pas encore de candidatures pour ce poste.</p>
                </div>
            <?php else: ?>
                <!-- Candidats non traités -->
                <?php foreach ($getALLpostulation as $postulant):
                    if (empty($postulant['statut'])):
                        $niveau = gettNiveau($db, $postulant['users_id']);
                        $explode_nom = explode(' ', $postulant['nom']);
                        $nom = $explode_nom[0] . ' , ' . (isset($explode_nom[1]) ? $explode_nom[1] : '');
                        $competencesUsers = getCompetences($db, $postulant['users_id']);
                        ?>
                        <div class="candidate-card untreated" data-nom="<?= strtolower($postulant['nom']) ?>"
                            data-competences="<?= strtolower($postulant['competences']) ?>">
                            <div class="card-header">
                                <div class="candidate-checkbox">
                                    <input type="checkbox" class="candidate-select" data-posteid="<?= $postulant['poste_id'] ?>"
                                        data-offreid="<?= $postulant['offre_id'] ?>"
                                        data-nom="<?= htmlspecialchars($postulant['nom']) ?>"
                                        data-email="<?= htmlspecialchars($postulant['mail']) ?>">
                                </div>
                                <div class="candidate-status untreated">
                                    Non traité
                                </div>
                                <?php if (isset($postulant['date_postulation'])): ?>
                                    <div class="candidate-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?= date('d/m/Y', strtotime($postulant['date_postulation'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="candidate-photo">
                                <img src="../upload/<?= $postulant['images'] ?>" alt="Photo de <?= htmlspecialchars($nom) ?>">
                            </div>

                            <div class="candidate-info">
                                <h3 class="candidate-name"><?= htmlspecialchars($nom) ?></h3>
                                <div class="candidate-skills">
                                    <?php
                                    $competences = explode(',', $postulant['competences']);
                                    $competences = array_slice($competences, 0, 3); // Limiter à 3 compétences
                        
                                    foreach ($competences as $competence):
                                        $competence = trim($competence);
                                        if (!empty($competence)):
                                            ?>
                                            <span class="skill-tag"><?= htmlspecialchars($competence) ?></span>
                                            <?php
                                        endif;
                                    endforeach;

                                    if (count(explode(',', $postulant['competences'])) > 3):
                                        ?>
                                        <span class="skill-tag more">+<?= count(explode(',', $postulant['competences'])) - 3 ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="candidate-details">
                                    <div class="detail-item">
                                        <i class="fas fa-phone"></i>
                                        <span><?= htmlspecialchars($postulant['phone']) ?></span>
                                    </div>

                                    <div class="detail-item">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span><?= $niveau ? htmlspecialchars($niveau['etude']) : 'Non renseigné' ?></span>
                                    </div>

                                    <div class="detail-item">
                                        <i class="fas fa-briefcase"></i>
                                        <span><?= $niveau ? htmlspecialchars($niveau['experience']) : 'Non renseigné' ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="candidate-actions">
                                <a href="../page/candidats.php?id=<?= $postulant['users_id'] ?>" class="action-btn view-btn"
                                    title="Voir le profil complet">
                                    <i class="fas fa-eye"></i>
                                    <span>Voir le profil</span>
                                </a>

                                <div class="action-group">
                                    <a href="?poste=<?= urlencode($poste) ?>&poste_id=<?= urlencode($poste_id) ?>&accepter=<?= $postulant['poste_id'] ?>&offrees_id=<?= $postulant['offre_id'] ?>"
                                        class="action-btn accept-btn" title="Accepter la candidature">
                                        <i class="fas fa-check"></i>
                                        <span>Accepter</span>
                                    </a>
                                    <a href="?poste=<?= urlencode($poste) ?>&poste_id=<?= urlencode($poste_id) ?>&recaler=<?= $postulant['poste_id'] ?>&offrees_id=<?= $postulant['offre_id'] ?>"
                                        class="action-btn reject-btn" title="Refuser la candidature">
                                        <i class="fas fa-times"></i>
                                        <span>Refuser</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;
                endforeach;
                ?>

                <!-- Candidats acceptés -->
                <?php foreach ($getALLpostulationAccepter as $postulant):
                    $niveau = gettNiveau($db, $postulant['users_id']);
                    $explode_nom = explode(' ', $postulant['nom']);
                    $nom = $explode_nom[0] . ' , ' . (isset($explode_nom[1]) ? $explode_nom[1] : '');
                    $competencesUsers = getCompetences($db, $postulant['users_id']);
                    ?>
                    <div class="candidate-card accepted" data-nom="<?= strtolower($postulant['nom']) ?>"
                        data-competences="<?= strtolower($postulant['competences']) ?>">
                        <div class="card-header">
                            <div class="candidate-status accepted">
                                Accepté
                            </div>
                            <?php if (isset($postulant['date_postulation'])): ?>
                                <div class="candidate-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?= date('d/m/Y', strtotime($postulant['date_postulation'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="candidate-photo">
                            <img src="../upload/<?= $postulant['images'] ?>" alt="Photo de <?= htmlspecialchars($nom) ?>">
                        </div>

                        <div class="candidate-info">
                            <h3 class="candidate-name"><?= htmlspecialchars($nom) ?></h3>
                            <div class="candidate-skills">
                                <?php
                                $competences = explode(',', $postulant['competences']);
                                $competences = array_slice($competences, 0, 3); // Limiter à 3 compétences
                        
                                foreach ($competences as $competence):
                                    $competence = trim($competence);
                                    if (!empty($competence)):
                                        ?>
                                        <span class="skill-tag"><?= htmlspecialchars($competence) ?></span>
                                        <?php
                                    endif;
                                endforeach;

                                if (count(explode(',', $postulant['competences'])) > 3):
                                    ?>
                                    <span class="skill-tag more">+<?= count(explode(',', $postulant['competences'])) - 3 ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="candidate-details">
                                <div class="detail-item">
                                    <i class="fas fa-phone"></i>
                                    <span><?= htmlspecialchars($postulant['phone']) ?></span>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span><?= $niveau ? htmlspecialchars($niveau['etude']) : 'Non renseigné' ?></span>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-briefcase"></i>
                                    <span><?= $niveau ? htmlspecialchars($niveau['experience']) : 'Non renseigné' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="candidate-actions">
                            <a href="../page/candidats.php?id=<?= $postulant['users_id'] ?>" class="action-btn view-btn"
                                title="Voir le profil complet">
                                <i class="fas fa-eye"></i>
                                <span>Voir le profil</span>
                            </a>

                            <a href="../entreprise/message.php?user_id=<?= $postulant['users_id'] ?>"
                                class="action-btn message-btn" title="Envoyer un message">
                                <i class="fas fa-envelope"></i>
                                <span>Message</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Candidats refusés -->
                <?php foreach ($getALLpostulationRejeter as $postulant):
                    $niveau = gettNiveau($db, $postulant['users_id']);
                    $explode_nom = explode(' ', $postulant['nom']);
                    $nom = $explode_nom[0] . ' , ' . (isset($explode_nom[1]) ? $explode_nom[1] : '');
                    $competencesUsers = getCompetences($db, $postulant['users_id']);
                    ?>
                    <div class="candidate-card rejected" data-nom="<?= strtolower($postulant['nom']) ?>"
                        data-competences="<?= strtolower($postulant['competences']) ?>">
                        <div class="card-header">
                            <div class="candidate-status rejected">
                                Refusé
                            </div>
                            <?php if (isset($postulant['date_postulation'])): ?>
                                <div class="candidate-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?= date('d/m/Y', strtotime($postulant['date_postulation'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="candidate-photo">
                            <img src="../upload/<?= $postulant['images'] ?>" alt="Photo de <?= htmlspecialchars($nom) ?>">
                        </div>

                        <div class="candidate-info">
                            <h3 class="candidate-name"><?= htmlspecialchars($nom) ?></h3>
                            <div class="candidate-skills">
                                <?php
                                $competences = explode(',', $postulant['competences']);
                                $competences = array_slice($competences, 0, 3); // Limiter à 3 compétences
                        
                                foreach ($competences as $competence):
                                    $competence = trim($competence);
                                    if (!empty($competence)):
                                        ?>
                                        <span class="skill-tag"><?= htmlspecialchars($competence) ?></span>
                                        <?php
                                    endif;
                                endforeach;

                                if (count(explode(',', $postulant['competences'])) > 3):
                                    ?>
                                    <span class="skill-tag more">+<?= count(explode(',', $postulant['competences'])) - 3 ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="candidate-details">
                                <div class="detail-item">
                                    <i class="fas fa-phone"></i>
                                    <span><?= htmlspecialchars($postulant['phone']) ?></span>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span><?= $niveau ? htmlspecialchars($niveau['etude']) : 'Non renseigné' ?></span>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-briefcase"></i>
                                    <span><?= $niveau ? htmlspecialchars($niveau['experience']) : 'Non renseigné' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="candidate-actions">
                            <a href="../page/candidats.php?id=<?= $postulant['users_id'] ?>" class="action-btn view-btn"
                                title="Voir le profil complet">
                                <i class="fas fa-eye"></i>
                                <span>Voir le profil</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Bouton pour remonter en haut de la page -->
        <button class="back-to-top" title="Retour en haut">
            <i class="fas fa-arrow-up"></i>
        </button>

    </section>

    <script>
        // Gestion des notifications
        const closeButtons = document.querySelectorAll('.notification .close-btn');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const notification = button.parentElement;
                notification.classList.add('closing');
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 300);
            });
        });

        // Masquer automatiquement les notifications après 5 secondes
        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => {
                notification.classList.add('closing');
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 300);
            });
        }, 5000);

        // Filtrage des candidats
        const filterTabs = document.querySelectorAll('.filter-tab');
        const candidateCards = document.querySelectorAll('.candidate-card');
        const bulkActionsContainer = document.getElementById('bulk-actions-container');

        // Filtrer par défaut pour montrer uniquement les candidats non traités au chargement
        candidateCards.forEach(card => {
            if (card.classList.contains('untreated')) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Activer l'onglet cliqué
                filterTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Filtrer les candidats
                const filter = tab.getAttribute('data-filter');

                // Afficher/masquer les options de sélection multiple selon l'onglet actif
                if (filter === 'untreated') {
                    bulkActionsContainer.style.display = 'flex';
                } else {
                    bulkActionsContainer.style.display = 'none';
                    // Décocher toutes les cases à cocher si on change d'onglet
                    document.querySelectorAll('.candidate-select:checked').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateSelectedCount();
                }

                candidateCards.forEach(card => {
                    if (filter === 'untreated' && card.classList.contains('untreated')) {
                        card.style.display = '';
                    } else if (filter === 'accepted' && card.classList.contains('accepted')) {
                        card.style.display = '';
                    } else if (filter === 'rejected' && card.classList.contains('rejected')) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Recherche de candidats
        const searchInput = document.getElementById('search-input');

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();

            candidateCards.forEach(card => {
                const nom = card.getAttribute('data-nom');
                const competences = card.getAttribute('data-competences');

                if (nom.includes(searchTerm) || competences.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Changement de vue (grille/liste)
        const viewOptions = document.querySelectorAll('.view-option');
        const candidatesContainer = document.querySelector('.candidates-container');

        viewOptions.forEach(option => {
            option.addEventListener('click', () => {
                viewOptions.forEach(o => o.classList.remove('active'));
                option.classList.add('active');

                const viewType = option.getAttribute('data-view');

                if (viewType === 'grid') {
                    candidatesContainer.classList.remove('list-view');
                    candidatesContainer.classList.add('grid-view');
                } else {
                    candidatesContainer.classList.remove('grid-view');
                    candidatesContainer.classList.add('list-view');
                }
            });
        });

        // Bouton pour remonter en haut de la page
        const backToTopButton = document.querySelector('.back-to-top');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Gestion de la sélection multiple
        const selectAllBtn = document.getElementById('select-all-btn');
        const bulkAcceptBtn = document.getElementById('bulk-accept-btn');
        const bulkRejectBtn = document.getElementById('bulk-reject-btn');
        const selectedCountSpan = document.getElementById('selected-count');
        const bulkActionForm = document.getElementById('bulk-action-form');
        const bulkActionTypeInput = document.getElementById('bulk-action-type');
        const selectedCandidatesInput = document.getElementById('selected-candidates-input');

        // Fonction pour mettre à jour le compteur de sélection
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.candidate-select:checked');
            const count = checkboxes.length;

            selectedCountSpan.textContent = `${count} candidat(s) sélectionné(s)`;

            // Activer/désactiver les boutons d'action en masse
            if (count > 0) {
                bulkAcceptBtn.disabled = false;
                bulkRejectBtn.disabled = false;
            } else {
                bulkAcceptBtn.disabled = true;
                bulkRejectBtn.disabled = true;
            }
        }

        // Sélectionner/désélectionner tous les candidats non traités
        selectAllBtn.addEventListener('click', () => {
            const untreatedCheckboxes = document.querySelectorAll('.candidate-card.untreated .candidate-select');
            const allChecked = [...untreatedCheckboxes].every(checkbox => checkbox.checked);

            untreatedCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });

            updateSelectedCount();

            // Changer le texte du bouton en fonction de l'état
            if (allChecked) {
                selectAllBtn.innerHTML = '<i class="fas fa-check-square"></i> Sélectionner tous les non traités';
            } else {
                selectAllBtn.innerHTML = '<i class="fas fa-square"></i> Désélectionner tous les non traités';
            }
        });

        // Écouter les changements sur les cases à cocher individuelles
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('candidate-select')) {
                updateSelectedCount();

                // Vérifier si tous les candidats non traités visibles sont sélectionnés
                const untreatedCheckboxes = document.querySelectorAll('.candidate-card.untreated:not([style*="display: none"]) .candidate-select');
                const allChecked = [...untreatedCheckboxes].every(checkbox => checkbox.checked);

                if (allChecked) {
                    selectAllBtn.innerHTML = '<i class="fas fa-square"></i> Désélectionner tous les non traités';
                } else {
                    selectAllBtn.innerHTML = '<i class="fas fa-check-square"></i> Sélectionner tous les non traités';
                }
            }
        });

        // Traitement des actions en masse
        bulkAcceptBtn.addEventListener('click', () => {
            processBulkAction('accepter');
        });

        bulkRejectBtn.addEventListener('click', () => {
            processBulkAction('recaler');
        });

        function processBulkAction(action) {
            // Collecter les ID des candidats sélectionnés
            const selectedCheckboxes = document.querySelectorAll('.candidate-select:checked');
            if (selectedCheckboxes.length === 0) return;

            const selectedData = [];
            selectedCheckboxes.forEach(checkbox => {
                selectedData.push({
                    poste_id: checkbox.dataset.posteid,
                    offre_id: checkbox.dataset.offreid,
                    nom: checkbox.dataset.nom,
                    email: checkbox.dataset.email
                });
            });

            // Confirmer l'action
            const actionText = action === 'accepter' ? 'accepter' : 'refuser';
            const confirmMessage = `Êtes-vous sûr de vouloir ${actionText} les ${selectedData.length} candidats sélectionnés ?`;

            if (confirm(confirmMessage)) {
                // Remplir le formulaire et le soumettre
                bulkActionTypeInput.value = action;
                selectedCandidatesInput.value = JSON.stringify(selectedData);
                bulkActionForm.submit();
            }
        }

        // Masquer les checkboxes dans les onglets acceptés et refusés
        function updateCheckboxVisibility() {
            const activeFilter = document.querySelector('.filter-tab.active').getAttribute('data-filter');

            document.querySelectorAll('.candidate-checkbox').forEach(checkbox => {
                if (activeFilter === 'untreated') {
                    checkbox.style.display = 'flex';
                } else {
                    checkbox.style.display = 'none';
                }
            });
        }

        // Mettre à jour la visibilité des checkboxes au chargement
        updateCheckboxVisibility();

        // Mettre à jour la visibilité des checkboxes lors du changement d'onglet
        filterTabs.forEach(tab => {
            tab.addEventListener('click', updateCheckboxVisibility);
        });
    </script>
</body>

</html>