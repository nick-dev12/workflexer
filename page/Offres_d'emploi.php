<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

// Définir le nombre d'offres par page pour chaque table
$offresParTable = 6;

// Obtenir la page actuelle à partir de l'URL, par défaut 1
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$pageActuelle = max(1, $pageActuelle);

// Calculer l'offset pour la requête SQL
$offset = ($pageActuelle - 1) * $offresParTable;

// Requêtes SQL pour récupérer les offres des quatre tables
$sqlOffresEmploi = "
    SELECT *
    FROM offre_emploi u 
    LEFT JOIN compte_entreprise e ON u.entreprise_id = e.id 
    WHERE 1=1
    ORDER BY u.date DESC
    LIMIT :offset, :limit
";

$stmtOffresEmploi = $db->prepare($sqlOffresEmploi);
$stmtOffresEmploi->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtOffresEmploi->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtOffresEmploi->execute();

$afficheOffresEmploi = $stmtOffresEmploi->fetchAll(PDO::FETCH_ASSOC);

$sqlEmploiEmploi = "
    SELECT *
    FROM scrap_emploi_emploisenegal o
    WHERE 1=1
    ORDER BY o.date_publication DESC
    LIMIT :offset, :limit
";

$stmtEmploiEmploi = $db->prepare($sqlEmploiEmploi);
$stmtEmploiEmploi->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtEmploiEmploi->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtEmploiEmploi->execute();

$afficheEmploiEmploi = $stmtEmploiEmploi->fetchAll(PDO::FETCH_ASSOC);

$sqlEmploiDakar = "
    SELECT *
    FROM scrap_emploi_emploidakar d
    WHERE 1=1
    ORDER BY d.date_publication DESC
    LIMIT :offset, :limit
";

$stmtEmploiDakar = $db->prepare($sqlEmploiDakar);
$stmtEmploiDakar->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtEmploiDakar->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtEmploiDakar->execute();

$afficheEmploiDakar = $stmtEmploiDakar->fetchAll(PDO::FETCH_ASSOC);

$sqlSenjob = "
    SELECT *
    FROM senjob s
    WHERE 1=1
    ORDER BY s.date_publication DESC
    LIMIT :offset, :limit
";

$stmtSenjob = $db->prepare($sqlSenjob);
$stmtSenjob->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtSenjob->bindValue(':limit', $offresParTable, PDO::PARAM_INT);
$stmtSenjob->execute();

$afficheSenjob = $stmtSenjob->fetchAll(PDO::FETCH_ASSOC);

