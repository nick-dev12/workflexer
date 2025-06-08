<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session



include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_categorie_users.php');
include_once('../controller/controller_niveau_etude_experience.php');


$totalUsers = getTotalUsers($db);

// Pagination
$profils_par_page = 20;
$page_courante = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page_courante - 1) * $profils_par_page;

// Récupérer le nombre total de profils
$total_profils = getTotalUsersCount($db);
$total_pages = ceil($total_profils / $profils_par_page);

// Récupérer les catégories
$categories = getAllCategories($db);

// Récupérer les profils pour la page courante
$totalUsers = getTotalUsers($db, $offset, $profils_par_page);


if (isset($_POST['recherche'])) {

    // Récupération des données du formulaire
    $recherche = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
    $categorie = isset($_POST['categorie']) ? htmlspecialchars($_POST['categorie']) : '';
    $experience = isset($_POST['experience']) ? htmlspecialchars($_POST['experience']) : '';
    $etude = isset($_POST['etude']) ? htmlspecialchars($_POST['etude']) : '';

    // Construction de la requête SQL de base
    $sql = "SELECT u.* FROM users u LEFT JOIN niveau_etude e ON u.id = e.users_id WHERE 1=1";
    $conditions = [];
    $params = [];

    // Ajout des conditions selon les paramètres fournis
    if (!empty($recherche)) {
        $conditions[] = "(u.competences LIKE ? OR u.nom LIKE ?)";
        $params[] = "%$recherche%";
        $params[] = "%$recherche%";
    }

    if (!empty($categorie)) {
        $conditions[] = "u.categorie = ?";
        $params[] = $categorie;
    }

    if (!empty($experience)) {
        $conditions[] = "e.experience = ?";
        $params[] = $experience;
    }

    if (!empty($etude)) {
        $conditions[] = "e.etude = ?";
        $params[] = $etude;
    }

    // Ajouter les conditions à la requête si nécessaire
    if (!empty($conditions)) {
        $sql .= " AND " . implode(" AND ", $conditions);
    }

    // Préparer et exécuter la requête
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $resulte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Stocker les résultats de la recherche dans une session
    $_SESSION['resultats_recherche'] = $resulte;

    header('Location: search.php');
    exit();
}

?>






<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez les profils de professionnels qualifiés sur Work-Flexer. Des experts en informatique, design, marketing, ingénierie et bien d'autres domaines. Trouvez le talent idéal pour vos projets avec notre système de recherche avancé. Recrutement simplifié et profils vérifiés.">

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
    <title>Explorez les profils</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script defer src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="../css/voir_profil.css">
    <link rel="stylesheet" href="../css/profil.css">
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
                    <h1>Explorez les
                        profils qui conviennent à vos besoins</h1>
                    <p>
                        Un large éventail de profils professionnels, toutes catégories confondues, pour satisfaire le
                        moindre de vos besoins en main-d'œuvre et bien plus encore.
                    </p>

                    <form action="" method="post" id="search-form">
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
                                    <option value="<?= $cat['categorie'] ?>" data-color-class="<?= $colorClass ?>">
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


    <section class="emploi">
        <?php
        // Tableau associatif d'icônes pour chaque catégorie
        $category_icons = [
            'Informatique et tech' => 'fa-laptop-code',
            'Design et création' => 'fa-paint-brush',
            'Rédaction et traduction' => 'fa-pen-fancy',
            'Marketing et communication' => 'fa-bullhorn',
            'Conseil et gestion d\'entreprise' => 'fa-briefcase',
            'Juridique' => 'fa-balance-scale',
            'Ingénierie et architecture' => 'fa-drafting-compass',
            'Finance et comptabilité' => 'fa-chart-line',
            'Santé et bien-être' => 'fa-heartbeat',
            'Éducation et formation' => 'fa-graduation-cap',
            'Tourisme et hôtellerie' => 'fa-hotel',
            'Commerce et vente' => 'fa-shopping-cart',
            'Transport et logistique' => 'fa-truck',
            'Agriculture et agroalimentaire' => 'fa-leaf',
            'Autre' => 'fa-star'
        ];

        // Compteur pour alterner les couleurs
        $colorIndex = 1;
        $totalColors = 15; // Nombre total de couleurs définies
        
        foreach ($categories as $category):
            // Déterminer l'icône à utiliser
            $icon_class = isset($category_icons[$category['categorie']])
                ? $category_icons[$category['categorie']]
                : 'fa-briefcase'; // Icône par défaut
        
            // Attribuer une classe de couleur
            $colorClass = "cat-color-" . $colorIndex;
            $colorIndex = ($colorIndex % $totalColors) + 1; // Passer à la couleur suivante, revenir à 1 quand on atteint la fin
            ?>
            <div class="category-box <?= $colorClass ?>" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400"
                data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                data-aos-anchor-placement="top-bottom">
                <div class="category-content">
                    <div class="category-icon">
                        <i class="fas <?= $icon_class ?>"></i>
                    </div>
                    <h3><?= $category['categorie'] ?></h3>
                    <p>Découvrez des professionnels qualifiés dans ce domaine</p>
                </div>
                <a href="categorie.php?categorie=<?= urlencode($category['categorie']) ?>" class="category-link">
                    <span>Explorer</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        <?php endforeach; ?>
    </section>


    <section class="call-to-action">
        <div class="cta-container">
            <h2>Prêt à découvrir tous nos talents?</h2>
            <p>Nous avons des profils qualifiés dans de nombreux domaines professionnels</p>
            <a href="voir_profil.php" class="cta-button">Explorer tous les profils</a>
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
        });
    </script>

    <!-- Intégration de Font Awesome pour les icônes -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Ajout du script pour les suggestions de recherche -->
    <script src="../js/search-suggestions.js"></script>

</body>

</html>