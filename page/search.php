<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session

include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');

// Vérifier si les résultats de la recherche sont disponibles dans la session
if (isset($_SESSION['resultats_recherche'])) {
    // Récupérer les résultats de la recherche
    $resultats = $_SESSION['resultats_recherche'];

    // Configuration de la pagination
    $resultats_par_page = 20; // Nombre de résultats par page
    $page_courante = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $nombre_total_resultats = count($resultats);
    $nombre_total_pages = ceil($nombre_total_resultats / $resultats_par_page);

    // S'assurer que la page courante est valide
    if ($page_courante < 1) {
        $page_courante = 1;
    } elseif ($page_courante > $nombre_total_pages && $nombre_total_pages > 0) {
        $page_courante = $nombre_total_pages;
    }

    // Calculer l'index de début pour la pagination
    $index_debut = ($page_courante - 1) * $resultats_par_page;

    // Sélectionner uniquement les résultats pour la page courante
    $resultats_page = array_slice($resultats, $index_debut, $resultats_par_page);

    // Mélanger les résultats de la page courante (si désiré)
    shuffle($resultats_page);
} else {
    // Aucun résultat n'est disponible
    $resultats_page = [];
    $nombre_total_resultats = 0;
    $nombre_total_pages = 0;
    $page_courante = 1;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Résultats de recherche pour les profils professionnels sur Work-Flexer. Découvrez les talents qui correspondent à vos critères.">

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

    <title>Recherche | Work-Flexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script defer src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="../css/voir_profil.css">
    <link rel="stylesheet" href="../css/profil.css">
    <link rel="stylesheet" href="../css/categorie-cards.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <section class="section2">
        <div class="slider">
            <div class="box">
                <div class="img owl-carousel boot">
                    <img src="/image/recherche.png" alt="">
                    <img src="/image/profile1.jpg" alt="">
                    <img src="/image/profile2.jpg" alt="">
                </div>
                <div class="text">
                    <h1>Résultats de recherche</h1>
                    <p>
                        Découvrez les talents qui correspondent à vos critères de recherche.
                    </p>

                    <form action="voir_profil.php" method="post" id="search-form">
                        <div class="search-container">
                            <div class="search">
                                <input type="search" name="search" id="search"
                                    placeholder="Rechercher un profil, une compétence..." autocomplete="off">
                                <label for="recherche"><i class="fa-solid fa-magnifying-glass"></i></label>
                                <input type="submit" name="recherche" value="recherche" id="recherche">
                            </div>
                            <!-- Conteneur pour les suggestions -->
                            <div class="search-suggestions" id="search-suggestions">
                                <!-- Les suggestions seront injectées ici via JavaScript -->
                            </div>
                        </div>

                        <div class="filtre">
                            <select name="experience" id="experience" class="custom-select">
                                <option value="">-- Niveau d'expérience --</option>
                                <option value="1an">1an</option>
                                <option value="2ans">2ans</option>
                                <option value="3ans">3ans</option>
                                <option value="4ans">4ans</option>
                                <option value="5ans">5ans</option>
                                <option value="6ans">6ans</option>
                                <option value="7ans">7ans</option>
                                <option value="8ans">8ans</option>
                                <option value="9ans">9ans</option>
                                <option value="10ans">10ans</option>
                            </select>

                            <select name="etude" id="etude" class="custom-select">
                                <option value="">-- Niveau d'étude --</option>
                                <option value="Bac+1an">Bac+1an</option>
                                <option value="Bac+2ans">Bac+2ans</option>
                                <option value="Bac+3ans">Bac+3ans</option>
                                <option value="Bac+4ans">Bac+4ans</option>
                                <option value="Bac+5ans">Bac+5ans</option>
                                <option value="Bac+6ans">Bac+6ans</option>
                                <option value="Bac+7ans">Bac+7ans</option>
                                <option value="Bac+8ans">Bac+8ans</option>
                                <option value="Bac+9ans">Bac+9ans</option>
                                <option value="Bac+10ans">Bac+10ans</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="tous_profil">
        <div class="container_box1">
            <div class="texte">
                <h1>
                    Résultats de recherche
                </h1>
            </div>

            <div class="produit_vedete">
                <?php
                // Déterminer une classe de couleur aléatoire pour les résultats
                $colorIndex = rand(1, 5);
                $categoryColorClass = "cat-color-" . $colorIndex;
                ?>

                <?php if (empty($resultats_page)): ?>
                    <h1 class="no-profile-message">Aucun profil disponible pour cette recherche</h1>
                <?php else: ?>
                    <div class="professionals-grid" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400"
                        data-aos-easing="ease-in-out">
                        <?php foreach ($resultats_page as $user): ?>
                            <?php
                            $nombreCompetences = countCompetences($db, $user['id']);
                            $niveauEtude = gettNiveau($db, $user['id']);

                            // On n'affiche que les profils avec au moins 4 compétences et qui ne sont pas occupés
                            if ($nombreCompetences >= 4 && $user['statut'] !== 'Occuper'):
                                ?>
                                <div class="profile-card <?= $categoryColorClass ?>">
                                    <!-- Indicateur de statut -->
                                    <?php if ($user['statut'] == 'Disponible'): ?>
                                        <div class="status-indicator available">
                                            <span></span><?= $user['statut'] ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- En-tête avec image -->
                                    <div class="profile-header">
                                        <img src="../upload/<?= $user['images'] ?>" alt="Photo de <?= $user['nom'] ?>">

                                        <!-- Overlay avec nom -->
                                        <div class="profile-name-overlay">
                                            <?php
                                            $fullName = $user['nom'];
                                            $words = explode(' ', $fullName);
                                            $nameUsers = isset($words[1]) ? $words[0] . ' ' . $words[1] : $words[0];
                                            ?>
                                            <p class="profile-name"><?= $nameUsers ?></p>
                                        </div>

                                        <!-- Localisation -->
                                        <div class="profile-location">
                                            <i class="fas fa-map-marker-alt"></i> <?= $user['ville'] ?>
                                        </div>
                                    </div>

                                    <!-- Contenu principal -->
                                    <div class="profile-content">
                                        <!-- Titre principal -->
                                        <h3 class="profile-title">
                                            <?= substr($user['competences'], 0, 60) . (strlen($user['competences']) > 60 ? '...' : '') ?>
                                        </h3>

                                        <!-- Badges de compétences -->
                                        <div class="skills-container">
                                            <?php
                                            $afficheCompetences = getCompetences($db, $user['id']);
                                            $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                            if (!empty($afficheCompetences)):
                                                foreach ($afficheCompetences as $compe):
                                                    ?>
                                                    <span class="skill-badge">
                                                        <?= substr($compe['competence'], 0, 20) . (strlen($compe['competence']) > 20 ? '...' : '') ?>
                                                    </span>
                                                    <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <span class="skill-badge">Compétences indisponibles</span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Détails d'éducation et expérience -->
                                        <div class="profile-details">
                                            <div class="detail-item">
                                                <strong>Niveau :</strong>
                                                <span><?= !empty($niveauEtude['etude']) ? $niveauEtude['etude'] : 'Indisponible' ?></span>
                                            </div>
                                            <div class="detail-item">
                                                <strong>Expérience :</strong>
                                                <span><?= !empty($niveauEtude['experience']) ? $niveauEtude['experience'] : 'Indisponible' ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de visualisation du profil -->
                                    <a href="/page/candidats.php?id=<?= $user['id'] ?>" class="view-profile-btn">
                                        <i class="fa-solid fa-eye"></i> Voir le profil
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Afficher le nombre total de résultats -->
                <div class="results-counter">
                    <p>
                        <?= $nombre_total_resultats ?> candidat<?= ($nombre_total_resultats > 1) ? 's' : '' ?>
                        trouvé<?= ($nombre_total_resultats > 1) ? 's' : '' ?> pour votre recherche
                    </p>
                </div>

                <!-- Pagination élégante -->
                <?php if ($nombre_total_pages > 1): ?>
                    <div class="pagination-container">
                        <ul class="pagination <?= $categoryColorClass ?>">
                            <!-- Lien vers la première page -->
                            <?php if ($page_courante > 3): ?>
                                <li>
                                    <a href="?page=1" class="page-nav first" title="Première page">
                                        <span class="icon-only">«</span>
                                        <span class="text-label">Premier</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Lien vers la page précédente -->
                            <?php if ($page_courante > 1): ?>
                                <li>
                                    <a href="?page=<?= $page_courante - 1 ?>" class="page-nav prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Pages précédant la page courante -->
                            <?php
                            // Afficher les deux pages précédentes
                            for ($i = max(1, $page_courante - 2); $i < $page_courante; $i++):
                                ?>
                                <li>
                                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Page courante -->
                            <li>
                                <span class="current"><?= $page_courante ?></span>
                            </li>

                            <!-- Pages suivant la page courante -->
                            <?php
                            // Afficher les deux pages suivantes
                            for ($i = $page_courante + 1; $i <= min($nombre_total_pages, $page_courante + 2); $i++):
                                ?>
                                <li>
                                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Lien vers la page suivante -->
                            <?php if ($page_courante < $nombre_total_pages): ?>
                                <li>
                                    <a href="?page=<?= $page_courante + 1 ?>" class="page-nav next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Lien vers la dernière page -->
                            <?php if ($page_courante < $nombre_total_pages - 2): ?>
                                <li>
                                    <a href="?page=<?= $nombre_total_pages ?>" class="page-nav last" title="Dernière page">
                                        <span class="icon-only">»</span>
                                        <span class="text-label">Dernier</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('../footer.php') ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

        // Animation de scroll fluide pour les liens de pagination
        document.addEventListener('DOMContentLoaded', function () {
            // Animation de scroll fluide pour les liens de pagination
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    // On laisse le comportement normal du lien mais on ajoute une animation
                    setTimeout(() => {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 5);
                });
            });

            // Masquer la pagination s'il n'y a pas de profils
            const totalProfiles = <?= $nombre_total_resultats ?>;
            const paginationSection = document.querySelector('.pagination-container');
            const messageElement = document.querySelector('.no-profile-message');

            if (totalProfiles === 0 && messageElement && paginationSection) {
                paginationSection.style.display = 'none';
            }
        });
    </script>
    <!-- Ajout du script pour les suggestions de recherche -->
    <script src="../js/search-suggestions.js"></script>
</body>

</html>