// Calculer le nombre total de pages
$totalOffres = $db->query("
    SELECT (
        (SELECT COUNT(*) FROM offre_emploi) +
        (SELECT COUNT(*) FROM emploi_emploi) +
        (SELECT COUNT(*) FROM scrap_emploi_emploidakar) +
        (SELECT COUNT(*) FROM senjob)
    ) AS total
")->fetchColumn();
$totalPages = ceil($totalOffres / ($offresParTable * 4));

// Définir le nombre maximum de boutons de pagination à afficher
$maxPagesToShow = 5;

// Calculer les pages de début et de fin
$startPage = max(1, $pageActuelle - floor($maxPagesToShow / 2));
$endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

// Ajuster le début si on est proche de la fin
if ($endPage - $startPage < $maxPagesToShow - 1) {
    $startPage = max(1, $endPage - $maxPagesToShow + 1);
}

/**
 * Système de recherche avancée multi-tables avec pagination
 */
if (isset($_POST['recherche'])) {
    // Stockage des critères de recherche en session pour la pagination
    $_SESSION['criteres_recherche'] = [
        'search' => $_POST['search'],
        'categorie' => $_POST['categorie'],
        'experience' => $_POST['experience'],
        'etude' => $_POST['etude']
    ];

    // Redirection vers la première page des résultats
    header('Location: search_results.php?page=1');
    exit();
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Consultez les dernières offres d'emploi sur Work-Flexer. Des opportunités dans tous les secteurs : IT, marketing, finance, ingénierie. Postulez facilement et suivez vos candidatures. Trouvez le poste qui correspond à vos compétences et ambitions.">

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

    <title>Offres D'emploi</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">

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
                    <img src="/image/offre1.webp" alt="">
                    <img src="/image/offre-emploi-quebec.webp" alt="">
                    <img src="/image/offre3.webp" alt="">
                    <img src="/image/offre4.webp" alt="">
                </div>
                <div class="text">
                    <h1>Explorez les offres d'emploi répondant à vos critères</h1>
                    <p>Un large éventail d'offres d'emploi, toutes catégories confondues, pour satisfaire le moindre de
                        vos besoins.</p>


                    <form action="" method="post">
                        <div class="search">
                            <input type="search" name="search" id="search">
                            <label for="recherche"><i class="fa-solid fa-magnifying-glass fa-xs"></i></label>
                            <input type="submit" name="recherche" value="recherche" id="recherche">
                        </div>

                        <div class="filtre">
                            <select id="categorie" name="categorie">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="Informatique et tech">Informatique et tech</option>
                                <option value="Design et création">Design et création</option>
                                <option value="Rédaction et traduction">Rédaction et traduction</option>
                                <option value="Marketing et communication">Marketing et communication</option>
                                <option value="Conseil et gestion d'entreprise">Conseil et gestion d'entreprise</option>
                                <option value="Juridique">Juridique</option>
                                <option value="Ingénierie et architecture">Ingénierie et architecture</option>
                                <option value="Finance et comptabilité">Finance et comptabilité</option>
                                <option value="Santé et bien-être">Santé et bien-être</option>
                                <option value="Éducation et formation">Éducation et formation</option>
                                <option value="Tourisme et hôtellerie">Tourisme et hôtellerie</option>
                                <option value="Commerce et vente">Commerce et vente</option>
                                <option value="Transport et logistique">Transport et logistique</option>
                                <option value="Agriculture et agroalimentaire">Agriculture et agroalimentaire</option>
                                <option value="Autre">Autre</option>
                            </select>

                            <select name="experience" id="experience">
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


                            <select name="etude" id="etude">
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


    <h1 class="titre_emploi">Trouvez votre voie parmi nos offres de métiers <br> Offres d'emploi disponibles</h1>



    <section class="tous_les_offres">

        <article class="articles">
            <?php if (empty($afficheOffresEmploi)): ?>
                <div class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</div>
            <?php else: ?>
                <?php foreach ($afficheOffresEmploi as $offre): ?>
                    <div class="carousel">
                        <div class="info-box">
                            <div class="header">
                                <span class="contrat"><?php echo $offre['contrat']; ?></span>
                                <span class="date"><?php echo $offre['date']; ?></span>
                            </div>
                            <h2 class="poste"> <strong>Poste :</strong> <?php echo substr($offre['poste'], 0, 100) . '...'; ?>
                            </h2>
                            <div class="entreprise">
                                <img src="../image/immeuble.png" alt="Entreprise">
                                <span><?php echo $offre['entreprise']; ?></span>
                            </div>
                            <div class="localite">
                                <img src="../image/position.png" alt="Localisation">
                                <span><?php echo $offre['localite']; ?></span>
                            </div>
                            <!-- <p class="description"><?php echo substr($offre['mission'], 0, 100) . '...'; ?></p> -->
                            <a href="../entreprise/voir_offre.php?offres_id=<?= $offre['offre_id']; ?>" class="details-btn">Voir
                                les détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <article class="articles">
            <?php if (empty($afficheEmploiEmploi)): ?>
                <div class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</div>
            <?php else: ?>
                <?php foreach ($afficheEmploiEmploi as $offre): ?>
                    <div class="carousel">
                        <div class="info-box">
                            <div class="header">
                                <span class="contrat"><?php echo $offre['type_contrat']; ?></span>
                                <span class="date"><?php echo $offre['date_publication']; ?></span>
                            </div>
                            <h2 class="poste"> <strong>Poste :</strong> <?php echo substr($offre['titre'], 0, 100) . '...'; ?>
                            </h2>
                            <div class="entreprise">
                                <img src="../image/immeuble.png" alt="Entreprise">
                                <span><?php echo $offre['entreprise']; ?></span>
                            </div>
                            <div class="localite">
                                <img src="../image/position.png" alt="Localisation">
                                <span><?php echo $offre['localisation']; ?></span>
                            </div>

                            <a href="/page/emploi_details1.php?id=<?php echo $offre['offre_id']; ?>" class="details-btn">Voir
                                les
                                détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <article class="articles">
            <?php if (empty($afficheEmploiDakar)): ?>
                <div class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</div>
            <?php else: ?>
                <?php foreach ($afficheEmploiDakar as $offre): ?>
                    <div class="carousel">
                        <div class="info-box">
                            <div class="header">
                                <span class="contrat"><?php echo $offre['type_contrat']; ?></span>
                                <span class="date"><?php echo $offre['date_publication']; ?></span>
                            </div>
                            <h2 class="poste"> <strong>Poste :</strong> <?php echo substr($offre['titre'], 0, 100) . '...'; ?>
                            </h2>
                            <div class="entreprise">
                                <img src="../image/immeuble.png" alt="Entreprise">
                                <span><?php echo $offre['entreprise']; ?></span>
                            </div>
                            <div class="localite">
                                <img src="../image/position.png" alt="Localisation">
                                <span><?php echo $offre['localisation']; ?></span>
                            </div>
                            <a href="/page/emploi_details2.php?id=<?php echo $offre['offre_id']; ?>" class="details-btn">Voir
                                les
                                détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <article class="articles">
            <?php if (empty($afficheSenjob)): ?>
                <div class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</div>
            <?php else: ?>
                <?php foreach ($afficheSenjob as $offre): ?>
                    <div class="carousel">
                        <div class="info-box">
                            <div class="header">
                                <span class="contrat"><?php echo $offre['type_contrat']; ?></span>
                                <span class="date"><?php echo $offre['date_publication']; ?></span>
                            </div>
                            <h2 class="poste"> <strong>Poste :</strong> <?php echo substr($offre['titre'], 0, 100) . '...'; ?>
                            </h2>
                            <div class="entreprise">
                                <img src="../image/immeuble.png" alt="Entreprise">
                                <span><?php echo $offre['entreprise']; ?></span>
                            </div>
                            <div class="localite">
                                <img src="../image/position.png" alt="Localisation">
                                <span><?php echo $offre['localisation']; ?></span>
                            </div>

                            <a href="/page/emploi_details3.php?id=<?php echo $offre['offre_id']; ?>" class="details-btn">Voir
                                les
                                détails</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

        <!-- Système de pagination -->
        <div class="pagination">
            <?php if ($pageActuelle > 1): ?>
                <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link">Précédent</a>
            <?php endif; ?>

            <?php
            // Calculer la plage de pages à afficher
            $start = max(1, $pageActuelle - 2);
            $end = min($totalPages, $start + 4);

            // Ajuster le début si on est proche de la fin
            if ($end - $start < 4) {
                $start = max(1, $end - 4);
            }

            for ($i = $start; $i <= $end; $i++):
                ?>
                <a href="?page=<?= $i ?>" class="page-link <?= (int) $i === (int) $pageActuelle ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($pageActuelle < $totalPages): ?>
                <a href="?page=<?= $pageActuelle + 1 ?>" class="page-link">Suivant</a>
            <?php endif; ?>
        </div>
    </section>


    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    <script src="../js/silder_offres.js"></script>

    <style>

    </style>

</body>

</html>