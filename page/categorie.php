<?php
// Démarre la session
session_start();

include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_categorie_users.php');
include_once('../controller/controller_niveau_etude_experience.php');

// Vérifier si une catégorie est spécifiée dans l'URL
if (!isset($_GET['categorie'])) {
    // Rediriger vers la page principale si aucune catégorie n'est spécifiée
    header('Location: voir_profil.php');
    exit();
}

$categorie = htmlspecialchars($_GET['categorie']);

// Pagination
$profils_par_page = 20;
$page_courante = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page_courante - 1) * $profils_par_page;

// Récupérer le nombre total de profils dans cette catégorie
$total_profils = countUsersByCategory($db, $categorie);
$total_pages = ceil($total_profils / $profils_par_page);

// Récupérer les profils pour cette catégorie
$usersInCategory = getUsersByCategory($db, $categorie, $offset, $profils_par_page);

// Récupérer toutes les catégories pour le menu
$categories = getAllCategories($db);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez les profils de professionnels qualifiés dans la catégorie <?= $categorie ?> sur Work-Flexer. Des experts en <?= $categorie ?> prêts à collaborer sur vos projets.">

    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->
    <title>Profils <?= $categorie ?> | Work-Flexer</title>
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
                    <h1>Explorez les profils de <?= $categorie ?></h1>
                    <p>
                        Découvrez les talents spécialisés en <?= $categorie ?> pour répondre à vos besoins
                        professionnels.
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
                            <select id="categorie" name="categorie" class="custom-select">
                                <option value="">Sélectionnez une catégorie</option>
                                <?php 
                                // Compteur pour alterner les couleurs
                                $colorIndex = 1;
                                $totalColors = 15; // Nombre total de couleurs définies
                                
                                foreach ($categories as $cat): 
                                    $colorClass = "cat-color-" . $colorIndex;
                                    $colorIndex = ($colorIndex % $totalColors) + 1;
                                ?>
                                <option value="<?= $cat['categorie'] ?>"
                                    <?= ($cat['categorie'] == $categorie) ? 'selected' : '' ?>
                                    data-color-class="<?= $colorClass ?>">
                                    <?= $cat['categorie'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>

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
                    Profils <?= $categorie ?>
                </h1>
            </div>

            <div class="produit_vedete">
                <?php 
                // Déterminer la classe de couleur pour cette catégorie
                $categoryNames = array_column($categories, 'categorie');
                $categoryIndex = array_search($categorie, $categoryNames);
                $colorIndex = ($categoryIndex % 5) + 1;
                $categoryColorClass = "cat-color-" . $colorIndex;
                ?>

                <?php if (empty($usersInCategory)): ?>
                <h1 class="no-profile-message">Aucun profil disponible pour cette catégorie</h1>
                <?php else: ?>
                <div class="professionals-grid" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400"
                    data-aos-easing="ease-in-out">
                    <?php foreach ($usersInCategory as $user): ?>
                    <?php
                            $nombreCompetences = countCompetences($db, $user['id']);
                            $niveauEtude = gettNiveau($db, $user['id']);
                            
                            // On n'affiche que les profils avec au moins 4 compétences et qui ne sont pas occupés
                            if ($nombreCompetences >= 4 ):
                            ?>
                    <div class="profile-card <?= $categoryColorClass ?>">
                        <!-- Indicateur de statut -->
                        <?php if ($user['statut'] == 'Disponible' || $user['statut'] == 'Occuper'): ?>
                        <div
                            class="status-indicator <?php echo ($user['statut'] == 'Disponible') ? 'available' : 'busy'; ?>">
                            <span></span><?= $user['statut'] ?>
                        </div>
                        <?php endif; ?>

                        <!-- En-tête avec image -->
                        <div class="profile-header">
                            <img src="../upload/<?= $user['images'] ?>" alt="Photo de <?= $user['nom'] ?>">

                            <!-- Overlay avec nom et localisation -->
                            <div class="profile-name-overlay">
                                <?php
                                            $fullName = $user['nom'];
                                            $words = explode(' ', $fullName);
                                            $nameUsers = isset($words[1]) ? $words[0] . ' ' . $words[1] : $words[0];
                                            ?>
                                <h2 class="profile-name"><?= $nameUsers ?></h2>
                                <div class="profile-location">
                                    <i class="fas fa-map-marker-alt"></i> <?= $user['ville'] ?>
                                </div>
                            </div>
                        </div>

                        <!-- Contenu principal -->
                        <div class="profile-content">
                            <!-- Titre principal (fonction) -->
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
                                <span
                                    class="skill-badge <?php echo ($compe['mis_en_avant'] == 1) ? 'highlighted' : ''; ?>">
                                    <?php if ($compe['mis_en_avant'] == 1): ?>
                                    <i class="fas fa-star"></i>
                                    <?php endif; ?>
                                    <?= substr($compe['competence'], 0, 20) . (strlen($compe['competence']) > 20 ? '...' : '') ?>
                                </span>
                                <?php
                                                endforeach;
                                            else:
                                            ?>
                                <span class="skill-badge">Compétences non spécifiées</span>
                                <?php endif; ?>
                            </div>

                            <!-- Détails d'éducation et expérience -->
                            <div class="profile-details">
                                <div class="detail-item">
                                    <strong>Niveau d'étude:</strong>
                                    <span><?= !empty($niveauEtude['etude']) ? $niveauEtude['etude'] : 'N/A' ?></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Expérience:</strong>
                                    <span><?= !empty($niveauEtude['experience']) ? $niveauEtude['experience'] : 'N/A' ?></span>
                                </div>
                            </div>

                            <!-- Bouton de visualisation du profil -->
                            <a href="/page/candidats.php?id=<?= $user['id'] ?>" class="view-profile-btn">
                                <i class="fa-solid fa-eye"></i> Voir le profil
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Afficher le nombre total de candidats dans la catégorie -->
                <div class="results-counter">
                    <p>
                        <?= $total_profils ?> candidat<?= ($total_profils > 1) ? 's' : '' ?>
                        trouvé<?= ($total_profils > 1) ? 's' : '' ?> dans la catégorie
                        <strong><?= $categorie ?></strong>
                    </p>
                </div>

                <!-- Pagination élégante -->
                <div class="pagination-container">
                    <ul class="pagination <?= $categoryColorClass ?>">
                        <?php if ($total_pages > 1): ?>
                        <!-- Lien vers la première page -->
                        <?php if ($page_courante > 3): ?>
                        <li>
                            <a href="?categorie=<?= urlencode($categorie) ?>&page=1" class="page-nav first"
                                title="Première page">
                                <span class="icon-only">«</span>
                                <span class="text-label">Premier</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Lien vers la page précédente -->
                        <?php if ($page_courante > 1): ?>
                        <li>
                            <a href="?categorie=<?= urlencode($categorie) ?>&page=<?= $page_courante - 1 ?>"
                                class="page-nav prev">
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
                            <a href="?categorie=<?= urlencode($categorie) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <!-- Page courante -->
                        <li>
                            <span class="current"><?= $page_courante ?></span>
                        </li>

                        <!-- Pages suivant la page courante -->
                        <?php
                            // Afficher les deux pages suivantes
                            for ($i = $page_courante + 1; $i <= min($total_pages, $page_courante + 2); $i++):
                            ?>
                        <li>
                            <a href="?categorie=<?= urlencode($categorie) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <!-- Lien vers la page suivante -->
                        <?php if ($page_courante < $total_pages): ?>
                        <li>
                            <a href="?categorie=<?= urlencode($categorie) ?>&page=<?= $page_courante + 1 ?>"
                                class="page-nav next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Lien vers la dernière page -->
                        <?php if ($page_courante < $total_pages - 2): ?>
                        <li>
                            <a href="?categorie=<?= urlencode($categorie) ?>&page=<?= $total_pages ?>"
                                class="page-nav last" title="Dernière page">
                                <span class="icon-only">»</span>
                                <span class="text-label">Dernier</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php else: ?>
                        <!-- Cas où il n'y a qu'une seule page -->
                        <li>
                            <span class="current">1</span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php include('../footer.php') ?>

    <script src="/js/silder_offres.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
    AOS.init();
    </script>

    <!-- Script pour ajouter une animation de scroll fluide aux liens de pagination -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation de scroll fluide pour les liens de pagination
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
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
        const totalProfiles = <?= $total_profils ?>;
        const paginationSection = document.getElementById('pagination-section');
        const messageElement = document.querySelector('.no-profile-message');

        if (totalProfiles === 0 && messageElement && paginationSection) {
            paginationSection.style.display = 'none';
        }
    });
    </script>
    <!-- Intégration de Font Awesome pour les icônes -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Ajout du script pour les suggestions de recherche -->
    <script src="../js/search-suggestions.js"></script>
</body>

</html>